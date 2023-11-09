<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$config = parse_ini_file('/home/rashawn_butler/mysql.ini');
$dbname = 'therpston';
print_r($config);
$conn = new mysqli(
    $config['lib_host'],
    $config['lib_user'],
    $config['lib_password'],
    $config['lib_database']
);

if ($conn->connect_errno) {
    echo "Error: Failed to make a MySQL connection, here is why: ". "<br>";
    echo "Errno: " . $conn->connect_errno . "\n";
    echo "Error: " . $conn->connect_error . "\n";
exit; // Quit this PHP script if the connection fails.
};

?>
<html>
    <head>
        <title>Managing Clubs Page</title>
        <body>
            <p>Hello World. This will be where clubs are managed</p>
        </body>
    </head>
</html>