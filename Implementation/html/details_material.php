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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST[$FORM_NAME])) {
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

    </header>
</body>

</html>