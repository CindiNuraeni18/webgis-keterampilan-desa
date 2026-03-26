<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Login') }}</title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>
        :root {
            --primary: #2f855a;
            --primary-dark: #276749;
            --secondary: #68d391;
            --text-dark: #1f2937;
            --text-muted: #6b7280;
            --white: #ffffff;
            --border: #dbe7df;
            --shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
            --radius: 24px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            color: var(--text-dark);
            background:
                radial-gradient(circle at top left, rgba(104, 211, 145, 0.18), transparent 30%),
                radial-gradient(circle at bottom right, rgba(47, 133, 90, 0.15), transparent 25%),
                linear-gradient(135deg, #eefaf1, #f8fcf9);
        }

        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            position: relative;
            overflow: hidden;
        }

        .login-page::before,
        .login-page::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            z-index: 0;
            filter: blur(12px);
        }

        .login-page::before {
            width: 320px;
            height: 320px;
            background: rgba(104, 211, 145, 0.22);
            top: -100px;
            left: -100px;
        }

        .login-page::after {
            width: 360px;
            height: 360px;
            background: rgba(47, 133, 90, 0.14);
            bottom: -120px;
            right: -120px;
        }

        .login-container {
            width: 100%;
            max-width: 520px;
            position: relative;
            z-index: 1;
        }

        .login-card {
            position: relative;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.75);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            animation: fadeUp 0.45s ease;
        }

        /* Tombol close pojok kanan */
        .close-login {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f3f4f6;
            color: #4b5563;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            transition: all 0.25s ease;
            z-index: 10;
            border: 1px solid #e5e7eb;
        }

        .close-login:hover {
            background: #ef4444;
            color: #ffffff;
            transform: rotate(90deg);
        }

        .login-header {
            text-align: center;
            padding: 42px 32px 20px;
        }

        .login-title {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 8px;
            color: var(--text-dark);
        }

        .login-title i {
            margin-right: 8px;
            color: var(--primary);
        }

        .login-body {
            padding: 10px 32px 32px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.95rem;
            color: #374151;
            margin-bottom: 8px;
        }

        .input-group-custom {
            position: relative;
        }

        .input-group-custom .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1rem;
            z-index: 2;
        }

        .form-control {
            height: 54px;
            border-radius: 14px;
            border: 1px solid var(--border);
            padding-left: 46px;
            font-size: 0.96rem;
            box-shadow: none !important;
            transition: all 0.25s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.22rem rgba(47, 133, 90, 0.13) !important;
        }

        .form-check-input {
            border-radius: 6px;
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .form-check-label {
            color: var(--text-muted);
            font-size: 0.94rem;
        }

        .invalid-feedback {
            display: block;
            font-size: 0.88rem;
            margin-top: 8px;
        }

        .btn-login {
            height: 54px;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--primary), #38a169);
            color: white;
            font-weight: 700;
            font-size: 1rem;
            width: 100%;
            box-shadow: 0 14px 24px rgba(47, 133, 90, 0.22);
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            color: white;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .bottom-note {
            margin-top: 22px;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.92rem;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(18px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 575.98px) {
            .login-header {
                padding: 40px 22px 16px;
            }

            .login-body {
                padding: 8px 22px 24px;
            }

            .login-title {
                font-size: 1.7rem;
            }

            .close-login {
                width: 36px;
                height: 36px;
                top: 14px;
                right: 14px;
            }
        }
    </style>
</head>
<body>

    <!-- Wrapper halaman login -->
    <main class="login-page">
        <div class="login-container">
            <div class="login-card">

                <!-- Tombol X kembali ke welcome -->
                <a href="{{ url('/') }}" class="close-login" title="Kembali ke halaman utama">
                    <i class="bi bi-x-lg"></i>
                </a>

                <!-- Header card -->
                <div class="login-header">
                    <h2 class="login-title">
                        <i class="bi bi-person-lock"></i>{{ __('Login') }}
                    </h2>
                </div>

                <!-- Body card -->
                <div class="login-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                {{ __('Email Address') }}
                            </label>
                            <div class="input-group-custom">
                                <i class="bi bi-envelope input-icon"></i>
                                <input
                                    id="email"
                                    type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email"
                                    autofocus
                                    placeholder="Masukkan email Anda"
                                >
                            </div>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                {{ __('Password') }}
                            </label>
                            <div class="input-group-custom">
                                <i class="bi bi-lock input-icon"></i>
                                <input
                                    id="password"
                                    type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="Masukkan password Anda"
                                >
                            </div>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Remember me -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="remember"
                                    id="remember"
                                    {{ old('remember') ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>

                        <!-- Tombol login -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-login">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                {{ __('Login') }}
                            </button>
                        </div>
                    </form>

                    <!-- Catatan bawah -->
                    <div class="bottom-note">
                        <span>*Akses hanya untuk Perangkat Desa.*</span>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>