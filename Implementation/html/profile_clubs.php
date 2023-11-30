<?php
require 'includes/setup.php';
require 'includes/functions.php';

$conn = setup();
$club_info = $conn->query("SELECT * FROM pretty_clubs_librarian");
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

    }
    header("Location: {$_SERVER['REQUEST_URI']}", true, 303);
    exit();
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
    <h3>Add Clubs</h3>
    <form method=POST>
        <label for="club_name">Club name:</label>
        <input type="text" name="club_name" /><br>
        <label for="add_club_desc">Club description:</label>
        <textarea name="add_club_desc"></textarea><br>
        <input type="submit" name="add_club" value="Add Club" />

    </form>
    <h1>Select a club to Examine:</h1>
    <form method="GET">
        <?php
        result_to_clickable_table($club_info, "club", "details_club.php", False);
            ?>
    </form>
</body>

</html>