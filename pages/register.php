<?php include_once("../config/config.php");
include('../includes/header.php'); ?>
<h2 class="mt-4">Register</h2>

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

// Fetch locations for farmers
$location_query = "SELECT name as county FROM counties";
$location_result = $conn->query($location_query);

$locations = [];
if ($location_result->num_rows > 0) {
    while ($row = $location_result->fetch_assoc()) {
        $locations[] = $row['county'];
    }
}

$conn->close();
?>

<form action="/amis-project-/pages/routes.php" method="post" class="needs-validation" novalidate>
    <input type="hidden" name="action" value="register">
    <div class="form-group mb-2">
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
    <div class="form-group mb-2">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" class="form-control" required>
        <div class="invalid-feedback">
            Please enter a username.
        </div>
    </div>
    <div class="form-group mb-2">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" class="form-control" required>
        <div class="invalid-feedback">
            Please enter a valid email address.
        </div>
    </div>
    <div class="form-group mb-2">
        <label for="password">Password:</label>
        <div class="input-group">
            <input type="password" id="password" name="password" class="form-control" required>
            <div class="input-group-append">
                <span class="input-group-text" id="toggle-password" style="cursor: pointer; height: 38px;">
                    <i class="fa fa-eye" onclick="togglePwd()" id="togglePassword"></i>
                </span>
            </div>
        </div>
        <div class="invalid-feedback">
            Please enter your password.
        </div>
    </div>
    <div id="additional-fields" class="form-group"></div><br>
    <button type="submit" class="btn btn-primary">Register</button>
    <button class="btn btn-success" type="button" onclick="window.location.href='login.php'" id="register">I already have an account</button>

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
    // Fetch locations from PHP to JavaScript
    var locations = <?php echo json_encode($locations); ?>;

    document.getElementById('user_type').addEventListener('change', function() {
        const userType = this.value;
        const additionalFields = document.getElementById('additional-fields');
        additionalFields.innerHTML = '';

        switch (userType) {
            case 'farmer':
                additionalFields.innerHTML += `
                    <div class="form-group mb-2">
                        <label for="location">Location:</label>
                        <select id="location" name="location" class="form-control" required>
                            <option value="" disabled selected>Select location</option>
                            ${locations.map(location => `<option value="${location}">${location.charAt(0).toUpperCase() + location.slice(1)}</option>`).join('')}
                        </select>
                        <div class="invalid-feedback">Please select your location.</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="phone_farmer">Phone:</label>
                        <input type="text" id="phone_farmer" name="phone" class="form-control" required>
                        <div class="invalid-feedback">Please enter your phone number.</div>
                    </div>`;
                break;
            case 'buyer':
                additionalFields.innerHTML += `
                    <div class="form-group mb-2">
                        <label for="phone_buyer">Phone:</label>
                        <input type="text" id="phone_buyer" name="phone" class="form-control" required>
                        <div class="invalid-feedback">Please enter your phone number.</div>
                    </div>`;
                break;
            case 'government':
                additionalFields.innerHTML += `
                    <div class="form-group mb-2">
                        <label for="location">Location:</label>
                        <select id="location" name="location" class="form-control" required>
                            <option value="" disabled selected>Select location</option>
                            ${locations.map(location => `<option value="${location}">${location.charAt(0).toUpperCase() + location.slice(1)}</option>`).join('')}
                        </select>
                        <div class="invalid-feedback">Please select your location.</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="phone_gov">Phone:</label>
                        <input type="text" id="phone_gov" name="phone" class="form-control" required>
                        <div class="invalid-feedback">Please enter your phone number.</div>
                    </div>`;
                break;
            case 'transporter':
                additionalFields.innerHTML += `
                    <div class="form-group mb-2">
                        <label for="phone_trans">Phone:</label>
                        <input type="text" id="phone_trans" name="phone" class="form-control" required>
                        <div class="invalid-feedback">Please enter your phone number.</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" class="form-control" required></textarea>
                        <div class="invalid-feedback">Please enter a description.</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="price">Price:</label>
                        <input type="number" step="0.01" id="price" name="price" class="form-control" required>
                        <div class="invalid-feedback">Please enter a price.</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="availability">Availability:</label>
                        <select id="availability" name="availability" class="form-control" required>
                            <option value="available">Available</option>
                            <option value="engaged">Engaged</option>
                            <option value="no_service">No Service</option>
                        </select>
                        <div class="invalid-feedback">Please select availability.</div>
                    </div>`;
                break;
            case 'marketing':
                additionalFields.innerHTML += `
                    <div class="form-group mb-2">
                        <label for="company">Company:</label>
                        <input type="text" id="company" name="company" class="form-control" required>
                        <div class="invalid-feedback">Please enter your company name.</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="phone_marketing">Phone:</label>
                        <input type="text" id="phone_marketing" name="phone" class="form-control" required>
                        <div class="invalid-feedback">Please enter your phone number.</div>
                    </div>`;
                break;
            case 'admin':
                additionalFields.innerHTML += `
                    <div class="form-group mb-2">
                        <label for="id_number">ID Number:</label>
                        <input type="number" id="id_number" name="id_number" class="form-control" required>
                        <div class="invalid-feedback">Please enter your ID number.</div>
                    </div>`;
                break;
            default:
                break;
        }
    });

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
</script>


<?php include('../includes/footer.php'); ?>