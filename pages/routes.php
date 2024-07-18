<?php
include_once("../config/config.php");
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
        case 'update-forex':
            isLoggedIn() ? updateForex() : '';
            echo isLoggedIn() ? '' : $m;
            break;
        case 'fetch-forex':
            isLoggedIn() ? fetchForex() : '';
            echo isLoggedIn() ? '' : $m;
            break;
        case 'get-yields':
            isLoggedIn() ? getYields() : '';
            echo isLoggedIn() ? '' : $m;
            break;
        case 'get-yield':
            isLoggedIn() ? getYield() : '';
            echo isLoggedIn() ? '' : $m;
            break;
        case 'add-yield':
            isLoggedIn() ? addYield() : '';
            echo isLoggedIn() ? '' : $m;
            break;
        case 'update-yield':
            isLoggedIn() ? updateYield() : '';
            echo isLoggedIn() ? '' : $m;
            break;
        case 'delete-yield':
            isLoggedIn() ? deleteYield() : '';
            echo isLoggedIn() ? '' : $m;
            break;
        case 'get-feedback':
            isLoggedIn() ? getAllFeedback() : '';
            echo isLoggedIn() ? '' : $m;
            break;
        case 'get-feedback-buyer':
            isLoggedIn() ? getFeedbackByBuyer() : '';
            echo isLoggedIn() ? '' : $m;
            break;
        case 'get-feedback-farmer':
            isLoggedIn() ? getFeedbackByFarmer() : '';
            echo isLoggedIn() ? '' : $m;
            break;
        case 'add-feedback':
            isLoggedIn() ? addFeedback() : '';
            echo isLoggedIn() ? '' : $m;
            break;
        case 'update-feedback':
            isLoggedIn() ? updateFeedback() : '';
            echo isLoggedIn() ? '' : $m;
            break;
        case 'delete-feedback':
            isLoggedIn() ? deleteFeedback() : '';
            echo isLoggedIn() ? '' : $m;
            break;
        case 'get-crop-market-price':
            isLoggedIn() ? getCropMarketPrice() : '';
            echo isLoggedIn() ? '' : $m;
            break;

        case 'get-market-prices':
            isLoggedIn() ? getMarketPrices() : '';
            echo isLoggedIn() ? '' : $m;
            break;

        case 'update-crop-market-price':
            isLoggedIn() ? updateCropMarketPrice() : '';
            echo isLoggedIn() ? '' : $m;
            break;

        case 'add-crop-market-price':
            isLoggedIn() ? addCropMarketPrice() : '';
            echo isLoggedIn() ? '' : $m;
            break;
        case 'get-compliance-certificates':
            isLoggedIn() ? getComplianceCertificates() : '';
            echo isLoggedIn() ? '' : $m;
            break;

        case 'update-certificate':
            isLoggedIn() ? updateCertificate() : '';
            echo isLoggedIn() ? '' : $m;
            break;

        case 'get-farmer-compliance-certificate':
            isLoggedIn() ? getFarmerComplianceCertificate() : '';
            echo isLoggedIn() ? '' : $m;
            break;
        case 'add-transaction':
            isLoggedIn() ? addTransaction() : '';
            echo isLoggedIn() ? '' : $m;
            break;

        case 'update-transaction':
            isLoggedIn() ? updateTransaction() : '';
            echo isLoggedIn() ? '' : $m;
            break;

        case 'get-transaction':
            isLoggedIn() ? getTransaction() : '';
            echo isLoggedIn() ? '' : $m;
            break;
        case 'verify-transactions':
            isLoggedIn() ? verifyTransactions() : '';
            echo isLoggedIn() ? '' : $m;
            break;
        case 'get-all-orders':
            isLoggedIn() ? getAllOrders() : '';
            echo isLoggedIn() ? '' : $m;
            break;

        case 'get-orders-by-crop':
            isLoggedIn() ? getOrdersByCrop() : '';
            echo isLoggedIn() ? '' : $m;
            break;

        case 'get-orders-by-farmer':
            isLoggedIn() ? getOrdersByFarmer() : '';
            echo isLoggedIn() ? '' : $m;
            break;

        case 'get-orders-by-buyer':
            isLoggedIn() ? getOrdersByBuyer() : '';
            echo isLoggedIn() ? '' : $m;
            break;

        case 'add-order':
            isLoggedIn() ? addOrder() : '';
            echo isLoggedIn() ? '' : $m;
            break;

        case 'update-order':
            isLoggedIn() ? updateOrder() : '';
            echo isLoggedIn() ? '' : $m;
            break;

        case 'update-order-status':
            isLoggedIn() ? updateOrderStatus() : '';
            echo isLoggedIn() ? '' : $m;
            break;
        case 'add-crop-demand':
            isLoggedIn() ? addCropDemand() : '';
            echo isLoggedIn() ? '' : $m;
            break;

        case 'get-crop-demand':
            isLoggedIn() ? getCropDemand() : '';
            echo isLoggedIn() ? '' : $m;
            break;

        case 'get-demand-trends':
            isLoggedIn() ? getDemandTrends() : '';
            echo isLoggedIn() ? '' : $m;
            break;

        case 'add-crop-market-trend':
            isLoggedIn() ? addCropMarketTrend() : '';
            echo isLoggedIn() ? '' : $m;
            break;

        case 'get-crop-market-trend':
            isLoggedIn() ? getCropMarketTrend() : '';
            echo isLoggedIn() ? '' : $m;
            break;

        case 'get-market-trends':
            isLoggedIn() ? getMarketTrends() : '';
            echo isLoggedIn() ? '' : $m;
            break;

        case 'add-message':
            isLoggedIn() ? addMessage() : '';
            echo isLoggedIn() ? '' : $m;
            break;

        case 'view-messages':
            isLoggedIn() ? viewMessages() : '';
            echo isLoggedIn() ? '' : $m;
            break;

        case 'view-my-messages':
            isLoggedIn() ? viewMyMessages() : '';
            echo isLoggedIn() ? '' : $m;
            break;
    }
}

