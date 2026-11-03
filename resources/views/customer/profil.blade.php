@extends('layouts.app')

@section('title', 'Profil Saya - SewaKendaraan')

@section('content')
<style>
    .profile-wrap { max-width: 920px; margin: 0 auto; }
    .profile-heading { margin-bottom: 24px; }
    .profile-heading h1 { margin: 0 0 8px; font-size: 30px; }
    .profile-heading p { margin: 0; color: var(--app-muted); }
    .profile-card { background: var(--app-panel); border: 1px solid var(--app-border); border-radius: 17px; padding: 25px; margin-bottom: 20px; }
    .profile-top { display: flex; align-items: center; gap: 16px; margin-bottom: 22px; }
    .profile-avatar { width: 64px; height: 64px; flex: 0 0 64px; border-radius: 50%; display: grid; place-items: center; background: rgba(72,223,197,.13); color: var(--app-accent); font-size: 25px; font-weight: 800; }
    .profile-top h2 { margin: 0 0 5px; font-size: 20px; }
    .profile-top p { margin: 0; color: var(--app-muted); font-size: 14px; }
    .profile-status { display: inline-block; margin-top: 8px; padding: 5px 10px; border-radius: 20px; background: rgba(255,193,7,.12); color: #ffd36a; font-size: 12px; font-weight: 700; }
    .profile-status.verified { background: rgba(72,223,197,.12); color: var(--app-accent); }
    .profile-card h2 { margin: 0 0 7px; font-size: 19px; }
    .profile-description { margin: 0 0 22px; color: var(--app-muted); font-size: 13px; }
    .profile-grid { display: grid; grid-template-columns: repeat(2,minmax(0,1fr)); gap: 0 18px; }
    .profile-alert { padding: 12px 15px; border-radius: 10px; margin-bottom: 16px; font-size: 14px; }
    .profile-alert.success { background: rgba(72,223,197,.12); border: 1px solid rgba(72,223,197,.25); color: #8cf0dc; }
    .profile-alert.error { background: rgba(220,53,69,.12); border: 1px solid rgba(220,53,69,.25); color: #ff9ba5; }
    .profile-error { color: #ff9ba5; font-size: 12px; margin-top: 6px; }
    .profile-meta { display: grid; grid-template-columns: repeat(2,minmax(0,1fr)); gap: 12px; margin-top: 18px; }
    .profile-meta div { padding: 13px; border-radius: 10px; background: rgba(255,255,255,.035); }
    .profile-meta small { display: block; color: var(--app-muted); margin-bottom: 5px; }
    .profile-meta strong { font-size: 14px; overflow-wrap: anywhere; }
    .profile-actions { display: flex; justify-content: flex-end; margin-top: 5px; }
    .profile-note { color: var(--app-muted); font-size: 12px; line-height: 1.6; margin-top: 14px; }
    @media(max-width:650px) { .profile-grid,.profile-meta { grid-template-columns: 1fr; } .profile-card { padding: 19px; } .profile-heading h1 { font-size: 25px; } }
</style>

<div class="profile-wrap">
    <div class="profile-heading">
        <span class="tag">AKUN CUSTOMER</span>
        <h1>Profil Saya</h1>
        <p>Kelola informasi pribadi dan keamanan akun penyewaan kendaraan kamu.</p>
    </div>

    @if(session('success'))
        <div class="profile-alert success">{{ session('success') }}</div>
    @endif
    @if(session('success_password'))
        <div class="profile-alert success">{{ session('success_password') }}</div>
    @endif
    @if($errors->any() && !$errors->getBag('password')->any())
        <div class="profile-alert error">Ada data yang perlu diperiksa kembali. Lihat keterangan pada formulir.</div>
    @endif
    @if($errors->getBag('password')->any())
        <div class="profile-alert error">Password belum berhasil diperbarui. Periksa kembali isian keamanan akun.</div>
    @endif

    <section class="profile-card">
        <div class="profile-top">
            <div class="profile-avatar">{{ strtoupper(substr($customer->nama, 0, 1)) }}</div>
            <div>
                <h2>{{ $customer->nama }}</h2>
                <p>{{ $customer->email }}</p>
                <span class="profile-status {{ strtolower($customer->status_verifikasi) === 'terverifikasi' ? 'verified' : '' }}">
                    {{ ucfirst($customer->status_verifikasi ?? 'belum') }} Verifikasi
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
                <strong>{{ $customer->created_at ? $customer->created_at->format('d M Y') : '-' }}</strong>
            </div>
        </div>
    </section>

    <section class="profile-card">
        <h2>Informasi Pribadi</h2>
        <p class="profile-description">Pastikan informasi kontak kamu selalu benar dan aktif.</p>

        <form method="POST" action="{{ route('customer.profile.update') }}">
            @csrf
            @method('PUT')

            <div class="profile-grid">
                <div class="field">
                    <label for="nama">Nama lengkap</label>
                    <input id="nama" name="nama" type="text" value="{{ old('nama', $customer->nama) }}" maxlength="120" required>
                    @error('nama') <div class="profile-error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="email">Alamat email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $customer->email) }}" maxlength="150" required>
                    @error('email') <div class="profile-error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="no_hp">Nomor HP</label>
                    <input id="no_hp" name="no_hp" type="tel" value="{{ old('no_hp', $customer->no_hp) }}" maxlength="25" required>
                    @error('no_hp') <div class="profile-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="profile-actions">
                <button type="submit">Simpan Perubahan</button>
            </div>
        </form>
        <p class="profile-note">Email dapat diubah selama belum digunakan oleh akun lain. Status verifikasi hanya dapat diperbarui oleh admin.</p>
    </section>

    <section class="profile-card">
        <h2>Keamanan Akun</h2>
        <p class="profile-description">Gunakan password yang kuat dan jangan membagikannya kepada orang lain.</p>

        <form method="POST" action="{{ route('customer.password.update') }}">
            @csrf
            @method('PUT')

            <div class="field">
                <label for="password_lama">Password saat ini</label>
                <input id="password_lama" name="password_lama" type="password" autocomplete="current-password" required>
                @error('password_lama', 'password') <div class="profile-error">{{ $message }}</div> @enderror
            </div>

            <div class="profile-grid">
                <div class="field">
                    <label for="password_baru">Password baru</label>
                    <input id="password_baru" name="password_baru" type="password" minlength="8" autocomplete="new-password" required>
                    @error('password_baru', 'password') <div class="profile-error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="password_baru_confirmation">Konfirmasi password baru</label>
                    <input id="password_baru_confirmation" name="password_baru_confirmation" type="password" minlength="8" autocomplete="new-password" required>
                </div>
            </div>

            <div class="profile-actions">
                <button type="submit">Perbarui Password</button>
            </div>
        </form>
    </section>
</div>
@endsection
