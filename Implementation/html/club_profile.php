<?php
require 'includes/setup.php';
require 'includes/format_result.php';

$conn = setup();
$club_info =$conn ->query( "SELECT club_name, patron_first_name, patron_last_name, member_info, member_is_leader 
FROM clubs 
INNER JOIN club_members 
USING(club_id) 
INNER JOIN patrons 
USING(patron_id) ");
$filter_stmt = '';
if (isset($_POST['search_clubs'])){
    if (isset($_POST['club_to_find'])){
        echo $_POST['club_to_find'];
        $filter_stmt = $conn->prepare("SELECT club_name, patron_first_name, patron_last_name, member_info, member_is_leader 
        FROM clubs 
        INNER JOIN club_members 
        USING(club_id) 
        INNER JOIN patrons 
        USING(patron_id) WHERE club_name = ?;");
        $filter_stmt -> bind_param('s', $_POST["club_to_find"] );
        $filter_stmt -> execute();
        $club_info = $filter_stmt->get_result();
        header("Location:" . $_SERVER['REQUEST_URI'], true, 303);
        exit();
    }
}/*
if (isset($_POST['end_filter'])){
    $club_info =$conn ->query( "SELECT club_name, patron_first_name, patron_last_name, member_info, member_is_leader 
    FROM clubs 
    INNER JOIN club_members 
    USING(club_id) 
    INNER JOIN patrons 
    USING(patron_id) ");
    header("Location:" . $_SERVER['REQUEST_URI'], true, 303);
    exit();
}*/
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
    <form method="POST">
        <?php
        result_to_table($club_info)
        ?>
        <p>Input the name of a club you'd like to search:</p>
        <input type="text" name="club_to_find">
        <input type="submit" name="search_clubs">
        <input type="submit" name="end_filter" value="Reset Filter">
    </form>
</body>

</html>