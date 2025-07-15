<?php
function loadProducts() {
    $file = 'products.json';
    return file_exists($file) ? json_decode(file_get_contents($file), true) : [];
}
?>