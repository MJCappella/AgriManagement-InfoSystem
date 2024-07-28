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
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                    <span class="fs-4">Buyer Dashboard</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link active" id="dashboard" onclick="loadDashboard(this)">
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
    /* Sidebar Styles */
.sidebar {
    background-color: #003366; /* Dark Blue */
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
    background-color: #004080; /* Lighter Blue */
    color: white !important;
}

.sidebar .nav-link:hover {
    background-color: #00264d; /* Slightly darker blue */
}

.sidebar .dropdown-toggle {
    color: white;
}

.sidebar .dropdown-menu {
    background-color: #003366; /* Dark Blue */
}

.sidebar .dropdown-menu .dropdown-item {
    color: white;
}

.sidebar .dropdown-menu .dropdown-item:hover {
    background-color: #004080; /* Lighter Blue */
}

/* Modal Header */
.modal-header {
    background-color: #003366 !important; /* Dark Blue */
    color: white;
}

/* Modal Footer Buttons */
.modal-footer .btn-secondary {
    background-color: #00264d; /* Slightly darker blue */
    border-color: #00264d;
}

.modal-footer .btn-danger {
    background-color: #cc0000; /* Red */
    border-color: #cc0000;
}

/* Primary Button */
.btn-primary {
    background-color: #004080; /* Lighter Blue */
    border-color: #004080;
}

    </style>
