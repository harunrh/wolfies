<?php
require_once 'vendor/autoload.php';

// Set up Twig environment
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/OpenDay/templates');
$twig = new \Twig\Environment($loader, [
    'debug' => true  // Enable debug mode if needed, we will disable in production
]);

// Render the Twig template
echo $twig->render('campus_tour_details.twig');
?>