@extends('layouts.app')

@section('title', 'Profil Saya - SewaKendaraan')

@section('content')
<style>
    .profile-wrap {
        max-width: 920px;
        margin: 0 auto;
    }

    .profile-heading {
        margin-bottom: 28px;
    }

    .profile-heading h1 {
        margin: 12px 0 7px;
        font-size: 30px;
        font-weight: 800;
        color: var(--app-text);
    }

    .profile-heading p {
        margin: 0;
        color: var(--app-muted);
        font-size: 14px;
    }

    .profile-card {
        background: #ffffff;
        border: 1px solid #eeeeee;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,.035);
    }

    .profile-top {
        display: flex;
        align-items: center;
        gap: 17px;
    }

    .profile-avatar {
        width: 68px;
        height: 68px;
        flex: 0 0 68px;
        display: grid;
        place-items: center;
        border-radius: 50%;
        background: #fff0e6;
        color: #f07828;
        font-size: 27px;
        font-weight: 800;
    }

    .profile-top h2 {
        margin: 0 0 5px;
        font-size: 21px;
        color: #252525;
    }

    .profile-top p {
        margin: 0;
        color: #777777;
        font-size: 14px;
    }

    .profile-status {
        display: inline-block;
        margin-top: 9px;
        padding: 5px 11px;
        border-radius: 20px;
        background: #fff4df;
        color: #b7791f;
        font-size: 11px;
        font-weight: 700;
    }

    .profile-status.verified {
        background: #e7f8ee;
        color: #218653;
    }

    .profile-meta {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 13px;
        margin-top: 23px;
        padding-top: 20px;
        border-top: 1px solid #eeeeee;
    }

    .profile-meta div {
        padding: 14px;
        border-radius: 10px;
        background: #fafafa;
    }

    .profile-meta small {
        display: block;
        color: #888888;
        font-size: 12px;
        margin-bottom: 6px;
    }

    .profile-meta strong {
        color: #292929;
        font-size: 14px;
        overflow-wrap: anywhere;
    }

    .profile-card h2.section-title {
        margin: 0 0 7px;
        color: #252525;
        font-size: 19px;
        font-weight: 750;
    }

    .profile-description {
        margin: 0 0 22px;
        color: #888888;
        font-size: 13px;
        line-height: 1.6;
    }

    .profile-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0 18px;
    }

    .profile-wrap .field {
        margin-bottom: 17px;
    }

    .profile-wrap .field label {
        display: block;
        margin-bottom: 8px;
        color: #444444;
        font-size: 13px;
        font-weight: 650;
    }

    .profile-wrap .field input {
        width: 100%;
        min-height: 44px;
        padding: 11px 13px;
        border: 1px solid #dddddd;
        border-radius: 9px;
        background: #ffffff;
        color: #292929;
        font-size: 14px;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }

    .profile-wrap .field input:focus {
        border-color: #f07828;
        box-shadow: 0 0 0 3px rgba(240,120,40,.12);
    }

    .profile-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 5px;
    }

    .profile-actions button {
        border: none;
        border-radius: 9px;
        padding: 12px 19px;
        background: #f07828;
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: background .2s, transform .2s;
    }

    .profile-actions button:hover {
        background: #dc6418;
        transform: translateY(-1px);
    }

    .profile-alert {
        padding: 13px 16px;
        border-radius: 10px;
        margin-bottom: 17px;
        font-size: 13px;
        line-height: 1.5;
    }

    .profile-alert.success {
        background: #eaf8ef;
        border: 1px solid #c9ecd5;
        color: #218653;
    }

    .profile-alert.error {
        background: #fff0f0;
        border: 1px solid #f4cccc;
        color: #c03939;
    }

    .profile-error {
        color: #d64040;
        font-size: 12px;
        margin-top: 6px;
    }

    .profile-note {
        margin: 14px 0 0;
        color: #999999;
        font-size: 12px;
        line-height: 1.6;
    }

    .profile-security-icon {
        display: inline-grid;
        place-items: center;
        width: 35px;
        height: 35px;
        margin-right: 8px;
        border-radius: 9px;
        background: #fff0e6;
        color: #f07828;
        font-size: 17px;
        vertical-align: middle;
    }

    @media(max-width: 650px) {
        .profile-grid,
        .profile-meta {
            grid-template-columns: 1fr;
        }

        .profile-card {
            padding: 19px;
        }

        .profile-heading h1 {
            font-size: 25px;
        }

        .profile-actions button {
            width: 100%;
        }
    }
</style>

