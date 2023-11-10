<?php
require 'includes/setup.php';
$conn = setup();

?>

<h1>Therpston County Public Library</h1>

<h2>Reports</h2>
Search for a Specific:
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
        <a href="manageClubs.php">Clubs</a>
    </li>  
    <li>
        Holds and Loans (selection)
    </li>  
</ul>



Notes
- library-facing and patron-facing, patrons as a subset.
- stretch goal: sessions an