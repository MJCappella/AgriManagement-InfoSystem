<script>
loadDashboard(document.getElementById('dashboard'));

function setActiveLink(element) {
    let links = document.querySelectorAll('.nav-link');
    links.forEach(link => link.classList.remove('active'));
    element.classList.add('active');
}

document.addEventListener('DOMContentLoaded', function () {
    const email = '<?php echo $_SESSION["email"] ?>'; // This should be dynamically fetched
    const apiUrl = '/amis-project-/pages/routes.php';

    $.ajax({
        url: apiUrl,
        type: 'POST',
        data: {
            action: 'get-subscription-status',
            email: email
        },
        success: function (response) {
            const responseData = JSON.parse(response);
            const switchElement = document.getElementById('subscriptionSwitch');
            const subscriptionStatus = document.getElementById('subscriptionStatus');

            if (responseData.success) {
                const isSubscribed = responseData.subscription === 'subscribed';
                switchElement.checked = isSubscribed;
                subscriptionStatus.textContent = isSubscribed ? 'Subscribed' : 'Subscribe';
            } else {
                alert('Error: ' + responseData.message);
            }
        },
        error: function (xhr, status, error) {
            alert('An error occurred: ' + error);
        }
    });
});

function toggleSubscription() {
    const switchElement = document.getElementById('subscriptionSwitch');
    const subscriptionStatus = document.getElementById('subscriptionStatus');
    const email = '<?php echo $_SESSION["email"] ?>'; // This should be dynamic based on the logged-in user

    const action = switchElement.checked ? 'subscribe' : 'unsubscribe';
    const statusText = switchElement.checked ? 'Subscribed' : 'Subscribe';
    const apiUrl = '/amis-project-/pages/routes.php';

    $.ajax({
        url: apiUrl,
        type: 'POST',
        data: {
            action: action,
            email: email
        },
        success: function (response) {
            const responseData = JSON.parse(response);
            if (responseData.success) {
                subscriptionStatus.textContent = statusText;
                alert(responseData.message);
            } else {
                alert('Error: ' + responseData.message);
                // Revert the switch in case of error
                switchElement.checked = !switchElement.checked;
            }
        },
        error: function (xhr, status, error) {
            alert('An error occurred: ' + error);
            switchElement.checked = !switchElement.checked;
        }
    });
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
                             <a href="#" class="btn btn-primary" onclick="orderCrops(this)">
                            Order Crops
                        </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Market Prices</h5>
                            <p class="card-text">Analyze current market prices.</p>
                            <a onclick="loadMarketPrices(this)" class="btn btn-primary">
                            Market Prices
                        </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Manage Orders</h5>
                            <p class="card-text">Track and manage your orders.</p>
                            <a onclick="loadOrders(this)" class="btn btn-primary">
                            Manage Orders</a>
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
        success: function (response) {
            var responseData = JSON.parse(response);
            if (responseData.success) {
                var tableContent = responseData.data.map(function (item) {
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
        error: function (xhr, status, error) {
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
        success: function (response) {
            var responseData = JSON.parse(response);
            if (responseData.success) {
                var tableContent = responseData.orders.map(function (item) {
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
        error: function (xhr, status, error) {
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
        success: function (response) {
            var responseData = JSON.parse(response);
            if (responseData.success) {
                loadOrders(document.querySelector('.nav-link[onclick="loadOrders(this)"]'));
                alert('Order status updated successfully');
            } else {
                alert('Error: ' + responseData.message);
            }
        },
        error: function (xhr, status, error) {
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
        success: function (response) {
            var responseData = JSON.parse(response);
            if (responseData.success) {
                const getOptions = Promise.resolve(responseData.crops.map(function (crop) {
                    return `<option value="${crop.crop_id}">${crop.cropname}</option>`;
                }).join(''));
                getOptions.then((options) => {
                    document.getElementById('add_cropname').innerHTML = options;
                });
            } else {
                alert('Error: ' + responseData.message);
            }
        },
        error: function (xhr, status, error) {
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
        success: function (response) {
            var responseData = JSON.parse(response);
            if (responseData.success) {
                var options = responseData.units.map(function (unit) {
                    return `<option value="${unit.name}">${unit.name}</option>`;
                }).join('');
                document.getElementById('add_unit').innerHTML = options;

                // Set initial value
                document.getElementById('add_unit').value = initialValue;
            } else {
                alert('Error: ' + responseData.message);
            }
        },
        error: function (xhr, status, error) {
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
        data: {
            action: 'get-all-adverts'
        },
        success: function (response) {
            var responseData = JSON.parse(response);
            if (responseData.success) {
                var advertsContent = responseData.adverts.map(function (advert) {
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
                            <p class="card-text"><small class="text-muted">Location: ${advert.location}</small></p>
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
        error: function (xhr, status, error) {
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

    quantityInput.oninput = function () {
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
document.getElementById('orderCropForm').addEventListener('submit', function (event) {
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
        success: function (response) {
            var responseData = JSON.parse(response);
            if (responseData.success) {
                console.log(responseData);
                orderModal.hide();
                showAlert('Order placed successfully!');
            } else {
                showAlert('Error: ' + responseData.message);
            }
        },
        error: function (xhr, status, error) {
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
        success: function (response) {
            var responseData = JSON.parse(response);
            if (responseData.success) {
                loadOrders(document.querySelector('.nav-link[onclick="loadOrders(this)"]'));
                alert('Order updated successfully!');
            } else {
                alert('Error: ' + responseData.message);
            }
        },
        error: function (xhr, status, error) {
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
            success: function (response) {
                var responseData = JSON.parse(response);
                if (responseData.success) {
                    loadOrders(document.querySelector('.nav-link[onclick="loadOrders(this)"]'));
                    alert('Order deleted successfully!');
                } else {
                    alert('Error: ' + responseData.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error: ' + error);
                alert('An error occurred while deleting the order. Please try again later.');
            }
        });
    }
}

// Load Chat Engagements for the Buyer
function loadEngagements(element) {
    setActiveLink(element);
    document.getElementById('main-content').innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';

    // Display chat UI
    document.getElementById('main-content').innerHTML = `
    <div class="card" style="width: 100%; max-width: 800px; margin: 0 auto;">
        <div class="card-header d-flex justify-content-between">
            <span>Chat with Marketer</span>
            <button class="btn btn-sm btn-secondary" onclick="loadEngagements()">Refresh</button>
        </div>
        <div class="card-body" style="height: 400px; overflow-y: auto;">
            <div id="message-list" class="mb-3">
                <!-- Messages will be loaded here -->
            </div>
            <div>
                <textarea id="message-text" class="form-control" placeholder="Type your message here"></textarea>
                <button class="btn btn-success mt-2" onclick="sendMessage()">Send</button>
            </div>
        </div>
    </div>
    `;

    // Fetch and display engagements/messages
    fetchEngagements();

    // Auto-refresh chat every 15 seconds
    setInterval(fetchEngagements, 15000);
}

// Fetch engagements/messages for the buyer
function fetchEngagements() {
    $.ajax({
        url: 'http://localhost/amis-project-/pages/routes.php',
        type: 'POST',
        data: {
            action: 'view-engagements'
        },
        success: function (response) {
            var data = JSON.parse(response);
            if (data.success) {
                let engagements = data.engagements.filter(engagement =>
                    engagement.sender === '<?php echo $_SESSION["username"] ?>' || engagement.receiver === '<?php echo $_SESSION["username"] ?>'
                );

                engagements.sort((a, b) => new Date(a.sent_at) - new Date(b.sent_at));

                let messagesHtml = '';
                engagements.forEach((engagement) => {
                    let isSender = engagement.sender === '<?php echo $_SESSION["username"] ?>';
                    messagesHtml += `
                    <div style="text-align: ${isSender ? 'right' : 'left'};">
                        <div class="p-2" style="display: inline-block; max-width: 60%; background-color: ${isSender ? '#d1e7dd' : '#f8d7da'}; border-radius: 10px;">
                            <strong>${engagement.sender}:</strong>
                            <p>${engagement.message_text}</p>
                            <small class="text-muted">${engagement.sent_at}</small>
                        </div>
                    </div>
                    <div style="clear: both;"></div>
                    <hr>
                `;
                });

                document.getElementById('message-list').innerHTML = messagesHtml;

            } else {
                document.getElementById('message-list').innerHTML = `<div class="alert alert-danger">Error: ${data.message}</div>`;
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
            document.getElementById('message-list').innerHTML = '<div class="alert alert-danger">An error occurred while fetching messages. Please try again later.</div>';
        }
    });
}

// Send message from the buyer
function sendMessage() {
    let messageText = document.getElementById('message-text').value;
    if (!messageText.trim()) {
        alert('Please enter a message.');
        return;
    }

    $.ajax({
        url: 'http://localhost/amis-project-/pages/routes.php',
        type: 'POST',
        data: {
            action: 'add-engagement',
            message_text: messageText,
            sender: '<?php echo $_SESSION["username"] ?>',
            receiver: 'Marketing Analyst' // Assuming "Marketer" is a general term; replace with actual logic if needed
        },
        success: function (response) {
            var data = JSON.parse(response);
            if (data.success) {
                // Refresh chat
                fetchEngagements();
                document.getElementById('message-text').value = ''; // Clear input field
            } else {
                alert('Error: ' + data.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
            alert('An error occurred while sending the message. Please try again later.');
        }
    });
}
</script>