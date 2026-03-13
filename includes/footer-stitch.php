<?php
/**
 * Unified site footer - include on all public pages.
 * Provides: page nav, social links, copyright, legal links.
 */
$footerBasePath = defined('BASE_PATH') ? BASE_PATH : '';
?>
<footer class="bg-slate-950 text-slate-400 py-12 pb-20 md:pb-12 border-t border-white/5">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col items-center text-center gap-10">
            <!-- Logo -->
            <a href="<?= $footerBasePath ?>/" class="flex items-center gap-2 text-primary hover:opacity-90 transition-opacity" aria-label="Home">
                <span class="material-symbols-outlined text-2xl">mic_external_on</span>
                <span class="text-white font-bold tracking-tight">DARREN <span class="text-primary">CONNELL</span></span>
            </a>

            <!-- Page nav - pill style matching site badges -->
            <nav class="flex flex-wrap justify-center gap-2" aria-label="Site navigation">
                <a href="<?= $footerBasePath ?>/" class="px-4 py-2 rounded-full bg-white/5 text-slate-300 hover:bg-primary hover:text-white font-semibold text-sm uppercase tracking-wider transition-all duration-200">Home</a>
                <a href="<?= $footerBasePath ?>/about.php" class="px-4 py-2 rounded-full bg-white/5 text-slate-300 hover:bg-primary hover:text-white font-semibold text-sm uppercase tracking-wider transition-all duration-200">About</a>
                <a href="<?= $footerBasePath ?>/live.php" class="px-4 py-2 rounded-full bg-white/5 text-slate-300 hover:bg-primary hover:text-white font-semibold text-sm uppercase tracking-wider transition-all duration-200">Tour Dates</a>
                <a href="<?= $footerBasePath ?>/merch.php" class="px-4 py-2 rounded-full bg-white/5 text-slate-300 hover:bg-primary hover:text-white font-semibold text-sm uppercase tracking-wider transition-all duration-200">Merch</a>
                <a href="<?= $footerBasePath ?>/podcast.php" class="px-4 py-2 rounded-full bg-white/5 text-slate-300 hover:bg-primary hover:text-white font-semibold text-sm uppercase tracking-wider transition-all duration-200">Podcast</a>
                <a href="<?= $footerBasePath ?>/media.php" class="px-4 py-2 rounded-full bg-white/5 text-slate-300 hover:bg-primary hover:text-white font-semibold text-sm uppercase tracking-wider transition-all duration-200">Media</a>
                <a href="<?= $footerBasePath ?>/bookings.php" class="px-4 py-2 rounded-full bg-white/5 text-slate-300 hover:bg-primary hover:text-white font-semibold text-sm uppercase tracking-wider transition-all duration-200">Bookings</a>
            </nav>

            <!-- Social icons -->
            <div class="flex gap-4">
                <a class="w-11 h-11 flex items-center justify-center rounded-full bg-primary/90 hover:bg-primary text-white hover:scale-110 transition-all duration-200" href="https://www.instagram.com/darrenconnellcomedian/?hl=en" target="_blank" rel="noopener" aria-label="Instagram"><svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                <a class="w-11 h-11 flex items-center justify-center rounded-full bg-primary/90 hover:bg-primary text-white hover:scale-110 transition-all duration-200" href="https://www.facebook.com/darren.connell.77/" target="_blank" rel="noopener" aria-label="Facebook"><svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                <a class="w-11 h-11 flex items-center justify-center rounded-full bg-primary/90 hover:bg-primary text-white hover:scale-110 transition-all duration-200" href="https://www.tiktok.com/@darrenconnellcomedian" target="_blank" rel="noopener" aria-label="TikTok"><svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12.53.02C13.84 0 15.14.01 16.44 0c.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.03 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.03-2.86-.31-4.13-1.03-2.28-1.3-3.48-3.92-2.91-6.47.28-1.25.96-2.42 1.94-3.23 1.25-1.04 2.89-1.64 4.52-1.62v4.14c-.6-.05-1.22.12-1.71.49-.63.48-.89 1.29-.75 2.06.13.71.74 1.28 1.45 1.39.73.1 1.5-.23 1.88-.86.33-.56.36-1.22.35-1.85V.02z"/></svg></a>
                <a class="w-11 h-11 flex items-center justify-center rounded-full bg-primary/90 hover:bg-primary text-white hover:scale-110 transition-all duration-200" href="https://www.threads.net/@darrenconnellcomedian" target="_blank" rel="noopener" aria-label="Threads"><svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12.186 24h-.007c-3.581-.024-6.334-1.205-8.184-3.509C2.35 18.44 1.5 15.586 1.472 12.01v-.017c.03-3.579.879-6.43 2.525-8.482C5.845 1.205 8.6.024 12.18 0h.014c2.746.02 5.043.725 6.826 2.098 1.677 1.29 2.858 3.13 3.509 5.467h-4.22c-.995-2.36-2.886-3.448-5.726-3.464h-.009c-2.926.02-5.194 1.061-6.705 3.078C4.858 9.862 4.166 11.967 4.14 12.004v.018c.027.037.717 2.154 2.246 3.894 1.511 2.016 3.779 3.057 6.705 3.077h.009c2.84-.016 4.731-1.104 5.726-3.464h4.22c-.651 2.338-1.832 4.177-3.509 5.467-1.783 1.373-4.08 2.078-6.826 2.098zM20 17.754v.017c0 1.938-.548 3.652-1.618 5.078-.992 1.32-2.358 2.301-4.053 2.91-1.658.593-3.565.895-5.659.895h-.014c-2.095 0-4.001-.302-5.659-.895-1.695-.609-3.061-1.59-4.053-2.91C4.548 21.423 4 19.709 4 17.771v-.017h4.14v.017c0 1.366.387 2.575 1.138 3.563.696.91 1.65 1.581 2.813 1.964 1.123.365 2.376.552 3.713.552h.014c1.337 0 2.59-.187 3.713-.552 1.164-.383 2.117-1.054 2.813-1.964.751-.988 1.138-2.197 1.138-3.563v-.017H20z"/></svg></a>
            </div>

            <!-- Copyright & disclaimer -->
            <div class="space-y-1">
                <p class="text-sm text-slate-500">© <?= date('Y') ?> Darren Connell. All rights reserved.</p>
                <a href="<?= $footerBasePath ?>/admin/" class="inline-flex items-center justify-center gap-1 mt-2 text-slate-500 hover:text-primary transition-colors text-xs" aria-label="Admin"><span class="material-symbols-outlined text-lg">mic_external_on</span></a>
                <p class="text-slate-600 text-sm text-balance max-w-md mx-auto">This site does not handle personal requests for autographs or video messages.</p>
            </div>

            <!-- Legal links - subtle pills matching nav -->
            <nav class="flex flex-wrap justify-center gap-2" aria-label="Legal">
                <a href="<?= $footerBasePath ?>/privacy.php" class="px-3 py-1.5 rounded-full bg-white/5 text-slate-400 hover:bg-white/10 hover:text-primary text-xs font-medium uppercase tracking-wider transition-all duration-200">Privacy</a>
                <a href="<?= $footerBasePath ?>/terms.php" class="px-3 py-1.5 rounded-full bg-white/5 text-slate-400 hover:bg-white/10 hover:text-primary text-xs font-medium uppercase tracking-wider transition-all duration-200">Terms</a>
                <a href="<?= $footerBasePath ?>/cookie-policy.php" class="px-3 py-1.5 rounded-full bg-white/5 text-slate-400 hover:bg-white/10 hover:text-primary text-xs font-medium uppercase tracking-wider transition-all duration-200">Cookies</a>
            </nav>
        </div>
    </div>
</footer>
