<?php
require 'includes/setup.php';
require 'includes/functions.php';
$conn = setup();

$ALL_SPACES = "All Spaces";

$space_names_res = $conn->query("SELECT space_name FROM spaces WHERE space_is_active = TRUE");
$space_names = $space_names_res->fetch_all();

$sql_query = 'SELECT * FROM pretty_all_upcoming_space_reservations'; // this by default; can be overridden by filtering

$result = $conn->query($sql_query);
if (isset($_GET["Filter"])) {
$where_clauses = [];
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
        <!-- this is where h1s etc. go, any explanatory info -->
    </header>

    <form method=GET> <!-- NOTE FOR FILTERING: don't freakin forget your quotes -->
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
            <?php for ($i = 0; $i < $multimedia_types_res->num_rows; $i++) { ?>
                <option value="<?= $multimedia_types[$i][0] ?>">
                    <?= $multimedia_types[$i][0] ?>
                </option>
            <?php } ?>
        </select>

        <?php result_to_clickable_table($result, "space", "details_space.php", true); ?>

</body>

</html>