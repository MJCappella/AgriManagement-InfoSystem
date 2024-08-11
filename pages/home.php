<?php
include_once('../config/config.php');
$pageTitle = 'Home';
include('../includes/header.php');
?>

        <!-- Hero Section -->
<div class="container-fluid bg-dark text-white text-center d-flex align-items-center justify-content-center hero-section" style="background-image: url('<?php echo BASE_URL; ?>/uploads/images/crops/default.jpg'); background-size: cover; height: 70vh; background-position: center;" data-aos="fade-up">
    <div class="hero-content">
        <h1 class="display-4">Welcome to the Agriculture Marketing Information System</h1>
        <p class="lead">Connecting Farmers, Buyers, and Market Professionals</p>
        <a href="register.php" class="btn btn-info btn-lg">Get Started</a>
    </div>
</div>

<style>
.hero-section {
    position: relative;
}

.hero-section::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 26, 38, .5); /* Adjust the color and opacity here */
    z-index: 1;
}

.hero-content {
    position: relative;
    z-index: 2;
}
</style>


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
                    <img class="bd-placeholder-img rounded-circle" src="<?php echo BASE_URL; ?>/assets/images/farmer.png" width="140" height="140" alt="Our Vision" />
                    <h2 class="fw-normal">Our Vision</h2>
                    <p>Our vision is to create a thriving agricultural community where technology and innovation drive growth, sustainability, and prosperity. We aspire to be the global leader in agricultural market solutions, transforming the marketing, trading, and consumption of agricultural products, fostering a sustainable and equitable agricultural ecosystem that enhances food security and promotes economic development.</p>
                    <p><a class="btn btn-secondary" href="#">Read More &raquo;</a></p>
                </div><!-- /.col-lg-4 -->
                <div class="col-lg-4" data-aos="fade-left">
                    <img class="bd-placeholder-img rounded-circle" src="<?php echo BASE_URL; ?>/assets/images/marketing.png" width="140" height="140" alt="Our Goal" />
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
                    <img src="http://localhost/amis-project-/assets/images/transporter.png" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" role="img" aria-label="Placeholder: 500x500" />
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
                    <img src="http://localhost/amis-project-/assets/images/government.png" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto rounded-corners" width="500" height="500" role="img" aria-label="Placeholder: 500x500" />
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


    <?php include('../includes/footer.php') ?>

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