<?php
$pageTitle = "About Us";
include('../config/config.php');
include('../includes/header.php');
?>
<main class="container my-5">
    <section data-aos="fade-up">
        <h1 class="fw-bold text-center mb-4">About AMIS</h1>
        <p class="text-center mb-5">Learn more about our mission, vision, and the people behind the Agriculture Marketing Information System.</p>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <h2 class="fw-bold d-flex align-items-center">Our Mission</h2>
                <p>Our mission is to connect farmers, buyers, marketers, and government agencies through a robust information system that promotes efficiency and transparency in the agricultural market.</p>
            </div>
            <div class="col-lg-6 mb-4">
                <h2 class="fw-bold d-flex align-items-center"> Our Vision</h2>
                <p>We envision a future where the agricultural market operates seamlessly, ensuring that all stakeholders can access the information they need to thrive in their respective roles.</p>
            </div>
        </div>

        <div class="row my-5">
            <div class="col-lg-12">
                <h2 class="fw-bold text-center">Our Team</h2>
                <div class="row text-center">
                    <div class="col-md-4 mb-4">
                        <img src="<?php echo BASE_URL; ?>/assets/images/profile.jpg" alt="John Doe - CEO" class="rounded-circle mb-3 shadow" width="150">
                        <h5>Essy Ngero</h5>
                        <p class="text-muted">CEO</p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <img src="<?php echo BASE_URL; ?>/assets/images/profile2.jpg" alt="Jane Smith - CTO" class="rounded-circle mb-3 shadow" width="150">
                        <h5>Jane Smith</h5>
                        <p class="text-muted">CTO</p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <img src="<?php echo BASE_URL; ?>/assets/images/profile3.jpg" alt="Emily Johnson - COO" class="rounded-circle mb-3 shadow" width="150">
                        <h5>Emily Johnson</h5>
                        <p class="text-muted">COO</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-5">
            <div class="col-lg-12">
                <h2 class="fw-bold text-center">Our Story</h2>
                <p class="text-center">Our journey began with a vision to revolutionize the agricultural market by bridging the gap between farmers, buyers, and market professionals. Over the years, we have grown into a trusted platform that empowers all stakeholders to make informed decisions and succeed in their endeavors.</p>
                <!-- Toast Container -->
                <div aria-live="polite" aria-atomic="true" class="position-relative">
                    <div class="toast-container position-fixed bottom-0 end-0 p-3" id="toastContainer">
                        <div id="storyToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                            <div class="toast-header">
                                <strong class="me-auto">Notification</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <div class="toast-body">
                                Stay tuned! Our full story is coming soon.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Button to Trigger Toast -->
                <div class="text-center mt-4">
                    <button class="btn btn-primary" onclick="showStoryToast()">Read Our Full Story</button>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    function showStoryToast() {
        var toastElement = document.getElementById('storyToast');
        var toast = new bootstrap.Toast(toastElement);
        toast.show();
    }
</script>
<?php include('../includes/footer.php'); ?>
