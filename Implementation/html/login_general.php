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
    <a class="link-button" href=index.php> Back to Sign-In</a>

    <h1>Therpston County Public Library</h1>
    </header>

    <h1>Please enter your library card number.</h1>
    <form method="POST" action="index_general.php"> 
        <input type="text" name="patron_login_id">
        <input type="submit" name="login_submit" value="Login">
    </form>
    
    <?php
    if(isset($_GET['error']))
    {
        ?><h4>An error occurred. Please log in again.</h4>
        <?php
    }
    ?>
</body>

</html>