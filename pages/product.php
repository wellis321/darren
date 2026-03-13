<?php
$slug = $productSlug ?? '';
if (!$slug) {
    http_response_code(404);
    include __DIR__ . '/../includes/errors/404.php';
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM products WHERE slug = ?");
$stmt->execute([$slug]);
$product = $stmt->fetch();

if (!$product) {
    http_response_code(404);
    include __DIR__ . '/../includes/errors/404.php';
    exit;
}

$currentPage = 'merch';
$pageTitle = $product['title'];
$metaDescription = $product['description'] ? substr(strip_tags($product['description']), 0, 160) : $product['title'] . ' - Darren Connell Shop';

$imgFallback = 'https://images.unsplash.com/photo-1666731843459-4005513dac66?w=800&q=80';
$imgFallbackLocal = BASE_PATH . '/assets/images/product-placeholder.svg';
$imgUrl = $product['image_url'] ?: $imgFallback;
$sizes = $product['sizes'] ? array_map('trim', explode(',', $product['sizes'])) : [];
?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<?php require __DIR__ . '/../includes/meta-stitch.php'; ?>
<title><?= e($pageTitle) ?> | Darren Connell Shop</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet"/>
<script id="tailwind-config">
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    "primary": "#f46a25",
                    "background-light": "#f8f6f5",
                    "background-dark": "#221610",
                },
                fontFamily: { "display": ["Space Grotesk"] },
                borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
            },
        },
    }
</script>
<style>
    body { font-family: 'Space Grotesk', sans-serif; min-height: max(884px, 100dvh); }
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; font-family: 'Material Symbols Outlined'; font-weight: normal; font-style: normal; display: inline-block; line-height: 1; }
</style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 antialiased">
<?php require __DIR__ . '/../includes/navbar-stitch.php'; ?>
<main id="main-content" class="min-h-screen pb-24">
<div class="max-w-4xl mx-auto px-4 py-8">
<a href="/merch.php" class="inline-flex items-center gap-1 text-slate-500 dark:text-slate-400 hover:text-primary transition-colors mb-6">
    <span class="material-symbols-outlined text-xl">arrow_back</span> Back to Shop
</a>
<div class="flex flex-col md:flex-row gap-8">
<div class="flex-1 aspect-square md:aspect-[4/5] rounded-2xl overflow-hidden bg-primary/5 border border-primary/10">
    <img src="<?= e($imgUrl) ?>" alt="<?= e($product['title']) ?>" class="w-full h-full object-cover" onerror="this.onerror=null;this.src='<?= e($imgFallbackLocal) ?>'">
</div>
<div class="flex-1 flex flex-col">
    <span class="inline-block px-2 py-1 rounded bg-primary/20 text-primary text-xs font-bold uppercase tracking-wider mb-2 w-fit"><?= e(str_replace('_', ' ', $product['category'])) ?></span>
    <h1 class="text-2xl md:text-3xl font-bold leading-tight text-slate-900 dark:text-slate-100"><?= e($product['title']) ?></h1>
    <?php if ($product['price']): ?>
    <p class="text-primary text-2xl font-bold mt-2">£<?= number_format((float)$product['price'], 2) ?></p>
    <?php endif; ?>
    <?php if ($product['description']): ?>
    <div class="mt-4 text-slate-600 dark:text-slate-400 leading-relaxed"><?= nl2br(e($product['description'])) ?></div>
    <?php endif; ?>
    <?php if (!empty($sizes)): ?>
    <div class="mt-4">
        <p class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Sizes</p>
        <div class="flex flex-wrap gap-2">
            <?php foreach ($sizes as $s): ?>
            <span class="px-3 py-1 border border-primary/20 rounded-lg text-sm font-medium"><?= e($s) ?></span>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
    <div class="mt-8 flex-1">
    <?php if ($product['buy_url']): ?>
    <a href="<?= e($product['buy_url']) ?>" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 w-full md:w-auto px-8 py-4 bg-primary text-white font-bold rounded-lg hover:brightness-110 transition-all shadow-lg shadow-primary/20">
        <span class="material-symbols-outlined">shopping_bag</span> Buy Now
    </a>
    <?php else: ?>
    <a href="/bookings.php" class="inline-flex items-center justify-center gap-2 w-full md:w-auto px-8 py-4 bg-primary text-white font-bold rounded-lg hover:brightness-110 transition-all shadow-lg shadow-primary/20">
        <span class="material-symbols-outlined">mail</span> Enquire to Order
    </a>
    <?php endif; ?>
    </div>
</div>
</div>
</div>
</div>
</main>
<footer class="border-t border-primary/10 py-8 mt-16">
    <div class="max-w-7xl mx-auto px-4 text-center text-slate-500 dark:text-slate-400 text-sm">
        <p>&copy; <?= date('Y') ?> Darren Connell. All rights reserved.</p>
        <p class="mt-2 opacity-80">This site does not handle personal requests for autographs or video messages.</p>
        <a href="/admin/" class="text-primary/70 hover:text-primary mt-2 inline-block text-xs">Admin</a>
    </div>
</footer>
</body>
</html>
