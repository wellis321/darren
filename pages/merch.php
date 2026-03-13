<?php
$currentPage = 'merch';
$pageTitle = 'Shop';
$metaDescription = 'Official Darren Connell merchandise. Tour t-shirts, Glasgow humor magnets, banter mugs and more.';

$catLabels = ['tour_apparel' => 'Tour Apparel', 'banter_mugs' => 'Banter Mugs', 'glasgow_humor' => 'Glasgow Humor'];
$activeCategory = trim($_GET['category'] ?? '');
if ($activeCategory && !isset($catLabels[$activeCategory])) {
    $activeCategory = '';
}

$stmt = $pdo->query("SELECT * FROM products ORDER BY is_featured DESC, sort_order ASC, created_at DESC");
$allProducts = $stmt->fetchAll();

$products = $activeCategory
    ? array_filter($allProducts, fn($p) => ($p['category'] ?? '') === $activeCategory)
    : $allProducts;

$featured = array_filter($products, fn($p) => !empty($p['is_featured']));
?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<?php require __DIR__ . '/../includes/meta-stitch.php'; ?>
<title>Darren Connell Shop - Official Merchandise</title>
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
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 antialiased">
<?php require __DIR__ . '/../includes/navbar-stitch.php'; ?>
<div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">
<!-- Category Tabs -->
<nav class="bg-background-light dark:bg-background-dark border-b border-primary/10">
<div class="flex px-4 gap-4 sm:gap-6 overflow-x-auto no-scrollbar scroll-smooth py-1" id="category-tabs">
<a class="flex flex-col items-center justify-center border-b-2 pb-3 pt-4 whitespace-nowrap transition-colors shrink-0 <?= !$activeCategory ? 'border-primary text-primary' : 'border-transparent text-slate-500 dark:text-slate-400 hover:text-primary' ?>" href="/merch.php" data-tab="all">
<span class="text-sm font-bold">All Items</span>
</a>
<?php foreach ($catLabels as $cat => $label): ?>
<a class="flex flex-col items-center justify-center border-b-2 pb-3 pt-4 whitespace-nowrap transition-colors shrink-0 <?= $activeCategory === $cat ? 'border-primary text-primary' : 'border-transparent text-slate-500 dark:text-slate-400 hover:text-primary' ?>" href="/merch.php?category=<?= e($cat) ?>" data-tab="<?= e($cat) ?>">
<span class="text-sm font-bold"><?= e($label) ?></span>
</a>
<?php endforeach; ?>
</div>
</nav>
<script>
(function(){var t=document.querySelector('#category-tabs a.border-primary');if(t)t.scrollIntoView({inline:'nearest',block:'nearest',behavior:'instant'});})();
</script>
<main id="main-content" class="flex-1 min-w-0 overflow-x-hidden">
<?php if (!empty($featured)): ?>
<section class="p-4">
<h1 class="text-slate-900 dark:text-slate-100 text-2xl font-bold leading-tight mb-4">Featured</h1>
<?php foreach ($featured as $p): ?>
<?php $imgFbLocal = BASE_PATH . '/assets/images/product-placeholder.svg'; $img = ($p['featured_image_url'] ?? $p['image_url']) ?: $imgFbLocal; ?>
<div class="mb-8">
<div class="flex flex-col overflow-hidden rounded-xl border border-primary/10 bg-primary/5">
<a href="/merch/<?= e($p['slug']) ?>" class="block aspect-[3/1] w-full overflow-hidden bg-center bg-cover">
<img src="<?= e($img) ?>" alt="<?= e($p['title']) ?>" class="h-full w-full object-cover" onerror="this.onerror=null;this.src='<?= e($imgFbLocal) ?>'"/>
</a>
<div class="flex flex-col gap-2 p-4">
<div class="flex justify-between items-start">
<div>
<span class="inline-block px-2 py-1 rounded bg-primary/20 text-primary text-[10px] font-bold uppercase tracking-wider mb-2">Best Seller</span>
<h3 class="text-slate-900 dark:text-slate-100 text-2xl font-bold leading-tight"><a href="/merch/<?= e($p['slug']) ?>" class="hover:text-primary transition-colors"><?= e($p['title']) ?></a></h3>
</div>
<?php if ($p['price']): ?><p class="text-primary text-xl font-bold">£<?= number_format((float)$p['price'], 2) ?></p><?php endif; ?>
</div>
<?php if ($p['description']): ?>
<p class="text-slate-600 dark:text-slate-400 text-base font-normal leading-relaxed line-clamp-2"><?= e($p['description']) ?></p>
<?php endif; ?>
<?php if ($p['sizes']): ?>
<div class="mt-4 flex flex-wrap gap-2">
<?php foreach (array_map('trim', explode(',', $p['sizes'])) as $s): ?>
<span class="px-3 py-1 border border-primary/20 rounded-lg text-xs font-medium"><?= e($s) ?></span>
<?php endforeach; ?>
</div>
<?php endif; ?>
<a href="/merch/<?= e($p['slug']) ?>" class="mt-4 flex w-full cursor-pointer items-center justify-center rounded-lg h-12 px-6 bg-primary text-white text-base font-bold shadow-lg shadow-primary/20 hover:brightness-110 active:scale-95 transition-all">
<span class="material-symbols-outlined mr-2">shopping_bag</span> View Product
</a>
</div>
</div>
</div>
<?php endforeach; ?>
</section>
<?php endif; ?>

