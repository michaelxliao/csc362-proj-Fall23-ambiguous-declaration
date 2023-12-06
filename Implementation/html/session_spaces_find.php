<?php
require 'includes/setup.php';
require 'includes/functions.php';
$conn = setup();
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


$ALL_SPACES = "All Spaces";

$space_names_res = $conn->query("SELECT space_name FROM spaces WHERE space_is_active = TRUE");
$space_names = $space_names_res->fetch_all();

$sql_query = 'SELECT * FROM pretty_all_upcoming_space_reservations'; // this by default; can be overridden by filtering

$result = $conn->query($sql_query);
if (isset($_GET["Filter"])) {
$where_clauses = [];
    if ($_GET["space_name"] == $ALL_SPACES) {
        // do nothing
    } else {
        //append the space name filter

        //NEED TO CHECK FOR SQL INJECTION.

        $where_clauses[] = '`Reserved Space` = "' . $_GET['space_name'] . '"';
    }

    $final_sql_query = $sql_query;

    if (sizeof($where_clauses) > 0) {
        $final_sql_query = $final_sql_query . ' WHERE';
        for ($i = 0; $i < sizeof($where_clauses) - 1; $i++) { // loop through all where clauses, append with ANDs
            $final_sql_query = $final_sql_query . ' (' . $where_clauses[$i] . ') AND ';
        }
        $final_sql_query = $final_sql_query . ' (' . $where_clauses[sizeof($where_clauses) - 1] . ')'; // handling the final where clause
    }    
    

    $result = $conn->query($final_sql_query);
    if (!$result) {
        echo 'failed to filter';
        exit();
    }

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
        <a class="link-button" href=login_general.php> Back to Sign-In</a>

        <h1> Welcome, <?=$patron_first_name?>, to the Therpston County Public Library.</h1>
    </header>

    <a href="session_spaces.php">Back to Spaces Menu</a>

    <h2>Spaces Available for Reservation</h2>
    <?php result_to_table($conn->query("SELECT space_name AS `Space` FROM spaces WHERE space_is_active = TRUE"));?>

    <h2>Current Reserved Spaces</h2>
    <form method=GET> <!-- NOTE FOR FILTERING: don't freakin forget your quotes -->
        <label for="space_name">Room Name: </label>
        <select name="space_name" id="space_name" required>
            <option value="<?=$ALL_SPACES?>"> 
            <?=$ALL_SPACES?>
            </option>   
            <?php for ($i = 0; $i < $space_names_res->num_rows; $i++) { ?>
                <option value="<?= $space_names[$i][0] ?>">
                    <?= $space_names[$i][0] ?>
                </option>
            <?php } ?>
        </select>
        <button type="submit" name="Filter">Filter</button>
    </form>

        <?php result_to_table_hideids($result); ?>

</body>

</html>