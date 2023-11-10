<?php
require '../includes/setup.php';
require '../includes/format_result.php';

$conn = setup();
?>
<!DOCTYPE html>
<html>

<head>

</head>

<body>
    <h1>Catalog</h1>
    <form> <!-- will hold filtering form later -->
    </form>
    <?php result_to_table($conn->query('SELECT * FROM active_selection')); ?>
</body>

</html>