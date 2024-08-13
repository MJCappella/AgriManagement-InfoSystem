<?php
include_once("../../config/config.php");
$pageTitle = 'Admin Dashboard';
$logoutButton = true;
include_once('../../includes/auth.php');
ensureLoggedIn(['admin']);
include_once('../../includes/header.php');
?>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <!-- sidebar -->
            <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 250px;">
                <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                    <span class="fs-4">Admin Dashboard</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link link-dark" id="dashboard" onclick="loadDashboard(this)">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-dark" id="manage-users" onclick="loadManageUsers(this)">
                            Manage Users
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-dark" onclick="loadManageCrops(this)">
                            Manage Crops
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-dark" onclick="loadManageReports(this)">
                            View Reports
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-dark" onclick="loadSubscribersMessaging(this)">
                            Message Subscribers
                        </a>
                    </li>
                </ul>
                <hr>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle"
                        id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                        <strong>Admin <?php echo $_SESSION['username'] ?></strong>
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
            <div id="main-content">
                <!-- Initial dashboard content -->
            </div>
        </main>
        <!-- Add Crop Modal -->
        <div class="modal fade" id="addCropModal" tabindex="-1" aria-labelledby="addCropModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCropModalLabel">Add New Crop</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addCropForm">
                            <div class="mb-3">
                                <label for="add_cropname" class="form-label">Crop Name</label>
                                <input type="text" class="form-control" id="add_cropname" name="cropname" required>
                            </div>
                            <div class="mb-3">
                                <label for="add_description" class="form-label">Description</label>
                                <textarea class="form-control" id="add_description" name="description" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="add_price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="add_price" name="price" step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label for="add_crop_image" class="form-label">Crop Image</label>
                                <input type="file" class="form-control" id="add_crop_image" name="crop_image">
                            </div>
                            <button type="submit" class="btn btn-primary">Add Crop</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Crop Modal -->
        <div class="modal fade" id="updateCropModal" tabindex="-1" aria-labelledby="updateCropModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateCropModalLabel">Update Crop</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="updateCropForm">
                            <input type="hidden" id="update_crop_id">
                            <div class="mb-3">
                                <label for="update_cropname" class="form-label">Crop Name</label>
                                <input type="text" class="form-control" id="update_cropname" name="cropname" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="update_description" class="form-label">Description</label>
                                <textarea class="form-control" id="update_description" name="description" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="update_price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="update_price" name="price" step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label for="update_crop_image" class="form-label">Crop Image</label>
                                <input type="file" class="form-control" id="update_crop_image" name="crop_image">
                                <!-- Image Preview -->
                                <div class="mt-2">
                                    <img id="crop_image_preview" src="" alt="Current Crop Image" class="img-fluid" style="display: none;" />
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Crop</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Delete Crop Modal -->
        <div class="modal fade" id="deleteCropModal" tabindex="-1" aria-labelledby="deleteCropModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteCropModalLabel">Delete Crop</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete <strong id="delete_cropname"></strong>?</p>
                        <input type="hidden" id="delete_crop_id">
                        <button type="button" class="btn btn-danger" onclick="confirmDeleteCrop()">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<style>
    /* Custom styles for the spinner */
    .spinner-border {
        border-width: 0.25em;
    }

    /* Custom styles for message titles */
    .bg-primary {
        background-color: #007377 !important;
    }

    .text-white {
        color: #ffffff !important;
    }

    /* Optional: For better visibility of loading text */
    #loadingSpinner p {
        color: #007377;
    }

    /* Add custom styles for the user type containers */
    .user-type-container {
        margin-bottom: 30px;
    }

    .user-type-title {
        display: flex;
        align-items: center;
        font-size: 1.5rem;
        font-weight: bold;
        color: #007377;
        /* Dark cyan color */
    }

    .user-type-icon {
        width: 30px;
        height: 30px;
        margin-right: 10px;
        /* Add a border or shadow to the icons if needed */
        border-radius: 50%;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Add custom styles for the tables */
    .table {
        border-collapse: separate;
        border-spacing: 0 1em;
    }

    .table thead th {
        background-color: #007377;
        /* Dark cyan color */
        color: white;
    }

    .table tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
        /* Light gray */
    }

    .table tbody tr:hover {
        background-color: #e0f7fa;
        /* Light cyan */
    }

    .card {
        width: 250px;
        margin: 15px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        padding: 15px;
        text-align: center;
        position: relative;
    }

    .card .value {
        font-size: 2em;
        margin-bottom: 10px;
    }

    .card .progress-bar {
        position: absolute;
        left: 0px;
        width: 100%;
        height: 4px;
        background-color: #e0e0e0;
        border-radius: 5px;
        overflow: hidden;
        bottom: 0px;
    }

    .card .progress-bar .fill {
        height: 100%;
        width: 0;
        background-color: #76c7c0;
        transition: width 2s ease-in-out;
    }

    .card.usd .fill {
        background-color: #00FF00;
    }

    .card.gbp .fill {
        background-color: #0000FF;
    }

    .card.eur .fill {
        background-color: #FFFF00;
    }

    .card.cad .fill {
        background-color: #FF0000;
    }

    .card::before {
        content: attr(data-currency);
        font-size: 1.2em;
        color: #555;
        display: block;
        margin-bottom: 5px;
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
        background-color: #f67019;
        /* Lighter Blue */
        color: white !important;
    }

    .sidebar .nav-link:hover {
        background-color: #f67019;
        /* Slightly darker blue */
    }

    .sidebar .dropdown-toggle {
        color: white;
    }

    .sidebar .dropdown-menu {
        background-color: #007377;
        /* Dark Blue */
    }

    .sidebar .dropdown-menu .dropdown-item {
        color: white;
    }

    .sidebar .dropdown-menu .dropdown-item:hover {
        background-color: #007377;
        /* Lighter Blue */
    }

    /* Modal Header */
    .modal-header {
        background-color: #007377 !important;
        /* Dark Blue */
        color: white;
    }

    /* Modal Footer Buttons */
    .modal-footer .btn-secondary {
        background-color: #f67019;
        /* Slightly darker blue */
        border-color: #007377;
    }

    .modal-footer .btn-danger {
        background-color: #cc0000;
        /* Red */
        border-color: #cc0000;
    }

    .btn-close {
        background-color: #e0e0e0;
    }

    .visually-hidden {
        background-color: #007377;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="module">
    import {
        Utils
    } from './utils.js';
    window.Utils = Utils;
</script>
<?php include("../../assets/js/admin.script.js.php") ?>
<?php include('../../includes/footer.php') ?>
</body>

</html>