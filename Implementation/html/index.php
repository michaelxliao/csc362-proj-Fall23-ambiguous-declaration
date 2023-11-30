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
    <h1> Welcome to the Therpston County
        Public Library (WIP)!
    </h1>
</header>

    <a class="link-button" href="login_general.php">For Patrons</a>
    <a class="link-button" href="index_staff.php">For Staff</a>
</body>

</html>