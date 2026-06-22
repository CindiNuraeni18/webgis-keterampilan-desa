<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SIPKAR Admin')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Leaflet CSS -->

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        :root {
            --bg-body: #f4f7fb;
            --accent-blue: #2563eb;
            --accent-blue-soft: rgba(37, 99, 235, 0.12);
            --sidebar-dark: #0f172a;
            --sidebar-dark-2: #111c34;
            --glass-white: rgba(255, 255, 255, 0.78);
            --text-main: #0f172a;
            --text-soft: #64748b;
            --border-soft: #e2e8f0;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.08), transparent 22%),
                radial-gradient(circle at bottom right, rgba(96, 239, 255, 0.08), transparent 20%),
                var(--bg-body);
            min-height: 100vh;
            overflow: hidden;
            color: var(--text-main);
        }

        a {
            text-decoration: none;
        }

        .app-container {
            display: flex;
            height: 100vh;
            padding: 1rem;
            gap: 1rem;
            overflow: hidden;
        }

        .main-wrapper {
            flex: 1;
            min-width: 0;
            min-height: 0;
            height: 100%;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            overflow: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 290px;
            height: 100%;
            min-height: 0;
            background: linear-gradient(180deg, var(--sidebar-dark) 0%, var(--sidebar-dark-2) 100%);
            border-radius: 24px;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.22);
            border: 1px solid rgba(255, 255, 255, 0.04);
            overflow: hidden;
        }

        .sidebar-header {
            padding: 1.6rem 1.4rem 1.2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            flex-shrink: 0;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 14px;
            color: #fff;
            font-weight: 800;
            font-size: 1.2rem;
            letter-spacing: 0.2px;
        }

        .brand-logo-img {
            width: 58px;

            height: 58px;

            object-fit: contain;

            flex-shrink: 0;
        }

        .brand-subtitle {
            font-size: 0.78rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.55);
            margin-top: 2px;
        }

        .sidebar-menu-wrapper {
            flex: 1;
            min-height: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .nav-list {
            list-style: none;
            margin: 0;
            padding: 1.2rem 0.9rem;
            flex: 1;
            min-height: 0;
            overflow-y: auto;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        .nav-section-title {
            padding: 0.5rem 0.9rem 0.7rem;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.35);
        }

        .nav-item {
            margin-bottom: 0.35rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 16px;
            color: #94a3b8;
            font-weight: 500;
            transition: all 0.25s ease;
            position: relative;
        }

        .nav-link .icon-wrap {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.04);
            color: #cbd5e1;
            transition: all 0.25s ease;
            flex-shrink: 0;
        }

        .nav-link .nav-text {
            flex: 1;
        }

        .nav-link .nav-arrow {
            font-size: 0.8rem;
            opacity: 0;
            transform: translateX(-4px);
            transition: all 0.25s ease;
        }

        .nav-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.06);
            transform: translateX(3px);
        }

        .nav-link:hover .icon-wrap {
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
        }

        .nav-link:hover .nav-arrow {
            opacity: 1;
            transform: translateX(0);
        }

        .nav-link.active {
            color: #fff;
            background: linear-gradient(90deg, rgba(37, 99, 235, 1) 0%, rgba(59, 130, 246, 0.95) 100%);
            box-shadow: 0 14px 25px rgba(37, 99, 235, 0.28);
        }

        .nav-link.active .icon-wrap {
            background: rgba(255, 255, 255, 0.16);
            color: #fff;
        }

        /* Topbar */
        .topbar {
            height: 80px;
            flex-shrink: 0;
            background: var(--glass-white);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-radius: 22px;
            border: 1px solid rgba(255, 255, 255, 0.55);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.4rem;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
            overflow: visible;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .page-info h1 {
            margin: 0;
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .page-info p {
            margin: 2px 0 0;
            font-size: 0.82rem;
            color: var(--text-soft);
        }

        .mobile-toggle {
            width: 46px;
            height: 46px;
            border: none;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: white;
            border-radius: 14px;
            display: none;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 18px rgba(15, 23, 42, 0.18);
            flex-shrink: 0;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .search-box {
            width: 290px;
            height: 48px;
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid var(--border-soft);
            border-radius: 16px;
            display: flex;
            align-items: center;
            padding: 0 14px;
            transition: all 0.25s ease;
        }

        .search-box:focus-within {
            border-color: rgba(37, 99, 235, 0.4);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.08);
        }

        .search-box i {
            color: #94a3b8;
            font-size: 0.95rem;
        }

        .search-box input {
            width: 100%;
            border: none;
            outline: none;
            background: transparent;
            padding-left: 10px;
            font-size: 0.92rem;
            color: var(--text-main);
        }

        .search-box input::placeholder {
            color: #94a3b8;
        }

        /* ===============================
   TOMBOL NOTIF AKTIF
================================= */
        .icon-btn {
            width: 46px;
            height: 46px;
            border-radius: 15px;
            border: 1px solid var(--border-soft);
            background: rgba(255, 255, 255, 0.96);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #334155;
            position: relative;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            flex-shrink: 0;
        }

        .icon-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 18px rgba(15, 23, 42, 0.08);
            background: #fff;
            color: var(--accent-blue);
        }

        /* tombol aktif */
        .icon-btn.show,
        .icon-btn:active {
            background: var(--accent-blue-soft) !important;
            color: var(--accent-blue) !important;
            border-color: rgba(37, 99, 235, 0.3) !important;
            transform: scale(0.95);
            box-shadow: inset 0 2px 4px rgba(37, 99, 235, 0.1);
        }

        /* ===============================
   DROPDOWN NOTIF
================================= */
        .notif-dropdown {
            width: 360px;
            border-radius: 22px;
            overflow: hidden;
            padding: 0;
            display: block;
            visibility: hidden;
            opacity: 0;
            transform: translateY(15px) scale(0.95);

            transition:
                all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);

            z-index: 99999 !important;
        }

        /* saat notif dibuka */
        .notif-dropdown.show {
            visibility: visible;
            opacity: 1;
            transform: translateY(10px) scale(1);
        }

        /* ===============================
   HEADER NOTIF
================================= */
        .notif-header {
            padding: 18px 20px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8fafc;
        }

        /* ===============================
   ITEM NOTIF
================================= */
        .notif-item {
            display: flex;
            gap: 14px;
            padding: 16px 18px;
            transition: all 0.2s ease;
            border-bottom: 1px solid #f1f5f9;
            color: #0f172a;
        }

        .notif-item:hover {
            background: #f8fafc;
            transform: translateX(4px);
        }

        .notif-icon {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            background: rgba(37, 99, 235, .1);
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1rem;
        }

        .notif-content {
            flex: 1;
            min-width: 0;
        }

        .notif-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 4px;
        }

        .notif-name {
            font-weight: 700;
            font-size: .92rem;
        }

        .notif-message {
            font-size: .83rem;
            color: #475569;
            margin-bottom: 4px;
            line-height: 1.4;
        }

        .notif-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: #2563eb;
            flex-shrink: 0;
        }

        /* ===============================
   FOOTER NOTIF
================================= */
        .notif-footer {
            padding: 14px 18px;
            background: #fff;
            text-align: center;
            border-top: 1px solid #f1f5f9;
        }

        .lihat-semua-link {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: .92rem;
            font-weight: 600;
            color: #2563eb;
            transition: .2s ease;
        }

        .lihat-semua-link i {
            font-size: 1.1rem;
            transition: .2s ease;
        }

        .lihat-semua-link:hover {
            color: #1d4ed8;
            gap: 8px;
        }

        .lihat-semua-link:hover i {
            transform: translateX(2px);
        }

        /* ===============================
   FIX DROPDOWN TIDAK BENTROK
================================= */
        .dropdown-menu {
            z-index: 99999 !important;
            position: absolute !important;
        }

        .topbar,
        .topbar-actions,
        .dropdown {
            position: relative;
            z-index: 9999;
        }

        .leaflet-container {
            z-index: 1 !important;
        }

        /* ===============================
   MOBILE
================================= */
        @media (max-width: 575.98px) {

            .notif-dropdown {
                width: 320px;
                max-width: 92vw;
                right: 0 !important;
                left: auto !important;
            }

        }

        .profile-btn {
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid var(--border-soft);
            border-radius: 18px;
            padding: 6px 8px 6px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .profile-btn:hover {
            box-shadow: 0 12px 22px rgba(15, 23, 42, 0.08);
            transform: translateY(-1px);
        }

        .profile-btn:focus,
        .profile-btn:focus-visible {
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.15);
        }

        .profile-meta {
            text-align: right;
            line-height: 1.2;
        }

        .profile-meta .name {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .profile-meta .role {
            font-size: 0.72rem;
            color: var(--text-soft);
        }

        .avatar-small {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: linear-gradient(135deg, #2563eb, #60a5fa);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.22);
            object-fit: cover;
            flex-shrink: 0;
        }

        /* Content */
        .content-container {
            flex: 1;
            min-height: 0;
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid var(--border-soft);
            border-radius: 24px;
            padding: 1.5rem;
            overflow-y: auto;
            overflow-x: hidden;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04);
            -webkit-overflow-scrolling: touch;
        }

        /* Tablet */
        @media (max-width: 1199.98px) {
            .search-box {
                width: 220px;
            }
        }

        /* Mobile / Tablet */
        @media (max-width: 991.98px) {

            html,
            body {
                height: 100%;
                overflow: hidden;
            }

            body {
                overflow: hidden;
            }

            .app-container {
                height: 100vh;
                min-height: 100vh;
                padding: 0.75rem;
                gap: 0.75rem;
                overflow: hidden;
            }

            .main-wrapper {
                height: calc(100vh - 1.5rem);
                min-height: 0;
                overflow: hidden;
            }

            .sidebar {
                display: none;
            }

            .mobile-toggle {
                display: inline-flex;
            }

            .topbar {
                height: auto;
                min-height: 72px;
                padding: 0.9rem 1rem;
            }

            .page-info h1 {
                font-size: 1rem;
            }

            .page-info p {
                font-size: 0.76rem;
            }

            .search-box {
                display: none;
            }

            .profile-meta {
                display: none;
            }

            .icon-btn {
                width: 42px;
                height: 42px;
                border-radius: 13px;
            }

            .profile-btn {
                padding: 5px;
                border-radius: 14px;
            }

            .avatar-small {
                width: 40px;
                height: 40px;
                border-radius: 12px;
            }

            .content-container {
                flex: 1;
                min-height: 0;
                height: auto;
                padding: 1rem;
                border-radius: 20px;
                overflow-y: auto;
                overflow-x: hidden;
            }
        }

        @media (max-width: 575.98px) {

            html,
            body {
                overflow: hidden;
            }

            .app-container {
                height: 100vh;
                min-height: 100vh;
                padding: 0.5rem;
                gap: 0.75rem;
                overflow: hidden;
            }

            .main-wrapper {
                height: calc(100vh - 1rem);
                overflow: hidden;
            }

            .topbar {
                border-radius: 18px;
                padding: 0.85rem;
            }

            .topbar-actions {
                gap: 8px;
            }

            .page-info p {
                display: none;
            }

            .content-container {
                padding: 0.9rem;
                border-radius: 18px;
                overflow-y: auto;
            }
        }

        /* Offcanvas */
        .offcanvas-admin {
            width: 290px !important;
            background: linear-gradient(180deg, var(--sidebar-dark) 0%, var(--sidebar-dark-2) 100%);
            color: white;
        }

        .offcanvas-admin .offcanvas-header {
            padding: 1.35rem 1.25rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            flex-shrink: 0;
        }

        .offcanvas-admin .offcanvas-body {
            min-height: 0;
            overflow: hidden;
        }

        .offcanvas-admin .btn-close {
            filter: invert(1);
            opacity: 1;
        }

        /* Scrollbar menu */
        .nav-list::-webkit-scrollbar {
            width: 6px;
        }

        .nav-list::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.35);
            border-radius: 999px;
        }

        .nav-list::-webkit-scrollbar-track {
            background: transparent;
        }

        /* Global Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 999px;
        }

        /* FIX DROPDOWN AGAR DI DEPAN */
        .dropdown-menu {
            z-index: 9999 !important;
            position: absolute !important;
        }

        .topbar,
        .topbar-actions,
        .dropdown {
            position: relative;
            z-index: 9999;
        }

        /* FIX AGAR MAP / ANIMASI TIDAK MENIMPA */
        .leaflet-container {
            z-index: 1 !important;
        }

        /* KHUSUS MOBILE FIX */
        @media (max-width: 991.98px) {

            /* turunkan topbar saat mobile */
            .topbar {
                position: relative;
                z-index: 1 !important;
            }

            /* naikkan sidebar mobile */
            .offcanvas {
                z-index: 99999 !important;
            }

            /* backdrop juga ikut */
            .offcanvas-backdrop {
                z-index: 99998 !important;
            }
        }

        /* notif modern */
        .notif-dropdown {
            width: 360px;
            border-radius: 22px;
            overflow: hidden;
            padding: 0;
            animation: notifFade .25s ease;
        }

        .notif-header {
            padding: 18px 20px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8fafc;
        }

        .notif-item {
            display: flex;
            gap: 14px;
            padding: 16px 18px;
            transition: .2s ease;
            border-bottom: 1px solid #f1f5f9;
            color: #0f172a;
        }

        .notif-item:hover {
            background: #f8fafc;
            transform: translateX(3px);
        }

        .notif-icon {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            background: rgba(37, 99, 235, .1);
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1rem;
        }

        .notif-content {
            flex: 1;
            min-width: 0;
        }

        .notif-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 4px;
        }

        .notif-name {
            font-weight: 700;
            font-size: .92rem;
        }

        .notif-message {
            font-size: .83rem;
            color: #475569;
            margin-bottom: 4px;
            line-height: 1.4;
        }

        .notif-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: #2563eb;
            flex-shrink: 0;
        }

        .notif-footer {
            padding: 16px;
            background: #fff;
        }

        @keyframes notifFade {

            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }

        }

        /* footer notif */
        .notif-footer {
            padding: 14px 18px;
            background: #fff;
            text-align: center;
        }

        /* lihat semua */
        .lihat-semua-link {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: .92rem;
            font-weight: 600;
            color: #2563eb;
            transition: .2s ease;
        }

        .lihat-semua-link i {
            font-size: 1.1rem;
            transition: .2s ease;
        }

        .lihat-semua-link:hover {
            color: #1d4ed8;
            gap: 8px;
        }

        .lihat-semua-link:hover i {
            transform: translateX(2px);
        }
    </style>
