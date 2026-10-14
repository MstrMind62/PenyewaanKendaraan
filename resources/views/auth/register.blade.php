
@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')
<style>
    .register-page,
    .register-page * {
        box-sizing: border-box;
    }

    .register-page {
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

    /* Dekorasi background */
    .register-page::before,
    .register-page::after {
        content: "";
        position: absolute;
        z-index: -1;
        border-radius: 50%;
        filter: blur(2px);
        pointer-events: none;
    }

    .register-page::before {
        width: 450px;
        height: 450px;
        top: -220px;
        right: -100px;
        background: rgba(128, 20, 35, .3);
    }

    .register-page::after {
        width: 420px;
        height: 420px;
        bottom: -250px;
        left: -100px;
        background: rgba(12, 83, 105, .28);
    }

    /* Panel utama */
    .register-shell {
        position: relative;
        width: 100%;
        max-width: 1000px;
        margin: auto;
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

    /* Navbar */
    .register-navbar {
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

    .register-brand {
        color: #ffffff;
        text-decoration: none;
        font-size: 20px;
        font-weight: 800;
        letter-spacing: -.5px;
    }

    .register-brand span {
        color: #73c9ef;
    }

    .register-nav-links {
        display: flex;
        align-items: center;
        gap: 25px;
    }

    .register-nav-links a {
        color: #d3d6de;
        text-decoration: none;
        font-size: 12px;
        transition: color .2s;
    }

    .register-nav-links a:hover {
        color: #ffffff;
    }

    .register-nav-links .register-nav-button {
        padding: 9px 17px;
        border-radius: 20px;
        background: #ffffff;
        color: #111827;
        font-weight: 700;
    }

    .register-nav-links .register-nav-button:hover {
        background: #dceaf5;
    }

    /* Dua kolom */
    .register-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-items: stretch;
    }

    /* Panel kiri */
    .register-visual {
        position: relative;
        min-width: 0;
        min-height: 570px;
        padding: 42px;

        display: flex;
        align-items: center;
        justify-content: center;

        overflow: hidden;
        background:
            radial-gradient(ellipse at 35% 50%, rgba(26, 74, 91, .4), transparent 60%),
            linear-gradient(145deg, rgba(3, 12, 21, .2), rgba(3, 10, 18, .6));
    }

    .register-visual::before,
    .register-visual::after {
        content: "";
        position: absolute;
        border: 1px solid rgba(255, 255, 255, .08);
        border-radius: 50%;
        pointer-events: none;
    }

    .register-visual::before {
        width: 410px;
        height: 410px;
    }

    .register-visual::after {
        width: 320px;
        height: 320px;
        border-color: rgba(255, 255, 255, .06);
    }

    .register-visual-caption {
        position: absolute;
        z-index: 2;
        top: 35px;
        left: 38px;
        right: 25px;
    }

    .register-visual-tag {
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

    .register-visual-caption h1 {
        max-width: 360px;
        margin: 0;
        color: #ffffff;
        font-size: clamp(28px, 3.1vw, 42px);
        line-height: 1.16;
        letter-spacing: -1.3px;
    }

    .register-visual-caption h1 span {
        color: #73c9ef;
    }

    .register-visual-caption p {
        max-width: 310px;
        margin: 13px 0 0;
        color: #b7c3d0;
        font-size: 12px;
        line-height: 1.8;
    }

    /* Tempat gambar mobil */
    .register-car-placeholder {
        position: relative;
        z-index: 1;
        width: 100%;
        min-height: 260px;
        margin-top: 155px;

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

    .register-car-icon {
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

    .register-car-placeholder strong {
        color: #ffffff;
        font-size: 13px;
    }

    /* Panel form kanan */
    .register-form-side {
        display: flex;
        align-items: center;
        justify-content: center;

        padding: 35px 38px;
        background: rgba(255, 255, 255, .045);
        border-left: 1px solid rgba(255, 255, 255, .08);
    }

    .register-form-card {
        width: 100%;
        max-width: 350px;
        padding: 8px 0;
    }

    .register-form-logo {
        width: 41px;
        height: 41px;
        margin-bottom: 17px;

        display: flex;
        align-items: center;
        justify-content: center;

        border: 1px solid rgba(255, 255, 255, .15);
        border-radius: 12px;
        background: rgba(255, 255, 255, .08);

        color: #ffffff;
        font-size: 18px;
        font-weight: 800;
    }

    .register-form-card h2 {
        margin: 0 0 9px;
        color: #ffffff;
        font-size: 29px;
        font-weight: 800;
        letter-spacing: -1px;
    }

    .register-description {
        margin: 0 0 23px;
        color: #aeb8c7;
        font-size: 12px;
        line-height: 1.8;
    }

    /* Alert */
    .register-alert {
        margin-bottom: 15px;
        padding: 11px 13px;
        border: 1px solid rgba(255, 115, 115, .3);
        border-radius: 7px;
        background: rgba(140, 32, 40, .2);
        color: #ffc1c1;
        font-size: 12px;
        line-height: 1.7;
    }

    .register-alert ul {
        margin: 0;
        padding-left: 18px;
    }

    .register-alert.success {
        border-color: rgba(91, 210, 145, .3);
        background: rgba(24, 112, 72, .2);
        color: #baf2d0;
    }

    /* Input */
    .register-field {
        margin-bottom: 14px;
    }

    .register-field label {
        display: block;
        margin-bottom: 7px;
        color: #e9edf3;
        font-size: 12px;
        font-weight: 650;
    }

    .register-input-wrap {
        position: relative;
    }

    .register-input {
        width: 100%;
        height: 42px;
        padding: 0 12px;

        border: 1px solid #dce0e6;
        border-radius: 6px;
        outline: none;

        background: #f1f2f4;
        color: #171a20;
        font-family: inherit;
        font-size: 12px;

        transition: border-color .2s, box-shadow .2s, background .2s;
    }

    .register-input::placeholder {
        color: #8b919b;
    }

    .register-input:focus {
        border-color: #7dc8f1;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(87, 183, 239, .16);
    }

    .register-password-input {
        padding-right: 92px;
    }

    .register-password-toggle {
        position: absolute;
        top: 50%;
        right: 11px;
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

    .register-password-toggle:hover {
        color: #087fbe;
    }

    /* Tombol daftar */
    .register-submit {
        width: 100%;
        min-height: 44px;
        margin-top: 5px;
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

        transition: background .2s, transform .2s;
    }

    .register-submit:hover {
        transform: translateY(-1px);
        background: #dceaf5;
        border-color: #dceaf5;
    }

    .register-submit:focus-visible,
    .register-password-toggle:focus-visible {
        outline: 2px solid #7dc8f1;
        outline-offset: 3px;
    }

    .register-divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 20px 0 15px;

        color: #b6c0ce;
        font-size: 10px;
        white-space: nowrap;
    }

    .register-divider::before,
    .register-divider::after {
        content: "";
        height: 1px;
        flex: 1;
        background: rgba(255, 255, 255, .22);
    }

    .register-login-text {
        margin: 0;
        color: #aeb8c7;
        font-size: 11px;
        text-align: center;
    }

    .register-login-text a {
        color: #ffffff;
        font-weight: 750;
        text-decoration: none;
    }

    .register-login-text a:hover {
        text-decoration: underline;
    }

    /* Footer */
    .register-footer {
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

    .register-footer strong {
        color: #e8edf4;
    }

    /* Tablet */
    @media (max-width: 850px) {
        .register-page {
            padding: 25px 4%;
        }

        .register-navbar {
            padding: 0 25px;
        }

        .register-visual {
            padding: 25px;
        }

        .register-visual-caption {
            left: 25px;
            top: 30px;
        }

        .register-visual-caption h1 {
            font-size: 30px;
        }

        .register-form-side {
            padding: 30px 25px;
        }
    }

    /* Mobile */
    @media (max-width: 620px) {
        .register-page {
            min-height: 100vh;
            padding: 15px;
        }

        .register-shell {
            max-width: 440px;
        }

        .register-navbar {
            min-height: 62px;
            padding: 0 18px;
        }

        .register-brand {
            font-size: 17px;
        }

        .register-nav-links {
            gap: 13px;
        }

        .register-nav-links a {
            font-size: 11px;
        }

        .register-nav-links a:first-child,
        .register-nav-links a:nth-child(2) {
            display: none;
        }

        .register-content {
            display: flex;
            flex-direction: column;
        }

        .register-visual {
            order: 2;
            min-height: 220px;
            padding: 20px;
        }

        .register-visual-caption {
            top: 20px;
            left: 20px;
        }

        .register-visual-tag {
            margin-bottom: 10px;
            padding: 6px 9px;
            font-size: 9px;
        }

        .register-visual-caption h1 {
            max-width: 260px;
            font-size: 25px;
        }

        .register-visual-caption p {
            max-width: 260px;
            margin-top: 8px;
            font-size: 11px;
        }

        .register-visual::before {
            width: 280px;
            height: 280px;
        }

        .register-visual::after {
            width: 220px;
            height: 220px;
        }

        .register-car-placeholder {
            min-height: 85px;
            margin-top: 115px;
            padding: 10px;
        }

        .register-car-icon {
            width: 35px;
            height: 35px;
            font-size: 17px;
        }

        .register-form-side {
            order: 1;
            padding: 28px 23px;
            border-left: none;
        }

        .register-form-card {
            max-width: none;
        }

        .register-form-card h2 {
            font-size: 27px;
        }

        .register-footer {
            padding: 13px 18px;
            font-size: 9px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .register-page * {
            transition: none !important;
        }
    }
</style>

<div class="register-page">
    <div class="register-shell">

        {{-- NAVBAR --}}
        <header class="register-navbar">
            <a href="{{ route('home') }}" class="register-brand">
                Sewa<span>Kendaraan.</span>
            </a>

            <nav class="register-nav-links">
                <a href="{{ route('home') }}">Beranda</a>
                <a href="{{ route('armada.index') }}">Armada</a>
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}" class="register-nav-button">
                    Daftar
                </a>
            </nav>
        </header>

        <main class="register-content">

            {{-- KIRI: VISUAL --}}
            <section class="register-visual">
                <div class="register-visual-caption">
                    <span class="register-visual-tag">
                        Partner Perjalananmu
                    </span>

                    <h1>
                        Mulai perjalanan<br>
                        <span>bersama kami.</span>
                    </h1>

                    <p>
                        Daftar sekarang dan temukan kendaraan yang sesuai
                        dengan kebutuhan perjalananmu.
                    </p>
                </div>

                <div class="register-car-placeholder">
                    <div class="register-car-icon">+</div>
                    <strong>Gambar Mobil</strong>
                    <span>Gambar kendaraanmu akan dipasang di area ini.</span>
                </div>

                {{--
                    Jika gambar mobil sudah siap, ganti placeholder
                    dengan tag img dan alamat gambar milikmu.
                --}}
            </section>

            {{-- KANAN: FORM DAFTAR --}}
            <section class="register-form-side">
                <div class="register-form-card">

                    <div class="register-form-logo" aria-hidden="true">
                        SK
                    </div>

                    <h2>Buat akun</h2>

                    <p class="register-description">
                        Lengkapi data berikut untuk mulai menyewa kendaraan.
                    </p>

                    @if ($errors->any())
                        <div class="register-alert" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="register-alert success" role="status">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.store') }}">
                        @csrf

                        <div class="register-field">
                            <label for="nama">Nama lengkap</label>
                            <input
                                class="register-input"
                                type="text"
                                id="nama"
                                name="nama"
                                value="{{ old('nama') }}"
                                placeholder="Masukkan nama lengkap"
                                maxlength="120"
                                autocomplete="name"
                                required
                            >
                        </div>

                        <div class="register-field">
                            <label for="email">Email</label>
                            <input
                                class="register-input"
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="nama@email.com"
                                maxlength="150"
                                autocomplete="email"
                                required
                            >
                        </div>

                        <div class="register-field">
                            <label for="no_hp">Nomor HP</label>
                            <input
                                class="register-input"
                                type="tel"
                                id="no_hp"
                                name="no_hp"
                                value="{{ old('no_hp') }}"
                                placeholder="Contoh: 081234567890"
                                maxlength="25"
                                autocomplete="tel"
                                required
                            >
                        </div>

                        <div class="register-field">
                            <label for="password">
                                Password (minimal 8 karakter)
                            </label>

                            <div class="register-input-wrap">
                                <input
                                    class="register-input register-password-input"
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="Buat password"
                                    minlength="8"
                                    autocomplete="new-password"
                                    required
                                >

                                <button
                                    type="button"
                                    class="register-password-toggle"
                                    data-target="password"
                                    aria-pressed="false"
                                >
                                    Lihat password
                                </button>
                            </div>
                        </div>

                        <div class="register-field">
                            <label for="password_confirmation">
                                Ulangi password
                            </label>

                            <div class="register-input-wrap">
                                <input
                                    class="register-input register-password-input"
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="Masukkan ulang password"
                                    minlength="8"
                                    autocomplete="new-password"
                                    required
                                >

                                <button
                                    type="button"
                                    class="register-password-toggle"
                                    data-target="password_confirmation"
                                    aria-pressed="false"
                                >
                                    Lihat password
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="register-submit">
                            <span>Buat akun sekarang</span>
                            <span aria-hidden="true">→</span>
                        </button>
                    </form>

                    <div class="register-divider">
                        Pendaftaran customer
                    </div>

                    <p class="register-login-text">
                        Sudah punya akun?
                        <a href="{{ route('login') }}">Login sekarang</a>
                    </p>

                </div>
            </section>

        </main>

        <footer class="register-footer">
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
        const toggleButtons = document.querySelectorAll(
            '.register-password-toggle'
        );

        toggleButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const targetId = button.dataset.target;
                const input = document.getElementById(targetId);

                if (!input) {
                    return;
                }

                const isHidden = input.type === 'password';

                input.type = isHidden ? 'text' : 'password';

                button.textContent = isHidden
                    ? 'Sembunyikan'
                    : 'Lihat password';

                button.setAttribute(
                    'aria-pressed',
                    String(isHidden)
                );
            });
        });
    });
</script>
@endsection
