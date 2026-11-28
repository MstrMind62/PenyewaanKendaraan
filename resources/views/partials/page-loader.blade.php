{{-- Global Inline Button & Top-Bar Loading Animation --}}
<style>
    .de-top-progress {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 99999;
        width: 100%;
        height: 3px;
        background: var(--loader-gradient, linear-gradient(90deg, #F28C28, #F5817A, #EE6A93));
        transform: scaleX(0);
        transform-origin: left;
        opacity: 0;
        pointer-events: none;
        transition: transform .20s ease, opacity .2s ease;
    }

    .de-top-progress.active {
        opacity: 1;
        transform: scaleX(0.78);
        transition: transform .20s ease-out, opacity .15s ease;
    }

    .de-top-progress.done {
        opacity: 0;
        transform: scaleX(1);
        transition: transform .2s ease, opacity .25s ease .1s;
    }

    .de-btn-loading {
        pointer-events: none !important;
        opacity: 0.85 !important;
        cursor: wait !important;
    }

    .de-btn-spinner {
        display: inline-block;
        width: 14px;
        height: 14px;
        flex-shrink: 0;
        border-radius: 50%;
        border: 2px solid currentColor;
        border-top-color: transparent;
        vertical-align: -2px;
        margin-right: 6px;
        animation: de-btn-spin .65s linear infinite;
    }

    @keyframes de-btn-spin {
        to { transform: rotate(360deg); }
    }

    @media (prefers-reduced-motion: reduce) {
        .de-btn-spinner { animation: none; }
    }
</style>

<div class="de-top-progress" id="deTopProgress" aria-hidden="true"></div>

<script>
(function () {
    var bar = document.getElementById('deTopProgress');
    var safetyTimer = null;

    function startTopBar() {
        if (!bar) return;
        bar.classList.remove('done', 'active');
        requestAnimationFrame(function () {
            bar.classList.add('active');
        });
    }

    function setButtonLoading(el, labelText) {
        if (!el || el.dataset.deLoading === '1') return;

        // Jangan ubah elemen yang hanya berisi gambar/logo
        if (el.querySelector('img') && el.textContent.trim() === '') return;

        el.dataset.deLoading = '1';
        el.dataset.deOriginalHtml = el.innerHTML;
        el.classList.add('de-btn-loading');

        if (labelText) {
            el.innerHTML = '<span class="de-btn-spinner" aria-hidden="true"></span><span>' + labelText + '</span>';
        } else {
            var spinner = document.createElement('span');
            spinner.className = 'de-btn-spinner';
            spinner.setAttribute('aria-hidden', 'true');
            el.insertBefore(spinner, el.firstChild);
        }

        clearTimeout(safetyTimer);
        safetyTimer = setTimeout(resetAllLoading, 15000);
    }

    function resetAllLoading() {
        clearTimeout(safetyTimer);
        if (bar) {
            bar.classList.remove('active');
            bar.classList.add('done');
        }
        document.querySelectorAll('[data-de-loading="1"]').forEach(function (el) {
            if (typeof el.dataset.deOriginalHtml === 'string') {
                el.innerHTML = el.dataset.deOriginalHtml;
            }
            el.classList.remove('de-btn-loading');
            delete el.dataset.deLoading;
            delete el.dataset.deOriginalHtml;
        });
    }

    // Saat klik link untuk berpindah halaman
    document.addEventListener('click', function (e) {
        if (e.defaultPrevented || e.button !== 0 || e.ctrlKey || e.metaKey || e.shiftKey || e.altKey) return;

        var link = e.target.closest('a[href]');
        if (!link) return;

        var href = link.getAttribute('href');
        if (!href || href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:')) return;
        if (link.target === '_blank' || link.hasAttribute('download')) return;
        if (link.origin !== window.location.origin) return;

        startTopBar();
        setButtonLoading(link);
    });

    // Saat submit form (login, daftar, pemesanan, update, dll.)
    document.addEventListener('submit', function (e) {
        if (e.defaultPrevented) return;

        var form = e.target;
        var submitBtn = e.submitter || form.querySelector('button[type="submit"], button:not([type])');
        var action = (form.getAttribute('action') || '').toLowerCase();
        var msg = 'Memproses...';

        if (action.indexOf('login') !== -1) {
            msg = 'Sedang masuk...';
        } else if (action.indexOf('daftar') !== -1 || action.indexOf('register') !== -1) {
            msg = 'Membuat akun...';
        } else if (action.indexOf('logout') !== -1) {
            msg = 'Keluar...';
        }

        startTopBar();
        if (submitBtn && submitBtn.tagName === 'BUTTON') {
            setButtonLoading(submitBtn, msg);
        }
    });

    // Kembalikan tombol ke kondisi semula saat kembali dari cache browser
    window.addEventListener('pageshow', resetAllLoading);
    window.addEventListener('pagehide', resetAllLoading);
})();
</script>
