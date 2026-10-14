
@extends('layouts.app')

@section('title', 'Login')

@section('content')
<style>
    .login-page,
    .login-page * {
        box-sizing: border-box;
    }

    .login-page {
        --white: #ffffff;
        --muted: #c2c7d0;

        position: relative;
        left: 50%;
        width: 100vw;
        min-height: 100vh;
        margin-left: -50vw;
        padding: 35px 5%;

        display: flex;
        align-items: center;
        justify-content: center;

        overflow: hidden;
        isolation: isolate;
        color: var(--white);
        font-family: "Segoe UI", Arial, sans-serif;

        background:
            radial-gradient(ellipse at 15% 15%, #092b38 0%, transparent 35%),
            radial-gradient(ellipse at 85% 30%, #60151f 0%, transparent 40%),
            radial-gradient(ellipse at 65% 90%, #071e2b 0%, transparent 45%),
            #080b12;
    }

    /* Cahaya dekorasi background */
    .login-page::before,
    .login-page::after {
        content: "";
        position: absolute;
        z-index: -1;
        border-radius: 50%;
        filter: blur(2px);
        pointer-events: none;
    }

    .login-page::before {
        width: 450px;
        height: 450px;
        top: -220px;
        right: -100px;
        background: rgba(128, 20, 35, .3);
    }

    .login-page::after {
        width: 420px;
        height: 420px;
        bottom: -250px;
        left: -100px;
        background: rgba(12, 83, 105, .28);
    }

    /* Panel utama */
    .login-shell {
        position: relative;
        width: 100%;
        max-width: 1120px;
        min-height: 570px;
        overflow: hidden;

        display: flex;
        flex-direction: column;

        border: 1px solid rgba(255, 255, 255, .15);
        border-radius: 14px;

        background: rgba(16, 22, 31, .68);
        box-shadow: 0 25px 80px rgba(0, 0, 0, .4);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
    }

    /* Navbar panel */
    .login-navbar {
        position: relative;
        z-index: 3;
        min-height: 68px;
        padding: 0 36px;

        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;

        border-bottom: 1px solid rgba(255, 255, 255, .09);
        background: rgba(0, 0, 0, .12);
    }

    .login-brand {
        color: #ffffff;
        text-decoration: none;
        font-size: 20px;
        font-weight: 800;
        letter-spacing: -.5px;
    }

    .login-brand span {
        color: #73c9ef;
    }

    .login-nav-links {
        display: flex;
        align-items: center;
        gap: 25px;
    }

    .login-nav-links a {
        color: #d3d6de;
        text-decoration: none;
        font-size: 12px;
        transition: color .2s;
    }

    .login-nav-links a:hover {
        color: #ffffff;
    }

    .login-nav-links .login-nav-register {
        padding: 9px 17px;
        border-radius: 20px;
        background: #ffffff;
        color: #111827;
        font-weight: 700;
    }

    .login-nav-links .login-nav-register:hover {
        background: #dceaf5;
    }

    /* Layout dua kolom */
    .login-content {
        flex: 1;
        display: grid;
        grid-template-columns: 1.1fr .9fr;
        align-items: stretch;
    }

    /* Area visual mobil */
    .login-visual {
        position: relative;
        min-width: 0;
        min-height: 480px;
        padding: 42px;

        display: flex;
        align-items: center;
        justify-content: center;

        overflow: hidden;
        background:
            radial-gradient(ellipse at 35% 50%, rgba(26, 74, 91, .4), transparent 60%),
            linear-gradient(145deg, rgba(3, 12, 21, .2), rgba(3, 10, 18, .6));
    }

    .login-visual::before {
        content: "";
        position: absolute;
        width: 410px;
        height: 410px;
        border: 1px solid rgba(255, 255, 255, .08);
        border-radius: 50%;
        pointer-events: none;
    }

    .login-visual::after {
        content: "";
        position: absolute;
        width: 320px;
        height: 320px;
        border: 1px solid rgba(255, 255, 255, .06);
        border-radius: 50%;
        pointer-events: none;
    }

    .login-visual-caption {
        position: absolute;
        z-index: 2;
        top: 35px;
        left: 38px;
        right: 25px;
    }

    .login-visual-tag {
        display: inline-block;
        margin-bottom: 18px;
        padding: 7px 12px;

        border: 1px solid rgba(255, 255, 255, .17);
        border-radius: 20px;
        background: rgba(255, 255, 255, .06);

        color: #d8e9f4;
        font-size: 10px;
        letter-spacing: 1.2px;
        text-transform: uppercase;
    }

    .login-visual-caption h2 {
        max-width: 360px;
        margin: 0;
        color: #ffffff;
        font-size: clamp(28px, 3.1vw, 42px);
        line-height: 1.16;
        letter-spacing: -1.3px;
    }

    .login-visual-caption p {
        max-width: 310px;
        margin: 13px 0 0;
        color: #b7c3d0;
        font-size: 12px;
        line-height: 1.8;
    }

    /* Tempat gambar mobil */
    .login-car-image {
        position: absolute;
        z-index: 1;
        left: 50%;
        bottom: 38px;
        transform: translateX(-50%);

        display: block;
        width: 110%;
        max-width: 610px;
        max-height: 340px;
        object-fit: contain;

        filter: drop-shadow(0 22px 25px rgba(0, 0, 0, .5));
        animation: carEnter .9s ease both;
    }

    .login-car-placeholder {
        position: relative;
        z-index: 1;
        width: 100%;
        min-height: 270px;
        margin-top: 145px;

        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 12px;

        border: 1px dashed rgba(255, 255, 255, .18);
        border-radius: 10px;
        background: rgba(255, 255, 255, .025);

        color: #9daab8;
        text-align: center;
        font-size: 12px;
    }

    .login-car-placeholder-icon {
        width: 48px;
        height: 48px;

        display: flex;
        align-items: center;
        justify-content: center;

        border: 1px solid rgba(255, 255, 255, .18);
        border-radius: 50%;

        color: #9fdcff;
        font-size: 23px;
    }

    .login-car-placeholder strong {
        color: #ffffff;
        font-size: 13px;
    }

    /* Bagian form */
    .login-form-side {
        display: flex;
        align-items: center;
        justify-content: center;

        padding: 38px 42px;
        background: rgba(255, 255, 255, .045);
        border-left: 1px solid rgba(255, 255, 255, .08);
    }

    .login-form-card {
        width: 100%;
        max-width: 340px;
        animation: formEnter .55s ease both;
    }

    .login-form-logo {
        width: 43px;
        height: 43px;
        margin-bottom: 20px;

        display: flex;
        align-items: center;
        justify-content: center;

        border: 1px solid rgba(255, 255, 255, .15);
        border-radius: 12px;
        background: rgba(255, 255, 255, .08);

        color: #ffffff;
        font-size: 19px;
        font-weight: 800;
    }

    .login-form-card h1 {
        margin: 0 0 10px;
        color: #ffffff;
        font-size: 31px;
        font-weight: 800;
        letter-spacing: -1px;
    }

    .login-form-description {
        margin: 0 0 29px;
        color: #aeb8c7;
        font-size: 12px;
        line-height: 1.8;
    }

    /* Alert */
    .login-alert {
        margin-bottom: 18px;
        padding: 12px 14px;
        border: 1px solid rgba(255, 115, 115, .3);
        border-radius: 7px;
        background: rgba(140, 32, 40, .2);
        color: #ffc1c1;
        font-size: 12px;
        line-height: 1.7;
    }

    .login-alert.success {
        border-color: rgba(91, 210, 145, .3);
        background: rgba(24, 112, 72, .2);
        color: #baf2d0;
    }

    /* Input */
    .login-field {
        margin-bottom: 19px;
    }

    .login-field label {
        display: block;
        margin-bottom: 8px;
        color: #e9edf3;
        font-size: 12px;
        font-weight: 650;
    }

    .login-input-wrap {
        position: relative;
    }

    .login-input {
        width: 100%;
        height: 45px;
        padding: 0 13px;

        border: 1px solid #dce0e6;
        border-radius: 6px;
        outline: none;

        background: #f1f2f4;
        color: #171a20;
        font-family: inherit;
        font-size: 12px;

        transition: border-color .2s, box-shadow .2s, background .2s;
    }

    .login-input::placeholder {
        color: #8b919b;
    }

    .login-input:focus {
        border-color: #7dc8f1;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(87, 183, 239, .16);
    }

    .login-password-input {
        padding-right: 105px;
    }

    .login-password-toggle {
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);

        padding: 5px 0;
        border: none;
        background: transparent;

        color: #465466;
        cursor: pointer;
        font-family: inherit;
        font-size: 10px;
        font-weight: 700;
    }

    .login-password-toggle:hover {
        color: #087fbe;
    }

    .login-forgot {
        display: flex;
        justify-content: flex-end;
        margin-top: -7px;
        margin-bottom: 23px;
    }

    .login-forgot a {
        color: #c3cbd5;
        font-size: 11px;
        text-decoration: none;
    }

    .login-forgot a:hover {
        color: #ffffff;
    }

    /* Tombol masuk */
    .login-submit {
        width: 100%;
        min-height: 45px;
        padding: 12px 16px;

        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;

        border: 1px solid #ffffff;
        border-radius: 6px;
        background: #ffffff;
        color: #111827;

        cursor: pointer;
        font-family: inherit;
        font-size: 12px;
        font-weight: 800;

        transition: background .2s, color .2s, transform .2s;
    }

    .login-submit:hover {
        transform: translateY(-1px);
        background: #dceaf5;
        border-color: #dceaf5;
    }

    .login-submit:active {
        transform: translateY(0);
    }

    .login-submit:focus-visible,
    .login-password-toggle:focus-visible {
        outline: 2px solid #7dc8f1;
        outline-offset: 3px;
    }

    .login-divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 24px 0 19px;

        color: #b6c0ce;
        font-size: 10px;
        white-space: nowrap;
    }

    .login-divider::before,
    .login-divider::after {
        content: "";
        height: 1px;
        flex: 1;
        background: rgba(255, 255, 255, .22);
    }

    .login-register-text {
        margin: 20px 0 0;
        color: #aeb8c7;
        font-size: 11px;
        text-align: center;
    }

    .login-register-text a {
        color: #ffffff;
        font-weight: 750;
        text-decoration: none;
    }

    .login-register-text a:hover {
        text-decoration: underline;
    }

    /* Footer */
    .login-footer {
        position: relative;
        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;

        padding: 15px 35px;
        border-top: 1px solid rgba(255, 255, 255, .08);

        color: #8d98a7;
        font-size: 10px;
    }

    .login-footer strong {
        color: #e8edf4;
    }

    /* Animasi */
    @keyframes carEnter {
        from {
            opacity: 0;
            transform: translate(-50%, 15px);
        }

        to {
            opacity: 1;
            transform: translate(-50%, 0);
        }
    }

    @keyframes formEnter {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Tablet */
    @media (max-width: 850px) {
        .login-page {
            padding: 25px 4%;
        }

        .login-shell {
            min-height: 520px;
        }

        .login-navbar {
            padding: 0 25px;
        }

        .login-content {
            grid-template-columns: 1fr 1fr;
        }

        .login-visual {
            min-height: 450px;
            padding: 25px;
        }

        .login-visual-caption {
            left: 25px;
            top: 30px;
        }

        .login-visual-caption h2 {
            font-size: 30px;
        }

        .login-form-side {
            padding: 30px 25px;
        }

        .login-car-image {
            width: 125%;
        }
    }

    /* Mobile */
    @media (max-width: 620px) {
        .login-page {
            min-height: 100vh;
            padding: 15px;
        }

        .login-shell {
            max-width: 440px;
            min-height: auto;
            margin: auto;
        }

        .login-navbar {
            min-height: 62px;
            padding: 0 18px;
        }

        .login-brand {
            font-size: 17px;
        }

        .login-nav-links {
            gap: 13px;
        }

        .login-nav-links a {
            font-size: 11px;
        }

        .login-nav-links a:first-child,
        .login-nav-links a:nth-child(2) {
            display: none;
        }

        .login-content {
            display: flex;
            flex-direction: column;
        }

        .login-visual {
            order: 2;
            min-height: 235px;
            padding: 20px;
        }

        .login-visual-caption {
            top: 20px;
            left: 20px;
        }

        .login-visual-tag {
            margin-bottom: 10px;
            padding: 6px 9px;
            font-size: 9px;
        }

        .login-visual-caption h2 {
            max-width: 260px;
            font-size: 25px;
        }

        .login-visual-caption p {
            max-width: 260px;
            margin-top: 8px;
            font-size: 11px;
        }

        .login-visual::before {
            width: 280px;
            height: 280px;
        }

        .login-visual::after {
            width: 220px;
            height: 220px;
        }

        .login-car-image {
            bottom: 0;
            width: 85%;
            max-height: 200px;
        }

        .login-car-placeholder {
            min-height: 100px;
            margin-top: 115px;
            padding: 15px;
        }

        .login-car-placeholder-icon {
            width: 35px;
            height: 35px;
            font-size: 17px;
        }

        .login-form-side {
            order: 1;
            padding: 30px 23px;
            border-left: none;
        }

        .login-form-card {
            max-width: none;
        }

        .login-form-logo {
            width: 38px;
            height: 38px;
            margin-bottom: 14px;
        }

        .login-form-card h1 {
            font-size: 28px;
        }

        .login-form-description {
            margin-bottom: 23px;
        }

        .login-footer {
            padding: 13px 18px;
            font-size: 9px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .login-car-image,
        .login-form-card {
            animation: none;
        }

        .login-page * {
            scroll-behavior: auto !important;
            transition: none !important;
        }
    }
</style>

<div class="login-page">
    <div class="login-shell">

        {{-- NAVBAR --}}
        <header class="login-navbar">
            <a href="{{ route('home') }}" class="login-brand">
                Sewa<span>Kendaraan.</span>
            </a>

            <nav class="login-nav-links">
                <a href="{{ route('home') }}">Beranda</a>
                <a href="{{ route('armada.index') }}">Armada</a>
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}" class="login-nav-register">
                    Daftar
                </a>
            </nav>
        </header>

        <main class="login-content">

            {{-- KIRI: VISUAL --}}
            <section class="login-visual">

                <div class="login-visual-caption">
                    <span class="login-visual-tag">
                        Partner Perjalananmu
                    </span>

                    <h2>
                        Perjalananmu dimulai dari sini.
                    </h2>

                    <p>
                        Temukan kendaraan yang tepat untuk setiap perjalanan.
                        Praktis, nyaman, dan sesuai kebutuhanmu.
                    </p>
                </div>

                {{-- Placeholder sementara untuk gambar mobil --}}
                <div class="login-car-placeholder">
                    <div class="login-car-placeholder-icon">+</div>

                    <strong>Gambar Mobil</strong>

                    <span>
                        Gambar kendaraanmu akan dipasang di area ini.
                    </span>
                </div>

                {{--
                    NANTI JIKA GAMBAR SUDAH SIAP:

                    Hapus div login-car-placeholder di atas,
                    lalu aktifkan kode img berikut.

                    <img
                        src="{{ asset('images/mobil-login.png') }}"
                        alt="Mobil rental"
                        class="login-car-image"
                    >
                --}}

            </section>

            {{-- KANAN: FORM LOGIN --}}
            <section class="login-form-side">
                <div class="login-form-card">

                    <div class="login-form-logo" aria-hidden="true">
                        SK
                    </div>

                    <h1>Selamat datang!</h1>

                    <p class="login-form-description">
                        Masuk untuk melanjutkan perjalananmu bersama kami.
                    </p>

                    {{-- Pesan error validasi --}}
                    @if ($errors->any())
                        <div class="login-alert" role="alert">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Pesan sukses --}}
                    @if (session('success'))
                        <div class="login-alert success" role="status">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form
                        method="POST"
                        action="{{ route('login.store') }}"
                    >
                        @csrf

                        <div class="login-field">
                            <label for="email">Email</label>

                            <input
                                class="login-input"
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="nama@email.com"
                                autocomplete="username"
                                maxlength="150"
                                required
                                autofocus
                            >
                        </div>

                        <div class="login-field">
                            <label for="password">Password</label>

                            <div class="login-input-wrap">
                                <input
                                    class="login-input login-password-input"
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="Masukkan password"
                                    autocomplete="current-password"
                                    required
                                >

                                <button
                                    type="button"
                                    class="login-password-toggle"
                                    id="togglePassword"
                                    aria-controls="password"
                                    aria-pressed="false"
                                >
                                    Lihat password
                                </button>
                            </div>
                        </div>

                        <div class="login-forgot">
                            <a href="{{ route('register') }}">
                                Belum punya akun?
                            </a>
                        </div>

                        <button type="submit" class="login-submit">
                            <span>Masuk ke akun</span>
                            <span aria-hidden="true">→</span>
                        </button>
                    </form>

                    <div class="login-divider">
                        Sewa kendaraan lebih mudah
                    </div>

                    <p class="login-register-text">
                        Belum terdaftar?
                        <a href="{{ route('register') }}">
                            Daftar sekarang
                        </a>
                    </p>

                </div>
            </section>

        </main>

        <footer class="login-footer">
            <span>
                © {{ date('Y') }}
                <strong>SewaKendaraan</strong>
            </span>

            <span>Teman perjalananmu.</span>
        </footer>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const password = document.getElementById('password');
        const toggle = document.getElementById('togglePassword');

        if (!password || !toggle) {
            return;
        }

        toggle.addEventListener('click', function () {
            const isHidden = password.type === 'password';

            password.type = isHidden ? 'text' : 'password';

            toggle.textContent = isHidden
                ? 'Sembunyikan'
                : 'Lihat password';

            toggle.setAttribute(
                'aria-pressed',
                String(isHidden)
            );
        });
    });
</script>
@endsection
