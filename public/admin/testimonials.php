<?php
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once __DIR__ . '/bootstrap.php';
requireAuth();

$pageTitle = 'Testimonials';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf()) {
    if (isset($_POST['id']) && $_POST['id']) {
        $stmt = $pdo->prepare("UPDATE testimonials SET quote=?, author=?, role=?, is_featured=? WHERE id=?");
        $stmt->execute([
            trim($_POST['quote'] ?? ''),
            trim($_POST['author'] ?? ''),
            trim($_POST['role'] ?? '') ?: null,
            isset($_POST['is_featured']) ? 1 : 0,
            (int)$_POST['id']
        ]);
        $message = 'Updated.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO testimonials (quote, author, role, is_featured) VALUES (?,?,?,?)");
        $stmt->execute([
            trim($_POST['quote'] ?? ''),
            trim($_POST['author'] ?? ''),
            trim($_POST['role'] ?? '') ?: null,
            isset($_POST['is_featured']) ? 1 : 0
        ]);
        $message = 'Added.';
    }
}

if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM testimonials WHERE id=?")->execute([(int)$_GET['delete']]);
    $message = 'Deleted.';
}

$stmt = $pdo->query("SELECT * FROM testimonials ORDER BY is_featured DESC, sort_order");
$items = $stmt->fetchAll();
$editId = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;
$edit = $editId ? (array_values(array_filter($items, fn($t) => (int) $t['id'] === $editId))[0] ?? null) : null;

ob_start();
?>
<div class="admin-header">
    <h1>Testimonials</h1>
    <a href="?action=add" class="btn btn-primary">+ Add</a>
</div>
<p class="admin-hint" style="margin-bottom:1rem;color:#666;font-size:0.875rem;">Testimonials marked &ldquo;Show on homepage&rdquo; appear on the homepage below the hero. Add quotes from peers, reviewers, or fans.</p>
<?php if (!empty($message)): ?><p class="flash flash-success"><?= e($message) ?></p><?php endif; ?>
<?php if ($edit || (isset($_GET['action']) && $_GET['action'] === 'add')): ?>
<form method="post" class="admin-form">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= $edit['id'] ?? 0 ?>">
    <div class="form-group">
        <label>Quote *</label>
        <textarea name="quote" rows="3" required><?= e($edit['quote'] ?? '') ?></textarea>
    </div>
    <div class="form-row">
        <div class="form-group">
            <label>Author *</label>
            <input type="text" name="author" value="<?= e($edit['author'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Role</label>
            <input type="text" name="role" value="<?= e($edit['role'] ?? '') ?>">
        </div>
    </div>
    <div class="form-group">
        <label><input type="checkbox" name="is_featured" value="1" <?= ($edit['is_featured'] ?? 0) ? 'checked' : '' ?>> Show on homepage</label>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="testimonials.php" class="btn btn-secondary">Cancel</a>
</form>
<?php endif; ?>
<table class="admin-table">
    <thead><tr><th>Quote</th><th>Author</th><th>Featured</th><th>Actions</th></tr></thead>
    <tbody>
        <?php foreach ($items as $t): ?>
        <tr>
            <td><?= e(mb_substr($t['quote'], 0, 60)) ?>...</td>
            <td><?= e($t['author']) ?></td>
            <td><?= $t['is_featured'] ? 'Yes' : 'No' ?></td>
            <td>
                <a href="/" target="_blank" rel="noopener" class="btn btn-small btn-secondary">View</a>
                <a href="?edit=<?= $t['id'] ?>" class="btn btn-small btn-primary">Edit</a>
                <a href="?delete=<?= $t['id'] ?>" class="btn btn-small btn-secondary" onclick="return confirm('Delete?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
$adminContent = ob_get_clean();
include __DIR__ . '/layout.php';
