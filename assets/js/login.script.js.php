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
    console.log($('#user_type option:selected').text());

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
            window.location.href = '../pages/dashboards/' + $('#user_type option:selected').text().trim().toLowerCase() + '_dashboard.php';
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

  function scrollToTop() {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  }
</script>