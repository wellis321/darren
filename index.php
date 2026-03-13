<?php
/**
 * When document root points at project root, run public/index.php directly.
 * No redirect — avoids ERR_TOO_MANY_REDIRECTS on Hostinger.
 * Prefer: set Hostinger document root to public/ instead.
 */
$_SERVER['SCRIPT_NAME'] = '/public/index.php';
chdir(__DIR__ . '/public');
require __DIR__ . '/public/index.php';
