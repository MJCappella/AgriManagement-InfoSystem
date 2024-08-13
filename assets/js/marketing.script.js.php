
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

    //Demand trends
    function loadDemand(element) {
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

                    // Now fetch demand data
                    fetchDemandData();
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
        function fetchDemandData() {
            $.ajax({
                url: 'http://localhost/amis-project-/pages/routes.php',
                type: 'POST',
                data: {
                    action: 'get-demand-trends'
                },
                success: function(response) {
                    var data = JSON.parse(response);

                    if (data.success) {
                        const demandTrends = data.demand_trends;
                        console.log(demandTrends);

                        // Prepare datasets for Chart.js
                        const labels = demandTrends.map(trend => trend.cropname.charAt(0).toUpperCase() + trend.cropname.slice(1));
                        const dataValues = demandTrends.map(trend => parseInt(trend.total_demand));

                        // Function to generate a random RGB color
                        function getRandomColor(alpha = 1) {
                            const r = Math.floor(Math.random() * 256);
                            const g = Math.floor(Math.random() * 256);
                            const b = Math.floor(Math.random() * 256);
                            return `rgba(${r}, ${g}, ${b}, ${alpha})`;
                        }

                        // Generate colors for each bar
                        const borderColors = dataValues.map(() => getRandomColor(1)); // Generate a random color for each border

                        const datasets = [{
                            label: 'Total Demand',
                            data: dataValues,
                            backgroundColor: borderColors.map(color => color.replace(/,[^,]*$/, ',0.5)')), // Make background color transparent
                            borderColor: borderColors, // Use the same colors for the border
                            borderWidth: 1,
                            borderRadius: 5,
                        }];

                        // Render the chart
                        const ctx = document.getElementById('myChart');
                        if (ctx) {
                            const myChart = new Chart(ctx.getContext('2d'), {
                                type: 'bar',
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
                                                    return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
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
                                                text: 'Crop Name'
                                            },
                                            ticks: {
                                                autoSkip: false
                                            }
                                        },
                                        y: {
                                            title: {
                                                display: true,
                                                text: 'Total Demand'
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
                                link.download = `demand_chart_${timestamp}.png`; // Name of the file to download
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
                    document.getElementById('main-content').innerHTML = '<div class="alert alert-danger">An error occurred while fetching demand data. Please try again later.</div>';
                }
            });
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
    // Customer engagement
    function loadCustomerEngagement(element) {
        setActiveLink(element);
        document.getElementById('main-content').innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';

        // Fetch customer data
        $.ajax({
            url: 'http://localhost/amis-project-/pages/routes.php',
            type: 'POST',
            data: {
                action: 'get-all-customers'
            },
            success: function(response) {
                var customerData = JSON.parse(response);
                if (customerData.success) {
                    let customers = customerData.customers;
                    let customerTable = `
                    <div style="height: 200px; overflow-y: auto;">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Farmer Name</th>
                                    <th>Buyer Name</th>
                                    <th>Engage</th>
                                </tr>
                            </thead>
                            <tbody>
                `;

                    customers.forEach((customer, index) => {
                        customerTable += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${customer.date}</td>
                            <td>${customer.farmer_name}</td>
                            <td>${customer.buyer_name}</td>
                            <td>
                                <button class="btn btn-primary" onclick="loadChat('${customer.buyer_name}')">
                                    <i class="bi bi-chat-dots"></i> Chat
                                </button>
                            </td>
                        </tr>
                    `;
                    });

                    customerTable += `</tbody></table></div>`;

                    // Insert the table and chat UI placeholder
                    document.getElementById('main-content').innerHTML = `
                    <div class="customer-table">
                        ${customerTable}
                    </div>
                    <div id="chat-ui" class="mt-4"></div>
                `;
                } else {
                    document.getElementById('main-content').innerHTML = `<div class="alert alert-danger">Error: ${customerData.message}</div>`;
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                document.getElementById('main-content').innerHTML = '<div class="alert alert-danger">An error occurred while fetching customers. Please try again later.</div>';
            }
        });
    }

    function loadChat(buyerName) {
        // Display chat UI
        document.getElementById('chat-ui').innerHTML = `
        <div class="card" style="width: 100%; max-width: 800px; margin: 0 auto;">
            <div class="card-header d-flex justify-content-between">
                <span>Chat with ${buyerName}</span>
                <button class="btn btn-sm btn-secondary" onclick="loadChat('${buyerName}')">Refresh</button>
            </div>
            <div class="card-body" style="height: 400px; overflow-y: auto;">
                <div id="message-list" class="mb-3">
                    <!-- Messages will be loaded here -->
                </div>
                <div>
                    <textarea id="message-text" class="form-control" placeholder="Type your message here"></textarea>
                    <button class="btn btn-success mt-2" onclick="sendMessage('${buyerName}')">Send</button>
                </div>
            </div>
        </div>
    `;

        // Fetch engagements and display messages
        fetchEngagements(buyerName);

        // Auto-refresh chat every 15 seconds
        setInterval(() => {
            fetchEngagements(buyerName);
        }, 15000);
    }

    function fetchEngagements(buyerName) {
        $.ajax({
            url: 'http://localhost/amis-project-/pages/routes.php',
            type: 'POST',
            data: {
                action: 'view-engagements'
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    let engagements = data.engagements.filter(engagement =>
                        (engagement.sender === buyerName || engagement.receiver === buyerName)
                    );

                    engagements.sort((a, b) => new Date(a.sent_at) - new Date(b.sent_at));

                    let messagesHtml = '';
                    engagements.forEach((engagement) => {
                        let isSender = engagement.sender === '<?php echo $_SESSION['username'] ?>';
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
            error: function(xhr, status, error) {
                console.error('Error:', error);
                document.getElementById('message-list').innerHTML = '<div class="alert alert-danger">An error occurred while fetching messages. Please try again later.</div>';
            }
        });
    }

    function sendMessage(buyerName) {
        let messageText = document.getElementById('message-text').value;
        if (!messageText.trim()) {
            alert('Please enter a message.');
            return;
        }

        // Send message
        $.ajax({
            url: 'http://localhost/amis-project-/pages/routes.php',
            type: 'POST',
            data: {
                action: 'add-engagement',
                message_text: messageText,
                sender: '<?php echo $_SESSION['username'] ?>', // You can dynamically set this
                receiver: buyerName
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    // Refresh chat
                    loadChat(buyerName);
                } else {
                    alert('Error: ' + data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('An error occurred while sending the message. Please try again later.');
            }
        });
    }
</script>