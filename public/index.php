<?php
$route = isset($_GET['route']) ? $_GET['route'] : '';

// Define an array of valid routes and their corresponding PHP files
$routes = [
    '' => '../pages/home.php',
    'home' => '../pages/home.php',
    'about' => './about.php',
    'services' => './services.php',
    'login' => '../pages/login.php',
    'register' => '../pages/register.php',
    'farmer' => '../pages/dashboards/farmer_dashboard.php',
    'buyer' => '../pages/dashboards/buyer_dashboard.php',
    'government' => '../pages/dashboards/government_dashboard.php',
    'marketing' => '../pages/dashboards/marketing_dashboard.php',
    'transporter' => '../pages/dashboards/transporter_dashboard.php',
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
// header('Location: ' . BASE_URL . '/pages/home.php');
exit();
?>
