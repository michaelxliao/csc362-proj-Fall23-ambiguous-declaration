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
        <h1>Therpston County Public Library</h1>
    </header>
    <a class="link-button" href=index.php> Back to Sign-In</a>

    <ul>
        <li>
            <a href="profile_patrons.php">View and Manage Patrons</a>
        </li>
        <li>
            <a href="profile_clubs.php">View and Manage Clubs</a>
            <!-- this is to look up all related info on a specific club -->
        </li>
        <li>
            <a href="profile_holds.php">Holds (WIP From Times, Spaces, and Patrons)</a>
        </li>
        <li>
            <a href="profile_narratives.php">Adaptations of a Narrative (WIP Find All Narratives)</a>
        </li>
        <li>
            <a href="profile_loans.php">Loans on the Selection (WIP)</a>
        </li>
        <li>
            <a href="profile_spaces.php">Spaces Available to Reserve</a>
        </li>   
        <li>
            <a href="profile_selection.php">The Catalog (filterable, public-facing)</a>
        </li>
        <li>
            <a href="manage_filters.php">Manage Filters for Selection (genres, languages, etc.)</a>
        </li>
    </ul>

    <!-- <h1>we prolly need a footer but that's a later problem</h1> -->

</body>

</html>