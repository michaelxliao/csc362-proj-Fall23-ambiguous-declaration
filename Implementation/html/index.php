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
    <h1> Welcome to the Therpston County
        Public Library!
    </h1>

    <a href="general_index.php">
        <button type="button">For Patrons</button>
    </a>
    <a href="staff_index.php">
        <button type="button">For Staff</button>
    </a>
</body>

</html>