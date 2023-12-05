<?php
require 'includes/setup.php';
require 'includes/functions.php';
$conn = setup();
// check patron exists


    if(!isset($_GET['spaceid']))
    {
        header("Location:profile_spaces.php?error=true", true, 303);
    }

    $space_id = $_GET['spaceid'];

    /*
    $space_data_stmt = $conn->prepare("SELECT 
                                    space_id, space_name
                                    FROM spaces 
                                    WHERE space_id = ?");
    */


    $space_data_stmt = $conn->prepare("SELECT 
                                    *
                                    FROM spaces 
                                    WHERE space_id = ?");

    $space_data_stmt->bind_param("i", $space_id);
    if(!$space_data_stmt->execute())
    {
        print("SQL error!");
    }
    $res = $space_data_stmt->get_result();
    if($res->num_rows == 0)
    {
        header("Location:profile_spaces.php", true, 303);
        exit();
    }

    $space_data = $res->fetch_all();


    $space_name = $space_data[0][1];


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['del_space'])){
            $delete_stmt = $conn->prepare("CALL del_space(?);");
            $delete_stmt->bind_param("i", $space_id);
            if(!($delete_stmt->execute()))
            {
                print("SQL oopsie doopsie! x3 we made a... mistake");
                exit();
            }
            header("Location:profile_spaces.php", true, 303);
            exit();
        }

        if (isset($_POST['add_reservation'])) {
            // $space_id is space id
            $patron_id = $_POST['patron_id'];
            if($patron_id == "")
            {
                header($_SERVER['REQUEST_URI'], true, 303);
            }
            $start_time = $_POST['start_date'] . ' '. $_POST['start_time'];
            $end_time = $_POST['end_date'] . ' '. $_POST['end_time'];
            $notes = $_POST['notes'];
                
            if($_POST['club_id'] == 'None')
            {
                $reservation_ins_stmt = $conn->prepare("CALL add_reservation(?, ?, ?, ?, ?);");
                $reservation_ins_stmt->bind_param("iisss", $patron_id, $space_id, $start_time, $end_time, $notes);
            }
            else
            {
                $new_club_id = $_POST['club_id'];
                $reservation_ins_stmt = $conn->prepare("CALL add_club_reservation(?, ?, ?, ?, ?, ?);");
                $reservation_ins_stmt->bind_param("iisssi", $patron_id, $space_id, $start_time, $end_time, $notes, $new_club_id);
            }
    
            $reservation_ins_stmt->execute();
    
        }

        if(isset($_POST["delete_records"])) {
            $result = $conn->query("SELECT reservation_id FROM space_reservations");
            $all_ids = $result->fetch_all();
            $num_rows = count($all_ids);
            $del_stmt = $conn->prepare("DELETE FROM space_reservations WHERE reservation_id=?");
            $del_stmt->bind_param('s', $id);
            for($i=0; $i<$num_rows; $i++)
            {
                $id = $all_ids[$i][0];
                if(isset($_POST['checkbox' . $id]))
                {
                    $result = $del_stmt->execute();
                }
            }
        }
        
    
        header($_SERVER['REQUEST_URI'], true, 303);
    }

    
    $club_spaces_query = $conn->query("SELECT club_id, club_name 
    FROM clubs");
    $club_spaces_data = $club_spaces_query->fetch_all();

    // for reservations of THIS space.

    $this_reservations_stmt = $conn->prepare("SELECT * 
                                            FROM pretty_upcoming_space_reservations
                                            WHERE space_id = ?;");
    $this_reservations_stmt->bind_param("i", $space_id);
    if(!$this_reservations_stmt->execute())
    {
        echo "SQL screwed up";
        exit();
    }

    $this_reservations_res = $this_reservations_stmt->get_result();
    $num_upcoming_reservations = $this_reservations_res->num_rows;
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
    <a href="profile_spaces.php">Back to All Spaces</a>
    <h1>Details for <?=$space_name?></h1>

    <h3>Edit Space Details</h3>


    <h2>Reserve This Space</h2>
    <!-- we need:
        - patronid, 
        - spaceid, 
        - start_time DATETIME,
        - end_time DATETIME,
        - notes VARCHAR(256),
        - clubid INT (whether it's a club or not!)-->

    <form method=POST>
        <!-- Space Name -->
        <label for="space_name">Space Name: <?=$space_name?></label>
        <br>
        <label for="patron_name">Patron Name:</label>
        <input type="text" name="patron_id" />
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
                for ($i = 0; $i < $club_spaces_query->num_rows; $i++) 
                { ?>
                    <option value="<?= $club_spaces_data[$i][0] ?>">
                        <?= $club_spaces_data[$i][1] ?>
                    </option>
                <?php } ?>
            </select>
        <br>
        <input type="submit" name="add_reservation" value="Add Reservation"/>
    </form>


    <h2>View/Delete Upcoming Reservations</h2>
            
    <?php
    if($num_upcoming_reservations == 0)
    {
        echo "No future reservations for this space at this time!";
    }
    else{
        result_to_deletable_table_general($this_reservations_res, [-1], "Cancel Reservation", "Cancel Selected Reservations");
    }
    ?>
    
    <br><br><br><br>

    <form method=POST>
        <input type="submit" name="del_space" value="Delete This Room"/>
    </form>


</body>

</html>