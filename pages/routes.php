<?php
include_once("../config/config.php");
include('../includes/db_connect.php');
include('../includes/auth.php');
include('../lib/mailing/vendor/autoload.php');

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
        case 'get-farmers':
            $authorized_users = ['admin'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getFarmers() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'get-buyers':
            $authorized_users = ['admin'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getBuyers() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'get-transporters':
            $authorized_users = ['admin'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getTransporters() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'get-government-agencies':
            $authorized_users = ['admin'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getGovernmentAgencies() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'get-marketing-professionals':
            $authorized_users = ['admin'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getMarketingProfessionals() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'set-farmer-account-status':
            $authorized_users = ['admin'];
            $logged = isLoggedIn($authorized_users);
            if ($logged) {
                $farmer_id = isset($_POST['farmer_id']) ? intval($_POST['farmer_id']) : null;
                $status = isset($_POST['status']) ? $_POST['status'] : null;

                if ($farmer_id !== null && $status !== null) {
                    setFarmerAccountStatus($farmer_id, $status);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Invalid farmer_id or status']);
                }
            } else {
                display_login_request($logged, $authorized_users);
            }
            break;
        case 'set-buyer-account-status':
            $authorized_users = ['admin'];
            $logged = isLoggedIn($authorized_users);
            if ($logged) {
                $buyer_id = isset($_POST['buyer_id']) ? intval($_POST['buyer_id']) : null;
                $status = isset($_POST['status']) ? $_POST['status'] : null;

                if ($buyer_id !== null && $status !== null) {
                    setBuyerAccountStatus($buyer_id, $status);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Invalid buyer_id or status']);
                }
            } else {
                display_login_request($logged, $authorized_users);
            }
            break;
        case 'set-transporter-account-status':
            $authorized_users = ['admin'];
            $logged = isLoggedIn($authorized_users);
            if ($logged) {
                $transport_id = isset($_POST['transport_id']) ? intval($_POST['transport_id']) : null;
                $status = isset($_POST['status']) ? $_POST['status'] : null;

                if ($transport_id !== null && $status !== null) {
                    setTransporterAccountStatus($transport_id, $status);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Invalid transport_id or status']);
                }
            } else {
                display_login_request($logged, $authorized_users);
            }
            break;
        case 'set-government-agency-account-status':
            $authorized_users = ['admin'];
            $logged = isLoggedIn($authorized_users);
            if ($logged) {
                $agency_id = isset($_POST['government_id']) ? intval($_POST['government_id']) : null;
                $status = isset($_POST['status']) ? $_POST['status'] : null;

                if ($agency_id !== null && $status !== null) {
                    setGovernmentAgencyAccountStatus($agency_id, $status);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Invalid agency_id or status']);
                }
            } else {
                display_login_request($logged, $authorized_users);
            }
            break;
        case 'set-marketing-professional-account-status':
            $authorized_users = ['admin'];
            $logged = isLoggedIn($authorized_users);
            if ($logged) {
                $professional_id = isset($_POST['marketing_id']) ? intval($_POST['marketing_id']) : null;
                $status = isset($_POST['status']) ? $_POST['status'] : null;

                if ($professional_id !== null && $status !== null) {
                    setMarketingProfessionalAccountStatus($professional_id, $status);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Invalid professional_id or status']);
                }
            } else {
                display_login_request($logged, $authorized_users);
            }
            break;

        case 'add-crop':
            $authorized_users = ['farmer', 'admin'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? addCrop() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'delete-crop':
            $authorized_users = ['admin'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? deleteCrop() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'update-crop':
            $authorized_users = ['admin'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? updateCrop() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'get-crops':
            $authorized_users = ['farmer', 'admin', 'buyer', 'government'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getCrops() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'get-crop':
            $authorized_users = ['farmer', 'admin', 'buyer'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getCrop() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'update-forex':
            $authorized_users = ['admin'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? updateForex() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'fetch-forex':
            $authorized_users = ['farmer', 'admin', 'buyer', 'government', 'marketing'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? fetchForex() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'get-yields':
            $authorized_users = ['farmer'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getYields() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'get-yield':
            $authorized_users = ['farmer'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getYield() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'add-yield':
            $authorized_users = ['farmer'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? addYield() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'update-yield':
            $authorized_users = ['farmer'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? updateYield() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'delete-yield':
            $authorized_users = ['farmer'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? deleteYield() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'get-feedback':
            $authorized_users = ['farmer'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getAllFeedback() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'get-feedback-buyer':
            $authorized_users = ['farmer'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getFeedbackByBuyer() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'get-feedback-farmer':
            $authorized_users = ['farmer'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getFeedbackByFarmer() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'add-feedback':
            $authorized_users = ['farmer'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? addFeedback() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'update-feedback':
            $authorized_users = ['farmer'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? updateFeedback() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'delete-feedback':
            $authorized_users = ['farmer'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? deleteFeedback() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'get-crop-market-price':
            $authorized_users = ['farmer', 'admin', 'buyer', 'government', 'marketing'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getCropMarketPrice() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'get-market-prices':
            $authorized_users = ['admin', 'farmer', 'buyer', 'government'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getMarketPrices() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'update-crop-market-price':
            $authorized_users = ['admin', 'government'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? updateCropMarketPrice() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'add-crop-market-price':
            $authorized_users = ['admin', 'government'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? addCropMarketPrice() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'get-compliance-certificates':
            $authorized_users = ['farmer'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getComplianceCertificates() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'update-certificate':
            $authorized_users = ['farmer'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? updateCertificate() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'get-farmer-compliance-certificate':
            $authorized_users = ['farmer'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getFarmerComplianceCertificate() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'add-transaction':
            $authorized_users = ['farmer'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? addTransaction() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'update-transaction':
            $authorized_users = ['farmer'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? updateTransaction() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'get-transaction':
            $authorized_users = ['farmer'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getTransaction() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'verify-transactions':
            $authorized_users = ['farmer'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? verifyTransactions() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'get-units':
            $authorized_users = ['admin', 'buyer', 'farmer'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getUnits() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'get-all-adverts':
            $authorized_users = ['admin', 'buyer', 'farmer'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getAllAdverts() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'get-adverts-by-farmer':
            $authorized_users = ['farmer', 'admin'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getAdvertsByFarmer() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'add-advert':
            $authorized_users = ['farmer', 'admin'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? addAdvert() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'update-advert':
            $authorized_users = ['farmer', 'admin'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? updateAdvert() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'update-advert-status':
            $authorized_users = ['farmer', 'admin'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? updateAdvertStatus() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'delete-advert':
            $authorized_users = ['farmer', 'admin'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? deleteAdvert() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'get-all-orders':
            $authorized_users = ['admin'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getAllOrders() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'get-all-customers':
            $authorized_users = ['admin', 'marketing'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getAllCustomers() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'get-orders-by-crop':
            $authorized_users = ['farmer', 'admin'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getOrdersByCrop() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'get-orders-by-farmer':
            $authorized_users = ['farmer', 'admin'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getOrdersByFarmer() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'get-orders-by-buyer':
            $authorized_users = ['buyer', 'admin'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getOrdersByBuyer() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'add-order':
            $authorized_users = ['buyer', 'admin'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? addOrder() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'update-order':
            $authorized_users = ['farmer', 'buyer', 'admin'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? updateOrder() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'update-order-status':
            $authorized_users = ['farmer', 'buyer', 'admin'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? updateOrderStatus() : '';
            display_login_request($logged, $authorized_users);
            break;
            // case 'add-crop-demand':
            //     $authorized_users = ['admin', 'buyer', 'farmer'];
            //     $logged = isLoggedIn($authorized_users);
            //     $logged  ? addCropDemand() : '';
            //     display_login_request($logged, $authorized_users);
            //     break;

        case 'get-crop-demand':
            $authorized_users = ['farmer', 'admin', 'buyer', 'government', 'marketing'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getCropDemand() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'get-demand-trends':
            $authorized_users = ['farmer', 'admin', 'buyer', 'government', 'marketing'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getDemandTrends() : '';
            display_login_request($logged, $authorized_users);
            break;

            // case 'add-crop-market-trend':
            //     $authorized_users = ['admin', 'farmer'];
            //     $logged = isLoggedIn($authorized_users);
            //     $logged  ? addCropMarketTrend() : '';
            //     display_login_request($logged, $authorized_users);
            //     break;

        case 'get-crop-market-trend':
            $authorized_users = ['farmer', 'admin', 'buyer', 'government', 'marketing'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getCropMarketTrend() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'get-market-trends':
            $authorized_users = ['farmer', 'admin', 'buyer', 'government', 'marketing'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? getMarketTrends() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'add-message':
            $authorized_users = ['admin'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? addMessage() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'view-messages':
            $authorized_users = ['admin'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? viewMessages() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'add-engagement':
            $authorized_users = ['admin', 'marketing', 'buyer'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? addEngagement() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'view-engagements':
            $authorized_users = ['admin', 'marketing', 'buyer'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? viewEngagements() : '';
            display_login_request($logged, $authorized_users);
            break;

        case 'view-my-messages':
            $authorized_users = ['farmer', 'buyer'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? viewMyMessages() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'verify-code':
            verifyTwoFactorAuth();
            break;
        case 'subscribe':
            $authorized_users = ['buyer'];
            $logged = isLoggedIn($authorized_users);
            $logged  ? subscribe() : '';
            display_login_request($logged, $authorized_users);
            break;
        case 'unsubscribe':
            $authorized_users = ['buyer'];
            $logged = isLoggedIn($authorized_users);
            $logged ? unsubscribe() : '';
            display_login_request($logged, $authorized_users);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Undefined route']);
            break;
    }
}else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
 echo "Undefined route";
}

function display_login_request($logged, $user_types)
{
    $user_types_str = implode(', ', $user_types); // Convert array to string
    $message = json_encode(array('success' => false, 'message' => 'You must be logged in as ' . $user_types_str));
    if (!$logged) {
        echo $message;
    }
}

function sendMessage($recipients, $subject, $message)
{
    // Ensure $recipients is an array, even if a single email is passed
    if (!is_array($recipients)) {
        $recipients = [$recipients];
    }

    $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, "ssl"))
        ->setUsername(SENDER_EMAIL)
        ->setPassword(SENDER_PASSWORD);

    $mailer = new Swift_Mailer($transport);

    // Create a message
    $message = (new Swift_Message($subject))
        ->setFrom([SENDER_EMAIL => 'AMIS INFO'])
        ->setTo($recipients)
        ->setBody($message, 'text/html');

    // Send the message
    try {
        $result = $mailer->send($message);
        return ['sent' => true, 'message' => 'Message sent successfully'];
    } catch (Exception $e) {
        return ['sent' => false, 'message' => $e->getMessage()];
    }
    return ['sent' => false, 'message' => 'Error sending email code'];
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

function generateVerificationCode()
{
    $length = 6;
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
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
            $email = $user['email'];
            $id = reset($user);
            login($id, $email, $username, $user_type);
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
    $enable_2fa = $_POST['enable_2fa'] === 'false' ? false : ($_POST['enable_2fa'] === 'true' ? true : $_POST['enable_2fa']);
    $account_status = 'suspended';
    $stmt = null;

    // Check if 2FA is enabled and set
    if ($enable_2fa) {
        // Generate a random 6-digit code
        $code = generateVerificationCode();

        // Insert code into two_factor_auth table
        $insertQuery = "INSERT INTO two_factor_auth (user_email, user_type_id, code) VALUES (?, ?, ?) 
                ON DUPLICATE KEY UPDATE 
                user_email = VALUES(user_email), 
                user_type_id = VALUES(user_type_id), 
                code = VALUES(code)";

        $insertStmt = $conn->prepare($insertQuery);
        $user_type_id = getUserTypeId($user_type); // Assuming a function to fetch user_type_id
        $insertStmt->bind_param('sis', $email, $user_type_id, $code);


        // Execute the 2FA insert queryc
        if ($insertStmt->execute()) {
            // Send email or notification with the code

            $sent = sendMessage([$email], 'Two-Factor Authentication Code', '
            <div style="font-family: Arial, sans-serif; padding: 20px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 10px;">
                <h2 style="color: #333;">Two-Factor Authentication Code</h2>
                <p style="font-size: 16px; color: #555;">
                    Here is your verification code:
                </p>
                <div style="text-align: center; margin: 20px 0;">
                    <h2 style="font-size: 36px; font-weight: bold;">' . $code . '</h2>
                </div>
                <p style="font-size: 16px; color: #555;">
                    It expires in 10 minutes. If you didn\'t request the code, ignore this message
                </p>
            </div>
        ');
            if ($sent['sent']) {
                echo json_encode(['success' => true, 'message' => 'A code sent to your email for verification. The code expires after 5 minutes']);
            } else {
                echo json_encode(['success' => false, 'message' => $sent['message']]);
                exit();
            }
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
            $stmt->bind_param('ssssss', $username, $email, $password, $location, $phone, $account_status);
            break;
        case 'buyer':
            $phone = $_POST['phone'];
            $query = "INSERT INTO buyer (username, email, password, phone, account_status) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sssss', $username, $email, $password, $phone, $account_status);
            break;
        case 'government':
            $location = $_POST['location'];
            $phone = $_POST['phone'];
            $query = "INSERT INTO government (username, email, password, location, phone, account_status) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ssssss', $username, $email, $password, $location, $phone, $account_status);
            break;
        case 'transporter':
            $phone = $_POST['phone'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $availability = $_POST['availability'];
            $query = "INSERT INTO transporter (username, email, password, phone, description, price, availability, account_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ssssssss', $username, $email, $password, $phone, $description, $price, $availability, $account_status);
            break;
        case 'marketing':
            $company = $_POST['company'];
            $phone = $_POST['phone'];
            $query = "INSERT INTO marketing (username, email, password, company, phone, account_status) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ssssss', $username, $email, $password, $company, $phone, $account_status);
            break;
        case 'admin':
            $id_number = $_POST['id_number'];
            $query = "INSERT INTO admin (username, email, password, id_number, account_status) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sssss', $username, $email, $password, $id_number, $account_status);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid user type']);
            return;
    }

    // Execute the user insert query
    if ($stmt && $stmt->execute()) {
        if (!$enable_2fa)
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

//admin settings
function getFarmers()
{
    global $conn;
    $query = "SELECT * FROM farmer";
    $stmt = $conn->prepare($query);

    if ($stmt && $stmt->execute()) {
        $result = $stmt->get_result();
        $farmers = [];

        while ($farmer = $result->fetch_assoc()) {
            $farmers[] = $farmer;
        }

        echo json_encode(['success' => true, 'length' => $result->num_rows, 'farmers' => $farmers]);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }

    $stmt->close();
}
function getBuyers()
{
    global $conn;
    $query = "SELECT * FROM buyer";
    $stmt = $conn->prepare($query);

    if ($stmt && $stmt->execute()) {
        $result = $stmt->get_result();
        $buyers = [];

        while ($buyer = $result->fetch_assoc()) {
            $buyers[] = $buyer;
        }

        echo json_encode(['success' => true, 'length' => $result->num_rows, 'buyers' => $buyers]);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }

    $stmt->close();
}
function getTransporters()
{
    global $conn;
    $query = "SELECT * FROM transporter";
    $stmt = $conn->prepare($query);

    if ($stmt && $stmt->execute()) {
        $result = $stmt->get_result();
        $transporters = [];

        while ($transporter = $result->fetch_assoc()) {
            $transporters[] = $transporter;
        }

        echo json_encode(['success' => true, 'length' => $result->num_rows, 'transporters' => $transporters]);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }

    $stmt->close();
}
function getGovernmentAgencies()
{
    global $conn;
    $query = "SELECT * FROM government";
    $stmt = $conn->prepare($query);

    if ($stmt && $stmt->execute()) {
        $result = $stmt->get_result();
        $agencies = [];

        while ($agency = $result->fetch_assoc()) {
            $agencies[] = $agency;
        }

        echo json_encode(['success' => true, 'length' => $result->num_rows, 'governments' => $agencies]);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }

    $stmt->close();
}
function getMarketingProfessionals()
{
    global $conn;
    $query = "SELECT * FROM marketing";
    $stmt = $conn->prepare($query);

    if ($stmt && $stmt->execute()) {
        $result = $stmt->get_result();
        $professionals = [];

        while ($professional = $result->fetch_assoc()) {
            $professionals[] = $professional;
        }

        echo json_encode(['success' => true, 'length' => $result->num_rows, 'marketings' => $professionals]);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }

    $stmt->close();
}
function setFarmerAccountStatus($farmer_id, $status)
{
    global $conn;
    $query = "UPDATE farmer SET account_status = ? WHERE farmer_id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("si", $status, $farmer_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Farmer account status updated']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No change in farmer account status']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
}
function setBuyerAccountStatus($buyer_id, $status)
{
    global $conn;
    $query = "UPDATE buyer SET account_status = ? WHERE buyer_id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("si", $status, $buyer_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Buyer account status updated']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No change in buyer account status']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
}
function setTransporterAccountStatus($transport_id, $status)
{
    global $conn;
    $query = "UPDATE transporter SET account_status = ? WHERE transport_id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("si", $status, $transport_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Transporter account status updated']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No change in transporter account status']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
}
function setGovernmentAgencyAccountStatus($agency_id, $status)
{
    global $conn;
    $query = "UPDATE government SET account_status = ? WHERE agency_id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("si", $status, $agency_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Government agency account status updated']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No change in government agency account status']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
}
function setMarketingProfessionalAccountStatus($professional_id, $status)
{
    global $conn;
    $query = "UPDATE marketing SET account_status = ? WHERE professional_id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("si", $status, $professional_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Marketing professional account status updated']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No change in marketing professional account status']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
}



//
function addCrop()
{
    global $conn;

    $cropname = $_POST['cropname'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $imagePath = null;

    if (isset($_FILES['crop_image']) && $_FILES['crop_image']['error'] == 0) {
        $targetDir = "../uploads/images/crops/";
        $targetFile = $targetDir . basename($_FILES['crop_image']['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES['crop_image']['tmp_name']);
        if ($check !== false) {
            if (move_uploaded_file($_FILES['crop_image']['tmp_name'], $targetFile)) {
                $imagePath = $targetFile;
            } else {
                echo json_encode(['success' => false, 'message' => 'Sorry, there was an error uploading your file.']);
                return;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'File is not an image.']);
            return;
        }
    }

    $query = "INSERT INTO crops (cropname, description, price, image_path) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);$imagePath='../'.$imagePath;
    $stmt->bind_param('ssss', $cropname, $description, $price, $imagePath);

    if ($stmt && $stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Crop added successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
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
    $imagePath = null;

    if (isset($_FILES['crop_image']) && $_FILES['crop_image']['error'] == 0) {
        $targetDir = "../uploads/images/crops/";
        $targetFile = $targetDir . basename($_FILES['crop_image']['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES['crop_image']['tmp_name']);
        if ($check !== false) {
            if (move_uploaded_file($_FILES['crop_image']['tmp_name'], $targetFile)) {
                $imagePath = $targetFile;
            } else {
                echo json_encode(['success' => false, 'message' => 'Sorry, there was an error uploading your file.']);
                return;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'File is not an image.']);
            return;
        }
    }

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
            $query = "UPDATE crops SET description = ?, price = ?, image_path = ? WHERE crop_id = ?";
            $stmt = $conn->prepare($query);$imagePath='../'.$imagePath;
            $stmt->bind_param('ssss', $description, $price, $imagePath, $crop_id);

            if ($stmt && $stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Crop updated successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => $stmt->error]);
            }
        } else if ($result->num_rows == 0) {
            echo json_encode(array('success' => false, 'message' => 'No record found'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Multiple records exist'));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => $stmt->error));
    }

    // Close the statement
    $stmt->close();
}

function getCrop()
{
    global $conn;
    $cropname = $_POST['cropname'];
    $query = "SELECT * FROM crops WHERE cropname = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $cropname);

    if ($stmt && $stmt->execute()) {
        $result = $stmt->get_result();
        // Check if there is exactly one record
        if ($result->num_rows == 1) {
            $crop = $result->fetch_assoc();
            echo json_encode(['success' => true, 'crop' => $crop]);
        } else if ($result->num_rows == 0) {
            echo json_encode(['success' => false, 'message' => 'Crop not found']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Multiple records exist']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }

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

        echo json_encode(['success' => true, 'length' => $result->num_rows, 'crops' => $crops]);
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
            echo json_encode(['success' => true, 'length' => $result->num_rows, 'forex' => $filteredForex]);
        } else {
            // Return default values if no records found
            $defaultForex = [
                'date' => date('Y-m-d'),
                'usd' => 100,
                'gbp' => 100,
                'eur' => 100,
                'cad' => 100
            ];
            echo json_encode(['success' => true, 'length' => $result->num_rows, 'forex' => $defaultForex]);
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
        echo json_encode(['success' => true, 'length' => $result->num_rows, 'yields' => $yields]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No yields found']);
    }
}
function getYield()
{
    global $conn;
    $farmer_email = $_SESSION['email'];
    // Fetch the farmer_id based on farmer_email
    $farmerQuery = "SELECT farmer_id FROM farmer WHERE email = ? LIMIT 1";
    $farmerStmt = $conn->prepare($farmerQuery);
    $farmerStmt->bind_param('s', $farmer_email);

    if ($farmerStmt->execute()) {
        $farmerResult = $farmerStmt->get_result();

        if ($farmerResult->num_rows == 1) {
            $farmer = $farmerResult->fetch_assoc();
            $farmer_id = $farmer['farmer_id'];

            // Fetch the yields based on farmer_id
            $query = "SELECT y.yield_id, c.cropname, y.quantity, y.harvest_date 
                      FROM yields AS y 
                      JOIN crops AS c ON y.crop_id = c.crop_id 
                      WHERE y.farmer_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('i', $farmer_id);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $yields = [];
                    while ($row = $result->fetch_assoc()) {
                        $yields[] = $row;
                    }
                    echo json_encode(['success' => true, 'length' => $result->num_rows, 'yields' => $yields]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'No yields found']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Error fetching yields: ' . $stmt->error]);
            }
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Farmer not found']);
        }
        $farmerStmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching farmer ID: ' . $farmerStmt->error]);
    }
}


function deleteYield()
{
    global $conn;
    $yield_id = $_POST['yield_id'];
    $farmer_email = $_SESSION['email'];

    // Fetch the crop_id and farmer_id based on yield_id
    $yieldQuery = "SELECT crop_id, farmer_id FROM yields WHERE yield_id = ? LIMIT 1";
    $yieldStmt = $conn->prepare($yieldQuery);
    $yieldStmt->bind_param('i', $yield_id);

    if ($yieldStmt->execute()) {
        $yieldResult = $yieldStmt->get_result();

        if ($yieldResult->num_rows == 1) {
            $yield = $yieldResult->fetch_assoc();
            $crop_id = $yield['crop_id'];
            $farmer_id_from_yield = $yield['farmer_id'];

            // Fetch the farmer_id based on farmer_email
            $farmerQuery = "SELECT farmer_id FROM farmer WHERE email = ? LIMIT 1";
            $farmerStmt = $conn->prepare($farmerQuery);
            $farmerStmt->bind_param('s', $farmer_email);

            if ($farmerStmt->execute()) {
                $farmerResult = $farmerStmt->get_result();

                if ($farmerResult->num_rows == 1) {
                    $farmer = $farmerResult->fetch_assoc();
                    $farmer_id = $farmer['farmer_id'];

                    if ($farmer_id === $farmer_id_from_yield) {
                        // Delete the yield entry
                        $deleteQuery = "DELETE FROM yields WHERE yield_id = ? AND crop_id = ? AND farmer_id = ?";
                        $deleteStmt = $conn->prepare($deleteQuery);
                        $deleteStmt->bind_param('iii', $yield_id, $crop_id, $farmer_id);

                        if ($deleteStmt->execute()) {
                            echo json_encode(['success' => true, 'message' => 'Yield deleted successfully']);
                        } else {
                            echo json_encode(['success' => false, 'message' => 'Error deleting yield: ' . $deleteStmt->error]);
                        }
                        $deleteStmt->close();
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Farmer ID does not match with the yield record']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'Farmer not found']);
                }
                $farmerStmt->close();
            } else {
                echo json_encode(['success' => false, 'message' => 'Error fetching farmer ID: ' . $farmerStmt->error]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Yield not found']);
        }
        $yieldStmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching yield details: ' . $yieldStmt->error]);
    }
}

function updateYield()
{
    global $conn;
    $yield_id = $_POST['yield_id'];
    $cropname = $_POST['cropname'];
    $farmer_email = $_SESSION['email'];
    $quantity = $_POST['quantity'];
    $harvest_date = $_POST['harvest_date'];

    // Fetch the crop_id based on cropname
    $cropQuery = "SELECT crop_id FROM crops WHERE cropname = ? LIMIT 1";
    $cropStmt = $conn->prepare($cropQuery);
    $cropStmt->bind_param('s', $cropname);

    if ($cropStmt->execute()) {
        $cropResult = $cropStmt->get_result();

        if ($cropResult->num_rows == 1) {
            $crop = $cropResult->fetch_assoc();
            $crop_id = $crop['crop_id'];

            // Fetch the farmer_id based on farmer_email
            $farmerQuery = "SELECT farmer_id FROM farmer WHERE email = ? LIMIT 1";
            $farmerStmt = $conn->prepare($farmerQuery);
            $farmerStmt->bind_param('s', $farmer_email);

            if ($farmerStmt->execute()) {
                $farmerResult = $farmerStmt->get_result();

                if ($farmerResult->num_rows == 1) {
                    $farmer = $farmerResult->fetch_assoc();
                    $farmer_id = $farmer['farmer_id'];

                    // Update the yield data
                    $updateQuery = "UPDATE yields SET crop_id = ?, quantity = ?, harvest_date = ? WHERE yield_id = ? AND farmer_id = ?";
                    $updateStmt = $conn->prepare($updateQuery);
                    $updateStmt->bind_param('iisii', $crop_id, $quantity, $harvest_date, $yield_id, $farmer_id);

                    if ($updateStmt->execute()) {
                        echo json_encode(['success' => true, 'message' => 'Yield updated successfully']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Error updating yield: ' . $updateStmt->error]);
                    }
                    $updateStmt->close();
                } else {
                    echo json_encode(['success' => false, 'message' => 'Farmer not found']);
                }
                $farmerStmt->close();
            } else {
                echo json_encode(['success' => false, 'message' => 'Error fetching farmer ID: ' . $farmerStmt->error]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Crop not found']);
        }
        $cropStmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching crop ID: ' . $cropStmt->error]);
    }
}

function addYield()
{
    global $conn;
    $crop_id = $_POST['crop_id'];
    $farmer_email = $_SESSION['email'];
    $quantity = $_POST['quantity'];
    $harvest_date = $_POST['harvest_date'];

    // Fetch the crop_id based on cropname
    $cropQuery = "SELECT crop_id FROM crops WHERE crop_id = ? LIMIT 1";
    $cropStmt = $conn->prepare($cropQuery);
    $cropStmt->bind_param('i', $crop_id);

    if ($cropStmt->execute()) {
        $cropResult = $cropStmt->get_result();

        if ($cropResult->num_rows == 1) {
            $crop = $cropResult->fetch_assoc();
            $crop_id = $crop['crop_id'];

            // Fetch the farmer_id based on farmer_email
            $farmerQuery = "SELECT farmer_id FROM farmer WHERE email = ? LIMIT 1";
            $farmerStmt = $conn->prepare($farmerQuery);
            $farmerStmt->bind_param('s', $farmer_email);

            if ($farmerStmt->execute()) {
                $farmerResult = $farmerStmt->get_result();

                if ($farmerResult->num_rows == 1) {
                    $farmer = $farmerResult->fetch_assoc();
                    $farmer_id = $farmer['farmer_id'];

                    // Insert the yield data
                    $insertQuery = "INSERT INTO yields (farmer_id, crop_id, quantity, harvest_date) VALUES (?, ?, ?, ?)";
                    $insertStmt = $conn->prepare($insertQuery);
                    $insertStmt->bind_param('iiis', $farmer_id, $crop_id, $quantity, $harvest_date);

                    if ($insertStmt->execute()) {
                        echo json_encode(['success' => true, 'message' => 'Yield added successfully']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Error adding yield: ' . $insertStmt->error]);
                    }
                    $insertStmt->close();
                } else {
                    echo json_encode(['success' => false, 'message' => 'Farmer not found']);
                }
                $farmerStmt->close();
            } else {
                echo json_encode(['success' => false, 'message' => 'Error fetching farmer ID: ' . $farmerStmt->error]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Crop not found']);
        }
        $cropStmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching crop ID: ' . $cropStmt->error]);
    }
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

    echo json_encode(['success' => true, 'length' => $result->num_rows, 'feedbacks' => $feedbacks]);
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

    echo json_encode(['success' => true, 'length' => $result->num_rows, 'feedbacks' => $feedbacks]);
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

    echo json_encode(['success' => true, 'length' => $result->num_rows, 'feedbacks' => $feedbacks]);
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
    $cropname = $_POST['cropname'];

    // Fetch the crop_id based on cropname
    $selectQuery = "SELECT crop_id FROM crops WHERE cropname = ? LIMIT 1";
    $selectStmt = $conn->prepare($selectQuery);
    $selectStmt->bind_param('s', $cropname);

    if ($selectStmt->execute()) {
        $result = $selectStmt->get_result();

        if ($result->num_rows == 1) {
            $crop = $result->fetch_assoc();
            $crop_id = $crop['crop_id'];

            // Retrieve market prices for the crop
            $query = "SELECT * FROM market_prices WHERE crop_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('i', $crop_id);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $market_prices = $result->fetch_all(MYSQLI_ASSOC);
                    echo json_encode(['success' => true, 'data' => $market_prices]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'No market prices found for the crop']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Error fetching market prices: ' . $stmt->error]);
            }
            $stmt->close();
        } else if ($result->num_rows == 0) {
            echo json_encode(['success' => false, 'message' => 'Crop not found']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Multiple crops found with the same name']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching crop id: ' . $selectStmt->error]);
    }

    $selectStmt->close();
}


function getMarketPrices()
{
    global $conn;

    $query = "SELECT m.*,c.cropname FROM market_prices as m join crops as c on m.crop_id=c.crop_id";
    $result = $conn->query($query);

    if ($result) {
        $market_prices = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'length' => $result->num_rows, 'data' => $market_prices]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching market prices: ' . $conn->error]);
    }
}

function updateCropMarketPrice()
{
    global $conn;
    $price_id = $_POST['price_id'];
    $cropname = $_POST['cropname'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $date = $_POST['date'];

    // Fetch the crop_id based on cropname
    $selectQuery = "SELECT crop_id FROM crops WHERE cropname = ? LIMIT 1";
    $selectStmt = $conn->prepare($selectQuery);
    $selectStmt->bind_param('s', $cropname);

    if ($selectStmt->execute()) {
        $result = $selectStmt->get_result();

        if ($result->num_rows == 1) {
            $crop = $result->fetch_assoc();
            $crop_id = $crop['crop_id'];

            // Update the market price
            $query = "UPDATE market_prices SET crop_id = ?, price = ?, status = ?, date = ? WHERE price_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('idssi', $crop_id, $price, $status, $date, $price_id);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Market price updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error updating market price: ' . $stmt->error]);
            }
            $stmt->close();
        } else if ($result->num_rows == 0) {
            echo json_encode(['success' => false, 'message' => 'Crop not found']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Multiple crops found with the same name']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching crop id: ' . $selectStmt->error]);
    }

    $selectStmt->close();
}
function addCropMarketPrice()
{
    global $conn;
    $cropname = $_POST['cropname'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $date = date('Y-m-d');

    // Fetch the crop_id based on cropname
    $selectQuery = "SELECT crop_id FROM crops WHERE cropname = ? LIMIT 1";
    $selectStmt = $conn->prepare($selectQuery);
    $selectStmt->bind_param('s', $cropname);

    if ($selectStmt->execute()) {
        $result = $selectStmt->get_result();

        if ($result->num_rows == 1) {
            $crop = $result->fetch_assoc();
            $crop_id = $crop['crop_id'];

            // Insert the market price
            $query = "INSERT INTO market_prices (crop_id, price, status, date) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('idss', $crop_id, $price, $status, $date);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Market price added successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error adding market price: ' . $stmt->error]);
            }
            $stmt->close();
        } else if ($result->num_rows == 0) {
            echo json_encode(['success' => false, 'message' => 'Crop not found']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Multiple crops found with the same name']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching crop id: ' . $selectStmt->error]);
    }

    $selectStmt->close();
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

    echo json_encode(['success' => true, 'length' => $result->num_rows, 'data' => $certificates]);
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

    echo json_encode(['success' => true, 'length' => $result->num_rows, 'data' => $certificates]);

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
            echo json_encode(['success' => true, 'length' => $result->num_rows, 'transaction' => $transaction]);
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

function getUnits()
{
    global $conn;

    $query = "SELECT * FROM unit_of_measure";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $unit_of_measure = [];
        while ($row = $result->fetch_assoc()) {
            $unit_of_measure[] = $row;
        }
        echo json_encode(['success' => true, 'length' => $result->num_rows, 'units' => $unit_of_measure]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No unit_of_measure found']);
    }
}

function getAllAdverts()
{
    global $conn;

    $query = "
                SELECT a.advert_id, a.price, a.quantity, a.unit, a.date, a.status, 
                    f.username as 'farmer_username', f.location, c.cropname, c.description, c.image_path 
                    FROM adverts as a 
                    join farmer as f on a.farmer_id=f.farmer_id 
                    join crops as c on a.crop_id=c.crop_id
    ";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $adverts = [];
        while ($row = $result->fetch_assoc()) {
            $adverts[] = $row;
        }
        echo json_encode(['success' => true, 'length' => $result->num_rows, 'adverts' => $adverts]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No adverts found']);
    }
}

function getAdvertsByFarmer()
{
    global $conn;

    $farmer_id = $_SESSION['user_id'];
    $query = "SELECT a.*, c.cropname FROM adverts as a join crops as c on a.crop_id=c.crop_id WHERE a.farmer_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $farmer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $adverts = [];
        while ($row = $result->fetch_assoc()) {
            $adverts[] = $row;
        }
        echo json_encode(['success' => true, 'length' => $result->num_rows, 'adverts' => $adverts]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No adverts found for this farmer']);
    }

    $stmt->close();
}

function addAdvert()
{
    global $conn;

    $farmer_id = $_SESSION['user_id'];
    $crop_id = $_POST['crop_id'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $unit = $_POST['unit'];
    $date = date('Y-m-d');
    $status = 'available'; // Default status
    $created_by = $_SESSION['user_id'];

    $query = "INSERT INTO adverts (farmer_id, crop_id, price, quantity, unit, date, status, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iisisssi', $farmer_id, $crop_id, $price, $quantity, $unit, $date, $status, $created_by);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Advert added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error adding advert: ' . $stmt->error]);
    }

    $stmt->close();
}

function updateAdvert()
{
    global $conn;

    $advert_id = $_POST['advert_id'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $unit = $_POST['unit'];
    $updated_by = $_SESSION['user_id'];

    // Check if the advert_id exists
    $checkQuery = "SELECT COUNT(*) FROM adverts WHERE advert_id = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param('i', $advert_id);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count == 0) {
        echo json_encode(['success' => false, 'message' => 'Advert not found']);
        return;
    }

    // Proceed with the update if the advert_id exists
    $query = "UPDATE adverts SET price = ?, quantity = ?, unit = ?, updated_by = ? WHERE advert_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sisii', $price, $quantity, $unit, $updated_by, $advert_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Advert updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating advert: ' . $stmt->error]);
    }

    $stmt->close();
}


function updateAdvertStatus()
{
    global $conn;

    $advert_id = $_POST['advert_id'];
    $status = $_POST['status'];
    $updated_by = $_SESSION['user_id'];

    $query = "UPDATE adverts SET status = ?, updated_by = ? WHERE advert_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sii', $status, $updated_by, $advert_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Advert status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating advert status: ' . $stmt->error]);
    }

    $stmt->close();
}

function deleteAdvert()
{
    global $conn;
    $advert_id = $_POST['advert_id'];
    $farmer_id = $_SESSION['user_id'];
    $query = "DELETE FROM adverts WHERE advert_id = ? AND farmer_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $advert_id, $farmer_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Advert deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting advert']);
    }
}


// Function to get all customers
function getAllCustomers()
{
    global $conn;

    $query = "SELECT o.order_id, o.date, o.farmer_id, o.buyer_id, f.username as farmer_name, 
    b.username as buyer_name FROM orders o 
    JOIN farmer f ON o.farmer_id=f.farmer_id
    JOIN buyer b ON o.buyer_id=b.buyer_id";
    $result = $conn->query($query);

    if ($result) {
        $customers = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'length' => $result->num_rows, 'customers' => $customers]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching customers: ' . $conn->error]);
    }
}
// Function to get all orders
function getAllOrders()
{
    global $conn;

    $query = "SELECT * FROM orders";
    $result = $conn->query($query);

    if ($result) {
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'length' => $result->num_rows, 'orders' => $orders]);
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
    $farmer_id = $_SESSION['user_id'];

    $query = "
                SELECT
                    orders.order_id,
                    crops.cropname,
                    orders.quantity,
                    orders.unit,
                    orders.total_cost,
                    orders.date,
                    buyer.username AS buyer_username,
                    buyer.phone AS buyer_phone,
                    orders.status
                FROM
                    orders
                JOIN crops ON orders.crop_id = crops.crop_id
                JOIN buyer ON orders.buyer_id = buyer.buyer_id
                WHERE orders.farmer_id = ?
            ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $farmer_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'length' => $result->num_rows, 'orders' => $orders]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching orders by farmer: ' . $stmt->error]);
    }

    $stmt->close();
}


// Function to get orders by buyer
function getOrdersByBuyer()
{
    global $conn;

    $buyer_id = $_SESSION['user_id'];

    $query = "
                SELECT
                    orders.order_id,
                    crops.cropname,
                    orders.quantity,
                    orders.unit,
                    orders.total_cost,
                    orders.date,
                    farmer.username AS farmer_username,
                    orders.status
                FROM
                    orders
                JOIN crops ON orders.crop_id = crops.crop_id
                JOIN farmer ON orders.farmer_id = farmer.farmer_id
                WHERE orders.buyer_id = ?
            ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $buyer_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'length' => $result->num_rows, 'orders' => $orders]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching orders by buyer: ' . $stmt->error]);
    }

    $stmt->close();
}

// Function to add a new order
function addOrder()
{
    global $conn;

    $advert_id = $_POST['advert_id'];
    $buyer_id = $_SESSION['user_id'];
    $quantity = $_POST['quantity'];
    $unit = $_POST['unit'];
    $today = date('Y-m-d');
    $status = 'pending'; // Default status

    // Check if the advert exists
    $checkAdvertQuery = "SELECT farmer_id, crop_id, price FROM adverts WHERE advert_id = ? LIMIT 1";
    $checkAdvertStmt = $conn->prepare($checkAdvertQuery);
    $checkAdvertStmt->bind_param('i', $advert_id);
    $checkAdvertStmt->execute();
    $result = $checkAdvertStmt->get_result();

    if ($result->num_rows == 1) {
        $advert = $result->fetch_assoc();

        // Calculate total cost
        $total_cost = $quantity * $advert['price'];

        // Proceed to insert the order
        $query = "INSERT INTO orders (advert_id, farmer_id, buyer_id, crop_id, quantity, unit, total_cost, date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('iiiissdss', $advert_id, $advert['farmer_id'], $buyer_id, $advert['crop_id'], $quantity, $unit, $total_cost, $today, $status);

        if ($stmt->execute()) {

            // Add demand for the crop
            addCropDemand($advert['crop_id']);

            // Add market trend for the crop
            // addCropMarketTrend($advert['crop_id'], $advert['price']); // transfered to ==confirmed
            // Order added successfully

            echo json_encode(['success' => true, 'message' => 'Order added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error adding order: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: Advert does not exist']);
    }
    $checkAdvertStmt->close();
}

// Function to update an existing order
function updateOrder()
{
    global $conn;

    $order_id = $_POST['order_id'];
    $quantity = $_POST['quantity'];
    $unit = $_POST['unit'];

    $query = "UPDATE orders SET quantity = ?, unit = ? WHERE order_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('isi', $quantity, $unit, $order_id);

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

    // Update the order status
    $updateQuery = "UPDATE orders SET status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('si', $status, $order_id);

    if ($stmt->execute()) {
        // If status updated successfully, check if it's 'confirmed'
        if ($status === 'confirmed') {
            // Fetch the crop_id and price from the adverts table
            $selectQuery = "SELECT crop_id, price FROM adverts WHERE advert_id = (
                SELECT advert_id FROM orders WHERE order_id = ? LIMIT 1
            )";
            $selectStmt = $conn->prepare($selectQuery);
            $selectStmt->bind_param('i', $order_id);

            if ($selectStmt->execute()) {
                $result = $selectStmt->get_result();

                if ($result->num_rows == 1) {
                    $advert = $result->fetch_assoc();
                    $crop_id = $advert['crop_id'];
                    $price = $advert['price'];

                    // Call addCropMarketTrend function
                    addCropMarketTrend($crop_id, $price);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Advert not found for the order']);
                }
                $selectStmt->close();
            } else {
                echo json_encode(['success' => false, 'message' => 'Error fetching advert details: ' . $selectStmt->error]);
            }
        }

        echo json_encode(['success' => true, 'message' => 'Order status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating order status: ' . $stmt->error]);
    }

    $stmt->close();
}

function addCropDemand($crop_id)
{
    global $conn;

    $date = date('Y-m-d');

    // Retrieve the current demand value for the crop
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
            // Demand incremented successfully
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
            echo json_encode(['success' => true, 'length' => $result->num_rows, 'demand_trends' => $demand_trends]);
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

    $query = "SELECT 
    c.cropname, 
    SUM(d.demand) AS total_demand
        FROM 
            demand_trends d 
        JOIN 
            crops c 
        ON 
            d.crop_id = c.crop_id 
        GROUP BY 
            c.cropname;";
    $result = $conn->query($query);

    if ($result) {
        $demand_trends = $result->fetch_all(MYSQLI_ASSOC);

        if (!empty($demand_trends)) {
            echo json_encode(['success' => true, 'length' => $result->num_rows, 'demand_trends' => $demand_trends]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No demand trends found']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching demand trends: ' . $conn->error]);
    }
}

function addCropMarketTrend($crop_id, $price)
{
    global $conn;

    $date = date('Y-m-d');

    // Insert or update the market trend for the crop
    $insertQuery = "INSERT INTO market_trends (crop_id, price, date) VALUES (?, ?, ?)
                    ON DUPLICATE KEY UPDATE price = ?";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param('idsd', $crop_id, $price, $date, $price);

    if ($insertStmt->execute()) {
        // Market trend updated successfully
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating crop market trend: ' . $insertStmt->error]);
    }

    $insertStmt->close();
}


function getCropMarketTrend()
{
    global $conn;
    $cropname = $_POST['cropname'];

    // Fetch the crop_id based on cropname
    $selectQuery = "SELECT crop_id FROM crops WHERE cropname = ? LIMIT 1";
    $selectStmt = $conn->prepare($selectQuery);
    $selectStmt->bind_param('s', $cropname);

    if ($selectStmt->execute()) {
        $result1 = $selectStmt->get_result();

        if ($result1->num_rows == 1) {
            $crop = $result1->fetch_assoc();
            $crop_id = $crop['crop_id'];

            // Retrieve the latest market trend for the crop along with max price
            $query = "
                SELECT mt.*, 
                       COALESCE((SELECT MAX(mp.price) 
                                 FROM market_prices mp 
                                 WHERE mp.crop_id = mt.crop_id), 0) AS max_price 
                FROM market_trends mt 
                WHERE mt.crop_id = ?
                ORDER BY mt.date DESC";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('i', $crop_id);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $marketTrend = $result->fetch_all(MYSQLI_ASSOC);

                if ($marketTrend) {
                    echo json_encode(['success' => true, 'length' => $result->num_rows, 'market_trend' => $marketTrend]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Market trend not found for the crop']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Error fetching market trend: ' . $stmt->error]);
            }

            $stmt->close();
        } else if ($result1->num_rows == 0) {
            echo json_encode(['success' => false, 'message' => 'Crop not found']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Multiple crops found with the same name']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching crop id: ' . $selectStmt->error]);
    }

    $selectStmt->close();
}



function getMarketTrends()
{
    global $conn;

    // Retrieve all market trends
    $query = "SELECT m.trend_id,c.cropname, m.price, m.date
        FROM market_trends m
        JOIN crops c ON m.crop_id = c.crop_id
        WHERE 1=1;";
    $stmt = $conn->prepare($query);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $marketTrends = $result->fetch_all(MYSQLI_ASSOC);

        if ($marketTrends) {
            echo json_encode(['success' => true, 'length' => $result->num_rows, 'market_trends' => $marketTrends]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No market trends found']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching market trends: ' . $stmt->error]);
    }

    $stmt->close();
}

function addEngagement()
{
    global $conn;
    $message_text = $_POST['message_text'];
    $sender = $_POST['sender'];
    $receiver = $_POST['receiver'];

    $query = "INSERT INTO engagements (message_text, sender, receiver) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sss', $message_text, $sender, $receiver);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Message sent successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error adding message to db: ' . $stmt->error]);
    }

    $stmt->close();
}

function viewEngagements()
{
    global $conn;
    $query = "SELECT * FROM engagements ORDER BY sent_at DESC";
    $result = $conn->query($query);

    if ($result) {
        $messages = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'length' => $result->num_rows, 'engagements' => $messages]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching messages: ' . $conn->error]);
    }
}

function addMessage()
{
    global $conn;

    $subject = $_POST['subject'];
    $message_text = $_POST['message_text'];
    $receiver_email = $_POST['receiver_email'];

    $query = "INSERT INTO messages (subject, message_text, receiver_email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sss', $subject, $message_text, $receiver_email);

    if ($stmt->execute()) {
        //actual sending
        $sent = sendMessage([$receiver_email], $subject, '
            <div style="font-family: Arial, sans-serif; padding: 20px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 10px;">
                <h2 style="color: #333;">Hello ' . $receiver_email . '</h2>
                <div style="text-align: center; margin: 20px 0;">
                    <p style="font-size: 16px; color: #222;">
                        ' . $message_text . '
                    </p>
                </div>
            </div>
        ');
        if ($sent['sent']) {
            echo json_encode(['success' => true, 'message' => 'Message sent successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => $sent['message']]);
            exit();
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error adding message to db: ' . $stmt->error]);
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
        echo json_encode(['success' => true, 'length' => $result->num_rows, 'messages' => $messages]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching messages: ' . $conn->error]);
    }
}

function viewMyMessages()
{
    global $conn;

    $email = $_POST['email'];

    $query = "SELECT * FROM messages WHERE receiver_email = ? ORDER BY sent_at DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $email);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $messages = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'length' => $result->num_rows, 'messages' => $messages]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching messages: ' . $stmt->error]);
    }

    $stmt->close();
}

function verifyTwoFactorAuth()
{
    global $conn;

    $email = $_POST['email'];
    $user_type = $_POST['user_type'];
    $user_type_id = getUserTypeId($user_type);
    $code = $_POST['verification_code'];

    // Query to fetch the authentication record
    $query = "SELECT * FROM two_factor_auth WHERE user_email = ? AND user_type_id = ?";
    $fetchStmt = $conn->prepare($query);
    $fetchStmt->bind_param('si', $email, $user_type_id);

    if ($fetchStmt->execute()) {
        $result = $fetchStmt->get_result();
        if ($result->num_rows === 1) {
            $auth = $result->fetch_assoc();
            $auth_id = $auth['auth_id'];
            $status = $auth['status'];
            $created_at = new DateTime($auth['sent_at']);
            $now = new DateTime();
            $interval = $created_at->diff($now);

            // Check if the code has expired (more than 10 minutes)
            if ($interval->i > 100 || $status === 'expired') {
                $expireQuery = "UPDATE two_factor_auth SET status = 'expired' WHERE auth_id = ?";
                $expireStmt = $conn->prepare($expireQuery);
                $expireStmt->bind_param('i', $auth_id);

                if ($expireStmt->execute()) {
                    $query = "DELETE FROM $user_type WHERE email = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('s', $email);

                    if ($stmt->execute()) {
                        //echo json_encode(['success' => true, 'message' => 'Verication code successful']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Error cleaning up user: ' . $stmt->error]);
                    }
                    echo json_encode(['success' => false, 'message' => 'Authentication code expired']);
                    $stmt->close();
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
                        //
                        $query = "UPDATE $user_type SET account_status = 'active' WHERE email = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param('s', $email);

                        if ($stmt->execute()) {
                            echo json_encode(['success' => true, 'message' => 'Two-factor code verified successfully']);
                        } else {
                            echo json_encode(['success' => false, 'message' => 'Error verifying code: ' . $stmt->error]);
                        }
                        //
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
                        $query = `DELETE FROM $user_type WHERE email = ?`;
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param('s', $email);

                        if ($stmt->execute()) {
                            //echo json_encode(['success' => true, 'message' => 'Verication code successful']);
                        } else {
                            echo json_encode(['success' => false, 'message' => 'Error cleaning up user: ' . $stmt->error]);
                        }
                        echo json_encode(['success' => false, 'message' => 'Invalid authentication code']);
                        $stmt->close();
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
        echo json_encode(['success' => false, 'message' => 'Error fetching authentication record: ' . $fetchStmt->error]);
    }

    $fetchStmt->close();
}

function subscribe()
{
    global $conn;

    $email = $_POST['email'];

    $query = "UPDATE buyer SET subscription = 'subscribed' WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Subscription status updated to subscribed']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating subscription status: ' . $stmt->error]);
    }

    $stmt->close();
}

function unsubscribe()
{
    global $conn;

    $email = $_POST['email'];

    $query = "UPDATE buyer SET subscription = 'unsubscribed' WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Subscription status updated to unsubscribed']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating subscription status: ' . $stmt->error]);
    }

    $stmt->close();
}
