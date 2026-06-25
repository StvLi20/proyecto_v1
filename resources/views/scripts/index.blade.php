@extends('layouts.app')

@section('title', 'Scripts')
@section('page-title', 'Catálogo de Scripts')

@section('content')

{{-- Filtros y búsqueda --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('scripts.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small text-muted fw-semibold">Buscar</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" name="buscar"
                            value="{{ request('buscar') }}" placeholder="Título, descripción o código...">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted fw-semibold">Motor</label>
                    <select class="form-select" name="motor_id">
                        <option value="">Todos los motores</option>
                        @foreach($motores as $motor)
                            <option value="{{ $motor->id }}" {{ request('motor_id') == $motor->id ? 'selected' : '' }}>
                                {{ $motor->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted fw-semibold">Categoría</label>
                    <select class="form-select" name="categoria_id">
                        <option value="">Todas las categorías</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel"></i> Filtrar
                    </button>
                    <a href="{{ route('scripts.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Tabla de scripts --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-3">
        <h6 class="fw-bold mb-0">
            <i class="bi bi-code-square me-2 text-muted"></i>
            Scripts <span class="badge bg-secondary ms-1">{{ $scripts->total() }}</span>
        </h6>
        @if(Auth::user()->rol !== 'consulta')
        <a href="{{ route('scripts.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Nuevo Script
        </a>
        @endif
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Título</th>
                        <th>Motor</th>
                        <th>Categoría</th>
                        <th>Autor</th>
                        <th>Fecha</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($scripts as $script)
                    <tr>
                        <td>
                            <a href="{{ route('scripts.show', $script) }}" class="text-decoration-none fw-semibold">
                                {{ $script->titulo }}
                            </a>
                            @if($script->descripcion)
                                <div class="text-muted small">{{ Str::limit($script->descripcion, 60) }}</div>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                {{ $script->motor->nombre }}
                            </span>
                        </td>
                        <td>{{ $script->categoria->nombre }}</td>
                        <td>{{ $script->autor->nombre }}</td>
                        <td class="text-muted small">{{ $script->created_at->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <a href="{{ route('scripts.show', $script) }}" class="btn btn-sm btn-outline-secondary" title="Ver">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if(Auth::id() === $script->creado_por || Auth::user()->rol === 'admin')
                            <a href="{{ route('scripts.edit', $script) }}" class="btn btn-sm btn-outline-primary" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('scripts.destroy', $script) }}" class="d-inline"
                                onsubmit="return confirm('¿Estás seguro de eliminar este script?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                            No hay scripts registrados
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($scripts->hasPages())
    <div class="card-footer bg-white border-0">
        {{ $scripts->withQueryString()->links() }}
    </div>
    @endif
</div>

@endsection