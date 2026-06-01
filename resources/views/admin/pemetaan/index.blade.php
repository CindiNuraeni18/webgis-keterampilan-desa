@extends('layouts.sidebar-admin')

@section('title', 'Pemetaan')

@section('content')
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
       #map {
        height: 400px; /* Diubah dari 600px ke 400px agar lebih compact */
        width: 100%;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        z-index: 1;
        margin-top: 10px; /* Memberi jarak sedikit dari filter */
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

        #legend-box {
            position: absolute;
            bottom: 20px;
            right: 20px;

            z-index: 999;

            background: #ffffff;
            padding: 14px 18px;

            border-radius: 12px;

            box-shadow: 0 4px 12px rgba(0, 0, 0, .15);

            min-width: 180px;

            font-size: 14px;
            line-height: 1.6;
        }

        #legend-box h6 {
            margin-bottom: 10px;
        }

        #legend-box p {
            margin-bottom: 8px;
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

.leaflet-popup-content-wrapper{
    border-radius:18px !important;
    padding:0 !important;
    overflow:hidden;
    box-shadow:
        0 12px 30px rgba(0,0,0,.15);
}

.leaflet-popup-content{
    margin:0 !important;
    min-width:280px;
}

.popup-modern{
    animation:popupFade .35s ease;
}

