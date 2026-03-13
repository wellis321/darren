-- Add editable content blocks for About page sections
-- Run: mysql -h 127.0.0.1 -P 8889 -u root -proot darrenn < sql/add-about-sections.sql

INSERT INTO content (slug, title, body, meta_description) VALUES
('about_quote', 'About - Quote', '"Truthful and very funny."', NULL),
('about_intro', 'About - Intro', 'Hailing from Glasgow, Darren has taken the comedy scene by storm with his raw, high-energy style and relatable storytelling.', NULL),
('about_journey', 'About - The Journey', 'From open mic nights in dusty Glasgow basements to the bright lights of the Edinburgh Fringe. Darren''s rise wasn''t accidental—it was forged in the fires of honest observation and a relentless work ethic. Best known for his breakout role as Bobby in the BBC hit Scot Squad, he''s proven he can command both the screen and the stage.', NULL),
('about_comedy_style', 'About - Comedy Style', 'High-octane, unfiltered, and unapologetically Glaswegian. Darren''s comedy doesn''t just ask for a laugh—it demands one. He finds the absurdity in the everyday and the heartbreak in the hilarious.', NULL),
('about_personal', 'About - Personal Life', 'When he''s not making people howl with laughter, Darren is a passionate advocate for mental health and staying grounded in his roots. He''s a man of the people, for the people, usually found with a coffee in hand planning his next big move.', NULL)
ON DUPLICATE KEY UPDATE title=VALUES(title), body=VALUES(body);