function getUserTypeId($user_type)
{
    switch ($user_type) {
        case 'farmer':
            return 1;
        case 'buyer':
            return 2;
        case 'government':
            return 3;
        case 'transporter':
            return 4;
        case 'marketing':
            return 5;
        case 'admin':
            return 6;
        default:
            return 0; // Or throw an exception or return null
    }
}
function handleLogin()
{
    global $conn;

    $username = $_POST['username'];
    $password = md5($_POST['password']); // MD5 hash
    $user_type = $_POST['user_type'];

    $user_type = stripslashes($user_type);
    $sql = "SELECT * FROM $user_type WHERE username = ? AND account_status='active'";
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
    $enable_2fa = isset($_POST['enable_2fa']) && $_POST['enable_2fa'] === 'true';
    $account_status = 'suspended';
    $stmt = null;
    // Check if 2FA is enabled and set
    if ($enable_2fa) {
        // Generate a random 6-digit code
        $code = rand(100000, 999999);

        // Insert code into two_factor_auth table
        $insertQuery = "INSERT INTO two_factor_auth (user_email, user_type_id, code, status) VALUES (?, ?, ?, 'pending')";
        $insertStmt = $conn->prepare($insertQuery);
        $user_type_id = getUserTypeId($user_type);
        $insertStmt->bind_param('sis', $email, $user_type_id, $code);

        // Execute the 2FA insert query
        if ($insertStmt->execute()) {
            // Send email or notification with the code
            sendMessage($email, $code); // Example function to send email

            echo json_encode(['success' => true, 'message' => 'A code sent to your email for verification. The code expires after 5 minutes']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error inserting 2FA code: ' . $insertStmt->error]);
            exit();
        }

        $insertStmt->close();
    }
    // Proceed with normal registration
    $account_status = $enable_2fa ? 'suspended' : 'active';
    switch ($user_type) {
        case 'farmer':
            $location = $_POST['location'];
            $phone = $_POST['phone'];
            $query = "INSERT INTO farmer (username, email, password, location, phone, account_status) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sssss', $username, $email, $password, $location, $phone, $account_status);
            break;
        case 'buyer':
            $phone = $_POST['phone'];
            $query = "INSERT INTO buyer (username, email, password, phone, account_status) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ssss', $username, $email, $password, $phone, $account_status);
            break;
        case 'government':
            $location = $_POST['location'];
            $phone = $_POST['phone'];
            $query = "INSERT INTO government (username, email, password, location, phone, account_status) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sssss', $username, $email, $password, $location, $phone, $account_status);
            break;
        case 'transporter':
            $phone = $_POST['phone'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $availability = $_POST['availability'];
            $query = "INSERT INTO transporter (username, email, password, phone, description, price, availability, account_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sssssss', $username, $email, $password, $phone, $description, $price, $availability, $account_status);
            break;
        case 'marketing':
            $company = $_POST['company'];
            $phone = $_POST['phone'];
            $query = "INSERT INTO marketing (username, email, password, company, phone, account_status) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sssss', $username, $email, $password, $company, $phone, $account_status);
            break;
        case 'admin':
            $id_number = $_POST['id_number'];
            $query = "INSERT INTO admin (username, email, password, id_number, account_status) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ssss', $username, $email, $password, $id_number, $account_status);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid user type']);
            return;
    }

    // Execute the user insert query
    if ($stmt && $stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Registration successful!']);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
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
function updateForex(bool $display_logs = true)
{
    global $conn;

    $apiUrl = FOREX_2_BASE_URL;
    $ch = curl_init($apiUrl);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Set a timeout (in seconds)
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch) && $display_logs) {
        echo json_encode(['success' => false, 'message' => 'Error fetching exchange rates. ' . curl_error($ch)]);
    } else {
        $data = json_decode($response, true);

        if (isset($data['results'])) {
            $date = $data['updated'];
            $usd = 1 / $data['results']['USD'];
            $gbp = 1 / $data['results']['GBP'];
            $eur = 1 / $data['results']['EUR'];
            $cad = 1 / $data['results']['CAD'];

            $query = "INSERT INTO forex (date, usd, gbp, eur, cad) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sdddd', $date, $usd, $gbp, $eur, $cad);

            if ($stmt && $stmt->execute() && $display_logs) {
                echo json_encode(['success' => true, 'message' => 'Forex update successful!']);
            } else {
                if ($display_logs)
                    echo json_encode(['success' => false, 'message' => $stmt->error]);
            }
            $stmt->close();
        } else if (isset($data['error']) && $display_logs) {
            echo json_encode(['success' => false, 'message' => $data['error']]);
        } else {
            if ($display_logs)
                echo json_encode(['success' => false, 'message' => 'Error fetching exchange rates']);
        }
    }
    curl_close($ch);
}

function fetchForex()
{
    //updateForex(false);
    global $conn;

    $query = "SELECT * FROM forex ORDER BY forex_id DESC LIMIT 1";
    $stmt = $conn->prepare($query);

    if ($stmt && $stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $forex = $result->fetch_assoc();
            $filteredForex = [
                'date' => $forex['date'],
                'usd' => $forex['usd'],
                'gbp' => $forex['gbp'],
                'eur' => $forex['eur'],
                'cad' => $forex['cad']
            ];
            echo json_encode(['success' => true, 'forex' => $filteredForex]);
        } else {
            // Return default values if no records found
            $defaultForex = [
                'date' => date('Y-m-d'),
                'usd' => 100,
                'gbp' => 100,
                'eur' => 100,
                'cad' => 100
            ];
            echo json_encode(['success' => true, 'forex' => $defaultForex]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }

    $stmt->close();
}

function getYields()
{
    global $conn;
    $query = "SELECT y.yield_id, f.username, c.cropname, y.quantity, y.harvest_date FROM yields as y JOIN farmer as f ON y.farmer_id=f.farmer_id JOIN crops as c ON y.crop_id = c.crop_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $yields = [];
        while ($row = $result->fetch_assoc()) {
            $yields[] = $row;
        }
        echo json_encode(['success' => true, 'yields' => $yields]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No yields found']);
    }
}
function getYield()
{
    global $conn;
    $farmer_id = $_POST['farmer_id'];
    $query = "SELECT y.yield_id, c.cropname, y.quantity, y.harvest_date FROM yields as y JOIN crops as c ON y.crop_id = c.crop_id WHERE y.farmer_id = $farmer_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $yields = [];
        while ($row = $result->fetch_assoc()) {
            $yields[] = $row;
        }
        echo json_encode(['success' => true, 'yields' => $yields]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No yields found']);
    }
}

function deleteYield()
{
    global $conn;
    $yield_id = $_POST['yield_id'];
    $farmer_id = $_POST['farmer_id'];
    $query = "DELETE FROM yields WHERE yield_id = ? AND farmer_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $yield_id, $farmer_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Yield deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting yield: ' . $stmt->error]);
    }
    $stmt->close();
}

function updateYield()
{
    global $conn;
    $yield_id = $_POST['yield_id'];
    $farmer_id = $_POST['farmer_id'];
    $crop_id = $_POST['crop_id'];
    $quantity = $_POST['quantity'];
    $harvest_date = $_POST['harvest_date'];
    $query = "UPDATE yields SET crop_id = ?, quantity = ?, harvest_date = ? WHERE yield_id = ? AND farmer_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iisii', $crop_id, $quantity, $harvest_date, $yield_id, $farmer_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Yield updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating yield: ' . $stmt->error]);
    }
    $stmt->close();
}

function addYield()
{
    global $conn;
    $farmer_id = $_POST['farmer_id'];
    $crop_id = $_POST['crop_id'];
    $quantity = $_POST['quantity'];
    $harvest_date = $_POST['harvest_date'];
    $query = "INSERT INTO yields (farmer_id, crop_id, quantity, harvest_date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iiis', $farmer_id, $crop_id, $quantity, $harvest_date);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Yield added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error adding yield: ' . $stmt->error]);
    }
    $stmt->close();
}

