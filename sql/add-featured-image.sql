-- Add featured_image_url for products shown in the featured banner
-- Use when the main product image doesn't work well in the wide featured layout
-- Run: mysql -u user -p YOUR_DB_NAME < sql/add-featured-image.sql

ALTER TABLE products ADD COLUMN featured_image_url VARCHAR(500) DEFAULT NULL AFTER image_url;
