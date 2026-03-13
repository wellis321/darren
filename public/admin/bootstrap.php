<?php
session_start();
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';

function requireAuth() {
    if (empty($_SESSION['admin_id'])) {
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Location: /admin/login.php');
        exit;
    }
}

function isLoggedIn() {
    return !empty($_SESSION['admin_id']);
}
