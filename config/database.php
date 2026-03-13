<?php
/**
 * Database connection using PDO
 */
require_once __DIR__ . '/env.php';

$dbHost = env('DB_HOST', 'localhost');
$dbPort = '3306';
if (strpos($dbHost, ':') !== false) {
    list($dbHost, $dbPort) = explode(':', $dbHost, 2);
}
// Use 127.0.0.1 for TCP when port is non-standard (localhost often uses socket and ignores port)
if ($dbHost === 'localhost' && $dbPort !== '3306') {
    $dbHost = '127.0.0.1';
}

$dsn = sprintf(
    'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
    $dbHost,
    $dbPort,
    env('DB_NAME', 'darrenn')
);

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, env('DB_USER', 'root'), env('DB_PASS', 'root'), $options);
} catch (PDOException $e) {
    if (php_sapi_name() === 'cli') {
        die("Database connection failed: " . $e->getMessage() . "\n");
    }
    http_response_code(503);
    $dbError = $e->getMessage();
    include __DIR__ . '/../includes/errors/500.php';
    exit;
}
