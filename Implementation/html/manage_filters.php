<?php // for managing validation tables
require 'includes/setup.php';
require 'includes/format_result.php';
$conn = setup();





///
/// Views for SQL output
///

$genres_res = $conn->query("SELECT genre_name 
                            FROM genres;");
$languages_res = $conn->query("SELECT language_name
                            FROM languages;");
$creator_roles_res = $conn->query("SELECT creator_role
                            FROM creator_roles;");
$multimedia_types_res = $conn->query("SELECT creator_role
                            FROM creator_roles;");  
$print_types_res = $conn->query("SELECT creator_role
FROM creator_roles;");

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

    <a href="staff_index.php">Back to Staff</a>
    <h1>Manage Filters For the Selection</h1>

    <h2>Genres</h2>
    <form action="manage_filters.php" method=POST>
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
    <form action="manage_filters.php" method=POST>
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
    <h2>Genres</h2>
    <form action="manage_filters.php" method=POST>
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
                                "delete_roles"              // check this at start
                                )
            ?>


    <h2>Print Types</h2>
    <h2>Genres</h2>
    <form action="manage_filters.php" method=POST>
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
                                "delete_prints"              // check this at start
                                )
            ?>

    <h2>Multimedia Types</h2>
    <h2>Genres</h2>
    <form action="manage_filters.php" method=POST>
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

    <h4>Delete Genres</h4>


    <?php
            result_to_checkbox_table($multimedia_types_res, // query
                                "Delete Type",             // string for column
                                "del_multimedia_id_",             // e.g. 'del_multimedia_id_podcast'
                                "Delete Selected Types",   // value of submit form
                                "delete_multimedias"              // check this at start
                                )
            ?>
</body>

</html>