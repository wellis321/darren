<?php
$currentPage = 'legal';
$pageTitle = 'Privacy Policy';
$metaDescription = 'Privacy policy for darrenconnell.com. How we collect, use and protect your data.';

$legalContent = <<<'HTML'
<p class="text-sm text-slate-500 dark:text-slate-400">Last updated: <?= date('F j, Y') ?></p>

<h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mt-8">1. Who we are</h2>
<p>This website is operated by Darren Connell. We are committed to protecting your personal information.</p>

<h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mt-8">2. Information we collect</h2>
<p>We may collect:</p>
<ul class="list-disc pl-6 space-y-1">
    <li><strong>Contact details</strong> – Name, email, phone when you submit a booking enquiry or contact form</li>
    <li><strong>Newsletter signups</strong> – Email address when you subscribe to updates</li>
    <li><strong>Popup signups</strong> – Email when you sign up via a site popup</li>
    <li><strong>Technical data</strong> – IP address, browser type, pages visited (via cookies – see our Cookie Policy)</li>
</ul>

<h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mt-8">3. How we use your information</h2>
<p>We use your data to:</p>
<ul class="list-disc pl-6 space-y-1">
    <li>Respond to booking and contact enquiries</li>
    <li>Send newsletter updates about tours, merchandise and news (with your consent)</li>
    <li>Improve the website and user experience</li>
    <li>Comply with legal obligations</li>
</ul>

<h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mt-8">4. Legal basis</h2>
<p>We process your data on the basis of: consent (newsletter, popup signups), contract (enquiries), and legitimate interests (website operation).</p>

<h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mt-8">5. Sharing your data</h2>
<p>We do not sell your personal data. We may share it with service providers (e.g. hosting, email) only as needed to run this site. We require them to protect your data.</p>

<h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mt-8">6. Data retention</h2>
<p>We keep your data only as long as necessary – e.g. enquiries for the duration of the relationship, newsletter data until you unsubscribe.</p>

<h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mt-8">7. Your rights</h2>
<p>You have the right to access, correct, or delete your personal data, and to withdraw consent. Contact us via the <a href="/bookings.php" class="text-primary hover:underline">Bookings</a> page.</p>

<h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mt-8">8. Changes</h2>
<p>We may update this policy from time to time. The latest version will always be on this page.</p>
HTML;

$legalContent = str_replace('<?= date(\'F j, Y\') ?>', date('F j, Y'), $legalContent);
require __DIR__ . '/../includes/legal-layout.php';
