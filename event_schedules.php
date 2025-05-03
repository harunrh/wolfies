<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Basic requirements
    require_once 'vendor/autoload.php';

    // Set up Twig environment
    $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/OpenDay/templates');
    $twig = new \Twig\Environment($loader);

    // Define University of Wolverhampton Open Day events with explicit keys
    $events = [
        [
            'event_id' => 1,
            'title' => 'Welcome Talk',
            'description' => 'Introduction to the University of Wolverhampton and overview of the Open Day',
            'start_time' => '2025-05-15 09:30:00',
            'end_time' => '2025-05-15 10:15:00',
            'location' => 'Harrison Learning Centre',
            'category' => 'general'
        ],
        [
            'event_id' => 2,
            'title' => 'City Campus Tour',
            'description' => 'Guided tour of our City Campus facilities',
            'start_time' => '2025-05-15 10:30:00',
            'end_time' => '2025-05-15 11:30:00',
            'location' => 'Meet at Ambika Paul Building',
            'category' => 'tour'
        ],
        [
            'event_id' => 3,
            'title' => 'Computing & Digital Technology Showcase',
            'description' => 'Explore our computing facilities',
            'start_time' => '2025-05-15 11:45:00',
            'end_time' => '2025-05-15 12:30:00',
            'location' => 'MI Building',
            'category' => 'academic'
        ],
        [
            'event_id' => 4,
            'title' => 'Lunch Break',
            'description' => 'Complimentary lunch provided',
            'start_time' => '2025-05-15 12:30:00',
            'end_time' => '2025-05-15 13:30:00',
            'location' => 'MC Building Atrium',
            'category' => 'general'
        ],
        [
            'event_id' => 5,
            'title' => 'Student Life at Wolves',
            'description' => 'Current students share their experiences',
            'start_time' => '2025-05-15 13:45:00',
            'end_time' => '2025-05-15 14:30:00',
            'location' => 'Wulfruna Building',
            'category' => 'student'
        ]
    ];

    // Extract categories (avoiding array_column for compatibility)
    $categories = array();
    foreach ($events as $event) {
        if (isset($event['category']) && !in_array($event['category'], $categories)) {
            $categories[] = $event['category'];
        }
    }
    sort($categories);

    // Render the template with simpler variables
    echo $twig->render('event_schedules.twig', [
        'active_page' => 'events',
        'events' => $events,
        'categories' => $categories
    ]);
    
} catch (Exception $e) {
    // Output a more useful error message
    echo "<h1>An error occurred</h1>";
    echo "<p>Error details: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . " on line " . $e->getLine() . "</p>";
}
?>