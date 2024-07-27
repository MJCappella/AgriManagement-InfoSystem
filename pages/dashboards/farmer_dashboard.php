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
                        <a href="#" class="nav-link link-dark" onclick="loadCropYields(this)">
                            Crop yields
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

<style>
    .form-label {
        color: #007377;
    }

    .btn-primary {
        background-color: #007377;
        border-color: #007377;
    }

    .btn-primary:hover {
        background-color: #005f5a;
        border-color: #005f5a;
    }

    form#add-yield-form, form#edit-yield-form {
        margin-bottom: 15px;
    }
</style>

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
            data: {
                action: 'get-crops'
            },
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
            data: {
                action: 'get-market-prices'
            },
            success: function(response) {
                var responseData = JSON.parse(response);
                if (responseData.success) {
                    var tableContent = responseData.data.map(function(item) {
                        return `
                            <tr>
                                <td>${item.price_id}</td>
                                <td>${item.cropname}</td>
                                <td>${item.price}</td>
                                <td>${item.status}</td>
                                <td>${item.date}</td>
                            </tr>
                        `;
                    }).join('');
                    document.getElementById('main-content').innerHTML = `
                        <h2>Market Prices</h2>
                        <div class="table-responsive">
                            <table class="table display table-bordered table-hover" id="prices-table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Price ID</th>
                                        <th>Crop Name</th>
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

                    // Add sortable table functionality
                    $('#prices-table').DataTable({
                        "ordering": true,
                        "searching": true,
                        "paging": true
                    });
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

    function loadCropYields(element) {
        setActiveLink(element);
        $.ajax({
            url: 'http://localhost/amis-project-/pages/routes.php',
            type: 'POST',
            data: {
                action: 'get-yield'
            },
            success: function(response) {
                var responseData = JSON.parse(response);
                if (responseData.success) {
                    var tableContent = responseData.yields.map(function(item) {
                        return `
                        <tr data-yield-id="${item.yield_id}">
                            <td>${item.cropname}</td>
                            <td>${item.quantity}</td>
                            <td>${item.harvest_date}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="showEditYieldForm(${item.yield_id})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteYield(${item.yield_id})">Delete</button>
                            </td>
                        </tr>
                    `;
                    }).join('');
                    document.getElementById('main-content').innerHTML = `
                        <button class="btn btn-success mb-3" id="add-yield-main" onclick="showAddYieldForm()">Add Yield</button>
                        <div id="yield-form-container"></div>
                        <div id="yields-table-container">
                        <h3>Current Yields</h3>
                        <div class="table-responsive">
                            <table id="yields-table" class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Crop Name</th>
                                        <th>Quantity</th>
                                        <th>Harvest Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${tableContent}
                                </tbody>
                            </table>
                        </div>
                        </div>
                    `;


                    // Add sortable table functionality
                    $('#yields-table').DataTable({
                        "ordering": true,
                        "searching": true,
                        "paging": true
                    });

                    loadCropOptions(); // Load crop options for select field
                } else {
                    document.getElementById('main-content').innerHTML = `<div class="alert alert-danger">Error: ${responseData.message}</div>`;
                }
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + error);
            }
        });
    }

    function loadCropOptions() {
        $.ajax({
            url: 'http://localhost/amis-project-/pages/routes.php',
            type: 'POST',
            data: {
                action: 'get-crops'
            },
            success: function(response) {
                var responseData = JSON.parse(response);
                if (responseData.success) {
                    var options = responseData.crops.map(function(crop) {
                        return `<option value="${crop.crop_id}">${crop.cropname}</option>`;
                    }).join('');
                    document.getElementById('cropname').innerHTML = options;
                } else {
                    alert('Error: ' + responseData.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + error);
            }
        });
    }

    function showAddYieldForm() {
        $("#add-yield-main").hide();
        document.getElementById('yield-form-container').innerHTML = `
        <h3>Add New Yield</h3>
        <form id="add-yield-form" class="p-4 rounded shadow-lg bg-white">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="cropname" class="form-label fw-bold">Crop Name</label>
                    <select class="form-select" id="cropname" name="cropname" required></select>
                </div>
                <div class="col-md-4">
                    <label for="quantity" class="form-label fw-bold">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" required>
                </div>
                <div class="col-md-4">
                    <label for="harvest_date" class="form-label fw-bold">Harvest Date</label>
                    <input type="date" class="form-control" id="harvest_date" name="harvest_date" required>
                </div>
                <div class="col-12 d-flex mt-3">
                    <button type="submit" class="btn btn-primary me-2">Add Yield</button>
                    <button type="button" class="btn btn-secondary" onclick="hideYieldForm()">Cancel</button>
                </div>
            </div>
        </form>

        `;
        document.getElementById('add-yield-form').addEventListener('submit', addYield);
        loadCropOptions(); // Load crop options for select field
    }

    function showEditYieldForm(yieldId) {
        alert('edit');
        var yieldRow = document.querySelector(`tr[data-yield-id="${yieldId}"]`);
        var cropname = yieldRow.children[0].textContent;
        var quantity = yieldRow.children[1].textContent;
        var harvestDate = yieldRow.children[2].textContent;

        document.getElementById('yield-form-container').innerHTML = `
        <h3>Edit Yield</h3>
            <form id="edit-yield-form" class="p-4 rounded shadow-lg bg-white">
                <input type="hidden" id="edit_yield_id" value="${yieldId}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="edit_cropname" class="form-label fw-bold">Crop Name</label>
                        <select class="form-select" id="edit_cropname" name="cropname" required></select>
                    </div>
                    <div class="col-md-4">
                        <label for="edit_quantity" class="form-label fw-bold">Quantity</label>
                        <input type="number" class="form-control" id="edit_quantity" name="quantity" value="${quantity}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="edit_harvest_date" class="form-label fw-bold">Harvest Date</label>
                        <input type="date" class="form-control" id="edit_harvest_date" name="harvest_date" value="${harvestDate}" required>
                    </div>
                    <div class="col-12 d-flex mt-3">
                        <button type="submit" class="btn btn-primary me-2">Update Yield</button>
                        <button type="button" class="btn btn-secondary" onclick="hideYieldForm()">Cancel</button>
                    </div>
                </div>
            </form>
        `;
        document.getElementById('edit-yield-form').addEventListener('submit', updateYield);
    }

    function hideYieldForm() {
        $("#add-yield-main").show();
        document.getElementById('yield-form-container').innerHTML = '';
    }

    function addYield(event) {
        event.preventDefault();
        var formData = {
            action: 'add-yield',
            cropname: document.getElementById('cropname').value,
            quantity: document.getElementById('quantity').value,
            harvest_date: document.getElementById('harvest_date').value
        };
        $.ajax({
            url: 'http://localhost/amis-project-/pages/routes.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                var responseData = JSON.parse(response);
                if (responseData.success) {
                    loadCropYields(document.querySelector('.nav-link[onclick="loadCropYields(this)"]'));
                    alert('Yield added successfully!');
                } else {
                    alert('Error: ' + responseData.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + error);
                alert('An error occurred while adding the yield. Please try again later.');
            }
        });
    }

    function updateYield(event) {
        event.preventDefault();
        var formData = {
            action: 'update-yield',
            yield_id: document.getElementById('edit_yield_id').value,
            cropname: document.getElementById('edit_cropname').value,
            quantity: document.getElementById('edit_quantity').value,
            harvest_date: document.getElementById('edit_harvest_date').value
        };
        $.ajax({
            url: 'http://localhost/amis-project-/pages/routes.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                var responseData = JSON.parse(response);
                if (responseData.success) {
                    loadCropYields(document.querySelector('.nav-link[onclick="loadCropYields(this)"]'));
                    alert('Yield updated successfully!');
                } else {
                    alert('Error: ' + responseData.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + error);
                alert('An error occurred while updating the yield. Please try again later.');
            }
        });
    }

    function deleteYield(yieldId) {
        if (confirm('Are you sure you want to delete this yield?')) {
            var formData = {
                action: 'delete-yield',
                farmer_email: 'farmer@example.com',
                yield_id: yieldId
            };
            $.ajax({
                url: 'http://localhost/amis-project-/pages/routes.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    var responseData = JSON.parse(response);
                    if (responseData.success) {
                        loadCropYields(document.querySelector('.nav-link[onclick="loadCropYields(this)"]'));
                        alert('Yield deleted successfully!');
                    } else {
                        alert('Error: ' + responseData.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error: ' + error);
                    alert('An error occurred while deleting the yield. Please try again later.');
                }
            });
        }
    }
</script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>