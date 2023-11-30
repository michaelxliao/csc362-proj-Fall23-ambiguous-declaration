<?php
require 'includes/setup.php';
require 'includes/functions.php';
$conn = setup();
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

$space_names_res = $conn->query("SELECT space_id, space_name FROM active_spaces");
$space_names = $space_names_res->fetch_all();

$clubs_patron_in_stmt = $conn->prepare("SELECT DISTINCT club_id,
                                        club_name
                                        FROM clubs
                                        INNER JOIN club_members
                                        USING (club_id)
                                        WHERE club_id IN 
                                            (SELECT club_id FROM club_members
                                             WHERE patron_id = ?) 
                                                ");
$clubs_patron_in_stmt->bind_param("i", $login_id);
if(!$clubs_patron_in_stmt->execute())
{
    echo "SQL issue";
    exit();
}
$res = $clubs_patron_in_stmt->get_result();
$clubs_patron_in_res = $res->fetch_all();
$num_clubs_in = count($clubs_patron_in_res);

//if here through post request

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_records'])) {
            
        $patron_spaces = $conn->prepare("SELECT * FROM pretty_upcoming_space_reservations WHERE patron_id = ?;");

        $patron_spaces->bind_param("i", $login_id);

        if(!$patron_spaces->execute())
        {
            print("SQL WENT WRONG (NOT CLICKBAIT)");
        }

        $res = $patron_spaces->get_result();
        $data = $res->fetch_all();

        $del_stmt = $conn->prepare("CALL del_reservation(?);");
        $del_stmt->bind_param("i", $record_id);

        for($i = 0; $i < $res->num_rows; $i++)
        {
            $record_id = $data[$i][0];
            if(isset($_POST['checkbox' . $record_id])) {
                $del_stmt->execute();
            }
        }
    
    }
    if (isset($_POST['add_reservation'])) {
        // $login_id is patron id
        $space_id = $_POST['space_name'];
        $start_time = $_POST['start_date'] . ' '. $_POST['start_time'];
        $end_time = $_POST['end_date'] . ' '. $_POST['end_time'];
        $notes = $_POST['notes'];
        //add_reservation(patronid INT, spaceid INT, start_time DATETIME, end_time DATETIME, notes VARCHAR(256))


        if($_POST['club_id'] == 'None')
        {
            $reservation_ins_stmt = $conn->prepare("CALL add_reservation(?, ?, ?, ?, ?);");
            $reservation_ins_stmt->bind_param("iisss", $login_id, $space_id, $start_time, $end_time, $notes);
        }
        else
        {
            $new_club_id = $_POST['club_id'];
            $reservation_ins_stmt = $conn->prepare("CALL add_club_reservation(?, ?, ?, ?, ?, ?);");
            $reservation_ins_stmt->bind_param("iisssi", $login_id, $space_id, $start_time, $end_time, $notes, $new_club_id);
        }

        $reservation_ins_stmt->execute();

    }

	header("Location:" .  $_SERVER['REQUEST_URI'],  true, 303);
    exit();
}


// prepare view of spaces

$patron_spaces = $conn->prepare("SELECT * FROM pretty_upcoming_space_reservations WHERE patron_id = ?;");

$patron_spaces->bind_param("i", $login_id);

if(!$patron_spaces->execute())
{
    print("SQL WENT WRONG (NOT CLICKBAIT)");
}

$res = $patron_spaces->get_result();

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
    <a href="index_general.php">Back to Main Patron Page</a>

    <h2>Reserve a Space</h2>
    <!-- we need:
        - patronid, 
        - spaceid, 
        - start_time DATETIME,
        - end_time DATETIME,
        - notes VARCHAR(256),
        - clubid INT (whether it's a club or not!)-->

    <form method=POST>
        <!-- Space Name -->
        <label for="space_name">Space Name: </label>
        <select name="space_name" id="space_name" required>
            <?php for ($i = 0; $i < $space_names_res->num_rows; $i++) { ?>
                <option value="<?= $space_names[$i][0]?>">
                    <?= $space_names[$i][1] ?>
                </option>
            <?php } ?>
        </select>
        <br>

        
        <label>Start Date:</label>
        <input type="date" name="start_date" />
        <br>
        <label>Start Time:</label>
        <input type="time" name="start_time" />
        <br>
        <label>End Date:</label>
        <input type="date" name="end_date" />
        <br>
        <label>End Time:</label>
        <input type="time" name="end_time" />
        <br>
        <label>Notes:</label>
        <textarea type="text" name="notes" value=""></textarea>
        <br>

        <!-- FOR CLUB RESERVATION-->
        <label for="club_id">Associated Club: </label>
            <select name="club_id" id="club_id" required>
                <option value="None">
                    No Club
                </option>   
                <?php 
                for ($i = 0; $i < $num_clubs_in; $i++) 
                { ?>
                    <option value="<?= $clubs_patron_in_res[$i][0] ?>">
                        <?= $clubs_patron_in_res[$i][1] ?>
                    </option>
                <?php } ?>
            </select>
        <br>
        <input type="submit" name="add_reservation" value="Add Reservation"/>
    </form>

    <a href="session_spaces_find.php">See Available Spaces</a>


    <h2>My Upcoming Space Reservations</h2>
    <?=result_to_deletable_table_general($res, [0,1], "Cancel?", "Cancel Reservations");?>

    <a href="session_spaces_past.php">Show All Past Reservations</a>

</body>

</html>