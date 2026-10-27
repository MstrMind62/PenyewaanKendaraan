@extends('layouts.app') 

@section('title', 'Pesanan Saya') 

@section('content')
<h1>Pesanan Saya</h1>
<p class="muted">Riwayat pemesanan dan status pembayaran.</p>

<div class="grid">
    @forelse($orders as $o)
        <article class="card">
            <span class="tag">{{ $o->status }}</span>
            <h2 style="margin:12px 0 4px">#{{ $o->id_pemesanan }} &middot; {{ $o->armada->nama_kendaraan }}</h2>
            <p>Tanggal: {{ $o->tanggal_sewa->format('d-m-Y') }} &middot; Durasi: {{ $o->durasi }} hari</p>
            <p>Total: <strong>Rp{{ number_format($o->total_biaya, 0, ',', '.') }}</strong></p>
            <p>Layanan: {{ $o->layanan === 'diantar' ? 'Diantar' : 'Ambil sendiri' }} &middot; Sopir: {{ $o->sopir->nama ?? 'Belum ditugaskan' }}</p>
            <p>Pembayaran: {{ $o->pembayaran->status_pembayaran ?? 'Belum dicatat' }} ({{ $o->pembayaran->metode_pembayaran ?? '-' }})</p>
            
            @if($o->status === 'Menunggu Pembayaran')
                <form method="post" action="{{ route('booking.pay', $o) }}" class="actions">
                    @csrf
                    <select name="metode_pembayaran" style="max-width:180px">
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="E-Wallet">E-Wallet</option>
                        <option value="QRIS">QRIS</option>
                    </select>
                    <button class="secondary">Pilih metode</button>
                </form>
            @endif 

            @if(in_array($o->status, ['Menunggu Pembayaran', 'Menunggu Konfirmasi']))
                <form method="post" action="{{ route('booking.cancel', $o) }}" style="margin-top:10px" onsubmit="return confirm('Batalkan pesanan ini?')">
                    @csrf
                    <button class="danger">Batalkan pesanan</button>
                </form>
            @endif

            @if($o->status === 'Selesai' && $o->pembayaran && $o->pembayaran->status_pembayaran === 'Lunas')
                <a class="btn" href="{{ route('booking.invoice', $o) }}">Cetak Invoice</a>
            @endif

        </article>
    @empty
        <div class="card">Kamu belum memiliki pesanan.</div>
    @endforelse
</div>
@endsection