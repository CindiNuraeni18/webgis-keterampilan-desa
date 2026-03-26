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
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary) !important;
            display: flex;
            align-items: center;
            gap: 10px;
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
        }

        .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            margin-left: 10px;
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary) !important;
        }

        /* =========================================================
           TAMBAHAN ANIMASI NAVBAR ACTIVE
           - Menandai menu yang sedang aktif / sedang dilihat
           - Tidak mengubah layout, hanya menambah efek visual
        ========================================================= */
        .nav-link.active {
            color: var(--primary) !important;
        }

        .nav-link::after {
            content: "";
            position: absolute;
            left: 10px;
            bottom: -4px;
            width: calc(100% - 10px);
            height: 2px;
            background-color: var(--primary);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .nav-link.active::after,
        .nav-link:hover::after {
            transform: scaleX(1);
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
        }

        .hero p {
            color: var(--text-muted);
            font-size: 1.1rem;
            margin-bottom: 28px;
        }

        .btn-main {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
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
            transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease, color 0.3s ease;
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
            transition: transform 0.3s ease, box-shadow 0.3s ease;
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
            scroll-margin-top: 90px; /* Agar smooth scroll tidak tertutup navbar */
        }

        .section-title {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 14px;
        }

        .section-subtitle {
            color: var(--text-muted);
            max-width: 700px;
            margin: 0 auto 50px auto;
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
            transition: transform 0.3s ease, box-shadow 0.3s ease;
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
        }

        footer {
            background: #1f4d35;
            color: rgba(255, 255, 255, 0.85);
            padding: 24px 0;
        }

        footer a {
            color: #d9f99d;
        }

        /* =========================================================
           TAMBAHAN ANIMASI SCROLL
           - Elemen akan fade + slide saat masuk viewport
           - Menggunakan delay dari data-delay
        ========================================================= */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.8s ease, transform 0.8s ease;
            transition-delay: var(--delay, 0ms);
            will-change: opacity, transform;
        }

        .reveal.reveal-left {
            transform: translateX(-40px);
        }

        .reveal.reveal-right {
            transform: translateX(40px);
        }

        .reveal.reveal-up {
            transform: translateY(40px);
        }

        .reveal.reveal-visible {
            opacity: 1;
            transform: translate(0, 0);
        }

        /* =========================================================
           TAMBAHAN HOVER ANIMATION
           - Untuk card dan button
           - Hanya menambah efek angkat/scale
        ========================================================= */
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-6px);
        }

        .hover-scale {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-scale:hover {
            transform: scale(1.03);
        }

        .btn-main.hover-lift:hover,
        .btn-outline-custom.hover-lift:hover {
            box-shadow: 0 16px 28px rgba(0, 0, 0, 0.12);
        }

        .stat-card.hover-lift:hover,
        .contact-card.hover-lift:hover,
        .hero-card.hover-lift:hover,
        .map-card.hover-lift:hover,
        .mini-stat.hover-scale:hover {
            box-shadow: 0 16px 35px rgba(0, 0, 0, 0.10);
        }

        /* =========================================================
           TAMBAHAN ANIMASI KHUSUS STATISTIK
           - Card statistik muncul lebih halus saat di-scroll
        ========================================================= */
        .stat-card.reveal {
            transform: translateY(50px) scale(0.98);
        }

        .stat-card.reveal.reveal-visible {
            transform: translateY(0) scale(1);
        }

        /* ===============================
           RESPONSIVE
        =============================== */
        @media (max-width: 991.98px) {
            .hero {
                text-align: center;
            }

            .hero h1 {
                font-size: 2.3rem;
            }

            .hero .d-flex {
                justify-content: center;
            }
        }

        @media (max-width: 575.98px) {
            .hero h1 {
                font-size: 2rem;
            }

            .section-title {
                font-size: 1.7rem;
            }
        }

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
                    <li class="nav-item"><a class="nav-link active" href="#beranda">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#fitur">Pemetaan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#data">Data</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">Login</a>
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
                <div class="col-lg-6 reveal reveal-left" style="--delay: 100ms;">
                    <h1>Sistem Pemetaan Keterampilan Warga Desa Karangmulya</h1>
                    <p>
                        Platform digital untuk mengelola dan memetakan data keterampilan warga
                        Desa Karangmulya berdasarkan wilayah administratif RT, RW, dan dusun secara terintegrasi.
                    </p>

                    <div class="d-flex flex-wrap gap-3">
                        <a href="#fitur" class="btn btn-main hover-lift">Pemetaan</a>
                        <a href="#data" class="btn btn-outline-custom hover-lift">Lihat Data Desa</a>
                    </div>
                </div>

                <div class="col-lg-6 reveal reveal-right" style="--delay: 250ms;">
                    <div class="hero-card hover-lift">
                        <div class="row g-3">

                            <!-- Judul -->
                            <div class="col-12">
                                <h5 class="fw-bold mb-3">
                                    <i class="bi bi-map-fill me-2 text-success"></i>
                                    Profil Singkat Desa
                                </h5>
                            </div>

                            <!-- Luas Wilayah -->
                            <div class="col-sm-6">
                                <div class="mini-stat hover-scale">
                                    <i class="bi bi-aspect-ratio-fill"></i>
                                    <h5>3,85</h5>
                                    <p class="mb-0 text-muted">km² Luas Wilayah</p>
                                </div>
                            </div>

                            <!-- Jumlah Penduduk -->
                            <div class="col-sm-6">
                                <div class="mini-stat hover-scale">
                                    <i class="bi bi-people-fill"></i>
                                    <h5>3.117</h5>
                                    <p class="mb-0 text-muted">Jumlah Penduduk</p>
                                </div>
                            </div>

                            <!-- RT -->
                            <div class="col-sm-6">
                                <div class="mini-stat hover-scale">
                                    <i class="bi bi-house-door-fill"></i>
                                    <h5>8</h5>
                                    <p class="mb-0 text-muted">RT</p>
                                </div>
                            </div>

                            <!-- RW -->
                            <div class="col-sm-6">
                                <div class="mini-stat hover-scale">
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
    <section id="tentang">
        <div class="container">
            <div class="text-center mb-5 reveal reveal-up" style="--delay: 100ms;">
                <h2 class="section-title">Tentang Sistem</h2>
                <p class="section-subtitle">
                    Sistem ini digunakan untuk mengelola data keterampilan warga secara
                    terpusat dan menampilkan sebarannya dalam bentuk peta digital.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4 reveal reveal-up" style="--delay: 100ms;">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-bullseye"></i>
                        </div>
                        <h5 class="fw-bold">Tujuan Utama</h5>
                        <p class="text-muted mb-0">
                            Mengidentifikasi potensi keterampilan masyarakat desa secara akurat
                            untuk mendukung program pembangunan berbasis data.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 reveal reveal-up" style="--delay: 220ms;">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-diagram-3-fill"></i>
                        </div>
                        <h5 class="fw-bold">Data Terintegrasi</h5>
                        <p class="text-muted mb-0">
                            Data warga, jenis keterampilan, dan lokasi dapat dikelola dalam satu
                            sistem yang terpusat dan mudah diakses.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 reveal reveal-up" style="--delay: 340ms;">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <h5 class="fw-bold">Dukungan Keputusan</h5>
                        <p class="text-muted mb-0">
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
    <section id="fitur" class="bg-soft">
        <div class="container">
            <div class="text-center mb-5 reveal reveal-up" style="--delay: 100ms;">
                <h2 class="section-title">Pemetaan Keterampilan Warga Desa Karangmulya</h2>
                <p class="section-subtitle">
                    Menampilkan sebaran keterampilan warga Desa Karangmulya secara interaktif
                    dalam bentuk peta digital berdasarkan wilayah RT, RW, dan dusun.
                </p>
            </div>

            <div class="map-card hover-lift reveal reveal-up" style="--delay: 220ms;">
                <div class="map-header">
                    <h5 class="fw-bold mb-1">
                        <i class="bi bi-map-fill text-success me-2"></i>
                        Peta Interaktif Desa
                    </h5>
                    <p class="text-muted mb-0">
                        Peta lokasi yang dapat dikembangkan dengan marker data warga
                    </p>
                </div>

                <div id="villageMap"></div>
            </div>
        </div>
    </section>

    <!-- ===============================
         DATA / STATISTIK DESA
         Menampilkan data
    ================================ -->
    <section id="data">
        <div class="container">
            <div class="text-center mb-5 reveal reveal-up" style="--delay: 100ms;">
                <h2 class="section-title">Statistik & Data Desa</h2>
                <p class="section-subtitle">
                    Berikut data sebaran keterampilan warga
                    desa Karangmulya.
                </p>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-6 col-md-3 reveal reveal-up" style="--delay: 100ms;">
                    <div class="stat-card hover-lift">
                        <div class="stat-number" data-target="1250">0</div>
                        <p class="mb-0 text-muted">Total Warga Terdata</p>
                    </div>
                </div>

                <div class="col-6 col-md-3 reveal reveal-up" style="--delay: 220ms;">
                    <div class="stat-card hover-lift">
                        <div class="stat-number" data-target="480">0</div>
                        <p class="mb-0 text-muted">Warga Produktif</p>
                    </div>
                </div>

                <div class="col-6 col-md-3 reveal reveal-up" style="--delay: 340ms;">
                    <div class="stat-card hover-lift">
                        <div class="stat-number" data-target="18">0</div>
                        <p class="mb-0 text-muted">Kategori Keterampilan</p>
                    </div>
                </div>

                <div class="col-6 col-md-3 reveal reveal-up" style="--delay: 460ms;">
                    <div class="stat-card hover-lift">
                        <div class="stat-number" data-target="12">0</div>
                        <p class="mb-0 text-muted">Dusun Terpetakan</p>
                    </div>
                </div>
            </div>

            <div class="data-box reveal reveal-up" style="--delay: 200ms;">
                <div class="row align-items-center g-4">
                    <div class="col-lg-6 reveal reveal-left" style="--delay: 250ms;">
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

                    <div class="col-lg-6 reveal reveal-right" style="--delay: 350ms;">
                        <div class="bg-white text-dark rounded-4 p-4 h-100 hover-lift">
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
    <section id="kontak" class="bg-soft">
        <div class="container">
            <div class="text-center mb-5 reveal reveal-up" style="--delay: 100ms;">
                <h2 class="section-title">Kontak</h2>
                <p class="section-subtitle">
                    Hubungi kami untuk informasi lebih lanjut mengenai Sistem
                    Pemetaan Keterampilan Warga Desa Karangmulya.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-lg-5 reveal reveal-left" style="--delay: 180ms;">
                    <div class="contact-card hover-lift">
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

                <div class="col-lg-7 reveal reveal-right" style="--delay: 300ms;">
                    <div class="contact-card hover-lift">
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
                                    <button type="button" class="btn btn-main hover-lift">
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
    <footer class="reveal reveal-up" style="--delay: 100ms;">
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
           Fungsi lama tetap dipertahankan, namun dijalankan saat
           elemen statistik masuk viewport agar animasinya lebih natural.
        ========================================================= */

        const counters = document.querySelectorAll(".stat-number");

        function animateCounter(counter) {
            /* Cegah counter berjalan lebih dari sekali */
            if (counter.dataset.animated === "true") return;

            counter.dataset.animated = "true";

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
        }

        /* =========================================================
           ANIMASI SCROLL REVEAL
           - Section / card muncul dengan fade + slide
           - Menggunakan IntersectionObserver agar ringan
        ========================================================= */
        const revealElements = document.querySelectorAll(".reveal");

        const revealObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("reveal-visible");

                    /* Jika elemen yang muncul berisi counter, jalankan animasi angka */
                    const counterInside = entry.target.querySelector(".stat-number");
                    if (counterInside) {
                        animateCounter(counterInside);
                    }

                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.15
        });

        revealElements.forEach((el) => {
            revealObserver.observe(el);
        });

        /* =========================================================
           KHUSUS UNTUK COUNTER
           Jika ada stat-number yang tidak berada dalam elemen .reveal
           tetap bisa diamati secara mandiri.
        ========================================================= */
        const counterObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.7
        });

        counters.forEach(counter => {
            counterObserver.observe(counter);
        });

        /* =========================================================
           SMOOTH SCROLL NAVBAR
           - Menambahkan smooth scroll manual agar lebih halus
           - Menyesuaikan posisi dengan tinggi navbar
        ========================================================= */
        const navLinks = document.querySelectorAll('.nav-link[href^="#"]');

        navLinks.forEach(link => {
            link.addEventListener("click", function (e) {
                const targetId = this.getAttribute("href");
                const targetSection = document.querySelector(targetId);

                if (targetSection) {
                    e.preventDefault();

                    const navbar = document.querySelector(".navbar");
                    const navbarHeight = navbar.offsetHeight;
                    const targetPosition =
                        targetSection.getBoundingClientRect().top + window.pageYOffset - navbarHeight + 1;

                    window.scrollTo({
                        top: targetPosition,
                        behavior: "smooth"
                    });

                    /* Tutup navbar collapse saat mobile setelah klik menu */
                    const navbarCollapse = document.querySelector("#mainNavbar");
                    const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                    if (bsCollapse) {
                        bsCollapse.hide();
                    }
                }
            });
        });

        /* =========================================================
           ACTIVE MENU NAVBAR SAAT SECTION DILIHAT
           - Menu akan otomatis aktif sesuai section di viewport
        ========================================================= */
        const sections = document.querySelectorAll("section[id]");
        const allNavLinks = document.querySelectorAll('.nav-link[href^="#"]');

        function setActiveNav() {
            const navbarHeight = document.querySelector(".navbar").offsetHeight;
            let currentSectionId = "";

            sections.forEach(section => {
                const sectionTop = section.offsetTop - navbarHeight - 120;
                const sectionHeight = section.offsetHeight;

                if (window.scrollY >= sectionTop && window.scrollY < sectionTop + sectionHeight) {
                    currentSectionId = section.getAttribute("id");
                }
            });

            allNavLinks.forEach(link => {
                link.classList.remove("active");
                if (link.getAttribute("href") === `#${currentSectionId}`) {
                    link.classList.add("active");
                }
            });
        }

        window.addEventListener("scroll", setActiveNav);
        window.addEventListener("load", setActiveNav);
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

        /* =========================================================
           OPTIONAL KECIL:
           Ketika peta muncul setelah animasi scroll, kadang ukuran Leaflet
           perlu dihitung ulang agar tampil sempurna.
        ========================================================= */
        window.addEventListener("load", () => {
            setTimeout(() => {
                map.invalidateSize();
            }, 500);
        });
    </script>
</body>
</html>