@extends('layouts.sidebar-admin')

@section('title', 'Pemetaan')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
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

        #legend-box{
    position:absolute;
    bottom:18px;
    right:18px;
    z-index:999;

    background:#fff;
    padding:14px 16px;
    border-radius:14px;

    box-shadow:0 8px 24px rgba(0,0,0,.12);

    width:220px;
    max-width:calc(100% - 24px);

    font-size:13px;
    line-height:1.5;

    transition:.3s ease;
}

#legend-box h6{
    margin-bottom:10px;
    font-size:14px;
    font-weight:700;
}

#legend-box p{
    margin:6px 0;
}

#legend-box hr{
    margin:8px 0;
}

#legend-box small{
    color:#6c757d;
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
        /* ===============================
   TABLET
==================================*/

@media (max-width:992px){

    #map{
        height:420px;
    }

    #legend-box{
        width:190px;
        right:12px;
        bottom:12px;
        padding:12px;
        font-size:12px;
    }

    .leaflet-control-layers{
        transform:scale(.95);
        transform-origin:top right;
    }

}


/* ===============================
   MOBILE
==================================*/

@media (max-width:768px){

    #map{
        height:420px;
    }

    #legend-box{

        width:160px;

        right:10px;

        bottom:10px;

        padding:10px;

        font-size:11px;

        line-height:1.35;

        border-radius:10px;
    }

    #legend-box h6{

        font-size:12px;

        margin-bottom:6px;

    }

    .kotak{

        width:12px;
        height:12px;

        margin-right:5px;

    }

    .besar{

        width:10px;
        height:10px;

    }

    .leaflet-control-zoom{

        transform:scale(.9);

        transform-origin:top left;

    }

    .leaflet-control-layers{

        transform:scale(.9);

        transform-origin:top right;

    }

}


/* ===============================
   ANDROID KECIL / iPhone SE
==================================*/

@media (max-width:480px){

    #map{

        height:380px;

    }

    #legend-box{

        width:140px;

        padding:8px;

        right:8px;

        bottom:8px;

        font-size:10px;

    }

    #legend-box h6{

        font-size:11px;

    }

    #legend-box p{

        margin:4px 0;

    }

    #legend-box hr{

        margin:5px 0;

    }

}
    </style>

    <div class="card card-map border-0 shadow-sm">
        <div class="card-body">
            <h4 class="mb-1">Pemetaan Desa Karangmulya</h4>
            <p class="text-muted mb-3">Visualisasi persebaran kategori keterampilan warga berdasarkan wilayah administrasi
                desa</p>
            <div class="row g-3 align-items-center">

                <div class="col-lg-3 col-md-6">

                    <div class="filter-group">

                        <i class="fa-solid fa-map-location-dot filter-icon"></i>

                        <select id="filterDusun" class="form-select filter-select"></select>

                    </div>

                </div>
                <div class="col-lg-3 col-md-6">
    <div class="filter-group">
        <i class="fa-solid fa-location-dot filter-icon"></i>

        <select id="filterRt" class="form-select filter-select">
            <option value="">Semua RT/RW</option>
        </select>
    </div>
</div>
                <div class="col-lg-3 col-md-6">

                    <div class="filter-group">

                        <i class="fa-solid fa-layer-group filter-icon"></i>

                        <select id="filterKategori" class="form-select filter-select">

                            <option value="">
                                Semua Kategori
                            </option>

                        </select>

                    </div>

                </div>

                <div class="col-lg-3 col-md-6">

                    <button id="resetFilter" class="btn btn-reset w-100">

                        <i class="fa-solid fa-rotate-left me-2"></i>

                        Reset Filter

                    </button>

                </div>

            </div>

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

                <p><span class="bulat besar"></span> Keterampilan Warga</p>

                <small>Warna: Kategori | Ukuran: Jumlah Warga</small>


            </div>
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
            layers: [streetLayer]
        });

        // pane khusus
        map.createPane('dusunPane');
        map.createPane('rwPane');
        map.createPane('rtPane');

        map.getPane('dusunPane').style.zIndex = 450;
        map.getPane('rwPane').style.zIndex = 650;
        map.getPane('rtPane').style.zIndex = 700;

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

            if (!kategori ||
                kategori === 'Tidak Ada Dominan') {
                return '#6c757d';
            }

            let hash = 0;

            for (let i = 0; i < kategori.length; i++) {

                hash = kategori.charCodeAt(i) +
                    ((hash << 5) - hash);

            }

            const warna =
                (hash & 0x00FFFFFF)
                .toString(16)
                .toUpperCase();

            return "#" +
                "000000".substring(0, 6 - warna.length) +
                warna;
        }

        function warnaPopup(kategori) {
            return warnaKategori(kategori);
        }

        function isiFilter(data) {

            const dusunSelect =
                document.getElementById('filterDusun');

            dusunSelect.innerHTML =
                '<option value="">Semua Dusun</option>';

            let dusunSet = new Set();

            data.dusun.forEach(d => {
                dusunSet.add(d.nama_dusun);
            });

            dusunSet.forEach(item => {

                dusunSelect.innerHTML += `
            <option value="${item}">
                ${item}
            </option>
        `;

            });

            dusunSelect.value = filterDusun;

           // =====================
// FILTER RT
// =====================

const rtSelect = document.getElementById('filterRt');

rtSelect.innerHTML =
'<option value="">Semua RT/RW</option>';

let rtSet = new Set();

// jika memilih dusun
let dataRt = filterDusun
    ? data.rt.filter(rt => rt.nama_dusun === filterDusun)
    : data.rt;

dataRt.forEach(item => {

   const value =
    item.nama_rt + "|" + item.nama_rw;

if (!rtSet.has(value)) {

    rtSet.add(value);

    rtSelect.innerHTML += `
        <option value="${value}">
            RT ${item.nama_rt} / RW ${item.nama_rw}
        </option>
    `;

}

});

rtSelect.value = filterRt;

            // =====================
            // FILTER KATEGORI
            // =====================

            const kategoriSelect =
                document.getElementById(
                    'filterKategori'
                );

            kategoriSelect.innerHTML =
                '<option value="">Semua Kategori</option>';

            let kategoriSet = new Set();

            data.kategori.forEach(item => {

                kategoriSet.add(item.kategori);

            });

            kategoriSet.forEach(item => {

                kategoriSelect.innerHTML += `
            <option value="${item}">
                ${item}
            </option>
        `;

            });

            kategoriSelect.value =
                filterKategori;
        }



        let semuaData = null;
        let filterDusun = '';
        let filterRt = '';
        let filterKategori = '';
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
                                interactive: true,

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



