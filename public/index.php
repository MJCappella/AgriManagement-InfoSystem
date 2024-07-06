<?php
// Include the configuration file
include_once('../config/config.php');

// Redirect to the home page using the BASE_URL
header('Location: ' . BASE_URL . '/pages/home.php');
exit();
?>
