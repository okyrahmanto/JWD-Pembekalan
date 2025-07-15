<html>
<head>
    <title>Grafik Stok</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php
    require '../config/jsonloader.php';
    $products = loadProducts();
    $labels = [];
    $stocks = [];
    foreach ($products as $p) {
        $labels[] = $p['name'];
        $stocks[] = $p['stock'];
    }
    ?>
    <h1>Grafik Stok Produk</h1>
    <canvas id="stockChart" width="400" height="200"></canvas>
    <script src="assets/js/scriptchart.js"></script>
</body>
    
</html>