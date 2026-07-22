@extends('layouts.app')

@section('title', 'Usuarios Eliminados')
@section('page-title', 'Usuarios Eliminados')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-3">
    <h6 class="fw-bold mb-0">
        <i class="bi bi-person-slash me-2 text-muted"></i>
        Usuarios Eliminados <span class="badge bg-danger ms-1">{{ $usuarios->count() }}</span>
    </h6>
    <div class="ms-auto">
        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Volver a Usuarios
        </a>
    </div>
</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Eliminado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $usuario)
                    <tr class="text-muted">
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($usuario->foto)
                                    <img src="{{ asset('storage/' . $usuario->foto) }}"
                                        class="rounded-circle"
                                        style="width:32px; height:32px; object-fit:cover; opacity:0.5;">
                                @else
                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                        style="width:32px; height:32px; opacity:0.5;">
                                        <i class="bi bi-person-fill text-white small"></i>
                                    </div>
                                @endif
                                <span>{{ $usuario->nombre }}</span>
                            </div>
                        </td>
                        <td class="small">{{ $usuario->correo }}</td>
                        <td>
                            @if($usuario->rol === 'admin')
                                <span class="badge bg-danger bg-opacity-10 text-danger">Admin</span>
                            @elseif($usuario->rol === 'dba')
                                <span class="badge bg-primary bg-opacity-10 text-primary">DBA</span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary">Consulta</span>
                            @endif
                        </td>
                        <td class="small">{{ $usuario->deleted_at->format('d/m/Y H:i') }}</td>
                        <td class="text-center">
                            <form method="POST" action="{{ route('admin.usuarios.restaurar', $usuario->id) }}"
                                class="d-inline"
                                onsubmit="event.preventDefault(); confirmarAccion(this, '¿Estás seguro de restaurar al usuario {{ $usuario->nombre }}?', 'Confirmar restauración')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-success" title="Restaurar">
                                    <i class="bi bi-arrow-counterclockwise"></i> Restaurar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="bi bi-check-circle fs-4 d-block mb-2 text-success"></i>
                            No hay usuarios eliminados
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection