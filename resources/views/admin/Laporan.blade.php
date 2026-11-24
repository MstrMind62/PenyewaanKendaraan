
@extends('layouts.admin')

@section('title', 'Laporan Penjualan')
@section('page-heading', 'Laporan Penjualan')

@section('content')

<style>


.report-container {
    max-width: 1200px;
    margin: 35px auto;
    padding: 0 20px;
    color: #E2E8F0;
}

.report-header {
    margin-bottom: 25px;
}

.report-header h2 {
    font-size: 27px;
    font-weight: 700;
    margin-bottom: 7px;
    color: #F1F5F9;
}

.report-header p {
    color: #94A3B8;
}

.report-cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-bottom: 25px;
}

.report-card,
.report-section {
    background: #111827;
    color: #E2E8F0;
    border: 1px solid #263449;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 14px rgba(0,0,0,.15);
}

.report-card small {
    color: #94A3B8;
    display: block;
    margin-bottom: 12px;
}

.report-card h3 {
    font-size: 23px;
    color: #60A5FA;
    margin: 0;
    font-weight: 700;
}

.report-section {
    margin-bottom: 25px;
    padding: 22px;
}

.report-section h3 {
    font-size: 18px;
    color: #F1F5F9;
    margin-bottom: 20px;
    font-weight: 700;
}

.filter-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    align-items: end;
}

.filter-field label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #CBD5E1;
    margin-bottom: 8px;
}

.filter-field input,
.filter-field select {
    width: 100%;
    padding: 11px;
    color: #E2E8F0;
    background: #1E293B;
    border: 1px solid #334155;
    border-radius: 8px;
    box-sizing: border-box;
    color-scheme: dark;
}

.filter-field input:focus,
.filter-field select:focus {
    outline: none;
    border-color: #3B82F6;
    box-shadow: 0 0 0 2px rgba(59,130,246,.2);
}

.report-button {
    padding: 11px 18px;
    border: 0;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    background: #2563EB;
    color: #F8FAFC;
    transition: background .2s;
}

.report-button:hover {
    background: #1D4ED8;
}

.report-button.reset {
    background: #334155;
    color: #E2E8F0;
    text-decoration: none;
    display: inline-block;
}

.report-button.reset:hover {
    background: #475569;
}

.report-table-wrapper {
    overflow-x: auto;
}

.report-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 900px;
    color: #CBD5E1;
    background: #111827;
}

.report-table th,
.report-table td {
    padding: 13px;
    text-align: left;
    border-bottom: 1px solid #263449;
    font-size: 13px;
    color: #CBD5E1;
}

.report-table th {
    background: #1E293B;
    color: #F1F5F9;
    font-weight: 700;
}

.report-table tbody tr:hover {
    background: #1A2638;
}

.status {
    display: inline-block;
    padding: 6px 10px;
    border-radius: 20px;
    font-size: 12px;
    background: #1E3A8A;
    color: #BFDBFE;
}

.status.selesai {
    background: #14532D;
    color: #BBF7D0;
}

.status.batal {
    background: #7F1D1D;
    color: #FECACA;
}

.status.menunggu {
    background: #78350F;
    color: #FDE68A;
}

.report-actions {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 15px;
}

.empty-report {
    text-align: center;
    padding: 35px;
    color: #94A3B8;
}

@media(max-width: 900px) {
    .report-cards {
        grid-template-columns: repeat(2, 1fr);
    }

    .filter-grid {
        grid-template-columns: 1fr;
    }
}

@media(max-width: 500px) {
    .report-cards {
        grid-template-columns: 1fr;
    }
}

@media print {
    nav,
    header,
    footer,
    .no-print,
    .report-actions {
        display: none !important;
    }

    .report-container {
        max-width: 100%;
        margin: 0;
    }

    .report-section,
    .report-card {
        box-shadow: none;
    }

    body {
        background: #fff !important;
        color: #111827 !important;
    }

    .report-card,
    .report-section,
    .report-table {
        background: #fff !important;
        color: #111827 !important;
    }

    .report-header h2,
    .report-header p,
    .report-section h3,
    .report-table th,
    .report-table td {
        color: #111827 !important;
    }
}


</style>

