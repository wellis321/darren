<?php
/**
 * Dynamic sitemap - outputs XML for search engines.
 * Accessed as /sitemap.xml (configure server rewrite or route).
 */
header('Content-Type: application/xml; charset=utf-8');

$baseUrl = rtrim(function_exists('env') ? env('APP_URL', 'http://localhost:8001') : 'http://localhost:8001', '/');

$pages = [
    ['loc' => $baseUrl . '/', 'priority' => '1.0', 'changefreq' => 'weekly'],
    ['loc' => $baseUrl . '/about.php', 'priority' => '0.9', 'changefreq' => 'monthly'],
    ['loc' => $baseUrl . '/live.php', 'priority' => '0.9', 'changefreq' => 'weekly'],
    ['loc' => $baseUrl . '/media.php', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ['loc' => $baseUrl . '/podcast.php', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ['loc' => $baseUrl . '/bookings.php', 'priority' => '0.8', 'changefreq' => 'monthly'],
    ['loc' => $baseUrl . '/merch.php', 'priority' => '0.8', 'changefreq' => 'weekly'],
];

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($pages as $p): ?>
  <url>
    <loc><?= htmlspecialchars($p['loc']) ?></loc>
    <changefreq><?= $p['changefreq'] ?></changefreq>
    <priority><?= $p['priority'] ?></priority>
  </url>
<?php endforeach; ?>
</urlset>
