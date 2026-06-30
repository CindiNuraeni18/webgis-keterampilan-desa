@extends('layouts.sidebar-admin')

@section('title', 'Detail Kategori')

@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
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

       .stat-card{
    border:none;
    border-radius:18px;
    overflow:hidden;
    cursor:pointer;
    height:100%;
    transition:all .35s ease;
}

.stat-card:hover{
    transform:translateY(-6px);
    box-shadow:0 14px 25px rgba(0,0,0,.12);
}

.stat-card .card-body{
    padding:22px 15px;
}

.stat-card i{
    font-size:30px;
    margin-bottom:10px;
    transition:all .35s ease;
}

.stat-card:hover i{
    transform:scale(1.2) rotate(-8deg);
}

.stat-card h2,
.stat-card h5{
    font-weight:700;
    margin-bottom:6px;
    transition:.3s;
}

.stat-card:hover h2,
.stat-card:hover h5{
    transform:translateY(-2px);
}

.stat-card small{
    opacity:.95;
}

        .page-title {

            font-weight: 700;

        }

        .sub-title {

            color: #64748b;

        }

        .card-title {

            font-weight: 700;

        }

        .info-card {

            border-radius: 18px;

        }

        @media(max-width:768px) {

            .page-title {

                font-size: 1.35rem;

            }

            .stat-card .card-body {

                padding: 18px 10px;

            }

            .stat-card h3 {

                font-size: 1.35rem;

            }

        }

        /* ===========================
           CHART
        =========================== */

        .chart-container {

            position: relative;

            width: 100%;

            height: 360px;

        }

        .chart-container canvas {

            width: 100% !important;

            height: 100% !important;

        }

        /* Tablet */

        @media(max-width:992px) {

            .chart-container {

                height: 420px;

            }

        }

        /* Android */

        @media(max-width:768px) {

            .chart-container {

                height: 520px;

            }

        }

        .table-responsive {

            border-radius: 14px;

            overflow-x: auto;

        }

        .table tbody tr {

            transition: .25s;

        }

        .table tbody tr:hover {

            background: #eff6ff;

            transform: translateX(3px);

        }

        .badge {

            font-size: .8rem;

            padding: 7px 12px;

            border-radius: 30px;

            font-weight: 600;

        }

        .card-header {

            font-weight: 600;

        }

        .pagination {

            gap: 6px;

        }

        .page-item .page-link {

            border: none;

            border-radius: 10px;

            min-width: 40px;

            height: 40px;

            display: flex;

            align-items: center;

            justify-content: center;

            font-weight: 600;

            box-shadow: 0 2px 8px rgba(0, 0, 0, .06);

            transition: .25s;

        }

        .page-item.active .page-link {

            background: #2563eb;

            color: white;

        }

        .page-item .page-link:hover {

            background: #dbeafe;

            color: #2563eb;

            transform: translateY(-2px);

        }

        @media(max-width:768px) {

            .table {

                font-size: .82rem;

            }

            .card-header {

                font-size: .9rem;

            }

            .badge {

                font-size: .7rem;

            }

        }
    </style>

    <div class="card shadow-sm border-0 info-card">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

                <div>

                    <h3 class="page-title">

                        Detail Kategori

                        <b class="text-primary">

                            {{ $kategori->nama_kategori }}

                        </b>

                    </h3>

                    <p class="sub-title mb-0">Analisis persebaran kategori keterampilan warga berdasarkan wilayah Desa
                        Karangmulya.</p>
                </div>

                <a href="{{ url()->previous() }}" class="btn btn-back">

                    <i class="fas fa-arrow-left me-2"></i>

                    Kembali

                </a>

            </div>
          
               <div class="row g-3 mb-4">

    <div class="col-lg-6">

        <div class="card stat-card bg-primary text-white">

            <div class="card-body text-center">

                <i class="fas fa-users fa-2x mb-2"></i>

                <h2>{{ $totalWarga }}</h2>

                <small>Warga Memiliki Kategori Ini</small>

            </div>

        </div>

    </div>

    <div class="col-lg-6">

        <div class="card stat-card bg-success text-white">

            <div class="card-body text-center">

                <i class="fas fa-map-marker-alt fa-2x mb-2"></i>

                <h5 class="mb-1">

                    {{ $wilayahDominan }}

                </h5>

                <small>

                    {{ $jumlahWilayahDominan }} Warga

                </small>

            </div>

        </div>

    </div>

