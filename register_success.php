<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

// Twig environment
$loader = new \Twig\Loader\FilesystemLoader('OpenDay/templates');
$twig = new \Twig\Environment($loader);

// Render the template
echo $twig->render('register_success.twig', [
    'active_page' => 'register',
    'email' => $_SESSION['registration_email'] ?? ''
]);
?>