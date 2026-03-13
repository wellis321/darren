<?php
$currentPage = 'about';
$stmt = $pdo->query("SELECT slug, title, body, meta_description FROM content WHERE slug IN ('about','about_quote','about_intro','about_journey','about_comedy_style','about_personal')");
$content = [];
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    $content[$row['slug']] = $row;
}
$pageTitle = $content['about']['title'] ?? 'About Darren';
$metaDescription = $content['about']['meta_description'] ?? 'Learn about Darren Connell - Scottish comedian and BAFTA-nominated actor.';
$defaults = [
    'about_quote' => '"Truthful and very funny."',
    'about_intro' => 'Hailing from Glasgow, Darren has taken the comedy scene by storm with his raw, high-energy style and relatable storytelling.',
    'about_journey' => 'From open mic nights in dusty Glasgow basements to the bright lights of the Edinburgh Fringe. Darren\'s rise wasn\'t accidental—it was forged in the fires of honest observation and a relentless work ethic. Best known for his breakout role as Bobby in the BBC hit Scot Squad, he\'s proven he can command both the screen and the stage.',
    'about_comedy_style' => 'High-octane, unfiltered, and unapologetically Glaswegian. Darren\'s comedy doesn\'t just ask for a laugh—it demands one. He finds the absurdity in the everyday and the heartbreak in the hilarious.',
    'about_personal' => 'When he\'s not making people howl with laughter, Darren is a passionate advocate for mental health and staying grounded in his roots. He\'s a man of the people, for the people, usually found with a coffee in hand planning his next big move.',
];
$c = function($key) use ($content, $defaults) {
    $row = $content[$key] ?? null;
    $body = ($row && $row['body'] !== null && $row['body'] !== '') ? trim($row['body']) : null;
    return $body ?? ($defaults[$key] ?? null);
};
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
<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 antialiased">
<?php require __DIR__ . '/../includes/navbar-stitch.php'; ?>
<div class="relative flex min-h-screen flex-col overflow-x-hidden">
<main id="main-content" class="flex-grow">
<div class="px-4 py-6">
<div class="bg-cover bg-center flex flex-col justify-end overflow-hidden rounded-xl min-h-[450px] relative group" style="background-image: linear-gradient(to top, rgba(34, 22, 16, 0.9) 0%, rgba(34, 22, 16, 0.4) 30%, rgba(34, 22, 16, 0) 100%), url('<?= BASE_PATH ?>/assets/images/darrenconnell_wideimage.jpg');">
<div class="flex flex-col p-6 space-y-2">
<span class="bg-primary text-white text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full w-fit">Glasgow's Own</span>
<h1 class="text-white text-4xl md:text-6xl font-bold leading-none tracking-tighter">Darren <br/>Connell</h1>
</div>
</div>
</div>
<section class="px-4 py-8 max-w-4xl mx-auto -mt-6">
<?php if ($c('about_quote')): ?>
<div class="inline-block bg-primary/20 border border-primary/30 px-3 py-1 rounded text-primary text-sm font-bold mb-4 italic">
    <?= e($c('about_quote')) ?>
</div>
<?php endif; ?>
<?php if ($c('about_intro')): ?>
<p class="text-xl md:text-2xl font-medium leading-snug mb-6 text-slate-800 dark:text-slate-200">
    <?= nl2br(e($c('about_intro'))) ?>
</p>
<?php endif; ?>
</section>
<section class="px-4 py-8 space-y-12 max-w-4xl mx-auto">
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
<div class="space-y-4">
<div class="flex items-center gap-3 text-primary">
<span class="material-symbols-outlined font-bold">route</span>
<h3 class="text-2xl font-bold uppercase tracking-tight">The Journey</h3>
</div>
<?php if ($c('about_journey')): ?>
<p class="text-slate-600 dark:text-slate-400 leading-relaxed">
    <?= nl2br(e($c('about_journey'))) ?>
</p>
<?php endif; ?>
</div>
<div class="bg-primary/5 rounded-xl p-6 border border-primary/10">
<span class="material-symbols-outlined text-primary text-4xl mb-4">mic_external_on</span>
<h4 class="text-xl font-bold mb-2">The Comedy Style</h4>
<?php if ($c('about_comedy_style')): ?>
<p class="text-slate-600 dark:text-slate-400">
    <?= nl2br(e($c('about_comedy_style'))) ?>
</p>
<?php endif; ?>
</div>
</div>
<div class="bg-slate-900 dark:bg-black rounded-2xl overflow-hidden border border-slate-800">
<div class="p-8 flex flex-col md:flex-row gap-8 items-center">
<div class="flex-1 space-y-4">
<div class="flex items-center gap-2">
<span class="inline-block w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
<span class="text-xs font-bold uppercase tracking-widest text-slate-400">Podcast Spotlight</span>
</div>
<h3 class="text-3xl font-bold text-white leading-tight">Glaswegians Anonymous</h3>
<p class="text-slate-400">
    Currently topping charts and rattling cages, Darren's podcast is a deep dive into the psyche of the city's most colorful characters. No topic is off-limits.
</p>
<a href="/podcast.php" class="inline-flex bg-primary hover:bg-primary/90 text-white font-bold py-3 px-8 rounded-full items-center gap-2 transition-all">
<span class="material-symbols-outlined">play_circle</span>
    Listen Now
</a>
</div>
<img alt="Glaswegians Anonymous Podcast" class="w-full md:w-48 aspect-square rounded-xl object-cover" src="<?= BASE_PATH ?>/assets/images/glaswegians-logo-dark.jpg"/>
</div>
</div>
<?php if ($c('about_personal')): ?>
<div class="space-y-4">
<div class="flex items-center gap-3 text-primary">
<span class="material-symbols-outlined font-bold">favorite</span>
<h3 class="text-2xl font-bold uppercase tracking-tight">Personal Life</h3>
</div>
<p class="text-slate-600 dark:text-slate-400 leading-relaxed max-w-2xl">
    <?= nl2br(e($c('about_personal'))) ?>
</p>
</div>
<?php endif; ?>
</section>
<div class="h-24"></div>
</main>
<?php require __DIR__ . '/../includes/footer-stitch.php'; ?>
<nav class="fixed bottom-0 left-0 right-0 z-50 flex border-t border-primary/20 bg-background-light dark:bg-background-dark px-4 pb-6 pt-3 shadow-2xl md:hidden">
<a class="flex flex-1 flex-col items-center justify-center gap-1 text-slate-500 dark:text-slate-400 hover:text-primary transition-colors" href="/">
<span class="material-symbols-outlined">home</span>
<p class="text-[10px] font-bold uppercase tracking-wider">Home</p>
</a>
<a class="flex flex-1 flex-col items-center justify-center gap-1 text-primary" href="/about.php">
<span class="material-symbols-outlined">person</span>
<p class="text-[10px] font-bold uppercase tracking-wider">About</p>
</a>
<a class="flex flex-1 flex-col items-center justify-center gap-1 text-slate-500 dark:text-slate-400 hover:text-primary transition-colors" href="/live.php">
<span class="material-symbols-outlined">confirmation_number</span>
<p class="text-[10px] font-bold uppercase tracking-wider">Shows</p>
</a>
<a class="flex flex-1 flex-col items-center justify-center gap-1 text-slate-500 dark:text-slate-400 hover:text-primary transition-colors" href="/podcast.php">
<span class="material-symbols-outlined">mic</span>
<p class="text-[10px] font-bold uppercase tracking-wider">Podcast</p>
</a>
</nav>
</div>
</body>
</html>
