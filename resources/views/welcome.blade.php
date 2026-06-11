<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistem Informasi Pemetaan Keterampilan Desa</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        /* ===============================
       WARNA DASAR TEMA DESA / NATURAL
    =============================== */
        :root {
            --primary: #2f855a;
            --primary-dark: #276749;
            --secondary: #68d391;
            --light-bg: #f4fbf6;
            --text-dark: #1f2937;
            --text-muted: #6b7280;
            --white: #ffffff;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --radius: 18px;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-dark);
            background-color: #f8faf8;
        }

        /* =========================================================
       GLOBAL SAFETY / RESPONSIVE BASE
       - Mencegah overflow horizontal
       - Menjaga media tetap proporsional
    ========================================================= */
        html,
        body {
            overflow-x: hidden;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        img,
        svg,
        iframe,
        video,
        canvas {
            max-width: 100%;
            height: auto;
            display: block;
        }

        .container,
        .container-fluid {
            width: 100%;
        }

        section {
            scroll-margin-top: 90px;
        }

        a {
            text-decoration: none;
        }

        /* ===============================
       NAVBAR
    =============================== */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            padding-top: 0.7rem;
            padding-bottom: 0.7rem;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary) !important;
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .brand-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            margin-left: 10px;
        }

        .nav-link:hover {
            color: var(--primary) !important;
        }

        .navbar-toggler {
            border: none;
            box-shadow: none !important;
            padding: 0.35rem 0.55rem;
        }

        /* =========================================================
       ACTIVE STATE NAVBAR
       - Memberi penanda visual pada menu yang sedang aktif
       - Tidak mengubah layout utama
    ========================================================= */
        .navbar .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }

        .navbar .nav-link.active {
            color: var(--primary) !important;
            font-weight: 600;
        }

        .navbar .nav-link.active::after {
            content: "";
            position: absolute;
            left: 10px;
            right: 0;
            bottom: -4px;
            width: calc(100% - 10px);
            height: 2px;
            background-color: var(--primary);
            border-radius: 999px;
        }

        /* ===============================
       HERO SECTION
    =============================== */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background:
                linear-gradient(rgba(244, 251, 246, 0.88), rgba(244, 251, 246, 0.96)),
                url("https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=1600&q=80") center/cover no-repeat;
            padding-top: 90px;
            position: relative;
            overflow: hidden;
        }

        .hero-badge {
            display: inline-block;
            padding: 8px 16px;
            background-color: #e6f7ea;
            color: var(--primary-dark);
            border-radius: 999px;
            font-weight: 600;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 18px;
            overflow-wrap: break-word;
        }

        .hero p {
            color: var(--text-muted);
            font-size: 1.1rem;
            margin-bottom: 28px;
            overflow-wrap: break-word;
        }

        .btn-main {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            box-shadow: var(--shadow);
            white-space: normal;
            text-align: center;
        }

        .btn-main:hover {
            background: var(--primary-dark);
            color: white;
        }

        .btn-outline-custom {
            border: 2px solid var(--primary);
            color: var(--primary);
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            white-space: normal;
            text-align: center;
        }

        .btn-outline-custom:hover {
            background: var(--primary);
            color: white;
        }

        .hero-card {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 28px;
        }

        .mini-stat {
            border-radius: 16px;
            background: #f7fcf8;
            padding: 18px;
            text-align: center;
            height: 100%;
        }

        .mini-stat i {
            font-size: 1.6rem;
            color: var(--primary);
        }

        .mini-stat h5 {
            margin-top: 12px;
            font-weight: 700;
        }

        /* ===============================
       SECTION UMUM
    =============================== */
        section {
            padding: 90px 0;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 14px;
            overflow-wrap: break-word;
        }

        .section-subtitle {
            color: var(--text-muted);
            max-width: 700px;
            margin: 0 auto 50px auto;
            overflow-wrap: break-word;
        }

        .bg-soft {
            background-color: var(--light-bg);
        }

        /* ===============================
       ABOUT
    =============================== */
        .about-box {
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 32px;
            height: 100%;
        }

        .icon-box {
            width: 58px;
            height: 58px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e8f8ec;
            color: var(--primary);
            font-size: 1.5rem;
            margin-bottom: 18px;
        }

        /* ===============================
       FITUR
    =============================== */
        .feature-card {
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 28px;
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 35px rgba(0, 0, 0, 0.10);
        }

        .feature-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.7rem;
            margin-bottom: 18px;
        }

        /* ===============================
       STATISTIK
    =============================== */
        .stat-card {
            position: relative;

            background:
                linear-gradient(135deg,
                    rgba(255, 255, 255, 0.96),
                    rgba(255, 255, 255, 0.88));

            backdrop-filter: blur(10px);

            border-radius: 24px;

            padding: 30px 24px;

            text-align: center;

            overflow: hidden;

            border: 1px solid rgba(255, 255, 255, 0.4);

            box-shadow:
                0 10px 30px rgba(0, 0, 0, 0.06);

            transition: all .35s ease;

            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-8px);

            box-shadow:
                0 18px 35px rgba(47, 133, 90, 0.15);
        }

        .stat-card::before {
            content: '';

            position: absolute;

            top: -30px;
            right: -30px;

            width: 100px;
            height: 100px;

            background: rgba(47, 133, 90, 0.08);

            border-radius: 50%;
        }

        .stat-icon {
            width: 70px;
            height: 70px;

            margin: auto;

            border-radius: 20px;

            background:
                linear-gradient(135deg,
                    #2f855a,
                    #68d391);

            display: flex;
            align-items: center;
            justify-content: center;

            color: white;

            font-size: 1.8rem;

            box-shadow:
                0 10px 25px rgba(47, 133, 90, 0.2);
        }

        .stat-number {
            font-size: 2rem;

            font-weight: 800;

            color: #2f855a;

            margin-bottom: 8px;
        }

        /* ===============================
   DATA BOX
================================ */

        .data-box {
            background:
                linear-gradient(135deg,
                    #1f6f4a,
                    #2f855a,
                    #4caf75);

            color: white;

            border-radius: 30px;

            padding: 45px;

            position: relative;

            overflow: hidden;

            box-shadow:
                0 20px 45px rgba(47, 133, 90, 0.18);
        }

        .data-box::before {
            content: '';

            position: absolute;

            top: -90px;
            right: -90px;

            width: 250px;
            height: 250px;

            background:
                rgba(255, 255, 255, 0.08);

            border-radius: 50%;
        }

        /* ===============================
   MINI CARD
================================ */

        .mini-data-card {
            background:
                rgba(255, 255, 255, 0.12);

            backdrop-filter: blur(10px);

            border-radius: 22px;

            padding: 24px;

            text-align: center;

            border: 1px solid rgba(255, 255, 255, 0.15);

            transition: all .3s ease;

            height: 100%;
        }

        .mini-data-card:hover {
            transform: translateY(-5px);

            background:
                rgba(255, 255, 255, 0.16);
        }

        .mini-data-icon {
            width: 60px;
            height: 60px;

            margin: auto auto 16px;

            border-radius: 18px;

            background:
                rgba(255, 255, 255, 0.18);

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 1.5rem;

            color: #fff;
        }

        .mini-data-card h3 {
            font-size: 2rem;

            font-weight: 800;

            margin-bottom: 6px;
        }

        .mini-data-card p {
            margin: 0;

            opacity: .85;
        }

        /* ===============================
   PROGRESS
================================ */

        .progress {
            height: 14px;

            border-radius: 999px;

            background:
                rgba(255, 255, 255, 0.18);

            overflow: hidden;
        }

        .progress-bar {
            border-radius: 999px;

            background:
                linear-gradient(90deg,
                    #d9f99d,
                    #ffffff);

            box-shadow:
                0 0 15px rgba(255, 255, 255, 0.35);
        }

        /* ===============================
       KONTAK / FOOTER
    =============================== */
        .contact-card {
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 30px;
            height: 100%;
        }

        .contact-item {
            display: flex;
            gap: 14px;
            margin-bottom: 18px;
        }

        .contact-item i {
            color: var(--primary);
            font-size: 1.25rem;
            margin-top: 3px;
            flex-shrink: 0;
        }

        /* ===============================
       MAP
    =============================== */
        .map-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .map-header {
            padding: 20px 24px;
            border-bottom: 1px solid #eef2f7;
            background: #f9fcfa;
        }



        /* =========================================================
       ANIMASI SCROLL ADVANCED
       - Delay, duration, easing dikontrol dari JavaScript
    ========================================================= */
        .scroll-animate {
            opacity: 0;
            transform: translate3d(0, 40px, 0) scale(0.985);
            will-change: opacity, transform;
            backface-visibility: hidden;

            --sa-duration: 680ms;
            --sa-delay: 0ms;
            --sa-ease: cubic-bezier(0.22, 1, 0.36, 1);

            transition:
                opacity var(--sa-duration) var(--sa-ease) var(--sa-delay),
                transform var(--sa-duration) var(--sa-ease) var(--sa-delay);
        }

        .scroll-animate.in-view {
            opacity: 1;
            transform: translate3d(0, 0, 0) scale(1);
        }

        .fade-up {
            transform: translate3d(0, 40px, 0) scale(0.985);
        }

        .fade-left {
            transform: translate3d(-42px, 0, 0) scale(0.985);
        }

        .fade-right {
            transform: translate3d(42px, 0, 0) scale(0.985);
        }

        .zoom-soft {
            transform: translate3d(0, 26px, 0) scale(0.94);
        }

        .scroll-animate.in-view.fade-up,
        .scroll-animate.in-view.fade-left,
        .scroll-animate.in-view.fade-right,
        .scroll-animate.in-view.zoom-soft {
            opacity: 1;
            transform: translate3d(0, 0, 0) scale(1);
        }

        .scroll-animate.is-leaving {
            pointer-events: none;
        }

        /* =========================================================
       RESPONSIVE TABLET
       - Menjaga layout tetap lega dan rapi
    ========================================================= */
        @media (max-width: 991.98px) {
            .navbar .container {
                align-items: center;
            }

            .navbar-collapse {
                margin-top: 12px;
                background: rgba(255, 255, 255, 0.98);
                border-radius: 16px;
                padding: 12px 14px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
            }

            .navbar-nav {
                gap: 4px;
            }

            .nav-link {
                margin-left: 0 !important;
                padding: 10px 12px;
                border-radius: 10px;
            }

            .navbar .nav-link.active::after {
                left: 12px;
                width: 32px;
                bottom: 4px;
            }

            .navbar-brand {
                max-width: calc(100% - 64px);
            }

            .navbar-brand span {
                font-size: 1rem;
                line-height: 1.2;
            }

            .brand-icon {
                width: 38px;
                height: 38px;
            }

            .hero {
                min-height: auto;
                padding-top: 120px;
                padding-bottom: 70px;
                text-align: center;
            }

            .hero h1 {
                font-size: 2.35rem;
                line-height: 1.25;
            }

            .hero p {
                font-size: 1.02rem;
                margin-bottom: 22px;
            }

            .hero .d-flex {
                justify-content: center;
            }

            section {
                padding: 72px 0;
            }

            .section-title {
                font-size: 1.9rem;
            }

            .section-subtitle {
                font-size: 0.98rem;
                margin-bottom: 38px;
                padding-inline: 6px;
            }

            .feature-card,
            .contact-card,
            .stat-card,
            .hero-card,
            .data-box {
                padding: 24px;
            }

            .map-header {
                padding: 18px 20px;
            }


        }

        /* =========================================================
       RESPONSIVE MOBILE
       - Layout menjadi stack vertikal
       - Font dan spacing lebih nyaman
    ========================================================= */
        @media (max-width: 767.98px) {
            body {
                font-size: 0.95rem;
            }

            section {
                padding: 58px 0;
            }

            .hero {
                min-height: auto;
                padding-top: 110px;
                padding-bottom: 55px;
            }

            .hero h1 {
                font-size: 1.95rem;
                line-height: 1.28;
                margin-bottom: 14px;
            }

            .hero p {
                font-size: 0.98rem;
                line-height: 1.7;
                margin-bottom: 20px;
            }

            .section-title {
                font-size: 1.55rem;
                line-height: 1.3;
                margin-bottom: 10px;
            }

            .section-subtitle {
                font-size: 0.95rem;
                margin-bottom: 30px;
                padding-inline: 4px;
            }

            .hero-card,
            .feature-card,
            .contact-card,
            .stat-card,
            .data-box,
            .map-header {
                padding: 20px;
            }

            .mini-stat {
                padding: 16px;
            }

            .mini-stat h5 {
                font-size: 1rem;
            }

            .feature-icon {
                width: 56px;
                height: 56px;
                font-size: 1.45rem;
                margin-bottom: 14px;
            }

            .icon-box {
                width: 52px;
                height: 52px;
                font-size: 1.3rem;
            }

            .stat-number {
                font-size: 1.8rem;
            }

            .contact-item {
                gap: 12px;
                align-items: flex-start;
            }

            .contact-item i {
                font-size: 1.1rem;
            }

            .btn-main,
            .btn-outline-custom {
                width: 100%;
                padding: 11px 18px;
                font-size: 0.95rem;
            }

            .hero .d-flex {
                flex-direction: column;
                align-items: stretch;
                width: 100%;
            }

            .hero .d-flex>* {
                width: 100%;
            }

            .map-card {
                border-radius: 16px;
            }

            .map-header {
                border-radius: 16px 16px 0 0;
            }



            .progress {
                height: 9px;
            }



            /* Animasi dibuat lebih ringan di mobile */
            .scroll-animate {
                --sa-duration: 760ms;
                transform: translate3d(0, 24px, 0) scale(0.99);
            }

            .fade-up {
                transform: translate3d(0, 24px, 0) scale(0.99);
            }

            .fade-left {
                transform: translate3d(-20px, 0, 0) scale(0.99);
            }

            .fade-right {
                transform: translate3d(20px, 0, 0) scale(0.99);
            }

            .zoom-soft {
                transform: translate3d(0, 18px, 0) scale(0.96);
            }
        }

        /* =========================================================
       MOBILE KECIL
       - Untuk layar sangat sempit
    ========================================================= */
        @media (max-width: 575.98px) {
            .container {
                padding-left: 16px;
                padding-right: 16px;
            }

            .hero {
                padding-top: 102px;
                padding-bottom: 48px;
            }

            .hero h1 {
                font-size: 1.75rem;
            }

            .hero p {
                font-size: 0.94rem;
            }

            .section-title {
                font-size: 1.4rem;
            }

            .section-subtitle {
                font-size: 0.92rem;
            }

            .hero-card,
            .feature-card,
            .contact-card,
            .stat-card,
            .data-box {
                padding: 18px;
                border-radius: 16px;
            }

            .mini-stat {
                padding: 14px;
                border-radius: 14px;
            }

            .mini-stat i {
                font-size: 1.35rem;
            }

            .mini-stat h5 {
                margin-top: 10px;
                font-size: 0.98rem;
            }

            .map-header {
                padding: 16px 16px 14px;
            }


            .contact-item {
                margin-bottom: 14px;
            }

            .navbar-brand span {
                font-size: 0.95rem;
            }
        }

        /* =========================================================
       ACCESSIBILITY
    ========================================================= */
        @media (prefers-reduced-motion: reduce) {

            .scroll-animate,
            .scroll-animate.in-view,
            .scroll-animate.is-leaving {
                transition: none !important;
                transform: none !important;
                opacity: 1 !important;
            }
        }

        /* ===============================
   NAVBAR LOGO BARU
=================================*/
        .logo-navbar {
            width: 55px;
            height: 55px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .brand-title {
            color: var(--primary);
            font-size: 1.1rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 12px;
            color: #6b7280;
            font-weight: 500;
        }

        /* navbar tetap slim */
        .navbar {
            min-height: 75px;
            padding-top: 0.4rem;
            padding-bottom: 0.4rem;
        }


        /* pemetaan */
        #map {
            height: 600px;
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        .card-map {
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }


        .leaflet-popup-content b {
            color: #0d6efd;
        }

        /* ===== marker di atas polygon ===== */

        .leaflet-marker-pane {
            z-index: 650 !important;
        }

        .leaflet-overlay-pane {
            z-index: 400 !important;
        }

        .leaflet-popup-pane {
            z-index: 700 !important;
        }


        /* ===== LEGENDA DI KANAN BAWAH (tidak bentrok layer control) ===== */

        #legend-box {
            position: absolute;
            bottom: 20px;
            right: 20px;

            z-index: 999;

            background: #ffffff;
            padding: 14px 18px;

            border-radius: 12px;

            box-shadow: 0 4px 12px rgba(0, 0, 0, .15);

            min-width: 180px;

            font-size: 14px;
            line-height: 1.6;
        }

        #legend-box h6 {
            margin-bottom: 10px;
        }

        #legend-box p {
            margin-bottom: 8px;
        }

        .kotak {
            display: inline-block;
            width: 16px;
            height: 16px;
            margin-right: 8px;
            border-radius: 3px;
            vertical-align: middle;
        }

        .hijau {
            background: #198754;
        }

        .ungu {
            background: #6f42c1;
        }

        .bulat {
            display: inline-block;
            background: #333;
            border-radius: 50%;
            margin-right: 8px;
            vertical-align: middle;
        }

        .besar {
            width: 14px;
            height: 14px;
        }

        .kecil {
            width: 8px;
            height: 8px;
        }

        /* Custom Layer Control */
        .custom-layer-ctrl {
            background: transparent;
        }

        .ctrl-toggle {
            width: 44px;
            height: 44px;
            background: #fff;
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .ctrl-panel {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            padding: 10px 14px;
            margin-top: 6px;
            min-width: 130px;
            font-size: 13px;
            color: #333;
        }

        .ctrl-section label {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 5px;
            cursor: pointer;
            white-space: nowrap;
        }

        .ctrl-section input {
            cursor: pointer;
            margin: 0;
        }

        .hero-stat-card {
            background: rgba(255, 255, 255, 0.55);

            backdrop-filter: blur(12px);

            -webkit-backdrop-filter: blur(12px);

            border-radius: 18px;

            padding: 16px 18px;

            border-left: 4px solid #2f855a;

            border: 1px solid rgba(255, 255, 255, 0.35);

            box-shadow:
                0 8px 24px rgba(0, 0, 0, 0.05);

            transition: all 0.3s ease;

            height: 100%;
        }

        .hero-stat-card:hover {
            transform: translateY(-4px);

            background: rgba(255, 255, 255, 0.7);

            box-shadow:
                0 14px 28px rgba(47, 133, 90, 0.12);
        }

        .hero-stat-label {
            display: block;

            font-size: 0.82rem;

            font-weight: 600;

            color: #64748b;

            margin-bottom: 8px;
        }

        .hero-stat-number {
            font-size: 2rem;

            font-weight: 800;

            color: #2f855a;

            margin: 0;

            line-height: 1;
        }

        .comparison-box {
            background:
                linear-gradient(180deg,
                    rgba(255, 255, 255, .16),
                    rgba(255, 255, 255, .10));

            border-radius: 28px;

            padding: 34px;

            backdrop-filter: blur(14px);

            border:
                1px solid rgba(255, 255, 255, .12);

            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, .08);

            height: 100%;
        }

        .compare-bar {
            width: 100%;

            height: 12px;

            border-radius: 999px;

            overflow: hidden;

            background:
                rgba(255, 255, 255, 0.10);
        }

        .compare-fill {
            height: 100%;

            border-radius: 999px;
        }

        .fill-blue {
            background:
                linear-gradient(90deg,
                    #60a5fa,
                    #bfdbfe);
        }

        .fill-green {
            background:
                linear-gradient(90deg,
                    #4ade80,
                    #bbf7d0);
        }

        .wilayah-table-box {
            overflow: hidden;
        }

        .ranking-icon {
            width: 52px;
            height: 52px;

            border-radius: 16px;

            background:
                rgba(255, 255, 255, 0.12);

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 1.2rem;

            color: #facc15;
        }

        .wilayah-table {
            color: #fff;
            margin-bottom: 0;
        }

        .wilayah-table thead th {
            border: none;

            background:
                rgba(255, 255, 255, 0.08);

            padding: 16px;

            font-size: .9rem;

            white-space: nowrap;
        }

        .wilayah-table tbody td {
            border-color:
                rgba(255, 255, 255, 0.08);

            padding: 16px;

            vertical-align: middle;
        }

        .ranking-badge {
            width: 42px;
            height: 42px;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            font-weight: 700;

            background:
                rgba(255, 255, 255, 0.10);
        }

        .gold {
            background:
                linear-gradient(135deg,
                    #facc15,
                    #fde68a);

            color: #000;
        }

        .silver {
            background:
                linear-gradient(135deg,
                    #d1d5db,
                    #f3f4f6);

            color: #000;
        }

        .bronze {
            background:
                linear-gradient(135deg,
                    #fb923c,
                    #fdba74);

            color: #000;
        }

        .skill-badge {
            font-size: .85rem;

            font-weight: 600;

            color: #070000;

            opacity: .9;
        }

        .wilayah-table {
            border-collapse: separate;
            border-spacing: 0 14px;
            margin-bottom: 0;
        }

        .wilayah-table thead th {
            background: transparent;
            color: rgba(255, 255, 255, .85);

            border: none;

            font-size: .9rem;
            font-weight: 600;

            padding-bottom: 14px;
        }

        .wilayah-table tbody tr {
            background: rgba(255, 255, 255, .96);

            transition: .3s ease;

            overflow: hidden;
        }

        .wilayah-table tbody tr:hover {
            transform: translateY(-2px);

            box-shadow:
                0 10px 24px rgba(0, 0, 0, .08);
        }

        .wilayah-table tbody td {
            border: none;

            padding: 18px 16px;

            vertical-align: middle;
        }

        .wilayah-table tbody td:first-child {
            border-radius: 18px 0 0 18px;
        }

        .wilayah-table tbody td:last-child {
            border-radius: 0 18px 18px 0;
        }

        .skill-badge {

            padding: 8px 14px;

            border-radius: 999px;

            font-size: .85rem;

            font-weight: 600;

            display: inline-block;
        }

        .jumlah-warga {
            font-weight: 700;

            color: #2f855a;

            font-size: 1rem;
        }

        .wilayah-label {
            font-weight: 700;

            color: #1f2937;

            margin-bottom: 2px;
        }

        .wilayah-sub {
            color: #6b7280;

            font-size: .84rem;
        }

        #map {
            height: 400px;
            /* Diubah dari 600px ke 400px agar lebih compact */
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            z-index: 1;
            margin-top: 10px;
            /* Memberi jarak sedikit dari filter */
        }

        /* 2. Merapikan card agar lebih fokus ke atas */
        .card-map {
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }

        /* 3. Menghilangkan padding berlebih agar lebih ke atas */
        .card-body {
            padding: 1.5rem !important;
        }

        /* Kustomisasi Ikon Layer Control (Dropdown) */
        .leaflet-control-layers-toggle {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='%230d6efd' class='bi bi-layers-fill' viewBox='0 0 16 16'%3E%3Cpath d='M7.765 1.559a.5.5 0 0 1 .47 0l6.39 3.39a.5.5 0 0 1 0 .87l-6.39 3.39a.5.5 0 0 1-.47 0L1.375 5.819a.5.5 0 0 1 0-.87l6.39-3.39z'/%3E%3Cpath d='m1.375 9.18 6.39 3.39a.5.5 0 0 0 .47 0l6.39-3.39a.5.5 0 0 0 0-.87l-6.39-3.39a.5.5 0 0 0-.47 0L1.375 8.31a.5.5 0 0 0 0 .87z'/%3E%3Cpath d='m1.375 12.54 6.39 3.39a.5.5 0 0 0 .47 0l6.39-3.39a.5.5 0 0 0 0-.87l-6.39-3.39a.5.5 0 0 0-.47 0L1.375 11.67a.5.5 0 0 0 0 .87z'/%3E%3C/svg%3E") !important;
            background-size: 22px;
            background-position: center;
            width: 44px !important;
            height: 44px !important;
            border-radius: 8px !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2) !important;
            border: none !important;
            background-color: #ffffff !important;
        }

        .leaflet-control-layers {
            border-radius: 12px !important;
            border: none !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15) !important;
            padding: 5px !important;
        }

        .leaflet-control-layers-expanded {
            padding: 12px !important;
            color: #333;
            font-family: 'Inter', sans-serif;
        }

        /* Label Styling dalam Dropdown */
        .leaflet-control-layers-selector {
            margin-top: 5px;
            cursor: pointer;
        }

        .leaflet-popup-content b {
            color: #0d6efd;
        }

        /* ===== marker di atas polygon ===== */

        .leaflet-marker-pane {
            z-index: 500 !important;
        }

        .leaflet-popup-pane {
            z-index: 9999 !important;
        }

        .leaflet-overlay-pane {
            z-index: 400 !important;
        }

        .leaflet-popup {
            z-index: 9999 !important;
        }

        .leaflet-popup-content-wrapper {
            position: relative;
            z-index: 9999 !important;
        }

        .leaflet-popup-tip-container {
            z-index: 9999 !important;
        }

        /* ===== LEGENDA DI KANAN BAWAH (tidak bentrok layer control) ===== */

        #legend-box {
            position: absolute;
            bottom: 20px;
            right: 20px;

            z-index: 999;

            background: #ffffff;
            padding: 14px 18px;

            border-radius: 12px;

            box-shadow: 0 4px 12px rgba(0, 0, 0, .15);

            min-width: 180px;

            font-size: 14px;
            line-height: 1.6;
        }

        #legend-box h6 {
            margin-bottom: 10px;
        }

        #legend-box p {
            margin-bottom: 8px;
        }

        .kotak {
            display: inline-block;
            width: 16px;
            height: 16px;
            margin-right: 8px;
            border-radius: 3px;
            vertical-align: middle;
        }

        .hijau {
            background: #198754;
        }

        .ungu {
            background: #6f42c1;
        }

        .bulat {
            display: inline-block;
            background: #333;
            border-radius: 50%;
            margin-right: 8px;
            vertical-align: middle;
        }

        .besar {
            width: 14px;
            height: 14px;
        }

        .kecil {
            width: 8px;
            height: 8px;
        }

        /* =========================
   POPUP MODERN
========================= */

        .leaflet-popup-content-wrapper {
            border-radius: 18px !important;
            padding: 0 !important;
            overflow: hidden;
            box-shadow:
                0 12px 30px rgba(0, 0, 0, .15);
        }

        .leaflet-popup-content {
            margin: 0 !important;
            min-width: 280px;
        }

        .popup-modern {
            animation: popupFade .35s ease;
        }

        @keyframes popupFade {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .popup-header {
            padding: 16px;
            color: white;
        }

        .popup-header-rw {
            background: linear-gradient(135deg,
                    #2563eb,
                    #3b82f6);
        }

        .popup-header-rt {
            background: linear-gradient(135deg,
                    #dc2626,
                    #ef4444);
        }

        .popup-header-dusun {
            background: linear-gradient(135deg,
                    #198754,
                    #20c997);
        }

        .popup-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 3px;
        }

        .popup-subtitle {
            font-size: 12px;
            opacity: .9;
        }

        .popup-body {
            padding: 14px 16px;
        }

        .popup-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 9px 0;
            border-bottom: 1px solid #eef2f7;
        }

        .popup-row:last-child {
            border-bottom: none;
        }

        .popup-label {
            color: #6b7280;
            font-size: 13px;
        }

        .popup-value {
            font-weight: 700;
            color: #111827;
        }

        .popup-badge {

            color: white;

            padding: 5px 10px;

            border-radius: 999px;

            font-size: 12px;

            font-weight: 600;

        }

        .btn-popup {
            display: block;
            width: 100%;
            margin-top: 12px;
            text-align: center;
            text-decoration: none;
            border: none;
            border-radius: 12px;
            padding: 10px;
            background: linear-gradient(135deg,
                    #2563eb,
                    #3b82f6);
            color: white !important;
            font-weight: 600;
            transition: .3s ease;
        }

        .btn-popup:hover {
            transform: translateY(-2px);
            color: white !important;
            box-shadow:
                0 8px 18px rgba(37, 99, 235, .25);
        }

        @media(max-width:576px) {

            .leaflet-popup-content {
                min-width: 240px;
            }

        }

        /* ==========================
   FILTER MODERN
========================== */

        .filter-wrapper {

            background: #fff;

            padding: 18px;

            border-radius: 18px;

            box-shadow:
                0 6px 18px rgba(15, 23, 42, .06);

            margin-bottom: 20px;

        }

        .filter-group {

            position: relative;

            transition: .3s ease;

        }

        .filter-group:hover {

            transform: translateY(-2px);

        }

        .filter-icon {

            position: absolute;

            left: 15px;

            top: 50%;

            transform: translateY(-50%);

            color: #2563eb;

            z-index: 10;

            font-size: 14px;

        }

        .filter-select {

            height: 52px;

            border-radius: 14px;

            border: 1px solid #dbe3f0;

            padding-left: 42px;

            font-weight: 500;

            transition: .3s ease;

            box-shadow: none !important;

        }

        .filter-select:hover {

            border-color: #60a5fa;

        }

        .filter-select:focus {

            border-color: #2563eb;

            box-shadow:
                0 0 0 4px rgba(37, 99, 235, .12) !important;

            transform: translateY(-1px);

        }

        .btn-reset {

            height: 52px;

            border: none;

            border-radius: 14px;

            font-weight: 600;

            color: #fff;

            background: linear-gradient(135deg,
                    #2563eb,
                    #3b82f6);

            transition: .35s ease;

            overflow: hidden;

            position: relative;

        }

        .btn-reset:hover {

            transform: translateY(-3px);

            box-shadow:
                0 10px 24px rgba(37, 99, 235, .25);

        }

        .btn-reset::before {

            content: '';

            position: absolute;

            top: 0;

            left: -100%;

            width: 100%;

            height: 100%;

            background:
                rgba(255, 255, 255, .2);

            transition: .5s;

        }

        .btn-reset:hover::before {

            left: 100%;

        }

        .btn-reset i {

            transition: .4s ease;

        }

        .btn-reset:hover i {

            transform: rotate(-180deg);

        }

        .footer-desa {
            background: #1f4d35;
            color: #ffffff;
            padding: 50px 0 20px;
        }

        .footer-desa h5,
        .footer-desa h6 {
            color: #fff;
        }

        .footer-desa p {
            color: rgba(255, 255, 255, .85);
            line-height: 1.8;
        }

        .footer-desa a {
            color: rgba(255, 255, 255, .85);
            text-decoration: none;
            transition: .3s;
        }

        .footer-desa a:hover {
            color: #68d391;
            padding-left: 4px;
        }

        .footer-desa hr {
            border-color: rgba(255, 255, 255, .15);
            margin: 25px 0;
        }

        .footer-desa i {
            color: #68d391;
        }
        .swal-kecil{
    width: 380px !important;
    padding: 1rem !important;
}

.swal-title-kecil{
    font-size: 1.2rem !important;
}

.swal-icon-kecil{
    zoom: 0.75;
}
    </style>
</head>

<body>

    <!-- ===============================
         NAVBAR
         Berisi logo dan menu utama
    ================================ -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#beranda">
                <img src="{{ asset('images/logo-indramayu.png') }}" alt="Logo Indramayu" class="logo-navbar">
                <div>
                    <span>SIKARMAP</span>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#beranda">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#fitur">Pemetaan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#data">Statistik</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kontak">Pengajuan</a></li>
                    {{-- <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link"> Login</a>
                    </li> --}}
                </ul>
            </div>
        </div>
    </nav>

    <!-- ===============================
         HERO SECTION
         Bagian pembuka halaman
    ================================ -->
    <section class="hero" id="beranda">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-6 scroll-animate fade-left delay-1">
                    <h1 class="scroll-animate fade-up delay-1">Sistem Pemetaan Keterampilan Warga Desa Karangmulya</h1>
                    <p class="scroll-animate fade-up delay-2">
                        Sistem berbasis WebGIS yang digunakan
                        untuk mengelola, menampilkan, dan memetakan
                        data keterampilan warga berdasarkan wilayah
                        RT, RW, dan dusun secara digital.
                    </p>

                    <div class="row g-3 mt-3 scroll-animate fade-up delay-3">

                        <div class="col-md-4 col-4">
                            <div class="hero-stat-card">
                                <span class="hero-stat-label">Total Kategori Keterampilan</span>
                                <h2 class="hero-stat-number">{{ $totalKategori }}</h2>
                            </div>
                        </div>

                        <div class="col-md-4 col-4">
                            <div class="hero-stat-card">
                                <span class="hero-stat-label">Warga Skill</span>
                                <h2 class="hero-stat-number">{{ $totalSkill }}</h2>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-6 scroll-animate fade-right delay-2">
                    <div class="hero-card" style="padding: 22px;">

                        <!-- Foto utama -->
                        <div style="position: relative; border-radius: 14px; overflow: hidden; margin-bottom: 12px;">
                            <img src="{{ asset('images/kantor-desa.jpeg') }}" alt="Kantor Desa Karangmulya"
                                style="width: 100%; height: 220px; object-fit: cover; display: block;">
                            <!-- Badge live pojok kiri atas -->
                            <span
                                style="position: absolute; top: 11px; left: 11px; background: rgba(0,0,0,0.48); color: #fff; font-size: 11px; font-weight: 600; padding: 4px 11px; border-radius: 999px; display: flex; align-items: center; gap: 5px;">
                                <span
                                    style="width: 6px; height: 6px; background: #68d391; border-radius: 50%; display: inline-block; animation: kantorBlink 1.5s infinite;"></span>
                                Kantor Desa Karangmulya
                            </span>
                            <!-- Caption overlay bawah -->
                            <div
                                style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.55) 0%, transparent 100%); padding: 28px 14px 12px;">
                                <strong style="color: #fff; font-size: 13px; display: block;">Kantor Desa
                                    Karangmulya</strong>
                                <span style="color: rgba(255,255,255,0.72); font-size: 11px;">Kec. Kandanghaur, Kab.
                                    Indramayu</span>
                            </div>
                        </div>

                        <!-- 3 thumbnail bawah -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; margin-bottom: 10px;">
                            <div style="border-radius: 10px; overflow: hidden;">
                                <img src="" alt="Ruang Pelayanan"
                                    style="width: 100%; height: 80px; object-fit: cover; display: block;">
                            </div>
                            <div style="border-radius: 10px; overflow: hidden;">
                                <img src="{{ asset('images/desa.jpeg') }}" alt="Lingkungan Desa"
                                    style="width: 100%; height: 80px; object-fit: cover; display: block;">
                            </div>
                            <div style="border-radius: 10px; overflow: hidden;">
                                <img src="" alt="Potensi Alam"
                                    style="width: 100%; height: 80px; object-fit: cover; display: block;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gelombang bawah hero -->
        <div class="position-absolute bottom-0 start-0 w-100" style="line-height: 0;">
            <svg viewBox="0 0 1440 120" xmlns="http://www.w3.org/2000/svg">
                <path fill="#ffffff" fill-opacity="1"
                    d="M0,64L80,64C160,64,320,64,480,58.7C640,53,800,43,960,48C1120,53,1280,75,1360,85.3L1440,96L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z">
                </path>
            </svg>
        </div>
    </section>

    <!-- ===============================
         TENTANG SISTEM
         Penjelasan singkat tujuan website
    ================================ -->
    <section id="tentang" class="bg-soft">
        <div class="container">

            <div class="text-center mb-5 scroll-animate fade-up">
                <h2 class="section-title">
                    Tentang Sistem
                </h2>

                <p class="section-subtitle">
                    SIPKARMAP merupakan Sistem Pemetaan
                    Keterampilan Warga Desa Karangmulya berbasis WebGIS
                    yang digunakan untuk mengelola, memvisualisasikan,
                    dan memetakan data keterampilan warga berdasarkan
                    wilayah RT, RW, dan dusun ke dalam bentuk peta digital
                    secara interaktif
                </p>
            </div>

            <div class="row g-4">

                <!-- fungsi -->
                <div class="col-md-4 scroll-animate fade-up">
                    <div class="feature-card h-100">

                        <div class="feature-icon">
                            <i class="bi bi-map"></i>
                        </div>

                        <h5 class="fw-bold mb-3">
                            Fungsi Sistem
                        </h5>

                        <p class="text-muted mb-0">
                            Membantu mengelola, dan menampilkan
                            keterampilan warga desa secara digital
                            melalui peta interaktif yang mudah diakses.
                        </p>

                    </div>
                </div>

                <!-- manfaat -->
                <div class="col-md-4 scroll-animate fade-up delay-1">
                    <div class="feature-card h-100">

                        <div class="feature-icon">
                            <i class="bi bi-bar-chart"></i>
                        </div>

                        <h5 class="fw-bold mb-3">
                            Manfaat Sistem
                        </h5>

                        <p class="text-muted mb-0">
                            Membantu pemerintah desa dan masyarakat
                            mengetahui keterampilan warga yang lebih
                            banyak dimiliki di setiap wilayah desa.
                        </p>

                    </div>
                </div>

                <!-- fitur -->
                <div class="col-md-4 scroll-animate fade-up delay-2">
                    <div class="feature-card h-100">

                        <div class="feature-icon">
                            <i class="bi bi-people"></i>
                        </div>

                        <h5 class="fw-bold mb-3">
                            Fitur Utama
                        </h5>

                        <p class="text-muted mb-0">
                            Menyediakan peta digital, statistik data,
                            dan pemetaan keterampilan warga berdasarkan
                            wilayah desa.
                        </p>

                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- ===================================
         PEMETAAN
         Menampilkan sebaran keterampilan
    ======================================== -->
    <section id="fitur" class="bg-soft scroll-animate fade-up">
        <div class="container">
            <div class="text-center mb-5 scroll-animate fade-up delay-1">
                <h2 class="section-title scroll-animate fade-up delay-1">Pemetaan Keterampilan Warga Desa Karangmulya
                </h2>
                <p class="section-subtitle scroll-animate fade-up delay-2">
                    Menampilkan sebaran keterampilan warga Desa Karangmulya secara interaktif
                    dalam bentuk peta digital berdasarkan wilayah RT, RW, dan dusun.
                </p>
            </div>
            <div class="row g-3 align-items-center">

                <div class="col-lg-3 col-md-6">

                    <div class="filter-group">

                        <i class="fa-solid fa-map-location-dot filter-icon"></i>

                        <select id="filterDusun" class="form-select filter-select"></select>

                    </div>

                </div>

                <div class="col-lg-3 col-md-6">

                    <div class="filter-group">

                        <i class="fa-solid fa-building filter-icon"></i>

                        <select id="filterRw" class="form-select filter-select"></select>

                    </div>

                </div>

                <div class="col-lg-3 col-md-6">

                    <div class="filter-group">

                        <i class="fa-solid fa-house filter-icon"></i>

                        <select id="filterRt" class="form-select filter-select"></select>

                    </div>

                </div>

                <div class="col-lg-3 col-md-6">

                    <button id="resetFilter" class="btn btn-reset w-100">

                        <i class="fa-solid fa-rotate-left me-2"></i>

                        Reset Filter

                    </button>

                </div>

            </div>
            <div class="card card-map border-0 shadow-sm">
                <div class="card-body">
                    <div id="map"></div>
                    <div id="legend-box">
                        <h6><b>Keterangan Peta</b></h6>
                        <p>
                            <span class="kotak hijau"></span>
                            Dusun Kemped
                        </p>

                        <p>
                            <span class="kotak ungu"></span>
                            Dusun Sukamelang
                        </p>

                        <hr>

                        <p>
                            <span class="bulat besar"></span>
                            Marker RW
                        </p>

                        <p>
                            <span class="bulat kecil"></span>
                            Marker RT
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===============================
     DATA / STATISTIK DESA
================================ -->
    <section id="data" class="scroll-animate fade-up">

        <div class="container">

            <div class="text-center mb-5 scroll-animate fade-up delay-1">

                <h2 class="section-title">
                    Statistik & Data Desa
                </h2>

                <p class="section-subtitle">
                    Berikut data sebaran keterampilan warga
                    Desa Karangmulya berdasarkan data terbaru
                    pada sistem.
                </p>

            </div>

            <!-- CARD STATISTIK -->
            <div class="row g-4 mb-5">

                <!-- total warga -->
                <div class="col-6 col-md-2 scroll-animate zoom-soft delay-1">

                    <div class="stat-card">

                        <div class="stat-icon mb-3">
                            <i class="bi bi-people-fill"></i>
                        </div>

                        <div class="stat-number" data-target="{{ $totalWarga }}">
                            0
                        </div>

                        <p class="mb-0 text-muted">
                            Total Warga
                        </p>

                    </div>

                </div>

                <!-- warga skill -->
                <div class="col-6 col-md-2 scroll-animate zoom-soft delay-1">

                    <div class="stat-card">

                        <div class="stat-icon mb-3">
                            <i class="bi bi-briefcase-fill"></i>
                        </div>

                        <div class="stat-number" data-target="{{ $totalSkill }}">
                            0
                        </div>

                        <p class="mb-0 text-muted">
                            Warga Berketerampilan
                        </p>

                    </div>

                </div>

                <!-- kategori -->
                <div class="col-6 col-md-2 scroll-animate zoom-soft delay-1">

                    <div class="stat-card">

                        <div class="stat-icon mb-3">
                            <i class="bi bi-grid-fill"></i>
                        </div>

                        <div class="stat-number" data-target="{{ $totalKategori }}">
                            0
                        </div>

                        <p class="mb-0 text-muted">
                            Kategori Keterampilan
                        </p>

                    </div>

                </div>

                <!-- dusun -->
                <div class="col-6 col-md-2 scroll-animate zoom-soft delay-1">

                    <div class="stat-card">

                        <div class="stat-icon mb-3">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>

                        <div class="stat-number" data-target="{{ $totalDusun }}">
                            0
                        </div>

                        <p class="mb-0 text-muted">
                            Total Dusun
                        </p>

                    </div>

                </div>

                <!-- rw -->
                <div class="col-6 col-md-2 scroll-animate zoom-soft delay-5">

                    <div class="stat-card h-100">

                        <div class="stat-icon small-icon mb-3">
                            <i class="bi bi-diagram-3-fill"></i>
                        </div>

                        <div class="stat-number" data-target="{{ $totalRw }}">
                            0
                        </div>

                        <p class="mb-0 text-muted">
                            Total RW
                        </p>

                    </div>

                </div>

                <!-- rt -->
                <div class="col-6 col-md-2 scroll-animate zoom-soft delay-6">

                    <div class="stat-card h-100">

                        <div class="stat-icon small-icon mb-3">
                            <i class="bi bi-signpost-2-fill"></i>
                        </div>

                        <div class="stat-number" data-target="{{ $totalRt }}">
                            0
                        </div>

                        <p class="mb-0 text-muted">
                            Total RT
                        </p>

                    </div>

                </div>


                <!-- VISUALISASI -->
                <div class="data-box scroll-animate fade-up delay-2">

                    <div class="row align-items-center g-5">
                        <div class="row g-4">

                            <!-- kategori -->
                            <div class="col-lg-6 scroll-animate fade-left delay-2">

                                <div class="comparison-box">

                                    <h4 class="fw-bold mb-3">
                                        Data Kategori Keterampilan
                                    </h4>

                                    @php
                                        $maxKategori = $kategoriChart->max('total') ?: 1;
                                    @endphp

                                    @foreach ($kategoriChart->take(5) as $item)
                                        <div class="wilayah-card mb-4">

                                            <div class="d-flex justify-content-between align-items-center mb-3">

                                                <div>

                                                    <h6 class="fw-bold mb-1">
                                                        {{ $item->nama_kategori }}
                                                    </h6>
                                                </div>

                                                <div class="jumlah-box">

                                                    <strong>
                                                        {{ $item->total }}
                                                    </strong>

                                                    <small>
                                                        Orang
                                                    </small>

                                                </div>

                                            </div>

                                            <div class="compare-bar">

                                                <div class="compare-fill fill-green"
                                                    style="width:
                         {{ ($item->total / $maxKategori) * 100 }}%;">
                                                </div>

                                            </div>

                                        </div>
                                    @endforeach

                                </div>

                            </div>

                            <!-- wilayah -->
                            <div class="col-lg-6 scroll-animate fade-right delay-3">

                                <div class="comparison-box wilayah-table-box">

                                    <div class="d-flex justify-content-between align-items-center mb-3">

                                        <div>

                                            <h4 class="fw-bold mb-1">
                                                Sebaran Keterampilan Wilayah
                                            </h4>

                                        </div>

                                    </div>

                                    <div class="table-responsive">

                                        <table class="table wilayah-table align-middle">

                                            <thead>

                                                <tr>

                                                    <th>Wilayah</th>
                                                    <th>Keterampilan Dominan</th>
                                                    <th>Jumlah Warga</th>

                                                </tr>

                                            </thead>

                                            <tbody>

                                                @foreach ($statistikDusun->take(5) as $item)
                                                    <tr>

                                                        <td>

                                                            <div class="fw-semibold">

                                                                RT {{ $item->rt }}
                                                                /
                                                                RW {{ $item->rw }}

                                                            </div>

                                                            <small class="opacity-75">

                                                                Dusun
                                                                {{ $item->nama_dusun }}

                                                            </small>

                                                        </td>

                                                        <td>

                                                            <span class="skill-badge">

                                                                {{ $item->nama_kategori }}

                                                            </span>

                                                        </td>

                                                        <td>

                                                            <strong>
                                                                {{ $item->total_skill }}
                                                            </strong>

                                                            Orang

                                                        </td>

                                                    </tr>
                                                @endforeach

                                            </tbody>

                                        </table>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

    </section>
    <!-- ===============================
     PENGAJUAN KETERAMPILAN
================================ -->
    <section id="kontak" class="bg-soft scroll-animate fade-up">
        <div class="container">

            <div class="text-center mb-5 scroll-animate fade-up delay-1">
                <h2 class="section-title">Pengajuan Keterampilan</h2>

                <p class="section-subtitle">
                    Masyarakat Desa Karangmulya yang memiliki keterampilan,
                    usaha, atau potensi yang belum terdata dapat mengajukan
                    informasi melalui formulir berikut untuk mendukung
                    pendataan potensi sumber daya manusia desa.
                </p>
            </div>

            <div class="row g-4">

                <!-- cari data -->
                <div class="col-lg-5 scroll-animate fade-left delay-2">
                    <div class="contact-card">

                        <div class="mb-4">

                            <h4 class="fw-bold mb-2">
                                Cari Data Warga
                            </h4>

                            <p class="text-muted small mb-0">
                                Masukkan NIK untuk melihat apakah data keterampilan sudah terdaftar dalam sistem.
                            </p>
                        </div>

                      <form action="{{ route('landing') }}#kontak" method="GET">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Nomor Induk Kependudukan (NIK)
                                </label>

                                <input type="text" name="nik" maxlength="16" class="form-control"
                                    placeholder="Masukkan 16 digit NIK" required>
                            </div>

                            <button type="submit" class="btn btn-main w-100">
                                <i class="bi bi-search me-2"></i>
                                Cari Data
                            </button>

                        </form>

                    </div>

                </div>

                <!-- Form Pengajuan -->
                <div class="col-lg-7 scroll-animate fade-right delay-3">
                    <div class="contact-card">

                        <h4 class="fw-bold mb-4">
                            Form Pengajuan Keterampilan
                        </h4>

                        <form action="{{ route('pesan.store') }}" method="POST">
                            @csrf

                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">
                                        Nama Lengkap
                                    </label>

                                    <input type="text" name="nama" class="form-control"
                                        placeholder="Masukkan nama lengkap" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        NIK
                                    </label>

                                    <input type="text" name="nik" class="form-control" maxlength="16"
                                        placeholder="Masukkan 16 digit NIK" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        Nomor Hp
                                    </label>

                                    <div class="input-group">
                                        <input type="text" name="nomor_hp" class="form-control"
                                            placeholder="081234567890" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        Dusun
                                    </label>

                                    <input type="text" name="dusun" class="form-control"
                                        placeholder="Nama Dusun" required>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">
                                        Wilayah
                                    </label>

                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="input-group">
                                                <span class="input-group-text">RW</span>

                                                <input type="text" name="rw" class="form-control"
                                                    placeholder="01">
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="input-group">
                                                <span class="input-group-text">RT</span>

                                                <input type="text" name="rt" class="form-control"
                                                    placeholder="01">
                                            </div>
                                        </div>
                                    </div>
                                </div>
<div class="col-md-6">
    <label class="form-label">
        Kategori Keterampilan
    </label>

    <select name="kategori_keterampilan_id"
            id="kategoriSelect"
            class="form-select"
            required>
        <option value="">-- Pilih Kategori Keterampilan --</option>

        @foreach($kategoriKeterampilans as $kategori)
            <option value="{{ $kategori->id }}">
                {{ $kategori->nama_kategori }}
            </option>
        @endforeach

        <option value="lainnya">Lainnya</option>
    </select>
</div>

<div class="col-md-6 d-none" id="kategoriLainnyaBox">
    <label class="form-label">
        Nama Kategori Baru
    </label>

    <input type="text"
           name="kategori_lainnya"
           id="kategoriLainnya"
           class="form-control"
           placeholder="Masukkan kategori keterampilan baru">
</div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        Keterampilan
                                    </label>

                                    <input type="text" name="keterampilan" class="form-control"
                                        placeholder="Contoh: Menjahit, Bertani, Servis Elektronik, UMKM" required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">
                                        Deskripsi
                                    </label>

                                    <textarea name="pesan" class="form-control" rows="5"
                                        placeholder="Jelaskan keterampilan, usaha, pengalaman, atau potensi yang ingin diajukan untuk didata." required></textarea>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-main w-100">
                                        <i class="bi bi-send-fill me-2"></i>
                                        Ajukan Data
                                    </button>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- ===============================
         FOOTER
    ================================ -->
    <footer class="footer-desa scroll-animate fade-up">
        <div class="container">

            <div class="row gy-4">

                <div class="col-lg-5">
                    <h5 class="fw-bold mb-3">
                        Sistem Pemetaan Keterampilan Warga
                    </h5>

                    <p class="mb-0">
                        Sistem informasi untuk mendukung pendataan dan pemetaan
                        keterampilan masyarakat Desa Karangmulya guna menunjang
                        pembangunan desa berbasis potensi warga.
                    </p>
                </div>

                <div class="col-lg-4">
                    <h6 class="fw-bold mb-3">Kontak Desa</h6>

                    <p class="mb-2">
                        <i class="bi bi-geo-alt-fill me-2"></i>
                        Desa Karangmulya, Kecamatan Kandanghaur,
                        Kabupaten Indramayu
                    </p>

                    <p class="mb-2">
                        <i class="bi bi-telephone-fill me-2"></i>
                        (021) 1234-5678
                    </p>

                    <p class="mb-0">
                        <i class="bi bi-envelope-fill me-2"></i>
                        info@skillmapdesa.id
                    </p>
                </div>

                <div class="col-lg-3">
                    <h6 class="fw-bold mb-3">Menu Cepat</h6>

                    <p class="mb-2">
                        <a href="#beranda">Beranda</a>
                    </p>

                    <p class="mb-2">
                        <a href="#tentang">Tentang</a>
                    </p>

                    <p class="mb-2">
                        <a href="#statistik">Statistik</a>
                    </p>

                    <p class="mb-0">
                        <a href="#kontak">Kontak</a>
                    </p>
                </div>

            </div>

            <hr>

            <div class="text-center">
                <small>
                    © 2026 Pemerintah Desa Karangmulya |
                    Sistem Pemetaan Keterampilan Warga Desa Karangmulya
                </small>
            </div>

        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        /* =========================================================
                            SCRIPT COUNTER ANGKA STATISTIK
                            Fungsi ini membuat angka statistik naik otomatis saat
                            halaman dimuat agar tampil lebih menarik.
                       ========================================================= */
        const counters = document.querySelectorAll(".stat-number");

        counters.forEach(counter => {
            const target = +counter.getAttribute("data-target");
            const increment = Math.ceil(target / 100);

            const updateCounter = () => {
                const current = +counter.innerText;

                if (current < target) {
                    counter.innerText = Math.min(current + increment, target);
                    setTimeout(updateCounter, 20);
                } else {
                    counter.innerText = target;
                }
            };

            updateCounter();
        });
    </script>

    <script>
      
        (() => {
            const animatedElements = Array.from(document.querySelectorAll('.scroll-animate'));
            if (!animatedElements.length) return;

            /* -----------------------------------------------
               Konfigurasi utama animasi
            ----------------------------------------------- */
            const CONFIG = {
                baseDelay: 100, // jarak stagger antar elemen
                randomJitter: 20, // random kecil agar natural
                enterDuration: 1000, // masuk lebih halus
                exitDuration: 700, // keluar lebih cepat
                enterThreshold: 0.16,
                rootMargin: '0px 0px -10% 0px'
            };

            /* -----------------------------------------------
               Easing berbeda untuk enter & exit
            ----------------------------------------------- */
            const EASING = {
                enter: 'cubic-bezier(0.22, 1, 0.36, 1)', // smooth, natural
                exit: 'ease-in-out' // lebih cepat saat keluar
            };

            /* -----------------------------------------------
               Helper: random kecil agar animasi terasa tidak robotik
            ----------------------------------------------- */
            const randomBetween = (min, max) =>
                Math.floor(Math.random() * (max - min + 1)) + min;

            /* -----------------------------------------------
               Helper: cari group/container terdekat
               Tujuan:
               elemen-elemen yang masih satu area akan distagger
               bersama-sama, bukan seluruh halaman sekaligus
            ----------------------------------------------- */
            function getAnimationGroup(el) {
                return el.closest(
                    '.row, .container, .hero, section, .hero-card, .map-card, .data-box, .contact-card'
                ) || document.body;
            }

            /* -----------------------------------------------
               Buat registry group
               Setiap group menyimpan daftar elemen .scroll-animate di dalamnya
            ----------------------------------------------- */
            const groupMap = new Map();

            animatedElements.forEach((el, globalIndex) => {
                const group = getAnimationGroup(el);

                if (!groupMap.has(group)) {
                    groupMap.set(group, []);
                }

                groupMap.get(group).push(el);

                /* Simpan global index untuk fallback */
                el.dataset.saGlobalIndex = globalIndex;

                /* Simpan jitter random per elemen agar konsisten saat repeat */
                el.dataset.saJitter = randomBetween(0, CONFIG.randomJitter);
            });

            /* -----------------------------------------------
               Simpan index lokal dalam group
               Ini dipakai untuk stagger masuk & reverse stagger keluar
            ----------------------------------------------- */
            groupMap.forEach((groupElements) => {
                groupElements.forEach((el, localIndex) => {
                    el.dataset.saIndex = localIndex;
                    el.dataset.saGroupSize = groupElements.length;
                });
            });

            /* -----------------------------------------------
               Helper: set transition variables per elemen
               mode:
               - enter => muncul satu per satu
               - exit  => hilang reverse stagger
            ----------------------------------------------- */
            function applyDynamicTiming(el, mode = 'enter') {
                const index = Number(el.dataset.saIndex || 0);
                const total = Number(el.dataset.saGroupSize || 1);
                const jitter = Number(el.dataset.saJitter || 0);

                let delay = 0;
                let duration = CONFIG.enterDuration;
                let easing = EASING.enter;

                if (mode === 'enter') {
                    /* Muncul satu per satu sesuai urutan */
                    delay = (index * CONFIG.baseDelay) + jitter;
                    duration = CONFIG.enterDuration + randomBetween(-30, 40);
                    easing = EASING.enter;
                } else {
                    /* Keluar satu per satu dengan urutan terbalik */
                    const reverseIndex = Math.max(total - 1 - index, 0);
                    delay = (reverseIndex * (CONFIG.baseDelay * 0.9)) + Math.floor(jitter * 0.5);
                    duration = CONFIG.exitDuration + randomBetween(-20, 20);
                    easing = EASING.exit;
                }

                el.style.setProperty('--sa-delay', `${delay}ms`);
                el.style.setProperty('--sa-duration', `${duration}ms`);
                el.style.setProperty('--sa-ease', easing);
            }

            /* -----------------------------------------------
               Helper: reset awal supaya semua elemen benar-benar hidden
            ----------------------------------------------- */
            function prepareInitialState() {
                animatedElements.forEach((el) => {
                    el.classList.remove('in-view', 'is-leaving');
                    applyDynamicTiming(el, 'enter');
                });
            }

            prepareInitialState();

            /* -----------------------------------------------
               Track state agar tidak memicu operasi berulang-ulang
            ----------------------------------------------- */
            const stateMap = new WeakMap();

            animatedElements.forEach((el) => {
                stateMap.set(el, {
                    visible: false,
                    entering: false,
                    leaving: false
                });
            });

            /* -----------------------------------------------
               IntersectionObserver utama
            ----------------------------------------------- */
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    const el = entry.target;
                    const state = stateMap.get(el);
                    if (!state) return;

                    if (entry.isIntersecting) {
                        /* -----------------------------------
                           ENTER:
                           - remove leaving state
                           - set timing enter
                           - tampilkan elemen
                        ----------------------------------- */
                        if (!state.visible || state.leaving) {
                            state.visible = true;
                            state.entering = true;
                            state.leaving = false;

                            el.classList.remove('is-leaving');
                            applyDynamicTiming(el, 'enter');

                            /* requestAnimationFrame agar browser
                               sempat membaca perubahan transition vars */
                            requestAnimationFrame(() => {
                                el.classList.add('in-view');
                            });

                            /* Tandai selesai enter */
                            const enterDone = () => {
                                state.entering = false;
                                el.removeEventListener('transitionend', enterDone);
                            };
                            el.addEventListener('transitionend', enterDone);
                        }
                    } else {
                        /* -----------------------------------
                           EXIT:
                           - set timing exit (lebih cepat)
                           - reverse stagger
                           - remove in-view
                        ----------------------------------- */
                        if (state.visible || state.entering) {
                            state.visible = false;
                            state.entering = false;
                            state.leaving = true;

                            applyDynamicTiming(el, 'exit');
                            el.classList.add('is-leaving');

                            requestAnimationFrame(() => {
                                el.classList.remove('in-view');
                            });

                            const exitDone = () => {
                                state.leaving = false;
                                el.classList.remove('is-leaving');
                                el.removeEventListener('transitionend', exitDone);
                            };
                            el.addEventListener('transitionend', exitDone);
                        }
                    }
                });
            }, {
                threshold: CONFIG.enterThreshold,
                root: null,
                rootMargin: CONFIG.rootMargin
            });

            animatedElements.forEach((el) => observer.observe(el));

            /* -----------------------------------------------
               Optional enhancement:
               Jika layout berubah (misalnya map / resize),
               kita refresh sedikit timing agar tetap natural
            ----------------------------------------------- */
            let resizeTimer = null;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    animatedElements.forEach((el) => {
                        if (el.classList.contains('in-view')) {
                            applyDynamicTiming(el, 'enter');
                        } else {
                            applyDynamicTiming(el, 'exit');
                        }
                    });
                }, 120);
            });
        })();
    </script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // 1. BASE LAYERS

        const streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        });

        const satelliteLayer = L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles &copy; Esri &mdash; Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EBP, and the GIS User Community'
            });

        const terrainLayer = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data: &copy; OpenStreetMap, SRTM | Style: &copy; OpenTopoMap'
        });

        // Inisialisasi Map
        const map = L.map('map', {
            center: [-6.39963, 108.11848],
            zoom: 14,
            layers: [streetLayer]
        });
        // ======================
        // PANE
        // ======================

        map.createPane('dusunPane');
        map.createPane('rwPane');
        map.createPane('rtPane');

        map.getPane('dusunPane').style.zIndex = 450;
        map.getPane('rwPane').style.zIndex = 650;
        map.getPane('rtPane').style.zIndex = 700;
        map.getPane('dusunPane').style.pointerEvents = 'none';

        // ======================
        // LAYER
        // ======================

        const polygonLayer = L.layerGroup().addTo(map);
        const dusunLayer = L.layerGroup().addTo(map);
        const rwLayer = L.layerGroup().addTo(map);
        const rtLayer = L.layerGroup().addTo(map);

        // ======================
        // BATAS DESA KARANGMULYA
        // ======================

        fetch("{{ asset('geojson/karangmulya.geojson') }}")
            .then(res => res.json())
            .then(data => {

                const geojson = L.geoJSON(data, {
                    style: {
                        color: '#0d6efd',
                        weight: 3,
                        fillOpacity: 0
                    }
                }).addTo(polygonLayer);

                polygonLayer.bringToBack();

                if (geojson.getBounds().isValid()) {
                    map.fitBounds(geojson.getBounds());
                }

            })
            .catch(err => {
                console.error('Karangmulya GeoJSON Error:', err);
            });

        function warnaKategori(kategori) {

            if (
                !kategori ||
                kategori === 'Tidak Ada Dominan'
            ) {
                return '#6c757d';
            }

            let warnaList = [
                '#198754',
                '#0d6efd',
                '#fd7e14',
                '#6f42c1',
                '#20c997',
                '#dc3545',
                '#6610f2',
                '#d63384',
                '#1982c4',
                '#8ac926',
                '#ffca3a',
                '#ff595e'
            ];

            let index = 0;

            for (let i = 0; i < kategori.length; i++) {
                index += kategori.charCodeAt(i);
            }

            return warnaList[
                index % warnaList.length
            ];
        }

        function warnaPopup(kategori) {
            return warnaKategori(kategori);
        }

        function isiFilter(data) {

            const dusunSelect =
                document.getElementById('filterDusun');

            const rwSelect =
                document.getElementById('filterRw');

            const rtSelect =
                document.getElementById('filterRt');

            dusunSelect.innerHTML =
                '<option value="">Semua Dusun</option>';

            rwSelect.innerHTML =
                '<option value="">Semua RW</option>';

            rtSelect.innerHTML =
                '<option value="">Semua RT</option>';

            let dusunSet = new Set();

            data.dusun.forEach(d => {

                dusunSet.add(
                    d.nama_dusun
                );

            });

            dusunSet.forEach(item => {

                dusunSelect.innerHTML +=
                    `<option value="${item}">
            ${item}
        </option>`;

            });

            data.rw.forEach(rw => {

                if (
                    filterDusun &&
                    rw.nama_dusun != filterDusun
                ) {
                    return;
                }

                rwSelect.innerHTML +=
                    `<option value="${rw.id}">
    RW ${rw.nama_rw}
</option>`;

            });

            let rtSet = new Set();

            data.rt.forEach(rt => {

                if (
                    filterDusun &&
                    rt.nama_dusun != filterDusun
                ) {
                    return;
                }

                rtSet.add(rt.nama_rt);

            });

            [...rtSet]
            .sort()
                .forEach(rtNomor => {

                    rtSelect.innerHTML += `
        <option value="${rtNomor}">
            RT ${rtNomor}
        </option>
    `;

                });

            dusunSelect.value = filterDusun;
            rwSelect.value = filterRw;
            rtSelect.value = filterRt;
        }

        let semuaData = null;

        let filterDusun = '';
        let filterRw = '';
        let filterRt = '';

        // 3. LOAD DATA API (Dusun, RW, RT)
        function loadData() {

            dusunLayer.clearLayers();
            rwLayer.clearLayers();
            rtLayer.clearLayers();

            fetch("{{ url('/api/pemetaan') }}")
                .then(res => res.json())
                .then(apiData => {
                    semuaData = apiData;
                    isiFilter(apiData);
                    // =====================
                    // polygon DUSUN
                    // =====================
                    fetch("{{ asset('geojson/dusunreal.geojson') }}")
                        .then(response => response.json())
                        .then(geojsonData => {

                            console.log(geojsonData);



                            L.geoJSON(geojsonData, {
                                pane: 'dusunPane',
                                interactive: false,
                                bubblingMouseEvents: false,

                                style: function(feature) {

                                    let namaDusun =
                                        feature.properties.dusunbaru ||
                                        feature.properties.nama_dusun ||
                                        feature.properties.NAMA_DUSUN ||
                                        '';

                                    namaDusun = namaDusun.toLowerCase();

                                    let warna = '#0d6efd';

                                    if (namaDusun.includes('kemped')) {
                                        warna = '#198754';
                                    }

                                    if (namaDusun.includes('sukamelang')) {
                                        warna = '#6f42c1';
                                    }

                                    let opacity = 0.35;
                                    let weight = 2;

                                    if (filterDusun) {

                                        if (
                                            !namaDusun.includes(
                                                filterDusun.toLowerCase()
                                            )
                                        ) {
                                            opacity = 0.01;
                                            weight = 1;
                                        } else {
                                            opacity = 0.75;
                                            weight = 5;
                                        }

                                    }

                                    return {
                                        color: warna,
                                        weight: weight,
                                        fillColor: warna,
                                        fillOpacity: opacity
                                    };
                                },

                                onEachFeature: function(feature, layer) {

                                    let namaDusun =
                                        feature.properties.dusunbaru ||
                                        feature.properties.nama_dusun ||
                                        feature.properties.NAMA_DUSUN ||
                                        '';

                                    const dusunData = apiData.dusun.find(d =>
                                        d.nama_dusun.toLowerCase().includes(
                                            namaDusun.toLowerCase()
                                        )
                                    );

                                    if (dusunData) {

                                        layer.bindPopup(`

                                    <div class="popup-modern">

                                    <div class="popup-header"
                                    style="
                                    background:${warnaPopup(
                                        dusunData.keterampilan_dominan
                                    )};
                                    color:white;
                                    ">

                                    <div class="popup-title">
                                    ${dusunData.nama_dusun}
                                    </div>

                                    <div class="popup-subtitle">
                                    Wilayah Dusun
                                    </div>

                                    </div>

                                    <div class="popup-body">

                                    <div class="popup-row">
                                    <span class="popup-label">
                                    Jumlah RW
                                    </span>
                                    <span class="popup-value">
                                    ${dusunData.jumlah_rw || 0}
                                    </span>
                                    </div>

                                    <div class="popup-row">
                                    <span class="popup-label">
                                    Jumlah RT
                                    </span>
                                    <span class="popup-value">
                                    ${dusunData.jumlah_rt || 0}
                                    </span>
                                    </div>

                                    <div class="popup-row">
                                    <span class="popup-label">
                                    Total Warga
                                    </span>
                                    <span class="popup-value">
                                    ${dusunData.jumlah_warga || 0}
                                    </span>
                                    </div>

                                    <div class="popup-row">
                                    <span class="popup-label">
                                    Total Keterampilan
                                    </span>
                                    <span class="popup-value">
                                    ${dusunData.jumlah_keterampilan || 0}
                                    </span>
                                    </div>

                                    <div class="popup-row">
                                    <span class="popup-label">
                                    Kategori Dominan
                                    </span>

                                    <span class="popup-badge"
                                    style="
                                    background:${warnaPopup(
                                        dusunData.keterampilan_dominan
                                    )};
                                    ">
                                    ${dusunData.keterampilan_dominan || '-'}
                                    </span>

                                    </div>

                                    <div class="popup-row">
                                    <span class="popup-label">
                                    Keterampilan Dominan
                                    </span>

                                    <span class="popup-value">
                                    ${dusunData.nama_keterampilan_dominan || '-'}
                                    </span>
                                    </div>

                                    <a href="#${dusunData.id}"
                                    class="btn-popup"
                                    style="
                                    background:${warnaPopup(
                                        dusunData.keterampilan_dominan
                                    )};
                                    ">

                                    <i class="fa-solid fa-eye me-1"></i>
                                    Lihat Detail Dusun

                                    </a>

                                    </div>

                                    </div>

                                    `);
                                    }

                                    layer.on({

                                        mouseover: function(e) {
                                            e.target.setStyle({
                                                weight: 5,
                                                fillOpacity: 0.7
                                            });
                                        },

                                        mouseout: function(e) {
                                            e.target.setStyle({
                                                weight: 2,
                                                fillOpacity: 0.35
                                            });
                                        },

                                        click: function(e) {

                                            layer.bindPopup(layer.getPopup().getContent())
                                                .openPopup(e.latlng);

                                        }

                                    });

                                }

                            }).addTo(dusunLayer);
                            dusunLayer.eachLayer(layer => {
                                layer.off();
                            });

                            // @foreach ($dusuns as $dusun)

                            // @if ($dusun->geojson)

                            // fetch("{{ asset('storage/' . $dusun->geojson) }}")
                            // .then(response => response.json())
                            // .then(geojsonData => {

                            //     L.geoJSON(geojsonData, {

                            //         interactive: false,

                            //         style: {
                            //             color: '#198754',
                            //             weight: 2,
                            //             fillColor: '#198754',
                            //             fillOpacity: 0.35
                            //         }

                            //     }).addTo(dusunLayer);

                            // });

                            // @endif

                            // @endforeach

                        })

                        .catch(error => {

                            console.log('GeoJSON Error:', error);

                        });
                    // MARKER RW
                    // =====================
                    apiData.rw.forEach(rw => {

                        if (!rw.latitude || !rw.longitude) return;

                        L.circleMarker(
                                [Number(rw.latitude), Number(rw.longitude)], {
                                    radius: 14,
                                    color: '#0d6efd',
                                    fillColor: '#0d6efd',
                                    fillOpacity: 1
                                }
                            )
                            .bindPopup(`RW ${rw.nama_rw}`)
                            .addTo(map);

                    });
                    // =====================
                    // MARKER RT
                    // =====================
                    apiData.rt.forEach(rt => {

                        if (!rt.latitude || !rt.longitude) return;

                        L.circleMarker(
                                [Number(rt.latitude), Number(rt.longitude)], {
                                    radius: 8,
                                    color: '#dc3545',
                                    fillColor: '#dc3545',
                                    fillOpacity: 1
                                }
                            )
                            .bindPopup(`RT ${rt.nama_rt}`)
                            .addTo(map);

                    });

                });
        }

        // Jalankan load data
        loadData();
        // setInterval(loadData, 10000); // Sinkronisasi data tiap 10 detik

        document.getElementById(
            'filterDusun'
        ).addEventListener('change', function() {

            filterDusun = this.value;

            filterRw = '';
            filterRt = '';

            isiFilter(semuaData);

            loadData();

        });

        document.getElementById(
            'filterRw'
        ).addEventListener('change', function() {

            filterRw = this.value;

            filterRt = '';

            isiFilter(semuaData);

            loadData();

        });

        document.getElementById(
            'filterRt'
        ).addEventListener('change', function() {

            filterRt = this.value;

            loadData();

        });

        document
            .getElementById('resetFilter')
            .addEventListener('click', function() {

                filterDusun = '';
                filterRw = '';
                filterRt = '';

                document.getElementById(
                    'filterDusun'
                ).value = '';

                document.getElementById(
                    'filterRw'
                ).value = '';

                document.getElementById(
                    'filterRt'
                ).value = '';

                loadData();

            });

        // 4. LAYER CONTROL (DROPDOWN)
        const baseMaps = {
            "<i class='bi bi-map'></i> Peta Jalan": streetLayer,
            "<i class='bi bi-globe'></i> Satelit": satelliteLayer,
            "<i class='bi bi-mountain'></i> Terrain": terrainLayer
        };

        const overlayMaps = {
            "Batas Wilayah": polygonLayer,
            "Titik Dusun": dusunLayer,
            "Titik RW": rwLayer,
            "Titik RT": rtLayer
        };

        // 'collapsed: true' akan mengubah menu menjadi ikon dropdown
        L.control.layers(baseMaps, overlayMaps, {
            collapsed: true,
            position: 'topright'
        }).addTo(map);

        // Responsive adjustment
        window.addEventListener('resize', () => map.invalidateSize());
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            /* Ambil semua link navbar yang mengarah ke section */
            const navLinks = document.querySelectorAll('.navbar .nav-link[href^="#"]');

            /* Ambil semua section yang punya id sesuai href navbar */
            const sections = Array.from(navLinks)
                .map(link => document.querySelector(link.getAttribute("href")))
                .filter(section => section !== null);

            /* Fungsi untuk menghapus active dari semua menu */
            function removeActiveClass() {
                navLinks.forEach(link => link.classList.remove("active"));
            }

            /* Fungsi untuk mengaktifkan menu berdasarkan id section */
            function setActiveLink(targetId) {
                removeActiveClass();

                const activeLink = document.querySelector(
                    `.navbar .nav-link[href="${targetId}"]`
                );

                if (activeLink) {
                    activeLink.classList.add("active");
                }
            }

            /* =====================================================
               1. ACTIVE SAAT MENU DIKLIK
               - Supaya user langsung melihat feedback saat klik
            ===================================================== */
            navLinks.forEach(link => {
                link.addEventListener("click", function() {
                    const targetId = this.getAttribute("href");
                    setActiveLink(targetId);
                });
            });

            /* =====================================================
               2. ACTIVE SAAT SCROLL
               - Observer akan mendeteksi section yang sedang dominan
               - Saat section terlihat, menu terkait akan aktif
            ===================================================== */
            const observerOptions = {
                root: null,
                threshold: 0.05,
                rootMargin: "-80px 0px -40% 0px"
            };

            const sectionObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        setActiveLink(`#${entry.target.id}`);
                    }
                });
            }, observerOptions);

            sections.forEach(section => {
                sectionObserver.observe(section);
            });

            /* =====================================================
               3. DEFAULT ACTIVE SAAT HALAMAN PERTAMA KALI DIBUKA
               - Jika posisi masih di atas, aktifkan Beranda
            ===================================================== */
            if (window.scrollY < 100) {
                setActiveLink("#beranda");
            }
        });
    </script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const kategoriSelect = document.getElementById('kategoriSelect');
    const kategoriLainnyaBox = document.getElementById('kategoriLainnyaBox');
    const kategoriLainnya = document.getElementById('kategoriLainnya');

    kategoriSelect.addEventListener('change', function () {

        if (this.value === 'lainnya') {

            kategoriLainnyaBox.classList.remove('d-none');
            kategoriLainnya.required = true;

        } else {

            kategoriLainnyaBox.classList.add('d-none');
            kategoriLainnya.required = false;
            kategoriLainnya.value = '';

        }

    });

});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil Dikirim',
    text: '{{ session("success") }}',
    confirmButtonColor: '#2f855a'
});

