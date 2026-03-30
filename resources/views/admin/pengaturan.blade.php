@extends('layouts.sidebar-admin')

@section('title', 'Pengaturan Akun')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    :root {
        --primary: #4361ee;
        --primary-dark: #3a56d4;
        --primary-soft: rgba(67, 97, 238, 0.08);
        --bg-light: #f8fafc;
        --text-dark: #1e293b;
        --text-muted: #64748b;
        --white: #ffffff;
        --border: #e2e8f0;
        --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .settings-page {
        padding: 2rem 1rem;
        animation: slideUp 0.5s ease-out;
        background: var(--bg-light);
        min-height: 100vh;
    }

    .settings-container {
        max-width: 900px;
        margin: auto;
    }

    .header-box {
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
    }

    .page-subtitle {
        color: var(--text-muted);
        font-size: 0.95rem;
        margin-top: 6px;
    }

    .form-card {
        background: var(--white);
        border-radius: 24px;
        box-shadow: var(--shadow);
        border: 1px solid var(--border);
        padding: 2.5rem;
        margin-bottom: 1.5rem;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .section-header i {
        font-size: 1.25rem;
        color: var(--primary);
        background: var(--primary-soft);
        padding: 10px;
        border-radius: 12px;
    }

    .section-header h5 {
        margin: 0;
        font-weight: 700;
        color: var(--text-dark);
    }

    .form-label {
        font-weight: 600;
        font-size: 0.88rem;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 12px;
        border: 1.5px solid var(--border);
        padding: 12px 16px;
        font-size: 0.95rem;
        background-color: #fcfcfd;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px var(--primary-soft);
        background-color: var(--white);
    }

    .avatar-upload-wrapper {
        display: flex;
        align-items: center;
        gap: 20px;
        background: #f8fafc;
        padding: 15px;
        border-radius: 16px;
        margin-bottom: 10px;
        flex-wrap: wrap;
    }

    #preview-img {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--white);
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .password-group {
        position: relative;
    }

    .password-group .form-control {
        padding-right: 42px;
    }

    .toggle-password {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: none;
        color: var(--text-muted);
        cursor: pointer;
    }

    .btn-submit {
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 14px;
        padding: 14px 30px;
        font-weight: 700;
        width: 100%;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-submit:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(67, 97, 238, 0.25);
    }

    .text-error {
        color: #dc2626;
        font-size: 0.82rem;
        margin-top: 6px;
    }

    @media (max-width: 768px) {
        .form-card { padding: 1.5rem; }
        .page-title { font-size: 1.35rem; }
    }
</style>

<main class="settings-page">
    <div class="settings-container">
        <div class="header-box">
            <h3 class="page-title">Pengaturan Akun</h3>
        </div>

        {{-- FORM 1: UPDATE PROFILE --}}
        <div class="form-card">
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="section-header">
                    <i class="bi bi-person-gear"></i>
                    <h5>Edit Profil</h5>
                </div>

                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label">Foto Profil Baru</label>
                        <div class="avatar-upload-wrapper">
                            <img id="preview-img"
                                 src="{{ $user->foto ? asset('storage/' . $user->foto) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=4361ee&color=fff' }}"
                                 alt="Preview">
                            <input type="file" name="foto" id="foto-input" class="form-control" accept="image/*">
                        </div>
                        @error('foto')
                            <div class="text-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="text-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
                        @error('username')
                            <div class="text-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="text-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $user->jabatan) }}">
                        @error('jabatan')
                            <div class="text-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">No. HP / WhatsApp</label>
                        <input type="text" name="nomor" class="form-control" value="{{ old('nomor', $user->nomor) }}">
                        @error('nomor')
                            <div class="text-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Alamat / Unit Kerja</label>
                        <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $user->alamat) }}">
                        @error('alamat')
                            <div class="text-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-5">
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-cloud-arrow-up-fill"></i>
                        Simpan Profil
                    </button>
                </div>
            </form>
        </div>

        {{-- FORM 2: UPDATE PASSWORD --}}
        <div class="form-card">
            <form action="{{ route('admin.settings.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="section-header">
                    <i class="bi bi-shield-lock"></i>
                    <h5>Keamanan & Password</h5>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-12">
                        <p class="text-muted small mb-0">
                            <i class="bi bi-info-circle me-1"></i>
                            Isi bagian ini hanya jika ingin mengganti password.
                        </p>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Password Saat Ini</label>
                        <div class="password-group">
                            <input type="password" name="current_password" id="current_password" class="form-control" placeholder="••••••••">
                            <button type="button" class="toggle-password" data-target="current_password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <div class="text-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Password Baru</label>
                        <div class="password-group">
                            <input type="password" name="password" id="password" class="form-control" placeholder="••••••••">
                            <button type="button" class="toggle-password" data-target="password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Konfirmasi Password</label>
                        <div class="password-group">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="••••••••">
                            <button type="button" class="toggle-password" data-target="password_confirmation">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-shield-check"></i>
                        Simpan Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fotoInput = document.getElementById('foto-input');
        const previewImg = document.getElementById('preview-img');

        if (fotoInput && previewImg) {
            fotoInput.onchange = evt => {
                const [file] = fotoInput.files;
                if (file) {
                    previewImg.src = URL.createObjectURL(file);
                }
            };
        }

        document.querySelectorAll('.toggle-password').forEach(btn => {
            btn.onclick = function() {
                const input = document.getElementById(this.dataset.target);
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.className = 'bi bi-eye-slash';
                } else {
                    input.type = 'password';
                    icon.className = 'bi bi-eye';
                }
            }
        });

        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false,
            customClass: { popup: 'rounded-4' }
        });z
        @endif

        @if(session('success_password'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success_password') }}',
            timer: 2000,
            showConfirmButton: false,
            customClass: { popup: 'rounded-4' }
        });
        @endif

        @if($errors->any())
let errorMessage = '';

@if($errors->has('current_password'))
    errorMessage = "{{ $errors->first('current_password') }}";
@elseif($errors->has('password'))
    errorMessage = "{{ $errors->first('password') }}";
@elseif($errors->has('password_confirmation'))
    errorMessage = "{{ $errors->first('password_confirmation') }}";
@else
    errorMessage = "{{ $errors->first() }}";
@endif

Swal.fire({
    icon: 'error',
    title: 'Gagal Simpan',
    text: errorMessage,
    customClass: { popup: 'rounded-4' }
});
@endif
    });
</script>

@endsection