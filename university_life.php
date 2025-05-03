<?php
require_once 'vendor/autoload.php';

// Twig environment
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/OpenDay/templates');
$twig = new \Twig\Environment($loader, [
    'debug' => true
]);

// Simplified content focused on open day visitors
$universityLife = [
    'campus_facilities' => [
        'title' => 'Campus Facilities',
        'description' => 'Explore our modern learning spaces, libraries, and recreational areas.',
        'image' => 'images/front.jpg'
    ],
    'clubs' => [
        'title' => 'Student Activities',
        'description' => 'Discover the wide range of clubs, societies and activities you can participate in.',
        'image' => 'images/clubs.jpg'
    ],
    'social' => [
        'title' => 'Social Experience',
        'description' => 'Get a taste of the vibrant social scene both on campus and in the surrounding area.',
        'image' => 'images/accommodation.jpg'
    ],
    'careers' => [
        'title' => 'Career Opportunities',
        'description' => 'Learn how we prepare our students for success after graduation.',
        'image' => 'images/support.jpg'
    ]
];

// Rendering the Twig template with university life data
echo $twig->render('university_life.twig', ['universityLife' => $universityLife]);
?>