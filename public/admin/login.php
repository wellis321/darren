<?php
require_once __DIR__ . '/bootstrap.php';

if (isLoggedIn()) {
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Location: /admin/index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        $stmt = $pdo->prepare("SELECT id, password_hash FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = $user['id'];
            header('Cache-Control: no-store, no-cache, must-revalidate');
            header('Location: /admin/index.php');
            exit;
        }
    }
    $error = 'Invalid email or password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Login - Darren Connell</title>
    <?php $cssPath = (defined('BASE_PATH') ? BASE_PATH : '') . '/assets/css/style.css'; $cssFile = dirname(__DIR__) . '/assets/css/style.css'; $cssV = file_exists($cssFile) ? filemtime($cssFile) : time(); ?>
    <link rel="preload" href="<?= e($cssPath) ?>?v=<?= $cssV ?>" as="style">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e($cssPath) ?>?v=<?= $cssV ?>">
</head>
<body class="admin-body">
    <div class="admin-login">
        <h1>Admin Login</h1>
        <?php if (!empty($_GET['reset'])): ?><p class="flash flash-success">Password updated. You can log in with your new password.</p><?php endif; ?>
        <?php if (!empty($error)): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
        <form method="post" class="admin-form">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Log In</button>
            <p class="login-hint" style="margin-top:0.75rem;"><a href="forgot-password.php">Forgot password?</a></p>
        </form>
    </div>
</body>
</html>
