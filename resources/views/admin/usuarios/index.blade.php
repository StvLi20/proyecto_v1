@extends('layouts.app')

@section('title', 'Usuarios')
@section('page-title', 'Gestión de Usuarios')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-3">
        <h6 class="fw-bold mb-0">
            <i class="bi bi-people me-2 text-muted"></i>
            Usuarios <span class="badge bg-secondary ms-1">{{ $usuarios->count() }}</span>
        </h6>
        <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Nuevo Usuario
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Creado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $usuario)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($usuario->foto)
                                    <img src="{{ asset('storage/' . $usuario->foto) }}"
                                        class="rounded-circle"
                                        style="width:32px; height:32px; object-fit:cover;">
                                @else
                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                        style="width:32px; height:32px;">
                                        <i class="bi bi-person-fill text-white small"></i>
                                    </div>
                                @endif
                                <span class="fw-semibold">{{ $usuario->nombre }}</span>
                            </div>
                        </td>
                        <td class="text-muted small">{{ $usuario->correo }}</td>
                        <td>
                            @if($usuario->rol === 'admin')
                                <span class="badge bg-danger bg-opacity-10 text-danger">Admin</span>
                            @elseif($usuario->rol === 'dba')
                                <span class="badge bg-primary bg-opacity-10 text-primary">DBA</span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary">Consulta</span>
                            @endif
                        </td>
                        <td>
                            @if($usuario->primer_login)
                                <span class="badge bg-warning bg-opacity-10 text-warning">
                                    <i class="bi bi-clock me-1"></i>Pendiente
                                </span>
                            @else
                                <span class="badge bg-success bg-opacity-10 text-success">
                                    <i class="bi bi-check me-1"></i>Activo
                                </span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ $usuario->created_at->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.usuarios.edit', $usuario) }}"
                                class="btn btn-sm btn-outline-primary" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.usuarios.reset-password', $usuario) }}"
                                class="d-inline"
                                onsubmit="return confirm('¿Resetear contraseña de {{ $usuario->nombre }}?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-warning" title="Resetear contraseña">
                                    <i class="bi bi-key"></i>
                                </button>
                            </form>
                            @if($usuario->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.usuarios.destroy', $usuario) }}"
                                class="d-inline"
                                onsubmit="return confirm('¿Eliminar usuario {{ $usuario->nombre }}?')">
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
                            <i class="bi bi-people fs-4 d-block mb-2"></i>
                            No hay usuarios registrados
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection