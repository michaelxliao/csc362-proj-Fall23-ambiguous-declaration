<?php
require 'includes/setup.php';
$conn = setup();
session_start();
$_SESSION['mode'] = 'viewonly';


// check if they've logged in through login page.
if(isset($_POST['login_submit']))
{
    if(!is_numeric($_POST['patron_login_id']))
    {   
        header("Location:login_general.php?error=true", true, 303);
        exit();
    }
    $login_id = $_POST['patron_login_id'];

    //check that their id is in the DB.
    $id_statement = $conn->prepare("SELECT patron_id FROM patrons WHERE patron_id = ?");
    $id_statement->bind_param("i", $login_id);
    if(!$id_statement->execute())
    {
        print("SQL error!");
    }
    $id_res = $id_statement->get_result();
    
    if($id_res->num_rows == 0)
    {
        header("Location:login_general.php?error=true", true, 303);
        exit();
    }

    $_SESSION['patron_id'] = $login_id;

    header("Location:" . $_SERVER['REQUEST_URI'], true, 303);
    exit();
}



// check if they're logged in at all, if not crash
if(!isset($_SESSION['patron_id']))
{
    header("Location:login_general.php?error=true", true, 303);
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
$patron_last_name = $patron_data['patron_last_name'];

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
    
    <p>
        Name: <?=$patron_first_name?> <?=$patron_last_name?><br>
        Email: <?=$patron_email?><br>
        Phone: <?=$patron_phone?><br>
    </p>
    
    <nav>
        <a href="session_loanholds.php">Show My Loans and Holds</a><br>
        <a href="session_sel_material.php">Search the Catalog</a><br>
        <a href="session_sel_narrative.php">Find Adaptations of a Material</a><br>
        <a href="session_spaces.php">Find Spaces to Reserve (and my current reservations)</a><br>
        <a href="session_clubs.php">Show My Clubs (and my roles in them)</a><br>
    </nav>

</body>

</html>