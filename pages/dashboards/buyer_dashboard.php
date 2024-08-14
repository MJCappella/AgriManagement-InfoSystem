<?php
include_once("../../config/config.php");
$pageTitle = 'Buyers Dashboard';
$logoutButton = true;
include_once('../../includes/auth.php');
ensureLoggedIn(['buyer']);
include_once('../../includes/header.php');
?>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <!-- sidebar -->
            <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 250px;">
                <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                    <span class="fs-4">Buyer Dashboard</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link link-dark" id="dashboard" onclick="loadDashboard(this)">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-dark" onclick="orderCrops(this)">
                            Order Crops
                        </a>
                    </li>
                    <li>
                        <a onclick="loadMarketPrices(this)" class="nav-link link-dark">
                            Market Prices
                        </a>
                    </li>
                    <li>
                        <a onclick="loadOrders(this)" class="nav-link link-dark">
                            Manage Orders
                        </a>
                    </li>
                    <li>
                        <a onclick="loadEngagements(this)" class="nav-link link-dark">
                            Engagement Marketers
                        </a>
                    </li>
                </ul>
                <hr>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                        <strong><?php echo $_SESSION['username'] ?></strong>
                    </a>
                    <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                        <!-- <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li> -->
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
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
                <div class="d-flex align-items-center">
                    <span class="me-2">Market Updates</span>
                    <label class="form-switch small-switch">
                        <input type="checkbox" id="subscriptionSwitch" onclick="toggleSubscription()">
                        <i></i>
                    </label>
                    <span id="subscriptionStatus" class="ms-2 fs-6 text-muted">Subscribe</span>
                </div>
            </div>


            <div id="main-content">
                <!-- Initial dashboard content -->
            </div>

        </main>
        <!-- Order Crop Modal -->
        <div class="modal fade" id="orderCropModal" tabindex="-1" aria-labelledby="orderCropModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderCropModalLabel">Order Crop</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="orderCropForm">
                            <input type="hidden" id="order_advert_id">
                            <div class="mb-3">
                                <label for="order_quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="order_quantity" name="quantity" min="1" required>
                                <div class="form-text">Must be less than the available quantity.</div>
                            </div>
                            <div class="mb-3">
                                <!-- <label for="order_unit" class="form-label">Unit</label> -->
                                <!-- <input type="text" class="form-control" id="order_unit" name="unit" readonly> -->
                                <label for="add_unit" class="form-label fw-bold">Unit</label>
                                <select class="form-select" id="add_unit" name="add_unit" required></select>
                            </div>
                            <div class="mb-3">
                                <label for="estimated_cost" class="form-label">Estimated Cost</label>
                                <input type="text" class="form-control" id="estimated_cost" readonly>
                            </div>
                            <button type="submit" class="btn btn-primary">Place Order</button>
                        </form>
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
    .form-switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 20px;
        margin-bottom: 0;
    }

    .form-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .form-switch i {
        position: absolute;
        top: 3px;
        left: 3px;
        right: 3px;
        bottom: 3px;
        background-color: #ccc;
        border-radius: 20px;
        transition: 0.4s;
    }

    .form-switch i:before {
        position: absolute;
        content: "";
        height: 14px;
        width: 14px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        border-radius: 50%;
        transition: 0.4s;
    }

    .form-switch input:checked+i {
        background-color: #28a745;
    }

    .form-switch input:checked+i:before {
        transform: translateX(20px);
    }

    #subscriptionStatus {
        font-size: 0.9rem;
    }

    /* Sidebar Styles */
    .sidebar {
        background-color: #003366;
        /* Dark Blue */
        color: white;
    }

    .sidebar .nav-link {
        color: white;
        padding: 10px 15px;
        border-radius: 5px;
        margin-bottom: 5px;
    }

    .sidebar .nav-link.active,
    .sidebar .nav-link:hover {
        background-color: #004080;
        /* Lighter Blue */
        color: white !important;
    }

    .sidebar .nav-link:hover {
        background-color: #00264d;
        /* Slightly darker blue */
    }

    .sidebar .dropdown-toggle {
        color: white;
    }

    .sidebar .dropdown-menu {
        background-color: #003366;
        /* Dark Blue */
    }

    .sidebar .dropdown-menu .dropdown-item {
        color: white;
    }

    .sidebar .dropdown-menu .dropdown-item:hover {
        background-color: #004080;
        /* Lighter Blue */
    }

    /* Modal Header */
    .modal-header {
        background-color: #003366 !important;
        /* Dark Blue */
        color: white;
    }

    /* Modal Footer Buttons */
    .modal-footer .btn-secondary {
        background-color: #00264d;
        /* Slightly darker blue */
        border-color: #00264d;
    }

    .modal-footer .btn-danger {
        background-color: #cc0000;
        /* Red */
        border-color: #cc0000;
    }

    /* Primary Button */
    .btn-primary {
        background-color: #004080;
        /* Lighter Blue */
        border-color: #004080;
    }
</style>
<?php include("../../assets/js/buyer.script.js.php") ?>

<?php include('../../includes/footer.php') ?>
</body>

</html>