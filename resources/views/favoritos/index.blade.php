@extends('layouts.app')

@section('title', 'Mis Favoritos')
@section('page-title', 'Mis Favoritos')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 pt-3">
        <h6 class="fw-bold mb-0">
            <i class="bi bi-star-fill text-warning me-2"></i>
            Mis Favoritos <span class="badge bg-secondary ms-1">{{ $favoritos->count() }}</span>
        </h6>
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
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($favoritos as $favorito)
                    <tr>
                        <td>
                            <a href="{{ route('scripts.show', $favorito->script) }}" class="text-decoration-none fw-semibold">
                                {{ $favorito->script->titulo }}
                            </a>
                            @if($favorito->script->descripcion)
                                <div class="text-muted small">{{ Str::limit($favorito->script->descripcion, 60) }}</div>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                {{ $favorito->script->motor->nombre }}
                            </span>
                        </td>
                        <td>{{ $favorito->script->categoria->nombre }}</td>
                        <td>{{ $favorito->script->autor->nombre }}</td>
                        <td class="text-center">
                            <a href="{{ route('scripts.show', $favorito->script) }}" class="btn btn-sm btn-outline-secondary" title="Ver">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('favoritos.toggle', $favorito->script) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Quitar de favoritos">
                                    <i class="bi bi-star-fill"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="bi bi-star fs-4 d-block mb-2"></i>
                            No tenés scripts en favoritos aún
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection