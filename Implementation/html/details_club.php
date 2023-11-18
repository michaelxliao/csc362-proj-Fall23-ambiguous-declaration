<?php
require 'includes/setup.php';
require 'includes/format_result.php';
$conn = setup();
$club_id = $_GET['clubid'];
$club_name_res = $conn->query("SELECT club_name FROM clubs WHERE club_id = $club_id"); // note all these need to be refactoered into perpared statements
$club_name = $club_name_res->fetch_row()[0];

$patrons_res = $conn->query('SELECT CONCAT(patron_first_name, " ", patron_last_name) AS patron_name,
                                    patron_id
                               FROM patrons');
$patron_info = $patrons_res->fetch_all();

$spaces_res = $conn->query('SELECT space_id, space_name FROM spaces');
$spaces_info = $spaces_res->fetch_all();

// echo $club_name;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_member'])) {
        $is_leader = false;
        if (isset($_POST['is_leader'])) {
            $is_leader = true;
        }
        $insert_stmt = $conn->prepare('INSERT INTO club_members (club_id, patron_id, member_info, member_is_leader)
                                       VALUES (?, ?, ?, ?)');
        $insert_stmt->bind_param('iisi', $club_id, $_POST['new_member_id'], $_POST['new_member_desc'], $is_leader);
        $insert_stmt->execute();
    }

    if (isset($_POST['add_space_reservation'])) {

    }
    
    header("Location: {$_SERVER['REQUEST_URI']}", true, 303);
    exit();
}

$club_members_res = $conn->query("SELECT CONCAT(patron_first_name, ' ', patron_last_name) AS 'Name',
                                     member_info AS 'Details',
                                     member_is_leader
                                FROM patrons
                                     INNER JOIN club_members USING(patron_id)
                                     INNER JOIN clubs USING(club_id)
                               WHERE club_id = $club_id;");
$club_spaces_reserved_res = $conn->query("SELECT space_name AS 'Space',
                                             start_reservation AS 'Reserved From',
                                             end_reservation AS 'Reserved Until'
                                        FROM clubs
                                             INNER JOIN club_reservations USING (club_id)
                                             INNER JOIN space_reservations USING (reservation_id)
                                             INNER JOIN spaces USING (space_id)
                                       WHERE club_id=$club_id;");

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
        <h1><?= $club_name ?></h1>
    </header>
    <a href="profile_clubs.php">Back to Club Profiles</a>
    <h2>Club Member(s):</h2>
    <form method=POST>
        <label for="new_member_id">Add new member: </label>
        <select name="new_member_id">
            <?php for ($i = 0; $i <$patrons_res->num_rows; $i++) { ?>
                <option value='<?= $patron_info[$i][1] ?>'><?= $patron_info[$i][0] ?></option>
            <?php } ?>
        </select>
        <label for="new_member_desc">Extra details? </label>
        <input type="text" name="new_member_desc" placeholder="Leave blank for no details">
        <label for="is_leader">Part of leadership?</label>
        <input type="checkbox" name="is_leader">
        <input type="submit" name="add_member" value="Submit">
    </form>
    <?php result_to_table($club_members_res); ?>
    <h2>Space Reservation(s):</h2>
    <!-- <form method=POST>
        <label for="space_id">Reserve a space: </label>
        <select name="space_id">
            <?php for ($i = 0; $i <$spaces_res->num_rows; $i++) { ?>
                <option value='<?= $spaces_info[$i][0] ?>'><?= $spaces_info[$i][1] ?></option>
            <?php } ?>
        </select>
        
    </form> -->
    <?= result_to_table($club_spaces_reserved_res); ?>
</body>

</html>