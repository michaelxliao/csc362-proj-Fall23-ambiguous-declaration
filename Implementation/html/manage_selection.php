<?php
require 'includes/setup.php';
require 'includes/format_result.php';

$conn = setup();

$print_types_res = $conn->query("SELECT print_type FROM print_types WHERE print_type_is_active = TRUE");
$multimedia_types_res = $conn->query("SELECT multimedia_type FROM multimedia_types WHERE multimedia_type_is_active = TRUE");

$print_types = $print_types_res->fetch_all();
$multimedia_types = $multimedia_types_res->fetch_all();

$sql_query = 'SELECT * FROM pretty_selection_librarian'; // this by default; can be overridden by filtering
$result = $conn->query($sql_query);

// defining constants like a good coder
$ALL_MEDIA = 'All media';
$PRINT = 'Print';
$MULTIMEDIA = 'Multimedia';

if (isset($_GET["Filter"])) {
    // echo $_GET["media-type"];
    if ($_GET["media-type"] == $ALL_MEDIA) {
        $sql_query = 'SELECT * FROM pretty_selection_librarian'; // this by default; can be overridden by filtering
        $result = $conn->query($sql_query);
    }
    if ($_GET["media-type"] == $PRINT) {
        $sql_query = 'SELECT * FROM pretty_selection_librarian
                       WHERE pretty_selection_librarian.`ID` IN (SELECT material_id FROM print_materials)';
        $result = $conn->query($sql_query);
    } elseif ($_GET["media-type"] == $MULTIMEDIA) {
        $sql_query = 'SELECT * FROM pretty_selection_librarian
                       WHERE pretty_selection_librarian.`ID` IN (SELECT material_id FROM multimedia)';
        $result = $conn->query($sql_query);
    } elseif ($_GET["media-type"] != $ALL_MEDIA) {
        $filter_stmt = $conn->prepare('SELECT * FROM pretty_selection_librarian
                                WHERE `Type` = ?');
        $filter_stmt->bind_param('s', $_GET["media-type"]);
        if ($filter_stmt->execute()) {
            $result = $filter_stmt->get_result();
        } else {
            echo "OOPSY DAISY!";
        }
    }
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
    <h1>Catalog</h1>
    <form method=GET> <!-- NOTE FOR FILTERING: don't freakin forget your quotes -->
    <!-- need to convert to checkboxes; we don't want just one or the other, we may want multiple -->
        <label for="media-type">Media type: </label>
        <select name="media-type" id="media-type" required>
            <option value="<?= $ALL_MEDIA ?>">
                <?= $ALL_MEDIA ?>
            </option>
            <option value="<?= $PRINT ?>">
                <?= $PRINT ?>
            </option>
            <option value="<?= $MULTIMEDIA ?>">
                <?= $MULTIMEDIA ?>
            </option>
            <?php for ($i = 0; $i < $print_types_res->num_rows; $i++) { ?>
                <option value="<?= $print_types[$i][0] ?>">
                    <?= $print_types[$i][0] ?>
                </option>
            <?php } ?>
            <?php for ($i = 0; $i < $multimedia_types_res->num_rows; $i++) { ?>
                <option value="<?= $multimedia_types[$i][0] ?>">
                    <?= $multimedia_types[$i][0] ?>
                </option>
            <?php } ?>
        </select>
        <button type="submit" name="Filter">Filter</button>
    </form>
    <?php result_to_table($result); ?>
</body>

</html>