<?php
include('../includes/db_connect.php');
include('../includes/auth.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($_POST['action']) {
        case 'login':
            handleLogin();
            break;
        case 'register':
            handleRegister();
            break;
        case 'logout':
            handleLogout();
            break;
    }
}

function handleLogin() {
    global $conn;

    $username = $_POST['username'];
    $password = md5($_POST['password']); // MD5 hash
    $user_type = $_POST['user_type'];

    $user_type = stripslashes($user_type);
    $sql = "SELECT * FROM $user_type WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if ($password === $user['password']) {
            $id=reset($user);
            login($id, $username.'-'.$user_type);
            header("Location: /amis-project-/pages/dashboard.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Invalid username or user type.";
    }

    $stmt->close();
}


function handleRegister() {
    global $conn;

    $user_type = $_POST['user_type'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // MD5 hash

    $query = "";
    $stmt = null;

    switch($user_type) {
        case 'farmer':
            $location = $_POST['location'];
            $phone = $_POST['phone'];
            $query = "INSERT INTO farmer (username, email, password, location, phone) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sssss', $username, $email, $password, $location, $phone);
            break;
        case 'buyer':
            $phone = $_POST['phone'];
            $query = "INSERT INTO buyer (username, email, password, phone) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ssss', $username, $email, $password, $phone);
            break;
        case 'government':
            $location = $_POST['location'];
            $phone = $_POST['phone'];
            $query = "INSERT INTO government (username, email, password, location, phone) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sssss', $username, $email, $password, $location, $phone);
            break;
        case 'transporter':
            $phone = $_POST['phone'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $availability = $_POST['availability'];
            $query = "INSERT INTO transporter (username, email, password, phone, description, price, availability) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sssssss', $username, $email, $password, $phone, $description, $price, $availability);
            break;
        case 'marketing':
            $company = $_POST['company'];
            $phone = $_POST['phone'];
            $query = "INSERT INTO marketing (username, email, password, company, phone) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sssss', $username, $email, $password, $company, $phone);
            break;
        case 'admin':
            $id_number = $_POST['id_number'];
            $query = "INSERT INTO admins (username, email, password, id_number) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sssi', $username, $email, $password, $id_number);
            break;
        default:
            echo "Invalid user type.";
            return;
    }

    if ($stmt && $stmt->execute()) {
        echo "Registration successful!";
        header("Location: /amis-project-/pages/login.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

function handleLogout() {
    logout();
    header("Location: /amis-project-/pages/login.php");
    exit();
}
?>
