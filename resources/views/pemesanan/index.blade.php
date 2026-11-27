@extends('layouts.app')

@section('title', 'Pesanan Saya')

@push('styles')
<style>
    /* ==============================
       ORDERS PAGE – Selaras dengan Home
    ============================== */

    .orders-page { width: 100%; }

    /* Latar halaman */
    .orders-page::before {
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

    /* ---------- HEADER ---------- */

    .orders-heading {
        margin-bottom: 28px;
    }

    .orders-heading h1 {
        margin: 0 0 7px;
        color: #202A35;
        font-size: 27px;
        font-weight: 800;
        letter-spacing: -0.7px;
    }

    .orders-heading p {
        margin: 0;
        color: #6B7280;
        font-size: 14px;
    }

    /* ---------- ALERTS ---------- */

    .order-alert {
        padding: 14px 18px;
        border-radius: 14px;
        margin-bottom: 20px;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .order-alert.success {
        background: linear-gradient(135deg, #ECFDF5, #F0FFF4);
        color: #166534;
        border: 1px solid #BBF7D0;
    }

    .order-alert.error {
        background: linear-gradient(135deg, #FEF2F2, #FFEEF3);
        color: #991B1B;
        border: 1px solid #FECACA;
    }

    /* ---------- ORDERS LIST ---------- */

    .orders-list { display: grid; gap: 20px; }

    /* ---------- ORDER CARD ---------- */

    .order-card {
        background: white;
        border: 1px solid #E5E7EB;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 6px 22px rgba(32,42,53,0.05);
        transition: border-color .3s, box-shadow .3s;
    }

    .order-card:hover {
        border-color: #F6C28E;
        box-shadow: 0 10px 28px rgba(32,42,53,0.08);
    }

    /* Top bar */
    .order-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        padding: 20px 24px;
        border-bottom: 1px solid #F0F0F0;
    }

    .order-number {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 13px;
        color: #6B7280;
        font-weight: 600;
    }

    .order-number .order-id-icon {
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: linear-gradient(135deg, #FFF0DF, #FFD6E2);
        color: #F28C28;
        font-size: 13px;
    }

    /* Status */
    .order-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 7px 14px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 700;
    }

    .order-status .status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .order-status.status-default {
        background: linear-gradient(135deg, #FFF0DF, #FFDCE6);
        color: #D97706;
    }

    .order-status.status-success {
        background: linear-gradient(135deg, #ECFDF5, #DCFCE7);
        color: #166534;
    }

    .order-status.status-danger {
        background: linear-gradient(135deg, #FEF2F2, #FEE2E2);
        color: #991B1B;
    }

    .order-status.status-info {
        background: linear-gradient(135deg, #EFF6FF, #DBEAFE);
        color: #1E40AF;
    }

    /* Vehicle */
    .order-vehicle {
        padding: 20px 24px 0;
    }

    .order-vehicle h2 {
        font-size: 20px;
        font-weight: 750;
        margin: 0 0 5px;
        color: #202A35;
        letter-spacing: -0.3px;
    }

    .order-vehicle p {
        color: #6B7280;
        font-size: 13px;
        margin: 0;
    }

    /* Details grid */
    .order-details {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        padding: 20px 24px;
    }

    .detail-item {
        padding: 14px 16px;
        border-radius: 12px;
        background: linear-gradient(135deg, #FAFAFA, #FFF8F5);
        border: 1px solid #F5F5F5;
        min-width: 0;
    }

    .detail-label {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #9CA3AF;
        font-size: 12px;
        margin-bottom: 6px;
        font-weight: 600;
    }

    .detail-label .detail-icon {
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 5px;
        background: linear-gradient(135deg, #FFF0DF, #FFD6E2);
        font-size: 10px;
        flex-shrink: 0;
    }

    .detail-value {
        display: block;
        font-size: 14px;
        font-weight: 650;
        color: #202A35;
        overflow-wrap: anywhere;
    }

    /* Total */
    .order-total {
        margin: 0 24px;
        padding: 18px 20px;
        border-radius: 14px;
        background:
            radial-gradient(200px 140px at 100% 0%, rgba(242,140,40,0.30), transparent 70%),
            linear-gradient(160deg, #2B3745 0%, #202A35 60%, #18202A 100%);
    }

    .order-total .detail-label {
        color: #CBD5E1;
    }

    .order-total .detail-value {
        color: white;
        font-size: 20px;
        font-weight: 800;
        -webkit-text-fill-color: white;
    }

    /* Payment */
    .order-payment {
        margin: 16px 24px 0;
        padding: 18px 20px;
        border-radius: 14px;
        background: linear-gradient(135deg, #FFF8F3, #FFF0F3);
        border: 1px solid #FFE5CA;
    }

    .order-payment h3 {
        font-size: 14px;
        margin: 0 0 10px;
        font-weight: 750;
        color: #202A35;
    }

    .payment-info {
        font-size: 13px;
        color: #6B7280;
        margin: 0;
    }

    .payment-info strong { color: #202A35; }

    /* Actions */
    .order-actions {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
        padding: 18px 24px;
    }

    .order-actions form { margin: 0; }

    .order-actions select {
        min-width: 160px;
        padding: 11px 14px;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        background: white;
        color: #202A35;
        font: inherit;
        font-size: 13px;
        outline: none;
        transition: border-color .2s;
    }

    .order-actions select:focus {
        border-color: #F28C28;
        box-shadow: 0 0 0 3px rgba(242,140,40,0.12);
    }

    .order-actions button {
        border: none;
        border-radius: 10px;
        padding: 11px 18px;
        font: inherit;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: transform .15s, box-shadow .2s, background-position .5s;
        position: relative;
        overflow: hidden;
    }

    .btn-payment {
        background: linear-gradient(135deg, #F7A04A 0%, #F5817A 55%, #EE6A93 100%);
        background-size: 200% 200%;
        background-position: 0% 50%;
        color: white;
        box-shadow: 0 6px 16px rgba(238,106,147,0.25);
    }

    .btn-payment:hover {
        background-position: 100% 50%;
        box-shadow: 0 8px 20px rgba(238,106,147,0.35);
        transform: translateY(-2px);
    }

    .btn-payment:active { transform: scale(.96); }

    .btn-cancel {
        background: white;
        color: #DC3545;
        border: 1px solid #FECACA !important;
    }

    .btn-cancel:hover {
        background: linear-gradient(135deg, #FEF2F2, #FFEEF3);
        transform: translateY(-1px);
    }

    .btn-cancel:active { transform: scale(.96); }

    /* Empty */
    .empty-orders {
        text-align: center;
        padding: 60px 24px;
        background: white;
        border: 1px dashed #D1D5DB;
        border-radius: 16px;
    }

    .empty-orders .empty-emoji { font-size: 42px; margin-bottom: 14px; }

    .empty-orders h2 {
        font-size: 19px;
        margin: 0 0 8px;
        color: #202A35;
    }

    .empty-orders p {
        color: #6B7280;
        font-size: 14px;
        margin: 0 0 22px;
    }

    .btn-browse {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 13px 24px;
        border-radius: 10px;
        background: linear-gradient(135deg, #F7A04A 0%, #F5817A 55%, #EE6A93 100%);
        background-size: 200% 200%;
        background-position: 0% 50%;
        color: white;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 6px 16px rgba(238,106,147,0.25);
        transition: background-position .5s, transform .15s, box-shadow .2s;
    }

    .btn-browse:hover {
        background-position: 100% 50%;
        box-shadow: 0 10px 22px rgba(238,106,147,0.35);
        transform: translateY(-2px);
        color: white;
    }

    .btn-browse:active { transform: scale(.96); }

    /* ---------- RIPPLE ---------- */

    .btn-payment, .btn-browse { position: relative; overflow: hidden; }

    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.45);
        transform: scale(0);
        pointer-events: none;
        animation: ripple .6s ease-out forwards;
    }

    @keyframes ripple { to { transform: scale(4); opacity: 0; } }

    /* ---------- SCROLL REVEAL ---------- */

    .js .od-reveal { opacity: 0; transform: translateY(22px); transition: opacity .6s ease, transform .6s ease; }
    .js .od-reveal.visible { opacity: 1; transform: none; }

    /* ---------- RESPONSIVE ---------- */

    @media(max-width: 650px) {
        .orders-heading h1 { font-size: 22px; }

        .order-top,
        .order-vehicle,
        .order-actions { padding-left: 18px; padding-right: 18px; }

        .order-details {
            grid-template-columns: 1fr;
            gap: 10px;
            padding-left: 18px;
            padding-right: 18px;
        }

        .order-total,
        .order-payment { margin-left: 18px; margin-right: 18px; }

        .order-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .order-actions form,
        .order-actions select,
        .order-actions button { width: 100%; }

        .empty-orders { padding: 40px 18px; }
    }

    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after { animation: none !important; transition: none !important; }
        .js .od-reveal { opacity: 1; transform: none; }
    }
</style>
@endpush

@section('content')

<div class="orders-page">

    {{-- ========== HEADER ========== --}}

    <div class="orders-heading od-reveal">
        <h1>Pesanan Saya</h1>
        <p>Lihat riwayat pemesanan dan pantau status penyewaan kendaraan kamu.</p>
    </div>

    {{-- ========== ALERTS ========== --}}

    @if(session('success'))
        <div class="order-alert success od-reveal">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="order-alert error od-reveal">
            ⚠️ {{ $errors->first() }}
        </div>
    @endif

    {{-- ========== ORDERS ========== --}}

    <div class="orders-list">

        @forelse($orders as $o)

            <article class="order-card od-reveal">

                {{-- Top --}}
                <div class="order-top">
                    <span class="order-number">
                        <span class="order-id-icon">📋</span>
                        ID PESANAN #{{ $o->id_pemesanan }}
                    </span>

                    @php
                        $statusClass = match($o->status) {
                            'Selesai' => 'status-success',
                            'Dibatalkan' => 'status-danger',
                            'Dikonfirmasi', 'Dalam Perjalanan' => 'status-info',
                            default => 'status-default',
                        };
                    @endphp

                    <span class="order-status {{ $statusClass }}">
                        <span class="status-dot"></span>
                        {{ $o->status }}
                    </span>
                </div>

                {{-- Vehicle --}}
                <div class="order-vehicle">
                    <h2>{{ $o->armada->nama_kendaraan ?? 'Kendaraan tidak tersedia' }}</h2>
                    <p>{{ $o->armada->tipe ?? 'Informasi kendaraan tidak tersedia' }}</p>
                </div>

                {{-- Details --}}
                <div class="order-details">

                    <div class="detail-item">
                        <span class="detail-label">
                            <span class="detail-icon">📅</span> Tanggal Sewa
                        </span>
                        <span class="detail-value">
                            @if($o->tanggalPemesanan->isNotEmpty())
                                {{ $o->tanggalPemesanan
                                    ->map(fn($item) => \Carbon\Carbon::parse($item->tanggal_sewa)->format('d-m-Y'))
                                    ->implode(', ') }}
                            @else
                                {{ \Carbon\Carbon::parse($o->tanggal_sewa)->format('d-m-Y') }}
                            @endif
                        </span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <span class="detail-icon">⏱️</span> Durasi Sewa
                        </span>
                        <span class="detail-value">{{ $o->durasi }} Hari</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <span class="detail-icon">🚗</span> Layanan
                        </span>
                        <span class="detail-value">
                            {{ $o->layanan === 'diantar' ? 'Diantar ke alamat' : 'Ambil sendiri' }}
                        </span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <span class="detail-icon">👤</span> Sopir
                        </span>
                        <span class="detail-value">
                            {{ $o->sopir->nama ?? 'Belum ditugaskan' }}
                        </span>
                    </div>

                </div>

                {{-- Total --}}
                <div class="order-total">
                    <span class="detail-label">Total Pembayaran</span>
                    <span class="detail-value">
                        Rp{{ number_format($o->total_biaya, 0, ',', '.') }}
                    </span>
                </div>

                {{-- Payment Info --}}
                <div class="order-payment">
                    <h3>Informasi Pembayaran</h3>
                    <p class="payment-info">
                        Status:
                        <strong>{{ $o->pembayaran->status_pembayaran ?? 'Belum dicatat' }}</strong>
                    </p>
                    <p class="payment-info" style="margin-top:5px;">
                        Metode:
                        <strong>{{ $o->pembayaran->metode_pembayaran ?? '-' }}</strong>
                    </p>

                    @if($o->status === 'Menunggu Pembayaran')
                        <form
                            method="POST"
                            action="{{ route('booking.pay', $o) }}"
                            class="order-actions"
                            style="padding: 12px 0 0;"
                        >
                            @csrf
                            <select name="metode_pembayaran" required>
                                <option value="Transfer Bank"
                                    @selected(($o->pembayaran->metode_pembayaran ?? '') === 'Transfer Bank')>
                                    Transfer Bank
                                </option>
                                <option value="E-Wallet"
                                    @selected(($o->pembayaran->metode_pembayaran ?? '') === 'E-Wallet')>
                                    E-Wallet
                                </option>
                                <option value="QRIS"
                                    @selected(($o->pembayaran->metode_pembayaran ?? '') === 'QRIS')>
                                    QRIS
                                </option>
                            </select>
                            <button type="submit" class="btn-payment">
                                Pilih Metode Pembayaran
                            </button>
                        </form>
                    @endif
                </div>

                {{-- Cancel --}}
                @if(in_array($o->status, ['Menunggu Pembayaran', 'Menunggu Konfirmasi']))
                    <div class="order-actions">
                        <form
                            method="POST"
                            action="{{ route('booking.cancel', $o) }}"
                            onsubmit="return confirm('Apakah kamu yakin ingin membatalkan pesanan ini?')"
                        >
                            @csrf
                            <button type="submit" class="btn-cancel">
                                ✕ Batalkan Pesanan
                            </button>
                        </form>
                    </div>
                @endif

            </article>

        @empty

            <div class="empty-orders od-reveal">
                <div class="empty-emoji">🚗</div>
                <h2>Belum Ada Pesanan</h2>
                <p>
                    Kamu belum memiliki riwayat penyewaan kendaraan.
                    Yuk, temukan kendaraan yang sesuai dengan kebutuhanmu!
                </p>
                <a href="{{ route('armada.index') }}" class="btn-browse">
                    Lihat Daftar Kendaraan &nbsp; →
                </a>
            </div>

        @endforelse

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
        var el = e.target.closest('.btn-payment, .btn-browse');
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

    /* Scroll reveal */
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (!en.isIntersecting) return;
                en.target.classList.add('visible');
                io.unobserve(en.target);
            });
        }, { threshold: 0.08 });
        document.querySelectorAll('.od-reveal').forEach(function (el) { io.observe(el); });
    } else {
        document.querySelectorAll('.od-reveal').forEach(function (el) { el.classList.add('visible'); });
    }
})();
</script>
@endpush
