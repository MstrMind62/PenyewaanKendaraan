
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'DriveEase - Rental Mobil')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #F28C28;
            --primary-hover: #E47713;

            --background: #FFFFFF;
            --surface: #F5F6F8;

            --text-dark: #202A35;
            --text-muted: #6B7280;

            --border: #E5E7EB;

            --success: #16A34A;
            --danger: #DC3545;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'DM Sans', sans-serif;
            background: var(--background);
            color: var(--text-dark);
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* =========================
           NAVBAR
        ========================= */

        .site-header {
            position: sticky;
            top: 0;
            z-index: 100;
            width: 100%;
            background: rgba(255,255,255,0.96);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
        }

        .site-header-inner {
            max-width: 1200px;
            min-height: 76px;
            padding: 12px 24px;
            margin: auto;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 25px;
        }

        /* LOGO WEBSITE */
        .site-brand {
            display: flex;
            align-items: center;
            flex-shrink: 0;
        }

        .site-brand img {
            width: 55px;
            height: 55px;
            object-fit: contain;
            display: block;
        }

        .site-nav {
            display: flex;
            align-items: center;
            gap: 28px;
        }

        .site-nav a {
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 600;
            transition: 0.2s;
        }

        .site-nav a:hover,
        .site-nav a.active {
            color: var(--primary);
        }

        .site-nav .site-register {
            background: var(--primary);
            color: white;
            padding: 11px 20px;
            border-radius: 9px;
        }

        .site-nav .site-register:hover {
            background: var(--primary-hover);
            color: white;
        }

        .site-nav form {
            margin: 0;
        }

        /* =========================
           BUTTON
        ========================= */

        .btn {
            display: inline-flex
            justify-content: center;
            align-items: center;

            padding: 12px 22px;
            border: none;
            border-radius: 9px;

            background: var(--primary);
            color: white;

            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn:hover {
            background: var(--primary-hover);
            color: white;
            transform: translateY(-2px);
        }

        .btn.secondary {
            background: white;
            color: var(--text-dark);
            border: 1px solid var(--border);
        }

        .btn.secondary:hover {
            background: var(--surface);
        }

        button {
            font-family: inherit;
            cursor: pointer;
        }

        button.danger,
        .danger {
            background: var(--danger) !important;
            color: white !important;
        }

        /* =========================
           CONTENT
        ========================= */

        .site-content {
            width: 100%;
            max-width: 1200px;
            min-height: calc(100vh - 160px);
            padding: 35px 24px 60px;
            margin: auto;
        }

        /* =========================
           CARD
        ========================= */

        .card {
            padding: 24px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.04);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(
                auto-fit,
                minmax(250px, 1fr)
            );
            gap: 22px;
        }

        .muted {
            color: var(--text-muted);
        }

        .tag {
            display: inline-block;
            padding: 6px 11px;
            border-radius: 20px;

            background: #FFF1E3;
            color: #D97706;

            font-size: 11px;
            font-weight: 700;
        }

        /* =========================
           FORM
        ========================= */

        .field {
            margin-bottom: 18px;
        }

        .field label {
            display: block;
            margin-bottom: 8px;

            color: var(--text-dark);
            font-size: 13px;
            font-weight: 700;
        }

        .field input,
        .field select,
        .field textarea {
            width: 100%;
            min-height: 45px;
            padding: 11px 13px;

            background: white;
            border: 1px solid var(--border);
            border-radius: 9px;

            color: var(--text-dark);
            font-family: inherit;
            outline: none;
            transition: 0.2s;
        }

        .field input:focus,
        .field select:focus,
        .field textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(242,140,40,0.12);
        }

        /* =========================
           PRICE
        ========================= */

        .price {
            color: var(--primary);
            font-size: 22px;
            font-weight: 800;
        }

        .price small {
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 500;
        }

        /* =========================
           FOOTER
        ========================= */

        .site-footer {
            width: 100%;
            padding: 30px 20px;

            background: var(--surface);
            border-top: 1px solid var(--border);

            color: var(--text-muted);
            text-align: center;
            font-size: 13px;
        }

        /* LOGO FOOTER */
        .footer-logo {
            width: 65px;
            height: 65px;
            object-fit: contain;
            display: block;
            margin: 0 auto 12px;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media(max-width: 700px) {

            .site-header-inner {
                padding: 14px 16px;
                min-height: auto;
                flex-wrap: wrap;
            }

            .site-brand img {
                width: 48px;
                height: 48px;
            }

            .site-nav {
                width: 100%;
                gap: 15px;
                flex-wrap: wrap;
            }

            .site-nav a {
                font-size: 12px;
            }

            .site-content {
                padding: 25px 16px 45px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    @php
        $isLoginPage = request()->routeIs('login');
    @endphp

    @unless($isLoginPage)

        <header class="site-header">

            <div class="site-header-inner">

                <!-- LOGO NAVBAR -->
                <a href="{{ route('home') }}" class="site-brand">
                    <img src="{{ asset('images/logo_sk.jpeg') }}"
                         alt="Logo SK Rental Mobil">
                </a>

                <nav class="site-nav">

                    <a href="{{ route('home') }}"
                       class="{{ request()->routeIs('home') ? 'active' : '' }}">
                        Beranda
                    </a>

                    <a href="{{ route('armada.index') }}"
                       class="{{ request()->routeIs('armada.*') || request()->routeIs('booking.create') ? 'active' : '' }}">
                        Daftar Mobil
                    </a>

                    @if(session('role') === 'customer')

                        <a href="{{ route('customer.orders') }}">
                            Pesanan Saya
                        </a>

                        <a href="{{ route('customer.profile') }}">
                            Profil Saya
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit"
                                    class="danger"
                                    style="padding: 10px 15px; border-radius: 8px; border: none;">
                                Logout
                            </button>
                        </form>

                    @elseif(session('role') === 'admin')

                        <a href="{{ route('admin.dashboard') }}">
                            Dashboard Admin
                        </a>

                    @else

                        <a href="{{ route('login') }}">
                            Masuk
                        </a>

                        <a href="{{ route('register') }}" class="site-register">
                            Daftar
                        </a>

                    @endif

                </nav>

            </div>

        </header>

    @endunless

    <main class="site-content">
        @yield('content')
    </main>

    @unless($isLoginPage)

        <footer class="site-footer">

            <!-- LOGO FOOTER -->
            <img src="{{ asset('images/logo_sk.jpeg') }}"
                 alt="Logo SK Rental Mobil"
                 class="footer-logo">

            <p>
                Solusi penyewaan kendaraan yang mudah,
                nyaman, dan terpercaya.
            </p>

            <small>
                © {{ date('Y') }} SK.
                All Rights Reserved.
            </small>

        </footer>

    @endunless

    @stack('scripts')

</body>
</html>
