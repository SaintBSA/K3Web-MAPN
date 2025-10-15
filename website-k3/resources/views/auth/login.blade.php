<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pelaporan K3 - MAPN Group</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        /* Gaya Kustom dari HTML Anda */
        body {
            font-family: 'Inter', sans-serif; 
            background-color: #f8f9fa;
        }
        .k3-background {
            /* Pastikan path ke safetybg.jpeg sudah benar */
            background-image: url('{{ asset('') }}'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        .k3-background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(2px);
        }
        .login-container {
            background-color: #ffffff; 
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            max-width: 380px;
            width: 100%;
            position: relative;
            z-index: 10;
        }
        .logo-mapn {
            max-width: 120px;
            height: auto;
            margin-bottom: 25px !important;
        }
        .login-title {
            font-weight: 600;
            color: #343a40;
        }
        /* Input Lebih Besar dan Matang */
        .form-floating input.form-control {
            border-radius: 8px;
            border-color: #ced4da; 
            min-height: calc(3.5rem + 2px); 
            font-size: 1.1rem; 
            padding-top: 1.5rem; 
        }
        .form-floating > label {
            padding: 1rem .75rem;
            font-size: 0.9rem;
        }
        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
             transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
        }
        .btn-primary {
            background-color: #0d6efd; 
            border-color: #0d6efd;
            border-radius: 8px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0b5ed7;
        }
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            z-index: 20;
        }
        .input-group-password {
            position: relative;
        }
        /* Style untuk validasi Laravel */
        .form-floating .is-invalid {
            border-color: #dc3545!important;
        }
        .form-floating .invalid-feedback {
            position: absolute;
            bottom: -20px;
            left: 0;
            width: 100%;
            font-size: 0.875em;
            text-align: left;
        }
    </style>
</head>
<body>

    <div class="k3-background">
        <div class="login-container text-center">
            
            <img src="{{ asset('assets/OIP.jpeg') }}" alt="MAPN Logo" class="logo-mapn mb-4">
            
            <h1 class="h5 mb-2 login-title">Masuk ke Sistem Pelaporan K3</h1>
            <p class="text-muted mb-4">MAPN Group Production Facility</p>

            {{-- INTEGRASI FORM LARAVEL --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-floating mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="floatingInput" 
                           placeholder="name@example.com" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    <label for="floatingInput">Alamat Email Perusahaan</label>
                    
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="input-group-password form-floating mb-4">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="floatingPassword" 
                           placeholder="Kata Sandi" name="password" required autocomplete="current-password">
                    <label for="floatingPassword">Kata Sandi</label>
                    <span class="password-toggle" id="togglePassword">
                        <i class="bi bi-eye-slash"></i> </span>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4 px-2">
                    <div class="form-check text-start">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label small text-muted" for="remember">
                            {{ __('Ingat Saya') }}
                        </label>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button class="btn btn-lg btn-primary" type="submit">
                        Masuk ke Dasbor
                    </button>
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="btn btn-sm btn-link text-decoration-none mt-2 text-muted">Lupa Kata Sandi?</a>
                    @endif
                </div>
            </form>
            {{-- END INTEGRASI FORM LARAVEL --}}
            
            <hr class="my-3"> <p class="mb-3 mt-3 text-muted">
                Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">Daftar Akun Baru</a>
            </p>
            
            <p class="mb-0 text-muted small">&copy; 2024 MAPN Group. Health & Safety System.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#floatingPassword');

        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            const icon = this.querySelector('i');
            if (icon.classList.contains('bi-eye-slash')) {
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye'); 
            } else {
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        });
    </script>
</body>
</html>