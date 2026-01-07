<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Sistem Manajemen Imunisasi">
    <meta name="author" content="Lyan Imun">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - Lyan Imun</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- core:css -->
    <link rel="stylesheet" href="{{ asset('vendors/core/core.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/demo1/style.css') }}">

    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />

    <style>
        .auth-page {
            max-height: 100vh;
        }

        .login-container {
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .left-side {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            color: white;
        }

        .left-side-content {
            text-align: center;
            max-width: 400px;
        }

        .left-side h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: white;
        }

        .left-side p {
            font-size: 1rem;
            margin-bottom: 2rem;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.6;
        }

        .immunization-image {
            width: 50%;
            max-width: 150px;
            margin: 0 auto 2rem;
            filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.2));
        }

        .feature-list {
            text-align: left;
            margin-top: 2rem;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .feature-item i {
            color: #4ade80;
            margin-right: 10px;
            font-size: 20px;
        }

        .right-side {
            background: white;
            padding: 60px 40px;
        }

        .login-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            color: #6c757d;
            margin-bottom: 2rem;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 30px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .captcha-box {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: #495057;
            font-family: 'Courier New', monospace;
            min-width: 150px;
        }

        .btn-refresh-captcha {
            background: #667eea;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-refresh-captcha:hover {
            background: #5568d3;
        }

        @media (max-width: 768px) {
            .left-side {
                display: none;
            }

            .right-side {
                padding: 40px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="main-wrapper">
        <div class="page-wrapper full-page">
            <div class="page-content d-flex align-items-center justify-content-center">
                <div class="row w-100 mx-0 auth-page">
                    <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                        <div class="card login-container">
                            <div class="row g-0">
                                <!-- Left Side - Image & Info -->
                                <div class="col-md-5 left-side">
                                    <div class="left-side-content">
                                        <img src="{{ asset('images/immunization.svg') }}"
                                             alt="Immunization"
                                             class="immunization-image"
                                             onerror="this.style.display='none'">

                                        <h1>Sistem Manajemen Imunisasi</h1>
                                        <p>Kelola data imunisasi dengan mudah, cepat, dan terorganisir</p>

                                        <div class="feature-list">
                                            <div class="feature-item">
                                                <i data-feather="check-circle"></i>
                                                <span><strong>IDL & IBL</strong> - Imunisasi Dasar Lengkap</span>
                                            </div>
                                            <div class="feature-item">
                                                <i data-feather="check-circle"></i>
                                                <span><strong>TT WUS</strong> - Tetanus Toxoid</span>
                                            </div>
                                            <div class="feature-item">
                                                <i data-feather="check-circle"></i>
                                                <span><strong>BIAS</strong> - Imunisasi Anak Sekolah</span>
                                            </div>
                                            <div class="feature-item">
                                                <i data-feather="check-circle"></i>
                                                <span><strong>Laporan</strong> - Rekapitulasi Lengkap</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Side - Login Form -->
                                <div class="col-md-7 right-side">
                                    <div class="auth-form-wrapper">
                                        <h2 class="login-title">Selamat Datang!</h2>
                                        <p class="login-subtitle">Silakan login untuk melanjutkan</p>

                                        @if (session('error'))
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <i data-feather="alert-circle"></i>
                                                {{ session('error') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif

                                        @if (session('status'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i data-feather="check-circle"></i>
                                                {{ session('status') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif

                                        <form class="forms-sample" method="POST" action="{{ route('login') }}">
                                            @csrf

                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email"
                                                       value="{{ old('email') }}"
                                                       class="form-control @error('email') is-invalid @enderror"
                                                       id="email"
                                                       name="email"
                                                       placeholder="nama@email.com"
                                                       autofocus
                                                       required>
                                                @error('email')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password"
                                                       class="form-control @error('password') is-invalid @enderror"
                                                       id="password"
                                                       name="password"
                                                       autocomplete="current-password"
                                                       placeholder="••••••••"
                                                       required>
                                                @error('password')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="captcha" class="form-label">Captcha</label>
                                                <div class="d-flex align-items-center gap-2 mb-2">
                                                    <div class="captcha-box" id="captcha-question">Loading...</div>
                                                    <button type="button"
                                                            class="btn-refresh-captcha"
                                                            onclick="refreshCaptcha()"
                                                            title="Refresh Captcha">
                                                        <i data-feather="refresh-cw"></i>
                                                    </button>
                                                </div>
                                                <input type="number"
                                                       id="captcha"
                                                       name="captcha"
                                                       class="form-control @error('captcha') is-invalid @enderror"
                                                       placeholder="Masukkan hasil perhitungan"
                                                       required>
                                                @error('captcha')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="mb-3 form-check">
                                                <input type="checkbox"
                                                       class="form-check-input"
                                                       id="remember"
                                                       name="remember">
                                                <label class="form-check-label" for="remember">
                                                    Ingat saya
                                                </label>
                                            </div>

                                            <div>
                                                <button type="submit" class="btn btn-login text-white w-100">
                                                    <i data-feather="log-in" class="me-2"></i>
                                                    Login
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- core:js -->
    <script src="{{ asset('vendors/core/core.js') }}"></script>
    <script src="{{ asset('vendors/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>

    <script>
        // Initialize Feather Icons
        feather.replace();

        // Load captcha on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadCaptcha();
        });

        function loadCaptcha() {
            fetch('{{ url("simple-captcha") }}', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                credentials: 'same-origin'
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('captcha-question').textContent = data.question;
                })
                .catch(error => {
                    console.error('Error loading captcha:', error);
                    document.getElementById('captcha-question').textContent = 'Error';
                });
        }

        function refreshCaptcha() {
            document.getElementById('captcha-question').textContent = 'Loading...';
            document.getElementById('captcha').value = '';
            loadCaptcha();
            feather.replace();
        }
    </script>
</body>

</html>
