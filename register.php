<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
// Include necessary files
require_once __DIR__ . '/vendor/autoload.php';
require_once 'db.php';
require_once 'email.php';
// Twig setup
$loader = new \Twig\Loader\FilesystemLoader('OpenDay/templates');
$twig = new \Twig\Environment($loader);
//  A function for email section that makes sure the code is unique by looping through the existing ones in db
// Produces a shoter code
function smallCode($db, $length = 10) {
    do {
        $randomBytes = random_bytes(5); 
        $registrationCode = strtoupper(base_convert(bin2hex($randomBytes), 16, 36));
        $stmt = $db->prepare("SELECT id FROM members WHERE registration_code = ?");
        $stmt->bind_param("s", $registrationCode);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
    } while ($exists);
    return $registrationCode;
}
// Helper to build consistent template variables
function buildTemplateVars($extras = []) {
    $vars = [
        'active_page' => 'register'
    ];
    
    if (isset($_SESSION['delete_success'])) {
        $vars['delete_success'] = $_SESSION['delete_success'];
    }
    
    if (isset($_SESSION['delete_errors'])) {
        $vars['delete_errors'] = $_SESSION['delete_errors'];
    }
    
    if (isset($_SESSION['show_delete_modal'])) {
        $vars['show_delete_modal'] = $_SESSION['show_delete_modal'];
    }
    
    return array_merge($vars, $extras);
}
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $studyLevel = isset($_POST['study_level']) ? $_POST['study_level'] : '';
    $subjectInterest = isset($_POST['subject_interest']) ? $_POST['subject_interest'] : '';
    $numberGuests = isset($_POST['guests']) ? $_POST['guests'] : '';
    
    $errors = [];
    
    // Validation
    if (empty($fullName)) {
        $errors['full_name'] = 'Full name is required.';
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email address.';
    }
    
    if (!empty($errors)) {
        echo $twig->render('register.twig', buildTemplateVars([
            'errors' => $errors,
            'fullName' => $fullName,
            'email' => $email
        ]));
        unset($_SESSION['delete_success']);
        exit;
    }
    
    // Check for duplicate email
    $stmt = $db->prepare("SELECT id FROM members WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $errors['email'] = 'Email address already registered.';
        echo $twig->render('register.twig', buildTemplateVars([
            'errors' => $errors,
            'fullName' => $fullName,
            'email' => $email
        ]));
        $stmt->close();
        unset($_SESSION['delete_success']);
        exit;
    }
    
    $stmt->close();
    
    // Generate registration code
    $registrationCode = smallCode($db);
    
    // Store in DB
    $stmt = $db->prepare("INSERT INTO members (full_name, email, study_level, subject_interest, number_of_guests, registration_code) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $fullName, $email, $studyLevel, $subjectInterest, $numberGuests, $registrationCode);
    
    if ($stmt->execute()) {
        // Use the verificationEmail function from email.php
        if (verificationEmail($email, $fullName, $registrationCode)) {
            $_SESSION['registration_email'] = $email;
            header("Location: register_success.php");
            exit;
        } else {
            echo "Error sending verification email.";
        }
    } else {
        echo "Database error: " . $stmt->error;
    }
    
    $stmt->close();
    $db->close();
} else {
    // Show form
    echo $twig->render('register.twig', buildTemplateVars());
    unset($_SESSION['delete_errors']);
    unset($_SESSION['delete_success']);
    unset($_SESSION['show_delete_modal']);
}
?>
