@extends('layouts.app')

@section('title', 'Editar Motor')
@section('page-title', 'Editar Motor')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 pt-3">
        <h6 class="fw-bold mb-0">
            <i class="bi bi-pencil me-2 text-muted"></i>Editar motor
        </h6>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.motores.update', $motor) }}">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                        name="nombre" value="{{ old('nombre', $motor->nombre) }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>Guardar Cambios
                </button>
                <a href="{{ route('admin.motores.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x me-2"></i>Cancelar
                </a>
            </div>

        </form>
    </div>
</div>

@endsection