<?php
$currentPage = 'media';
$pageTitle = 'Darren Connell Media';
$metaDescription = 'Watch Darren Connell stand-up clips, Scot Squad highlights and comedy videos.';

$stmt = $pdo->query("SELECT * FROM media WHERE type IN ('video', 'image') ORDER BY sort_order ASC, created_at DESC");
$allMedia = $stmt->fetchAll();

$videos = array_filter($allMedia, fn($m) => $m['type'] === 'video');
$images = array_filter($allMedia, fn($m) => $m['type'] === 'image');

// Extract YouTube ID for thumbnail
function youtube_thumbnail($url) {
    if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $url ?? '', $m)) {
        return 'https://img.youtube.com/vi/' . $m[1] . '/hqdefault.jpg';
    }
    return null;
}

// Fallback: Crowd Work video if no media in DB
if (empty($videos)) {
    $videos = [
        ['title' => 'Crowd Work', 'url' => 'https://www.youtube.com/watch?v=yGhz51GFeRs', 'embed_code' => '<iframe width="100%" height="315" src="https://www.youtube.com/embed/yGhz51GFeRs" title="Darren Connell - Crowd Work" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>', 'description' => 'Raw crowd work from Darren Connell.']
    ];
}
?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<?php require __DIR__ . '/../includes/meta-stitch.php'; ?>
<title><?= e($pageTitle) ?> | Darren Connell</title>
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
    .filled-icon { font-variation-settings: 'FILL' 1; }
