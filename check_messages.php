<?php
// Start session to access session variables
session_start();

// Check for success message
if(isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])) {
    echo '<div class="success-message">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']); // Clear the message
}

// Check for error message
if(isset($_SESSION['error_message']) && !empty($_SESSION['error_message'])) {
    echo '<div class="error-message">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']); // Clear the message
}
?>