@keyframes popupFade{
    from{
        opacity:0;
        transform:translateY(10px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

.popup-header{
    padding:16px;
    color:white;
}

.popup-header-rw{
    background:linear-gradient(
        135deg,
        #2563eb,
        #3b82f6
    );
}

.popup-header-rt{
    background:linear-gradient(
        135deg,
        #dc2626,
        #ef4444
    );
}

.popup-header-dusun{
    background:linear-gradient(
        135deg,
        #198754,
        #20c997
    );
}

.popup-title{
    font-size:16px;
    font-weight:700;
    margin-bottom:3px;
}

.popup-subtitle{
    font-size:12px;
    opacity:.9;
}

.popup-body{
    padding:14px 16px;
}

.popup-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:9px 0;
    border-bottom:1px solid #eef2f7;
}

.popup-row:last-child{
    border-bottom:none;
}

.popup-label{
    color:#6b7280;
    font-size:13px;
}

.popup-value{
    font-weight:700;
    color:#111827;
}

.popup-badge{

    color:white;

    padding:5px 10px;

    border-radius:999px;

    font-size:12px;

    font-weight:600;

}

.btn-popup{
    display:block;
    width:100%;
    margin-top:12px;
    text-align:center;
    text-decoration:none;
    border:none;
    border-radius:12px;
    padding:10px;
    background:linear-gradient(
        135deg,
        #2563eb,
        #3b82f6
    );
    color:white !important;
    font-weight:600;
    transition:.3s ease;
}

.btn-popup:hover{
    transform:translateY(-2px);
    color:white !important;
    box-shadow:
        0 8px 18px rgba(37,99,235,.25);
}

@media(max-width:576px){

    .leaflet-popup-content{
        min-width:240px;
    }

}
/* ==========================
   FILTER MODERN
========================== */

.filter-wrapper{

    background:#fff;

    padding:18px;

    border-radius:18px;

    box-shadow:
        0 6px 18px rgba(15,23,42,.06);

    margin-bottom:20px;

}

.filter-group{

    position:relative;

    transition:.3s ease;

}

.filter-group:hover{

    transform:translateY(-2px);

}

.filter-icon{

    position:absolute;

    left:15px;

    top:50%;

    transform:translateY(-50%);

    color:#2563eb;

    z-index:10;

    font-size:14px;

}

.filter-select{

    height:52px;

    border-radius:14px;

    border:1px solid #dbe3f0;

    padding-left:42px;

    font-weight:500;

    transition:.3s ease;

    box-shadow:none !important;

}

.filter-select:hover{

    border-color:#60a5fa;

}

.filter-select:focus{

    border-color:#2563eb;

    box-shadow:
        0 0 0 4px rgba(37,99,235,.12) !important;

    transform:translateY(-1px);

}

.btn-reset{

    height:52px;

    border:none;

    border-radius:14px;

    font-weight:600;

    color:#fff;

    background:linear-gradient(
        135deg,
        #2563eb,
        #3b82f6
    );

    transition:.35s ease;

    overflow:hidden;

    position:relative;

}

.btn-reset:hover{

    transform:translateY(-3px);

    box-shadow:
        0 10px 24px rgba(37,99,235,.25);

}

.btn-reset::before{

    content:'';

    position:absolute;

    top:0;

    left:-100%;

    width:100%;

    height:100%;

    background:
        rgba(255,255,255,.2);

    transition:.5s;

}

.btn-reset:hover::before{

    left:100%;

}

.btn-reset i{

    transition:.4s ease;

}

.btn-reset:hover i{

    transform:rotate(-180deg);

}
    </style>

    <div class="card card-map border-0 shadow-sm">
    <div class="card-body">
    <h4 class="mb-1">Peta Desa Karangmulya</h4>
    <p class="text-muted mb-3">Visualisasi data wilayah berdasarkan Dusun, RW, dan RT</p>
    <div class="row g-3 align-items-center">

        <div class="col-lg-3 col-md-6">

            <div class="filter-group">

                <i class="fa-solid fa-map-location-dot filter-icon"></i>

                <select id="filterDusun" class="form-select filter-select"></select>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="filter-group">

                <i class="fa-solid fa-building filter-icon"></i>

                <select id="filterRw" class="form-select filter-select"></select>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="filter-group">

                <i class="fa-solid fa-house filter-icon"></i>

                <select id="filterRt" class="form-select filter-select"></select>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <button id="resetFilter"
                class="btn btn-reset w-100">

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

                <p>
                    <span class="bulat besar"></span>
                    Marker RW
                </p>

                <p>
                    <span class="bulat kecil"></span>
                    Marker RT
                </p>

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

    if(
        !kategori ||
        kategori === 'Tidak Ada Dominan'
    ){
        return '#6c757d';
    }

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

function warnaPopup(kategori){
    return warnaKategori(kategori);
}

function isiFilter(data){

    const dusunSelect =
    document.getElementById('filterDusun');

    const rwSelect =
    document.getElementById('filterRw');

    const rtSelect =
    document.getElementById('filterRt');

    dusunSelect.innerHTML =
    '<option value="">Semua Dusun</option>';

    rwSelect.innerHTML =
    '<option value="">Semua RW</option>';

    rtSelect.innerHTML =
    '<option value="">Semua RT</option>';

    let dusunSet = new Set();

    data.dusun.forEach(d => {

        dusunSet.add(
            d.nama_dusun
        );

    });

    dusunSet.forEach(item => {

        dusunSelect.innerHTML +=
        `<option value="${item}">
            ${item}
        </option>`;

    });

    data.rw.forEach(rw => {

        if(
            filterDusun &&
            rw.nama_dusun != filterDusun
        ){
            return;
        }

        rwSelect.innerHTML +=
`<option value="${rw.id}">
    RW ${rw.nama_rw}
</option>`;

    });

    let rtSet = new Set();

data.rt.forEach(rt => {

    if (
        filterDusun &&
        rt.nama_dusun != filterDusun
    ){
        return;
    }

    rtSet.add(rt.nama_rt);

});

[...rtSet]
.sort()
.forEach(rtNomor => {

    rtSelect.innerHTML += `
        <option value="${rtNomor}">
            RT ${rtNomor}
        </option>
    `;

});

    dusunSelect.value = filterDusun;
    rwSelect.value = filterRw;
    rtSelect.value = filterRt;
}

let semuaData = null;

let filterDusun = '';
let filterRw = '';
let filterRt = '';

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

    if(filterDusun){

        if(
            !namaDusun.includes(
                filterDusun.toLowerCase()
            )
        ){
            opacity = 0.01;
            weight = 1;
        }else{
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
Total Keterampilan
</span>
<span class="popup-value">
${dusunData.jumlah_keterampilan || 0}
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

<div class="popup-row">
<span class="popup-label">
Keterampilan Dominan
</span>

<span class="popup-value">
${dusunData.nama_keterampilan_dominan || '-'}
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
            weight:5,
            fillOpacity:0.7
        });
    },

    mouseout: function(e) {
        e.target.setStyle({
            weight:2,
            fillOpacity:0.35
        });
    },

    click: function(e) {

    layer.bindPopup(layer.getPopup().getContent())
         .openPopup(e.latlng);

}

});

    }

}).addTo(dusunLayer);

        
@foreach($dusuns as $dusun)

@if($dusun->geojson)

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
// MARKER RW
// =====================