</head>

<body>
    @php
        $notifPesan = \App\Models\Pesan::where('status_baca', false)->count();
    @endphp

    <div class="app-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <a href="#" class="brand-logo">
                    <img src="{{ asset('images/logo-indramayu.png') }}" alt="Logo" class="brand-logo-img">
                    <div>
                        <div>SIKARMAP</div>
                        <div class="brand-subtitle">Desa Karangmulya</div>
                    </div>
                </a>
            </div>

            <div class="sidebar-menu-wrapper">
                <ul class="nav-list">
                    <li class="nav-section-title">Main Menu</li>

                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <span class="icon-wrap"><i class="bi bi-grid-fill"></i></span>
                            <span class="nav-text">Dashboard</span>
                            <i class="bi bi-chevron-right nav-arrow"></i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.dusun.index') }}"
                            class="nav-link {{ request()->routeIs('admin.dusun.*') ? 'active' : '' }}">
                            <span class="icon-wrap"><i class="bi bi-geo-alt-fill"></i></span>
                            <span class="nav-text">Data Dusun</span>
                            <i class="bi bi-chevron-right nav-arrow"></i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.rw.index') }}"
                            class="nav-link {{ request()->routeIs('admin.rw.*') ? 'active' : '' }}">
                            <span class="icon-wrap"><i class="bi bi-diagram-3-fill"></i></span>
                            <span class="nav-text">Data RW</span>
                            <i class="bi bi-chevron-right nav-arrow"></i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.rt.index') }}"
                            class="nav-link {{ request()->routeIs('admin.rt.*') ? 'active' : '' }}">
                            <span class="icon-wrap"><i class="bi bi-person-badge-fill"></i></span>
                            <span class="nav-text">Data RT</span>
                            <i class="bi bi-chevron-right nav-arrow"></i>
                        </a>
                    </li>

     <li class="nav-item">
                        <a href="{{ route('admin.kategori-keterampilan.index') }}"
                            class="nav-link {{ request()->routeIs('admin.kategori-keterampilan.*') ? 'active' : '' }}">
                            <span class="icon-wrap"><i class="bi bi-stars"></i></span>
                            <span class="nav-text">Kategori Keterampilan</span>
                            <i class="bi bi-chevron-right nav-arrow"></i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.warga.index') }}"
                            class="nav-link {{ request()->routeIs('admin.warga.*') ? 'active' : '' }}">
                            <span class="icon-wrap"><i class="bi bi-people-fill"></i></span>
                            <span class="nav-text">Data Warga</span>
                            <i class="bi bi-chevron-right nav-arrow"></i>
                        </a>
                    </li>

                    {{-- <li class="nav-item">
                        <a href="{{ route('admin.keterampilan.index') }}"
                            class="nav-link 
    {{ request()->routeIs('admin.keterampilan.index') ||
    request()->routeIs('admin.keterampilan.create') ||
    request()->routeIs('admin.keterampilan.edit') ||
    request()->routeIs('admin.keterampilan.show')
        ? 'active'
        : '' }}">
                            <span class="icon-wrap"><i class="bi bi-stars"></i></span>
                            <span class="nav-text">Data Keterampilan</span>
                            <i class="bi bi-chevron-right nav-arrow"></i>
                        </a>
                    </li> --}}

                    <li class="nav-item">
                        <a href="{{ route('admin.pemetaan.index') }}"
                            class="nav-link {{ request()->routeIs('admin.pemetaan.*') ? 'active' : '' }}">
                            <span class="icon-wrap"><i class="bi bi-map-fill"></i></span>
                            <span class="nav-text">Pemetaan</span>
                            <i class="bi bi-chevron-right nav-arrow"></i>
                        </a>
                    </li>

                    {{-- <li class="nav-section-title mt-2">Laporan</li>

                    <li class="nav-item">
                        <a href="{{ route('admin.keterampilan.statistik') }}"
                            class="nav-link {{ request()->routeIs('admin.keterampilan.statistik') ? 'active' : '' }}">

                            <span class="icon-wrap"><i class="bi bi-bar-chart-steps"></i></span>
                            <span class="nav-text">Statistik</span>
                            <i class="bi bi-chevron-right nav-arrow"></i>
                        </a>
                    </li> --}}

                    <li class="nav-item">
                        <a href="{{ route('admin.keterampilan.laporan') }}"
                            class="nav-link {{ request()->routeIs('admin.keterampilan.laporan') ? 'active' : '' }}">

                            <span class="icon-wrap"><i class="bi bi-file-earmark-text-fill"></i></span>
                            <span class="nav-text">Laporan</span>
                            <i class="bi bi-chevron-right nav-arrow"></i>
                        </a>
                    </li>

                    <li class="nav-section-title mt-2">Pengaturan</li>

                    <li class="nav-item">
                        <a href="{{ route('admin.backup.index') }}"
                            class="nav-link {{ request()->routeIs('admin.backup.*') ? 'active' : '' }}">
                            <span class="icon-wrap"><i class="bi bi-database-fill-gear"></i></span>
                            <span class="nav-text">Backup Data</span>
                            <i class="bi bi-chevron-right nav-arrow"></i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.pesan.index') }}"
                            class="nav-link {{ request()->routeIs('admin.pesan.*') ? 'active' : '' }}">

                            <span class="icon-wrap">
                                <i class="bi bi-chat-dots-fill"></i>
                            </span>

                            <span class="nav-text d-flex align-items-center justify-content-between w-100">

                                Pengajuan Keterampilan

                                @if ($notifPesan > 0)
                                    <span class="badge bg-danger rounded-pill ms-2">

                                        {{ $notifPesan }}

                                    </span>
                                @endif

                            </span>

                            <i class="bi bi-chevron-right nav-arrow"></i>
                        </a>
                    </li>

                </ul>
            </div>
        </aside>

        <div class="main-wrapper">
            <header class="topbar">
                <div class="topbar-left">
                    <button class="mobile-toggle d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu"
                        type="button">
                        <i class="bi bi-list fs-4"></i>
                    </button>

                    <div class="page-info">
                        <h1>@yield('title', 'Dashboard')</h1>
                    </div>
                </div>

                <div class="topbar-actions">
                    <div class="search-box d-none d-md-flex">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Cari data warga, laporan, dusun...">
                    </div>

                    <div class="dropdown">

                        <button class="icon-btn d-none d-sm-inline-flex position-relative" type="button"
                            data-bs-toggle="dropdown">

                            <i class="bi bi-bell"></i>

                            @if ($notifPesan > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle
            badge rounded-pill bg-danger">

                                    {{ $notifPesan }}

                                </span>
                            @endif

                        </button>

                        <ul class="dropdown-menu dropdown-menu-end notif-dropdown border-0 shadow">

                            <!-- header -->
                            <li class="notif-header">

                                <div>

                                    <h6 class="mb-0 fw-bold">
                                        Notifikasi
                                    </h6>

                                    <small class="text-muted">
                                        Pesan masyarakat terbaru
                                    </small>

                                </div>

                                @if ($notifPesan > 0)
                                    <span class="badge bg-danger rounded-pill">
                                        {{ $notifPesan }}
                                    </span>
                                @endif

                            </li>

                            @php
                                $pesanBaru = \App\Models\Pesan::where('status_baca', false)->latest()->take(5)->get();
                            @endphp

                            @forelse($pesanBaru as $pesan)
                                <li>

                                    <a href="{{ route('admin.pesan.index') }}" class="notif-item">

                                        <div class="notif-icon">

                                            <i class="bi bi-chat-dots-fill"></i>

                                        </div>

                                        <div class="notif-content">

                                            <div class="notif-top">

                                                <span class="notif-name">
                                                    {{ $pesan->nama }}
                                                </span>

                                                <span class="notif-dot"></span>

                                            </div>

                                            <div class="notif-message">

                                                {{ \Illuminate\Support\Str::limit($pesan->pesan, 55) }}

                                            </div>

                                            <small class="text-muted">

                                                Pengajuan keterampilan baru

                                            </small>

                                        </div>

                                    </a>

                                </li>

                            @empty

                                <li class="text-center py-5 text-muted">

                                    <i class="bi bi-bell fs-2 d-block mb-2"></i>

                                    Tidak ada notifikasi baru

                                </li>
                            @endforelse

                            <!-- footer -->
                            <li class="notif-footer">

                                <a href="{{ route('admin.pesan.index') }}" class="lihat-semua-link">

                                    Lihat semua pesan

                                    <i class="bi bi-arrow-right-short"></i>

                                </a>

                            </li>

                        </ul>

                    </div>

                    <div class="dropdown">
                        <button class="profile-btn border-0" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <div class="profile-meta d-none d-sm-block">
                                <div class="name">{{ auth()->user()->name }}</div>
                                <div class="role">{{ auth()->user()->jabatan ?? 'Admin Desa' }}</div>
                            </div>

                            @if (auth()->user()->foto)
                                <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Foto Profil"
                                    class="avatar-small">
                            @else
                                <div class="avatar-small">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-3 p-2"
                            style="border-radius: 16px; min-width: 220px;">
                            <li>
                                <a class="dropdown-item rounded-3 py-2" href="{{ route('admin.profile') }}">
                                    <i class="bi bi-person me-2"></i> Profil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item rounded-3 py-2" href="{{ route('admin.settings') }}">
                                    <i class="bi bi-gear me-2"></i> Pengaturan
                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item rounded-3 py-2 text-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-power me-2"></i> Keluar
                                </a>
                            </li>
                        </ul>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </header>

            <main class="content-container">
                @yield('content')
            </main>
        </div>
    </div>

    <div class="offcanvas offcanvas-start offcanvas-admin border-0" tabindex="-1" id="mobileMenu">
        <div class="offcanvas-header">
            <a href="#" class="brand-logo">
                <div class="brand-mark">
                    <i class="bi bi-cpu-fill"></i>
                </div>
                <div>
                    <div>SIPKAR ADMIN</div>
                    <div class="brand-subtitle">Desa Karangmulya</div>
                </div>
            </a>

            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="sidebar-menu-wrapper">
            <ul class="nav-list mt-2">
                <li class="nav-section-title">Main Menu</li>

                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="icon-wrap"><i class="bi bi-grid-fill"></i></span>
                        <span class="nav-text">Dashboard</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.dusun.index') }}"
                        class="nav-link {{ request()->routeIs('admin.dusun.*') ? 'active' : '' }}">
                        <span class="icon-wrap"><i class="bi bi-geo-alt-fill"></i></span>
                        <span class="nav-text">Data Dusun</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.rw.index') }}"
                        class="nav-link {{ request()->routeIs('admin.rw.*') ? 'active' : '' }}">
                        <span class="icon-wrap"><i class="bi bi-diagram-3-fill"></i></span>
                        <span class="nav-text">Data RW</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.rt.index') }}"
                        class="nav-link {{ request()->routeIs('admin.rt.*') ? 'active' : '' }}">
                        <span class="icon-wrap"><i class="bi bi-person-badge-fill"></i></span>
                        <span class="nav-text">Data RT</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

 <li class="nav-item">
                    <a href="{{ route('admin.kategori-keterampilan.index') }}"
                        class="nav-link {{ request()->routeIs('admin.kategori-keterampilan.*') ? 'active' : '' }}">
                        <span class="icon-wrap"><i class="bi bi-tags-fill"></i></span>
                        <span class="nav-text">Kategori Keterampilan</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.warga.index') }}"
                        class="nav-link {{ request()->routeIs('admin.warga.*') ? 'active' : '' }}">
                        <span class="icon-wrap"><i class="bi bi-people-fill"></i></span>
                        <span class="nav-text">Data Warga</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                {{-- <li class="nav-item">
                    <a href="{{ route('admin.keterampilan.index') }}"
                        class="nav-link 
    {{ request()->routeIs('admin.keterampilan.index') ||
    request()->routeIs('admin.keterampilan.create') ||
    request()->routeIs('admin.keterampilan.edit') ||
    request()->routeIs('admin.keterampilan.show')
        ? 'active'
        : '' }}">
                        <span class="icon-wrap"><i class="bi bi-stars"></i></span>
                        <span class="nav-text">Data Keterampilan</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li> --}}

                <li class="nav-item">
                    <a href="{{ route('admin.pemetaan.index') }}"
                        class="nav-link {{ request()->routeIs('admin.pemetaan.*') ? 'active' : '' }}">
                        <span class="icon-wrap"><i class="bi bi-map-fill"></i></span>
                        <span class="nav-text">Pemetaan</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-section-title mt-2">Laporan</li>


                <li class="nav-item">
                    <a href="{{ route('admin.keterampilan.statistik') }}"
                        class="nav-link {{ request()->routeIs('admin.keterampilan.statistik') ? 'active' : '' }}">

                        <span class="icon-wrap"><i class="bi bi-bar-chart-steps"></i></span>
                        <span class="nav-text">Statistik</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

            </ul>
        </div>

        <div class="sidebar-footer pt-0"></div>
    </div>

    <!-- Leaflet JS -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // DESKTOP
            const activeDesktop = document.querySelector('.sidebar .nav-link.active');
            if (activeDesktop) {
                activeDesktop.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }

            // MOBILE (offcanvas)
            const activeMobile = document.querySelector('#mobileMenu .nav-link.active');
            if (activeMobile) {
                activeMobile.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }

        });
    </script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

</body>

</html>
