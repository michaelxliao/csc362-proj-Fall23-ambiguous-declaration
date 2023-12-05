<?php
require 'includes/setup.php';
require 'includes/functions.php';
$conn = setup();

$ALL_SPACES = "All Spaces";

$space_names_res = $conn->query("SELECT * FROM pretty_spaces_librarian");
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
<a class="link-button" href=index.php> Back to Sign-In</a>

<h1>Therpston County Public Library</h1>
</header>
<a href="index_staff.php">Back to Staff</a>


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

        <?php result_to_clickable_table($space_names_res, "space", "details_space.php", true); ?>

</body>

</html>