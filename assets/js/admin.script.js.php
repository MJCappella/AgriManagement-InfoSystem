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
                            <h5 class="card-title">Manage Users</h5>
                            <p class="card-text">Add, edit, or remove users.</p>
                            <a href="#" class="btn btn-primary">Manage Users</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Manage Crops</h5>
                            <p class="card-text">Add crops.</p>
                            <a href="#" class="btn btn-primary">Manage Crops</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">View Reports</h5>
                            <p class="card-text">View various system reports.</p>
                            <a href="#" class="btn btn-primary">View Reports</a>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    //
    function loadManageUsers(element) {
        setActiveLink(element);
        document.getElementById('main-content').innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';

        const userTypes = ['farmers', 'buyers', 'governments', 'marketings', 'transporters'];
        let content = '';

        // Function to handle the AJAX success response
        function handleSuccess(userType, response) {
            const responseData = JSON.parse(response);
            console.log(responseData);
            if (responseData.success) {
                const tableContent = responseData[userType].map(user => `
            <tr data-${userType.slice(0, -1)}-id="${user[Object.keys(user)[0]]}">
                <td>${user.username}</td>
                <td>${user.email}</td>
                <td>${user.phone}</td>
                <td>
                    <select class="form-select" onchange="updateAccountStatus('${userType}', ${user[Object.keys(user)[0]]}, this.value)">
                        <option value="active" ${user.account_status === 'active' ? 'selected' : ''}>Active</option>
                        <option value="suspended" ${user.account_status === 'suspended' ? 'selected' : ''}>Suspended</option>
                        <option value="inactive" ${user.account_status === 'inactive' ? 'selected' : ''}>Inactive</option>
                    </select>
                </td>
            </tr>
        `).join('');
                console.log(userType.slice(0, -1));
                content += `
        <div id="${userType}-table-container" class="user-type-container">
            <h3 class="user-type-title">
                <img src="http://localhost/amis-project-/assets/images/${userType.slice(0,-1)}.png" alt="${userType} Icon" class="user-type-icon"/>
                ${userType.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase())}
            </h3>
            <div class="table-responsive">
                <table id="${userType}-table" class="table table-bordered table-hover table-responsive table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Account Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${tableContent}
                    </tbody>
                </table>
            </div>
        </div>
    `;
            } else {
                content += `<div class="alert alert-danger">Error fetching ${userType}: ${responseData.message}</div>`;
            }
        }

        // Function to fetch data and handle response
        function fetchData(userType) {
            let fetchData;
            switch (userType) {
                case 'farmers':
                    fetchData = getFarmers();
                    break;
                case 'buyers':
                    fetchData = getBuyers();
                    break;
                case 'governments':
                    fetchData = getGovernmentAgencies();
                    break;
                case 'marketings':
                    fetchData = getMarketingProfessionals();
                    break;
                case 'transporters':
                    fetchData = getTransporters();
                    break;
                default:
                    console.error('Unknown user type');
                    return Promise.resolve(); // Resolve immediately to avoid breaking Promise.all
            }

            return fetchData
                .done(response => handleSuccess(userType, response))
                .fail((xhr, status, error) => {
                    console.error('Error: ' + error);
                    content += `<div class="alert alert-danger">Error fetching ${userType}: ${error}</div>`;
                });
        }

        // Fetch data for each user type
        const fetchPromises = userTypes.map(fetchData);

        // When all data is fetched, update the main content and initialize DataTables
        Promise.all(fetchPromises).then(() => {
            document.getElementById('main-content').innerHTML = content;

            userTypes.forEach(userType => {
                if (responseData[userType] && responseData[userType].length) {
                    $(`#${userType}-table`).DataTable({
                        "ordering": true,
                        "searching": true,
                        "paging": true
                    });
                }
            });
        });
    }


    // Example AJAX functions
    function getFarmers() {
        return $.ajax({
            url: '/amis-project-/pages/routes.php',
            type: 'POST',
            data: {
                action: 'get-farmers'
            }
        });
    }

    function getBuyers() {
        return $.ajax({
            url: '/amis-project-/pages/routes.php',
            type: 'POST',
            data: {
                action: 'get-buyers'
            }
        });
    }

    function getGovernmentAgencies() {
        return $.ajax({
            url: '/amis-project-/pages/routes.php',
            type: 'POST',
            data: {
                action: 'get-government-agencies'
            }
        });
    }

    function getMarketingProfessionals() {
        return $.ajax({
            url: '/amis-project-/pages/routes.php',
            type: 'POST',
            data: {
                action: 'get-marketing-professionals'
            }
        });
    }

    function getTransporters() {
        return $.ajax({
            url: '/amis-project-/pages/routes.php',
            type: 'POST',
            data: {
                action: 'get-transporters'
            }
        });
    }

    function updateAccountStatus(userType, userId, newStatus) {
        let action;

        switch (userType) {
            case 'farmers':
                action = 'set-farmer-account-status';
                break;
            case 'buyers':
                action = 'set-buyer-account-status';
                break;
            case 'governments':
                action = 'set-government-agency-account-status';
                break;
            case 'marketings':
                action = 'set-marketing-professional-account-status';
                break;
            case 'transporters':
                action = 'set-transporter-account-status';
                break;
            default:
                console.error('Unknown user type');
                return;
        }
        var formDat = {
            action: action,
            [`${userType.slice(0, -1)}_id`]: userId,
            status: newStatus
        };
        console.log(formDat);
        $.ajax({
            url: '/amis-project-/pages/routes.php',
            type: 'POST',
            data: {
                action: action,
                [`${userType.slice(0, -1)}_id`]: userId,
                status: newStatus
            },
            success: function(response) {
                const responseData = JSON.parse(response);
                if (responseData.success) {
                    alert('Account status updated successfully');
                } else {
                    alert('Error: ' + responseData.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + error);
            }
        });
    }


    //
    // Function to load crops and display them
    function loadManageCrops(element) {
        setActiveLink(element);
        document.getElementById('main-content').innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';

        $.ajax({
            url: '/amis-project-/pages/routes.php',
            type: 'POST',
            data: {
                action: 'get-crops'
            },
            success: function(response) {
                const responseData = JSON.parse(response);
                console.log(responseData);
                if (responseData.success) {
                    let tableContent = responseData.crops.map(crop => `
                    <tr>
                        <td>${crop.cropname}</td>
                        <td>${crop.description}</td>
                        <td>${crop.price}</td>
                        <td><img src="${crop.image_path}" alt="${crop.cropname}" height="75" width="100"></td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="showUpdateCropForm(${crop.crop_id}, '${crop.cropname}', '${crop.description}', ${crop.price}, '${crop.image_path}')">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="showDeleteCropConfirm('${crop.cropname}', ${crop.crop_id})">Delete</button>
                        </td>
                    </tr>
                `).join('');
                    document.getElementById('main-content').innerHTML = `
                        <button class="btn btn-primary mb-3" id="add-crop" onclick="showAddCropModal()">Add Crop</button>
                        <h2>Market Prices</h2>
                        <div class="table-responsive">
                            <table class="table display table-bordered table-hover" id="cropsTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Crop</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Picture</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${tableContent}
                                </tbody>
                            </table>
                        </div>
                    `;

                    // Add sortable table functionality
                    $('#cropsTable').DataTable({
                        "ordering": true,
                        "searching": true,
                        "paging": true
                    });

                } else {
                    $('#cropsTable tbody').html(`<tr><td colspan="5" class="text-center text-danger">${responseData.message}</td></tr>`);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    // Function to show Add Crop modal
    function showAddCropModal() {
        var addModal = new bootstrap.Modal(document.getElementById('addCropModal'));
        addModal.show();
    }

    // Function to handle Add Crop form submission
    $('#addCropForm').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        formData.append('action', 'add-crop');
        $.ajax({
            url: '/amis-project-/pages/routes.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                const responseData = JSON.parse(response);
                if (responseData.success) {
                    $('#addCropModal').modal('hide');
                    loadManageCrops(document.getElementById('manage-users'));
                    showAlert('Success', responseData.message);
                } else {
                    showAlert('Error', responseData.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });

    // Function to show Update Crop form
    function showUpdateCropForm(crop_id, cropname, description, price, image_path) {
        $('#update_crop_id').val(crop_id);
        $('#update_cropname').val(cropname);
        $('#update_description').val(description);
        $('#update_price').val(price);

        // Set the image preview source
        const imagePreview = $('#crop_image_preview');
        if (image_path) {
            imagePreview.attr('src', image_path).show();
        } else {
            imagePreview.hide();
        }

        $('#updateCropModal').modal('show');
    }

    // Function to handle file input change (optional)
    $('#update_crop_image').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#crop_image_preview').attr('src', e.target.result).show();
            };
            reader.readAsDataURL(file);
        }
    });


    // Function to handle Update Crop form submission
    $('#updateCropForm').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        formData.append('action', 'update-crop');
        $.ajax({
            url: '/amis-project-/pages/routes.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                const responseData = JSON.parse(response);
                if (responseData.success) {
                    $('#updateCropModal').modal('hide');
                    loadManageCrops(document.getElementById('manage-users'));
                    showAlert('Success', responseData.message);
                } else {
                    showAlert('Error', responseData.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });

    // Function to show Delete Crop confirmation modal
    function showDeleteCropConfirm(cropname, crop_id) {
        $('#delete_cropname').text(cropname);
        $('#delete_crop_id').val(crop_id);
        $('#deleteCropModal').modal('show');
    }

    // Function to handle Delete Crop confirmation
    function confirmDeleteCrop() {
        let crop_id = $('#delete_cropname').text();
        console.log(crop_id);
        $.ajax({
            url: '/amis-project-/pages/routes.php',
            type: 'POST',
            data: {
                action: 'delete-crop',
                cropname: crop_id
            },
            success: function(response) {
                const responseData = JSON.parse(response);
                if (responseData.success) {
                    $('#deleteCropModal').modal('hide');
                    loadManageCrops(document.getElementById('manage-users'));
                    showAlert('Success', responseData.message);
                } else {
                    showAlert('Error', responseData.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    // Function to show alert messages
    function showAlert(title, message) {
        alert(`${title}: ${message}`);
    }

    // Initialize crop management on page load
    // $(document).ready(function() {
    //     loadManageCrops();
    // });



    //
    function loadManageReports(element) {
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

    //messages
    function loadSubscribersMessaging(element) {
        setActiveLink(element);
        document.getElementById('main-content').innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';

        // Fetch previous messages
        $.ajax({
            url: 'http://localhost/amis-project-/pages/routes.php',
            type: 'POST',
            data: {
                action: 'view-messages'
            },
            success: function(response) {
                let data = JSON.parse(response);
                if (data.success) {
                    console.log(data.messages);
                    displayMessageFormAndHistory(data.messages);
                } else {
                    alert('Error loading messages: ' + data.message);
                }
            },
            error: function() {
                alert('Failed to fetch messages. Please try again later.');
            }
        });
    }

    function displayMessageFormAndHistory(messages) {
        let mainContent = `
    <div class="container py-4">
        <h3 class="mb-2 bg-primary text-white text-center p-1 rounded">Message Subscribers</h3>
        <form id="messageForm" class="mb-4">
            <div class="mb-3">
                <label for="subject" class="form-label">Subject</label>
                <input type="text" class="form-control" value="Exciting New Products Just Arrived!" id="subject" name="subject" required>
            </div>
            <div class="mb-3">
                <label for="message_text" class="form-label">Message</label>
                <textarea class="form-control" id="message_text" name="message_text" rows="5" required>
Dear Subscriber,
We are thrilled to announce the arrival of our latest products in the market! Our new collection features innovative designs and top-notch quality that you will absolutely love.
Visit our website to explore the new arrivals and take advantage of exclusive offers available only to our subscribers.
Thank you for being a valued member of our community!
Best regards,
                </textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
        <h3 class="mb-2 bg-primary text-white text-center p-1 rounded">Previous Messages</h3>
        <div class="list-group overflow-auto" style="max-height: 400px;">`;

        if (messages.length > 0) {
            messages.forEach(msg => {
                mainContent += `
            <a href="#" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">${msg.subject}</h5>
                    <small class="text-muted">${new Date(msg.sent_at).toLocaleString()}</small>
                </div>
                <p class="mb-1 text-secondary">${msg.message_text}</p>
            </a>`;
            });
        } else {
            mainContent += `
        <div class="alert alert-info" role="alert">
            No previous messages found.
        </div>`;
        }

        mainContent += `</div></div>`;

        document.getElementById('main-content').innerHTML = mainContent;

        // Handle form submission
        $('#messageForm').on('submit', function(e) {
            e.preventDefault();
            sendMessageToSubscribers();
        });
    }

    function sendMessageToSubscribers() {
        let subject = $('#subject').val();
        let message_text = $('#message_text').val();

        // Disable the form and show the loading spinner
        $('#messageForm button').prop('disabled', true);
        $('#messageForm').append(`
        <div id="loadingSpinner" class="text-center mt-3">
            <div class="spinner-border" role="status" style="border-color: #007377 transparent transparent transparent;">
                <span class="visually-hidden">Sending...</span>
            </div>
            <p class="mt-2">Sending your message, please wait...</p>
        </div>
    `);

        $.ajax({
            url: 'http://localhost/amis-project-/pages/routes.php',
            type: 'POST',
            data: {
                action: 'message-subscribers',
                subject: subject,
                message_text: message_text
            },
            success: function(response) {
                let data = JSON.parse(response);
                $('#messageForm button').prop('disabled', false);
                $('#loadingSpinner').remove();
                if (data.success) {
                    alert('Message sent successfully!');
                } else {
                    alert('Error sending message: ' + data.message);
                }
            },
            error: function() {
                alert('Failed to send message. Please try again later.');
            },
            complete: function() {
                loadSubscribersMessaging(); // Reload the page to show the new message in history
            }
        });
    }
</script>