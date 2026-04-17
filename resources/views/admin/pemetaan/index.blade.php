@extends('layouts.sidebar-admin')

@section('title', 'Pemetaan')

@section('content')
    <style>
        /* Kontainer Peta */
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
    </style>

    <div class="card card-map border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h4 class="mb-1">Peta Desa Karangmulya</h4>
                    <p class="text-muted mb-0">Visualisasi data wilayah berdasarkan Dusun, RW, dan RT</p>
                </div>
            </div>

            <div id="map"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        // 1. DEFINISI TAMPILAN PETA (Base Layers)
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
            layers: [streetLayer] // Default awal: Peta Jalan
        });

        // Layer Groups
        const polygonLayer = L.layerGroup().addTo(map);
        const dusunLayer = L.layerGroup().addTo(map);
        const rwLayer = L.layerGroup().addTo(map);
        const rtLayer = L.layerGroup().addTo(map);

        // 2. LOAD GEOJSON (Outline Saja - Tanpa Warna Tengah)
        fetch("{{ asset('geojson/karangmulya.geojson') }}")
            .then(res => res.json())
            .then(data => {
                const geojson = L.geoJSON(data, {
                    style: {
                        color: '#0d6efd',
                        weight: 3,
                        fillOpacity: 0 // Membuat tengah transparan
                    }
                }).addTo(polygonLayer);

                polygonLayer.bringToBack();
                try {
                    map.fitBounds(geojson.getBounds());
                } catch (e) {}
            });


        // fungsi warna kategori
        function warnaKategori(kategori) {

            if (!kategori) return '#6c757d';

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

        // 3. LOAD DATA API (Dusun, RW, RT)
        function loadData() {

            dusunLayer.clearLayers();
            rwLayer.clearLayers();
            rtLayer.clearLayers();

            fetch("{{ url('/admin/api/pemetaan') }}")
                .then(res => res.json())
                .then(data => {

                    // =====================
                    // MARKER DUSUN
                    // =====================
                    data.dusun.forEach(dusun => {

                        if (dusun.latitude && dusun.longitude) {

                            L.marker([
                                    dusun.latitude,
                                    dusun.longitude
                                ])
                                .bindPopup(`
                        <div style="min-width:220px">

                            <h6 style="margin-bottom:8px;">
                                Dusun ${dusun.nama_dusun}
                            </h6>

                            <hr style="margin:6px 0;">

                            <p>
                                <b>Jumlah Warga:</b> 
                                ${dusun.jumlah_warga || 0}
                            </p>

                            <p>
                                <b>Warga Berketerampilan:</b> 
                                ${dusun.jumlah_keterampilan || 0}
                            </p>

                            <p>
                                <b>Potensi Utama:</b> 
                                ${dusun.keterampilan_dominan || 'Belum tersedia'}
                            </p>

                            <a href="/admin/dusun/${dusun.id}"
                               class="btn btn-sm btn-primary mt-2 w-100">

                               Lihat Detail

                            </a>

                        </div>
                    `)
                                .addTo(dusunLayer);

                        }

                    });


                    // =====================
                    // MARKER RW
                    // =====================
                    data.rw.forEach(rw => {

                        if (rw.latitude && rw.longitude) {

                            L.circleMarker(
                                    [rw.latitude, rw.longitude], {
                                        radius: 12,

                                        color: warnaKategori(rw.keterampilan_dominan),

                                        fillColor: warnaKategori(rw.keterampilan_dominan),

                                        fillOpacity: 0.8
                                    })

                                .bindPopup(`

                        <div style="min-width:220px">

                        <h6>
                        RW ${rw.nama_rw}
                        </h6>

                        <hr>

                        <p>
                        <b>Dusun :</b>
                        ${rw.nama_dusun || '-'}
                        </p>

                        <p>
                        <b>Jumlah Warga :</b>
                        ${rw.jumlah_warga || 0}
                        </p>

                        <p>
                        <b>Warga Berketerampilan :</b>
                        ${rw.jumlah_keterampilan || 0}
                        </p>

                        <p>
                        <b>Kategori Dominan :</b>
                        ${rw.keterampilan_dominan || '-'}
                        </p>

                        <p>
                        <b>Keterampilan Dominan :</b>
                        ${rw.nama_keterampilan_dominan || '-'}
                        </p>

                        <a href="/admin/rw/${rw.id}"
                        class="btn btn-sm btn-success mt-2 w-100">

                        Lihat Detail

                        </a>

                        </div>

                        `)

                                .addTo(rwLayer);

                        }

                    });


                    // =====================
                    // MARKER RT
                    // =====================
                    data.rt.forEach(rt => {

                        if (rt.latitude && rt.longitude) {

                            L.circleMarker(
                                    [rt.latitude, rt.longitude], {
                                        radius: 4,

                                        color: warnaKategori(rt.keterampilan_dominan),

                                        fillColor: warnaKategori(rt.keterampilan_dominan),

                                        fillOpacity: 0.8
                                    })

                                .bindPopup(`

                        <div style="min-width:220px">

                        <h6>
                        RT ${rt.nama_rt}
                        </h6>

                        <hr>

                        <p>
                        <b>RW :</b>
                        ${rt.nama_rw || '-'}
                        </p>

                        <p>
                        <b>Dusun :</b>
                        ${rt.nama_dusun || '-'}
                        </p>

                        <p>
                        <b>Jumlah Warga :</b>
                        ${rt.jumlah_warga || 0}
                        </p>

                        <p>
                        <b>Warga Berketerampilan :</b>
                        ${rt.jumlah_keterampilan || 0}
                        </p>

                        <p>
                        <b>Kategori Dominan :</b>
                        ${rt.keterampilan_dominan || '-'}
                        </p>

                        <p>
                        <b>Keterampilan Dominan :</b>
                        ${rt.nama_keterampilan_dominan || '-'}
                        </p>

                        <a href="/admin/rt/${rt.id}"
                        class="btn btn-sm btn-danger mt-2 w-100">

                        Lihat Detail

                        </a>

                        </div>

                        `)

                                .addTo(rtLayer);

                        }

                    });

                });
        }

        // Jalankan load data
        loadData();
        setInterval(loadData, 10000); // Sinkronisasi data tiap 10 detik

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
@endpush
