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
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                    <span class="fs-4">Farmer Dashboard</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link active" onclick="loadDashboard(this)">
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
                        <a href="#" class="nav-link link-dark" onclick="loadTransportInfo(this)">
                            Transportation Info
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-dark" onclick="loadAccountSettings(this)">
                            Account Settings
                        </a>
                    </li>
                </ul>
                <hr>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                        <strong>Farmer Name</strong>
                    </a>
                    <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
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
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Market Prices</h5>
                                <p class="card-text">Check the latest market prices for your crops.</p>
                                <a href="#" class="btn btn-primary" onclick="loadMarketPrices(this)">View Prices</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Crop Yields</h5>
                                <p class="card-text">Track your crop yields over time.</p>
                                <a href="#" class="btn btn-primary" onclick="loadCrops(this)">View Yields</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Transportation</h5>
                                <p class="card-text">Access transportation information for your crops.</p>
                                <a href="#" class="btn btn-primary" onclick="loadTransportInfo(this)">View Transportation</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    function setActiveLink(element) {
        let links = document.querySelectorAll('.nav-link');
        links.forEach(link => link.classList.remove('active'));
        element.classList.add('active');
    }

    function loadDashboard(element) {
        setActiveLink(element);
        document.getElementById('main-content').innerHTML = `
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Market Prices</h5>
                            <p class="card-text">Check the latest market prices for your crops.</p>
                            <a href="#" class="btn btn-primary" onclick="loadMarketPrices()">View Prices</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Crop Yields</h5>
                            <p class="card-text">Track your crop yields over time.</p>
                            <a href="#" class="btn btn-primary" onclick="loadCrops()">View Yields</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Transportation</h5>
                            <p class="card-text">Access transportation information for your crops.</p>
                            <a href="#" class="btn btn-primary" onclick="loadTransportInfo()">View Transportation</a>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    function loadCrops(element) {
        setActiveLink(element);
        document.getElementById('main-content').innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
        
        $.ajax({
            url: 'http://localhost/amis-project-/pages/routes.php',
            type: 'POST',
            data: { action: 'get-crops' },
            success: function(response) {
                var responseData = JSON.parse(response);
                if (responseData.success) {
                    var cropCards = responseData.crops.map(function(crop) {
                        console.log(crop.image_path);
                        return `
                            <div class="col-12 col-md-6 col-lg-4 mb-4">
                                <div class="card shadow-sm">
                                    <img src="${crop.image_path}" class="card-img-top" alt="${crop.cropname}" style="height: 300px;">
                                    <div class="card-body">
                                        <h5 class="card-title">${crop.cropname}</h5>
                                        <p class="card-text">${crop.description}</p>
                                        <p class="card-text"><strong>Price: </strong>${crop.price}</p>
                                        <p class="card-text"><small class="text-muted">Added on ${crop.created_at}</small></p>
                                    </div>
                                </div>
                            </div>
                        `;
                    }).join('');
                    document.getElementById('main-content').innerHTML = `
                        <h2>View Crops</h2>
                        <div class="row">
                            ${cropCards}
                        </div>
                    `;
                } else {
                    document.getElementById('main-content').innerHTML = `<div class="alert alert-danger">Error: ${responseData.message}</div>`;
                }
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + error);
                document.getElementById('main-content').innerHTML = '<div class="alert alert-danger">An error occurred while fetching crop data. Please try again later.</div>';
            }
        });
    }

    function loadMarketPrices(element) {
        setActiveLink(element);
        document.getElementById('main-content').innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
        
        $.ajax({
            url: 'http://localhost/amis-project-/pages/routes.php',
            type: 'POST',
            data: { action: 'get-market-prices' },
            success: function(response) {
                var responseData = JSON.parse(response);
                if (responseData.success) {
                    var tableContent = responseData.data.map(function(item) {
                        return `
                            <tr>
                                <td>${item.price_id}</td>
                                <td>${item.crop_id}</td>
                                <td>${item.price}</td>
                                <td>${item.status}</td>
                                <td>${item.date}</td>
                            </tr>
                        `;
                    }).join('');
                    document.getElementById('main-content').innerHTML = `
                        <h2>Market Prices</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Price ID</th>
                                        <th>Crop ID</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${tableContent}
                                </tbody>
                            </table>
                        </div>
                    `;
                } else {
                    document.getElementById('main-content').innerHTML = `<div class="alert alert-danger">Error: ${responseData.message}</div>`;
                }
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + error);
                document.getElementById('main-content').innerHTML = '<div class="alert alert-danger">An error occurred while fetching market prices. Please try again later.</div>';
            }
        });
    }
</script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>