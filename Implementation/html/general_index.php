<?php
require '../includes/setup.php';
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
    <h2> Welcome, esteemed patron of Therpston.</h2>

    <ul>
        <li>
            <a href="catalog.php">Search the Catalog</a>
        </li>
        <li>
            <a href="catalog.php">Show My Loans and Holds</a>
        </li>
        <li>
            <a href="catalog.php">Find Spaces to Reserve (and my current reservations)</a>
        </li>
        <li>
            <a href="catalog.php">Show My Clubs (and my roles in them)</a>
        </li>



    </ul>

</body>

</html>