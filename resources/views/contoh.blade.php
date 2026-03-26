<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SIPKAR Admin')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --bg-body: #f0f2f5;
            --accent-blue: #0061ff;
            --sidebar-dark: #0f172a;
            --glass-white: rgba(255, 255, 255, 0.85);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            height: 100vh;
            overflow: hidden;
            color: #1e293b;
        }

        /* --- LAYOUT STRUCTURE --- */
        .app-container {
            display: flex;
            height: 100vh;
            padding: 1rem;
            gap: 1rem;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 280px;
            background: var(--sidebar-dark);
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            flex-shrink: 0;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .brand-logo {
            font-weight: 700;
            font-size: 1.4rem;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .nav-list {
            padding: 1.5rem 1rem;
            list-style: none;
            margin: 0;
            flex-grow: 1;
            overflow-y: auto;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 500;
            transition: 0.2s;
            margin-bottom: 0.3rem;
        }

        .nav-link i { font-size: 1.2rem; margin-right: 12px; }

        .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.08);
        }

        .nav-link.active {
            background: var(--accent-blue);
            color: #fff;
            box-shadow: 0 10px 15px -3px rgba(0, 97, 255, 0.3);
        }

        /* --- MAIN CONTENT --- */
        .main-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            min-width: 0;
        }

        /* --- TOPBAR --- */
        .topbar {
            background: var(--glass-white);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            height: 75px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .search-box {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 6px 15px;
            display: flex;
            align-items: center;
            width: 260px;
        }

        .search-box input {
            border: none;
            outline: none;
            padding-left: 10px;
            font-size: 0.9rem;
            width: 100%;
        }

        /* --- PROFILE DROPDOWN --- */
        .profile-btn {
            background: #fff;
            border: 1px solid #e2e8f0;
            padding: 5px 5px 5px 15px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: 0.2s;
        }

        .profile-btn:hover { background: #f8fafc; }

        .avatar-small {
            width: 38px;
            height: 38px;
            background: var(--accent-blue);
            color: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* --- CONTENT BOX --- */
        .content-container {
            flex-grow: 1;
            background: #fff;
            border-radius: 20px;
            padding: 1.5rem;
            overflow-y: auto;
            border: 1px solid #e2e8f0;
        }

        /* --- MOBILE ADAPTATION --- */
        @media (max-width: 991.98px) {
            .app-container { padding: 0.5rem; }
            .sidebar { display: none; }
            .topbar { padding: 0 1rem; height: 65px; }
            .search-box { display: none !important; }
            .page-info h1 { font-size: 1.1rem; }
            
            .mobile-toggle {
                width: 40px;
                height: 40px;
                background: var(--sidebar-dark);
                color: white;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-right: 10px;
                cursor: pointer;
            }
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body>

<div class="app-container">
    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="#" class="brand-logo">
                <i class="bi bi-cpu-fill text-primary"></i> 
                <span>SIPKAR<span class="text-primary opacity-75">ADMIN</span></span>
            </a>
        </div>
        
        <ul class="nav-list">
            <li class="nav-item">
                <a href="#" class="nav-link active"><i class="bi bi-grid-fill"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link"><i class="bi bi-people-fill"></i> Data Warga</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link"><i class="bi bi-stars"></i> Keterampilan</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link"><i class="bi bi-geo-alt-fill"></i> Wilayah Dusun</a>
            </li>
            <li class="nav-item mt-4 ms-3">
                <span class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">Laporan</span>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link"><i class="bi bi-bar-chart-steps"></i> Statistik</a>
            </li>
        </ul>

        <div class="p-3">
            <div class="bg-primary bg-opacity-10 p-3 rounded-4 border border-primary border-opacity-10">
                <p class="text-white small mb-1">Butuh bantuan?</p>
                <a href="#" class="text-primary small text-decoration-none fw-bold">Support Center</a>
            </div>
        </div>
    </aside>

    <div class="main-wrapper">
        <header class="topbar">
            <div class="d-flex align-items-center">
                <div class="mobile-toggle d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                    <i class="bi bi-list fs-4"></i>
                </div>
                <div class="page-info">
                    <h1 class="m-0 h5 fw-bold text-dark">@yield('title', 'Dashboard')</h1>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="search-box d-none d-md-flex">
                    <i class="bi bi-search text-muted"></i>
                    <input type="text" placeholder="Search data...">
                </div>

                <div class="dropdown">
                    <div class="profile-btn" data-bs-toggle="dropdown">
                        <div class="d-none d-sm-block text-end me-2">
                            <p class="mb-0 fw-bold small">Alexandre</p>
                            <p class="mb-0 text-muted" style="font-size: 0.65rem;">Super Admin</p>
                        </div>
                        <div class="avatar-small">A</div>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-3 p-2" style="border-radius: 15px;">
                        <li><a class="dropdown-item rounded-3" href="#"><i class="bi bi-person me-2"></i> Profile</a></li>
                        <li><a class="dropdown-item rounded-3" href="#"><i class="bi bi-gear me-2"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item rounded-3 text-danger" href="#"><i class="bi bi-power me-2"></i> Sign Out</a></li>
                    </ul>
                </div>
            </div>
        </header>

        <main class="content-container">
            @yield('content')
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 text-white" style="background: linear-gradient(45deg, #0061ff, #60efff);">
                        <p class="mb-1 opacity-75">Total Population</p>
                        <h2 class="fw-bold mb-0">12,540</h2>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<div class="offcanvas offcanvas-start border-0" tabindex="-1" id="mobileMenu" style="width: 280px; background: var(--sidebar-dark);">
    <div class="offcanvas-header p-4">
        <div class="brand-logo">
            <i class="bi bi-cpu-fill text-primary"></i> 
            <span>SIPKAR<span class="text-primary opacity-75">ADMIN</span></span>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
        <ul class="nav-list mt-2">
            <li class="nav-item"><a href="#" class="nav-link active"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-people-fill"></i> Data Warga</a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-stars"></i> Keterampilan</a></li>
            <li class="nav-item mt-4 ms-3"><span class="text-white-50 small fw-bold">LAPORAN</span></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-bar-chart-steps"></i> Statistik</a></li>
        </ul>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>