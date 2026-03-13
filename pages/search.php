<?php
$currentPage = 'search';
$q = trim($_GET['q'] ?? '');
$results = ['events' => [], 'content' => []];

if (strlen($q) >= 2) {
    $term = '%' . $q . '%';
    $stmt = $pdo->prepare("SELECT id, title, venue, venue_city, event_date, ticket_url FROM events WHERE event_date >= CURDATE() AND (title LIKE ? OR venue LIKE ? OR venue_city LIKE ? OR description LIKE ?) ORDER BY event_date ASC LIMIT 10");
    $stmt->execute([$term, $term, $term, $term]);
    $results['events'] = $stmt->fetchAll();

    $stmt = $pdo->prepare("SELECT slug, title, body FROM content WHERE (title LIKE ? OR body LIKE ?) AND slug NOT LIKE 'about_%' LIMIT 5");
    $stmt->execute([$term, $term]);
    $results['content'] = $stmt->fetchAll();
}

$pageTitle = $q ? "Search: " . e($q) : 'Search';
$metaDescription = $q ? "Search results for " . e($q) : 'Search the site';
?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta name="description" content="<?= e($metaDescription) ?>">
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
                fontFamily: { "display": ["Space Grotesk", "sans-serif"] },
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
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen">
<?php require __DIR__ . '/../includes/navbar-stitch.php'; ?>
<main class="max-w-3xl mx-auto px-4 py-12">
<h1 class="text-2xl font-bold font-display mb-6"><?= $q ? 'Search results' : 'Search' ?></h1>
<?php if (!$q): ?>
<form action="/search.php" method="get" class="mb-8">
<div class="flex gap-2">
<input type="search" name="q" placeholder="Search events, content..." class="flex-1 bg-white dark:bg-primary/5 border border-slate-200 dark:border-primary/20 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary outline-none" autofocus>
<button type="submit" class="px-6 py-3 bg-primary text-white font-bold rounded-lg hover:bg-primary/90 transition-colors flex items-center gap-2">
<span class="material-symbols-outlined">search</span> Search
</button>
</div>
</form>
<?php else: ?>
<form action="/search.php" method="get" class="mb-8">
<div class="flex gap-2 mb-8">
<input type="search" name="q" value="<?= e($q) ?>" placeholder="Search..." class="flex-1 bg-white dark:bg-primary/5 border border-slate-200 dark:border-primary/20 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary outline-none">
<button type="submit" class="px-6 py-3 bg-primary text-white font-bold rounded-lg hover:bg-primary/90 transition-colors">Search</button>
</div>
</form>

<?php if (!empty($results['events']) || !empty($results['content'])): ?>
<?php if (!empty($results['events'])): ?>
<section class="mb-10">
<h2 class="text-lg font-bold text-primary mb-4">Upcoming Events</h2>
<div class="space-y-3">
<?php foreach ($results['events'] as $e): ?>
<a href="/live.php" class="block p-4 rounded-xl bg-white dark:bg-white/5 border border-primary/10 hover:border-primary/30 transition-colors">
<p class="font-bold text-slate-900 dark:text-slate-100"><?= e($e['title']) ?> — <?= e($e['venue']) ?></p>
<p class="text-sm text-slate-500"><?= format_date($e['event_date']) ?><?= $e['venue_city'] ? ' · ' . e($e['venue_city']) : '' ?></p>
</a>
<?php endforeach; ?>
</div>
</section>
<?php endif; ?>
<?php if (!empty($results['content'])): ?>
<section>
<h2 class="text-lg font-bold text-primary mb-4">Pages</h2>
<div class="space-y-3">
<?php foreach ($results['content'] as $c): ?>
<a href="<?= $c['slug'] === 'about' ? '/about.php' : '#' ?>" class="block p-4 rounded-xl bg-white dark:bg-white/5 border border-primary/10 hover:border-primary/30 transition-colors">
<p class="font-bold text-slate-900 dark:text-slate-100"><?= e($c['title']) ?></p>
<p class="text-sm text-slate-500 line-clamp-2"><?= e(mb_substr(strip_tags($c['body']), 0, 120)) ?>…</p>
</a>
<?php endforeach; ?>
</div>
</section>
<?php endif; ?>
<?php else: ?>
<p class="text-slate-500 dark:text-slate-400">No results found for &ldquo;<?= e($q) ?>&rdquo;. Try a different search term.</p>
<?php endif; ?>
<?php endif; ?>
</main>
</body>
</html>
