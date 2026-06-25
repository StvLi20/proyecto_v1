@extends('layouts.app')

@section('title', 'Nuevo Usuario')
@section('page-title', 'Nuevo Usuario')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 pt-3">
        <h6 class="fw-bold mb-0">
            <i class="bi bi-person-plus me-2 text-muted"></i>Crear nuevo usuario
        </h6>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.usuarios.store') }}">
            @csrf

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nombre completo <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                        name="nombre" value="{{ old('nombre') }}"
                        placeholder="Ej: Juan Pérez" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Correo institucional <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('correo') is-invalid @enderror"
                        name="correo" value="{{ old('correo') }}"
                        placeholder="usuario@bancatlan.hn" required>
                    @error('correo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Rol <span class="text-danger">*</span></label>
                    <select class="form-select @error('rol') is-invalid @enderror" name="rol" required>
                        <option value="">Seleccioná un rol</option>
                        <option value="admin" {{ old('rol') === 'admin' ? 'selected' : '' }}>Administrador</option>
                        <option value="dba"   {{ old('rol') === 'dba'   ? 'selected' : '' }}>DBA</option>
                        <option value="consulta" {{ old('rol') === 'consulta' ? 'selected' : '' }}>Consulta</option>
                    </select>
                    @error('rol')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <div class="alert alert-info d-flex align-items-center gap-2 py-2">
                        <i class="bi bi-info-circle"></i>
                        <span class="small">Se generará una contraseña temporal automáticamente. El usuario deberá cambiarla en su primer inicio de sesión.</span>
                    </div>
                </div>

            </div>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>Crear Usuario
                </button>
                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x me-2"></i>Cancelar
                </a>
            </div>

        </form>
    </div>
</div>

@endsection