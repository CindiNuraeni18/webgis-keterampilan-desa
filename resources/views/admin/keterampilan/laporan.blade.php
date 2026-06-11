@extends('layouts.sidebar-admin')

@section('title', 'Laporan Keterampilan')

@section('content')
    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        .card {
            border-radius: 12px;
            transition: .3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
            transform: translateY(-2px);
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
        }

        .search-group:focus-within {
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, .15);
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
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: white;
        }

        .btn-export {
            border: none;
            border-radius: 14px;
            color: white;
            font-weight: 600;
            transition: .3s;
        }

        .btn-pdf {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .btn-excel {
            background: linear-gradient(135deg, #16a34a, #22c55e);
        }

        .btn-export:hover {
            transform: translateY(-2px);
            color: white;
        }
    </style>
    <div class="container-fluid">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h4 class="mb-1">Laporan Data Keterampilan</h4>
                <p class="text-muted mb-0">
                    Rekap data keterampilan warga Desa Karangmulya
                </p>
            </div>

            <div class="d-flex gap-2">

                <!-- Export PDF -->
                <a href="{{ route('admin.keterampilan.laporan.pdf', request()->query()) }}" class="btn btn-export btn-pdf">
                    <i class="bi bi-file-earmark-pdf"></i> PDF
                </a>

                <!-- Export Excel -->
                <a href="{{ route('admin.keterampilan.laporan.excel', request()->query()) }}"
                    class="btn btn-export btn-excel">
                    <i class="bi bi-file-earmark-excel-fill"></i>
                    Excel
                </a>

                {{-- <!-- Print -->
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="bi bi-printer-fill"></i>
                    Print
                </button> --}}

            </div>
        </div>

        <!-- Search -->
        <div class="d-flex flex-wrap gap-2 mb-4">

            <!-- SEARCH -->
            <form id="filterForm" method="GET" action="{{ route('admin.keterampilan.laporan') }}"
                class="row g-2 align-items-center">

                <!-- SEARCH -->
                <div class="col-lg-3">
                    <div class="input-group search-group shadow-sm">

                        <span class="input-group-text bg-primary text-white border-0">
                            <i class="bi bi-search"></i>
                        </span>

                        <input type="text" name="search" class="form-control" placeholder="Cari nama warga..."
                            value="{{ request('search') }}">

                    </div>
                </div>

                <!-- TAHUN -->
                <div class="col-lg-2">
                    <select name="tahun" class="form-select">
                        <option value="">Semua Tahun</option>
                        @foreach ($tahuns as $tahun)
                            <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- DUSUN -->
                <div class="col-lg-2">
                    <select name="dusun" class="form-select">
                        <option value="">Semua Dusun</option>

                        @foreach ($dusuns as $item)
                            <option value="{{ $item->id }}" {{ request('dusun') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_dusun }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- RW -->
                <div class="col-lg-1">
                    <select name="rw" class="form-select">
                        <option value="">RW</option>

                        @foreach ($rws as $item)
                            <option value="{{ $item->id }}" {{ request('rw') == $item->id ? 'selected' : '' }}>
                                RW {{ $item->nomor_rw }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- RT -->
                <div class="col-lg-1">
                    <select name="rt" class="form-select">
                        <option value="">RT</option>

                        @foreach ($rts as $item)
                            <option value="{{ $item->id }}" {{ request('rt') == $item->id ? 'selected' : '' }}>
                                RT {{ $item->nomor_rt }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- KATEGORI -->
                <div class="col-lg-2">
                    <select name="kategori" class="form-select">
                        <option value="">Semua Kategori</option>

                        @foreach ($kategoris as $item)
                            <option value="{{ $item->id }}" {{ request('kategori') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- RESET -->
                @if (request()->filled('search') ||
                        request()->filled('tahun') ||
                        request()->filled('dusun') ||
                        request()->filled('rw') ||
                        request()->filled('rt') ||
                        request()->filled('kategori'))
                    <div class="col-lg-1">
                        <a href="{{ route('admin.keterampilan.laporan') }}" class="btn btn-danger w-100"
                            title="Reset Filter">

                            <i class="fas fa-rotate-left"></i>

                        </a>
                    </div>
                @endif

            </form>
        </div>
        <!-- Table laporan -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered align-middle table-striped table-hover text-nowrap">
                        <thead class="table-primary text-center">
                            <tr>
                                <th width="60">No</th>
                                <th>Nama Warga</th>
                                <th width="120">Dusun</th>
                                <th width="80">RT</th>
                                <th width="80">RW</th>
                                <th width="220">Kategori</th>
                                <th width="250">Keterampilan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($laporans as $index => $item)
                                <tr>
                                    <td>
                                        {{ $laporans->firstItem() + $index }}
                                    </td>

                                    <td>{{ $item->warga->nama }}</td>
                                    <td>{{ $item->warga->rt->rw->dusun->nama_dusun ?? '-' }}</td>
                                    <td class="text-center">
                                        RT {{ $item->warga->rt->nomor_rt ?? '-' }}
                                    </td>
                                    <td class="text-center">
                                        RW {{ $item->warga->rt->rw->nomor_rw ?? '-' }}
                                    </td>

                                    <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                                    <td>{{ $item->nama_keterampilan }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        Data tidak ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION -->
                <div class="mt-3">

                    {{ $laporans->links() }}

                </div>
            </div>
        </div>

    </div>
    <script>
        document.querySelectorAll('#filterForm select')
            .forEach(el => {

                el.addEventListener('change', () => {

                    document
                        .getElementById('filterForm')
                        .submit();

                });

            });

        let timer;

        document.querySelector('input[name="search"]')
            .addEventListener('keyup', function() {

                clearTimeout(timer);

                timer = setTimeout(() => {

                    this.form.submit();

                }, 800);

            });
    </script>
@endsection
