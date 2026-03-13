<?php
$currentPage = 'podcast';
$pageTitle = 'Glaswegians Anonymous Podcast';
$metaDescription = 'Listen to Glaswegians Anonymous — hosted by Darren Connell and Gary Faulds. Honest, funny conversations about Glasgow life.';

$stmt = $pdo->query("SELECT * FROM podcast_episodes WHERE podcast_name LIKE '%Glaswegians%' ORDER BY release_date DESC, sort_order DESC, id DESC LIMIT 20");
$episodes = $stmt->fetchAll();

$appleUrl = 'https://podcasts.apple.com/gb/podcast/glaswegians-anonymous/id1834912592';
$spotifyUrl = 'https://open.spotify.com/show/0hjOxRAlk3A9CVt1KFlmpI';
$youtubeUrl = 'https://www.youtube.com/results?search_query=Glaswegians+Anonymous+podcast';
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
</style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 min-h-screen">
<div class="relative flex h-auto min-h-screen w-full flex-col overflow-x-hidden">
<?php require __DIR__ . '/../includes/navbar-stitch.php'; ?>
<main id="main-content" class="flex-1 pb-24">
<!-- Hero Section -->
<section class="flex p-6">
<div class="flex w-full flex-col gap-6 items-center">
<img alt="Glaswegians Anonymous Podcast - Darren Connell and Gary Faulds. Scan the QR code to subscribe." class="w-full max-w-2xl rounded-xl shadow-2xl shadow-primary/20 border-2 border-primary/20 object-cover aspect-[4/3]" src="/assets/images/Glas-wegians%20anonQR.jpg"/>
<div class="flex flex-col items-center gap-2">
<h1 class="text-3xl font-bold leading-tight tracking-tight text-center text-primary">Glaswegians Anonymous</h1>
<p class="text-slate-600 dark:text-primary/70 text-lg font-medium text-center">Hosted by Darren Connell &amp; Gary Faulds</p>
<div class="flex gap-2">
<span class="px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider">Comedy</span>
<span class="px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider">Glasgow Life</span>
</div>
</div>
<p class="text-slate-700 dark:text-slate-300 text-base font-normal leading-relaxed max-w-md text-center">
    Honest, funny conversations about Glasgow life. Join Darren and Gary as they dive into the real Glasgow, covering everything from local legends to everyday madness.
</p>
</div>
</section>
<!-- Platform Links -->
<section class="px-6 mb-8">
<div class="grid grid-cols-3 gap-4">
<a class="flex flex-col items-center gap-2 group" href="<?= e($appleUrl) ?>" target="_blank" rel="noopener">
<div class="rounded-2xl bg-slate-200 dark:bg-primary/10 p-4 w-full flex justify-center group-hover:bg-primary transition-colors duration-300">
<span class="material-symbols-outlined text-primary group-hover:text-white">podcasts</span>
</div>
<p class="text-xs font-bold uppercase tracking-widest opacity-70">Apple</p>
</a>
<a class="flex flex-col items-center gap-2 group" href="<?= e($spotifyUrl) ?>" target="_blank" rel="noopener">
<div class="rounded-2xl bg-slate-200 dark:bg-primary/10 p-4 w-full flex justify-center group-hover:bg-primary transition-colors duration-300">
<span class="material-symbols-outlined text-primary group-hover:text-white">equalizer</span>
</div>
<p class="text-xs font-bold uppercase tracking-widest opacity-70">Spotify</p>
</a>
<a class="flex flex-col items-center gap-2 group" href="<?= e($youtubeUrl) ?>" target="_blank" rel="noopener">
<div class="rounded-2xl bg-slate-200 dark:bg-primary/10 p-4 w-full flex justify-center group-hover:bg-primary transition-colors duration-300">
<span class="material-symbols-outlined text-primary group-hover:text-white">video_library</span>
</div>
<p class="text-xs font-bold uppercase tracking-widest opacity-70">YouTube</p>
</a>
</div>
</section>
<!-- Episodes List -->
<section class="px-6 space-y-4">
<div class="flex items-center justify-between mb-4">
<h3 class="text-xl font-bold tracking-tight">Recent Episodes</h3>
</div>
<?php if (empty($episodes)): ?>
<p class="text-slate-500 dark:text-slate-400 py-8 text-center">No episodes yet. Add them in the admin.</p>
<?php endif; ?>
<?php foreach (array_slice($episodes, 0, 10) as $i => $ep): ?>
<?php
$epNum = $ep['episode_num'] ?? ($i + 1);
$duration = $ep['duration'] ?? null;
$url = !empty($ep['episode_url']) ? $ep['episode_url'] : $spotifyUrl;
$title = e($ep['episode_title'] ?? 'Episode ' . $epNum);
?>
<div class="bg-white dark:bg-primary/5 rounded-xl p-4 flex items-center gap-4 border border-slate-200 dark:border-primary/10 hover:border-primary/40 transition-colors">
<img alt="Glaswegians Anonymous episode" class="size-16 rounded-lg shrink-0 object-cover bg-primary/20" src="/assets/images/glaswegians-icon-white.png"/>
<div class="flex-1 min-w-0">
<p class="text-xs font-bold text-primary mb-1">EPISODE <?= (int)$epNum ?><?= $duration ? ' • ' . e($duration) . ' MIN' : '' ?></p>
<h4 class="font-bold truncate"><?= $title ?></h4>
</div>
<a href="<?= e($url) ?>" class="size-10 rounded-full bg-primary text-white flex items-center justify-center shrink-0 shadow-lg shadow-primary/30 hover:scale-105 transition-transform" target="_blank" rel="noopener" aria-label="Play">
<span class="material-symbols-outlined">play_arrow</span>
</a>
</div>
<?php endforeach; ?>
</section>
</main>
<!-- Bottom Navigation Bar -->
<nav class="fixed bottom-0 left-0 right-0 flex gap-2 border-t border-slate-200 dark:border-primary/20 bg-background-light dark:bg-background-dark px-4 pb-6 pt-3 z-20">
<a class="flex flex-1 flex-col items-center justify-center gap-1 text-slate-500 dark:text-slate-400 hover:text-primary transition-colors" href="/">
<span class="material-symbols-outlined">home</span>
<p class="text-[10px] font-bold uppercase tracking-widest leading-none">Home</p>
</a>
<a class="flex flex-1 flex-col items-center justify-center gap-1 text-slate-500 dark:text-slate-400 hover:text-primary transition-colors" href="/about.php">
<span class="material-symbols-outlined">person</span>
<p class="text-[10px] font-bold uppercase tracking-widest leading-none">About</p>
</a>
<a class="flex flex-1 flex-col items-center justify-center gap-1 text-slate-500 dark:text-slate-400 hover:text-primary transition-colors" href="/live.php">
<span class="material-symbols-outlined">confirmation_number</span>
<p class="text-[10px] font-bold uppercase tracking-widest leading-none">Shows</p>
</a>
<a class="flex flex-1 flex-col items-center justify-center gap-1 text-primary" href="/podcast.php">
<span class="material-symbols-outlined">library_music</span>
<p class="text-[10px] font-bold uppercase tracking-widest leading-none">Podcast</p>
</a>
</nav>
</div>
</body>
</html>
