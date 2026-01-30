<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name', 'LPPM-PM ITH') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=plus-jakarta-sans:300,400,500,600,700&display=swap"
    integrity="sha384-fiLs8UJYB2M0rcpygECa8F4nHa+r7kwKemBvVat/MJ3Ln1UTGbrO4ysElpxmwhjK" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha384-iw3OoTErCYJJB9mCa8LNS2hbsQ7M3C0EpIsO/H5+EGAkPGc6rk+V8i04oW/K5xq0" crossorigin="anonymous">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-dark: #4338ca;
            --secondary-color: #ec4899;
            --dark-bg: #0f172a;
            --light-bg: #f8fafc;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--light-bg);
            overflow-x: hidden;
        }
        
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            width: 100%;
        }
        
        /* Left Side - Visual */
        .login-visual {
            flex: 1.2;
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 4rem;
            overflow: hidden;
            color: white;
        }

        /* Abstract Shapes */
        .shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            animation: float 10s infinite ease-in-out;
        }

        .shape-1 {
            width: 400px;
            height: 400px;
            background: #ec4899;
            top: -100px;
            right: -100px;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 300px;
            height: 300px;
            background: #4f46e5;
            bottom: -50px;
            left: -50px;
            animation-delay: -5s;
        }

        .visual-content {
            position: relative;
            z-index: 10;
            text-align: center;
            max-width: 500px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            padding: 3rem;
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            transform: translateY(20px);
            opacity: 0;
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .visual-logo {
            width: 100px;
            height: auto;
            margin-bottom: 2rem;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
        }

        .visual-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .visual-text {
            font-size: 1.1rem;
            opacity: 0.9;
            line-height: 1.6;
            font-weight: 300;
        }

        /* Right Side - Form */
        .login-form-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: white;
            position: relative;
        }

        .form-container {
            width: 100%;
            max-width: 420px;
            padding: 2rem;
            transform: translateX(20px);
            opacity: 0;
            animation: fadeInRight 0.8s ease-out 0.2s forwards;
        }

        .form-header {
            margin-bottom: 2.5rem;
        }

        .form-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.5rem;
        }

        .form-subtitle {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .modern-input-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .modern-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 0.5rem;
        }

        .input-wrapper {
            position: relative;
        }

        .modern-input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 2.75rem;
            font-size: 1rem;
            color: var(--text-main);
            background: #f8fafc;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .modern-input:focus {
            outline: none;
            border-color: var(--primary-color);
            background: white;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            transition: color 0.3s ease;
        }

        .modern-input:focus + .input-icon {
            color: var(--primary-color);
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            cursor: pointer;
            border: none;
            background: none;
            padding: 0;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .custom-checkbox {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .custom-checkbox input {
            width: 18px;
            height: 18px;
            accent-color: var(--primary-color);
            cursor: pointer;
        }

        .custom-checkbox span {
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .forgot-link {
            font-size: 0.9rem;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .forgot-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(79, 70, 229, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            margin-top: 2rem;
            transition: color 0.3s ease;
            width: 100%;
            justify-content: center;
        }

        .back-link:hover {
            color: var(--primary-color);
        }

        /* Alerts */
        .alert-modern {
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            font-size: 0.9rem;
            animation: slideDown 0.3s ease-out;
        }

        .alert-success {
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        /* Animations */
        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(20px, -20px); }
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInRight {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive */
        @media (max-width: 991px) {
            .login-visual {
                display: none;
            }
            
            .login-form-side {
                background: #f8fafc;
            }
            
            .form-container {
                background: white;
                padding: 2.5rem;
                border-radius: 24px;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            }
        }

        @media (max-width: 480px) {
            .form-container {
                padding: 1.5rem;
                box-shadow: none;
                background: transparent;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Left Side: Visual -->
        <div class="login-visual">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            
            <div class="visual-content">
                <img src="{{ asset('Logo.png') }}" alt="LPPM-PM ITH" class="visual-logo">
                <h2 class="visual-title">LPPM-PM ITH</h2>
                <p class="visual-text">
                    Sistem Informasi Lembaga Penelitian, Pengabdian Masyarakat, dan Penjaminan Mutu<br>
                    <strong>Institut Teknologi B.J. Habibie</strong>
                </p>
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="login-form-side">
            <div class="form-container">
                <div class="form-header">
                    <h1 class="form-title">Selamat Datang</h1>
                    <p class="form-subtitle">Silakan masuk ke akun Anda untuk melanjutkan</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert-modern alert-success">
                        <i class="fas fa-check-circle mt-1"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="alert-modern alert-error">
                        <i class="fas fa-exclamation-circle mt-1"></i>
                        <div>
                            @foreach ($errors->all() as $error)
                                <div class="mb-1">{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" novalidate>
                    @csrf

                    <!-- Email -->
                    <div class="modern-input-group">
                        <label for="email" class="modern-label">Email Address</label>
                        <div class="input-wrapper">
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="modern-input" 
                                placeholder="nama@email.com"
                                value="{{ old('email') }}"
                                required 
                                autofocus
                            >
                            <i class="fas fa-envelope input-icon"></i>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="modern-input-group">
                        <label for="password" class="modern-label">Password</label>
                        <div class="input-wrapper">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="modern-input" 
                                placeholder="Masukkan password Anda"
                                required
                            >
                            <i class="fas fa-lock input-icon"></i>
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <i class="fas fa-eye" id="password-icon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Options -->
                    <div class="form-actions">
                        <label class="custom-checkbox">
                            <input type="checkbox" name="remember" id="remember_me">
                            <span>Ingat Saya</span>
                        </label>
                        
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">
                                Lupa Password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit">
                        <span>Masuk Sekarang</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>

                <a href="{{ route('home') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('password-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Auto-hide alerts
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert-modern');
                alerts.forEach(alert => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    alert.style.transition = 'all 0.3s ease';
                    setTimeout(() => alert.remove(), 300);
                });
            }, 5000);
        });
    </script>
</body>
</html>
