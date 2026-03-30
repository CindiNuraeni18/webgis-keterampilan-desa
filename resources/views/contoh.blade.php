@extends('layouts.sidebar-admin')

@section('title', 'Profil Admin')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --primary: #4361ee; /* Warna Biru Modern agar cocok dengan sidebar gelap */
        --primary-dark: #3a56d4;
        --bg-light: #f8fafc;
        --text-dark: #1e293b;
        --text-muted: #64748b;
        --white: #ffffff;
        --border: #e2e8f0;
        --radius: 20px;
        --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
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

    /* Card Styling */
    .info-card, .form-card {
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        border: 1px solid var(--border);
        padding: 24px;
        height: 100%;
    }

    .card-title-custom {
        font-size: 1.15rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Avatar Styling */
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
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
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
    }

    /* Info Items */
    .info-item { margin-bottom: 15px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px; }
    .info-label { font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; }
    .info-value { font-size: 0.95rem; font-weight: 600; color: var(--text-dark); }

    /* Form Styling */
    .form-label { font-weight: 600; font-size: 0.9rem; color: var(--text-dark); }
    .form-control {
        border-radius: 10px;
        border: 1px solid var(--border);
        padding: 10px 15px;
        background-color: #fcfcfd;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
    }

    .btn-primary-custom {
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 12px 24px;
        font-weight: 600;
        transition: 0.3s;
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
</style>

<main class="profile-page">
    <div class="profile-container">
        <h3 class="mb-4 fw-bold">Pengaturan Profil</h3>

        

        <div class="row g-4">
            <div class="col-lg-4">
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

                    <h5 class="text-center fw-bold mb-1">{{ $user->name }}</h5>
                    <p class="text-center text-muted mb-4 small">{{ $user->jabatan ?? 'Admin Desa' }}</p>
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

                    <div class="info-item border-0">
                        <div class="info-label">Unit Kerja</div>
                        <div class="info-value">{{ $user->alamat ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="form-card">
                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <h5 class="card-title-custom"><i class="bi bi-pencil-square me-2"></i>Ubah Profil</h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jabatan</label>
                                <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $user->jabatan) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">No. HP</label>
                                <input type="text" name="nomor" class="form-control" value="{{ old('nomor', $user->nomor) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Foto Profil</label>
                                <input type="file" name="foto" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Alamat / Unit Kerja</label>
                                <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $user->alamat) }}">
                            </div>
                        </div>

                        <div class="divider"></div>

                        <h5 class="card-title-custom"><i class="bi bi-shield-lock"></i> Keamanan (Isi jika ingin ganti password)</h5>
                        
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Password Lama</label>
                                <input type="password" name="current_password" class="form-control" placeholder="******">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password" class="form-control" placeholder="******">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Konfirmasi Baru</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="******">
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary-custom">
                                <i class="bi bi-save me-2"></i>Simpan Perubahan
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
            <div style="text-align:left">
                <ul style="margin:0; padding-left:18px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
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
@endsection