<?php
require_once 'vendor/autoload.php';

// Twig environment
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/OpenDay/templates');
$twig = new \Twig\Environment($loader, [
    'debug' => true
]);

// Rendering the Twig template without any additional data
echo $twig->render('university_life.twig');
?>
