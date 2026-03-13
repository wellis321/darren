-- Ensure all 5 products exist with distinct images (insert or update)
-- Run in phpMyAdmin: select your database, then run this.

INSERT INTO products (slug, title, description, price, image_url, category, sizes, is_featured, sort_order) VALUES
('banter-2024-tour-tee', 'Banter 2024 Tour Tee', 'Heavyweight 100% organic cotton tee featuring the iconic 2024 Glasgow Banter tour dates on the back. Limited edition run.', 25.00, 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800&q=80', 'tour_apparel', 'S, M, L, XL', 1, 0),
('banter-mug-pure-dead-brilliant', 'Banter Mug: Pure Dead Brilliant', NULL, 12.50, 'https://images.unsplash.com/photo-1666731843459-4005513dac66?w=800&q=80', 'banter_mugs', NULL, 0, 1),
('banter-mug-hows-it-hingin', 'Banter Mug: How''s it hingin''?', NULL, 12.50, 'https://images.unsplash.com/photo-1571545479842-77b86d3f9fdf?w=800&q=80', 'banter_mugs', NULL, 0, 2),
('magnet-people-make-glasgow', 'Magnet: People Make Glasgow', NULL, 5.00, 'https://images.unsplash.com/photo-1612565775767-97a9fffef857?w=800&q=80', 'glasgow_humor', NULL, 0, 3),
('magnet-did-ye-aye', 'Magnet: Did Ye Aye?', NULL, 5.00, 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80', 'glasgow_humor', NULL, 0, 4)
ON DUPLICATE KEY UPDATE
  title = VALUES(title),
  description = VALUES(description),
  price = VALUES(price),
  image_url = VALUES(image_url),
  category = VALUES(category),
  sizes = VALUES(sizes),
  is_featured = VALUES(is_featured),
  sort_order = VALUES(sort_order);
