@extends('layouts.app')

@section('title', 'Daftar Armada')

@section('content')
    <h1>Daftar Armada</h1>
    <p class="muted">Harga ditampilkan per hari. Ketersediaan akhir diperiksa saat pemesanan.</p>

    <div class="grid">
        @forelse($armadas as $a)
            <article class="card">
                <span class="tag">{{ $a->status_ketersediaan }}</span>

                <h2 style="margin: 12px 0 4px">{{ $a->nama_kendaraan }}</h2>

                <p class="muted">Tipe: {{ $a->tipe }} 
                    · Transmisi: {{ $a->transmisi ?: '-' }}</p>
                <p class="muted">Plat: {{ $a->plat_nomor ?: 'Belum dicatat' }}</p>

                <p class="price">
                    Rp{{ number_format($a->harga_sewa, 0, ',', '.') }}
                    <small>/ hari</small>
                </p>

                @if($a->status_ketersediaan === 'tersedia')
                    @if(session('role') === 'customer')
                        <a class="btn" href="{{ route('booking.create', $a) }}">Pesan kendaraan</a>
                    @elseif(!session('role'))
                        <a class="btn" href="{{ route('login') }}">Login untuk memesan</a>
                    @else
                        <span class="muted">Mode admin</span>
                    @endif
                @else
                    <span class="muted">Belum tersedia untuk disewa</span>
                @endif
            </article>
        @empty
            <div class="card">
                Belum ada armada di database. Admin dapat menambahkan armada melalui menu Kelola Armada.
            </div>
        @endforelse
    </div>
@endsection
