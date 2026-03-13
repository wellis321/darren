<?php
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once __DIR__ . '/bootstrap.php';
requireAuth();

$popup_id = (int)($_GET['popup'] ?? 0);
if (!$popup_id) {
    header('Location: popups.php');
    exit;
}

$stmt = $pdo->prepare("SELECT title FROM site_popups WHERE id = ?");
$stmt->execute([$popup_id]);
$popup = $stmt->fetch();
if (!$popup) {
    header('Location: popups.php');
    exit;
}

$stmt = $pdo->prepare("SELECT email, created_at FROM popup_signups WHERE popup_id = ? ORDER BY created_at DESC");
$stmt->execute([$popup_id]);
$signups = $stmt->fetchAll();

$pageTitle = 'Popup Signups: ' . $popup['title'];

ob_start();
?>
<div class="admin-header">
    <h1>Signups: <?= e($popup['title']) ?></h1>
    <a href="popups.php" class="btn btn-secondary">← Back to Popups</a>
</div>
<p class="text-slate-600 mb-6"><?= count($signups) ?> email<?= count($signups) !== 1 ? 's' : '' ?> captured.</p>
<?php if (!empty($signups)): ?>
<table class="admin-table">
    <thead><tr><th>Email</th><th>Date</th></tr></thead>
    <tbody>
        <?php foreach ($signups as $s): ?>
        <tr>
            <td><?= e($s['email']) ?></td>
            <td><?= e($s['created_at']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p>No signups yet.</p>
<?php endif; ?>
<?php
$adminContent = ob_get_clean();
include __DIR__ . '/layout.php';
