<?php
require 'includes/setup.php';
require 'includes/functions.php';
$conn = setup();

if (!isset($_GET['materialid'])) {
    header('Location:manage_selection.php', true, 303);
}

$curr_material = $_GET['materialid']; // might be invalid still

// if 0 rows, then curr_material is invalid.
$get_material_info_query = "SELECT *
                              FROM pretty_selection_librarian
                             WHERE `ID` = ?";

$get_material_info_stmt = $conn->prepare($get_material_info_query);
$get_material_info_stmt->bind_param('i', $curr_material);
if (!$get_material_info_stmt->execute()) {
    print("SQL error. Sorry!");
}

$get_material_info_result = $get_material_info_stmt->get_result();
$material_info = $get_material_info_result->fetch_assoc();
$material_title = $material_info['Title'];
$date_selected = $material_info['Date Selected into Library'];
$date_created = $material_info['Date Created'];
$pending = $material_info['Pending?'];
$cost = $material_info['Cost'];
$type = $material_info['Type'];
$length = $material_info['Length'];

if ($conn->query('SELECT 1 FROM multimedia_types WHERE multimedia_type = "' . $type . '"')->num_rows > 0) { // can be unsafe here because inputs guaranteed coming out of database
    $is_print = false;
} else {
    $is_print = true;
}

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
    if (isset($_POST['delete_creators'])) {
        $get_relevant_records_stmt = $conn->prepare("SELECT creator_id, material_id, creator_role
                                                       FROM selection_creators
                                                      WHERE material_id = ?");
        $get_relevant_records_stmt->bind_param("i", $curr_material);
        $get_relevant_records_stmt->execute();
        $res = $get_relevant_records_stmt->get_result();
        $data = $res->fetch_all();

        $del_stmt = $conn->prepare("DELETE FROM selection_creators WHERE creator_id = ? AND material_id = ? AND creator_role = ?");
        $del_stmt->bind_param("iis", $creator_id, $material_id, $creator_role);

        for ($i = 0; $i < $res->num_rows; $i++) {
            $creator_id = $data[$i][0];
            $material_id = $data[$i][1];
            $creator_role = $data[$i][2];
            if (isset($_POST['checkbox' . $creator_id . ',' . $material_id . ',' . $creator_role])) {
                $del_stmt->execute();
            }
        }
    } elseif (isset($_POST['add_creator'])) {
        $add_stmt = $conn->prepare('INSERT INTO selection_creators (creator_id, material_id, creator_role)
                                    VALUES (?, ?, ?)');
        $add_stmt->bind_param('iis', $_POST['creator_id'], $curr_material, $_POST['new_role']);
        if (!$add_stmt->execute()) {
            echo $add_stmt->error;
        }
    } elseif (isset($_POST['delete_genres'])) {
        $get_relevant_records_stmt = $conn->prepare("SELECT genre_name
                                                       FROM selection_genres
                                                      WHERE material_id = ?");
        $get_relevant_records_stmt->bind_param("i", $curr_material);
        $get_relevant_records_stmt->execute();
        $res = $get_relevant_records_stmt->get_result();
        $data = $res->fetch_all();

        $del_stmt = $conn->prepare("DELETE FROM selection_genres WHERE material_id = ? AND genre_name = ?");
        $del_stmt->bind_param("is", $curr_material, $genre_name);

        for ($i = 0; $i < $res->num_rows; $i++) {
            $genre_name = $data[$i][0];
            if (isset($_POST['checkbox' . $genre_name])) {
                try {
                    $del_stmt->execute();
                } catch (mysqli_sql_exception $e) {
                    echo $e->getMessage();
                }
            }
        }
    } elseif (isset($_POST['add_genre'])) {
        $add_stmt = $conn->prepare('INSERT INTO selection_genres (material_id, genre_name)
                                    VALUES (?, ?)');
        $add_stmt->bind_param('is', $curr_material, $_POST['genre_name']);
        try {
            $add_stmt->execute();
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
    } elseif (isset($_POST['delete_languages'])) {
        $get_relevant_records_stmt = $conn->prepare("SELECT language_name
                                                       FROM selection_languages
                                                      WHERE material_id = ?");
        $get_relevant_records_stmt->bind_param("i", $curr_material);
        $get_relevant_records_stmt->execute();
        $res = $get_relevant_records_stmt->get_result();
        $data = $res->fetch_all();

        $del_stmt = $conn->prepare("DELETE FROM selection_languages WHERE material_id = ? AND language_name = ?");
        $del_stmt->bind_param("is", $curr_material, $language_name);

        for ($i = 0; $i < $res->num_rows; $i++) {
            $language_name = $data[$i][0];
            if (isset($_POST['checkbox' . $language_name])) {
                try {
                    $del_stmt->execute();
                } catch (mysqli_sql_exception $e) {
                    echo $e->getMessage();
                }
            }
        }
    } elseif (isset($_POST['add_language'])) {
        $add_stmt = $conn->prepare('INSERT INTO selection_languages (material_id, language_name)
                                    VALUES (?, ?)');
        $add_stmt->bind_param('is', $curr_material, $_POST['language_name']);
        try {
            $add_stmt->execute();
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
    } elseif (isset($_POST["edit_material"])) {
        $new_club_name = $_POST["edit_club_name"];
        $new_club_decs = $_POST["edit_club_desc"];
        $changes_made = True;

        if (isset($_POST["edit_club_name"]) && isset($_POST["edit_club_desc"])) {
            # Check for the club already being in database.
            echo "GOT HERE";
            $checkexists = $conn->prepare("SELECT * FROM clubs WHERE club_name = ?");
            $checkexists->bind_param('s', $club_name);
            $checkexists->execute();

            $result = $checkexists->get_result();

            // this is technically an int but 0 means it does not have that club & 1 means it does
            $has_value = $result->num_rows;

            #we update if the club currently exists.
            if ($has_value) {
                $update_stmt = $conn->prepare("CALL update_club(?, ?, ?)");
                $update_stmt->bind_param('iss', $club_id, $new_club_name, $new_club_decs);
                $update_stmt->execute();

            }
        }
    }

    header("Location:" . $_SERVER['REQUEST_URI'], true, 303);
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
        <h1>
            <?= $material_title ?>
        </h1>
        <?php
        $loan_status_stmt = $conn->prepare('SELECT 1
                                             FROM current_loans
                                            WHERE material_id = ?');
        $loan_status_stmt->bind_param('i', $curr_material);
        if (!$loan_status_stmt->execute()) {
            echo $loan_status_stmt->error;
        }
        $loan_status_res = $loan_status_stmt->get_result();
        $loan_status = $loan_status_res->fetch_all();

        if ($loan_status) {
            ?>
            <p> Currently checked out! </p>
        <?php } else { ?>
            <p> Currently available! </p>
        <?php } ?>

        <?php
        $holds_stmt = $conn->prepare("SELECT COUNT(*) FROM current_holds WHERE material_id = ? GROUP BY material_id"); // displaying how many there are; simple enough to convert into a table
        $holds_stmt->bind_param("i", $curr_material);
        if (!$holds_stmt->execute()) {
            echo $holds_stmt->error;
        }
        $holds_res = $holds_stmt->get_result();
        $holds_data = $holds_res->fetch_all();
        if ($holds_res->num_rows > 0) { ?>
            <p> There are currently
                <?= $holds_data[0][0] ?> holds on this material.
            </p>
        <?php } else { ?>
            <p> There are no holds on this material. </p>
        <?php } ?>

        <?php
        $is_source_stmt = $conn->prepare('SELECT material_is_source, narrative_name
                                                FROM adaptations
                                                     NATURAL JOIN narratives
                                               WHERE material_id = ?');
        $is_source_stmt->bind_param('i', $curr_material);
        if (!$is_source_stmt->execute()) {
            echo $is_source_stmt->error;
        }
        $is_source_res = $is_source_stmt->get_result();
        $is_source_data = $is_source_res->fetch_all();
        if ($is_source_res->num_rows == 0) { ?>
            <p> This material is not an adaptation of any narrative at the moment. </p>
        <?php } else {
            $is_source = $is_source_data[0][0];
            $narrative_title = $is_source_data[0][1];
            if ($is_source) {
                ?>
                <p> This material is the source for the narrative
                    <?= $narrative_title ?>.
                </p>
            <?php } elseif (!$is_source) { ?>
                <p> This material adapts the narrative
                    <?= $narrative_title ?>
                </p>
            <?php }
        } ?>
    </header>

    <h2>Update this Material</h2>
    <form method=POST>
        <label for="new_title">Title:</label>
        <input type="text" name="new_title" value="<?= $material_title ?>" required />
        <br>
        <label for="date_selected">Date Selected: </label>
        <input type="date" name="date_selected" value="<?= $date_selected ?>" required />
        <br>
        <label for="date_created">Date Created: </label>
        <input type="date" name="date_created" value="<?= $date_created ?>" required />
        <br>
        <label for="pending">Pending? </label>
        <input type="checkbox" name="pending" <?php if ($pending) { ?> checked <?php } ?> required />
        <br>
        <label for="cost">Cost: </label>
        <input type="number" min="0" step="any" name="cost" value="<?= $cost ?>" required />
        <br>
        <label for="type">Type: </label>
        <select>
            <?php if ($is_print) {
                $print_types_res = $conn->query("SELECT print_type FROM print_types WHERE print_type_is_active = TRUE");
                $print_types = $print_types_res->fetch_all();

                for ($i = 0; $i < $print_types_res->num_rows; $i++) { ?>
                    <option value="<?= $print_types[$i][0] ?>" required <?php if ($print_types[$i][0] == $type) { ?> selected
                        <?php } ?>>
                        <?= $print_types[$i][0] ?>
                    </option>
                <?php }
            } else {
                $multimedia_types_res = $conn->query("SELECT multimedia_type FROM multimedia_types WHERE multimedia_type_is_active = TRUE");
                $multimedia_types = $multimedia_types_res->fetch_all();

                for ($i = 0; $i < $multimedia_types_res->num_rows; $i++) { ?>
                    <option value="<?= $multimedia_types[$i][0] ?>" required <?php if ($multimedia_types[$i][0] == $type) { ?>
                            selected <?php } ?>>
                        <?= $multimedia_types[$i][0] ?>
                    </option>
                <?php }
            } ?>
        </select>
        <br>
        <label for="length">Length: </label>
        <?php if ($is_print) { ?>
            <input type="number" min="1" name="length" value="<?= $length ?>" required />
        <?php } else { ?>
            <input pattern="^\d{2}:\d{2}:\d{2}$" name="duration" placeholder="HH:MM:SS" value="<?= $length ?>" required>
        <?php } ?>
        <br>
        <input type="submit" name="edit_material" value="Edit Material" />
    </form>

    <h2>Creator(s)</h2>
    <form method=POST>
        <label for="creator_id">Creator ID: </label>
        <input type="number" min="1" name="creator_id" required>
        <label for="new_role">New Creator Role: </label>
        <select name="new_role" id="new_role" required>
            <?php
            $roles_res = $conn->query('SELECT * FROM creator_roles');
            $roles_data = $roles_res->fetch_all();

            for ($i = 0; $i < $roles_res->num_rows; $i++) { ?>
                <option value="<?= $roles_data[$i][0] ?>">
                    <?= $roles_data[$i][0] ?>
                </option>
            <?php } ?>
        </select>
        <input type="submit" name="add_creator" value="Add Creator">
    </form>
    <form method=POST>
        <?php $creators_data = $creators_res->fetch_all(); ?>
        <table>
            <thead>
                <tr>
                    <th>
                        <?= $creators_res->fetch_fields()[3]->name ?>
                    </th>
                    <th> Delete? </th>
                </tr>
            </thead>

            <tbody>
                <?php for ($i = 0; $i < $creators_res->num_rows; $i++) {
                    $id_1 = $creators_data[$i][0];
                    $id_2 = $creators_data[$i][1];
                    $id_3 = $creators_data[$i][2];
                    ?>
                    <tr>
                        <td>
                            <?= $creators_data[$i][3] ?>
                        </td>
                        <td>
                            <input type="checkbox" name="checkbox<?= $id_1 . ',' . $id_2 . ',' . $id_3 ?>"
                                value="<?= $id_1 . ',' . $id_2 . ',' . $id_3 ?>" />
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <input type="submit" name="delete_creators" value="Delete Selected Records" />
    </form>

    <h2>Genre(s)</h2>
    <form method=POST>
        <label for="genre_name">New Genre: </label>
        <select name="genre_name" id="genre_name" required>
            <?php
            $all_genres_res = $conn->query('SELECT * FROM genres');
            $all_genres_data = $all_genres_res->fetch_all();

            for ($i = 0; $i < $all_genres_res->num_rows; $i++) { ?>
                <option value="<?= $all_genres_data[$i][0] ?>">
                    <?= $all_genres_data[$i][0] ?>
                </option>
            <?php } ?>
        </select>
        <input type="submit" name="add_genre" value="Add Genre">
    </form>
    <?= result_to_deletable_table_general($genres_res, [-1], 'Delete?', 'Delete Genre', 'delete_genres') ?>

    <h2>Language(s)</h2>
    <form method=POST>
        <label for="genre_name">New Language: </label>
        <select name="language_name" id="language_name" required>
            <?php
            $all_languages_res = $conn->query('SELECT * FROM languages');
            $all_languages_data = $all_languages_res->fetch_all();

            for ($i = 0; $i < $all_languages_res->num_rows; $i++) { ?>
                <option value="<?= $all_languages_data[$i][0] ?>">
                    <?= $all_languages_data[$i][0] ?>
                </option>
            <?php } ?>
        </select>
        <input type="submit" name="add_language" value="Add Language">
    </form>
    <?= result_to_deletable_table_general($languages_res, [-1], 'Delete?', 'Delete Language', 'delete_languages') ?>

    <h2>Adaptation(s)</h2> <!-- no data management here; that happens elsewhere -->
    <?= result_to_table($adaptations_res) ?>

</body>

</html>