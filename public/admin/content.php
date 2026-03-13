<?php
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once __DIR__ . '/bootstrap.php';
requireAuth();

$pageTitle = 'Content';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf()) {
    $slug = $_POST['slug'] ?? '';
    $title = trim($_POST['title'] ?? '');
    $body = trim($_POST['body'] ?? '');
    $meta = trim($_POST['meta_description'] ?? '') ?: null;
    if ($slug && $title) {
        $stmt = $pdo->prepare("UPDATE content SET title=?, body=?, meta_description=? WHERE slug=?");
        $stmt->execute([$title, $body, $meta, $slug]);
        $message = 'Content saved.';
    }
}

$stmt = $pdo->query("SELECT * FROM content ORDER BY slug");
$pages = $stmt->fetchAll();
$editSlug = $_GET['edit'] ?? $pages[0]['slug'] ?? 'about';
$stmt = $pdo->prepare("SELECT * FROM content WHERE slug=?");
$stmt->execute([$editSlug]);
$current = $stmt->fetch();

ob_start();
?>
<div class="admin-header">
    <h1>Content</h1>
</div>
<?php if (!empty($message)): ?><p class="flash flash-success"><?= e($message) ?></p><?php endif; ?>
<div class="admin-content-edit">
    <ul class="content-tabs">
        <?php foreach ($pages as $p): ?>
        <li><a href="?edit=<?= e($p['slug']) ?>" class="<?= $p['slug'] === $editSlug ? 'active' : '' ?>"><?= e($p['title']) ?></a></li>
        <?php endforeach; ?>
    </ul>
    <?php if ($current): ?>
    <form method="post" class="admin-form">
        <?= csrf_field() ?>
        <input type="hidden" name="slug" value="<?= e($current['slug']) ?>">
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="<?= e($current['title']) ?>" required>
        </div>
        <div class="form-group">
            <label>Meta Description</label>
            <input type="text" name="meta_description" value="<?= e($current['meta_description']) ?>" placeholder="For search engines">
        </div>
        <div class="form-group">
            <label>Body</label>
            <textarea name="body" rows="15"><?= e($current['body']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <?php
        $viewUrl = strpos($current['slug'], 'about') === 0 ? '/about.php' : '/';
        ?>
        <a href="<?= e($viewUrl) ?>" target="_blank" rel="noopener" class="btn btn-secondary">View on site</a>
    </form>
    <?php endif; ?>
</div>
<?php
$adminContent = ob_get_clean();
include __DIR__ . '/layout.php';
