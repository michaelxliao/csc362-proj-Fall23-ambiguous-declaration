<?php
# setup debugging php errors

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

# Create sql connection

$config = parse_ini_file('/home/stard/mysql.ini');
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
    } else {
        echo "Connection established." . "<br>";
    }
?>

<h1>Therpston County Public Library</h1>

<h2>Reports</h2>
Search for Specific:
<ul>
    <li>
        <a href="patron_profile.php">Patrons (Patron Profile)</a>
    </li>
    <li>
        <a href="club_profile.php">Clubs (Club Profile)</a>
    </li>
    <li>
        <a href="current_holds.php">Holds (rework)</a>
    </li>  
    <li>
        Adaptations of a Narrative    
</li>
</ul>

Show Details On:
</ul>
    <li>
        The Catalog (filterable, public-facing)
    </li>
    <li>
        Current Loans
    </li>
    <li>
        Current Reservations
    </li>
    <li>
        Current Holds
    </li>
    <li>
        All Active Clubs
    </li>
</ul>


<h2>Data Management</h2>
<ul>
    <li>
        Selection
    </li>
    <li>
        Patrons
    </li>
    <li>
        Spaces and Space Reservations
    </li>  
    <li>
        Clubs
    </li>  
    <li>
        Holds and Loans (selection)
    </li>  
</ul>



Notes
- library-facing and patron-facing, patrons as a subset.
- stretch goal: sessions an