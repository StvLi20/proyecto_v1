@extends('layouts.app')

@section('title', 'Mi Perfil')
@section('page-title', 'Mi Perfil')

@section('content')

<div class="row g-4">

    {{-- Foto de perfil --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-4">

                @if($usuario->foto)
                    <img src="{{ asset('storage/' . $usuario->foto) }}"
                        alt="Foto de perfil"
                        class="rounded-circle mb-3"
                        style="width:120px; height:120px; object-fit:cover; border: 3px solid #e5e7eb;">
                @else
                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto mb-3"
                        style="width:120px; height:120px;">
                        <i class="bi bi-person-fill text-white" style="font-size:3rem;"></i>
                    </div>
                @endif

                <h5 class="fw-bold mb-1">{{ $usuario->nombre }}</h5>
                <span class="badge bg-secondary mb-3">{{ $usuario->rol }}</span>
                <div class="text-muted small">{{ $usuario->correo }}</div>

                <hr>

                <form method="POST" action="{{ route('perfil.foto') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="foto" class="form-label small text-muted fw-semibold">
                            Actualizar foto
                        </label>
                        <input type="file" class="form-control form-control-sm @error('foto') is-invalid @enderror"
                            id="foto" name="foto" accept="image/jpeg,image/png">
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">JPG o PNG, máximo 2MB</div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-upload me-2"></i>Subir foto
                    </button>
                </form>

            </div>
        </div>
    </div>

    {{-- Cambiar contraseña --}}
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-lock me-2 text-muted"></i>Cambiar contraseña
                </h6>
            </div>
            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('perfil.password') }}">
                    @csrf

                    <div class="mb-3">
    <label class="form-label fw-semibold">Contraseña actual</label>
    <div class="input-group">
        <input type="password"
            class="form-control @error('password_actual') is-invalid @enderror"
            name="password_actual" id="password_actual" required>
        <button class="btn btn-outline-secondary" type="button" onclick="togglePass('password_actual', 'eye1')">
            <i class="bi bi-eye" id="eye1"></i>
        </button>
    </div>
    @error('password_actual')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Nueva contraseña</label>
    <div class="input-group">
        <input type="password"
            class="form-control @error('password_nuevo') is-invalid @enderror"
            name="password_nuevo" id="password_nuevo" required>
        <button class="btn btn-outline-secondary" type="button" onclick="togglePass('password_nuevo', 'eye2')">
            <i class="bi bi-eye" id="eye2"></i>
        </button>
    </div>
    @error('password_nuevo')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
    <div class="form-text">Mínimo 14 caracteres, mayúsculas, minúsculas y números.</div>
</div>

<div class="mb-4">
    <label class="form-label fw-semibold">Confirmar nueva contraseña</label>
    <div class="input-group">
        <input type="password" class="form-control"
            name="password_nuevo_confirmation" id="password_confirm" required>
        <button class="btn btn-outline-secondary" type="button" onclick="togglePass('password_confirm', 'eye3')">
            <i class="bi bi-eye" id="eye3"></i>
        </button>
    </div>
</div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Actualizar contraseña
                    </button>

                </form>
            </div>
        </div>
    </div>

</div>

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

@endsection