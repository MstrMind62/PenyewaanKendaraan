@extends('layouts.app')

@section('title', 'DriveEase - Rental Kendaraan Terpercaya')

@push('styles')
<style>
    /* ==============================
       HOMEPAGE
    ============================== */

    .home-page { width: 100%; }

    /* ---------- HERO ---------- */

    .hero-section {
        position: relative;
        overflow: hidden;
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-items: center;
        gap: 30px;
        min-height: 430px;
        padding: 55px;
        background:
            linear-gradient(rgba(255,255,255,0.78), rgba(255,255,255,0.78)),
            url('/images/remie_bg.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        border-radius: 22px;
    }

    .hero-content { position: relative; z-index: 2; }

    .hero-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 30px;
        background: #FFF0DF;
        color: #D97706;
        font-size: 12px;
        font-weight: 700;
    }

    .hero-label .spark { display: inline-block; animation: spin-slow 6s linear infinite; }

    .hero-content h1 {
        margin: 22px 0 18px;
        font-size: clamp(32px, 4vw, 49px);
        line-height: 1.15;
        letter-spacing: -1.8px;
        color: #202A35;
    }

    .hero-content h1 span { color: #F28C28; }

    .hero-content p {
        max-width: 470px;
        margin-bottom: 28px;
        color: #6B7280;
        font-size: 15px;
        line-height: 1.8;
    }

    .hero-actions { display: flex; align-items: center; flex-wrap: wrap; gap: 12px; }
    .hero-actions .btn { padding: 14px 23px; }

    .hero-image {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 280px;
        perspective: 800px;
    }

    .hero-image::before {
        content: "";
        position: absolute;
        width: 330px;
        height: 330px;
        background: #FFE5CA;
        border-radius: 50%;
        z-index: -1;
        animation: pulse-ring 4s ease-in-out infinite;
    }

    .hero-image img {
        width: 115%;
        max-width: 570px;
        max-height: 350px;
        object-fit: contain;
        border-radius: 100px;
        filter: drop-shadow(0 15px 20px rgba(0,0,0,0.12));
        transition: transform 0.25s ease-out;
        animation: car-in 0.9s cubic-bezier(.2,.8,.2,1) both;
        will-change: transform;
    }

    .hero-image-placeholder {
        width: 100%;
        max-width: 430px;
        height: 230px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        border-radius: 18px;
        color: #9CA3AF;
        font-weight: 600;
    }

    /* ---------- BENEFIT ---------- */

    .benefit-section {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin: 30px 0 65px;
    }

    .benefit-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 20px;
        background: white;
        border: 1px solid #E5E7EB;
        border-radius: 14px;
        cursor: pointer;
        user-select: none;
        transition: transform .2s, border-color .2s, box-shadow .2s;
    }

    .benefit-item:hover { border-color: #F6C28E; box-shadow: 0 8px 20px rgba(32,42,53,0.07); }
    .benefit-item:active { transform: scale(.97); }
    .benefit-item.pop .benefit-icon { animation: icon-pop .5s ease; }

    .benefit-icon {
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #FFF0DF;
        color: #F28C28;
        font-size: 23px;
    }

    .benefit-item h4 { margin: 0 0 5px; font-size: 14px; color: #202A35; }
    .benefit-item p { margin: 0; color: #6B7280; font-size: 12px; line-height: 1.5; }

    /* ---------- SECTION HEADER ---------- */

    .section-heading {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 25px;
    }

    .section-heading h2 { margin: 0 0 7px; color: #202A35; font-size: 27px; letter-spacing: -0.7px; }
    .section-heading p { margin: 0; color: #6B7280; font-size: 14px; }
    .section-link { color: #F28C28; font-size: 13px; font-weight: 700; }
    .section-link:hover { color: #E47713; }

    /* ---------- FILTER & SEARCH ---------- */

    .cars-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 22px;
    }

    .filter-bar { display: flex; flex-wrap: wrap; gap: 8px; }

    .home-search-wrap {
        position: relative;
        display: flex;
        align-items: center;
        margin-left: auto;
    }

    .home-search-icon {
        position: absolute;
        left: 14px;
        font-size: 13px;
        color: #9CA3AF;
        pointer-events: none;
    }

    .home-search-input {
        width: 240px;
        padding: 9px 34px 9px 36px;
        border: 1px solid #E5E7EB;
        border-radius: 30px;
        background: white;
        color: #202A35;
        font: inherit;
        font-size: 13px;
        font-weight: 500;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }

    .home-search-input::placeholder { color: #9CA3AF; }
    .home-search-input:hover { border-color: #F6C28E; }
    .home-search-input:focus {
        border-color: #F28C28;
        box-shadow: 0 0 0 3px rgba(242,140,40,0.12);
    }

    .home-search-clear {
        position: absolute;
        right: 9px;
        width: 20px;
        height: 20px;
        display: none;
        align-items: center;
        justify-content: center;
        border: 0;
        border-radius: 50%;
        background: #FFF0DF;
        color: #D97706;
        font-size: 11px;
        font-weight: 800;
        cursor: pointer;
    }

    .home-search-clear.show { display: inline-flex; }

    .filter-chip {
        padding: 9px 16px;
        border: 1px solid #E5E7EB;
        border-radius: 30px;
        background: white;
        color: #6B7280;
        font: inherit;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: background .2s, color .2s, border-color .2s, transform .15s;
    }

    .filter-chip:hover { border-color: #F6C28E; color: #D97706; }
    .filter-chip:active { transform: scale(.94); }
    .filter-chip.active { background: #F28C28; border-color: #F28C28; color: white; }

    /* ---------- CAR LIST ---------- */

    .home-car-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 22px; }

    .home-car-card {
        overflow: hidden;
        background: white;
        border: 1px solid #E5E7EB;
        border-radius: 16px;
        transition: transform .3s, box-shadow .3s, border-color .3s;
    }

    .home-car-card:hover { transform: translateY(-5px); box-shadow: 0 12px 28px rgba(32,42,53,0.09); border-color: #F6C28E; }
    .home-car-card:active { transform: translateY(-2px) scale(.99); }
    .home-car-card.hide { display: none; }
    .home-car-card.show { animation: card-in .4s ease both; }

    .car-image-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 205px;
        margin: 10px;
        overflow: hidden;
        border-radius: 12px;
        background: #F5F6F8;
    }

    .car-image-wrapper img { width: 100%; height: 100%; padding: 12px; object-fit: contain; transition: transform .3s; }
    .home-car-card:hover .car-image-wrapper img { transform: scale(1.05); }

    .car-type {
        position: absolute;
        top: 12px;
        left: 12px;
        padding: 6px 11px;
        border-radius: 20px;
        background: white;
        color: #D97706;
        font-size: 11px;
        font-weight: 700;
    }

    .car-card-body { padding: 12px 17px 18px; }
    .car-card-body h3 { margin: 0 0 7px; color: #202A35; font-size: 18px; }
    .car-transmission { margin: 0 0 16px; color: #6B7280; font-size: 12px; }

    .car-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding-top: 15px;
        border-top: 1px solid #E5E7EB;
    }

    .car-price { color: #F28C28; font-size: 17px; font-weight: 800; }
    .car-price small { display: block; margin-top: 3px; color: #9CA3AF; font-size: 11px; font-weight: 500; }

    .car-detail-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 13px;
        border-radius: 8px;
        background: #FFF0DF;
        color: #D97706;
        font-size: 12px;
        font-weight: 700;
        transition: background .2s, color .2s, transform .15s;
    }

    .car-detail-btn:hover { background: #F28C28; color: white; }
    .car-detail-btn:active { transform: scale(.94); }

    .empty-cars {
        grid-column: 1 / -1;
        padding: 55px 20px;
        background: #F5F6F8;
        border: 1px dashed #D1D5DB;
        border-radius: 16px;
        text-align: center;
    }

    .empty-cars h3 { margin: 12px 0 7px; color: #202A35; }
    .empty-cars p { margin: 0; color: #6B7280; font-size: 13px; }

    /* ---------- ABOUT STORE ---------- */

    .about-section { margin-top: 75px; }

    .about-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-bottom: 22px;
    }

    .stat-box {
        padding: 22px;
        background: #FFF0DF;
        border-radius: 14px;
        text-align: center;
    }

    .stat-number { display: block; color: #F28C28; font-size: 34px; font-weight: 800; letter-spacing: -1px; }
    .stat-label { display: block; margin-top: 4px; color: #6B7280; font-size: 12px; font-weight: 600; }

    .about-card {
        display: grid;
        grid-template-columns: 230px 1fr;
        overflow: hidden;
        background: white;
        border: 1px solid #E5E7EB;
        border-radius: 16px;
    }

    .about-tabs { display: flex; flex-direction: column; padding: 14px; gap: 6px; background: #F5F6F8; }

    .about-tab {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 13px 14px;
        border: 0;
        border-radius: 10px;
        background: transparent;
        color: #6B7280;
        font: inherit;
        font-size: 14px;
        font-weight: 700;
        text-align: left;
        cursor: pointer;
        transition: background .2s, color .2s, transform .15s;
    }

    .about-tab:hover { color: #D97706; }
    .about-tab:active { transform: scale(.96); }
    .about-tab.active { background: white; color: #F28C28; box-shadow: 0 3px 10px rgba(32,42,53,0.07); }

    .about-panels { padding: 30px 34px; }
    .about-panel { display: none; }
    .about-panel.active { display: block; animation: panel-in .35s ease both; }
    .about-panel h3 { margin: 0 0 12px; color: #202A35; font-size: 21px; letter-spacing: -.4px; }
    .about-panel p { max-width: 560px; margin: 0 0 14px; color: #6B7280; font-size: 14px; line-height: 1.8; }

    .about-list { list-style: none; margin: 0; padding: 0; display: grid; gap: 10px; }

    .about-list li {
        display: flex;
        gap: 10px;
        align-items: flex-start;
        color: #202A35;
        font-size: 14px;
        line-height: 1.6;
    }

    .about-list li::before {
        content: "✓";
        flex-shrink: 0;
        width: 22px;
        height: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #FFF0DF;
        color: #F28C28;
        font-size: 12px;
        font-weight: 800;
    }

    /* ---------- FAQ ---------- */

    .faq-section { margin-top: 70px; }
    .faq-list { display: grid; gap: 12px; max-width: 820px; }

    .faq-item { background: white; border: 1px solid #E5E7EB; border-radius: 14px; transition: border-color .2s; }
    .faq-item.open { border-color: #F6C28E; }

    .faq-question {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 18px 20px;
        border: 0;
        background: transparent;
        color: #202A35;
        font: inherit;
        font-size: 14px;
        font-weight: 700;
        text-align: left;
        cursor: pointer;
    }

    .faq-icon {
        flex-shrink: 0;
        width: 26px;
        height: 26px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #FFF0DF;
        color: #F28C28;
        font-size: 16px;
        transition: transform .3s, background .2s, color .2s;
    }

    .faq-item.open .faq-icon { transform: rotate(45deg); background: #F28C28; color: white; }

    .faq-answer { display: grid; grid-template-rows: 0fr; transition: grid-template-rows .3s ease; }
    .faq-item.open .faq-answer { grid-template-rows: 1fr; }
    .faq-answer > div { overflow: hidden; }
    .faq-answer p { margin: 0; padding: 0 20px 18px; color: #6B7280; font-size: 13px; line-height: 1.8; }


    /* ---------- KALKULATOR ---------- */

    .estimator-section { margin-top: 70px; }

    .estimator-card {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        overflow: hidden;
        background: white;
        border: 1px solid #E5E7EB;
        border-radius: 16px;
    }

    .estimator-form { display: grid; gap: 18px; padding: 30px 34px; }
    .field label { display: block; margin-bottom: 8px; color: #202A35; font-size: 13px; font-weight: 700; }

    .field select {
        width: 100%;
        padding: 13px 14px;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        background: white;
        color: #202A35;
        font: inherit;
        font-size: 14px;
    }

    .field select:focus { outline: 2px solid #F28C28; outline-offset: 1px; border-color: #F28C28; }

    .stepper { display: inline-flex; align-items: center; border: 1px solid #E5E7EB; border-radius: 10px; overflow: hidden; }

    .stepper button {
        width: 44px;
        height: 44px;
        border: 0;
        background: #FFF0DF;
        color: #D97706;
        font-size: 20px;
        font-weight: 700;
        cursor: pointer;
        transition: background .2s, color .2s, transform .15s;
    }

    .stepper button:hover { background: #F28C28; color: white; }
    .stepper button:active { transform: scale(.88); }
    .stepper output { min-width: 80px; text-align: center; color: #202A35; font-size: 15px; font-weight: 800; }

    .estimator-result {
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 6px;
        padding: 30px 34px;
        background: #202A35;
    }

    .estimator-result small { color: #CBD5E1; font-size: 12px; }
    .estimator-total { color: white; font-size: 32px; font-weight: 800; letter-spacing: -1px; transition: color .3s; }
    .estimator-total.bump { color: #F28C28; }
    .estimator-note { margin: 0 0 14px; color: #CBD5E1; font-size: 12px; line-height: 1.6; }
    .estimator-result .btn { align-self: flex-start; }

    /* ---------- KONTAK ---------- */

    .contact-section { margin-top: 70px; }
    .contact-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }

    .contact-card {
        display: flex;
        flex-direction: column;
        gap: 6px;
        padding: 22px;
        background: white;
        border: 1px solid #E5E7EB;
        border-radius: 14px;
        color: inherit;
        text-decoration: none;
        transition: transform .2s, border-color .2s, box-shadow .2s;
    }

    a.contact-card:hover { transform: translateY(-4px); border-color: #F6C28E; box-shadow: 0 10px 22px rgba(32,42,53,0.08); }
    a.contact-card:active { transform: scale(.97); }
    .contact-card .benefit-icon { margin-bottom: 8px; }
    .contact-card h4 { margin: 0; color: #202A35; font-size: 14px; }
    .contact-card p { margin: 0; color: #6B7280; font-size: 13px; line-height: 1.6; }

    /* ---------- MELAYANG ---------- */

    .scroll-progress {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 9998;
        width: 100%;
        height: 3px;
        background: #F28C28;
        transform: scaleX(0);
        transform-origin: left;
    }

    .fab-stack { position: fixed; right: 20px; bottom: 20px; z-index: 900; display: flex; flex-direction: column; align-items: flex-end; gap: 10px; }

    .fab {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        height: 48px;
        padding: 0 18px;
        border: 0;
        border-radius: 30px;
        background: #F28C28;
        color: white;
        font: inherit;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 8px 20px rgba(242,140,40,0.35);
        cursor: pointer;
        transition: transform .2s, background .2s, opacity .3s;
    }

    .fab:hover { background: #E47713; transform: translateY(-2px); color: white; }
    .fab:active { transform: scale(.94); }
    .fab.top { width: 48px; padding: 0; background: #202A35; box-shadow: 0 8px 20px rgba(32,42,53,0.25); opacity: 0; pointer-events: none; }
    .fab.top.on { opacity: 1; pointer-events: auto; }
    .fab.top:hover { background: #2b3745; }

    /* ---------- CTA ---------- */

    .home-cta {
        position: relative;
        overflow: hidden;
        margin-top: 70px;
        padding: 45px 40px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 25px;
        background: #202A35;
        border-radius: 18px;
    }

    .home-cta h2 { margin: 0 0 10px; color: white; font-size: 27px; }
    .home-cta p { margin: 0; color: #CBD5E1; font-size: 14px; line-height: 1.6; }
    .home-cta .btn { flex-shrink: 0; }

    /* ---------- CLICK EFFECTS ---------- */

    .btn, .car-detail-btn, .filter-chip { position: relative; overflow: hidden; }
    .fab, .stepper button { position: relative; overflow: hidden; }
    .btn:active { transform: scale(.96); }

    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.55);
        transform: scale(0);
        pointer-events: none;
        animation: ripple .6s ease-out forwards;
    }

    .filter-chip:not(.active) .ripple { background: rgba(242,140,40,0.25); }
    .car-detail-btn:not(:hover) .ripple { background: rgba(242,140,40,0.3); }

    .click-spark {
        position: fixed;
        z-index: 9999;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #F28C28;
        pointer-events: none;
        animation: spark .6s ease-out forwards;
    }

    /* ---------- SCROLL REVEAL ---------- */

    .js .reveal { opacity: 0; transform: translateY(22px); transition: opacity .6s ease, transform .6s ease; }
    .js .reveal.visible { opacity: 1; transform: none; }

    /* ==============================
       TEMA GRADASI & LATAR
       (tetap memakai oranye #F28C28 dan navy #202A35)
    ============================== */

    /* Latar halaman: cahaya oranye lembut di sudut, tetap di tempat saat scroll */
    .home-page::before {
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

    /* Hero: gambar anime berada di depan latar halaman, tanpa campuran gradasi */
    .hero-section {
        /* Atur transparansi gambar anime: 1 = jelas penuh, 0 = hilang */
        --anime-opacity: 0.35;
        background: transparent;
        box-shadow: 0 14px 34px rgba(32,42,53,0.10);
    }

    /* Gambar anime dipasang di lapisan sendiri agar benar-benar transparan */
    .hero-section::before {
        content: "";
        position: absolute;
        inset: 0;
        z-index: -1;
        background: url('/images/remie_bg.jpg') center / cover no-repeat;
        opacity: var(--anime-opacity);
        border-radius: inherit;
        pointer-events: none;
    }

    .hero-label { background: linear-gradient(135deg, #FFF0DF, #FFD3E0); }

    .hero-content h1 span {
        background: linear-gradient(100deg, #F28C28 0%, #F7857F 50%, #EE6A93 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        color: #F28C28;
    }

    .hero-image::before { background: radial-gradient(circle at 35% 30%, #FFF3F6 0%, #FFDCE6 48%, #FFC3D4 100%); }

    /* Tombol utama bergradasi (tidak mengubah tombol .secondary) */
    .hero-actions .btn:not(.secondary),
    .home-cta .btn,
    .estimator-result .btn {
        background: linear-gradient(135deg, #F7A04A 0%, #F5817A 55%, #EE6A93 100%);
        background-size: 200% 200%;
        background-position: 0% 50%;
        color: white;
        border: 0;
        box-shadow: 0 8px 20px rgba(238,106,147,0.30);
        transition: background-position .5s ease, transform .15s, box-shadow .2s;
    }

    .hero-actions .btn:not(.secondary):hover,
    .home-cta .btn:hover,
    .estimator-result .btn:hover {
        background-position: 100% 50%;
        box-shadow: 0 12px 26px rgba(238,106,147,0.40);
    }

    /* Ikon & kartu */
    .benefit-icon { background: linear-gradient(135deg, #FFF0DF, #FFD6E2); }
    .benefit-item:hover { background: linear-gradient(135deg, #FFFFFF, #FFF5F8); }

    .car-image-wrapper { background: linear-gradient(145deg, #F5F6F8 0%, #FFEEF3 100%); }
    .home-car-card:hover { background: linear-gradient(180deg, #FFFFFF 60%, #FFF7FA 100%); }

    .car-price {
        background: linear-gradient(100deg, #F28C28, #EE6A93);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .car-price small { -webkit-text-fill-color: #9CA3AF; }

    .car-detail-btn { background: linear-gradient(135deg, #FFF0DF, #FFDCE6); }
    .car-detail-btn:hover { background: linear-gradient(135deg, #F7A04A, #F5817A 60%, #EE6A93); color: white; }

    .filter-chip.active { background: linear-gradient(135deg, #F7A04A, #F5817A 60%, #EE6A93); }

    /* Bagian tentang: panel bergradasi supaya terasa sebagai blok sendiri */
    .about-section {
        padding: 36px;
        border-radius: 22px;
        background:
            radial-gradient(420px 260px at 100% 0%, rgba(255,143,171,0.22), transparent 70%),
            linear-gradient(160deg, #FFF8F4 0%, #FFE6EE 100%);
    }

    .stat-box { background: linear-gradient(145deg, #FFFFFF 0%, #FFE3EC 100%); border: 1px solid #FFD3E0; }
    .about-tabs { background: linear-gradient(180deg, #F5F6F8, #FFEEF3); }

    /* Kalkulator & CTA: navy bergradasi dengan cahaya oranye */
    .estimator-result {
        background:
            radial-gradient(300px 220px at 100% 0%, rgba(242,140,40,0.35), transparent 70%),
            linear-gradient(160deg, #2B3745 0%, #202A35 60%, #18202A 100%);
    }

    .home-cta {
        background:
            radial-gradient(420px 260px at 100% 0%, rgba(242,140,40,0.38), transparent 70%),
            radial-gradient(300px 200px at 0% 100%, rgba(255,143,171,0.25), transparent 70%),
            linear-gradient(135deg, #2B3745 0%, #202A35 55%, #18202A 100%);
        box-shadow: 0 18px 40px rgba(32,42,53,0.22);
    }

    .faq-item.open { background: linear-gradient(180deg, #FFFFFF, #FFF7FA); }
    .faq-item.open .faq-icon { background: linear-gradient(135deg, #F7A04A, #EE6A93); }

    /* Tombol melayang & progress */
    .scroll-progress { background: linear-gradient(90deg, #F28C28, #F5817A, #EE6A93); }
    .fab:not(.top) { background: linear-gradient(135deg, #F7A04A, #F5817A 55%, #EE6A93); }
    .fab.top { background: linear-gradient(135deg, #2B3745, #202A35); }

    /* ---- Kotak putih untuk gambar kendaraan ---- */
    .hero-section { isolation: isolate; }

    .hero-image { z-index: auto; perspective: none; }
    .hero-image::before { display: none; }

    .hero-image img {
        background: #FFFFFF;
        border-radius: 60px;
        padding: 14px;
        mix-blend-mode: normal;
        -webkit-mask-image: none;
        mask-image: none;
        filter: brightness(1.07);
        box-shadow: 0 18px 40px rgba(32,42,53,0.18);
    }

    @keyframes ripple { to { transform: scale(4); opacity: 0; } }
    @keyframes spark { to { transform: translate(var(--dx), var(--dy)) scale(0); opacity: 0; } }
    @keyframes spin-slow { to { transform: rotate(360deg); } }
    @keyframes pulse-ring { 0%,100% { transform: scale(1); } 50% { transform: scale(1.07); } }
    @keyframes car-in { from { opacity: 0; transform: translateX(60px); } to { opacity: 1; transform: none; } }
    @keyframes icon-pop { 0% { transform: scale(1); } 40% { transform: scale(1.3) rotate(-8deg); } 100% { transform: scale(1); } }
    @keyframes card-in { from { opacity: 0; transform: translateY(14px) scale(.97); } to { opacity: 1; transform: none; } }
    @keyframes panel-in { from { opacity: 0; transform: translateX(14px); } to { opacity: 1; transform: none; } }

    /* ---------- FOCUS & MOTION ---------- */

    .filter-chip:focus-visible, .about-tab:focus-visible, .faq-question:focus-visible, .benefit-item:focus-visible {
        outline: 2px solid #F28C28;
        outline-offset: 2px;
    }

    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after { animation: none !important; transition: none !important; }
        .js .reveal { opacity: 1; transform: none; }
    }

    /* ---------- RESPONSIVE ---------- */

    @media(max-width: 900px) {
        .hero-section { padding: 35px; gap: 10px; }
        .hero-image img { width: 110%; }
        .home-car-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .benefit-section { gap: 10px; }
        .benefit-item { padding: 14px; }
        .about-card { grid-template-columns: 1fr; }
        .estimator-card { grid-template-columns: 1fr; }
        .contact-grid { grid-template-columns: 1fr; }
        .about-tabs { flex-direction: row; overflow-x: auto; }
        .about-tab { white-space: nowrap; }
    }

    @media(max-width: 650px) {
        .hero-section { grid-template-columns: 1fr; padding: 30px 23px; }
        .hero-content h1 { font-size: 35px; }
        .hero-image { min-height: 220px; }
        .hero-image::before { width: 230px; height: 230px; }
        .hero-image img { width: 100%; max-height: 230px; }
        .benefit-section { grid-template-columns: 1fr; margin-bottom: 45px; }
        .home-car-grid { grid-template-columns: 1fr; }
        .section-heading h2 { font-size: 22px; }
        .about-stats { grid-template-columns: 1fr; }
        .estimator-form, .estimator-result { padding: 24px 20px; }
        .fab span.fab-label { display: none; }
        .fab { padding: 0; width: 48px; }
        .about-panels { padding: 24px 20px; }
        .home-cta { flex-direction: column; align-items: flex-start; padding: 30px 24px; }
        .home-cta h2 { font-size: 23px; }
    }
</style>
@endpush


@section('content')

<div class="home-page">

    {{-- ==========================
         HERO SECTION
    =========================== --}}

    <section class="hero-section">

        <div class="hero-content">

            <span class="hero-label">
                <span class="spark">✦</span> RENTAL KENDARAAN TERPERCAYA
            </span>

            <h1>
                Perjalanan Lebih Mudah,
                <span>Kendaraan Terbaik</span>
                Untukmu.
            </h1>

            <p>
                Temukan kendaraan yang sesuai dengan kebutuhan perjalananmu.
                Pilihan kendaraan berkualitas, harga transparan, dan proses
                pemesanan yang praktis.
            </p>

            <div class="hero-actions">

                <a href="{{ route('armada.index') }}" class="btn">
                    Jelajahi Kendaraan &nbsp; →
                </a>

                @if(!session('role'))
                    <a href="{{ route('register') }}" class="btn secondary">
                        Buat Akun
                    </a>
                @endif

            </div>

        </div>


        {{-- Gambar kendaraan dari database --}}

        <div class="hero-image" id="heroImage">

            @if($armadas->first() && !empty($armadas->first()->gambar))

                <img
                    src="{{ $armadas->first()->gambar }}"
                    alt="{{ $armadas->first()->nama_kendaraan }}"
                    referrerpolicy="no-referrer"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                >

                <div class="hero-image-placeholder" style="display:none;">
                    Gambar kendaraan tidak tersedia
                </div>

            @else

                <div class="hero-image-placeholder">
                    🚘 &nbsp; DriveEase
                </div>

            @endif

        </div>

    </section>


    {{-- ==========================
         BENEFIT SECTION
    =========================== --}}

    <section class="benefit-section reveal">

        <div class="benefit-item" tabindex="0">
            <div class="benefit-icon">🚘</div>
            <div>
                <h4>Pilihan Kendaraan</h4>
                <p>Beragam kendaraan sesuai kebutuhanmu.</p>
            </div>
        </div>

        <div class="benefit-item" tabindex="0">
            <div class="benefit-icon">💰</div>
            <div>
                <h4>Harga Transparan</h4>
                <p>Informasi harga sewa yang jelas.</p>
            </div>
        </div>

        <div class="benefit-item" tabindex="0">
            <div class="benefit-icon">🛡️</div>
            <div>
                <h4>Pemesanan Mudah</h4>
                <p>Pesan kendaraan melalui website.</p>
            </div>
        </div>

    </section>


    {{-- ==========================
         POPULAR CARS
    =========================== --}}

    <section class="cars-section reveal">

        <div class="section-heading">

            <div>
                <h2>Pilihan Kendaraan Kami</h2>
                <p>Temukan kendaraan yang tepat untuk perjalananmu.</p>
            </div>

            <a href="{{ route('armada.index') }}" class="section-link">
                Lihat Semua Kendaraan →
            </a>

        </div>

        {{-- Filter & Search bar --}}
        @php
            $tipeList = $armadas->pluck('tipe')->filter()->unique()->values();
        @endphp

        @if($armadas->count())
            <div class="cars-toolbar">
                @if($tipeList->count() > 1)
                    <div class="filter-bar" id="filterBar">
                        <button type="button" class="filter-chip active" data-filter="all">Semua</button>
                        @foreach($tipeList as $tipe)
                            <button type="button" class="filter-chip" data-filter="{{ $tipe }}">{{ $tipe }}</button>
                        @endforeach
                    </div>
                @endif

                <div class="home-search-wrap">
                    <span class="home-search-icon">🔍</span>
                    <input
                        type="search"
                        id="homeCarSearch"
                        class="home-search-input"
                        placeholder="Cari mobil, tipe, transmisi..."
                        aria-label="Cari kendaraan"
                    >
                    <button type="button" id="homeSearchClear" class="home-search-clear" aria-label="Hapus pencarian">✕</button>
                </div>
            </div>
        @endif


        <div class="home-car-grid" id="carGrid">

            @forelse($armadas as $a)

                <article
                    class="home-car-card"
                    data-tipe="{{ $a->tipe ?: 'Kendaraan' }}"
                    data-search="{{ strtolower(trim(($a->nama_kendaraan ?? '') . ' ' . ($a->tipe ?? '') . ' ' . ($a->transmisi ?? ''))) }}"
                >

                    <div class="car-image-wrapper">

                        <span class="car-type">
                            {{ $a->tipe ?: 'Kendaraan' }}
                        </span>

                        @if(!empty($a->gambar))

                            <img
                                src="{{ $a->gambar }}"
                                alt="{{ $a->nama_kendaraan }}"
                                loading="lazy"
                                referrerpolicy="no-referrer"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            >

                            <div
                                style="display:none; width:100%; height:100%; align-items:center; justify-content:center; color:#9CA3AF; font-size:13px;"
                            >
                                Gambar gagal dimuat
                            </div>

                        @else

                            <div style="color:#9CA3AF; font-size:13px;">
                                Gambar belum tersedia
                            </div>

                        @endif

                    </div>


                    <div class="car-card-body">

                        <h3>{{ $a->nama_kendaraan }}</h3>

                        <p class="car-transmission">
                            ⚙ Transmisi:
                            {{ $a->transmisi ?: 'Belum diisi' }}
                        </p>


                        <div class="car-card-footer">

                            <div class="car-price">

                                Rp{{ number_format($a->harga_sewa, 0, ',', '.') }}

                                <small>Per hari</small>

                            </div>


                            @if(session('role') === 'customer')

                                <a href="{{ route('booking.create', $a->id_armada) }}" class="car-detail-btn">
                                    Pesan Sekarang
                                </a>

                            @else

                                <a href="{{ route('armada.index') }}" class="car-detail-btn">
                                    Lihat Kendaraan
                                </a>

                            @endif

                        </div>

                    </div>

                </article>

            @empty

                <div class="empty-cars">

                    <div style="font-size:40px;">🚘</div>

                    <h3>Belum Ada Mobil Tersedia</h3>

                    <p>
                        Silakan kunjungi kembali halaman ini
                        untuk melihat pilihan kendaraan kami.
                    </p>

                </div>

            @endforelse

            <div class="empty-cars" id="homeSearchEmpty" style="display:none;">
                <div style="font-size:36px;">🔍</div>
                <h3>Kendaraan Tidak Ditemukan</h3>
                <p>Coba kata kunci lain atau pilih kategori lainnya.</p>
            </div>

        </div>

    </section>


    {{-- ==========================
         TENTANG TOKO
    =========================== --}}

    <section class="about-section reveal" id="tentang">

        <div class="section-heading">
            <div>
                <h2>Kenali DriveEase</h2>
                <p>Rental kendaraan yang mengutamakan kemudahan dan kejelasan.</p>
            </div>
        </div>

        <div class="about-stats">
            <div class="stat-box">
                <span class="stat-number" data-count="{{ $armadas->count() }}">0</span>
                <span class="stat-label">Kendaraan siap disewa</span>
            </div>
            <div class="stat-box">
                <span class="stat-number" data-count="3">0</span>
                <span class="stat-label">Langkah menuju pemesanan</span>
            </div>
            <div class="stat-box">
                <span class="stat-number" data-count="24" data-suffix=" jam">0</span>
                <span class="stat-label">Pemesanan online kapan saja</span>
            </div>
        </div>

        <div class="about-card">

            <div class="about-tabs" role="tablist">
                <button type="button" class="about-tab active" role="tab" data-tab="tentang">🏢 Tentang Kami</button>
                <button type="button" class="about-tab" role="tab" data-tab="layanan">🔧 Layanan</button>
                <button type="button" class="about-tab" role="tab" data-tab="cara">🧭 Cara Memesan</button>
            </div>

            <div class="about-panels">

                <div class="about-panel active" id="tab-tentang" role="tabpanel">
                    <h3>Kendaraan yang tepat, tanpa ribet</h3>
                    <p>
                        DriveEase adalah layanan rental kendaraan yang membantu kamu
                        menemukan kendaraan sesuai kebutuhan perjalanan. Semua informasi
                        harga dan jenis kendaraan ditampilkan jelas di website, sehingga
                        kamu bisa membandingkan sebelum memesan.
                    </p>
                </div>

                <div class="about-panel" id="tab-layanan" role="tabpanel">
                    <h3>Yang kamu dapatkan</h3>
                    <ul class="about-list">
                        <li>Pilihan kendaraan dengan berbagai tipe dan transmisi.</li>
                        <li>Harga sewa per hari yang tertera jelas.</li>
                        <li>Pemesanan langsung dari website tanpa antre.</li>
                    </ul>
                </div>

                <div class="about-panel" id="tab-cara" role="tabpanel">
                    <h3>Pesan dalam 3 langkah</h3>
                    <ul class="about-list">
                        <li>Buat akun atau masuk ke akunmu.</li>
                        <li>Pilih kendaraan dan klik “Pesan Sekarang”.</li>
                        <li>Isi data pemesanan, lalu kirim.</li>
                    </ul>
                </div>

            </div>

        </div>

    </section>


    {{-- ==========================
         FAQ
    =========================== --}}

    <section class="faq-section reveal">

        <div class="section-heading">
            <div>
                <h2>Pertanyaan yang sering diajukan</h2>
                <p>Klik pertanyaan untuk melihat jawabannya.</p>
            </div>
        </div>

        <div class="faq-list">

            <div class="faq-item">
                <button type="button" class="faq-question" aria-expanded="false">
                    Bagaimana cara memesan kendaraan?
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer"><div>
                    <p>Masuk ke akun customer, pilih kendaraan yang kamu inginkan, lalu klik tombol Pesan Sekarang dan lengkapi data pemesanan.</p>
                </div></div>
            </div>

            <div class="faq-item">
                <button type="button" class="faq-question" aria-expanded="false">
                    Apakah harga sewa sudah jelas?
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer"><div>
                    <p>Ya. Harga sewa per hari ditampilkan di setiap kartu kendaraan sebelum kamu memesan.</p>
                </div></div>
            </div>

            <div class="faq-item">
                <button type="button" class="faq-question" aria-expanded="false">
                    Apakah saya harus punya akun?
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer"><div>
                    <p>Kamu bisa melihat daftar kendaraan tanpa akun. Untuk memesan, silakan buat akun terlebih dahulu.</p>
                </div></div>
            </div>

        </div>

    </section>


    {{-- ==========================
         KALKULATOR HARGA SEWA
    =========================== --}}

    @php
        $estimatorArmadas = $allArmadas ?? $armadas;
    @endphp

    @if($estimatorArmadas->count())
    <section class="estimator-section reveal">

        <div class="section-heading">
            <div>
                <h2>Hitung Estimasi Sewa</h2>
                <p>Pilih kendaraan dan lama sewa, total langsung terlihat.</p>
            </div>
        </div>

        <div class="estimator-card">

            <div class="estimator-form">

                <div class="field">
                    <label for="estCar">Kendaraan</label>
                    <select id="estCar">
                        @foreach($estimatorArmadas as $a)
                            <option
                                value="{{ (int) $a->harga_sewa }}"
                                data-url="{{ session('role') === 'customer' ? route('booking.create', $a->id_armada) : route('armada.index') }}"
                            >
                                {{ $a->nama_kendaraan }} - Rp{{ number_format($a->harga_sewa, 0, ',', '.') }}/hari
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label>Lama sewa</label>
                    <div class="stepper">
                        <button type="button" id="estMinus" aria-label="Kurangi hari">−</button>
                        <output id="estDays">1 hari</output>
                        <button type="button" id="estPlus" aria-label="Tambah hari">+</button>
                    </div>
                </div>

            </div>

            <div class="estimator-result">
                <small>Estimasi total</small>
                <div class="estimator-total" id="estTotal">Rp0</div>
                <p class="estimator-note">Perkiraan berdasarkan harga sewa per hari.</p>
                <a href="#" class="btn" id="estLink">
                    {{ session('role') === 'customer' ? 'Pesan Kendaraan Ini' : 'Lihat Kendaraan' }}
                </a>
            </div>

        </div>

    </section>
    @endif


    {{-- ==========================
         KONTAK & LOKASI
         (ubah data di bawah ini sesuai toko kamu)
    =========================== --}}

    @php
        $kontak = [
            'whatsapp' => '6281234567890',
            'alamat'   => 'Jl. Contoh No. 1, Yogyakarta',
            'jam'      => 'Setiap hari, 08.00 - 20.00 WIB',
        ];
    @endphp

    <section class="contact-section reveal" id="kontak">

        <div class="section-heading">
            <div>
                <h2>Hubungi & Kunjungi Kami</h2>
                <p>Ada pertanyaan sebelum memesan? Kami siap membantu.</p>
            </div>
        </div>

        <div class="contact-grid">

            <a class="contact-card" href="https://wa.me/{{ $kontak['whatsapp'] }}" target="_blank" rel="noopener">
                <div class="benefit-icon">💬</div>
                <h4>WhatsApp</h4>
                <p>Klik untuk chat langsung dengan kami.</p>
            </a>

            <a class="contact-card" href="https://www.google.com/maps/search/?api=1&query={{ urlencode($kontak['alamat']) }}" target="_blank" rel="noopener">
                <div class="benefit-icon">📍</div>
                <h4>Lokasi</h4>
                <p>{{ $kontak['alamat'] }}</p>
            </a>

            <div class="contact-card">
                <div class="benefit-icon">🕘</div>
                <h4>Jam Operasional</h4>
                <p>{{ $kontak['jam'] }}</p>
            </div>

        </div>

    </section>


    {{-- Tombol melayang --}}
    <div class="scroll-progress" id="scrollProgress"></div>

    <div class="fab-stack">
        <button type="button" class="fab top" id="toTop" aria-label="Kembali ke atas">↑</button>
        <a class="fab" href="https://wa.me/{{ $kontak['whatsapp'] }}" target="_blank" rel="noopener">
            💬 <span class="fab-label">Tanya via WhatsApp</span>
        </a>
    </div>


    {{-- ==========================
         CALL TO ACTION
    =========================== --}}

    <section class="home-cta reveal">

        <div>
            <h2>Siap Memulai Perjalananmu?</h2>
            <p>
                Temukan mobil yang sesuai dengan kebutuhanmu
                dan lakukan pemesanan sekarang.
            </p>
        </div>

        <a href="{{ route('armada.index') }}" class="btn">
            Mulai Sewa Mobil →
        </a>

    </section>

</div>

@endsection


@push('scripts')
<script>
(function () {
    document.documentElement.classList.add('js');
    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ---- Ripple + percikan saat klik tombol ---- */
    document.addEventListener('click', function (e) {
        var el = e.target.closest('.btn, .car-detail-btn, .filter-chip, .fab, .stepper button');
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

        for (var i = 0; i < 6; i++) {
            var s = document.createElement('span');
            var angle = (Math.PI * 2 * i) / 6;
            s.className = 'click-spark';
            s.style.left = e.clientX + 'px';
            s.style.top = e.clientY + 'px';
            s.style.setProperty('--dx', Math.cos(angle) * 28 + 'px');
            s.style.setProperty('--dy', Math.sin(angle) * 28 + 'px');
            document.body.appendChild(s);
            setTimeout((function (n) { return function () { n.remove(); }; })(s), 650);
        }
    });

    /* ---- Benefit: ikon memantul saat diklik ---- */
    document.querySelectorAll('.benefit-item').forEach(function (item) {
        item.addEventListener('click', function () {
            item.classList.remove('pop');
            void item.offsetWidth;
            item.classList.add('pop');
        });
    });
    
    /* ---- Gambar hero mengikuti kursor ---- */
    var hero = document.getElementById('heroImage');
    var heroImg = hero && hero.querySelector('img');
    if (heroImg && !reduce) {
        hero.addEventListener('mousemove', function (e) {
            var b = hero.getBoundingClientRect();
            var x = (e.clientX - b.left) / b.width - 0.5;
            var y = (e.clientY - b.top) / b.height - 0.5;
            heroImg.style.transform = 'perspective(800px) rotateY(' + (x * 8) + 'deg) rotateX(' + (-y * 6) + 'deg) scale(1.03)';
        });
        hero.addEventListener('mouseleave', function () { heroImg.style.transform = ''; });
    }

    /* ---- Filter & pencarian kendaraan ---- */
    var bar = document.getElementById('filterBar');
    var homeSearch = document.getElementById('homeCarSearch');
    var homeClear = document.getElementById('homeSearchClear');
    var homeEmpty = document.getElementById('homeSearchEmpty');
    var homeCards = document.querySelectorAll('#carGrid .home-car-card');
    var activeFilter = 'all';

    function applyHomeFilter() {
        var q = homeSearch ? homeSearch.value.trim().toLowerCase() : '';
        if (homeClear) homeClear.classList.toggle('show', q.length > 0);

        var shown = 0;
        homeCards.forEach(function (card) {
            var matchTipe = activeFilter === 'all' || card.getAttribute('data-tipe') === activeFilter;
            var text = card.getAttribute('data-search') || '';
            var matchQuery = q === '' || text.indexOf(q) !== -1;
            var match = matchTipe && matchQuery;

            card.classList.toggle('hide', !match);
            card.classList.remove('show');
            if (match) {
                shown++;
                void card.offsetWidth;
                card.classList.add('show');
            }
        });

        if (homeEmpty) {
            homeEmpty.style.display = (homeCards.length > 0 && shown === 0) ? '' : 'none';
        }
    }

    if (bar) {
        bar.addEventListener('click', function (e) {
            var chip = e.target.closest('.filter-chip');
            if (!chip) return;
            bar.querySelectorAll('.filter-chip').forEach(function (c) { c.classList.remove('active'); });
            chip.classList.add('active');
            activeFilter = chip.getAttribute('data-filter');
            applyHomeFilter();
        });
    }

    if (homeSearch) {
        homeSearch.addEventListener('input', applyHomeFilter);
        if (homeClear) {
            homeClear.addEventListener('click', function () {
                homeSearch.value = '';
                applyHomeFilter();
                homeSearch.focus();
            });
        }
    }

    /* ---- Tab tentang toko ---- */
    document.querySelectorAll('.about-tab').forEach(function (tab) {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.about-tab').forEach(function (t) { t.classList.remove('active'); });
            document.querySelectorAll('.about-panel').forEach(function (p) { p.classList.remove('active'); });
            tab.classList.add('active');
            document.getElementById('tab-' + tab.getAttribute('data-tab')).classList.add('active');
        });
    });

    /* ---- FAQ accordion ---- */
    document.querySelectorAll('.faq-question').forEach(function (q) {
        q.addEventListener('click', function () {
            var item = q.parentElement;
            var open = item.classList.toggle('open');
            q.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    });

    /* ---- Angka statistik naik saat terlihat ---- */
    function countUp(el) {
        var target = parseInt(el.getAttribute('data-count'), 10) || 0;
        var suffix = el.getAttribute('data-suffix') || '';
        if (reduce || target === 0) { el.textContent = target + suffix; return; }
        var start = null;
        function step(t) {
            if (!start) start = t;
            var p = Math.min((t - start) / 1000, 1);
            el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3))) + suffix;
            if (p < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    }

    /* ---- Muncul saat di-scroll ---- */
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (!en.isIntersecting) return;
                en.target.classList.add('visible');
                en.target.querySelectorAll('[data-count]').forEach(countUp);
                io.unobserve(en.target);
            });
        }, { threshold: 0.12 });
        document.querySelectorAll('.reveal').forEach(function (el) { io.observe(el); });
    } else {
        document.querySelectorAll('.reveal').forEach(function (el) { el.classList.add('visible'); });
        document.querySelectorAll('[data-count]').forEach(countUp);
    }

    /* ---- Kalkulator sewa ---- */
    var estCar = document.getElementById('estCar');
    if (estCar) {
        var days = 1, estDays = document.getElementById('estDays'),
            estTotal = document.getElementById('estTotal'), estLink = document.getElementById('estLink');
        function rupiah(n) { return 'Rp' + n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.'); }
        function updateEst() {
            var opt = estCar.options[estCar.selectedIndex];
            estDays.textContent = days + ' hari';
            estTotal.textContent = rupiah(parseInt(estCar.value, 10) * days);
            estLink.setAttribute('href', opt.getAttribute('data-url'));
            estTotal.classList.add('bump');
            setTimeout(function () { estTotal.classList.remove('bump'); }, 250);
        }
        document.getElementById('estMinus').addEventListener('click', function () { if (days > 1) { days--; updateEst(); } });
        document.getElementById('estPlus').addEventListener('click', function () { if (days < 60) { days++; updateEst(); } });
        estCar.addEventListener('change', updateEst);
        updateEst();
    }

    /* ---- Progress scroll & tombol ke atas ---- */
    var bar2 = document.getElementById('scrollProgress'), topBtn = document.getElementById('toTop');
    function onScroll() {
        var h = document.documentElement.scrollHeight - window.innerHeight;
        var pct = h > 0 ? window.scrollY / h : 0;
        if (bar2) bar2.style.transform = 'scaleX(' + pct + ')';
        if (topBtn) topBtn.classList.toggle('on', window.scrollY > 500);
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
    if (topBtn) topBtn.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: reduce ? 'auto' : 'smooth' });
    });
})();
</script>
@endpush
