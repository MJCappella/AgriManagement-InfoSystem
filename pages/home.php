<?php
include_once('../config/config.php');
include_once('../includes/header.php');
?>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">AMIS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="#advantages">Advantages</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="btn btn-outline-primary" href="#login">Login</a></li>
                <li class="nav-item"><a class="btn btn-primary ml-2" href="#signup">Sign Up</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div>
            <h1>Welcome to the Agriculture Marketing Information System</h1>
            <button class="btn btn-info mt-3" onclick="showWelcomeMessage()">Learn More</button>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services container">
        <div class="row">
            <div class="col-md-6 d-flex align-items-center">
                <img src="http://localhost/amis-project-/uploads/images/crops/default.jpg" class="img-fluid" alt="Farmers">
                <div class="ml-4">
                    <h3>For Farmers</h3>
                    <p>Track your yields, advertise your products, and sell to a large audience.</p>
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <div class="ml-4">
                    <h3>For Buyers</h3>
                    <p>Access numerous sellers, buy from them, and get regular updates on the latest crops.</p>
                </div>
                <img src="http://localhost/amis-project-/uploads/images/crops/default.jpg" class="img-fluid" alt="Buyers">
            </div>
            <!-- Add more service items as needed -->
        </div>
    </section>

    <!-- Advantages Section -->
    <section id="advantages" class="advantages container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Advantage 1</h5>
                        <p class="card-text">Detailed description of the advantage.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Advantage 2</h5>
                        <p class="card-text">Detailed description of the advantage.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Advantage 3</h5>
                        <p class="card-text">Detailed description of the advantage.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <p>&copy; 2024 Agriculture Marketing Information System. All rights reserved.</p>
            <a href="#policy">Policy</a> | <a href="#terms">Terms</a> | <a href="#about">About Us</a> | <a href="#faq">FAQ</a>
        </div>
    </footer>

    <!-- Go to Top Button -->
    <button class="go-to-top" onclick="scrollToTop()"><i class="fas fa-arrow-up"></i></button>

    <script>
        function showWelcomeMessage() {
            alert('Welcome to the Agriculture Marketing Information System!');
        }

        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>

<?php include_once('../includes/footer.php'); ?>