
@extends('layouts.app')

@section('title', 'Dashboard Admin')

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

    .admin-dashboard {
        color: var(--dash-text);
        font-family: 'DM Sans', 'Segoe UI', sans-serif;
    }

    .admin-dashboard * {
        box-sizing: border-box;
    }

    .admin-dashboard .muted {
        color: var(--dash-muted);
    }

    .admin-dashboard .dashboard-hero {
        position: relative;
        overflow: hidden;
        padding: 32px;
        margin-bottom: 26px;
        border: 1px solid var(--dash-border);
        border-radius: 20px;
        background:
            radial-gradient(circle at 90% 20%, rgba(139,41,53,.3), transparent 35%),
            radial-gradient(circle at 75% 100%, rgba(66,214,197,.12), transparent 40%),
            linear-gradient(135deg, #111e2b, #0b111a);
    }

    .admin-dashboard .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
        color: var(--dash-teal);
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .admin-dashboard .eyebrow::before {
        content: '';
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--dash-teal);
        box-shadow: 0 0 12px rgba(66,214,197,.65);
    }

    .admin-dashboard .dashboard-hero h1 {
        margin: 0 0 10px;
        font-size: clamp(27px, 4vw, 38px);
        line-height: 1.2;
        font-weight: 800;
        letter-spacing: -1px;
    }

    .admin-dashboard .dashboard-hero h1 span {
        color: var(--dash-teal);
    }

    .admin-dashboard .dashboard-hero p {
        max-width: 650px;
        margin: 0;
        color: var(--dash-muted);
        font-size: 14px;
        line-height: 1.8;
    }

    .admin-dashboard .hero-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 18px;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid var(--dash-border);
    }

    .admin-dashboard .hero-note {
        color: #d1d8e0;
        font-size: 12px;
    }

    .admin-dashboard .hero-note strong {
        color: var(--dash-teal);
    }

    .admin-dashboard .actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .admin-dashboard .btn {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 9px;
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

    .admin-dashboard .btn:hover {
        transform: translateY(-2px);
        filter: brightness(1.06);
    }

    .admin-dashboard .btn.secondary {
        border-color: var(--dash-border);
        background: rgba(255,255,255,.04);
        color: var(--dash-text);
    }

    .admin-dashboard .section-heading {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 14px;
        flex-wrap: wrap;
        margin: 30px 0 15px;
    }

    .admin-dashboard .section-heading h2 {
        margin: 0;
        font-size: 19px;
        font-weight: 800;
    }

    .admin-dashboard .section-heading p {
        margin: 4px 0 0;
        color: var(--dash-muted);
        font-size: 12px;
    }

    .admin-dashboard .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 25px;
    }

    .admin-dashboard .stat-card {
        position: relative;
        overflow: hidden;
        min-width: 0;
        padding: 22px;
        border: 1px solid var(--dash-border);
        border-radius: 16px;
        background: linear-gradient(145deg, rgba(20,35,48,.98), rgba(12,19,29,.98));
        transition: transform .2s, border-color .2s;
    }

    .admin-dashboard .stat-card:hover {
        transform: translateY(-3px);
        border-color: rgba(66,214,197,.35);
    }

    .admin-dashboard .stat-card::after {
        position: absolute;
        right: -22px;
        bottom: -38px;
        width: 100px;
        height: 100px;
        content: '';
        border-radius: 50%;
        background: rgba(66,214,197,.06);
    }

    .admin-dashboard .stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .admin-dashboard .stat-label {
        color: var(--dash-muted);
        font-size: 12px;
        font-weight: 600;
    }

    .admin-dashboard .stat-icon {
        display: grid;
        place-items: center;
        flex-shrink: 0;
        width: 38px;
        height: 38px;
        border: 1px solid rgba(66,214,197,.2);
        border-radius: 11px;
        background: rgba(66,214,197,.09);
        color: var(--dash-teal);
        font-size: 18px;
    }

    .admin-dashboard .stat-card.red .stat-icon {
        border-color: rgba(255,115,130,.2);
        background: rgba(139,41,53,.2);
        color: #ff8996;
    }

    .admin-dashboard .stat-number {
        margin-top: 18px;
        font-size: clamp(27px, 3vw, 34px);
        line-height: 1.2;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .admin-dashboard .stat-foot {
        margin-top: 9px;
        color: var(--dash-muted);
        font-size: 11px;
    }

    .admin-dashboard .stat-foot span {
        color: var(--dash-teal);
    }

    .admin-dashboard .content-card {
        min-width: 0;
        overflow: hidden;
        border: 1px solid var(--dash-border);
        border-radius: 16px;
        background: rgba(15,24,35,.92);
    }

    .admin-dashboard .card-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        padding: 20px 22px;
        border-bottom: 1px solid var(--dash-border);
    }

    .admin-dashboard .card-heading h3 {
        margin: 0;
        font-size: 15px;
        font-weight: 800;
    }

    .admin-dashboard .card-heading p {
        margin: 4px 0 0;
        color: var(--dash-muted);
        font-size: 12px;
    }

    .admin-dashboard .badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 5px 9px;
        border: 1px solid rgba(66,214,197,.2);
        border-radius: 20px;
        background: rgba(66,214,197,.08);
        color: var(--dash-teal);
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .admin-dashboard .badge.red {
        border-color: rgba(255,137,150,.2);
        background: rgba(139,41,53,.17);
        color: #ff9ba5;
    }

    .admin-dashboard .table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .admin-dashboard table {
        width: 100%;
        min-width: 930px;
        border-collapse: collapse;
        text-align: left;
    }

    .admin-dashboard th {
        padding: 14px 17px;
        background: rgba(255,255,255,.025);
        color: #94a4b5;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .7px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .admin-dashboard td {
        padding: 17px;
        border-top: 1px solid rgba(255,255,255,.055);
        color: #e3e8ef;
        font-size: 12px;
        vertical-align: top;
    }

    .admin-dashboard tbody tr:hover {
        background: rgba(66,214,197,.025);
    }

    .admin-dashboard .order-id {
        color: var(--dash-teal);
        font-weight: 800;
        white-space: nowrap;
    }

    .admin-dashboard .person-name {
        font-weight: 700;
    }

    .admin-dashboard .subtext {
        display: block;
        margin-top: 4px;
        color: var(--dash-muted);
        font-size: 11px;
    }

    .admin-dashboard .total-price {
        color: var(--dash-teal);
        font-weight: 800;
        white-space: nowrap;
    }

    .admin-dashboard .field {
        display: flex;
        flex-direction: column;
        gap: 7px;
        min-width: 170px;
    }

    .admin-dashboard select {
        width: 100%;
        min-height: 36px;
        padding: 8px 28px 8px 10px;
        border: 1px solid rgba(255,255,255,.12);
        border-radius: 8px;
        outline: none;
        background: #101b28;
        color: #edf2f7;
        font-size: 11px;
    }

    .admin-dashboard select:focus {
        border-color: var(--dash-teal);
    }

    .admin-dashboard .save-btn {
        min-height: 35px;
        padding: 8px 12px;
        border: 0;
        border-radius: 8px;
        background: var(--dash-teal);
        color: #071311;
        font-size: 11px;
        font-weight: 800;
        cursor: pointer;
        transition: .2s;
    }

    .admin-dashboard .save-btn:hover {
        filter: brightness(1.08);
    }

    .admin-dashboard .empty-state {
        padding: 40px 20px;
        text-align: center;
        color: var(--dash-muted);
    }

    .admin-dashboard .empty-state .empty-icon {
        margin-bottom: 10px;
        font-size: 30px;
    }

    .admin-dashboard .bottom-grid {
        display: grid;
        grid-template-columns: 1.1fr .9fr;
        gap: 18px;
        margin-top: 24px;
    }

    .admin-dashboard .quick-list {
        display: grid;
        gap: 0;
        padding: 5px 20px;
    }

    .admin-dashboard .quick-item {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 16px 0;
        border-bottom: 1px solid rgba(255,255,255,.06);
    }

    .admin-dashboard .quick-item:last-child {
        border-bottom: 0;
    }

    .admin-dashboard .quick-icon {
        display: grid;
        place-items: center;
        flex-shrink: 0;
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: rgba(66,214,197,.09);
        color: var(--dash-teal);
        font-size: 19px;
    }

    .admin-dashboard .quick-item h4 {
        margin: 0;
        font-size: 13px;
    }

    .admin-dashboard .quick-item p {
        margin: 3px 0 0;
        color: var(--dash-muted);
        font-size: 11px;
    }

    .admin-dashboard .quick-arrow {
        margin-left: auto;
        color: var(--dash-teal);
        font-size: 20px;
    }

    .admin-dashboard .guide-list {
        padding: 20px 22px;
    }

    .admin-dashboard .guide-step {
        position: relative;
        display: flex;
        gap: 13px;
        padding-bottom: 21px;
    }

    .admin-dashboard .guide-step:last-child {
        padding-bottom: 0;
    }

    .admin-dashboard .step-number {
        display: grid;
        place-items: center;
        flex-shrink: 0;
        width: 30px;
        height: 30px;
        border: 1px solid rgba(66,214,197,.25);
        border-radius: 10px;
        background: rgba(66,214,197,.08);
        color: var(--dash-teal);
        font-size: 12px;
        font-weight: 800;
    }

    .admin-dashboard .guide-step h4 {
        margin: 2px 0 4px;
        font-size: 12px;
    }

    .admin-dashboard .guide-step p {
        margin: 0;
        color: var(--dash-muted);
        font-size: 11px;
        line-height: 1.7;
    }

    .admin-dashboard .dashboard-footer {
        margin-top: 26px;
        padding: 20px 0 8px;
        border-top: 1px solid var(--dash-border);
        color: var(--dash-muted);
        font-size: 11px;
        text-align: center;
    }

    .admin-dashboard .dashboard-footer span {
        color: var(--dash-teal);
    }

    @media (max-width: 1100px) {
        .admin-dashboard .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 760px) {
        .admin-dashboard .dashboard-hero {
            padding: 24px 20px;
        }

        .admin-dashboard .bottom-grid {
            grid-template-columns: 1fr;
        }

        .admin-dashboard .section-heading {
            align-items: flex-start;
        }
    }

    @media (max-width: 480px) {
        .admin-dashboard .stats-grid {
            grid-template-columns: 1fr;
        }

        .admin-dashboard .stat-card {
            padding: 19px;
        }

        .admin-dashboard .actions {
            width: 100%;
        }

        .admin-dashboard .actions .btn {
            flex: 1;
        }
    }
