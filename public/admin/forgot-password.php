<?php
require_once __DIR__ . '/bootstrap.php';

if (isLoggedIn()) {
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Location: /admin/index.php');
    exit;
}

$sent = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    if (!$email) {
        $error = 'Please enter a valid email address.';
    } else {
        $stmt = $pdo->prepare("SELECT id, name FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user) {
            try {
                $token = bin2hex(random_bytes(32));
                $tokenHash = hash('sha256', $token);
                $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));
                $stmt = $pdo->prepare("INSERT INTO password_reset_tokens (user_id, token_hash, expires_at) VALUES (?, ?, ?)");
                $stmt->execute([$user['id'], $tokenHash, $expiresAt]);
                $resetUrl = rtrim(env('APP_URL', 'http://localhost:8001'), '/') . '/admin/reset-password.php?token=' . $token;
                $siteName = 'Darren Connell Admin';
                $subject = "Reset your password - $siteName";
                $body = "Hi " . e($user['name']) . ",\n\n";
                $body .= "You requested a password reset. Click the link below to set a new password (valid for 1 hour):\n\n";
                $body .= $resetUrl . "\n\n";
                $body .= "If you didn't request this, you can ignore this email. Your password won't change.\n\n";
                $body .= "— $siteName";
                $headers = "From: " . (env('ADMIN_EMAIL', 'noreply@darrenconnell.com')) . "\r\n";
                $headers .= "Reply-To: " . (env('ADMIN_EMAIL', 'noreply@darrenconnell.com')) . "\r\n";
                $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
                @mail($email, $subject, $body, $headers);
                $sent = true;
            } catch (PDOException $e) {
                $error = 'Password reset is not set up. Please run sql/add-password-reset.sql and try again.';
            }
        } else {
            $sent = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Forgot Password - Darren Connell Admin</title>
    <?php $cssPath = '/assets/css/style.css'; $cssFile = dirname(__DIR__) . $cssPath; $cssV = file_exists($cssFile) ? filemtime($cssFile) : time(); ?>
    <link rel="preload" href="<?= e($cssPath) ?>?v=<?= $cssV ?>" as="style">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e($cssPath) ?>?v=<?= $cssV ?>">
</head>
<body class="admin-body">
    <div class="admin-login">
        <h1>Forgot Password</h1>
        <?php if ($sent): ?>
            <p class="flash flash-success">If that email is on file, we've sent a reset link. Check your inbox (and spam folder). The link expires in 1 hour.</p>
            <p><a href="login.php" class="btn btn-secondary">Back to Login</a></p>
        <?php else: ?>
            <?php if ($error): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
            <form method="post" class="admin-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= e($_POST['email'] ?? '') ?>" required autofocus>
                </div>
                <button type="submit" class="btn btn-primary">Send Reset Link</button>
            </form>
            <p class="login-hint"><a href="login.php">Back to Login</a></p>
        <?php endif; ?>
    </div>
</body>
</html>
