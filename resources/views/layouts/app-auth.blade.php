<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Catálogo de Scripts SQL - INFATLAN')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: #000000;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 1.5rem;
        }

        .login-card {
            background: #111111;
            border: 1px solid #222222;
            border-radius: 20px;
            padding: 2.5rem 2.25rem;
            box-shadow: 0 32px 64px rgba(0, 0, 0, 0.9);
        }

        .login-logo {
            text-align: center;
            margin-bottom: 1.75rem;
        }

        .login-logo img {
            height: 48px;
            object-fit: contain;
            margin-bottom: 1rem;
            filter: brightness(0) invert(1);
        }

        .login-logo h4 {
            color: #f5f5f5;
            font-size: 1.6rem;
            font-weight: 600;
            letter-spacing: -0.3px;
            margin-bottom: 0.4rem;
        }

        .login-logo p {
            color: #444;
            font-size: 0.82rem;
            line-height: 1.5;
        }

        .form-label {
            display: none;
        }

        .input-group {
            margin-bottom: 0.85rem;
        }

        .input-group-text {
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-right: none;
            color: #444;
            border-radius: 10px 0 0 10px;
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
        }

        .form-control {
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-left: none;
            color: #e8e8e8;
            border-radius: 0 10px 10px 0;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .form-control::placeholder {
            color: #333;
        }

        .form-control:focus {
            background: #1f1f1f;
            border-color: #444;
            color: #f5f5f5;
            box-shadow: none;
            outline: none;
        }

        .input-group:focus-within .input-group-text {
            border-color: #444;
            background: #1f1f1f;
            color: #888;
        }

        .btn-toggle {
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-left: none;
            color: #444;
            border-radius: 0 10px 10px 0 !important;
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
        }

        .btn-toggle:hover {
            background: #1f1f1f;
            color: #888;
        }

        .btn-login {
            width: 100%;
            background: #f5f5f5;
            border: none;
            color: #000;
            font-weight: 700;
            font-size: 0.95rem;
            border-radius: 10px;
            padding: 0.8rem;
            margin-top: 0.5rem;
            transition: all 0.2s ease;
            letter-spacing: 0.3px;
        }

        .btn-login:hover {
            background: #ffffff;
            color: #000;
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.08);
        }

        .btn-login:active {
            transform: translateY(0);
            background: #ddd;
        }

        .footer-text {
            color: #2a2a2a;
            font-size: 0.74rem;
            text-align: center;
            margin-top: 1.5rem;
        }

        .alert-danger {
            background: rgba(220, 38, 38, 0.07);
            border: 1px solid rgba(220, 38, 38, 0.18);
            color: #f87171;
            font-size: 0.85rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            padding: 0.65rem 1rem;
        }
    </style>
    @stack('styles')
</head>
<body>

    <div class="login-wrapper">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>