Tampilan halaman *Register* Anda sebelumnya masih menggunakan desain kotak lama. Agar 100% serasi dengan halaman *Login* modern (layar terbelah 50:50, tema gelap pekat, dan aksen *teal*/toska) yang baru saja kita buat, saya telah merombak ulang kodenya.

Semua kolom *input* bawaan Anda (Nama, Email, No HP, Password, dan Konfirmasi) serta logika *error/success* tetap aman dan tidak ada yang dihilangkan.

Silakan *copy* kode di bawah ini dan timpa seluruh isi file **`resources/views/auth/register.blade.php`** Anda:

```blade
@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')
<style>
    /* Reset & Fullscreen Container */
    .register-fullscreen {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        width: 100vw; height: 100vh;
        display: flex;
        z-index: 1000;
        font-family: 'DM Sans', "Segoe UI", Arial, sans-serif;
        background: #0d1014;
        color: #ffffff;
        overflow-y: auto;
    }

    /* ===============================
       BAGIAN KIRI (Teks & Visual)
       =============================== */
    .register-left {
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
        color: #95dfc3;
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
       BAGIAN KANAN (Form Register)
       =============================== */
    .register-right {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #0d1014;
        padding: 40px;
        /* Tambahan agar form panjang bisa di-scroll dengan aman di desktop kecil */
        overflow-y: auto; 
    }

    .form-wrapper {
        width: 100%;
        max-width: 380px;
        margin: auto 0;
        padding: 40px 0;
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
        margin: 0 0 30px 0;
    }

    /* Alert / Notifikasi */
    .register-alert {
        padding: 12px 15px;
        border-radius: 8px;
        font-size: 12px;
        margin-bottom: 25px;
    }
    .register-alert ul {
        margin: 0;
        padding-left: 18px;
    }
    .register-alert.error {
        background: rgba(220, 53, 69, 0.1);
        border: 1px solid rgba(220, 53, 69, 0.2);
        color: #ffc1c1;
    }
    .register-alert.success {
        background: rgba(149, 223, 195, 0.1);
        border: 1px solid rgba(149, 223, 195, 0.2);
        color: #95dfc3;
    }

    /* Input Fields */
    .input-group {
        margin-bottom: 18px;
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
        height: 46px;
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
        margin-top: 15px;
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
        .register-fullscreen {
            display: block; /* Matikan flex agar bisa scroll alami di mobile */
        }
        .register-left {
            padding: 40px 30px;
            min-height: auto;
            border-right: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        .brand-logo {
            position: relative;
            top: 0; left: 0;
            display: inline-block;
            margin-bottom: 30px;
        }
        .left-footer {
            display: none;
        }
        .left-content h1 {
            font-size: 32px;
        }
        .register-right {
            padding: 40px 30px;
            height: auto;
        }
        .form-wrapper {
            padding: 0;
            margin: 0 auto;
        }
    }
</style>

<div class="register-fullscreen">
    
    {{-- BAGIAN KIRI: Visual & Teks --}}
    <div class="register-left">
        <a href="{{ route('home') }}" class="brand-logo">
            SewaKendaraan<span>.</span>
        </a>

        <div class="left-content">
            <span class="control-tag">Customer Portal</span>
            <h1>Mulai perjalanan.<br>Bersama kami.</h1>
            <p>Daftar sekarang dan temukan kendaraan yang sesuai dengan kebutuhan perjalanan Anda. Proses cepat, mudah, dan aman.</p>
        </div>

        <div class="left-footer">
            © {{ date('Y') }} SewaKendaraan · Customer Area
        </div>
    </div>

    {{-- BAGIAN KANAN: Form --}}
    <div class="register-right">
        <div class="form-wrapper">
            
            <div class="form-icon">+</div>

            <h2>Buat akun</h2>
            <p>Lengkapi data berikut untuk mulai menyewa kendaraan.</p>

            {{-- Menampilkan Error --}}
            @if ($errors->any())
                <div class="register-alert error" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Menampilkan Sukses --}}
            @if (session('success'))
                <div class="register-alert success" role="status">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register.store') }}">
                @csrf

                <div class="input-group">
                    <label for="nama">Nama lengkap</label>
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
                            class="input-field" 
                            placeholder="Buat password" 
                            minlength="8"
                            required
                        >
                        <button type="button" class="toggle-pw register-password-toggle" data-target="password">Lihat</button>
                    </div>
                </div>

                <div class="input-group">
                    <label for="password_confirmation">Ulangi password</label>
                    <div class="input-wrap">
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            class="input-field" 
                            placeholder="Masukkan ulang password" 
                            minlength="8"
                            required
                        >
                        <button type="button" class="toggle-pw register-password-toggle" data-target="password_confirmation">Lihat</button>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    Buat akun sekarang &rarr;
                </button>
            </form>

            <a href="{{ route('login') }}" class="back-link">
                Sudah punya akun? <span style="color: #95dfc3; font-weight: 700;">Login sekarang</span>
            </a>
            
            <a href="{{ route('home') }}" class="back-link" style="margin-top: 10px;">
                &larr; Kembali ke website utama
            </a>

        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleButtons = document.querySelectorAll('.register-password-toggle');

        toggleButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const targetId = button.dataset.target;
                const input = document.getElementById(targetId);

                if (!input) return;

                const isHidden = input.type === 'password';
                input.type = isHidden ? 'text' : 'password';
                button.textContent = isHidden ? 'Sembunyikan' : 'Lihat';
            });
        });
    });
</script>
@endsection

```