<div class="profile-wrap">

    <div class="profile-heading">
        <span class="tag">AKUN CUSTOMER</span>
        <h1>Profil Saya</h1>
        <p>Kelola informasi pribadi dan keamanan akun penyewaan kendaraan kamu.</p>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="profile-alert success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('success_password'))
        <div class="profile-alert success">
            {{ session('success_password') }}
        </div>
    @endif

    @if($errors->any() && !$errors->getBag('password')->any())
        <div class="profile-alert error">
            Ada data yang perlu diperiksa kembali. Silakan lihat keterangan pada formulir.
        </div>
    @endif

    @if($errors->getBag('password')->any())
        <div class="profile-alert error">
            Password belum berhasil diperbarui. Periksa kembali isian keamanan akun.
        </div>
    @endif

    {{-- Informasi Akun --}}
    <section class="profile-card">

        <div class="profile-top">
            <div class="profile-avatar">
                {{ strtoupper(substr($customer->nama ?? 'C', 0, 1)) }}
            </div>

            <div>
                <h2>{{ $customer->nama }}</h2>
                <p>{{ $customer->email }}</p>

                <span class="profile-status {{ strtolower($customer->status_verifikasi ?? '') === 'terverifikasi' ? 'verified' : '' }}">
                    {{ ucfirst($customer->status_verifikasi ?? 'Belum') }} Verifikasi
                </span>
            </div>
        </div>

        <div class="profile-meta">
            <div>
                <small>ID Customer</small>
                <strong>#{{ $customer->id_customer }}</strong>
            </div>

            <div>
                <small>Tanggal Bergabung</small>
                <strong>
                    {{ $customer->created_at ? $customer->created_at->format('d M Y') : '-' }}
                </strong>
            </div>
        </div>

    </section>

    {{-- Informasi Pribadi --}}
    <section class="profile-card">

        <h2 class="section-title">Informasi Pribadi</h2>

        <p class="profile-description">
            Pastikan informasi kontak kamu selalu benar dan aktif.
        </p>

        <form method="POST" action="{{ route('customer.profile.update') }}">
            @csrf
            @method('PUT')

            <div class="profile-grid">

                <div class="field">
                    <label for="nama">Nama Lengkap</label>
                    <input
                        id="nama"
                        name="nama"
                        type="text"
                        value="{{ old('nama', $customer->nama) }}"
                        maxlength="120"
                        required
                    >
                    @error('nama')
                        <div class="profile-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="email">Alamat Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email', $customer->email) }}"
                        maxlength="150"
                        required
                    >
                    @error('email')
                        <div class="profile-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="no_hp">Nomor HP</label>
                    <input
                        id="no_hp"
                        name="no_hp"
                        type="tel"
                        value="{{ old('no_hp', $customer->no_hp) }}"
                        maxlength="25"
                        required
                    >
                    @error('no_hp')
                        <div class="profile-error">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="profile-actions">
                <button type="submit">Simpan Perubahan</button>
            </div>

        </form>

        <p class="profile-note">
            Email dapat diubah selama belum digunakan oleh akun lain.
            Status verifikasi hanya dapat diperbarui oleh admin.
        </p>

    </section>

    {{-- Keamanan Akun --}}
    <section class="profile-card">

        <h2 class="section-title">
            <span class="profile-security-icon">🔒</span>
            Keamanan Akun
        </h2>

        <p class="profile-description">
            Gunakan password yang kuat dan jangan membagikannya kepada orang lain.
        </p>

        <form method="POST" action="{{ route('customer.password.update') }}">
            @csrf
            @method('PUT')

            <div class="field">
                <label for="password_lama">Password Saat Ini</label>
                <input
                    id="password_lama"
                    name="password_lama"
                    type="password"
                    autocomplete="current-password"
                    required
                >
                @error('password_lama', 'password')
                    <div class="profile-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="profile-grid">

                <div class="field">
                    <label for="password_baru">Password Baru</label>
                    <input
                        id="password_baru"
                        name="password_baru"
                        type="password"
                        minlength="8"
                        autocomplete="new-password"
                        required
                    >
                    @error('password_baru', 'password')
                        <div class="profile-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="password_baru_confirmation">Konfirmasi Password Baru</label>
                    <input
                        id="password_baru_confirmation"
                        name="password_baru_confirmation"
                        type="password"
                        minlength="8"
                        autocomplete="new-password"
                        required
                    >
                </div>

            </div>

            <div class="profile-actions">
                <button type="submit">Perbarui Password</button>
            </div>

        </form>

    </section>

</div>
@endsection
