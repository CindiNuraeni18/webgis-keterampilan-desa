<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SIPKAR Admin')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

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

        html, body {
            height: 100%;
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
            display: flex;
            flex-direction: column;
            gap: 1rem;
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
            border-bottom: 1px solid rgba(255,255,255,0.06);
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

        .brand-mark {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            background: linear-gradient(135deg, #2563eb, #60a5fa);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: white;
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.35);
            flex-shrink: 0;
        }

        .brand-subtitle {
            font-size: 0.78rem;
            font-weight: 500;
            color: rgba(255,255,255,0.55);
            margin-top: 2px;
        }

        .sidebar-user {
            margin: 1.25rem 1rem 0;
            padding: 1rem;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255,255,255,0.06);
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .sidebar-user-avatar {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            flex-shrink: 0;
        }

        .sidebar-user-info h6 {
            margin: 0;
            font-size: 0.92rem;
            color: #fff;
            font-weight: 600;
        }

        .sidebar-user-info p {
            margin: 2px 0 0;
            font-size: 0.76rem;
            color: rgba(255,255,255,0.58);
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
            color: rgba(255,255,255,0.35);
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
            background: rgba(255,255,255,0.04);
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
            background: rgba(255,255,255,0.06);
            transform: translateX(3px);
        }

        .nav-link:hover .icon-wrap {
            background: rgba(255,255,255,0.12);
            color: #fff;
        }

        .nav-link:hover .nav-arrow {
            opacity: 1;
            transform: translateX(0);
        }

        .nav-link.active {
            color: #fff;
            background: linear-gradient(90deg, rgba(37,99,235,1) 0%, rgba(59,130,246,0.95) 100%);
            box-shadow: 0 14px 25px rgba(37, 99, 235, 0.28);
        }

        .nav-link.active .icon-wrap {
            background: rgba(255,255,255,0.16);
            color: #fff;
        }

        .sidebar-footer {
            padding: 1rem;
            flex-shrink: 0;
        }

        .support-card {
            border-radius: 20px;
            padding: 1rem;
            background: linear-gradient(135deg, rgba(37,99,235,0.16), rgba(96,165,250,0.12));
            border: 1px solid rgba(59,130,246,0.16);
            color: #fff;
        }

        .support-card h6 {
            margin: 0 0 0.35rem;
            font-weight: 700;
        }

        .support-card p {
            margin: 0 0 0.8rem;
            color: rgba(255,255,255,0.68);
            font-size: 0.82rem;
        }

        .support-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #93c5fd;
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* Topbar */
        .topbar {
            height: 80px;
            flex-shrink: 0;
            background: var(--glass-white);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-radius: 22px;
            border: 1px solid rgba(255,255,255,0.55);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.4rem;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
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
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .search-box {
            width: 290px;
            height: 48px;
            background: rgba(255,255,255,0.96);
            border: 1px solid var(--border-soft);
            border-radius: 16px;
            display: flex;
            align-items: center;
            padding: 0 14px;
            transition: all 0.25s ease;
        }

        .search-box:focus-within {
            border-color: rgba(37,99,235,0.4);
            box-shadow: 0 0 0 4px rgba(37,99,235,0.08);
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

        .icon-btn {
            width: 46px;
            height: 46px;
            border-radius: 15px;
            border: 1px solid var(--border-soft);
            background: rgba(255,255,255,0.96);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #334155;
            position: relative;
            transition: all 0.25s ease;
        }

        .icon-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 18px rgba(15, 23, 42, 0.08);
        }

        .icon-btn .badge-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: #ef4444;
            position: absolute;
            top: 11px;
            right: 12px;
            border: 2px solid #fff;
        }

        .profile-btn {
            background: rgba(255,255,255,0.96);
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
        }

        /* Content */
        .content-container {
            flex: 1;
            min-height: 0;
            background: rgba(255,255,255,0.96);
            border: 1px solid var(--border-soft);
            border-radius: 24px;
            padding: 1.5rem;
            overflow-y: auto;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04);
        }

        /* Tablet */
        @media (max-width: 1199.98px) {
            .search-box {
                width: 220px;
            }
        }

        /* Mobile / Tablet */
        @media (max-width: 991.98px) {
            body {
                overflow: auto;
            }

            .app-container {
                min-height: 100vh;
                height: auto;
                padding: 0.75rem;
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
                padding: 1rem;
                border-radius: 20px;
            }
        }

        @media (max-width: 575.98px) {
            .app-container {
                padding: 0.5rem;
                gap: 0.75rem;
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
            border-bottom: 1px solid rgba(255,255,255,0.06);
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
    </style>
</head>
<body>

<div class="app-container">
    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="#" class="brand-logo">
                <div class="brand-mark">
                    <i class="bi bi-cpu-fill"></i>
                </div>
                <div>
                    <div>SIPKAR ADMIN</div>
                    <div class="brand-subtitle">Desa Karangmulya</div>
                </div>
            </a>
        </div>

       

        <div class="sidebar-menu-wrapper">
            <ul class="nav-list">
                <li class="nav-section-title">Main Menu</li>

                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <span class="icon-wrap"><i class="bi bi-grid-fill"></i></span>
                        <span class="nav-text">Dashboard</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-people-fill"></i></span>
                        <span class="nav-text">Data Warga</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-stars"></i></span>
                        <span class="nav-text">Keterampilan</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-geo-alt-fill"></i></span>
                        <span class="nav-text">Wilayah Dusun</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-person-badge-fill"></i></span>
                        <span class="nav-text">Data RT / RW</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-house-door-fill"></i></span>
                        <span class="nav-text">Data Rumah</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-briefcase-fill"></i></span>
                        <span class="nav-text">Pekerjaan</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-mortarboard-fill"></i></span>
                        <span class="nav-text">Pendidikan</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-heart-pulse-fill"></i></span>
                        <span class="nav-text">Kesehatan Warga</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-section-title mt-2">Laporan</li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-bar-chart-steps"></i></span>
                        <span class="nav-text">Statistik</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-file-earmark-text-fill"></i></span>
                        <span class="nav-text">Laporan Bulanan</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-file-bar-graph-fill"></i></span>
                        <span class="nav-text">Laporan Tahunan</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-archive-fill"></i></span>
                        <span class="nav-text">Arsip Laporan</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-section-title mt-2">Pengaturan</li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-person-gear"></i></span>
                        <span class="nav-text">Manajemen Admin</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-shield-lock-fill"></i></span>
                        <span class="nav-text">Hak Akses</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-gear-wide-connected"></i></span>
                        <span class="nav-text">Pengaturan Sistem</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-database-fill-gear"></i></span>
                        <span class="nav-text">Backup Data</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>
            </ul>
        </div>

        
    </aside>

    <div class="main-wrapper">
        <header class="topbar">
            <div class="topbar-left">
                <button class="mobile-toggle d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" type="button">
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

                <button class="icon-btn d-none d-sm-inline-flex" type="button">
                    <i class="bi bi-bell"></i>
                    <span class="badge-dot"></span>
                </button>

                

                <div class="dropdown">
                    <div class="profile-btn" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                        <div class="profile-meta d-none d-sm-block">
                            <div class="name">Alexandre</div>
                            <div class="role">Super Admin</div>
                        </div>
                        <div class="avatar-small">A</div>
                    </div>

                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-3 p-2" style="border-radius: 16px; min-width: 220px;">
                        <li><a class="dropdown-item rounded-3 py-2" href="#"><i class="bi bi-person me-2"></i> Profile</a></li>
                        <li><a class="dropdown-item rounded-3 py-2" href="#"><i class="bi bi-gear me-2"></i> Settings</a></li>
                        <li><a class="dropdown-item rounded-3 py-2" href="#"><i class="bi bi-shield-check me-2"></i> Role & Access</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item rounded-3 py-2 text-danger" href="#"><i class="bi bi-power me-2"></i> Sign Out</a></li>
                    </ul>
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
                    <a href="#" class="nav-link active">
                        <span class="icon-wrap"><i class="bi bi-grid-fill"></i></span>
                        <span class="nav-text">Dashboard</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-people-fill"></i></span>
                        <span class="nav-text">Data Warga</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-stars"></i></span>
                        <span class="nav-text">Keterampilan</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-geo-alt-fill"></i></span>
                        <span class="nav-text">Wilayah Dusun</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-person-badge-fill"></i></span>
                        <span class="nav-text">Data RT / RW</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-house-door-fill"></i></span>
                        <span class="nav-text">Data Rumah</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-briefcase-fill"></i></span>
                        <span class="nav-text">Pekerjaan</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-mortarboard-fill"></i></span>
                        <span class="nav-text">Pendidikan</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-heart-pulse-fill"></i></span>
                        <span class="nav-text">Kesehatan Warga</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-section-title mt-2">Laporan</li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-bar-chart-steps"></i></span>
                        <span class="nav-text">Statistik</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-file-earmark-text-fill"></i></span>
                        <span class="nav-text">Laporan Bulanan</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-file-bar-graph-fill"></i></span>
                        <span class="nav-text">Laporan Tahunan</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-archive-fill"></i></span>
                        <span class="nav-text">Arsip Laporan</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-section-title mt-2">Pengaturan</li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-person-gear"></i></span>
                        <span class="nav-text">Manajemen Admin</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-shield-lock-fill"></i></span>
                        <span class="nav-text">Hak Akses</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-gear-wide-connected"></i></span>
                        <span class="nav-text">Pengaturan Sistem</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon-wrap"><i class="bi bi-database-fill-gear"></i></span>
                        <span class="nav-text">Backup Data</span>
                        <i class="bi bi-chevron-right nav-arrow"></i>
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-footer pt-0">
           
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>