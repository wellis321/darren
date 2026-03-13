-- Update About page: Glaswegians Anonymous — he works on it at the moment and it's brilliant
-- Run: mysql -h 127.0.0.1 -P 8889 -u root -proot darrenn < sql/update-about-glaswegians.sql

UPDATE content SET body = REPLACE(body, 
  'He also co-hosts Glaswegians Anonymous with fellow comedian Gary Faulds — a weekly dose of Glasgow life, comedy and nostalgia.',
  'He currently co-hosts Glaswegians Anonymous with fellow comedian Gary Faulds — and it\'s brilliant. A weekly dose of Glasgow life, comedy and nostalgia.'
) WHERE slug = 'about';
