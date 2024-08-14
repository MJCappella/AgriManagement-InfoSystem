<?php
include_once("../../config/config.php");
$pageTitle = 'Farmers Dashboard';
$logoutButton = true;
include_once('../../includes/auth.php');
ensureLoggedIn(['farmer']);
include_once('../../includes/header.php');
?>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 250px;">
                <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                    <span class="fs-4">Farmer Dashboard</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link link-dark" id="dashboard" onclick="loadDashboard(this)">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-dark" onclick="loadCrops(this)">
                            View Crops
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-dark" onclick="loadMarketPrices(this)">
                            Market Prices
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-dark" onclick="loadCropYields(this)">
                            Crop yields
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-dark" onclick="loadAdverts(this)">
                            Advertise crops
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-dark" onclick="loadOrders(this)">
                            Manage Orders
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-dark" onclick="loadTransporters(this)">
                            Transporters
                        </a>
                    </li>
                </ul>
                <hr>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                        <strong><?php echo $_SESSION['username'] ?></strong>
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
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
            </div>

            <div id="main-content">
                <!-- Initial dashboard content -->
            </div>
        </main>
        <!--Alerts -->
        <!-- Confirm Modal -->
        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Confirm Action</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this advert?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert Modal -->
        <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="alertModalLabel">Notification</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="alertModalBody">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    body {
        background-color: #f7f7f7;
    }
    .sidebar {
        background-color: #004d00;
        color: white;
    }
    .sidebar .nav-link {
        color: white;
    }
    .sidebar .nav-link.active, .nav-link:hover {
        background-color: #006600;
        color: white !important; /* Ensures the color stays white */
    }
    .sidebar .nav-link:hover {
        background-color: #005500;
    }
    .dropdown-toggle {
        color: white;
    }
    .dropdown-menu {
        background-color: #004d00;
    }
    .dropdown-menu .dropdown-item {
        color: white;
    }
    .dropdown-menu .dropdown-item:hover {
        background-color: #006600;
    }
    .modal-header {
        background-color: #004d00;
        color: white;
    }
    .modal-footer .btn-secondary {
        background-color: #005500;
        border-color: #005500;
    }
    .modal-footer .btn-danger {
        background-color: #ff0000;
        border-color: #ff0000;
    }
    .btn-primary {
        background-color: #006600;
        border-color: #006600;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="module">
    import {
        Utils
    } from './utils.js';
    window.Utils = Utils;
</script>
<?php include("../../assets/js/farmer.script.js.php") ?>

</body>

</html>