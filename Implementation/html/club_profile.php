<?php
require '../includes/setup.php';
require '../includes/format_result.php';

$conn = setup()
    ?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gentium+Book+Plus&family=Montserrat:wght@500&display=swap"
        rel="stylesheet">
</head>

<body>
    <form>
        <?php
        result_to_table($conn->query('SELECT * FROM clubs'))
            ?>
    </form>
</body>

</html>