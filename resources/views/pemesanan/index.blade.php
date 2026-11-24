
@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')

<style>
    .orders-page {
        max-width: 1100px;
        margin: 0 auto;
        padding: 30px 20px 60px;
        color: #252525;
    }

    .orders-header {
        margin-bottom: 30px;
    }

    .orders-header h1 {
        font-size: 30px;
        font-weight: 750;
        margin: 0 0 8px;
        letter-spacing: -0.8px;
    }

    .orders-header p {
        color: #777;
        margin: 0;
        font-size: 14px;
    }

    .orders-list {
        display: grid;
        gap: 20px;
    }

    .order-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.035);
    }

    .order-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        padding-bottom: 18px;
        border-bottom: 1px solid #f0f0f0;
    }

    .order-number {
        font-size: 13px;
        color: #888;
        font-weight: 600;
    }

    .order-status {
        display: inline-block;
        padding: 7px 13px;
        border-radius: 30px;
        background: #fff2e8;
        color: #e87524;
        font-size: 12px;
        font-weight: 700;
    }

    .order-status.status-success {
        background: #e8f7ed;
        color: #25834a;
    }

    .order-status.status-danger {
        background: #ffeded;
        color: #d64040;
    }

    .order-status.status-info {
        background: #eaf2ff;
        color: #3474c8;
    }

    .order-vehicle {
        margin: 20px 0;
    }

    .order-vehicle h2 {
        font-size: 21px;
        font-weight: 750;
        margin: 0 0 5px;
    }

    .order-vehicle p {
        color: #888;
        font-size: 13px;
        margin: 0;
    }

    .order-details {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
        margin: 22px 0;
    }

    .detail-item {
        background: #fafafa;
        border-radius: 10px;
        padding: 13px 15px;
        min-width: 0;
    }

    .detail-label {
        display: block;
        color: #888;
        font-size: 12px;
        margin-bottom: 6px;
    }

    .detail-value {
        display: block;
        font-size: 14px;
        font-weight: 650;
        color: #333;
        overflow-wrap: anywhere;
    }

    .order-payment {
        background: #fff9f4;
        border: 1px solid #ffeadb;
        border-radius: 12px;
        padding: 16px;
        margin-top: 20px;
    }

    .order-payment h3 {
        font-size: 14px;
        margin: 0 0 10px;
        font-weight: 750;
    }

    .payment-info {
        font-size: 13px;
        color: #666;
        margin: 0;
    }

    .payment-info strong {
        color: #333;
    }

    .order-actions {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
        margin-top: 18px;
    }

    .order-actions form {
        margin: 0;
    }

    .order-actions select {
        min-width: 160px;
        padding: 11px 13px;
        border: 1px solid #ddd;
        border-radius: 9px;
        background: #fff;
        font-size: 13px;
    }

    .order-actions button {
        border: none;
        border-radius: 9px;
        padding: 11px 17px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-payment {
        background: #f47b2a;
        color: #fff;
    }

    .btn-payment:hover {
        background: #dd671c;
    }

    .btn-cancel {
        background: #fff;
        color: #d64545;
        border: 1px solid #f0caca !important;
    }

    .btn-cancel:hover {
        background: #fff0f0;
    }

    .empty-orders {
        text-align: center;
        padding: 65px 20px;
        background: #fff;
        border: 1px dashed #ddd;
        border-radius: 16px;
    }

    .empty-icon {
        font-size: 42px;
        margin-bottom: 14px;
    }

    .empty-orders h2 {
        font-size: 19px;
        margin: 0 0 8px;
    }

    .empty-orders p {
        color: #888;
        font-size: 14px;
        margin: 0 0 20px;
    }

    .btn-browse {
        display: inline-block;
        background: #f47b2a;
        color: #fff;
        text-decoration: none;
        padding: 11px 20px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 700;
    }

    .btn-browse:hover {
        background: #dd671c;
    }

    .order-alert {
        padding: 13px 16px;
        border-radius: 10px;
        margin-bottom: 18px;
        font-size: 13px;
    }

    .order-alert.success {
        background: #eaf7ee;
        color: #247a42;
    }

    .order-alert.error {
        background: #fff0f0;
        color: #c43d3d;
    }

    @media (max-width: 600px) {
        .orders-page {
            padding: 22px 14px 40px;
        }

        .orders-header h1 {
            font-size: 25px;
        }

        .order-card {
            padding: 18px;
        }

        .order-details {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .order-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .order-actions form,
        .order-actions select,
        .order-actions button {
            width: 100%;
        }
    }
</style>

<div class="orders-page">

    {{-- Header halaman --}}
    <div class="orders-header">
        <h1>Pesanan Saya</h1>
        <p>Lihat riwayat pemesanan dan pantau status penyewaan kendaraan kamu.</p>
    </div>

    {{-- Notifikasi berhasil --}}
    @if(session('success'))
        <div class="order-alert success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Notifikasi error --}}
    @if($errors->any())
        <div class="order-alert error">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="orders-list">

        @forelse($orders as $o)

            <article class="order-card">

                {{-- Bagian atas kartu pesanan --}}
                <div class="order-top">

                    <span class="order-number">
                        ID PESANAN #{{ $o->id_pemesanan }}
                    </span>

                    @php
                        $statusClass = match($o->status) {
                            'Selesai' => 'status-success',
                            'Dibatalkan' => 'status-danger',
                            'Dikonfirmasi', 'Dalam Perjalanan' => 'status-info',
                            default => '',
                        };
                    @endphp

                    <span class="order-status {{ $statusClass }}">
                        {{ $o->status }}
                    </span>

                </div>

                {{-- Informasi kendaraan --}}
                <div class="order-vehicle">
                    <h2>
                        {{ $o->armada->nama_kendaraan ?? 'Kendaraan tidak tersedia' }}
                    </h2>

                    <p>
                        {{ $o->armada->tipe ?? 'Informasi kendaraan tidak tersedia' }}
                    </p>
                </div>

                {{-- Detail pesanan --}}
                <div class="order-details">

                    <div class="detail-item">
                        <span class="detail-label">Tanggal Sewa</span>

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
                        <span class="detail-label">Durasi Sewa</span>
                        <span class="detail-value">
                            {{ $o->durasi }} Hari
                        </span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">Layanan</span>
                        <span class="detail-value">
                            {{ $o->layanan === 'diantar' ? 'Diantar ke alamat' : 'Ambil sendiri' }}
                        </span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">Sopir</span>
                        <span class="detail-value">
                            {{ $o->sopir->nama ?? 'Belum ditugaskan' }}
                        </span>
                    </div>

                </div>

                {{-- Total biaya --}}
                <div class="detail-item">
                    <span class="detail-label">Total Pembayaran</span>

                    <span class="detail-value" style="color:#ed7626; font-size:19px;">
                        Rp{{ number_format($o->total_biaya, 0, ',', '.') }}
                    </span>
                </div>

                {{-- Informasi pembayaran --}}
                <div class="order-payment">

                    <h3>Informasi Pembayaran</h3>

                    <p class="payment-info">
                        Status:
                        <strong>
                            {{ $o->pembayaran->status_pembayaran ?? 'Belum dicatat' }}
                        </strong>
                    </p>

                    <p class="payment-info" style="margin-top:5px;">
                        Metode:
                        <strong>
                            {{ $o->pembayaran->metode_pembayaran ?? '-' }}
                        </strong>
                    </p>

                    {{-- Mengubah metode pembayaran --}}
                    @if($o->status === 'Menunggu Pembayaran')

                        <form
                            method="POST"
                            action="{{ route('booking.pay', $o) }}"
                            class="order-actions"
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

                {{-- Tombol pembatalan --}}
                @if(in_array($o->status, [
                    'Menunggu Pembayaran',
                    'Menunggu Konfirmasi'
                ]))

                    <div class="order-actions">

                        <form
                            method="POST"
                            action="{{ route('booking.cancel', $o) }}"
                            onsubmit="return confirm('Apakah kamu yakin ingin membatalkan pesanan ini?')"
                        >
                            @csrf

                            <button type="submit" class="btn-cancel">
                                Batalkan Pesanan
                            </button>
                        </form>

                    </div>

                @endif

            </article>

        @empty

            {{-- Tampilan jika belum memiliki pesanan --}}
            <div class="empty-orders">

                <div class="empty-icon">🚗</div>

                <h2>Belum Ada Pesanan</h2>

                <p>
                    Kamu belum memiliki riwayat penyewaan kendaraan.
                    Yuk, temukan kendaraan yang sesuai dengan kebutuhanmu!
                </p>

                <a href="{{ route('armada.index') }}" class="btn-browse">
                    Lihat Daftar Kendaraan
                </a>

            </div>

        @endforelse

    </div>

</div>

@endsection
