#!/usr/bin/env php
<?php
/**
 * Build a flat deployment for Hostinger (document root = single folder).
 * Run: php build-flat-deploy.php
 * Upload the contents of deploy/ to your Hostinger document root.
 */
$root = __DIR__;
$deploy = $root . '/deploy';

if (is_dir($deploy)) {
    passthru('rm -rf ' . escapeshellarg($deploy));
}
mkdir($deploy, 0755, true);

$copy = function ($src, $dst = null) use ($root, $deploy) {
    $dst = $dst ?? $src;
    $from = $root . '/' . $src;
    $to = $deploy . '/' . $dst;
    if (is_file($from)) {
        @mkdir(dirname($to), 0755, true);
        copy($from, $to);
    } elseif (is_dir($from)) {
        $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($from, RecursiveDirectoryIterator::SKIP_DOTS));
        foreach ($it as $f) {
            $rel = substr($f->getPathname(), strlen($from) + 1);
            $target = $to . '/' . $rel;
            if ($f->isDir()) {
                @mkdir($target, 0755, true);
            } else {
                @mkdir(dirname($target), 0755, true);
                copy($f->getPathname(), $target);
            }
        }
    }
};

// Public folder contents → deploy root
$copy('public/index.php');
$copy('public/admin', 'admin');
$copy('public/api', 'api');
$copy('public/assets', 'assets');
$copy('public/sitemap.xml.php');
$copy('public/llms.txt.php');
$copy('public/ai.txt.php');
$copy('public/robots.txt');
$copy('public/check.php');
if (file_exists($root . '/public/.htaccess')) {
    $copy('public/.htaccess');
}
if (file_exists($root . '/public/.htaccess.minimal')) {
    $copy('public/.htaccess.minimal');
}

// Config, includes, pages → deploy root
$copy('config', 'config');
$copy('includes', 'includes');
$copy('pages', 'pages');

// .env.example for reference (user adds .env manually)
$copy('.env.example');

echo "Built flat deployment in deploy/\n";
echo "Next steps:\n";
echo "1. Create deploy/.env with your production settings\n";
echo "2. Upload everything inside deploy/ to your Hostinger document root\n";
echo "3. Set permissions: 755 dirs, 644 files\n";
