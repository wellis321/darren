<?php
/**
 * Returns the currently active popup as JSON (no auth required)
 * Active = is_active=1 and today is within start_date..end_date (null = no limit)
 */
require_once dirname(__DIR__, 2) . '/config/database.php';
header('Content-Type: application/json');
header('Cache-Control: no-store, max-age=60');

$today = date('Y-m-d');
$stmt = $pdo->prepare("
    SELECT id, title, content, venue, link_url, link_text, show_email_field
    FROM site_popups
    WHERE is_active = 1
    AND (start_date IS NULL OR start_date <= ?)
    AND (end_date IS NULL OR end_date >= ?)
    ORDER BY sort_order ASC, created_at ASC
    LIMIT 1
");
$stmt->execute([$today, $today]);
$popup = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($popup ?: null);
