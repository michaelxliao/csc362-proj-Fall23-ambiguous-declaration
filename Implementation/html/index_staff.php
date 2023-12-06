<?php
require 'includes/setup.php';
$conn = setup();
session_start();
$_SESSION['mode'] = 'staff';

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

    <nav>
            <a href="profile_selection.php">All Materials</a>
            <br>
            <a href="profile_narratives.php">Adaptations of a Narrative</a>
            <br>
            <a href="profile_patrons.php">View and Manage Patrons</a>
            <br>
            <a href="profile_holds.php">Holds</a> <!-- (WIP From Times, Spaces, and Patrons) -->
            <br>
            <a href="profile_spaces.php">Spaces and Reservations</a>
            <br>
            <a href="profile_clubs.php">Clubs</a>
            <br>
            <a href="profile_filters.php">Catalog Filters (e.g. genres)</a>
            <br>
        </nav>

    <!-- <h1>we prolly need a footer but that's a later problem</h1> -->

</body>
Lorem ipsum dolor sit amet,
</html>