@extends('layouts.sidebar-admin')

@section('title', 'Data Dusun')

@section('content')

    <style>
        /* =========================
           ANIMASI
        ========================= */
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
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* =========================
           CARD
        ========================= */
        .card {
            border-radius: 12px;
            transition: 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        /* =========================
           TABLE
        ========================= */
        .table-responsive {
            border-radius: 10px;
            overflow-x: auto;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            animation: slideInUp 0.6s ease;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead {
            background: #f8f9fa;
        }

        .table tbody tr {
            transition: 0.2s ease;
            animation: fadeIn 0.5s ease;
            animation-fill-mode: both;
        }

        .table tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.05);
            transform: translateX(3px);
        }

        /* Delay animasi */
        .table tbody tr:nth-child(1) {
            animation-delay: 0.05s;
        }

        .table tbody tr:nth-child(2) {
            animation-delay: 0.1s;
        }

        .table tbody tr:nth-child(3) {
            animation-delay: 0.15s;
        }

        .table tbody tr:nth-child(4) {
            animation-delay: 0.2s;
        }

        .table tbody tr:nth-child(5) {
            animation-delay: 0.25s;
        }

        /* =========================
           STICKY AKSI
        ========================= */
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
           BUTTON
        ========================= */
        .btn {
            transition: 0.2s ease-in-out;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        /* =========================
           SEARCH (FIX CLEAN)
        ========================= */

        /* wrapper */
        .search-wrapper {
            flex: 1;
            max-width: 380px;
        }

        /* search group (PAKAI INI SAJA, jangan pakai input-group lagi di CSS) */
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

        /* focus */
        .search-group:focus-within {
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
        }

        /* input */
        .search-group input {
            flex: 1;
            border: none;
            outline: none;
            padding: 6px 10px;
        }

        /* tombol kiri */
        .search-group .input-group-text {
            border: none;
            background: #0d6efd;
            color: white;
        }

        /* tombol kanan */
        .search-group .btn {
            border: none;
        }

        /* hover */
        .search-group .input-group-text:hover {
            background: #0b5ed7;
        }

        .search-group .btn:hover {
            background: #f1f5f9;
        }

        /* =========================
           RESPONSIVE
        ========================= */
        @media (max-width: 768px) {
            .table {
                font-size: 12px;
                white-space: nowrap;
            }
        }

        @media (max-width: 576px) {

            .table th,
            .table td {
                padding: 6px;
                font-size: 11px;
            }

            .search-wrapper {
                max-width: 100%;
                width: 100%;
            }
        }

        /* =========================
       ANIMASI HEADER (BARU)
    ========================= */

        /* Judul */
        .title-animate {
            animation: slideFadeLeft 0.6s ease;
        }

        /* Search */
        .search-animate {
            animation: zoomFade 0.6s ease;
        }

        /* Tombol tambah */
        .btn-animate {
            animation: slideFadeRight 0.6s ease;
        }

        /* Klik effect */
        .click-animate:active {
            transform: scale(0.95);
        }

        /* =========================
       KEYFRAMES BARU
    ========================= */
        @keyframes slideFadeLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideFadeRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes zoomFade {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* =========================
       ANIMASI GLOBAL (HALUS)
    ========================= */
        :root {
            --anim-speed: 0.85s;
            --anim-ease: cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* =========================
       ANIMASI TABLE (TETAP)
    ========================= */
        .table-responsive {
            animation: slideInUp var(--anim-speed) var(--anim-ease);
        }

        .table tbody tr {
            animation: fadeIn var(--anim-speed) var(--anim-ease);
            animation-fill-mode: both;
        }

        /* =========================
       ANIMASI HEADER (DIPERHALUS)
    ========================= */

        /* Judul */
        .title-animate {
            animation: slideFadeLeft var(--anim-speed) var(--anim-ease);
        }

        /* Search */
        .search-animate {
            animation: zoomFade calc(var(--anim-speed) + 0.1s) var(--anim-ease);
        }

        /* Tombol tambah */
        .btn-animate {
            animation: slideFadeRight calc(var(--anim-speed) + 0.15s) var(--anim-ease);
        }

        /* Klik effect lebih halus */
        .click-animate {
            transition: transform 0.15s ease;
        }

        .click-animate:active {
            transform: scale(0.96);
        }

        /* =========================
       KEYFRAMES (HALUS)
    ========================= */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
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

        /* dari bawah */
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
    </style>

    <div class="card border-0 shadow-sm fade-in">
        <div class="card-body">

            <!-- HEADER -->
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

                <div>
                    <h4 class="mb-1 title-animate">Data Dusun</h4>
                    <p class="text-muted title-animate mb-0">Kelola data dusun</p>
                </div>

                <div class="d-flex flex-wrap gap-2">

                    <!-- SEARCH -->
                    <form action="{{ route('admin.dusun.index') }}" method="GET" class="search-wrapper search-animate">
                        <div class="input-group search-group shadow-sm">

                            <button type="submit" class="input-group-text bg-primary text-white border-0">
                                <i class="bi bi-search"></i>
                            </button>

                            <input type="text" name="search" class="form-control border-0" placeholder="Cari dusun..."
                                value="{{ request('search') }}">

                            @if (request()->filled('search'))
                                <a href="{{ route('admin.dusun.index', request()->except('search')) }}"
                                    class="btn btn-light border-0">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            @endif

                        </div>
                    </form>

                    <!-- TAMBAH -->
                    <a href="{{ route('admin.dusun.create') }}" class="btn btn-primary btn-animate click-animate">
                        <i class="bi bi-plus-circle"></i>
                        <span class="d-none d-md-inline">Tambah</span>
                    </a>

                </div>
            </div>

            <!-- ALERT -->
            @if (session('success'))
                <div class="alert alert-success fade-in">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <!-- TABLE -->
            <div class="table-responsive">
                <table class="table table-bordered align-middle table-striped table-hover align-middle text-nowrap">
                    <thead class="table-primary text-center">
                        <tr>
                            <th width="60">No</th>
                            <th>Nama Dusun</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th width="180" class="sticky-col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dusuns as $key => $dusun)
                            <tr>
                                <td class="text-center">{{ $dusuns->firstItem() + $key }}</td>
                                <td>{{ $dusun->nama_dusun }}</td>
                                <td>{{ $dusun->latitude ?? '-' }}</td>
                                <td>{{ $dusun->longitude ?? '-' }}</td>
                                <td class="text-center sticky-col">

                                    <div class="d-flex justify-content-center gap-2">

                                        <a href="{{ route('admin.dusun.show', $dusun->id) }}" class="btn btn-info btn-sm"
                                            title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('admin.dusun.edit', $dusun->id) }}"
                                            class="btn btn-warning btn-sm" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('admin.dusun.destroy', $dusun->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus"
                                                onclick="return confirm('Yakin hapus data?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </div>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    <i class="bi bi-inbox"></i> Data dusun belum ada.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div class="mt-3">
                {{ $dusuns->links() }}
            </div>

        </div>
    </div>

@endsection
