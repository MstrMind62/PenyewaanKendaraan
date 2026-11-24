<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Portal Supir') | SK Rental Mobil</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #07090d;
            --panel: #0e1219;
            --panel2: #111722;
            --line: #202936;
            --text: #f4f7fb;
            --muted: #8995a7;
            --teal: #14b8a6;
            --teal2: #0f9488;
            --blue: #60a5fa;
            --amber: #fbbf24;
            --green: #34d399;
            --red: #fb7185;
            --radius: 18px;
        }

        * {
            box-sizing: border-box;
        }

        html {
            min-height: 100%;
            background: var(--bg);
        }

        body {
            margin: 0;
            background: radial-gradient(ellipse at 80% -15%, rgba(20,184,166,.10), transparent 35%), var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            line-height: 1.55;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button, input {
            font: inherit;
        }

        button, a, input {
            transition: all .18s ease;
        }

        button {
            cursor: pointer;
        }

        .app-shell {
            min-height: 100vh;
        }

        /* SIDEBAR */

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 246px;
            padding: 25px 17px;
            background: #090c11;
            border-right: 1px solid var(--line);
            display: flex;
            flex-direction: column;
            z-index: 20;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 0 10px 28px;
        }

        .brand-mark {
            width: 45px;
            height: 45px;
            min-width: 45px;
            border-radius: 10px;
            background: #FFFFFF url('{{ asset('images/logo_sk.jpeg') }}') center / contain no-repeat;
            display: block;
            border: 1px solid #E5E7EB;
            box-shadow: 0 4px 12px rgba(0,0,0,.08);
            font-size: 0;
        }

        .brand-name {
            font: 800 17px Manrope, sans-serif;
            letter-spacing: -.6px;
            color: #FFFFFF;
        }

        .brand-sub {
            display: block;
            font-size: 10px;
            color: var(--muted);
            letter-spacing: 1.1px;
            text-transform: uppercase;
            margin-top: 1px;
        }

        .nav-label {
            padding: 12px 12px 8px;
            color: #596577;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 13px;
            margin: 3px 0;
            border: 1px solid transparent;
            border-radius: 11px;
            color: #9aa6b6;
            font-weight: 600;
        }

        .nav-link .nav-icon {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        .nav-link:hover {
            background: #121923;
            color: #fff;
        }

        .nav-link.active {
            background: linear-gradient(100deg,#0d766f55,#0d766f12);
            border-color: #14b8a633;
            color: #65f0df;
        }

        .sidebar-bottom {
            margin-top: auto;
        }

        .driver-mini {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 13px 10px;
            margin: 0 0 10px;
            border: 1px solid var(--line);
            border-radius: 13px;
            background: #0d1118;
        }

        .avatar {
            width: 36px;
            height: 36px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            border-radius: 12px;
            background: #1b2b32;
            color: #70e7d8;
            font-weight: 800;
        }

        .driver-mini-name {
            font-weight: 700;
            font-size: 12px;
        }

        .driver-mini-role {
            font-size: 11px;
            color: var(--muted);
        }

        /* MAIN CONTENT */

        .main {
            margin-left: 246px;
            min-height: 100vh;
        }

        .topbar {
            height: 76px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 0 34px;
            border-bottom: 1px solid #1a222d;
            background: #080b10d9;
            backdrop-filter: blur(18px);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .crumb {
            color: var(--muted);
            font-size: 12px;
        }

        .top-title {
            font: 700 15px Manrope, sans-serif;
        }

        .top-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .top-user .avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
        }

        .page {
            max-width: 1500px;
            margin: 0 auto;
            padding: 30px 34px 42px;
        }

        .eyebrow {
            color: #5eead4;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.7px;
            text-transform: uppercase;
        }

        .page-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 25px;
        }

        .page-heading h1 {
            font: 800 clamp(24px,3vw,32px) Manrope,sans-serif;
            letter-spacing: -1.2px;
            margin: 5px 0 6px;
        }

        .page-heading p {
            margin: 0;
            color: var(--muted);
            max-width: 650px;
        }

        /* BUTTON */

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border: 1px solid var(--line);
            border-radius: 11px;
            padding: 11px 15px;
            background: #151b25;
            color: #e8edf5;
            font-weight: 700;
        }

        .btn:hover {
            transform: translateY(-1px);
            border-color: #435063;
            background: #1a2431;
        }

        .btn-primary {
            background: var(--teal);
            color: #031412;
            border-color: var(--teal);
            box-shadow: 0 8px 24px #14b8a61c;
        }

        .btn-primary:hover {
            background: #2dd4bf;
            border-color: #2dd4bf;
            color: #031412;
        }

        .btn-quiet {
            background: transparent;
        }

        .btn-danger {
            color: #fecdd3;
            border-color: #7f1d1d;
            background: #2a1118;
        }

        .btn-small {
            padding: 8px 11px;
            font-size: 12px;
            border-radius: 9px;
        }

        /* CARD */

        .card {
            background: linear-gradient(145deg,#111720,#0d1118);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            padding: 22px;
            min-width: 0;
            box-shadow: 0 14px 40px #0000000b;
        }

        .card-title-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 17px;
        }

        .card h2, .card h3 {
            font: 700 16px Manrope,sans-serif;
            margin: 0;
        }

        .muted {
            color: var(--muted);
        }

        .small {
            font-size: 12px;
        }

        /* STATISTICS */

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4,minmax(0,1fr));
            gap: 14px;
            margin-bottom: 22px;
        }

        .stat-card {
            position: relative;
            overflow: hidden;
            padding: 20px;
        }

        .stat-card:after {
            content: '';
            position: absolute;
            width: 110px;
            height: 110px;
            right: -55px;
            top: -60px;
            border-radius: 50%;
            background: var(--glow,#14b8a6);
            opacity: .10;
            filter: blur(3px);
        }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 600;
        }

        .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            background: #14352f;
            color: #5eead4;
            font-size: 17px;
        }

        .stat-number {
            font: 800 31px Manrope,sans-serif;
            letter-spacing: -1px;
            margin: 12px 0 4px;
        }

        .stat-foot {
            font-size: 11px;
            color: #768396;
        }

        /* WELCOME BANNER */

        .welcome-banner {
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 22px;
            min-height: 174px;
            padding: 27px 30px;
            margin-bottom: 20px;
            border: 1px solid #253641;
            border-radius: 20px;
            background: radial-gradient(ellipse at 85% 50%,#0d94882c,transparent 40%),linear-gradient(110deg,#101923,#0b1016);
        }

        .welcome-banner:after {
            content: '✦';
            position: absolute;
            right: 12%;
            top: -60px;
            font-size: 230px;
            color: #9ef7e922;
            pointer-events: none;
        }

        .welcome-banner h2 {
            font: 800 clamp(22px,3vw,30px) Manrope,sans-serif;
            letter-spacing: -.8px;
            margin: 7px 0;
        }

        .welcome-banner p {
            color: #9ba8b8;
            margin: 0;
            max-width: 560px;
        }

        .welcome-actions {
            display: flex;
            gap: 9px;
            flex-wrap: wrap;
            z-index: 1;
        }

        /* TABLE */

        .table-card {
            padding: 0;
            overflow: hidden;
        }

        .table-card .card-title-row {
            padding: 21px 22px 15px;
            margin: 0;
        }

        .table-tools {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .searchbox {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            border: 1px solid var(--line);
            border-radius: 10px;
            background: #0a0e14;
            color: var(--muted);
            min-width: 220px;
        }

        .searchbox input {
            width: 100%;
            min-width: 0;
            background: transparent;
            border: 0;
            outline: 0;
            color: var(--text);
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            white-space: nowrap;
        }

        thead {
            background: #0a0e14;
        }

        th {
            font-size: 10px;
            letter-spacing: .7px;
            text-transform: uppercase;
            color: #718095;
            font-weight: 800;
            text-align: left;
            padding: 13px 20px;
            border-top: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
        }

        td {
            padding: 15px 20px;
            border-bottom: 1px solid #1b222c;
            color: #cbd5e1;
            font-size: 12px;
        }

        tbody tr:hover {
            background: #ffffff04;
        }

        tbody tr:last-child td {
            border-bottom: 0;
        }

        .order-id {
            font-weight: 800;
            color: #e8edf5;
        }

        .sub-cell {
            font-size: 11px;
            color: var(--muted);
            margin-top: 3px;
        }

        .vehicle-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .vehicle-thumb {
            width: 45px;
            height: 34px;
            border-radius: 8px;
            background: linear-gradient(145deg,#243641,#111820);
            display: grid;
            place-items: center;
            font-size: 20px;
            border: 1px solid #2a3b44;
        }

        /* STATUS */

        .status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 9px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 800;
            border: 1px solid transparent;
        }

        .status:before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: currentColor;
        }

        .status-pending {
            background: #3a2b12;
            color: #facc65;
            border-color: #6a4d1c;
        }

        .status-progress {
            background: #102c46;
            color: #7cc5ff;
            border-color: #1b4d73;
        }

        .status-done {
            background: #10372d;
            color: #6ee7b7;
            border-color: #1b5c48;
        }

        .status-other {
            background: #252b35;
            color: #cbd5e1;
            border-color: #394351;
        }

        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: var(--muted);
        }

        .empty-icon {
            font-size: 32px;
            margin-bottom: 8px;
        }

        /* ALERT */

        .alert {
            padding: 13px 15px;
            border: 1px solid #235c4e;
            background: #0d2924;
            color: #a7f3d0;
            border-radius: 12px;
            margin-bottom: 18px;
        }

        .alert-error {
            border-color: #71313a;
            background: #291218;
            color: #fecdd3;
        }

        /* CONTENT GRID */

        .content-grid {
            display: grid;
            grid-template-columns: minmax(0,1.1fr) minmax(300px,.9fr);
            gap: 18px;
        }

        .info-list {
            display: grid;
            gap: 0;
        }

        .info-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            padding: 13px 0;
            border-bottom: 1px solid #202936;
        }

        .info-row:last-child {
            border-bottom: 0;
        }

        .info-label {
            color: var(--muted);
            font-size: 12px;
        }

        .info-value {
            text-align: right;
            font-weight: 600;
            overflow-wrap: anywhere;
        }

        .section-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.4px;
            color: #5eead4;
            font-weight: 800;
            margin-bottom: 10px;
        }

        /* PROGRESS */

        .progress-track {
            display: grid;
            grid-template-columns: repeat(3,1fr);
            gap: 8px;
            margin: 23px 0;
        }

        .progress-step {
            position: relative;
            text-align: center;
            color: #657184;
            font-size: 11px;
        }

        .progress-step:before {
            content: '';
            display: block;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 1px solid #344151;
            background: #111822;
            margin: 0 auto 9px;
            position: relative;
            z-index: 1;
        }

        .progress-step:after {
            content: '';
            height: 2px;
            position: absolute;
            top: 13px;
            left: calc(50% + 17px);
            width: calc(100% - 26px);
            background: #293442;
        }

        .progress-step:last-child:after {
            display: none;
        }

        .progress-step.done {
            color: #99f6e4;
        }

        .progress-step.done:before {
            background: #0f766e;
            border-color: #2dd4bf;
            box-shadow: 0 0 0 4px #14b8a614;
        }

        .progress-step.done:after {
            background: #0f766e;
        }

        /* FORM DASHBOARD */

        .form-control {
            width: 100%;
            border: 1px solid #2a3442;
            border-radius: 11px;
            padding: 13px 14px;
            background: #090d13;
            color: #f8fafc;
            outline: 0;
        }

        .form-control:focus {
            border-color: #14b8a6;
            box-shadow: 0 0 0 3px #14b8a61a;
        }

        .form-label {
            display: block;
            margin: 16px 0 8px;
            color: #cbd5e1;
            font-size: 12px;
            font-weight: 700;
        }

        /* =========================================
           LOGIN SUPIR - TEMA PUTIH DAN ORANYE
        ========================================= */

        body:has(.login-page) {
            background: #FFFFFF;
            color: #202A35;
        }

        .login-page {
            min-height: 100vh;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: #FFFFFF;
            color: #202A35;
        }

        /* BAGIAN KIRI */

        .login-visual {
            position: relative;
            min-height: 100vh;
            padding: 55px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;

            background: linear-gradient(
                135deg,
                #FFF1E1,
                #FFFFFF
            );

            color: #202A35;
        }

        .login-visual::before {
            content: "🚘";
            position: absolute;
            right: -25px;
            top: 25%;
            font-size: clamp(170px,23vw,310px);
            opacity: 0.12;
            transform: rotate(-8deg);
            pointer-events: none;
        }

        .login-visual::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 25%;
            background: linear-gradient(
                transparent,
                rgba(242,140,40,.08)
            );
            pointer-events: none;
        }

        .login-visual > * {
            position: relative;
            z-index: 1;
        }

        /* LOGO LOGIN */

        .login-brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            width: fit-content;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        .login-brand img {
            width: 55px;
            height: 55px;
            object-fit: contain;
            display: block;
            border-radius: 10px;
            background: #FFFFFF;
            border: 1px solid #E5E7EB;
        }

        .login-brand-name {
            font: 800 17px Manrope,sans-serif;
            color: #202A35;
        }

        .login-brand-sub {
            display: block;
            color: #9CA3AF;
            font-size: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* TEKS KIRI */

        .login-copy {
            max-width: 540px;
            margin-bottom: 20px;
        }

        .login-copy h1 {
            font: 800 clamp(38px,5vw,62px) Manrope,sans-serif;
            line-height: 1.08;
            letter-spacing: -2px;
            margin: 16px 0;
            color: #202A35;
        }

        .login-copy p {
            color: #6B7280;
            max-width: 430px;
            font-size: 15px;
            line-height: 1.8;
        }

        .login-visual .eyebrow {
            color: #D97706;
        }

        /* FITUR LOGIN */

        .login-features {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            color: #4B5563;
            font-size: 12px;
        }

        .login-feature {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .login-feature span:first-child {
            width: 32px;
            height: 32px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            background: #FFF0DF;
            border: 1px solid #F6D6B5;
        }

        /* BAGIAN KANAN */

        .login-form-wrap {
            display: grid;
            place-items: center;
            padding: 40px 25px;
            background: #FFFFFF;
        }

        /* KARTU LOGIN */

        .login-card {
            width: 100%;
            max-width: 430px;
            padding: 38px;

            border: 1px solid #E5E7EB;
            border-radius: 22px;

            background: #FFFFFF;
            color: #202A35;

            box-shadow: 0 20px 60px rgba(32,42,53,.08);
        }

        .login-card h2 {
            font: 800 28px Manrope,sans-serif;
            letter-spacing: -.8px;
            margin: 5px 0;
            color: #202A35;
        }

        .login-card .login-intro {
            color: #6B7280;
            margin: 0 0 22px;
        }

        .login-card .form-label {
            display: block;
            margin: 16px 0 8px;
            color: #374151;
            font-size: 12px;
            font-weight: 700;
        }

        .login-card .form-control {
            width: 100%;
            border: 1px solid #E5E7EB;
            border-radius: 10px;
            padding: 13px 14px;
            background: #FFFFFF;
            color: #202A35;
            outline: none;
            transition: .2s;
        }

        .login-card .form-control:focus {
            border-color: #F28C28;
            box-shadow: 0 0 0 3px rgba(242,140,40,.13);
        }

        .login-card .form-control::placeholder {
            color: #9CA3AF;
        }

        .login-card .btn {
            width: 100%;
            margin-top: 23px;
            padding: 14px;
            border: 1px solid #F28C28;
            border-radius: 10px;
            background: #F28C28;
            color: #FFFFFF;
            font-weight: 700;
        }

        .login-card .btn:hover {
            background: #E47713;
            border-color: #E47713;
            color: #FFFFFF;
            transform: translateY(-2px);
        }

        .login-card a {
            color: #D97706;
        }

        .login-card a:hover {
            color: #E47713;
        }

        .back-home {
            display: block;
            text-align: center;
            color: #6B7280;
            font-size: 12px;
            margin-top: 20px;
        }

        .back-home:hover {
            color: #F28C28;
        }

        .footer-note {
            margin-top: 22px;
            color: #9CA3AF;
            font-size: 11px;
            text-align: center;
        }

        /* RESPONSIVE */

        @media(max-width:1100px) {
            .stats-grid {
                grid-template-columns: repeat(2,minmax(0,1fr));
            }

            .page {
                padding: 25px 22px;
            }

            .topbar {
                padding: 0 22px;
            }

            .content-grid {
                grid-template-columns: 1fr;
            }

            .sidebar {
                width: 220px;
            }

            .main {
                margin-left: 220px;
            }
        }

        @media(max-width:760px) {
            .sidebar {
                position: static;
                width: auto;
                height: auto;
                padding: 12px 15px;
                border-right: 0;
                border-bottom: 1px solid var(--line);
            }

            .sidebar .brand {
                padding: 0;
            }

            .sidebar nav,
            .sidebar .nav-label,
            .sidebar-bottom {
                display: none;
            }

            .main {
                margin-left: 0;
            }

            .topbar {
                height: 62px;
                padding: 0 17px;
            }

            .page {
                padding: 22px 15px 32px;
            }

            .page-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .stats-grid {
                gap: 10px;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-number {
                font-size: 26px;
            }

            .welcome-banner {
                padding: 22px;
                align-items: flex-start;
                flex-direction: column;
            }

            .table-card .card-title-row {
                align-items: flex-start;
                flex-direction: column;
            }

            .table-tools,
            .searchbox {
                width: 100%;
                min-width: 0;
            }

            /* Login HP */
            .login-page {
                grid-template-columns: 1fr;
            }

            .login-visual {
                display: none;
            }

            .login-form-wrap {
                min-height: 100vh;
                padding: 25px 18px;
                background: #F9FAFB;
            }

            .login-card {
                padding: 30px 23px;
            }

            .info-row {
                gap: 12px;
            }

            .info-value {
                max-width: 62%;
            }
        }

        @media(max-width:420px) {
            .stats-grid {
                grid-template-columns: repeat(2,minmax(0,1fr));
            }

            .stat-top {
                font-size: 11px;
            }

            .card {
                padding: 16px;
            }

            .top-user .user-text {
                display: none;
            }

            .page-heading h1 {
                font-size: 25px;
            }
        }

    </style>
</head>

<body>

@php($isLogin = request()->routeIs('supir.login'))

@if($isLogin)

    @yield('content')

@else

<div class="app-shell">

    <aside class="sidebar">

        <a class="brand" href="{{ route('supir.dashboard') }}">

            <span class="brand-mark"></span>

            <span>
                <span class="brand-name">SK Rental Mobil</span>
                <span class="brand-sub">Driver Portal</span>
            </span>

        </a>

        <div class="nav-label">Menu utama</div>

        <nav>
            <a class="nav-link {{ request()->routeIs('supir.dashboard') ? 'active' : '' }}" href="{{ route('supir.dashboard') }}">
                <span class="nav-icon">▦</span>
                Dashboard
            </a>

            <a class="nav-link {{ request()->routeIs('supir.tugas*') ? 'active' : '' }}" href="{{ route('supir.tugas') }}">
                <span class="nav-icon">▤</span>
                Tugas perjalanan
            </a>
        </nav>

        <div class="sidebar-bottom">

            <div class="driver-mini">
                <div class="avatar">
                    {{ strtoupper(substr(session('user_name', 'S'), 0, 1)) }}
                </div>

                <div>
                    <div class="driver-mini-name">
                        {{ session('user_name', 'Supir') }}
                    </div>

                    <div class="driver-mini-role">
                        Supir terdaftar
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('supir.logout') }}">
                @csrf

                <button type="submit" class="nav-link" style="width:100%;background:transparent;text-align:left">
                    <span class="nav-icon">↪</span>
                    Keluar akun
                </button>
            </form>

        </div>

    </aside>

    <main class="main">

        <header class="topbar">

            <div>
                <div class="crumb">SK / Portal Supir</div>
                <div class="top-title">
                    @yield('topbar-title', 'Ringkasan aktivitas')
                </div>
            </div>

            <div class="top-user">

                <div class="avatar">
                    {{ strtoupper(substr(session('user_name', 'S'), 0, 1)) }}
                </div>

                <div class="user-text">
                    <strong>{{ session('user_name', 'Supir') }}</strong>
                    <div class="muted small">Portal Supir</div>
                </div>

            </div>

        </header>

        <div class="page">

            @if(session('success'))
                <div class="alert">
                    ✓ &nbsp;{{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            @yield('content')

        </div>

    </main>

</div>

@endif

</body>
</html>
