<?php
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

function createRegistrationTable($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Registrations (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        phone VARCHAR(50),
        study_level VARCHAR(100) NOT NULL,
        subject_interest VARCHAR(100) NOT NULL,
        guests INT(1) NOT NULL DEFAULT 0,
        special_requirements TINYINT(1) NOT NULL DEFAULT 0,
        special_requirements_details TEXT,
        registration_date DATETIME NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    return $conn->query($sql);
}
?>
