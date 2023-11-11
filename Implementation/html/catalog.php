<?php
require '../includes/setup.php';
require '../includes/format_result.php';

$conn = setup();

$print_types_res = $conn->query("SELECT print_type FROM print_types WHERE print_type_is_active = TRUE");
$multimedia_types_res = $conn->query("SELECT multimedia_type FROM multimedia_types WHERE multimedia_type_is_active = TRUE");

$print_types = $print_types_res->fetch_all();
$multimedia_types = $multimedia_types_res->fetch_all();

$sql_query = 'SELECT * FROM active_selection'; // this by default; can be overridden by filtering
$result = $conn->query($sql_query);

// defining constants like a good coder
$ALL_MEDIA = 'All media';
$PRINT = 'Print';
$MULTIMEDIA = 'Multimedia';

if (isset($_GET["Filter"])) {
    if ($_GET["media-type"] == $PRINT) {
        $sql_query = 'SELECT * FROM active_selection WHERE material_id IN (SELECT material_id FROM print_materials)';
        $result = $conn->query($sql_query);
    } elseif ($_GET["media-type"] == $MULTIMEDIA) {
        $sql_query = 'SELECT * FROM active_selection WHERE material_id IN (SELECT material_id FROM multimedia)';
        $result = $conn->query($sql_query);
    } elseif ($_GET["media-type"] != $ALL_MEDIA) {
        $filter_stmt = $conn->prepare('SELECT * FROM active_selection
                                      LEFT OUTER JOIN print_materials USING (material_id)
                                      LEFT OUTER JOIN multimedia USING (material_id)
                                WHERE (multimedia_type = ?) OR (print_material_type = ?)');
        $filter_stmt->bind_params('ss', $_GET["media-type"], $_GET["media-type"]);
        if (!$filter_stmt->execute()) {
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
<link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <h1>Catalog</h1>
    <form method=GET> <!-- will hold filtering form later -->
        <label for="media-type">Media type: </label>
        <select name="media-type" id="media-type" required>
            <option value=<?= $ALL_MEDIA ?>><?= $ALL_MEDIA ?></option>
            <option value=<?= $PRINT ?>><?= $PRINT ?></option>
            <option value=<?= $MULTIMEDIA ?>><?= $MULTIMEDIA ?></option>
            <?php for ($i = 0; $i<$print_types_res->num_rows; $i++) { ?>
                <option value=<?= $print_types[$i][0] ?>><?= $print_types[$i][0] ?></option>
            <?php } ?>
            <?php for ($i = 0; $i<$multimedia_types_res->num_rows; $i++) { ?>
                <option value=<?= $multimedia_types[$i][0] ?>><?= $multimedia_types[$i][0] ?></option>
            <?php } ?>
        </select>
        <button type="submit" name="Filter">Filter</button>
    </form>
    <?php result_to_table($result); ?>
</body>

</html>