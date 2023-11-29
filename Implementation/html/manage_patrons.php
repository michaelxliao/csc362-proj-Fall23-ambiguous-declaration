<?php
require 'includes/setup.php';
require 'includes/format_result.php';

$conn = setup();

$changesMade = False;

# Check if club added

if (isset($_POST["add_patron"])) {
    $changesMade = True;

    if (isset($_POST["add_patron_first_name"])&& (isset($_POST["add_patron_last_name"]))){
        if(isset($_POST["add_patron_email"])&&(isset($_POST["add_patron_phone"]))) {
        # Check if the patron is already being in database.
            $checkexists = $conn->prepare("SELECT * FROM clubs WHERE club_name = ?");
            $checkexists->bind_param('s', $_POST["club_name"]);
            $result = $checkexists->execute();
            $has_value = $checkexists->get_result()->num_rows;
            if (!$has_value) {
                $insert_stmt = $conn->prepare("CALL add_patron(?,?,?,?)");
                $insert_stmt->bind_param('ssss', $_POST["add_patron_first_name"],$_POST["add_patron_last_name"], $_POST["add_patron_email"], $_POST["add_patron_phone"]);
                $result = $insert_stmt->execute();
            }
        }
        if(isset($_POST["add_patron_email"])&&(!isset($_POST["add_patron_phone"]))) {
            # Check if the patron is already being in database.
            $checkexists = $conn->prepare("SELECT * FROM clubs WHERE club_name = ?");
            $checkexists->bind_param('s', $_POST["club_name"]);
            $result = $checkexists->execute();
            $has_value = $checkexists->get_result()->num_rows;
            if (!$has_value) {
                $insert_stmt = $conn->prepare("CALL add_patron(?,?,?,?)");
                $insert_stmt->bind_param('ssss', $_POST["add_patron_first_name"],$_POST["add_patron_last_name"], $_POST["add_patron_email"],"");
                $result = $insert_stmt->execute();
            }
        }
        if(!isset($_POST["add_patron_email"])&&(isset($_POST["add_patron_phone"]))) {
            # Check if the patron is already being in database.
            $checkexists = $conn->prepare("SELECT * FROM patron WHERE club_name = ?");
            $checkexists->bind_param('s', $_POST["club_name"]);
            $result = $checkexists->execute();
            $has_value = $checkexists->get_result()->num_rows;
            if (!$has_value) {
                $insert_stmt = $conn->prepare("CALL add_patron(?,?,?,?)");
                $insert_stmt->bind_param('ssss', $_POST["add_patron_first_name"],$_POST["add_patron_last_name"],"",$_POST["add_patron_phone"]);
                $result = $insert_stmt->execute();
            }
        }
    }
}


if ($changesMade) {
    header("Location:" . $_SERVER['REQUEST_URI'], true, 303);
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
<a href="index_staff.php">Back to Staff Page</a>
    <h2>Patron Adding and Editing</h2>
    <h3>Add Patron</h3>
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

    <h3>All Patrons
        <form> <!-- will hold filtering form later -->
            <?php
            result_to_toggle_active_table($conn->query('SELECT * FROM patrons'));
            ?>
        </form>




</body>

</html>