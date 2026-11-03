<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — SewaKendaraan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >
    <style>
        :root {
            color-scheme: dark;
            --bg: #080b10;
            --panel: #101720;
            --panel2: #141e29;
            --line: rgba(255, 255, 255, 0.09);
            --text: #f3f6fa;
            --muted: #9aa8b8;
            --teal: #48dfc5;
            --red: #ff6677;
            --radius: 16px;
        }

        * {
            box-sizing: border-box;
        }

        html {
            min-height: 100%;
            background: var(--bg);
        }

        body {
            min-height: 100vh;
            margin: 0;
            background:
                radial-gradient(circle at 80% 0%, rgba(36, 115, 112, 0.12), transparent 30%),
                var(--bg);
            color: var(--text);
            font: 14px 'DM Sans', sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button,
        input,
        select,
        textarea {
            font: inherit;
        }

        .admin-shell {
            min-height: 100vh;
        }

        .admin-sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 20;
            display: flex;
            width: 248px;
            flex-direction: column;
            padding: 25px 17px;
            background: #0c1118;
            border-right: 1px solid var(--line);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 0 10px 28px;
            font: 800 18px Manrope, sans-serif;
            letter-spacing: -0.5px;
        }

        .brand-mark {
            display: grid;
            width: 38px;
            height: 38px;
            place-items: center;
            border-radius: 12px;
            background: var(--teal);
            color: #071411;
            font-size: 20px;
            font-weight: 900;
        }

        .brand span {
            color: var(--teal);
        }

        .side-label {
            padding: 12px 12px 9px;
            color: #68788a;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.8px;
            text-transform: uppercase;
        }

        .side-nav {
            display: grid;
            gap: 6px;
        }

        .side-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border: 1px solid transparent;
            border-radius: 11px;
            color: #aab6c4;
            font-weight: 600;
            transition: 0.18s;
        }

        .side-nav a:hover,
        .side-nav a.active {
            border-color: rgba(72, 223, 197, 0.16);
            background: rgba(72, 223, 197, 0.09);
            color: var(--teal);
        }

        .nav-icon {
            width: 22px;
            text-align: center;
            font-size: 17px;
        }

        .side-bottom {
            margin-top: auto;
            padding: 15px 11px 0;
            border-top: 1px solid var(--line);
        }

        .side-bottom p {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.6;
        }

        .logout-btn {
            width: 100%;
            padding: 11px;
            border: 1px solid var(--line);
            border-radius: 10px;
            background: #151c25;
            color: #e8edf3;
            cursor: pointer;
        }

        .logout-btn:hover {
            border-color: rgba(255, 102, 119, 0.5);
            color: #ff9ca7;
        }

        .admin-main {
            min-height: 100vh;
            margin-left: 248px;
        }

        .admin-topbar {
            position: sticky;
            top: 0;
            z-index: 10;
            display: flex;
            height: 76px;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 0 32px;
            border-bottom: 1px solid var(--line);
            background: rgba(8, 11, 16, 0.78);
            backdrop-filter: blur(14px);
        }

        .top-title {
            font: 800 17px Manrope, sans-serif;
        }

        .top-sub {
            margin-top: 3px;
            color: var(--muted);
            font-size: 12px;
        }

        .admin-user {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--muted);
            font-size: 12px;
        }

        .avatar {
            display: grid;
            width: 35px;
            height: 35px;
            place-items: center;
            border-radius: 12px;
            background: #183b3a;
            color: var(--teal);
            font-weight: 800;
        }

        .admin-content {
            max-width: 1600px;
            margin: 0 auto;
            padding: 30px 32px 42px;
        }

        .flash {
            margin-bottom: 18px;
            padding: 13px 15px;
            border: 1px solid rgba(72, 223, 197, 0.22);
            border-radius: 11px;
            background: rgba(72, 223, 197, 0.08);
            color: #aaf5e7;
        }

        .flash.error {
            border-color: rgba(255, 102, 119, 0.25);
            background: rgba(255, 102, 119, 0.08);
            color: #ffb4bd;
        }

        .page-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 23px;
        }

        .page-heading h1 {
            margin: 0;
            font: 800 clamp(25px, 3vw, 34px) Manrope, sans-serif;
            letter-spacing: -1px;
        }

        .page-heading p {
            margin: 8px 0 0;
            color: var(--muted);
            line-height: 1.6;
        }

        .panel,
        .card {
            margin-bottom: 20px;
            padding: 22px;
            border: 1px solid var(--line);
            border-radius: var(--radius);
            background: linear-gradient(145deg, rgba(18, 27, 38, 0.98), rgba(13, 19, 28, 0.98));
        }

        .panel h2,
        .card h2 {
            margin: 0 0 17px;
            font: 700 17px Manrope, sans-serif;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .field {
            display: flex;
            min-width: 0;
            flex-direction: column;
            gap: 7px;
        }

        .field label {
            color: #cbd4df;
            font-size: 12px;
            font-weight: 700;
        }

        .field input,
        .field select,
        .field textarea {
            width: 100%;
            min-height: 43px;
            padding: 11px 12px;
            border: 1px solid #293545;
            border-radius: 10px;
            outline: none;
            background: #0a1017;
            color: var(--text);
        }

        .field input:focus,
        .field select:focus,
        .field textarea:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(72, 223, 197, 0.08);
        }

        .btn,
        button.btn {
            display: inline-flex;
            min-height: 42px;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 16px;
            border: 1px solid var(--teal);
            border-radius: 10px;
            background: var(--teal);
            color: #071411;
            font-weight: 800;
            cursor: pointer;
            transition: 0.18s;
        }

        .btn:hover,
        button.btn:hover {
            filter: brightness(1.06);
            transform: translateY(-1px);
        }

        .btn-secondary {
            border-color: #2a3746;
            background: #151e29;
            color: var(--text);
        }

        .btn-danger,
        .danger {
            border: 1px solid rgba(255, 102, 119, 0.3) !important;
            background: rgba(255, 102, 119, 0.1) !important;
            color: #ff9ba6 !important;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 17px;
        }

        .table-wrap {
            overflow-x: auto;
            border: 1px solid var(--line);
            border-radius: 14px;
            background: rgba(13, 19, 28, 0.8);
        }

        table {
            width: 100%;
            min-width: 700px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 14px 15px;
            border-bottom: 1px solid var(--line);
            text-align: left;
            vertical-align: middle;
        }

        th {
            background: #131d28;
            color: #aebccc;
            font-size: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        td {
            color: #e0e6ed;
            font-size: 13px;
        }

        tbody tr:hover {
            background: rgba(255, 255, 255, 0.018);
        }

        tbody tr:last-child td {
            border-bottom: 0;
        }

        .table-wrap button {
            padding: 8px 11px;
            border-radius: 8px;
            cursor: pointer;
        }

        .muted {
            color: var(--muted);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 5px 9px;
            border: 1px solid rgba(72, 223, 197, 0.17);
            border-radius: 999px;
            background: rgba(72, 223, 197, 0.09);
            color: var(--teal);
            font-size: 11px;
            font-weight: 700;
        }

        .empty-state {
            padding: 24px;
            color: var(--muted);
            text-align: center;
        }

        .errors {
            margin: 0 0 15px;
            padding: 12px 16px;
            border: 1px solid rgba(255, 102, 119, 0.25);
            border-radius: 11px;
            background: rgba(255, 102, 119, 0.08);
            color: #ffb4bd;
        }

        .admin-dashboard {
            color: var(--text);
        }

        .admin-dashboard .dashboard-hero,
        .admin-dashboard .stat-card,
        .admin-dashboard .content-card {
            border-color: var(--line);
            background: linear-gradient(145deg, #121d29, #0d141d);
        }

        .admin-dashboard .dashboard-hero {
            border-radius: 17px;
        }

        .admin-dashboard .stat-card,
        .admin-dashboard .content-card {
            border: 1px solid var(--line);
            border-radius: 15px;
        }

        .admin-dashboard .stat-card,
        .admin-dashboard .content-card {
            padding: 20px;
        }

        .admin-dashboard .section-heading h2,
        .admin-dashboard h3,
        .admin-dashboard h4 {
            color: var(--text);
        }

        .admin-dashboard .muted,
        .admin-dashboard .section-heading p,
        .admin-dashboard .dashboard-footer {
            color: var(--muted);
        }

        .admin-dashboard table {
            min-width: 780px;
        }

        .admin-dashboard th {
            background: #131d28;
        }

        .admin-dashboard td {
            border-color: var(--line);
        }

        .admin-dashboard .btn {
            border-color: var(--teal);
            background: var(--teal);
            color: #071411;
        }

        .admin-dashboard .btn.secondary {
            border-color: #2a3746;
            background: #151e29;
            color: var(--text);
        }

        @media (max-width: 900px) {
            .admin-sidebar {
                width: 74px;
                padding: 20px 9px;
            }

            .brand {
                padding: 0 8px 25px;
            }

            .brand-name,
            .side-label,
            .nav-text,
            .side-bottom p,
            .logout-text {
                display: none;
            }

            .side-nav a {
                justify-content: center;
                padding: 13px 5px;
            }

            .nav-icon {
                font-size: 19px;
            }

            .side-bottom {
                padding: 15px 0 0;
            }

            .admin-main {
                margin-left: 74px;
            }

            .admin-topbar {
                padding: 0 20px;
            }

            .admin-content {
                padding: 22px 20px 32px;
            }
        }

        @media (max-width: 560px) {
            .admin-sidebar {
                width: 60px;
            }

            .admin-main {
                margin-left: 60px;
            }

            .admin-topbar {
                height: 66px;
                padding: 0 13px;
            }

            .admin-content {
                padding: 18px 12px 25px;
            }

            .admin-user .user-name {
                display: none;
            }

            .grid {
                grid-template-columns: 1fr;
            }

            .panel,
            .card {
                padding: 16px;
            }

            .admin-dashboard .dashboard-hero {
                padding: 20px !important;
            }

            .admin-dashboard .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    @if (request()->routeIs('admin.login'))
        @yield('content')
    @else
        <div class="admin-shell">
            <aside class="admin-sidebar">
                <a class="brand" href="{{ route('admin.dashboard') }}">
                    <span class="brand-mark">S</span>
                    <span class="brand-name">Sewa<span>Kendaraan.</span></span>
                </a>

                <div class="side-label">Workspace</div>

                <nav class="side-nav">
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    >
                        <span class="nav-icon">▦</span>
                        <span class="nav-text">Dashboard</span>
                    </a>
                    <a
                        href="{{ route('admin.armada') }}"
                        class="{{ request()->routeIs('admin.armada*') ? 'active' : '' }}"
                    >
                        <span class="nav-icon">▣</span>
                        <span class="nav-text">Kelola Armada</span>
                    </a>
                    <a
                        href="{{ route('admin.sopir') }}"
                        class="{{ request()->routeIs('admin.sopir*') ? 'active' : '' }}"
                    >
                        <span class="nav-icon">♙</span>
                        <span class="nav-text">Kelola Supir</span>
                    </a>
                    <a href="{{ route('home') }}">
                        <span class="nav-icon">↗</span>
                        <span class="nav-text">Lihat Website</span>
                    </a>
                </nav>

                <div class="side-bottom">
                    <p>
                        Masuk sebagai<br>
                        <strong>{{ session('user_name', 'Administrator') }}</strong>
                    </p>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button class="logout-btn" type="submit">
                            <span>↪</span>
                            <span class="logout-text">Keluar dari Admin</span>
                        </button>
                    </form>
                </div>
            </aside>

            <main class="admin-main">
                <header class="admin-topbar">
                    <div>
                        <div class="top-title">@yield('page-heading', 'Admin Workspace')</div>
                        <div class="top-sub">Sistem pengelolaan penyewaan kendaraan</div>
                    </div>

                    <div class="admin-user">
                        <span class="avatar">
                            {{ strtoupper(substr(session('user_name', 'A'), 0, 1)) }}
                        </span>
                        <span class="user-name">
                            {{ session('user_name', 'Administrator') }}
                        </span>
                    </div>
                </header>

                <section class="admin-content">
                    @if (session('success'))
                        <div class="flash">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="errors">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    @yield('content')
                </section>
            </main>
        </div>
    @endif

    @stack('scripts')
</body>
</html>
