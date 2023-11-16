<?php
require 'includes/setup.php';
require 'includes/format_result.php';

$conn = setup();
$club_info = $conn->query("SELECT DISTINCT club_id, club_name, club_is_active FROM clubs ORDER BY club_name")
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
    <a href="staff_index.php">Back to Staff</a>
    <p>Select a club to examine:</p>
    <form method="GET">
        <?php
        result_to_clickable_table($club_info, "club", "details_club.php", False);
            ?>
    </form>
</body>

</html>