<?php
/**
 * Session initialization with secure cookie params.
 * Require this instead of calling session_start() directly.
 */
require_once __DIR__ . '/env.php';

$isSecure = env('APP_ENV') === 'production';
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => $isSecure,
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();
