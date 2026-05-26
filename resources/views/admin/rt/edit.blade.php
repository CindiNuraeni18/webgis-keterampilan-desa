@extends('layouts.sidebar-admin')

@section('title', 'Edit RT')

@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .btn-update {
            border: none;
            border-radius: 14px;
            padding: 12px 22px;
            font-weight: 600;
            color: white;
            background: linear-gradient(135deg,
                    #f59e0b,
                    #fbbf24);
            transition: all .3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(245, 158, 11, .25);
        }

        .btn-update::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, .2);
            transition: .5s;
        }

        .btn-update:hover::before {
            left: 100%;
        }

        .btn-update i {
            transition: .3s ease;
        }

        .btn-update:hover i {
            transform: rotate(-10deg) scale(1.15);
        }

        .btn-back {
            border-radius: 14px;
            padding: 12px 22px;
            font-weight: 600;
            background: #f3f6fb;
            color: #374151;
            border: 1px solid #e5e7eb;
            transition: all .3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-back:hover {
            background: #e8eefc;
            color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(37, 99, 235, .12);
        }

        .btn-back i {
            transition: .3s ease;
        }

        .btn-back:hover i {
            transform: translateX(-4px);
        }
    </style>



    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            <h4 class="mb-4 fw-bold">
                Edit Data RT
            </h4>

            <form action="{{ route('admin.rt.update', $rt->id) }}" method="POST">

                @csrf
                @method('PUT')

                @include('admin.rt.form')



                <!-- BUTTON -->
                <div class="d-flex gap-2 mt-4">

                    <button type="submit" class="btn btn-update px-4">

                        <i class="fa-solid fa-pen-to-square me-2"></i>

                        <span>
                            Update
                        </span>

                    </button>



                    <a href="{{ route('admin.rt.index') }}" class="btn btn-back px-4">

                        <i class="fa-solid fa-arrow-left me-2"></i>

                        <span>
                            Kembali
                        </span>

                    </a>

                </div>

            </form>

        </div>

    </div>

@endsection



@push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/@mapbox/leaflet-pip@latest/leaflet-pip.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const map = L.map('map').setView(
            [
                {{ $rt->latitude ?? '-6.39963' }},
                {{ $rt->longitude ?? '108.11848' }}
            ],
            14
        );

        // ==========================
        // BASEMAP
        // ==========================

        // PETA BIASA
        const osm = L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            });


        // PETA SATELIT
        const satellite = L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles © Esri'
            });


        // DEFAULT MAP SATELIT
        satellite.addTo(map);


        // ==========================
        // CONTROL LAYER
        // ==========================

        const baseMaps = {

            "Peta Biasa": osm,

            "Satelit": satellite

        };


        L.control.layers(baseMaps).addTo(map);

        let marker;

        let dusunLayer;


        // ==========================
        // LOAD GEOJSON GABUNGAN
        // ==========================

        fetch("{{ asset('geojson/dusunreal.geojson') }}")

            .then(response => response.json())

            .then(data => {

                dusunLayer = L.geoJSON(data, {

                    style: function(feature) {

                        let namaDusun =
                            feature.properties.dusunbaru?.toLowerCase();

                        // WARNA KEMPED
                        if (namaDusun == 'kemped') {

                            return {
                                color: '#198754',
                                weight: 2,
                                fillColor: '#198754',
                                fillOpacity: 0.3
                            };

                        }

                        // WARNA SUKAMELANG
                        if (namaDusun == 'sukamelang') {

                            return {
                                color: '#6f42c1',
                                weight: 2,
                                fillColor: '#6f42c1',
                                fillOpacity: 0.3
                            };

                        }

                        // DEFAULT
                        return {
                            color: '#2563eb',
                            weight: 2,
                            fillColor: '#60a5fa',
                            fillOpacity: 0.3
                        };

                    }

                }).addTo(map);



                // ==========================
                // TAMPILKAN MARKER LAMA
                // ==========================

                @if ($rt->latitude && $rt->longitude)

                    marker = L.marker([
                        {{ $rt->latitude }},
                        {{ $rt->longitude }}
                    ]).addTo(map);
                @endif

            });




        // ==========================
        // KLIK PETA
        // ==========================

        map.on('click', function(e) {

            let lat = e.latlng.lat;
            let lng = e.latlng.lng;


            // ==========================
            // VALIDASI INPUT DULU
            // ==========================

            let rwValue =
                document.querySelector(
                    'select[name="rw_id"]'
                ).value;

            let rtValue =
                document.querySelector(
                    'input[name="nomor_rt"]'
                ).value;


            // JIKA RW / RT KOSONG
            if (!rwValue || !rtValue) {

                Swal.fire({

                    icon: 'warning',

                    title: 'Data Belum Lengkap',

                    text: 'Silahkan isi RW/Dusun dan Nomor RT terlebih dahulu.',

                    showConfirmButton: false,

                    timer: 2200,

                    background: '#ffffff',

                    backdrop: `
                rgba(0,0,0,0.45)
            `

                });

                return;

            }


            // ==========================
            // AMBIL RW YANG DIPILIH
            // ==========================

            let rwSelect =
                document.querySelector(
                    'select[name="rw_id"] option:checked'
                ).text.toLowerCase();


            let result = leafletPip.pointInLayer(
                [lng, lat],
                dusunLayer
            );


            // ==========================
            // LUAR KARANGMULYA
            // ==========================

            if (result.length == 0) {

                Swal.fire({

                    icon: 'warning',

                    title: 'Lokasi Tidak Valid',

                    text: 'Titik berada di luar wilayah Desa Karangmulya.',

                    showConfirmButton: false,

                    timer: 2200,

                    background: '#ffffff',

                    backdrop: `
                rgba(0,0,0,0.45)
            `

                });

                return;

            }


            // ==========================
            // CEK DUSUN
            // ==========================

            let namaDusunPolygon =
                result[0].feature.properties.dusunbaru
                ?.toLowerCase();


            if (
                !rwSelect.includes(namaDusunPolygon)
            ) {

                Swal.fire({

                    icon: 'error',

                    title: 'Dusun Tidak Sesuai',

                    text: 'Titik berada di Dusun ' +
                        namaDusunPolygon +
                        ', bukan dusun pada RW yang dipilih.',

                    showConfirmButton: false,

                    timer: 2500,

                    background: '#ffffff',

                    backdrop: `
                rgba(0,0,0,0.45)
            `

                });

                return;

            }


            // ==========================
            // SIMPAN KOORDINAT
            // ==========================

            document.getElementById('latitude').value = lat;

            document.getElementById('longitude').value = lng;


            // ==========================
            // HAPUS MARKER LAMA
            // ==========================

            if (marker) {

                map.removeLayer(marker);

            }


            // ==========================
            // TAMBAH MARKER BARU
            // ==========================

            marker = L.marker([lat, lng]).addTo(map);

        });
    </script>
@endpush
