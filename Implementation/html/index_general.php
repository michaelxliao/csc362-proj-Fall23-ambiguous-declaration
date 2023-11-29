<?php
require 'includes/setup.php';
$conn = setup();
session_start();

// check if they've logged in through login page.
if(isset($_POST['login_submit']))
{
    if(!is_numeric($_POST['patron_login_id']))
    {   
        header("Location:login_general.php?error=true", true, 303);
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
    }

    $_SESSION['patron_id'] = $login_id;
}



// check if they're logged in at all, if not crash
if(!isset($_SESSION['patron_id']))
{
    header("Location:login_general.php?error=true", true, 303);
}



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
<a class="link-button" href=login_general.php> Back to Sign-In</a>
    <header>
        <h2> Welcome, esteemed patron , to Therpston County Public Library.</h2>
    </header>

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