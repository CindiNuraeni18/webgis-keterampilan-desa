@extends('layouts.sidebar-admin')
@section('title', 'Dashboard')

@section('content')

    <div class="container dashboard-admin">

        <!-- HEADER -->
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">Dashboard Admin {{ Auth::user()->name }}</h2>
                <p class="text-muted">Sistem Informasi Pemetaan Keterampilan Warga</p>
            </div>
        </div>

        <!-- STATISTIK -->
        <div class="row g-4">

            <div class="col-6 col-md-3">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Total Warga</h6>
                        <h3 class="fw-bold">{{ $totalWarga ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Warga Terampil</h6>
                        <h3 class="fw-bold text-success">{{ $wargaTerampil ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Total Skill</h6>
                        <h3 class="fw-bold text-primary">{{ $totalSkill ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h6 class="text-muted">RT & RW</h6>
                        <h3 class="fw-bold">{{ $totalRTRW ?? 0 }}</h3>
                    </div>
                </div>
            </div>

        </div>

        <!-- MAP + AKTIVITAS -->
        <div class="row mt-5 g-4">

            <!-- MAP -->
            <div class="col-lg-8">
                <div class="card shadow border-0">
                    <div class="card-header fw-bold">Peta Sebaran</div>
                    <div class="card-body">
                        <div id="map" style="height:400px;"></div>
                    </div>
                </div>
            </div>

            <!-- QUICK ACTIONS -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex gap-2">
                        <a href="{{ route('warga.create') }}" class="btn btn-primary shadow-sm">
                            <i class="fas fa-plus me-1"></i> Tambah Warga
                        </a>
                        <a href="{{ route('keterampilan.index') }}" class="btn btn-outline-primary shadow-sm bg-white">
                            <i class="fas fa-list me-1"></i> Kelola Skill
                        </a>
                        <a href="{{ route('laporan.export') }}" class="btn btn-success shadow-sm">
                            <i class="fas fa-file-export me-1"></i> Cetak Laporan
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- ANALISIS -->
        <div class="row mt-4 g-4">

            <!-- PERSENTASE -->
            <div class="col-md-4">
                <div class="card shadow border-0">
                    <div class="card-header fw-bold">Persentase Warga Terampil</div>
                    <div class="card-body text-center">
                        <h1 class="text-success">{{ $persentaseSkill ?? 0 }}%</h1>
                    </div>
                </div>
            </div>

            <!-- TOP SKILL -->
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="card-header fw-bold">Top Keterampilan</div>
                    <div class="card-body">

                        @if (isset($topSkill) && $topSkill->count())
                            @foreach ($topSkill as $item)
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <span>{{ $item->nama_keterampilan }}</span>
                                        <span>{{ $item->total }}</span>
                                    </div>
                                    <div class="progress" style="height:6px;">
                                        <div class="progress-bar bg-primary"
                                            style="width: {{ ($item->total / max($topSkill->max('total'), 1)) * 100 }}%">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">Belum ada data</p>
                        @endif

                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- LEAFLET -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const map = L.map('map').setView([-6.326, 108.320], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png')
            .addTo(map);
    </script>

@endsection
