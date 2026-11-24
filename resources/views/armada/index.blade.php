@extends('layouts.app')

@section('title', 'Daftar Armada')

@section('content')
<style>
    .armada-page {
        background: #fafafa;
        min-height: 100vh;
        padding: 55px 7%;
        color: #252525;
    }

    .armada-heading {
        display: flex;
        justify-content: space-between;
        align-items: end;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 35px;
    }

    .armada-heading h1 {
        font-size: 32px;
        font-weight: 800;
        margin: 0 0 8px;
        color: #222;
    }

    .armada-heading p {
        color: #777;
        margin: 0;
        font-size: 15px;
    }

    .armada-filter select {
        padding: 11px 15px;
        border: 1px solid #e5e5e5;
        border-radius: 9px;
        background: white;
        color: #333;
        font-size: 14px;
        outline: none;
        cursor: pointer;
    }

    .armada-filter select:focus {
        border-color: #f07835;
    }

    .armada-alert {
        padding: 13px 17px;
        border-radius: 9px;
        margin-bottom: 22px;
        font-size: 14px;
    }

    .armada-alert.success {
        background: #e8f7ed;
        color: #247442;
    }

    .armada-alert.error {
        background: #fdecec;
        color: #a83232;
    }

    .armada-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 25px;
    }

    .armada-card {
        background: white;
        border: 1px solid #ededed;
        border-radius: 13px;
        overflow: hidden;
        transition: transform .25s, box-shadow .25s;
    }

    .armada-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, .07);
    }

    .armada-image {
        width: 100%;
        height: 205px;
        object-fit: contain;
        padding: 12px;
        background: #f5f5f5;
    }

    .armada-image-fallback {
        width: 100%;
        height: 205px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f5f5f5;
        color: #999;
        font-size: 14px;
    }

    .armada-content {
        padding: 21px;
    }

    .armada-name {
        font-size: 19px;
        font-weight: 750;
        margin: 0 0 13px;
        color: #252525;
    }

    .armada-status {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 650;
        margin-bottom: 17px;
    }

    .armada-status.available {
        background: #e8f7ed;
        color: #25834a;
    }

    .armada-status.unavailable {
        background: #fdecec;
        color: #c23b3b;
    }

    .armada-info {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 12px;
        font-size: 13px;
    }

    .armada-info span {
        color: #888;
    }

    .armada-info strong {
        color: #333;
        text-align: right;
        font-weight: 600;
    }

    .armada-price {
        border-top: 1px solid #eee;
        margin-top: 17px;
        padding-top: 16px;
        margin-bottom: 17px;
    }

    .armada-price small {
        color: #888;
        font-size: 12px;
    }

    .armada-price h3 {
        color: #ed7130;
        font-size: 22px;
        font-weight: 800;
        margin: 5px 0 0;
    }

    .armada-booking-button {
        display: block;
        width: 100%;
        text-align: center;
        padding: 12px;
        border-radius: 8px;
        background: #f07835;
        color: white;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        border: none;
        transition: background .2s;
    }

    .armada-booking-button:hover {
        background: #d96120;
        color: white;
    }

    .armada-disabled-button {
        display: block;
        width: 100%;
        padding: 12px;
        text-align: center;
        border-radius: 8px;
        background: #eee;
        color: #999;
        font-size: 14px;
        font-weight: 600;
    }

    .armada-empty {
        grid-column: 1 / -1;
        background: white;
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 55px 20px;
        text-align: center;
        color: #888;
    }

    .armada-empty h3 {
        color: #333;
        margin-bottom: 8px;
    }

    @media (max-width: 950px) {
        .armada-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .armada-page {
            padding: 35px 5%;
        }

        .armada-heading h1 {
            font-size: 26px;
        }

        .armada-grid {
            grid-template-columns: 1fr;
        }

        .armada-filter,
        .armada-filter select {
            width: 100%;
        }
    }
</style>

<div class="armada-page">

    <div class="armada-heading">
        <div>
            <h1>Daftar Armada</h1>
            <p>Temukan kendaraan yang sesuai untuk perjalanan Anda.</p>
        </div>

        <form method="GET" action="{{ route('armada.index') }}" class="armada-filter">
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

    <div class="armada-grid">

        @forelse($armadas as $a)

            <div class="armada-card">

                @if(!empty($a->gambar))
                    <img
                        class="armada-image"
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

                <div class="armada-content">

                    <h2 class="armada-name">
                        {{ $a->nama_kendaraan }}
                    </h2>

                    @if(strtolower($a->status_ketersediaan) === 'tersedia')
                        <span class="armada-status available">
                            Tersedia
                        </span>
                    @else
                        <span class="armada-status unavailable">
                            Tidak Tersedia
                        </span>
                    @endif

                    <div class="armada-info">
                        <span>Tipe Kendaraan</span>
                        <strong>{{ $a->tipe }}</strong>
                    </div>

                    <div class="armada-info">
                        <span>Transmisi</span>
                        <strong>{{ $a->transmisi }}</strong>
                    </div>

                    <div class="armada-info">
                        <span>Plat Nomor</span>
                        <strong>{{ $a->plat_nomor }}</strong>
                    </div>

                    <div class="armada-price">
                        <small>Harga Sewa / Hari</small>
                        <h3>
                            Rp {{ number_format($a->harga_sewa, 0, ',', '.') }}
                        </h3>
                    </div>

                    @if(strtolower($a->status_ketersediaan) === 'tersedia')

                        @if(session('role') === 'customer')
                            <a
                                href="{{ route('booking.create', $a) }}"
                                class="armada-booking-button"
                            >
                                Pesan Sekarang
                            </a>

                        @elseif(session('role') === 'admin')
                            <span class="armada-disabled-button">
                                Mode Admin
                            </span>

                        @else
                            <a
                                href="{{ route('login') }}"
                                class="armada-booking-button"
                            >
                                Login untuk Memesan
                            </a>
                        @endif

                    @else
                        <span class="armada-disabled-button">
                            Kendaraan Tidak Tersedia
                        </span>
                    @endif

                </div>
            </div>

        @empty
            <div class="armada-empty">
                <h3>Belum Ada Armada</h3>
                <p>Data kendaraan belum tersedia.</p>
            </div>
        @endforelse

    </div>
</div>
@endsection
