<?php
/**
 * Helper functions
 */

function e($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

function format_date($date, $format = 'l j F Y') {
    if (!$date) return '';
    $dt = is_string($date) ? new DateTime($date) : $date;
    return $dt->format($format);
}

function format_time($time) {
    if (!$time) return '';
    $t = is_string($time) ? new DateTime($time) : $time;
    return $t->format('g:ia');
}

function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field() {
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function verify_csrf() {
    $token = $_POST['csrf_token'] ?? $_GET['csrf_token'] ?? '';
    return hash_equals($_SESSION['csrf_token'] ?? '', $token);
}

function redirect($url, $status = 302) {
    header("Location: $url", true, $status);
    exit;
}

/**
 * Redirect back to referer only if it's same-origin (prevents open redirect).
 */
function safe_redirect_back($fallback = '/') {
    $referer = $_SERVER['HTTP_REFERER'] ?? '';
    if ($referer !== '') {
        $refHost = parse_url($referer, PHP_URL_HOST);
        $reqHost = $_SERVER['HTTP_HOST'] ?? '';
        if ($refHost !== '' && strtolower($refHost) === strtolower($reqHost)) {
            redirect($referer);
        }
    }
    redirect($fallback);
}

function old($key, $default = '') {
    return $_SESSION['old'][$key] ?? $default;
}

function flash($key, $message = null) {
    if ($message === null) {
        $m = $_SESSION['flash'][$key] ?? null;
        unset($_SESSION['flash'][$key]);
        return $m;
    }
    $_SESSION['flash'][$key] = $message;
}
