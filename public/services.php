<?php
$pageTitle = "Services";
include('../config/config.php');
include('../includes/header.php');
?>
<main class="container my-5">
    <section data-aos="fade-up">
        <h1 class="fw-bold text-center mb-4">Our Services</h1>
        <p class="text-center mb-5">We offer a range of services to meet the needs of farmers, buyers, transporters, marketers, and government agencies.</p>
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-seedling text-success fa-3x mb-3"></i>
                        <h4 class="card-title">For Farmers</h4>
                        <p class="card-text">Empowering farmers with tools for market trends, yield tracking, and direct selling.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-shopping-cart text-info fa-3x mb-3"></i>
                        <h4 class="card-title">For Buyers</h4>
                        <p class="card-text">Access a marketplace with various crops, view market trends, and manage orders.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-truck text-danger fa-3x mb-3"></i>
                        <h4 class="card-title">For Transporters</h4>
                        <p class="card-text">Manage and track transportation logistics to ensure timely delivery of goods.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-chart-line text-primary fa-3x mb-3"></i>
                        <h4 class="card-title">For Marketing Agencies</h4>
                        <p class="card-text">Leverage market data to create effective marketing strategies and campaigns.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-gavel text-warning fa-3x mb-3"></i>
                        <h4 class="card-title">For Government Agencies</h4>
                        <p class="card-text">Monitor market trends, ensure regulatory compliance, and collect vital data.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include('../includes/footer.php'); ?>
