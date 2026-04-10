<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | LARAVEIL SUITES</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Aboreto&family=Kanit:wght@300;400;600;700&family=Karla:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bg-deep: #1E140C;
            --bg-warm: #2A1D12;
            --brand-gold: #BFA75D;
            --brand-gold-h: #D4BC72;
            --brand-cream: #FEF3E2;
            --glass-bg: rgba(30, 20, 12, 0.7);
            --border-gold: rgba(191, 167, 93, 0.25);
            --border-subtle: rgba(191, 167, 93, 0.12);
            --text-muted: rgba(254, 243, 226, 0.4);
        }

        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Karla', sans-serif;
            background-color: var(--bg-deep);
            overflow: hidden;
        }

        /* ── Cinematic Background ───────────────── */
        .bg-container {
            position: fixed;
            top: -5%; left: -5%;
            width: 110%; height: 110%;
            background: url('/images/HOTELMAINPAGEPIC.jpg') center/cover no-repeat;
            z-index: 0;
            animation: kenburns 30s infinite alternate ease-in-out;
        }

        @keyframes kenburns {
            0%   { transform: scale(1) translate(0, 0); }
            100% { transform: scale(1.08) translate(-1%, -1%); }
        }

        .overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(30, 20, 12, 0.92) 0%, rgba(30, 20, 12, 0.5) 60%, rgba(30, 20, 12, 0.85) 100%);
            z-index: 1;
        }

        /* Noise texture */
        .overlay::after {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            opacity: 0.04;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
            pointer-events: none;
        }

        /* ── Login Container ────────────────────── */
        .login-wrapper {
            position: relative;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            padding: 20px;
        }

        .login-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-gold);
            border-radius: 24px;
            padding: 48px 40px 40px;
            width: 100%;
            max-width: 440px;
            box-shadow:
                0 25px 60px -12px rgba(0, 0, 0, 0.5),
                0 0 0 1px rgba(191, 167, 93, 0.06) inset;
            animation: cardEntrance 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes cardEntrance {
            from { opacity: 0; transform: translateY(24px) scale(0.97); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ── Brand Header ───────────────────────── */
        .brand-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .brand-logo {
            width: 64px;
            height: auto;
            margin-bottom: 16px;
            filter: drop-shadow(0 4px 12px rgba(191, 167, 93, 0.25));
            animation: logoFloat 3s ease-in-out infinite;
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }

        .brand-name {
            font-family: 'Kanit', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--brand-cream);
            letter-spacing: 3px;
            margin: 0;
            line-height: 1;
        }

        .brand-sub {
            font-family: 'Aboreto', cursive;
            font-size: 0.75rem;
            color: var(--brand-gold);
            margin-top: 6px;
            letter-spacing: 6px;
            text-transform: uppercase;
        }

        /* Gold divider line */
        .brand-divider {
            width: 48px;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--brand-gold), transparent);
            margin: 20px auto 0;
            border-radius: 1px;
        }

        /* ── Form Styles ────────────────────────── */
        .form-label {
            color: var(--brand-cream);
            font-size: 0.78rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 8px;
            opacity: 0.7;
        }

        .form-control {
            background: rgba(254, 243, 226, 0.04);
            border: 1px solid rgba(254, 243, 226, 0.12);
            border-radius: 12px;
            color: var(--brand-cream);
            padding: 14px 18px;
            font-size: 0.95rem;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-control:focus {
            background: rgba(254, 243, 226, 0.07);
            border-color: var(--brand-gold);
            box-shadow: 0 0 0 4px rgba(191, 167, 93, 0.08);
            color: var(--brand-cream);
        }

        .form-control::placeholder {
            color: var(--text-muted);
            font-size: 0.88rem;
        }

        /* ── Submit Button ──────────────────────── */
        .btn-premium {
            background: linear-gradient(135deg, var(--brand-gold) 0%, #D4BC72 100%);
            border: none;
            border-radius: 12px;
            color: var(--bg-deep);
            font-family: 'Karla', sans-serif;
            font-weight: 700;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            padding: 15px;
            width: 100%;
            margin-top: 8px;
            cursor: pointer;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .btn-premium::before {
            content: '';
            position: absolute;
            top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.5s ease;
        }

        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(191, 167, 93, 0.3);
        }

        .btn-premium:hover::before {
            left: 100%;
        }

        .btn-premium:active {
            transform: translateY(0);
        }

        /* Loading state */
        .btn-premium.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        /* ── Helper Elements ─────────────────────── */
        .error-message {
            background: rgba(231, 76, 60, 0.08);
            border: 1px solid rgba(231, 76, 60, 0.2);
            color: #ff8e9a;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            text-align: center;
            animation: shake 0.4s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-6px); }
            75% { transform: translateX(6px); }
        }

        .meta-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4px;
        }

        .form-check-input {
            background-color: transparent;
            border-color: rgba(254, 243, 226, 0.3);
            width: 16px; height: 16px;
        }

        .form-check-input:checked {
            background-color: var(--brand-gold);
            border-color: var(--brand-gold);
        }

        .form-check-label {
            color: var(--brand-cream);
            opacity: 0.5;
            font-size: 0.82rem;
        }

        .forgot-link {
            color: var(--brand-gold);
            text-decoration: none;
            font-size: 0.78rem;
            font-weight: 500;
            transition: opacity 0.3s;
        }

        .forgot-link:hover {
            opacity: 0.7;
            color: var(--brand-gold-h);
        }

        .footer-links {
            text-align: center;
            margin-top: 28px;
        }

        .footer-links a {
            color: var(--brand-cream);
            text-decoration: none;
            font-size: 0.82rem;
            opacity: 0.4;
            transition: all 0.3s;
        }

        .footer-links a:hover {
            opacity: 0.8;
            color: var(--brand-gold);
        }

        /* Staggered field entrance */
        .field-group:nth-child(1) { animation: fieldIn 0.5s ease-out 0.3s both; }
        .field-group:nth-child(2) { animation: fieldIn 0.5s ease-out 0.4s both; }
        .meta-row { animation: fieldIn 0.5s ease-out 0.5s both; }
        .btn-premium { animation: fieldIn 0.5s ease-out 0.55s both; }

        @keyframes fieldIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ── Responsive ──────────────────────────── */
        @media (max-width: 480px) {
            .login-card { padding: 32px 24px 28px; border-radius: 20px; }
            .brand-name { font-size: 1.6rem; letter-spacing: 2px; }
            .brand-sub { font-size: 0.65rem; letter-spacing: 4px; }
        }
    </style>
