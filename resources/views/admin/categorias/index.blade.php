@extends('layouts.app')

@section('title', 'Categorías')
@section('page-title', 'Gestión de Categorías')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-3">
        <h6 class="fw-bold mb-0">
            <i class="bi bi-tags me-2 text-muted"></i>
            Categorías <span class="badge bg-secondary ms-1">{{ $categorias->count() }}</span>
        </h6>
        <a href="{{ route('admin.categorias.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Nueva Categoría
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th class="text-center">Scripts</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categorias as $categoria)
                    <tr>
                        <td class="fw-semibold">{{ $categoria->nombre }}</td>
                        <td class="text-muted small">{{ $categoria->descripcion ?? '—' }}</td>
                        <td class="text-center">
                            <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                {{ $categoria->scripts()->count() }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.categorias.edit', $categoria) }}"
                                class="btn btn-sm btn-outline-primary" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.categorias.destroy', $categoria) }}"
                                class="d-inline"
                                onsubmit="return confirm('¿Eliminar categoría {{ $categoria->nombre }}?')">
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
                        <td colspan="4" class="text-center text-muted py-4">
                            <i class="bi bi-tags fs-4 d-block mb-2"></i>
                            No hay categorías registradas
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection