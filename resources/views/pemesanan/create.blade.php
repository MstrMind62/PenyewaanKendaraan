@extends('layouts.app')

@section('title', 'Buat Pemesanan')

@push('styles')
<style>
    /* ==============================
       BOOKING PAGE – Selaras dengan Home
    ============================== */

    .booking-page { width: 100%; }

    /* Latar halaman: cahaya oranye lembut, sama seperti home */
    .booking-page::before {
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

    /* ---------- BACK LINK ---------- */

    .booking-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 30px;
        background: linear-gradient(135deg, #FFF0DF, #FFD3E0);
        color: #D97706;
        font-size: 13px;
        font-weight: 700;
        transition: transform .2s, box-shadow .2s;
    }

    .booking-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(242,140,40,0.18);
        color: #D97706;
    }

    .booking-back:active { transform: scale(.96); }

    /* ---------- HEADER SECTION ---------- */

    .booking-hero {
        position: relative;
        overflow: hidden;
        margin-top: 20px;
        padding: 36px 40px;
        background: transparent;
        border-radius: 22px;
        box-shadow: 0 14px 34px rgba(32,42,53,0.10);
        isolation: isolate;
    }

    .booking-hero::before {
        content: "";
        position: absolute;
        inset: 0;
        z-index: -1;
        background: url('/images/remie_bg.jpg') center / cover no-repeat;
        opacity: 0.18;
        border-radius: inherit;
        pointer-events: none;
    }

    .booking-hero h1 {
        margin: 10px 0 8px;
        font-size: clamp(24px, 3.5vw, 34px);
        line-height: 1.2;
        letter-spacing: -1.2px;
        color: #202A35;
    }

    .booking-hero h1 span {
        background: linear-gradient(100deg, #F28C28 0%, #F7857F 50%, #EE6A93 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        color: #F28C28;
    }

    .booking-hero .booking-price {
        background: linear-gradient(100deg, #F28C28, #EE6A93);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        font-size: 28px;
        font-weight: 800;
        margin: 10px 0 6px;
    }

    .booking-hero .booking-price small {
        -webkit-text-fill-color: #9CA3AF;
        font-size: 13px;
        font-weight: 500;
    }

    .booking-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 12px;
    }

    .booking-meta-item {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 14px;
        border-radius: 30px;
        background: white;
        border: 1px solid #E5E7EB;
        color: #6B7280;
        font-size: 12px;
        font-weight: 600;
    }

    .booking-meta-item .meta-icon {
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: linear-gradient(135deg, #FFF0DF, #FFD6E2);
        color: #F28C28;
        font-size: 14px;
        flex-shrink: 0;
    }

    /* ---------- ALERT ---------- */

    .booking-alert-card {
        margin-top: 18px;
        padding: 16px 20px;
        border-radius: 14px;
        background: linear-gradient(135deg, #FEF2F2, #FFEEF3);
        border: 1px solid #FECACA;
        color: #991B1B;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .booking-alert-card .alert-icon {
        width: 32px;
        height: 32px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #FEE2E2;
        font-size: 16px;
    }

    /* ---------- FORM CARD ---------- */

    .booking-form-card {
        margin-top: 24px;
        padding: 0;
        background: white;
        border: 1px solid #E5E7EB;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 28px rgba(32,42,53,0.06);
        transition: border-color .3s;
    }

    .booking-form-card:hover {
        border-color: #F6C28E;
    }

    .form-section {
        padding: 28px 32px;
        border-bottom: 1px solid #F0F0F0;
    }

    .form-section:last-child { border-bottom: 0; }

    .form-section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        color: #202A35;
        font-size: 16px;
        font-weight: 700;
        letter-spacing: -0.3px;
    }

    .form-section-title .section-icon {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: linear-gradient(135deg, #FFF0DF, #FFD6E2);
        color: #F28C28;
        font-size: 18px;
        flex-shrink: 0;
    }

    /* ---------- FIELD STYLES ---------- */

    .bk-field {
        margin-bottom: 20px;
    }

    .bk-field:last-child { margin-bottom: 0; }

    .bk-field > label {
        display: block;
        margin-bottom: 8px;
        color: #202A35;
        font-size: 13px;
        font-weight: 700;
    }

    .bk-field input,
    .bk-field select,
    .bk-field textarea {
        width: 100%;
        box-sizing: border-box;
        min-height: 46px;
        padding: 12px 14px;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        background: white;
        color: #202A35;
        font: inherit;
        font-size: 14px;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }

    .bk-field input:focus,
    .bk-field select:focus,
    .bk-field textarea:focus {
        border-color: #F28C28;
        box-shadow: 0 0 0 3px rgba(242,140,40,0.12);
    }

    .bk-field .field-hint {
        display: block;
        margin-top: 6px;
        color: #9CA3AF;
        font-size: 12px;
        line-height: 1.5;
    }

    /* ---------- DRIVER RADIO ---------- */

    .driver-option-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        margin-bottom: 8px;
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        cursor: pointer;
        transition: border-color .2s, background .2s, box-shadow .2s;
    }

    .driver-option-card:hover {
        border-color: #F6C28E;
        background: linear-gradient(135deg, #FFFFFF, #FFF5F8);
    }

    .driver-option-card.checked {
        border-color: #F28C28;
        background: linear-gradient(135deg, #FFF8F3, #FFF0F3);
        box-shadow: 0 4px 14px rgba(242,140,40,0.10);
    }

    .driver-option-card input[type="radio"] {
        width: auto;
        min-height: auto;
        padding: 0;
        accent-color: #F28C28;
    }

    .driver-option-card .driver-label {
        font-size: 14px;
        font-weight: 600;
        color: #202A35;
    }

    .driver-option-card .driver-extra {
        margin-left: auto;
        padding: 5px 10px;
        border-radius: 20px;
        background: linear-gradient(135deg, #FFF0DF, #FFDCE6);
        color: #D97706;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    /* ---------- CALENDAR ---------- */

    .calendar-heading {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 14px;
    }

    .calendar-heading label { margin-bottom: 5px; }

    .calendar-month {
        padding: 6px 14px;
        border-radius: 20px;
        background: linear-gradient(135deg, #FFF0DF, #FFD3E0);
        color: #D97706;
        font-size: 13px;
        font-weight: 750;
        white-space: nowrap;
    }

    .calendar-legend {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin: 14px 0 18px;
        font-size: 12px;
        color: #6B7280;
    }

    .calendar-legend span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .legend-dot {
        width: 10px;
        height: 10px;
        display: inline-block;
        border-radius: 50%;
        background: #16a34a;
    }

    .legend-dot.limited { background: #e6a23c; }
    .legend-dot.full { background: #dc5555; }
    .legend-dot.chosen { background: linear-gradient(135deg, #F28C28, #EE6A93); }

    .calendar-weekdays,
    .calendar-days {
        display: grid;
        grid-template-columns: repeat(7, minmax(0, 1fr));
        gap: 8px;
    }

    .calendar-weekdays {
        margin-bottom: 10px;
        text-align: center;
        color: #9CA3AF;
        font-size: 12px;
        font-weight: 700;
    }

    .calendar-days button,
    .calendar-empty {
        min-width: 0;
        min-height: 68px;
        border-radius: 12px;
    }

    .calendar-days button {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 4px;
        border: 1px solid #E5E7EB;
        background: white;
        color: #202A35;
        cursor: pointer;
        padding: 6px 2px;
        font: inherit;
        transition: transform .15s, border-color .2s, background .2s, box-shadow .2s;
    }

    .calendar-days button:hover:not(:disabled):not(.selected) {
        border-color: #F6C28E;
        background: linear-gradient(135deg, #FFFFFF, #FFF5F8);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(32,42,53,0.06);
    }

    .calendar-days button:active:not(:disabled) { transform: scale(.95); }

    .calendar-days button .day-number {
        font-size: 15px;
        font-weight: 750;
    }

    .calendar-days button .day-stock {
        font-size: 10px;
        color: #9CA3AF;
    }

    .calendar-days button.available { border-color: #a9dcb8; }
    .calendar-days button.limited { border-color: #f0c77e; }

    .calendar-days button.full,
    .calendar-days button:disabled {
        opacity: .35;
        cursor: not-allowed;
        background: #F5F6F8;
    }

    .calendar-days button.selected {
        color: #fff;
        background: linear-gradient(135deg, #F7A04A, #F5817A 55%, #EE6A93);
        border-color: transparent;
        opacity: 1;
        box-shadow: 0 6px 18px rgba(238,106,147,0.25);
    }

    .calendar-days button.selected .day-stock { color: rgba(255,255,255,0.8); }

    .calendar-days button:focus-visible {
        outline: 2px solid #F28C28;
        outline-offset: 2px;
    }

    /* ---------- SELECTED DATES BOX ---------- */

    .selected-dates-box {
        margin-top: 18px;
        padding: 16px;
        border: 1px solid #F0F0F0;
        border-radius: 14px;
        background: linear-gradient(135deg, #FAFAFA, #FFF8F5);
    }

    .selected-dates-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        font-size: 13px;
        color: #6B7280;
        font-weight: 600;
    }

    .selected-dates-title strong {
        padding: 4px 12px;
        border-radius: 20px;
        background: linear-gradient(135deg, #FFF0DF, #FFDCE6);
        color: #D97706;
        font-size: 12px;
    }

    .selected-date-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .selected-date-chip {
        border-radius: 20px;
        background: linear-gradient(135deg, #FFF0DF, #FFDCE6);
        color: #D97706;
        padding: 7px 13px;
        font-size: 12px;
        font-weight: 650;
        transition: transform .15s;
    }

    .selected-date-chip:hover { transform: scale(1.04); }

    .calendar-message {
        min-height: 20px;
        margin-top: 10px;
        color: #D97706;
        font-size: 12px;
        font-weight: 600;
    }

    /* ---------- ERRORS ---------- */

    .booking-error {
        padding: 12px 14px;
        border-radius: 10px;
        color: #991B1B;
        background: linear-gradient(135deg, #FEF2F2, #FFEEF3);
        border: 1px solid #FECACA;
        margin-top: 10px;
        font-size: 13px;
        font-weight: 600;
    }

    /* ---------- TOTAL CARD ---------- */

    .booking-total-card {
        position: relative;
        overflow: hidden;
        margin-top: 24px;
        padding: 28px 32px;
        border-radius: 16px;
        background:
            radial-gradient(300px 220px at 100% 0%, rgba(242,140,40,0.35), transparent 70%),
            linear-gradient(160deg, #2B3745 0%, #202A35 60%, #18202A 100%);
        box-shadow: 0 14px 34px rgba(32,42,53,0.18);
    }

    .total-label {
        color: #CBD5E1;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .total-driver-fee {
        color: #94A3B8;
        font-size: 13px;
        margin-bottom: 6px;
    }

    .total-amount {
        color: white;
        font-size: 32px;
        font-weight: 800;
        letter-spacing: -1px;
        margin-bottom: 8px;
        transition: color .3s;
    }

    .total-amount.bump { color: #F28C28; }

    .total-note {
        color: #94A3B8;
        font-size: 12px;
        line-height: 1.6;
        margin: 0;
    }

    /* ---------- SUBMIT BUTTON ---------- */

    .booking-submit {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        margin-top: 20px;
        padding: 16px;
        border: none;
        border-radius: 14px;
        background: linear-gradient(135deg, #F7A04A 0%, #F5817A 55%, #EE6A93 100%);
        background-size: 200% 200%;
        background-position: 0% 50%;
        color: white;
        font: inherit;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(238,106,147,0.30);
        transition: background-position .5s ease, transform .15s, box-shadow .2s;
        position: relative;
        overflow: hidden;
    }

    .booking-submit:hover {
        background-position: 100% 50%;
        box-shadow: 0 12px 26px rgba(238,106,147,0.40);
        transform: translateY(-2px);
    }

    .booking-submit:active { transform: scale(.97); }

    .booking-submit:disabled {
        opacity: .45;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    /* ---------- RIPPLE ---------- */

    .booking-submit,
    .booking-back,
    .driver-option-card { position: relative; overflow: hidden; }

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

    .js .bk-reveal { opacity: 0; transform: translateY(22px); transition: opacity .6s ease, transform .6s ease; }
    .js .bk-reveal.visible { opacity: 1; transform: none; }

    /* ---------- RESPONSIVE ---------- */

    @media(max-width: 650px) {
        .booking-hero { padding: 24px 20px; }
        .booking-hero h1 { font-size: 24px; }
        .form-section { padding: 22px 18px; }
        .booking-total-card { padding: 22px 20px; }
        .total-amount { font-size: 26px; }

        .calendar-days,
        .calendar-weekdays { gap: 5px; }

        .calendar-days button,
        .calendar-empty {
            min-height: 56px;
            border-radius: 9px;
        }

        .calendar-days button .day-stock { font-size: 9px; }
        .calendar-legend { gap: 10px; }
        .booking-meta { gap: 8px; }
    }

    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after { animation: none !important; transition: none !important; }
        .js .bk-reveal { opacity: 1; transform: none; }
    }
</style>
@endpush

@section('content')

@php
    $tanggalDipilihAwal = old('tanggal_sewa', []);
    if (!is_array($tanggalDipilihAwal)) {
        $tanggalDipilihAwal = [];
    }
    $armadaBisaDipesan =
        $armada->status_ketersediaan === 'tersedia'
        && (int) ($armada->stok ?? 1) > 0;
@endphp

<div class="booking-page">

    {{-- ========== BACK LINK ========== --}}

    <a href="{{ route('armada.index') }}" class="booking-back">
        ← Kembali ke armada
    </a>


    {{-- ========== HERO HEADER ========== --}}

    <section class="booking-hero bk-reveal">

        <h1>
            Pesan <span>{{ $armada->nama_kendaraan }}</span>
        </h1>

        <div class="booking-price">
            Rp{{ number_format($armada->harga_sewa, 0, ',', '.') }}
            <small>/ hari</small>
        </div>

        <div class="booking-meta">
            <span class="booking-meta-item">
                <span class="meta-icon">📦</span>
                Stok: <strong>{{ $armada->stok ?? 1 }} unit</strong>
            </span>
            <span class="booking-meta-item">
                <span class="meta-icon">ℹ️</span>
                Setiap tanggal yang dipilih menggunakan satu unit stok
            </span>
        </div>

        @if(!$armadaBisaDipesan)
            <div class="booking-alert-card">
                <span class="alert-icon">⚠️</span>
                Armada ini sedang tidak tersedia untuk dipesan.
            </div>
        @endif

    </section>


    {{-- ========== BOOKING FORM ========== --}}

    <form method="POST" action="{{ route('booking.store', $armada) }}" id="booking">
        @csrf

        <div class="booking-form-card bk-reveal">

            {{-- SECTION: DURASI --}}
            <div class="form-section">
                <div class="form-section-title">
                    <span class="section-icon">📅</span>
                    Durasi & Tanggal Sewa
                </div>

                <div class="bk-field">
                    <label for="durasi">Berapa hari ingin menyewa?</label>
                    <input
                        type="number"
                        name="durasi"
                        id="durasi"
                        min="1"
                        max="31"
                        value="{{ old('durasi', max(1, count($tanggalDipilihAwal))) }}"
                        required
                    >
                    <span class="field-hint">
                        Masukkan jumlah hari, lalu pilih tanggal sebanyak jumlah tersebut.
                        Tanggal tidak harus berurutan.
                    </span>
                </div>

                {{-- KALENDER --}}
                <div class="bk-field">
                    <div class="calendar-heading">
                        <div>
                            <label>Pilih tanggal sewa</label>
                            <span class="field-hint" style="margin-top:0">
                                Tanggal hanya dapat dipilih setelah hari ini
                                sampai akhir bulan ini.
                            </span>
                        </div>
                        <span class="calendar-month" id="calendar-month"></span>
                    </div>

                    <div class="calendar-legend">
                        <span><i class="legend-dot available"></i> Tersedia</span>
                        <span><i class="legend-dot limited"></i> Stok terbatas</span>
                        <span><i class="legend-dot full"></i> Penuh</span>
                        <span><i class="legend-dot chosen"></i> Dipilih</span>
                    </div>

                    <div class="calendar-weekdays">
                        @foreach(['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $hari)
                            <span>{{ $hari }}</span>
                        @endforeach
                    </div>

                    <div
                        class="calendar-days"
                        id="calendar-days"
                        aria-label="Kalender tanggal sewa"
                    ></div>

                    <div class="selected-dates-box">
                        <div class="selected-dates-title">
                            <span>Tanggal yang dipilih</span>
                            <strong id="selected-count">0</strong>
                        </div>
                        <div id="selected-dates" class="selected-date-list">
                            <span class="field-hint">Belum ada tanggal dipilih.</span>
                        </div>
                    </div>

                    <div
                        id="calendar-message"
                        class="calendar-message"
                        aria-live="polite"
                    ></div>

                    <div id="selected-inputs"></div>

                    @error('tanggal_sewa')
                        <div class="booking-error">{{ $message }}</div>
                    @enderror

                    @error('tanggal_sewa.*')
                        <div class="booking-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            {{-- SECTION: LAYANAN --}}
            <div class="form-section">
                <div class="form-section-title">
                    <span class="section-icon">🚗</span>
                    Layanan & Pengiriman
                </div>

                <div class="bk-field">
                    <label for="layanan">Layanan</label>
                    <select name="layanan" id="layanan">
                        <option
                            value="ambil"
                            @selected(old('layanan', 'ambil') === 'ambil')
                        >
                            Ambil sendiri di lokasi
                        </option>
                        <option
                            value="diantar"
                            @selected(old('layanan') === 'diantar')
                        >
                            Diantar ke alamat
                        </option>
                    </select>
                </div>

                <div class="bk-field" id="alamat">
                    <label>Alamat pengantaran</label>
                    <textarea name="alamat_antar" rows="2">{{ old('alamat_antar') }}</textarea>
                </div>

                <div class="bk-field">
                    <label>Layanan supir</label>
                    <label class="driver-option-card" id="driver-no">
                        <input type="radio" name="menggunakan_sopir" value="0" @checked(old('menggunakan_sopir', '0') === '0')>
                        <span class="driver-label">Tidak menggunakan supir</span>
                    </label>
                    <label class="driver-option-card" id="driver-yes">
                        <input type="radio" name="menggunakan_sopir" value="1" @checked(old('menggunakan_sopir', '0') === '1')>
                        <span class="driver-label">Menggunakan supir</span>
                        <span class="driver-extra">+Rp150.000/hari</span>
                    </label>
                    <span class="field-hint">Biaya supir dihitung untuk setiap tanggal sewa yang dipilih.</span>
                </div>
            </div>


            {{-- SECTION: PEMBAYARAN --}}
            <div class="form-section">
                <div class="form-section-title">
                    <span class="section-icon">💳</span>
                    Pembayaran
                </div>

                <div class="bk-field">
                    <label for="metode_pembayaran">Metode pembayaran</label>
                    <select
                        name="metode_pembayaran"
                        id="metode_pembayaran"
                        required
                    >
                        @foreach(['Transfer Bank', 'E-Wallet', 'QRIS'] as $metode)
                            <option
                                value="{{ $metode }}"
                                @selected(old('metode_pembayaran', 'Transfer Bank') === $metode)
                            >
                                {{ $metode }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>


        {{-- ========== TOTAL CARD ========== --}}

        <div class="booking-total-card bk-reveal">
            <div class="total-label">Estimasi total</div>
            <div class="total-driver-fee" id="driver-fee">Biaya supir: Rp0</div>
            <div class="total-amount" id="total">
                Rp{{ number_format($armada->harga_sewa, 0, ',', '.') }}
            </div>
            <p class="total-note">
                Harga dihitung berdasarkan jumlah tanggal yang dipilih.
                Pembayaran pada versi ini masih berupa simulasi.
            </p>
        </div>


        {{-- ========== SUBMIT ========== --}}

        <button
            type="submit"
            class="booking-submit bk-reveal"
            id="submit-booking"
            @disabled(!$armadaBisaDipesan)
        >
            Konfirmasi Pemesanan &nbsp; →
        </button>

    </form>

</div>

@endsection


@push('scripts')
<script>
(() => {
    document.documentElement.classList.add('js');
    const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const harga = {{ (float) $armada->harga_sewa }};
    const stokTotal = {{ (int) ($armada->stok ?? 1) }};
    const armadaAktif = @json($armadaBisaDipesan);
    const jumlahTerpakai = @json($jumlahTerpakai);
    const tanggalMinimal = @json($tanggalMinimal);
    const tanggalMaksimal = @json($tanggalMaksimal);
    const tanggalAwal = @json(array_values($tanggalDipilihAwal));

    const durasi = document.getElementById('durasi');
    const calendar = document.getElementById('calendar-days');
    const selectedDatesBox = document.getElementById('selected-dates');
    const selectedCount = document.getElementById('selected-count');
    const selectedInputs = document.getElementById('selected-inputs');
    const message = document.getElementById('calendar-message');
    const total = document.getElementById('total');
    const driverFee = document.getElementById('driver-fee');
    const driverInputs = document.querySelectorAll('input[name="menggunakan_sopir"]');
    const biayaSupirPerHari = 150000;
    function pakaiSupir() { return document.querySelector('input[name="menggunakan_sopir"]:checked')?.value === '1'; }
    const layanan = document.getElementById('layanan');
    const alamat = document.getElementById('alamat');
    const submit = document.getElementById('submit-booking');

    const selected = new Set(tanggalAwal);

    const [year, month, day] = tanggalMinimal.split('-').map(Number);
    const monthIndex = month - 1;
    const [maxYear, maxMonth] = tanggalMaksimal.split('-').map(Number);

    document.getElementById('calendar-month').textContent =
        new Intl.DateTimeFormat('id-ID', {
            month: 'long',
            year: 'numeric'
        }).format(new Date(maxYear, maxMonth - 1, 1));

    function formatTanggal(value) {
        const [y, m, d] = value.split('-').map(Number);
        return new Intl.DateTimeFormat('id-ID', {
            day: 'numeric',
            month: 'short',
            year: 'numeric'
        }).format(new Date(y, m - 1, d));
    }

    function tanggalString(dayNumber) {
        return `${maxYear}-${String(maxMonth).padStart(2, '0')}-${String(dayNumber).padStart(2, '0')}`;
    }

    function sisaStok(tanggal) {
        return Math.max(0, stokTotal - Number(jumlahTerpakai[tanggal] || 0));
    }

    function render() {
        calendar.innerHTML = '';

        const firstWeekday = (new Date(maxYear, maxMonth - 1, 1).getDay() + 6) % 7;
        const totalHari = new Date(maxYear, maxMonth, 0).getDate();

        for (let i = 0; i < firstWeekday; i++) {
            const empty = document.createElement('span');
            empty.className = 'calendar-empty';
            calendar.appendChild(empty);
        }

        for (let dayNumber = 1; dayNumber <= totalHari; dayNumber++) {
            const tanggal = tanggalString(dayNumber);
            const sisa = sisaStok(tanggal);
            const bolehPilih = armadaAktif && tanggal >= tanggalMinimal && tanggal <= tanggalMaksimal && sisa > 0;

            const button = document.createElement('button');
            button.type = 'button';
            button.className = sisa === 0 ? 'full' : (sisa < stokTotal ? 'limited' : 'available');

            if (selected.has(tanggal)) {
                button.classList.add('selected');
            }

            button.disabled = !bolehPilih && !selected.has(tanggal);
            button.setAttribute('aria-label', `${formatTanggal(tanggal)}, sisa ${sisa} unit`);

            const number = document.createElement('span');
            number.className = 'day-number';
            number.textContent = dayNumber;

            const stock = document.createElement('span');
            stock.className = 'day-stock';
            stock.textContent = sisa === 0 ? 'Penuh' : `${sisa} unit`;

            button.append(number, stock);

            button.addEventListener('click', () => {
                message.textContent = '';
                if (selected.has(tanggal)) {
                    selected.delete(tanggal);
                } else {
                    const jumlahHari = Math.max(1, Number(durasi.value) || 1);
                    if (selected.size >= jumlahHari) {
                        message.textContent = `Jumlah tanggal sudah mencapai durasi ${jumlahHari} hari. Hapus salah satu tanggal jika ingin mengganti.`;
                        return;
                    }
                    selected.add(tanggal);
                }
                render();
            });

            calendar.appendChild(button);
        }

        const daftarTerpilih = [...selected].sort();
        const jumlahHari = Math.max(1, Number(durasi.value) || 1);

        selectedCount.textContent = `${daftarTerpilih.length} / ${jumlahHari}`;

        selectedDatesBox.innerHTML = '';
        selectedInputs.innerHTML = '';

        if (daftarTerpilih.length === 0) {
            const empty = document.createElement('span');
            empty.className = 'field-hint';
            empty.textContent = 'Belum ada tanggal dipilih.';
            selectedDatesBox.appendChild(empty);
        }

        daftarTerpilih.forEach(tanggal => {
            const chip = document.createElement('span');
            chip.className = 'selected-date-chip';
            chip.textContent = formatTanggal(tanggal);
            selectedDatesBox.appendChild(chip);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'tanggal_sewa[]';
            input.value = tanggal;
            selectedInputs.appendChild(input);
        });

        const biayaDriver = pakaiSupir() ? biayaSupirPerHari * daftarTerpilih.length : 0;
        driverFee.textContent = 'Biaya supir: ' + new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(biayaDriver);
        total.textContent = new Intl.NumberFormat('id-ID', {
            style: 'currency', currency: 'IDR', maximumFractionDigits: 0
        }).format((harga * daftarTerpilih.length) + biayaDriver);

        submit.disabled = !armadaAktif || daftarTerpilih.length !== jumlahHari;
    }

    driverInputs.forEach(input => input.addEventListener('change', () => {
        render();
        updateDriverCards();
    }));

    durasi.addEventListener('input', () => {
        let jumlah = Math.max(1, Math.min(31, Number(durasi.value) || 1));
        durasi.value = jumlah;
        const daftar = [...selected].sort();
        while (selected.size > jumlah) {
            selected.delete(daftar.pop());
        }
        message.textContent = '';
        render();
    });

    layanan.addEventListener('change', () => {
        alamat.style.display = layanan.value === 'diantar' ? 'block' : 'none';
    });

    document.getElementById('booking').addEventListener('submit', event => {
        if (selected.size !== Number(durasi.value)) {
            event.preventDefault();
            message.textContent = `Pilih tepat ${durasi.value} tanggal sebelum melanjutkan.`;
        }
    });

    // Driver card highlight
    function updateDriverCards() {
        document.querySelectorAll('.driver-option-card').forEach(card => {
            const radio = card.querySelector('input[type="radio"]');
            card.classList.toggle('checked', radio.checked);
        });
    }

    document.querySelectorAll('.driver-option-card').forEach(card => {
        card.addEventListener('click', () => setTimeout(updateDriverCards, 10));
    });

    // Ripple effect
    document.addEventListener('click', function (e) {
        const el = e.target.closest('.booking-submit, .booking-back');
        if (!el || reduce) return;

        const rect = el.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const r = document.createElement('span');
        r.className = 'ripple';
        r.style.width = r.style.height = size + 'px';
        r.style.left = (e.clientX - rect.left - size / 2) + 'px';
        r.style.top = (e.clientY - rect.top - size / 2) + 'px';
        el.appendChild(r);
        setTimeout(() => r.remove(), 650);
    });

    // Scroll reveal
    if ('IntersectionObserver' in window) {
        const io = new IntersectionObserver(entries => {
            entries.forEach(en => {
                if (!en.isIntersecting) return;
                en.target.classList.add('visible');
                io.unobserve(en.target);
            });
        }, { threshold: 0.08 });
        document.querySelectorAll('.bk-reveal').forEach(el => io.observe(el));
    } else {
        document.querySelectorAll('.bk-reveal').forEach(el => el.classList.add('visible'));
    }

    // Init
    alamat.style.display = layanan.value === 'diantar' ? 'block' : 'none';
    updateDriverCards();
    render();
})();
</script>
@endpush
