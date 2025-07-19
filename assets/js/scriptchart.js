// Function to initialize stock chart
function initStockChart(labels, stocks) {
    const ctx = document.getElementById('stockChart').getContext('2d');
    const stockChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Stok',
                data: stocks,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Stok'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Nama Produk'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Grafik Stok Produk',
                    font: {
                        size: 16
                    }
                },
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });
    
    return stockChart;
}

// Function to show loading spinner for chart
function showChartLoading() {
    const canvas = document.getElementById('stockChart');
    if (canvas) {
        canvas.style.display = 'none';
        const loading = document.createElement('div');
        loading.id = 'chartLoading';
        loading.innerHTML = '<div class="spinner"></div>';
        loading.style.cssText = 'text-align: center; padding: 20px;';
        canvas.parentNode.insertBefore(loading, canvas);
    }
}

// Function to hide loading spinner for chart
function hideChartLoading() {
    const canvas = document.getElementById('stockChart');
    const loading = document.getElementById('chartLoading');
    if (canvas && loading) {
        canvas.style.display = 'block';
        loading.remove();
    }
}