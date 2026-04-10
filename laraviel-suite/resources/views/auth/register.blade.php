<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | LARAVEIL SUITES</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Aboreto&family=Kanit:wght@300;400;600;700&family=Karla:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bg-deep: #1E140C;
            --brand-gold: #BFA75D;
            --brand-gold-h: #D4BC72;
            --brand-cream: #FEF3E2;
            --glass-bg: rgba(30, 20, 12, 0.75);
            --border-gold: rgba(191, 167, 93, 0.25);
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
            animation: kenburns 40s infinite alternate ease-in-out;
        }

        @keyframes kenburns {
            0%   { transform: scale(1) translate(0, 0); }
            100% { transform: scale(1.12) translate(-2%, -1%); }
        }

        .overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(30, 20, 12, 0.94) 0%, rgba(30, 20, 12, 0.6) 60%, rgba(30, 20, 12, 0.88) 100%);
            z-index: 1;
        }

        /* ── Register Container ─────────────────── */
        .register-wrapper {
            position: relative;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            padding: 20px;
            overflow-y: auto;
        }

        .register-card {
            background: var(--glass-bg);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--border-gold);
            border-radius: 28px;
            padding: 40px;
            width: 100%;
            max-width: 520px;
            box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.6);
            animation: cardEntrance 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
            margin: auto;
        }

        @keyframes cardEntrance {
            from { opacity: 0; transform: translateY(30px) scale(0.96); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .brand-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-logo {
            width: 56px;
            margin-bottom: 12px;
            filter: drop-shadow(0 4px 12px rgba(191, 167, 93, 0.3));
        }

        .brand-name {
            font-family: 'Kanit', sans-serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--brand-cream);
            letter-spacing: 2.5px;
            margin: 0;
            text-transform: uppercase;
        }

        .brand-sub {
            font-family: 'Aboreto', cursive;
            font-size: 0.65rem;
            color: var(--brand-gold);
            margin-top: 4px;
            letter-spacing: 5px;
        }

        /* ── Form Styling ───────────────────────── */
        .form-label {
            color: var(--brand-gold);
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-bottom: 6px;
            opacity: 0.9;
        }

        .form-control, .form-select {
            background: rgba(254, 243, 226, 0.04);
            border: 1px solid rgba(191, 167, 93, 0.15);
            border-radius: 12px;
            color: var(--brand-cream);
            padding: 12px 16px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            background: rgba(254, 243, 226, 0.08);
            border-color: var(--brand-gold);
            box-shadow: 0 0 0 4px rgba(191, 167, 93, 0.1);
            color: var(--brand-cream);
        }

        .form-select option {
            background: var(--bg-deep);
            color: var(--brand-cream);
        }

        .text-danger {
            font-size: 0.75rem;
            color: #ff8e9a !important;
            margin-top: 4px;
            font-weight: 500;
        }

        .btn-premium {
            background: linear-gradient(135deg, var(--brand-gold) 0%, #a8914d 100%);
            border: none;
            border-radius: 12px;
            color: var(--bg-deep);
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            padding: 14px;
            width: 100%;
            margin-top: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(191, 167, 93, 0.3);
            background: linear-gradient(135deg, var(--brand-gold-h) 0%, var(--brand-gold) 100%);
        }

        .footer-links {
            text-align: center;
            margin-top: 24px;
            border-top: 1px solid var(--border-gold);
            padding-top: 20px;
        }

        .footer-links a {
            color: var(--brand-cream);
            text-decoration: none;
            font-size: 0.8rem;
            opacity: 0.5;
            transition: all 0.3s;
        }

        .footer-links a:hover {
            opacity: 1;
            color: var(--brand-gold);
        }

        /* ── Custom Scrollbar ───────────────────── */
        .register-wrapper::-webkit-scrollbar { width: 4px; }
        .register-wrapper::-webkit-scrollbar-track { background: transparent; }
        .register-wrapper::-webkit-scrollbar-thumb { background: var(--brand-gold); border-radius: 10px; }

        @keyframes fieldIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .row > div { animation: fieldIn 0.5s ease-out both; }
        .row > div:nth-child(1) { animation-delay: 0.2s; }
        .row > div:nth-child(2) { animation-delay: 0.3s; }
        .row > div:nth-child(3) { animation-delay: 0.4s; }
        .row > div:nth-child(4) { animation-delay: 0.5s; }
        .row > div:nth-child(5) { animation-delay: 0.6s; }
    </style>
</head>
<body>

    <div class="bg-container"></div>
    <div class="overlay"></div>

    <div class="register-wrapper">
        <div class="register-card">
            
            <!-- Brand Header -->
            <div class="brand-header">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="brand-logo">
                <h1 class="brand-name">Create Account</h1>
                <div class="brand-sub">Registration Portal</div>
            </div>

            <!-- Registration Form -->
            <form method="POST" action="/register">
                @csrf

                <div class="row g-3">
                    <!-- Full Name -->
                    <div class="col-md-12">
                        <label for="name" class="form-label">Full Name</label>
                        <input id="name" type="text" name="name" class="form-control" 
                               placeholder="John Doe" value="{{ old('name') }}" required autofocus>
                        @if($errors->has('name'))
                            <div class="text-danger">{{ $errors->first('name') }}</div>
                        @endif
                    </div>

                    <!-- Email Address -->
                    <div class="col-md-12">
                        <label for="email" class="form-label">Office Email</label>
                        <input id="email" type="email" name="email" class="form-control" 
                               placeholder="john@laraveil.com" value="{{ old('email') }}" required>
                        @if($errors->has('email'))
                            <div class="text-danger">{{ $errors->first('email') }}</div>
                        @endif
                    </div>

                    <!-- Role Selection -->
                    <div class="col-md-12">
                        <label for="role" class="form-label">System Role</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="" disabled selected>Choose a level of access</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                            <option value="cashier" {{ old('role') == 'cashier' ? 'selected' : '' }}>Cashier</option>
                        </select>
                        @if($errors->has('role'))
                            <div class="text-danger">{{ $errors->first('role') }}</div>
                        @endif
                    </div>

                    <!-- Password -->
                    <div class="col-md-6">
                        <label for="password" class="form-label">Security Password</label>
                        <div class="input-group">
                            <input id="password" type="password" name="password" class="form-control" 
                                   placeholder="Min. 8 characters" required style="border-right: none;">
                            <button class="btn" type="button" onclick="togglePass('password', this)" 
                                    style="background: rgba(254, 243, 226, 0.04); border: 1px solid rgba(191, 167, 93, 0.15); border-left: none; color: var(--brand-cream);">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                        @if($errors->has('password'))
                            <div class="text-danger">{{ $errors->first('password') }}</div>
                        @endif
                    </div>

                    <!-- Confirm Password -->
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Confirm Key</label>
                        <div class="input-group">
                            <input id="password_confirmation" type="password" name="password_confirmation" 
                                   class="form-control" placeholder="Re-type password" required style="border-right: none;">
                            <button class="btn" type="button" onclick="togglePass('password_confirmation', this)" 
                                    style="background: rgba(254, 243, 226, 0.04); border: 1px solid rgba(191, 167, 93, 0.15); border-left: none; color: var(--brand-cream);">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-premium">
                    Initialize Account
                </button>
            </form>

            <div class="footer-links">
                <a href="/login"><i class="bi bi-shield-lock me-1"></i> Already have credentials? Log in here</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
