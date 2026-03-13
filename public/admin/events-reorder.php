<?php
/**
 * API: Reorder events via drag-and-drop.
 * POST: csrf_token, ids[] (array of IDs in new order)
 * Requires sort_order column: run sql/add-events-sort-order.sql first
 */
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once __DIR__ . '/bootstrap.php';
requireAuth();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf()) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Invalid request']);
    exit;
}

$ids = $_POST['ids'] ?? [];
$ids = is_array($ids) ? array_map('intval', $ids) : array_filter(array_map('intval', explode(',', $ids)));
if (empty($ids)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'No IDs']);
    exit;
}

$stmt = $pdo->prepare("UPDATE events SET sort_order = ? WHERE id = ?");
foreach ($ids as $pos => $id) {
    if ($id > 0) $stmt->execute([$pos, $id]);
}
echo json_encode(['ok' => true]);
