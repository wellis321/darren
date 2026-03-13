<?php
/**
 * Redirect root requests to /public/ when document root points at project root.
 * Preserves query string so every page does not land on home.
 * On Hostinger: set document root to public/ instead.
 */
$q = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== '' ? '?' . $_SERVER['QUERY_STRING'] : '';
header('Location: /public/' . ltrim($q, '/'), true, 302);
exit;
