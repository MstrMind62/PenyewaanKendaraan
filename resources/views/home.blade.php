@extends('layouts.app')

@section('title', 'Sistem Penyewaan Kendaraan')

@section('content')
    <section class="card" style="padding: clamp(24px, 6vw, 60px); background: linear-gradient(120deg, #fff, #eaf2ff)">
        <span class="tag">Pemesanan kendaraan online</span>

        <h1 style="margin-top: 14px">
            Perjalanan lebih mudah,<br>
            kendaraan pilihanmu.
        </h1>

        <p class="muted" style="max-width: 650px">
            Lihat armada yang tersedia, tentukan tanggal dan durasi sewa, lalu pantau status pesanan melalui satu sistem.
        </p>

        <div class="actions">
            <a class="btn" href="{{ route('armada.index') }}">Lihat Armada</a>
            @if(!session('role'))
                <a class="btn secondary" href="{{ route('register') }}">Buat Akun</a>
            @endif
        </div>
    </section>

    <h2 style="margin-top: 28px">Pilihan Armada</h2>

    <div class="grid">
        @forelse($armadas as $a)
            <article class="card">
                <span class="tag">{{ $a->tipe }}</span>

                <h2 style="margin: 12px 0 4px">{{ $a->nama_kendaraan }}</h2>
                <p class="muted">Transmisi: {{ $a->transmisi ?: 'Belum diisi' }}</p>

                <p class="price">
                    Rp{{ number_format($a->harga_sewa, 0, ',', '.') }}
                    <small>/ hari</small>
                </p>

                <a class="btn" href="{{ route('armada.index') }}">Lihat detail</a>
            </article>
        @empty
            <div class="card">
                Belum ada data armada. Admin dapat menambahkannya setelah login.
            </div>
        @endforelse
    </div>
@endsection
