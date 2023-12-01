<?php // for managing validation tables
require 'includes/setup.php';
require 'includes/functions.php';
$conn = setup();

///
/// Checking Changes in SQL
///

$changes_made = False;
// adding genres
if (isset($_POST["add_genre"])) {
    $changes_made = True;

    if (isset($_POST["add_genre_id"])) {
        # Check for the genre already being in database.
        $checkexists = $conn->prepare("SELECT * FROM genres WHERE genre_name = ?");
        $checkexists->bind_param('s', $_POST["add_genre_id"]);
        $result = $checkexists->execute();
        $has_value = $checkexists->get_result()->num_rows;

        # Add if the genre doesn't exist.
        if (!$has_value) {
            $insert_stmt = $conn->prepare("CALL add_genre(?)");
            $insert_stmt->bind_param('s', $_POST["add_genre_id"]);
            $result = $insert_stmt->execute();
        }

    }
}
// deleting genres
if(isset($_POST["delete_genres"])) {
    $changes_made = True;
    #query all instruments
    $result = $conn->query("SELECT genre_name FROM genres");
    $all_ids = $result->fetch_all();
    $num_rows = count($all_ids);
    $del_stmt = $conn->prepare("DELETE FROM genres WHERE genre_name=?");
    $del_stmt->bind_param('s', $id);
    #loop through checkboxes of instruments
    for($i=0; $i<$num_rows; $i++)
    {
        $id = $all_ids[$i][0];
        echo $id;
        if(isset($_POST['del_genre_id_' . $id]))
        {
            $result = $del_stmt->execute();
        }
    }
}
// below is essentially the same handling for all of these, it's essentially just SQL for web.
// recommended: collapse the if statements below this
// (even better if you write a function for all this, which i should've done oops)

// add languages
if (isset($_POST["add_lang"])) {
    $changes_made = True;

    if (isset($_POST["add_lang_id"])) {
        # Check for the genre already being in database.
        $checkexists = $conn->prepare("SELECT * FROM languages WHERE language_name = ?");
        $checkexists->bind_param('s', $_POST["add_lang_id"]);
        $result = $checkexists->execute();
        $has_value = $checkexists->get_result()->num_rows;

        # Add if the genre doesn't exist.
        if (!$has_value) {
            $insert_stmt = $conn->prepare("CALL add_language(?)");
            $insert_stmt->bind_param('s', $_POST["add_lang_id"]);
            $result = $insert_stmt->execute();
        }

    }
}
// deleting languages
if(isset($_POST["delete_languages"])) {
    $changes_made = True;
    #query all instruments
    $result = $conn->query("SELECT language_name FROM languages");
    $all_ids = $result->fetch_all();
    $num_rows = count($all_ids);
    $del_stmt = $conn->prepare("DELETE FROM languages WHERE language_name=?");
    $del_stmt->bind_param('s', $id);
    #loop through checkboxes of instruments
    for($i=0; $i<$num_rows; $i++)
    {
        $id = $all_ids[$i][0];
        echo $id;
        if(isset($_POST['del_lang_id_' . $id]))
        {
            $result = $del_stmt->execute();
        }
    }
}

// add creator roles
if (isset($_POST["add_role"])) {
    $changes_made = True;

    if (isset($_POST["add_role_id"])) {
        # Check for the role already being in database.
        $checkexists = $conn->prepare("SELECT * FROM creator_roles WHERE creator_role = ?");
        $checkexists->bind_param('s', $_POST["add_role_id"]);
        $result = $checkexists->execute();
        $has_value = $checkexists->get_result()->num_rows;

        # Add if the role doesn't exist.
        if (!$has_value) {
            $insert_stmt = $conn->prepare("CALL add_creator_role(?)");
            $insert_stmt->bind_param('s', $_POST["add_role_id"]);
            $result = $insert_stmt->execute();
        }

    }
}
// delete creator roles
if(isset($_POST["del_roles"])) {
    $changes_made = True;
    #query all instruments
    $result = $conn->query("SELECT creator_role FROM creator_roles");
    $all_ids = $result->fetch_all();
    $num_rows = count($all_ids);
    $del_stmt = $conn->prepare("DELETE FROM creator_roles WHERE creator_role=?");
    $del_stmt->bind_param('s', $id);
    #loop through checkboxes of instruments
    for($i=0; $i<$num_rows; $i++)
    {
        $id = $all_ids[$i][0];
        echo $id;
        if(isset($_POST['del_role_id_' . $id]))
        {
            $result = $del_stmt->execute();
        }
    }
}


