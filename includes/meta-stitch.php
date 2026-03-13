<?php
/**
 * SEO meta tags: description, canonical, Open Graph, Twitter Card, JSON-LD.
 * Expects: $pageTitle, $metaDescription. Optional: $metaImage, $canonicalPath, $jsonLdEvents
 */
$baseUrl = rtrim(function_exists('env') ? env('APP_URL', 'http://localhost:8001') : 'http://localhost:8001', '/');
$canonicalPath = $canonicalPath ?? (parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');
$canonicalUrl = $baseUrl . $canonicalPath;
$metaImage = $metaImage ?? $baseUrl . (defined('BASE_PATH') ? BASE_PATH : '') . '/assets/images/darren__banner.png';
$fullTitle = $fullTitle ?? (($pageTitle ?? 'Darren Connell') . ' | Darren Connell');
?>
<meta name="description" content="<?= e($metaDescription ?? 'Darren Connell - Scottish comedian, actor and BAFTA-nominated star of Scot Squad. Book tickets, watch clips, and stay updated.') ?>">
<link rel="canonical" href="<?= e($canonicalUrl) ?>">
<meta property="og:type" content="website">
<meta property="og:title" content="<?= e($fullTitle) ?>">
<meta property="og:description" content="<?= e($metaDescription ?? 'Darren Connell - Scottish comedian, actor and BAFTA-nominated star of Scot Squad.') ?>">
<meta property="og:url" content="<?= e($canonicalUrl) ?>">
<meta property="og:image" content="<?= e($metaImage) ?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:site_name" content="Darren Connell">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= e($fullTitle) ?>">
<meta name="twitter:description" content="<?= e($metaDescription ?? 'Darren Connell - Scottish comedian, actor and BAFTA-nominated star of Scot Squad.') ?>">
<meta name="twitter:image" content="<?= e($metaImage) ?>">
<?php
$jsonLdGraph = [
    [
        '@type' => 'Person',
        '@id' => $baseUrl . '/#person',
        'name' => 'Darren Connell',
        'url' => $baseUrl,
        'jobTitle' => 'Comedian & Actor',
        'description' => 'Scottish comedian, actor and BAFTA-nominated star of Scot Squad. Stand-up comedy, podcasts and live performances across the UK.',
        'image' => $baseUrl . (defined('BASE_PATH') ? BASE_PATH : '') . '/assets/images/darren.png',
        'sameAs' => [
            'https://www.instagram.com/darrenconnellcomedian/',
            'https://www.facebook.com/darren.connell.77/',
            'https://www.tiktok.com/@darrenconnellcomedian'
        ]
    ],
    [
        '@type' => 'WebSite',
        '@id' => $baseUrl . '/#website',
        'url' => $baseUrl,
        'name' => 'Darren Connell',
        'publisher' => ['@id' => $baseUrl . '/#person'],
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => ['@type' => 'EntryPoint', 'urlTemplate' => $baseUrl . '/search.php?q={search_term_string}'],
            'query-input' => 'required name=search_term_string'
        ]
    ]
];
if (!empty($jsonLdEvents) && is_array($jsonLdEvents)) {
    foreach ($jsonLdEvents as $ev) {
        $loc = ['@type' => 'Place', 'name' => $ev['venue'] ?? ''];
        if (!empty($ev['venue_city'])) {
            $loc['address'] = ['@type' => 'PostalAddress', 'addressLocality' => $ev['venue_city']];
        }
        $event = [
            '@type' => 'Event',
            'name' => $ev['title'] ?? '',
            'startDate' => ($ev['event_date'] ?? '') . 'T' . ($ev['event_time'] ?? '19:00:00'),
            'location' => $loc
        ];
        if (!empty($ev['ticket_url'])) $event['url'] = $ev['ticket_url'];
        $jsonLdGraph[] = $event;
    }
}
?>
<script type="application/ld+json"><?= json_encode(['@context' => 'https://schema.org', '@graph' => $jsonLdGraph], JSON_UNESCAPED_SLASHES) ?></script>
