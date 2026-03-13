<?php
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once __DIR__ . '/bootstrap.php';
requireAuth();

$pageTitle = 'Media';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf()) {
    $id = (int)($_POST['id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $type = $_POST['type'] ?? 'video';
    $url = trim($_POST['url'] ?? '');
    $embed = trim($_POST['embed_code'] ?? '') ?: null;
    $desc = trim($_POST['description'] ?? '') ?: null;
    if ($title && ($url || $embed)) {
        if ($id) {
            $stmt = $pdo->prepare("UPDATE media SET type=?, title=?, url=?, embed_code=?, description=? WHERE id=?");
            $stmt->execute([$type, $title, $url ?: '', $embed, $desc, $id]);
            $message = 'Media updated.';
        } else {
            $stmt = $pdo->prepare("INSERT INTO media (type, title, url, embed_code, description) VALUES (?,?,?,?,?)");
            $stmt->execute([$type, $title, $url ?: '', $embed, $desc]);
            $message = 'Media added.';
        }
    }
}

if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM media WHERE id=?")->execute([(int)$_GET['delete']]);
    $message = 'Media deleted.';
}

$edit = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM media WHERE id=?");
    $stmt->execute([(int)$_GET['edit']]);
    $edit = $stmt->fetch();
} elseif (isset($_GET['action']) && $_GET['action'] === 'add') {
    $edit = ['id' => 0, 'type' => 'video', 'title' => '', 'url' => '', 'embed_code' => '', 'description' => ''];
}

$stmt = $pdo->query("SELECT * FROM media ORDER BY sort_order, created_at DESC");
$items = $stmt->fetchAll();

ob_start();
?>
<div class="admin-header">
    <h1>Media</h1>
    <a href="?action=add" class="btn btn-primary">+ Add Media</a>
</div>
<?php if (!empty($message)): ?><p class="flash flash-success"><?= e($message) ?></p><?php endif; ?>

<?php if ($edit): ?>
<form method="post" class="admin-form">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= $edit['id'] ?>">
    <h3><?= $edit['id'] ? 'Edit Media' : 'Add Media' ?></h3>
    <div class="form-group">
        <label>Type</label>
        <select name="type">
            <option value="video" <?= ($edit['type'] ?? '') === 'video' ? 'selected' : '' ?>>Video</option>
            <option value="image" <?= ($edit['type'] ?? '') === 'image' ? 'selected' : '' ?>>Image</option>
        </select>
    </div>
    <div class="form-group">
        <label>Title *</label>
        <input type="text" name="title" value="<?= e($edit['title'] ?? '') ?>" required>
    </div>
    <div class="form-group">
        <label>URL (or embed code below)</label>
        <input type="url" name="url" value="<?= e($edit['url'] ?? '') ?>" placeholder="https://...">
    </div>
    <div class="form-group">
        <label>Embed Code (YouTube iframe etc.)</label>
        <textarea name="embed_code" rows="3" placeholder="<iframe src=...></iframe>"><?= e($edit['embed_code'] ?? '') ?></textarea>
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea name="description" rows="2"><?= e($edit['description'] ?? '') ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary"><?= $edit['id'] ? 'Save' : 'Add' ?></button>
    <a href="media.php" class="btn btn-secondary">Cancel</a>
</form>
<?php endif; ?>
<div class="admin-table-wrapper">
<table class="admin-table" id="media-table">
    <thead><tr><th style="width:36px"></th><th>Type</th><th>Title</th><th>Actions</th></tr></thead>
    <tbody>
        <?php foreach ($items as $i): ?>
        <tr data-id="<?= (int)$i['id'] ?>">
            <td class="admin-drag-handle" title="Drag to reorder">⋮⋮</td>
            <td><?= e($i['type']) ?></td>
            <td><?= e(mb_strlen($i['title']) > 20 ? mb_substr($i['title'], 0, 20) . '…' : $i['title']) ?></td>
            <td>
                <a href="/media.php" target="_blank" rel="noopener" class="btn btn-small btn-secondary">View</a>
                <a href="?edit=<?= $i['id'] ?>" class="btn btn-small btn-primary">Edit</a>
                <a href="?delete=<?= $i['id'] ?>" class="btn btn-small btn-secondary" onclick="return confirm('Delete?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php if (empty($items)): ?><p>No media yet.</p><?php endif; ?>
<?php if (!empty($items)): ?>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
(function(){var t=document.querySelector('#media-table tbody');if(!t)return;var f=document.createElement('form');f.innerHTML='<input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">';var c=f.querySelector('input').value;new Sortable(t,{handle:'.admin-drag-handle',animation:150,onEnd:function(){var ids=[].map.call(t.querySelectorAll('tr[data-id]'),function(r){return r.dataset.id});var fd=new FormData();fd.append('csrf_token',c);ids.forEach(function(i){fd.append('ids[]',i)});fetch('media-reorder.php',{method:'POST',body:fd}).then(function(r){return r.json()}).then(function(d){if(d.ok){var m=document.createElement('p');m.className='flash flash-success';m.textContent='Order saved.';var main=document.querySelector('.admin-main');if(main)main.insertAdjacentElement('afterbegin',m);setTimeout(function(){m.remove()},2000)}})}});})();
</script>
<?php endif; ?>
<?php
$adminContent = ob_get_clean();
include __DIR__ . '/layout.php';