<!-- Product Grid -->
<section class="p-4 pb-24">
<?php if (empty($products)): ?>
<p class="text-slate-500 dark:text-slate-400">No products yet. Check back soon!</p>
<?php else: ?>
<div class="grid grid-cols-2 gap-4">
<?php foreach ($products as $p): ?>
<?php if (!empty($p['is_featured'])) continue; ?>
<?php $imgFb = 'https://images.unsplash.com/photo-1666731843459-4005513dac66?w=800&q=80'; $imgFbLocal = BASE_PATH . '/assets/images/product-placeholder.svg'; $img = $p['image_url'] ?: $imgFb; ?>
<div class="flex min-w-0 flex-col gap-3 group">
<a href="/merch/<?= e($p['slug']) ?>" class="aspect-square w-full overflow-hidden rounded-xl bg-primary/5 relative block">
<img src="<?= e($img) ?>" alt="<?= e($p['title']) ?>" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" onerror="this.onerror=null;this.src='<?= e($imgFbLocal) ?>'"/>
</a>
<div>
<p class="text-slate-900 dark:text-slate-100 font-bold"><a href="/merch/<?= e($p['slug']) ?>" class="hover:text-primary transition-colors"><?= e($p['title']) ?></a></p>
<?php if ($p['description']): ?><p class="text-slate-600 dark:text-slate-400 text-sm line-clamp-2 mt-0.5"><?= e($p['description']) ?></p><?php endif; ?>
<?php if ($p['price']): ?><p class="text-primary font-medium mt-1">£<?= number_format((float)$p['price'], 2) ?></p><?php endif; ?>
</div>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>
</section>
</main>
<?php require __DIR__ . '/../includes/footer-stitch.php'; ?>
<!-- Bottom Navigation Bar -->
<footer class="md:hidden fixed bottom-0 left-0 right-0 z-50">
<div class="flex gap-2 border-t border-primary/10 bg-background-light dark:bg-background-dark/95 backdrop-blur-md px-4 pb-6 pt-2">
<a class="flex flex-1 flex-col items-center justify-center gap-1 text-slate-500 dark:text-slate-400" href="/">
<div class="flex h-8 items-center justify-center"><span class="material-symbols-outlined">home</span></div>
<p class="text-[10px] font-medium leading-normal uppercase tracking-wider">Home</p>
</a>
<a class="flex flex-1 flex-col items-center justify-center gap-1 text-primary" href="/merch.php">
<div class="flex h-8 items-center justify-center"><span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1">storefront</span></div>
<p class="text-[10px] font-bold leading-normal uppercase tracking-wider">Shop</p>
</a>
<a class="flex flex-1 flex-col items-center justify-center gap-1 text-slate-500 dark:text-slate-400" href="/live.php">
<div class="flex h-8 items-center justify-center"><span class="material-symbols-outlined">confirmation_number</span></div>
<p class="text-[10px] font-medium leading-normal uppercase tracking-wider">Tours</p>
</a>
<a class="flex flex-1 flex-col items-center justify-center gap-1 text-slate-500 dark:text-slate-400" href="/bookings.php">
<div class="flex h-8 items-center justify-center"><span class="material-symbols-outlined">mail</span></div>
<p class="text-[10px] font-medium leading-normal uppercase tracking-wider">Book</p>
</a>
</div>
</footer>
</div>
</body>
</html>
