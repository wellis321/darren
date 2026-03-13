<?php
/**
 * Shared layout for legal pages (privacy, terms, cookie policy)
 * Expects: $pageTitle, $metaDescription, $legalContent (HTML string)
 */
$currentPage = $currentPage ?? 'legal';
?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<?php require __DIR__ . '/meta-stitch.php'; ?>
<title><?= e($pageTitle) ?> | Darren Connell</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet"/>
<script id="tailwind-config">
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: { "primary": "#f46a25", "background-light": "#f8f6f5", "background-dark": "#221610" },
                fontFamily: { "display": ["Space Grotesk", "sans-serif"] },
            },
        },
    }
</script>
<style>body{font-family:'Space Grotesk',sans-serif;min-height:100vh}.material-symbols-outlined{font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24;font-family:'Material Symbols Outlined'}</style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 antialiased">
<?php require __DIR__ . '/navbar-stitch.php'; ?>
<main id="main-content" class="max-w-3xl mx-auto px-4 py-12 pb-24">
<a href="javascript:history.back()" class="inline-flex items-center gap-1 text-slate-500 dark:text-slate-400 hover:text-primary transition-colors mb-8">
    <span class="material-symbols-outlined text-xl">arrow_back</span> Back
</a>
<h1 class="text-3xl font-bold mb-8"><?= e($pageTitle) ?></h1>
<div class="prose prose-slate dark:prose-invert max-w-none space-y-6 text-slate-600 dark:text-slate-300">
<?= $legalContent ?>
</div>
</main>
<footer class="border-t border-primary/10 py-8 mt-16">
    <div class="max-w-7xl mx-auto px-4 text-center text-slate-500 dark:text-slate-400 text-sm">
        <p>&copy; <?= date('Y') ?> Darren Connell. All rights reserved.</p>
        <nav class="mt-2 flex items-center justify-center gap-2" aria-label="Legal">
        <a href="/privacy.php" class="text-slate-400 hover:text-primary transition-colors">Privacy</a>
        <span class="text-slate-500 dark:text-slate-600">·</span>
        <a href="/terms.php" class="text-slate-400 hover:text-primary transition-colors">Terms</a>
        <span class="text-slate-500 dark:text-slate-600">·</span>
        <a href="/cookie-policy.php" class="text-slate-400 hover:text-primary transition-colors">Cookies</a>
    </nav>
    </div>
</footer>
</body>
</html>
