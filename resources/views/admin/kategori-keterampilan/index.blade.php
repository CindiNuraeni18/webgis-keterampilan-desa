@extends('layouts.sidebar-admin')

@section('title', 'Kategori Keterampilan')

@section('content')
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
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
            padding: 6px 12px;
        }

        .search-group .input-group-text {
            border: none;
            background: #0d6efd;
            color: white;
        }

       /* =========================
   BUTTON SAVE
========================= */

.btn-save{

    position: relative;

    overflow: hidden;

    border: none;

    border-radius: 14px;

    background: linear-gradient(
        135deg,
        #2563eb,
        #3b82f6
    );

    color: white !important;

    font-weight: 600;

    transition: all .35s ease;

    box-shadow:
        0 6px 18px rgba(37,99,235,.25);

}

.btn-save::before{

    content: '';

    position: absolute;

    top: 0;

    left: -75%;

    width: 50%;

    height: 100%;

    background: rgba(255,255,255,.22);

    transform: skewX(-25deg);

    transition: .7s;

}

.btn-save:hover{

    transform:
        translateY(-2px)
        scale(1.03);

    box-shadow:
        0 10px 24px rgba(37,99,235,.35);

    color: white !important;

}

.btn-save:hover::before{

    left: 130%;

}

.btn-save i{

    transition: .3s ease;

}

.btn-save:hover i{

    transform: rotate(-10deg);

}

.btn-save span{

    color: white !important;

    position: relative;

    z-index: 2;

}

        /* Header Animation */
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
            }
        }
         /* SWEETALERT DI ATAS NAVBAR */

        .swal2-container {
            z-index: 999999 !important;
        }

        .swal2-backdrop-show {
            z-index: 999998 !important;
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

            box-shadow:
                0 2px 8px rgba(0, 0, 0, .05);

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

            box-shadow:
                0 8px 20px rgba(37, 99, 235, .25);

        }

        .page-item.disabled .page-link {

            background: #f8fafc;

            color: #94a3b8;

        }
    </style>

    <div class="card border-0 shadow-sm fade-in">
        <div class="card-body">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                <div>
                    <h4 class="mb-1 title-animate">Kategori Keterampilan</h4>
                    <p class="text-muted title-animate mb-0">Kelola kategori keterampilan warga</p>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <form action="{{ route('admin.kategori-keterampilan.index') }}" method="GET"
                        class="search-wrapper search-animate">
                        <div class="input-group search-group shadow-sm">
                            <button type="submit" class="input-group-text bg-primary text-white border-0">
                                <i class="bi bi-search"></i>
                            </button>
                            <input type="text" name="search" class="form-control border-0"
                                placeholder="Cari kategori..." value="{{ request('search') }}">

                            @if (request()->filled('search'))
                               <a href="{{ route('admin.kategori-keterampilan.index', request()->except('search')) }}"
    class="btn btn-light border-0">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            @endif
                        </div>
                    </form>

                    <a href="{{ route('admin.kategori-keterampilan.create') }}"
    class="btn btn-save px-4">
    <i class="fa-solid fa-plus me-2"></i>
    <span>
        Tambah
    </span>
</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-primary text-center">
                        <tr>
                            <th width="60">No</th>
                            <th>Nama Kategori</th>
                            {{-- <th width="200">Aksi</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategoris as $key => $kategori)
                            <tr style="animation-delay: {{ $loop->index * 0.05 }}s">
                                <td class="text-center">{{ $kategoris->firstItem() + $key }}</td>
                                <td class="fw-semibold">{{ $kategori->nama_kategori }}</td>
                                {{-- <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.kategori-keterampilan.show', $kategori->id) }}"
                                            class="btn btn-info btn-sm text-white" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.kategori-keterampilan.edit', $kategori->id) }}"
                                            class="btn btn-warning btn-sm" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.kategori-keterampilan.destroy', $kategori->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" title="Hapus"
                                                onclick="return confirm('Yakin hapus data?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td> --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">
                                    <i class="bi bi-inbox"></i>
                                    Data kategori belum ada.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $kategoris->links() }}
            </div>

        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))

<script>
document.addEventListener('DOMContentLoaded', function(){

    Swal.fire({

        icon: 'success',

        title: 'Berhasil Ditambahkan',

        text: '{{ session("success") }}',

        showConfirmButton: false,

        timer: 2200,

        timerProgressBar: true,

        backdrop: true

    });

});
</script>

@endif
@endsection
