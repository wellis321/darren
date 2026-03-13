<?php
$currentPage = 'live';
$pageTitle = 'Tour Dates';
$metaDescription = 'View Darren Connell\'s upcoming tour dates and comedy shows. Book tickets for Glasgow, Edinburgh and UK-wide performances.';

$stmt = $pdo->query("SELECT * FROM events WHERE event_date >= CURDATE() ORDER BY event_date ASC");
$upcoming = $stmt->fetchAll();

$stmt = $pdo->query("SELECT * FROM events WHERE event_date < CURDATE() ORDER BY event_date DESC LIMIT 10");
$past = $stmt->fetchAll();

// Deduplicate by title+venue+date (in case SQL was run multiple times)
$dedupe = function($rows) {
    $seen = [];
    return array_values(array_filter($rows, function($e) use (&$seen) {
        $key = ($e['title'] ?? '') . '|' . ($e['venue'] ?? '') . '|' . ($e['event_date'] ?? '');
        if (isset($seen[$key])) return false;
        $seen[$key] = true;
        return true;
    }));
};
$upcoming = $dedupe($upcoming);
$past = $dedupe($past);

$count = count($upcoming);
$tourTag = date('Y') . ' Tour';
?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<?php $jsonLdEvents = array_slice($upcoming, 0, 10); require __DIR__ . '/../includes/meta-stitch.php'; ?>
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
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        font-family: 'Material Symbols Outlined';
        font-weight: normal;
        font-style: normal;
        display: inline-block;
        line-height: 1;
    }
</style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen">
<div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">
<?php require __DIR__ . '/../includes/navbar-stitch.php'; ?>
<main id="main-content">
<!-- Hero Banner -->
<div class="p-4">
<div class="relative flex flex-col justify-end overflow-hidden rounded-xl min-h-[240px] group" style="background-image: linear-gradient(0deg, rgba(34, 22, 16, 0.9) 0%, rgba(34, 22, 16, 0.2) 50%, rgba(34, 22, 16, 0) 100%), url('/assets/images/darren__banner.png'); background-size: cover; background-position: center;">
<div class="flex flex-col p-6">
<span class="bg-primary text-white text-[10px] font-bold uppercase tracking-widest px-2 py-1 rounded w-fit mb-2"><?= e($tourTag) ?></span>
<h1 class="text-white text-3xl font-bold leading-tight font-display">Live & Uncut</h1>
<p class="text-slate-300 text-sm mt-1">Experience the raw energy of Darren Connell live on stage across the UK.</p>
</div>
</div>
</div>

<!-- Section Title -->
<div class="px-4 py-2 flex items-center justify-between">
<h2 class="text-slate-900 dark:text-slate-100 text-xl font-bold leading-tight tracking-tight font-display">Upcoming Shows</h2>
<span class="text-primary text-xs font-bold uppercase tracking-wider"><?= $count ?> <?= $count === 1 ? 'Date' : 'Dates' ?> Found</span>
</div>

