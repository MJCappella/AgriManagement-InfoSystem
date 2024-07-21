<?php
include_once('../config/config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Agriculture Marketing Information System connecting farmers, buyers, and market professionals">
    <meta name="keywords" content="agriculture, marketing, information, system, farmers, buyers">
    <meta name="author" content="Your Name">
    <title>Home</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/scripts.js" defer></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/popper.min.js" defer></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/d3.min.js" defer></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Proxima+Nova:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js" defer></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            AOS.init();
        });
    </script>

    <style>
        body {
            font-family: 'Proxima Nova', sans-serif;
        }

        #scrollToTopBtn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            border: none;
            outline: none;
            background-color: #007377;
            color: white;
            cursor: pointer;
            padding: 15px;
            border-radius: 10px;
        }

        #scrollToTopBtn:hover {
            background-color: #555;
        }

        .bg-body-tertiary {
            background-color: #f8f9fa !important;
        }

        .list-unstyled li {
            font-size: 1.2rem;
            display: flex;
            align-items: center;
        }

        .list-unstyled li i {
            margin-right: 10px;
        }

        .featurette-image {
            border-radius: 15px;
        }
        #my-nav{
        background-color: #f3f9f9 !important;
        }
        .text-content .full-text {
    display: none;
}

.read-more-btn {
    cursor: pointer;
}

    </style>
</head>

