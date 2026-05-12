@extends('layouts.sidebar-admin')

@section('title', 'Statistik Keterampilan')

@section('content')
    <div class="container-fluid py-4" style="background-color: #f8f9fa; min-height: 100vh;">

        {{-- HEADER --}}
        <div class="mb-4">
            <h4 class="fw-bold mb-1" style="color: #2c3e50; letter-spacing: -0.5px;">Statistik Keterampilan Warga</h4>
            <p class="text-muted small mb-0">
                <i class="fas fa-chart-pie me-1"></i> Analisis mendalam kapasitas sumber daya manusia desa
            </p>
        </div>

        {{-- GRAFIK KESELURUHAN (HERO SECTION) --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm overflow-hidden"
                    style="border-radius: 20px; background: linear-gradient(135deg, #1e293b 0%, #334155 100%);">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-7 text-white">
                                <h5 class="fw-bold mb-2 text-info">Total Kapasitas SDM Desa</h5>
                                <p class="text-white-50 small mb-4">Perbandingan jumlah warga yang memiliki keterampilan
                                    terdata terhadap total populasi desa.</p>
                                <div class="row g-3">
                                    <div class="col-6 col-sm-4">
                                        <div class="p-3 rounded-3"
                                            style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                                            <h3 class="fw-bold mb-0 text-white">
                                                {{ $statistikRt->sum(fn($rt) => $rt->wargas->count()) }}</h3>
                                            <small class="text-white-50">Total Warga</small>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-4">
                                        <div class="p-3 rounded-3"
                                            style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                                            <h3 class="fw-bold mb-0 text-success">
                                                {{ $statistikRt->sum(fn($rt) => $rt->wargas->filter(fn($w) => $w->keterampilans->count() > 0)->count()) }}
                                            </h3>
                                            <small class="text-white-50">Warga Terampil</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 mt-4 mt-md-0 d-flex justify-content-center">
                                <div style="height: 180px; width: 180px; position: relative;">
                                    <canvas id="overallChart"></canvas>
                                    <div
                                        style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                                        <h4 class="text-white fw-bold mb-0">Total</h4>
                                        <small class="text-white-50">Statistik</small>
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
                <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0 text-dark">Distribusi Keterampilan per Dusun</h5>
                        <small class="text-muted">Perbandingan jumlah entri skill antar wilayah</small>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div style="height: 320px;">
                            <canvas id="dusunChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 text-center">
                        <h5 class="fw-bold mb-0 text-dark">Proporsi Kategori</h5>
                        <small class="text-muted">Komposisi rumpun keahlian</small>
                    </div>
                    <div class="card-body px-4 pb-4 d-flex align-items-center">
                        <canvas id="kategoriChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLES --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px; overflow: hidden;">
            <div class="card-header bg-white border-0 pt-4 px-4 d-flex align-items-center">
                <i class="fas fa-map-marked-alt me-2 text-primary"></i>
                <h5 class="fw-bold mb-0 text-dark">Statistik Per RW</h5>
            </div>
            <div class="card-body p-0 mt-2">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr class="text-secondary"
                                style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px;">
                                <th class="px-4 py-3 border-0">Wilayah RW</th>
                                <th class="py-3 border-0">Dusun</th>
                                <th class="py-3 border-0 text-center">RT</th>
                                <th class="py-3 border-0 text-center">Populasi</th>
                                <th class="py-3 border-0 text-center px-4">Total Skill</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($statistikRw as $rw)
                                <tr>
                                    <td class="px-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                                                style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                {{ $rw->nomor_rw }}
                                            </div>
                                            <span class="fw-bold text-dark">RW {{ $rw->nomor_rw }}</span>
                                        </div>
                                    </td>
                                    <td><span
                                            class="badge bg-light text-primary border-0 px-3 py-2">{{ $rw->dusun->nama_dusun ?? '-' }}</span>
                                    </td>
                                    <td class="text-center text-muted">{{ $rw->rts->count() }}</td>
                                    <td class="text-center fw-medium">{{ $rw->rts->sum(fn($rt) => $rt->wargas->count()) }}
                                    </td>
                                    <td class="text-center px-4">
                                        <span class="badge bg-success px-3 py-2 rounded-pill">
                                            {{ $rw->rts->sum(fn($rt) => $rt->wargas->sum(fn($w) => $w->keterampilans->count())) }}
                                        </span>
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
                <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">Detail Per RT</h5>
                    </div>
                    <div class="card-body px-0 pt-0">
                        <div class="table-responsive" style="max-height: 400px;">
                            <table class="table table-hover align-middle">
                                <thead class="sticky-top bg-white">
                                    <tr class="text-muted small">
                                        <th class="px-4 py-3 border-0">RT / RW</th>
                                        <th class="text-center border-0">Warga</th>
                                        <th class="text-center border-0">Total Skill</th>
                                        <th class="px-4 border-0">Visualitas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($statistikRt as $rt)
                                        <tr>
                                            <td class="px-4 py-3 text-dark fw-medium">RT {{ $rt->nomor_rt }} / RW
                                                {{ $rt->rw->nomor_rw ?? '-' }}</td>
                                            <td class="text-center text-muted">{{ $rt->wargas->count() }}</td>
                                            <td class="text-center fw-bold text-primary">
                                                @php $count = $rt->wargas->sum(fn($w) => $w->keterampilans->count()); @endphp
                                                {{ $count }}
                                            </td>
                                            <td class="px-4">
                                                <div class="progress"
                                                    style="height: 6px; border-radius: 10px; width: 70px;">
                                                    <div class="progress-bar bg-info"
                                                        style="width: {{ min($count * 10, 100) }}%"></div>
                                                </div>
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
                <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0 text-dark">Top Keterampilan Terdata</h5>
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
    <script>
        // Konfigurasi Chart Global
        Chart.defaults.font.family = "'Plus Jakarta Sans', 'Inter', sans-serif";
        Chart.defaults.color = '#64748b';

        // 1. OVERALL CHART (Gauge Style)
        new Chart(document.getElementById('overallChart'), {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [
                        {{ $statistikRt->sum(fn($rt) => $rt->wargas->filter(fn($w) => $w->keterampilans->count() > 0)->count()) }},
                        {{ $statistikRt->sum(fn($rt) => $rt->wargas->filter(fn($w) => $w->keterampilans->count() == 0)->count()) }}
                    ],
                    backgroundColor: ['#38bdf8', 'rgba(255,255,255,0.1)'],
                    borderWidth: 0,
                    hoverOffset: 0
                }]
            },
            options: {
                cutout: '82%',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        enabled: true
                    },
                    legend: {
                        display: false
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
        new Chart(document.getElementById('kategoriChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($kategoriChart->pluck('nama_kategori')) !!},
                datasets: [{
                    data: {!! json_encode($kategoriChart->pluck('total')) !!},
                    backgroundColor: ['#4361ee', '#3a0ca3', '#7209b7', '#f72585', '#4cc9f0'],
                    borderWidth: 5,
                    borderColor: '#ffffff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
