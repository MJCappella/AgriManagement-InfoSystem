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
                <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                    <img src="http://localhost/amis-project-/assets/images/transporter.png" width="50" height="50" alt="Transporter Logo" class="me-2">
                    <span class="fs-4">Transporter Dashboard</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link link-dark" id="dashboard" onclick="loadDashboard(this)">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-dark" onclick="loadSchedules(this)">
                            Transport Schedule
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-dark" onclick="loadShipments(this)">
                            View Shipments
                        </a>
                    </li>
                </ul>
                <hr>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle"
                        id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                        <strong><?php echo $_SESSION['username'] ?></strong>
                    </a>
                    <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
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
    </div>
</div>

<style>
    /* body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 20px;
        } */
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
        background-color: #2ec4b6;
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

    .sidebar {
        background-color: #081c15;
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
        background-color: #1b4332;
        /* Lighter Blue */
        color: white !important;
    }

    .sidebar .nav-link:hover {
        background-color: #1b4332;
        /* Slightly darker blue */
    }

    .sidebar .dropdown-toggle {
        color: white;
    }

    .sidebar .dropdown-menu {
        background-color: #1b4332;
        /* Dark Blue */
    }

    .sidebar .dropdown-menu .dropdown-item {
        color: white;
    }

    .sidebar .dropdown-menu .dropdown-item:hover {
        background-color: #1b4332;
        /* Lighter Blue */
    }

    /* Modal Header */
    .modal-header {
        background-color: #1b4332 !important;
        /* Dark Blue */
        color: white;
    }

    /* Modal Footer Buttons */
    .modal-footer .btn-secondary {
        background-color: #00264d;
        /* Slightly darker blue */
        border-color: #1b4332;
    }

    .modal-footer .btn-danger {
        background-color: #cc0000;
        /* Red */
        border-color: #cc0000;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="module">
    import {
        Utils
    } from './utils.js';
    window.Utils = Utils;
</script>
<?php include("../../assets/js/transporter.script.js.php") ?>
<?php include('../../includes/footer.php') ?>
</body>

</html>