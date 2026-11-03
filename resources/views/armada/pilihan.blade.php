@extends('layouts.app')

@section('title', 'Pilih Jenis Armada')

@section('content')
<style>
    :root {
        --dash-bg: #080b12;
        --dash-panel: #111b27;
        --dash-panel-2: #142330;
        --dash-teal: #42d6c5;
        --dash-red: #8b2935;
        --dash-text: #f4f7fb;
        --dash-muted: #a2adbb;
        --dash-border: rgba(255,255,255,.09);
    }

    /* Memastikan background seluruh halaman cocok dengan tema gelap */
    body {
        background-color: var(--dash-bg) !important;
        color: var(--dash-text) !important;
    }

    .customer-armada {
        color: var(--dash-text);
        font-family: 'DM Sans', 'Segoe UI', sans-serif;
        padding: 20px 0;
    }

    .customer-armada * {
        box-sizing: border-box;
    }

    .customer-armada .muted {
        color: var(--dash-muted);
    }

    .customer-armada .page-header {
        margin-bottom: 30px;
    }

    .customer-armada .page-header h1 {
        margin: 0 0 8px;
        font-size: clamp(24px, 4vw, 32px);
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    .customer-armada .page-header p {
        margin: 0;
        font-size: 14px;
        line-height: 1.6;
    }

    .customer-armada .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }

    .customer-armada .card {
        position: relative;
        display: flex;
        flex-direction: column;
        padding: 24px;
        border: 1px solid var(--dash-border);
        border-radius: 16px;
        background: linear-gradient(145deg, rgba(20,35,48,.98), rgba(12,19,29,.98));
        transition: transform .2s, border-color .2s;
    }

    .customer-armada .card:hover {
        transform: translateY(-4px);
        border-color: rgba(66,214,197,.35);
    }

    .customer-armada .card h2 {
        margin: 16px 0 6px;
        font-size: 20px;
        font-weight: 800;
        color: #fff;
    }

    .customer-armada .card .specs {
        margin: 0 0 16px;
        font-size: 13px;
        line-height: 1.6;
    }

    .customer-armada .price {
        margin: auto 0 20px;
        padding-top: 16px;
        border-top: 1px solid var(--dash-border);
        color: var(--dash-teal);
        font-size: 24px;
        font-weight: 800;
    }

    .customer-armada .price small {
        color: var(--dash-muted);
        font-size: 13px;
        font-weight: 600;
    }

    .customer-armada .tag {
        align-self: flex-start;
        padding: 6px 12px;
        border: 1px solid rgba(66,214,197,.2);
        border-radius: 20px;
        background: rgba(66,214,197,.08);
        color: var(--dash-teal);
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .customer-armada .btn {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        min-height: 42px;
        padding: 11px 17px;
        border: 1px solid var(--dash-teal);
        border-radius: 10px;
        background: var(--dash-teal);
        color: #071311;
        font-size: 13px;
        font-weight: 800;
        text-decoration: none;
        transition: .2s ease;
        cursor: pointer;
    }

    .customer-armada .btn:hover {
        transform: translateY(-2px);
        filter: brightness(1.06);
    }
</style>

<div class="customer-armada">
    <div class="page-header">
        <h1>Pilih Jenis Armada</h1>
        <p class="muted">Silakan pilih kategori armada yang ingin Anda cari.</p>
    </div>

    <div class="grid">
        {{-- Kartu 1: Motor --}}
        <article class="card">
            <span class="tag">Kategori</span>
            <h2>Motor</h2>
            <div class="specs muted">
                <div>Pilihan kendaraan roda dua yang lincah dan hemat untuk perjalanan perkotaan.</div>
            </div>
            <div class="price">
                Mulai Rp50.000 <small>/ hari</small>
            </div>
            <a class="btn" href="{{ route('armada.index') }}">Lihat Daftar Armada</a>
        </article>

        {{-- Kartu 2: Mobil --}}
        <article class="card">
            <span class="tag">Kategori</span>
            <h2>Mobil</h2>
            <div class="specs muted">
                <div>Berbagai pilihan mobil keluarga, city car, hingga SUV untuk kenyamanan Anda.</div>
            </div>
            <div class="price">
                Mulai Rp250.000 <small>/ hari</small>
            </div>
            <a class="btn" href="{{ route('armada.index') }}">Lihat Daftar Armada</a>
        </article>

        {{-- Kartu 3: Travel --}}
        <article class="card">
            <span class="tag">Kategori</span>
            <h2>Travel</h2>
            <div class="specs muted">
                <div>Armada berkapasitas besar seperti minibus dan hiace, cocok untuk rombongan.</div>
            </div>
            <div class="price">
                Mulai Rp600.000 <small>/ hari</small>
            </div>
            <a class="btn" href="{{ route('armada.index') }}">Lihat Daftar Armada</a>
        </article>
    </div>
</div>
@endsection