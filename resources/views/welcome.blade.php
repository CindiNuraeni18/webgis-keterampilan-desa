<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
    <title>Sistem Informasi Pemetaan Keterampilan Desa</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        /* ===============================
           ROOT VARIABLES - TEMA DESA YANG HIDUP
        =============================== */
        :root {
            --primary: #2f855a;
            --primary-dark: #1f6f4a;
            --primary-light: #68d391;
            --primary-gradient: linear-gradient(135deg, #2f855a 0%, #48bb78 50%, #68d391 100%);
            --light-bg: #f0f7f2;
            --text-dark: #1a2a2a;
            --text-muted: #5a6b6b;
            --white: #ffffff;
            --shadow-sm: 0 4px 15px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 8px 30px rgba(0, 0, 0, 0.10);
            --shadow-lg: 0 15px 50px rgba(0, 0, 0, 0.12);
            --radius-sm: 12px;
            --radius-md: 20px;
            --radius-lg: 28px;
            --transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-dark);
            background: var(--light-bg);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        img,
        svg,
        iframe,
        video {
            max-width: 100%;
            height: auto;
            display: block;
        }

        section {
            scroll-margin-top: 80px;
            padding: 80px 0;
        }

        /* ===============================
           ANIMASI DASAR
        =============================== */
        @keyframes float {
            0%,
            100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-12px);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -200% center;
            }
            100% {
                background-position: 200% center;
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse-dot {
            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.30;
                transform: scale(0.70);
            }
        }

        @keyframes float-particle {
            0% {
                transform: translate(0, 0) scale(1);
                opacity: 0.3;
            }
            25% {
                transform: translate(30px, -60px) scale(1.2);
                opacity: 0.6;
            }
            50% {
                transform: translate(-20px, -120px) scale(0.8);
                opacity: 0.4;
            }
            75% {
                transform: translate(40px, -80px) scale(1.1);
                opacity: 0.7;
            }
            100% {
                transform: translate(0, -160px) scale(1);
                opacity: 0.2;
            }
        }

        /* ===============================
           NAVBAR
        =============================== */
        .navbar {
            background: rgba(255, 255, 255, 0);
            backdrop-filter: blur(0px);
            box-shadow: none;
            padding: 1.2rem 0;
            transition: var(--transition);
            min-height: 80px;
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.08);
            padding: 0.6rem 0;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 800;
            color: var(--white) !important;
            transition: var(--transition);
        }

        .navbar.scrolled .navbar-brand {
            color: var(--primary) !important;
        }

        .logo-navbar {
            width: 48px;
            height: 48px;
            object-fit: contain;
            flex-shrink: 0;
            filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.10));
        }

        .navbar.scrolled .logo-navbar {
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.05));
        }

        .brand-title {
            font-size: 1.1rem;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -0.3px;
        }

        .brand-subtitle {
            font-size: 0.6rem;
            font-weight: 500;
            opacity: 0.8;
            display: block;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .navbar .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            transition: var(--transition);
            position: relative;
            font-size: 0.92rem;
        }

        .navbar.scrolled .nav-link {
            color: var(--text-dark) !important;
        }

        .navbar .nav-link:hover {
            color: var(--white) !important;
            background: rgba(255, 255, 255, 0.12);
        }

        .navbar.scrolled .nav-link:hover {
            color: var(--primary) !important;
            background: rgba(47, 133, 90, 0.08);
        }

        .navbar .nav-link.active {
            color: var(--white) !important;
            font-weight: 600;
        }

        .navbar.scrolled .nav-link.active {
            color: var(--primary) !important;
        }

        .navbar .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 4px;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 3px;
            background: var(--white);
            border-radius: 999px;
            transition: var(--transition);
        }

        .navbar.scrolled .nav-link.active::after {
            background: var(--primary);
        }

        .navbar-toggler {
            border: none;
            padding: 0.4rem 0.6rem;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            border-radius: 10px;
            color: var(--white);
        }

        .navbar.scrolled .navbar-toggler {
            background: rgba(0, 0, 0, 0.05);
            color: var(--text-dark);
        }

        .navbar-toggler:focus {
            box-shadow: none !important;
        }

        /* ===============================
           HERO SECTION
        =============================== */
        .hero {
            position: relative;
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            align-items: center;
            overflow: hidden;
            background:
                linear-gradient(135deg,
                    rgba(8, 35, 24, 0.60) 0%,
                    rgba(8, 35, 24, 0.30) 50%,
                    rgba(8, 35, 24, 0.10) 100%),
                url("{{ asset('images/bg.png') }}") center center / cover no-repeat;
            padding: 100px 0 60px;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 30% 20%, rgba(47, 133, 90, 0.25) 0%, transparent 60%),
                radial-gradient(circle at 70% 80%, rgba(47, 133, 90, 0.15) 0%, transparent 50%);
            pointer-events: none;
            z-index: 1;
        }

        .hero-particles {
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .hero-particles span {
            position: absolute;
            width: 6px;
            height: 6px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            animation: float-particle linear infinite;
        }

        .hero-particles span:nth-child(1) {
            left: 10%;
            top: 20%;
            animation-duration: 18s;
            width: 8px;
            height: 8px;
        }
        .hero-particles span:nth-child(2) {
            left: 20%;
            top: 60%;
            animation-duration: 22s;
            animation-delay: 2s;
        }
        .hero-particles span:nth-child(3) {
            left: 80%;
            top: 15%;
            animation-duration: 16s;
            animation-delay: 4s;
            width: 10px;
            height: 10px;
        }
        .hero-particles span:nth-child(4) {
            left: 85%;
            top: 70%;
            animation-duration: 20s;
            animation-delay: 1s;
        }
        .hero-particles span:nth-child(5) {
            left: 50%;
            top: 85%;
            animation-duration: 24s;
            animation-delay: 3s;
            width: 12px;
            height: 12px;
        }
        .hero-particles span:nth-child(6) {
            left: 5%;
            top: 40%;
            animation-duration: 19s;
            animation-delay: 5s;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.20);
            font-weight: 600;
            font-size: 0.78rem;
            color: var(--white);
            margin-bottom: 20px;
            animation: slideDown 0.6s ease;
        }

        .hero-badge i {
            color: #68d391;
            font-size: 0.85rem;
        }

        .hero h1 {
            font-size: clamp(2.2rem, 7vw, 4.2rem);
            font-weight: 900;
            line-height: 1.10;
            color: var(--white);
            text-shadow: 0 2px 30px rgba(0, 0, 0, 0.20);
            margin-bottom: 16px;
            letter-spacing: -0.02em;
        }

        .hero h1 .highlight {
            background: linear-gradient(135deg, #68d391, #48bb78, #68d391);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 4s ease-in-out infinite;
        }

        .hero p {
            font-size: clamp(0.95rem, 1.2vw, 1.15rem);
            color: rgba(255, 255, 255, 0.90);
            max-width: 580px;
            line-height: 1.8;
            text-shadow: 0 1px 12px rgba(0, 0, 0, 0.10);
            margin-bottom: 0;
        }

        .hero-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 28px;
        }

        .btn-main {
            background: var(--primary-gradient);
            border: none;
            padding: 14px 34px;
            border-radius: 50px;
            font-weight: 700;
            font-size: clamp(0.85rem, 1vw, 1rem);
            color: white !important;
            box-shadow: 0 12px 35px rgba(47, 133, 90, 0.30);
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .btn-main::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), transparent);
            opacity: 0;
            transition: var(--transition);
        }

        .btn-main:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 18px 45px rgba(47, 133, 90, 0.40);
            color: white !important;
        }

        .btn-main:hover::after {
            opacity: 1;
        }

        .btn-main:active {
            transform: scale(0.96);
        }

        .btn-outline-hero {
            border: 2px solid rgba(255, 255, 255, 0.35);
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            color: white !important;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: clamp(0.85rem, 1vw, 1rem);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: var(--transition);
        }

        .btn-outline-hero:hover {
            background: rgba(255, 255, 255, 0.18);
            border-color: rgba(255, 255, 255, 0.50);
            transform: translateY(-2px);
            color: white !important;
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-top: 32px;
            max-width: 480px;
        }

        .hero-stat-card {
            background: rgba(255, 255, 255, 0.10);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 16px;
            padding: 14px 12px;
            text-align: center;
            transition: var(--transition);
        }

        .hero-stat-card:hover {
            background: rgba(255, 255, 255, 0.18);
            transform: translateY(-4px);
        }

        .hero-stat-label {
            display: block;
            font-size: clamp(0.55rem, 0.7vw, 0.70rem);
            font-weight: 600;
            color: rgba(255, 255, 255, 0.70);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .hero-stat-number {
            font-size: clamp(1.5rem, 3vw, 2.2rem);
            font-weight: 900;
            color: var(--white);
            line-height: 1.2;
            margin: 2px 0;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.10);
        }

        .hero-stat-sub {
            font-size: clamp(0.50rem, 0.6vw, 0.65rem);
            color: rgba(255, 255, 255, 0.60);
        }

        /* Hero Card - Carousel */
        .hero-card-wrapper {
            position: relative;
            z-index: 2;
        }

        .hero-card {
            position: relative;
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.20);
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.10);
        }

        .hero-carousel-img {
            width: 100%;
            height: clamp(200px, 35vh, 360px);
            object-fit: cover;
            transition: transform 0.8s ease;
        }

        .carousel-item.active .hero-carousel-img {
            transform: scale(1.03);
        }

        .carousel-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.75) 0%, transparent 100%);
            padding: 24px 18px 16px;
            text-align: left;
        }

        .carousel-caption h6 {
            color: #fff;
            font-weight: 700;
            font-size: clamp(0.85rem, 1.1vw, 1rem);
            margin: 0;
        }

        .carousel-caption small {
            color: rgba(255, 255, 255, 0.70);
            font-size: clamp(0.65rem, 0.8vw, 0.80rem);
        }

        .carousel-indicators {
            position: absolute;
            bottom: 10px;
            right: 14px;
            left: auto;
            margin: 0;
            gap: 5px;
        }

        .carousel-indicators button {
            width: 24px;
            height: 3px;
            border-radius: 999px;
            border: none;
            background: rgba(255, 255, 255, 0.30);
            transition: var(--transition);
            padding: 0;
        }

        .carousel-indicators .active {
            width: 38px;
            background: var(--white);
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 34px;
            height: 34px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.30);
            backdrop-filter: blur(4px);
            border-radius: 50%;
            opacity: 0.5;
            transition: var(--transition);
            border: 1px solid rgba(255, 255, 255, 0.10);
        }

        .carousel-control-prev {
            left: 10px;
        }
        .carousel-control-next {
            right: 10px;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            opacity: 1;
            background: rgba(0, 0, 0, 0.50);
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 14px;
            height: 14px;
            background-size: 60% 60%;
        }

        .hero-badge-live {
            position: absolute;
            top: 14px;
            left: 14px;
            z-index: 10;
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            color: #fff;
            font-size: clamp(0.60rem, 0.7vw, 0.75rem);
            font-weight: 700;
            padding: 4px 14px 4px 10px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            gap: 6px;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .live-dot {
            width: 7px;
            height: 7px;
            background: #4ade80;
            border-radius: 50%;
            display: inline-block;
            animation: pulse-dot 1.5s ease-in-out infinite;
        }

        .hero-wave {
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            line-height: 0;
            z-index: 2;
            pointer-events: none;
        }

        .hero-wave svg {
            width: 100%;
            height: clamp(40px, 8vw, 80px);
            display: block;
        }

        /* ===============================
           SECTION TITLE
        =============================== */
        .section-title {
            font-size: clamp(1.6rem, 3.5vw, 2.5rem);
            font-weight: 800;
            margin-bottom: 12px;
            color: var(--text-dark);
            letter-spacing: -0.02em;
        }

        .section-title .highlight {
            color: var(--primary);
        }

        .section-subtitle {
            color: var(--text-muted);
            max-width: 680px;
            margin: 0 auto 45px auto;
            font-size: clamp(0.95rem, 1.1vw, 1.1rem);
            line-height: 1.7;
        }

        .section-badge {
            display: inline-block;
            padding: 4px 16px;
            border-radius: 999px;
            background: rgba(47, 133, 90, 0.10);
            color: var(--primary);
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .bg-soft {
            background: var(--light-bg);
        }

        /* ===============================
           FEATURE CARDS
        =============================== */
        .feature-card {
            background: var(--white);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            padding: 32px 24px;
            height: 100%;
            transition: var(--transition);
            border: 1px solid rgba(0, 0, 0, 0.03);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
            opacity: 0;
            transition: var(--transition);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-md);
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: var(--primary-gradient);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            margin-bottom: 18px;
            box-shadow: 0 8px 24px rgba(47, 133, 90, 0.20);
        }

        .feature-card h5 {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 10px;
        }

        .feature-card p {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.7;
            margin: 0;
        }

        /* ===============================
           STATISTIK CARD
        =============================== */
        .stat-card {
            background: var(--white);
            border-radius: var(--radius-md);
            padding: 24px 18px;
            text-align: center;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            height: 100%;
            border: 1px solid rgba(0, 0, 0, 0.03);
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--primary-gradient);
            opacity: 0;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-md);
        }

        .stat-card:hover::after {
            opacity: 1;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 14px;
            border-radius: 16px;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 8px 24px rgba(47, 133, 90, 0.18);
        }

        .stat-number {
            font-size: clamp(1.6rem, 2.5vw, 2.2rem);
            font-weight: 900;
            color: var(--primary);
            line-height: 1.2;
        }

        .stat-card p {
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 500;
            margin: 4px 0 0;
        }

        /* ===============================
           DATA BOX
        =============================== */
        .data-box {
            background: var(--primary-gradient);
            color: white;
            border-radius: var(--radius-lg);
            padding: 45px 40px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(47, 133, 90, 0.20);
        }

        .data-box::before {
            content: '';
            position: absolute;
            top: -120px;
            right: -120px;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .data-box::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.04);
            border-radius: 50%;
        }

        .data-box .comparison-box {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: var(--radius-md);
            padding: 28px 24px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            height: 100%;
            position: relative;
            z-index: 1;
        }

        .data-box .comparison-box h4 {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        .compare-bar {
            width: 100%;
            height: 10px;
            border-radius: 999px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.12);
        }

        .compare-fill {
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, #d9f99d, #ffffff);
            transition: width 1.2s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .wilayah-card {
            margin-bottom: 18px;
        }

        .wilayah-card:last-child {
            margin-bottom: 0;
        }

        .wilayah-card .d-flex {
            margin-bottom: 6px;
        }

        .wilayah-card h6 {
            font-weight: 600;
            font-size: 0.92rem;
            margin: 0;
            color: rgba(255, 255, 255, 0.95);
        }

        .wilayah-card .jumlah-box {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .wilayah-card .jumlah-box small {
            font-weight: 400;
            opacity: 0.7;
            font-size: 0.75rem;
        }

        /* ===============================
           WILAYAH TABLE
        =============================== */
        .wilayah-table-box {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            border-radius: var(--radius-md);
            padding: 28px 24px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            height: 100%;
            position: relative;
            z-index: 1;
        }

        .wilayah-table {
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .wilayah-table thead th {
            border: none;
            background: rgba(255, 255, 255, 0.06);
            padding: 12px 14px;
            font-size: 0.78rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            color: rgba(255, 255, 255, 0.70);
        }

        .wilayah-table thead th:first-child {
            border-radius: 10px 0 0 10px;
        }
        .wilayah-table thead th:last-child {
            border-radius: 0 10px 10px 0;
        }

        .wilayah-table tbody tr {
            background: rgba(255, 255, 255, 0.04);
            transition: var(--transition);
            border-radius: 10px;
        }

        .wilayah-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .wilayah-table tbody td {
            border: none;
            padding: 12px 14px;
            vertical-align: middle;
            font-size: 0.88rem;
        }

        .wilayah-table tbody td:first-child {
            border-radius: 10px 0 0 10px;
        }
        .wilayah-table tbody td:last-child {
            border-radius: 0 10px 10px 0;
        }

        .skill-badge {
            padding: 4px 14px;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 600;
            display: inline-block;
            background: rgba(255, 255, 255, 0.12);
            color: rgba(255, 255, 255, 0.95);
        }

        /* ===============================
           CONTACT
        =============================== */
        .contact-card {
            background: var(--white);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            padding: 32px 28px;
            height: 100%;
            transition: var(--transition);
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .contact-card:hover {
            box-shadow: var(--shadow-md);
        }

        .contact-card h4 {
            font-weight: 700;
            font-size: 1.2rem;
        }

        .contact-card .form-control {
            border-radius: var(--radius-sm);
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            transition: var(--transition);
            font-size: 0.92rem;
        }

        .contact-card .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(47, 133, 90, 0.10);
        }

        .contact-card .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 4px;
        }

        .contact-card .input-group-text {
            background: #f7faf7;
            border: 1px solid #e2e8f0;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .contact-card .btn-main {
            width: 100%;
            justify-content: center;
        }

        /* ===============================
           MAP - TETAP PERTAHANKAN
        =============================== */
        .map-card {
            background: var(--white);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .map-header {
            padding: 18px 24px;
            background: var(--white);
            border-bottom: 1px solid #eef2f7;
        }

        .map-header h5 {
            font-weight: 700;
            font-size: 1.05rem;
            margin: 0;
        }

        .map-header p {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin: 0;
        }

        #map {
            height: 400px;
            width: 100%;
            border-radius: 0;
            z-index: 1;
        }

        #legend-box {
            position: absolute;
            bottom: 20px;
            right: 20px;
            z-index: 999;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 14px 18px;
            border-radius: 14px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
            min-width: 160px;
            font-size: 0.82rem;
            line-height: 1.6;
            border: 1px solid rgba(255, 255, 255, 0.30);
        }

        #legend-box h6 {
            font-weight: 700;
            margin-bottom: 8px;
            font-size: 0.85rem;
        }

        .kotak {
            display: inline-block;
            width: 14px;
            height: 14px;
            margin-right: 8px;
            border-radius: 4px;
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
            width: 12px;
            height: 12px;
        }
        .kecil {
            width: 8px;
            height: 8px;
        }

        /* ===============================
           FOOTER
        =============================== */
        .footer-desa {
            background: #0d2a1a;
            color: #ffffff;
            padding: 50px 0 20px;
        }

        .footer-desa h5,
        .footer-desa h6 {
            color: #fff;
            font-weight: 700;
        }

        .footer-desa p {
            color: rgba(255, 255, 255, 0.75);
            line-height: 1.8;
            font-size: 0.92rem;
        }

        .footer-desa a {
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            transition: var(--transition);
        }

        .footer-desa a:hover {
            color: #68d391;
            padding-left: 4px;
        }

        .footer-desa hr {
            border-color: rgba(255, 255, 255, 0.08);
            margin: 25px 0;
        }

        .footer-desa i {
            color: #68d391;
            width: 20px;
        }

        /* ===============================
           SCROLL ANIMATION
        =============================== */
        .scroll-animate {
            opacity: 0;
            transform: translate3d(0, 40px, 0) scale(0.97);
            will-change: opacity, transform;
            backface-visibility: hidden;
            transition: all 0.8s cubic-bezier(0.22, 1, 0.36, 1) 0s;
        }

        .scroll-animate.in-view {
            opacity: 1;
            transform: translate3d(0, 0, 0) scale(1);
        }

        .fade-up {
            transform: translate3d(0, 40px, 0) scale(0.97);
        }
        .fade-left {
            transform: translate3d(-40px, 0, 0) scale(0.97);
        }
        .fade-right {
            transform: translate3d(40px, 0, 0) scale(0.97);
        }

        .delay-1 {
            transition-delay: 0.08s;
        }
        .delay-2 {
            transition-delay: 0.18s;
        }
        .delay-3 {
            transition-delay: 0.30s;
        }
        .delay-4 {
            transition-delay: 0.42s;
        }
        .delay-5 {
            transition-delay: 0.55s;
        }
        .delay-6 {
            transition-delay: 0.68s;
        }

        /* ===============================
           FILTER
        =============================== */
        .filter-group {
            position: relative;
        }

        .filter-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            z-index: 10;
            font-size: 0.9rem;
        }

        .filter-select {
            height: 48px;
            border-radius: var(--radius-sm);
            border: 1px solid #e2e8f0;
            padding-left: 40px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: var(--transition);
            background: #fafcfa;
        }

        .filter-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(47, 133, 90, 0.10);
        }

        .btn-reset {
            height: 48px;
            border: none;
            border-radius: var(--radius-sm);
            font-weight: 600;
            color: #fff;
            background: var(--primary-gradient);
            transition: var(--transition);
            width: 100%;
            font-size: 0.9rem;
        }

        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(47, 133, 90, 0.25);
            color: #fff;
        }

        /* ===============================
           RESPONSIVE - SMARTPHONE
        =============================== */
        @media (max-width: 575.98px) {
            section {
                padding: 50px 0;
            }

            .hero {
                padding: 120px 0 40px;
                min-height: 90dvh;
            }

            .hero h1 {
                font-size: 1.8rem;
            }

            .hero p {
                font-size: 0.92rem;
            }

            .hero-stats {
                gap: 8px;
            }

            .hero-stat-card {
                padding: 10px 8px;
            }

            .hero-stat-number {
                font-size: 1.3rem;
            }

            .hero-buttons {
                flex-direction: column;
                width: 100%;
            }

            .hero-buttons .btn-main,
            .hero-buttons .btn-outline-hero {
                width: 100%;
                justify-content: center;
            }

            .hero-card {
                border-radius: var(--radius-sm);
            }

            .hero-carousel-img {
                height: 180px;
            }

            .carousel-caption {
                padding: 14px 12px 10px;
            }

            .carousel-caption h6 {
                font-size: 0.75rem;
            }

            .carousel-caption small {
                font-size: 0.60rem;
            }

            .carousel-control-prev,
            .carousel-control-next {
                width: 26px;
                height: 26px;
            }

            .section-title {
                font-size: 1.5rem;
            }

            .section-subtitle {
                font-size: 0.9rem;
                margin-bottom: 30px;
            }

            .feature-card {
                padding: 24px 18px;
            }

            .stat-card {
                padding: 18px 12px;
            }

            .stat-icon {
                width: 48px;
                height: 48px;
                font-size: 1.2rem;
            }

            .stat-number {
                font-size: 1.4rem;
            }

            .data-box {
                padding: 28px 18px;
                border-radius: var(--radius-md);
            }

            .data-box .comparison-box,
            .wilayah-table-box {
                padding: 18px 14px;
            }

            .contact-card {
                padding: 24px 18px;
            }

            #map {
                height: 300px;
            }

            #legend-box {
                bottom: 12px;
                right: 12px;
                padding: 10px 14px;
                font-size: 0.7rem;
                min-width: 130px;
            }

            .footer-desa {
                padding: 30px 0 15px;
            }

            .hero-badge-live {
                font-size: 0.55rem;
                padding: 3px 10px 3px 8px;
                top: 8px;
                left: 8px;
            }

            .live-dot {
                width: 5px;
                height: 5px;
            }

            .navbar {
                padding: 0.6rem 0;
            }

            .logo-navbar {
                width: 38px;
                height: 38px;
            }

            .brand-title {
                font-size: 0.9rem;
            }
        }

        /* ===============================
           RESPONSIVE - TABLET
        =============================== */
        @media (min-width: 576px) and (max-width: 991.98px) {
            .hero {
                padding: 130px 0 50px;
                min-height: auto;
            }

            .hero h1 {
                font-size: 2.6rem;
            }

            .hero-carousel-img {
                height: 250px;
            }

            .section-title {
                font-size: 2rem;
            }

            #map {
                height: 380px;
            }

            .data-box {
                padding: 35px 28px;
            }

            .navbar-collapse {
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(12px);
                border-radius: var(--radius-sm);
                padding: 12px 16px;
                margin-top: 12px;
                box-shadow: var(--shadow-md);
            }

            .navbar .nav-link {
                color: var(--text-dark) !important;
            }

            .navbar .nav-link.active {
                color: var(--primary) !important;
            }

            .navbar .nav-link.active::after {
                background: var(--primary);
            }
        }

        /* ===============================
           RESPONSIVE - DESKTOP
        =============================== */
        @media (min-width: 992px) {
            .hero {
                min-height: 100vh;
                min-height: 100dvh;
            }

            .hero h1 {
                font-size: 4rem;
            }
        }

        /* ===============================
           ORIENTASI LANDSCAPE
        =============================== */
        @media (max-height: 500px) and (orientation: landscape) {
            .hero {
                min-height: 100vh;
                padding: 90px 0 30px;
            }

            .hero h1 {
                font-size: 1.8rem;
            }

            .hero p {
                font-size: 0.85rem;
                max-width: 70%;
            }

            .hero-carousel-img {
                height: 160px;
            }

            .hero-stats {
                grid-template-columns: repeat(3, 1fr);
                gap: 6px;
                max-width: 400px;
            }

            .hero-stat-number {
                font-size: 1.2rem;
            }

            .hero-stat-card {
                padding: 6px 8px;
            }

            .hero-buttons .btn-main,
            .hero-buttons .btn-outline-hero {
                padding: 8px 20px;
                font-size: 0.75rem;
            }

            .carousel-caption {
                padding: 8px 12px 6px;
            }

            .carousel-caption h6 {
                font-size: 0.7rem;
            }

            .carousel-caption small {
                font-size: 0.55rem;
            }

            .hero-wave svg {
                height: 20px;
            }
        }

        /* ===============================
           ACCESSIBILITY
        =============================== */
        @media (prefers-reduced-motion: reduce) {
            .scroll-animate,
            .scroll-animate.in-view {
                transition: none !important;
                transform: none !important;
                opacity: 1 !important;
            }

            .hero h1 .highlight {
                animation: none !important;
                -webkit-text-fill-color: #68d391;
            }

            .live-dot {
                animation: none !important;
            }

            .hero-particles span {
                animation: none !important;
                display: none;
            }

            .btn-main,
            .btn-outline-hero,
            .feature-card,
            .stat-card,
            .hero-stat-card,
            .carousel-control-prev,
            .carousel-control-next {
                transition: none !important;
            }

            .btn-main:hover,
            .btn-outline-hero:hover {
                transform: none !important;
            }

            .feature-card:hover {
                transform: none !important;
            }

            .stat-card:hover {
                transform: none !important;
            }
        }

        /* ===============================
           TOUCH DEVICE
        =============================== */
        @media (hover: none) {
            .feature-card:hover {
                transform: none !important;
            }
            .stat-card:hover {
                transform: none !important;
            }
            .hero-stat-card:hover {
                transform: none !important;
            }
            .btn-main:hover {
                transform: none !important;
            }
            .btn-outline-hero:hover {
                transform: none !important;
            }
            .carousel-control-prev:hover,
            .carousel-control-next:hover {
                opacity: 0.5 !important;
            }
        }

        /* ===============================
           PRINT
        =============================== */
        @media print {
            .hero {
                background: #ffffff !important;
                min-height: auto !important;
                padding: 20px 0 !important;
            }

            .hero h1 {
                color: #1a2a2a !important;
                text-shadow: none !important;
            }

            .hero h1 .highlight {
                -webkit-text-fill-color: #2f855a !important;
            }

            .hero p {
                color: #4a5a5a !important;
                text-shadow: none !important;
            }

            .hero-badge {
                background: #f0f7f2 !important;
                color: #2f855a !important;
            }

            .btn-main,
            .btn-outline-hero {
                border: 1px solid #d1d5db !important;
                background: #f9fafb !important;
                color: #1a2a2a !important;
                box-shadow: none !important;
            }

            .hero-card {
                box-shadow: none !important;
                border: 1px solid #e5e7eb !important;
            }

            .hero-badge-live {
                display: none !important;
            }

            .hero-particles {
                display: none !important;
            }

            .hero-wave {
                display: none !important;
            }

            .carousel-control-prev,
            .carousel-control-next,
            .carousel-indicators {
                display: none !important;
            }

            .scroll-animate {
                opacity: 1 !important;
                transform: none !important;
            }

            section {
                padding: 30px 0 !important;
            }

            .navbar {
                background: #ffffff !important;
                position: static !important;
            }

            .navbar .nav-link {
                color: #1a2a2a !important;
            }
        }

        /* ===============================
           POPUP MODERN - TETAP PERTAHANKAN
        =============================== */
        .leaflet-popup-content-wrapper {
            border-radius: 18px !important;
            padding: 0 !important;
            overflow: hidden;
            box-shadow: 0 12px 30px rgba(0, 0, 0, .15);
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
            background: linear-gradient(135deg, #2563eb, #3b82f6);
        }

        .popup-header-rt {
            background: linear-gradient(135deg, #dc2626, #ef4444);
        }

        .popup-header-dusun {
            background: linear-gradient(135deg, #198754, #20c997);
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
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: white !important;
            font-weight: 600;
            transition: .3s ease;
        }

        .btn-popup:hover {
            transform: translateY(-2px);
            color: white !important;
            box-shadow: 0 8px 18px rgba(37, 99, 235, .25);
        }

        @media(max-width:576px) {
            .leaflet-popup-content {
                min-width: 240px;
            }
        }

        /* ===============================
           LAYER CONTROL CUSTOM
        =============================== */
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

        /* ===============================
           LEAFLET LAYER CONTROL OVERRIDE
        =============================== */
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
    </style>
</head>

<body>

    <!-- ===============================
         NAVBAR
    ================================ -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#beranda">
                <img src="{{ asset('images/logo-indramayu.png') }}" alt="Logo Indramayu" class="logo-navbar">
                <div>
                    <span class="brand-title">SIKARMAP</span>
                    <span class="brand-subtitle">Desa Karangmulya</span>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#beranda">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#fitur">Pemetaan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#data">Statistik</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kontak">Pengajuan</a></li>
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ===============================
         HERO SECTION
    ================================ -->
    <section class="hero" id="beranda">
        <!-- Partikel Dekoratif -->
        <div class="hero-particles">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>

        <div class="container">
            <div class="row align-items-center g-4 g-lg-5">
                <!-- KONTEN KIRI -->
                <div class="col-lg-6 order-2 order-lg-1">
                    <div class="hero-content text-center text-lg-start">
                        <div class="hero-badge scroll-animate fade-up delay-1">
                            <i class="fas fa-map-pin"></i>
                            Desa Karangmulya
                        </div>

                        <h1 class="scroll-animate fade-up delay-1">
                            Sistem Pemetaan<br>
                            <span class="highlight">Keterampilan Warga</span>
                        </h1>

                        <p class="scroll-animate fade-up delay-2">
                            Sistem berbasis WebGIS untuk mengelola, menampilkan, dan memetakan
                            data keterampilan warga berdasarkan wilayah RT, RW, dan dusun secara digital.
                        </p>

                        <div class="hero-buttons scroll-animate fade-up delay-3">
                            <a href="#fitur" class="btn-main">
                                <i class="fas fa-map"></i> Lihat Peta
                            </a>
                            <a href="#tentang" class="btn-outline-hero">
                                <i class="fas fa-info-circle"></i> Pelajari
                            </a>
                        </div>

                        <!-- Statistik -->
                        <div class="hero-stats scroll-animate fade-up delay-3">
                            <div class="hero-stat-card">
                                <span class="hero-stat-label">Total Kategori</span>
                                <div class="hero-stat-number">{{ $totalKategori ?? 12 }}</div>
                            </div>
                            <div class="hero-stat-card">
                                <span class="hero-stat-label">Warga Terdata</span>
                                <div class="hero-stat-number">{{ $totalSkill ?? 847 }}</div>
                            </div>
                            <div class="hero-stat-card">
                                <span class="hero-stat-label">Wilayah</span>
                                <div class="hero-stat-number">3</div>
                                <span class="hero-stat-sub">Dusun</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KONTEN KANAN - CAROUSEL -->
                <div class="col-lg-6 order-1 order-lg-2 scroll-animate fade-right delay-2">
                    <div class="hero-card-wrapper">
                        <div class="hero-card">
                            <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="{{ asset('images/kantor-desa.jpeg') }}"
                                            alt="Kantor Desa Karangmulya"
                                            class="hero-carousel-img"
                                            loading="lazy">
                                        <div class="carousel-caption">
                                            <h6>Kantor Desa Karangmulya</h6>
                                            <small>Kec. Kandanghaur, Kab. Indramayu</small>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <img src="{{ asset('images/desa.jpeg') }}"
                                            alt="Lingkungan Desa"
                                            class="hero-carousel-img"
                                            loading="lazy">
                                        <div class="carousel-caption">
                                            <h6>Lingkungan Asri</h6>
                                            <small>Potensi Alam Desa Karangmulya</small>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <img src="{{ asset('images/bg.png') }}"
                                            alt="Potensi Desa"
                                            class="hero-carousel-img"
                                            loading="lazy">
                                        <div class="carousel-caption">
                                            <h6>Potensi Desa</h6>
                                            <small>Kekayaan Sumber Daya Manusia</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-label="Slide 1"></button>
                                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                </div>

                                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>

                            <div class="hero-badge-live">
                                <span class="live-dot"></span>
                                Live
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gelombang -->
        <div class="hero-wave">
            <svg viewBox="0 0 1440 120" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path fill="#ffffff" fill-opacity="1"
                    d="M0,64L80,64C160,64,320,64,480,58.7C640,53,800,43,960,48C1120,53,1280,75,1360,85.3L1440,96L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z">
                </path>
            </svg>
        </div>
    </section>

    <!-- ===============================
         TENTANG SISTEM
    ================================ -->
    <section id="tentang" class="bg-soft">
        <div class="container">
            <div class="text-center mb-5 scroll-animate fade-up">
                <span class="section-badge">Tentang Kami</span>
                <h2 class="section-title">
                    Mengenal <span class="highlight">SIKARMAP</span>
                </h2>
                <p class="section-subtitle">
                    SIKARMAP merupakan Sistem Pemetaan Keterampilan Warga Desa Karangmulya berbasis WebGIS
                    yang digunakan untuk mengelola, memvisualisasikan, dan memetakan data keterampilan warga
                    berdasarkan wilayah RT, RW, dan dusun ke dalam bentuk peta digital secara interaktif.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-md-4 scroll-animate fade-up">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-map"></i>
                        </div>
                        <h5>Fungsi Sistem</h5>
                        <p>Membantu mengelola dan menampilkan keterampilan warga desa secara digital melalui peta interaktif yang mudah diakses.</p>
                    </div>
                </div>

                <div class="col-md-4 scroll-animate fade-up delay-2">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-bar-chart"></i>
                        </div>
                        <h5>Manfaat Sistem</h5>
                        <p>Membantu pemerintah desa dan masyarakat mengetahui keterampilan warga yang lebih banyak dimiliki di setiap wilayah desa.</p>
                    </div>
                </div>

                <div class="col-md-4 scroll-animate fade-up delay-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <h5>Fitur Utama</h5>
                        <p>Menyediakan peta digital, statistik data, dan pemetaan keterampilan warga berdasarkan wilayah desa secara real-time.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===============================
         PEMETAAN - TETAP SAMA (MARKER & POPUP TIDAK DIRUBAH)
    ================================ -->
    <section id="fitur" class="bg-soft scroll-animate fade-up">
        <div class="container">
            <div class="text-center mb-5 scroll-animate fade-up delay-1">
                <span class="section-badge">Pemetaan</span>
                <h2 class="section-title">
                    Peta <span class="highlight">Keterampilan Warga</span>
                </h2>
                <p class="section-subtitle">
                    Menampilkan sebaran keterampilan warga Desa Karangmulya secara interaktif
                    dalam bentuk peta digital berdasarkan wilayah RT, RW, dan dusun.
                </p>
            </div>

            <!-- Filter -->
            <div class="row g-3 align-items-center mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="filter-group">
                        <i class="fa-solid fa-map-location-dot filter-icon"></i>
                        <select id="filterDusun" class="form-select filter-select">
                            <option value="">Semua Dusun</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="filter-group">
                        <i class="fa-solid fa-location-dot filter-icon"></i>
                        <select id="filterRt" class="form-select filter-select">
                            <option value="">Semua RT / RW</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="filter-group">
                        <i class="fa-solid fa-tags filter-icon"></i>
                        <select id="filterKategori" class="form-select filter-select">
                            <option value="">Semua Kategori</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <button id="resetFilter" class="btn btn-reset">
                        <i class="fa-solid fa-rotate-left me-2"></i>
                        Reset Filter
                    </button>
                </div>
            </div>

            <!-- Map -->
            <div class="card card-map border-0 shadow-sm">
                <div class="card-body position-relative">
                    <div id="map"></div>
                    <div id="legend-box">
                        <h6><i class="fas fa-layer-group me-1"></i> Keterangan</h6>
                        <p>
                            <span class="kotak hijau"></span> Dusun Kemped
                        </p>
                        <p>
                            <span class="kotak ungu"></span> Dusun Sukamelang
                        </p>
                        <hr>
                        <p><span class="bulat besar"></span> Keterampilan Warga</p>
                        <small class="text-muted">Warna: Kategori | Ukuran: Jumlah</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===============================
         STATISTIK & DATA
    ================================ -->
    <section id="data" class="scroll-animate fade-up">
        <div class="container">
            <div class="text-center mb-5 scroll-animate fade-up delay-1">
                <span class="section-badge">Statistik</span>
                <h2 class="section-title">
                    Data & <span class="highlight">Statistik Desa</span>
                </h2>
                <p class="section-subtitle">
                    Berikut data sebaran keterampilan warga Desa Karangmulya berdasarkan data terbaru pada sistem.
                </p>
            </div>

            <!-- Statistik Cards -->
            <div class="row g-3 g-md-4 mb-5">
                <div class="col-6 col-md-2 scroll-animate zoom-soft delay-1">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                        <div class="stat-number" data-target="{{ $totalWarga ?? 0 }}">0</div>
                        <p>Total Warga</p>
                    </div>
                </div>
                <div class="col-6 col-md-2 scroll-animate zoom-soft delay-2">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="bi bi-briefcase-fill"></i></div>
                        <div class="stat-number" data-target="{{ $totalSkill ?? 0 }}">0</div>
                        <p>Warga Berketerampilan</p>
                    </div>
                </div>
                <div class="col-6 col-md-2 scroll-animate zoom-soft delay-3">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="bi bi-grid-fill"></i></div>
                        <div class="stat-number" data-target="{{ $totalKategori ?? 0 }}">0</div>
                        <p>Kategori Keterampilan</p>
                    </div>
                </div>
                <div class="col-6 col-md-2 scroll-animate zoom-soft delay-4">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="bi bi-geo-alt-fill"></i></div>
                        <div class="stat-number" data-target="{{ $totalDusun ?? 0 }}">0</div>
                        <p>Total Dusun</p>
                    </div>
                </div>
                <div class="col-6 col-md-2 scroll-animate zoom-soft delay-5">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="bi bi-diagram-3-fill"></i></div>
                        <div class="stat-number" data-target="{{ $totalRw ?? 0 }}">0</div>
                        <p>Total RW</p>
                    </div>
                </div>
                <div class="col-6 col-md-2 scroll-animate zoom-soft delay-6">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="bi bi-signpost-2-fill"></i></div>
                        <div class="stat-number" data-target="{{ $totalRt ?? 0 }}">0</div>
                        <p>Total RT</p>
                    </div>
                </div>
            </div>

            <!-- Visualisasi Data -->
            <div class="data-box scroll-animate fade-up delay-2">
                <div class="row g-4">
                    <div class="col-lg-6 scroll-animate fade-left delay-2">
                        <div class="comparison-box">
                            <h4><i class="fas fa-chart-bar me-2"></i> Kategori Keterampilan</h4>
                            @php
                                $maxKategori = isset($kategoriChart) ? $kategoriChart->max('total') : 1;
                            @endphp
                            @foreach (isset($kategoriChart) ? $kategoriChart->take(5) : [] as $item)
                                <div class="wilayah-card">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6>{{ $item->nama_kategori ?? 'Kategori' }}</h6>
                                        <div class="jumlah-box">
                                            <strong>{{ $item->total ?? 0 }}</strong>
                                            <small>Orang</small>
                                        </div>
                                    </div>
                                    <div class="compare-bar">
                                        <div class="compare-fill" style="width: {{ (($item->total ?? 0) / max($maxKategori, 1)) * 100 }}%;"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-lg-6 scroll-animate fade-right delay-3">
                        <div class="wilayah-table-box">
                            <h4><i class="fas fa-table me-2"></i> Sebaran Wilayah</h4>
                            <div class="table-responsive">
                                <table class="table wilayah-table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Wilayah</th>
                                            <th>Keterampilan Dominan</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (isset($statistikDusun) ? $statistikDusun->take(5) : [] as $item)
                                            <tr>
                                                <td>
                                                    <div class="fw-semibold">RT {{ $item->rt ?? '-' }} / RW {{ $item->rw ?? '-' }}</div>
                                                    <small class="opacity-75">Dusun {{ $item->nama_dusun ?? '-' }}</small>
                                                </td>
                                                <td>
                                                    <span class="skill-badge">{{ $item->nama_kategori ?? '-' }}</span>
                                                </td>
                                                <td><strong>{{ $item->total_skill ?? 0 }}</strong> Orang</td>
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
    </section>

    <!-- ===============================
         PENGAJUAN KETERAMPILAN
    ================================ -->
    <section id="kontak" class="bg-soft scroll-animate fade-up">
        <div class="container">
            <div class="text-center mb-5 scroll-animate fade-up delay-1">
                <span class="section-badge">Pengajuan</span>
                <h2 class="section-title">
                    Ajukan <span class="highlight">Keterampilan</span>
                </h2>
                <p class="section-subtitle">
                    Masyarakat Desa Karangmulya yang memiliki keterampilan, usaha, atau potensi yang belum terdata
                    dapat mengajukan informasi melalui formulir berikut untuk mendukung pendataan potensi SDM desa.
                </p>
            </div>

            <div class="row g-4">
                <!-- Cari Data -->
                <div class="col-lg-5 scroll-animate fade-left delay-2">
                    <div class="contact-card">
                        <div class="mb-4">
                            <h4><i class="fas fa-search text-primary me-2"></i> Cari Data Warga</h4>
                            <p class="text-muted small mb-0">
                                Masukkan NIK untuk melihat apakah data keterampilan sudah terdaftar dalam sistem.
                            </p>
                        </div>

                        <form action="{{ route('landing') }}#kontak" method="GET" id="formCariNik">
                            <div class="mb-3">
                                <label class="form-label">Nomor Induk Kependudukan (NIK)</label>
                                <input type="text" name="nik" maxlength="16" class="form-control"
                                    placeholder="Masukkan 16 digit NIK" required>
                            </div>
                            <button type="submit" class="btn btn-main">
                                <i class="bi bi-search me-2"></i>
                                Cari Data
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Form Pengajuan -->
                <div class="col-lg-7 scroll-animate fade-right delay-3">
                    <div class="contact-card">
                        <h4 class="fw-bold mb-4"><i class="fas fa-pen-fancy text-primary me-2"></i> Form Pengajuan</h4>

                        <form action="{{ route('pesan.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control"
                                        placeholder="Masukkan nama lengkap" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK</label>
                                    <input type="text" name="nik" class="form-control" maxlength="16"
                                        placeholder="Masukkan 16 digit NIK" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nomor HP</label>
                                    <input type="text" name="nomor_hp" class="form-control"
                                        placeholder="081234567890" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Dusun</label>
                                    <input type="text" name="dusun" class="form-control"
                                        placeholder="Nama Dusun" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Wilayah</label>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="input-group">
                                                <span class="input-group-text">RW</span>
                                                <input type="text" name="rw" class="form-control" placeholder="01">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="input-group">
                                                <span class="input-group-text">RT</span>
                                                <input type="text" name="rt" class="form-control" placeholder="01">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kategori Keterampilan</label>
                                    <select name="kategori_keterampilan_id" id="kategoriSelect" class="form-select" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach (isset($kategoriKeterampilans) ? $kategoriKeterampilans : [] as $kategori)
                                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                        @endforeach
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div class="col-md-6 d-none" id="kategoriLainnyaBox">
                                    <label class="form-label">Nama Kategori Baru</label>
                                    <input type="text" name="kategori_lainnya" id="kategoriLainnya"
                                        class="form-control" placeholder="Masukkan kategori baru">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Keterampilan</label>
                                    <input type="text" name="keterampilan" class="form-control"
                                        placeholder="Contoh: Menjahit, Bertani, Servis" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="pesan" class="form-control" rows="4"
                                        placeholder="Jelaskan keterampilan, usaha, atau potensi yang ingin diajukan." required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-main">
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
                        <i class="fas fa-map-pin me-2"></i>
                        SIKARMAP
                    </h5>
                    <p>
                        Sistem informasi untuk mendukung pendataan dan pemetaan
                        keterampilan masyarakat Desa Karangmulya guna menunjang
                        pembangunan desa berbasis potensi warga.
                    </p>
                </div>
                <div class="col-lg-4">
                    <h6 class="fw-bold mb-3"><i class="fas fa-address-book me-2"></i>Kontak Desa</h6>
                    <p><i class="bi bi-geo-alt-fill me-2"></i>Desa Karangmulya, Kec. Kandanghaur, Kab. Indramayu</p>
                    <p><i class="bi bi-telephone-fill me-2"></i>(021) 1234-5678</p>
                    <p><i class="bi bi-envelope-fill me-2"></i>info@skillmapdesa.id</p>
                </div>
                <div class="col-lg-3">
                    <h6 class="fw-bold mb-3"><i class="fas fa-link me-2"></i>Menu Cepat</h6>
                    <p><a href="#beranda">Beranda</a></p>
                    <p><a href="#tentang">Tentang</a></p>
                    <p><a href="#data">Statistik</a></p>
                    <p><a href="#kontak">Pengajuan</a></p>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <small>© 2026 Pemerintah Desa Karangmulya | Sistem Pemetaan Keterampilan Warga</small>
            </div>
        </div>
    </footer>

    <!-- ===============================
         SCRIPTS
    ================================ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- ===============================
         COUNTER STATISTIK
    ================================ -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const counters = document.querySelectorAll('.stat-number[data-target]');

            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target')) || 0;
                const increment = Math.ceil(target / 80);

                const updateCounter = () => {
                    const current = parseInt(counter.innerText) || 0;
                    if (current < target) {
                        counter.innerText = Math.min(current + increment, target);
                        setTimeout(updateCounter, 20);
                    } else {
                        counter.innerText = target;
                    }
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            updateCounter();
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.2 });

                observer.observe(counter);
            });
        });
    </script>

    <!-- ===============================
         SCROLL ANIMATION
    ================================ -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const animatedElements = document.querySelectorAll('.scroll-animate');

            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('in-view');
                        }
                    });
                }, {
                    threshold: 0.10,
                    rootMargin: '0px 0px -30px 0px'
                });

                animatedElements.forEach(el => observer.observe(el));
            } else {
                animatedElements.forEach(el => el.classList.add('in-view'));
            }
        });
    </script>

    <!-- ===============================
         NAVBAR SCROLL & ACTIVE
    ================================ -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.querySelector('.navbar');

            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });

            const navLinks = document.querySelectorAll('.navbar .nav-link[href^="#"]');
            const sections = Array.from(navLinks)
                .map(link => document.querySelector(link.getAttribute('href')))
                .filter(section => section !== null);

            function setActiveLink(id) {
                navLinks.forEach(link => link.classList.remove('active'));
                const active = document.querySelector(`.navbar .nav-link[href="${id}"]`);
                if (active) active.classList.add('active');
            }

            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    setActiveLink(this.getAttribute('href'));
                });
            });

            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            setActiveLink(`#${entry.target.id}`);
                        }
                    });
                }, { threshold: 0.05, rootMargin: '-80px 0px -40% 0px' });

                sections.forEach(section => observer.observe(section));
            }

            if (window.scrollY < 100) setActiveLink('#beranda');
        });
    </script>

    <!-- ===============================
         FORM KATEGORI LAINNYA
    ================================ -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kategoriSelect = document.getElementById('kategoriSelect');
            const kategoriLainnyaBox = document.getElementById('kategoriLainnyaBox');
            const kategoriLainnya = document.getElementById('kategoriLainnya');

            if (kategoriSelect) {
                kategoriSelect.addEventListener('change', function() {
                    if (this.value === 'lainnya') {
                        kategoriLainnyaBox.classList.remove('d-none');
                        kategoriLainnya.required = true;
                    } else {
                        kategoriLainnyaBox.classList.add('d-none');
                        kategoriLainnya.required = false;
                        kategoriLainnya.value = '';
                    }
                });
            }
        });
    </script>

    <!-- ===============================
         ALERT PENGAJUAN BERHASIL
    ================================ -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Dikirim',
                text: '{{ session('success') }}',
                confirmButtonColor: '#2f855a',
                timer: 3000,
                timerProgressBar: true
            });

            history.replaceState(null, null, '#kontak');
            setTimeout(() => {
                document.getElementById('kontak')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 100);
        </script>
    @endif

    <!-- ===============================
         ALERT HASIL PENCARIAN NIK
    ================================ -->
    @if (request('nik'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(() => {
                    document.getElementById('kontak')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 100);

                @if ($hasil ?? false)
                    @if ($jenis == 'warga')
                        Swal.fire({
                            icon: 'success',
                            title: 'Data Ditemukan',
                            confirmButtonColor: '#2f855a',
                            html: `
                                <div style="text-align:left;font-size:14px;line-height:1.8">
                                    <b>Nama:</b> {{ $hasil->nama ?? '-' }}<br>
                                    <b>NIK:</b> {{ $hasil->nik ?? '-' }}<br>
                                    <b>Wilayah:</b> Dusun {{ $hasil->rt->rw->dusun->nama_dusun ?? '-' }},
                                    RW {{ $hasil->rt->rw->nomor_rw ?? '-' }},
                                    RT {{ $hasil->rt->nomor_rt ?? '-' }}<br>
                                    <b>Kategori:</b> {{ $hasil->keterampilans->pluck('kategori.nama_kategori')->filter()->unique()->implode(', ') ?: '-' }}<br>
                                    <b>Keterampilan:</b> {{ $hasil->keterampilans->pluck('nama_keterampilan')->implode(', ') ?: '-' }}<br>
                                    <b>Status:</b> <span style="color:#198754;font-weight:600">Terdaftar</span>
                                </div>
                            `
                        });
                    @else
                        Swal.fire({
                            icon: '{{ $hasil->status == 'Disetujui' ? 'success' : ($hasil->status == 'Ditolak' ? 'error' : 'info') }}',
                            title: 'Data Pengajuan Ditemukan',
                            confirmButtonColor: '#2f855a',
                            html: `
                                <div style="text-align:left;font-size:14px;line-height:1.8">
                                    <b>Nama:</b> {{ $hasil->nama ?? '-' }}<br>
                                    <b>NIK:</b> {{ $hasil->nik ?? '-' }}<br>
                                    <b>Kategori:</b> {{ $hasil->kategori->nama_kategori ?? '-' }}<br>
                                    <b>Keterampilan:</b> {{ $hasil->keterampilan ?? '-' }}<br>
                                    <b>Wilayah:</b> Dusun {{ $hasil->dusun ?? '-' }}, RW {{ $hasil->rw ?? '-' }}, RT {{ $hasil->rt ?? '-' }}<br>
                                    <b>Status:</b> <strong>{{ $hasil->status ?? '-' }}</strong>
                                    @if (($hasil->status ?? '') == 'Ditolak')
                                        <br><br><b>Alasan Penolakan:</b><br>{{ $hasil->alasan_penolakan ?? '-' }}
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
                        confirmButtonColor: '#f59e0b'
                    });
                @endif
            });
        </script>
    @endif

    <!-- ===============================
         LEAFLET MAP - TETAP SAMA (TIDAK DIRUBAH)
    ================================ -->
    <script>
        const streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        });

        const satelliteLayer = L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles &copy; Esri'
            });

        const terrainLayer = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data: &copy; OpenStreetMap | Style: &copy; OpenTopoMap'
        });

        // 2. INISIALISASI MAP
        const map = L.map('map', {
            center: [-6.39963, 108.11848],
            zoom: 14,
            layers: [streetLayer]
        });
        map.createPane('dusunPane');
        map.createPane('rwPane');
        map.createPane('rtPane');

        map.getPane('dusunPane').style.zIndex = 300;
        map.getPane('rwPane').style.zIndex = 700;
        map.getPane('rtPane').style.zIndex = 750;
        // Nonaktifkan interaksi sampai peta diklik
        map.scrollWheelZoom.disable();
        map.dragging.disable();

        map.once('click', function() {
            map.scrollWheelZoom.enable();
            map.dragging.enable();
        });

        // 3. LAYER GROUPS
        const polygonLayer = L.featureGroup().addTo(map);
        const dusunLayer = L.featureGroup().addTo(map);
        const skillLayer = L.featureGroup().addTo(map);

        let globalData = {
            rw: [],
            rt: []
        };

        // 4. LOAD GEOJSON BATAS DESA
        fetch("{{ asset('geojson/karangmulya.geojson') }}")
            .then(res => res.json())
            .then(data => {
                const geojson = L.geoJSON(data, {
                    pane: 'dusunPane',
                    style: function(feature) {
                        let nama = (
                            feature.properties.dusunbaru ||
                            feature.properties.nama_dusun ||
                            ''
                        ).toLowerCase();
                        return {
                            color: nama.includes('kemped') ? '#198754' : '#6f42c1',
                            fillColor: nama.includes('kemped') ? '#198754' : '#6f42c1',
                            weight: 2,
                            fillOpacity: 0.10
                        };
                    }
                }).addTo(dusunLayer);
                polygonLayer.bringToBack();
                polygonLayer.bringToBack();
                try {
                    map.fitBounds(geojson.getBounds());
                } catch (e) {}
            });

        // 5. FUNGSI WARNA KATEGORI
        function warnaKategori(kategori) {
            if (!kategori) return '#6c757d';
            let hash = 0;
            for (let i = 0; i < kategori.length; i++) {
                hash = kategori.charCodeAt(i) + ((hash << 5) - hash);
            }
            const warna = (hash & 0x00FFFFFF).toString(16).toUpperCase();
            return "#" + "000000".substring(0, 6 - warna.length) + warna;
        }

        let semuaData = null;
        let filterDusun = '';
        let filterRt = '';
        let filterKategori = '';

        function isiFilter(data) {
            const dusunSelect = document.getElementById('filterDusun');
            const rtSelect = document.getElementById('filterRt');
            const kategoriSelect = document.getElementById('filterKategori');

            if (!dusunSelect || !rtSelect || !kategoriSelect) return;

            dusunSelect.innerHTML = '<option value="">Semua Dusun</option>';
            rtSelect.innerHTML = '<option value="">Semua RT / RW</option>';

            let rtSet = new Set();
            const daftarRt = filterDusun ? data.rt.filter(rt => rt.nama_dusun === filterDusun) : data.rt;

            daftarRt.forEach(item => {
                const value = item.nama_rt + "|" + item.nama_rw;
                if (!rtSet.has(value)) {
                    rtSet.add(value);
                    rtSelect.innerHTML += `
                        <option value="${value}">RT ${item.nama_rt} / RW ${item.nama_rw}</option>
                    `;
                }
            });
            rtSelect.value = filterRt;

            kategoriSelect.innerHTML = '<option value="">Semua Kategori</option>';
            [...new Set(data.kategori.map(item => item.dusun))].forEach(dusun => {
                dusunSelect.innerHTML += `<option value="${dusun}">${dusun}</option>`;
            });
            dusunSelect.value = filterDusun;
            
            [...new Set(data.kategori.map(item => item.kategori))].forEach(kategori => {
                kategoriSelect.innerHTML += `<option value="${kategori}">${kategori}</option>`;
            });
            kategoriSelect.value = filterKategori;
        }

        // 6. LOAD DATA
        function loadData() {
            dusunLayer.clearLayers();
            skillLayer.clearLayers();
            window.rtPosisi = {};

            fetch("{{ url('/api/pemetaan') }}")
                .then(res => res.json())
                .then(data => {
                    semuaData = data;
                    window.dataDusun = data.dusun;
                    isiFilter(data);

                    fetch("{{ asset('geojson/dusunreal.geojson') }}")
                        .then(res => res.json())
                        .then(geoData => {
                            L.geoJSON(geoData, {
                                interactive: true,
                                style: function(feature) {
                                    let nama = (feature.properties.dusunbaru || feature.properties
                                        .nama_dusun || '').toLowerCase();
                                    return {
                                        color: nama.includes('kemped') ? '#198754' : '#6f42c1',
                                        fillColor: nama.includes('kemped') ? '#198754' : '#6f42c1',
                                        weight: 3,
                                        fillOpacity: 0.15
                                    };
                                },
                                onEachFeature: function(feature, layer) {
                                    const namaDusun = (feature.properties.dusunbaru || feature
                                        .properties.nama_dusun || '').toLowerCase();
                                    const dusunData = window.dataDusun?.find(d =>
                                        d.nama_dusun.toLowerCase() === namaDusun
                                    );
                                    if (!dusunData) return;

                                    layer.bindPopup(`
                                        <div class="popup-modern">
                                            <div class="popup-header" style="background:${warnaKategori(dusunData.keterampilan_dominan)};color:white;">
                                                <div class="popup-title">${dusunData.nama_dusun}</div>
                                                <div class="popup-subtitle">Wilayah Dusun</div>
                                            </div>
                                            <div class="popup-body">
                                                <div class="popup-row">
                                                    <span class="popup-label">Jumlah RW</span>
                                                    <span class="popup-value">${dusunData.jumlah_rw || 0}</span>
                                                </div>
                                                <div class="popup-row">
                                                    <span class="popup-label">Jumlah RT</span>
                                                    <span class="popup-value">${dusunData.jumlah_rt || 0}</span>
                                                </div>
                                                <div class="popup-row">
                                                    <span class="popup-label">Total Warga</span>
                                                    <span class="popup-value">${dusunData.jumlah_warga || 0}</span>
                                                </div>
                                                <div class="popup-row">
                                                    <span class="popup-label">Kategori Dominan</span>
                                                    <span class="popup-badge" style="background:${warnaKategori(dusunData.keterampilan_dominan)};">${dusunData.keterampilan_dominan || '-'}</span>
                                                </div>
                                               
                                            </div>
                                        </div>
                                    `);

                                    layer.on({
                                        mouseover: function(e) {
                                            e.target.setStyle({ weight: 5, fillOpacity: 0.25 });
                                        },
                                        mouseout: function(e) {
                                            e.target.setStyle({ weight: 3, fillOpacity: 0.15 });
                                        },
                                        click: function(e) {
                                            if (layer.getPopup()) {
                                                layer.bindPopup(layer.getPopup()
                                                    .getContent()).openPopup(e.latlng);
                                            }
                                        }
                                    });
                                }
                            }).addTo(dusunLayer);
                            dusunLayer.bringToBack();
                        });

                    data.kategori.forEach(item => {
                        if (filterDusun && item.dusun !== filterDusun) return;
                        if (filterRt) {
                            const value = item.rt + "|" + item.rw;
                            if (value !== filterRt) return;
                        }
                        if (filterKategori && item.kategori !== filterKategori) return;
                        if (!item.latitude || !item.longitude) return;

                        const ukuran = data.max_jumlah > 0 ? 5 + ((item.jumlah_warga / data.max_jumlah) *
                            12) : 5;
                        if (!window.rtPosisi) {
                            window.rtPosisi = {};
                        }

                        const key = item.rt + '-' + item.rw;
                        if (!window.rtPosisi[key]) {
                            window.rtPosisi[key] = 0;
                        }

                        const index = window.rtPosisi[key]++;

                        let lat = parseFloat(item.latitude);
                        let lng = parseFloat(item.longitude);

                        const posisi = [
                            [0, 0],
                            [0.0018, 0],
                            [-0.0018, 0],
                            [0, 0.0018],
                            [0, -0.0018],
                            [0.0015, 0.0015],
                            [-0.0015, -0.0015],
                            [0.0015, -0.0015],
                            [-0.0015, 0.0015],
                            [0.0030, 0],
                            [-0.0030, 0],
                            [0, 0.0030],
                            [0, -0.0030],
                            [0.0025, 0.0025],
                            [-0.0025, -0.0025],
                            [0.0025, -0.0025],
                            [-0.0025, 0.0025],
                            [0.0038, 0.0015],
                            [-0.0038, -0.0015],
                            [0.0015, -0.0038]
                        ];

                        const p = posisi[index % posisi.length];
                        lat += p[0];
                        lng += p[1];

                        L.circleMarker([lat, lng], {
                            radius: ukuran,
                            color: '#ffffff',
                            fillColor: warnaKategori(item.kategori),
                            fillOpacity: 0.9,
                            weight: 2
                        }).bindPopup(`
                            <div class="popup-modern">
                                <div class="popup-header" style="background:${warnaKategori(item.kategori)};">
                                    <div class="popup-title">${item.kategori}</div>
                                    <div class="popup-subtitle">Kategori Keterampilan</div>
                                </div>
                                <div class="popup-body">
                                    <div class="popup-row">
                                        <span class="popup-label">Jumlah Warga</span>
                                        <span class="popup-value">${item.jumlah_warga} Orang</span>
                                    </div>
                                    <div class="popup-row">
                                        <span class="popup-label">RT</span>
                                        <span class="popup-value">${item.rt}</span>
                                    </div>
                                    <div class="popup-row">
                                        <span class="popup-label">RW</span>
                                        <span class="popup-value">${item.rw}</span>
                                    </div>
                                    <div class="popup-row">
                                        <span class="popup-label">Dusun</span>
                                        <span class="popup-value">${item.dusun}</span>
                                    </div>
                                </div>
                            </div>
                        `, { maxWidth: 320, className: 'custom-popup' }).addTo(skillLayer);
                    });
                });
        }

        loadData();

        // 7. LAYER CONTROL CUSTOM
        const CustomControl = L.Control.extend({
            options: { position: 'topright' },
            onAdd: function() {
                const div = L.DomUtil.create('div', 'custom-layer-ctrl');
                div.innerHTML = `
                    <button class="ctrl-toggle" onclick="toggleLayerPanel(this)">
                        <svg width="20" height="20" fill="#0d6efd" viewBox="0 0 16 16">
                            <path d="M7.765 1.559a.5.5 0 0 1 .47 0l6.39 3.39a.5.5 0 0 1 0 .87l-6.39 3.39a.5.5 0 0 1-.47 0L1.375 5.819a.5.5 0 0 1 0-.87l6.39-3.39z"/>
                            <path d="m1.375 9.18 6.39 3.39a.5.5 0 0 0 .47 0l6.39-3.39a.5.5 0 0 0 0-.87l-6.39-3.39a.5.5 0 0 0-.47 0L1.375 8.31a.5.5 0 0 0 0 .87z"/>
                            <path d="m1.375 12.54 6.39 3.39a.5.5 0 0 0 .47 0l6.39-3.39a.5.5 0 0 0 0-.87l-6.39-3.39a.5.5 0 0 0-.47 0L1.375 11.67a.5.5 0 0 0 0 .87z"/>
                        </svg>
                    </button>
                    <div class="ctrl-panel" style="display:none;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                            <small style="font-weight:600; color:#555;">Layer</small>
                            <button onclick="closeLayerPanel(this)" style="background:none; border:none; cursor:pointer; font-size:16px; color:#999; line-height:1; padding:0;">&times;</button>
                        </div>
                        <div class="ctrl-section">
                            <label><input type="radio" name="basemap" value="street" checked onchange="switchBase(this)"> Peta Jalan</label>
                            <label><input type="radio" name="basemap" value="satellite" onchange="switchBase(this)"> Satelit</label>
                            <label><input type="radio" name="basemap" value="terrain" onchange="switchBase(this)"> Terrain</label>
                        </div>
                        <hr style="margin:6px 0;">
                        <div class="ctrl-section">
                            <label><input type="checkbox" checked onchange="toggleLayer('polygon', this)"> Batas Wilayah</label>
                            <label><input type="checkbox" checked onchange="toggleLayer('dusun', this)"> Dusun</label>
                        </div>
                    </div>
                `;
                L.DomEvent.disableClickPropagation(div);
                return div;
            }
        });
        new CustomControl().addTo(map);

        // Toggle panel
        function toggleLayerPanel(btn) {
            const panel = btn.nextElementSibling;
            panel.style.display = 'block';
            btn.style.display = 'none';
        }

        function closeLayerPanel(closeBtn) {
            const panel = closeBtn.closest('.ctrl-panel');
            const toggle = panel.previousElementSibling;
            panel.style.display = 'none';
            toggle.style.display = 'flex';
        }

        // Ganti base layer
        function switchBase(radio) {
            map.removeLayer(streetLayer);
            map.removeLayer(satelliteLayer);
            map.removeLayer(terrainLayer);
            if (radio.value === 'street') map.addLayer(streetLayer);
            if (radio.value === 'satellite') map.addLayer(satelliteLayer);
            if (radio.value === 'terrain') map.addLayer(terrainLayer);
        }

        // Toggle overlay
        function toggleLayer(name, cb) {
            const layers = { polygon: polygonLayer, dusun: dusunLayer, skill: skillLayer };
            if (cb.checked) map.addLayer(layers[name]);
            else map.removeLayer(layers[name]);
        }

        document.addEventListener('change', function(e) {
            if (e.target.id === 'filterDusun') {
                filterDusun = e.target.value;
                filterRt = '';
                document.getElementById('filterRt').value = '';
                loadData();
            }
            if (e.target.id === 'filterRt') {
                filterRt = e.target.value;
                loadData();
            }
            if (e.target.id === 'filterKategori') {
                filterKategori = e.target.value;
                loadData();
            }
        });

        document.getElementById('resetFilter')?.addEventListener('click', function() {
            filterDusun = '';
            filterRt = '';
            filterKategori = '';
            document.getElementById('filterDusun').value = '';
            document.getElementById('filterRt').value = '';
            document.getElementById('filterKategori').value = '';
            loadData();
        });

        window.addEventListener('resize', () => map.invalidateSize());
    </script>

    <!-- ===============================
         NAVBAR ACTIVE MENU
    ================================ -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const navLinks = document.querySelectorAll('.navbar .nav-link[href^="#"]');
            const sections = Array.from(navLinks)
                .map(link => document.querySelector(link.getAttribute("href")))
                .filter(section => section !== null);

            function removeActiveClass() {
                navLinks.forEach(link => link.classList.remove("active"));
            }

            function setActiveLink(targetId) {
                removeActiveClass();
                const activeLink = document.querySelector(`.navbar .nav-link[href="${targetId}"]`);
                if (activeLink) {
                    activeLink.classList.add("active");
                }
            }

            navLinks.forEach(link => {
                link.addEventListener("click", function() {
                    const targetId = this.getAttribute("href");
                    setActiveLink(targetId);
                });
            });

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

            if (window.scrollY < 100) {
                setActiveLink("#beranda");
            }
        });
    </script>

    <!-- ===============================
          FORM PENGAJUAN KETERAMPILAN
    ================================ -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kategoriSelect = document.getElementById('kategoriSelect');
            const kategoriLainnyaBox = document.getElementById('kategoriLainnyaBox');
            const kategoriLainnya = document.getElementById('kategoriLainnya');

            kategoriSelect.addEventListener('change', function() {
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

    <!-- ===============================
   FORM PENCARIAN NIK
  ================================ -->
    <script>
        document.getElementById('formCariNik').addEventListener('submit', function() {
            this.action = "{{ route('landing') }}#kontak";
        });
    </script>

</body>
</html>