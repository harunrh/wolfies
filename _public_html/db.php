<?php
// Database credentials
$host = 'localhost';
$username = 'u771031651_wolfies';
$password = 'f:x0gX3E/';
$database = 'u771031651_wolfies';

// MySQLi connection with error handling
$db = new mysqli($host, $username, $password, $database);

// Charset to utf8mb4 for full Unicode support
$db->set_charset("utf8mb4");

// Check connection
if ($db->connect_errno) {
    error_log("Failed to connect to MySQL: " . $db->connect_error);
    exit(); // Terminate script
}

// Optionally, you can create a function to close the connection, though it's not usually necessary
function closeDbConnection($db) {
    $db->close();
}
?>