// add print types
if (isset($_POST["add_print"])) {
    $changes_made = True;

    if (isset($_POST["add_print_id"])) {
        # Check for the genre already being in database.
        $checkexists = $conn->prepare("SELECT * FROM print_types WHERE print_type = ?");
        $checkexists->bind_param('s', $_POST["add_print_id"]);
        $result = $checkexists->execute();
        $has_value = $checkexists->get_result()->num_rows;

        # Add if the genre doesn't exist.
        if (!$has_value) {
            $insert_stmt = $conn->prepare("CALL add_print_type(?)");
            $insert_stmt->bind_param('s', $_POST["add_print_id"]);
            $result = $insert_stmt->execute();
        }

    }
}
// delete print types
if(isset($_POST["del_prints"])) {
    $changes_made = True;
    #query all instruments
    $result = $conn->query("SELECT print_type FROM print_types");
    $all_ids = $result->fetch_all();
    $num_rows = count($all_ids);
    $del_stmt = $conn->prepare("DELETE FROM print_types WHERE print_type=?");
    $del_stmt->bind_param('s', $id);
    #loop through checkboxes of instruments
    for($i=0; $i<$num_rows; $i++)
    {
        $id = $all_ids[$i][0];
        echo $id;
        if(isset($_POST['del_print_id_' . $id]))
        {
            $result = $del_stmt->execute();
        }
    }
}

// add multimedia types
if (isset($_POST["add_multimedia"])) {
    $changes_made = True;

    if (isset($_POST["add_multimedia_id"])) {
        # Check for the genre already being in database.
        $checkexists = $conn->prepare("SELECT * FROM multimedia_types WHERE multimedia_type = ?");
        $checkexists->bind_param('s', $_POST["add_multimedia_id"]);
        $result = $checkexists->execute();
        $has_value = $checkexists->get_result()->num_rows;

        # Add if the genre doesn't exist.
        if (!$has_value) {
            $insert_stmt = $conn->prepare("CALL add_multimedia_type(?)");
            $insert_stmt->bind_param('s', $_POST["add_multimedia_id"]);
            $result = $insert_stmt->execute();
        }

    }
}
// delete multimedia types
if(isset($_POST["del_multimedias"])) {
    $changes_made = True;
    #query all instruments
    $result = $conn->query("SELECT multimedia_type FROM multimedia_types");
    $all_ids = $result->fetch_all();
    $num_rows = count($all_ids);
    $del_stmt = $conn->prepare("DELETE FROM multimedia_types WHERE multimedia_type=?");
    $del_stmt->bind_param('s', $id);
    #loop through checkboxes of instruments
    for($i=0; $i<$num_rows; $i++)
    {
        $id = $all_ids[$i][0];
        echo $id;
        if(isset($_POST['del_multimedia_id_' . $id]))
        {
            $result = $del_stmt->execute();
        }
    }
}

if (isset($_POST["add_creator"])) {
    $changes_made = True;

    if ($_POST["add_creator_firstname"] != "") {

        $new_first_name = $_POST['add_creator_firstname'];

        if($_POST["add_creator_lastname"] == "")
        {
            $new_last_name = Null;
        }
        else
        {
            $new_last_name = $_POST["add_creator_lastname"];
        }

            $insert_stmt = $conn->prepare("CALL add_creator(?, ?)");
            $insert_stmt->bind_param('ss', $new_first_name, $new_last_name);
            $result = $insert_stmt->execute();

    }
}


// delete creators UNFINISHED>>
if(isset($_POST["del_creators"])) {
    $changes_made = True;
    #query all instruments
    $result = $conn->query("SELECT creator_id FROM creators");
    $all_ids = $result->fetch_all();
    $num_rows = count($all_ids);
    $del_stmt = $conn->prepare("DELETE FROM creators WHERE creator_id=?");
    $del_stmt->bind_param('s', $id);
    #loop through checkboxes of instruments
    for($i=0; $i<$num_rows; $i++)
    {
        $id = $all_ids[$i][0];
        echo $id;
        if(isset($_POST['del_creator_id_' . $id]))
        {
            $result = $del_stmt->execute();
        }
    }
}


//post request get
if($changes_made == True)
{
    header("Location:" . $_SERVER['REQUEST_URI'], true, 303);
}

///
/// Views for SQL output
///

