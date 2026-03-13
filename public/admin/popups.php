<?php
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once __DIR__ . '/bootstrap.php';
requireAuth();

$pageTitle = 'Site Popups';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf()) {
    $id = (int)($_POST['id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '') ?: null;
    $venue = trim($_POST['venue'] ?? '') ?: null;
    $link_url = trim($_POST['link_url'] ?? '') ?: null;
    $link_text = trim($_POST['link_text'] ?? '') ?: 'Get Tickets';
    $show_email_field = isset($_POST['show_email_field']) ? 1 : 0;
    $start_date = trim($_POST['start_date'] ?? '') ?: null;
    $end_date = trim($_POST['end_date'] ?? '') ?: null;
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $sort_order = (int)($_POST['sort_order'] ?? 0);

    if ($title) {
        if ($id) {
            $stmt = $pdo->prepare("UPDATE site_popups SET title=?, content=?, venue=?, link_url=?, link_text=?, show_email_field=?, start_date=?, end_date=?, is_active=?, sort_order=? WHERE id=?");
            $stmt->execute([$title, $content, $venue, $link_url, $link_text, $show_email_field, $start_date, $end_date, $is_active, $sort_order, $id]);
            $message = 'Popup updated.';
        } else {
            $stmt = $pdo->prepare("INSERT INTO site_popups (title, content, venue, link_url, link_text, show_email_field, start_date, end_date, is_active, sort_order) VALUES (?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute([$title, $content, $venue, $link_url, $link_text, $show_email_field, $start_date, $end_date, $is_active, $sort_order]);
            $message = 'Popup added.';
        }
    }
}

if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM site_popups WHERE id=?")->execute([(int)$_GET['delete']]);
    $message = 'Popup deleted.';
}

$edit = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM site_popups WHERE id=?");
    $stmt->execute([(int)$_GET['edit']]);
    $edit = $stmt->fetch();
} elseif (isset($_GET['action']) && $_GET['action'] === 'add') {
    $edit = ['id' => 0, 'title' => '', 'content' => '', 'venue' => '', 'link_url' => '', 'link_text' => 'Get Tickets', 'show_email_field' => 1, 'start_date' => '', 'end_date' => '', 'is_active' => 1, 'sort_order' => 0];
}

$stmt = $pdo->query("SELECT p.*, (SELECT COUNT(*) FROM popup_signups s WHERE s.popup_id = p.id) AS signup_count FROM site_popups p ORDER BY p.sort_order ASC, p.created_at DESC");
$items = $stmt->fetchAll();

ob_start();
?>
<div class="admin-header">
    <h1>Site Popups</h1>
    <a href="?action=add" class="btn btn-primary">+ Add Popup</a>
</div>
<?php if ($message): ?><p class="flash flash-success"><?= e($message) ?></p><?php endif; ?>

<p class="text-slate-600 mb-6">Popups appear when visitors load the site. They must click to dismiss. Set active dates to control when each popup shows.</p>

<?php if ($edit): ?>
<form method="post" class="admin-form">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= $edit['id'] ?>">
    <h3><?= $edit['id'] ? 'Edit Popup' : 'Add Popup' ?></h3>
    <div class="form-group">
        <label>Title *</label>
        <input type="text" name="title" value="<?= e($edit['title']) ?>" required placeholder="e.g. Glasgow Show – Tickets On Sale">
    </div>
    <div class="form-group">
        <label>Content / Message</label>
        <textarea name="content" rows="3" placeholder="Optional message or announcement"><?= e($edit['content']) ?></textarea>
    </div>
    <div class="form-group">
        <label>Venue</label>
        <input type="text" name="venue" value="<?= e($edit['venue']) ?>" placeholder="e.g. The King's Theatre">
    </div>
    <div class="form-group">
        <label>Link URL</label>
        <input type="url" name="link_url" value="<?= e($edit['link_url']) ?>" placeholder="https://...">
    </div>
    <div class="form-group">
        <label>Link Text</label>
        <input type="text" name="link_text" value="<?= e($edit['link_text']) ?>" placeholder="Get Tickets">
    </div>
    <div class="form-group">
        <label><input type="checkbox" name="show_email_field" value="1" <?= !empty($edit['show_email_field']) ? 'checked' : '' ?>> Show email signup field</label>
    </div>
    <div class="form-row">
        <div class="form-group">
            <label>Active from (date)</label>
            <input type="date" name="start_date" value="<?= e($edit['start_date']) ?>">
            <small class="form-hint">Leave blank for no start limit</small>
        </div>
        <div class="form-group">
            <label>Active until (date)</label>
            <input type="date" name="end_date" value="<?= e($edit['end_date']) ?>">
            <small class="form-hint">Leave blank for no end limit</small>
        </div>
    </div>
    <div class="form-group">
        <label><input type="checkbox" name="is_active" value="1" <?= !empty($edit['is_active']) ? 'checked' : '' ?>> Active (show on site)</label>
    </div>
    <div class="form-group">
        <label>Sort order</label>
        <input type="number" name="sort_order" value="<?= (int)($edit['sort_order']) ?>">
    </div>
    <button type="submit" class="btn btn-primary"><?= $edit['id'] ? 'Save' : 'Add' ?></button>
    <a href="popups.php" class="btn btn-secondary">Cancel</a>
</form>
<?php endif; ?>

<table class="admin-table">
    <thead><tr><th>Title</th><th>Venue</th><th>Active Dates</th><th>Signups</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
        <?php foreach ($items as $i): ?>
        <tr>
            <td><?= e($i['title']) ?></td>
            <td><?= e($i['venue'] ?? '—') ?></td>
            <td><?= $i['start_date'] || $i['end_date'] ? e($i['start_date'] ?? '…') . ' → ' . e($i['end_date'] ?? '…') : 'Always' ?></td>
            <td><?php $c = (int)($i['signup_count'] ?? 0); ?><?= $c ? '<a href="popup-signups.php?popup=' . $i['id'] . '">' . $c . '</a>' : '0' ?></td>
            <td><?= $i['is_active'] ? '<span class="text-green-600">Active</span>' : '<span class="text-slate-400">Inactive</span>' ?></td>
            <td>
                <a href="?edit=<?= $i['id'] ?>" class="btn btn-small btn-primary">Edit</a>
                <a href="?delete=<?= $i['id'] ?>" class="btn btn-small btn-secondary" onclick="return confirm('Delete this popup?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php if (empty($items)): ?><p>No popups yet. Add one to show announcements or newsletter signups on site load.</p><?php endif; ?>
<?php
$adminContent = ob_get_clean();
include __DIR__ . '/layout.php';
