<?php

declare(strict_types=1);

// Get the path from the URL
$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = $_SERVER['SCRIPT_NAME'];

// Remove the script name from the request URI to get the path
$path = str_replace($scriptName, '', $requestUri);
$path = trim($path, '/');

// Define the routing rules
$routes = [
    'list' => 'produk/list.php',
    'add' => 'produk/add.php',
    'chart' => 'produk/chart.php',
    'update' => 'produk/update.php',
    'proses' => 'produk/proses.php',
];

// Check if the path exists in our routes
if (isset($routes[$path])) {
    // Include the corresponding file directly
    $filePath = $routes[$path];
    if (file_exists($filePath)) {
        include $filePath;
        exit();
    }
}

// Default to list page if no valid route
if (file_exists('produk/list.php')) {
    include 'produk/list.php';
    exit();
}

// Fallback if list.php doesn't exist
echo 'Error: Could not find the requested page.';
exit();
?>