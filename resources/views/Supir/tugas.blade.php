@extends('Supir.layout')
@section('title', 'Tugas Perjalanan')
@section('topbar-title', 'Tugas perjalanan')
@section('content')
<div class="page-heading"><div><div class="eyebrow">DAFTAR PEKERJAAN</div><h1>Tugas perjalanan</h1><p>Semua pesanan yang sudah ditugaskan kepadamu tersedia di halaman ini.</p></div><a class="btn btn-quiet" href="{{ route('supir.dashboard') }}">← Dashboard</a></div>
<div class="card table-card"><div class="card-title-row"><div><h2>Semua tugas</h2><div class="muted small" style="margin-top:5px">{{ $orders->count() }} pesanan tercatat</div></div><div class="table-tools"><label class="searchbox"><span>⌕</span><input id="taskSearch" type="search" placeholder="Cari pesanan, pelanggan, kendaraan..."></label><select id="taskFilter" class="form-control" style="width:auto;min-width:150px;padding:10px"><option value="">Semua status</option><option value="dikonfirmasi">Dikonfirmasi</option><option value="dalam perjalanan">Dalam perjalanan</option><option value="selesai">Selesai</option></select></div></div>
<div class="table-wrap"><table id="tasksTable"><thead><tr><th>Pesanan</th><th>Pelanggan</th><th>Kontak</th><th>Kendaraan</th><th>Tanggal</th><th>Layanan</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
@forelse($orders as $order)
    @php($st = strtolower($order->status ?? ''))
    <tr data-status="{{ $st }}"><td><span class="order-id">#{{ $order->id_pemesanan }}</span></td><td>{{ $order->customer->nama ?? '-' }}</td><td>{{ $order->customer->no_hp ?? '-' }}</td><td>{{ $order->armada->nama_kendaraan ?? '-' }}</td><td>{{ optional($order->tanggal_sewa)->format('d M Y') ?? '-' }}</td><td>{{ $order->layanan ?? '-' }}</td><td><span class="status {{ $st === 'selesai' ? 'status-done' : ($st === 'dalam perjalanan' ? 'status-progress' : ($st === 'dikonfirmasi' ? 'status-pending' : 'status-other')) }}">{{ $order->status }}</span></td><td><a class="btn btn-small" href="{{ route('supir.tugas.detail', $order) }}">Lihat detail →</a></td></tr>
@empty
    <tr><td colspan="8"><div class="empty-state"><div class="empty-icon">▤</div><strong>Belum ada tugas perjalanan</strong><div class="small" style="margin-top:5px">Hubungi admin jika kamu merasa seharusnya sudah mendapat tugas.</div></div></td></tr>
@endforelse
</tbody></table></div><div id="noSearchResult" class="empty-state" style="display:none">Tidak ada tugas yang cocok dengan pencarian.</div></div>
<script>
(function(){const q=document.getElementById('taskSearch'),f=document.getElementById('taskFilter'),rows=[...document.querySelectorAll('#tasksTable tbody tr[data-status]')],empty=document.getElementById('noSearchResult');function apply(){let shown=0;rows.forEach(r=>{const matchesText=r.innerText.toLowerCase().includes(q.value.toLowerCase());const matchesStatus=!f.value||r.dataset.status===f.value;const visible=matchesText&&matchesStatus;r.style.display=visible?'':'none';if(visible)shown++;});empty.style.display=shown?'none':'block';}q.addEventListener('input',apply);f.addEventListener('change',apply);})();
</script>
@endsection
