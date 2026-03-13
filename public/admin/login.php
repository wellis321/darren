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
    <?php $cssPath = '/assets/css/style.css'; $cssFile = dirname(__DIR__) . $cssPath; $cssV = file_exists($cssFile) ? filemtime($cssFile) : time(); ?>
    <link rel="preload" href="<?= e($cssPath) ?>?v=<?= $cssV ?>" as="style">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e($cssPath) ?>?v=<?= $cssV ?>">
</head>
<body class="admin-body">
    <div class="admin-login">
        <h1>Admin Login</h1>
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
        </form>
        <p class="login-hint">Default: admin@darrenconnell.com / changeme123</p>
    </div>
</body>
</html>
