<?php
require 'includes/setup.php';
require 'includes/functions.php';

$conn = setup();
if (isset($_POST["add_patron"])) {
    $changes_made = True;

    if (isset($_POST["add_patron_first_name"])&& (isset($_POST["add_patron_last_name"]))){
        $first_name = $_POST["add_patron_first_name"];
        $last_name = $_POST["add_patron_last_name"];
        $email=$_POST["add_patron_email"];
        $phone =  $_POST["add_patron_phone"];
        $empty = NULL;
        if(($_POST["add_patron_email"]!="" && $_POST["add_patron_phone"]!="")) {
        # Check if the patron is already being in database.
            $checkexists = $conn->prepare("SELECT * FROM patrons WHERE patron_email = ?");
            $checkexists->bind_param('s', $email);
            $result = $checkexists->execute();
            $has_value = $checkexists->get_result()->num_rows;
            if (!$has_value) {
                $insert_stmt = $conn->prepare("CALL add_patron(?,?,?,?)");
                $insert_stmt->bind_param('ssss', $first_name, $last_name, $email, $phone);
                $result = $insert_stmt->execute();
           }
        }
        if(($_POST["add_patron_email"]!="" && $_POST["add_patron_phone"]=="")) {
            # Check if the patron is already being in database.
            $checkexists = $conn->prepare("SELECT * FROM patrons WHERE patron_email = ?");
            $checkexists->bind_param('s', $email);
            $result = $checkexists->execute();
            $has_value = $checkexists->get_result()->num_rows;
            if (!$has_value) {
                $insert_stmt = $conn->prepare("CALL add_patron(?,?,?,?)");
                $insert_stmt->bind_param('ssss', $first_name, $last_name, $email, $empty);
                $result = $insert_stmt->execute();
           }
        }
        if($_POST["add_patron_email"]=="" && $_POST["add_patron_phone"]!="") {
                $insert_stmt = $conn->prepare("CALL add_patron(?,?,?,?)");
                $insert_stmt->bind_param('ssss', $first_name, $last_name, $empty, $phone);
                $result = $insert_stmt->execute();
            }
        }
    if ($changes_made) {
        header("Location:" . $_SERVER['REQUEST_URI'], true, 303);
    }
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
<header>
<a class="link-button" href=index.php> Back to Sign-In</a>

<h1>Therpston County Public Library</h1>
</header>
<a href="index_staff.php">Back to Staff</a>
    <h2>Add a Patron</h2>
    <form method=POST>
        <label for="add_patron_first_name">Patron First Name:</label>
        <input type="text" name="add_patron_first_name" required /><br>
        <label for="add_patron_last_name">Patron Last Name:</label>
        <input type="text" name="add_patron_last_name" required /><br>
        <label for="add_patron_email">Patron Email</label>
        <input type="text" name="add_patron_email" /><br>
        <label for="add_patron_phone">Patron Phone</label>
        <input type="text" name="add_patron_phone" max="14" pattern="^\d{3}-\d{3}-\d{4}$" placeholder="XXX-XXX-XXXX" /><br>
        <input type="submit" name="add_patron" value="Add Patron" />

    </form>
    <h1>Select a Patron to Examine</h1>
    <form>
    <?php result_to_clickable_table($conn->query('SELECT * FROM pretty_patron_details_librarian'), "patron", "details_patron.php", true) ?>
    </form>
</body>