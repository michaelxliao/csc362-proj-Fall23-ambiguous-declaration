<?php
require 'includes/setup.php';
require 'includes/functions.php';
$conn = setup();
$club_id = $_GET['clubid'];
$current_club_stmt = $conn->prepare("SELECT club_name,
                                        club_description
                                         FROM active_clubs WHERE club_id = ?"); // note all these need to be refactoered into perpared statements
$current_club_stmt->bind_param("i", $club_id);
if(!$current_club_stmt->execute())
{
    echo "SQL did a bad";
    exit();
}
$current_club_res = $current_club_stmt->get_result();
$current_club_data = $current_club_res->fetch_all();
$club_name = $current_club_data[0][0];
$club_desc = $current_club_data[0][1];


$all_patrons_res = $conn->query('SELECT CONCAT(patron_first_name, " ", patron_last_name) AS patron_name,
                                    patron_id
                               FROM patrons');
$all_patrons_info = $all_patrons_res->fetch_all();

$spaces_res = $conn->query('SELECT space_id, space_name FROM spaces');
$spaces_info = $spaces_res->fetch_all();

$club_members_stmt = $conn->prepare("SELECT patron_id, CONCAT(patron_first_name, ' ', patron_last_name) AS 'Name',
                                     member_info AS 'Details',
                                     (CASE WHEN member_is_leader
                                      THEN 'Part of Leadership'
                                      ELSE 'Not Leadership'
                                      END) AS 'Leadership Status'
                                FROM patrons
                                     INNER JOIN club_members USING(patron_id)
                                     INNER JOIN active_clubs USING(club_id)
                               WHERE club_id = ?;");

$club_members_stmt->bind_param("i", $club_id);
if(!$club_members_stmt->execute())
{
    echo "SQL did a bad";
    exit();
}
$club_members_res = $club_members_stmt->get_result();

$club_spaces_reserved_stmt = $conn->prepare("SELECT space_name AS 'Space',
                                          CONCAT(patron_first_name, ' ', patron_last_name) AS 'Reserved By',
                                          start_reservation AS 'Reserved From',
                                          end_reservation AS 'Reserved Until'
                                    FROM
                                        club_reservations
                                            LEFT OUTER JOIN space_reservations USING (reservation_id)
                                            LEFT OUTER JOIN patrons USING (patron_id)
                                            LEFT OUTER JOIN spaces USING (space_id)
                                    WHERE club_id = ?;");
$club_spaces_reserved_stmt->bind_param("i", $club_id);
if(!$club_spaces_reserved_stmt->execute())
{
    echo "SQL did a bad";
    exit();
}


$club_spaces_reserved_res = $club_spaces_reserved_stmt->get_result();
$club_spaces_reserved_stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["edit_old_club"])) {
        $new_club_name = $_POST["edit_club_name"];
        $new_club_decs = $_POST["edit_club_desc"];
        $changes_made = True;
    
        if (isset($_POST["edit_club_name"]) && isset($_POST["edit_club_desc"])) {
            # Check for the club already being in database.
            $checkexists = $conn->prepare("SELECT * FROM active_clubs WHERE club_name = ?");
            $checkexists->bind_param('s',$club_name);
            $checkexists->execute();
    
            $result = $checkexists->get_result();
    
            // this is technically an int but 0 means it does not have that club & 1 means it does
            $has_value = $result->num_rows;
    
            #we update if the club currently exists.
            if ($has_value) {
                $update_stmt = $conn->prepare("CALL update_club(?, ?, ?)");
                $update_stmt->bind_param('iss', $club_id, $new_club_name, $new_club_decs);
                try {
                    $update_stmt->execute();
                } catch (mysqli_sql_exception $e) {
                    print_r($e);
                }
    
            }
        }
    } 
    
    if(isset($_POST["delete_records"])){

        $deletable_patrons_stmt = $conn->prepare("SELECT patron_id
                                    FROM patrons
                                    INNER JOIN club_members USING(patron_id)
                                    INNER JOIN active_clubs USING(club_id)
                                    WHERE club_id = ?;");
        $deletable_patrons_stmt->bind_param("i", $club_id);
        $deletable_patrons_stmt->execute();
        $deletable_patrons_res = $deletable_patrons_stmt->get_result();
        $deletable_patrons_data = $deletable_patrons_res->fetch_all();

        $del_stmt=$conn->prepare("DELETE FROM club_members WHERE patron_id=?");
        $del_stmt->bind_param('i',$id);
        for($_i=0;$_i<$deletable_patrons_res->num_rows;$_i++){
            
            
            $id=$deletable_patrons_data[$_i][0];
            
                if(isset($_POST["checkbox$id"])){
                    $del_stmt->execute();
                }
        }
    }


    if (isset($_POST['add_member'])) {
        $is_leader = false;
        if (isset($_POST['is_leader'])) {
            $is_leader = true;
        }
        $insert_stmt = $conn->prepare('INSERT INTO club_members (club_id, patron_id, member_info, member_is_leader)
                                       VALUES (?, ?, ?, ?)');
        $insert_stmt->bind_param('iisi', $club_id, $_POST['new_member_id'], $_POST['new_member_desc'], $is_leader);
        try {
            $insert_stmt->execute();
        } catch (mysqli_sql_exception $e) {
            print_r($e);
        }
    }

    if (isset($_POST['del_club'])){
        $del_club = $conn->prepare("CALL del_club(?)");
        $del_club ->bind_param('i', $club_id);
        $del_club -> execute();
        header("Location: profile_clubs.php", true, 303);
        exit();

    }
    
    header("Location: {$_SERVER['REQUEST_URI']}", true, 303);
    exit();
}
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
    <a class="link-button" href=index.php> Back to Sign-In</a>

    <h1>Therpston County Public Library</h1>
    </header>
    <a href="profile_clubs.php">Back to Club Profiles</a>
    <h1><?= $club_name ?></h1>

    <form method=POST>
        <label for ="edit_club_name">Club Name:</label>
        <input type="text" name="edit_club_name" value = "<?=$club_name?> " />
        <br>
        <label for ="edit_club_desc">Club Description:</label>
        <textarea name="edit_club_desc"> <?=$club_desc ?></textarea>
        <br>
        <input type="submit" name="edit_old_club" value="Edit Club" />
    </form>
    <h2>Club Member(s):</h2>
    <form method=POST>
        <label for="new_member_id">Add new member: </label>
        <select name="new_member_id">
            <?php for ($i = 0; $i <$all_patrons_res->num_rows; $i++) { ?>
                <option value='<?= $all_patrons_info[$i][1] ?>'><?= $all_patrons_info[$i][0] ?></option>
            <?php } ?>
        </select>
        <label for="new_member_desc">Extra details? </label>
        <input type="text" name="new_member_desc" placeholder="Leave blank for no details">
        <label for="is_leader">Part of leadership?</label>
        <input type="checkbox" name="is_leader">
        <input type="submit" name="add_member" value="Submit">
    </form>



    <?php result_to_deletable_table($club_members_res, False); ?>





    <h2>Space Reservation(s):</h2>
    <!-- <form method=POST>
        <label for="space_id">Reserve a space: </label>
        <select name="space_id">
            <?php for ($i = 0; $i <$spaces_res->num_rows; $i++) { ?>
                <option value='<?= $spaces_info[$i][0] ?>'><?= $spaces_info[$i][1] ?></option>
            <?php } ?>
        </select>
        
    </form> -->
    <?= result_to_table($club_spaces_reserved_res); ?>
    <form method=POST>
        <input type ="submit" name ="del_club" value ="Delete Club?"/>
    </form>
</body>

</html>