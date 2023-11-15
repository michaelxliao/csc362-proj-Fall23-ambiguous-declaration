<?php
# Specifically, this is to add fields with GET requests.
function result_to_clickable_table($result, $typeofid, $url) {
    $fields = $result->fetch_fields();
    $data = $result->fetch_all();
?>
    <table>
        <thead>
            <tr>
                <?php for ($i=0; $i<$result->field_count; $i++) { ?>
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
                        if ($j == 1) { 
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


 '?' + patronid  
?>