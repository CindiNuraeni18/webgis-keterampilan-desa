@extends('layouts.sidebar-admin')

@section('title', 'Detail RW')

@section('content')
    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
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

        .stat-card {
            border-radius: 16px;
            overflow: hidden;
            transition: .3s ease;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, .12);
        }

        .stat-card .card-body {
            padding: 14px 10px;
        }

        .stat-card i {
            font-size: 1.1rem;
            margin-bottom: 6px;
            transition: .3s ease;
        }

        .stat-card:hover i {
            transform: scale(1.15) rotate(-8deg);
        }

        .stat-card h4 {
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .stat-card h6 {
            font-size: .95rem;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .stat-card small {
            font-size: .75rem;
            opacity: .95;
        }

        .table-responsive {
            border-radius: 10px;
            overflow-x: auto;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .05);
        }

        .table {
            margin-bottom: 0;
        }

        .table tbody tr {
            transition: .2s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(13, 110, 253, .05);
            transform: translateX(3px);
        }

        .pagination {
            justify-content: center;
            gap: 6px;
            margin-top: 25px;
        }

        .page-item .page-link {
            border: none;
            border-radius: 12px !important;
            min-width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #475569;
            font-weight: 600;
            transition: .3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .05);
        }

        .page-item .page-link:hover {
            transform: translateY(-2px);
            background: #eff6ff;
            color: #2563eb;
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg,
                    #2563eb,
                    #3b82f6);
            color: white;
        }

        .page-item.disabled .page-link {
            background: #f8fafc;
            color: #94a3b8;
        }
    </style>
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>
                    <h3 class="mb-1">
                        Detail Wilayah RW {{ $rw->nomor_rw }}
                    </h3>

                    <p class="text-muted mb-0">
                        Informasi warga dan keterampilan yang terdata pada wilayah RW ini
                    </p>
                </div>

                <a href="{{ url()->previous() }}" class="btn btn-back px-4">

                    <i class="fa-solid fa-arrow-left me-2"></i>
                    Kembali

                </a>

            </div>

            <p>
                <b>Dusun:</b>
                {{ $rw->dusun->nama_dusun }}
            </p>
            @php

                $totalRt = $rw->rts->count();

                $totalWarga = $rw->rts->flatMap(fn($rt) => $rt->wargas)->count();

                $totalSkill = $rw->rts->flatMap(fn($rt) => $rt->wargas)->flatMap(fn($w) => $w->keterampilans)->count();

                $kategoriTerbanyak = $rw->rts
                    ->flatMap(fn($rt) => $rt->wargas)
                    ->flatMap(fn($w) => $w->keterampilans)
                    ->groupBy('kategori_id')
                    ->sortByDesc(fn($items) => $items->count())
                    ->first();

                $namaKategoriTerbanyak = '-';
                $jumlahKategoriTerbanyak = 0;

                if ($kategoriTerbanyak) {
                    $namaKategoriTerbanyak = $kategoriTerbanyak->first()->kategori->nama_kategori;

                    $jumlahKategoriTerbanyak = $kategoriTerbanyak->count();
                }
            @endphp
            <div class="row g-3 mb-4">

                <div class="col-md-3">
                    <div class="card stat-card border-0 bg-info text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-map"></i>
                            <h4>{{ $totalRt }}</h4>
                            <small>Total RT</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card border-0 bg-primary text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-users"></i>
                            <h4>{{ $totalWarga }}</h4>
                            <small>Total Warga</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card border-0 bg-success text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-tools"></i>
                            <h4>{{ $totalSkill }}</h4>
                            <small>Total Keterampilan</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card border-0 bg-warning text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-trophy"></i>

                            <h6 class="fw-bold">
                                {{ $namaKategoriTerbanyak }}
                            </h6>

                            <small>
                                {{ $jumlahKategoriTerbanyak }} Keterampilan
                            </small>
                        </div>
                    </div>
                </div>

            </div>
            <div class="table-responsive">

                <table class="table table-bordered align-middle table-striped table-hover text-nowrap">

                    <thead class="table-primary text-center">
                        <tr>
                            <th width="60">No</th>
                            <th>Nama Warga</th>
                            <th>Keterampilan</th>
                            <th width="220">Kategori</th>
                            <th width="150">Dusun</th>
                        </tr>
                    </thead>

                    <tbody>

                        @php $no = 1; @endphp

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
                                    {{ $skill->nama_keterampilan }}
                                </td>

                                <td>
                                    {{ $skill->kategori->nama_kategori }}
                                </td>

                                <td>
                                    {{ $rw->dusun->nama_dusun }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="text-center">
                                    Tidak ada data
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $skills->links() }}
            </div>
        </div>
    </div>

@endsection