</div>

            </div>
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-primary text-white">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                        <div>
                            <i class="fas fa-chart-column me-2"></i>
                            Grafik Persebaran Warga Berdasarkan Wilayah
                        </div>



                    </div>

                </div>

                <div class="card-body">
                    <div class="d-flex justify-content-center align-items-center gap-4 flex-wrap mb-3">

                        <div class="d-flex align-items-center">

                            <span
                                style="
                    width:15px;
                    height:15px;
                    background:#2563eb;
                    border-radius:4px;
                    display:inline-block;
                    margin-right:6px;
                "></span>

                            <small class="text-black">
                                Dusun Kemped
                            </small>

                        </div>

                        <div class="d-flex align-items-center">

                            <span
                                style="
                    width:15px;
                    height:15px;
                    background:#16a34a;
                    border-radius:4px;
                    display:inline-block;
                    margin-right:6px;
                "></span>

                            <small class="text-black">
                                Dusun Sukamelang
                            </small>

                        </div>

                    </div>
                    <div class="chart-container">

                        <canvas id="kategoriChart"></canvas>

                    </div>

                </div>

            </div>

            <div class="card shadow-sm border-0">


                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover align-middle text-nowrap">

                            <thead class="table-primary text-center">

                                <tr>

                                    <th width="60">No</th>

                                    <th>Nama Warga</th>

                                    <th>Kategori</th>

                                    <th>Keterampilan</th>

                                    <th width="70">RT</th>

                                    <th width="70">RW</th>

                                    <th>Dusun</th>
                                    <th>Pengalaman</th>

                                </tr>

                            </thead>

                            <tbody>

                                @php
                                    $no = $skills->firstItem();
                                @endphp

                                @forelse($skills as $skill)
                                    <tr>

                                        <td class="text-center">

                                            {{ $no++ }}

                                        </td>

                                        <td>

                                            {{ $skill->warga->nama }}

                                        </td>

                                        <td>

                                            <span>

                                                {{ $skill->kategori->nama_kategori }}

                                            </span>

                                        </td>

                                        <td>

                                            {{ $skill->nama_keterampilan }}

                                        </td>

                                        <td class="text-center">

                                            {{ optional($skill->warga->rt)->nomor_rt }}

                                        </td>

                                        <td class="text-center">

                                            {{ optional($skill->warga->rt->rw)->nomor_rw }}

                                        </td>

                                        <td>

                                            {{ optional(optional($skill->warga->rt)->rw->dusun)->nama_dusun }}

                                        </td>
                                        <td>

                                            {{ $skill->pengalaman }}

                                        </td>
                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="7" class="text-center py-4">

                                            <i class="fas fa-folder-open fa-2x text-muted mb-2"></i>

                                            <br>

                                            Belum ada data keterampilan.

                                        </td>

                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>
                    <div class="mt-4 d-flex justify-content-end">

                        {{ $skills->links() }}

                    </div>
                </div>

            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const mobile = window.innerWidth <= 768;

                const grafik = @json($grafikWilayah->values());

                const ctx = document.getElementById('kategoriChart');

                new Chart(ctx, {

                    type: 'bar',

                    data: {

                        labels: grafik.map(item => item.label),

                        datasets: [{

                            label: 'Jumlah Warga',

                            data: grafik.map(item => item.jumlah),

                            backgroundColor: grafik.map(item => item.warna),

                            borderRadius: 10,

                            borderWidth: 0,

                            maxBarThickness: mobile ? 22 : 35

                        }]

                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        indexAxis: mobile ? 'y' : 'x',

                        plugins: {

                            legend: {

                                display: false

                            },

                            tooltip: {

                                callbacks: {

                                    label: function(context) {

                                        return context.raw + " Warga";

                                    }

                                }

                            }

                        },

                        scales: {

                            x: {

                                ticks: {

                                    autoSkip: false,

                                    maxRotation: mobile ? 0 : 45,

                                    minRotation: mobile ? 0 : 45,

                                    font: {

                                        size: mobile ? 10 : 12

                                    }

                                },

                                grid: {

                                    display: false

                                }

                            },

                            y: {

                                beginAtZero: true,

                                ticks: {

                                    precision: 0,

                                    stepSize: 1

                                }

                            }

                        }

                    }

                });
            </script>
        @endsection
