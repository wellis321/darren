#!/usr/bin/env php
<?php
/**
 * Build Hostinger upload package (document root = public_html/public).
 * Run: php build-hostinger.php
 * Upload the CONTENTS of hostinger-upload/ to public_html/
 * (so public_html/public/, public_html/config/, etc. are created)
 */
$root = __DIR__;
$out = $root . '/hostinger-upload';

if (is_dir($out)) {
    array_map('unlink', glob("$out/public/*"));
    array_map(function ($d) { if (is_dir($d)) @rmdir($d); }, glob("$out/public/*"));
    @rmdir("$out/public");
    @rmdir("$out/config");
    @rmdir("$out/includes");
    @rmdir("$out/pages");
}
@mkdir("$out/public", 0755, true);
@mkdir("$out/config", 0755, true);
@mkdir("$out/includes", 0755, true);
@mkdir("$out/pages", 0755, true);

$copyDir = function ($src, $dst) use ($root, $out) {
    $from = $root . '/' . $src;
    $to = $out . '/' . $dst;
    if (!is_dir($from)) return;
    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($from, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
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
};

$copyFile = function ($src, $dst = null) use ($root, $out) {
    $dst = $dst ?? basename($src);
    $from = $root . '/' . $src;
    $to = $out . '/' . $dst;
    if (file_exists($from)) {
        @mkdir(dirname($to), 0755, true);
        copy($from, $to);
    }
};

// public/ → hostinger-upload/public/
$copyDir('public', 'public');

// config, includes, pages
$copyDir('config', 'config');
$copyDir('includes', 'includes');
$copyDir('pages', 'pages');

// .env.example (user renames to .env and fills in)
$copyFile('.env.example', '.env.example');

echo "Built hostinger-upload/\n\n";
echo "Upload to Hostinger:\n";
echo "1. Open File Manager → public_html/\n";
echo "2. Delete or empty the existing public/ folder (if it has old files)\n";
echo "3. Upload the CONTENTS of hostinger-upload/ into public_html/\n";
echo "   (So you get: public_html/public/, public_html/config/, public_html/includes/, public_html/pages/)\n";
echo "4. In public_html/, create .env (copy from .env.example) with production values\n";
echo "5. Permissions: 755 dirs, 644 files\n";
