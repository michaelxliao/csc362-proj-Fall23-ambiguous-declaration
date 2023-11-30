<?php
require 'includes/setup.php';
require 'includes/functions.php';
$conn = setup();

$sql_query = 'SELECT * FROM pretty_narratives_librarian'
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
        <h1>Narratives</h1>
        <p> Curious what other versions or adaptations of your favorite media might exist? Look no further. </p>
    </header>
    <a href="index_staff.php">Back to Staff</a>
    <?php result_to_clickable_table($conn->query($sql_query), "narrative", "details_narrative.php", true, 0); ?>

</body>

</html>