@extends('layouts.app')

@section('title', 'Akses Ditolak - DriveEase')

@push('styles')
<style>
    .denied-page {
        min-height: calc(100vh - 220px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px 16px;
    }

    .denied-page::before {
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

    .denied-card {
        width: 100%;
        max-width: 520px;
        padding: 42px 36px;
        text-align: center;
        background: white;
        border: 1px solid #E5E7EB;
        border-radius: 22px;
        box-shadow: 0 18px 44px rgba(32,42,53,0.09);
    }

    .denied-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 20px;
        display: grid;
        place-items: center;
        border-radius: 20px;
        background: linear-gradient(135deg, #FEF2F2, #FFDCE6);
        color: #DC3545;
        font-size: 32px;
    }

    .denied-badge {
        display: inline-block;
        padding: 6px 14px;
        margin-bottom: 14px;
        border-radius: 30px;
        background: linear-gradient(135deg, #FFF0DF, #FFD3E0);
        color: #D97706;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.6px;
        text-transform: uppercase;
    }

    .denied-card h1 {
        margin: 0 0 12px;
        color: #202A35;
        font-size: 26px;
        font-weight: 800;
        letter-spacing: -0.6px;
    }

    .denied-card p {
        margin: 0 0 28px;
        color: #6B7280;
        font-size: 14px;
        line-height: 1.7;
    }

    .denied-actions {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 12px;
    }

    .denied-btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 13px 22px;
        border-radius: 10px;
        background: linear-gradient(135deg, #F7A04A 0%, #F5817A 55%, #EE6A93 100%);
        color: white;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 8px 20px rgba(238,106,147,0.28);
        transition: transform .15s, box-shadow .2s;
    }

    .denied-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(238,106,147,0.38);
        color: white;
    }

    .denied-btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 13px 22px;
        border-radius: 10px;
        background: white;
        border: 1px solid #E5E7EB;
        color: #202A35;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: background .2s, border-color .2s;
    }

    .denied-btn-secondary:hover {
        background: #F5F6F8;
        border-color: #D1D5DB;
    }
</style>
@endpush

@section('content')
<div class="denied-page">
    <div class="denied-card">
        <div class="denied-icon">🔒</div>

        <span class="denied-badge">403 · Akses Ditolak</span>

        <h1>Kamu Tidak Memiliki Akses</h1>

        <p>
            @if(request()->is('admin*'))
                Menu admin belum dapat dibuka karena kamu belum melakukan login sebagai Admin.
                Silakan login menggunakan akun Administrator untuk melanjutkan.
            @elseif(request()->is('supir*'))
                Menu supir belum dapat dibuka karena kamu belum melakukan login sebagai Supir.
                Silakan login menggunakan akun Supir untuk melanjutkan.
            @else
                Maaf, kamu tidak memiliki izin untuk membuka halaman ini.
            @endif
        </p>

        <div class="denied-actions">
            @if(request()->is('admin*'))
                <a href="{{ route('admin.login') }}" class="denied-btn-primary">
                    Login sebagai Admin &nbsp; →
                </a>
            @elseif(request()->is('supir*'))
                <a href="{{ route('supir.login') }}" class="denied-btn-primary">
                    Login sebagai Supir &nbsp; →
                </a>
            @endif

            <a href="{{ route('home') }}" class="denied-btn-secondary">
                ← Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
