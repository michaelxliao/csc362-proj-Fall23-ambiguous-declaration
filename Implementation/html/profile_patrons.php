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
            // $checkexists = $conn->prepare("SELECT * FROM clubs WHERE club_name = ?");
            // $checkexists->bind_param('s', $_POST["club_name"]);
            // $result = $checkexists->execute();
            // $has_value = $checkexists->get_result()->num_rows;
            // if (!$has_value) {
                $insert_stmt = $conn->prepare("CALL add_patron(?,?,?,?)");
                $insert_stmt->bind_param('ssss', $first_name, $last_name, $email, $phone);
                $result = $insert_stmt->execute();
           // }
        }
        if(($_POST["add_patron_email"]!="" && $_POST["add_patron_phone"]=="")) {
            # Check if the patron is already being in database.
            // $checkexists = $conn->prepare("SELECT * FROM clubs WHERE club_name = ?");
            // $checkexists->bind_param('s', $_POST["club_name"]);
            // $result = $checkexists->execute();
            // $has_value = $checkexists->get_result()->num_rows;
            // if (!$has_value) {
                $insert_stmt = $conn->prepare("CALL add_patron(?,?,?,?)");
                $insert_stmt->bind_param('ssss', $first_name, $last_name, $email, $empty);
                $result = $insert_stmt->execute();
           //}
        }
        if($_POST["add_patron_email"]=="" && $_POST["add_patron_phone"]!="") {
            # Check if the patron is already being in database.
            // $checkexists = $conn->prepare("SELECT * FROM clubs WHERE club_name = ?");
            // $checkexists->bind_param('s', $_POST["club_name"]);
            // $result = $checkexists->execute();
            // $has_value = $checkexists->get_result()->num_rows;
            // if (!$has_value) {
                $insert_stmt = $conn->prepare("CALL add_patron(?,?,?,?)");
                $insert_stmt->bind_param('ssss', $first_name, $last_name, $empty, $phone);
                $result = $insert_stmt->execute();
            //}
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
    <a href="index_staff.php">Back to Staff</a>
    <h2>Add a Patron</h2>
    <form method=POST>
        <table>
            <thead>
                <th></th>
            </thead>
            <tbody>
                <!-- Name -->
                <tr>
                    <td style="text-align: right">Patron First Name:</td>
                    <td><input type="text" name="add_patron_first_name" /></td>
                </tr>
                <tr>
                    <td style="text-align: right">Patron Last Name:</td>
                    <td><input type="text" name="add_patron_last_name" /></td>
                </tr>
                <!-- Contact Info -->
                <tr>
                    <td style="text-align: right;">Patron Email</td>
                    <td><input type="text" name="add_patron_email" style="height: 70px;" /></td>
                </tr>
                <tr>
                    <td style="text-align: right;">Patron Phone</td>
                    <td><input type="text" name="add_patron_phone" style="height: 70px;" /></td>
                </tr>
                <tr>
            </tbody>
        </table>
        <input type="submit" name="add_patron" value="Add Patron" />

    </form>
    <h1>Select a Patron to Examine</h1>
    <p>To add a patron, use <a href="manage_patrons.php">this link.</a></p>
    <form>
    <?php result_to_clickable_table($conn->query('SELECT * FROM pretty_patron_details_librarian'), "patron", "details_patron.php", true) ?>
    </form>
</body>