function getFeedbackByBuyer()
{
    global $conn;
    $buyer_id = $_POST['buyer_id'];
    $query = "SELECT * FROM customer_feedback WHERE buyer_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $buyer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $feedbacks = [];
    while ($row = $result->fetch_assoc()) {
        $feedbacks[] = $row;
    }

    echo json_encode(['success' => true, 'feedbacks' => $feedbacks]);
}

function getFeedbackByFarmer()
{
    global $conn;
    $farmer_id = $_POST['farmer_id'];
    $query = "SELECT * FROM customer_feedback WHERE farmer_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $farmer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $feedbacks = [];
    while ($row = $result->fetch_assoc()) {
        $feedbacks[] = $row;
    }

    echo json_encode(['success' => true, 'feedbacks' => $feedbacks]);
}

function getAllFeedback()
{
    global $conn;
    $query = "SELECT * FROM customer_feedback";
    $result = $conn->query($query);

    $feedbacks = [];
    while ($row = $result->fetch_assoc()) {
        $feedbacks[] = $row;
    }

    echo json_encode(['success' => true, 'feedbacks' => $feedbacks]);
}

function deleteFeedback()
{
    global $conn;
    $feedback_id = $_POST['feedback_id'];
    $buyer_id = $_POST['buyer_id'];
    $query = "DELETE FROM customer_feedback WHERE feedback_id = ? AND buyer_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $feedback_id, $buyer_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Feedback deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting feedback']);
    }
}

