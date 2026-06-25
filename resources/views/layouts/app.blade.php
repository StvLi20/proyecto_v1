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
    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/adminlte.min.css') }}">

    @stack('styles')
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

    {{-- Navbar --}}
    <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                        <i class="bi bi-list fs-5"></i>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
    @if(Auth::user()->foto)
        <img src="{{ asset('storage/' . Auth::user()->foto) }}"
            class="rounded-circle"
            style="width:32px; height:32px; object-fit:cover;">
    @else
        <i class="bi bi-person-circle fs-5"></i>
    @endif
    <span>{{ Auth::user()->nombre }}</span>
    <span class="badge bg-secondary">{{ Auth::user()->rol }}</span>
</a>
<ul class="dropdown-menu dropdown-menu-end">
    <li>
        <a class="dropdown-item" href="{{ route('perfil.index') }}">
            <i class="bi bi-person me-2"></i> Mi perfil
        </a>
    </li>
    <li><hr class="dropdown-divider"></li>
    <li>
        <form method="POST" action="{{ route('auth.logout') }}">
            @csrf
            <button type="submit" class="dropdown-item text-danger">
                <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
            </button>
        </form>
    </li>
</ul>
                </li>
            </ul>
        </div>
    </nav>

    {{-- Sidebar --}}
    <aside class="app-sidebar bg-dark shadow" data-bs-theme="dark">
        <div class="sidebar-brand d-flex align-items-center justify-content-center py-3">
            <img src="{{ asset('img/logo-infatlan.png') }}" alt="INFATLAN" style="height:36px; filter: brightness(0) invert(1);">
        </div>

        <div class="sidebar-wrapper">
            <nav class="mt-2">
                <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview">

                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-speedometer2"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('scripts.index') }}" class="nav-link {{ request()->routeIs('scripts.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-code-square"></i>
                            <p>Scripts</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('favoritos.index') }}" class="nav-link {{ request()->routeIs('favoritos.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-star"></i>
                            <p>Mis Favoritos</p>
                        </a>
                    </li>

                    @if(Auth::user()->rol === 'admin')
                    <li class="nav-header text-muted small px-3 mt-2">ADMINISTRACIÓN</li>

                    <li class="nav-item">
                        <a href="{{ route('admin.usuarios.index') }}" class="nav-link {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-people"></i>
                            <p>Usuarios</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.categorias.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-tags"></i>
                            <p>Categorías</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.motores.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-database"></i>
                            <p>Motores</p>
                        </a>
                    </li>
                    @endif

                </ul>
            </nav>
        </div>
    </aside>

    {{-- Contenido principal --}}
    <main class="app-main">
        <div class="app-content-header py-3 px-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">@yield('page-title', 'Dashboard')</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')

            </div>
        </div>
    </main>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="{{ asset('vendor/adminlte/js/adminlte.min.js') }}"></script>
@stack('scripts')
</body>
</html>