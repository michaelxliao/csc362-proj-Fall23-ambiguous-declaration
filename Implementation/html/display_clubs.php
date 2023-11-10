<?php
require '../includes/setup.php';
require '../includes/format_result.php';

$conn = setup();


?>
<!DOCTYPE html>
<html>

<head>

</head>

<body>
    <h2>Club Search and Editing</h2>
    <h3>Add a Club</h3>
    <form>
    <table>
       <thead>
           <th></th>
       </thead>
       <tbody>
           <!-- Name -->
           <tr>
               <td style="text-align: right">Club name:</td>
               <td><input type="text" name="club_name"/></td>
           </tr>
           <!-- Description -->
           <tr>
               <td style="text-align: right;">Club description:</td>
               <td><input type="text" name="club_desc"
                            style="height: 70px;"/></td>
           </tr>
       </tbody>
</table>
    </form>

a
<h3>a
    <form> <!-- will hold filtering form later -->
    <?php 
    result_to_toggle_active_table($conn->query('SELECT * FROM clubs'));
    ?>    
    </form>


    
    
</body>

</html>