apiData.rw.forEach(rw => {

    if (
        filterDusun &&
        rw.nama_dusun != filterDusun
    ){
        return;
    }

    if (
        filterRw &&
        rw.id != filterRw
    ){
        return;
    }

    // jika sedang filter RT saja
    if (
        filterRt &&
        !filterRw
    ){
        return;
    }
                        if (rw.latitude && rw.longitude) {

                            L.circleMarker(
                                    [rw.latitude, rw.longitude], {
                                      pane:'rwPane',
                                        radius: 14,

                                        color: warnaKategori(rw.keterampilan_dominan),

                                        fillColor: warnaKategori(rw.keterampilan_dominan),

                                        fillOpacity: 0.8
                                    })

                              .bindPopup(`

<div class="popup-modern">

<div class="popup-header"
style="
background:${warnaPopup(rw.keterampilan_dominan)};
color:white;
">

<div class="popup-title">
RW ${rw.nama_rw}
</div>

<div class="popup-subtitle">
${rw.nama_dusun || '-'}
</div>

</div>

<div class="popup-body">

<div class="popup-row">
<span class="popup-label">Total Warga</span>
<span class="popup-value">
${rw.jumlah_warga || 0}
</span>
</div>

<div class="popup-row">
<span class="popup-label">Total Keterampilan</span>
<span class="popup-value">
${rw.jumlah_keterampilan || 0}
</span>
</div>

<div class="popup-row">
<span class="popup-label">
Kategori Dominan
</span>

<span class="popup-badge"
style="
background:${warnaPopup(rw.keterampilan_dominan)};
">
${rw.keterampilan_dominan || '-'}
</span>

</div>

<div class="popup-row">
<span class="popup-label">
Keterampilan Dominan
</span>

<span class="popup-value">
${rw.nama_keterampilan_dominan || '-'}
</span>
</div>

<a href="/admin/detail/rw/${rw.id}"
class="btn-popup"
style="
background:${warnaPopup(rw.keterampilan_dominan)};
">

<i class="fa-solid fa-eye me-1"></i>
Lihat Detail RW

</a>

</div>

</div>

`)
                                .addTo(rwLayer);

                        }

                    });


                    // =====================
                    // MARKER RT
                    // =====================
            apiData.rt.forEach(rt => {

    // filter dusun
    if (
        filterDusun &&
        rt.nama_dusun != filterDusun
    ){
        return;
    }

    // filter RT berdasarkan nomor RT
    if (
        filterRt &&
        rt.nama_rt != filterRt
    ){
        return;
    }
  // jika pilih RW saja
    if (
        filterRw &&
        filterRt === ''
    ){
        return;
    }

    console.log(rt);
    if (rt.latitude && rt.longitude) {

                            L.circleMarker(
                                    [rt.latitude, rt.longitude], {
                                      pane:'rtPane',
                                        radius: 4,

                                        color: warnaKategori(rt.keterampilan_dominan),

                                        fillColor: warnaKategori(rt.keterampilan_dominan),

                                        fillOpacity: 0.8
                                    })

                               .bindPopup(`

<div class="popup-modern">

<div class="popup-header"
style="
background:${warnaPopup(rt.keterampilan_dominan)};
color:white;
">

<div class="popup-title">
RT ${rt.nama_rt || '-'}
</div>

<div class="popup-subtitle">
${rt.nama_dusun || '-'}
</div>

</div>

<div class="popup-body">

<div class="popup-row">
<span class="popup-label">Total Warga</span>
<span class="popup-value">
${rt.jumlah_warga || 0}
</span>
</div>

<div class="popup-row">
<span class="popup-label">Total Keterampilan</span>
<span class="popup-value">
${rt.jumlah_keterampilan || 0}
</span>
</div>

<div class="popup-row">
<span class="popup-label">Kategori Dominan</span>

<span class="popup-badge"
style="
background:${warnaPopup(rt.keterampilan_dominan)};
">
${rt.keterampilan_dominan || '-'}
</span>

</div>

<div class="popup-row">
<span class="popup-label">
Keterampilan Dominan
</span>

<span class="popup-value">
${rt.nama_keterampilan_dominan || '-'}
</span>
</div>

<a href="/admin/detail/rt/${rt.id}"
class="btn-popup"
style="
background:${warnaPopup(rt.keterampilan_dominan)};
">

<i class="fa-solid fa-eye me-1"></i>
Lihat Detail RT

</a>

</div>

</div>

`)
                                .addTo(rtLayer);

                        }

                    });

                });
        }

        // Jalankan load data
        loadData();
        // setInterval(loadData, 10000); // Sinkronisasi data tiap 10 detik

document.getElementById(
'filterDusun'
).addEventListener('change', function(){

    filterDusun = this.value;

    filterRw = '';
    filterRt = '';

    isiFilter(semuaData);

    loadData();

});

document.getElementById(
'filterRw'
).addEventListener('change', function(){

    filterRw = this.value;

    filterRt = '';

    isiFilter(semuaData);

    loadData();

});

document.getElementById(
'filterRt'
).addEventListener('change', function(){

    filterRt = this.value;

    loadData();

});

document
.getElementById('resetFilter')
.addEventListener('click', function(){

    filterDusun = '';
    filterRw = '';
    filterRt = '';

    document.getElementById(
        'filterDusun'
    ).value = '';

    document.getElementById(
        'filterRw'
    ).value = '';

    document.getElementById(
        'filterRt'
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
