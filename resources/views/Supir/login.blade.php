@extends('Supir.layout')
@section('title', 'Login Supir')
@section('content')
<div class="login-page">
    <section class="login-visual">
        <a class="brand" href="{{ route('home') }}"><span class="brand-mark">R</span><span><span class="brand-name">RentDrive</span><span class="brand-sub">Move smart. Drive safe.</span></span></a>
        <div class="login-copy"><div class="eyebrow">PORTAL PENGEMUDI</div><h1>Perjalanan yang baik dimulai dari persiapan.</h1><p>Kelola tugas, pantau detail pelanggan, dan perbarui status perjalanan dalam satu ruang kerja yang praktis.</p></div>
        <div class="login-features"><div class="login-feature"><span>▣</span><span>Jadwal tugas</span></div><div class="login-feature"><span>↗</span><span>Status perjalanan</span></div><div class="login-feature"><span>◎</span><span>Info pelanggan</span></div></div>
    </section>
    <section class="login-form-wrap"><div class="login-card">
        <div class="brand"><span class="brand-mark">R</span><span><span class="brand-name">RentDrive</span><span class="brand-sub">Driver portal</span></span></div>
        <div class="eyebrow">SELAMAT DATANG KEMBALI</div><h2>Login Supir</h2><p class="login-intro">Masuk untuk melihat tugas perjalanan kamu.</p>
        @if($errors->any())<div class="alert alert-error">{{ $errors->first() }}</div>@endif
        <form method="POST" action="{{ route('supir.login.store') }}">
            @csrf
            <label class="form-label" for="email">Alamat email</label><input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" autocomplete="username" required autofocus>
            <label class="form-label" for="password">Password</label><input class="form-control" id="password" type="password" name="password" placeholder="Masukkan password" autocomplete="current-password" required>
            <button class="btn btn-primary" type="submit">Masuk ke portal <span>→</span></button>
        </form>
        <a class="back-home" href="{{ route('home') }}">← Kembali ke halaman utama</a><div class="footer-note">Akses khusus supir yang terdaftar oleh admin.</div>
    </div></section>
</div>
@endsection
