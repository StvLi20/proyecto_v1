@extends('layouts.app')

@section('title', 'Editar Usuario')
@section('page-title', 'Editar Usuario')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 pt-3">
        <h6 class="fw-bold mb-0">
            <i class="bi bi-pencil me-2 text-muted"></i>Editar usuario
        </h6>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.usuarios.update', $usuario) }}">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nombre completo <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                        name="nombre" value="{{ old('nombre', $usuario->nombre) }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Correo institucional <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('correo') is-invalid @enderror"
                        name="correo" value="{{ old('correo', $usuario->correo) }}" required>
                    @error('correo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Rol <span class="text-danger">*</span></label>
                    <select class="form-select @error('rol') is-invalid @enderror" name="rol" required>
                        <option value="admin"    {{ old('rol', $usuario->rol) === 'admin'    ? 'selected' : '' }}>Administrador</option>
                        <option value="dba"      {{ old('rol', $usuario->rol) === 'dba'      ? 'selected' : '' }}>DBA</option>
                        <option value="consulta" {{ old('rol', $usuario->rol) === 'consulta' ? 'selected' : '' }}>Consulta</option>
                    </select>
                    @error('rol')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>Guardar Cambios
                </button>
                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x me-2"></i>Cancelar
                </a>
            </div>

        </form>
    </div>
</div>

@endsection