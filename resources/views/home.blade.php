
@extends('layouts.app')

@section('title', 'DriveEase - Rental Mobil Terpercaya')

@push('styles')
<style>
    /* ==============================
       HOMEPAGE
    ============================== */

    .home-page {
        width: 100%;
    }

    /* HERO SECTION */

    .hero-section {
        position: relative;
        overflow: hidden;
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-items: center;
        gap: 30px;

        min-height: 430px;
        padding: 55px;

        /* BACKGROUND GAMBAR */
        background:
            linear-gradient(
                rgba(255, 255, 255, 0.78),
                rgba(255, 255, 255, 0.78)
            ),
            url('/images/remie_bg.jpg');

        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;

        border-radius: 22px;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;

        padding: 8px 14px;
        border-radius: 30px;

        background: #FFF0DF;
        color: #D97706;

        font-size: 12px;
        font-weight: 700;
    }

    .hero-content h1 {
        margin: 22px 0 18px;

        font-size: clamp(32px, 4vw, 49px);
        line-height: 1.15;
        letter-spacing: -1.8px;

        color: #202A35;
    }

    .hero-content h1 span {
        color: #F28C28;
    }

    .hero-content p {
        max-width: 470px;
        margin-bottom: 28px;

        color: #6B7280;
        font-size: 15px;
        line-height: 1.8;
    }

    .hero-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .hero-actions .btn {
        padding: 14px 23px;
    }

    .hero-image {
        position: relative;
        z-index: 1;

        display: flex;
        align-items: center;
        justify-content: center;

        min-height: 280px;
    }

    .hero-image::before {
        content: "";

        position: absolute;
        width: 330px;
        height: 330px;

        background: #FFE5CA;
        border-radius: 50%;
        z-index: -1;
    }

    .hero-image img {
    width: 115%;
    max-width: 570px;
    max-height: 350px;

    object-fit: contain;

    /* Membuat sudut gambar membulat */
    border-radius: 100px;

    /* Bayangan lebih lembut */
    filter: drop-shadow(0 15px 20px rgba(0,0,0,0.12));

    /* Transisi halus */
    transition: all 0.3s ease;
    }

    .hero-image img:hover {
    transform: scale(1.03);
    }

    .hero-image-placeholder {
        width: 100%;
        max-width: 430px;
        height: 230px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: white;
        border-radius: 18px;

        color: #9CA3AF;
        font-weight: 600;
    }

    /* BENEFIT SECTION */

    .benefit-section {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;

        margin: 30px 0 65px;
    }

    .benefit-item {
        display: flex;
        align-items: center;
        gap: 14px;

        padding: 20px;

        background: white;
        border: 1px solid #E5E7EB;
        border-radius: 14px;
    }

    .benefit-icon {
        width: 48px;
        height: 48px;
        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 12px;

        background: #FFF0DF;
        color: #F28C28;

        font-size: 23px;
    }

    .benefit-item h4 {
        margin: 0 0 5px;
        font-size: 14px;
        color: #202A35;
    }

    .benefit-item p {
        margin: 0;
        color: #6B7280;
        font-size: 12px;
        line-height: 1.5;
    }

    /* SECTION HEADER */

    .section-heading {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 15px;

        margin-bottom: 25px;
    }

    .section-heading h2 {
        margin: 0 0 7px;

        color: #202A35;
        font-size: 27px;
        letter-spacing: -0.7px;
    }

    .section-heading p {
        margin: 0;
        color: #6B7280;
        font-size: 14px;
    }

    .section-link {
        color: #F28C28;
        font-size: 13px;
        font-weight: 700;
    }

    .section-link:hover {
        color: #E47713;
    }

    /* CAR LIST */

    .home-car-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 22px;
    }

    .home-car-card {
        overflow: hidden;

        background: white;
        border: 1px solid #E5E7EB;
        border-radius: 16px;

        transition: 0.3s;
    }

    .home-car-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(32,42,53,0.09);
        border-color: #F6C28E;
    }

    .car-image-wrapper {
        position: relative;

        display: flex;
        align-items: center;
        justify-content: center;

        height: 205px;
        margin: 10px;

        overflow: hidden;
        border-radius: 12px;

        background: #F5F6F8;
    }

    .car-image-wrapper img {
        width: 100%;
        height: 100%;

        padding: 12px;

        object-fit: contain;
        transition: transform 0.3s;
    }

    .home-car-card:hover .car-image-wrapper img {
        transform: scale(1.05);
    }

    .car-type {
        position: absolute;
        top: 12px;
        left: 12px;

        padding: 6px 11px;

        border-radius: 20px;
        background: white;

        color: #D97706;
        font-size: 11px;
        font-weight: 700;
    }

    .car-card-body {
        padding: 12px 17px 18px;
    }

    .car-card-body h3 {
        margin: 0 0 7px;

        color: #202A35;
        font-size: 18px;
    }

    .car-transmission {
        margin: 0 0 16px;

        color: #6B7280;
        font-size: 12px;
    }

    .car-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;

        padding-top: 15px;
        border-top: 1px solid #E5E7EB;
    }

    .car-price {
        color: #F28C28;
        font-size: 17px;
        font-weight: 800;
    }

    .car-price small {
        display: block;
        margin-top: 3px;

        color: #9CA3AF;
        font-size: 11px;
        font-weight: 500;
    }

    .car-detail-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding: 10px 13px;

        border-radius: 8px;
        background: #FFF0DF;

        color: #D97706;
        font-size: 12px;
        font-weight: 700;

        transition: 0.2s;
    }

    .car-detail-btn:hover {
        background: #F28C28;
        color: white;
    }

    /* EMPTY STATE */

    .empty-cars {
        grid-column: 1 / -1;

        padding: 55px 20px;

        background: #F5F6F8;
        border: 1px dashed #D1D5DB;
        border-radius: 16px;

        text-align: center;
    }

    .empty-cars h3 {
        margin: 12px 0 7px;
        color: #202A35;
    }

    .empty-cars p {
        margin: 0;
        color: #6B7280;
        font-size: 13px;
    }

    /* CTA SECTION */

    .home-cta {
        position: relative;
        overflow: hidden;

        margin-top: 70px;
        padding: 45px 40px;

        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 25px;

        background: #202A35;
        border-radius: 18px;
    }

    .home-cta h2 {
        margin: 0 0 10px;

        color: white;
        font-size: 27px;
    }

    .home-cta p {
        margin: 0;
        color: #CBD5E1;
        font-size: 14px;
        line-height: 1.6;
    }

    .home-cta .btn {
        flex-shrink: 0;
    }

    /* RESPONSIVE */

    @media(max-width: 900px) {

        .hero-section {
            padding: 35px;
            gap: 10px;
        }

        .hero-image img {
            width: 110%;
        }

        .home-car-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .benefit-section {
            gap: 10px;
        }

        .benefit-item {
            padding: 14px;
        }
    }

    @media(max-width: 650px) {

        .hero-section {
            grid-template-columns: 1fr;
            padding: 30px 23px;
        }

        .hero-content h1 {
            font-size: 35px;
        }

        .hero-image {
            min-height: 220px;
        }

        .hero-image::before {
            width: 230px;
            height: 230px;
        }

        .hero-image img {
            width: 100%;
            max-height: 230px;
        }

        .benefit-section {
            grid-template-columns: 1fr;
            margin-bottom: 45px;
        }

        .home-car-grid {
            grid-template-columns: 1fr;
        }

        .section-heading h2 {
            font-size: 22px;
        }

        .home-cta {
            flex-direction: column;
            align-items: flex-start;
            padding: 30px 24px;
        }

        .home-cta h2 {
            font-size: 23px;
        }
    }
