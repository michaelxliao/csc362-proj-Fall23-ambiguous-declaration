<?php
require 'includes/setup.php';
require 'includes/format_result.php';
$conn = setup();

if (!isset($_GET['materialid']))
{
    header('Location:manage_selection.php', true, 303);
}

$curr_material = $_GET['materialid']; // might be invalid still

// if 0 rows, then curr_material is invalid.
$get_material_info_query = "SELECT material_id,
                                   material_title
                              FROM selection
                             WHERE material_id = ?";

$get_material_info_stmt = $conn->prepare($get_material_info_query);
$get_material_info_stmt->bind_param('i', $curr_material);
if(!$get_material_info_stmt->execute())
{
    print("SQL error. Sorry!");
}

function find_result($material_id, $query) {
    $stmt = $GLOBALS['conn']->prepare($query);
    $stmt->bind_param('i', $material_id);
    if ( !$stmt->execute() ) {
        echo 'SQL error. Sorry!';
    }
    $res = $stmt->get_result();
    return $res;
}

$get_material_info_result = $get_material_info_stmt->get_result();
$material_title = $get_material_info_result->fetch_assoc()['material_title'];

$get_creators_query = "SELECT creator_id,
                              material_id,
                              creator_role,
                              CONCAT(creator_role, ': ', creator_first_name, ' ', creator_last_name) AS 'Creator'
                         FROM selection_creators
                              LEFT OUTER JOIN creators USING (creator_id)
                        WHERE material_id = ?";

$creators_res = find_result($curr_material, $get_creators_query);

$genres_query = "SELECT genre_name AS 'Genre'
                   FROM selection_genres
                  WHERE material_id = ?";

$genres_res = find_result($curr_material, $genres_query);

$languages_query = "SELECT language_name AS 'Language'
                      FROM selection_languages
                     WHERE material_id = ?";

$languages_res = find_result($curr_material, $languages_query);

$adaptations_query = "SELECT material_title AS 'Adaptation Title',
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
                                               WHERE material_id = ?)";

$adaptations_res = find_result($curr_material, $adaptations_query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST[''])) {
        // ...
        echo "";
    }
    
	header("Location:" .  $_SERVER['REQUEST_URI'],  true, 303);
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
        <h1><?= $material_title ?></h1>
        <p> Currently checked out/Available for checkout! </p> <!-- DO THIS -->
        <?php
            $is_source_stmt = $conn->prepare('SELECT material_is_source FROM adaptations WHERE material_id = ?');
            $is_source_stmt->bind_param('i', $curr_material);
            if (!$is_source_stmt->execute()) {
                echo $is_source_stmt->error;
            }
            $is_source = $is_so
            if () { ?>
            <p> This material is the source for the narrative </p> <!-- DO THIS ALSO -->
        <?php } ?>
    </header>

    <h2>Holds on this Material</h2>

    <h2>Creator(s)</h2>
    <form method=POST>
        <label for="new_creator_fname">New Creator First Name: </label>
        <input name="new_creator_fname" required>
        <label for="new_creator_lname">New Creator Last Name: </label>
        <input name="new_creator_lname" required>
        <label for="new_role">New Creator Role: </label>
        <select name="new_role" id="new_role" required>
            <?php
                $roles_res = $conn->query('SELECT * FROM creator_roles');
                $roles_data = $roles_res->fetch_all();

                for ($i = 0; $i < $roles_res->num_rows; $i++) { ?>
                <option value="<?= $roles_data[$i][0] ?>"><?= $roles_data[$i][0] ?></option>
            <?php } ?>
        </select>
        <input type="submit" name="add_creator" value="Add Creator">
    </form>
    <form method=POST>
        <?php $creators_data = $creators_res->fetch_all(); ?>
            <table>
                <thead>
                    <tr>
                        <th> <?= $creators_res->fetch_fields()[3]->name ?> </th>
                        <th> Delete? </th>
                    </tr>
                </thead>

                <tbody>
                    <?php for ($i=0; $i < $creators_res->num_rows; $i++) {
                        $id_1 = $creators_data[$i][0];
                        $id_2 = $creators_data[$i][1];
                        $id_3 = $creators_data[$i][2];
                    ?>
                        <tr>
                            <td><?= $creators_data[$i][3] ?></td>
                            <td>
                                <input type="checkbox"
                                    name="checkbox<?= $id_1 . ',' . $id_2 . ',' . $id_3 ?>"
                                    value="<?= $id_1 . ',' . $id_2 . ',' . $id_3 ?>"
                                />
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
        </table>
        <input type="submit" name="delete_creators" value="Delete Selected Records"/>
    </form>

    <h2>Genre(s)</h2>
    <form method=POST>
        <label for="genre_name">New Genre: </label>
        <select name="genre_name" id="genre_name" required>
            <?php
                $all_genres_res = $conn->query('SELECT * FROM genres');
                $all_genres_data = $all_genres_res->fetch_all();

                for ($i = 0; $i < $all_genres_res->num_rows; $i++) { ?>
                <option value="<?= $all_genres_data[$i][0] ?>"><?= $all_genres_data[$i][0] ?></option>
            <?php } ?>
        </select>
        <input type="submit" name="add_genre" value="Add Genre">
    </form>
    <?= result_to_deletable_table_general($genres_res, [-1], 'Delete?', 'Delete Genre', 'delete_genre') ?>

    <h2>Language(s)</h2>
    <form method=POST>
        <label for="genre_name">New Language: </label>
        <select name="language_name" id="language_name" required>
            <?php
                $all_languages_res = $conn->query('SELECT * FROM languages');
                $all_languages_data = $all_languages_res->fetch_all();

                for ($i = 0; $i < $all_languages_res->num_rows; $i++) { ?>
                <option value="<?= $all_languages_data[$i][0] ?>"><?= $all_languages_data[$i][0] ?></option>
            <?php } ?>
        </select>
        <input type="submit" name="add_language" value="Add Language">
    </form>
    <?= result_to_deletable_table_general($languages_res, [-1], 'Delete?', 'Delete Language', 'delete_language') ?>

    <h2>Adaptation(s)</h2> <!-- no data management here; that happens elsewhere -->
    <?= result_to_table($adaptations_res) ?>

</body>

</html>