<script>
    loadDashboard(document.getElementById('dashboard'));

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
                            <h5 class="card-title">Search Crops</h5>
                            <p class="card-text">Find the crops you need.</p>
                            <a href="/amis-project-/pages/search_crops.php" class="btn btn-primary">Search Crops</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Market Trends</h5>
                            <p class="card-text">Analyze current market trends.</p>
                            <a onclick="loadMarketPrices()" class="btn btn-primary">View Trends</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Manage Orders</h5>
                            <p class="card-text">Track and manage your orders.</p>
                            <a href="/amis-project-/pages/manage_orders.php" class="btn btn-primary">Manage Orders</a>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    //Market
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

    //Manage orders
    function loadOrders(element) {
        setActiveLink(element);
        $.ajax({
            url: 'http://localhost/amis-project-/pages/routes.php',
            type: 'POST',
            data: {
                action: 'get-orders-by-buyer'
            },
            success: function(response) {
                var responseData = JSON.parse(response);
                if (responseData.success) {
                    var tableContent = responseData.orders.map(function(item) {
                        return `
                    <tr data-order-id="${item.order_id}">
                        <td>${item.cropname}</td>
                        <td>${item.quantity}</td>
                        <td>${item.unit}</td>
                        <td>${item.total_cost}</td>
                        <td>${item.date}</td>
                        <td>${item.farmer_username}</td>
                        <td>
                            <select class="form-select" onchange="updateOrderStatus(${item.order_id}, this.value)">
                                <option value="pending" ${item.status === 'pending' ? 'selected' : ''}>Pending</option>
                                <option value="cancelled" ${item.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                            </select>
                        </td>
                        <td>
                        <button class="btn btn-warning btn-sm" onclick="showEditOrderForm(${item.order_id})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteOrder(${item.order_id})">Delete</button>

                        </td>
                    </tr>
                `;
                    }).join('');
                    document.getElementById('main-content').innerHTML = `
                    <div id="order-form-container"></div>
                    <div id="orders-table-container">
                        <h3>Current Orders</h3>
                        <div class="table-responsive">
                            <table id="orders-table" class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Crop Name</th>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                        <th>Cost</th>
                                        <th>Date</th>
                                        <th>Farmer</th>
                                        <th>Status</th>
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
                    $('#orders-table').DataTable({
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

    function updateOrderStatus(orderId, newStatus) {
        $.ajax({
            url: 'http://localhost/amis-project-/pages/routes.php',
            type: 'POST',
            data: {
                action: 'update-order-status',
                order_id: orderId,
                status: newStatus
            },
            success: function(response) {
                var responseData = JSON.parse(response);
                if (responseData.success) {
                    loadOrders(document.querySelector('.nav-link[onclick="loadOrders(this)"]'));
                    alert('Order status updated successfully');
                } else {
                    alert('Error: ' + responseData.message);
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
                    const getOptions = Promise.resolve(responseData.crops.map(function(crop) {
                        return `<option value="${crop.crop_id}">${crop.cropname}</option>`;
                    }).join(''));
                    getOptions.then((options) => {
                        document.getElementById('add_cropname').innerHTML = options;
                    });
                } else {
                    alert('Error: ' + responseData.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + error);
            }
        });
    }

    function showEditOrderForm(orderId) {
        var orderRow = document.querySelector(`tr[data-order-id="${orderId}"]`);
        var cropname = orderRow.children[0].textContent;
        var quantity = orderRow.children[1].textContent;
        var unit = orderRow.children[2].textContent;
        var orderDate = orderRow.children[4].textContent;

        document.getElementById('order-form-container').innerHTML = `
        <h3>Edit Order</h3>
            <form id="edit-order-form" class="p-4 rounded shadow-lg bg-white">
                <input type="hidden" id="edit_order_id" value="${orderId}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="edit_cropname" class="form-label fw-bold">Crop Name</label>
                        <input type="text" class="form-control" id="edit_cropname" name="cropname" value="${cropname}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="edit_quantity" class="form-label fw-bold">Quantity</label>
                        <input type="number" class="form-control" id="edit_quantity" name="quantity" value="${quantity}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="add_unit" class="form-label fw-bold">Unit</label>
                        <select class="form-select" id="add_unit" name="edit_unit" required></select>
                    </div>
                    <div class="col-md-4">
                        <label for="edit_orderDate" class="form-label fw-bold">Order Date</label>
                        <input type="text" class="form-control" id="edit_orderDate" name="orderDate" value="${orderDate}" readonly>
                    </div>
                    <div class="col-12 d-flex mt-3">
                        <button type="submit" class="btn btn-primary me-2">Update Order</button>
                        <button type="button" class="btn btn-secondary" onclick="hideOrderForm()">Cancel</button>
                    </div>
                </div>
            </form>
        `;
        document.getElementById('edit-order-form').addEventListener('submit', updateOrder);
        loadMeasurementUnitOptions(unit);
    }
    function loadMeasurementUnitOptions(initialValue) {
        $.ajax({
            url: 'http://localhost/amis-project-/pages/routes.php',
            type: 'POST',
            data: {
                action: 'get-units'
            },
            success: function(response) {
                var responseData = JSON.parse(response);
                if (responseData.success) {
                    var options = responseData.units.map(function(unit) {
                        return `<option value="${unit.name}">${unit.name}</option>`;
                    }).join('');
                    document.getElementById('add_unit').innerHTML = options;

                    // Set initial value
                    document.getElementById('add_unit').value = initialValue;
                } else {
                    alert('Error: ' + responseData.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + error);
            }
        });
    }
    function hideOrderForm() {
        $("#add-order-main").show();
        document.getElementById('order-form-container').innerHTML = '';
    }

    // Load and display all adverts
function orderCrops(element) {
    setActiveLink(element);
    $.ajax({
        url: 'http://localhost/amis-project-/pages/routes.php',
        type: 'POST',
        data: { action: 'get-all-adverts' },
        success: function(response) {
            var responseData = JSON.parse(response);
            if (responseData.success) {
                var advertsContent = responseData.adverts.map(function(advert) {
                    return `
                    <div class="card mb-3" style="max-width: 540px;">
                      <div class="row g-0">
                        <div class="col-md-4">
                          <img src="${advert.image_path}" class="img-fluid rounded-start" alt="${advert.cropname}">
                        </div>
                        <div class="col-md-8">
                          <div class="card-body">
                            <h5 class="card-title">${advert.cropname}</h5>
                            <p class="card-text">${advert.description}</p>
                            <p class="card-text"><small class="text-muted">Price: $${advert.price} per ${advert.unit}</small></p>
                            <p class="card-text"><small class="text-muted">Available Quantity: ${advert.quantity} ${advert.unit}</small></p>
                            <button class="btn btn-primary" onclick="showOrderModal(${advert.advert_id}, ${advert.price}, ${advert.quantity}, '${advert.unit}')">Order</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    `;
                }).join('');
                document.getElementById('main-content').innerHTML = advertsContent;
            } else {
                document.getElementById('main-content').innerHTML = `<div class="alert alert-danger">Error: ${responseData.message}</div>`;
            }
        },
        error: function(xhr, status, error) {
            console.error('Error: ' + error);
        }
    });
}

// Show the order modal and prefill the fields
function showOrderModal(advertId, price, availableQuantity, unit) {
    var orderModal = new bootstrap.Modal(document.getElementById('orderCropModal'));
    document.getElementById('order_advert_id').value = advertId;
    var quantityInput = document.getElementById('order_quantity');
    var unitInput = document.getElementById('add_unit');
    var estimatedCostInput = document.getElementById('estimated_cost');
    quantityInput.max = availableQuantity;
    quantityInput.value = availableQuantity;
    loadMeasurementUnitOptions(unit);
    estimatedCostInput.value = (price * availableQuantity).toFixed(2);
    
    quantityInput.oninput = function() {
        var quantity = parseInt(quantityInput.value);
        if (quantity > availableQuantity) {
            quantityInput.value = availableQuantity;
            quantity = availableQuantity;
        }
        estimatedCostInput.value = (price * quantity).toFixed(2);
    };

    orderModal.show();
}

// Handle the order form submission
document.getElementById('orderCropForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var advertId = document.getElementById('order_advert_id').value;
    var quantity = document.getElementById('order_quantity').value;
    var unit = document.getElementById('add_unit').value;
    addOrder(advertId, quantity, unit);
});

// Add order function
function addOrder(advertId, quantity, unit) {
    var orderModal = bootstrap.Modal.getInstance(document.getElementById('orderCropModal'));
    $.ajax({
        url: 'http://localhost/amis-project-/pages/routes.php',
        type: 'POST',
        data: {
            action: 'add-order',
            advert_id: advertId,
            quantity: quantity,
            unit: unit
        },
        success: function(response) {
            var responseData = JSON.parse(response);
            if (responseData.success) {
                console.log(responseData);
                orderModal.hide();
                showAlert('Order placed successfully!');
            } else {
                showAlert('Error: ' + responseData.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error: ' + error);
            showAlert('An error occurred while placing the order. Please try again later.');
        }
    });
}

// Show alert function
function showAlert(message) {
    document.getElementById('alertModalBody').textContent = message;
    var alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
    alertModal.show();
}

    function updateOrder(event) {
        event.preventDefault();
        var formData = {
            action: 'update-order',
            order_id: document.getElementById('edit_order_id').value,
            quantity: document.getElementById('edit_quantity').value,
            unit: document.getElementById('add_unit').value
        };
        $.ajax({
            url: 'http://localhost/amis-project-/pages/routes.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                var responseData = JSON.parse(response);
                if (responseData.success) {
                    loadOrders(document.querySelector('.nav-link[onclick="loadOrders(this)"]'));
                    alert('Order updated successfully!');
                } else {
                    alert('Error: ' + responseData.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + error);
                alert('An error occurred while updating the order. Please try again later.');
            }
        });
    }

    function deleteOrder(orderId) {
        if (confirm('Are you sure you want to delete this order?')) {
            var formData = {
                action: 'delete-order',
                order_id: orderId
            };
            $.ajax({
                url: 'http://localhost/amis-project-/pages/routes.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    var responseData = JSON.parse(response);
                    if (responseData.success) {
                        loadOrders(document.querySelector('.nav-link[onclick="loadOrders(this)"]'));
                        alert('Order deleted successfully!');
                    } else {
                        alert('Error: ' + responseData.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error: ' + error);
                    alert('An error occurred while deleting the order. Please try again later.');
                }
            });
        }
    }
</script>



<?php include('../../includes/footer.php') ?>
</body>

</html>