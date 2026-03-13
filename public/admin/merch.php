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
    $category = trim($_POST['category'] ?? 'general') ?: 'general';
    $sizes = trim($_POST['sizes'] ?? '') ?: null;
    $buy_url = trim($_POST['buy_url'] ?? '') ?: null;
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $sort_order = (int)($_POST['sort_order'] ?? 0);

    if ($title && $slug) {
        if ($id) {
            $stmt = $pdo->prepare("UPDATE products SET slug=?, title=?, description=?, price=?, image_url=?, category=?, sizes=?, buy_url=?, is_featured=?, sort_order=? WHERE id=?");
            $stmt->execute([$slug, $title, $description, $price, $image_url, $category, $sizes, $buy_url, $is_featured, $sort_order, $id]);
            $message = 'Product updated.';
        } else {
            $stmt = $pdo->prepare("INSERT INTO products (slug, title, description, price, image_url, category, sizes, buy_url, is_featured, sort_order) VALUES (?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute([$slug, $title, $description, $price, $image_url, $category, $sizes, $buy_url, $is_featured, $sort_order]);
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
    $edit = ['id' => 0, 'slug' => '', 'title' => '', 'description' => '', 'price' => '', 'image_url' => '', 'category' => 'tour_apparel', 'sizes' => '', 'buy_url' => '', 'is_featured' => 0, 'sort_order' => 0];
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
<table class="admin-table">
    <thead><tr><th>Title</th><th>Category</th><th>Price</th><th>Actions</th></tr></thead>
    <tbody>
        <?php foreach ($items as $i): ?>
        <tr>
            <td><?= e($i['title']) ?><?= !empty($i['is_featured']) ? ' <span class="text-primary">★</span>' : '' ?></td>
            <td><?= e(str_replace('_', ' ', $i['category'])) ?></td>
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
<?php if (empty($items)): ?><p>No products yet. Add one to get started.</p><?php endif; ?>
<?php
$adminContent = ob_get_clean();
include __DIR__ . '/layout.php';