</head>
<body>

    <div class="bg-container"></div>
    <div class="overlay"></div>

    <div class="login-wrapper">
        <div class="login-card">

            <!-- Brand Header -->
            <div class="brand-header">
                <img src="{{ asset('images/logo.png') }}" alt="LARAVEIL SUITES" class="brand-logo">
                <h1 class="brand-name">LARAVEIL</h1>
                <div class="brand-sub">SUITES</div>
                <div class="brand-divider"></div>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                @if ($errors->any())
                    <div class="error-message">
                        <i class="bi bi-exclamation-triangle"></i> Invalid credentials. Please try again.
                    </div>
                @endif

                <div class="field-group mb-3">
                    <label for="email" class="form-label">Office Email</label>
                    <input type="email" name="email" id="email" class="form-control"
                           placeholder="staff@laraveil.com" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="field-group mb-4">
                    <label for="password" class="form-label">Security Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control"
                               placeholder="••••••••" required style="border-right: none;">
                        <button class="btn" type="button" onclick="togglePass('password', this)" 
                                style="background: rgba(254, 243, 226, 0.04); border: 1px solid rgba(254, 243, 226, 0.12); border-left: none; color: var(--brand-cream);">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <div class="meta-row">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link" style="margin-left: auto;">Forgot Access?</a>
                    @endif
                </div>

                <button type="submit" class="btn-premium" id="submitBtn">
                    <span id="btnText">Log In</span>
                </button>
            </form>

            <div class="footer-links">
                <a href="/"><i class="bi bi-arrow-left"></i> Return to Main Page</a>
            </div>
        </div>
    </div>

    <script>
        // Add loading state on submit
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            const text = document.getElementById('btnText');
            btn.classList.add('loading');
            text.textContent = 'Verifying...';
        });

        function togglePass(fieldId, btn) {
            const input = document.getElementById(fieldId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            }
        }
    </script>
</body>
</html>
