<?php
/**
 * API: Reorder products via drag-and-drop.
 * POST: csrf_token, ids[] (array of product IDs in new order)
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
if (!is_array($ids)) {
    $ids = array_filter(array_map('intval', explode(',', $ids)));
} else {
    $ids = array_map('intval', $ids);
}

if (empty($ids)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'No IDs']);
    exit;
}

$stmt = $pdo->prepare("UPDATE products SET sort_order = ? WHERE id = ?");
foreach ($ids as $pos => $id) {
    if ($id > 0) {
        $stmt->execute([$pos, $id]);
    }
}

echo json_encode(['ok' => true]);
