<?php

declare(strict_types=1);

require 'config/dbloader.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newProduct = [
        'id' => time(),
        'name' => $_POST['name'],
        'category' => $_POST['category'],
        'price' => (float) $_POST['price'],
        'stock' => (int) $_POST['stock'],
    ];

    // Add to both database and JSON
    $success = $productManager->addProduct($newProduct);

    if ($success) {
        // Success message could be added here
    }
}

header('Location: list');
exit();