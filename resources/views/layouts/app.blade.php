<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Catálogo de Scripts SQL - INFATLAN')</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }
        .navbar-brand {
            font-weight: bold;
            letter-spacing: 1px;
        }
        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: #212529;
        }
        .sidebar .nav-link {
            color: #adb5bd;
            padding: 10px 20px;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background-color: #343a40;
            border-radius: 5px;
        }
        .sidebar .nav-link i {
            margin-right: 8px;
        }
        .main-content {
            padding: 30px;
        }
    </style>
    @stack('styles')
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-dark bg-dark px-3">
        <span class="navbar-brand">
            <i class="bi bi-database"></i> Catálogo Scripts SQL
        </span>
        <div class="d-flex align-items-center gap-3">
            <span class="text-white">
                <i class="bi bi-person-circle"></i>
                {{ Auth::user()->nombre }}
                <span class="badge bg-secondary ms-1">{{ Auth::user()->rol }}</span>
            </span>
            <form method="POST" action="{{ route('auth.logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Salir
                </button>
            </form>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">

            {{-- Sidebar --}}
            <div class="col-md-2 sidebar pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                           href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('scripts.*') ? 'active' : '' }}"
                           href="#">
                            <i class="bi bi-code-square"></i> Scripts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('favoritos.*') ? 'active' : '' }}"
                           href="#">
                            <i class="bi bi-star"></i> Favoritos
                        </a>
                    </li>
                    {{-- Solo visible para admin --}}
                    @if(Auth::user()->rol === 'admin')
                    <li class="nav-item mt-3">
                        <small class="text-muted px-3">ADMINISTRACIÓN</small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}"
                           href="#">
                            <i class="bi bi-people"></i> Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.categorias.*') ? 'active' : '' }}"
                           href="#">
                            <i class="bi bi-tags"></i> Categorías
                        </a>
                    </li>
                    @endif
                </ul>
            </div>

            {{-- Contenido principal --}}
            <div class="col-md-10 main-content">
                {{-- Mensajes de éxito --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Mensajes de error --}}
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>