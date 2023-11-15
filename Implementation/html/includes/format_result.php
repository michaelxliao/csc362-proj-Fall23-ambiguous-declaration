<?php // taken from lab 7
/*
    This file contains several functions that manipulate a mysqli result object
    (often from the execution of a prepared statement or a call to query()) and
    produce a variety of HTML-ready tables based on it. A list of functions follow.

    result_to_table() -- creates a basic table that lists all fields, no interactivity
    result_to_deletable_table() -- creates a table with checkboxes that can be deleted from (ignoring FK constraints)
    result_to_clickable_table() -- creates a table with clickable/drill-downable links in the second column
*/

function result_to_table($result) {
        $fields = $result->fetch_fields();
        $data = $result->fetch_all();
    ?>
        <table>
            <thead>
                <tr>
                    <?php for ($i=0; $i<$result->field_count; $i++) { ?>
                        <th> <?= $fields[$i] -> name ?> </th>
                    <?php } ?>
                </tr>
            </thead>

            <tbody>
                <?php for ($i=0; $i<$result->num_rows; $i++) { ?>
                    <?php $id = $data[$i][0] // this is the primary key ?>
                    <tr>
                        <?php for ($j=0; $j<$result->field_count; $j++) { ?>
                            <td> <?= $data[$i][$j] ?> </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
    </table>
<?php } ?>

<?php
function result_to_deletable_table($result) { // defining deletable table
        $fields = $result->fetch_fields();
        $data = $result->fetch_all();
    ?>
        <form method=POST>
            <table>
                <thead>
                    <tr>
                        <?php for ($i=0; $i<$result->field_count; $i++) { ?>
                            <th> <?= $fields[$i]->name ?> </th>
                        <?php } ?>
                        <th> Delete? </th>
                    </tr>
                </thead>

                <tbody>
                    <?php for ($i=0; $i<$result->num_rows; $i++) { ?>
                        <?php $id = $data[$i][0] // this is the primary key ?>
                        <tr>
                            <?php for ($j=0; $j<$result->field_count; $j++) { ?>
                                <td> <?= $data[$i][$j] ?> </td>
                            <?php } ?>
                            <td>
                                <input type="checkbox"
                                    name="checkbox<?= $id ?>"
                                    value=<?= $id ?>
                                />
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
        </table>
        <input type="submit" name="delete_records" value="Delete Selected Records" method=POST />
    </form>
<?php } ?>

<?php
function result_to_toggle_active_table($result) { // defining toggle active table
        $fields = $result->fetch_fields();
        $data = $result->fetch_all();
    ?>
        <form method=POST>
            <table>
                <thead>
                    <tr>
                        <?php for ($i=0; $i<$result->field_count; $i++) { ?>
                            <th> <?= $fields[$i]->name ?> </th>
                        <?php } ?>
                        <th> Set Active/Inactive </th>
                    </tr>
                </thead>

                <tbody>
                    <?php for ($i=0; $i<$result->num_rows; $i++) { ?>
                        <?php $id = $data[$i][0] // this is the primary key ?>
                        <tr>
                            <?php for ($j=0; $j<$result->field_count; $j++) { ?>
                                <td> <?= $data[$i][$j] ?> </td>
                            <?php } ?>
                            <td>
                                <input type="checkbox"
                                    name="setactive<?= $id ?>"
                                    value=<?= $id ?>
                                />
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
        </table>
        <input type="submit" name="toggle_active_records" value="Toggle Activity For Selected Records" method=POST />
    </form>
<?php } ?>

<?php
# Specifically, this is to add fields with GET requests.
function result_to_clickable_table($result, $typeofid, $url, $show_ids) {
    $fields = $result->fetch_fields();
    $data = $result->fetch_all();
?>
    <table>
        <thead>
            <tr>
                <?php for ($i=0; $i<$result->field_count; $i++) { 
                    // Only have field for ids if show_ids
                    if (($i == 0) && (!$show_ids)) {
                        continue;
                    }
                    ?>
                    <th> <?= $fields[$i] -> name ?> </th>
                <?php
                    }
                  ?>
            </tr>
        </thead>

        <tbody>
            <?php for ($i=0; $i<$result->num_rows; $i++) { ?>
                <?php $id = $data[$i][0] // this is the primary key ?>
                <tr>
                    <?php for ($j=0; $j<$result->field_count; $j++) {
                        // Only show ids if show_ids is True 
                        if (($j == 0) && (!$show_ids)) { 
                            continue;
                        }
                        if ($j == 1) { // index of the clickable column 
                        $newurl = $url . "?" . $typeofid . "id=" . $id; ?>
                        <td> <a href=<?=$newurl?>> <?= $data[$i][$j] ?> </a> </td>
                    <?php }
                        else { ?>
                            <td> <?=$data[$i][$j] ?> </td>
                        <?php }
                    } ?>
                </tr>
            <?php } ?>
        </tbody>
</table>
<?php } ?>