</style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 antialiased">
<div class="relative flex min-h-screen flex-col overflow-x-hidden">
<?php require __DIR__ . '/../includes/navbar-stitch.php'; ?>
<!-- Category Tabs -->
<nav class="sticky top-16 z-40 bg-background-light dark:bg-background-dark border-b border-primary/10">
<div class="flex px-4 gap-8 overflow-x-auto no-scrollbar">
<a class="flex flex-col items-center justify-center border-b-2 border-primary text-primary pb-3 pt-4 shrink-0" href="#all">
<span class="text-sm font-bold">All Media</span>
</a>
<a class="flex flex-col items-center justify-center border-b-2 border-transparent text-slate-500 dark:text-slate-400 pb-3 pt-4 hover:text-primary transition-colors shrink-0" href="#all">
<span class="text-sm font-bold">Stand-up Clips</span>
</a>
<a class="flex flex-col items-center justify-center border-b-2 border-transparent text-slate-500 dark:text-slate-400 pb-3 pt-4 hover:text-primary transition-colors shrink-0" href="#all">
<span class="text-sm font-bold">Sketches</span>
</a>
<a class="flex flex-col items-center justify-center border-b-2 border-transparent text-slate-500 dark:text-slate-400 pb-3 pt-4 hover:text-primary transition-colors shrink-0" href="#gallery">
<span class="text-sm font-bold">Gallery</span>
</a>
<a class="flex flex-col items-center justify-center border-b-2 border-transparent text-slate-500 dark:text-slate-400 pb-3 pt-4 hover:text-primary transition-colors shrink-0" href="#threads">
<span class="text-sm font-bold">Threads</span>
</a>
</div>
</nav>
<main id="main-content" class="flex-1 pb-24">
<!-- Video Section -->
<section id="all" class="p-4">
<div class="flex items-center justify-between mb-4">
<h1 class="text-lg font-bold tracking-tight">Stand-up &amp; Sketches</h1>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
<?php foreach (array_slice($videos, 0, 2) as $i => $item): ?>
<?php $thumb = youtube_thumbnail($item['url'] ?? ''); ?>
<div class="group relative overflow-hidden rounded-xl bg-slate-200 dark:bg-slate-800 aspect-video flex items-end">
<?php if ($thumb): ?>
<div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-105" style="background-image: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 60%), url('<?= e($thumb) ?>');"></div>
<?php else: ?>
<div class="absolute inset-0 bg-slate-800"></div>
<?php endif; ?>
<div class="absolute inset-0 flex items-center justify-center">
<a href="<?= e($item['url'] ?? '#') ?>" class="size-14 rounded-full bg-primary/90 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform" target="_blank" rel="noopener" aria-label="Play">
<span class="material-symbols-outlined filled-icon text-3xl">play_arrow</span>
</a>
</div>
<div class="relative p-4 w-full">
<p class="text-white text-base font-bold leading-tight"><?= e($item['title']) ?></p>
<?php if (!empty($item['description'])): ?>
<p class="text-white/70 text-xs mt-1"><?= e($item['description']) ?></p>
<?php endif; ?>
</div>
</div>
<?php endforeach; ?>
</div>
<?php if (count($videos) > 2): ?>
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-4">
<?php foreach (array_slice($videos, 2, 4) as $item): ?>
<?php $thumb = youtube_thumbnail($item['url'] ?? ''); ?>
<a href="<?= e($item['url'] ?? '#') ?>" class="group relative aspect-square rounded-lg overflow-hidden bg-slate-800 block" target="_blank" rel="noopener">
<?php if ($thumb): ?>
<div class="absolute inset-0 bg-cover bg-center group-hover:scale-105 transition-transform" style="background-image: url('<?= e($thumb) ?>');"></div>
<?php endif; ?>
<div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
<span class="material-symbols-outlined text-white text-4xl">play_circle</span>
</div>
<div class="absolute bottom-0 left-0 right-0 p-2 bg-gradient-to-t from-black/80 to-transparent">
<p class="text-white text-xs font-bold line-clamp-1"><?= e($item['title']) ?></p>
</div>
</a>
<?php endforeach; ?>
</div>
<?php endif; ?>
</section>
<!-- Photo Gallery Section -->
<?php if (!empty($images)): ?>
<section id="gallery" class="p-4 mt-4">
<div class="flex items-center justify-between mb-4">
<h2 class="text-lg font-bold tracking-tight">Performance Photos</h2>
</div>
<div class="columns-2 md:columns-3 lg:columns-4 gap-3 space-y-3">
<?php foreach ($images as $item): ?>
<div class="break-inside-avoid">
<img alt="<?= e($item['title']) ?>" class="w-full rounded-xl object-cover hover:opacity-90 transition-opacity cursor-zoom-in" src="<?= e($item['url']) ?>" loading="lazy"/>
</div>
<?php endforeach; ?>
</div>
</section>
<?php else: ?>
<section id="gallery" class="p-4 mt-4">
<div class="flex items-center justify-between mb-4">
<h2 class="text-lg font-bold tracking-tight">Performance Photos</h2>
</div>
<div class="columns-2 md:columns-3 lg:columns-4 gap-3 space-y-3">
<?php
$placeholderPhotos = [
    ['url' => '/assets/images/darrenconnell_wideimage.jpg', 'alt' => 'Darren Connell'],
    ['url' => '/assets/images/darren_relaxed.png', 'alt' => 'Darren Connell'],
    ['url' => '/assets/images/Glas-wegians%20anonQR.jpg', 'alt' => 'Glaswegians Anonymous - Darren Connell and Gary Faulds'],
    ['url' => '/assets/images/darren.jpg', 'alt' => 'Darren Connell'],
];
foreach ($placeholderPhotos as $p):
?>
<div class="break-inside-avoid">
<img alt="<?= e($p['alt']) ?>" class="w-full rounded-xl object-cover hover:opacity-90 transition-opacity" src="<?= e($p['url']) ?>" loading="lazy"/>
</div>
<?php endforeach; ?>
</div>
</section>
<?php endif; ?>

