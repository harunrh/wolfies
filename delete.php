<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Start the session

// Include necessary files
require_once 'db.php'; // Database connection
require_once 'vendor/autoload.php';

// Initialize Twig
$loader = new \Twig\Loader\FilesystemLoader('OpenDay/templates');
$twig = new \Twig\Environment($loader);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate email
    $email = trim($_POST['delete_email']);
    $delete_errors = [];
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $delete_errors['delete_email'] = 'Invalid email address.';
    }
    
    if (empty($delete_errors)) {
        // Check if email exists in the database
        $stmt = $db->prepare("SELECT id FROM members WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            // Email exists, proceed to delete
            $stmt->close();
            
            $stmt = $db->prepare("DELETE FROM members WHERE email = ?");
            $stmt->bind_param("s", $email);
            
            if ($stmt->execute()) {
                $_SESSION['delete_success'] = "Your registration has been successfully deleted.";
                header("Location: register.php");
                exit;
            } else {
                $delete_errors['delete_email'] = "Error deleting registration: " . $stmt->error;
            }
        } else {
            $delete_errors['delete_email'] = "No registration found with this email.";
        }
        
        $stmt->close();
    }
    
    // If there are errors, store them in session and redirect back to register page
    if (!empty($delete_errors)) {
        $_SESSION['delete_errors'] = $delete_errors;
        $_SESSION['show_delete_modal'] = true;
        header("Location: register.php");
        exit;
    }
} else {
    // If accessed directly without POST data, redirect to register page
    header("Location: register.php");
    exit;
}