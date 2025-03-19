<?php
// Start session
session_start();

// Include database configuration
require_once '../private/db_config.php';
require_once '../private/functions.php';

// Only process POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $fullName = isset($_POST['fullName']) ? sanitizeInput($_POST['fullName']) : '';
    $email = isset($_POST['email']) ? sanitizeInput($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? sanitizeInput($_POST['phone']) : '';
    $studyLevel = isset($_POST['studyLevel']) ? sanitizeInput($_POST['studyLevel']) : '';
    $subjectInterest = isset($_POST['subjectInterest']) ? sanitizeInput($_POST['subjectInterest']) : '';
    $guests = isset($_POST['guests']) ? (int)$_POST['guests'] : 0;
    $specialRequirements = isset($_POST['specialRequirements']) ? 1 : 0;
    $specialRequirementsDetails = isset($_POST['specialRequirementsDetails']) ? sanitizeInput($_POST['specialRequirementsDetails']) : '';
    
    // Validate required fields
    if (empty($fullName) || empty($email) || empty($studyLevel) || empty($subjectInterest)) {
        // Redirect with error status
        header("Location: index.html?status=error");
        exit();
    }
    
    try {
        // Insert into database
        $sql = "INSERT INTO Registrations (full_name, email, phone, study_level, subject_interest, 
                guests, special_requirements, special_requirements_details, registration_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssiis", $fullName, $email, $phone, $studyLevel, $subjectInterest, 
                         $guests, $specialRequirements, $specialRequirementsDetails);
        
        if ($stmt->execute()) {
            // Success - redirect with success parameter
            header("Location: index.html?status=success#register");
            exit();
        } else {
            // Error with query
            header("Location: index.html?status=error#register");
            exit();
        }
    } catch (Exception $e) {
        // Database error
        header("Location: index.html?status=error#register");
        exit();
    }
} else {
    // Not a POST request
    header("Location: index.html");
    exit();
}
?>
