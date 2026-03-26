@extends('layouts.sidebar-admin')
@section('title', 'Dashboard')

@section('content')
<style>
    /* =========================================================
       DASHBOARD ADMIN RESPONSIVE
       - Tetap mempertahankan desain utama
       - Fokus pada kerapihan layout di semua perangkat
    ========================================================= */

    /* -----------------------------
       Global safety
    ----------------------------- */
    .dashboard-admin,
    .dashboard-admin * {
        box-sizing: border-box;
    }

    .dashboard-admin {
        overflow-x: hidden;
        width: 100%;
    }

    .dashboard-admin img,
    .dashboard-admin svg,
    .dashboard-admin canvas,
    .dashboard-admin iframe {
        max-width: 100%;
        height: auto;
        display: block;
    }

    .dashboard-admin .row {
        --bs-gutter-x: 1.5rem;
    }

    /* =========================================================
       FIX HEADER / TOPBAR LAYOUT
       - Bagian ini memperbaiki header pada layout sidebar-admin
       - Tujuannya agar tombol menu, judul Dashboard, dan user
         tetap rapi dalam satu baris di mobile/tablet
    ========================================================= */

    /* Header wrapper umum */
    header.navbar,
    .topbar,
    .main-header,
    .dashboard-topbar,
    .content-header {
        position: relative;
        z-index: 1040;
    }

    /* Container header dibuat flex */
    header.navbar .container,
    header.navbar .container-fluid,
    .topbar .container,
    .topbar .container-fluid,
    .main-header .container,
    .main-header .container-fluid,
    .dashboard-topbar .container,
    .dashboard-topbar .container-fluid,
    .content-header .container,
    .content-header .container-fluid {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: nowrap;
    }

    /* Area kiri header: toggle + title */
    .topbar-left,
    .header-left,
    .dashboard-topbar-left,
    .main-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
        flex: 1 1 auto;
        min-width: 0;
    }

    /* Area kanan header: admin/profile */
    .topbar-right,
    .header-right,
    .dashboard-topbar-right,
    .main-header-right {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        flex: 0 0 auto;
        margin-left: auto;
        min-width: 0;
        position: relative;
        z-index: 1060;
    }

    /* Toggle button/menu button */
    .sidebar-toggle,
    .menu-toggle,
    .navbar-toggler {
        flex-shrink: 0;
        position: relative;
        z-index: 1061;
    }

    /* Judul di header/layout */
    .page-title,
    .topbar-title,
    .header-title,
    .dashboard-page-title,
    header.navbar h1,
    header.navbar h2,
    header.navbar .fw-bold,
    .content-header h1,
    .content-header h2 {
        margin: 0;
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        min-width: 0;
    }

    /* Profile / dropdown user */
    .profile-dropdown,
    .user-dropdown,
    .topbar-profile,
    .header-profile,
    .dropdown.user-menu,
    .dropdown.profile-menu {
        display: flex;
        align-items: center;
        gap: 8px;
        position: relative;
        z-index: 1065;
        white-space: nowrap;
    }

    .profile-name,
    .user-name,
    .topbar-profile-name,
    .header-profile-name {
        display: inline-block;
        max-width: 160px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        vertical-align: middle;
    }

    .dropdown-menu {
        z-index: 1070;
    }

    /* Jika nav active punya pseudo element, jangan blok klik dropdown/profile */
    .nav-link.active::after,
    .navbar .nav-link.active::after,
    .sidebar .nav-link.active::after {
        pointer-events: none;
    }

    /* -----------------------------
       Header / title dashboard content
    ----------------------------- */
    .dashboard-header {
        margin-bottom: 1.75rem;
    }

    .dashboard-title {
        font-size: 2rem;
        line-height: 1.25;
        margin-bottom: 0.35rem;
        word-break: break-word;
    }

    .dashboard-subtitle {
        font-size: 1rem;
        margin-bottom: 0;
        line-height: 1.6;
    }

    /* -----------------------------
       Card umum
    ----------------------------- */
    .dashboard-admin .card {
        border-radius: 16px;
        overflow: hidden;
    }

    .dashboard-admin .card-header {
        font-size: 1rem;
        padding: 1rem 1.25rem;
        overflow-wrap: break-word;
    }

    .dashboard-admin .card-body {
        padding: 1.25rem;
        overflow-wrap: break-word;
        word-wrap: break-word;
    }

    /* -----------------------------
       Card statistik
    ----------------------------- */
    .dashboard-stat-card {
        height: 100%;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .dashboard-stat-card:hover {
        transform: translateY(-3px);
    }

    .dashboard-stat-title {
        font-size: 0.95rem;
        margin-bottom: 0.45rem;
        line-height: 1.4;
    }

    .dashboard-stat-number {
        font-size: 2rem;
        line-height: 1.2;
        margin-bottom: 0;
        word-break: break-word;
    }

    /* -----------------------------
       Map
    ----------------------------- */
    .dashboard-map-wrapper {
        width: 100%;
        overflow: hidden;
        border-radius: 12px;
    }

    .dashboard-map {
        width: 100%;
        height: 400px;
        min-height: 240px;
        border-radius: 12px;
        overflow: hidden;
    }

    /* -----------------------------
       Aktivitas
    ----------------------------- */
    .dashboard-activity .list-group {
        margin-bottom: 0;
    }

    .dashboard-activity .list-group-item {
        padding-left: 0;
        padding-right: 0;
        font-size: 0.95rem;
        line-height: 1.55;
        background: transparent;
    }

    .dashboard-activity .list-group-item:first-child {
        padding-top: 0;
    }

    .dashboard-activity .list-group-item:last-child {
        padding-bottom: 0;
        border-bottom: 0;
    }

    /* -----------------------------
       Desktop besar
    ----------------------------- */
    @media (min-width: 1200px) {
        .dashboard-title {
            font-size: 2.1rem;
        }
    }

    /* -----------------------------
       Tablet
    ----------------------------- */
    @media (max-width: 991.98px) {
        /* Header layout */
        header.navbar,
        .topbar,
        .main-header,
        .dashboard-topbar,
        .content-header {
            padding-top: 14px;
            padding-bottom: 14px;
        }

        header.navbar .container,
        header.navbar .container-fluid,
        .topbar .container,
        .topbar .container-fluid,
        .main-header .container,
        .main-header .container-fluid,
        .dashboard-topbar .container,
        .dashboard-topbar .container-fluid,
        .content-header .container,
        .content-header .container-fluid {
            gap: 12px;
        }

        .page-title,
        .topbar-title,
        .header-title,
        .dashboard-page-title,
        header.navbar h1,
        header.navbar h2,
        header.navbar .fw-bold,
        .content-header h1,
        .content-header h2 {
            font-size: 1.35rem;
        }

        .profile-name,
        .user-name,
        .topbar-profile-name,
        .header-profile-name {
            max-width: 120px;
            font-size: 0.95rem;
        }

        .dashboard-header {
            margin-bottom: 1.5rem;
        }

        .dashboard-title {
            font-size: 1.75rem;
        }

        .dashboard-subtitle {
            font-size: 0.95rem;
        }

        .dashboard-stat-number {
            font-size: 1.75rem;
        }

        .dashboard-map {
            height: 340px;
        }

        .dashboard-section-gap {
            margin-top: 2rem !important;
        }
    }

    /* -----------------------------
       Mobile
    ----------------------------- */
    @media (max-width: 767.98px) {
        .dashboard-admin.container,
        .dashboard-admin.container-fluid {
            padding-left: 16px;
            padding-right: 16px;
        }

        .dashboard-admin .row {
            --bs-gutter-x: 1rem;
            --bs-gutter-y: 1rem;
        }

        /* Header layout di mobile */
        header.navbar,
        .topbar,
        .main-header,
        .dashboard-topbar,
        .content-header {
            padding-top: 12px;
            padding-bottom: 12px;
        }

        header.navbar .container,
        header.navbar .container-fluid,
        .topbar .container,
        .topbar .container-fluid,
        .main-header .container,
        .main-header .container-fluid,
        .dashboard-topbar .container,
        .dashboard-topbar .container-fluid,
        .content-header .container,
        .content-header .container-fluid {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: nowrap;
            gap: 10px;
        }

        .topbar-left,
        .header-left,
        .dashboard-topbar-left,
        .main-header-left {
            flex: 1 1 auto;
            min-width: 0;
            gap: 10px;
        }

        .topbar-right,
        .header-right,
        .dashboard-topbar-right,
        .main-header-right {
            flex: 0 0 auto;
            margin-left: auto;
        }

        .sidebar-toggle,
        .menu-toggle,
        .navbar-toggler {
            width: 42px;
            height: 42px;
            min-width: 42px;
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .page-title,
        .topbar-title,
        .header-title,
        .dashboard-page-title,
        header.navbar h1,
        header.navbar h2,
        header.navbar .fw-bold,
        .content-header h1,
        .content-header h2 {
            font-size: 1.1rem;
            line-height: 1.2;
        }

        .profile-name,
        .user-name,
        .topbar-profile-name,
        .header-profile-name {
            max-width: 90px;
            font-size: 0.9rem;
        }

        .dashboard-header {
            margin-bottom: 1.25rem;
        }

        .dashboard-title {
            font-size: 1.45rem;
            line-height: 1.3;
        }

        .dashboard-subtitle {
            font-size: 0.92rem;
            line-height: 1.6;
        }

        .dashboard-stat-title {
            font-size: 0.9rem;
        }

        .dashboard-stat-number {
            font-size: 1.45rem;
        }

        .dashboard-admin .card-header {
            padding: 0.95rem 1rem;
            font-size: 0.95rem;
        }

        .dashboard-admin .card-body {
            padding: 1rem;
        }

        .dashboard-map {
            height: 280px;
        }

        .dashboard-activity .list-group-item {
            font-size: 0.92rem;
            line-height: 1.55;
        }

        .dashboard-section-gap {
            margin-top: 1.5rem !important;
        }
    }

    /* -----------------------------
       Mobile kecil
    ----------------------------- */
    @media (max-width: 575.98px) {
        .dashboard-admin.container,
        .dashboard-admin.container-fluid {
            padding-left: 14px;
            padding-right: 14px;
        }

        .dashboard-admin .row {
            --bs-gutter-x: 0.9rem;
        }

        .page-title,
        .topbar-title,
        .header-title,
        .dashboard-page-title,
        header.navbar h1,
        header.navbar h2,
        header.navbar .fw-bold,
        .content-header h1,
        .content-header h2 {
            font-size: 1rem;
        }

        .profile-name,
        .user-name,
        .topbar-profile-name,
        .header-profile-name {
            max-width: 72px;
            font-size: 0.85rem;
        }

        .dashboard-title {
            font-size: 1.25rem;
        }

        .dashboard-subtitle {
            font-size: 0.88rem;
        }

        .dashboard-stat-title {
            font-size: 0.85rem;
        }

        .dashboard-stat-number {
            font-size: 1.3rem;
        }

        .dashboard-admin .card {
            border-radius: 14px;
        }

        .dashboard-admin .card-header {
            padding: 0.85rem 0.95rem;
            font-size: 0.92rem;
        }

        .dashboard-admin .card-body {
            padding: 0.95rem;
        }

        .dashboard-map-wrapper,
        .dashboard-map {
            border-radius: 10px;
        }

        .dashboard-map {
            height: 240px;
        }

        .dashboard-activity .list-group-item {
            font-size: 0.88rem;
        }
    }
</style>

<div class="container dashboard-admin">
    <div class="row dashboard-header">
        <div class="col-12">
            <h2 class="fw-bold dashboard-title">Dashboard Admin {{ Auth::user()->name }}</h2>
            <p class="text-muted dashboard-subtitle">
                Selamat datang di Sistem Informasi Pemetaan Keterampilan Warga Desa
            </p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Total Warga -->
        <div class="col-6 col-md-3">
            <div class="card shadow border-0 dashboard-stat-card">
                <div class="card-body">
                    <h6 class="text-muted dashboard-stat-title">Total Warga</h6>
                    <h3 class="fw-bold dashboard-stat-number">{{ $totalWarga ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <!-- Total Keterampilan -->
        <div class="col-6 col-md-3">
            <div class="card shadow border-0 dashboard-stat-card">
                <div class="card-body">
                    <h6 class="text-muted dashboard-stat-title">Total Keterampilan</h6>
                    <h3 class="fw-bold dashboard-stat-number">{{ $totalSkill ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <!-- Total Dusun -->
        <div class="col-6 col-md-3">
            <div class="card shadow border-0 dashboard-stat-card">
                <div class="card-body">
                    <h6 class="text-muted dashboard-stat-title">Total Dusun</h6>
                    <h3 class="fw-bold dashboard-stat-number">{{ $totalDusun ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <!-- Total RT/RW -->
        <div class="col-6 col-md-3">
            <div class="card shadow border-0 dashboard-stat-card">
                <div class="card-body">
                    <h6 class="text-muted dashboard-stat-title">Total RT/RW</h6>
                    <h3 class="fw-bold dashboard-stat-number">{{ $totalRTRW ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5 g-4 dashboard-section-gap">
        <div class="col-12 col-lg-8">
            <div class="card shadow border-0 h-100">
                <div class="card-header bg-white fw-bold">
                    Peta Sebaran Keterampilan
                </div>
                <div class="card-body">
                    <div class="dashboard-map-wrapper">
                        <div id="map" class="dashboard-map"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card shadow border-0 h-100">
                <div class="card-header bg-white fw-bold">
                    Aktivitas Terbaru
                </div>
                <div class="card-body dashboard-activity">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Data warga ditambahkan</li>
                        <li class="list-group-item">Keterampilan baru ditambahkan</li>
                        <li class="list-group-item">Update lokasi warga</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet Map -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    /* =========================================================
       LEAFLET MAP
       - Inisialisasi peta
       - Aman untuk resize di mobile / tablet
    ========================================================= */
    const map = L.map('map').setView([-6.326, 108.320], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    function refreshMapSize() {
        setTimeout(function () {
            map.invalidateSize();
        }, 250);
    }

    window.addEventListener('load', refreshMapSize);
    window.addEventListener('resize', refreshMapSize);

    document.addEventListener('click', function (e) {
        const target = e.target.closest('.navbar-toggler, .sidebar-toggle, [data-bs-toggle="collapse"]');
        if (target) {
            setTimeout(function () {
                map.invalidateSize();
            }, 350);
        }
    });
</script>
@endsection