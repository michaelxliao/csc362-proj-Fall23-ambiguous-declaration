<?php
require 'includes/setup.php';
$conn = setup();

if (!isset($_GET['materialid']))
{
    header('Location:manage_selection.php', true, 303);
}

$curr_material = $_GET['materialid']; // might be invalid still

// if 0 rows, then curr_material is invalid.
$get_material_info_query = "SELECT material_id,
                                   material_title
                              FROM selection
                             WHERE material_id = ?";

$get_material_info_stmt = $conn->prepare($get_material_info_query);
$get_material_info_stmt->bind_param('i', $curr_material);
if(!$get_material_info_stmt->execute())
{
    print("SQL error. Sorry!");
}

$get_material_info_result = $get_material_info_stmt->get_result();
$material_title = $get_material_info_result->fetch_assoc()['material_title'];

$get_creators_query = "SELECT *
                         FROM creators
                        WHERE material_id = ?";

$get_material_info_stmt = $conn->prepare($get_creators_query); // WIP
$get_material_info_stmt->bind_param('i', $curr_material);
if(!$get_material_info_stmt->execute())
{
    print("SQL error. Sorry!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST[''])) {
        // ...
        echo "";
    }
    
	header("Location:" .  $_SERVER['REQUEST_URI'],  true, 303);
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
    <header>
        <h1><?= $material_title ?></h1>
    </header>

    <?php // need creators, genres, languages, ++ ADAPTATIONS, as well as loan status/holds ?>

    <h2>Creator(s)</h2>
    <form method=POST>

    </form>
    <?= result_to_deletable_table($creators_res, false) ?>
</body>

</html>