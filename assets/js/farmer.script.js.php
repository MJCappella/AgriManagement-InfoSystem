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

    function showAddYieldForm() {
        $("#add-yield-main").hide();
        document.getElementById('yield-form-container').innerHTML = `
        <h3>Add New Yield</h3>
        <form id="add-yield-form" class="p-4 rounded shadow-lg bg-white">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="cropname" class="form-label fw-bold">Crop Name</label>
                    <select class="form-select" id="add_cropname" name="cropname" required></select>
                </div>
                <div class="col-md-4">
                    <label for="quantity" class="form-label fw-bold">Quantity</label>
                    <input type="number" class="form-control" id="add_quantity" name="quantity" required>
                </div>
                <div class="col-md-4">
                    <label for="harvest_date" class="form-label fw-bold">Harvest Date</label>
                    <input type="date" class="form-control" id="add_harvest_date" name="harvest_date" required value="<?php echo date('Y-m-d'); ?>">
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
                        <input type="text" class="form-control" id="edit_cropname" name="cropname" value="${cropname}" readonly>
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
            crop_id: document.getElementById('add_cropname').value,
            quantity: document.getElementById('add_quantity').value,
            harvest_date: document.getElementById('add_harvest_date').value
        };
        console.log(formData);
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

    function loadAdverts(element) {
        setActiveLink(element);
        $.ajax({
            url: 'http://localhost/amis-project-/pages/routes.php',
            type: 'POST',
            data: {
                action: 'get-adverts-by-farmer'
            },
            success: function(response) {
                var responseData = JSON.parse(response);
                if (responseData.success) {
                    var tableContent = responseData.adverts.map(function(item) {
                        return `
                        <tr data-advert-id="${item.advert_id}">
                            <td>${item.cropname}</td>
                            <td>${item.price}</td>
                            <td>${item.quantity}</td>
                            <td>${item.unit}</td>
                            <td>${item.date}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="showEditAdvertForm(${item.advert_id})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteAdvert(${item.advert_id})">Delete</button>
                            </td>
                        </tr>
                    `;
                    }).join('');
                    document.getElementById('main-content').innerHTML = `
                        <button class="btn btn-success mb-3" id="add-advert-main" onclick="showAddAdvertForm()">Add advert</button>
                        <div id="advert-form-container"></div>
                        <div id="adverts-table-container">
                        <h3>Current adverts</h3>
                        <div class="table-responsive">
                            <table id="adverts-table" class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Crop Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                        <th>Advert Date</th>
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
                    $('#adverts-table').DataTable({
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

    function showAddAdvertForm() {
        $("#add-advert-main").hide();
        document.getElementById('advert-form-container').innerHTML = `
        <h3>Add New advert</h3>
        <form id="add-advert-form" class="p-4 rounded shadow-lg bg-white">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="add_cropname" class="form-label fw-bold">Crop Name</label>
                    <select class="form-select" id="add_cropname" name="crop_id" required></select>
                </div>
                <div class="col-md-4">
                    <label for="add_price" class="form-label fw-bold">Price</label>
                    <input type="number" class="form-control" id="add_price" name="price" required>
                </div>
                <div class="col-md-4">
                    <label for="add_quantity" class="form-label fw-bold">Quantity</label>
                    <input type="number" class="form-control" id="add_quantity" name="quantity" required>
                </div>
                <div class="col-md-4">
                    <label for="add_unit" class="form-label fw-bold">Advert Unit</label>
                    <select class="form-select" id="add_unit" name="add_unit" required></select>
                </div>
                <div class="col-12 d-flex mt-3">
                    <button type="submit" class="btn btn-primary me-2">Add advert</button>
                    <button type="button" class="btn btn-secondary" onclick="hideAdvertForm()">Cancel</button>
                </div>
            </div>
            </form>
        `;
        document.getElementById('add-advert-form').addEventListener('submit', addAdvert);
        loadCropOptions(); // Load crop options for select field
        loadMeasurementUnitOptions(); // Load unit options for select field
    }

    function addAdvert(event) {
        event.preventDefault();
        var formData = {
            action: 'add-advert',
            crop_id: document.getElementById('add_cropname').value,
            price: document.getElementById('add_price').value,
            quantity: document.getElementById('add_quantity').value,
            unit: document.getElementById('add_unit').value
        };
        console.log(formData);
        $.ajax({
            url: 'http://localhost/amis-project-/pages/routes.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                var responseData = JSON.parse(response);
                if (responseData.success) {
                    loadAdverts(document.querySelector('.nav-link[onclick="loadAdverts(this)"]'));
                    alert('Advert added successfully!');
                } else {
                    alert('Error: ' + responseData.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + error);
                alert('An error occurred while adding the advert. Please try again later.');
            }
        });
    }

    function showEditAdvertForm(advertId) {
        var advertRow = document.querySelector(`tr[data-advert-id="${advertId}"]`);
        var cropname = advertRow.children[0].textContent;
        var price = advertRow.children[1].textContent;
        var quantity = advertRow.children[2].textContent;
        var unit = advertRow.children[3].textContent;
        var advertDate = advertRow.children[4].textContent;

        document.getElementById('advert-form-container').innerHTML = `
        <h3>Edit Advert</h3>
            <form id="edit-advert-form" class="p-4 rounded shadow-lg bg-white">
                <input type="hidden" id="edit_advert_id" value="${advertId}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="add_cropname" class="form-label fw-bold">Crop Name</label>
                        <input type="text" class="form-control" id="add_cropname" name="cropname" value="${cropname}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="edit_price" class="form-label fw-bold">Price</label>
                        <input type="number" class="form-control" id="edit_price" name="price" value="${price}" required>
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
                        <label for="add_advertDate" class="form-label fw-bold">Advert Date</label>
                        <input type="text" class="form-control" id="add_advertDate" name="advertDate" value="${advertDate}" readonly>
                    </div>
                    <div class="col-12 d-flex mt-3">
                        <button type="submit" class="btn btn-primary me-2">Update Advert</button>
                        <button type="button" class="btn btn-secondary" onclick="hideAdvertForm()">Cancel</button>
                    </div>
                </div>
            </form>
        `;
        document.getElementById('edit-advert-form').addEventListener('submit', updateAdvert);
        loadMeasurementUnitOptions(unit); // Load unit options for select field and set initial value
    }

    function hideAdvertForm() {
        $("#add-advert-main").show();
        document.getElementById('advert-form-container').innerHTML = '';
    }

    function updateAdvert(event) {
        event.preventDefault();
        var formData = {
            action: 'update-advert',
            advert_id: document.getElementById('edit_advert_id').value,
            price: document.getElementById('edit_price').value,
            quantity: document.getElementById('edit_quantity').value,
            unit: document.getElementById('add_unit').value
        };
        console.log(formData);
        $.ajax({
            url: 'http://localhost/amis-project-/pages/routes.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                var responseData = JSON.parse(response);
                if (responseData.success) {
                    loadAdverts(document.querySelector('.nav-link[onclick="loadAdverts(this)"]'));
                    alert('Advert updated successfully!');
                } else {
                    alert('Error: ' + responseData.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + error);
                alert('An error occurred while adding the advert. Please try again later.');
            }
        });
    }

    function deleteAdvert(advertId) {
        // Show the confirm modal
        var confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
        confirmModal.show();

        // Handle the confirm button click
        document.getElementById('confirmDeleteBtn').onclick = function() {
            var formData = {
                action: 'delete-advert',
                advert_id: advertId
            };
            $.ajax({
                url: 'http://localhost/amis-project-/pages/routes.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    var responseData = JSON.parse(response);
                    if (responseData.success) {
                        loadAdverts(document.querySelector('.nav-link[onclick="loadAdverts(this)"]'));
                        showAlert('Advert deleted successfully!');
                    } else {
                        showAlert('Error: ' + responseData.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error: ' + error);
                    showAlert('An error occurred while deleting the advert. Please try again later.');
                }
            });

            // Hide the confirm modal
            confirmModal.hide();
        };
    }

    function showAlert(message) {
        document.getElementById('alertModalBody').textContent = message;
        var alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
        alertModal.show();
    }

    //Manage orders
    function loadOrders(element) {
        setActiveLink(element);
        document.getElementById('main-content').innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
        $.ajax({
            url: 'http://localhost/amis-project-/pages/routes.php',
            type: 'POST',
            data: {
                action: 'get-orders-by-farmer'
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
                        <td>${item.buyer_username}</td>
                        <td>${item.buyer_phone}</td>
                        <td>
                            <select class="form-select" onchange="updateOrderStatus(${item.order_id}, this.value)">
                                <option value="pending" ${item.status === 'pending' ? 'selected' : ''}>Pending</option>
                                <option value="confirmed" ${item.status === 'confirmed' ? 'selected' : ''}>Confirmed</option>
                                <option value="cancelled" ${item.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                                <option value="delivered" ${item.status === 'delivered' ? 'selected' : ''}>Delivered</option>
                            </select>
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
                                        <th>Buyer</th>
                                        <th>Phone</th>
                                        <th>Status</th>
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

    // Transporters
function loadTransporters(element) {
    setActiveLink(element);
    document.getElementById('main-content').innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';

    $.ajax({
        url: 'http://localhost/amis-project-/pages/routes.php',
        type: 'POST',
        data: {
            action: 'get-transporters'
        },
        success: function(response) {
            var responseData = JSON.parse(response);
            if (responseData.success) {
                var transportersOptions = responseData.transporters.map(function(transporter) {
                    return `<option value="${transporter.transporter_id}">${transporter.username} (${transporter.availability})</option>`;
                }).join('');

                var tableContent = responseData.schedules.map(function(schedule) {
                    return `
                        <tr data-schedule-id="${schedule.schedule_id}">
                            <td>${schedule.schedule_date}</td>
                            <td>${schedule.transporter_username}</td>
                            <td>${schedule.buyer_username}</td>
                            <td>
                                <select class="form-select" onchange="updateTransportStatus(${schedule.schedule_id}, this.value)">
                                    <option value="pending" ${schedule.status === 'pending' ? 'selected' : ''}>Pending</option>
                                    <option value="confirmed" ${schedule.status === 'confirmed' ? 'selected' : ''}>Confirmed</option>
                                    <option value="cancelled" ${schedule.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                                    <option value="delivered" ${schedule.status === 'delivered' ? 'selected' : ''}>Delivered</option>
                                </select>
                            </td>
                            <td><button class="btn btn-warning" onclick="rescheduleTransport(${schedule.schedule_id})">Reschedule</button></td>
                        </tr>
                    `;
                }).join('');

                document.getElementById('main-content').innerHTML = `
                    <div id="transporter-form-container">
                        <h3>Book a Transporter</h3>
                        <form id="add-transporter-form" onsubmit="return addTransporter();">
                            <div class="form-group">
                                <label for="transporter_id">Select Transporter:</label>
                                <select id="transporter_id" name="transporter_id" class="form-select">
                                    ${transportersOptions}
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="schedule_date">Schedule Date:</label>
                                <input type="date" id="schedule_date" name="schedule_date" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Book Transporter</button>
                        </form>
                    </div>
                    <div id="transport-schedules-table-container">
                        <h3>Transport Schedules</h3>
                        <div class="table-responsive">
                            <table id="transport-schedules-table" class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Schedule Date</th>
                                        <th>Transporter</th>
                                        <th>Buyer</th>
                                        <th>Status</th>
                                        <th>Reschedule</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${tableContent}
                                </tbody>
                            </table>
                        </div>
                    </div>
                `;
                $('#transport-schedules-table').DataTable({
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
        }
    });
}

function addTransporter() {
    $.ajax({
        url: 'http://localhost/amis-project-/pages/routes.php',
        type: 'POST',
        data: {
            action: 'add-transport-schedule',
            transporter_id: $('#transporter_id').val(),
            schedule_date: $('#schedule_date').val(),
            buyer_id: 1 // Assuming a buyer ID; adjust accordingly
        },
        success: function(response) {
            var responseData = JSON.parse(response);
            if (responseData.success) {
                loadTransporters(document.querySelector('.nav-link[onclick="loadTransporters(this)"]'));
                alert('Transporter booked successfully');
            } else {
                alert('Error: ' + responseData.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error: ' + error);
        }
    });
    return false; // Prevent form from submitting traditionally
}

function updateTransportStatus(scheduleId, newStatus) {
    $.ajax({
        url: 'http://localhost/amis-project-/pages/routes.php',
        type: 'POST',
        data: {
            action: 'update-transport-status',
            schedule_id: scheduleId,
            status: newStatus
        },
        success: function(response) {
            var responseData = JSON.parse(response);
            if (responseData.success) {
                loadTransporters(document.querySelector('.nav-link[onclick="loadTransporters(this)"]'));
                alert('Transport status updated successfully');
            } else {
                alert('Error: ' + responseData.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error: ' + error);
        }
    });
}

function rescheduleTransport(scheduleId) {
    var newDate = prompt("Enter the new schedule date (YYYY-MM-DD):");
    if (newDate) {
        $.ajax({
            url: 'http://localhost/amis-project-/pages/routes.php',
            type: 'POST',
            data: {
                action: 'reschedule-transport',
                schedule_id: scheduleId,
                new_date: newDate
            },
            success: function(response) {
                var responseData = JSON.parse(response);
                if (responseData.success) {
                    loadTransporters(document.querySelector('.nav-link[onclick="loadTransporters(this)"]'));
                    alert('Transport schedule rescheduled successfully');
                } else {
                    alert('Error: ' + responseData.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + error);
            }
        });
    }
}

</script>