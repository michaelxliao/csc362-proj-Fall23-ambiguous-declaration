<?php
require 'includes/setup.php';
require 'includes/functions.php';

$conn = setup();

if (!isset($_GET['materialid'])) {
    header('Location:manage_selection.php', true, 303);
}
session_start();

// check if they're logged in, if not crash
    if(!isset($_SESSION['patron_id']))
    {
        header("Location:login_general.php?error=true", true, 303);
        exit();
    }

    $login_id = $_SESSION['patron_id'];

    $patron_info = $conn->prepare("SELECT patron_id, 
                                    patron_first_name,
                                    patron_last_name,
                                    patron_phone,
                                    patron_email
                                    FROM patrons 
                                    WHERE patron_id = ?");

    $patron_info->bind_param("i", $login_id);
    if(!$patron_info->execute())
    {
        print("SQL error!");
    }
    $res = $patron_info->get_result();
    $patron_data = $res->fetch_assoc();

    if(isset($patron_data['patron_email']))
    {
        $patron_email = $patron_data['patron_email'];
    }
    else
    {
        $patron_email = "Not Set";
    }


    if(isset($patron_data['patron_phone']))
    {
        $patron_phone = $patron_data['patron_phone'];
    }
    else
    {
        $patron_phone = "Not Set";
    }

    $patron_first_name = $patron_data['patron_first_name'];

try{
    $curr_material = $_GET['materialid']; // might be invalid still
} catch(Exception $e)
{
    //$_GET['materialid'] isn't set
    header("Location:session_sel_material.php?error=true", true, 303);
}

// if 0 rows, then curr_material is invalid.
$get_material_info_query = "SELECT *
                              FROM pretty_selection_librarian
                             WHERE ID = ?";

$get_material_info_stmt = $conn->prepare($get_material_info_query);
$get_material_info_stmt->bind_param('i', $curr_material);
if (!$get_material_info_stmt->execute()) {
    print("SQL error. Sorry!");
}

$get_material_info_result = $get_material_info_stmt->get_result();
$material_info = $get_material_info_result->fetch_assoc();
$material_title = $material_info['Title'];
$date_selected = $material_info['Date Selected into Library'];
$date_created = $material_info['Date Created'];
$pending = $material_info['Pending?'];
$cost = $material_info['Cost'];
$type = $material_info['Type'];
$length = $material_info['Length'];

if($_SERVER['REQUEST_METHOD'] === "POST")
{
    if(isset($_POST['put_hold']))
    {
        $put_hold_stmt = $conn->prepare("CALL add_hold(?, ?, CURRENT_TIMESTAMP())");
        $put_hold_stmt->bind_param("ii", $curr_material, $login_id);
        if(!$put_hold_stmt->execute())
        {
            print("Bad SQL, bad boy");
            exit();
        }
    } 

    header("Location:" . $_SERVER['REQUEST_URI'], true, 303);
    exit();
}

$get_creators_query = "SELECT creator_id,
                              material_id,
                              creator_role,
                              CONCAT(creator_role, ': ', creator_first_name, ' ', creator_last_name) AS 'Creator'
                         FROM selection_creators
                              LEFT OUTER JOIN creators USING (creator_id)
                        WHERE material_id = ?";

$creators_res = find_result($curr_material, $get_creators_query);

$genres_query = "SELECT genre_name AS 'Genre'
                   FROM selection_genres
                  WHERE material_id = ?";

$genres_res = find_result($curr_material, $genres_query);

$languages_query = "SELECT language_name AS 'Language'
                      FROM selection_languages
                     WHERE material_id = ?";

$languages_res = find_result($curr_material, $languages_query);

?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gentium+Book+Plus&family=Montserrat:wght@500&display=swap"
        rel="stylesheet">
</head>

<body>
<header>
    <a class="link-button" href=login_general.php> Back to Sign-In</a>

        <h1> Welcome, <?=$patron_first_name?>, to the Therpston County Public Library.</h1>
    </header>
    <a href="session_sel_material.php">Back to Catalog</a><br>
    <a href="session_adaptations.php">Back to Adaptations</a>


    
        <h1>
            <?= $material_title ?>
        </h1>

        <!-- show if it's currently on loan! -->
        <?php
        $loan_status_stmt = $conn->prepare('SELECT 1
                                             FROM current_loans
                                            WHERE material_id = ?');
        $loan_status_stmt->bind_param('i', $curr_material);
        if (!$loan_status_stmt->execute()) {
            echo $loan_status_stmt->error;
        }
        $loan_status_res = $loan_status_stmt->get_result();
        $loan_status = $loan_status_res->num_rows;
        // 1 == book checked out currently.
        // 0 == book available.
        if ($loan_status) {
        ?><p> Currently checked out!</p>

    <!--We show hold data ONLY if it's checked out.
        Doesn't have any otherwise. -->

            <!-- HOLDS -->
            <?php
            
            $num_holds_stmt = $conn->prepare(
                "(SELECT material_id, interaction_id
                    FROM current_holds
                    WHERE material_id = ?)"
            );
            $num_holds_stmt->bind_param("i", $curr_material);
            if(!$num_holds_stmt->execute()) {
                print("SQL Gone WRong");
                exit();
            }
            $num_holds_res = $num_holds_stmt->get_result();
            $num_holds = $num_holds_res->num_rows;
            ?>

            <h3>Number of holds on this material: <?=$num_holds?></h3>

            <?php
            $has_hold_stmt = $conn->prepare(
                "(SELECT material_id, interaction_id
                    FROM current_holds
                    WHERE material_id = ?
                    AND
                    patron_id = ?)"
            );
            $has_hold_stmt->bind_param("ii", $curr_material, $login_id);
            if(!$has_hold_stmt->execute()) {
                print("SQL Gone Wrong");
                exit();
            }
            $has_hold_res = $has_hold_stmt->get_result();
            $has_hold = $has_hold_res->num_rows;


/*<!-- If the patron has a hold on the material, show that.
    Else, give a button for placing a hold.-->*/
            
            if($has_hold){
                ?><h3>You currently have a hold placed on this material.</h3><?php
            }

            else{

                
                ?>    <form method=POST>
                <input type="submit" name="put_hold" value="Place a Hold on this Material"/>
            </form>
        <?php
            }



} else { 
            ?>
            <p> Currently available! </p>
        <?php } 
