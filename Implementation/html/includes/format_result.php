<?php // taken from lab 7
/*
    This file contains several functions that manipulate a mysqli result object
    (often from the execution of a prepared statement or a call to query()) and
    produce a variety of HTML-ready tables based on it. A list of functions follow.

    result_to_table() 
        -- creates a basic table that lists all fields, no interactivity
    result_to_deletable_table() 
        -- creates a table with checkboxes that can be deleted from (ignoring FK constraints)
    result_to_clickable_table() 
        -- creates a table with clickable/drill-downable links in the second column. 
        -- MUST HAVE ID IN FIRST COLUMN OF RESULT, view can be toggled
    result_to_toggle_active_table() 
        -- creates a table with checkboxes that toggle activity 
        -- (!!! NOTE UNNECESSARY; SHOULD BE SAME AS DELETE)
    result_to_checkbox_table() 
        -- highly customizable checkbox table. Extension of result_to_deletable_table.
    result_to_session_table()
        -- creates a basic table that lists fields NOT including last field.
        -- Used for blocking out patron_id in corresponding session tables.
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
function result_to_deletable_table($result, $showids) { // defining deletable table
        $fields = $result->fetch_fields();
        $data = $result->fetch_all();
    ?>
        <form method=POST>
            <table>
                <thead>
                    <tr>
                        <?php
                        //if we want to show ids, usually false because they're backend. 
                        if($showids) {
                            $start = 0;
                        }
                        else {
                            $start = 1;
                        }
                         for ($i=$start; $i<$result->field_count; $i++) { ?>
                            <th> <?= $fields[$i]->name ?> </th>
                        <?php } ?>
                        <th> Delete? </th>
                    </tr>
                </thead>

                <tbody>
                    <?php for ($i=0; $i<$result->num_rows; $i++) { ?>
                        <?php $id = $data[$i][0] // this is the primary key ?>
                        <tr>
                            <?php
                            // start is the same as earlier
                            for ($j=$start; $j<$result->field_count; $j++) { ?>
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
        <input type="submit" name="delete_records" value="Delete Selected Records"/>
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


<?php

function result_to_checkbox_table($result, $col_output_name, $name_of_checkbox, $submit_output_name, $name_of_submit) { // defining toggle active table
    // $result is sqli query result
    // $col_output_name is the string for the table header cell, for the output
    // $name_of_checkbox is the name of the ID you want for the checkbox when submitte. In general, you grab it by:
        // $_POST[name_of_checkbox<id>]
        //e.g. $name_of_checkbox = 'clubid', and I want to see if the 5th record is checked.
        // I would do the following command: isset($_POST['clubid5']) 
    // $submit_output_name is the string for the SUBMIT form. 
    // $name_of_submit is the name of the variable for the SUBMIT button.

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
                        <th> <?=$col_output_name?> </th>
                    </tr>
                </thead>

                <tbody>
                    <?php for ($i=0; $i<$result->num_rows; $i++) { ?>
                        <?php $prim_key = $data[$i][0] // this is the primary key ?>
                        <tr>
                            <?php for ($j=0; $j<$result->field_count; $j++) { ?>
                                <td> <?= $data[$i][$j] ?> </td>
                            <?php } ?>
                            <td>
                                <input type="checkbox"
                                    name="<?=$name_of_checkbox?><?= $prim_key ?>"
                                />
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
        </table>
        <input type="submit" name="<?=$name_of_submit?>" value="<?=$submit_output_name?>" method=POST />
    </form>
<?php } ?>

<?php
function result_to_session_table($result) {
        $fields = $result->fetch_fields();
        $data = $result->fetch_all();
    ?>
        <table>
            <thead>
                <tr>
                    <?php for ($i=0; $i<$result->field_count - 1; $i++) { ?>
                        <th> <?= $fields[$i] -> name ?> </th>
                    <?php } ?>
                </tr>
            </thead>

            <tbody>
                <?php for ($i=0; $i<$result->num_rows; $i++) { ?>
                    <?php $id = $data[$i][0] // this is the primary key ?>
                    <tr>
                        <?php for ($j=0; $j<$result->field_count - 1; $j++) { ?>
                            <td> <?= $data[$i][$j] ?> </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
    </table>
<?php } ?>
