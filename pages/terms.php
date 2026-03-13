<?php
$currentPage = 'legal';
$pageTitle = 'Terms of Use';
$metaDescription = 'Terms of use for darrenconnell.com. Rules for using this website.';

$legalContent = <<<'HTML'
<p class="text-sm text-slate-500 dark:text-slate-400">Last updated: <?= date('F j, Y') ?></p>

<h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mt-8">1. Acceptance</h2>
<p>By using this website, you agree to these terms. If you do not agree, please do not use the site.</p>

<h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mt-8">2. Use of the site</h2>
<p>This site is for informational and promotional purposes relating to Darren Connell. You may browse, view content, and use contact/booking forms for their intended purpose. You must not:</p>
<ul class="list-disc pl-6 space-y-1">
    <li>Use the site for any unlawful purpose</li>
    <li>Attempt to gain unauthorised access to any part of the site or systems</li>
    <li>Transmit viruses, malware or harmful code</li>
    <li>Scrape, copy or republish content without permission</li>
</ul>

<h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mt-8">3. Ticket purchases and merchandise</h2>
<p>Ticket sales are handled by third-party vendors. Their terms apply to purchases. Merchandise links may direct you to external sellers. We are not responsible for third-party sites or transactions.</p>

<h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mt-8">4. Booking enquiries</h2>
<p>Submitting a booking enquiry does not create a binding contract. All bookings are subject to availability and separate agreement.</p>

<h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mt-8">5. Intellectual property</h2>
<p>All content on this site (text, images, branding) is owned by Darren Connell or licensors. You may not use it without written permission.</p>

<h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mt-8">6. Disclaimer</h2>
<p>This site is provided "as is". We do not guarantee uninterrupted access or that content is error-free. We are not liable for any loss arising from use of the site.</p>

<h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mt-8">7. Contact</h2>
<p>For questions about these terms, use the <a href="/bookings.php" class="text-primary hover:underline">Bookings</a> page.</p>
HTML;

$legalContent = str_replace('<?= date(\'F j, Y\') ?>', date('F j, Y'), $legalContent);
require __DIR__ . '/../includes/legal-layout.php';
