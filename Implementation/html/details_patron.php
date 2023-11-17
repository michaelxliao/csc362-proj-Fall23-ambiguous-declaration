<?php
require 'includes/setup.php';
require 'includes/format_result.php';
$conn = setup();
$patron_id = $_GET['patronid'];
$patron_first_name= $conn->query("SELECT patron_first_name
                                    FROM patrons
                                    WHERE patron_id = $patron_id;");
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
                               WHERE patron_id = $patron_id")
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
    </header>
    <a href="profile_patrons.php">Back to Patron List</a>
    <form>
    <h2>Checked Out Material(s):</h2>
    <?php result_to_table($patron_loans);?>
    <h2>Current Hold(s):</h2>
    <?= result_to_table($patron_holds);?>
    <h2>Future Reservation(s):</h2>
    <?= result_to_table($patron_spaces_reserved)?>
    <h2>Club(s):</h2>
    <?= result_to_table($patron_clubs)?>
    </form>
</body>

</html>