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

    .customer-armada .tag.red {
        border-color: rgba(255,137,150,.2);
        background: rgba(139,41,53,.17);
        color: #ff9ba5;
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

    .customer-armada .status-note {
        display: block;
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        background: rgba(255,255,255,.04);
        border: 1px solid var(--dash-border);
        text-align: center;
        font-size: 12px;
        font-weight: 600;
    }

    .customer-armada .empty-state {
        grid-column: 1 / -1;
        padding: 50px 20px;
        border: 1px dashed var(--dash-border);
        border-radius: 16px;
        text-align: center;
        color: var(--dash-muted);
        background: rgba(255,255,255,.01);
    }
</style>

<div class="customer-armada">
    <div class="page-header">
        <h1>Daftar Armada</h1>
        <p class="muted">Harga ditampilkan per hari. Ketersediaan akhir diperiksa saat pemesanan.</p>
    </div>

    <div class="grid">
        @forelse($armadas as $a)
            <article class="card">
                {{-- Logika warna tag: hijau (teal) jika tersedia, merah jika disewa/perawatan --}}
                <span class="tag {{ $a->status_ketersediaan === 'tersedia' ? '' : 'red' }}">
                    {{ $a->status_ketersediaan }}
                </span>

                <h2>{{ $a->nama_kendaraan }}</h2>

                <div class="specs muted">
                    <div>Tipe: {{ $a->tipe }} &nbsp;&middot;&nbsp; Transmisi: {{ $a->transmisi ?: '-' }}</div>
                    <div>Plat: {{ $a->plat_nomor ?: 'Belum dicatat' }}</div>
                </div>

                <div class="price">
                    Rp{{ number_format($a->harga_sewa, 0, ',', '.') }}
                    <small>/ hari</small>
                </div>

                @if($a->status_ketersediaan === 'tersedia')
                    @if(session('role') === 'customer')
                        <a class="btn" href="{{ route('booking.create', $a) }}">Pesan Kendaraan</a>
                    @elseif(!session('role'))
                        <a class="btn" href="{{ route('login') }}">Login untuk Memesan</a>
                    @else
                        <span class="status-note muted">Mode Admin Aktif</span>
                    @endif
                @else
                    <span class="status-note muted">Tidak Tersedia Saat Ini</span>
                @endif
            </article>
        @empty
            <div class="empty-state">
                <div style="font-size: 32px; margin-bottom: 12px; color: var(--dash-border);">▣</div>
                Belum ada armada di database.<br>Admin dapat menambahkan armada melalui menu Kelola Armada.
            </div>
        @endforelse
    </div>
</div>
@endsection