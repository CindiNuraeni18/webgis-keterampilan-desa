<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistem Informasi Pemetaan Keterampilan Desa</title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />

    <link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    />

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
            url("https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=1600&q=80")
            center/cover no-repeat;
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
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 28px;
        text-align: center;
        height: 100%;
    }

    .stat-number {
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--primary);
    }

    .data-box {
        background: linear-gradient(135deg, #2f855a, #3fa46e);
        color: white;
        border-radius: var(--radius);
        padding: 35px;
        box-shadow: var(--shadow);
    }

    .progress {
        height: 10px;
        border-radius: 999px;
        background-color: rgba(255, 255, 255, 0.25);
    }

    .progress-bar {
        background-color: #d9f99d;
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

    footer {
        background: #1f4d35;
        color: rgba(255, 255, 255, 0.85);
        padding: 24px 0;
    }

    footer a {
        color: #d9f99d;
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

    #villageMap {
        width: 100%;
        height: 450px;
        max-width: 100%;
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

        #villageMap {
            height: 380px;
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

        .hero .d-flex > * {
            width: 100%;
        }

        .map-card {
            border-radius: 16px;
        }

        .map-header {
            border-radius: 16px 16px 0 0;
        }

        #villageMap {
            height: 300px;
        }

        .progress {
            height: 9px;
        }

        footer {
            padding: 20px 0;
            text-align: center;
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

        #villageMap {
            height: 260px;
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
                <div class="brand-icon">
                    <i class="bi bi-geo-alt-fill"></i>
                </div>
                <span>SkillMap Desa</span>
            </a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNavbar"
                aria-controls="mainNavbar"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#beranda">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#fitur">Pemetaan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#data">Data</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link"> Login</a>
                    </li>
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
                        Platform digital untuk mengelola dan memetakan data keterampilan warga 
                        Desa Karangmulya berdasarkan wilayah administratif RT, RW, dan dusun secara terintegrasi.
                    </p>

                    <div class="d-flex flex-wrap gap-3 scroll-animate fade-up delay-3">
                        <a href="#fitur" class="btn btn-main">Pemetaan</a>
                        <a href="#data" class="btn btn-outline-custom">Lihat Data Desa</a>
                    </div>
                </div>

                <div class="col-lg-6 scroll-animate fade-right delay-2">
                    <div class="hero-card">
                        <div class="row g-3">

                            <!-- Judul -->
                            <div class="col-12 scroll-animate fade-up delay-1">
                                <h5 class="fw-bold mb-3">
                                    <i class="bi bi-map-fill me-2 text-success"></i>
                                    Profil Singkat Desa
                                </h5>
                            </div>

                            <!-- Luas Wilayah -->
                            <div class="col-sm-6 scroll-animate zoom-soft delay-1">
                                <div class="mini-stat scroll-animate zoom-soft delay-1">
                                    <i class="bi bi-aspect-ratio-fill"></i>
                                    <h5>3,85</h5>
                                    <p class="mb-0 text-muted">km² Luas Wilayah</p>
                                </div>
                            </div>

                            <!-- Jumlah Penduduk -->
                            <div class="col-sm-6 scroll-animate zoom-soft delay-2">
                                <div class="mini-stat scroll-animate zoom-soft delay-2">
                                    <i class="bi bi-people-fill"></i>
                                    <h5>3.117</h5>
                                    <p class="mb-0 text-muted">Jumlah Penduduk</p>
                                </div>
                            </div>

                            <!-- RT -->
                            <div class="col-sm-6 scroll-animate zoom-soft delay-3">
                                <div class="mini-stat scroll-animate zoom-soft delay-3">
                                    <i class="bi bi-house-door-fill"></i>
                                    <h5>8</h5>
                                    <p class="mb-0 text-muted">RT</p>
                                </div>
                            </div>

                            <!-- RW -->
                            <div class="col-sm-6 scroll-animate zoom-soft delay-4">
                                <div class="mini-stat scroll-animate zoom-soft delay-4">
                                    <i class="bi bi-building"></i>
                                    <h5>4</h5>
                                    <p class="mb-0 text-muted">RW</p>
                                </div>
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
    <section id="tentang" class="scroll-animate fade-up">
        <div class="container">
            <div class="text-center mb-5 scroll-animate fade-up delay-1">
                <h2 class="section-title scroll-animate fade-up delay-1">Tentang Sistem</h2>
                <p class="section-subtitle scroll-animate fade-up delay-2">
                    Sistem ini digunakan untuk mengelola data keterampilan warga secara 
                    terpusat dan menampilkan sebarannya dalam bentuk peta digital.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4 scroll-animate fade-up delay-1">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-bullseye"></i>
                        </div>
                        <h5 class="fw-bold scroll-animate fade-up delay-3">Tujuan Utama</h5>
                        <p class="text-muted mb-0 scroll-animate fade-up delay-4">
                            Mengidentifikasi potensi keterampilan masyarakat desa secara akurat
                            untuk mendukung program pembangunan berbasis data.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 scroll-animate fade-up delay-2">
                    <div class="feature-card">
                        <div class="feature-icon">
                           <i class="bi bi-diagram-3-fill"></i>
                        </div>
                        <h5 class="fw-bold scroll-animate fade-up delay-3">Data Terintegrasi</h5>
                        <p class="text-muted mb-0 scroll-animate fade-up delay-4">
                            Data warga, jenis keterampilan, dan lokasi dapat dikelola dalam satu
                            sistem yang terpusat dan mudah diakses.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 scroll-animate fade-up delay-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <h5 class="fw-bold scroll-animate fade-up delay-3">Dukungan Keputusan</h5>
                        <p class="text-muted mb-0 scroll-animate fade-up delay-4">
                            Informasi yang tersaji membantu desa menentukan prioritas pelatihan,
                            UMKM, dan kolaborasi pengembangan potensi warga.
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
                <h2 class="section-title scroll-animate fade-up delay-1">Pemetaan Keterampilan Warga Desa Karangmulya</h2>
                <p class="section-subtitle scroll-animate fade-up delay-2">
                    Menampilkan sebaran keterampilan warga Desa Karangmulya secara interaktif
                    dalam bentuk peta digital berdasarkan wilayah RT, RW, dan dusun.
                </p>
            </div>

            <div class="map-card scroll-animate zoom-soft delay-2">
                <div class="map-header scroll-animate fade-up delay-2">
                    <h5 class="fw-bold mb-1 scroll-animate fade-up delay-1">
                        <i class="bi bi-map-fill text-success me-2"></i>
                        Peta Interaktif Desa
                    </h5>
                    <p class="text-muted mb-0 scroll-animate fade-up delay-1">
                        Peta lokasi yang dapat dikembangkan dengan marker data warga
                    </p>
                </div>

                <div id="villageMap" class="scroll-animate fade-up delay-3"></div>
            </div>
        </div>
    </section>

    <!-- ===============================
         DATA / STATISTIK DESA
         Menampilkan data
    ================================ -->
    <section id="data" class="scroll-animate fade-up">
        <div class="container">
            <div class="text-center mb-5 scroll-animate fade-up delay-1">
                <h2 class="section-title scroll-animate fade-up delay-1">Statistik & Data Desa</h2>
                <p class="section-subtitle scroll-animate fade-up delay-2">
                    Berikut data sebaran keterampilan warga
                    desa Karangmulya.
                </p>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-6 col-md-3 scroll-animate zoom-soft delay-1">
                    <div class="stat-card">
                        <div class="stat-number" data-target="1250">0</div>
                        <p class="mb-0 text-muted">Total Warga Terdata</p>
                    </div>
                </div>

                <div class="col-6 col-md-3 scroll-animate zoom-soft delay-2">
                    <div class="stat-card">
                        <div class="stat-number" data-target="480">0</div>
                        <p class="mb-0 text-muted">Warga Produktif</p>
                    </div>
                </div>

                <div class="col-6 col-md-3 scroll-animate zoom-soft delay-3">
                    <div class="stat-card">
                        <div class="stat-number" data-target="18">0</div>
                        <p class="mb-0 text-muted">Kategori Keterampilan</p>
                    </div>
                </div>

                <div class="col-6 col-md-3 scroll-animate zoom-soft delay-4">
                    <div class="stat-card">
                        <div class="stat-number" data-target="12">0</div>
                        <p class="mb-0 text-muted">Dusun Terpetakan</p>
                    </div>
                </div>
            </div>

            <div class="data-box scroll-animate fade-up delay-2">
                <div class="row align-items-center g-4">
                    <div class="col-lg-6 scroll-animate fade-left delay-2">
                        <h4 class="fw-bold mb-3">Contoh Sebaran Keterampilan</h4>
                        <p class="mb-4">
                            Data berikut merupakan simulasi kategori keterampilan yang paling
                            banyak dimiliki warga desa.
                        </p>

                        <!-- Contoh progress keterampilan -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Pertanian Modern</span>
                                <span>80%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" style="width: 80%;"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Kerajinan Tangan</span>
                                <span>65%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" style="width: 65%;"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Pengolahan Pangan</span>
                                <span>72%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" style="width: 72%;"></div>
                            </div>
                        </div>

                        <div class="mb-0">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Jasa & Teknologi</span>
                                <span>40%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" style="width: 40%;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 scroll-animate fade-right delay-3">
                        <div class="bg-white text-dark rounded-4 p-4 h-100">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-info-circle-fill text-success me-2"></i>Informasi Ringkas
                            </h5>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    Mayoritas warga memiliki keterampilan di bidang pertanian dan UMKM.
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    Data lokasi dapat dikaitkan dengan peta dusun atau RW.
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    Informasi ini bermanfaat untuk perencanaan pelatihan dan bantuan usaha.
                                </li>
                                <li class="mb-0">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    Sistem dapat dikembangkan lebih lanjut untuk integrasi GIS dan dashboard admin.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===============================
         KONTAK
         Informasi kontak dan ajakan
    ================================ -->
    <section id="kontak" class="bg-soft scroll-animate fade-up">
        <div class="container">
            <div class="text-center mb-5 scroll-animate fade-up delay-1">
                <h2 class="section-title scroll-animate fade-up delay-1">Kontak</h2>
                <p class="section-subtitle scroll-animate fade-up delay-2">
                    Hubungi kami untuk informasi lebih lanjut mengenai Sistem
                    Pemetaan Keterampilan Warga Desa Karangmulya.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-lg-5 scroll-animate fade-left delay-2">
                    <div class="contact-card">
                        <h4 class="fw-bold mb-4">Informasi Kontak</h4>

                        <div class="contact-item">
                            <i class="bi bi-geo-alt-fill"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Alamat</h6>
                                <p class="text-muted mb-0">
                                    Kantor Desa Karangmulya, Kecamatan Kandanghaur, Kabupaten Indramayu
                                </p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <i class="bi bi-telephone-fill"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Telepon</h6>
                                <p class="text-muted mb-0">(021) 1234-5678</p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <i class="bi bi-envelope-fill"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Email</h6>
                                <p class="text-muted mb-0">info@skillmapdesa.id</p>
                            </div>
                        </div>

                        <div class="contact-item mb-0">
                            <i class="bi bi-clock-fill"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Jam Layanan</h6>
                                <p class="text-muted mb-0">Senin - Jumat, 08.00 - 16.00 WIB</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 scroll-animate fade-right delay-3">
                    <div class="contact-card">
                        <h4 class="fw-bold mb-4">Kirim Pesan</h4>

                        <!-- Form dummy kontak -->
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" placeholder="Masukkan nama">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" placeholder="Masukkan email">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Subjek</label>
                                    <input type="text" class="form-control" placeholder="Masukkan subjek">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Pesan</label>
                                    <textarea class="form-control" rows="5" placeholder="Tulis pesan Anda"></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="button" class="btn btn-main">
                                        <i class="bi bi-send-fill me-2"></i>Kirim Pesan
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
    <footer class="scroll-animate fade-up">
        <div class="container">
            <div class="row gy-3 align-items-center">
                <div class="text-center">
                    <strong>Sistem Pemetaan Keterampilan Warga Desa Karangmulya</strong><br>
                    <small>© 2026 Semua hak dilindungi.</small>
                </div>
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
    /* =========================================================
       ADVANCED SCROLL STAGGER ANIMATION
       =========================================================
       Fitur:
       - IntersectionObserver sebagai trigger utama
       - Delay dinamis dari JavaScript berdasarkan index elemen
       - Masuk satu per satu (stagger enter)
       - Keluar satu per satu (reverse stagger exit)
       - Exit lebih cepat dari enter
       - Ada sedikit random delay kecil agar terasa natural
       - Bisa repeat saat scroll naik & turun
       - Tetap memakai class animasi yang sudah ada:
         .fade-up, .fade-left, .fade-right, .zoom-soft
    ========================================================= */

    (() => {
        const animatedElements = Array.from(document.querySelectorAll('.scroll-animate'));
        if (!animatedElements.length) return;

        /* -----------------------------------------------
           Konfigurasi utama animasi
        ----------------------------------------------- */
        const CONFIG = {
            baseDelay: 100,          // jarak stagger antar elemen
            randomJitter: 20,       // random kecil agar natural
            enterDuration: 1000,     // masuk lebih halus
            exitDuration: 700,      // keluar lebih cepat
            enterThreshold: 0.16,
            rootMargin: '0px 0px -10% 0px'
        };

        /* -----------------------------------------------
           Easing berbeda untuk enter & exit
        ----------------------------------------------- */
        const EASING = {
            enter: 'cubic-bezier(0.22, 1, 0.36, 1)',     // smooth, natural
            exit: 'ease-in-out'           // lebih cepat saat keluar
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
        // Koordinat contoh, silakan ganti dengan koordinat asli Desa Karangmulya
        const map = L.map('villageMap').setView([-6.914744, 107.609810], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        L.marker([-6.914744, 107.609810])
            .addTo(map)
            .bindPopup('<b>Desa Karangmulya</b><br>Lokasi pemetaan keterampilan warga.')
            .openPopup();
    </script>
    <script>
    /* =========================================================
       ACTIVE NAVBAR MENU
       =========================================================
       Fitur:
       - Saat menu diklik -> langsung aktif
       - Saat scroll -> aktif otomatis mengikuti section yang terlihat
       - Ringan: menggunakan IntersectionObserver
       - Aman: hanya untuk link navbar yang menuju id section (#...)
    ========================================================= */

    document.addEventListener("DOMContentLoaded", function () {
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
            link.addEventListener("click", function () {
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
            threshold: 0.45,
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
</body>
</html>