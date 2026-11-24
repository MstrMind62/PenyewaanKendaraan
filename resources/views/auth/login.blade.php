
@extends('layouts.app')

@section('title', 'Login Customer')

@section('content')
<style>
    /* Container Login */
    .login-page {
        min-height: 75vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 45px 20px;
        background: #fafafa;
    }

    .login-container {
        width: 100%;
        max-width: 1000px;
        min-height: 570px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        background: #ffffff;
        border: 1px solid #eeeeee;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 12px 35px rgba(0,0,0,.06);
    }

    /* Bagian Kiri */
    .login-visual {
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 55px;
        background: linear-gradient(145deg, #fff5ec, #ffead9);
        overflow: hidden;
    }

    .login-brand {
        position: absolute;
        top: 35px;
        left: 40px;
        color: #292929;
        font-size: 19px;
        font-weight: 800;
        text-decoration: none;
        letter-spacing: -.5px;
    }

    .login-brand span {
        color: #f07828;
    }

    .visual-content {
        position: relative;
        z-index: 2;
    }

    .visual-tag {
        display: inline-block;
        margin-bottom: 18px;
        padding: 7px 12px;
        border-radius: 20px;
        background: #ffffff;
        color: #e87525;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .visual-content h1 {
        margin: 0 0 18px;
        color: #292929;
        font-size: 39px;
        font-weight: 850;
        line-height: 1.2;
        letter-spacing: -1.3px;
    }

    .visual-content p {
        max-width: 350px;
        margin: 0;
        color: #777777;
        font-size: 14px;
        line-height: 1.8;
    }

    .visual-decoration {
        position: absolute;
        width: 230px;
        height: 230px;
        right: -65px;
        bottom: -75px;
        border: 35px solid rgba(240,120,40,.12);
        border-radius: 50%;
    }

    .visual-decoration::before {
        content: "";
        position: absolute;
        width: 100px;
        height: 100px;
        left: -110px;
        top: -150px;
        border: 20px solid rgba(240,120,40,.10);
        border-radius: 50%;
    }

    .visual-footer {
        position: absolute;
        bottom: 28px;
        left: 40px;
        color: #a18c7d;
        font-size: 11px;
    }

    /* Bagian Kanan */
    .login-form-section {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 45px;
        background: #ffffff;
    }

    .login-form {
        width: 100%;
        max-width: 350px;
    }

    .form-icon {
        width: 52px;
        height: 52px;
        display: grid;
        place-items: center;
        margin-bottom: 25px;
        border-radius: 13px;
        background: #fff0e6;
        color: #f07828;
        font-size: 24px;
        font-weight: 850;
    }

    .login-form h2 {
        margin: 0 0 8px;
        color: #292929;
        font-size: 27px;
        font-weight: 800;
    }

    .form-subtitle {
        margin: 0 0 28px;
        color: #888888;
        font-size: 13px;
        line-height: 1.6;
    }

    /* Alert */
    .login-alert {
        padding: 12px 14px;
        border-radius: 9px;
        margin-bottom: 19px;
        font-size: 12px;
        line-height: 1.6;
    }

    .login-alert.error {
        background: #fff0f0;
        border: 1px solid #f4cccc;
        color: #c03939;
    }

    .login-alert.success {
        background: #eaf8ef;
        border: 1px solid #c9ecd5;
        color: #218653;
    }

    /* Input */
    .input-group {
        margin-bottom: 19px;
    }

    .input-group label {
        display: block;
        margin-bottom: 8px;
        color: #444444;
        font-size: 13px;
        font-weight: 700;
    }

    .input-wrap {
        position: relative;
    }

    .input-field {
        width: 100%;
        height: 47px;
        padding: 0 14px;
        border: 1px solid #dddddd;
        border-radius: 9px;
        background: #ffffff;
        color: #292929;
        font-family: inherit;
        font-size: 13px;
        outline: none;
        transition: .2s;
    }

    .input-field:focus {
        border-color: #f07828;
        box-shadow: 0 0 0 3px rgba(240,120,40,.12);
    }

    .input-field::placeholder {
        color: #aaaaaa;
    }

    .password-field {
        padding-right: 85px;
    }

    .toggle-pw {
        position: absolute;
        top: 50%;
        right: 13px;
        transform: translateY(-50%);
        border: none;
        background: none;
        color: #e87525;
        font-size: 11px;
        font-weight: 800;
        cursor: pointer;
    }

    .toggle-pw:hover {
        color: #c75b16;
    }

    /* Tombol Login */
    .btn-submit {
        width: 100%;
        height: 48px;
        margin-top: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: none;
        border-radius: 9px;
        background: #f07828;
        color: #ffffff;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        transition: .2s;
    }

    .btn-submit:hover {
        background: #dc6418;
        transform: translateY(-1px);
    }

    .login-links {
        margin-top: 23px;
        text-align: center;
    }

    .login-links a {
        display: block;
        margin-top: 12px;
        color: #888888;
        font-size: 12px;
        text-decoration: none;
        transition: .2s;
    }

    .login-links a:hover {
        color: #f07828;
    }

    .login-links a.register-link {
        color: #f07828;
        font-weight: 750;
    }

    /* Responsive */
    @media(max-width: 750px) {
        .login-page {
            padding: 25px 15px;
        }

        .login-container {
            grid-template-columns: 1fr;
            min-height: auto;
        }

        .login-visual {
            min-height: 240px;
            padding: 65px 30px 35px;
        }

        .login-brand {
            top: 22px;
            left: 30px;
        }

        .visual-content h1 {
            font-size: 30px;
        }

        .visual-footer {
            display: none;
        }

        .login-form-section {
            padding: 35px 25px;
        }
    }
</style>

<div class="login-page">

    <div class="login-container">

        {{-- Bagian Visual --}}
        <div class="login-visual">

            <a href="{{ route('home') }}" class="login-brand">
                SewaKendaraan<span>.</span>
            </a>

            <div class="visual-content">
                <span class="visual-tag">Customer Portal</span>

                <h1>Sewa kendaraan.<br>Lebih mudah.</h1>

                <p>
                    Temukan kendaraan yang sesuai kebutuhanmu,
                    atur jadwal penyewaan, dan pantau pesanan
                    dalam satu tempat.
                </p>
            </div>

            <div class="visual-decoration"></div>

            <div class="visual-footer">
                © {{ date('Y') }} SewaKendaraan · Customer Area
            </div>

        </div>

        {{-- Bagian Form Login --}}
        <div class="login-form-section">

            <div class="login-form">

                <div class="form-icon">S</div>

                <h2>Selamat Datang!</h2>

                <p class="form-subtitle">
                    Masuk menggunakan akun customer untuk melanjutkan.
                </p>

                {{-- Notifikasi Error --}}
                @if ($errors->any())
                    <div class="login-alert error">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                {{-- Notifikasi Sukses --}}
                @if (session('success'))
                    <div class="login-alert success">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}">
                    @csrf

                    <div class="input-group">
                        <label for="email">Email Customer</label>

                        <div class="input-wrap">
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="input-field"
                                placeholder="nama@domain.com"
                                value="{{ old('email') }}"
                                required
                                autofocus
                            >
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="password">Password</label>

                        <div class="input-wrap">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="input-field password-field"
                                placeholder="Masukkan password"
                                autocomplete="current-password"
                                required
                            >

                            <button
                                type="button"
                                class="toggle-pw"
                                id="togglePassword"
                            >
                                Lihat
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        Masuk ke Dashboard →
                    </button>

                </form>

                <div class="login-links">

                    <a href="{{ route('home') }}">
                        ← Kembali ke website utama
                    </a>

                    <a href="{{ route('register') }}" class="register-link">
                        Belum punya akun? Daftar sekarang
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const password = document.getElementById('password');
        const toggle = document.getElementById('togglePassword');

        if (password && toggle) {

            toggle.addEventListener('click', function () {

                const isHidden = password.type === 'password';

                password.type = isHidden ? 'text' : 'password';

                toggle.textContent = isHidden
                    ? 'Sembunyikan'
                    : 'Lihat';

            });

        }

    });
</script>
@endsection
