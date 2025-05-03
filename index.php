<?php
require_once 'vendor/autoload.php';

// Set up Twig environment
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/OpenDay/templates');
$twig = new \Twig\Environment($loader);

// Render the template
echo $twig->render('index.twig');
?>