function addFeedback()
{
    global $conn;
    $buyer_id = $_POST['buyer_id'];
    $farmer_id = $_POST['farmer_id'];
    $feedback = $_POST['feedback'];
    $date = $_POST['date'];
    $query = "INSERT INTO customer_feedback (buyer_id, farmer_id, feedback, date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iiss', $buyer_id, $farmer_id, $feedback, $date);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Feedback added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error adding feedback']);
    }
}

function updateFeedback()
{
    global $conn;
    $feedback_id = $_POST['feedback_id'];
    $buyer_id = $_POST['buyer_id'];
    $farmer_id = $_POST['farmer_id'];
    $feedback = $_POST['feedback'];
    $date = $_POST['date'];
    $query = "UPDATE customer_feedback SET farmer_id = ?, feedback = ?, date = ? WHERE feedback_id = ? AND buyer_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('issii', $farmer_id, $feedback, $date, $feedback_id, $buyer_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Feedback updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating feedback']);
    }
}

function getCropMarketPrice()
{
    global $conn;
    $crop_id = $_POST['crop_id'];

    $query = "SELECT * FROM market_prices WHERE crop_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $crop_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $market_prices = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'data' => $market_prices]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching market prices: ' . $stmt->error]);
    }
    $stmt->close();
}

