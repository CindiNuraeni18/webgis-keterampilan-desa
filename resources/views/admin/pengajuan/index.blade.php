@extends('layouts.sidebar-admin')

@section('title', 'Pengajuan Keterampilan')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        /* ==================================================== */
        /* ANIMASI GLOBAL & LAYOUT (DIADOPSI DARI KETERAMPILAN) */
        /* ==================================================== */
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

        /* Card & Table Customization */
        .card {
            border-radius: 12px;
            transition: 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        /* PERBAIKAN SCROLLBAR DI LUAR TABEL */
        .table-outer-wrapper {
            overflow-x: auto;
            width: 100%;
            -webkit-overflow-scrolling: touch;
        }

        .table-responsive-custom {
            display: block;
            width: 100%;
            animation: slideInUp var(--anim-speed) var(--anim-ease);
        }

        .table {
            margin-bottom: 0;
            width: 100%;
        }

        .table tbody tr {
            animation: fadeIn var(--anim-speed) var(--anim-ease);
            animation-fill-mode: both;
            transition: 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.05) !important;
            transform: translateX(3px);
        }

        /* STICKY AKSI WARNA PUTIH */
        .sticky-col {
            position: sticky;
            right: 0;
            background: #ffffff !important;
            z-index: 5;
        }

        thead .sticky-col {
            position: sticky;
            right: 0;
            top: 0;
            background: #ffffff !important;
            color: #212529 !important;
            z-index: 6;
        }

        /* Efek bayangan halus pemisah kolom sticky */
        .sticky-col::before {
            content: "";
            position: absolute;
            top: 0;
            left: -5px;
            width: 5px;
            height: 100%;
            background: linear-gradient(to left, rgba(0, 0, 0, 0.05), rgba(0, 0, 0, 0));
            pointer-events: none;
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

        /* Header Animation */
        .title-animate {
            animation: slideFadeLeft var(--anim-speed) var(--anim-ease);
        }

        .badge-animate {
            animation: zoomFade calc(var(--anim-speed) + 0.1s) var(--anim-ease);
        }

        @media (max-width: 768px) {
            .table {
                font-size: 12px;
                white-space: nowrap;
            }
        }

        /* ==================================================== */
        /* PREMIUM FIX MODAL & TEXT DISPLAY                    */
        /* ==================================================== */
        .modal {
            z-index: 99999 !important;
        }

        .modal-backdrop {
            z-index: 99998 !important;
        }

        .modal-content-premium {
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12) !important;
            overflow: hidden;
        }

        .info-detail-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px;
            height: 100%;
        }

        .info-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .info-value {
            color: #1e293b;
            font-weight: 550;
            font-size: 0.925rem;
        }

        .message-display-box {
            background-color: #f1f5f9;
            border-left: 4px solid #0d6efd;
            border-radius: 4px 12px 12px 4px;
            padding: 16px;
            font-size: 0.95rem;
            color: #334155;
            line-height: 1.6;
        }

        .reject-display-box {
            background-color: #fef2f2;
            border-left: 4px solid #dc3545;
            border-radius: 4px 12px 12px 4px;
            padding: 16px;
            font-size: 0.95rem;
            color: #991b1b;
            line-height: 1.6;
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

        /* DETAIL */
        .btn-detail-modern {
            border: none;
            border-radius: 12px;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg,
                    #0ea5e9,
                    #38bdf8);
            color: white;
            transition: .3s ease;
            box-shadow: 0 4px 10px rgba(14, 165, 233, .2);
        }

        .btn-detail-modern:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 8px 18px rgba(14, 165, 233, .35);
            color: white;
        }

        /* SETUJUI */
        .btn-approve-modern {
            border: none;
            border-radius: 12px;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg,
                    #22c55e,
                    #16a34a);
            color: white;
            transition: .3s ease;
            box-shadow: 0 4px 10px rgba(34, 197, 94, .2);
        }

        .btn-approve-modern:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 8px 18px rgba(34, 197, 94, .35);
            color: white;
        }

        /* TOLAK */
        .btn-delete-modern {
            border: none;
            border-radius: 12px;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg,
                    #ef4444,
                    #dc2626);
            color: white;
            transition: .3s ease;
            box-shadow: 0 4px 10px rgba(239, 68, 68, .2);
        }

        .btn-delete-modern:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 8px 18px rgba(239, 68, 68, .35);
            color: white;
        }

        /* ANIMASI ICON DETAIL */
        .btn-detail-modern i {
            transition: .3s ease;
        }

        .btn-detail-modern:hover i {
            transform: scale(1.12);
        }

        /* ANIMASI ICON SETUJUI */
        .btn-approve-modern i {
            transition: .3s ease;
        }

        .btn-approve-modern:hover i {
            transform: rotate(-10deg);
        }

        /* ANIMASI ICON TOLAK */
        .btn-delete-modern i {
            transition: .3s ease;
        }

        .btn-delete-modern:hover i {
            transform: scale(1.12);
        }
    </style>

    <div class="card border-0 shadow-sm fade-in">
        <div class="card-body">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                <div>
                    <h4 class="mb-1 title-animate">Pengajuan Keterampilan</h4>
                    <p class="text-muted title-animate mb-0">Daftar pengajuan keterampilan dari masyarakat desa.</p>
                </div>
                <div class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                    Total: {{ $pesans->count() }} Pesan
                </div>
            </div>

            <div class="table-outer-wrapper">
                <div class="table-responsive-custom">
                    <table class="table table-bordered table-striped table-hover align-middle text-nowrap">
                        <thead class="table-primary text-center">
                            <tr>
                                <th width="60">No</th>
                                <th>Nama</th>
                                <th>Wilayah</th>
                                <th>Kategori</th>
                                <th>Keterampilan</th>
                                <th>Status</th>
                                <th width="180" class="sticky-col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pesans as $item)
                                <tr style="animation-delay: {{ $loop->index * 0.05 }}s">
                                    <td class="text-center fw-semibold">{{ $pesans->firstItem() + $loop->index }}</td>
                                    <td class="fw-semibold text-dark">{{ $item->nama }}</td>
                                    <td>
                                        <div>{{ $item->dusun }}</div>
                                        <small class="text-muted text-xs">RT
                                            {{ $item->rt ?? '-' }} / RW {{ $item->rw ?? '-' }}</small>
                                    </td>
                                    <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                                    <td>{{ $item->keterampilan ?? '-' }}</td>
                                    <td class="text-center">
                                        @if ($item->status == 'Disetujui')
                                            <span class="badge bg-success px-2.5 py-1.5 rounded-pill small">Disetujui</span>
                                        @elseif($item->status == 'Ditolak')
                                            <span class="badge bg-danger px-2.5 py-1.5 rounded-pill small">Ditolak</span>
                                        @else
                                            <span
                                                class="badge bg-warning text-dark px-2.5 py-1.5 rounded-pill small">Menunggu</span>
                                        @endif
                                    </td>
                                    <td class="text-center sticky-col">
                                        <div class="d-flex justify-content-center gap-2">

                                            <!-- DETAIL -->
                                            <button class="btn-detail-modern" data-bs-toggle="modal"
                                                data-bs-target="#detailModal{{ $item->id }}" title="Detail">

                                                <i class="bi bi-eye-fill"></i>

                                            </button>

                                            @if ($item->status == 'Menunggu')
                                                <!-- SETUJUI -->
                                                <form action="{{ route('admin.pesan.setujui', $item->id) }}" method="POST"
                                                    class="d-inline">

                                                    @csrf
                                                    @method('PUT')

                                                    <button class="btn-approve-modern" title="Setujui">

                                                        <i class="bi bi-check-lg"></i>

                                                    </button>

                                                </form>

                                                <!-- TOLAK -->
                                                <button class="btn-delete-modern" data-bs-toggle="modal"
                                                    data-bs-target="#tolakModal{{ $item->id }}" title="Tolak">

                                                    <i class="bi bi-x-lg"></i>

                                                </button>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox me-1"></i> Belum ada data pesan masyarakat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="mt-3">{{ $pesans->links() }}</div>
        </div>
    </div>

    @foreach ($pesans as $item)
        <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content modal-content-premium">
                    <div
                        class="modal-header bg-white border-0 pt-4 px-4 pb-2 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary-subtle p-2.5 rounded-3 text-primary d-inline-flex">
                                <i class="bi bi-envelope-open-fill fs-5"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-0">Detail Pengajuan</h5>
                                <span class="text-muted small">Informasi berkas pengajuan masuk masyarakat</span>
                            </div>
                        </div>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body px-4 pt-3 pb-4">
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="info-detail-card">
                                    <div class="info-label">Nama Lengkap</div>
                                    <div class="info-value text-primary fw-bold">{{ $item->nama }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-detail-card">
                                    <div class="info-label">NIK</div>
                                    <div class="info-value">{{ $item->nik }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-detail-card">
                                    <div class="info-label">Nomor WhatsApp</div>
                                    <div class="info-value">
                                        <a href="https://wa.me/{{ $item->nomor_hp }}" target="_blank"
                                            class="text-decoration-none">
                                            {{ $item->nomor_hp }} <i class="bi bi-box-arrow-up-right small ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-detail-card">
                                    <div class="info-label">Kategori</div>
                                    <div class="info-value">
                                        {{ $item->kategori->nama_kategori ?? '-' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-detail-card">
                                    <div class="info-label">Keterampilan</div>
                                    <div class="info-value"><span
                                            class="badge bg-dark-subtle text-dark px-2 py-1">{{ $item->keterampilan ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="info-detail-card">
                                    <div class="info-label">Cakupan Wilayah Tempat Tinggal</div>
                                    <div class="info-value">Dusun {{ $item->dusun }}, RW {{ $item->rw ?? '-' }}, RT
                                        {{ $item->rt ?? '-' }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex align-items-center gap-2 mb-2 px-1">
                                <i class="bi bi-chat-left-text text-secondary small"></i>
                                <span class="text-uppercase fw-bold text-secondary"
                                    style="font-size:0.75rem; letter-spacing: 0.5px;">Isi Pesan / Lampiran Aduan</span>
                            </div>
                            <div class="message-display-box fw-medium">
                                {!! nl2br(e($item->pesan)) !!}
                            </div>
                        </div>

                        @if ($item->status == 'Ditolak')
                            <div class="mt-3">
                                <div class="d-flex align-items-center gap-2 mb-2 px-1">
                                    <i class="bi bi-exclamation-triangle text-danger small"></i>
                                    <span class="text-uppercase fw-bold text-danger"
                                        style="font-size:0.75rem; letter-spacing: 0.5px;">Alasan Penolakan Tim Admin</span>
                                </div>
                                <div class="reject-display-box">
                                    {{ $item->alasan_penolakan }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tolakModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content modal-content-premium">
                    <form action="{{ route('admin.pesan.tolak', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header border-0 pt-4 px-4 pb-2">
                            <h5 class="fw-bold text-danger mb-0"><i class="bi bi-x-circle-fill me-2"></i>Tolak Pengajuan
                            </h5>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body px-4 py-3">
                            <div class="mb-2">
                                <label class="form-label text-secondary fw-semibold small">Berikan Alasan Penolakan Yang
                                    Jelas:</label>
                                <textarea name="alasan_penolakan" class="form-control border-secondary-subtle rounded-3 p-3" rows="4"
                                    placeholder="Masukkan alasan penolakan berkas..." required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer border-0 px-4 pb-4 pt-2 d-flex gap-2 justify-content-end">
                            <button type="button" class="btn btn-light rounded-pill px-4 fw-medium"
                                data-bs-dismiss="modal">Batal</button>
                            <button class="btn btn-danger rounded-pill px-4 fw-semibold">Konfirmasi Tolak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

@endsection