<!-- From Threads Section -->
<section id="threads" class="p-4 mt-8">
<div class="flex items-center justify-between mb-4">
<h2 class="text-lg font-bold tracking-tight">From Threads</h2>
<a href="https://www.threads.net/@darrenconnellcomedian" target="_blank" rel="noopener" class="text-primary text-sm font-bold hover:underline">Follow @darrenconnellcomedian</a>
</div>
<p class="text-slate-500 dark:text-slate-400 text-sm mb-6">Latest from Darren on Threads — comedy, podcasts, tour updates and Glasgow banter.</p>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
<article class="rounded-xl border border-primary/10 bg-white/5 dark:bg-primary/5 overflow-hidden">
<iframe class="w-full min-h-[400px] border-0" src="https://www.threads.net/embed/post/DVwcAoiAu3S" allowfullscreen></iframe>
<a href="https://www.threads.net/@darrenconnellcomedian/post/DVwcAoiAu3S" target="_blank" rel="noopener" class="block p-3 text-sm text-slate-500 dark:text-slate-400 hover:text-primary">View on Threads →</a>
</article>
<article class="rounded-xl border border-primary/10 bg-white/5 dark:bg-primary/5 overflow-hidden">
<iframe class="w-full min-h-[400px] border-0" src="https://www.threads.net/embed/post/DVmNp5Rjoft" allowfullscreen></iframe>
<a href="https://www.threads.net/@darrenconnellcomedian/post/DVmNp5Rjoft" target="_blank" rel="noopener" class="block p-3 text-sm text-slate-500 dark:text-slate-400 hover:text-primary">View on Threads →</a>
</article>
<article class="rounded-xl border border-primary/10 bg-white/5 dark:bg-primary/5 overflow-hidden">
<iframe class="w-full min-h-[400px] border-0" src="https://www.threads.net/embed/post/DVj1QdmDRGa" allowfullscreen></iframe>
<a href="https://www.threads.net/@darrenconnellcomedian/post/DVj1QdmDRGa" target="_blank" rel="noopener" class="block p-3 text-sm text-slate-500 dark:text-slate-400 hover:text-primary">View on Threads →</a>
</article>
</div>
</section>
</main>
<!-- Bottom Navigation Bar -->
<nav class="fixed bottom-0 left-0 right-0 z-50 flex h-auto flex-col bg-background-light dark:bg-background-dark border-t border-primary/10 px-4 pb-6 pt-2">
<div class="flex gap-2">
<a class="flex flex-1 flex-col items-center justify-end gap-1 text-slate-500 dark:text-slate-400 hover:text-primary transition-colors" href="/">
<div class="flex h-8 items-center justify-center"><span class="material-symbols-outlined">home</span></div>
<p class="text-[10px] font-medium leading-normal tracking-wide uppercase">Home</p>
</a>
<a class="flex flex-1 flex-col items-center justify-end gap-1 text-slate-500 dark:text-slate-400 hover:text-primary transition-colors" href="/live.php">
<div class="flex h-8 items-center justify-center"><span class="material-symbols-outlined">confirmation_number</span></div>
<p class="text-[10px] font-medium leading-normal tracking-wide uppercase">Tour</p>
</a>
<a class="flex flex-1 flex-col items-center justify-end gap-1 text-primary" href="/media.php">
<div class="flex h-8 items-center justify-center"><span class="material-symbols-outlined filled-icon">photo_library</span></div>
<p class="text-[10px] font-medium leading-normal tracking-wide uppercase">Media</p>
</a>
<a class="flex flex-1 flex-col items-center justify-end gap-1 text-slate-500 dark:text-slate-400 hover:text-primary transition-colors" href="/merch.php">
<div class="flex h-8 items-center justify-center"><span class="material-symbols-outlined">shopping_bag</span></div>
<p class="text-[10px] font-medium leading-normal tracking-wide uppercase">Merch</p>
</a>
<a class="flex flex-1 flex-col items-center justify-end gap-1 text-slate-500 dark:text-slate-400 hover:text-primary transition-colors" href="/bookings.php">
<div class="flex h-8 items-center justify-center"><span class="material-symbols-outlined">mail</span></div>
<p class="text-[10px] font-medium leading-normal tracking-wide uppercase">Contact</p>
</a>
</div>
</nav>
</div>
</body>
</html>