function getMarketPrices()
{
    global $conn;

    $query = "SELECT * FROM market_prices";
    $result = $conn->query($query);

    if ($result) {
        $market_prices = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'data' => $market_prices]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching market prices: ' . $conn->error]);
    }
}

function updateCropMarketPrice()
{
    global $conn;
    $price_id = $_POST['price_id'];
    $crop_id = $_POST['crop_id'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $date = $_POST['date'];

    $query = "UPDATE market_prices SET crop_id = ?, price = ?, status = ?, date = ? WHERE price_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('idssi', $crop_id, $price, $status, $date, $price_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Market price updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating market price: ' . $stmt->error]);
    }
    $stmt->close();
}

function addCropMarketPrice()
{
    global $conn;
    $crop_id = $_POST['crop_id'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $date = $_POST['date'];

    $query = "INSERT INTO market_prices (crop_id, price, status, date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('idss', $crop_id, $price, $status, $date);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Market price added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error adding market price: ' . $stmt->error]);
    }
    $stmt->close();
}

function getComplianceCertificates()
{
    global $conn;
    $query = "SELECT * FROM compliance_certificates";
    $result = $conn->query($query);

    $certificates = [];
    while ($row = $result->fetch_assoc()) {
        $certificates[] = $row;
    }

    echo json_encode(['success' => true, 'data' => $certificates]);
}

// Function to approve a compliance certificate
function updateCertificate()
{
    global $conn;

    $certificate_id = $_POST['certificate_id'];
    $status = $_POST['status'];
    $approved_by = $_POST['approved_by'];

    $query = "UPDATE compliance_certificates SET status = ?, approved_by = ? WHERE certificate_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sii', $status, $approved_by, $certificate_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Certificate updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating certificate: ' . $stmt->error]);
    }

    $stmt->close();
}

function getFarmerComplianceCertificate()
{
    global $conn;
    $farmer_id = $_POST['farmer_id'];

    $query = "SELECT * FROM compliance_certificates WHERE farmer_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $farmer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $certificates = [];
    while ($row = $result->fetch_assoc()) {
        $certificates[] = $row;
    }

    echo json_encode(['success' => true, 'data' => $certificates]);

    $stmt->close();
}

function addTransaction()
{
    global $conn;

    $farmer_id = $_POST['farmer_id'];
    $transaction_code = $_POST['transaction_code'];
    $status = 'pending';
    $date = $_POST['date'];

    $query = "INSERT INTO transactions (farmer_id, transaction_code, status, date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('isss', $farmer_id, $transaction_code, $status, $date);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Transaction added successfully. Status: pending']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error adding transaction: ' . $stmt->error]);
    }

    $stmt->close();
}

