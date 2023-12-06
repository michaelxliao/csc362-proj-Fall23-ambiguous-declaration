<?php
require 'includes/setup.php';
require 'includes/functions.php';
$conn = setup();

$narrative_name = $_GET['narrativeid'];
$real_narrative_id_res = $conn->query("SELECT narrative_id
                                    FROM active_narratives
                                    WHERE narrative_name = '$narrative_name'");
$real_narrative_id = $real_narrative_id_res->fetch_all()[0][0];

$narrative_desc = $conn->query("SELECT narrative_description
                                FROM active_narratives
                                WHERE narrative_name = '$narrative_name'");
$narrative_desc_res = $narrative_desc->fetch_all()[0][0];
$sql_query = $conn->query("SELECT material_id AS 'Material ID', material_title AS 'Title'
                FROM active_narratives
                     INNER JOIN adaptations USING(narrative_id)
                     LEFT OUTER JOIN selection USING(material_id)
               WHERE narrative_name = '$narrative_name'");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST["new_adaptation"])){
        // printf($_POST["new_material_id"]);
        if (isset($_POST["is_source"])) {
            $is_source = 1;
        } else {
            $is_source = 0;
        }
        $checkexists = $conn->prepare("SELECT * FROM adaptations WHERE narrative_id = ? AND material_id = ?");
        $checkexists->bind_param('ii',$real_narrative_id, $_POST["new_material_id"]);
        $checkexists->execute();

        $result = $checkexists->get_result();

        // this is technically an int but 0 means it does not have that club & 1 means it does
        $has_value = $result->num_rows;

        if (!$has_value) {
            $update_stmt = $conn->prepare("INSERT INTO adaptations(narrative_id, material_id, material_is_source)
            VALUES (?, ?, ?)");
            $update_stmt->bind_param('iii', $real_narrative_id, $_POST["new_material_id"], $is_source);
            try {
                $update_stmt->execute();
            } catch (mysqli_sql_exception $e) {
                $e->getMessage();
            }
        }
    }
    if(isset($_POST["delete_records"])){
        print("Got this far");
        $deletable_narrative_ids = $conn->query("SELECT material_id
        FROM active_narratives
                INNER JOIN adaptations USING(narrative_id)
                LEFT OUTER JOIN selection USING(material_id)
        WHERE narrative_name = '$narrative_name'");
        $ids_res = $deletable_narrative_ids->fetch_all();
        for($_i=0;$_i<$deletable_narrative_ids->num_rows;$_i++){
            $id=$ids_res[$_i][0];
            $_delete_statement=$conn->prepare("DELETE FROM adaptations WHERE narrative_id=? AND material_id = ?");
            $_delete_statement->bind_param('ii',$real_narrative_id,$id);
            if(isset($_POST["checkbox$id"])){
                $_delete_statement->execute();
                print_r("Deleted $id");
            }
        }
    }

    if(isset($_POST["edit_old_description"])){
        $update_stmt = $conn->prepare("UPDATE narratives
                                        SET narratives.narrative_description = ?
                                        WHERE narratives.narrative_id = ?");
        $update_stmt->bind_param('si',$_POST["new_desc"] ,$real_narrative_id);
        $update_stmt->execute();
    }
    if(isset($_POST["del_narrative"])){
        $del_stmt = $conn->prepare("CALL del_narrative(?)");
        $del_stmt -> bind_param('i', $real_narrative_id);
        $del_stmt -> execute();
        header("Location: profile_narratives.php", true, 303);
        exit();

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
    <a href="profile_narratives.php">Back to Narrative List</a>
    <h1><?= $narrative_name ?></h1>
    <p>A bit more information about this material:<br>
    <?=$narrative_desc_res?></p>


    <h2> Update description: </h2>
    <form method=POST>
        <label for="new_desc">Narrative Description:</td>
            <textarea type="textarea"  name="new_desc"><?=$narrative_desc_res?></textarea>
        <input type="submit" name="edit_old_description" value="Edit Narrative" />
    </form>
    <h2> Material Adapted from This Narrative: </h2>

    <form method=POST>
        <label for="new_material_id">Enter in barcode or ID for a new material:</label>
        <input type="text" name="new_material_id" />
        <label for="is_source">Source of the adaptation?</label>
        <input type="checkbox" name="is_source" value="1" />

        <input type="submit" name="new_adaptation" value = "Add Material"/>
    </form>
    <?php result_to_deletable_table($sql_query, true) ?>
</body>

</html>