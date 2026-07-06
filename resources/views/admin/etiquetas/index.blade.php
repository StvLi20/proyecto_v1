@extends('layouts.app')

@section('title', 'Etiquetas')
@section('page-title', 'Gestión de Etiquetas')

@section('content')

<div class="card border-0 shadow-sm">
    <<div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-3">
    <h6 class="fw-bold mb-0">
        <i class="bi bi-tag me-2 text-muted"></i>
        Etiquetas <span class="badge bg-secondary ms-1">{{ $etiquetas->count() }}</span>
    </h6>
    <div class="ms-auto">
        <a href="{{ route('admin.etiquetas.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Nueva Etiqueta
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
                    @forelse($etiquetas as $etiqueta)
                    <tr>
                        <td>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary fs-6">
                                {{ $etiqueta->nombre }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                {{ $etiqueta->scripts()->count() }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.etiquetas.edit', $etiqueta) }}"
                                class="btn btn-sm btn-outline-primary" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.etiquetas.destroy', $etiqueta) }}"
                                class="d-inline"
                                onsubmit="return confirm('¿Eliminar etiqueta {{ $etiqueta->nombre }}?')">
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
                            <i class="bi bi-tag fs-4 d-block mb-2"></i>
                            No hay etiquetas registradas
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection