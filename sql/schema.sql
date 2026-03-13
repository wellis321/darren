-- Darren Connell Website Database Schema
-- Run this to set up the database

CREATE DATABASE IF NOT EXISTS darrenn;
USE darrenn;

-- Admin users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Events (tour dates)
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    venue VARCHAR(255) NOT NULL,
    venue_city VARCHAR(100) DEFAULT NULL,
    event_date DATE NOT NULL,
    event_time TIME DEFAULT NULL,
    ticket_url VARCHAR(500) DEFAULT NULL,
    description TEXT DEFAULT NULL,
    is_featured TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_event_date (event_date),
    INDEX idx_featured (is_featured)
);

-- Booking requests from contact form
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT DEFAULT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) DEFAULT NULL,
    company VARCHAR(255) DEFAULT NULL,
    budget VARCHAR(100) DEFAULT NULL,
    event_type VARCHAR(100) DEFAULT NULL,
    message TEXT NOT NULL,
    status ENUM('new', 'contacted', 'confirmed', 'declined') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE SET NULL,
    INDEX idx_status (status)
);

-- Content pages (editable by admin)
CREATE TABLE IF NOT EXISTS content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(100) NOT NULL UNIQUE,
    title VARCHAR(255) NOT NULL,
    body TEXT,
    meta_description VARCHAR(255) DEFAULT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug)
);

-- Media (videos, gallery images)
CREATE TABLE IF NOT EXISTS media (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('video', 'image', 'podcast') NOT NULL,
    title VARCHAR(255) NOT NULL,
    url VARCHAR(500) NOT NULL,
    embed_code TEXT DEFAULT NULL,
    description TEXT DEFAULT NULL,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_type (type)
);

-- Podcast episodes
CREATE TABLE IF NOT EXISTS podcast_episodes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    podcast_name VARCHAR(100) NOT NULL,
    episode_title VARCHAR(255) NOT NULL,
    episode_url VARCHAR(500) DEFAULT NULL,
    embed_code TEXT DEFAULT NULL,
    description TEXT DEFAULT NULL,
    release_date DATE DEFAULT NULL,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_podcast (podcast_name)
);

-- Testimonials (quotes from peers)
CREATE TABLE IF NOT EXISTS testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quote TEXT NOT NULL,
    author VARCHAR(100) NOT NULL,
    role VARCHAR(100) DEFAULT NULL,
    is_featured TINYINT(1) DEFAULT 0,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_featured (is_featured)
);

-- Newsletter subscribers
CREATE TABLE IF NOT EXISTS newsletter_subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin (password: changeme123 - change on first login)
INSERT INTO users (email, password_hash, name) VALUES 
('admin@darrenconnell.com', '$2y$12$nucWLvKmqAaQha6Em2uU7e1pPXOH4Enzaj2BTEjYSNjtEU4PD65Hi', 'Darren Connell')
ON DUPLICATE KEY UPDATE id=id;

-- Insert Kevin Bridges testimonial
INSERT INTO testimonials (quote, author, role, is_featured) VALUES 
('A natural with a real bright future.', 'Kevin Bridges', 'Comedian', 1);

-- Insert default content for About page
INSERT INTO content (slug, title, body, meta_description) VALUES 
('about', 'About Darren', 
'Darren Connell is a Scottish stand-up comedian, podcaster and actor from Glasgow, best known for playing Bobby Muir in the BBC Scotland mockumentary series Scot Squad — a role that earned him a BAFTA Scotland New Talent Award nomination for Best Actor in 2015.

Connell grew up in Springburn in Glasgow. He started performing stand-up whilst juggling a full-time job collecting trolleys at Morrisons and Asda until fellow comedian Kevin Bridges convinced him to quit and pursue comedy full-time.

Since then, Connell has hosted many solo shows across the UK including an appearance at the Edinburgh Fringe Festival. His shows include Trolleywood (2016), No Filter (2017), Abandon All Hope (2019) — which sold out at the Glasgow Comedy Festival — and My Name Is Darren Connell and This Is My Self-Tape.

As of 2019, he hosted The Darren Connell Show podcast on Glasgow Live, featuring guests including Grado, Loki and Greg Hemphill. In September 2021, he launched Straight White Whale with producer Paul Shields. He also co-hosts Glaswegians Anonymous with fellow comedian Gary Faulds — a weekly dose of Glasgow life, comedy and nostalgia.',
'Learn about Darren Connell - Scottish comedian, actor and BAFTA-nominated star of Scot Squad.')
ON DUPLICATE KEY UPDATE slug=slug;

-- Crowd work video
INSERT INTO media (type, title, url, embed_code, description, sort_order) VALUES 
("video", "Crowd Work", "https://www.youtube.com/watch?v=yGhz51GFeRs", 
"<iframe width=\"100%\" height=\"315\" src=\"https://www.youtube.com/embed/yGhz51GFeRs\" title=\"Darren Connell - Crowd Work\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>",
"Raw crowd work from Darren Connell.", 0);

-- Sample podcast episodes (Glaswegians Anonymous)
INSERT INTO podcast_episodes (podcast_name, episode_title, episode_url, sort_order) VALUES
('Glaswegians Anonymous', 'The Deep Fried Mars Bar Myth', 'https://open.spotify.com/show/0hjOxRAlk3A9CVt1KFlmpI', 3),
('Glaswegians Anonymous', 'Taxis, Kebabs and Late Nights', 'https://open.spotify.com/show/0hjOxRAlk3A9CVt1KFlmpI', 2),
('Glaswegians Anonymous', 'Why Does It Always Rain on Me?', 'https://open.spotify.com/show/0hjOxRAlk3A9CVt1KFlmpI', 1);
