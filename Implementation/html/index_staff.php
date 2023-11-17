<?php
require 'includes/setup.php';
$conn = setup();
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

    <h2>Reports</h2>
    <h3>Search for:</h3>
    <ul>
        <li>
            <a href="profile_patrons.php">Patrons (Patron Profile) (FILTER BY NAME, EMAIL, PHONE)</a>
        </li>
        <li>
            <a href="profile_clubs.php">Clubs (Club Profile)</a>
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
    </ul>

    <h3>All Active:</h3>
    </ul>
    <li>
        <a href="catalog.php">The Catalog (filterable, public-facing)</a>
    </li>
    <li>
        <a href="active_loans.php">Active Loans (WIP)</a>
    </li>
    <li>
        <a href="active_spaces.php">Active Space Reservations (WIP)</a>
    </li>
    <li>
        <a href="active_holds.php">Active Holds (WIP)</a>
    </li>
    <li>
        <a href="active_clubs.php">Active Clubs (WIP)</a>
    </li>
    </ul>


    <h2>Data Management</h2>
    <ul>
        <li>
            <a href="manage_selection.php"> Review Selection to Add or Remove (WIP)</a>
        </li>
        <li>
            <a href="manage_patrons.php">Patrons (WIP)</a>
        </li>
        <li>
            <a href="manage_spaces.php">Spaces and Space Reservations (WIP)</a>
        </li>
        <li>
            <a href="manage_clubs.php">Clubs</a> <!-- this is to see and manage all clubs -->
        </li>
        <li>
            <a href="manage_loanhold.php">Holds and Loans for Selection (WIP)</a>
        </li>
        <li>
            <a href="manage_filters.php">Filters for Selection (WIP)</a>
        </li>
    </ul>

    <h1>we prolly need a footer but that's a later problem</h1>

</body>

</html>