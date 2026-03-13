<?php
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once __DIR__ . '/bootstrap.php';
requireAuth();

$pageTitle = 'Change Password';
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf()) {
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['new_password_confirm'] ?? '';

    if (!$current || !$new || !$confirm) {
        $error = 'All fields are required.';
    } elseif (strlen($new) < 8) {
        $error = 'New password must be at least 8 characters.';
    } elseif ($new !== $confirm) {
        $error = 'New passwords do not match.';
    } else {
        $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['admin_id']]);
        $user = $stmt->fetch();
        if (!$user || !password_verify($current, $user['password_hash'])) {
            $error = 'Current password is incorrect.';
        } else {
            $hash = password_hash($new, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
            $stmt->execute([$hash, $_SESSION['admin_id']]);
            $message = 'Password updated successfully.';
        }
    }
}

ob_start();
?>
<div class="admin-header">
    <h1>Change Password</h1>
</div>
<?php if ($message): ?><p class="flash flash-success"><?= e($message) ?></p><?php endif; ?>
<?php if ($error): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
<form method="post" class="admin-form" style="max-width:400px;">
    <?= csrf_field() ?>
    <div class="form-group">
        <label for="current_password">Current Password</label>
        <input type="password" id="current_password" name="current_password" required autocomplete="current-password">
    </div>
    <div class="form-group">
        <label for="new_password">New Password</label>
        <input type="password" id="new_password" name="new_password" minlength="8" required autocomplete="new-password">
    </div>
    <div class="form-group">
        <label for="new_password_confirm">Confirm New Password</label>
        <input type="password" id="new_password_confirm" name="new_password_confirm" minlength="8" required autocomplete="new-password">
    </div>
    <button type="submit" class="btn btn-primary">Update Password</button>
</form>
<?php
$adminContent = ob_get_clean();
include __DIR__ . '/layout.php';
