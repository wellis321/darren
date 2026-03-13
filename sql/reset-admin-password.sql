-- Reset admin password to: changeme123
-- Run: mysql -h 127.0.0.1 -P 8889 -u root -proot darrenn < sql/reset-admin-password.sql

UPDATE users SET password_hash = '$2y$12$nucWLvKmqAaQha6Em2uU7e1pPXOH4Enzaj2BTEjYSNjtEU4PD65Hi' WHERE email = 'admin@darrenconnell.com';
