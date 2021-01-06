<?php
// database inloggegevens
$db_hostname = 'localhost';
$db_username = 'ame';
$db_password = 'M694tPB618dwMxKD';
$db_database = 'intratuin';

// maak de databse verbinding
$mysqli = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);

if (!$mysqli)
{
    echo "FOUT: geen connectie naar de database";
    echo "Errno: " . mysqli_connect_errno() . "<br>";
    echo "Error: " . mysqli_connect_error() . "<br>";
    exit;
}


?>