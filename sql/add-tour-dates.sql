-- Add tour dates from WeGotTickets
-- Run: mysql -h 127.0.0.1 -P 8889 -u root -proot darrenn < sql/add-tour-dates.sql

-- Darren Connell: Cancelled - Blackfriars Glasgow, 14 June 2026
-- https://wegottickets.com/event/693930
INSERT INTO events (title, venue, venue_city, event_date, event_time, ticket_url, description, is_featured) VALUES 
(
  'Darren Connell: Cancelled',
  'Blackfriars of Bell Street',
  'Glasgow',
  '2026-06-14',
  '17:30:00',
  'https://wegottickets.com/event/693930',
  'After his nationwide tour was abruptly pulled from under him, Darren Connell is doing what he does best: turning chaos into comedy. His new show, Cancelled, lands at Blackfriars — raw, restless and very, very funny. Door 5pm, show 5:30pm. 18+.',
  1
);

-- Glaswegians Anonymous Live! Ep:2 - SEC Glasgow, 20 June 2026
-- https://www.ents24.com/glasgow-events/the-scottish-event-centre-and-clyde-auditorium-the-armadillo/glaswegians-anonymous-live-ep2/7399913
INSERT INTO events (title, venue, venue_city, event_date, event_time, ticket_url, description, is_featured) VALUES 
(
  'Glaswegians Anonymous Live! Ep:2',
  'SEC (Clyde Auditorium / The Armadillo)',
  'Glasgow',
  '2026-06-20',
  '19:00:00',
  'https://www.ents24.com/glasgow-events/the-scottish-event-centre-and-clyde-auditorium-the-armadillo/glaswegians-anonymous-live-ep2/7399913',
  'Gary Faulds and Darren Connell are taking the podcast to the stunning SEC Glasgow, for episode 2. Expect chaos, carnage, and plenty of laughs - this is Glaswegians Anonymous like you''ve never seen it before!',
  1
);