<div class="report-container">

    <div class="report-header">
        <h2>Laporan Penyewaan</h2>
        <p>Kelola dan pantau seluruh transaksi penyewaan kendaraan.</p>
    </div>

    @if(session('success'))
        <div style="padding:12px;background:#dcfce7;color:#166534;border-radius:8px;margin-bottom:18px">
            {{ session('success') }}
        </div>
    @endif

    {{-- KARTU RINGKASAN --}}
    <div class="report-cards">

        <div class="report-card">
            <small>Total Penyewaan</small>
            <h3>{{ $totalPemesanan }}</h3>
        </div>

        <div class="report-card">
            <small>Total Pendapatan</small>
            <h3>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
        </div>

        <div class="report-card">
            <small>Penyewaan Aktif</small>
            <h3>{{ $pemesananAktif }}</h3>
        </div>

        <div class="report-card">
            <small>Menunggu Proses</small>
            <h3>{{ $pemesananMenunggu }}</h3>
        </div>

    </div>

    {{-- FILTER LAPORAN --}}
    <div class="report-section no-print">

        <h3>Filter Laporan</h3>

        <form action="{{ route('admin.laporan') }}" method="GET">

            <div class="filter-grid">

                <div class="filter-field">
                    <label>Tanggal Mulai</label>
                    <input
                        type="date"
                        name="tanggal_mulai"
                        value="{{ $filters['tanggal_mulai'] ?? '' }}"
                    >
                </div>

                <div class="filter-field">
                    <label>Tanggal Akhir</label>
                    <input
                        type="date"
                        name="tanggal_selesai"
                        value="{{ $filters['tanggal_selesai'] ?? '' }}"
                    >
                </div>

                <div class="filter-field">
                    <label>Status Penyewaan</label>

                    <select name="status">
                        <option value="">Semua Status</option>

                        @foreach([
                            'Menunggu Pembayaran',
                            'Menunggu Konfirmasi',
                            'Dikonfirmasi',
                            'Dalam Perjalanan',
                            'Selesai',
                            'Dibatalkan'
                        ] as $status)

                            <option
                                value="{{ $status }}"
                                @selected(($filters['status'] ?? '') === $status)
                            >
                                {{ $status }}
                            </option>

                        @endforeach

                    </select>
                </div>

            </div>

            <div style="margin-top:18px;display:flex;gap:10px;flex-wrap:wrap">

                <button type="submit" class="report-button">
                    Terapkan Filter
                </button>

                <a href="{{ route('admin.laporan') }}" class="report-button reset">
                    Reset
                </a>

            </div>

        </form>

    </div>

    {{-- TABEL TRANSAKSI --}}
    <div class="report-section">

        <div class="report-actions">
            <button
                type="button"
                onclick="window.print()"
                class="report-button no-print"
            >
                Cetak / Simpan PDF
            </button>
        </div>

        <h3>Data Transaksi Penyewaan</h3>

        <div class="report-table-wrapper">

            <table class="report-table">

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>ID Pesanan</th>
                        <th>Customer</th>
                        <th>Kendaraan</th>
                        <th>Tanggal Sewa</th>
                        <th>Durasi</th>
                        <th>Total Biaya</th>
                        <th>Pembayaran</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($orders as $index => $pesanan)

                        @php
                            $statusClass = match($pesanan->status) {
                                'Selesai' => 'selesai',
                                'Dibatalkan' => 'batal',
                                'Menunggu Pembayaran',
                                'Menunggu Konfirmasi' => 'menunggu',
                                default => ''
                            };
                        @endphp

                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>
                                #{{ $pesanan->id_pemesanan }}
                            </td>

                            <td>
                                {{ $pesanan->customer?->nama ?? '-' }}
                            </td>

                            <td>
                                {{ $pesanan->armada?->nama_kendaraan ?? '-' }}
                            </td>

                            <td>
                                {{ $pesanan->tanggal_sewa
                                    ? \Carbon\Carbon::parse($pesanan->tanggal_sewa)->format('d-m-Y')
                                    : '-' }}
                            </td>

                            <td>
                                {{ $pesanan->durasi }} hari
                            </td>

                            <td>
                                Rp {{ number_format($pesanan->total_biaya ?? 0, 0, ',', '.') }}
                            </td>

                            <td>
                                {{ $pesanan->pembayaran?->status_pembayaran ?? 'Belum ada' }}
                            </td>

                            <td>
                                <span class="status {{ $statusClass }}">
                                    {{ $pesanan->status }}
                                </span>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="9" class="empty-report">
                                Belum ada data penyewaan.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
