<?php
include_once("../../config/config.php");
$pageTitle = 'Transporter Dashboard';
$logoutButton = true;
include_once('../../includes/auth.php');
ensureLoggedIn(['transporter']);
include_once('../../includes/header.php');
?>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <!-- sidebar -->
            <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 250px;">
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                    <span class="fs-4">Transporter Dashboard</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="/amis-project-/pages/transporter_dashboard.php" class="nav-link active">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="/amis-project-/pages/transport_schedule.php" class="nav-link link-dark">
                            Transport Schedule
                        </a>
                    </li>
                    <li>
                        <a href="/amis-project-/pages/track_shipments.php" class="nav-link link-dark">
                            Track Shipments
                        </a>
                    </li>
                    <li>
                        <a href="/amis-project-/pages/available_routes.php" class="nav-link link-dark">
                            Available Routes
                        </a>
                    </li>
                    <li>
                        <a href="/amis-project-/pages/account_settings.php" class="nav-link link-dark">
                            Account Settings
                        </a>
                    </li>
                </ul>
                <hr>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle"
                        id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                        <strong>Transporter Name</strong>
                    </a>
                    <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="/amis-project-/pages/routes.php" method="post">
                                <input type="hidden" name="action" value="logout">
                                <button type="submit" class="dropdown-item">
                                    Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
            </div>

            <!-- Main content here -->
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Transport Schedule</h5>
                            <p class="card-text">View and manage your transport schedule.</p>
                            <a href="/amis-project-/pages/transport_schedule.php" class="btn btn-primary">View Schedule</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Track Shipments</h5>
                            <p class="card-text">Track your current shipments.</p>
                            <a href="/amis-project-/pages/track_shipments.php" class="btn btn-primary">Track Shipments</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Available Routes</h5>
                            <p class="card-text">Explore available transport routes.</p>
                            <a href="/amis-project-/pages/available_routes.php" class="btn btn-primary">View Routes</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include('../../includes/footer.php') ?>
</body>
</html>
