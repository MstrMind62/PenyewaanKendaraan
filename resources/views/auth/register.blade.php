@extends('layouts.app')

@section('title', 'Daftar Akun - DriveEase')

@push('styles')
<style>
    /* ==============================
       REGISTER PAGE – Selaras dengan Home & Login
    ============================== */

    .register-page {
        min-height: calc(100vh - 95px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px 0;
    }

    /* Latar halaman: cahaya oranye & pink lembut, sama seperti home */
    .register-page::before {
        content: "";
        position: fixed;
        inset: 0;
        z-index: -1;
        pointer-events: none;
        background:
            radial-gradient(620px 420px at 8% 4%,  rgba(242,140,40,0.13), transparent 70%),
            radial-gradient(560px 460px at 96% 38%, rgba(255,143,171,0.20), transparent 70%),
            radial-gradient(640px 460px at 20% 96%, rgba(255,143,171,0.14), transparent 70%),
            linear-gradient(180deg, #FFFAF8 0%, #F8F7FA 55%, #FFF1F5 100%);
    }

    .register-container {
        width: 100%;
        max-width: 980px;
        min-height: 620px;
        display: grid;
        grid-template-columns: 1.05fr 1fr;
        background: white;
        border: 1px solid #E5E7EB;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 18px 44px rgba(32,42,53,0.09);
        animation: card-in .55s cubic-bezier(.2,.8,.2,1) both;
    }

    @keyframes card-in {
        from { opacity: 0; transform: translateY(18px) scale(.98); }
        to { opacity: 1; transform: none; }
    }

    /* ---------- BAGIAN KIRI (VISUAL) ---------- */

    .register-visual {
        position: relative;
        isolation: isolate;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 52px 46px;
        background:
            radial-gradient(420px 260px at 100% 0%, rgba(255,143,171,0.24), transparent 70%),
            radial-gradient(320px 240px at 0% 100%, rgba(242,140,40,0.16), transparent 70%),
            linear-gradient(160deg, #FFF8F4 0%, #FFE6EE 100%);
        overflow: hidden;
    }

    .register-visual::before {
        content: "";
        position: absolute;
        inset: 0;
        z-index: -1;
        background: url('/images/remie_bg.jpg') center / cover no-repeat;
        opacity: 0.14;
        pointer-events: none;
    }

    .register-brand {
        position: absolute;
        top: 32px;
        left: 40px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: #202A35;
        font-size: 19px;
        font-weight: 800;
        text-decoration: none;
        letter-spacing: -0.5px;
    }

    .register-brand img {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        object-fit: contain;
        background: white;
        padding: 3px;
        box-shadow: 0 3px 10px rgba(32,42,53,0.08);
    }

    .register-brand span {
        background: linear-gradient(100deg, #F28C28, #EE6A93);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .visual-content {
        position: relative;
        z-index: 2;
    }

    .visual-tag {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 18px;
        padding: 7px 14px;
        border-radius: 30px;
        background: linear-gradient(135deg, #FFF0DF, #FFD3E0);
        color: #D97706;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        box-shadow: 0 2px 10px rgba(242,140,40,0.12);
    }

    .visual-tag .spark {
        display: inline-block;
        animation: spin-slow 6s linear infinite;
    }

    @keyframes spin-slow { to { transform: rotate(360deg); } }

    .visual-content h1 {
        margin: 0 0 16px;
        color: #202A35;
        font-size: clamp(28px, 3.2vw, 38px);
        font-weight: 800;
        line-height: 1.18;
        letter-spacing: -1.2px;
    }

    .visual-content h1 span {
        background: linear-gradient(100deg, #F28C28 0%, #F7857F 50%, #EE6A93 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        color: #F28C28;
    }

    .visual-content p {
        max-width: 350px;
        margin: 0;
        color: #6B7280;
        font-size: 14px;
        line-height: 1.75;
    }

    .visual-points {
        list-style: none;
        margin: 22px 0 0;
        padding: 0;
        display: grid;
        gap: 10px;
    }

    .visual-points li {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #202A35;
        font-size: 13px;
        font-weight: 600;
    }

    .visual-points li::before {
        content: "✓";
        flex-shrink: 0;
        width: 22px;
        height: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: white;
        color: #F28C28;
        font-size: 11px;
        font-weight: 800;
        box-shadow: 0 2px 8px rgba(32,42,53,0.07);
    }

    .visual-footer {
        position: absolute;
        bottom: 26px;
        left: 40px;
        color: #6B7280;
        font-size: 11px;
        font-weight: 500;
    }

    /* ---------- BAGIAN KANAN (FORM) ---------- */

    .register-form-section {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 38px 44px;
        background: white;
    }

    .register-form {
        width: 100%;
        max-width: 370px;
    }

    .form-icon {
        width: 48px;
        height: 48px;
        display: grid;
        place-items: center;
        margin-bottom: 18px;
        border-radius: 13px;
        background: linear-gradient(135deg, #FFF0DF, #FFD6E2);
        color: #F28C28;
        font-size: 22px;
    }

    .register-form h2 {
        margin: 0 0 6px;
        color: #202A35;
        font-size: 26px;
        font-weight: 800;
        letter-spacing: -0.6px;
    }

    .form-subtitle {
        margin: 0 0 22px;
        color: #6B7280;
        font-size: 13px;
        line-height: 1.6;
    }

    /* Alert */
    .register-alert {
        padding: 12px 15px;
        border-radius: 12px;
        margin-bottom: 16px;
        font-size: 12px;
        font-weight: 600;
        line-height: 1.5;
    }

    .register-alert ul {
        margin: 0;
        padding-left: 18px;
    }

    .register-alert.error {
        background: linear-gradient(135deg, #FEF2F2, #FFEEF3);
        border: 1px solid #FECACA;
        color: #991B1B;
    }

    .register-alert.success {
        background: linear-gradient(135deg, #ECFDF5, #F0FFF4);
        border: 1px solid #BBF7D0;
        color: #166534;
    }

    /* Input */
    .input-group { margin-bottom: 14px; }

    .input-group label {
        display: block;
        margin-bottom: 6px;
        color: #202A35;
        font-size: 12px;
        font-weight: 700;
    }

    .input-wrap { position: relative; }

    .input-field {
        width: 100%;
        height: 44px;
        padding: 0 14px;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        background: white;
        color: #202A35;
        font-family: inherit;
        font-size: 13px;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }

    .input-field:focus {
        border-color: #F28C28;
        box-shadow: 0 0 0 3px rgba(242,140,40,0.12);
    }

    .input-field::placeholder { color: #9CA3AF; }

    .password-field { padding-right: 92px; }

    .toggle-pw {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        padding: 5px 10px;
        border: none;
        border-radius: 7px;
        background: #FFF0DF;
        color: #D97706;
        font: inherit;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        transition: background .2s, color .2s;
    }

    .toggle-pw:hover {
        background: #F28C28;
        color: white;
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
        border-radius: 10px;
        background: linear-gradient(135deg, #F7A04A 0%, #F5817A 55%, #EE6A93 100%);
        background-size: 200% 200%;
        background-position: 0% 50%;
        color: white;
        font: inherit;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(238,106,147,0.30);
        transition: background-position .5s ease, transform .15s, box-shadow .2s;
        position: relative;
        overflow: hidden;
    }

    .btn-submit:hover {
        background-position: 100% 50%;
        box-shadow: 0 12px 26px rgba(238,106,147,0.40);
        transform: translateY(-2px);
    }

    .btn-submit:active { transform: scale(.97); }

    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.45);
        transform: scale(0);
        pointer-events: none;
        animation: ripple .6s ease-out forwards;
    }

    @keyframes ripple { to { transform: scale(4); opacity: 0; } }

    /* Link */
    .register-links {
        margin-top: 20px;
        padding-top: 16px;
        border-top: 1px solid #F0F0F0;
        text-align: center;
        display: grid;
        gap: 10px;
    }

    .register-links a {
        color: #6B7280;
        font-size: 13px;
        text-decoration: none;
        transition: color .2s;
    }

    .register-links a:hover { color: #F28C28; }

    .register-links a.login-link {
        color: #D97706;
        font-weight: 700;
    }

    .register-links a.login-link:hover { color: #EE6A93; }

    /* Responsive */
    @media(max-width: 820px) {
        .register-page { padding: 10px 0; }

        .register-container {
            grid-template-columns: 1fr;
            min-height: auto;
        }

        .register-visual {
            padding: 72px 28px 34px;
        }

        .register-brand {
            top: 22px;
            left: 28px;
        }

        .visual-footer { display: none; }

        .register-form-section { padding: 34px 24px; }
    }

    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after { animation: none !important; transition: none !important; }
    }
</style>
@endpush

@section('content')

<div class="register-page">

    <div class="register-container">

        {{-- Bagian Visual --}}
        <div class="register-visual">

            <a href="{{ route('home') }}" class="register-brand">
                <img src="{{ asset('images/logo_sk.jpeg') }}" alt="Logo DriveEase">
                <span>DriveEase.</span>
            </a>

            <div class="visual-content">
                <span class="visual-tag">
                    <span class="spark">✦</span> Customer Portal
                </span>

                <h1>Mulai perjalanan.<br><span>Lebih mudah.</span></h1>

                <p>
                    Daftar sekarang dan temukan kendaraan yang sesuai
                    dengan kebutuhan perjalananmu. Proses cepat,
                    mudah, dan nyaman.
                </p>

                <ul class="visual-points">
                    <li>Proses pendaftaran cepat kurang dari 1 menit</li>
                    <li>Pesan kendaraan langsung dari kalender</li>
                    <li>Kelola pesanan & pembayaran dalam satu akun</li>
                </ul>
            </div>

            <div class="visual-footer">
                © {{ date('Y') }} DriveEase · Customer Area
            </div>

        </div>

        {{-- Bagian Form Register --}}
        <div class="register-form-section">

            <div class="register-form">

                <div class="form-icon">✨</div>

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
                        ✅ {{ session('success') }}
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

                    <button type="submit" class="btn-submit" id="registerSubmit">
                        Buat Akun Sekarang &nbsp; →
                    </button>

                </form>

                <div class="register-links">

                    <a href="{{ route('login') }}" class="login-link">
                        Sudah punya akun? Login sekarang →
                    </a>

                    <a href="{{ route('home') }}">
                        ← Kembali ke beranda
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
(function () {
    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    document.querySelectorAll('.register-password-toggle').forEach(function (button) {
        button.addEventListener('click', function () {
            var input = document.getElementById(button.dataset.target);
            if (!input) return;
            var isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            button.textContent = isHidden ? 'Sembunyikan' : 'Lihat';
        });
    });

    var submitBtn = document.getElementById('registerSubmit');
    if (submitBtn && !reduce) {
        submitBtn.addEventListener('click', function (e) {
            var rect = submitBtn.getBoundingClientRect();
            var size = Math.max(rect.width, rect.height);
            var r = document.createElement('span');
            r.className = 'ripple';
            r.style.width = r.style.height = size + 'px';
            r.style.left = (e.clientX - rect.left - size / 2) + 'px';
            r.style.top = (e.clientY - rect.top - size / 2) + 'px';
            submitBtn.appendChild(r);
            setTimeout(function () { r.remove(); }, 650);
        });
    }
})();
</script>
@endpush
