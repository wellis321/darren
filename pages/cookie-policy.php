<?php
$currentPage = 'legal';
$pageTitle = 'Cookie Policy';
$metaDescription = 'Cookie policy for darrenconnell.com. How we use cookies and similar technologies.';

$legalContent = <<<'HTML'
<p class="text-sm text-slate-500 dark:text-slate-400">Last updated: <?= date('F j, Y') ?></p>

<h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mt-8">1. What are cookies?</h2>
<p>Cookies are small text files stored on your device when you visit a website. They help the site remember your preferences and improve your experience.</p>

<h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mt-8">2. Cookies we use</h2>

<h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mt-4">Strictly necessary</h3>
<p>These are required for the site to work:</p>
<ul class="list-disc pl-6 space-y-1">
    <li><strong>Session cookie</strong> – Keeps you logged in and helps with form security (CSRF protection). Deleted when you close your browser.</li>
</ul>

<h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mt-4">Functional</h3>
<p>These improve your experience:</p>
<ul class="list-disc pl-6 space-y-1">
    <li><strong>Popup dismissal</strong> – We use <code class="bg-slate-200 dark:bg-slate-700 px-1 rounded">sessionStorage</code> (not a cookie) to remember when you've dismissed a site popup, so it doesn't show again during your visit.</li>
</ul>

<h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mt-4">Third‑party</h3>
<p>We may embed content from services like YouTube. These may set their own cookies. See their privacy policies for details.</p>

<h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mt-8">3. Managing cookies</h2>
<p>You can control cookies via your browser settings. Blocking strictly necessary cookies may affect how the site works (e.g. form submission, admin login).</p>

<h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mt-8">4. Changes</h2>
<p>We may update this policy. The latest version will be on this page.</p>
HTML;

$legalContent = str_replace('<?= date(\'F j, Y\') ?>', date('F j, Y'), $legalContent);
require __DIR__ . '/../includes/legal-layout.php';