</style>

<div class="admin-dashboard">

    {{-- HERO / SAMBUTAN --}}
    <section class="dashboard-hero">
        <div class="eyebrow">Admin Control Center</div>

        <h1>Dashboard <span>Admin.</span></h1>

        <p>
            Selamat datang di pusat pengelolaan SewaKendaraan.
            Pantau data armada, customer, pesanan, serta pembayaran
            dalam satu tempat untuk membantu operasional penyewaan
            berjalan lebih teratur.
        </p>

        <div class="hero-bottom">
            <div class="hero-note">
                <strong>● Sistem Pengelolaan</strong>
                <span> — Ringkasan operasional penyewaan kendaraan</span>
            </div>

            <div class="actions">
                <a class="btn" href="{{ route('admin.armada') }}">
                    <span>＋</span> Kelola Armada
                </a>

                <a class="btn secondary" href="{{ route('admin.sopir') }}">
                    <span>♙</span> Kelola Sopir
                </a>
            </div>
        </div>
    </section>

    {{-- STATISTIK --}}
    <div class="section-heading">
        <div>
            <h2>Ringkasan Operasional</h2>
            <p>Gambaran umum data penyewaan yang tercatat dalam sistem.</p>
        </div>
        <span class="badge">STATISTIK</span>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-label">Jumlah Armada</div>
                <div class="stat-icon">▣</div>
            </div>
            <div class="stat-number">{{ $stats['armada'] ?? 0 }}</div>
            <div class="stat-foot">Total data kendaraan terdaftar</div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-label">Total Customer</div>
                <div class="stat-icon">♙</div>
            </div>
            <div class="stat-number">{{ $stats['customer'] ?? 0 }}</div>
            <div class="stat-foot">Customer yang tercatat di sistem</div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-label">Total Pesanan</div>
                <div class="stat-icon">▤</div>
            </div>
            <div class="stat-number">{{ $stats['pesanan'] ?? 0 }}</div>
            <div class="stat-foot">Seluruh pesanan yang tercatat</div>
        </div>

        <div class="stat-card red">
            <div class="stat-top">
                <div class="stat-label">Menunggu Pembayaran</div>
                <div class="stat-icon">◷</div>
            </div>
            <div class="stat-number">{{ $stats['menunggu'] ?? 0 }}</div>
            <div class="stat-foot">Pesanan dengan status pembayaran menunggu</div>
        </div>
    </div>

    {{-- TABEL PESANAN --}}
    <div class="section-heading">
        <div>
            <h2>Pesanan Terbaru</h2>
            <p>Periksa detail pesanan dan perbarui status sesuai proses yang berlangsung.</p>
        </div>
        <span class="badge">MANAJEMEN PESANAN</span>
    </div>

    <div class="content-card">
        <div class="card-heading">
            <div>
                <h3>Daftar Transaksi Penyewaan</h3>
                <p>Perubahan status akan dikirim ke sistem setelah tombol Simpan ditekan.</p>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Customer</th>
                        <th>Armada</th>
                        <th>Tanggal / Durasi</th>
                        <th>Total Biaya</th>
                        <th>Status & Tindakan</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($orders as $o)
                        <tr>
                            <td>
                                <span class="order-id">#{{ $o->id_pemesanan }}</span>
                            </td>

                            <td>
                                <span class="person-name">
                                    {{ $o->customer->nama ?? 'Customer tidak ditemukan' }}
                                </span>
                                <span class="subtext">Penyewa</span>
                            </td>

                            <td>
                                <span class="person-name">
                                    {{ $o->armada->nama_kendaraan ?? 'Armada tidak ditemukan' }}
                                </span>
                                <span class="subtext">Kendaraan sewaan</span>
                            </td>

                            <td>
                                <span>
                                    {{ $o->tanggal_sewa ? \Carbon\Carbon::parse($o->tanggal_sewa)->format('d M Y') : '-' }}
                                </span>
                                <span class="subtext">{{ $o->durasi }} hari</span>
                            </td>

                            <td>
                                <span class="total-price">
                                    Rp{{ number_format($o->total_biaya, 0, ',', '.') }}
                                </span>
                            </td>

                            <td>
                                <form method="POST"
                                      action="{{ route('admin.orders.update', $o) }}"
                                      class="field">
                                    @csrf
                                    @method('PATCH')

                                    <select name="status" aria-label="Status pesanan">
                                        @foreach([
                                            'Menunggu Pembayaran',
                                            'Menunggu Konfirmasi',
                                            'Dikonfirmasi',
                                            'Dalam Perjalanan',
                                            'Selesai',
                                            'Dibatalkan',
                                        ] as $st)
                                            <option value="{{ $st }}"
                                                @selected($o->status === $st)>
                                                {{ $st }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <select name="id_sopir" aria-label="Pilih sopir">
                                        <option value="">-- Pilih sopir --</option>

                                        @foreach(\App\Models\Sopir::where('status', 'tersedia')->get() as $s)
                                            <option value="{{ $s->id_sopir }}"
                                                @selected($o->id_sopir == $s->id_sopir)>
                                                {{ $s->nama }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <select name="status_pembayaran" aria-label="Status pembayaran">
                                        <option value="">-- Pembayaran --</option>
                                        @foreach(['Menunggu', 'Dibayar', 'Ditolak'] as $pembayaran)
                                            <option value="{{ $pembayaran }}"
                                                @selected(($o->status_pembayaran ?? '') === $pembayaran)>
                                                {{ $pembayaran }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <button type="submit" class="save-btn">
                                        Simpan Perubahan
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-icon">▤</div>
                                    <strong>Belum ada pesanan</strong>
                                    <p>Pesanan customer akan ditampilkan di bagian ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- AKSES CEPAT DAN PANDUAN --}}
    <div class="bottom-grid">

        <section class="content-card">
            <div class="card-heading">
                <div>
                    <h3>Akses Cepat</h3>
                    <p>Menu yang sering digunakan untuk operasional.</p>
                </div>
                <span class="badge">MENU</span>
            </div>

            <div class="quick-list">
                <a href="{{ route('admin.armada') }}" class="quick-item">
                    <div class="quick-icon">▣</div>
                    <div>
                        <h4>Kelola Armada</h4>
                        <p>Periksa dan atur data kendaraan rental.</p>
                    </div>
                    <span class="quick-arrow">›</span>
                </a>

                <a href="{{ route('admin.sopir') }}" class="quick-item">
                    <div class="quick-icon">♙</div>
                    <div>
                        <h4>Kelola Sopir</h4>
                        <p>Periksa data dan ketersediaan sopir.</p>
                    </div>
                    <span class="quick-arrow">›</span>
                </a>
            </div>
        </section>

        <section class="content-card">
            <div class="card-heading">
                <div>
                    <h3>Alur Pengelolaan Pesanan</h3>
                    <p>Panduan ringkas untuk admin.</p>
                </div>
                <span class="badge">PANDUAN</span>
            </div>

            <div class="guide-list">
                <div class="guide-step">
                    <div class="step-number">01</div>
                    <div>
                        <h4>Periksa pesanan masuk</h4>
                        <p>Periksa identitas customer, kendaraan, tanggal sewa, durasi, dan total biaya.</p>
                    </div>
                </div>

                <div class="guide-step">
                    <div class="step-number">02</div>
                    <div>
                        <h4>Periksa pembayaran</h4>
                        <p>Pastikan pembayaran telah diverifikasi sebelum mengubah status menjadi dikonfirmasi.</p>
                    </div>
                </div>

                <div class="guide-step">
                    <div class="step-number">03</div>
                    <div>
                        <h4>Atur sopir jika diperlukan</h4>
                        <p>Pilih sopir yang sesuai dan tersedia berdasarkan kebutuhan pesanan.</p>
                    </div>
                </div>

                <div class="guide-step">
                    <div class="step-number">04</div>
                    <div>
                        <h4>Perbarui status pesanan</h4>
                        <p>Sesuaikan status dengan kondisi sebenarnya, lalu klik Simpan Perubahan.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- CATATAN --}}
    <div class="dashboard-footer">
        <p>
            <span>SewaKendaraan.</span>
            Dashboard Pengelolaan Penyewaan Kendaraan
        </p>
        <p style="margin-top: 5px">
            Pastikan data pembayaran dan status pesanan diperbarui secara akurat.
        </p>
    </div>

</div>
@endsection
