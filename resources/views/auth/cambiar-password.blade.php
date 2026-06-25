@extends('layouts.app-auth')

@section('title', 'Cambiar Contraseña')

@section('content')
<div class="login-card">

    <div class="login-logo">
        <img src="{{ asset('img/logo-infatlan.png') }}" alt="INFATLAN">
        <h4>Cambiar contraseña</h4>
        <p>Debés cambiar tu contraseña antes de continuar</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger d-flex align-items-center gap-2">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('auth.cambiar-password.post') }}">
        @csrf

        <div class="input-group">
            <span class="input-group-text">
                <i class="bi bi-lock"></i>
            </span>
            <input type="password" class="form-control"
                id="password" name="password"
                placeholder="Nueva contraseña" required>
            <button class="btn btn-toggle" type="button" onclick="togglePass('password', 'eye1')">
                <i class="bi bi-eye" id="eye1"></i>
            </button>
        </div>

        <div class="input-group">
            <span class="input-group-text">
                <i class="bi bi-lock-fill"></i>
            </span>
            <input type="password" class="form-control"
                id="password_confirmation" name="password_confirmation"
                placeholder="Confirmar contraseña" required>
            <button class="btn btn-toggle" type="button" onclick="togglePass('password_confirmation', 'eye2')">
                <i class="bi bi-eye" id="eye2"></i>
            </button>
        </div>

        <p style="color:#444; font-size:0.78rem; margin: 0.5rem 0 1rem;">
            <i class="bi bi-info-circle me-1"></i>
            Mínimo 14 caracteres, mayúsculas, minúsculas y números.
        </p>

        <button type="submit" class="btn btn-login">
            Cambiar contraseña
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
    function togglePass(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
</script>
@endpush