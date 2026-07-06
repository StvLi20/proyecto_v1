@extends('layouts.app')

@section('title', 'Motores')
@section('page-title', 'Gestión de Motores')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-3">
    <h6 class="fw-bold mb-0">
        <i class="bi bi-database me-2 text-muted"></i>
        Motores <span class="badge bg-secondary ms-1">{{ $motores->count() }}</span>
    </h6>
    <div class="ms-auto">
        <a href="{{ route('admin.motores.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Nuevo Motor
        </a>
    </div>
</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th class="text-center">Scripts</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($motores as $motor)
                    <tr>
                        <td class="fw-semibold">{{ $motor->nombre }}</td>
                        <td class="text-center">
                            <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                {{ $motor->scripts()->count() }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.motores.edit', $motor) }}"
                                class="btn btn-sm btn-outline-primary" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.motores.destroy', $motor) }}"
                                class="d-inline"
                                onsubmit="return confirm('¿Eliminar motor {{ $motor->nombre }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">
                            <i class="bi bi-database fs-4 d-block mb-2"></i>
                            No hay motores registrados
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection