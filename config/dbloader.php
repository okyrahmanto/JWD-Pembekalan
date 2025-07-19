<?php

declare(strict_types=1);

require_once 'database.php';
require_once 'jsonloader.php';

/**
 * Product Manager Class
 * 
 * Handles product operations with dual storage (MySQL + JSON)
 */
class ProductManager
{
    private PDO $pdo;
    private string $jsonFile = 'produk/products.json';

    public function __construct()
    {
        $this->pdo = getDBConnection();
    }

    /**
     * Load products from database (primary) and JSON (fallback)
     */
    public function loadProducts(): array
    {
        try {
            // Try to load from database first
            $stmt = $this->pdo->prepare(
                'SELECT * FROM products ORDER BY created_at DESC'
            );
            $stmt->execute();
            $products = $stmt->fetchAll();

            if (!empty($products)) {
                return $products;
            }

            // If database is empty, load from JSON and sync to database
            $jsonProducts = loadProducts(); // From jsonloader.php
            if (!empty($jsonProducts)) {
                $this->syncJsonToDatabase($jsonProducts);

                return $jsonProducts;
            }

            return [];
        } catch (Exception $e) {
            // Fallback to JSON if database fails
            return loadProducts();
        }
    }

    /**
     * Add new product to both database and JSON
     */
    public function addProduct(array $product): bool
    {
        try {
            // Add to database
            $stmt = $this->pdo->prepare(
                'INSERT INTO products (id, name, category, price, stock) 
                VALUES (:id, :name, :category, :price, :stock)'
            );

            $stmt->execute([
                ':id' => $product['id'],
                ':name' => $product['name'],
                ':category' => $product['category'],
                ':price' => $product['price'],
                ':stock' => $product['stock'],
            ]);

            // Also save to JSON as backup
            $this->saveToJson($product);

            return true;
        } catch (Exception $e) {
            // If database fails, save to JSON only
            $this->saveToJson($product);

            return false;
        }
    }

    /**
     * Update product in both database and JSON
     */
    public function updateProduct(array $product): bool
    {
        try {
            // Update in database
            $stmt = $this->pdo->prepare(
                'UPDATE products 
                SET name = :name, category = :category, price = :price, stock = :stock 
                WHERE id = :id'
            );

            $stmt->execute([
                ':id' => $product['id'],
                ':name' => $product['name'],
                ':category' => $product['category'],
                ':price' => $product['price'],
                ':stock' => $product['stock'],
            ]);

            // Also update JSON
            $this->updateInJson($product);

            return true;
        } catch (Exception $e) {
            // If database fails, update JSON only
            $this->updateInJson($product);

            return false;
        }
    }

    /**
     * Delete product from both database and JSON
     */
    public function deleteProduct(int $id): bool
    {
        try {
            // Delete from database
            $stmt = $this->pdo->prepare('DELETE FROM products WHERE id = :id');
            $stmt->execute([':id' => $id]);

            // Also delete from JSON
            $this->deleteFromJson($id);

            return true;
        } catch (Exception $e) {
            // If database fails, delete from JSON only
            $this->deleteFromJson($id);

            return false;
        }
    }

    /**
     * Get product by ID
     */
    public function getProduct(int $id): ?array
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM products WHERE id = :id');
            $stmt->execute([':id' => $id]);

            return $stmt->fetch() ?: null;
        } catch (Exception $e) {
            // Fallback to JSON
            $products = loadProducts();
            foreach ($products as $product) {
                if ($product['id'] == $id) {
                    return $product;
                }
            }

            return null;
        }
    }

    /**
     * Get products by category
     */
    public function getProductsByCategory(string $category): array
    {
        try {
            $stmt = $this->pdo->prepare(
                'SELECT * FROM products WHERE category = :category ORDER BY created_at DESC'
            );
            $stmt->execute([':category' => $category]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            // Fallback to JSON
            $products = loadProducts();

            return array_filter($products, function ($product) use ($category) {
                return $product['category'] === $category;
            });
        }
    }

    /**
     * Get product statistics
     */
    public function getProductStats(): array
    {
        try {
            $stats = [];

            // Total products
            $stmt = $this->pdo->prepare('SELECT COUNT(*) as total FROM products');
            $stmt->execute();
            $stats['total'] = $stmt->fetch()['total'];

            // Total stock
            $stmt = $this->pdo->prepare('SELECT SUM(stock) as total_stock FROM products');
            $stmt->execute();
            $stats['total_stock'] = $stmt->fetch()['total_stock'] ?? 0;

            // Total value
            $stmt = $this->pdo->prepare(
                'SELECT SUM(price * stock) as total_value FROM products'
            );
            $stmt->execute();
            $stats['total_value'] = $stmt->fetch()['total_value'] ?? 0;

            // Categories count
            $stmt = $this->pdo->prepare(
                'SELECT category, COUNT(*) as count FROM products GROUP BY category'
            );
            $stmt->execute();
            $stats['categories'] = $stmt->fetchAll();

            return $stats;
        } catch (Exception $e) {
            // Fallback to JSON calculation
            $products = loadProducts();
            $stats = [
                'total' => count($products),
                'total_stock' => array_sum(array_column($products, 'stock')),
                'total_value' => array_sum(
                    array_map(function ($p) {
                        return $p['price'] * $p['stock'];
                    }, $products)
                ),
                'categories' => [],
            ];

            $categories = [];
            foreach ($products as $product) {
                $categories[$product['category']] = ($categories[$product['category']] ?? 0) + 1;
            }

            foreach ($categories as $category => $count) {
                $stats['categories'][] = ['category' => $category, 'count' => $count];
            }

            return $stats;
        }
    }

    /**
     * Private helper methods for JSON operations
     */
    private function saveToJson(array $product): void
    {
        $products = loadProducts();
        $products[] = $product;
        file_put_contents($this->jsonFile, json_encode($products, JSON_PRETTY_PRINT));
    }

    private function updateInJson(array $updatedProduct): void
    {
        $products = loadProducts();
        foreach ($products as &$product) {
            if ($product['id'] == $updatedProduct['id']) {
                $product = $updatedProduct;
                break;
            }
        }
        file_put_contents($this->jsonFile, json_encode($products, JSON_PRETTY_PRINT));
    }

    private function deleteFromJson(int $id): void
    {
        $products = loadProducts();
        $products = array_filter($products, function ($product) use ($id) {
            return $product['id'] != $id;
        });
        file_put_contents($this->jsonFile, json_encode(array_values($products), JSON_PRETTY_PRINT));
    }

    private function syncJsonToDatabase(array $jsonProducts): void
    {
        foreach ($jsonProducts as $product) {
            try {
                $stmt = $this->pdo->prepare(
                    'INSERT IGNORE INTO products (id, name, category, price, stock) 
                    VALUES (:id, :name, :category, :price, :stock)'
                );
                $stmt->execute([
                    ':id' => $product['id'],
                    ':name' => $product['name'],
                    ':category' => $product['category'],
                    ':price' => $product['price'],
                    ':stock' => $product['stock'],
                ]);
            } catch (Exception $e) {
                // Skip if product already exists
                continue;
            }
        }
    }
}

// Create global instance
$productManager = new ProductManager(); 