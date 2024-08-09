<?php
include_once("../../config/config.php");
$pageTitle = 'Marketing Dashboard';
$logoutButton = true;
include_once('../../includes/auth.php');
ensureLoggedIn(['marketing']);
include_once('../../includes/header.php');
?>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <!-- sidebar -->
            <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 250px;">
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                    <span class="fs-4">Marketing Dashboard</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link link-dark" id="dashboard" onclick="loadDashboard(this)">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-dark" onclick="loadAnalyis(this)">
                            Market Analysis
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-dark">
                            Customer Engagement
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
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                            <h5 class="card-title">Market Analysis</h5>
                            <p class="card-text">Analyze market trends and data.</p>
                            <a href="#" class="btn btn-primary" onclick="loadAnalysis(this)">Analyze Market</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Customer Engagement</h5>
                            <p class="card-text">Seek feedback from customers.</p>
                            <a href="#" class="btn btn-primary">Engage Customers</a>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    //analysis
    function loadAnalyis(element) {
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