<?php
// Database configuration
define('RHOST', '192.168.100.237'); // or the IP address of your MySQL server
define('RUSER', 'dongera'); // replace with your MySQL username
define('RPASS', 'Winger2004!'); // replace with your MySQL password
define('DB', 'CAT1'); // name of your database

// Establish a connection to the database
$conn = mysqli_connect(RHOST, RUSER, RPASS, DB);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

