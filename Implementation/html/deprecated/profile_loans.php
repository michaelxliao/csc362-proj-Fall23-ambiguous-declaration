<?php
require 'includes/setup.php';
require 'includes/functions.php';

$conn = setup();
$loan_info = $conn->query("SELECT * FROM pretty_selection_librarian");
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
    <a href="index_staff.php">Back to Staff</a>
    <h1>Select a loan to Examine:</h1>
    <form method="GET">
        <?php
        result_to_clickable_table($loan_info, "club", "details_loans.php", False);
            ?>
    </form>
</body>

</html>