<?php
    // Get the path from the URL
    $request_uri = $_SERVER['REQUEST_URI'];
    $script_name = $_SERVER['SCRIPT_NAME'];
    
    // Remove the script name from the request URI to get the path
    $path = str_replace($script_name, '', $request_uri);
    $path = trim($path, '/');
    
    // Define the routing rules
    $routes = [
        'list' => 'produk/list.php',
        'add' => 'produk/add.php',
        'chart' => 'produk/chart.php',
        'update' => 'produk/update.php',
        'proses' => 'produk/proses.php'
    ];
    
    // Check if the path exists in our routes
    if (isset($routes[$path])) {
        // Redirect to the corresponding file
        header("Location: " . $routes[$path]);
        exit();
    } else {
        // Default redirect to list page if no valid route
        header("Location: produk/list.php");
        exit();
    }
?>