@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')
<style>
    /* Container Register */
    .register-page {
        min-height: 75vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 45px 20px;
        background: #fafafa;
    }

    .register-container {
        width: 100%;
        max-width: 1000px;
        min-height: 650px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        background: #ffffff;
        border: 1px solid #eeeeee;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 12px 35px rgba(0,0,0,.06);
    }

    /* Bagian Kiri */
    .register-visual {
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 55px;
        background: linear-gradient(145deg, #fff5ec, #ffead9);
        overflow: hidden;
    }

    .register-brand {
        position: absolute;
        top: 35px;
        left: 40px;
        color: #292929;
        font-size: 19px;
        font-weight: 800;
        text-decoration: none;
        letter-spacing: -.5px;
    }

    .register-brand span {
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
    .register-form-section {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 45px;
        background: #ffffff;
        overflow-y: auto;
    }

    .register-form {
        width: 100%;
        max-width: 350px;
        margin: auto;
        padding: 15px 0;
    }

    .form-icon {
        width: 52px;
        height: 52px;
        display: grid;
        place-items: center;
        margin-bottom: 22px;
        border-radius: 13px;
        background: #fff0e6;
        color: #f07828;
        font-size: 27px;
        font-weight: 850;
    }

    .register-form h2 {
        margin: 0 0 8px;
        color: #292929;
        font-size: 27px;
        font-weight: 800;
    }

    .form-subtitle {
        margin: 0 0 24px;
        color: #888888;
        font-size: 13px;
        line-height: 1.6;
    }

    /* Alert */
    .register-alert {
        padding: 12px 14px;
        border-radius: 9px;
        margin-bottom: 17px;
        font-size: 12px;
        line-height: 1.6;
    }

    .register-alert ul {
        margin: 0;
        padding-left: 18px;
    }

    .register-alert.error {
        background: #fff0f0;
        border: 1px solid #f4cccc;
        color: #c03939;
    }

    .register-alert.success {
        background: #eaf8ef;
        border: 1px solid #c9ecd5;
        color: #218653;
    }

    /* Input */
    .input-group {
        margin-bottom: 15px;
    }

    .input-group label {
        display: block;
        margin-bottom: 7px;
        color: #444444;
        font-size: 12px;
        font-weight: 700;
    }

    .input-wrap {
        position: relative;
    }

    .input-field {
        width: 100%;
        height: 44px;
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

    /* Tombol Submit */
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

    /* Link */
    .register-links {
        margin-top: 20px;
        text-align: center;
    }

    .register-links a {
        display: block;
        margin-top: 11px;
        color: #888888;
        font-size: 12px;
        text-decoration: none;
        transition: .2s;
    }

    .register-links a:hover {
        color: #f07828;
    }

    .register-links a.login-link {
        color: #f07828;
        font-weight: 750;
    }

    /* Responsive */
    @media(max-width: 750px) {
        .register-page {
            padding: 25px 15px;
        }

        .register-container {
            grid-template-columns: 1fr;
            min-height: auto;
        }

        .register-visual {
            min-height: 240px;
            padding: 65px 30px 35px;
        }

        .register-brand {
            top: 22px;
            left: 30px;
        }

        .visual-content h1 {
            font-size: 30px;
        }

        .visual-footer {
            display: none;
        }

        .register-form-section {
            padding: 30px 25px;
        }

        .register-form {
            padding: 0;
        }
    }
</style>

<div class="register-page">

    <div class="register-container">

        {{-- Bagian Visual --}}
        <div class="register-visual">

            <a href="{{ route('home') }}" class="register-brand">
                SewaKendaraan<span>.</span>
            </a>

            <div class="visual-content">
                <span class="visual-tag">Customer Portal</span>

                <h1>Mulai perjalanan.<br>Lebih mudah.</h1>

                <p>
                    Daftar sekarang dan temukan kendaraan yang sesuai
                    dengan kebutuhan perjalananmu. Proses cepat,
                    mudah, dan nyaman.
                </p>
            </div>

            <div class="visual-decoration"></div>

            <div class="visual-footer">
                © {{ date('Y') }} SewaKendaraan · Customer Area
            </div>

        </div>

        {{-- Bagian Form Register --}}
        <div class="register-form-section">

            <div class="register-form">

                <div class="form-icon">+</div>

                <h2>Buat Akun</h2>

                <p class="form-subtitle">
                    Lengkapi data berikut untuk mulai menyewa kendaraan.
                </p>

                {{-- Notifikasi Error --}}
                @if ($errors->any())
                    <div class="register-alert error" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Notifikasi Sukses --}}
                @if (session('success'))
                    <div class="register-alert success" role="status">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('register.store') }}">
                    @csrf

                    <div class="input-group">
                        <label for="nama">Nama Lengkap</label>

                        <div class="input-wrap">
                            <input
                                type="text"
                                id="nama"
                                name="nama"
                                class="input-field"
                                placeholder="Masukkan nama lengkap"
                                value="{{ old('nama') }}"
                                maxlength="120"
                                required
                                autofocus
                            >
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="email">Email</label>

                        <div class="input-wrap">
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="input-field"
                                placeholder="nama@domain.com"
                                value="{{ old('email') }}"
                                maxlength="150"
                                required
                            >
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="no_hp">Nomor HP</label>

                        <div class="input-wrap">
                            <input
                                type="tel"
                                id="no_hp"
                                name="no_hp"
                                class="input-field"
                                placeholder="Contoh: 081234567890"
                                value="{{ old('no_hp') }}"
                                maxlength="25"
                                required
                            >
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="password">Password (Minimal 8 karakter)</label>

                        <div class="input-wrap">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="input-field password-field"
                                placeholder="Buat password"
                                minlength="8"
                                autocomplete="new-password"
                                required
                            >

                            <button
                                type="button"
                                class="toggle-pw register-password-toggle"
                                data-target="password"
                            >
                                Lihat
                            </button>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="password_confirmation">Konfirmasi Password</label>

                        <div class="input-wrap">
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="input-field password-field"
                                placeholder="Masukkan ulang password"
                                minlength="8"
                                autocomplete="new-password"
                                required
                            >

                            <button
                                type="button"
                                class="toggle-pw register-password-toggle"
                                data-target="password_confirmation"
                            >
                                Lihat
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        Buat Akun Sekarang →
                    </button>

                </form>

                <div class="register-links">

                    <a href="{{ route('login') }}" class="login-link">
                        Sudah punya akun? Login sekarang
                    </a>

                    <a href="{{ route('home') }}">
                        ← Kembali ke website utama
                    </a>

                </div>

            </div>

        </div>

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

                if (!input) return;

                const isHidden = input.type === 'password';

                input.type = isHidden ? 'text' : 'password';

                button.textContent = isHidden
                    ? 'Sembunyikan'
                    : 'Lihat';

            });

        });

    });
</script>
@endsection
