<?php
require '../includes/setup.php';
require '../includes/format_result.php';

$conn = setup()
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/styles.css">
</head>
    <body>
        <form>
            <?php
            result_to_table($conn->query('SELECT  FROM "))
            ?>
        </form>
    </body>
</html>
