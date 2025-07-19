-- UMKM Database Setup
-- Create database if not exists
CREATE DATABASE IF NOT EXISTS umkm_db 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Use the database
USE umkm_db;

-- Create products table
CREATE TABLE IF NOT EXISTS products (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create indexes for better performance
CREATE INDEX idx_products_category ON products(category);
CREATE INDEX idx_products_created_at ON products(created_at);

-- Insert sample data (optional)
INSERT INTO products (id, name, category, price, stock) VALUES
(1703123456789, 'Laptop Asus ROG', 'Elektronik', 15000000.00, 5),
(1703123456790, 'Smartphone Samsung', 'Elektronik', 5000000.00, 10),
(1703123456791, 'Buku Programming', 'Buku', 150000.00, 20),
(1703123456792, 'Kemeja Pria', 'Pakaian', 250000.00, 15),
(1703123456793, 'Sepatu Nike', 'Olahraga', 1200000.00, 8)
ON DUPLICATE KEY UPDATE
    name = VALUES(name),
    category = VALUES(category),
    price = VALUES(price),
    stock = VALUES(stock);

-- Show table structure
DESCRIBE products;

-- Show sample data
SELECT * FROM products; 