<body class="d-flex flex-column h-100">
    <div>

        <!-- Navigation -->
        <nav id="my-nav" class="navbar navbar-expand-lg navbar-light bg-light" data-aos="fade-down">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><img width="36" src="<?php echo BASE_URL; ?>/assets/images/logo.png" alt="Logo">&nbsp;AMIS</a>
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
                            <a class="nav-link" href="login.php"><i class="fa fa-lock"></i>&nbsp; Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Sign Up</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="container-fluid bg-dark text-white text-center d-flex align-items-center justify-content-center" style="background-image: url('<?php echo BASE_URL; ?>/uploads/images/crops/default.jpg'); background-size: cover; height: 70vh; background-position: center;" data-aos="fade-up">
            <div>
                <h1 class="display-4">Welcome to the Agriculture Marketing Information System</h1>
                <p class="lead">Connecting Farmers, Buyers, and Market Professionals</p>
                <a href="register.php" class="btn btn-info btn-lg">Get Started</a>
            </div>
        </div>

        <!-- Mission and Core values -->
        <div class="container marketing text-center mt-4">
            <div class="row">
                <div class="col-lg-4" data-aos="fade-right">
                    <img class="bd-placeholder-img rounded-circle" src="<?php echo BASE_URL; ?>/assets/images/harvest2.png" width="140" height="140" alt="Our Mission" />
                    <h2 class="fw-normal">Our Mission</h2>
                    <p>Our mission is to empower farmers, buyers, marketing professionals, government agencies, and transporters by providing a comprehensive platform that facilitates efficient, transparent, and profitable agricultural transactions and interactions. We aim to promote sustainable agriculture practices by offering real-time market data, trends, and insights, enhancing market accessibility and ensuring fair pricing and increased market efficiency.</p>
                    <p><a class="btn btn-secondary" href="#">Read More &raquo;</a></p>
                </div><!-- /.col-lg-4 -->
                <div class="col-lg-4" data-aos="fade-up">
                    <img class="bd-placeholder-img rounded-circle" src="<?php echo BASE_URL; ?>/assets/images/grocery.jpg" width="140" height="140" alt="Our Vision" />
                    <h2 class="fw-normal">Our Vision</h2>
                    <p>Our vision is to create a thriving agricultural community where technology and innovation drive growth, sustainability, and prosperity. We aspire to be the global leader in agricultural market solutions, transforming the marketing, trading, and consumption of agricultural products, fostering a sustainable and equitable agricultural ecosystem that enhances food security and promotes economic development.</p>
                    <p><a class="btn btn-secondary" href="#">Read More &raquo;</a></p>
                </div><!-- /.col-lg-4 -->
                <div class="col-lg-4" data-aos="fade-left">
                    <img class="bd-placeholder-img rounded-circle" src="<?php echo BASE_URL; ?>/assets/images/stock-market.jpg" width="140" height="140" alt="Our Goal" />
                    <h2 class="fw-normal">Our Goal</h2>
                    <p>We uphold the highest standards of integrity, ensuring honesty and accountability in all our operations. Committed to continuous innovation, we leverage cutting-edge technologies to meet the evolving needs of the agricultural community. We believe in collaboration, building strong relationships with all stakeholders, and promoting sustainable practices that protect the environment. Our customer-centric approach ensures we deliver exceptional value and support, fostering a prosperous agricultural ecosystem.</p>
                    <p><a class="btn btn-secondary" href="#">Read More &raquo;</a></p>
                </div><!-- /.col-lg-4 -->
            </div><!-- /.row -->
        </div>

        <!-- Featurettes -->
        <div class="container">

            <hr class="featurette-divider">

            <div class="row featurette" data-aos="fade-right">
                <div class="col-md-7">
                    <h2 class="featurette-heading fw-normal lh-1">We help farmers</h2>
                    <p class="lead">Track your yields, advertise your products, and sell directly to buyers.</p>
                </div>
                <div class="col-md-5">
                    <img src="http://localhost/amis-project-/assets/images/farmers.png" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" role="img" aria-label="Placeholder: 500x500" />
                </div>
            </div>

            <hr class="featurette-divider">

            <div class="row featurette" data-aos="fade-left">
                <div class="col-md-5">
                    <img src="http://localhost/amis-project-/assets/images/crops.png" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" role="img" aria-label="Placeholder: 500x500" />
                </div>
                <div class="col-md-7">
                    <h2 class="featurette-heading fw-normal lh-1">We help buyers</h2>
                    <p class="lead">Access numerous sellers, buy from them, and get regular updates on the latest crops.</p>
                </div>
            </div>

            <hr class="featurette-divider">

            <div class="row featurette" data-aos="fade-right">
                <div class="col-md-7">
                    <h2 class="featurette-heading fw-normal lh-1">We help transporters</h2>
                    <p class="lead">Connect with farmers and buyers to provide efficient transportation services.</p>
                </div>
                <div class="col-md-5">
                    <img src="http://localhost/amis-project-/assets/images/lorry.png" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" role="img" aria-label="Placeholder: 500x500" />
                </div>
            </div>

            <hr class="featurette-divider">

            <div class="row featurette" data-aos="fade-left">
                <div class="col-md-5">
                    <img src="http://localhost/amis-project-/assets/images/marketing.png" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" role="img" aria-label="Placeholder: 500x500" />
                </div>
                <div class="col-md-7">
                    <h2 class="featurette-heading fw-normal lh-1">We help marketing agencies</h2>
                    <p class="lead">Get real-time data and trends on the market to make informed decisions.</p>
                </div>
            </div>

            <hr class="featurette-divider">

            <div class="row featurette" data-aos="fade-right">
                <div class="col-md-7">
                    <h2 class="featurette-heading fw-normal lh-1">We help the government</h2>
                    <p class="lead">Access data and insights to support agricultural policies and programs.</p>
                </div>
                <div class="col-md-5">
                    <img src="http://localhost/amis-project-/assets/images/court-of-arms.png" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto rounded-corners" width="500" height="500" role="img" aria-label="Placeholder: 500x500" />
                </div>
            </div>
        </div>
        <hr class="featurette-divider">

    <!-- Why Choose Us Section -->
    <div class="p-5 mb-4 bg-body-tertiary rounded-3 just"  data-aos="fade-up" data-aos-delay="200" data-aos-duration="1500" style="background-color: #f8f9fa; border: 1px solid #dee2e6;">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold text-dark">Why Choose Us</h1>
            <p class="col-md-8 fs-4 text-muted">We provide a comprehensive platform that connects all stakeholders in the agricultural market. Our services are designed to enhance productivity, efficiency, and profitability for everyone involved.</p>
            <ul class="list-unstyled">
                <li class="mb-2"><i class="fas fa-chart-line text-primary"></i>&nbsp; Real-time data and insights</li>
                <li class="mb-2"><i class="fas fa-users text-success"></i>&nbsp; Wide network of buyers and sellers</li>
                <li class="mb-2"><i class="fas fa-laptop text-info"></i>&nbsp; Easy-to-use platform</li>
                <li class="mb-2"><i class="fas fa-lock text-warning"></i>&nbsp; Secure and reliable</li>
            </ul>
        </div>
    </div>


    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1500">
            <div class="row">
                <div class="col-md-4">
                    <h5>Contact Us</h5>
                    <p>Email: info@amis.com</p>
                    <p>Phone: +254 711 000 200</p>
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
                <p>&copy; 2024 Agriculture Marketing Information System. All rights reserved.</p>
            </div>
        </div>
    </footer>
    </div>

    <script>
        // Show or hide the scroll-to-top button based on scroll position
        window.onscroll = function() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                document.getElementById("scrollToTopBtn").style.display = "block";
            } else {
                document.getElementById("scrollToTopBtn").style.display = "none";
            }
        };

        // Scroll to top function
        function scrollToTop() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const readMoreButtons = document.querySelectorAll('.read-more-btn');

        readMoreButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const textContent = this.previousElementSibling;
                const fullText = textContent.querySelector('.full-text');
                const shortText = textContent.querySelector('.short-text');
                
                if (fullText.style.display === "none") {
                    fullText.style.display = "block";
                    shortText.style.display = "none";
                    this.textContent = "Read Less &laquo;";
                } else {
                    fullText.style.display = "none";
                    shortText.style.display = "block";
                    this.textContent = "Read More &raquo;";
                }
            });
        });
    });
</script>

</body>

</html>