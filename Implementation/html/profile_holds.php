<?php
require 'includes/setup.php';
require 'includes/functions.php';
$conn = setup();


$processing_holds_res = $conn->query("SELECT material_id AS 'Material ID',
                                    patron_id AS 'Patron ID',
                                    patron_email AS 'Patron Email',
                                    patron_phone AS 'Patron Phone Number',
                                    CONCAT(patron_first_name, ' ', patron_last_name) AS 'Patron Name',
                                    material_title AS 'Title'
                                    FROM processing_holds;");


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
    <a class="link-button" href=index.php> Back to Sign-In</a>

    <h1>Therpston County Public Library</h1>

    </header>

    <h2>Holds to be Checked Out</h2>

    <p>Holds are automatically deleted as a patron checks them out.</p>
    <?=result_to_table($processing_holds_res)?>

</body>

</html>