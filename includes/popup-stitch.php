<?php
if (!function_exists('csrf_token')) {
    require_once __DIR__ . '/../config/session.php';
    require_once __DIR__ . '/../includes/functions.php';
}
$popupCsrf = csrf_token();
$popupBasePath = defined('BASE_PATH') ? BASE_PATH : '';
?>
<div id="site-popup-overlay" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-black/70 backdrop-blur-sm" aria-modal="true" aria-labelledby="popup-title" role="dialog">
    <div class="relative w-full max-w-md bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-primary/20 overflow-hidden">
        <button type="button" id="popup-dismiss" class="absolute top-4 right-4 p-2 rounded-full hover:bg-primary/10 text-slate-500 hover:text-primary transition-colors" aria-label="Close">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <div id="popup-content" class="p-6 pt-12"></div>
    </div>
</div>
<script>
(function() {
    var overlay = document.getElementById('site-popup-overlay');
    var content = document.getElementById('popup-content');
    var dismissBtn = document.getElementById('popup-dismiss');
    var basePath = <?= json_encode($popupBasePath) ?>;
    var csrfToken = <?= json_encode($popupCsrf) ?>;

    function getStorageKey(id) {
        return 'popup_dismissed_' + id;
    }

    function show(popup) {
        if (!popup || sessionStorage.getItem(getStorageKey(popup.id))) return;
        var html = '<h2 id="popup-title" class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-2">' + escapeHtml(popup.title) + '</h2>';
        if (popup.content) html += '<p class="text-slate-600 dark:text-slate-400 mb-4">' + escapeHtml(popup.content).replace(/\n/g, '<br>') + '</p>';
        if (popup.venue) html += '<p class="text-primary font-medium mb-4">' + escapeHtml(popup.venue) + '</p>';
        if (popup.link_url) html += '<a href="' + escapeAttr(popup.link_url) + '" target="_blank" rel="noopener" class="inline-block px-6 py-3 bg-primary text-white font-bold rounded-lg hover:brightness-110 transition-all mb-4">' + escapeHtml(popup.link_text || 'Get Tickets') + '</a>';
        if (popup.show_email_field) {
            html += '<form id="popup-form" class="mt-4"><input type="email" name="email" required placeholder="Your email" class="w-full px-4 py-3 rounded-lg border border-primary/20 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 mb-2"><button type="submit" class="w-full px-6 py-3 bg-primary/20 text-primary font-bold rounded-lg hover:bg-primary/30 transition-colors">Notify me</button></form>';
            html += '<p id="popup-form-msg" class="mt-2 text-sm text-green-600 hidden"></p>';
        }
        html += '<p class="mt-4 text-sm text-slate-500"><button type="button" id="popup-close-btn" class="underline hover:text-primary">Continue to site</button></p>';
        content.innerHTML = html;
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
        document.body.style.overflow = 'hidden';

        var closeBtn = document.getElementById('popup-close-btn');
        if (closeBtn) closeBtn.addEventListener('click', function() { close(popup.id); });
        dismissBtn.onclick = function() { close(popup.id); };
        overlay.addEventListener('click', function(e) { if (e.target === overlay) close(popup.id); });

        var form = document.getElementById('popup-form');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                var fd = new FormData();
                fd.append('popup_id', popup.id);
                fd.append('email', form.querySelector('[name=email]').value);
                fd.append('csrf_token', csrfToken);
                fetch((basePath || '') + '/api/popup-signup.php', { method: 'POST', body: fd })
                    .then(function(r) { return r.json(); })
                    .then(function(data) {
                        document.getElementById('popup-form-msg').textContent = data.message || 'Thanks!';
                        document.getElementById('popup-form-msg').classList.remove('hidden');
                        form.remove();
                        setTimeout(function() { close(popup.id); }, 1500);
                    })
                    .catch(function() {
                        document.getElementById('popup-form-msg').textContent = 'Something went wrong. Please try again.';
                        document.getElementById('popup-form-msg').classList.remove('hidden');
                    });
            });
        }
    }

    function close(id) {
        if (id) sessionStorage.setItem(getStorageKey(id), '1');
        overlay.classList.add('hidden');
        overlay.classList.remove('flex');
        document.body.style.overflow = '';
    }

    function escapeHtml(s) {
        var d = document.createElement('div');
        d.textContent = s;
        return d.innerHTML;
    }
    function escapeAttr(s) {
        return String(s).replace(/"/g, '&quot;');
    }

    fetch((basePath || '') + '/api/active-popup.php')
        .then(function(r) { return r.json(); })
        .then(function(popup) { show(popup); })
        .catch(function() {});
})();
</script>
