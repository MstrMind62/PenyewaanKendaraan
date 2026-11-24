@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')

<h1>Pesanan Saya</h1>
<p class="muted">Riwayat pemesanan dan status pembayaran.</p>

<div class="grid">
    @forelse($orders as $o)

        <article class="card">

            {{-- Status pemesanan --}}
            <span class="tag">{{ $o->status }}</span>

            <h2 style="margin:12px 0 4px">
                #{{ $o->id_pemesanan }}
                &middot;
                {{ $o->armada->nama_kendaraan ?? 'Kendaraan tidak tersedia' }}
            </h2>

            {{-- Tanggal sewa --}}
            <p>
                <strong>Tanggal sewa:</strong>

                @if($o->tanggalPemesanan->isNotEmpty())

                    {{ $o->tanggalPemesanan
                        ->map(fn($item) => \Carbon\Carbon::parse($item->tanggal_sewa)->format('d-m-Y'))
                        ->implode(', ') }}

                @else

                    {{ \Carbon\Carbon::parse($o->tanggal_sewa)->format('d-m-Y') }}

                @endif
            </p>

            {{-- Durasi --}}
            <p>
                <strong>Durasi:</strong>
                {{ $o->durasi }} hari
            </p>

            {{-- Total biaya --}}
            <p>
                <strong>Total:</strong>
                Rp{{ number_format($o->total_biaya, 0, ',', '.') }}
            </p>

            {{-- Layanan --}}
            <p>
                <strong>Layanan:</strong>
                {{ $o->layanan === 'diantar' ? 'Diantar' : 'Ambil sendiri' }}
            </p>

            {{-- Sopir --}}
            <p>
                <strong>Sopir:</strong>
                {{ $o->sopir->nama ?? 'Belum ditugaskan' }}
            </p>

            {{-- Informasi pembayaran --}}
            <p>
                <strong>Pembayaran:</strong>
                {{ $o->pembayaran->status_pembayaran ?? 'Belum dicatat' }}
                ({{ $o->pembayaran->metode_pembayaran ?? '-' }})
            </p>

            {{-- Memilih metode pembayaran --}}
            @if($o->status === 'Menunggu Pembayaran')

                <form
                    method="POST"
                    action="{{ route('booking.pay', $o) }}"
                    class="actions"
                >
                    @csrf

                    <select
                        name="metode_pembayaran"
                        style="max-width:180px"
                    >
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="E-Wallet">E-Wallet</option>
                        <option value="QRIS">QRIS</option>
                    </select>

                    <button class="secondary">
                        Pilih metode
                    </button>
                </form>

            @endif

            {{-- Membatalkan pesanan --}}
            @if(in_array($o->status, [
                'Menunggu Pembayaran',
                'Menunggu Konfirmasi'
            ]))

                <form
                    method="POST"
                    action="{{ route('booking.cancel', $o) }}"
                    style="margin-top:10px"
                    onsubmit="return confirm('Batalkan pesanan ini?')"
                >
                    @csrf

                    <button class="danger" type="submit">
                        Batalkan pesanan
                    </button>
                </form>

            @endif

        </article>

    @empty

        <div class="card">
            Kamu belum memiliki pesanan.
        </div>

    @endforelse
</div>

@endsection