$genres_res = $conn->query("SELECT genre_name 
                            FROM genres;");
$languages_res = $conn->query("SELECT language_name
                            FROM languages;");
$creator_roles_res = $conn->query("SELECT creator_role
                            FROM creator_roles;");
$print_types_res = $conn->query("SELECT print_type
                            FROM print_types;");  
$multimedia_types_res = $conn->query("SELECT multimedia_type
FROM multimedia_types;");
$creators_res = $conn->query("SELECT creator_id, creator_first_name, creator_last_name FROM creators;")

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
        <!-- this is where h1s etc. go, any explanatory info -->
        <h1>Therpston County Public Library</h1>
    </header>

    <a href="index_staff.php">Back to Staff</a>
    <h1>Manage Filters For the Selection</h1>

    <h2>Genres</h2>
    <form method=POST>
        <table>
            <thead>
                <th></th>
            </thead>
            <tbody>
                <!-- Name -->
                <tr>
                    <td style="text-align: right">Add a Genre:</td>
                    <td><input type="text" name="add_genre_id" /></td>
                </tr>
            </tbody>
        </table>
        <input type="submit" name="add_genre" value="Add Genre" />

    </form>

    <h4>Delete Genres</h4>

        <?php
        result_to_checkbox_table($genres_res, // query
                                "Delete Genre",             // string for column
                                "del_genre_id_",             // 'del_genre_id_fantasy' would be the checkbox's POST, for ex.
                                "Delete Selected Genres",   // value of submit form
                                "delete_genres"              // check this at start
                                )
        ?>

    <h2>Languages</h2>
    <form method=POST>
        <table>
            <thead>
                <th></th>
            </thead>
            <tbody>
                <!-- Name -->
                <tr>
                    <td style="text-align: right">Add a Language:</td>
                    <td><input type="text" name="add_lang_id" /></td>
                </tr>
            </tbody>
        </table>
        <input type="submit" name="add_lang" value="Add Language" />

    </form>

    <h4>Delete Languages</h4>


        <?php
            result_to_checkbox_table($languages_res, // query
                                "Delete Language",             // string for column
                                "del_lang_id_",             // 'del_lang_id_english' would be the checkbox's POST, for ex.
                                "Delete Selected Languages",   // value of submit form
                                "delete_languages"              // check this at start
                                )
            ?>


    <h2>Creator Roles</h2>
    <form method=POST>
        <table>
            <thead>
                <th></th>
            </thead>
            <tbody>
                <!-- Name -->
                <tr>
                    <td style="text-align: right">Add a Creator Role:</td>
                    <td><input type="text" name="add_role_id" /></td>
                </tr>
            </tbody>
        </table>
        <input type="submit" name="add_role" value="Add Creator Role" />

    </form>

    <h4>Delete Creator Roles</h4>


        <?php
            result_to_checkbox_table($creator_roles_res, // query
                                "Delete Role",             // string for column
                                "del_role_id_",             // 'del_role_id_actor' would be the checkbox's POST, for ex.
                                "Delete Selected Roles",   // value of submit form
                                "del_roles"              // check this at start
                                )
            ?>


    <h2>Print Types</h2>
    <form method=POST>
        <table>
            <thead>
                <th></th>
            </thead>
            <tbody>
                <!-- Name -->
                <tr>
                    <td style="text-align: right">Add a Print Type:</td>
                    <td><input type="text" name="add_print_id" /></td>
                </tr>
            </tbody>
        </table>
        <input type="submit" name="add_print" value="Add Print Type" />

    </form>

    <h4>Delete Print Types</h4>
    <?php
            result_to_checkbox_table($print_types_res, // query
                                "Delete Type",             // string for column
                                "del_print_id_",             // 'del_print_id_book' would be the checkbox's POST, for ex.
                                "Delete Selected Types",   // value of submit form
                                "del_prints"              // check this at start
                                )
            ?>

    <h2>Multimedia Types</h2>
    <form method=POST>
        <table>
            <thead>
                <th></th>
            </thead>
            <tbody>
                <!-- Name -->
                <tr>
                    <td style="text-align: right">Add a Multimedia Type:</td>
                    <td><input type="text" name="add_multimedia_id" /></td>
                </tr>
            </tbody>
        </table>
        <input type="submit" name="add_multimedia" value="Add Multimedia Type" />

    </form>

    <h4>Delete Multimedias</h4>
    <?php
            result_to_checkbox_table($multimedia_types_res, // query
                                "Delete Type",             // string for column
                                "del_multimedia_id_",             // e.g. 'del_multimedia_id_podcast'
                                "Delete Selected Types",   // value of submit form
                                "del_multimedias"              // check this at start
                                )
            ?>

<h2>Creators</h2>
    <form method=POST>
        <table>
            <thead>
                <th></th>
            </thead>
            <tbody>
                <!-- Name -->
                <tr>
                    <td style="text-align: right">Add a Creator:</td>
                    <td><label>First Name:</label><input type="text" name="add_creator_firstname" /></td>
                    <td><label>Last Name:</label><input type="text" name="add_creator_lastname" /></td>

                </tr>
            </tbody>
        </table>
        <input type="submit" name="add_creator" value="Add Creator" />



<h4>Delete Creators</h4>
    <?php
            result_to_checkbox_table($creators_res, // query
                                "Delete Creator",             // string for column
                                "del_creator_id_",             // e.g. 'del_multimedia_id_podcast'
                                "Delete Selected Creators",   // value of submit form
                                "del_creators"              // check this at start
                                )
            ?>

</body>

</html>