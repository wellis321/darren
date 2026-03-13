<?php
session_start();
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('/');
}

if (!verify_csrf()) {
    flash('error', 'Invalid request. Please try again.');
    redirect($_SERVER['HTTP_REFERER'] ?? '/');
}

$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
if (!$email) {
    flash('error', 'Please enter a valid email address.');
    redirect($_SERVER['HTTP_REFERER'] ?? '/');
}

try {
    $stmt = $pdo->prepare("INSERT INTO newsletter_subscribers (email) VALUES (?)");
    $stmt->execute([$email]);
    flash('success', 'Thanks for subscribing! You\'ll hear from us soon.');
} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        flash('success', 'You\'re already on the list. Thanks!');
    } else {
        flash('error', 'Something went wrong. Please try again.');
    }
}
redirect($_SERVER['HTTP_REFERER'] ?? '/');
