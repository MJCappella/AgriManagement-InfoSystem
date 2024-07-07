// Sample data
const data = [
    { date: '2024-01-01', productA: 60 + Math.random() * 20, productB: 90 + Math.random() * 20, productC: 90 + Math.random() * 20 },
    { date: '2024-02-01', productA: 60 + Math.random() * 20, productB: 70 + Math.random() * 20, productC: 130 + Math.random() * 20 },
    { date: '2024-03-01', productA: 45 + Math.random() * 20, productB: 90 + Math.random() * 20, productC: 130 + Math.random() * 20 },
    { date: '2024-04-01', productA: 55 + Math.random() * 20, productB: 90 + Math.random() * 20, productC: 90 + Math.random() * 20 },
    { date: '2024-05-01', productA: 55 + Math.random() * 20, productB: 70 + Math.random() * 20, productC: 130 + Math.random() * 20 },
    { date: '2024-06-01', productA: 60 + Math.random() * 20, productB: 90 + Math.random() * 20, productC: 90 + Math.random() * 20 },
    { date: '2024-07-01', productA: 60 + Math.random() * 20, productB: 90 + Math.random() * 20, productC: 130 + Math.random() * 20 },
    { date: '2024-08-01', productA: 72 + Math.random() * 20, productB: 52 + Math.random() * 20, productC: 78 + Math.random() * 20 },
    { date: '2024-09-01', productA: 65 + Math.random() * 20, productB: 85 + Math.random() * 20, productC: 95 + Math.random() * 20 },
    { date: '2024-10-01', productA: 70 + Math.random() * 20, productB: 75 + Math.random() * 20, productC: 100 + Math.random() * 20 },
    { date: '2024-11-01', productA: 68 + Math.random() * 20, productB: 80 + Math.random() * 20, productC: 110 + Math.random() * 20 },
    { date: '2024-12-01', productA: 75 + Math.random() * 20, productB: 85 + Math.random() * 20, productC: 120 + Math.random() * 20 },
];

// Extract labels and data
const labels = data.map(d => d.date);
const productAData = data.map(d => d.productA);
const productBData = data.map(d => d.productB);
const productCData = data.map(d => d.productC);

// Create the stacked area chart
const ctx = document.getElementById('myChart').getContext('2d');
const myChart = new Chart(ctx, {
    type: 'line', // Use line chart type
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Product A',
                data: productAData,
                backgroundColor: 'rgba(70, 130, 180, 0.5)',
                borderColor: 'rgba(70, 130, 180, 1)',
                borderWidth: 1,
                fill: true, // Enable filling
            },
            {
                label: 'Product B',
                data: productBData,
                backgroundColor: 'rgba(34, 139, 34, 0.5)',
                borderColor: 'rgba(34, 139, 34, 1)',
                borderWidth: 1,
                fill: true, // Enable filling
            },
            {
                label: 'Product C',
                data: productCData,
                backgroundColor: 'rgba(255, 69, 0, 0.5)',
                borderColor: 'rgba(255, 69, 0, 1)',
                borderWidth: 1,
                fill: true, // Enable filling
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
                    label: function(tooltipItem) {
                        return tooltipItem.dataset.label + ': ' + tooltipItem.raw.toFixed(2);
                    }
                }
            }
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
    link.download = 'chart.png'; // Name of the file to download
    // Trigger the download
    link.click();
});
