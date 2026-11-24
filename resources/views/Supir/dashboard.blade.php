@extends('Supir.layout')
@section('title', 'Dashboard Supir')
@section('topbar-title', 'Dashboard')
@section('content')
<div class="welcome-banner"><div><div class="eyebrow">RINGKASAN AKTIVITAS</div><h2>Halo, {{ $sopir->nama }} 👋</h2><p>Semoga harimu lancar. Berikut ringkasan tugas dan perjalanan yang ditugaskan kepadamu.</p></div><div class="welcome-actions"><a class="btn btn-primary" href="{{ route('supir.tugas') }}">Lihat semua tugas <span>→</span></a></div></div>
<div class="stats-grid">
    <div class="card stat-card" style="--glow:#14b8a6"><div class="stat-top"><span>Total tugas</span><span class="stat-icon">▤</span></div><div class="stat-number">{{ $stats['total'] }}</div><div class="stat-foot">Seluruh pesanan yang ditugaskan</div></div>
    <div class="card stat-card" style="--glow:#fbbf24"><div class="stat-top"><span>Menunggu dijalankan</span><span class="stat-icon" style="background:#3b2e15;color:#fcd34d">◷</span></div><div class="stat-number">{{ $stats['menunggu'] }}</div><div class="stat-foot">Pesanan sudah dikonfirmasi</div></div>
    <div class="card stat-card" style="--glow:#60a5fa"><div class="stat-top"><span>Dalam perjalanan</span><span class="stat-icon" style="background:#142b43;color:#93c5fd">↗</span></div><div class="stat-number">{{ $stats['berjalan'] }}</div><div class="stat-foot">Perjalanan sedang berlangsung</div></div>
    <div class="card stat-card" style="--glow:#34d399"><div class="stat-top"><span>Selesai</span><span class="stat-icon" style="background:#10352b;color:#6ee7b7">✓</span></div><div class="stat-number">{{ $stats['selesai'] }}</div><div class="stat-foot">Perjalanan telah diselesaikan</div></div>
</div>
<div class="card table-card"><div class="card-title-row"><div><h2>Tugas terbaru</h2><div class="muted small" style="margin-top:5px">Pesanan yang terakhir ditugaskan kepadamu.</div></div><a class="btn btn-quiet btn-small" href="{{ route('supir.tugas') }}">Lihat semua ↗</a></div>
    <div class="table-wrap"><table><thead><tr><th>Pesanan</th><th>Pelanggan</th><th>Kendaraan</th><th>Tanggal sewa</th><th>Status</th><th></th></tr></thead><tbody>
    @forelse($orders as $order)
        @php($st = strtolower($order->status ?? ''))
        <tr><td><span class="order-id">#{{ $order->id_pemesanan }}</span><div class="sub-cell">ID pesanan</div></td><td>{{ $order->customer->nama ?? '-' }}<div class="sub-cell">{{ $order->customer->no_hp ?? 'Nomor HP tidak tersedia' }}</div></td><td><div class="vehicle-cell"><span class="vehicle-thumb">🚘</span><span>{{ $order->armada->nama_kendaraan ?? '-' }}</span></div></td><td>{{ optional($order->tanggal_sewa)->format('d M Y') ?? '-' }}</td><td><span class="status {{ $st === 'selesai' ? 'status-done' : ($st === 'dalam perjalanan' ? 'status-progress' : ($st === 'dikonfirmasi' ? 'status-pending' : 'status-other')) }}">{{ $order->status }}</span></td><td><a class="btn btn-small" href="{{ route('supir.tugas.detail', $order) }}">Detail →</a></td></tr>
    @empty
        <tr><td colspan="6"><div class="empty-state"><div class="empty-icon">▤</div><strong>Belum ada tugas</strong><div class="small" style="margin-top:5px">Tugas perjalanan akan muncul di sini setelah admin menugaskan pesanan kepadamu.</div></div></td></tr>
    @endforelse
    </tbody></table></div>
</div>
@endsection
