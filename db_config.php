<?php
// Database connection
$host = 'localhost';
$username = 'u771031651_wolfies';
$password = 'wolfies12345X';
$database = 'u771031651_wolfies';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8mb4");
?>
