<?php
require '../config/jsonloader.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $products = loadProducts();
    foreach ($products as &$item) {
        if ($item['id'] == $_POST['id']) {
            $item['name'] = $_POST['name'];
            $item['category'] = $_POST['category'];
            $item['price'] = (int)$_POST['price'];
            $item['stock'] = (int)$_POST['stock'];
            break;
        }
    }
    file_put_contents('products.json', json_encode($products, JSON_PRETTY_PRINT));
}

header('Location: list.php');
exit();