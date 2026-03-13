-- Remove duplicate events (keeps lowest id per title+venue+date)
-- Run: mysql -h 127.0.0.1 -P 8889 -u root -proot darrenn < sql/remove-duplicate-events.sql

DELETE e1 FROM events e1
INNER JOIN events e2
  ON e1.title = e2.title
  AND e1.venue = e2.venue
  AND e1.event_date = e2.event_date
  AND e1.id > e2.id;
