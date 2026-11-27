@extends('layouts.app')

@section('title', 'Daftar Armada')

@push('styles')
<style>
    /* ==============================
       ARMADA PAGE – Minimalis & Selaras dengan Home
    ============================== */

    .armada-page { width: 100%; }

    /* Latar halaman: cahaya oranye & pink lembut */
    .armada-page::before {
        content: "";
        position: fixed;
        inset: 0;
        z-index: -1;
        pointer-events: none;
        background:
            radial-gradient(620px 420px at 8% 4%,  rgba(242,140,40,0.13), transparent 70%),
            radial-gradient(560px 460px at 96% 38%, rgba(255,143,171,0.20), transparent 70%),
            radial-gradient(640px 460px at 20% 96%, rgba(255,143,171,0.14), transparent 70%),
            linear-gradient(180deg, #FFFAF8 0%, #F8F7FA 55%, #FFF1F5 100%);
    }

    /* ---------- HEADING ---------- */

    .armada-heading {
        display: flex;
        justify-content: space-between;
        align-items: end;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 28px;
    }

    .armada-heading h1 {
        margin: 0 0 7px;
        color: #202A35;
        font-size: 27px;
        font-weight: 800;
        letter-spacing: -0.7px;
    }

    .armada-heading p {
        margin: 0;
        color: #6B7280;
        font-size: 14px;
    }

    /* ---------- FILTER & SEARCH ---------- */

    .armada-controls {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
    }

    .armada-search-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .armada-search-icon {
        position: absolute;
        left: 15px;
        font-size: 14px;
        color: #9CA3AF;
        pointer-events: none;
    }

    .armada-search-input {
        width: 260px;
        padding: 10px 36px 10px 38px;
        border: 1px solid #E5E7EB;
        border-radius: 30px;
        background: white;
        color: #202A35;
        font: inherit;
        font-size: 13px;
        font-weight: 500;
        outline: none;
        transition: border-color .2s, box-shadow .2s, width .2s;
    }

    .armada-search-input::placeholder { color: #9CA3AF; }
    .armada-search-input:hover { border-color: #F6C28E; }
    .armada-search-input:focus {
        border-color: #F28C28;
        box-shadow: 0 0 0 3px rgba(242,140,40,0.12);
    }

    .armada-search-clear {
        position: absolute;
        right: 10px;
        width: 22px;
        height: 22px;
        display: none;
        align-items: center;
        justify-content: center;
        border: 0;
        border-radius: 50%;
        background: #FFF0DF;
        color: #D97706;
        font-size: 11px;
        font-weight: 800;
        cursor: pointer;
    }

    .armada-search-clear.show { display: inline-flex; }

    .armada-filter-bar select {
        padding: 10px 18px;
        border: 1px solid #E5E7EB;
        border-radius: 30px;
        background: white;
        color: #202A35;
        font: inherit;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }

    .armada-filter-bar select:hover { border-color: #F6C28E; }

    .armada-filter-bar select:focus {
        border-color: #F28C28;
        box-shadow: 0 0 0 3px rgba(242,140,40,0.12);
    }

    /* ---------- ALERTS ---------- */

    .armada-alert {
        padding: 13px 18px;
        border-radius: 14px;
        margin-bottom: 22px;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .armada-alert.success {
        background: linear-gradient(135deg, #ECFDF5, #F0FFF4);
        color: #166534;
        border: 1px solid #BBF7D0;
    }

    .armada-alert.error {
        background: linear-gradient(135deg, #FEF2F2, #FFEEF3);
        color: #991B1B;
        border: 1px solid #FECACA;
    }

    /* ---------- CAR GRID ---------- */

    .armada-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 22px;
    }

    /* ---------- CAR CARD (Minimalis seperti Home) ---------- */

    .armada-card {
        display: flex;
        flex-direction: column;
        overflow: hidden;
        background: white;
        border: 1px solid #E5E7EB;
        border-radius: 16px;
        transition: transform .3s, box-shadow .3s, border-color .3s;
    }

    .armada-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(32,42,53,0.09);
        border-color: #F6C28E;
        background: linear-gradient(180deg, #FFFFFF 60%, #FFF7FA 100%);
    }

    .armada-card:active { transform: translateY(-2px) scale(.99); }

    .armada-image-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 205px;
        margin: 10px;
        overflow: hidden;
        border-radius: 12px;
        background: linear-gradient(145deg, #F5F6F8 0%, #FFEEF3 100%);
    }

    .armada-image-wrapper img {
        width: 100%;
        height: 100%;
        padding: 12px;
        object-fit: contain;
        transition: transform .3s;
    }

    .armada-card:hover .armada-image-wrapper img { transform: scale(1.05); }

    .armada-image-fallback {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9CA3AF;
        font-size: 13px;
    }

    .armada-type-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        padding: 5px 11px;
        border-radius: 20px;
        background: white;
        color: #D97706;
        font-size: 11px;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(32,42,53,0.06);
    }

    .armada-status-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(32,42,53,0.06);
    }

    .armada-status-badge.available {
        background: #ECFDF5;
        color: #166534;
    }

    .armada-status-badge.unavailable {
        background: #FEF2F2;
        color: #991B1B;
    }

    .armada-status-badge .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    /* Card Body */
    .armada-card-body {
        display: flex;
        flex-direction: column;
        flex: 1;
        padding: 10px 18px 18px;
    }

    .armada-name {
        margin: 0 0 6px;
        color: #202A35;
        font-size: 18px;
        font-weight: 700;
        letter-spacing: -0.2px;
    }

    .armada-transmission {
        margin: 0 0 16px;
        color: #6B7280;
        font-size: 12px;
    }

    /* Footer: Harga & Tombol sejajar seperti Home */
    .armada-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-top: auto;
        padding-top: 14px;
        border-top: 1px solid #E5E7EB;
    }

    .armada-price {
        background: linear-gradient(100deg, #F28C28, #EE6A93);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        font-size: 17px;
        font-weight: 800;
        line-height: 1.2;
    }

    .armada-price small {
        display: block;
        margin-top: 3px;
        -webkit-text-fill-color: #9CA3AF;
        color: #9CA3AF;
        font-size: 11px;
        font-weight: 500;
    }

    .armada-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 14px;
        border-radius: 8px;
        font: inherit;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        transition: background .2s, color .2s, transform .15s;
        position: relative;
        overflow: hidden;
    }

    .armada-btn-primary {
        background: linear-gradient(135deg, #FFF0DF, #FFDCE6);
        color: #D97706;
    }

    .armada-btn-primary:hover {
        background: linear-gradient(135deg, #F7A04A, #F5817A 60%, #EE6A93);
        color: white;
    }

    .armada-btn-primary:active { transform: scale(.94); }

    .armada-btn-disabled {
        background: #F5F6F8;
        color: #9CA3AF;
        cursor: not-allowed;
    }

    /* Empty */
    .armada-empty {
        grid-column: 1 / -1;
        padding: 55px 20px;
        background: white;
        border: 1px dashed #D1D5DB;
        border-radius: 16px;
        text-align: center;
    }

    .armada-empty .empty-emoji { font-size: 40px; margin-bottom: 10px; }
    .armada-empty h3 { margin: 0 0 7px; color: #202A35; font-size: 18px; }
    .armada-empty p { margin: 0; color: #6B7280; font-size: 13px; }

    /* ---------- RIPPLE ---------- */

    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(242,140,40,0.3);
        transform: scale(0);
        pointer-events: none;
        animation: ripple .6s ease-out forwards;
    }

    @keyframes ripple { to { transform: scale(4); opacity: 0; } }

    /* ---------- SCROLL REVEAL ---------- */

    .js .ar-reveal { opacity: 0; transform: translateY(22px); transition: opacity .6s ease, transform .6s ease; }
    .js .ar-reveal.visible { opacity: 1; transform: none; }
    .js .ar-card-reveal { opacity: 0; transform: translateY(14px) scale(.97); transition: opacity .4s ease, transform .4s ease; }
    .js .ar-card-reveal.visible { opacity: 1; transform: none; }

    /* ---------- RESPONSIVE ---------- */

    @media(max-width: 900px) {
        .armada-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media(max-width: 650px) {
        .armada-heading h1 { font-size: 22px; }
        .armada-grid { grid-template-columns: 1fr; }
        .armada-controls,
        .armada-search-wrap,
        .armada-search-input,
        .armada-filter-bar,
        .armada-filter-bar select { width: 100%; }
    }

    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after { animation: none !important; transition: none !important; }
        .js .ar-reveal, .js .ar-card-reveal { opacity: 1; transform: none; }
    }
</style>
@endpush

@section('content')

<div class="armada-page">

    {{-- ========== HEADING ========== --}}

    <div class="armada-heading ar-reveal">
        <div>
            <h1>Pilihan Kendaraan Kami</h1>
            <p>Temukan kendaraan yang sesuai untuk perjalanan Anda.</p>
        </div>

        <div class="armada-controls">
            <div class="armada-search-wrap">
                <span class="armada-search-icon">🔍</span>
                <input
                    type="search"
                    id="armadaSearch"
                    class="armada-search-input"
                    value="{{ request('q') }}"
                    placeholder="Cari mobil, tipe, transmisi..."
                    aria-label="Cari kendaraan"
                >
                <button type="button" id="armadaSearchClear" class="armada-search-clear" aria-label="Hapus pencarian">✕</button>
            </div>

            <form method="GET" action="{{ route('armada.index') }}" class="armada-filter-bar">
                @if(request('q'))
                    <input type="hidden" name="q" value="{{ request('q') }}">
                @endif
                <select name="kategori" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    <option value="Motor" {{ request('kategori') == 'Motor' ? 'selected' : '' }}>
                        Kendaraan Motor
                    </option>
                    <option value="Travel" {{ request('kategori') == 'Travel' ? 'selected' : '' }}>
                        Kendaraan Travel / Mobil
                    </option>
                </select>
            </form>
        </div>
    </div>

    {{-- ========== ALERTS ========== --}}

    @if(session('success'))
        <div class="armada-alert success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="armada-alert error">
            {{ session('error') }}
        </div>
    @endif

    {{-- ========== GRID ========== --}}

    <div class="armada-grid" id="armadaGrid">

        @forelse($armadas as $a)

            <article
                class="armada-card ar-card-reveal"
                data-search="{{ strtolower(trim(($a->nama_kendaraan ?? '') . ' ' . ($a->tipe ?? '') . ' ' . ($a->transmisi ?? ''))) }}"
            >

                <div class="armada-image-wrapper">

                    <span class="armada-type-badge">
                        {{ $a->tipe ?: 'Kendaraan' }}
                    </span>

                    @if(strtolower($a->status_ketersediaan) === 'tersedia')
                        <span class="armada-status-badge available">
                            <span class="status-dot"></span> Tersedia
                        </span>
                    @else
                        <span class="armada-status-badge unavailable">
                            <span class="status-dot"></span> Tidak Tersedia
                        </span>
                    @endif

                    @if(!empty($a->gambar))
                        <img
                            src="{{ $a->gambar }}"
                            alt="{{ $a->nama_kendaraan }}"
                            loading="lazy"
                            referrerpolicy="no-referrer"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                        >
                        <div class="armada-image-fallback" style="display:none;">
                            Gambar gagal dimuat
                        </div>
                    @else
                        <div class="armada-image-fallback">
                            Gambar belum tersedia
                        </div>
                    @endif

                </div>

                <div class="armada-card-body">

                    <h2 class="armada-name">{{ $a->nama_kendaraan }}</h2>

                    <p class="armada-transmission">
                        ⚙ Transmisi: {{ $a->transmisi ?: 'Belum diisi' }}
                    </p>

                    <div class="armada-card-footer">

                        <div class="armada-price">
                            Rp{{ number_format($a->harga_sewa, 0, ',', '.') }}
                            <small>Per hari</small>
                        </div>

                        @if(strtolower($a->status_ketersediaan) === 'tersedia')

                            @if(session('role') === 'customer')
                                <a href="{{ route('booking.create', $a) }}" class="armada-btn armada-btn-primary">
                                    Pesan Sekarang
                                </a>
                            @elseif(session('role') === 'admin')
                                <span class="armada-btn armada-btn-disabled">
                                    Mode Admin
                                </span>
                            @else
                                <a href="{{ route('login') }}" class="armada-btn armada-btn-primary">
                                    Login untuk Memesan
                                </a>
                            @endif

                        @else
                            <span class="armada-btn armada-btn-disabled">
                                Tidak Tersedia
                            </span>
                        @endif

                    </div>

                </div>

            </article>

        @empty

            <div class="armada-empty">
                <div class="empty-emoji">🚘</div>
                <h3>Belum Ada Armada</h3>
                <p>Data kendaraan belum tersedia.</p>
            </div>

        @endforelse

        <div class="armada-empty" id="armadaSearchEmpty" style="display: none;">
            <div class="empty-emoji">🔍</div>
            <h3>Kendaraan Tidak Ditemukan</h3>
            <p>Coba kata kunci lain atau hapus pencarian untuk melihat semua kendaraan.</p>
        </div>

    </div>

</div>

@endsection


@push('scripts')
<script>
(function () {
    document.documentElement.classList.add('js');
    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* Ripple */
    document.addEventListener('click', function (e) {
        var el = e.target.closest('.armada-btn-primary');
        if (!el || reduce) return;
        var rect = el.getBoundingClientRect();
        var size = Math.max(rect.width, rect.height);
        var r = document.createElement('span');
        r.className = 'ripple';
        r.style.width = r.style.height = size + 'px';
        r.style.left = (e.clientX - rect.left - size / 2) + 'px';
        r.style.top = (e.clientY - rect.top - size / 2) + 'px';
        el.appendChild(r);
        setTimeout(function () { r.remove(); }, 650);
    });

    /* Live search */
    var searchInput = document.getElementById('armadaSearch');
    var clearBtn = document.getElementById('armadaSearchClear');
    var emptyBox = document.getElementById('armadaSearchEmpty');
    var armadaCards = document.querySelectorAll('#armadaGrid .armada-card');

    function filterArmada() {
        if (!searchInput) return;
        var q = searchInput.value.trim().toLowerCase();
        if (clearBtn) clearBtn.classList.toggle('show', q.length > 0);

        var shown = 0;
        armadaCards.forEach(function (card) {
            var text = card.getAttribute('data-search') || '';
            var match = q === '' || text.indexOf(q) !== -1;
            card.style.display = match ? '' : 'none';
            if (match) shown++;
        });

        if (emptyBox) {
            emptyBox.style.display = (armadaCards.length > 0 && shown === 0) ? '' : 'none';
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterArmada);
        if (clearBtn) {
            clearBtn.addEventListener('click', function () {
                searchInput.value = '';
                filterArmada();
                searchInput.focus();
            });
        }
        filterArmada();
    }

    /* Scroll reveal */
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (!en.isIntersecting) return;
                en.target.classList.add('visible');
                io.unobserve(en.target);
            });
        }, { threshold: 0.08 });
        document.querySelectorAll('.ar-reveal, .ar-card-reveal').forEach(function (el) { io.observe(el); });
    } else {
        document.querySelectorAll('.ar-reveal, .ar-card-reveal').forEach(function (el) { el.classList.add('visible'); });
    }
})();
</script>
@endpush
