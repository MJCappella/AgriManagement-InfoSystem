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

    function submitRegForm() {
        var myForm = document.getElementById('registration-form');

        if (myForm.checkValidity() === false) {
            myForm.classList.add('was-validated');
            return;
        }

        myForm.classList.remove('was-validated');

        $('#v_action').val('verify-code');
        $('#v_user_type').val($('#user_type').val());
        $('#v_email').val($('#email').val());
        var formData = $(myForm).serialize();
        if ($('#enable_2fa').prop('checked')) {
            formData = formData.substring(0, formData.lastIndexOf('&'));
            formData += '&enable_2fa=true';
        } else {
            formData += '&enable_2fa=false';
        }
        console.log(formData);
        $.ajax({
            url: '/amis-project-/pages/routes.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                var data = JSON.parse(response);
                var registrationSuccessful = data.success;
                var alertPlaceholder = $('#alert-placeholder');
                console.log(data);
                if (registrationSuccessful) {
                    if ($('#enable_2fa').is(':checked')) {
                        $('#registration-form').hide();
                        $('#verification-section').show();
                        alertPlaceholder.html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                    } else {
                        alertPlaceholder.html('<div class="alert alert-success" role="alert">' + data.message + ' Redirecting...</div>');
                        setTimeout(() => {
                            window.location.href = 'login.php';
                        }, 1000);
                    }
                } else {
                    alertPlaceholder.html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Registration error:', error);
                $('#alert-placeholder').html('<div class="alert alert-danger" role="alert">An error occurred during registration. Please try again.</div>');
            }
        });
    }

    function submitVerificationForm() {
        var verificationForm = document.getElementById('verification-form');

        if (verificationForm.checkValidity() === false) {
            verificationForm.classList.add('was-validated');
            return;
        }

        verificationForm.classList.remove('was-validated');

        var formData = $(verificationForm).serialize();
        console.log(formData);
        $.ajax({
            url: '/amis-project-/pages/routes.php', // Update with your verification endpoint
            type: 'POST',
            data: formData,
            success: function(response) {
                var data = JSON.parse(response);
                var verificationSuccessful = data.success;
                var alertPlaceholder = $('#alert-placeholder');
                console.log(data);
                if (verificationSuccessful) {
                    alertPlaceholder.html('<div class="alert alert-success" role="alert">' + data.message + ' Redirecting...</div>');
                    setTimeout(() => {
                        window.location.href = 'login.php';
                    }, 1000);
                } else {
                    alertPlaceholder.html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Verification error:', error);
                $('#alert-placeholder').html('<div class="alert alert-danger" role="alert">An error occurred during verification. Please try again.</div>');
            }
        });
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
</script>