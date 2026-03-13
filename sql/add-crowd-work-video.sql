-- Add crowd work video: https://youtu.be/yGhz51GFeRs
-- Run: mysql -h 127.0.0.1 -P 8889 -u root -proot darrenn < sql/add-crowd-work-video.sql

INSERT INTO media (type, title, url, embed_code, description, sort_order) VALUES 
('video', 'Crowd Work', 'https://www.youtube.com/watch?v=yGhz51GFeRs', 
'<iframe width="100%" height="315" src="https://www.youtube.com/embed/yGhz51GFeRs" title="Darren Connell - Crowd Work" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
'Raw crowd work from Darren Connell.', 0);
