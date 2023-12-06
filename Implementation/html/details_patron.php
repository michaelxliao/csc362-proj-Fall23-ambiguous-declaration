<?php
require 'includes/setup.php';
require 'includes/functions.php';
$conn = setup();
// check patron exists
    if(!isset($_GET['patronid']))
    {
        header("Location:profile_patrons.php?error=true", true, 303);
    }

    $patron_id = $_GET['patronid'];

    $patron_info = $conn->prepare("SELECT 
                                    patron_first_name,
                                    patron_last_name,
                                    patron_email,
                                    patron_phone,
                                    patron_id
                                    FROM patrons 
                                    WHERE patron_id = ?");

    $patron_info->bind_param("i", $patron_id);
    if(!$patron_info->execute())
    {
        print("SQL error!");
    }
    $res = $patron_info->get_result();
    if($res->num_rows == 0)
    {
        header("Location:profile_patrons.php", true, 303);
        exit();
    }

$patron_info_res = $res->fetch_all();
$patron_spaces_reserved_stmt = $conn->prepare("SELECT space_name AS 'Space Name', space_room_number AS 'Space Room Number', start_reservation AS 'Start of Reservation', end_reservation AS 'Start of Reservation'
                                        FROM patrons
                                        INNER JOIN space_reservations
                                        USING (patron_id)
                                        INNER JOIN spaces
                                        USING (space_id)
                                        WHERE patron_id = ?");
$patron_spaces_reserved_stmt->bind_param('i', $patron_id);
if(!$patron_spaces_reserved_stmt->execute()) {
    print('patron spaces fail');
}

$patron_spaces_reserved_res = $patron_spaces_reserved_stmt->get_result();
$patron_spaces_reserved_stmt->close();


$patron_clubs_stmt = $conn->prepare("SELECT club_name AS 'Club Name',
                                     (CASE WHEN member_is_leader
                                      THEN 'Part of Leadership'
                                      ELSE 'Not Leadership'
                                      END) AS 'Leadership Status'
                                FROM patrons
                                INNER JOIN club_members
                                USING (patron_id)
                                INNER JOIN clubs
                                USING (club_id)
                                WHERE patron_id = ?");
$patron_clubs_stmt->bind_param('i', $patron_id);
if(!$patron_clubs_stmt->execute()) {
    print('patron clubs fail');
}
$patron_clubs_res = $patron_clubs_stmt->get_result();
$patron_clubs_stmt->close();

$patron_holds_stmt = $conn->prepare("SELECT material_title AS 'Title', hold_date_requested AS 'Date Requested'
                                FROM selection
                                INNER JOIN patron_selection_interactions
                                USING (material_id)
                                INNER JOIN holds
                                USING (interaction_id)
                                WHERE patron_id = ?");
$patron_holds_stmt->bind_param('i', $patron_id);
if(!$patron_holds_stmt->execute()) {
    print('patron holds fail');
}

$patron_holds_res = $patron_holds_stmt->get_result();
$patron_holds_stmt->close();


$patron_loans_stmt = $conn->prepare("SELECT interaction_id,
                                            material_title AS 'Title',
                                            loan_start_date AS 'Checked Out',
                                            --  loan_return_date AS 'Returned?',
                                            DATE_ADD(loan_start_date, INTERVAL (2*(loan_renewal_tally+1)) WEEK) AS 'Due Date'
                                        FROM selection
                                            INNER JOIN patron_selection_interactions USING(material_id)
                                            INNER JOIN loans USING (interaction_id)
                                    WHERE patron_id = ? AND loan_return_date IS NULL;");
$patron_loans_stmt->bind_param('i', $patron_id);
if(!$patron_loans_stmt->execute()) {
    print('patron loans fail');
}
$patron_loans_res = $patron_loans_stmt->get_result();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['del_patron'])){
        $delete_stmt = $conn->prepare("DELETE FROM patrons WHERE patron_id=?");
        $delete_stmt->bind_param("i", $patron_id);
        if(!($delete_stmt->execute()))
        {
            print("SQL oopsie doopsie! x3 we made a... mistake");
            exit();
        }
        header("Location:profile_patrons.php", true, 303);
        exit();
    }
    if(isset($_POST["change_email"])){
        $_update_statement=$conn->prepare("CALL update_patron(?,?,?,?,?)");
        $_update_statement->bind_param('issss', $patron_id, $patron_info_res[0][0], $patron_info_res[0][1], $_POST["new_email"], $patron_info_res[0][3]);
        $_update_statement->execute();
    }
    if(isset($_POST["change_phone"])){
        $_update_statement=$conn->prepare("CALL update_patron(?,?,?,?,?)");
        $_update_statement->bind_param('issss', $patron_id, $patron_info_res[0][0], $patron_info_res[0][1], $patron_info_res[0][2], $_POST["new_phone"]);
        $_update_statement->execute();
    }
    if(isset($_POST["new_loan"])){
        //make sure is MATERIAL
        $check_material_stmt = $conn->prepare("SELECT material_id
                                        FROM selection
                                        WHERE material_id = ?");
    
        $check_material_stmt->bind_param("i", $_POST['material_id']);
        if(!$check_material_stmt->execute())
        {
            print("SQL error!");
        }
        $res = $check_material_stmt->get_result();
        if($res->num_rows == 0)
        {
            header("Location:details_patron.php", true, 303);
            exit(); // get outta here not real material ID lol
        }
        
        //execute stmt
        $insert_stmt = $conn->prepare("CALL add_loan(?, ?, CURDATE(), NULL, 0)");
        $insert_stmt->bind_param("ii", $_POST['material_id'], $patron_id);
        try {
            $insert_stmt->execute();
        } catch (mysqli_sql_exception $e) {
            $e->getMessage();
        }
    }

    if (isset($_POST["del_loans"])){
        
        $get_relevant_records_stmt = $conn->prepare("SELECT interaction_id
                                                       FROM current_loans
                                                       WHERE patron_id = ?");
        $get_relevant_records_stmt->bind_param("i", $patron_id);
        $get_relevant_records_stmt->execute();
        $res = $get_relevant_records_stmt->get_result();
        $data = $res->fetch_all();

        $del_stmt = $conn->prepare("CALL return_loan(?)");
        $del_stmt->bind_param("i", $interaction_id);

        for ($i = 0; $i < $res->num_rows; $i++) {
            $interaction_id = $data[$i][0];
            if (isset($_POST['checkbox' . $interaction_id])) {
                try {
                    $del_stmt->execute();
                    echo 'HELP';
                } catch (mysqli_sql_exception $e) {
                    $e->getMessage();
                }
            }
        }
    }
    
    if(isset($_POST["change_first_name"])&&($_POST["change_first_name"]!=NULL)){
        $_update_statement=$conn->prepare("CALL update_patron(?,?,?,?,?)");
        $_update_statement->bind_param('issss',$patron_id,$_POST["new_first_name"], $patron_info_res[0][1], $patron_info_res[0][2], $patron_info_res[0][3]);
        $_update_statement->execute();
    }
    if(isset($_POST["change_last_name"])){
        $_update_statement=$conn->prepare("CALL update_patron(?,?,?,?,?)");
        $_update_statement->bind_param('issss',$patron_id,$patron_info_res[0][0],$_POST["new_last_name"], $patron_info_res[0][2], $patron_info_res[0][3]);
        $_update_statement->execute();
    }
    header("Location: {$_SERVER['REQUEST_URI']}", true, 303);
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
    <a class="link-button" href=index.php> Back to Sign-In</a>

    <h1>Therpston County Public Library</h1>
    </header>
    <a href="profile_patrons.php">Back to All Patrons</a>
    <h1>Details for <?= $patron_info_res[0][0] . " " . $patron_info_res[0][1]; ?></h1>

    <form method=POST>
        <label for = "change_first_name" >Current First Name:</label>
        <input type="text" name="new_first_name" value ="<?= $patron_info_res[0][0]?>">
        <input type="submit" name="change_first_name" value="Update Patron First Name">
        <br>
        <label for ="change_last_name">Current Last Name:<label>
        <input type="text" name="new_last_name" value ="<?= $patron_info_res[0][1]?>">
        <input type="submit" name="change_last_name" value="Update Patron Last Name">
        <br>
        <label for ="new_email" >Current Email:</label>
        <input type="text" name="new_email" value ="<?= $patron_info_res[0][2]?>">
        <input type="submit" name="change_email" value="Update Email">
        <br>
        <label for = "change_phone">Current Phone Number:</label>
        <input type="text" name="new_phone" max="14" pattern="^\d{3}-\d{3}-\d{4}$" placeholder="XXX-XXX-XXXX" value ="<?= $patron_info_res[0][3]?>">
        <input type="submit" name="change_phone" value="Update Phone Number">
    </form>
    <h2>Checked Out Material(s):</h2>
    <h4>Check Out a New Material</h4>
    <form method=POST>
        <label for="material_id">Material ID: </label>
        <input type="number" min="1" name="material_id" required />
        <input type="submit" value="Loan Material Out" name="new_loan" />
    </form>

    <?php result_to_deletable_table_general($patron_loans_res,[0],"Return?","Return Materials","del_loans");?>
    <h2>Current Hold(s):</h2>
    The patron can cancel holds using their library account.
    <?= result_to_table($patron_holds_res);?>
    <h2>Future Reservation(s):</h2>
    The patron can cancel reservations using their library account.
    <?= result_to_table($patron_spaces_reserved_res)?>
    <h2>Club(s):</h2>
    The patron can leave clubs using their library account.
    <form method=POST>
        <?=result_to_table($patron_clubs_res)?>
    </form>

    <form method=POST>
        <input type="submit" name="del_patron" value="Delete Patron"/>
    </form>
</body>

</html>