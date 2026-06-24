@extends('layouts.app-auth')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="login-card">

    <div class="login-logo">
        <img src="{{ asset('img/logo-infatlan.png') }}" alt="INFATLAN">
        <h4>Iniciar sesión</h4>
        <p>Ingresá tus credenciales para acceder al<br>Catálogo de Scripts</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger d-flex align-items-center gap-2">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('auth.login.post') }}">
        @csrf

        <div class="input-group">
            <span class="input-group-text">
                <i class="bi bi-envelope"></i>
            </span>
            <input
                type="email"
                class="form-control @error('correo') is-invalid @enderror"
                name="correo"
                value="{{ old('correo') }}"
                placeholder="Ingresá tu correo"
                autofocus
                required
            >
        </div>

        <div class="input-group">
            <span class="input-group-text">
                <i class="bi bi-lock"></i>
            </span>
            <input
                type="password"
                class="form-control @error('password') is-invalid @enderror"
                id="password"
                name="password"
                placeholder="Ingresá tu contraseña"
                required
            >
            <button class="btn btn-toggle" type="button" id="togglePassword">
                <i class="bi bi-eye" id="eyeIcon"></i>
            </button>
        </div>

        <button type="submit" class="btn btn-login">
            Iniciar sesión
        </button>

    </form>

    <p class="footer-text">
        <i class="bi bi-shield-lock me-1"></i>
        Acceso restringido al personal autorizado
    </p>

</div>
@endsection

@push('scripts')
<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const input = document.getElementById('password');
        const icon  = document.getElementById('eyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });
</script>
@endpush