<?php
include_once("../../config/config.php");
$pageTitle = 'Government Dashboard';
$logoutButton = true;
include_once('../../includes/auth.php');
ensureLoggedIn(['government']);
include_once('../../includes/header.php');
?>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <!-- sidebar -->
            <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 250px;">
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                    <span class="fs-4">Government Dashboard</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link link-dark" id="dashboard" onclick="loadDashboard(this)">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a onclick="setMarketPrices(this)" class="nav-link link-dark">
                            Set Prices
                        </a>
                    </li>
                    <li>
                        <a onclick="loadMarketPrices(this)" class="nav-link link-dark">
                            Market Monitoring
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-dark">
                            Account Settings
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
        <!-- Alert Modal -->

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
        background-color: #007377;
        /* Lighter Blue */
        color: white !important;
    }

    .sidebar .nav-link:hover {
        background-color: #007377;
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
        background-color: #00264d;
        /* Slightly darker blue */
        border-color: #007377;
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
<script>
    loadDashboard(document.getElementById('dashboard'));

    function setActiveLink(element) {
        let links = document.querySelectorAll('.nav-link');
        links.forEach(link => link.classList.remove('active'));
        element.classList.add('active');
    }
    // Show alert function
    function showAlert(message) {
        document.getElementById('alertModalBody').textContent = message;
        var alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
        alertModal.show();
    }

    function loadDashboard(element) {
        setActiveLink(element);
        document.getElementById('main-content').innerHTML = `
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Market Monitoring</h5>
                            <p class="card-text">Monitor the agricultural market.</p>
                            <a href="#" class="btn btn-primary">View Monitoring</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Set Prices</h5>
                            <p class="card-text">Set market prices</p>
                            <a href="#" class="btn btn-primary">Set Prices</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Data Collection</h5>
                            <p class="card-text">Collect and analyze data.</p>
                            <a href="#" class="btn btn-primary">Collect Data</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Regulatory Compliance</h5>
                            <p class="card-text">Ensure compliance with regulations.</p>
                            <a href="#" class="btn btn-primary">View Compliance</a>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // Set prices
    function setMarketPrices(element) {
        setActiveLink(element);
        document.getElementById('main-content').innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';

        // Fetch the market prices
        $.ajax({
            url: 'http://localhost/amis-project-/pages/routes.php',
            type: 'POST',
            data: {
                action: 'get-market-prices'
            },
            success: function(response) {
                const data = JSON.parse(response);
                if (data.success) {
                    renderMarketPricesTable(data.data);
                } else {
                    document.getElementById('main-content').innerHTML = `<div class="alert alert-danger">Error: ${data.message}</div>`;
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                document.getElementById('main-content').innerHTML = '<div class="alert alert-danger">An error occurred while fetching market prices. Please try again later.</div>';
            }
        });
    }

    // Fetch crops and populate the select field
    function fetchCrops(callback) {
        $.ajax({
            url: 'http://localhost/amis-project-/pages/routes.php',
            type: 'POST',
            data: {
                action: 'get-crops'
            },
            success: function(response) {
                const data = JSON.parse(response);
                if (data.success) {
                    callback(data.crops);
                } else {
                    alert('Error fetching crops: ' + data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('An error occurred while fetching crops. Please try again later.');
            }
        });
    }

    // Open modal for editing an existing market price
    function openEditMarketPriceModal(price_id, cropname, price, status, date) {
        console.log(cropname);
        fetchCrops(function(crops) {
            let cropOptions = crops.map(crop =>
                `<option value="${crop.cropname}" ${crop.cropname === cropname ? 'selected' : ''}>${crop.cropname}</option>`
            ).join('');

            let modalHtml = `
        <div class="modal fade" id="marketPriceModal" tabindex="-1" aria-labelledby="marketPriceModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="marketPriceModalLabel">Edit Market Price</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editMarketPriceForm">
                            <input type="hidden" id="price_id" name="price_id" value="${price_id}">
                            <div class="mb-3">
                                <label for="cropname" class="form-label">Crop Name</label>
                                <select class="form-select" id="cropname" name="cropname" required>
                                    ${cropOptions}
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="price" value="${price}" required>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="effective" ${status === 'effective' ? 'selected' : ''}>Effective</option>
                                    <option value="provisional" ${status === 'provisional' ? 'selected' : ''}>Provisional</option>
                                    <option value="ineffective" ${status === 'ineffective' ? 'selected' : ''}>Ineffective</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="date" name="date" value="${date}" required>
                            </div>
                            <button type="button" class="btn btn-primary" onclick="updateMarketPrice()">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        `;

            // Append modal HTML to the body and show it
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            new bootstrap.Modal(document.getElementById('marketPriceModal')).show();
        });
    }

    // Render the market prices table with action buttons
    function renderMarketPricesTable(marketPrices) {
        let tableHtml = `
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Market Prices</h4>
        <button class="btn btn-success" onclick="openAddMarketPriceModal()">Add New Price</button>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Crop Name</th>
                <th>Price</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
    `;

        marketPrices.forEach(price => {
            tableHtml += `
        <tr>
            <td>${price.cropname}</td>
            <td>${price.price}</td>
            <td>${price.status}</td>
            <td>${price.date}</td>
            <td>
                <button class="btn btn-primary btn-sm" onclick="openEditMarketPriceModal(${price.price_id}, '${price.cropname}', '${price.price}', '${price.status}', '${price.date}')">Edit</button>
            </td>
        </tr>
    `;
        });

        tableHtml += `
        </tbody>
    </table>
    `;

        document.getElementById('main-content').innerHTML = tableHtml;
    }

    // Open modal for adding a new market price
    function openAddMarketPriceModal() {
        fetchCrops(function(crops) {
            let cropOptions = crops.map(crop => `<option value="${crop.cropname}">${crop.cropname}</option>`).join('');

            let modalHtml = `
        <div class="modal fade" id="marketPriceModal" tabindex="-1" aria-labelledby="marketPriceModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="marketPriceModalLabel">Add Market Price</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addMarketPriceForm">
                            <div class="mb-3">
                                <label for="cropname" class="form-label">Crop Name</label>
                                <select class="form-select" id="cropname" name="cropname" required>
                                    ${cropOptions}
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="price" required>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="effective">Effective</option>
                                    <option value="provisional">Provisional</option>
                                    <option value="ineffective">Ineffective</option>
                                </select>
                            </div>
                            <button type="button" class="btn btn-primary" onclick="addMarketPrice()">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        `;

            // Append modal HTML to the body and show it
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            new bootstrap.Modal(document.getElementById('marketPriceModal')).show();
        });
    }

    // Add new market price
    function addMarketPrice() {
        const form = document.getElementById('addMarketPriceForm');
        const formData = new FormData(form);

        $.ajax({
            url: 'http://localhost/amis-project-/pages/routes.php',
            type: 'POST',
            data: {
                action: 'add-crop-market-price',
                cropname: formData.get('cropname'),
                price: formData.get('price'),
                status: formData.get('status')
            },
            success: function(response) {
                const data = JSON.parse(response);
                if (data.success) {
                    alert('Market price added successfully!');
                    setMarketPrices(document.querySelector('nav .active'));
                    $('#marketPriceModal').modal('hide');
                    $('#marketPriceModal').remove(); // Clean up
                } else {
                    alert('Error adding market price: ' + data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('An error occurred while adding market price. Please try again later.');
            }
        });
    }

    // Update existing market price
    function updateMarketPrice() {
        const form = document.getElementById('editMarketPriceForm');
        const formData = new FormData(form);

        $.ajax({
            url: 'http://localhost/amis-project-/pages/routes.php',
            type: 'POST',
            data: {
                action: 'update-crop-market-price',
                price_id: formData.get('price_id'),
                cropname: formData.get('cropname'),
                price: formData.get('price'),
                status: formData.get('status'),
                date: formData.get('date')
            },
            success: function(response) {
                const data = JSON.parse(response);
                if (data.success) {
                    alert('Market price updated successfully!');
                    setMarketPrices(document.querySelector('nav .active'));
                    $('#marketPriceModal').modal('hide');
                    $('#marketPriceModal').remove(); // Clean up
                } else {
                    alert('Error updating market price: ' + data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('An error occurred while updating market price. Please try again later.');
            }
        });
    }


    //market monitoring
    function loadMarketPrices(element) {
        setActiveLink(element);
        document.getElementById('main-content').innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';

        // Fetch forex data first
        $.ajax({
            url: 'http://localhost/amis-project-/pages/routes.php',
            type: 'POST',
            data: {
                action: 'fetch-forex'
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    // Clear the loading spinner
                    document.getElementById('main-content').innerHTML = `
                <div class="row">
                    <div class="card usd col-md-3" id="usdCard" data-currency="USD/KES">
                        <div class="value" id="usdValue">0</div>
                        <div class="progress-bar"><div class="fill" id="usdProgress"></div></div>
                    </div>
                    <div class="card gbp col-md-3" id="gbpCard" data-currency="GBP/KES">
                        <div class="value" id="gbpValue">0</div>
                        <div class="progress-bar"><div class="fill" id="gbpProgress"></div></div>
                    </div>
                    <div class="card eur col-md-3" id="eurCard" data-currency="EUR/KES">
                        <div class="value" id="eurValue">0</div>
                        <div class="progress-bar"><div class="fill" id="eurProgress"></div></div>
                    </div>
                    <div class="card cad col-md-3" id="cadCard" data-currency="CAD/KES">
                        <div class="value" id="cadValue">0</div>
                        <div class="progress-bar"><div class="fill" id="cadProgress"></div></div>
                    </div>
                </div>
                <!-- Product Prices Chart -->
                <div style="width: 100%; height: 600px;">
                    <canvas id="myChart"></canvas>
                </div>
                <button id="downloadBtn" class="btn btn-primary">Download Chart</button>
                `;

                    // Animate the cards with the fetched data
                    animateCard('usdCard', 'usdValue', 'usdProgress', parseFloat(data.forex.usd));
                    animateCard('gbpCard', 'gbpValue', 'gbpProgress', parseFloat(data.forex.gbp));
                    animateCard('eurCard', 'eurValue', 'eurProgress', parseFloat(data.forex.eur));
                    animateCard('cadCard', 'cadValue', 'cadProgress', parseFloat(data.forex.cad));

                    // Now fetch product data
                    fetchProductData();
                } else {
                    document.getElementById('main-content').innerHTML = `<div class="alert alert-danger">Error: ${data.message}</div>`;
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                document.getElementById('main-content').innerHTML = '<div class="alert alert-danger">An error occurred while fetching market prices. Please try again later.</div>';
            }
        });

        // Function to fetch and process product data
        function fetchProductData() {
            $.ajax({
                url: 'http://localhost/amis-project-/pages/routes.php',
                type: 'POST',
                data: {
                    action: 'get-market-trends'
                },
                success: function(response) {
                    var data = JSON.parse(response);

                    if (data.success) {
                        const marketTrends = data.market_trends;
                        console.log(marketTrends);
                        // Group data by cropname
                        const groupedData = {};
                        marketTrends.forEach(trend => {
                            const cropName = trend.cropname.toLowerCase();
                            if (!groupedData[cropName]) {
                                groupedData[cropName] = [];
                            }
                            groupedData[cropName].push({
                                date: trend.date,
                                price: parseFloat(trend.price)
                            });
                        });

                        // Interpolate missing data and prepare datasets for Chart.js
                        const labels = Array.from(new Set(marketTrends.map(trend => trend.date))).sort(); // unique sorted dates
                        const datasets = [];

                        for (const cropName in groupedData) {
                            const cropData = groupedData[cropName];
                            const interpolatedPrices = interpolateMissingPrices(labels, cropData);
                            datasets.push({
                                label: cropName.charAt(0).toUpperCase() + cropName.slice(1),
                                data: interpolatedPrices,
                                borderColor: getRandomColor(),
                                backgroundColor: getRandomColor(0.5),
                                borderWidth: 2,
                                cubicInterpolationMode: 'monotone'
                            });
                        }

                        // Render the chart
                        const ctx = document.getElementById('myChart');
                        if (ctx) {

                            const myChart = new Chart(ctx.getContext('2d'), {
                                type: 'line',
                                data: {
                                    labels: labels,
                                    datasets: datasets
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            display: true,
                                            position: 'top'
                                        },
                                        tooltip: {
                                            callbacks: {
                                                label: function(tooltipItem) {
                                                    return tooltipItem.dataset.label + ': ' + tooltipItem.raw.toFixed(2);
                                                }
                                            }
                                        }
                                    },
                                    interaction: {
                                        intersect: false,
                                    },
                                    scales: {
                                        x: {
                                            title: {
                                                display: true,
                                                text: 'Date'
                                            },
                                            ticks: {
                                                autoSkip: false
                                            }
                                        },
                                        y: {
                                            title: {
                                                display: true,
                                                text: 'Price'
                                            },
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                            // Add event listener for the download button
                            document.getElementById('downloadBtn').addEventListener('click', () => {
                                // Convert the chart to a Base64 image URL
                                const imageUrl = myChart.toBase64Image();
                                // Create a temporary link element
                                const link = document.createElement('a');
                                link.href = imageUrl;
                                // Get the current time in milliseconds
                                const timestamp = Date.now();
                                // Set the download attribute with the unique filename
                                link.download = `chart_${timestamp}.png`; // Name of the file to download
                                // Trigger the download
                                link.click();
                            });
                        } else {
                            console.error('Canvas element with id "myChart" not found.');
                        }
                    } else {
                        document.getElementById('main-content').innerHTML = `<div class="alert alert-danger">Error: ${data.message}</div>`;
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    document.getElementById('main-content').innerHTML = '<div class="alert alert-danger">An error occurred while fetching product data. Please try again later.</div>';
                }
            });
        }

        // Function to interpolate missing prices
        function interpolateMissingPrices(labels, cropData) {
            const prices = [];
            let cropDataIndex = 0;

            labels.forEach((label, index) => {
                if (cropData[cropDataIndex] && cropData[cropDataIndex].date === label) {
                    prices.push(cropData[cropDataIndex].price);
                    cropDataIndex++;
                } else {
                    // Interpolate missing price if possible
                    const prevPrice = prices.length > 0 ? prices[prices.length - 1] : null;
                    const nextPrice = cropData[cropDataIndex] ? cropData[cropDataIndex].price : null;

                    if (prevPrice !== null && nextPrice !== null) {
                        const interpolatedPrice = prevPrice + (nextPrice - prevPrice) / 2;
                        prices.push(interpolatedPrice);
                    } else if (prevPrice !== null) {
                        prices.push(prevPrice); // Use previous price if next price is missing
                    } else {
                        prices.push(nextPrice); // Use next price if previous price is missing
                    }
                }
            });

            return prices;
        }

        // Function to get a random color
        function getRandomColor(alpha = 1) {
            const r = Math.floor(Math.random() * 255);
            const g = Math.floor(Math.random() * 255);
            const b = Math.floor(Math.random() * 255);
            return `rgba(${r}, ${g}, ${b}, ${alpha})`;
        }

        // Function to animate number and progress bar
        function animateCard(cardId, valueId, progressId, finalValue) {
            let currentValue = 0;
            const duration = 2000; // Duration in milliseconds
            const stepTime = 20; // Update every 20ms
            const steps = duration / stepTime;
            const increment = finalValue / steps;

            function update() {
                if (currentValue >= finalValue) {
                    currentValue = finalValue;
                    clearInterval(interval); // Stop the interval when the animation completes
                }
                document.getElementById(valueId).textContent = currentValue.toFixed(2);
                document.getElementById(progressId).style.width = `${(currentValue / finalValue) * 100}%`;
                currentValue += increment;
            }

            const interval = setInterval(update, stepTime);
            update(); // Initial call to ensure immediate update
        }

    }
</script>
<?php include('../../includes/footer.php') ?>
</body>

</html>