<?php
session_start();

function isLoggedIn($user_types) {
    if (isset($_SESSION['user_id'])) {
        if(in_array($_SESSION['user_type'],$user_types))
        return true;
    }
    return false;
}

function login($user_id, $email, $username, $user_type) {
    $_SESSION['user_id'] = $user_id;
    $_SESSION['email'] = $email;
    $_SESSION['username'] = $username;
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
function ensureLoggedIn($authorized_users) {
    if (!isLoggedIn($authorized_users)) {
        echo '{"success":false, message:"You must be logged in"}';
        header('Location: /amis-project-/pages/login.php');
        exit();
    }
}
?>