<a href="/admin/detail/dusun/${dusunData.id}"
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


                            @foreach ($dusuns as $dusun)

                                @if ($dusun->geojson)

                                    fetch("{{ asset('storage/' . $dusun->geojson) }}")
                                        .then(response => response.json())
                                        .then(geojsonData => {

                                            L.geoJSON(geojsonData, {

                                                interactive: false,

                                                style: {
                                                    color: '#198754',
                                                    weight: 2,
                                                    fillColor: '#198754',
                                                    fillOpacity: 0.35
                                                }

                                            }).addTo(dusunLayer);

                                        });
                                @endif
                            @endforeach

                        })

                        .catch(error => {

                            console.log('GeoJSON Error:', error);

                        });


                    // =====================
                    // MARKER RT
                    // =====================
                    if (apiData.kategori) {

                        apiData.kategori.forEach(item => {

                            if (
                                filterDusun &&
                                item.dusun !== filterDusun
                            ) {
                                return;
                            }
if (filterRt) {

   const value =
    item.rt + "|" + item.rw;

    if (value !== filterRt) {

        return;

    }

}
                            if (
                                filterKategori &&
                                item.kategori !== filterKategori
                            ) {
                                return;
                            }

                            if (!item.latitude || !item.longitude) {
                                return;
                            }

                            const maxJumlah =
                                apiData.max_jumlah || 1;

                            let radius = Math.max(
                                6,
                                (
                                    item.jumlah_warga /
                                    maxJumlah
                                ) * 20
                            );
                            // ======================
// POSISI MARKER AGAR TIDAK BERTUMPUK
// ======================

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

// posisi menyebar
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
                            L.circleMarker(
                                    [lat, lng], {
                                        pane: 'rtPane',
                                        radius: radius,
                                        color: warnaKategori(item.kategori),
                                        fillColor: warnaKategori(item.kategori),
                                        fillOpacity: 0.8,
                                        weight: 2
                                    }
                                )
                                .bindPopup(`

<div class="popup-modern">

<div class="popup-header"
style="
background:${warnaKategori(item.kategori)};
">

<div class="popup-title">
${item.kategori}
</div>

<div class="popup-subtitle">
Kategori Keterampilan
</div>

</div>

<div class="popup-body">

<div class="popup-row">
<span class="popup-label">
Jumlah Warga
</span>

<span class="popup-value">
${item.jumlah_warga} Orang
</span>
</div>

<div class="popup-row">
<span class="popup-label">
RT
</span>

<span class="popup-value">
${item.rt}
</span>
</div>

<div class="popup-row">
<span class="popup-label">
RW
</span>

<span class="popup-value">
${item.rw}
</span>
</div>

<div class="popup-row">
<span class="popup-label">
Dusun
</span>

<span class="popup-value">
${item.dusun}
</span>

</div>

<a href="/admin/detail/kategori/${item.id}?rt=${item.rt_id}"
class="btn-popup"
style="
background:${warnaKategori(item.kategori)};
">

<i class="fa-solid fa-eye me-1"></i>

Lihat Detail Kategori

</a>
</div>

</div>

`)
                                .addTo(rtLayer);

                        });

                    }

                }); // tutup .then(apiData => {})

        } // 
        // Jalankan load data
        loadData();
        // setInterval(loadData, 10000); // Sinkronisasi data tiap 10 detik

       document.getElementById('filterDusun')
.addEventListener('change', function () {

    filterDusun = this.value;

    // reset filter RT
    filterRt = '';

    document.getElementById('filterRt').value = '';

    loadData();

});

document.getElementById(
'filterRt'
)
.addEventListener('change',function(){

    filterRt=this.value;

    loadData();

});
        document.getElementById(
            'filterKategori'
        ).addEventListener(
            'change',
            function() {

                filterKategori =
                    this.value;

                loadData();

            }
        );
        document.getElementById(
            'resetFilter'
        ).addEventListener('click', function() {

            filterDusun = '';
            filterRt='';
            filterKategori = '';
            document.getElementById(
                'filterDusun'
            ).value = '';
            document.getElementById(
'filterRt'
).value='';
            document.getElementById(
                'filterKategori'
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
