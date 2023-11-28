<?php
require 'includes/setup.php';
require 'includes/format_result.php';
$conn = setup();
$patron_id = $_GET['patronid'];
$patron_info= $conn->query("SELECT patron_first_name ,patron_last_name, patron_email, patron_phone
                                    FROM patrons
                                    WHERE patron_id = $patron_id;");
$patron_info_res = $patron_info->fetch_all();
$patron_loans = $conn->query("SELECT material_title, loan_start_date, loan_return_date
                                FROM selection
                                INNER JOIN patron_selection_interactions
                                USING(material_id)
                                INNER JOIN loans
                                USING (interaction_id)
                                WHERE patron_id = $patron_id;");
$patron_spaces_reserved = $conn->query("SELECT space_name, space_room_number, start_reservation, end_reservation
                                        FROM patrons
                                        INNER JOIN space_reservations
                                        USING (patron_id)
                                        INNER JOIN spaces
                                        USING (space_id)
                                        WHERE patron_id = $patron_id;");
$patron_clubs = $conn->query("SELECT club_name, member_is_leader
                                FROM patrons
                                INNER JOIN club_members
                                USING (patron_id)
                                INNER JOIN clubs
                                USING (club_id)
                                WHERE patron_id =$patron_id;");
$patron_holds = $conn->query("SELECT material_title, hold_date_requested
                                FROM selection
                                INNER JOIN patron_selection_interactions
                                USING (material_id)
                                INNER JOIN holds
                                USING (interaction_id)
                                WHERE patron_id = $patron_id;");
$patron_loans = $conn->query("SELECT material_title AS 'Title',
                                     loan_start_date AS 'Checked Out',
                                     loan_return_date AS 'Returned?',
                                     DATE_ADD(loan_start_date, INTERVAL (2*(loan_renewal_tally+1)) WEEK) AS 'Due Date'
                                FROM selection
                                     INNER JOIN patron_selection_interactions USING(material_id)
                                     INNER JOIN loans USING (interaction_id)
                               WHERE patron_id = $patron_id AND loan_return_date IS NULL;");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST["new_email"])){
        $_update_statement=$conn->prepare("CALL update_patron(?,?,?,?,?)");
        $_update_statement->bind_param('issss',$patron_id,$patron_info_res[0][0], $patron_info_res[0][1], $_POST["new_email"], $patron_info_res[0][3]);
        $_update_statement->execute();
    }
    if(isset($_POST["new_phone"])){
        $_update_statement=$conn->prepare("CALL update_patron(?,?,?,?,?)");
        $_update_statement->bind_param('issss',$patron_id,$patron_info_res[0][0], $patron_info_res[0][1], $patron_info_res[0][2], $_POST["new_phone"]);
        $_update_statement->execute();
    }
    if(isset($_POST["change_first_name"])){
        $_update_statement=$conn->prepare("CALL update_patron(?,?,?,?,?)");
        $_update_statement->bind_param('issss',$patron_id,$_POST["new_first_name"], $patron_info_res[0][1], $patron_info_res[0][2], $patron_info_res[0][3]);
        $_update_statement->execute();
    }
    if(isset($_POST["change_last_name"])){
        $_update_statement=$conn->prepare("CALL update_patron(?,?,?,?,?)");
        $_update_statement->bind_param('issss',$patron_id,$patron_info_res[0][0],$_POST["new_last_name"], $patron_info_res[0][2], $patron_info_res[0][3]);
        $_update_statement->execute();
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
       <h1><?=  print_r($patron_info_res[0][0] . " " . $patron_info_res[0][1]); ?></h1>
    </header>
    <a href="profile_patrons.php">Back to Patron List</a>
    <h2>Current First Name: <?php print_r( $patron_info_res[0][0]);?></h2>
    <form method=POST>
        <input type="text" name="new_first_name">
        <input type="submit" name="change_first_name" value="Update Patron First Name";>
    </form>
    <h2>Current Last Name: <?php print_r($patron_info_res[0][1]);?></h2>
    <form method=POST>
        <input type="text" name="new_last_name">
        <input type="submit" name="change_last_name" value="Update Patron Last Name";>
    </form>
    <h2>Current Email: <?php echo $patron_info_res[0][2];?></h2>
    <form method=POST>
        <input type="text" name="new_email">
        <input type="submit" name="change_email" value="Update Email";>
    </form>
    <h2>Current Phone Number: <?php echo $patron_info_res[0][3];?></h2>
    <form method=POST>
        <input type="text" name="new_phone">
        <input type="submit" name="change_phone" value="Update Phone Number";>
    </form>
    <h2>Checked Out Material(s):</h2>
    <?php result_to_table($patron_loans);?>
    <h2>Current Hold(s):</h2>
    <?= result_to_table($patron_holds);?>
    <h2>Future Reservation(s):</h2>
    <?= result_to_table($patron_spaces_reserved)?>
    <h2>Club(s):</h2>
    <form method=POST>
        <?=result_to_table($patron_clubs)?>
    </form>
</body>

</html>