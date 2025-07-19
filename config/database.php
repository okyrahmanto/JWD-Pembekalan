<?php

declare(strict_types=1);

// Database configuration
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'umkm_jwd');
define('DB_USER', 'root');
define('DB_PASS', 'root');

/**
 * Create database connection
 */
function getDBConnection(): PDO
{
    try {
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8',
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );

        return $pdo;
    } catch (PDOException $e) {
        die('Database connection failed: ' . $e->getMessage());
    }
}

/**
 * Initialize database tables
 */
function initDatabase(): bool
{
    try {
        $pdo = getDBConnection();

        // Create products table
        $sql = 'CREATE TABLE IF NOT EXISTS products (
            id BIGINT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            category VARCHAR(255) NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            stock INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';

        $pdo->exec($sql);

        return true;
    } catch (PDOException $e) {
        die('Database initialization failed: ' . $e->getMessage());
    }
}

/**
 * Test database connection
 */
function testConnection(): bool
{
    try {
        $pdo = getDBConnection();
        echo 'Database connection successful!';

        return true;
    } catch (Exception $e) {
        echo 'Database connection failed: ' . $e->getMessage();

        return false;
    }
} 