function updateTransaction()
{
    global $conn;

    $transaction_id = $_POST['transaction_id'];
    $farmer_id = $_POST['farmer_id'];
    $status = $_POST['status'];

    $query = "UPDATE transactions SET status = ? WHERE transaction_id = ? AND farmer_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sii', $status, $transaction_id, $farmer_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Transaction updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating transaction: ' . $stmt->error]);
    }

    $stmt->close();
}

function getTransaction()
{
    global $conn;

    $farmer_id = $_POST['farmer_id'];

    $query = "SELECT * FROM transactions WHERE farmer_id = ? ORDER BY date DESC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $farmer_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $transaction = $result->fetch_assoc();

        if ($transaction) {
            echo json_encode(['success' => true, 'transaction' => $transaction]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Transaction not found']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching transaction: ' . $stmt->error]);
    }

    $stmt->close();
}

function verifyTransactions()
{
    global $conn;

    $today = date('Y-m-d');
    $pattern = '/^[A-Z]{3}[0-9][A-Z0-9]{6}$/';

    // Select all transactions
    $query = "SELECT transaction_id, date, transaction_code, status FROM transactions";
    $stmt = $conn->prepare($query);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $transactions = $result->fetch_all(MYSQLI_ASSOC);

        foreach ($transactions as $transaction) {
            $transaction_id = $transaction['transaction_id'];
            $date = $transaction['date'];
            $transaction_code = $transaction['transaction_code'];
            $new_status = 'valid';

            if ($date !== $today) {
                $new_status = 'expired';
            }

            // Check if the transaction code does not match the pattern
            if (!preg_match($pattern, $transaction_code)) {
                $new_status = 'rejected';
            }

            // Update the transaction status if needed
            if ($new_status !== 'valid' || $transaction['status'] === 'pending' || !($transaction['status'] === 'valid' && $new_status === 'valid')) {
                $updateQuery = "UPDATE transactions SET status = ? WHERE transaction_id = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param('si', $new_status, $transaction_id);

                if (!$updateStmt->execute()) {
                    echo json_encode(['success' => false, 'message' => 'Error updating transaction status: ' . $updateStmt->error]);
                    $updateStmt->close();
                    return;
                }

                $updateStmt->close();
            }
        }

        echo json_encode(['success' => true, 'message' => 'Transactions verified and updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching transactions: ' . $stmt->error]);
    }

    $stmt->close();
}

// Function to get all orders
function getAllOrders()
{
    global $conn;

    $query = "SELECT * FROM orders";
    $result = $conn->query($query);

    if ($result) {
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'orders' => $orders]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching orders: ' . $conn->error]);
    }
}

// Function to get orders by crop
function getOrdersByCrop()
{
    global $conn;

    $crop_id = $_POST['crop_id'];

    $query = "SELECT * FROM orders WHERE crop_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $crop_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'orders' => $orders]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching orders by crop: ' . $stmt->error]);
    }

    $stmt->close();
}

// Function to get orders by farmer
function getOrdersByFarmer()
{
    global $conn;

    $farmer_id = $_POST['farmer_id'];

    $query = "SELECT * FROM orders WHERE farmer_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $farmer_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'orders' => $orders]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching orders by farmer: ' . $stmt->error]);
    }

    $stmt->close();
}

// Function to get orders by buyer
function getOrdersByBuyer()
{
    global $conn;

    $buyer_id = $_POST['buyer_id'];

    $query = "SELECT * FROM orders WHERE buyer_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $buyer_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'orders' => $orders]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching orders by buyer: ' . $stmt->error]);
    }

    $stmt->close();
}

// Function to add a new order
function addOrder()
{
    global $conn;

    $farmer_id = $_POST['farmer_id'];
    $buyer_id = $_POST['buyer_id'];
    $crop_id = $_POST['crop_id'];
    $quantity = $_POST['quantity'];
    $today = date('Y-m-d');
    $status = 'pending'; // Default status

    $query = "INSERT INTO orders (farmer_id, buyer_id, crop_id, quantity, date, status) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iiiiss', $farmer_id, $buyer_id, $crop_id, $quantity, $today, $status);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Order added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error adding order: ' . $stmt->error]);
    }

    $stmt->close();
}

