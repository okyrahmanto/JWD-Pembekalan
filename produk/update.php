<?php
require '../config/dbloader.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedProduct = [
        'id' => (int)$_POST['id'],
        'name' => $_POST['name'],
        'category' => $_POST['category'],
        'price' => (float)$_POST['price'],
        'stock' => (int)$_POST['stock']
    ];
    
    // Update in both database and JSON
    $success = $productManager->updateProduct($updatedProduct);
    
    if ($success) {
        // Success message could be added here
    }
}

header('Location: ../index.php/list');
exit();