<?php
require '../includes/setup.php';
$conn = setup();
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gentium+Book+Plus&family=Montserrat:wght@500&display=swap"
        rel="stylesheet">
</head>

<body>
    <a href=index.php> Back to Sign-In</a>
    <h1>Therpston County Public Library</h1>

    <h2>Reports</h2>
    <h3>Find Specific:</h3>
    <ul>
        <li>
            <a href="patron_profile.php">Patrons (Patron Profile)</a>
        </li>
        <li>
            <a href="club_profile.php">Clubs (Club Profile)</a>
            <!-- this is to look up all related info on a specific club -->
        </li>
        <li>
            <a href="current_holds.php">Holds (rework)</a>
        </li>
        <li>
            Adaptations of a Narrative
        </li>
    </ul>

    Show Details On:
    </ul>
    <li>
        <a href="catalog.php">The Catalog (filterable, public-facing)</a>
    </li>
    <li>
        Current Loans
    </li>
    <li>
        <a>Current Reservations</a>
    </li>
    <li>
        Current Holds
    </li>
    <li>
        All Active Clubs
    </li>
    </ul>


    <h2>Data Management</h2>
    <ul>
        <li>
            Selection
        </li>
        <li>
            Patrons
        </li>
        <li>
            Spaces and Space Reservations
        </li>
        <li>
            <a href="manage_clubs.php">Clubs</a> <!-- this is to see and manage all clubs -->
        </li>
        <li>
            Holds and Loans (selection)
        </li>
    </ul>



</body>

</html>