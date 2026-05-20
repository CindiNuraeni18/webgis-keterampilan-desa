@extends('layouts.sidebar-admin')

@section('title', 'Laporan Keterampilan')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold">Laporan Data Keterampilan</h4>
                <p class="text-muted mb-0">
                    Rekap data keterampilan warga Desa Karangmulya
                </p>
            </div>

            <div class="d-flex gap-2">

                <!-- Export PDF -->
                <a href="{{ route('admin.keterampilan.laporan.pdf') }}" class="btn btn-danger">
                    <i class="bi bi-file-earmark-pdf"></i> PDF
                </a>

                <!-- Export Excel -->
                <a href="{{ route('admin.keterampilan.laporan.excel') }}" class="btn btn-success">
                    <i class="bi bi-file-earmark-excel-fill"></i>
                    Excel
                </a>

                <!-- Print -->
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="bi bi-printer-fill"></i>
                    Print
                </button>

            </div>
        </div>

        <!-- Search -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form method="GET" id="filterForm">
                    <div class="row g-3 align-items-end">

                        <!-- SEARCH -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Cari Warga</label>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="Nama warga / NIK...">
                        </div>
                        <!-- TAHUN -->
                        <div class="col-md-2">

                            <label class="form-label fw-semibold">
                                Tahun
                            </label>

                            <select name="tahun" class="form-select">

                                <option value="">Semua</option>

                                @foreach ($tahuns as $tahun)
                                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>

                                        {{ $tahun }}

                                    </option>
                                @endforeach

                            </select>

                        </div>
                        <!-- DUSUN -->
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Dusun</label>
                            <select name="dusun" class="form-select">
                                <option value="">Semua</option>
                                @foreach ($dusuns as $item)
                                    <option value="{{ $item->id }}"
                                        {{ request('dusun') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_dusun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- RW -->
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">RW</label>
                            <select name="rw" class="form-select">
                                <option value="">Semua</option>
                                @foreach ($rws as $item)
                                    <option value="{{ $item->id }}" {{ request('rw') == $item->id ? 'selected' : '' }}>
                                        RW {{ $item->nomor_rw }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- RT -->
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">RT</label>
                            <select name="rt" class="form-select">
                                <option value="">Semua</option>
                                @foreach ($rts as $item)
                                    <option value="{{ $item->id }}"
                                        {{ request('rt') == $item->id ? 'selected' : '' }}>
                                        RT {{ $item->nomor_rt }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- KATEGORI -->
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Kategori</label>
                            <select name="kategori" class="form-select">
                                <option value="">Semua</option>
                                @foreach ($kategoris as $item)
                                    <option value="{{ $item->id }}"
                                        {{ request('kategori') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- RESET BUTTON -->
                        <div class="col-md-12 text-end">
                            @if (request()->filled('search') ||
                                    request()->filled('dusun') ||
                                    request()->filled('rw') ||
                                    request()->filled('rt') ||
                                    request()->filled('kategori') ||
                                    request()->filled('tahun'))
                                <a href="{{ route('admin.keterampilan.laporan') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-clockwise"></i>
                                    Reset Filter
                                </a>
                            @endif
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <!-- Table laporan -->
        <div class="card shadow-sm border-0">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Nama Warga</th>
                                <th>NIK</th>
                                <th>Dusun</th>
                                <th>RW</th>
                                <th>RT</th>
                                <th>Kategori</th>
                                <th>Keterampilan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($laporans as $index => $item)
                                <tr>
                                    <td>
                                        {{ $laporans->firstItem() + $index }}
                                    </td>

                                    <td>{{ $item->warga->nama }}</td>
                                    <td>{{ $item->warga->nik }}</td>
                                    <td>{{ $item->warga->rt->rw->dusun->nama_dusun ?? '-' }}</td>
                                    <td>{{ $item->warga->rt->rw->nomor_rw ?? '-' }}</td>
                                    <td>{{ $item->warga->rt->nomor_rt ?? '-' }}</td>
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

                <div class="mt-3">
                    {{ $laporans->links() }}
                </div>

            </div>
        </div>

    </div>
    <script>
        const form = document.getElementById('filterForm');

        // semua select otomatis submit
        document.querySelectorAll('#filterForm select').forEach(el => {
            el.addEventListener('change', function() {
                form.submit();
            });
        });

        // search input (opsional: auto setelah berhenti ngetik)
        let timer;
        document.querySelector('input[name="search"]').addEventListener('keyup', function() {
            clearTimeout(timer);
            timer = setTimeout(() => {
                form.submit();
            }, 800); // delay 0.8 detik
        });
    </script>
@endsection
