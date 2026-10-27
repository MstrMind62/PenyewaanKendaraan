@extends('layouts.admin')

@section('title', 'Login Admin')

@section('content')
    <style>
        .admin-login {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            background: #080b10;
            color: #f3f6fa;
        }

        .login-story {
            position: relative;
            overflow: hidden;
            padding: clamp(30px, 6vw, 86px);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background:
                radial-gradient(circle at 15% 20%, rgba(72, 223, 197, 0.16), transparent 34%),
                radial-gradient(circle at 85% 80%, rgba(133, 40, 58, 0.2), transparent 35%),
                linear-gradient(145deg, #111b27, #080b10);
            border-right: 1px solid rgba(255, 255, 255, 0.08);
        }

        .login-brand {
            font: 800 22px Manrope, sans-serif;
        }

        .login-brand span {
            color: #48dfc5;
        }

        .story-copy {
            max-width: 560px;
            position: relative;
            z-index: 1;
        }

        .story-kicker {
            color: #48dfc5;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 11px;
            font-weight: 800;
        }

        .story-copy h1 {
            font: 800 clamp(36px, 5vw, 64px) / 1.08 Manrope, sans-serif;
            letter-spacing: -2px;
            margin: 18px 0;
        }

        .story-copy p {
            color: #a5b1bf;
            line-height: 1.8;
            max-width: 430px;
        }

        .story-foot {
            color: #758394;
            font-size: 12px;
        }

        .login-panel {
            display: grid;
            place-items: center;
            padding: 30px;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
        }

        .login-symbol {
            width: 52px;
            height: 52px;
            display: grid;
            place-items: center;
            border-radius: 16px;
            background: #48dfc5;
            color: #071411;
            font-size: 25px;
            font-weight: 900;
            margin-bottom: 27px;
        }

        .login-card h2 {
            font: 800 30px Manrope, sans-serif;
            margin: 0 0 8px;
        }

        .login-card .intro {
            color: #9aa8b8;
            line-height: 1.6;
            margin: 0 0 28px;
        }

        .login-card .field {
            margin-bottom: 17px;
        }

        .login-card .field input {
            min-height: 48px;
        }

        .login-submit {
            width: 100%;
            min-height: 48px;
            border: 0;
            border-radius: 11px;
            background: #48dfc5;
            color: #071411;
            font-weight: 800;
            cursor: pointer;
            margin-top: 5px;
        }

        .login-submit:hover {
            filter: brightness(1.08);
        }

        .login-back {
            display: block;
            text-align: center;
            color: #9aa8b8;
            font-size: 12px;
            margin-top: 20px;
        }

        .login-back:hover {
            color: #48dfc5;
        }

        .login-error {
            padding: 12px 14px;
            margin-bottom: 18px;
            border-radius: 10px;
            border: 1px solid rgba(255, 102, 119, 0.25);
            background: rgba(255, 102, 119, 0.08);
            color: #ffb4bd;
            font-size: 13px;
        }

        @media (max-width: 800px) {
            .admin-login {
                grid-template-columns: 1fr;
            }

            .login-story {
                display: none;
            }

            .login-panel {
                min-height: 100vh;
                padding: 24px;
            }
        }
    </style>

    <div class="admin-login">
        <section class="login-story">
            <a href="{{ route('home') }}" class="login-brand">
                Sewa<span>Kendaraan.</span>
            </a>

            <div class="story-copy">
                <div class="story-kicker">Admin Control Center</div>
                <h1>Kelola perjalanan.<br>Dalam satu tempat.</h1>
                <p>
                    Pusat kendali operasional untuk mengelola armada, supir, dan pemesanan
                    dengan lebih teratur.
                </p>
            </div>

            <div class="story-foot">
                © {{ date('Y') }} SewaKendaraan · Administrator Area
            </div>
        </section>

        <section class="login-panel">
            <div class="login-card">
                <div class="login-symbol">S</div>
                <h2>Selamat datang</h2>
                <p class="intro">
                    Masuk menggunakan akun administrator untuk melanjutkan.
                </p>

                @if ($errors->any())
                    <div class="login-error">{{ $errors->first() }}</div>
                @endif

                @if (session('success'))
                    <div
                        class="login-error"
                        style="border-color: rgba(72, 223, 197, 0.25); color: #aaf5e7"
                    >
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.store') }}">
                    @csrf

                    <div class="field">
                        <label for="email">Email Admin</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            placeholder="admin@domain.com"
                            autocomplete="username"
                            required
                            autofocus
                        >
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            required
                        >
                    </div>

                    <button class="login-submit" type="submit">
                        Masuk ke Dashboard
                        <span aria-hidden="true">→</span>
                    </button>
                </form>

                <a class="login-back" href="{{ route('home') }}">
                    ← Kembali ke website utama
                </a>
            </div>
        </section>
    </div>
@endsection
