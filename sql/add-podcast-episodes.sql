-- Add sample Glaswegians Anonymous episodes
-- Run: mysql -h 127.0.0.1 -P 8889 -u root -proot darrenn < sql/add-podcast-episodes.sql
-- (Skip if you already have episodes, or you'll get duplicates)

INSERT INTO podcast_episodes (podcast_name, episode_title, episode_url, sort_order) VALUES
('Glaswegians Anonymous', 'The Deep Fried Mars Bar Myth', 'https://open.spotify.com/show/0hjOxRAlk3A9CVt1KFlmpI', 3),
('Glaswegians Anonymous', 'Taxis, Kebabs and Late Nights', 'https://open.spotify.com/show/0hjOxRAlk3A9CVt1KFlmpI', 2),
('Glaswegians Anonymous', 'Why Does It Always Rain on Me?', 'https://open.spotify.com/show/0hjOxRAlk3A9CVt1KFlmpI', 1);