// Function to update an existing order
function updateOrder()
{
    global $conn;

    $order_id = $_POST['order_id'];
    $quantity = $_POST['quantity'];

    $query = "UPDATE orders SET quantity = ? WHERE order_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $quantity, $order_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Order updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating order: ' . $stmt->error]);
    }

    $stmt->close();
}

// Function to update order status
function updateOrderStatus()
{
    global $conn;

    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $query = "UPDATE orders SET status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $status, $order_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Order status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating order status: ' . $stmt->error]);
    }

    $stmt->close();
}

function addCropDemand()
{
    global $conn;

    $crop_id = $_POST['crop_id'];
    $date = date('Y-m-d');

    // First, retrieve the current demand value for the crop
    $selectQuery = "SELECT demand FROM demand_trends WHERE crop_id = ? ORDER BY date DESC LIMIT 1";
    $selectStmt = $conn->prepare($selectQuery);
    $selectStmt->bind_param('i', $crop_id);

    if ($selectStmt && $selectStmt->execute()) {
        $selectStmt->bind_result($currentDemand);
        $selectStmt->fetch();
        $selectStmt->close();

        // If no record exists, set currentDemand to 0
        if (!isset($currentDemand)) {
            $currentDemand = 0;
        }

        // Calculate the new demand value
        $newDemand = $currentDemand + 1;

        // Insert or update the demand value into the database
        $insertQuery = "INSERT INTO demand_trends (crop_id, demand, date) VALUES (?, ?, ?)
                        ON DUPLICATE KEY UPDATE demand = ?";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param('iisi', $crop_id, $newDemand, $date, $newDemand);

        if ($insertStmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Crop demand incremented successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error incrementing crop demand: ' . $insertStmt->error]);
        }

        $insertStmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching current demand: ' . $conn->error]);
    }
}

// Function to get crop demand by crop_id
function getCropDemand()
{
    global $conn;

    $crop_id = $_POST['crop_id'];

    $query = "SELECT * FROM demand_trends WHERE crop_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $crop_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $demand_trends = $result->fetch_all(MYSQLI_ASSOC);

        if (!empty($demand_trends)) {
            echo json_encode(['success' => true, 'demand_trends' => $demand_trends]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No demand trends found for this crop']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching demand trends: ' . $stmt->error]);
    }

    $stmt->close();
}

// Function to get all demand trends
function getDemandTrends()
{
    global $conn;

    $query = "SELECT * FROM demand_trends";
    $result = $conn->query($query);

    if ($result) {
        $demand_trends = $result->fetch_all(MYSQLI_ASSOC);

        if (!empty($demand_trends)) {
            echo json_encode(['success' => true, 'demand_trends' => $demand_trends]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No demand trends found']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching demand trends: ' . $conn->error]);
    }
}

function addCropMarketTrend()
{
    global $conn;

    $crop_id = $_POST['crop_id'];
    $price = $_POST['price'];
    $date = date('Y-m-d');

    // Insert or update the market trend for the crop
    $insertQuery = "INSERT INTO market_trends (crop_id, price, date) VALUES (?, ?, ?)
                        ON DUPLICATE KEY UPDATE price = ?";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param('idsd', $crop_id, $price, $date, $price);

    if ($insertStmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Crop market trend updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating crop market trend: ' . $insertStmt->error]);
    }

    $insertStmt->close();
}

function getCropMarketTrend()
{
    global $conn;

    $crop_id = $_POST['crop_id'];

    // Retrieve the latest market trend for the crop
    $query = "SELECT * FROM market_trends WHERE crop_id = ? ORDER BY date DESC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $crop_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $marketTrend = $result->fetch_assoc();

        if ($marketTrend) {
            echo json_encode(['success' => true, 'market_trend' => $marketTrend]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Market trend not found for the crop']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching market trend: ' . $stmt->error]);
    }

    $stmt->close();
}

