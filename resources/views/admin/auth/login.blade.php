<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — OSIS SMA</title>
    @php $favicon = \App\Models\Pengaturan::where('key', 'logo')->value('value'); @endphp
    @if(!empty($favicon))
        <link rel="icon" href="{{ asset('storage/'.$favicon) }}" type="image/png">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @endif
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #050d1a;
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            overflow: hidden; position: relative;
        }

        /* Background */
        .bg-canvas { position: fixed; inset: 0; z-index: 0; }
        .bg-gradient {
            position: fixed; inset: 0;
            background: linear-gradient(145deg, #020810 0%, #0a1628 45%, #0d1f3c 100%);
            z-index: 0;
        }
        .orb {
            position: fixed; border-radius: 50%; filter: blur(80px); pointer-events: none; z-index: 0;
        }
        .orb-1 {
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(245,166,35,0.1), transparent 70%);
            top: -200px; right: -150px;
            animation: orbFloat 9s ease-in-out infinite;
        }
        .orb-2 {
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(26,74,122,0.18), transparent 70%);
            bottom: -150px; left: -100px;
            animation: orbFloat 12s ease-in-out infinite reverse;
        }
        @keyframes orbFloat {
            0%,100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-30px) scale(1.06); }
        }

        /* Grid lines (optional subtle) */
        .bg-grid {
            position: fixed; inset: 0; z-index: 0; opacity: 0.03;
            background-image:
                linear-gradient(rgba(245,166,35,0.4) 1px, transparent 1px),
                linear-gradient(90deg, rgba(245,166,35,0.4) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        /* Login Card */
        .login-wrap {
            position: relative; z-index: 10;
            width: 100%; max-width: 460px;
            padding: 1.5rem;
        }
        .login-card {
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(24px) saturate(160%);
            -webkit-backdrop-filter: blur(24px) saturate(160%);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            box-shadow: 0 32px 80px rgba(0,0,0,0.5), inset 0 1px 0 rgba(255,255,255,0.08);
            animation: cardSlideIn 0.6s cubic-bezier(0.4,0,0.2,1) both;
        }
        @keyframes cardSlideIn {
            from { opacity: 0; transform: translateY(30px) scale(0.97); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Logo area */
        .login-logo { text-align: center; margin-bottom: 2.25rem; }
        .logo-ring {
            width: 80px; height: 80px; margin: 0 auto 1.1rem;
            background: linear-gradient(135deg, #f5a623, #d48a0a);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 2.2rem; font-weight: 900; color: #050d1a;
            box-shadow: 0 0 0 8px rgba(245,166,35,0.12), 0 12px 32px rgba(245,166,35,0.3);
            animation: logoGlow 3s ease-in-out infinite;
        }
        @keyframes logoGlow {
            0%,100% { box-shadow: 0 0 0 8px rgba(245,166,35,0.12), 0 12px 32px rgba(245,166,35,0.3); }
            50% { box-shadow: 0 0 0 14px rgba(245,166,35,0.08), 0 16px 40px rgba(245,166,35,0.4); }
        }
        .login-logo h1 {
            font-size: 1.55rem; font-weight: 900; color: white;
            letter-spacing: -0.02em;
        }
        .login-logo p { color: rgba(255,255,255,0.45); font-size: 0.88rem; margin-top: 4px; }

        /* Divider */
        .login-divider {
            display: flex; align-items: center; gap: 12px; margin-bottom: 1.75rem;
        }
        .login-divider-line { flex: 1; height: 1px; background: rgba(255,255,255,0.08); }
        .login-divider-text { color: rgba(255,255,255,0.3); font-size: 0.75rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; }

        /* Form */
        .form-group { margin-bottom: 1.1rem; }
        label {
            display: block; font-size: 0.82rem; font-weight: 700;
            color: rgba(255,255,255,0.6); margin-bottom: 8px;
            letter-spacing: 0.04em; text-transform: uppercase;
        }
        .input-wrap { position: relative; }
        .input-wrap .icon {
            position: absolute; left: 15px; top: 50%; transform: translateY(-50%);
            color: rgba(255,255,255,0.3); font-size: 0.9rem; pointer-events: none;
            transition: color 0.2s;
        }
        .input-wrap:focus-within .icon { color: #f5a623; }
        input[type="email"], input[type="password"] {
            width: 100%; padding: 13px 14px 13px 44px;
            background: rgba(255,255,255,0.05);
            border: 1.5px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            font-size: 0.92rem; font-family: inherit;
            color: white; outline: none;
            transition: all 0.25s;
        }
        input[type="email"]::placeholder, input[type="password"]::placeholder { color: rgba(255,255,255,0.25); }
        input[type="email"]:focus, input[type="password"]:focus {
            border-color: rgba(245,166,35,0.6);
            background: rgba(245,166,35,0.06);
            box-shadow: 0 0 0 4px rgba(245,166,35,0.1);
        }

        /* Remember */
        .remember-row {
            display: flex; align-items: center; gap: 9px; margin-bottom: 1.25rem;
        }
        input[type="checkbox"] { width: 17px; height: 17px; accent-color: #f5a623; cursor: pointer; }
        .remember-label { color: rgba(255,255,255,0.5); font-size: 0.85rem; font-weight: 500; margin: 0; text-transform: none; letter-spacing: 0; }

        /* Submit */
        .btn-login {
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, #f5a623, #d48a0a);
            color: #050d1a; border: none; border-radius: 12px;
            font-size: 0.98rem; font-weight: 800; cursor: pointer;
            font-family: inherit; letter-spacing: 0.01em;
            transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
            box-shadow: 0 6px 20px rgba(245,166,35,0.35);
            display: flex; align-items: center; justify-content: center; gap: 9px;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 32px rgba(245,166,35,0.45);
            background: linear-gradient(135deg, #ffc94d, #f5a623);
        }
        .btn-login:active { transform: translateY(0); }

        /* Alert */
        .alert {
            padding: 12px 16px; border-radius: 10px; margin-bottom: 1.25rem;
            font-size: 0.88rem; background: rgba(220,38,38,0.15);
            color: #fca5a5; border: 1px solid rgba(220,38,38,0.3);
            display: flex; align-items: center; gap: 9px;
        }

        /* Footer link */
        .form-footer { text-align: center; margin-top: 1.75rem; }
        .form-footer a {
            color: rgba(255,255,255,0.45); text-decoration: none;
            font-size: 0.85rem; font-weight: 600;
            transition: color 0.2s; display: inline-flex; align-items: center; gap: 7px;
        }
        .form-footer a:hover { color: #f5a623; }

        /* Security badge */
        .security-badge {
            display: flex; align-items: center; justify-content: center; gap: 6px;
            color: rgba(255,255,255,0.2); font-size: 0.72rem; margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="bg-gradient"></div>
    <div class="bg-grid"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

    <div class="login-wrap">
        <div class="login-card">
            <div class="login-logo">
                @php $currentLogo = \App\Models\Pengaturan::where('key', 'logo')->value('value'); @endphp
                @if(!empty($currentLogo))
                    <div class="logo-ring" style="background:transparent;border:2px solid rgba(245,166,35,0.4);">
                        <img src="{{ asset('storage/'.$currentLogo) }}" alt="Logo" style="width:60px;height:60px;object-fit:contain;border-radius:50%;">
                    </div>
                @else
                    <div class="logo-ring">O</div>
                @endif
                <h1>Admin Panel</h1>
                <p>OSIS SMA — Masuk untuk melanjutkan</p>
            </div>

            @if($errors->any())
                <div class="alert"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
            @endif
            @if(session('error'))
                <div class="alert"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
            @endif

            <div class="login-divider">
                <div class="login-divider-line"></div>
                <div class="login-divider-text">Masuk dengan akun admin</div>
                <div class="login-divider-line"></div>
            </div>

            <form method="POST" action="{{ route('admin.login.post') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrap">
                        <span class="icon"><i class="fas fa-envelope"></i></span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="admin@osis.sch.id" required autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <span class="icon"><i class="fas fa-lock"></i></span>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                    </div>
                </div>
                <div class="remember-row">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember" class="remember-label">Ingat saya di perangkat ini</label>
                </div>
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Masuk ke Dashboard
                </button>
            </form>

            <div class="form-footer">
                <a href="{{ route('home') }}"><i class="fas fa-arrow-left"></i> Kembali ke Website</a>
            </div>
            <div class="security-badge">
                <i class="fas fa-shield-alt"></i> Koneksi aman & terenkripsi
            </div>
        </div>
    </div>
</body>
</html>
