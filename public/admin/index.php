<?php
require_once __DIR__ . '/bootstrap.php';
requireAuth();

$pageTitle = 'Dashboard';
ob_start();
include __DIR__ . '/dashboard.php';
$adminContent = ob_get_clean();
include __DIR__ . '/layout.php';