?>
        <?php
        $is_source_stmt = $conn->prepare('SELECT material_is_source, narrative_name
                                                FROM adaptations
                                                     NATURAL JOIN narratives
                                               WHERE material_id = ?');
        $is_source_stmt->bind_param('i', $curr_material);
        if (!$is_source_stmt->execute()) {
            echo $is_source_stmt->error;
        }
        $is_source_res = $is_source_stmt->get_result();
        $is_source_data = $is_source_res->fetch_all();
        if ($is_source_res->num_rows == 0) { ?>
            <p> This material is not an adaptation of any narrative at the moment. </p>
        <?php } else {
            $is_source = $is_source_data[0][0];
            $narrative_title = $is_source_data[0][1];
            if ($is_source) {
                ?>
                <p> This material is the source for the narrative
                    <?= $narrative_title ?>.
                </p>
            <?php } elseif (!$is_source) { ?>
                <p> This material adapts the narrative
                    <?= $narrative_title ?>
                </p>
            <?php }
        } ?>


    <!-- -->
    <h2>Creator(s)</h2>
        <?php $creators_data = $creators_res->fetch_all(); ?>

        <?php if($creators_res->num_rows == 0)
        {
            ?><p>No creators assigned to this material.</p><?php
        }
        else {
            ?>
        <table>

            <th>
                <?= $creators_res->fetch_fields()[3]->name ?>
            </th>

            <tbody>
                <?php for ($i = 0; $i < $creators_res->num_rows; $i++) {
                    $id_1 = $creators_data[$i][0];
                    $id_2 = $creators_data[$i][1];
                    $id_3 = $creators_data[$i][2];
                    ?>
                    <tr>
                        <td>
                            <?= $creators_data[$i][3] ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
        }?>

    <h2>Genre(s)</h2>
    <?php if($genres_res->num_rows == 0)
        {
            ?><p>No genres assigned to this material.</p><?php
        }
        else { 
            result_to_table($genres_res); }?>

    <h2>Language(s)</h2>
    <?php if($languages_res->num_rows == 0)
        {
            ?><p>No languages assigned to this material.</p><?php
        }
        else { 
            result_to_table($languages_res); }?>


</body>

</html>