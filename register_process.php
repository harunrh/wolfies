<?php
// Start session
session_start();

// Include database configuration and functions
require_once '../private/db_config.php';
require_once '../private/functions.php';

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['success_message'] = "Thank you for registering for our Open Day!";
    header("Location: index.php?registration=success#register");
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>
