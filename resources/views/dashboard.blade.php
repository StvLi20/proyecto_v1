@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Tarjetas de estadísticas --}}
<div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded p-3" style="background: rgba(99,102,241,0.1)">
                    <i class="bi bi-code-square fs-3" style="color:#6366f1"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Scripts</div>
                    <div class="fw-bold fs-3">{{ $totalScripts }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded p-3" style="background: rgba(16,185,129,0.1)">
                    <i class="bi bi-star fs-3" style="color:#10b981"></i>
                </div>
                <div>
                    <div class="text-muted small">Mis Favoritos</div>
                    <div class="fw-bold fs-3">{{ $totalFavoritos }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded p-3" style="background: rgba(245,158,11,0.1)">
                    <i class="bi bi-tags fs-3" style="color:#f59e0b"></i>
                </div>
                <div>
                    <div class="text-muted small">Categorías</div>
                    <div class="fw-bold fs-3">{{ $totalCategorias }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded p-3" style="background: rgba(59,130,246,0.1)">
                    <i class="bi bi-people fs-3" style="color:#3b82f6"></i>
                </div>
                <div>
                    <div class="text-muted small">Usuarios</div>
                    <div class="fw-bold fs-3">{{ $totalUsuarios }}</div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Últimos scripts --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 pt-3">
        <h6 class="fw-bold mb-0">
            <i class="bi bi-clock-history me-2 text-muted"></i>Últimos scripts agregados
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
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ultimosScripts as $script)
                    <tr>
                        <td>
                            <i class="bi bi-code-square text-muted me-2"></i>
                            {{ $script->titulo }}
                        </td>
                        <td>
                           @foreach($script->motores as $motor)
    <span class="badge bg-primary bg-opacity-10 text-primary me-1">
        {{ $motor->nombre }}
    </span>
@endforeach
                        </td>
                        <td>{{ $script->categoria->nombre }}</td>
                        <td>{{ $script->autor->nombre }}</td>
                        <td class="text-muted small">{{ $script->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                            No hay scripts registrados aún
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection