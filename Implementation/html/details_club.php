<?php
require 'includes/setup.php';
require 'includes/format_result.php';
$conn = setup();
$club_id = $_GET['clubid'];
$new_club_info = $conn->query("SELECT patron_first_name, patron_last_name, member_info, member_is_leader 
                            FROM patrons
                            INNER JOIN club_members USING(patron_id)
                            INNER JOIN clubs USING(club_id)
                            WHERE club_id = $club_id;");

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
    <a href="profile_clubs.php">Back to Club Profiles</a>
    <form>
    <?php
    result_to_table($new_club_info); 
    ?>

    </form>
</body>

</html>