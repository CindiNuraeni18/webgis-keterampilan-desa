@extends('layouts.sidebar-admin')
@section('title', 'Data Backup')

@section('content')

<div class="container-fluid">

    <!-- HEADER -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-start mb-4 gap-3">

        <!-- TITLE -->
        <div>
            <h4 class="fw-semibold mb-1">
                Data Backup Sistem
            </h4>

            <p class="text-muted mb-0 small">
                Kelola dan unduh file cadangan data sistem
            </p>
        </div>

        <!-- ACTION -->
        <div class="text-md-end">

            <!-- BUTTON -->
            <form action="{{ route('admin.backup.store') }}" method="POST">
                @csrf

                <button class="btn btn-primary btn-sm shadow-sm px-3 py-2 rounded-3">
                    <i class="bi bi-database-fill-add me-1"></i>
                    Backup Sekarang
                </button>
            </form>

            <!-- TOTAL -->
            <div class="mt-2">
                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill small">
                    Total Backup: {{ $backups->count() }}
                </span>
            </div>

        </div>

    </div>

    <!-- CARD -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">

        <!-- TABLE -->
        <div class="table-responsive">

            <table class="table table-sm align-middle mb-0">

                <thead class="table-light">

                    <tr>
                        <th class="ps-4">No</th>
                        <th class="text-center">Nama File</th>
                        <th>Tanggal Backup</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($backups as $item)

                        <tr>

                            <!-- NO -->
                            <td class="ps-4 fw-semibold text-secondary">
                                {{ $loop->iteration }}
                            </td>

                            <!-- FILE -->
                            <td>

                                <div class="d-flex align-items-center gap-2">

                                    <!-- ICON -->
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2">
                                        <i class="bi bi-file-earmark-zip-fill"></i>
                                    </div>

                                    <!-- FILE INFO -->
                                    <div>

                                        <div class="fw-semibold small">
                                            {{ $item->nama_file }}
                                        </div>

                                        <small class="text-muted">
                                            File cadangan sistem
                                        </small>

                                    </div>

                                </div>

                            </td>

                            <!-- DATE -->
                            <td>

                                <div class="fw-semibold small">
                                    {{ \Carbon\Carbon::parse($item->created_at)
                                        ->locale('id')
                                        ->timezone('Asia/Jakarta')
                                        ->translatedFormat('d F Y') }}
                                </div>

                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($item->created_at)
                                        ->locale('id')
                                        ->timezone('Asia/Jakarta')
                                        ->format('H:i') }}
                                    WIB
                                </small>

                            </td>

                            <!-- STATUS -->
                            <td>

                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill small">
                                    Backup Tersimpan
                                </span>

                            </td>

                            <!-- ACTION -->
                            <td class="text-center">

                                <a href="{{ route('admin.backup.download', $item->id) }}"
                                   class="btn btn-success btn-sm rounded-3 px-2">

                                    <i class="bi bi-download me-1"></i>
                                    Download

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="text-center py-5">

                                <div class="d-flex flex-column align-items-center">

                                    <!-- EMPTY ICON -->
                                    <div class="bg-light rounded-circle p-3 mb-3">
                                        <i class="bi bi-database-x fs-3 text-secondary"></i>
                                    </div>

                                    <!-- EMPTY TEXT -->
                                    <h6 class="fw-semibold mb-1">
                                        Belum Ada Backup
                                    </h6>

                                    <p class="text-muted small mb-0">
                                        Silakan lakukan backup data terlebih dahulu
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection