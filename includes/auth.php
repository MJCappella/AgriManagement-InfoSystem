<?php
session_start();

function isLoggedIn() {
    if (isset($_SESSION['user_id'])) {
        //echo $_SESSION['user_type'];
        return true;
    }
    return false;
}

function login($user_id, $user_type) {
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_type'] = $user_type;
}

function logout() {
    session_unset();
    session_destroy();
    echo '{"success":true, "message":"Logout successful"}';
}

function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}

function getCurrentUserType() {
    return $_SESSION['user_type'] ?? null;
}

// Redirect to login page if user is not logged in
function ensureLoggedIn() {
    if (!isLoggedIn()) {
        echo '{"success":false, message:"You must be logged in"}';
        header('Location: /amis-project-/pages/login.php');
        exit();
    }
}
?>
