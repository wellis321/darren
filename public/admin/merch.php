<?php
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once __DIR__ . '/bootstrap.php';
requireAuth();

$pageTitle = 'Merch / Products';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf()) {
    $id = (int)($_POST['id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    if (!$slug && $title) {
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', trim($title, ' -')));
    }
    $description = trim($_POST['description'] ?? '') ?: null;
    $price = trim($_POST['price'] ?? '') ?: null;
    $image_url = trim($_POST['image_url'] ?? '') ?: null;
    $featured_image_url = trim($_POST['featured_image_url'] ?? '') ?: null;
    $category = trim($_POST['category'] ?? 'general') ?: 'general';
    $sizes = trim($_POST['sizes'] ?? '') ?: null;
    $buy_url = trim($_POST['buy_url'] ?? '') ?: null;
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $sort_order = (int)($_POST['sort_order'] ?? 0);

    if ($title && $slug) {
        if ($id) {
            $stmt = $pdo->prepare("UPDATE products SET slug=?, title=?, description=?, price=?, image_url=?, featured_image_url=?, category=?, sizes=?, buy_url=?, is_featured=?, sort_order=? WHERE id=?");
            $stmt->execute([$slug, $title, $description, $price, $image_url, $featured_image_url, $category, $sizes, $buy_url, $is_featured, $sort_order, $id]);
            $message = 'Product updated.';
        } else {
            $stmt = $pdo->prepare("INSERT INTO products (slug, title, description, price, image_url, featured_image_url, category, sizes, buy_url, is_featured, sort_order) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute([$slug, $title, $description, $price, $image_url, $featured_image_url, $category, $sizes, $buy_url, $is_featured, $sort_order]);
            $message = 'Product added.';
        }
    }
}

if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM products WHERE id=?")->execute([(int)$_GET['delete']]);
    $message = 'Product deleted.';
}

$edit = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id=?");
    $stmt->execute([(int)$_GET['edit']]);
    $edit = $stmt->fetch();
} elseif (isset($_GET['action']) && $_GET['action'] === 'add') {
    $edit = ['id' => 0, 'slug' => '', 'title' => '', 'description' => '', 'price' => '', 'image_url' => '', 'featured_image_url' => '', 'category' => 'tour_apparel', 'sizes' => '', 'buy_url' => '', 'is_featured' => 0, 'sort_order' => 0];
}

$stmt = $pdo->query("SELECT * FROM products ORDER BY sort_order ASC, created_at DESC");
$items = $stmt->fetchAll();

ob_start();
?>
<div class="admin-header">
    <h1>Merch / Products</h1>
    <a href="?action=add" class="btn btn-primary">+ Add Product</a>
</div>
<?php if (!empty($message)): ?><p class="flash flash-success"><?= e($message) ?></p><?php endif; ?>

