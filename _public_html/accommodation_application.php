<?php
require_once __DIR__ . '/vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('OpenDay/templates');
$twig = new \Twig\Environment($loader);

echo $twig->render('accommodation_application.twig', [
    'active_page' => 'university_life'
]);