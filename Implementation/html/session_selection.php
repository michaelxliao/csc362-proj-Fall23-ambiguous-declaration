<?php
require 'includes/setup.php';
require 'includes/format_result.php';

$conn = setup();

//from $_GET request, find what mode to display.

session_start();

// check if they're logged in, if not crash
    if(!isset($_SESSION['patron_id']))
    {
        header("Location:login_general.php?error=true", true, 303);
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


//SELECTION START

$print_types_res = $conn->query("SELECT print_type FROM print_types WHERE print_type_is_active = TRUE");
$multimedia_types_res = $conn->query("SELECT multimedia_type FROM multimedia_types WHERE multimedia_type_is_active = TRUE");

$print_types = $print_types_res->fetch_all();
$multimedia_types = $multimedia_types_res->fetch_all();

$sql_query = 'SELECT * FROM pretty_selection_librarian'; // this by default; can be overridden by filtering
$result = $conn->query($sql_query);

// defining constants like a good coder
$ALL_MEDIA = 'All media';
$PRINT = 'Print';
$MULTIMEDIA = 'Multimedia';

$ALL_AVAILABILITY = 'All';
$ON_SHELF = 'On Shelf';
$CHECKED_OUT = 'Checked Out';

function generate_insert_form($type_string)
{ // do not use this function in other php files. it will NOT WORK. 
?>
    <form method=POST>
        <label for="title">Title: </label>
        <input name="title" required>
        <label for="date_received">Date Received:</label>
        <input type="date" name="date_received" required>
        <label for="date_created">Date Created:</label>
        <input type="date" name="date_created" required>
        <label for="pending">Still being processed?</label>
        <input type="checkbox" name="pending">
        <label for="price">Price: $</label>
        <input type="number" min="0" step="any" name="price">
        <?php if ($type_string == $GLOBALS["PRINT"]) { ?>
            <label for="print_type">Print Type:</label>
            <select name="print_type">
                <?php for ($i = 0; $i < $GLOBALS["print_types_res"]->num_rows; $i++) { ?>
                    <option value="<?= $GLOBALS["print_types"][$i][0] ?>">
                        <?= $GLOBALS["print_types"][$i][0] ?>
                    </option>
                <?php } ?>
            </select>
            <label for="num_pages">Page Count: </label>
            <input type="number" name="num_pages" min="1" required>
        <?php } elseif ($type_string == $GLOBALS["MULTIMEDIA"]) { ?>
            <label for="multimedia_type">Multimedia Type:</label>
            <select name="multimedia_type">
                <?php for ($i = 0; $i < $GLOBALS["multimedia_types_res"]->num_rows; $i++) { ?>
                    <option value="<?= $GLOBALS["multimedia_types"][$i][0] ?>">
                        <?= $GLOBALS["multimedia_types"][$i][0] ?>
                    </option>
                <?php } ?>
            </select>
            <label for="duration">Duration: </label>
            <input pattern="^\d{2}:\d{2}:\d{2}$" name="duration" placeholder="HH:MM:SS" required>
        <?php } ?>
        <br>
        <input type="submit" name="add_material" value="Submit">
    </form>
<?php }

if (isset($_GET["Filter"])) {
    $where_clauses = [];
    $need_type = false;
    // echo $_GET["media-type"];
    if ($_GET["media-type"] == $ALL_MEDIA) {
        // do nothing
    } elseif ($_GET["media-type"] == $PRINT) {
        // this is hands down the wildest way i've ever seen appending to an array handled. just fwiw.
        $where_clauses[] = '`ID` IN (SELECT material_id FROM print_materials)';
    } elseif ($_GET["media-type"] == $MULTIMEDIA) {
        $where_clauses[] = '`ID` IN (SELECT material_id FROM multimedia)';
    } elseif ($_GET["media-type"] != $ALL_MEDIA) {
        $where_clauses[] = '`Type` = ?';
        $need_type = true;
    }

    if ($_GET["availability"] == $ALL_AVAILABILITY) {
        // do nothing
    } elseif ($_GET["availability"] == $CHECKED_OUT) {
        $where_clauses[] = '`ID` IN (SELECT material_id FROM current_loans)';
    } elseif ($_GET["availability"] == $ON_SHELF) {
        $where_clauses[] = '`ID` NOT IN (SELECT material_id FROM current_loans)';
    }

    // later: filter by pending

    if (sizeof($where_clauses) > 0) {
        $final_sql_query = $sql_query . ' WHERE';
        for ($i = 0; $i < sizeof($where_clauses) - 1; $i++) { // loop through all where clauses, append with ANDs
            $final_sql_query = $final_sql_query . ' (' . $where_clauses[$i] . ') AND ';
        }
        $final_sql_query = $final_sql_query . ' (' . $where_clauses[sizeof($where_clauses) - 1] . ')'; // handling the final where clause
        $filter_stmt = $conn->prepare($final_sql_query);
        if ($need_type) { // can alter this later to add more bindable params
            $filter_stmt->bind_param('s', $_GET["media-type"]);
        }
        if (!$filter_stmt->execute()) {
            echo 'failed to filter';
            exit();
        } else {
            $result = $filter_stmt->get_result();
        }
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gentium+Book+Plus&family=Montserrat:wght@500&display=swap" rel="stylesheet">
</head>

<body>
    <a class="link-button" href=login_general.php> Back to Sign-In</a>
    <header>
        <h2> Welcome, <?=$patron_first_name?>, to the Therpston County Public Library.</h2>
    </header>

    <h1>The Catalog</h1>

    <br>

    <form method=GET> <!-- NOTE FOR FILTERING: don't freakin forget your quotes -->
        <!-- need to convert to checkboxes; we don't want just one or the other, we may want multiple -->
        <label for="media-type">Media type: </label>
        <select name="media-type" id="media-type" required>
            <option value="<?= $ALL_MEDIA ?>">
                <?= $ALL_MEDIA ?>
            </option>
            <option value="<?= $PRINT ?>">
                <?= $PRINT ?>
            </option>
            <option value="<?= $MULTIMEDIA ?>">
                <?= $MULTIMEDIA ?>
            </option>
            <?php for ($i = 0; $i < $print_types_res->num_rows; $i++) { ?>
                <option value="<?= $print_types[$i][0] ?>">
                    <?= $print_types[$i][0] ?>
                </option>
            <?php } ?>
            <?php for ($i = 0; $i < $multimedia_types_res->num_rows; $i++) { ?>
                <option value="<?= $multimedia_types[$i][0] ?>">
                    <?= $multimedia_types[$i][0] ?>
                </option>
            <?php } ?>
        </select>

        <label for="availability">Availability: </label>
        <select name="availability" id="availability" required>
            <option value="<?= $ALL_AVAILABILITY ?>">
                <?= $ALL_AVAILABILITY ?>
            </option>
            <option value="<?= $ON_SHELF ?>">
                <?= $ON_SHELF ?>
            </option>
            <option value="<?= $CHECKED_OUT ?>">
                <?= $CHECKED_OUT ?>
            </option>
        </select>
        <button type="submit" name="Filter">Filter</button>
    </form>
    <?php result_to_clickable_table($result, "material", "details_material.php", true); ?>
</body>

</html>