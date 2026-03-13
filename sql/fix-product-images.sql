-- Clear Google/Stitch image URLs that often fail to load (403/hotlink protection).
-- Products will use the fallback (darren.png) until you add proper image URLs in Admin → Merch.
-- Run: mysql -h 127.0.0.1 -P 8889 -u root -proot darrenn < sql/fix-product-images.sql

UPDATE products SET image_url = NULL WHERE image_url LIKE '%googleusercontent.com%';
