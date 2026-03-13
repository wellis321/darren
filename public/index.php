<?php
/**
 * Front controller - handles all requests
 * Run: cd public && php -S localhost:8001 index.php
 */
// Pass through existing static files
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$file = __DIR__ . $path;
if ($path !== '/' && file_exists($file) && is_file($file)) {
    return false;
}
// Pass through /admin and /api requests (let PHP serve those files)
if (strpos($path, '/admin') === 0 || strpos($path, '/api') === 0) {
    return false;
}
// Short-circuit favicon to avoid DB load and 500
if ($path === '/favicon.ico') {
    header('HTTP/1.1 204 No Content');
    exit;
}
// Redirect /public and /public/ to / (server root is already public)
if (preg_match('#^/public/?$#', parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH))) {
    header('Location: /', true, 301);
    exit;
}

session_start();
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/includes/functions.php';

// Parse request
$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$path = parse_url($requestUri, PHP_URL_PATH);
$path = $scriptName !== '/' ? str_replace($scriptName, '', $path) : $path;
$path = '/' . trim($path, '/');
if ($path === '/') $path = '/index';

// Route to appropriate handler
$routes = [
    '/' => 'index',
    '/index' => 'index',
    '/about' => 'about',
    '/about.php' => 'about',
    '/live' => 'live',
    '/live.php' => 'live',
    '/media' => 'media',
    '/media.php' => 'media',
    '/podcast' => 'podcast',
    '/podcast.php' => 'podcast',
    '/bookings' => 'bookings',
    '/bookings.php' => 'bookings',
    '/merch' => 'merch',
    '/merch.php' => 'merch',
    '/store' => 'merch',
    '/store.php' => 'merch',
    '/search' => 'search',
    '/search.php' => 'search',
];

$page = $routes[$path] ?? null;
if ($page) {
    ob_start();
    include dirname(__DIR__) . "/pages/{$page}.php";
    $content = ob_get_clean();
    // Index, merch, live, about, podcast, media, and bookings output full Stitch HTML (no layout wrapper)
    if (in_array($page, ['index', 'merch', 'live', 'about', 'podcast', 'media', 'bookings', 'search'])) {
        echo $content;
    } else {
        include dirname(__DIR__) . '/includes/layout-stitch.php';
    }
    exit;
}

// Static files - let PHP serve them
if (preg_match('/\.(css|js|jpg|jpeg|png|gif|ico|svg|woff2?)$/', $path)) {
    return false; // Let PHP built-in server handle
}

http_response_code(404);
include dirname(__DIR__) . '/includes/errors/404.php';
