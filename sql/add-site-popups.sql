-- Site popups (newsletter signup, event announcements) shown on load
-- Run: mysql -u user -p YOUR_DB_NAME < sql/add-site-popups.sql

CREATE TABLE IF NOT EXISTS site_popups (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT DEFAULT NULL,
    venue VARCHAR(255) DEFAULT NULL,
    link_url VARCHAR(500) DEFAULT NULL,
    link_text VARCHAR(100) DEFAULT 'Get Tickets',
    show_email_field TINYINT(1) DEFAULT 1,
    start_date DATE DEFAULT NULL,
    end_date DATE DEFAULT NULL,
    is_active TINYINT(1) DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_active_dates (is_active, start_date, end_date)
);

CREATE TABLE IF NOT EXISTS popup_signups (
    id INT AUTO_INCREMENT PRIMARY KEY,
    popup_id INT NOT NULL,
    email VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_popup (popup_id),
    FOREIGN KEY (popup_id) REFERENCES site_popups(id) ON DELETE CASCADE
);