<!-- Tour Dates List -->
<div class="flex flex-col gap-1 px-4 pb-24">
<?php if (!empty($upcoming)): ?>
<?php foreach ($upcoming as $event): ?>
<?php
$soldOut = !empty($event['is_sold_out'] ?? 0);
$dayName = format_date($event['event_date'], 'l');
$timeStr = $event['event_time'] ? (new DateTime($event['event_time']))->format('g:i A') : 'TBC';
$city = trim($event['venue_city'] ?? '');
$country = in_array($city, ['Glasgow','Edinburgh','Aberdeen','Dundee','Inverness']) ? 'Scotland' : ($city === 'London' ? 'UK' : ($city ? 'UK' : ''));
$locationStr = $city ? e($city) . ($country ? ', ' . $country : '') : '';
?>
<div class="flex flex-col sm:flex-row gap-4 bg-white dark:bg-background-dark border <?= $soldOut ? 'border-slate-200 dark:border-slate-800' : 'border-primary/5 dark:border-primary/10' ?> p-4 rounded-xl items-center justify-between hover:border-primary/40 transition-all duration-300 mt-2 <?= $soldOut ? 'opacity-80' : '' ?>">
<div class="flex items-start gap-4 w-full">
<div class="flex flex-col items-center justify-center rounded-lg <?= $soldOut ? 'bg-slate-100 dark:bg-slate-800 border-slate-200 dark:border-slate-700' : 'bg-primary/10 dark:bg-primary/20 border-primary/20' ?> shrink-0 size-14 border">
<span class="<?= $soldOut ? 'text-slate-500' : 'text-primary' ?> font-bold text-lg leading-none"><?= format_date($event['event_date'], 'j') ?></span>
<span class="<?= $soldOut ? 'text-slate-500' : 'text-primary' ?> text-[10px] font-bold uppercase"><?= format_date($event['event_date'], 'M') ?></span>
</div>
<div class="flex flex-1 flex-col justify-center">
<p class="<?= $soldOut ? 'text-slate-500 line-through' : 'text-slate-900 dark:text-slate-100' ?> text-base font-bold font-display"><?= e($event['title']) ?> — <?= e($event['venue']) ?></p>
<p class="text-slate-500 dark:text-slate-400 text-sm font-medium"><?= $locationStr ?></p>
<div class="flex items-center gap-2 mt-1">
<?php if ($soldOut): ?>
<span class="material-symbols-outlined text-slate-400 text-xs">block</span>
<p class="text-slate-400 dark:text-slate-500 text-xs uppercase font-bold tracking-tighter">Sold Out</p>
<?php else: ?>
<span class="material-symbols-outlined text-primary text-xs">schedule</span>
<p class="text-slate-500 dark:text-slate-400 text-xs"><?= e($dayName) ?> • <?= e($timeStr) ?></p>
<?php endif; ?>
</div>
</div>
</div>
<div class="shrink-0 w-full sm:w-auto">
<?php if ($soldOut): ?>
<button class="w-full sm:min-w-[120px] cursor-not-allowed items-center justify-center rounded-lg h-10 px-4 bg-slate-200 dark:bg-slate-800 text-slate-500 text-sm font-bold" disabled>Sold Out</button>
<?php elseif ($event['ticket_url']): ?>
<a href="<?= e($event['ticket_url']) ?>" class="inline-flex w-full sm:min-w-[120px] items-center justify-center rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold transition-transform hover:scale-105 active:scale-95 shadow-lg shadow-primary/20" target="_blank" rel="noopener">Book Now</a>
<?php else: ?>
<a href="/bookings.php" class="inline-flex w-full sm:min-w-[120px] items-center justify-center rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold transition-transform hover:scale-105 active:scale-95 shadow-lg shadow-primary/20">Book Now</a>
<?php endif; ?>
</div>
</div>
<?php endforeach; ?>
<?php else: ?>
<div class="mt-2 p-8 rounded-xl bg-white/5 dark:bg-white/5 border border-primary/10 text-center">
<p class="text-slate-500 dark:text-slate-400 mb-4">No upcoming dates announced yet. Check back soon.</p>
<a href="/bookings.php" class="inline-flex px-6 py-3 bg-primary text-white font-bold rounded-lg hover:scale-105 transition-transform">Enquire About Booking</a>
</div>
<?php endif; ?>

<?php if (!empty($past)): ?>
<details class="mt-8 group">
<summary class="cursor-pointer text-slate-500 dark:text-slate-400 text-sm font-medium hover:text-primary py-2">Past Shows (<?= count($past) ?>)</summary>
<div class="flex flex-col gap-2 pt-2">
<?php foreach ($past as $event): ?>
<div class="flex items-center gap-4 py-2 border-b border-slate-200/50 dark:border-slate-700/50 last:border-0">
<div class="shrink-0 w-12 text-center">
<span class="text-slate-500 text-xs font-bold"><?= format_date($event['event_date'], 'j') ?></span>
<span class="block text-slate-500 text-[10px]"><?= format_date($event['event_date'], 'M') ?></span>
</div>
<p class="text-slate-500 dark:text-slate-400 text-sm"><?= e($event['title']) ?> — <?= e($event['venue']) ?><?= $event['venue_city'] ? ', ' . e($event['venue_city']) : '' ?></p>
</div>
<?php endforeach; ?>
</div>
</details>
<?php endif; ?>
</div>
</main>
<!-- Bottom Nav -->
<nav class="fixed bottom-0 left-0 right-0 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-lg border-t border-primary/10 px-4 pb-4 pt-2 flex justify-between items-center z-50">
<a class="flex flex-col items-center gap-1 group flex-1" href="/">
<span class="material-symbols-outlined text-slate-500 dark:text-slate-400 group-hover:text-primary transition-colors">home</span>
<span class="text-[10px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400 group-hover:text-primary">Home</span>
</a>
<a class="flex flex-col items-center gap-1 group flex-1" href="/live.php">
<span class="material-symbols-outlined text-primary">confirmation_number</span>
<span class="text-[10px] font-bold uppercase tracking-widest text-primary">Tour</span>
</a>
<a class="flex flex-col items-center gap-1 group flex-1" href="/media.php">
<span class="material-symbols-outlined text-slate-500 dark:text-slate-400 group-hover:text-primary transition-colors">play_circle</span>
<span class="text-[10px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400 group-hover:text-primary">Videos</span>
</a>
<a class="flex flex-col items-center gap-1 group flex-1" href="/about.php">
<span class="material-symbols-outlined text-slate-500 dark:text-slate-400 group-hover:text-primary transition-colors">person</span>
<span class="text-[10px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400 group-hover:text-primary">About</span>
</a>
</nav>
</div>
</body>
</html>
