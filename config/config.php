<?php
// config/config.php

// Function to load environment variables from .env file
function loadEnv($path) {
    if (!file_exists($path)) {
        throw new Exception(".env file not found");
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}

// Load environment variables
loadEnv(__DIR__ . '/../.env');

// Define constants based on environment variables
define('BASE_URL', getenv('BASE_URL'));
define('DB_HOST', getenv('DB_HOST'));
define('DB_NAME', getenv('DB_NAME'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASS', getenv('DB_PASS'));
define('FOREX_BASE_URL', getenv('FOREX_BASE_URL'));
define('FOREX_API_KEY', getenv('FOREX_API_KEY'));
define('FOREX_2_BASE_URL', getenv('FOREX_2_BASE_URL'));
define('FOREX_2_API_KEY', getenv('FOREX_2_API_KEY'));
define('SENDER_EMAIL', getenv('SENDER_EMAIL'));
define('SENDER_PASSWORD', getenv('SENDER_PASSWORD'));
