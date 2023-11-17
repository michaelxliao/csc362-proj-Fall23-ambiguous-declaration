<?php
require 'includes/setup.php';
require 'includes/format_result.php';

$conn = setup();
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
    <h1>Select a Patron to Examine</h1>
    
    <?php result_to_clickable_table($conn->query('SELECT * FROM pretty_patron_details_librarian'), "patron", "details_patron.php", true) ?>

</body>