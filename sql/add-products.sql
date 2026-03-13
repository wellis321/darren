-- Products/merch table for shop
-- Run against your DB: mysql -u user -p YOUR_DB_NAME < sql/add-products.sql
-- Or in phpMyAdmin: select your database first, then run this.
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(120) NOT NULL UNIQUE,
    title VARCHAR(255) NOT NULL,
    description TEXT DEFAULT NULL,
    price DECIMAL(10,2) DEFAULT NULL,
    image_url VARCHAR(500) DEFAULT NULL,
    category VARCHAR(50) DEFAULT 'general',
    sizes VARCHAR(255) DEFAULT NULL,
    buy_url VARCHAR(500) DEFAULT NULL,
    is_featured TINYINT(1) DEFAULT 0,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_featured (is_featured)
);

-- Seed sample products (distinct Unsplash images per product)
INSERT INTO products (slug, title, description, price, image_url, category, sizes, is_featured, sort_order) VALUES
('banter-2024-tour-tee', '''Banter'' 2024 Tour Tee', 'Heavyweight 100% organic cotton tee featuring the iconic 2024 Glasgow ''Banter'' tour dates on the back. Limited edition run.', 25.00, 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800&q=80', 'tour_apparel', 'S, M, L, XL', 1, 0),
('banter-mug-pure-dead-brilliant', 'Banter Mug: ''Pure Dead Brilliant''', NULL, 12.50, 'https://images.unsplash.com/photo-1666731843459-4005513dac66?w=800&q=80', 'banter_mugs', NULL, 0, 1),
('banter-mug-hows-it-hingin', 'Banter Mug: ''How''s it hingin''?''', NULL, 12.50, 'https://images.unsplash.com/photo-1571545479842-77b86d3f9fdf?w=800&q=80', 'banter_mugs', NULL, 0, 2),
('magnet-people-make-glasgow', 'Magnet: ''People Make Glasgow''', NULL, 5.00, 'https://images.unsplash.com/photo-1612565775767-97a9fffef857?w=800&q=80', 'glasgow_humor', NULL, 0, 3),
('magnet-did-ye-aye', 'Magnet: ''Did Ye Aye?''', NULL, 5.00, 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80', 'glasgow_humor', NULL, 0, 4)
ON DUPLICATE KEY UPDATE slug=slug;
