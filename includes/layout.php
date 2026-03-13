<?php
$currentPage = $currentPage ?? 'home';
$pageTitle = ($pageTitle ?? 'Darren Connell') . ' | Comedian & Actor';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= e($metaDescription ?? 'Darren Connell - Scottish comedian, actor and BAFTA-nominated star of Scot Squad. Book tickets, watch clips, and stay updated.') ?>">
    <title><?= e($pageTitle) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Source+Sans+3:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header class="site-header">
        <a href="/" class="logo">Darren Connell</a>
        <button class="nav-toggle" aria-label="Menu" type="button">
            <span></span><span></span><span></span>
        </button>
        <nav class="main-nav">
            <a href="/" class="<?= $currentPage === 'home' ? 'active' : '' ?>">Home</a>
            <a href="/about.php" class="<?= $currentPage === 'about' ? 'active' : '' ?>">About</a>
            <a href="/live.php" class="<?= $currentPage === 'live' ? 'active' : '' ?>">Live Dates</a>
            <a href="/media.php" class="<?= $currentPage === 'media' ? 'active' : '' ?>">Video & Media</a>
            <a href="/podcast.php" class="<?= $currentPage === 'podcast' ? 'active' : '' ?>">Podcast</a>
            <a href="/bookings.php" class="<?= $currentPage === 'bookings' ? 'active' : '' ?>">Bookings</a>
        </nav>
    </header>
    <main class="main-content">
        <?php if ($flash = flash('success')): ?>
            <div class="flash flash-success"><?= e($flash) ?></div>
        <?php endif; ?>
        <?php if ($flash = flash('error')): ?>
            <div class="flash flash-error"><?= e($flash) ?></div>
        <?php endif; ?>
        <?= $content ?? '' ?>
    </main>
    <footer class="site-footer">
        <div class="footer-inner">
            <p>&copy; <?= date('Y') ?> Darren Connell. All rights reserved.</p>
            <p class="footer-disclaimer">This site does not handle personal requests for autographs or video messages. For professional bookings, please use the contact form.</p>
            <a href="/admin/" class="admin-link">Admin</a>
        </div>
    </footer>
    <script src="/assets/js/main.js"></script>
</body>
</html>
