<?php
include_once("../config/config.php");
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
  header('Location: ' . BASE_URL . '/public/index.php?route=login');
  exit;
}

// Fetch user types from the database
include('../includes/db_connect.php'); // Ensure this file connects to your database

$query = "SELECT user_type FROM user_type_tbl";
$result = $conn->query($query);

$user_types = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $user_types[] = $row['user_type'];
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.min.css">
  <script src="<?php echo BASE_URL; ?>/assets/js/scripts.js" defer></script>
  <script src="<?php echo BASE_URL; ?>/assets/js/popper.min.js" defer></script>
  <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>
  <style>
    body {
      background-color: rgb(251, 249, 244);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      overflow: hidden;
    }

    .centered-form {
      width: 100%;
      max-width: 400px;
      padding: 15px;
      opacity: 0;
      transform: translateY(30px);
      animation: fadeInUp 0.8s ease-out forwards;
    }

    .form-container {
      background-color: #ffffff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      opacity: 0;
      /* Add this line */
      transform: translateY(30px);
      /* Add this line */
      animation: fadeInUp 0.8s ease-out forwards;
      animation-delay: 0.2s;
    }

    .logo {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
      opacity: 0;
      animation: fadeIn 0.8s ease-out forwards;
      animation-delay: 0.4s;
    }

    .logo img {
      width: 60px;
      height: 60px;
      transform: rotate(360deg);
      animation: rotate 1s ease-in-out 1;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes rotate {
      from {
        transform: rotate(0deg);
      }

      to {
        transform: rotate(360deg);
      }
    }
  </style>
</head>

<body>
  <div class="container centered-form">
    <div class="form-container">
      <div class="logo">
        <img src="<?php echo BASE_URL; ?>/assets/images/logo.png" alt="Logo">
      </div>
      <h2 class="text-center mb-4">Login</h2>
      <div id="alert-placeholder"></div>

      <form id="login-form" role="form" class="needs-validation" novalidate>
        <input type="hidden" name="action" value="login">
        <div class="form-group mb-3">
          <label for="user_type">User Type:</label>
          <select id="user_type" name="user_type" class="form-control" required>
            <option value="" disabled selected>Select user type</option>
            <?php foreach ($user_types as $user_type) : ?>
              <option value="<?php echo htmlspecialchars($user_type); ?>">
                <?php echo htmlspecialchars(ucfirst($user_type)); ?>
              </option>
            <?php endforeach; ?>
          </select>
          <div class="invalid-feedback">
            Please select a user type.
          </div>
        </div>
        <div class="form-group mb-3">
          <label for="username">Username:</label>
          <input type="text" id="username" name="username" class="form-control" required>
          <div class="invalid-feedback">
            Please enter your username.
          </div>
        </div>
        <div class="form-group mb-3">
          <label for="password">Password:</label>
          <div class="input-group">
            <input type="password" id="password" name="password" class="form-control" required>
            <div class="input-group-append">
              <span class="input-group-text" id="toggle-password" style="cursor: pointer; height: 38px;">
                <i class="fa fa-eye" onclick="togglePwd()" id="togglePassword"></i>
              </span>
            </div>
            <div class="invalid-feedback">
              Please enter your password.
            </div>
          </div>
        </div>
        <button type="button" class="btn btn-primary w-100" onclick="submitLoginForm()">Login</button>
        <button class="btn btn-success w-100 mt-2" type="button" onclick="window.location.href='<?php echo BASE_URL; ?>/public/index.php?route=register'" id="register">I don't have an account</button>
      </form>
    </div>
  </div>

  <?php include("../assets/js/login.script.js.php") ?>
  <script>
    function togglePwd() {
      var pwd = document.getElementById("password");
      var icon = document.getElementById("togglePassword");
      if (pwd.type === "password") {
        pwd.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      } else {
        pwd.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      }
    }
  </script>
</body>

</html>