<?php if ($edit): ?>
<form method="post" class="admin-form">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= $edit['id'] ?>">
    <h3><?= $edit['id'] ? 'Edit Product' : 'Add Product' ?></h3>
    <div class="form-group">
        <label>Title *</label>
        <input type="text" name="title" value="<?= e($edit['title'] ?? '') ?>" required>
    </div>
    <div class="form-group">
        <label>Slug (URL)</label>
        <input type="text" name="slug" value="<?= e($edit['slug'] ?? '') ?>" placeholder="banter-2024-tour-tee">
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea name="description" rows="3"><?= e($edit['description'] ?? '') ?></textarea>
    </div>
    <div class="form-group">
        <label>Price</label>
        <input type="text" name="price" value="<?= e($edit['price'] ?? '') ?>" placeholder="25.00">
    </div>
    <div class="form-group">
        <label>Image URL</label>
        <input type="url" name="image_url" value="<?= e($edit['image_url'] ?? '') ?>" placeholder="https://...">
        <small class="form-hint">Recommended: 800×800px square (product page displays at 384×384px)</small>
    </div>
    <div class="form-group">
        <label>Featured image URL <small>(optional – used in the shop banner when featured; leave blank to use main image)</small></label>
        <input type="url" name="featured_image_url" value="<?= e($edit['featured_image_url'] ?? '') ?>" placeholder="https://...">
        <small class="form-hint">Recommended: 1200×400px (3:1 landscape for the featured banner)</small>
    </div>
    <div class="form-group">
        <label>Category</label>
        <select name="category">
            <option value="tour_apparel" <?= ($edit['category'] ?? '') === 'tour_apparel' ? 'selected' : '' ?>>Tour Apparel</option>
            <option value="banter_mugs" <?= ($edit['category'] ?? '') === 'banter_mugs' ? 'selected' : '' ?>>Banter Mugs</option>
            <option value="glasgow_humor" <?= ($edit['category'] ?? '') === 'glasgow_humor' ? 'selected' : '' ?>>Glasgow Humor</option>
            <option value="general" <?= ($edit['category'] ?? '') === 'general' ? 'selected' : '' ?>>General</option>
        </select>
    </div>
    <div class="form-group">
        <label>Sizes (e.g. S, M, L, XL)</label>
        <input type="text" name="sizes" value="<?= e($edit['sizes'] ?? '') ?>" placeholder="S, M, L, XL">
    </div>
    <div class="form-group">
        <label>Buy URL (link to purchase)</label>
        <input type="url" name="buy_url" value="<?= e($edit['buy_url'] ?? '') ?>" placeholder="https://...">
    </div>
    <div class="form-group">
        <label><input type="checkbox" name="is_featured" value="1" <?= !empty($edit['is_featured']) ? 'checked' : '' ?>> Featured on shop</label>
    </div>
    <div class="form-group">
        <label>Sort order</label>
        <input type="number" name="sort_order" value="<?= (int)($edit['sort_order'] ?? 0) ?>">
    </div>
    <button type="submit" class="btn btn-primary"><?= $edit['id'] ? 'Save' : 'Add' ?></button>
    <a href="merch.php" class="btn btn-secondary">Cancel</a>
</form>
<?php endif; ?>
<div class="admin-table-wrapper">
<table class="admin-table" id="merch-table">
    <thead><tr><th style="width:36px"></th><th>Title</th><th>Category</th><th>Price</th><th>Actions</th></tr></thead>
    <tbody>
        <?php foreach ($items as $i): ?>
        <tr data-id="<?= (int)$i['id'] ?>">
            <td class="merch-drag-handle" title="Drag to reorder">⋮⋮</td>
            <td><?= e(mb_strlen($i['title']) > 20 ? mb_substr($i['title'], 0, 20) . '…' : $i['title']) ?><?= !empty($i['is_featured']) ? ' <span class="text-primary">★</span>' : '' ?></td>
            <td><?= e(mb_strlen($i['category']) > 20 ? mb_substr(str_replace('_', ' ', $i['category']), 0, 20) . '…' : str_replace('_', ' ', $i['category'])) ?></td>
            <td><?= $i['price'] ? '£' . number_format((float)$i['price'], 2) : '—' ?></td>
            <td>
                <a href="/merch/<?= e($i['slug']) ?>" target="_blank" rel="noopener" class="btn btn-small btn-secondary">View</a>
                <a href="?edit=<?= $i['id'] ?>" class="btn btn-small btn-primary">Edit</a>
                <a href="?delete=<?= $i['id'] ?>" class="btn btn-small btn-secondary" onclick="return confirm('Delete?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php if (empty($items)): ?><p>No products yet. Add one to get started.</p><?php endif; ?>
<?php if (!empty($items)): ?>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
(function() {
    var tbody = document.querySelector('.admin-table#merch-table tbody');
    if (!tbody) return;
    var form = document.createElement('form');
    form.innerHTML = '<input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">';
    var csrf = form.querySelector('input').value;
    new Sortable(tbody, {
        handle: '.merch-drag-handle',
        animation: 150,
        onEnd: function() {
            var ids = [].map.call(tbody.querySelectorAll('tr[data-id]'), function(tr) { return tr.dataset.id; });
            var fd = new FormData();
            fd.append('csrf_token', csrf);
            ids.forEach(function(id) { fd.append('ids[]', id); });
            fetch('merch-reorder.php', { method: 'POST', body: fd })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data.ok) {
                        var msg = document.createElement('p');
                        msg.className = 'flash flash-success';
                        msg.textContent = 'Order saved.';
                        var main = document.querySelector('.admin-main');
                        if (main) main.insertAdjacentElement('afterbegin', msg);
                        setTimeout(function() { msg.remove(); }, 2000);
                    }
                });
        }
    });
})();
</script>
<?php endif; ?>
<?php
$adminContent = ob_get_clean();
include __DIR__ . '/layout.php';
