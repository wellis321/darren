<?php
/**
 * When document root points at project root, run public/index.php directly.
 * No redirect — avoids ERR_TOO_MANY_REDIRECTS on Hostinger.
 * Assets live under public/ so we need BASE_PATH for correct URLs.
 */
define('BASE_PATH', '/public');
$_SERVER['SCRIPT_NAME'] = '/public/index.php';
chdir(__DIR__ . '/public');
require __DIR__ . '/public/index.php';
