<?php
require '../config/jsonloader.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $products = loadProducts();
    $new = [
        'id' => time(),
        'name' => $_POST['name'],
        'category' => $_POST['category'],
        'price' => (int)$_POST['price'],
        'stock' => (int)$_POST['stock']
    ];
    $products[] = $new;
    file_put_contents('products.json', json_encode($products, JSON_PRETTY_PRINT));
}

header('Location: list.php');
exit();