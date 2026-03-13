<?php
$currentPage = $currentPage ?? 'home';
$pageTitle = ($pageTitle ?? 'Darren Connell') . ' | Comedian & Actor';
$useStitch = true; // Stitch project 3458059587571971262
?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= e($metaDescription ?? 'Darren Connell - Scottish comedian, actor and BAFTA-nominated star of Scot Squad. Book tickets, watch clips, and stay updated.') ?>">
    <title><?= e($pageTitle) ?></title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
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
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 antialiased">
<?php require __DIR__ . '/navbar-stitch.php'; ?>
<main>
    <?php if ($flash = flash('success')): ?>
    <div class="max-w-7xl mx-auto px-4 py-4">
        <div class="bg-green-500/20 border border-green-500/40 rounded-lg px-4 py-2 text-green-200"><?= e($flash) ?></div>
    </div>
    <?php endif; ?>
    <?php if ($flash = flash('error')): ?>
    <div class="max-w-7xl mx-auto px-4 py-4">
        <div class="bg-red-500/20 border border-red-500/40 rounded-lg px-4 py-2 text-red-200"><?= e($flash) ?></div>
    </div>
    <?php endif; ?>
    <?= $content ?? '' ?>
</main>
<footer class="border-t border-primary/10 py-8 mt-16">
    <div class="max-w-7xl mx-auto px-4 text-center text-slate-500 dark:text-slate-400 text-sm">
        <p>&copy; <?= date('Y') ?> Darren Connell. All rights reserved.</p>
        <p class="mt-2 opacity-80">This site does not handle personal requests for autographs or video messages.</p>
        <a href="/admin/" class="text-primary/70 hover:text-primary mt-2 inline-block text-xs">Admin</a>
    </div>
</footer>
<script src="/assets/js/main.js"></script>
</body>
</html>
