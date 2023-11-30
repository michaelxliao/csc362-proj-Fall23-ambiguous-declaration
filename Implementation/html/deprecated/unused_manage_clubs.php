<?php
require 'includes/setup.php';
require 'includes/functions.php';

$conn = setup();

$changesMade = False;

# Check if club added

if (isset($_POST["add_club"])) {
    $changesMade = True;

    if (isset($_POST["club_name"]) && isset($_POST["add_club_desc"])) {
        # Check for the club already being in database.
        $checkexists = $conn->prepare("SELECT * FROM clubs WHERE club_name = ?");
        $checkexists->bind_param('s', $_POST["club_name"]);
        $result = $checkexists->execute();

        // this is technically an int but 0 means it does not have that club & 1 means it does
        $has_value = $checkexists->get_result()->num_rows;

        #we update if the club currently exists.
        if (!$has_value) {
            $insert_stmt = $conn->prepare("CALL add_club(?, ?)");
            $insert_stmt->bind_param('ss', $_POST["club_name"], $_POST["add_club_desc"]);
            $result = $insert_stmt->execute();
        }

        /*
            $insert_stmt = $conn->prepare("CALL update_club(?, ?)");
            $insert_stmt->bind_param('ss', $_POST["club_name"], $_POST["club_desc"]);
            $result = $insert_stmt->execute();

        } 
        #we insert otherwise.
        else{
        
        }
        */
    }
}

if (isset($_POST["edit_club"])) {
    $changesMade = True;

    if (isset($_POST["old_club_name"]) && isset($_POST["new_club_name"]) && isset($_POST["edit_club_desc"])) {
        # Check for the club already being in database.
        $checkexists = $conn->prepare("SELECT * FROM clubs WHERE club_name = ?");
        $checkexists->bind_param('s', $_POST["old_club_name"]);
        $checkexists->execute();

        $result = $checkexists->get_result();

        // this is technically an int but 0 means it does not have that club & 1 means it does
        $has_value = $result->num_rows;

        #we update if the club currently exists.
        if ($has_value) {
            $club = $result->fetch_all()[0];
            $insert_stmt = $conn->prepare("CALL update_club(?, ?, ?)");
            $insert_stmt->bind_param('iss', $club_id[0], $_POST["new_club_name"], $_POST["edit_club_desc"]);
            $result = $insert_stmt->execute();

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
    <h2>Club Search and Editing</h2>
    <h3>Add Clubs</h3>
    <form method=POST>
        <table>
            <thead>
                <th></th>
            </thead>
            <tbody>
                <!-- Name -->
                <tr>
                    <td style="text-align: right">Club name:</td>
                    <td><input type="text" name="club_name" /></td>
                </tr>
                <!-- Description -->
                <tr>
                    <td style="text-align: right;">Club description:</td>
                    <td><input type="text" name="add_club_desc" style="height: 70px;" /></td>
                </tr>
                <tr>
            </tbody>
        </table>
        <input type="submit" name="add_club" value="Add Club" />

    </form>


    <h3>Edit Clubs</h3>
    <form method=POST>
        <table>
            <thead>
                <th></th>
            </thead>
            <tbody>
                <!-- Name -->
                <tr>
                    <td style="text-align: right">Old club name:</td>
                    <td><input type="text" name="old_club_name" /></td>
                </tr>
                <tr>
                    <td style="text-align: right">New club name:</td>
                    <td><input type="text" name="new_club_name" /></td>
                </tr>
                <!-- Description -->
                <tr>
                    <td style="text-align: right;">Club description:</td>
                    <td><input type="text" name="edit_club_desc" style="height: 70px;" /></td>
                </tr>
                <tr>
            </tbody>
        </table>
        <input type="submit" name="edit_club" value="Edit Club" />

    </form>

    <h3>All Clubs
        <form> <!-- will hold filtering form later -->
            <?php
            result_to_toggle_active_table($conn->query('SELECT * FROM clubs'));
            ?>
        </form>




</body>

</html>