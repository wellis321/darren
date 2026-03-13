<?php
$consentBasePath = defined('BASE_PATH') ? BASE_PATH : '';
?>
<div id="cookie-consent-banner" class="fixed bottom-16 md:bottom-0 left-0 right-0 z-[99] hidden p-4 bg-slate-900/95 dark:bg-slate-950/95 backdrop-blur-md border-t border-primary/20 shadow-lg" role="dialog" aria-label="Cookie consent">
    <div class="max-w-4xl mx-auto flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <p class="text-slate-200 text-sm sm:text-base">
            We use cookies to keep the site working and to remember your preferences. See our <a href="<?= $consentBasePath ?>/cookie-policy.php" class="text-primary hover:underline">Cookie Policy</a> for details.
        </p>
        <div class="flex items-center gap-3 shrink-0">
            <button type="button" id="cookie-consent-accept" class="px-5 py-2.5 bg-primary text-white font-bold rounded-lg hover:brightness-110 transition-colors text-sm">
                Accept all
            </button>
            <button type="button" id="cookie-consent-essential" class="px-5 py-2.5 bg-slate-700 text-slate-200 font-medium rounded-lg hover:bg-slate-600 transition-colors text-sm">
                Essential only
            </button>
        </div>
    </div>
</div>
<script>
(function() {
    var banner = document.getElementById('cookie-consent-banner');
    var acceptBtn = document.getElementById('cookie-consent-accept');
    var essentialBtn = document.getElementById('cookie-consent-essential');
    var key = 'cookie_consent';

    if (!sessionStorage.getItem(key) && !localStorage.getItem(key)) {
        banner.classList.remove('hidden');
        banner.classList.add('flex', 'flex-col');
    }

    function hide(choice) {
        localStorage.setItem(key, choice);
        banner.classList.add('hidden');
        banner.classList.remove('flex');
    }

    if (acceptBtn) acceptBtn.addEventListener('click', function() { hide('all'); });
    if (essentialBtn) essentialBtn.addEventListener('click', function() { hide('essential'); });
})();
</script>
