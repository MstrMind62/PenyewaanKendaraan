
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'SewaKendaraan')</title>

   <style>
    :root {
        --app-bg: #080b12;
        --app-panel: #111b27;
        --app-accent: #48dfc5;
        --app-text: #f4f7fb;
        --app-muted: #a2adbb;
        --app-border: rgba(255, 255, 255, 0.09);
    }

    * { box-sizing: border-box; }
    html { min-height: 100%; }
    
    body {
        margin: 0; 
        min-height: 100vh;
        font-family: 'DM Sans', "Segoe UI", Arial, sans-serif;
        color: var(--app-text);
        background: var(--app-bg);
    }

    a { color: var(--app-accent); text-decoration: none; }

    /* HEADER */
    .site-header {
        position: relative; z-index: 10; width: 100%;
        background: var(--app-bg);
        border-bottom: 1px solid var(--app-border);
    }

    .site-header-inner {
        width: 100%; max-width: 1250px; min-height: 82px;
        margin: 0 auto; padding: 15px 25px;
        display: flex; align-items: center; justify-content: space-between; gap: 24px;
    }

    .site-brand {
        color: var(--app-text); font-size: 23px; font-weight: 850; letter-spacing: -.6px;
    }

    .site-nav { display: flex; align-items: center; gap: 24px; }
    .site-nav a { color: var(--app-muted); font-size: 15px; font-weight: 600; transition: .2s; }
    .site-nav a:hover { color: var(--app-accent); }

    .site-nav .site-register {
        padding: 10px 17px; border-radius: 11px;
        background: rgba(72, 223, 197, 0.08); 
        color: var(--app-accent);
        border: 1px solid rgba(72, 223, 197, 0.3);
    }
    
    .site-nav .site-register:hover { 
        background: var(--app-accent); color: #071311; 
    }

    /* KONTEN & FOOTER */
    .site-content {
        width: 100%; max-width: 1250px; margin: 0 auto;
        min-height: calc(100vh - 155px); padding: 30px 25px;
    }

    .site-footer {
        width: 100%; padding: 28px 20px; 
        background: var(--app-bg);
        border-top: 1px solid var(--app-border);
        color: var(--app-muted); text-align: center; font-size: 13px;
    }

    /* KOMPONEN UI */
    .card {
        padding: 24px; border: 1px solid var(--app-border); border-radius: 17px;
        background: var(--app-panel);
        box-shadow: 0 8px 25px rgba(0, 0, 0, .2);
    }

    .muted { color: var(--app-muted); }
    
    .grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 18px;
    }

    /* FORM & TOMBOL */
    .field { margin-bottom: 17px; }
    .field label { 
        display: block; margin-bottom: 7px; font-size: 13px; font-weight: 600; color: var(--app-muted); 
    }
    
    .field input, .field select, .field textarea {
        width: 100%; min-height: 43px; padding: 10px 12px;
        border: 1px solid rgba(255,255,255,.12); border-radius: 8px;
        background: #101b28; color: var(--app-text); font: inherit; outline: none;
    }
    
    .field input:focus, .field select:focus { border-color: var(--app-accent); }

    button {
        padding: 11px 17px; border: 0; border-radius: 8px;
        background: var(--app-accent); color: #071311; 
        font-weight: 800; cursor: pointer; font: inherit; transition: .2s;
    }
    
    button:hover { filter: brightness(1.1); }
    
    .danger { background: #dc3545 !important; color: #ffffff !important; }
    
    .tag {
        display: inline-block; padding: 4px 10px; border-radius: 6px;
        background: rgba(72, 223, 197, 0.15); color: var(--app-accent);
        font-size: 11px; font-weight: 800; margin-bottom: 8px;
    }

    @media (max-width: 600px) {
        .site-header-inner { min-height: 70px; padding: 12px 16px; }
        .site-brand { font-size: 19px; }
        .site-nav { gap: 13px; }
        .site-nav a { font-size: 13px; }
        .site-nav .site-register { padding: 8px 12px; }
    }
</style>
</head>

<body>

    @php
        $isLoginPage = request()->routeIs('login');
    @endphp

    {{-- Header hanya ditampilkan di halaman selain login --}}
    @unless($isLoginPage)
        <header class="site-header">
            <div class="site-header-inner">
                <a href="{{ route('home') }}" class="site-brand">
                    SewaKendaraan
                </a>

                <nav class="site-nav">
    <a href="{{ route('armada.index') }}">Armada</a>

    {{-- Cek jika yang login adalah customer --}}
    @if(session('role') === 'customer')
        <a href="{{ route('customer.orders') }}">Pesanan Saya</a>
        <form method="POST" action="{{ route('logout') }}" style="display: inline-block;">
            @csrf
            {{-- Menggunakan class "danger" bawaan CSS Anda agar tombol berwarna merah --}}
            <button type="submit" class="danger" style="padding: 10px 15px;">
                Logout ({{ session('user_name') }})
            </button>
        </form>

    {{-- Cek jika yang login kebetulan admin (akses nyasar) --}}
    @elseif(session('role') === 'admin')
        <a href="{{ route('admin.dashboard') }}">Dashboard Admin</a>

    {{-- Tampilan untuk pengunjung yang belum login --}}
    @else
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}" class="site-register">
            Daftar
        </a>
    @endif
</nav>
            </div>
        </header>
    @endunless

    {{-- Konten halaman --}}
    <main class="site-content">
        @yield('content')
    </main>

    {{-- Footer hanya ditampilkan di halaman selain login --}}
    @unless($isLoginPage)
        <footer class="site-footer">
            Sistem Informasi Penyewaan Kendaraan · Proyek RPL
        </footer>
    @endunless

</body>
</html>
