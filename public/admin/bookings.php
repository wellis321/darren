<?php
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once __DIR__ . '/bootstrap.php';
requireAuth();

$pageTitle = 'Bookings';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf()) {
    if (isset($_POST['status'], $_POST['id'])) {
        $stmt = $pdo->prepare("UPDATE bookings SET status=? WHERE id=?");
        $stmt->execute([$_POST['status'], (int)$_POST['id']]);
        flash('success', 'Booking updated.');
    }
}

if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM bookings WHERE id=?")->execute([(int)$_GET['delete']]);
    flash('success', 'Booking deleted.');
    header('Location: bookings.php');
    exit;
}

$status = $_GET['status'] ?? 'all';
$where = $status !== 'all' ? "WHERE status = " . $pdo->quote($status) : "";
$stmt = $pdo->query("SELECT * FROM bookings $where ORDER BY created_at DESC");
$bookings = $stmt->fetchAll();

ob_start();
?>
<div class="admin-header">
    <h1>Bookings & Enquiries</h1>
    <div>
        <a href="?status=all" class="btn btn-small <?= $status === 'all' ? 'active' : '' ?>">All</a>
        <a href="?status=new" class="btn btn-small <?= $status === 'new' ? 'active' : '' ?>">New</a>
    </div>
</div>
<?php if ($m = flash('success')): ?><p class="flash flash-success"><?= e($m) ?></p><?php endif; ?>
<table class="admin-table">
    <thead>
        <tr><th>Date</th><th>Name</th><th>Email</th><th>Enquiry</th><th>Status</th><th>Actions</th></tr>
    </thead>
    <tbody>
        <?php foreach ($bookings as $b): ?>
        <tr>
            <td><?= format_date($b['created_at'], 'j M Y') ?></td>
            <td><?= e($b['name']) ?></td>
            <td><a href="mailto:<?= e($b['email']) ?>"><?= e($b['email']) ?></a></td>
            <td><?= e(mb_substr($b['message'], 0, 80)) ?>...</td>
            <td><span class="badge badge-<?= $b['status'] ?>"><?= e($b['status']) ?></span></td>
            <td>
                <a href="?view=<?= $b['id'] ?>" class="btn btn-small btn-secondary">View</a>
                <a href="?delete=<?= $b['id'] ?>" class="btn btn-small btn-secondary" onclick="return confirm('Delete this booking?')">Delete</a>
                <form method="post" style="display:inline;margin-left:0.5rem">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= $b['id'] ?>">
                    <select name="status" onchange="this.form.submit()">
                        <?php foreach (['new','contacted','confirmed','declined'] as $s): ?>
                        <option value="<?= $s ?>" <?= $b['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </td>
        </tr>
        <?php if (isset($_GET['view']) && $_GET['view'] == $b['id']): ?>
        <tr class="expand">
            <td colspan="6">
                <div class="booking-detail">
                    <p><strong>Company:</strong> <?= e($b['company'] ?: '—') ?></p>
                    <p><strong>Phone:</strong> <?= e($b['phone'] ?: '—') ?></p>
                    <p><strong>Budget:</strong> <?= e($b['budget'] ?: '—') ?></p>
                    <p><strong>Event Type:</strong> <?= e($b['event_type'] ?: '—') ?></p>
                    <p><strong>Message:</strong><br><?= nl2br(e($b['message'])) ?></p>
                </div>
            </td>
        </tr>
        <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>
<?php if (empty($bookings)): ?><p>No bookings yet.</p><?php endif; ?>
<?php
$adminContent = ob_get_clean();
include __DIR__ . '/layout.php';
