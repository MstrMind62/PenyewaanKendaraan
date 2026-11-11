
@extends('layouts.app')

@section('title', 'Sistem Penyewaan Kendaraan')

@section('content')

    <section class="card" style="padding: clamp(24px, 6vw, 60px); background: linear-gradient(145deg, var(--app-panel), var(--app-bg)); border: 1px solid var(--app-border);">
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

    <style>
        .home-armada-image {
            width: 100%;
            height: 190px;
            object-fit: contain;
            display: block;
            margin: 12px 0;
            border-radius: 12px;
            background: rgba(255,255,255,.025);
        }
    </style>

    <div class="grid">
        @forelse($armadas as $a)

            @php
                $nama = strtolower($a->nama_kendaraan);

                $gambarMobil = [
                    'alphard' => 'alphard.png',
                    'avanza' => 'avanza.png',
                    'brio' => 'brio.png',
                    'rocky' => 'Daihatsu Rocky.png',
                    'ertiga' => 'ertiga.png',
                    'hiace' => 'hiace.png',
                    'innova' => 'innova.png',
                    'pajero' => 'pajero.png',
                    'xenia' => 'xenia.png',
                    'xpander' => 'xpander.png',
                ];

                $namaGambar = null;

                foreach ($gambarMobil as $keyword => $file) {
                    if (str_contains($nama, $keyword)) {
                        $namaGambar = $file;
                        break;
                    }
                }
            @endphp

            <article class="card">

                <span class="tag">{{ $a->tipe }}</span>

                @if($namaGambar)
                    <img
                    src="{{ asset('images/armada/alphard.png') }}"
                    alt="Alphard"
                    style="width:100%; height:190px; object-fit:contain;"
                    >
                @else
                    <div class="home-armada-image"
                         style="display:flex; align-items:center; justify-content:center; color:var(--app-muted, #999);">
                        Gambar belum tersedia
                    </div>
                @endif

                <h2 style="margin: 12px 0 4px">
                    {{ $a->nama_kendaraan }}
                </h2>

                <p class="muted">
                    Transmisi: {{ $a->transmisi ?: 'Belum diisi' }}
                </p>

                <p class="price">
                    Rp{{ number_format($a->harga_sewa, 0, ',', '.') }}
                    <small>/ hari</small>
                </p>

                <a class="btn" href="{{ route('armada.index') }}">
                    Lihat detail
                </a>

            </article>

        @empty
            <div class="card">
                Belum ada data armada. Admin dapat menambahkannya setelah login.
            </div>
        @endforelse
    </div>

@endsection
