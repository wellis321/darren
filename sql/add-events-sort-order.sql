-- Add sort_order to events for drag-and-drop reordering in admin
-- Run: mysql -u user -p YOUR_DB_NAME < sql/add-events-sort-order.sql

ALTER TABLE events ADD COLUMN sort_order INT DEFAULT 0 AFTER is_featured;
