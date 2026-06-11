@extends('layouts.sidebar-admin')
@section('title', 'Data Backup')
@section('content')
    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        .btn-save {
            position: relative;
            overflow: hidden;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg,
                    #2563eb,
                    #3b82f6);
            color: white !important;
            font-weight: 600;
            transition: all .35s ease;
            box-shadow:
                0 6px 18px rgba(37, 99, 235, .25);
        }

        /* EFEK PUTIH */
        .btn-save::before {
            content: '';
            position: absolute;
            top: 0;
            left: -75%;
            width: 50%;
            height: 100%;
            background: rgba(255, 255, 255, .22);
            transform: skewX(-25deg);
            transition: .7s;
        }

        /* HOVER */
        .btn-save:hover {
            transform:
                translateY(-2px) scale(1.03);
            box-shadow:
                0 10px 24px rgba(37, 99, 235, .35);
            color: white !important;
        }

        /* GERAK PUTIH */
        .btn-save:hover::before {
            left: 130%;
        }

        /* ICON */
        .btn-save i {
            transition: .3s ease;
        }

        /* ICON HOVER */
        .btn-save:hover i {
            transform: rotate(-10deg);
        }

        /* SAAT DIKLIK */
        .btn-save:active {
            transform: scale(0.97);
            color: white !important;
        }

        /* FOCUS & VISITED */
        .btn-save:focus,
        .btn-save:visited {
            color: white !important;
            outline: none;
            box-shadow:
                0 10px 24px rgba(37, 99, 235, .35) !important;
        }

        /* SPAN TEXT */
        .btn-save span {
            color: white !important;
            position: relative;
            z-index: 2;
        }

        /* ICON Z-INDEX */
        .btn-save i {
            position: relative;
            z-index: 2;
        }

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
        }

        .table {
            margin-bottom: 0;
        }

        .table tbody tr {
            transition: .25s ease;
        }

        .table tbody tr:hover {
            background: rgba(13, 110, 253, .05);
            transform: translateX(3px);
        }

        .sticky-col {
            position: sticky;
            right: 0;
            background: white;
            z-index: 10;
            box-shadow: -3px 0 6px rgba(0, 0, 0, .05);
        }

        thead .sticky-col {
            background: #f8f8f9;
            z-index: 3;
        }

        .btn-download-modern {
            border: none;
            border-radius: 12px;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg,
                    #10b981,
                    #059669);
            color: white;
            transition: .3s;
        }

        .btn-download-modern:hover {
            transform: translateY(-2px);
            color: white;
        }

        .btn-restore-modern {
            border: none;
            border-radius: 12px;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg,
                    #f59e0b,
                    #fbbf24);
            color: white;
            transition: .3s;
        }

        .btn-restore-modern:hover {
            transform: translateY(-2px);
            color: white;
        }

        /* =========================
       PAGINATION MODERN
    ========================= */
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

        /* DOWNLOAD */
        .btn-download-modern {
            box-shadow: 0 4px 10px rgba(16, 185, 129, .20);
        }

        .btn-download-modern i {
            transition: .3s ease;
        }

        .btn-download-modern:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 8px 18px rgba(16, 185, 129, .35);
            color: white;
        }

        .btn-download-modern:hover i {
            transform: translateY(-2px);
        }

        /* RESTORE */
        .btn-restore-modern {
            box-shadow: 0 4px 10px rgba(245, 158, 11, .20);
        }

        .btn-restore-modern i {
            transition: .3s ease;
        }

        .btn-restore-modern:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 8px 18px rgba(245, 158, 11, .35);
            color: white;
        }

        .btn-restore-modern:hover i {
            transform: rotate(-180deg);
        }
    </style>
    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

                <div>

                    <h4 class="mb-1">
                        Data Backup
                    </h4>

                    <p class="text-muted mb-0">
                        Kelola dan unduh file cadangan sistem
                    </p>

                </div>

                <div class="d-flex flex-column align-items-end">

                    <form id="backupForm" action="{{ route('admin.backup.store') }}" method="POST">

                        @csrf

                        <button type="button" id="btnBackup" class="btn btn-save px-4">

                            <i class="bi bi-database-fill-add me-2"></i>

                            Backup Sekarang

                        </button>

                    </form>

                    <span class="badge bg-light text-dark border mt-2">
                        Total Backup :
                        {{ $backups->count() }}
                    </span>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <!-- TABLE -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle text-nowrap">
                        <thead class="table-primary align-middle text-center">
                            <tr>
                                <th width="60">No</th>
                                <th width="350">Nama File</th>
                                <th width="180">Tanggal Backup</th>
                                <th width="180">Tanggal Restore</th>
                                <th width="120" class="sticky-col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($backups as $item)
                                <tr> <!-- NO -->
                                    <td class="text-center fw-semibold text-secondary">
                                        {{ $backups->firstItem() + $loop->index }} </td> <!-- FILE -->
                                    <td>
                                        <div class="d-flex align-items-center gap-2"> <!-- ICON -->
                                            <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2"> <i
                                                    class="bi bi-file-earmark-zip-fill"></i> </div> <!-- FILE INFO -->
                                            <div>
                                                <div class="fw-semibold small"> {{ $item->nama_file }} </div> <small
                                                    class="text-muted"> File cadangan sistem </small>
                                            </div>
                                        </div>
                                    </td> 
                                    <td>
                                        <div class="fw-semibold small">
                                            {{ \Carbon\Carbon::parse($item->created_at)->locale('id')->timezone('Asia/Jakarta')->translatedFormat('d F Y') }}
                                        </div> <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($item->created_at)->locale('id')->timezone('Asia/Jakarta')->format('H:i') }}
                                            WIB </small>
                                    </td>
                                    <td>
                                        @if ($item->last_restored_at)
                                            <div class="fw-semibold small">
                                                {{ \Carbon\Carbon::parse($item->last_restored_at)->locale('id')->timezone('Asia/Jakarta')->translatedFormat('d F Y') }}
                                            </div>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($item->last_restored_at)->locale('id')->timezone('Asia/Jakarta')->format('H:i') }}
                                                WIB
                                            </small>
                                        @else
                                            <span class="text-muted">Belum pernah</span>
                                        @endif
                                    </td>
                                    <!-- ACTION -->
                                    <td class="text-center sticky-col">
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <a href="{{ route('admin.backup.download', $item->id) }}"
                                                class="btn-download-modern">
                                                <i class="bi bi-download"></i>
                                            </a>
                                            <form id="restoreForm{{ $item->id }}"
                                                action="{{ route('admin.backup.restore', $item->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="button" onclick="confirmRestore({{ $item->id }})"
                                                    class="btn-restore-modern">
                                                    <i class="bi bi-arrow-clockwise"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                            </tr> @empty <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center"> <!-- EMPTY ICON -->
                                            <div class="bg-light rounded-circle p-3 mb-3"> <i
                                                    class="bi bi-database-x fs-3 text-secondary"></i> </div>
                                            <!-- EMPTY TEXT -->
                                            <h6 class="fw-semibold mb-1"> Belum Ada Backup </h6>
                                            <p class="text-muted small mb-0"> Silakan lakukan backup data terlebih dahulu
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $backups->links() }}
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.getElementById('btnBackup').addEventListener('click', function() {
                Swal.fire({
                    title: 'Backup Database?',
                    text: 'File SQL akan dibuat dan disimpan ke sistem.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Backup',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Sedang Membuat Backup...',
                            text: 'Mohon tunggu',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        document.getElementById('backupForm').submit();
                    }
                });
            });

            function confirmRestore(id) {
                Swal.fire({
                    title: 'Restore Database?',
                    html: `
            Data saat ini akan diganti dengan isi backup.<br><br>
            <b>Tindakan ini tidak dapat dibatalkan.</b>
        `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Restore',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Sedang Restore...',
                            text: 'Mohon tunggu',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        document.getElementById('restoreForm' + id).submit();
                    }
                });
            }
        </script>
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            </script>
        @endif

        @if (session('success') && !session('backup_file'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Restore Berhasil',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: '{{ session('error') }}'
                });
            </script>
        @endif
    @endsection
