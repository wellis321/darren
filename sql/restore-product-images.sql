-- Restore 5 products with distinct Unsplash images
-- Run: mysql -h 127.0.0.1 -P 8889 -u root -proot darrenn < sql/restore-product-images.sql
-- Or in phpMyAdmin: select your database, then run this.

UPDATE products SET image_url = 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800&q=80' WHERE slug = 'banter-2024-tour-tee';
UPDATE products SET image_url = 'https://images.unsplash.com/photo-1666731843459-4005513dac66?w=800&q=80' WHERE slug = 'banter-mug-pure-dead-brilliant';
UPDATE products SET image_url = 'https://images.unsplash.com/photo-1571545479842-77b86d3f9fdf?w=800&q=80' WHERE slug = 'banter-mug-hows-it-hingin';
UPDATE products SET image_url = 'https://images.unsplash.com/photo-1612565775767-97a9fffef857?w=800&q=80' WHERE slug = 'magnet-people-make-glasgow';
UPDATE products SET image_url = 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80' WHERE slug = 'magnet-did-ye-aye';
