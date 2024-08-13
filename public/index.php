<?php
$route = isset($_GET['route']) ? $_GET['route'] : '';

// Define an array of valid routes and their corresponding PHP files
$routes = [
    '' => '../pages/home.php',
    'about' => './error.php',
    'contact' => './error.php',
    'login' => '../pages/login.php',
    // Add more routes here
];

if (array_key_exists($route, $routes)) {
    include($routes[$route]);
} else {
    include('./404.php'); // Show 404 page for undefined routes
}

// Include the configuration file
include_once('../config/config.php');

// Redirect to the home page using the BASE_URL
header('Location: ' . BASE_URL . '/pages/home.php');
exit();
?>
