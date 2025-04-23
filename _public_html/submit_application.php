<?php
// Handle form submission for accommodation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data here
    
    // Redirect to a success page or back to university life
    header("Location: university_life.php?success=true");
    exit();
} else {
    // Redirect if accessed directly
    header("Location: university_life.php");
    exit();
}