</style>
@endpush


@section('content')

<div class="home-page">

    {{-- ==========================
         HERO SECTION
    =========================== --}}

    <section class="hero-section">

        <div class="hero-content">

            <span class="hero-label">
                ✦ RENTAL MOBIL TERPERCAYA
            </span>

            <h1>
                Perjalanan Lebih Mudah,
                <span>Mobil Terbaik</span>
                Untukmu.
            </h1>

            <p>
                Temukan kendaraan yang sesuai dengan kebutuhan perjalananmu.
                Pilihan mobil berkualitas, harga transparan, dan proses
                pemesanan yang praktis.
            </p>

            <div class="hero-actions">

                <a href="{{ route('armada.index') }}" class="btn">
                    Jelajahi Mobil &nbsp; →
                </a>

                @if(!session('role'))
                    <a href="{{ route('register') }}" class="btn secondary">
                        Buat Akun
                    </a>
                @endif

            </div>

        </div>


        {{-- Gambar kendaraan dari database --}}

        <div class="hero-image">

            @if($armadas->first() && !empty($armadas->first()->gambar))

                <img
                    src="{{ $armadas->first()->gambar }}"
                    alt="{{ $armadas->first()->nama_kendaraan }}"
                    referrerpolicy="no-referrer"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                >

                <div class="hero-image-placeholder" style="display:none;">
                    Gambar kendaraan tidak tersedia
                </div>

            @else

                <div class="hero-image-placeholder">
                    🚘 &nbsp; DriveEase
                </div>

            @endif

        </div>

    </section>


    {{-- ==========================
         BENEFIT SECTION
    =========================== --}}

    <section class="benefit-section">

        <div class="benefit-item">

            <div class="benefit-icon">
                🚘
            </div>

            <div>
                <h4>Pilihan Kendaraan</h4>
                <p>Beragam kendaraan sesuai kebutuhanmu.</p>
            </div>

        </div>


        <div class="benefit-item">

            <div class="benefit-icon">
                💰
            </div>

            <div>
                <h4>Harga Transparan</h4>
                <p>Informasi harga sewa yang jelas.</p>
            </div>

        </div>


        <div class="benefit-item">

            <div class="benefit-icon">
                🛡️
            </div>

            <div>
                <h4>Pemesanan Mudah</h4>
                <p>Pesan kendaraan melalui website.</p>
            </div>

        </div>

    </section>


    {{-- ==========================
         POPULAR CARS
    =========================== --}}

    <section class="cars-section">

        <div class="section-heading">

            <div>
                <h2>Pilihan Mobil Kami</h2>

                <p>
                    Temukan kendaraan yang tepat untuk perjalananmu.
                </p>
            </div>

            <a href="{{ route('armada.index') }}" class="section-link">
                Lihat Semua Mobil →
            </a>

        </div>


        <div class="home-car-grid">

            @forelse($armadas as $a)

                <article class="home-car-card">

                    <div class="car-image-wrapper">

                        <span class="car-type">
                            {{ $a->tipe ?: 'Kendaraan' }}
                        </span>

                        @if(!empty($a->gambar))

                            <img
                                src="{{ $a->gambar }}"
                                alt="{{ $a->nama_kendaraan }}"
                                loading="lazy"
                                referrerpolicy="no-referrer"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            >

                            <div
                                style="display:none; width:100%; height:100%; align-items:center; justify-content:center; color:#9CA3AF; font-size:13px;"
                            >
                                Gambar gagal dimuat
                            </div>

                        @else

                            <div style="color:#9CA3AF; font-size:13px;">
                                Gambar belum tersedia
                            </div>

                        @endif

                    </div>


                    <div class="car-card-body">

                        <h3>
                            {{ $a->nama_kendaraan }}
                        </h3>

                        <p class="car-transmission">
                            ⚙ Transmisi:
                            {{ $a->transmisi ?: 'Belum diisi' }}
                        </p>


                        <div class="car-card-footer">

                            <div class="car-price">

                                Rp{{ number_format($a->harga_sewa, 0, ',', '.') }}

                                <small>Per hari</small>

                            </div>


                            @if(session('role') === 'customer')

                                <a
                                    href="{{ route('booking.create', $a->id_armada) }}"
                                    class="car-detail-btn"
                                >
                                    Pesan Sekarang
                                </a>

                            @else

                                <a
                                    href="{{ route('armada.index') }}"
                                    class="car-detail-btn"
                                >
                                    Lihat Mobil
                                </a>

                            @endif

                        </div>

                    </div>

                </article>

            @empty

                <div class="empty-cars">

                    <div style="font-size:40px;">
                        🚘
                    </div>

                    <h3>Belum Ada Mobil Tersedia</h3>

                    <p>
                        Silakan kunjungi kembali halaman ini
                        untuk melihat pilihan kendaraan kami.
                    </p>

                </div>

            @endforelse

        </div>

    </section>


    {{-- ==========================
         CALL TO ACTION
    =========================== --}}

    <section class="home-cta">

        <div>

            <h2>Siap Memulai Perjalananmu?</h2>

            <p>
                Temukan mobil yang sesuai dengan kebutuhanmu
                dan lakukan pemesanan sekarang.
            </p>

        </div>

        <a href="{{ route('armada.index') }}" class="btn">
            Mulai Sewa Mobil →
        </a>

    </section>

</div>

@endsection
