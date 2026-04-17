@extends('layouts.sidebar-admin')

@section('title', 'Data RW')

@section('content')

    <style>
        /* =========================
           ANIMASI GLOBAL (HALUS)
        ========================= */
        :root {
            --anim-speed: 0.85s;
            --anim-ease: cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(25px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* dari kiri */
        @keyframes slideFadeLeft {
            from {
                opacity: 0;
                transform: translateX(-25px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* dari kanan */
        @keyframes slideFadeRight {
            from {
                opacity: 0;
                transform: translateX(25px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* zoom halus */
        @keyframes zoomFade {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* =========================
           CARD & TABLE
        ========================= */
        .card {
            border-radius: 12px;
            transition: 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .table-responsive {
            border-radius: 10px;
            overflow-x: auto;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            animation: slideInUp var(--anim-speed) var(--anim-ease);
        }

        .table {
            margin-bottom: 0;
        }

        .table tbody tr {
            animation: fadeIn var(--anim-speed) var(--anim-ease);
            animation-fill-mode: both;
            transition: 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.05);
            transform: translateX(3px);
        }

        /* Delay animasi baris tabel */
        .table tbody tr:nth-child(1) {
            animation-delay: 0.05s;
        }

        .table tbody tr:nth-child(2) {
            animation-delay: 0.1s;
        }

        .table tbody tr:nth-child(3) {
            animation-delay: 0.15s;
        }

        /* sticky aksi */
        .sticky-col {
            position: sticky;
            right: 0;
            background: #fff;
            z-index: 2;
        }

        thead .sticky-col {
            background: #f8f9fa;
            z-index: 3;
        }

        /* =========================
           SEARCH & BUTTONS
        ========================= */
        .search-wrapper {
            flex: 1;
            max-width: 380px;
        }

        .search-group {
            display: flex;
            align-items: center;
            width: 100%;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            background: #fff;
            transition: 0.2s ease;
        }

        .search-group:focus-within {
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
        }

        .search-group input {
            flex: 1;
            border: none;
            outline: none;
            padding: 6px 10px;
        }

        .search-group .input-group-text {
            border: none;
            background: #0d6efd;
            color: white;
        }

        .btn {
            transition: 0.2s ease-in-out;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .click-animate {
            transition: transform 0.15s ease;
        }

        .click-animate:active {
            transform: scale(0.96);
        }

        /* Header Animation Assignment */
        .title-animate {
            animation: slideFadeLeft var(--anim-speed) var(--anim-ease);
        }

        .search-animate {
            animation: zoomFade calc(var(--anim-speed) + 0.1s) var(--anim-ease);
        }

        .btn-animate {
            animation: slideFadeRight calc(var(--anim-speed) + 0.15s) var(--anim-ease);
        }

        @media (max-width: 768px) {
            .table {
                font-size: 12px;
                white-space: nowrap;
            }

            .search-wrapper {
                max-width: 100%;
                width: 100%;
            }
        }
    </style>

    <div class="card border-0 shadow-sm fade-in">
        <div class="card-body">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                <div>
                    <h4 class="mb-1 title-animate">Data RW</h4>
                    <p class="text-muted title-animate mb-0">Kelola data RW berdasarkan dusun</p>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <form action="{{ route('admin.rw.index') }}" method="GET" class="search-wrapper search-animate">
                        <div class="input-group search-group shadow-sm">
                            <button type="submit" class="input-group-text bg-primary text-white border-0">
                                <i class="bi bi-search"></i>
                            </button>

                            <input type="text" name="search" class="form-control border-0"
                                placeholder="Cari RW / dusun..." value="{{ request('search') }}">

                            @if (request()->filled('search'))
                                <a href="{{ route('admin.rw.index', request()->except('search')) }}"
                                    class="btn btn-light border-0">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            @endif
                        </div>
                    </form>

                    <a href="{{ route('admin.rw.create') }}" class="btn btn-primary btn-animate click-animate">
                        <i class="bi bi-plus-circle"></i>
                        <span class="d-none d-md-inline">Tambah</span>
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success fade-in">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered align-middle table-striped table-hover text-nowrap">
                    <thead class="table-primary text-center">
                        <tr>
                            <th width="60">No</th>
                            <th>Nomor RW</th>
                            <th>Dusun</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th width="180" class="sticky-col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rws as $key => $rw)
                            <tr>
                                <td class="text-center">{{ $rws->firstItem() + $key }}</td>
                                <td>{{ $rw->nomor_rw }}</td>
                                <td>{{ $rw->dusun->nama_dusun }}</td>
                                <td>{{ $rw->latitude ?? '-' }}</td>
                                <td>{{ $rw->longitude ?? '-' }}</td>
                                <td class="text-center sticky-col">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.rw.show', $rw->id) }}" class="btn btn-info btn-sm"
                                            title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.rw.edit', $rw->id) }}" class="btn btn-warning btn-sm"
                                            title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.rw.destroy', $rw->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" title="Hapus"
                                                onclick="return confirm('Yakin hapus data?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    <i class="bi bi-inbox"></i> Data RW belum ada.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $rws->links() }}
            </div>

        </div>
    </div>

@endsection
