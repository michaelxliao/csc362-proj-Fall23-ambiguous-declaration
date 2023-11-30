<?php
require 'includes/setup.php';
require 'includes/functions.php';
$conn = setup();
session_start();

// check if they're logged in, if not crash
    if(!isset($_SESSION['patron_id']))
    {
        header("Location:login_general.php?error=true", true, 303);
    }

    $login_id = $_SESSION['patron_id'];

    $patron_info = $conn->prepare("SELECT patron_id, 
                                    patron_first_name,
                                    patron_last_name,
                                    patron_phone,
                                    patron_email
                                    FROM patrons 
                                    WHERE patron_id = ?");

    $patron_info->bind_param("i", $login_id);
    if(!$patron_info->execute())
    {
        print("SQL error!");
    }
    $res = $patron_info->get_result();
    $patron_data = $res->fetch_assoc();

    if(isset($patron_data['patron_email']))
    {
        $patron_email = $patron_data['patron_email'];
    }
    else
    {
        $patron_email = "Not Set";
    }


    if(isset($patron_data['patron_phone']))
    {
        $patron_phone = $patron_data['patron_phone'];
    }
    else
    {
        $patron_phone = "Not Set";
    }

    $patron_first_name = $patron_data['patron_first_name'];



//work with the current material: if it doesn't exist then go abck out

    if(!isset($_GET['materialid']))
    {
        header("Location:session_sel_narrative.php", true, 303);
    }

    //NEXT find if valid material id

    $curr_material = $_GET['materialid']; 

    $material_stmt = $conn->prepare("SELECT material_id, material_title 
                                    FROM selection
                                    WHERE material_id = ?");
    $material_stmt->bind_param("i", $curr_material);
    if(!$material_stmt->execute())
    {
        echo "SQL error lol";
        exit();
    }
    $material_stmt_res = $material_stmt->get_result();
    $material_data = $material_stmt_res->fetch_all();

    // material not in DB.
    if($material_stmt_res->num_rows == 0)
    {
        header("Location:session_sel_narrative.php", true, 303);
    }

    $material_title = $material_data[0][1];


    $adaptations_query = "SELECT material_id AS 'Material ID',
                            material_title AS 'Adaptation Title',
                             (CASE WHEN (multimedia_type IS NULL)
                             THEN print_type
                             ELSE multimedia_type
                             END) AS 'Type'
                        FROM adaptations
                             NATURAL JOIN narratives
                             LEFT OUTER JOIN selection USING (material_id)
                             LEFT OUTER JOIN multimedia USING (material_id)
                             LEFT OUTER JOIN print_materials USING (material_id)
                       WHERE narrative_id IN (SELECT narrative_id
                                                FROM adaptations
                                               WHERE material_id = ?)
                        ORDER BY material_title";

$adaptations_res = find_result($curr_material, $adaptations_query);

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
    <a class="link-button" href=login_general.php> Back to Sign-In</a>

    <h1> Welcome, <?=$patron_first_name?>, to the Therpston County Public Library.</h1>
</header>
    <a href="session_sel_narrative.php">Search for Adaptations of a Different Material</a>

    <h2>Adaptations of "<?=$material_title?>" </h2>

    <?=result_to_clickable_table($adaptations_res, "material", "session_material_details.php", True)?>

</body>

</html>