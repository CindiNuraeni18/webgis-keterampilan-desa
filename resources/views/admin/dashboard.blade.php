@extends('layouts.sidebar-admin')
@section('title', 'Dashboard')

@section('content')
    <style>
        /* =========================================================
               DASHBOARD ADMIN MODERN & RESPONSIVE WITH ANIMATIONS
            ========================================================= */

        :root {
            --primary-gradient: linear-gradient(135deg, #0d6efd, #0a58ca);
            --success-gradient: linear-gradient(135deg, #198754, #146c43);
            --warning-gradient: linear-gradient(135deg, #fd7e14, #d96609);
            --info-gradient: linear-gradient(135deg, #0dcaf0, #0aa2c0);
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            --hover-shadow: 0 15px 35px rgba(13, 110, 253, 0.15);
        }

        .dashboard-admin,
        .dashboard-admin * {
            box-sizing: border-box;
        }

        .dashboard-admin {
            overflow-x: hidden;
            width: 100%;
            padding-bottom: 2rem;
        }

        /* --- ANIMASI FADE IN UP --- */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(25px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animated-fade-in {
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }

        /* --- HEADER LAYOUT STYLE --- */
        .dashboard-header {
            margin-bottom: 2rem;
        }

        .dashboard-title {
            font-size: 2.2rem;
            color: #1e293b;
            letter-spacing: -0.5px;
        }

        .dashboard-subtitle {
            font-size: 1.05rem;
            color: #64748b;
        }

        /* --- MODERN STAT CARDS --- */
        .dashboard-stat-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            background: #ffffff;
            box-shadow: var(--card-shadow);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            height: 100%;
        }

        .dashboard-stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 38px rgba(0, 0, 0, 0.08);
        }

        .card-icon-wrapper {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
            color: #ffffff;
        }

        .bg-warga { background: var(--primary-gradient); }
        .bg-skill { background: var(--success-gradient); }
        .bg-dusun { background: var(--warning-gradient); }
        .bg-rtrw { background: var(--info-gradient); }

        .dashboard-stat-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
        }

        .dashboard-stat-number {
            font-size: 2.2rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.1;
            margin-bottom: 0;
        }

        /* --- CARD MAP & INTERACTIVE BANNER --- */
        .card-map {
            border: none;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            background: #ffffff;
            transition: box-shadow 0.3s ease;
        }

        .card-map:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
        }

        .map-info-banner {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 1rem 1.25rem;
        }

        #map {
            width: 100%;
            height: 500px;
            border-radius: 18px;
            overflow: hidden;
            position: relative;
            z-index: 1;
            border: 1px solid #e2e8f0;
            background: #f1f5f9;
        }

        /* --- MAP LEGENDA CONTROLS --- */
        #legend-box {
            position: absolute;
            bottom: 25px;
            right: 25px;
            z-index: 999;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            padding: 16px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(226, 232, 240, 0.8);
            min-width: 200px;
            font-size: 13px;
        }

        #legend-box h6 {
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 12px;
            font-size: 14px;
        }

        #legend-box p {
            margin-bottom: 8px;
            color: #475569;
            display: flex;
            align-items: center;
        }

        .kotak {
            display: inline-block;
            width: 16px;
            height: 16px;
            margin-right: 10px;
            border-radius: 4px;
            flex-shrink: 0;
        }

        .hijau { background: #198754; }
        .ungu { background: #6f42c1; }

        .bulat {
            display: inline-block;
            background: #334155;
            border-radius: 50%;
            margin-right: 10px;
            flex-shrink: 0;
        }

        .besar { width: 14px; height: 14px; border: 2px solid #fff; }
        .kecil { width: 9px; height: 9px; border: 1.5px solid #fff; }

        /* Customizing Leaflet Control Layers Dropdown */
        .leaflet-control-layers-toggle {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='%230d6efd' class='bi bi-layers-fill' viewBox='0 0 16 16'%3E%3Cpath d='M7.765 1.559a.5.5 0 0 1 .47 0l6.39 3.39a.5.5 0 0 1 0 .87l-6.39 3.39a.5.5 0 0 1-.47 0L1.375 5.819a.5.5 0 0 1 0-.87l6.39-3.39z'/%3E%3Cpath d='m1.375 9.18 6.39 3.39a.5.5 0 0 0 .47 0l6.39-3.39a.5.5 0 0 0 0-.87l-6.39-3.39a.5.5 0 0 0-.47 0L1.375 8.31a.5.5 0 0 0 0 .87z'/%3E%3Cpath d='m1.375 12.54 6.39 3.39a.5.5 0 0 0 .47 0l6.39-3.39a.5.5 0 0 0 0-.87l-6.39-3.39a.5.5 0 0 0-.47 0L1.375 11.67a.5.5 0 0 0 0 .87z'/%3E%3C/svg%3E") !important;
            background-size: 20px;
            background-position: center;
            width: 40px !important;
            height: 40px !important;
            border-radius: 12px !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.12) !important;
            border: none !important;
            background-color: #ffffff !important;
        }

        .leaflet-control-layers {
            border-radius: 14px !important;
            border: none !important;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
        }

        /* --- RESPONSIVE BREAKPOINTS --- */
        @media (max-width: 991.98px) {
            .dashboard-title { font-size: 1.8rem; }
            #map { height: 400px; }
        }

        @media (max-width: 767.98px) {
            .dashboard-admin .row { --bs-gutter-x: 1rem; --bs-gutter-y: 1rem; }
            .dashboard-title { font-size: 1.5rem; }
            .dashboard-stat-number { font-size: 1.8rem; }
            #map { height: 320px; }
            #legend-box { position: relative; bottom: 0; right: 0; margin-top: 15px; width: 100%; }
        }
    </style>

    <div class="container dashboard-admin">
        <div class="row dashboard-header animated-fade-in">
            <div class="col-12">
                <h2 class="fw-bold dashboard-title">Dashboard Admin {{ Auth::user()->name }}</h2>
                <p class="dashboard-subtitle">
                    Selamat datang di Sistem Informasi Pemetaan Keterampilan Warga Desa
                </p>
            </div>
        </div>

        <div class="row g-4 animated-fade-in delay-1">
            <div class="col-6 col-md-3">
                <div class="card dashboard-stat-card">
                    <div class="card-body">
                        <div class="card-icon-wrapper bg-warga">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16"><path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/></svg>
                        </div>
                        <h6 class="dashboard-stat-title">Total Warga</h6>
                        <h3 class="dashboard-stat-number">{{ $totalWarga ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="card dashboard-stat-card">
                    <div class="card-body">
                        <div class="card-icon-wrapper bg-skill">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-mortarboard-fill" viewBox="0 0 16 16"><path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.135 3.56a.5.5 0 0 0 0 .893L3.18 7.749a3.5 3.5 0 1 0 5.64 0l2.518-1.25 2.759 1.38a.5.5 0 0 0 .672-.223l.5-1a.5.5 0 0 0-.223-.672L8.211 2.047z"/><path d="M4.176 9.032a.5.5 0 0 0-.656.327A7 7 0 0 0 3 12c0 .542.076 1.067.218 1.564a.5.5 0 0 0 .964-.268A5.5 5.5 0 0 1 4 12c0-.853.15-1.672.428-2.428a.5.5 0 0 0-.326-.64a.5.5 0 0 0-.326.64zm8.992.327a.5.5 0 0 0-.656-.327.5.5 0 0 0-.326.64c.279.756.428 1.575.428 2.428 0 .426-.048.841-.14 1.241a.5.5 0 0 0 .964.268C13.924 13.067 14 12.542 14 12a7 7 0 0 0-.832-2.641z"/></svg>
                        </div>
                        <h6 class="dashboard-stat-title">Total Keterampilan</h6>
                        <h3 class="dashboard-stat-number">{{ $totalSkill ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="card dashboard-stat-card">
                    <div class="card-body">
                        <div class="card-icon-wrapper bg-dusun">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16"><path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/></svg>
                        </div>
                        <h6 class="dashboard-stat-title">Total Dusun</h6>
                        <h3 class="dashboard-stat-number">{{ $totalDusun ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="card dashboard-stat-card">
                    <div class="card-body">
                        <div class="card-icon-wrapper bg-rtrw">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-building-fill" viewBox="0 0 16 16"><path d="M3 0a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h3v-3.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V16h3a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1zm1 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-6 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-6 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z"/></svg>
                        </div>
                        <h6 class="dashboard-stat-title">Total RT/RW</h6>
                        <h3 class="dashboard-stat-number">{{ $totalRTRW ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4 g-4 animated-fade-in delay-2">
            <div class="col-12">
                <div class="card card-map">
                    <div class="card-body p-3 p-md-4">
                        <div class="map-info-banner d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                            <div>
                                <h5 class="fw-bold text-dark mb-1" style="font-size:1.05rem;">Pratinjau Mini GIS Desa</h5>
                                <p class="text-muted mb-0 small">Menampilkan data visual sebaran wilayah. Klik tombol di kanan untuk mengelola atau melihat analisis filter pemetaan penuh.</p>
                            </div>
                            <a href="{{ url('/admin/pemetaan') }}" class="btn btn-primary btn-sm px-4 py-2 rounded-pill shadow-sm fw-semibold d-inline-flex align-items-center gap-2">
                                Lihat Fitur Pemetaan Penuh
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16"><path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0M4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5z"/></svg>
                            </a>
                        </div>

                        <div class="position-relative">
                            <div id="map"></div>

                            <div id="legend-box">
                                <h6><b>Keterangan Peta</b></h6>
                                <p><span class="kotak hijau"></span> Dusun Kemped</p>
                                <p><span class="kotak ungu"></span> Dusun Sukamelang</p>
                                <hr class="my-2" style="border-color: #cbd5e1;">
                                <p><span class="bulat besar"></span> Marker RW</p>
                                <p><span class="bulat kecil"></span> Marker RT</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // 1. DEFINISI TAMPILAN PETA (Base Layers)
        const streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        });

        const satelliteLayer = L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles &copy; Esri'
            });

        const terrainLayer = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
            attribution: 'Style: &copy; OpenTopoMap'
        });

        // Inisialisasi Map
        const map = L.map('map', {
            center: [-6.39963, 108.11848],
            zoom: 14,
            layers: [streetLayer]
        });

        // Layer Groups
        const polygonLayer = L.layerGroup().addTo(map);
        const dusunLayer = L.layerGroup().addTo(map);
        const rwLayer = L.layerGroup().addTo(map);
        const rtLayer = L.layerGroup().addTo(map);

        // 2. LOAD GEOJSON Outline Saja
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
                try {
                    map.fitBounds(geojson.getBounds());
                } catch (e) {}
            });

        // Fungsi Warna Kategori
        function warnaKategori(kategori) {
            if (!kategori) return '#6c757d';
            let warnaList = ['#198754', '#0d6efd', '#fd7e14', '#6f42c1', '#20c997', '#dc3545', '#6610f2'];
            let index = 0;
            for (let i = 0; i < kategori.length; i++) {
                index += kategori.charCodeAt(i);
            }
            return warnaList[index % warnaList.length];
        }

        // 3. LOAD DATA API (Dusun, RW, RT)
        function loadData() {
            fetch("{{ url('/api/pemetaan') }}")
                .then(res => res.json())
                .then(data => {
                    // Bersihkan layer lama hanya jika data baru dari API berhasil diambil
                    dusunLayer.clearLayers();
                    rwLayer.clearLayers();
                    rtLayer.clearLayers();

                    // Load Polygon DUSUN terlebih dahulu
                    fetch("{{ asset('geojson/dusunreal.geojson') }}")
                        .then(response => response.json())
                        .then(dataDusun => {
                            L.geoJSON(dataDusun, {
                                interactive: false,
                                pane: 'overlayPane',
                                style: function(feature) {
                                    let namaDusun = feature.properties.dusunbaru;
                                    if (namaDusun === 'kemped') {
                                        return { color: '#198754', weight: 2, fillColor: '#198754', fillOpacity: 0.25 };
                                    }
                                    if (namaDusun === 'sukamelang') {
                                        return { color: '#6f42c1', weight: 2, fillColor: '#6f42c1', fillOpacity: 0.25 };
                                    }
                                    return { color: '#0d6efd', weight: 2, fillColor: '#0d6efd', fillOpacity: 0.15 };
                                }
                            }).addTo(dusunLayer);

                            // Tambahkan Marker RW setelah polygon Dusun selesai di-render
                            data.rw.forEach(rw => {
                                if (rw.latitude && rw.longitude) {
                                    L.circleMarker([rw.latitude, rw.longitude], {
                                        radius: 11,
                                        color: '#ffffff',
                                        weight: 2.5,
                                        fillColor: warnaKategori(rw.keterampilan_dominan),
                                        fillOpacity: 0.9
                                    })
                                    .bindPopup(`
                                        <div style="min-width:200px; font-family:'Segoe UI',sans-serif;">
                                            <h6 class="fw-bold text-primary mb-1">RW ${rw.nama_rw}</h6>
                                            <p class="mb-1 small"><b>Dusun:</b> ${rw.nama_dusun || '-'}</p>
                                            <p class="mb-1 small"><b>Total Warga:</b> ${rw.jumlah_warga || 0}</p>
                                            <p class="mb-1 small"><b>Dominan Keterampilan:</b> ${rw.keterampilan_dominan || '-'}</p>
                                        </div>
                                    `)
                                    .bindTooltip(`RW ${rw.nama_rw}`, { direction: 'top' })
                                    .addTo(rwLayer);
                                }
                            });

                            // Tambahkan Marker RT setelah polygon Dusun selesai di-render
                            data.rt.forEach(rt => {
                                if (rt.latitude && rt.longitude) {
                                    let lat = parseFloat(rt.latitude) + 0.00015;
                                    let lng = parseFloat(rt.longitude) + 0.00015;

                                    L.circleMarker([lat, lng], {
                                        radius: 6,
                                        color: '#ffffff',
                                        weight: 1.5,
                                        fillColor: warnaKategori(rt.keterampilan_dominan),
                                        fillOpacity: 0.9
                                    })
                                    .bindPopup(`
                                        <div style="min-width:200px; font-family:'Segoe UI',sans-serif;">
                                            <h6 class="fw-bold text-success mb-1">RT ${rt.nama_rt}</h6>
                                            <p class="mb-1 small"><b>RW:</b> ${rt.nama_rw || '-'}</p>
                                            <p class="mb-1 small"><b>Total Warga:</b> ${rt.jumlah_warga || 0}</p>
                                            <p class="mb-1 small"><b>Dominan Keterampilan:</b> ${rt.keterampilan_dominan || '-'}</p>
                                        </div>
                                    `)
                                    .bindTooltip(`RT ${rt.nama_rt}`, { direction: 'top' })
                                    .addTo(rtLayer);
                                }
                            });

                            // ATUR URUTAN LAYER (Z-INDEX) SETELAH SEMUA ELEMENT DI-RENDER
                            dusunLayer.bringToBack();
                            rwLayer.bringToFront();
                            rtLayer.bringToFront();
                        });
                });
        }

        loadData();
        setInterval(loadData, 15000);

        // 4. LAYER CONTROL DROPDOWN
        const baseMaps = {
            "<span class='small text-dark'> Peta Jalan</span>": streetLayer,
            "<span class='small text-dark'> Satelit</span>": satelliteLayer,
            "<span class='small text-dark'> Terrain</span>": terrainLayer
        };

        const overlayMaps = {
            "<span class='small text-dark'> Batas Wilayah</span>": polygonLayer,
            "<span class='small text-dark'> Wilayah Dusun</span>": dusunLayer,
            "<span class='small text-dark'> Titik RW</span>": rwLayer,
            "<span class='small text-dark'> Titik RT</span>": rtLayer
        };

        L.control.layers(baseMaps, overlayMaps, {
            collapsed: true,
            position: 'topright'
        }).addTo(map);

        window.addEventListener('resize', () => map.invalidateSize());
    </script>
@endsection