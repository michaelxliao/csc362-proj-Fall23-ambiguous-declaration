<?php
require 'includes/setup.php';
require 'includes/functions.php';
$conn = setup();

$sql_query = 'SELECT narrative_name, narrative_description FROM narratives';

if(isset($_POST["add_narrative"])){
    print($_POST["new_narrative_name"]);
    print($_POST["new_narrative_decs"]);
    $add_stmt = $conn->prepare('INSERT INTO narratives(narrative_name, narrative_description) VALUES (?,?)');
    $add_stmt -> bind_param('ss', $_POST["new_narrative_name"], $_POST["new_narrative_decs"]);
    $add_stmt -> execute();

    // header("Location: {$_SERVER['REQUEST_URI']}", true, 303);
    // exit();
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
<a class="link-button" href=index.php> Back to Sign-In</a>

<h1>Therpston County Public Library</h1>
</header>
<a href="index_staff.php">Back to Staff</a>
    <h1>Narratives</h1>
        <p> Curious what other versions or adaptations of your favorite media might exist? Look no further. </p>

    <h3>Add Narrative</h3>
    <form method=POST>
        <label for="new_narrative_name">Narrative Name:</label>
        <input type="text" name="new_narrative_name" /><br>
        <label for="new_narrative_decs">Narrative Description:</label>
        <textarea name="new_narrative_decs" placeholder="Enter a description"></textarea><br>
        <input type="submit" name="add_narrative" value="Add Narrative" />
    </form>
    <?php result_to_clickable_table($conn->query($sql_query), "narrative", "details_narrative.php", true, 0); ?>

</body>

</html>