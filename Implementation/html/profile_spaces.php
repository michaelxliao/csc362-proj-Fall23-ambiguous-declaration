<?php
require 'includes/setup.php';
require 'includes/functions.php';
$conn = setup();

$ALL_SPACES = "All Spaces";

$space_names_res = $conn->query("SELECT space_name FROM active_spaces");
$space_names = $space_names_res->fetch_all();

$sql_query = "SELECT *
                FROM pretty_spaces_librarian";
$space_id_res = $conn->query($sql_query);

$pretty_sql_query = 'SELECT reservation_id AS "Reservation ID",
                     `Reserved Space` AS "Space Name", -- need to rename because one form filters both tables!
                     `Room Number`,
                     `Capacity`,
                     `Start Time`,
                     `End Time`,
                     `Notes`
                FROM pretty_all_upcoming_space_reservations
                ORDER BY `Start Time` ASC'; // this by default; can be overridden by filtering

$pretty_result = $conn->query($pretty_sql_query);
if (isset($_GET["Filter"])) {
    $where_clauses = [];
    $need_space = false;
    $need_capacity = false;

    if ($_GET["space-name"] == $ALL_SPACES) {
        // do nothing (no addnl filter required)
    } elseif (isset($_GET["space-name"])) { // in this case, show only reservations 4 that space
        $where_clauses[] = '`Space Name` = ?';
        $need_space = true;
    }

    if (isset($_GET["min-capacity"])) {
        $where_clauses[] = '`Capacity` = ?';
        $need_capacity = true;
    }

    if (sizeof($where_clauses) > 0) {
        $final_sql_query = $sql_query . ' WHERE';
        $final_reservation_query = 'SELECT reservation_id AS "Reservation ID",
                                      `Reserved Space` AS "Space Name",
                                      `Room Number`,
                                      `Capacity`,
                                      `Start Time`,
                                      `End Time`,
                                      `Notes`
                                FROM pretty_all_upcoming_space_reservations
                                WHERE';
        for ($i = 0; $i < sizeof($where_clauses) - 1; $i++) { // loop through all where clauses, append with ANDs
            $final_sql_query = $final_sql_query . ' (' . $where_clauses[$i] . ') AND ';
            $final_reservation_query = $final_reservation_query . ' (' . $where_clauses[$i] . ') AND ';
        }
        $final_sql_query = $final_sql_query . ' (' . $where_clauses[sizeof($where_clauses) - 1] . ')'; // handling the final where clause
        $final_reservation_query = $final_reservation_query . ' (' . $where_clauses[sizeof($where_clauses) - 1] . ')' . " ORDER BY `Start Time` ASC'"; // handling the final where clause
        echo $final_sql_query;
        echo '<br>';
        echo $final_reservation_query;

        $filter_stmt = $conn->prepare($final_sql_query);
        $filter_reservation_stmt = $conn->prepare($final_reservation_query); // NOTE!!! @Michael - needs to execute prepared stmts sequentially
        if ($need_space && $need_capacity) { // can alter this later to add more bindable params
            $filter_stmt->bind_param('si', $_GET["space-name"], $_GET['min-capacity']);
            $filter_reservation_stmt->bind_param('si', $_GET["space-name"], $_GET['min-capacity']);
        } elseif ($need_space) {
            $filter_stmt->bind_param('s', $_GET["space-name"]);
            $filter_reservation_stmt->bind_param('s', $_GET["space-name"]);
        } elseif ($need_capacity) {
            $filter_stmt->bind_param('i', $_GET["min-capacity"]);
            $filter_reservation_stmt->bind_param('i', $_GET["min-capacity"]);
        }
        if (!$filter_stmt->execute() || !$filter_reservation_stmt->execute()) {
            echo 'failed to filter';
            exit();
        } else {
            $space_id_res = $filter_stmt->get_result();
            $pretty_result = $filter_reservation_stmt->get_result();
        }
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

    <h2> All Spaces </h2>
    <form method=GET>
        <label for="space-name">Room Name: </label>
        <select name="space-name" id="space-name" required>
            <option value=<?=$ALL_SPACES?>> 
            <?=$ALL_SPACES?>
            </option>   
            <?php for ($i = 0; $i < $space_names_res->num_rows; $i++) { ?>
                <option value="<?= $space_names[$i][0] ?>">
                    <?= $space_names[$i][0] ?>
                </option>
            <?php } ?>
        </select>

        <label for="min-capacity">Minimum Capacity: </label>
        <input type="number" min="1" name="min-capacity" />

        <input type="submit" value="Filter" name="Filter" />
    </form>
    <?php result_to_clickable_table($space_id_res, "space", "details_space.php", true); ?>

    <h2>Reservations Today</h2>
    <?php result_to_table($pretty_result); ?>

</body>

</html>