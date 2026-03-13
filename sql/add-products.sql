-- Products/merch table for shop
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

-- Seed sample products
INSERT INTO products (slug, title, description, price, image_url, category, sizes, is_featured, sort_order) VALUES
('banter-2024-tour-tee', '''Banter'' 2024 Tour Tee', 'Heavyweight 100% organic cotton tee featuring the iconic 2024 Glasgow ''Banter'' tour dates on the back. Limited edition run.', 25.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuAf9wbGAXxz4De4SK03As0NAInpUEBDrE_hNIEDEt_Zkptx9skUU4HK7KWKMBHzAZ1nKhmak164465u7jnrXgO01PAYT12uSnFnQQ-bf8-q1Xz3krJZBZkpE4R9J-vJJtu7wxljkTatTbmfTCMMrwsTeoOCDXLoAFTG__wmfeDs5r1342EABpQWH9H8YLuwR_kreqBn31tdjoPfmjVk7Gy4Zbc820mzLdzofz_IW7RnLN54CaWUJXFmHKUWeNzP0Wt1-5K_gzmOnyw', 'tour_apparel', 'S, M, L, XL', 1, 0),
('banter-mug-pure-dead-brilliant', 'Banter Mug: ''Pure Dead Brilliant''', NULL, 12.50, 'https://lh3.googleusercontent.com/aida-public/AB6AXuDTxmQTxcV3WzpENHs-GH-lO9PDcfeW7Z1gcEf_jElrziMJbziucunGV4EZSN63rHNVwJ37oC2bFdLoSNSY7k_NukIJr1ieOW9SW0p_CORniymBYy20WjpPG5GZECYxhUffshf-Nua-rKyQS_sgrGCZ6UuEd4w-dcI63Soo49bWYYdmPM3GF-oc1LGKSR0lmn4wXxptMQI6OFGswwhGCwSp_e2hNu5GKGp3BAKTA2pxOTvx_QyM3U0KHkgsXriuQN4ThFQcAZJ8Kw', 'banter_mugs', NULL, 0, 1),
('banter-mug-hows-it-hingin', 'Banter Mug: ''How''s it hingin''?''', NULL, 12.50, 'https://lh3.googleusercontent.com/aida-public/AB6AXuBV2IlOsoESoLInduqYEHqAT10zqux5ekb-GiC06mIynmoToqJLVAWjbtcwHl0v8I9UnZBoRSP9RZVtnYrSFWMqMyzmoqYlntkqPPEzrfXx6OPbEFfyjtlL3jJ6Jsf_IfYWA7X0qBVeMTCJfWigAkZaJKbROjuISDPNiqOV2nnKTc1fnuRQNEYXaF1Keg6DzC0C0-aIy0VYw3VRJE4GIcVDvvGsCpRyaxj0ScgVrSsSgJI_yl-BFpuhuyI_G2bm6yjRrUzpWIT8wQc', 'banter_mugs', NULL, 0, 2),
('magnet-people-make-glasgow', 'Magnet: ''People Make Glasgow''', NULL, 5.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuAlZLtx20RIOLLSwNYw4AEoNtS9MRGOuRWf4SDZOR7sURTy8P5CDMB8INyJQFY7NZ4o4xq11_eKkVy8fvHR5ES5L_phccDOweIt66mqLaaoJr5cSuRxJFpjbgHFy7IfrkiXdtQCpeOUR5aDkGdzVOMDeh_KtgkZyzMOg_DoJLdxRF6mN9-Aq_ZEyIXZVrQ8RgbwG8ziRGIdxTzb-IjvmthKQoVyN0oP2jnoorAOOtV3k4ZaYc19BhU-A_ow_5v7AehUkSic-pXE124', 'glasgow_humor', NULL, 0, 3),
('magnet-did-ye-aye', 'Magnet: ''Did Ye Aye?''', NULL, 5.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuAIAE8vL_7gXg_sDfZfRF0JsARYDzBV47vNghpZ9_qNLF5tqfdqJfeV_-yhTQ57hetDTjs9vmv-8abxKWkzPv5Obq2vUaq-lE-m3hyvk4EkbzQadzI23uuJ8Hyc6eS9ABXIil8DI2N6izGEnczcJrIoff-TCeMkF22BAn3bsHaHiPFg8Tc1lNzSV-2ZnxzRPjv3eszLdQbLQXHtePq31_qtO5DgE3VpuAyjRosyD7lgR7kP-i-C0Ce28j8xrk4VVd3UmgdiusADvcw', 'glasgow_humor', NULL, 0, 4)
ON DUPLICATE KEY UPDATE slug=slug;