function getMarketTrends()
{
    global $conn;

    // Retrieve all market trends
    $query = "SELECT * FROM market_trends";
    $stmt = $conn->prepare($query);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $marketTrends = $result->fetch_all(MYSQLI_ASSOC);

        if ($marketTrends) {
            echo json_encode(['success' => true, 'market_trends' => $marketTrends]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No market trends found']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching market trends: ' . $stmt->error]);
    }

    $stmt->close();
}

function addMessage()
{
    global $conn;

    $message_text = $_POST['message_text'];
    $sender_id = $_POST['sender_id'];
    $receiver_id = $_POST['receiver_id'];

    $query = "INSERT INTO messages (message_text, sender_id, receiver_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sii', $message_text, $sender_id, $receiver_id);

    if ($stmt->execute()) {
        //actual sending
        echo json_encode(['success' => true, 'message' => 'Message added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error adding message: ' . $stmt->error]);
    }

    $stmt->close();
}

function viewMessages()
{
    global $conn;

    $query = "SELECT * FROM messages ORDER BY sent_at DESC";
    $result = $conn->query($query);

    if ($result) {
        $messages = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'messages' => $messages]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching messages: ' . $conn->error]);
    }
}

function viewMyMessages()
{
    global $conn;

    $receiver_id = $_POST['receiver_id'];

    $query = "SELECT * FROM messages WHERE receiver_id = ? ORDER BY sent_at DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $receiver_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $messages = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'messages' => $messages]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching messages: ' . $stmt->error]);
    }

    $stmt->close();
}

function verifyTwoFactorAuth()
{
    global $conn;

    $user_id = $_POST['user_id'];
    $user_type_id = $_POST['user_type_id'];
    $code = $_POST['code'];

    // Query to fetch the authentication record
    $query = "SELECT * FROM two_factor_auth WHERE user_id = ? AND user_type_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $user_id, $user_type_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $auth = $result->fetch_assoc();
            $auth_id = $auth['auth_id'];
            $status = $auth['status'];
            $created_at = new DateTime($auth['sent_at']);
            $now = new DateTime();
            $interval = $created_at->diff($now);

            // Check if the code has expired (more than 5 minutes)
            if ($interval->i > 5) {
                $expireQuery = "UPDATE two_factor_auth SET status = 'expired' WHERE auth_id = ?";
                $expireStmt = $conn->prepare($expireQuery);
                $expireStmt->bind_param('i', $auth_id);

                if ($expireStmt->execute()) {
                    echo json_encode(['success' => false, 'message' => 'Authentication code expired']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error expiring authentication code: ' . $expireStmt->error]);
                }

                $expireStmt->close();
            } else {
                // Check if the code matches
                if ($code === $auth['code']) {
                    // Expire the code after successful verification
                    $updateQuery = "UPDATE two_factor_auth SET status = 'expired' WHERE auth_id = ?";
                    $updateStmt = $conn->prepare($updateQuery);
                    $updateStmt->bind_param('i', $auth_id);
                    if ($updateStmt->execute()) {
                        echo json_encode(['success' => true, 'message' => 'Two-factor authentication verified successfully']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Error expiring authentication status: ' . $updateStmt->error]);
                    }

                    $updateStmt->close();
                } else {
                    // Code does not match, update status to 'rejected'
                    $rejectQuery = "UPDATE two_factor_auth SET status = 'rejected' WHERE auth_id = ?";
                    $rejectStmt = $conn->prepare($rejectQuery);
                    $rejectStmt->bind_param('i', $auth_id);

                    if ($rejectStmt->execute()) {
                        echo json_encode(['success' => false, 'message' => 'Invalid authentication code']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Error rejecting authentication code: ' . $rejectStmt->error]);
                    }

                    $rejectStmt->close();
                }
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Authentication record not found']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching authentication record: ' . $stmt->error]);
    }

    $stmt->close();
}
