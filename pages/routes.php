<?php
include('../includes/db_connect.php');
include('../includes/auth.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $m = json_encode(array('success' => false, 'message' => 'You must be logged in'));
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
        case 'add-crop':
            isLoggedIn() ? addCrop() : '';
            echo isLoggedIn() ? '' : $m;
            break;
        case 'delete-crop':
            isLoggedIn() ? deleteCrop() : '';
            echo isLoggedIn() ? '' : $m;
            break;
        case 'update-crop':
            isLoggedIn() ? updateCrop() : '';
            echo isLoggedIn() ? '' : $m;
            break;
        case 'get-crop':
            isLoggedIn() ? getCrops() : '';
            echo isLoggedIn() ? '' : $m;
            break;
    }
}

function handleLogin()
{
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
            $id = reset($user);
            login($id, $username . '-' . $user_type);
            echo '{"success":true, "message": "login successful"}';
        } else {
            echo '{"success":false, "message": "Invalid password"}';
        }
    } else {
        echo '{"success":false, "message": "Invalid username or user type"}';
    }

    $stmt->close();
}


function handleRegister()
{
    global $conn;

    $user_type = $_POST['user_type'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // MD5 hash

    $query = "";
    $stmt = null;

    $user_type = stripslashes($user_type);

    switch ($user_type) {
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
            echo '{"success":false, "message":"Invalid user type"}';
            return;
    }

    if ($stmt && $stmt->execute()) {
        echo '{"success":true, "message":"Registration successful!"}';
    } else {
        echo '{"success":false, "message": "' . $stmt->error . '"}';
    }
    $stmt->close();
}

function handleLogout()
{
    logout();
    header("Location: /amis-project-/pages/login.php");
    exit();
}

function addCrop()
{
    global $conn;

    $cropname = $_POST['cropname'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $query = "INSERT INTO crops (cropname, description, price) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sss', $cropname, $description, $price);

    if ($stmt && $stmt->execute()) {
        echo '{"success":true, "message":"Crop added successful!"}';
    } else {
        echo '{"success":false, "message": "' . $stmt->error . '"}';
    }
    $stmt->close();
}

function deleteCrop()
{
    global $conn;
    $cropname = $_POST['cropname'];

    // Prepare the SELECT query
    $query = "SELECT * FROM crops WHERE cropname = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $cropname);

    if ($stmt && $stmt->execute()) {
        $result = $stmt->get_result();

        // Check if there is exactly one record
        if ($result->num_rows == 1) {
            $crop = $result->fetch_assoc();
            $crop_id = $crop['crop_id'];

            // Prepare the DELETE query
            $query = "DELETE FROM crops WHERE crop_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s', $crop_id);

            if ($stmt && $stmt->execute()) {
                echo '{"success":true, "message":"Crop deleted successfully!"}';
            } else {
                echo '{"success":false, "message": "' . $stmt->error . '"}';
            }
        } else if ($result->num_rows == 0) {
            echo '{"success":false, "message": "No record found"}';
        } else {
            echo '{"success":false, "message": "Multiple records exist"}';
        }
    } else {
        echo '{"success":false, "message": "' . $stmt->error . '"}';
    }

    // Close the statement
    $stmt->close();
}

function updateCrop()
{
    global $conn;
    $cropname = $_POST['cropname'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Prepare the SELECT query
    $query = "SELECT * FROM crops WHERE cropname = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $cropname);

    if ($stmt && $stmt->execute()) {
        $result = $stmt->get_result();

        // Check if there is exactly one record
        if ($result->num_rows == 1) {
            $crop = $result->fetch_assoc();
            $crop_id = $crop['crop_id'];

            // Prepare the UPDATE query
            $query = "UPDATE crops SET description = ?, price = ? WHERE crop_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sss', $description, $price, $crop_id);

            if ($stmt && $stmt->execute()) {
                echo '{"success":true, "message":"Crop updated successfully!"}';
            } else {
                echo '{"success":false, "message": "' . $stmt->error . '"}';
            }
        } else if ($result->num_rows == 0) {
            echo '{"success":false, "message": "No record found"}';
        } else {
            echo '{"success":false, "message": "Multiple records exist"}';
        }
    } else {
        echo '{"success":false, "message": "' . $stmt->error . '"}';
    }

    // Close the statement
    $stmt->close();
}

function getCrops()
{
    global $conn;
    $query = "SELECT * FROM crops";
    $stmt = $conn->prepare($query);

    if ($stmt && $stmt->execute()) {
        $result = $stmt->get_result();
        $crops = [];

        while ($crop = $result->fetch_assoc()) {
            $crops[] = $crop;
        }

        echo json_encode(['success' => true, 'crops' => $crops]);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }

    $stmt->close();
}


?>