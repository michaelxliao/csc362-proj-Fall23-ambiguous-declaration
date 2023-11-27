<?php
require 'includes/setup.php';
$conn = setup();

$FORM_NAME = 'placeholder'; // change this!

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST[$FORM_NAME])) {
        // ...
    }
    
	header(‘Location: { $_SERVER[‘REQUEST_URI’] }’, true, 303);
    exit();
}

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
    <form method="POST"> <!-- GENERIC!! action defaults to original page -->
        <!-- labels, inputs -->
        <input type="submit" name="<?= $FORM_NAME ?>">
    </form>
</body>

</html>