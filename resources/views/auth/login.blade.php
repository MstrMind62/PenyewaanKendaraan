@extends('layouts.app')

@section('title', 'Login Customer')

@section('content')
<style>
    /* Reset & Fullscreen Container */
    .login-fullscreen {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        width: 100vw; height: 100vh;
        display: flex;
        z-index: 1000;
        font-family: 'DM Sans', "Segoe UI", Arial, sans-serif;
        background: #0d1014; /* Warna dasar gelap */
        color: #ffffff;
    }

    /* ===============================
       BAGIAN KIRI (Teks & Visual)
       =============================== */
    .login-left {
        flex: 1;
        position: relative;
        padding: 60px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: radial-gradient(circle at 30% 50%, #1e242c 0%, #11151a 80%);
        border-right: 1px solid rgba(255, 255, 255, 0.05);
    }

    .brand-logo {
        position: absolute;
        top: 50px;
        left: 60px;
        font-size: 20px;
        font-weight: 700;
        color: #ffffff;
        text-decoration: none;
        letter-spacing: -0.5px;
    }

    .brand-logo span {
        color: #95dfc3; /* Warna teal/mint sesuai gambar */
    }

    .left-content {
        max-width: 500px;
    }

    .control-tag {
        display: inline-block;
        color: #95dfc3;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-bottom: 20px;
    }

    .left-content h1 {
        font-size: 52px;
        font-weight: 700;
        line-height: 1.1;
        letter-spacing: -1.5px;
        margin: 0 0 20px 0;
        color: #ffffff;
    }

    .left-content p {
        font-size: 14px;
        line-height: 1.7;
        color: #8b949e;
        margin: 0;
        max-width: 400px;
    }

    .left-footer {
        position: absolute;
        bottom: 50px;
        left: 60px;
        font-size: 12px;
        color: #586069;
    }

    /* ===============================
       BAGIAN KANAN (Form Login)
       =============================== */
    .login-right {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #0d1014;
        padding: 40px;
    }

    .form-wrapper {
        width: 100%;
        max-width: 380px;
    }

    .form-icon {
        width: 54px;
        height: 54px;
        background: #95dfc3;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0d1014;
        font-size: 24px;
        font-weight: 800;
        margin-bottom: 35px;
    }

    .form-wrapper h2 {
        font-size: 26px;
        font-weight: 700;
        margin: 0 0 10px 0;
        color: #ffffff;
        letter-spacing: -0.5px;
    }

    .form-wrapper p {
        font-size: 13px;
        color: #8b949e;
        margin: 0 0 35px 0;
    }

    /* Alert / Notifikasi */
    .login-alert {
        padding: 12px 15px;
        border-radius: 8px;
        font-size: 12px;
        margin-bottom: 25px;
    }
    .login-alert.error {
        background: rgba(220, 53, 69, 0.1);
        border: 1px solid rgba(220, 53, 69, 0.2);
        color: #ffc1c1;
    }
    .login-alert.success {
        background: rgba(149, 223, 195, 0.1);
        border: 1px solid rgba(149, 223, 195, 0.2);
        color: #95dfc3;
    }

    /* Input Fields */
    .input-group {
        margin-bottom: 22px;
    }

    .input-group label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #c9d1d9;
        margin-bottom: 8px;
    }

    .input-wrap {
        position: relative;
    }

    .input-field {
        width: 100%;
        height: 48px;
        padding: 0 16px;
        background: #121519;
        border: 1px solid #242b33;
        border-radius: 8px;
        color: #ffffff;
        font-family: inherit;
        font-size: 13px;
        outline: none;
        transition: 0.2s;
    }

    .input-field:focus {
        border-color: #95dfc3;
        background: #161a20;
    }

    .input-field::placeholder {
        color: #4b535d;
    }

    .toggle-pw {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #8b949e;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
    }

    .toggle-pw:hover {
        color: #95dfc3;
    }

    /* Tombol Submit */
    .btn-submit {
        width: 100%;
        height: 48px;
        background: #95dfc3;
        color: #0d1014;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s;
        margin-top: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-submit:hover {
        filter: brightness(1.1);
        transform: translateY(-1px);
    }

    .back-link {
        display: block;
        text-align: center;
        margin-top: 25px;
        color: #8b949e;
        font-size: 12px;
        text-decoration: none;
        transition: 0.2s;
    }

    .back-link:hover {
        color: #ffffff;
    }

    /* Responsive untuk Layar Kecil (Mobile) */
    @media (max-width: 900px) {
        .login-fullscreen {
            flex-direction: column;
            overflow-y: auto;
        }
        .login-left {
            flex: none;
            padding: 40px 30px;
            min-height: 45vh;
            border-right: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        .brand-logo {
            top: 30px; left: 30px;
        }
        .left-footer {
            display: none; /* Sembunyikan footer di mobile agar tidak sempit */
        }
        .left-content h1 {
            font-size: 36px;
        }
        .login-right {
            flex: none;
            padding: 40px 30px;
            min-height: 55vh;
        }
    }
</style>

<div class="login-fullscreen">
    
    {{-- BAGIAN KIRI: Visual & Teks --}}
    <div class="login-left">
        <a href="{{ route('home') }}" class="brand-logo">
            SewaKendaraan<span>.</span>
        </a>

        <div class="left-content">
            <span class="control-tag">Customer Portal</span>
            <h1>Sewa kendaraan.<br>Dalam satu tempat.</h1>
            <p>Pusat layanan untuk memilih armada, menentukan durasi, dan memantau status pesanan Anda dengan lebih teratur.</p>
        </div>

        <div class="left-footer">
            © {{ date('Y') }} SewaKendaraan · Customer Area
        </div>
    </div>

    {{-- BAGIAN KANAN: Form --}}
    <div class="login-right">
        <div class="form-wrapper">
            
            <div class="form-icon">S</div>

            <h2>Selamat datang</h2>
            <p>Masuk menggunakan akun customer untuk melanjutkan.</p>

            {{-- Menampilkan Error --}}
            @if ($errors->any())
                <div class="login-alert error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            {{-- Menampilkan Sukses --}}
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
                            class="input-field" 
                            placeholder="Masukkan password" 
                            required
                        >
                        <button type="button" class="toggle-pw" id="togglePassword">Lihat</button>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    Masuk ke Dashboard &rarr;
                </button>
            </form>

            <a href="{{ route('home') }}" class="back-link">
                &larr; Kembali ke website utama
            </a>
            
            <a href="{{ route('register') }}" class="back-link" style="margin-top: 10px; color: #95dfc3;">
                Belum punya akun? Daftar
            </a>

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
                toggle.textContent = isHidden ? 'Sembunyikan' : 'Lihat';
            });
        }
    });
</script>
@endsection