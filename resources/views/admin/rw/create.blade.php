@extends('layouts.sidebar-admin')

@section('title', 'Tambah RW')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .btn-save {
            border: none;
            border-radius: 14px;
            padding: 13px;
            font-weight: 600;
            color: white;
            background: linear-gradient(135deg,
                    #2563eb,
                    #4f8cff);
            transition: all .3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, .25);
        }

        .btn-save::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, .2);
            transition: .5s;
        }

        .btn-save:hover::before {
            left: 100%;
        }

        .btn-save i {
            transition: .3s ease;
        }

        .btn-save:hover i {
            transform: rotate(-10deg) scale(1.15);
        }

        .btn-back {
            border-radius: 14px;
            padding: 13px;
            font-weight: 600;
            background: #f3f6fb;
            color: #374151;
            border: 1px solid #e5e7eb;
            transition: all .3s ease;
            display: flex;
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
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <h4 class="mb-4">
                Tambah Data RW
            </h4>

            <form action="{{ route('admin.rw.store') }}" method="POST">

                @csrf

                @include('admin.rw.form')

                <div class="d-flex gap-2 mt-4">

                    <!-- BUTTON SIMPAN -->
                    <button type="submit" class="btn btn-save px-4">

                        <i class="fa-solid fa-floppy-disk me-2"></i>

                        <span>
                            Simpan
                        </span>

                    </button>



                    <!-- BUTTON KEMBALI -->
                    <a href="{{ route('admin.rw.index') }}" class="btn btn-back px-4">

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/@mapbox/leaflet-pip@latest/leaflet-pip.js"></script>

    <script>
        const map = L.map('map').setView(
            [-6.39963, 108.11848],
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

            let dusunValue =
                document.querySelector(
                    'select[name="dusun_id"]'
                ).value;

            let rwValue =
                document.querySelector(
                    'input[name="nomor_rw"]'
                ).value;


            // JIKA DUSUN / RW KOSONG
            if (!dusunValue || !rwValue) {

                Swal.fire({

                    icon: 'warning',

                    title: 'Data Belum Lengkap',

                    text: 'Silahkan isi Dusun dan Nomor RW terlebih dahulu.',

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
            // AMBIL DUSUN YANG DIPILIH
            // ==========================

            let dusunDipilih =
                document.querySelector(
                    'select[name="dusun_id"] option:checked'
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
                !dusunDipilih.includes(namaDusunPolygon)
            ) {

                Swal.fire({

                    icon: 'error',

                    title: 'Dusun Tidak Sesuai',

                    text: 'Titik berada di Dusun ' +
                        namaDusunPolygon +
                        ', bukan dusun yang dipilih.',

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
