<?php
require_once 'database.php';
require_once 'dbloader.php';

echo "<h2>Database Connection Test</h2>";

// Test database connection
echo "<h3>1. Testing Database Connection</h3>";
try {
    $pdo = getDBConnection();
    echo "✅ Database connection successful!<br>";
    echo "Database: " . DB_NAME . "<br>";
    echo "Host: " . DB_HOST . "<br>";
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
    exit;
}

// Test table creation
echo "<h3>2. Testing Table Creation</h3>";
try {
    initDatabase();
    echo "✅ Database tables initialized successfully!<br>";
} catch (Exception $e) {
    echo "❌ Table creation failed: " . $e->getMessage() . "<br>";
}

// Test ProductManager
echo "<h3>3. Testing Product Manager</h3>";
try {
    $products = $productManager->loadProducts();
    echo "✅ ProductManager loaded " . count($products) . " products<br>";
    
    if (!empty($products)) {
        echo "<h4>Sample Products:</h4>";
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th></tr>";
        foreach (array_slice($products, 0, 3) as $product) {
            echo "<tr>";
            echo "<td>{$product['id']}</td>";
            echo "<td>{$product['name']}</td>";
            echo "<td>{$product['category']}</td>";
            echo "<td>{$product['price']}</td>";
            echo "<td>{$product['stock']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
} catch (Exception $e) {
    echo "❌ ProductManager test failed: " . $e->getMessage() . "<br>";
}

// Test statistics
echo "<h3>4. Testing Statistics</h3>";
try {
    $stats = $productManager->getProductStats();
    echo "✅ Statistics generated successfully!<br>";
    echo "Total Products: " . $stats['total'] . "<br>";
    echo "Total Stock: " . $stats['total_stock'] . "<br>";
    echo "Total Value: Rp " . number_format($stats['total_value'], 0, ',', '.') . "<br>";
    echo "Categories: " . count($stats['categories']) . "<br>";
} catch (Exception $e) {
    echo "❌ Statistics test failed: " . $e->getMessage() . "<br>";
}

echo "<h3>5. Database Configuration</h3>";
echo "DB_HOST: " . DB_HOST . "<br>";
echo "DB_NAME: " . DB_NAME . "<br>";
echo "DB_USER: " . DB_USER . "<br>";
echo "DB_PASS: " . (DB_PASS ? '***' : 'empty') . "<br>";

echo "<h3>6. Next Steps</h3>";
echo "If all tests pass above, your database is ready!<br>";
echo "You can now use the application with MySQL database.<br>";
echo "<a href='../index.php/list'>Go to Product List</a><br>";
echo "<a href='../index.php/chart'>Go to Charts</a><br>";
?> 