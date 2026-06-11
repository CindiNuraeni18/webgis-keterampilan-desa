@extends('layouts.sidebar-admin')

@section('title', 'Statistik Keterampilan')

@section('content')
    <style>
        @media (max-width:768px) {

            #kategoriPersen {
                font-size: 1.4rem !important;
            }

            #kategoriNama {
                font-size: .8rem !important;
            }

            .table {
                font-size: .85rem;
            }

        }

        /* ANIMASI CARD */

        .card {
            transition: all .35s ease;
        }

        @media (min-width:769px) {

            .card:hover {
                transform: translateY(-4px);
                box-shadow: 0 15px 35px rgba(0, 0, 0, .08) !important;
            }

        }

        /* ANIMASI TABEL */

        .table tbody tr {
            transition: all .25s ease;
        }

        .table tbody tr:hover {
            background: #f8fbff;
        }

        .table tbody tr:hover td {

            color: #0f172a;

        }

        /* ANIMASI SKILL */

        .skill-link {
            transition: all .25s ease;
            cursor: pointer;
        }

        .skill-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 202, 240, .35);
        }

        /* ANIMASI PROGRESS */

        .progress-bar {
            animation: growBar 1.8s ease;
        }

        @keyframes growBar {
            from {
                width: 0;
            }
        }

        /* SCROLL ANIMATION */

        .fade-up {
            opacity: 0;
            transform: translateY(25px);
            transition:
                opacity .8s ease,
                transform .8s ease;
        }

        .fade-up.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* HERO CARD */

        .hero-box {
            transition: all .3s ease;
        }

        .hero-box:hover {
            background: rgba(255, 255, 255, .10) !important;
            transform: translateY(-3px);
        }
    </style>
   

    <div class="container-fluid py-4" style="background-color: #f8f9fa; min-height: 100vh;">

        @php

            $totalWarga = $statistikRt->sum(fn($rt) => $rt->wargas->count());

            $totalKeterampilan = $statistikRt->sum(fn($rt) => $rt->wargas->sum(fn($w) => $w->keterampilans->count()));

        @endphp

        {{-- GRAFIK KESELURUHAN (HERO SECTION) --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm fade-up overflow-hidden"
                    style="border-radius: 20px; background: linear-gradient(135deg, #1e293b 0%, #334155 100%);">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-7 text-white">
                                 <h1 class="fw-bold dashboard-title">Selamat Datang Admin</h1>
                                {{-- <h5 class="fw-bold mb-2 text-info">{{ Auth::user()->name }}</h5> --}}
                                <p class="text-white-50 small mb-4">
                                    Menampilkan ringkasan jumlah warga dan total keterampilan yang terdata dalam sistem.
                                </p>
                                <div class="row g-3">

                                    <div class="col-6">

                                        <div class="p-3 rounded-3 hero-box"
                                            style="background: rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1);">

                                            <h3 class="fw-bold mb-0 text-info">
                                                {{ $totalWarga }}
                                            </h3>

                                            <small class="text-white-50">
                                                Total Warga
                                            </small>

                                        </div>

                                    </div>

                                    <div class="col-6">

                                        <div class="p-3 rounded-3 hero-box"
                                            style="background: rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1);">

                                            <h3 class="fw-bold mb-0 text-success">
                                                {{ $totalKeterampilan }}
                                            </h3>

                                            <small class="text-white-50">
                                                Total Keterampilan
                                            </small>

                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="col-md-5 mt-4 mt-md-0 d-flex justify-content-center">
                                <div style="height: 180px; width: 180px; position: relative;">
                                    <canvas id="overallChart"></canvas>
                                    <div
                                        style="position:absolute; top:38%; left:48%; transform:translate(-50%,-50%); display:flex; flex-direction:column; 
                                        align-items:center; justify-content:center; width:100px; height:100px;">
                                        <h2 class="text-white fw-bold mb-0" style="line-height:1; font-size:2rem;">
                                            {{ $totalKeterampilan }}
                                        </h2>

                                        <span class="text-white-50" style="font-size:.85rem; margin-top:6px;">
                                            Skill
                                        </span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CHART UTAMA --}}
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm fade-up h-100" style="border-radius: 15px;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0 text-dark">Sebaran Keterampilan Warga per Dusun</h5>
                        <small class="text-muted"> Menampilkan jumlah keterampilan yang dimiliki warga pada setiap
                            dusun.</small>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div style="height: 320px;">
                            <canvas id="dusunChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100 fade-up" style="border-radius: 15px;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 text-center">
                        <h5 class="fw-bold mb-0 text-dark">Persentase Kategori Keterampilan</h5>
                    </div>
                    <div class="card-body px-4 pb-4">

                        <div style="
        position:relative;
        height:320px;
        ">

                            <canvas id="kategoriChart"></canvas>

                            <div id="kategoriCenter" style="display:none;">

                                <h3 id="kategoriPersen" class="fw-bold mb-0 text-dark">
                                    0%
                                </h3>

                                <small id="kategoriNama" class="text-muted">
                                    Kategori
                                </small>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- TABLES --}}
        <div class="card border-0 shadow-sm mb-4 fade-up h-100" style="border-radius: 15px; overflow: hidden;">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <i class="fas fa-map-marked-alt me-2 text-primary"></i>
                <h5 class="fw-bold mb-1">
                    Sebaran Warga dan Keterampilan per RT
                </h5>

                <small class="text-muted">
                    Menampilkan jumlah warga dan total keterampilan pada setiap RT.
                </small>
            </div>

            <div class="card-body p-0 mt-2">
                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="sticky-top bg-white">
                            <tr class="text-muted small">

                                <th class="text-center px-4 py-3 border-0">
                                    RT
                                </th>

                                <th class="text-center py-3 border-0">
                                    RW
                                </th>

                                <th class="text-center py-3 border-0">
                                    Dusun
                                </th>

                                <th class="text-center py-3 border-0">
                                    Jumlah Warga
                                </th>

                                <th class="text-center py-3 border-0">
                                    Total Keterampilan
                                </th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($statistikRt as $rt)
                                @php
                                    $jumlahWarga = $rt->wargas->count();

                                    $totalSkill = $rt->wargas->sum(fn($w) => $w->keterampilans->count());
                                @endphp

                                <tr>
                                    <td class="text-center">

                                        <span class="fw-bold text-dark">
                                            RT {{ $rt->nomor_rt }}
                                        </span>

                                    </td>
                                    <td class="text-center">

                                        <span class="fw-bold text-dark">
                                            RW {{ $rt->rw->nomor_rw ?? '-' }}
                                        </span>

                                    </td>
                                    <td class="text-center">

                                        <span class="fw-bold text-dark">
                                            {{ $rt->rw->dusun->nama_dusun ?? '-' }}
                                        </span>

                                    </td>

                                    <td class="text-center">

                                        <div class="fw-bold text-dark">
                                            {{ $jumlahWarga }}
                                        </div>

                                        <small class="text-muted">
                                            Orang
                                        </small>

                                    </td>

                                    <td class="text-center">

                                        <a href="{{ route('admin.pemetaan.detail.rt', $rt->id) }}"
                                            class="badge bg-info px-3 py-2 rounded-pill text-decoration-none skill-link">

                                            {{ $totalSkill }} Skill

                                        </a>

                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>
            </div>

        </div>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm fade-up h-100" style="border-radius: 15px;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0 text-dark">Sebaran Warga dan Keterampilan per RW</h5>
                        <small class="text-muted">Menampilkan jumlah RT, warga, dan keterampilan pada setiap RW.</small>
                    </div>
                    <div class="card-body px-0 pt-0">
                        <div class="table-responsive" style="max-height: 400px;">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light">
                                    <tr class="text-secondary"
                                        style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px;">

                                        <th class="px-4 py-3 border-0">
                                            RW
                                        </th>

                                        <th class="py-3 border-0">
                                            Dusun
                                        </th>

                                        {{-- <th class="py-3 border-0 text-center">
                                    Jumlah RT
                                </th> --}}

                                        <th class="py-3 border-0 text-center">
                                            Jumlah Warga
                                        </th>

                                        <th class="py-3 border-0 text-center px-4">
                                            Total Keterampilan
                                        </th>

                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($statistikRw as $rw)
                                        @php
                                            $jumlahRt = $rw->rts->count();

                                            $jumlahWarga = $rw->rts->sum(fn($rt) => $rt->wargas->count());

                                            $totalSkill = $rw->rts->sum(
                                                fn($rt) => $rt->wargas->sum(fn($w) => $w->keterampilans->count()),
                                            );
                                        @endphp

                                        <tr>

                                            <td class="px-4">
                                                <div class="d-flex align-items-center">
                                                    <span class="fw-bold text-dark">
                                                        RW {{ $rw->nomor_rw }}
                                                    </span>

                                                </div>
                                            </td>

                                            <td>
                                                <span class="text-dark">
                                                    {{ $rw->dusun->nama_dusun ?? '-' }}
                                                </span>
                                            </td>
                                            {{-- 
                                    <td class="text-center">

                                        <div class="fw-bold text-dark">
                                            {{ $jumlahRt }}
                                        </div>

                                        <small class="text-muted">
                                            RT
                                        </small>

                                    </td> --}}

                                            <td class="text-center">

                                                <div class="fw-bold text-dark">
                                                    {{ $jumlahWarga }}
                                                </div>

                                                <small class="text-muted">
                                                    Orang
                                                </small>

                                            </td>

                                            <td class="text-center px-4">

                                                <a href="{{ route('admin.pemetaan.detail.rw', $rw->id) }}"
                                                    class="badge bg-success px-3 py-2 rounded-pill text-decoration-none skill-link">

                                                    {{ $totalSkill }} Skill

                                                </a>

                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm fade-up h-100" style="border-radius: 15px;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0 text-dark">
                            Keterampilan Dominan
                        </h5>

                        <small class="text-muted">
                            Menampilkan keterampilan yang paling banyak dimiliki warga.
                        </small>
                    </div>
                    <div class="card-body px-4">
                        @foreach ($topSkillChart->take(6) as $index => $item)
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold text-dark small"
                                        style="font-size: 0.85rem;">{{ $item->nama_keterampilan }}</span>
                                    <span class="text-primary fw-bold small">{{ $item->total }} <small
                                            class="text-muted">Orang</small></span>
                                </div>
                                <div class="progress" style="height: 5px; border-radius: 10px;">
                                    @php
                                        $maxTotal = $topSkillChart->max('total') ?: 1;
                                        $percentage = ($item->total / $maxTotal) * 100;
                                    @endphp
                                    <div class="progress-bar bg-primary" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script>
        // Konfigurasi Chart Global
        Chart.defaults.font.family = "'Plus Jakarta Sans', 'Inter', sans-serif";
        Chart.defaults.color = '#64748b';

        // 1. OVERALL CHART (Gauge Style)
        // 1. OVERALL CHART

        new Chart(document.getElementById('overallChart'), {

            type: 'doughnut',

            data: {

                labels: [
                    'Total Warga',
                    'Total Keterampilan'
                ],

                datasets: [{

                    data: [
                        {{ $totalWarga }},
                        {{ $totalKeterampilan }}
                    ],

                    backgroundColor: [
                        '#38bdf8',
                        '#22c55e'
                    ],

                    borderWidth: 0

                }]

            },

            options: {

                cutout: '82%',

                responsive: true,

                maintainAspectRatio: false,
                animation: {
                    duration: 1800,
                    easing: 'easeOutQuart'
                },

                plugins: {

                    legend: {

                        position: 'bottom',

                        labels: {
                            color: '#ffffff',
                            usePointStyle: true
                        }

                    }

                }

            }

        });

        // 2. DUSUN CHART (Bar Gradient)
        const ctxDusun = document.getElementById('dusunChart').getContext('2d');
        const gradient = ctxDusun.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, '#4361ee');
        gradient.addColorStop(1, '#4cc9f0');

        new Chart(ctxDusun, {
            type: 'bar',
            data: {
                labels: {!! json_encode($statistikDusun->pluck('nama_dusun')) !!},
                datasets: [{
                    label: 'Total Skill',
                    data: {!! json_encode(
                        $statistikDusun->map(
                            fn($d) => $d->rws->sum(
                                fn($rw) => $rw->rts->sum(fn($rt) => $rt->wargas->sum(fn($w) => $w->keterampilans->count())),
                            ),
                        ),
                    ) !!},
                    backgroundColor: gradient,
                    borderRadius: 8,
                    barThickness: 30,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,

                animation: {
                    duration: 1800,
                    easing: 'easeOutQuart'
                },
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        grid: {
                            borderDash: [5, 5],
                            drawBorder: false
                        },
                        beginAtZero: true
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // 3. KATEGORI CHART (Doughnut)
        const kategoriLabels =
            {!! json_encode($kategoriChart->pluck('nama_kategori')) !!};

        const kategoriValues =
            {!! json_encode($kategoriChart->pluck('total')) !!};

        const totalKategori =
            kategoriValues.reduce((a, b) => a + b, 0);

        const maxValue =
            Math.max(...kategoriValues);

        const maxIndex =
            kategoriValues.indexOf(maxValue);

        const persenTerbesar =
            (
                maxValue /
                totalKategori *
                100
            ).toFixed(1);

        document.getElementById(
                'kategoriPersen'
            ).innerText =
            persenTerbesar + '%';

        document.getElementById(
                'kategoriNama'
            ).innerText =
            kategoriLabels[maxIndex];
        new Chart(document.getElementById('kategoriChart'), {
            type: 'doughnut',
            data: {
                labels: kategoriLabels,
                datasets: [{
                    data: kategoriValues,
                    backgroundColor: [
                        '#4361ee',
                        '#3a0ca3',
                        '#7209b7',
                        '#f72585',
                        '#4cc9f0',
                        '#4f46e5',
                        '#3b0ca3',
                        '#7b2cbf'
                    ],
                    borderWidth: 5,
                    borderColor: '#ffffff',
                }]
            },
            plugins: [ChartDataLabels],
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                animation: {
                    duration: 1800,
                    easing: 'easeOutQuart'
                },
                plugins: {

                    datalabels: {

                        color: '#ffffff',

                        font: {
                            weight: '600',
                            size: 6
                        },

                        formatter: (value, context) => {

                            const total = context.dataset.data.reduce(
                                (a, b) => a + b,
                                0
                            );

                            return ((value / total) * 100).toFixed(1) + '%';
                        }
                    },

                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            boxWidth: 10,
                            font: {
                                size: 12
                            }
                        }
                    },

                    tooltip: {
                        callbacks: {
                            label: function(context) {

                                const total =
                                    context.dataset.data.reduce(
                                        (a, b) => a + b,
                                        0
                                    );

                                const persen =
                                    (
                                        context.raw /
                                        total *
                                        100
                                    ).toFixed(1);

                                return context.label +
                                    ' : ' +
                                    persen + '%';
                            }
                        }
                    }
                }
            }
        });
        /* ANIMASI SAAT SCROLL */

        const observer = new IntersectionObserver(
            (entries) => {

                entries.forEach(entry => {

                    if (entry.isIntersecting) {

                        entry.target.classList.add('show');

                        observer.unobserve(entry.target);

                    }

                });

            }, {
                threshold: 0.15
            });

        document
            .querySelectorAll('.fade-up')
            .forEach(el => observer.observe(el));
    </script>
@endpush
