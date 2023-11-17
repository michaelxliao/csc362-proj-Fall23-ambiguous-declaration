<?php
require 'includes/setup.php';
require 'includes/format_result.php';
$conn = setup();
$patron_id = $_GET['patronid'];
$patron_loans = $conn->query("SELECT material_title, loan_start_date, loan_return_date
                                FROM selection
                                INNER JOIN patron_selection_interactions
                                USING(material_id)
                                INNER JOIN loans
                                USING (interaction_id)
                                WHERE patron_id = $patron_id")
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
    <form>
    <h1>Checked Out Material(s):</h1>
    <?php result_to_table($patron_loans);?>
    </form>
</body>

</html>