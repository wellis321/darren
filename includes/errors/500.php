<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Required - Darren Connell</title>
</head>
<body style="font-family:sans-serif;padding:2rem;max-width:600px;margin:0 auto;">
    <h1>Setup Required</h1>
    <p>Unable to connect to the database. Please check:</p>
    <ol>
        <li>MySQL is running (e.g. MAMP on port 8889)</li>
        <li>The <code>darrenn</code> database exists — run <code>sql/schema.sql</code></li>
        <li>Your <code>.env</code> matches: DB_HOST=localhost:8889, DB_NAME=darrenn, DB_USER=root, DB_PASS=root</li>
    </ol>
    <?php if (!empty($dbError)): ?>
    <p style="padding:1rem;background:#fee;border-radius:4px;font-size:0.9rem;"><strong>Error:</strong> <?= htmlspecialchars($dbError) ?></p>
    <?php endif; ?>
    <p><a href="/">Try again</a></p>
</body>
</html>
