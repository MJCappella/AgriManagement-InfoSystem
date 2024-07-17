<?php
include_once("../config/config.php");
include('../includes/header.php');
?>

<h2 class="mt-4">Login</h2>

<?php
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
    <button type="button" class="btn btn-primary" onclick="submitLoginForm()">Login</button>
    <button class="btn btn-success" type="button" onclick="window.location.href='register.php'" id="register">I don't have an account</button>
</form>

<script>
    function togglePwd() {
        if ($('#password').attr('type') === 'password') {
            $('#password').attr('type', 'text');
            $('#togglePassword').removeClass('fa-eye');
            $('#togglePassword').addClass('fa-eye-slash');
        } else {
            $('#password').attr('type', 'password');
            $('#togglePassword').removeClass('fa-eye-slash');
            $('#togglePassword').addClass('fa-eye');
        }
    }

    // Bootstrap validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    // AJAX form submission
    function submitLoginForm() {
        var myForm = document.getElementById('login-form');

        if (myForm.checkValidity() === false) {
            myForm.classList.add('was-validated');
            return;
        }

        myForm.classList.remove('was-validated');

        var formData = $(myForm).serialize();

        $.ajax({
            url: '/amis-project-/pages/routes.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                var data = JSON.parse(response);
                var loginSuccessful = data.success;
                var alertPlaceholder = $('#alert-placeholder');

                if (loginSuccessful) {
                    alertPlaceholder.html('<div class="alert alert-success" role="alert">Login successful! Redirecting...</div>');
                    setTimeout(() => {
                        window.location.href = 'dashboard.php';
                    }, 1200);
                } else {
                    alertPlaceholder.html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Login error:', error);
                $('#alert-placeholder').html('<div class="alert alert-danger" role="alert">An error occurred during login. Please try again.</div>');
            }
        });
    }
</script>

<?php
include('../includes/footer.php');
?>
