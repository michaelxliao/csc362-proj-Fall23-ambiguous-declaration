<?php
require 'includes/setup.php';
require 'includes/functions.php';
$conn = setup();
session_start();

// check if they're logged in, if not crash
    if(!isset($_SESSION['patron_id']))
    {
        header("Location:login_general.php?error=true", true, 303);
        exit();
    }

    $login_id = $_SESSION['patron_id'];

    $patron_info = $conn->prepare("SELECT patron_id, 
                                    patron_first_name,
                                    patron_last_name,
                                    patron_phone,
                                    patron_email
                                    FROM patrons 
                                    WHERE patron_id = ?");

    $patron_info->bind_param("i", $login_id);
    if(!$patron_info->execute())
    {
        print("SQL error!");
    }
    $res = $patron_info->get_result();
    $patron_data = $res->fetch_assoc();

    if(isset($patron_data['patron_email']))
    {
        $patron_email = $patron_data['patron_email'];
    }
    else
    {
        $patron_email = "Not Set";
    }


    if(isset($patron_data['patron_phone']))
    {
        $patron_phone = $patron_data['patron_phone'];
    }
    else
    {
        $patron_phone = "Not Set";
    }

    $patron_first_name = $patron_data['patron_first_name'];

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
    <a class="link-button" href=login_general.php> Back to Sign-In</a>

        <h1> Welcome, <?=$patron_first_name?>, to the Therpston County Public Library.</h1>
    </header>
    <a href="index_general.php">Back to Main Patron Page</a>

</body>

</html>