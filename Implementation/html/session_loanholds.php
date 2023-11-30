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






//post handles
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $additional_url = "";

    if (isset($_POST['increment_loans'])) {

        $successful = True;
                
        $patron_loans = $conn->prepare("SELECT interaction_id
                                        FROM patron_selection_interactions 
                                        INNER JOIN loans USING (interaction_id)
                                        WHERE patron_id = ? 
                                        AND loan_return_date IS NULL;");

        $patron_loans->bind_param("i", $login_id);

        if(!$patron_loans->execute())
        {
            print("SQL WENT WRONG (NOT CLICKBAIT)");
        }

        $res = $patron_loans->get_result();
        $data = $res->fetch_all();

        $increment_stmt = $conn->prepare("CALL increment_loan_renewal(?);");
        $increment_stmt->bind_param("i", $record_id);

        for($i = 0; $i < $res->num_rows; $i++)
        {
            $record_id = $data[$i][0];
            if(isset($_POST['checkbox' . $record_id])) {
                try {
                    $increment_stmt->execute();
                }
                catch(Exception $e) {
                    $successful = False;
                }
            }
        }
        if(!$successful)
        {
            $s = "";
            if($additional_url) {
                $s = $s . "&";
            }
            else {
                $s = $s . "?";
            }

            $s = $s . "increment_error=True";
            $additional_url = $additional_url . $s;
        }
    }

    if (isset($_POST['delete_records'])) {
            
        $patron_holds = $conn->prepare("SELECT interaction_id 
                                            FROM patron_selection_interactions 
                                            LEFT OUTER JOIN holds USING (interaction_id) 
                                            WHERE patron_id = ?;");

        $patron_holds->bind_param("i", $login_id);

        if(!$patron_holds->execute())
        {
            print("SQL WENT WRONG (NOT CLICKBAIT)");
        }

        $res = $patron_holds->get_result();
        $data = $res->fetch_all();

        $del_stmt = $conn->prepare("CALL del_interaction(?);");
        $del_stmt->bind_param("i", $record_id);

        for($i = 0; $i < $res->num_rows; $i++)
        {
            $record_id = $data[$i][0];
            if(isset($_POST['checkbox' . $record_id])) {
                $del_stmt->execute();
            }
        }
    
    }

    header("Location:" .  $_SERVER['PHP_SELF'] . $additional_url,  true, 303);
}
//output stmts

$patron_hold_stmt = $conn->prepare("SELECT interaction_id,
                                material_title, 
                                hold_date_requested
                                FROM selection
                                INNER JOIN patron_selection_interactions
                                USING (material_id)
                                INNER JOIN holds
                                USING (interaction_id)
                                WHERE patron_id = ?;");
$patron_hold_stmt->bind_param("i", $login_id);
if(!$patron_hold_stmt->execute())
{
    echo "SQL did a bad";
    exit();
}
$hold_res = $patron_hold_stmt->get_result();
$patron_loan_stmt = $conn->prepare("SELECT interaction_id,
                                     material_title AS 'Title',
                                     loan_start_date AS 'Checked Out',
                                     loan_renewal_tally AS 'Times Renewed',
                                     DATE_ADD(loan_start_date, INTERVAL (2*(loan_renewal_tally+1)) WEEK) AS 'Due Date'
                                FROM selection
                                     INNER JOIN patron_selection_interactions USING(material_id)
                                     INNER JOIN loans USING (interaction_id)
                               WHERE patron_id = ? AND loan_return_date IS NULL;");
$patron_loan_stmt->bind_param("i", $login_id);
if(!$patron_loan_stmt->execute())
{
    echo "SQL did a bad";
    exit();
}
$loan_res = $patron_loan_stmt->get_result();

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

<a href="index_general.php">Back to Main Patron Page</a>

    <?php
    if(isset($_GET['increment_error']))
    {
        echo "<p>ERROR: You can have, at max, four print renewals and two multimedia renewals.</p>";
    }?>

    <h2>Checked Out Material(s):</h2>
    <?php result_to_deletable_table_general($loan_res, [-1], "Renew Material", "Renew Selected Materials", "increment_loans");?>
    <h2>Current Hold(s):</h2>
    <?= result_to_deletable_table_general($hold_res, [-1], "Cancel Hold", "Cancel Selected Holds");?>
</body>

</html>
