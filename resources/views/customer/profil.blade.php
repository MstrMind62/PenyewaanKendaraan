@extends('layouts.app')

@section('title', 'Profil Saya - DriveEase')

@push('styles')
<style>
    /* ==============================
       PROFILE PAGE – Selaras dengan Home
    ============================== */

    .profile-page { width: 100%; }

    /* Latar halaman: cahaya oranye & pink lembut */
    .profile-page::before {
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

    /* ---------- HEADING ---------- */

    .profile-heading {
        margin-bottom: 28px;
    }

    .profile-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        border-radius: 30px;
        background: linear-gradient(135deg, #FFF0DF, #FFD3E0);
        color: #D97706;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.4px;
    }

    .profile-heading h1 {
        margin: 12px 0 7px;
        color: #202A35;
        font-size: 27px;
        font-weight: 800;
        letter-spacing: -0.7px;
    }

    .profile-heading p {
        margin: 0;
        color: #6B7280;
        font-size: 14px;
    }

    /* ---------- ALERTS ---------- */

    .profile-alert {
        padding: 14px 18px;
        border-radius: 14px;
        margin-bottom: 22px;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .profile-alert.success {
        background: linear-gradient(135deg, #ECFDF5, #F0FFF4);
        color: #166534;
        border: 1px solid #BBF7D0;
    }

    .profile-alert.error {
        background: linear-gradient(135deg, #FEF2F2, #FFEEF3);
        color: #991B1B;
        border: 1px solid #FECACA;
    }

    /* ---------- WORKSPACE LAYOUT ---------- */

    .profile-layout {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 22px;
        align-items: start;
    }

    /* ---------- SIDEBAR ---------- */

    .profile-sidebar {
        background: white;
        border: 1px solid #E5E7EB;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 6px 22px rgba(32,42,53,0.05);
    }

    .profile-identity {
        padding: 26px 22px 22px;
        text-align: center;
        background:
            radial-gradient(240px 160px at 100% 0%, rgba(255,143,171,0.18), transparent 70%),
            linear-gradient(160deg, #FFF8F4 0%, #FFE6EE 100%);
        border-bottom: 1px solid #F3E8E2;
    }

    .profile-avatar {
        width: 76px;
        height: 76px;
        margin: 0 auto 14px;
        display: grid;
        place-items: center;
        border-radius: 50%;
        background: linear-gradient(135deg, #F7A04A 0%, #F5817A 55%, #EE6A93 100%);
        color: white;
        font-size: 30px;
        font-weight: 800;
        box-shadow: 0 8px 20px rgba(238,106,147,0.28);
    }

    .profile-identity h2 {
        margin: 0 0 4px;
        color: #202A35;
        font-size: 18px;
        font-weight: 750;
    }

    .profile-identity p {
        margin: 0 0 12px;
        color: #6B7280;
        font-size: 13px;
        overflow-wrap: anywhere;
    }

    .profile-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: 20px;
        background: white;
        color: #D97706;
        font-size: 11px;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(32,42,53,0.06);
    }

    .profile-status.verified {
        background: #ECFDF5;
        color: #166534;
    }

    .profile-status .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    /* Info ringkas di sidebar */
    .profile-meta-list {
        padding: 16px 20px;
        display: grid;
        gap: 10px;
        border-bottom: 1px solid #F0F0F0;
    }

    .profile-meta-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        font-size: 12px;
    }

    .profile-meta-item span { color: #6B7280; }
    .profile-meta-item strong { color: #202A35; font-weight: 700; text-align: right; }

    /* Menu tab navigasi profil (gaya .about-tabs di home) */
    .profile-tabs {
        display: flex;
        flex-direction: column;
        padding: 12px;
        gap: 6px;
        background: linear-gradient(180deg, #F5F6F8, #FFEEF3);
    }

    .profile-tab {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        padding: 12px 14px;
        border: 0;
        border-radius: 10px;
        background: transparent;
        color: #6B7280;
        font: inherit;
        font-size: 13px;
        font-weight: 700;
        text-align: left;
        cursor: pointer;
        transition: background .2s, color .2s, transform .15s, box-shadow .2s;
    }

    .profile-tab:hover { color: #D97706; }
    .profile-tab:active { transform: scale(.97); }
    .profile-tab.active {
        background: white;
        color: #F28C28;
        box-shadow: 0 3px 10px rgba(32,42,53,0.07);
    }

    /* ---------- MAIN EDIT PANEL ---------- */

    .profile-panel-card {
        background: white;
        border: 1px solid #E5E7EB;
        border-radius: 16px;
        padding: 28px 32px;
        box-shadow: 0 6px 22px rgba(32,42,53,0.05);
        transition: border-color .3s;
    }

    .profile-panel-card:hover { border-color: #F6C28E; }

    .profile-panel { display: none; }
    .profile-panel.active {
        display: block;
        animation: panel-in .35s ease both;
    }

    @keyframes panel-in {
        from { opacity: 0; transform: translateX(12px); }
        to { opacity: 1; transform: none; }
    }

    .panel-header {
        display: flex;
        align-items: center;
        gap: 14px;
        padding-bottom: 20px;
        margin-bottom: 24px;
        border-bottom: 1px solid #F0F0F0;
    }

    .panel-icon {
        width: 44px;
        height: 44px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: linear-gradient(135deg, #FFF0DF, #FFD6E2);
        color: #F28C28;
        font-size: 20px;
    }

    .panel-header h2 {
        margin: 0 0 4px;
        color: #202A35;
        font-size: 19px;
        font-weight: 750;
        letter-spacing: -0.3px;
    }

    .panel-header p {
        margin: 0;
        color: #6B7280;
        font-size: 13px;
    }

    /* ---------- FORM FIELDS ---------- */

    .pf-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .pf-field { margin-bottom: 18px; }
    .pf-grid .pf-field { margin-bottom: 0; }
    .pf-field.full { grid-column: 1 / -1; }

    .pf-field label {
        display: block;
        margin-bottom: 8px;
        color: #202A35;
        font-size: 13px;
        font-weight: 700;
    }

    .input-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .pf-field input {
        width: 100%;
        min-height: 46px;
        padding: 11px 14px;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        background: white;
        color: #202A35;
        font: inherit;
        font-size: 14px;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }

    .pf-field input.has-toggle { padding-right: 44px; }

    .pf-field input:focus {
        border-color: #F28C28;
        box-shadow: 0 0 0 3px rgba(242,140,40,0.12);
    }

    .toggle-pw {
        position: absolute;
        right: 10px;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 0;
        border-radius: 7px;
        background: transparent;
        color: #9CA3AF;
        font-size: 15px;
        cursor: pointer;
        transition: color .2s, background .2s;
    }

    .toggle-pw:hover {
        color: #F28C28;
        background: #FFF0DF;
    }

    .pf-error {
        color: #DC3545;
        font-size: 12px;
        font-weight: 600;
        margin-top: 6px;
    }

    .pf-note {
        margin: 20px 0 0;
        padding: 13px 16px;
        border-radius: 12px;
        background: linear-gradient(135deg, #FAFAFA, #FFF8F5);
        border: 1px solid #F0F0F0;
        color: #6B7280;
        font-size: 12px;
        line-height: 1.6;
    }

    /* ---------- SUBMIT BUTTON ---------- */

    .pf-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 24px;
    }

    .pf-submit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 13px 26px;
        border: none;
        border-radius: 10px;
        background: linear-gradient(135deg, #F7A04A 0%, #F5817A 55%, #EE6A93 100%);
        background-size: 200% 200%;
        background-position: 0% 50%;
        color: white;
        font: inherit;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(238,106,147,0.28);
        transition: background-position .5s ease, transform .15s, box-shadow .2s;
        position: relative;
        overflow: hidden;
    }

    .pf-submit:hover {
        background-position: 100% 50%;
        box-shadow: 0 12px 26px rgba(238,106,147,0.38);
        transform: translateY(-2px);
    }

    .pf-submit:active { transform: scale(.96); }

    /* ---------- RIPPLE ---------- */

    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.45);
        transform: scale(0);
        pointer-events: none;
        animation: ripple .6s ease-out forwards;
    }

    @keyframes ripple { to { transform: scale(4); opacity: 0; } }

    /* ---------- SCROLL REVEAL ---------- */

    .js .pf-reveal { opacity: 0; transform: translateY(20px); transition: opacity .6s ease, transform .6s ease; }
    .js .pf-reveal.visible { opacity: 1; transform: none; }

    /* ---------- RESPONSIVE ---------- */

    @media(max-width: 850px) {
        .profile-layout { grid-template-columns: 1fr; }
        .profile-tabs { flex-direction: row; overflow-x: auto; }
        .profile-tab { white-space: nowrap; justify-content: center; }
    }

    @media(max-width: 600px) {
        .profile-heading h1 { font-size: 22px; }
        .profile-panel-card { padding: 22px 18px; }
        .pf-grid { grid-template-columns: 1fr; }
        .pf-actions { justify-content: stretch; }
        .pf-submit { width: 100%; }
    }

    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after { animation: none !important; transition: none !important; }
        .js .pf-reveal { opacity: 1; transform: none; }
    }
</style>
@endpush

@section('content')

@php
    $activeTab = ($errors->getBag('password')->any() || session('success_password')) ? 'keamanan' : 'pribadi';
@endphp

<div class="profile-page">

    {{-- ========== HEADING ========== --}}

    <div class="profile-heading pf-reveal">
        <span class="profile-badge">✦ AKUN CUSTOMER</span>
        <h1>Pengaturan Profil</h1>
        <p>Kelola informasi pribadi dan keamanan akun penyewaan kendaraan kamu.</p>
    </div>

    {{-- ========== ALERTS ========== --}}

    @if(session('success'))
        <div class="profile-alert success pf-reveal">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if(session('success_password'))
        <div class="profile-alert success pf-reveal">
            ✅ {{ session('success_password') }}
        </div>
    @endif

    @if($errors->any() && !$errors->getBag('password')->any())
        <div class="profile-alert error pf-reveal">
            ⚠️ Ada data yang perlu diperiksa kembali. Silakan lihat keterangan pada formulir.
        </div>
    @endif

    @if($errors->getBag('password')->any())
        <div class="profile-alert error pf-reveal">
            ⚠️ Password belum berhasil diperbarui. Periksa kembali isian keamanan akun.
        </div>
    @endif

    {{-- ========== WORKSPACE ========== --}}

    <div class="profile-layout pf-reveal">

        {{-- SIDEBAR --}}
        <aside class="profile-sidebar">

            <div class="profile-identity">
                <div class="profile-avatar">
                    {{ strtoupper(substr($customer->nama ?? 'C', 0, 1)) }}
                </div>
                <h2>{{ $customer->nama }}</h2>
                <p>{{ $customer->email }}</p>

                <span class="profile-status {{ strtolower($customer->status_verifikasi ?? '') === 'terverifikasi' ? 'verified' : '' }}">
                    <span class="status-dot"></span>
                    {{ ucfirst($customer->status_verifikasi ?? 'Belum') }} Verifikasi
                </span>
            </div>

            <div class="profile-meta-list">
                <div class="profile-meta-item">
                    <span>ID Customer</span>
                    <strong>#{{ $customer->id_customer }}</strong>
                </div>
                <div class="profile-meta-item">
                    <span>Nomor HP</span>
                    <strong>{{ $customer->no_hp ?: '-' }}</strong>
                </div>
                <div class="profile-meta-item">
                    <span>Bergabung</span>
                    <strong>{{ $customer->created_at ? $customer->created_at->format('d M Y') : '-' }}</strong>
                </div>
            </div>

            <div class="profile-tabs" role="tablist">
                <button
                    type="button"
                    class="profile-tab {{ $activeTab === 'pribadi' ? 'active' : '' }}"
                    role="tab"
                    data-tab="pribadi"
                >
                    👤 Edit Informasi Pribadi
                </button>
                <button
                    type="button"
                    class="profile-tab {{ $activeTab === 'keamanan' ? 'active' : '' }}"
                    role="tab"
                    data-tab="keamanan"
                >
                    🔒 Ubah Password
                </button>
            </div>

        </aside>

        {{-- MAIN PANEL --}}
        <div class="profile-panel-card">

            {{-- TAB 1: INFORMASI PRIBADI --}}
            <section class="profile-panel {{ $activeTab === 'pribadi' ? 'active' : '' }}" id="panel-pribadi" role="tabpanel">

                <div class="panel-header">
                    <div class="panel-icon">👤</div>
                    <div>
                        <h2>Informasi Pribadi</h2>
                        <p>Perbarui nama, email, dan nomor HP aktif untuk keperluan pemesanan.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('customer.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="pf-grid">

                        <div class="pf-field full">
                            <label for="nama">Nama Lengkap</label>
                            <input
                                id="nama"
                                name="nama"
                                type="text"
                                value="{{ old('nama', $customer->nama) }}"
                                maxlength="120"
                                placeholder="Masukkan nama lengkap"
                                required
                            >
                            @error('nama')
                                <div class="pf-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="pf-field">
                            <label for="email">Alamat Email</label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email', $customer->email) }}"
                                maxlength="150"
                                placeholder="contoh@email.com"
                                required
                            >
                            @error('email')
                                <div class="pf-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="pf-field">
                            <label for="no_hp">Nomor HP / WhatsApp</label>
                            <input
                                id="no_hp"
                                name="no_hp"
                                type="tel"
                                value="{{ old('no_hp', $customer->no_hp) }}"
                                maxlength="25"
                                placeholder="08xxxxxxxxxx"
                                required
                            >
                            @error('no_hp')
                                <div class="pf-error">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <p class="pf-note">
                        ℹ️ Email dapat diubah selama belum digunakan oleh akun lain. Status verifikasi akun hanya dapat diperbarui oleh admin.
                    </p>

                    <div class="pf-actions">
                        <button type="submit" class="pf-submit">
                            Simpan Perubahan &nbsp; →
                        </button>
                    </div>

                </form>

            </section>

            {{-- TAB 2: KEAMANAN AKUN --}}
            <section class="profile-panel {{ $activeTab === 'keamanan' ? 'active' : '' }}" id="panel-keamanan" role="tabpanel">

                <div class="panel-header">
                    <div class="panel-icon">🔒</div>
                    <div>
                        <h2>Keamanan Akun</h2>
                        <p>Gunakan password minimal 8 karakter dan jangan bagikan kepada siapapun.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('customer.password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="pf-field">
                        <label for="password_lama">Password Saat Ini</label>
                        <div class="input-wrap">
                            <input
                                id="password_lama"
                                name="password_lama"
                                type="password"
                                class="has-toggle"
                                autocomplete="current-password"
                                placeholder="Masukkan password saat ini"
                                required
                            >
                            <button type="button" class="toggle-pw" data-target="password_lama" aria-label="Tampilkan password">👁️</button>
                        </div>
                        @error('password_lama', 'password')
                            <div class="pf-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="pf-grid">

                        <div class="pf-field">
                            <label for="password_baru">Password Baru</label>
                            <div class="input-wrap">
                                <input
                                    id="password_baru"
                                    name="password_baru"
                                    type="password"
                                    class="has-toggle"
                                    minlength="8"
                                    autocomplete="new-password"
                                    placeholder="Minimal 8 karakter"
                                    required
                                >
                                <button type="button" class="toggle-pw" data-target="password_baru" aria-label="Tampilkan password">👁️</button>
                            </div>
                            @error('password_baru', 'password')
                                <div class="pf-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="pf-field">
                            <label for="password_baru_confirmation">Konfirmasi Password Baru</label>
                            <div class="input-wrap">
                                <input
                                    id="password_baru_confirmation"
                                    name="password_baru_confirmation"
                                    type="password"
                                    class="has-toggle"
                                    minlength="8"
                                    autocomplete="new-password"
                                    placeholder="Ulangi password baru"
                                    required
                                >
                                <button type="button" class="toggle-pw" data-target="password_baru_confirmation" aria-label="Tampilkan password">👁️</button>
                            </div>
                        </div>

                    </div>

                    <div class="pf-actions">
                        <button type="submit" class="pf-submit">
                            Perbarui Password &nbsp; →
                        </button>
                    </div>

                </form>

            </section>

        </div>

    </div>

</div>

@endsection


@push('scripts')
<script>
(function () {
    document.documentElement.classList.add('js');
    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* Tab switching */
    document.querySelectorAll('.profile-tab').forEach(function (tab) {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.profile-tab').forEach(function (t) { t.classList.remove('active'); });
            document.querySelectorAll('.profile-panel').forEach(function (p) { p.classList.remove('active'); });
            tab.classList.add('active');
            document.getElementById('panel-' + tab.getAttribute('data-tab')).classList.add('active');
        });
    });

    /* Toggle password visibility */
    document.querySelectorAll('.toggle-pw').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input = document.getElementById(btn.getAttribute('data-target'));
            if (!input) return;
            var isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            btn.textContent = isHidden ? '🙈' : '👁️';
        });
    });

    /* Ripple */
    document.addEventListener('click', function (e) {
        var el = e.target.closest('.pf-submit');
        if (!el || reduce) return;
        var rect = el.getBoundingClientRect();
        var size = Math.max(rect.width, rect.height);
        var r = document.createElement('span');
        r.className = 'ripple';
        r.style.width = r.style.height = size + 'px';
        r.style.left = (e.clientX - rect.left - size / 2) + 'px';
        r.style.top = (e.clientY - rect.top - size / 2) + 'px';
        el.appendChild(r);
        setTimeout(function () { r.remove(); }, 650);
    });

    /* Scroll reveal */
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (!en.isIntersecting) return;
                en.target.classList.add('visible');
                io.unobserve(en.target);
            });
        }, { threshold: 0.08 });
        document.querySelectorAll('.pf-reveal').forEach(function (el) { io.observe(el); });
    } else {
        document.querySelectorAll('.pf-reveal').forEach(function (el) { el.classList.add('visible'); });
    }
})();
</script>
@endpush
