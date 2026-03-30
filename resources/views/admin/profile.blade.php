@extends('layouts.sidebar-admin')

@section('title', 'Profil Admin')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --primary: #4361ee;
        --primary-dark: #3a56d4;
        --bg-light: #f8fafc;
        --text-dark: #1e293b;
        --text-muted: #64748b;
        --white: #ffffff;
        --border: #e2e8f0;
        --radius: 20px;
        --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
    }

    body {
        margin: 0;
        font-family: "Inter", sans-serif;
        background: var(--bg-light);
        color: var(--text-dark);
    }

    .profile-page {
        padding: 30px 20px;
    }

    .profile-container {
        max-width: 1200px;
        margin: auto;
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 24px;
        line-height: 1.3;
    }

    .profile-card {
        background: var(--white);
        border-radius: 24px;
        box-shadow: var(--shadow);
        border: 1px solid var(--border);
        overflow: hidden;
    }

    .profile-layout {
        display: grid;
        grid-template-columns: 320px 1fr;
        min-height: 100%;
    }

    .profile-left {
        background: linear-gradient(180deg, #f8fbff 0%, #eef4ff 100%);
        border-right: 1px solid var(--border);
        padding: 32px 24px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .profile-photo-link {
        display: inline-block;
        text-decoration: none;
    }

    .profile-photo {
        width: 170px;
        height: 170px;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid #ffffff;
        box-shadow: 0 12px 24px rgba(67, 97, 238, 0.18);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        cursor: zoom-in;
    }

    .profile-photo:hover {
        transform: scale(1.03);
        box-shadow: 0 16px 32px rgba(67, 97, 238, 0.24);
    }

    .profile-photo-placeholder {
        width: 170px;
        height: 170px;
        border-radius: 50%;
        background: #dbe7ff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        color: var(--primary);
        border: 5px solid #ffffff;
        box-shadow: 0 12px 24px rgba(67, 97, 238, 0.12);
    }

    .profile-name {
        font-size: 1.35rem;
        font-weight: 700;
        margin-top: 18px;
        margin-bottom: 6px;
        text-align: center;
        word-break: break-word;
    }

    .profile-role {
        text-align: center;
        color: var(--text-muted);
        font-size: 0.95rem;
        margin-bottom: 10px;
        word-break: break-word;
    }

    .profile-hint {
        font-size: 0.82rem;
        color: var(--text-muted);
        text-align: center;
        margin-top: 8px;
    }

    .profile-right {
        padding: 32px;
    }

    .card-title-custom {
        font-size: 1.15rem;
        font-weight: 700;
        margin-bottom: 22px;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 10px;
        line-height: 1.4;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .info-item {
        background: #f8fafc;
        border: 1px solid #edf2f7;
        border-radius: 16px;
        padding: 16px 18px;
        min-height: 92px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .info-item.full-width {
        grid-column: 1 / -1;
    }

    .info-label {
        font-size: 0.78rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .info-value {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-dark);
        word-break: break-word;
        line-height: 1.5;
    }

    .image-modal .modal-content {
        background: transparent;
        border: none;
        box-shadow: none;
    }

    .image-modal .modal-body {
        text-align: center;
        padding: 0;
    }

    .image-modal img {
        max-width: 100%;
        max-height: 80vh;
        border-radius: 20px;
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.25);
    }

    .image-modal .btn-close {
        background-color: #fff;
        border-radius: 50%;
        opacity: 1;
        position: absolute;
        top: 14px;
        right: 14px;
        z-index: 10;
        padding: 10px;
    }

    /* Tablet */
    @media (max-width: 991.98px) {
        .profile-page {
            padding: 24px 16px;
        }

        .page-title {
            font-size: 1.45rem;
            margin-bottom: 20px;
        }

        .profile-layout {
            grid-template-columns: 260px 1fr;
        }

        .profile-left {
            padding: 24px 18px;
        }

        .profile-right {
            padding: 24px;
        }

        .profile-photo,
        .profile-photo-placeholder {
            width: 140px;
            height: 140px;
        }

        .profile-photo-placeholder {
            font-size: 3.2rem;
        }

        .info-grid {
            gap: 14px;
        }
    }

    /* Mobile */
    @media (max-width: 767.98px) {
        .profile-page {
            padding: 18px 12px;
        }

        .profile-container {
            max-width: 100%;
        }

        .page-title {
            font-size: 1.2rem;
            margin-bottom: 16px;
        }

        .profile-card {
            border-radius: 18px;
        }

        .profile-layout {
            grid-template-columns: 1fr;
        }

        .profile-left {
            border-right: none;
            border-bottom: 1px solid var(--border);
            padding: 24px 16px 20px;
        }

        .profile-right {
            padding: 18px 16px;
        }

        .profile-photo,
        .profile-photo-placeholder {
            width: 115px;
            height: 115px;
        }

        .profile-photo-placeholder {
            font-size: 2.6rem;
        }

        .profile-name {
            font-size: 1.1rem;
            margin-top: 14px;
        }

        .profile-role {
            font-size: 0.88rem;
            margin-bottom: 6px;
        }

        .profile-hint {
            font-size: 0.76rem;
        }

        .card-title-custom {
            font-size: 1rem;
            margin-bottom: 16px;
        }

        .info-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .info-item,
        .info-item.full-width {
            grid-column: auto;
            min-height: auto;
            padding: 14px 15px;
            border-radius: 14px;
        }

        .info-label {
            font-size: 0.72rem;
        }

        .info-value {
            font-size: 0.93rem;
        }
    }

    @media (max-width: 575.98px) {
        .page-title {
            font-size: 1.1rem;
        }

        .profile-left {
            padding: 20px 14px 18px;
        }

        .profile-right {
            padding: 16px 14px;
        }

        .profile-photo,
        .profile-photo-placeholder {
            width: 100px;
            height: 100px;
        }

        .profile-photo-placeholder {
            font-size: 2.2rem;
        }
    }
</style>

<main class="profile-page">
    <div class="profile-container">
        <h3 class="page-title">Informasi Profil</h3>

        <div class="profile-card">
            <div class="profile-layout">
                <div class="profile-left">
                    @if($user->foto)
                        <a href="{{ asset('storage/' . $user->foto) }}"
                           class="profile-photo-link"
                           data-bs-toggle="modal"
                           data-bs-target="#fotoProfilModal">
                            <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil" class="profile-photo">
                        </a>
                        <div class="profile-hint">Klik foto untuk melihat ukuran penuh</div>
                    @else
                        <div class="profile-photo-placeholder">
                            <i class="bi bi-person"></i>
                        </div>
                    @endif

                    <h5 class="profile-name">{{ $user->name }}</h5>
                    <p class="profile-role">{{ $user->jabatan ?? 'Admin Desa' }}</p>
                </div>

                <div class="profile-right">
                    <h5 class="card-title-custom">
                        <i class="bi bi-person-vcard"></i>
                        <span>Detail Informasi</span>
                    </h5>

                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Nama Lengkap</div>
                            <div class="info-value">{{ $user->name }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Username</div>
                            <div class="info-value">{{ $user->username }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Email</div>
                            <div class="info-value">{{ $user->email }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">No. HP</div>
                            <div class="info-value">{{ $user->nomor ?? '-' }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Jabatan</div>
                            <div class="info-value">{{ $user->jabatan ?? '-' }}</div>
                        </div>

                        <div class="info-item full-width">
                            <div class="info-label">Unit Kerja</div>
                            <div class="info-value">{{ $user->alamat ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@if($user->foto)
<div class="modal fade image-modal" id="fotoProfilModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content position-relative">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil Besar">
            </div>
        </div>
    </div>
</div>
@endif

@endsection