history.replaceState(null, null, '#kontak');

window.addEventListener('load', function () {
    const kontak = document.getElementById('kontak');

    if (kontak) {
        kontak.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
});
</script>
@endif
<script>
document.getElementById('formCariNik').addEventListener('submit', function() {
    this.action = "{{ route('landing') }}#kontak";
});
</script>
@if(request('nik'))

<script>
document.addEventListener('DOMContentLoaded', function() {

    const kontak = document.getElementById('kontak');

    if (kontak) {
        setTimeout(() => {
            kontak.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }, 100);
    }

    @if($hasil)

        @if($jenis == 'warga')

        Swal.fire({
            icon: 'success',
            title: 'Data Ditemukan',
            width: '400px',
            confirmButtonColor: '#2f855a',
            html: `
                <div style="text-align:left;font-size:14px;line-height:1.7">

                    <b>Nama:</b> {{ $hasil->nama }}<br>

                    <b>NIK:</b> {{ $hasil->nik }}<br>

                    <b>Wilayah:</b>
                    Dusun {{ $hasil->rt->rw->dusun->nama_dusun }},
                    RW {{ $hasil->rt->rw->nomor_rw }},
                    RT {{ $hasil->rt->nomor_rt }}<br>

                    <b>Kategori:</b>
                    {{ $hasil->keterampilans->pluck('kategori.nama_kategori')->filter()->unique()->implode(', ') ?: '-' }}
                    <br>

                    <b>Keterampilan:</b>
                    {{ $hasil->keterampilans->pluck('nama_keterampilan')->implode(', ') }}
                    <br>

                    <b>Status:</b>
                    <span style="color:#198754;font-weight:600">
                        Terdaftar
                    </span>

                </div>
            `
        });

        @else

        Swal.fire({
    icon: '{{ $hasil->status == "Disetujui" ? "success" : ($hasil->status == "Ditolak" ? "error" : "info") }}',
    title: 'Data Pengajuan Ditemukan',
    confirmButtonColor: '#2f855a',
    customClass: {
        popup: 'swal-kecil',
        title: 'swal-title-kecil',
        icon: 'swal-icon-kecil'
    },
    html: `
        
                <div style="text-align:left;font-size:14px;line-height:1.7">

                    <b>Nama:</b> {{ $hasil->nama }}<br>

                    <b>NIK:</b> {{ $hasil->nik }}<br>

                    <b>Kategori:</b>
                    {{ $hasil->kategori->nama_kategori ?? '-' }}
                    <br>

                    <b>Keterampilan:</b>
                    {{ $hasil->keterampilan }}
                    <br>

                    <b>Wilayah:</b>
                    Dusun {{ $hasil->dusun }},
                    RW {{ $hasil->rw }},
                    RT {{ $hasil->rt }}
                    <br>

                    <b>Status:</b>
                    <strong>{{ $hasil->status }}</strong>

                    @if($hasil->status == 'Ditolak')
                    <br><br>
                    <b>Alasan Penolakan:</b><br>
                    {{ $hasil->alasan_penolakan }}
                    @endif

                </div>
            `
        });

        @endif

    @else

        Swal.fire({
            icon: 'warning',
            title: 'Data Tidak Ditemukan',
            text: 'NIK belum ditemukan pada data warga maupun data pengajuan.',
            confirmButtonColor: '#f59e0b',
            width: '400px'
        });

    @endif

});
</script>

@endif
</body>

</html>
