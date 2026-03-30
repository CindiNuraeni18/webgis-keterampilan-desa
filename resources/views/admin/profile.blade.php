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

    .info-card,
    .form-card {
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        border: 1px solid var(--border);
        padding: 24px;
        height: 100%;
    }

    .card-title-custom {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 10px;
        line-height: 1.4;
    }

    .profile-photo-wrapper {
        text-align: center;
        margin-bottom: 20px;
    }

    .profile-photo {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #f1f5f9;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.08);
    }

    .profile-photo-placeholder {
        width: 120px;
        height: 120px;
        margin: auto;
        border-radius: 50%;
        background: #e0e7ff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: var(--primary);
        border: 4px solid #f1f5f9;
    }

    .profile-name {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 4px;
        text-align: center;
        word-break: break-word;
    }

    .profile-role {
        text-align: center;
        color: var(--text-muted);
        font-size: 0.92rem;
        margin-bottom: 22px;
        word-break: break-word;
    }

    .info-item {
        margin-bottom: 14px;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 10px;
    }

    .info-item:last-child {
        margin-bottom: 0;
    }

    .info-label {
        font-size: 0.78rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .info-value {
        font-size: 0.96rem;
        font-weight: 600;
        color: var(--text-dark);
        word-break: break-word;
    }

    .form-label {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 12px;
        border: 1px solid var(--border);
        padding: 12px 14px;
        background-color: #fcfcfd;
        min-height: 46px;
        font-size: 0.95rem;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
    }

    input[type="file"].form-control {
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .btn-primary-custom {
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 600;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 46px;
    }

    .btn-primary-custom:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }

    .divider {
        height: 1px;
        background: var(--border);
        margin: 30px 0;
    }

    .password-group {
        position: relative;
    }

    .password-group .form-control {
        padding-right: 46px;
    }

    .toggle-password {
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
        border: none;
        background: transparent;
        color: #64748b;
        cursor: pointer;
        padding: 0;
        width: 24px;
        height: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .toggle-password:focus {
        outline: none;
    }

    /* Tablet */
    @media (max-width: 991.98px) {
        .profile-page {
            padding: 24px 16px;
        }

        .page-title {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .info-card,
        .form-card {
            padding: 20px;
            border-radius: 18px;
        }

        .profile-photo,
        .profile-photo-placeholder {
            width: 105px;
            height: 105px;
        }

        .profile-photo-placeholder {
            font-size: 2.5rem;
        }

        .card-title-custom {
            font-size: 1.05rem;
        }

        .divider {
            margin: 24px 0;
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
            font-size: 1.25rem;
            margin-bottom: 16px;
        }

        .info-card,
        .form-card {
            padding: 16px;
            border-radius: 16px;
        }

        .profile-photo,
        .profile-photo-placeholder {
            width: 90px;
            height: 90px;
        }

        .profile-photo-placeholder {
            font-size: 2rem;
        }

        .profile-name {
            font-size: 1.05rem;
        }

        .profile-role {
            font-size: 0.85rem;
            margin-bottom: 18px;
        }

        .card-title-custom {
            font-size: 1rem;
            align-items: flex-start;
        }

        .info-label {
            font-size: 0.72rem;
        }

        .info-value {
            font-size: 0.9rem;
        }

        .form-label {
            font-size: 0.85rem;
        }

        .form-control {
            font-size: 0.92rem;
            min-height: 44px;
            padding: 11px 12px;
        }

        .divider {
            margin: 20px 0;
        }

        .form-action {
            margin-top: 20px;
        }

        .form-action .btn-primary-custom {
            width: 100%;
        }
    }

    @media (max-width: 575.98px) {
        .row.g-4 {
            --bs-gutter-x: 1rem;
            --bs-gutter-y: 1rem;
        }

        .row.g-3 {
            --bs-gutter-x: 0.75rem;
            --bs-gutter-y: 0.75rem;
        }

        .page-title {
            font-size: 1.15rem;
        }

        .card-title-custom {
            font-size: 0.95rem;
        }
    }
</style>

<main class="profile-page">
    <div class="profile-container">
        <h3 class="page-title">Pengaturan Profil</h3>

        <div class="row g-4 align-items-stretch">
            <div class="col-12 col-lg-4">
                <div class="info-card">
                    <div class="profile-photo-wrapper">
                        @if($user->foto)
                            <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil" class="profile-photo">
                        @else
                            <div class="profile-photo-placeholder">
                                <i class="bi bi-person"></i>
                            </div>
                        @endif
                    </div>

                    <h5 class="profile-name">{{ $user->name }}</h5>
                    <p class="profile-role">{{ $user->jabatan ?? 'Admin Desa' }}</p>

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

                    <div class="info-item border-0 pb-0 mb-0">
                        <div class="info-label">Unit Kerja</div>
                        <div class="info-value">{{ $user->alamat ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-8">
                <div class="form-card">
                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <h5 class="card-title-custom">
                            <i class="bi bi-pencil-square"></i>
                            <span>Ubah Profil</span>
                        </h5>

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">Jabatan</label>
                                <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $user->jabatan) }}">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">No. HP</label>
                                <input type="text" name="nomor" class="form-control" value="{{ old('nomor', $user->nomor) }}">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">Foto Profil</label>
                                <input type="file" name="foto" class="form-control">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Alamat / Unit Kerja</label>
                                <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $user->alamat) }}">
                            </div>
                        </div>

                        <div class="divider"></div>

                        <h5 class="card-title-custom">
                            <i class="bi bi-shield-lock"></i>
                            <span>Keamanan (Isi jika ingin ganti password)</span>
                        </h5>

                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                <label class="form-label">Password Lama</label>
                                <div class="password-group">
                                    <input type="password" name="current_password" id="current_password" class="form-control" placeholder="******">
                                    <button type="button" class="toggle-password" data-target="current_password">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label">Password Baru</label>
                                <div class="password-group">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="******">
                                    <button type="button" class="toggle-password" data-target="password">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label">Konfirmasi Baru</label>
                                <div class="password-group">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="******">
                                    <button type="button" class="toggle-password" data-target="password_confirmation">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-action mt-4 text-md-end text-start">
                            <button type="submit" class="btn btn-primary-custom">
                                <i class="bi bi-save"></i>
                                <span>Simpan Perubahan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success') || session('success_password'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: @json(session('success') ?? session('success_password')),
        showConfirmButton: false,
        timer: 2200,
        timerProgressBar: true,
        customClass: {
            popup: 'rounded-4'
        }
    });
});
</script>
@endif

@if($errors->any())
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'error',
        title: 'Terjadi Kesalahan',
        html: `
            <div style="text-align:center;">
                @foreach($errors->all() as $error)
                    <div style="margin-bottom:8px;">{{ $error }}</div>
                @endforeach
            </div>
        `,
        confirmButtonText: 'Tutup',
        customClass: {
            popup: 'rounded-4'
        }
    });
});
</script>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle-password').forEach(function(button) {
        button.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });
});
</script>

@endsection