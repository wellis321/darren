<?php
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
$cssPath = (defined('BASE_PATH') ? BASE_PATH : '') . '/assets/css/style.css';
$cssFile = dirname(__DIR__) . '/assets/css/style.css';
$cssV = file_exists($cssFile) ? filemtime($cssFile) : time();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= e($pageTitle ?? 'Admin') ?> - Darren Connell</title>
    <link rel="preload" href="<?= e($cssPath) ?>?v=<?= $cssV ?>" as="style">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e($cssPath) ?>?v=<?= $cssV ?>">
</head>
<body class="admin-body">
    <aside class="admin-sidebar">
        <a href="index.php" class="admin-logo">Darren Connell</a>
        <nav class="admin-nav">
            <a href="index.php">Dashboard</a>
            <a href="events.php">Events</a>
            <a href="bookings.php">Bookings</a>
            <a href="content.php">Content</a>
            <a href="media.php">Media</a>
            <a href="podcast.php">Podcasts</a>
            <a href="testimonials.php">Testimonials</a>
            <a href="change-password.php">Change Password</a>
        </nav>
    </aside>
    <main class="admin-main">
        <?= $adminContent ?? '' ?>
    </main>
</body>
</html>
