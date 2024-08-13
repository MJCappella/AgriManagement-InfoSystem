<?php
include_once('../config/config.php');
include('../includes/header.php');
?>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 40vh;">
    <div class="text-center">
        <h2 class="text-danger mb-4"><i class="bi bi-exclamation-triangle-fill"></i> 404 - Page Not Found</h2>
        <p class="lead">The page you are looking for does not exist.</p>
        <a href="<?php echo BASE_URL . '/pages/home.php' ?>" class="btn btn-primary mt-3">Go to Homepage</a>
    </div>
</div>
<?php
include('../includes/footer.php');
?>
