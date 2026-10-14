
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'SewaKendaraan')</title>

    <style>
        * {
            box-sizing: border-box;
        }

        html {
            min-height: 100%;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", Arial, sans-serif;
            color: #172033;
            background: #f3f6fb;
        }

        a {
            color: #175bd7;
        }

        /* HEADER halaman umum */
        .site-header {
            position: relative;
            z-index: 10;
            width: 100%;
            background: #ffffff;
            border-bottom: 1px solid #e4e9f1;
        }

        .site-header-inner {
            width: 100%;
            max-width: 1250px;
            min-height: 82px;
            margin: 0 auto;
            padding: 15px 25px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .site-brand {
            color: #172033;
            font-size: 23px;
            font-weight: 850;
            letter-spacing: -.6px;
            text-decoration: none;
        }

        .site-nav {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .site-nav a {
            color: #175bd7;
            font-size: 15px;
            text-decoration: none;
        }

        .site-nav a:hover {
            color: #0c3e9c;
        }

        .site-nav .site-register {
            padding: 14px 19px;
            border-radius: 11px;
            background: #195bd7;
            color: #ffffff;
        }

        .site-nav .site-register:hover {
            background: #1049b5;
            color: #ffffff;
        }

        /* Area halaman */
        .site-content {
            width: 100%;
            min-height: calc(100vh - 155px);
        }

        /* Footer halaman umum */
        .site-footer {
            width: 100%;
            padding: 28px 20px;
            background: #f3f6fb;
            color: #718096;
            text-align: center;
            font-size: 14px;
        }

        /* Komponen umum yang dipakai halaman lain */
        .card {
            padding: 24px;
            border: 1px solid #e1e8f2;
            border-radius: 17px;
            background: #ffffff;
            box-shadow: 0 8px 25px rgba(20, 40, 80, .035);
        }

        .field {
            margin-bottom: 17px;
        }

        .field label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: 600;
        }

        .field input,
        .field select,
        .field textarea {
            width: 100%;
            min-height: 43px;
            padding: 10px 12px;
            border: 1px solid #d8dfeb;
            border-radius: 8px;
            background: #ffffff;
            font: inherit;
        }

        .field input:focus,
        .field select:focus,
        .field textarea:focus {
            outline: 2px solid rgba(37, 99, 235, .16);
            border-color: #2563eb;
        }

        button {
            cursor: pointer;
            font: inherit;
        }

        button:not(.login-password-toggle) {
            padding: 11px 17px;
            border: 0;
            border-radius: 8px;
            background: #195bd7;
            color: #ffffff;
        }

        button:not(.login-password-toggle):hover {
            filter: brightness(.94);
        }

        .danger {
            background: #dc3545 !important;
            color: #ffffff;
        }

        .muted {
            color: #718096;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
            border-radius: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
        }

        th,
        td {
            padding: 13px 15px;
            border-bottom: 1px solid #e8edf4;
            text-align: left;
        }

        th {
            background: #f7f9fc;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .site-header-inner {
                min-height: 70px;
                padding: 12px 16px;
            }

            .site-brand {
                font-size: 19px;
            }

            .site-nav {
                gap: 13px;
            }

            .site-nav a {
                font-size: 13px;
            }

            .site-nav .site-register {
                padding: 10px 12px;
            }

            .grid {
                grid-template-columns: 1fr;
            }
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
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}" class="site-register">
                        Daftar
                    </a>
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
