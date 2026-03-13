<?php
/**
 * Load environment variables from .env file
 */
if (!defined('BASE_PATH')) {
    // When doc root is project root, assets/admin live under public/ — detect from script path
    $docRoot = rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/');
    $scriptDir = dirname($_SERVER['SCRIPT_FILENAME'] ?? '');
    define('BASE_PATH', ($docRoot !== '' && strpos($scriptDir, $docRoot . '/public') === 0) ? '/public' : '');
}
$envFile = dirname(__DIR__) . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value, " \t\n\r\0\x0B\"'");
            if (!array_key_exists($key, $_ENV)) {
                putenv("$key=$value");
                $_ENV[$key] = $value;
            }
        }
    }
}

function env($key, $default = null) {
    return $_ENV[$key] ?? getenv($key) ?: $default;
}
