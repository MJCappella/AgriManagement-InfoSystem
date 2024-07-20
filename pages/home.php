<?php
include_once('../config/config.php');
include_once('../includes/header.php');
?>

    <!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">AgriMarket</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Services</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="#"><i class="fa fa-lock"></i>&nbsp; Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Sign Up</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<div class="container-fluid bg-dark text-white text-center py-5" style="background-image: url('http://localhost/amis-project-/uploads/images/crops/default.jpg'); background-size: cover; background-position: center;">
  <h1 class="display-4">Welcome to AgriMarket</h1>
  <p class="lead">Connecting Farmers, Buyers, and Market Professionals</p>
  <a href="#" class="btn btn-primary btn-lg">Get Started</a>
</div>

<!-- Services Section -->
<div class="container my-5">
  <div class="row">
    <div class="col-md-4">
      <div class="card mb-4 shadow-sm">
        <img src="http://localhost/amis-project-/uploads/images/crops/default.jpg" class="card-img-top" alt="Farmers">
        <div class="card-body">
          <h5 class="card-title">For Farmers</h5>
          <p class="card-text">Track your yields, advertise your products, and sell directly to buyers.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card mb-4 shadow-sm">
        <img src="http://localhost/amis-project-/uploads/images/crops/default.jpg" class="card-img-top" alt="Buyers">
        <div class="card-body">
          <h5 class="card-title">For Buyers</h5>
          <p class="card-text">Access numerous sellers, buy from them, and get regular updates on the latest crops.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card mb-4 shadow-sm">
        <img src="http://localhost/amis-project-/uploads/images/crops/default.jpg" class="card-img-top" alt="Marketing Professionals">
        <div class="card-body">
          <h5 class="card-title">For Marketing Professionals</h5>
          <p class="card-text">Get real-time data and trends on the market to make informed decisions.</p>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="card mb-4 shadow-sm">
        <img src="http://localhost/amis-project-/uploads/images/crops/default.jpg" class="card-img-top" alt="Government">
        <div class="card-body">
          <h5 class="card-title">For Government</h5>
          <p class="card-text">Access data and insights to support agricultural policies and programs.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card mb-4 shadow-sm">
        <img src="http://localhost/amis-project-/uploads/images/crops/default.jpg" class="card-img-top" alt="Transporters">
        <div class="card-body">
          <h5 class="card-title">For Transporters</h5>
          <p class="card-text">Connect with farmers and buyers to provide efficient transportation services.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Why Choose Us Section -->
<div class="container my-5">
  <div class="row">
    <div class="col-md-6">
      <img src="http://localhost/amis-project-/uploads/images/crops/default.jpg" class="img-fluid" alt="Why Choose Us">
    </div>
    <div class="col-md-6">
      <h2>Why Choose Us</h2>
      <p>We provide a comprehensive platform that connects all stakeholders in the agricultural market. Our services are designed to enhance productivity, efficiency, and profitability for everyone involved.</p>
      <ul>
        <li>Real-time data and insights</li>
        <li>Wide network of buyers and sellers</li>
        <li>Easy-to-use platform</li>
        <li>Secure and reliable</li>
      </ul>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white py-4">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h5>Contact Us</h5>
        <p>Email: info@agrimarket.com</p>
        <p>Phone: +123 456 7890</p>
      </div>
      <div class="col-md-4">
        <h5>Important Links</h5>
        <ul class="list-unstyled">
          <li><a href="#" class="text-white">Privacy Policy</a></li>
          <li><a href="#" class="text-white">Terms of Service</a></li>
          <li><a href="#" class="text-white">About Us</a></li>
          <li><a href="#" class="text-white">FAQ</a></li>
        </ul>
      </div>
      <div class="col-md-4 text-end">
        <h5>Follow Us</h5>
        <a href="#" class="text-white me-2"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="text-white me-2"><i class="fab fa-twitter"></i></a>
        <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
      </div>
    </div>
    <div class="text-center mt-3">
      <p>&copy; 2024 AgriMarket. All rights reserved.</p>
    </div>
  </div>
</footer>

<!-- Scroll to Top Button -->
<button onclick="topFunction()" id="scrollToTopBtn" class="btn btn-dark"><i class="fas fa-arrow-up"></i></button>

<script>
  // Scroll to Top Function
  var mybutton = document.getElementById("scrollToTopBtn");
  window.onscroll = function() {scrollFunction()};

  function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
      mybutton.style.display = "block";
    } else {
      mybutton.style.display = "none";
    }
  }

  function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
  }
</script>

<?php include_once('../includes/footer.php'); ?>