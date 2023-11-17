<?php
require 'includes/setup.php';
$conn = setup();

$patron_id = $_GET['narrativeid'];
$sql_query = 'SELECT material_title AS "Title"
                FROM active_narratives
                     INNER JOIN adaptations USING(narrative_id)
                     LEFT OUTER JOIN selection USING(material_id)
               WHERE narrative_id = ?'

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
        <!-- this is where h1s etc. go, any explanatory info -->
    </header>
</body>

</html>