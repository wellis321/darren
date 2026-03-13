<?php
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once __DIR__ . '/bootstrap.php';
requireAuth();

$pageTitle = 'Podcasts';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf()) {
    $id = (int)($_POST['id'] ?? 0);
    $podcast = trim($_POST['podcast_name'] ?? '');
    $title = trim($_POST['episode_title'] ?? '');
    $url = trim($_POST['episode_url'] ?? '') ?: null;
    $embed = trim($_POST['embed_code'] ?? '') ?: null;
    $desc = trim($_POST['description'] ?? '') ?: null;
    $date = trim($_POST['release_date'] ?? '') ?: null;
    $sortOrder = (int)($_POST['sort_order'] ?? 0);
    if ($podcast && $title) {
        if ($id) {
            $stmt = $pdo->prepare("UPDATE podcast_episodes SET podcast_name=?, episode_title=?, episode_url=?, embed_code=?, description=?, release_date=?, sort_order=? WHERE id=?");
            $stmt->execute([$podcast, $title, $url, $embed, $desc, $date, $sortOrder, $id]);
            $message = 'Episode updated.';
        } else {
            $stmt = $pdo->prepare("INSERT INTO podcast_episodes (podcast_name, episode_title, episode_url, embed_code, description, release_date, sort_order) VALUES (?,?,?,?,?,?,?)");
            $stmt->execute([$podcast, $title, $url, $embed, $desc, $date, $sortOrder]);
            $message = 'Episode added.';
        }
    }
}

if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM podcast_episodes WHERE id=?")->execute([(int)$_GET['delete']]);
    $message = 'Episode deleted.';
}

$edit = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM podcast_episodes WHERE id=?");
    $stmt->execute([(int)$_GET['edit']]);
    $edit = $stmt->fetch();
} elseif (isset($_GET['action']) && $_GET['action'] === 'add') {
    $edit = ['id' => 0, 'podcast_name' => '', 'episode_title' => '', 'episode_url' => '', 'embed_code' => '', 'description' => '', 'release_date' => '', 'sort_order' => 0];
}

$stmt = $pdo->query("SELECT * FROM podcast_episodes ORDER BY sort_order ASC, release_date DESC, id DESC");
$episodes = $stmt->fetchAll();

ob_start();
?>
<div class="admin-header">
    <h1>Podcast Episodes</h1>
    <a href="?action=add" class="btn btn-primary">+ Add Episode</a>
</div>
<?php if (!empty($message)): ?><p class="flash flash-success"><?= e($message) ?></p><?php endif; ?>

<?php if ($edit): ?>
<form method="post" class="admin-form">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= $edit['id'] ?>">
    <h3><?= $edit['id'] ? 'Edit Episode' : 'Add Episode' ?></h3>
    <div class="form-group">
        <label>Podcast Name *</label>
        <input type="text" name="podcast_name" value="<?= e($edit['podcast_name']) ?>" required placeholder="e.g. Glaswegians Anonymous">
    </div>
    <div class="form-group">
        <label>Episode Title *</label>
        <input type="text" name="episode_title" value="<?= e($edit['episode_title']) ?>" required>
    </div>
    <div class="form-row">
        <div class="form-group">
            <label>Listen URL</label>
            <input type="url" name="episode_url" value="<?= e($edit['episode_url']) ?>" placeholder="https://...">
        </div>
        <div class="form-group">
            <label>Release Date</label>
            <input type="date" name="release_date" value="<?= e($edit['release_date']) ?>">
        </div>
    </div>
    <div class="form-group">
        <label>Sort Order</label>
        <input type="number" name="sort_order" value="<?= e($edit['sort_order']) ?>" placeholder="0 (higher = first)">
    </div>
    <div class="form-group">
        <label>Embed Code</label>
        <textarea name="embed_code" rows="3"><?= e($edit['embed_code']) ?></textarea>
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea name="description" rows="2"><?= e($edit['description']) ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary"><?= $edit['id'] ? 'Save' : 'Add' ?></button>
    <a href="podcast.php" class="btn btn-secondary">Cancel</a>
</form>
<?php endif; ?>

<div class="admin-table-wrapper">
<table class="admin-table" id="podcast-table">
    <thead><tr><th style="width:36px"></th><th>Podcast</th><th>Episode</th><th>Date</th><th>Actions</th></tr></thead>
    <tbody>
        <?php foreach ($episodes as $e): ?>
        <tr data-id="<?= (int)$e['id'] ?>">
            <td class="admin-drag-handle" title="Drag to reorder">⋮⋮</td>
            <td><?= e(mb_strlen($e['podcast_name']) > 20 ? mb_substr($e['podcast_name'], 0, 20) . '…' : $e['podcast_name']) ?></td>
            <td><?= e(mb_strlen($e['episode_title']) > 20 ? mb_substr($e['episode_title'], 0, 20) . '…' : $e['episode_title']) ?></td>
            <td><?= $e['release_date'] ? format_date($e['release_date'], 'd/m/Y') : '—' ?></td>
            <td>
                <a href="/podcast.php" target="_blank" rel="noopener" class="btn btn-small btn-secondary">View</a>
                <a href="?edit=<?= $e['id'] ?>" class="btn btn-small btn-primary">Edit</a>
                <a href="?delete=<?= $e['id'] ?>" class="btn btn-small btn-secondary" onclick="return confirm('Delete?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php if (empty($episodes)): ?><p>No episodes yet.</p><?php endif; ?>
<?php if (!empty($episodes)): ?>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
(function(){var t=document.querySelector('#podcast-table tbody');if(!t)return;var f=document.createElement('form');f.innerHTML='<input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">';var c=f.querySelector('input').value;new Sortable(t,{handle:'.admin-drag-handle',animation:150,onEnd:function(){var ids=[].map.call(t.querySelectorAll('tr[data-id]'),function(r){return r.dataset.id});var fd=new FormData();fd.append('csrf_token',c);ids.forEach(function(i){fd.append('ids[]',i)});fetch('podcast-reorder.php',{method:'POST',body:fd}).then(function(r){return r.json()}).then(function(d){if(d.ok){var m=document.createElement('p');m.className='flash flash-success';m.textContent='Order saved.';var main=document.querySelector('.admin-main');if(main)main.insertAdjacentElement('afterbegin',m);setTimeout(function(){m.remove()},2000)}})}});})();
</script>
<?php endif; ?>
<?php
$adminContent = ob_get_clean();
include __DIR__ . '/layout.php';
