<?php
function doErrorReporting() {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Noah's extra code
}

function connectToDB() {
    $config = parse_ini_file('/home/' . get_current_user() . '/mysql.ini'); // scuffed but it works
    // $config = parse_ini_file('/home/stard/mysql.ini');
    // if (!$config) { // if this fails, try another directory (NOTE: WILL PRODUCE WARNINGS! DISABLE WHEN DONE)
    //     $config = parse_ini_file('/home/michael/mysql.ini');
    //     if (!$config) {
    //         $config = parse_ini_file('/home/rashawn_butler/mysql.ini');
    //     }
    // }

    $conn = new mysqli(
                $config['lib_host'],
                $config['lib_user'],
                $config['lib_password'],
                $config['lib_database']);
    if ($conn->connect_errno) {
            echo "Error: Failed to make a MySQL connection, here is why: ". "<br>";
            echo "Errno: " . $conn->connect_errno . "\n";
            echo "Error: " . $conn->connect_error . "\n";
            exit; // Quit this PHP script if the connection fails.
    }
        // } else {
        //     echo "Connection established." . "<br>";
        // }

    return $conn;
}

function setup($enable_errors = false) { // can turn off enable errors by passing false bool
    if ($enable_errors) {
        doErrorReporting();
    }
    return connectToDB();
}

?>
