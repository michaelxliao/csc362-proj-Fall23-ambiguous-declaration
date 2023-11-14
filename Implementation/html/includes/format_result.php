<?php // taken from lab 7
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