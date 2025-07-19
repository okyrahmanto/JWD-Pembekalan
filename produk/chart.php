<html>
<head>
    <title>Grafik Stok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/csslist.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <?php
        require '../config/dbloader.php';
        $products = $productManager->loadProducts();
        $stats = $productManager->getProductStats();
        
        $labels = [];
        $stocks = [];
        $prices = [];
        $values = [];
        
        foreach ($products as $p) {
            $labels[] = $p['name'];
            $stocks[] = $p['stock'];
            $prices[] = $p['price'];
            $values[] = $p['price'] * $p['stock'];
        }
        ?>
        <h1>Dashboard Produk</h1>
        <a href="../index.php/list" class="btn btn-primary mb-3">Kembali ke Daftar</a>
        
        <!-- Statistics Summary -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ringkasan Statistik</h5>
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Total Produk:</strong> <?= $stats['total'] ?>
                            </div>
                            <div class="col-md-3">
                                <strong>Total Stok:</strong> <?= $stats['total_stock'] ?>
                            </div>
                            <div class="col-md-3">
                                <strong>Total Nilai:</strong> Rp <?= number_format($stats['total_value'], 0, ',', '.') ?>
                            </div>
                            <div class="col-md-3">
                                <strong>Kategori:</strong> <?= count($stats['categories']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Charts Row -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Grafik Stok Produk</h5>
                        <div class="chart-container" style="position: relative; height:300px;">
                            <canvas id="stockChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Grafik Nilai Produk</h5>
                        <div class="chart-container" style="position: relative; height:300px;">
                            <canvas id="valueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Category Chart -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Distribusi Kategori</h5>
                        <div class="chart-container" style="position: relative; height:300px;">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading spinner -->
    <div id="loading" class="loading">
        <div class="spinner"></div>
    </div>

    <script src="../assets/js/scriptchart.js"></script>
    <script>
        // Show loading initially
        showChartLoading();
        
        // Initialize charts with PHP data
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                hideChartLoading();
                
                // Stock Chart
                initStockChart(<?= json_encode($labels) ?>, <?= json_encode($stocks) ?>);
                
                // Value Chart
                const valueCtx = document.getElementById('valueChart').getContext('2d');
                new Chart(valueCtx, {
                    type: 'line',
                    data: {
                        labels: <?= json_encode($labels) ?>,
                        datasets: [{
                            label: 'Nilai Total (Rp)',
                            data: <?= json_encode($values) ?>,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 2,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Nilai (Rp)'
                                }
                            }
                        }
                    }
                });
                
                // Category Chart
                const categoryCtx = document.getElementById('categoryChart').getContext('2d');
                new Chart(categoryCtx, {
                    type: 'doughnut',
                    data: {
                        labels: <?= json_encode(array_column($stats['categories'], 'category')) ?>,
                        datasets: [{
                            data: <?= json_encode(array_column($stats['categories'], 'count')) ?>,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.8)',
                                'rgba(54, 162, 235, 0.8)',
                                'rgba(255, 206, 86, 0.8)',
                                'rgba(75, 192, 192, 0.8)',
                                'rgba(153, 102, 255, 0.8)'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }, 500);
        });
    </script>
</body>
</html>