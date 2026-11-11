
@extends('layouts.app')

@section('title', 'Daftar Armada')

@section('content')
<style>
    :root {
        --dash-bg: #080b12;
        --dash-panel: #111b27;
        --dash-panel-2: #142330;
        --dash-teal: #42d6c5;
        --dash-red: #8b2935;
        --dash-text: #f1f5f9;
        --dash-muted: #94a3b8;
    }

    .armada-container {
        min-height: 100vh;
        padding: 35px 5%;
        background: var(--dash-bg);
        color: var(--dash-text);
    }

    .armada-header {
        margin-bottom: 30px;
    }

    .armada-header h1 {
        font-size: 30px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .armada-header p {
        color: var(--dash-muted);
        font-size: 14px;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 24px;
    }

    .vehicle-card {
        background: var(--dash-panel);
        border: 1px solid #263747;
        border-radius: 14px;
        overflow: hidden;
        transition: 0.3s;
    }

    .vehicle-card:hover {
        transform: translateY(-5px);
        border-color: var(--dash-teal);
    }

    .vehicle-image {
        width: 100%;
        height: 190px;
        object-fit: contain;
        background: #ffffff;
        padding: 10px;
    }

    .vehicle-content {
        padding: 18px;
    }

    .vehicle-name {
        font-size: 19px;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .vehicle-status {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .status-available {
        background: rgba(34, 197, 94, 0.15);
        color: #4ade80;
    }

    .status-unavailable {
        background: rgba(239, 68, 68, 0.15);
        color: #f87171;
    }

    .vehicle-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 13px;
        color: var(--dash-muted);
        gap: 10px;
    }

    .vehicle-info strong {
        color: var(--dash-text);
        text-align: right;
    }

    .vehicle-price {
        border-top: 1px solid #263747;
        margin-top: 15px;
        padding-top: 15px;
        margin-bottom: 15px;
    }

    .vehicle-price small {
        color: var(--dash-muted);
        font-size: 12px;
    }

    .vehicle-price h3 {
        color: var(--dash-teal);
        font-size: 21px;
        margin-top: 4px;
    }

    .booking-button {
        display: block;
        width: 100%;
        text-align: center;
        padding: 11px;
        border-radius: 8px;
        background: var(--dash-teal);
        color: #08111b;
        font-weight: 700;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: 0.2s;
    }

    .booking-button:hover {
        background: #2bb9aa;
        color: #08111b;
    }

    .disabled-button {
        display: block;
        width: 100%;
        padding: 11px;
        text-align: center;
        border-radius: 8px;
        background: #374151;
        color: #9ca3af;
        font-weight: 600;
        cursor: not-allowed;
    }

    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: var(--dash-muted);
        background: var(--dash-panel);
        border-radius: 12px;
    }

    @media (max-width: 600px) {
        .armada-container {
            padding: 25px 4%;
        }

        .armada-header h1 {
            font-size: 24px;
        }
    }
</style>

<div class="armada-container">

    <div class="armada-header">
        <h1>Daftar Armada</h1>
        <p>Pilih kendaraan yang sesuai dengan kebutuhan perjalanan Anda.</p>
    </div>

    @if(session('success'))
        <div style="background:#14532d; color:#bbf7d0; padding:12px 16px; border-radius:8px; margin-bottom:20px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background:#7f1d1d; color:#fecaca; padding:12px 16px; border-radius:8px; margin-bottom:20px;">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid">

        @forelse($armadas as $a)

            <div class="vehicle-card">

                @if(!empty($a->gambar))
                    <img
                        class="vehicle-image"
                        src="{{ $a->gambar }}"
                        alt="{{ $a->nama_kendaraan }}"
                        loading="lazy"
                        referrerpolicy="no-referrer"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                    >

                    <div
                        class="vehicle-image"
                        style="display:none; align-items:center; justify-content:center; color:#64748b;"
                    >
                        Gambar gagal dimuat
                    </div>
                @else
                    <div
                        class="vehicle-image"
                        style="display:flex; align-items:center; justify-content:center; color:#64748b;"
                    >
                        Gambar belum tersedia
                    </div>
                @endif

                <div class="vehicle-content">

                    <h2 class="vehicle-name">
                        {{ $a->nama_kendaraan }}
                    </h2>

                    @if(strtolower($a->status_ketersediaan) === 'tersedia')
                        <span class="vehicle-status status-available">
                            Tersedia
                        </span>
                    @else
                        <span class="vehicle-status status-unavailable">
                            Tidak Tersedia
                        </span>
                    @endif

                    <div class="vehicle-info">
                        <span>Tipe Kendaraan</span>
                        <strong>{{ $a->tipe }}</strong>
                    </div>

                    <div class="vehicle-info">
                        <span>Transmisi</span>
                        <strong>{{ $a->transmisi }}</strong>
                    </div>

                    <div class="vehicle-info">
                        <span>Plat Nomor</span>
                        <strong>{{ $a->plat_nomor }}</strong>
                    </div>

                    <div class="vehicle-price">
                        <small>Harga Sewa / Hari</small>
                        <h3>
                            Rp {{ number_format($a->harga_sewa, 0, ',', '.') }}
                        </h3>
                    </div>

                    @if(strtolower($a->status_ketersediaan) === 'tersedia')

                        @if(session('role') === 'customer')
                            <a
                                href="{{ route('booking.create', $a) }}"
                                class="booking-button"
                            >
                                Pesan Sekarang
                            </a>

                        @elseif(session('role') === 'admin')
                            <span class="disabled-button">
                                Mode Admin
                            </span>

                        @else
                            <a
                                href="{{ route('login') }}"
                                class="booking-button"
                            >
                                Login untuk Memesan
                            </a>
                        @endif

                    @else
                        <span class="disabled-button">
                            Kendaraan Tidak Tersedia
                        </span>
                    @endif

                </div>
            </div>

        @empty
            <div class="empty-state">
                <h3>Belum Ada Armada</h3>
                <p>Data kendaraan belum tersedia.</p>
            </div>
        @endforelse

    </div>

</div>
@endsection
