import { color, transparentize, CHART_COLORS, namedColor, newDateString, parseISODate } from '../utils.js';
// Forex rates for today
const rates = {
    USD_KES: 100,
    GBP_KES: 100,
    EUR_KES: 100,
    CAD_KES: 100
};

$.ajax({
    url: 'http://localhost/amis-project-/pages/routes.php',
    type: 'POST',
    data: { action: 'fetch-forex' },
    success: function (response) {
        var data = JSON.parse(response);
        if (data.success) {
            // Update the rates object with fetched data
            rates.USD_KES = parseFloat(data.forex.usd);
            rates.GBP_KES = parseFloat(data.forex.gbp);
            rates.EUR_KES = parseFloat(data.forex.eur);
            rates.CAD_KES = parseFloat(data.forex.cad);

            // Update the DOM with the new rates
            updateRates();
        } else {
            console.error('Failed to fetch forex rates:', data.message);
        }
    },
    error: function (xhr, status, error) {
        updateRates();
        console.error('Error:', error);
    }
});
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
            document.getElementById(valueId).textContent = finalValue.toFixed(2);
            document.getElementById(progressId).style.width = '100%';
            return;
        }
        currentValue += increment;
        document.getElementById(valueId).textContent = currentValue.toFixed(2);
        document.getElementById(progressId).style.width = `${(currentValue / finalValue) * 100}%`;
    }

    const interval = setInterval(update, stepTime);
    update(); // Initial call to ensure immediate update
}

// Animate each card

function updateRates() {
    animateCard('usdCard', 'usdValue', 'usdProgress', rates.USD_KES);
    animateCard('gbpCard', 'gbpValue', 'gbpProgress', rates.GBP_KES);
    animateCard('eurCard', 'eurValue', 'eurProgress', rates.EUR_KES);
    animateCard('cadCard', 'cadValue', 'cadProgress', rates.CAD_KES);
}

// Sample data

$.ajax({
    url: 'http://localhost/amis-project-/pages/routes.php',
    type: 'POST',
    data: { action: 'get-crop-market-trend', cropname: 'potatoes' },
    success: function(response) {
        var data = JSON.parse(response);
        if (data.success) {
            updateChart(data.market_trend);
        } else {
            alert(data.message);
        }
    },
    error: function(xhr, status, error) {
        alert('An error occurred: ' + error);
    }
});
function updateChart(marketTrend) {
    var labels = marketTrend.map(function(d) { return d.date; });
    var prices = marketTrend.map(function(d) { return parseFloat(d.price); });
    var maxPrice = marketTrend.length > 0 ? parseFloat(marketTrend[0].max_price) : 0;

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Crop Price',
                    data: prices,
                    backgroundColor: 'rgba(70, 130, 180, 0.5)',
                    borderColor: 'rgba(70, 130, 180, 1)',
                    borderWidth: 1,
                    tension: 0.4, // This adds the curve to the line
                    pointRadius: 5, // This controls the size of the points
                    pointHoverRadius: 7, // This controls the size of the points when hovered
                    pointBackgroundColor: 'rgba(70, 130, 180, 1)' // This sets the color of the points
                }
            ]
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
                        label: function (tooltipItem) {
                            return tooltipItem.dataset.label + ': ' + tooltipItem.raw.toFixed(2);
                        }
                    }
                },
                annotation: {
                    annotations: maxPrice > 0 ? [
                        {
                            type: 'line',
                            mode: 'horizontal',
                            scaleID: 'y',
                            value: maxPrice,
                            borderColor: 'red',
                            borderWidth: 1,
                            borderDash: [5, 2],
                            label: {
                                enabled: true,
                                content: 'Max Price'
                            }
                        }
                    ] : []
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Date'
                    },
                    stacked: false,
                    ticks: {
                        autoSkip: false
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Price'
                    },
                    beginAtZero: false,
                    stacked: false
                }
            }
        }
    });
}



// Add event listener for the download button
document.getElementById('downloadBtn').addEventListener('click', () => {
    // Convert the chart to a Base64 image URL
    const imageUrl = myChart.toBase64Image();
    // Create a temporary link element
    const link = document.createElement('a');
    link.href = imageUrl;
    link.download = 'chart.png'; // Name of the file to download
    // Trigger the download
    link.click();
});
