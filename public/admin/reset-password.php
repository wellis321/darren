<?php
require_once __DIR__ . '/bootstrap.php';

if (isLoggedIn()) {
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Location: /admin/index.php');
    exit;
}

$token = trim($_GET['token'] ?? '');
$validToken = false;
$userId = null;
$error = '';

if (strlen($token) === 64 && ctype_xdigit($token)) {
    $tokenHash = hash('sha256', $token);
    $stmt = $pdo->prepare("SELECT prt.user_id FROM password_reset_tokens prt WHERE prt.token_hash = ? AND prt.expires_at > NOW()");
    $stmt->execute([$tokenHash]);
    $row = $stmt->fetch();
    if ($row) {
        $validToken = true;
        $userId = (int) $row['user_id'];
    }
}

if (!$validToken && $token) {
    $error = 'This reset link has expired or is invalid. Please request a new one.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $validToken) {
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['password_confirm'] ?? '';
    if (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        $stmt->execute([$hash, $userId]);
        $stmt = $pdo->prepare("DELETE FROM password_reset_tokens WHERE user_id = ?");
        $stmt->execute([$userId]);
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Location: /admin/login.php?reset=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Reset Password - Darren Connell Admin</title>
    <?php $cssPath = (defined('BASE_PATH') ? BASE_PATH : '') . '/assets/css/style.css'; $cssFile = dirname(__DIR__) . '/assets/css/style.css'; $cssV = file_exists($cssFile) ? filemtime($cssFile) : time(); ?>
    <link rel="preload" href="<?= e($cssPath) ?>?v=<?= $cssV ?>" as="style">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e($cssPath) ?>?v=<?= $cssV ?>">
</head>
<body class="admin-body">
    <div class="admin-login">
        <h1>Reset Password</h1>
        <?php if (!$validToken && !$token): ?>
            <p class="error">Missing reset token. Please use the link from your email or <a href="forgot-password.php">request a new one</a>.</p>
            <p><a href="login.php" class="btn btn-secondary">Back to Login</a></p>
        <?php elseif (!$validToken): ?>
            <p class="error"><?= e($error) ?></p>
            <p><a href="forgot-password.php" class="btn btn-primary">Request New Link</a></p>
            <p><a href="login.php" class="login-hint">Back to Login</a></p>
        <?php else: ?>
            <?php if ($error): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
            <form method="post" class="admin-form">
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" minlength="8" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password_confirm">Confirm Password</label>
                    <input type="password" id="password_confirm" name="password_confirm" minlength="8" required>
                </div>
                <button type="submit" class="btn btn-primary">Set New Password</button>
            </form>
            <p class="login-hint"><a href="login.php">Back to Login</a></p>
        <?php endif; ?>
    </div>
</body>
</html>
