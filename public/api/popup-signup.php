<?php
require_once dirname(__DIR__, 2) . '/config/session.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
    exit;
}

if (!verify_csrf()) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Invalid request']);
    exit;
}

$popup_id = (int)($_POST['popup_id'] ?? 0);
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);

if (!$popup_id || !$email) {
    echo json_encode(['ok' => false, 'error' => 'Invalid email or popup']);
    exit;
}

// Verify popup exists and is active
$stmt = $pdo->prepare("SELECT id FROM site_popups WHERE id = ? AND is_active = 1");
$stmt->execute([$popup_id]);
if (!$stmt->fetch()) {
    echo json_encode(['ok' => false, 'error' => 'Invalid popup']);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO popup_signups (popup_id, email) VALUES (?, ?)");
    $stmt->execute([$popup_id, $email]);
    echo json_encode(['ok' => true, 'message' => 'Thanks for signing up!']);
} catch (PDOException $e) {
    echo json_encode(['ok' => true, 'message' => 'You\'re already on the list. Thanks!']);
}
