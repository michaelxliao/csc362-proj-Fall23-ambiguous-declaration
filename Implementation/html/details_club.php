<?php
require 'includes/setup.php';
require 'includes/format_result.php';
$conn = setup();
$club_id = $_GET['clubid'];
$club_members = $conn->query("SELECT patron_first_name, patron_last_name, member_info, member_is_leader 
                            FROM patrons
                            INNER JOIN club_members USING(patron_id)
                            INNER JOIN clubs USING(club_id)
                            WHERE club_id = $club_id;");
$club_spaces_reserved = $conn->query("SELECT space_name, start_reservation, end_reservation
                                        FROM clubs
                                        INNER JOIN club_reservations
                                        USING (club_id)
                                        INNER JOIN space_reservations
                                        USING (reservation_id)
                                        INNER JOIN spaces
                                        USING (space_id)
                                        WHERE club_id=$club_id;");

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
        <!-- this is where h1s etc. go, any explanatory info -->
    </header>
    <a href="profile_clubs.php">Back to Club Profiles</a>
    <form>
        <h1>Club Member(s):</h1>
    <?php

    result_to_table($club_members); 
    ?>
        <h1>Space Reservation(s):</h1>
    <?= result_to_table($club_spaces_reserved); ?>
    </form>
</body>

</html>