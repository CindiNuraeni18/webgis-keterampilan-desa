@extends('layouts.sidebar-admin')

@section('title', 'Data Warga')

@section('content')

<style>
    :root {
        --anim-speed: 0.85s;
        --anim-ease: cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ANIMASI */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
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

    /* CARD */
    .card {
        border-radius: 14px;
        transition: 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }

    /* TABLE */
    .table-responsive {
        border-radius: 12px;
        overflow-x: auto;
        animation: slideInUp var(--anim-speed) var(--anim-ease);
    }

    .table tbody tr {
        transition: 0.2s ease;
    }

    .table tbody tr:hover {
        background: rgba(13,110,253,0.05);
    }

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

    /* SEARCH */
    .search-wrapper {
        flex: 1;
        max-width: 400px;
    }

    .search-group {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        background: white;
    }

    .search-group input {
        border: none;
        outline: none;
    }

    .search-group .input-group-text {
        background: #0d6efd;
        color: white;
        border: none;
    }

    /* BUTTON */
    .btn {
        transition: 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .click-animate:active {
        transform: scale(0.96);
    }

    /* MODAL PILIHAN */
    .pilihan-card{
        transition:0.25s ease;
        cursor:pointer;
    }

    .pilihan-card:hover{
        transform:translateY(-4px);
        box-shadow:0 10px 24px rgba(0,0,0,0.08);
    }

    .icon-box{
        width:60px;
        height:60px;
        border-radius:18px;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:24px;
        flex-shrink:0;
    }

    /* RESPONSIVE */
    @media(max-width:768px){

        .table{
            font-size:12px;
            white-space:nowrap;
        }

        .search-wrapper{
            max-width:100%;
            width:100%;
        }

    }
</style>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <!-- HEADER -->
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

            <div>

                <h4 class="mb-1">
                    Data Warga
                </h4>

                <p class="text-muted mb-0">
                    Kelola informasi kependudukan Desa Karangmulya
                </p>

            </div>

            <div class="d-flex flex-wrap gap-2">

                <!-- SEARCH -->
                <form action="{{ route('admin.warga.index') }}"
                    method="GET"
                    class="search-wrapper">

                    <div class="input-group search-group shadow-sm">

                        <button type="submit"
                            class="input-group-text">

                            <i class="bi bi-search"></i>

                        </button>

                        <input type="text"
                            name="search"
                            class="form-control"
                            placeholder="Cari nama atau NIK..."
                            value="{{ request('search') }}">

                        @if(request()->filled('search'))

                            <a href="{{ route('admin.warga.index') }}"
                                class="btn btn-light border-0">

                                <i class="bi bi-x-circle"></i>

                            </a>

                        @endif

                    </div>

                </form>

                <!-- BUTTON TAMBAH -->
                <button class="btn btn-primary click-animate"
                    data-bs-toggle="modal"
                    data-bs-target="#pilihanTambahModal">

                    <i class="bi bi-plus-circle"></i>
                    Tambah Data

                </button>

            </div>

        </div>

        <!-- ALERT -->
        @if(session('success'))

            <div class="alert alert-success">

                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}

            </div>

        @endif

        <!-- TABLE -->
        <div class="table-responsive">

            <table class="table table-bordered align-middle table-striped table-hover text-nowrap">

                <thead class="table-primary text-center">

                    <tr>
                        <th width="60">No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>JK</th>
                        <th>RT</th>
                        <th>RW</th>
                        <th>Dusun</th>
                        <th>No HP</th>
                        <th>Pekerjaan</th>
                        <th width="180" class="sticky-col">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($wargas as $key => $warga)

                        <tr>

                            <td class="text-center">
                                {{ $wargas->firstItem() + $key }}
                            </td>

                            <td>{{ $warga->nik }}</td>
                            <td>{{ $warga->nama }}</td>
                            <td>{{ $warga->jenis_kelamin }}</td>
                            <td>{{ $warga->rt->nomor_rt }}</td>
                            <td>{{ $warga->rt->rw->nomor_rw }}</td>
                            <td>{{ $warga->rt->rw->dusun->nama_dusun }}</td>
                            <td>{{ $warga->no_hp ?? '-' }}</td>
                            <td>{{ $warga->pekerjaan ?? '-' }}</td>

                            <td class="text-center sticky-col">

                                <div class="d-flex justify-content-center gap-2">

                                    <!-- DETAIL -->
                                    <a href="{{ route('admin.warga.show', $warga->id) }}"
                                        class="btn btn-info btn-sm text-white">

                                        <i class="bi bi-eye"></i>

                                    </a>

                                    <!-- EDIT -->
                                    <a href="{{ route('admin.warga.edit', $warga->id) }}"
                                        class="btn btn-warning btn-sm">

                                        <i class="bi bi-pencil"></i>

                                    </a>

                                    <!-- DELETE -->
                                    <form action="{{ route('admin.warga.destroy', $warga->id) }}"
                                        method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus data warga ini?')">

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="10"
                                class="text-center text-muted">

                                <i class="bi bi-inbox"></i>
                                Data warga tidak ditemukan.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- PAGINATION -->
        <div class="mt-3">
            {{ $wargas->links() }}
        </div>

    </div>

</div>

<!-- MODAL PILIHAN TAMBAH -->
<div class="modal fade"
    id="pilihanTambahModal"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow rounded-4 overflow-hidden">

            <!-- HEADER -->
            <div class="modal-header bg-primary text-white">

                <h5 class="modal-title">

                    <i class="bi bi-plus-circle me-2"></i>
                    Tambah Data Warga

                </h5>

                <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <!-- BODY -->
            <div class="modal-body p-4">

                <div class="row g-3">

                    <!-- MANUAL -->
                    <div class="col-12">

                        <a href="{{ route('admin.warga.create') }}"
                            class="text-decoration-none">

                            <div class="card border-0 shadow-sm pilihan-card rounded-4">

                                <div class="card-body d-flex align-items-center gap-3">

                                    <div class="icon-box bg-primary bg-opacity-10 text-primary">

                                        <i class="bi bi-pencil-square"></i>

                                    </div>

                                    <div>

                                        <h6 class="mb-1 fw-semibold">
                                            Tambah Manual
                                        </h6>

                                        <small class="text-muted">
                                            Input data warga satu per satu
                                        </small>

                                    </div>

                                </div>

                            </div>

                        </a>

                    </div>

                    <!-- IMPORT -->
                    <div class="col-12">

                        <button class="btn p-0 border-0 w-100"
                            data-bs-dismiss="modal"
                            data-bs-toggle="modal"
                            data-bs-target="#importModal">

                            <div class="card border-0 shadow-sm pilihan-card rounded-4">

                                <div class="card-body d-flex align-items-center gap-3">

                                    <div class="icon-box bg-success bg-opacity-10 text-success">

                                        <i class="bi bi-upload"></i>

                                    </div>

                                    <div class="text-start">

                                        <h6 class="mb-1 fw-semibold">
                                            Import Excel
                                        </h6>

                                        <small class="text-muted">
                                            Upload data warga dari Excel / CSV
                                        </small>

                                    </div>

                                </div>

                            </div>

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- MODAL IMPORT -->
<div class="modal fade"
    id="importModal"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content border-0 shadow rounded-4">

            <!-- HEADER -->
            <div class="modal-header bg-success text-white">

                <h5 class="modal-title">

                    <i class="bi bi-upload me-2"></i>
                    Import Data Warga

                </h5>

                <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <!-- FORM -->
            <form action="{{ route('admin.warga.import') }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Upload File Excel / CSV
                        </label>

                        <input type="file"
                            name="file"
                            class="form-control"
                            accept=".xlsx,.xls,.csv"
                            required>

                    </div>

                    <div class="alert alert-info small mb-0">

                        <i class="bi bi-info-circle me-1"></i>

                        Format file harus:
                        <strong>.xlsx</strong>,
                        <strong>.xls</strong>,
                        atau
                        <strong>.csv</strong>

                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer">

                    <button type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button type="submit"
                        class="btn btn-success">

                        <i class="bi bi-upload me-1"></i>
                        Import Data

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection