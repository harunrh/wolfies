<?php
require_once 'vendor/autoload.php';

// Twig environment
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/OpenDay/templates');
$twig = new \Twig\Environment($loader, [
    'debug' => true
]);


// Render the template
echo $twig->render('conditions.twig');
?>