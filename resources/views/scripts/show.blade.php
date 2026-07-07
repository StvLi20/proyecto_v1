@extends('layouts.app')

@section('title', $script->titulo)
@section('page-title', 'Detalle del Script')

@section('content')

<div class="row g-4">

    {{-- Columna principal --}}
    <div class="col-md-8">

        {{-- Código --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-3">
                <h6 class="fw-bold mb-0">
    @if($script->tipo === 'bash')
        <i class="bi bi-terminal me-2 text-muted"></i>
    @else
        <i class="bi bi-database me-2 text-muted"></i>
    @endif
    {{ $script->titulo }}
    <span class="badge ms-2 {{ $script->tipo === 'bash' ? 'bg-warning text-dark' : 'bg-primary' }}">
        {{ strtoupper($script->tipo) }}
    </span>
</h6>
                <button class="btn btn-sm btn-outline-secondary" id="btnCopiar" onclick="copiarCodigo()">
                    <i class="bi bi-clipboard me-1"></i> Copiar
                </button>
            </div>
            <div class="card-body p-0">
    <div id="monacoViewer" style="height:400px; border-radius:0 0 8px 8px;"></div>
</div>
        </div>

        {{-- Historial de versiones --}}
        @if($script->versiones->count() > 0)
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-clock-history me-2 text-muted"></i>
                    Historial de versiones
                    <span class="badge bg-secondary ms-1">{{ $script->versiones->count() }}</span>
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="accordion" id="accordionVersiones">
                    @foreach($script->versiones->sortByDesc('created_at') as $index => $version)
                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed py-2" type="button"
                                data-bs-toggle="collapse" data-bs-target="#version{{ $index }}">
                                <small>
                                    <i class="bi bi-person me-2 text-muted"></i>
                                    {{ $version->modificadoPor->nombre }}
                                    <span class="text-muted ms-2">{{ $version->created_at->format('d/m/Y H:i') }}</span>
                                </small>
                            </button>
                        </h2>
                        <div id="version{{ $index }}" class="accordion-collapse collapse">
                            <div class="accordion-body p-0">
                                <pre class="m-0 p-3"
                                    style="background:#1a1a1a; color:#aaa; font-size:0.8rem; overflow-x:auto; max-height:250px;"><code>{{ $version->codigo_anterior }}</code></pre>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

    </div>

    {{-- Columna lateral --}}
    <div class="col-md-4">

        {{-- Info del script --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-info-circle me-2 text-muted"></i>Información
                </h6>
            </div>
            <div class="card-body">

                @if($script->descripcion)
                <p class="text-muted small mb-3">{{ $script->descripcion }}</p>
                <hr>
                @endif

                <div class="mb-2">
    <span class="text-muted small">Motores</span>
    <div class="d-flex flex-wrap gap-1 mt-1">
        @foreach($script->motores as $motor)
            <span class="badge bg-primary bg-opacity-10 text-primary">
                {{ $motor->nombre }}
            </span>
        @endforeach
    </div>
</div>

                <div class="mb-2">
                    <span class="text-muted small">Categoría</span>
                    <div class="fw-semibold small">{{ $script->categoria->nombre }}</div>
                </div>

                <div class="mb-2">
                    <span class="text-muted small">Autor</span>
                    <div class="fw-semibold small">{{ $script->autor->nombre }}</div>
                </div>

                <div class="mb-3">
                    <span class="text-muted small">Fecha de creación</span>
                    <div class="fw-semibold small">{{ $script->created_at->format('d/m/Y H:i') }}</div>
                </div>

                @if($script->etiquetas->count() > 0)
                <div>
                    <span class="text-muted small">Etiquetas</span>
                    <div class="d-flex flex-wrap gap-1 mt-1">
                        @foreach($script->etiquetas as $etiqueta)
                            <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                {{ $etiqueta->nombre }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="mb-2 mt-2">
    <span class="text-muted small">Tipo</span>
    <div>
        <span class="badge {{ $script->tipo === 'bash' ? 'bg-warning text-dark' : 'bg-primary' }}">
            {{ strtoupper($script->tipo) }}
        </span>
    </div>
</div>

            </div>
        </div>

        {{-- Acciones --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex flex-column gap-2">

                @if(Auth::id() === $script->creado_por || Auth::user()->rol === 'admin' || Auth::user()->rol === 'dba')
                <a href="{{ route('scripts.edit', $script) }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-pencil me-2"></i>Editar Script
                </a>
                <form method="POST" action="{{ route('scripts.destroy', $script) }}"
                    onsubmit="return confirm('¿Estás seguro de eliminar este script?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                        <i class="bi bi-trash me-2"></i>Eliminar Script
                    </button>
                </form>
                <hr class="my-1">
                @endif

                {{-- Botón favorito --}}
@php
    $esFavorito = \App\Models\Favorito::where('usuario_id', Auth::id())
        ->where('script_id', $script->id)
        ->exists();
@endphp
            <form method="POST" action="{{ route('favoritos.toggle', $script) }}">
                @csrf
                        <button type="submit" class="btn btn-sm w-100 {{ $esFavorito ? 'btn-warning' : 'btn-outline-warning' }}">
                            <i class="bi bi-star{{ $esFavorito ? '-fill' : '' }} me-2"></i>
                            {{ $esFavorito ? 'Quitar de favoritos' : 'Agregar a favoritos' }}
                        </button>
                    </form>

                    <a href="{{ route('scripts.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-2"></i>Volver al catálogo
                    </a>

                

            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/monaco-editor@0.44.0/min/vs/loader.js"></script>
<script>
    require.config({ paths: { vs: 'https://cdn.jsdelivr.net/npm/monaco-editor@0.44.0/min/vs' } });

    require(['vs/editor/editor.main'], function() {
        const codigo   = @json($script->codigo);
        const lenguaje = '{{ $script->tipo }}' === 'bash' ? 'shell' : 'sql';

        monaco.editor.create(document.getElementById('monacoViewer'), {
            value: codigo,
            language: lenguaje,
            theme: 'vs-dark',
            fontSize: 14,
            readOnly: true,
            minimap: { enabled: false },
            scrollBeyondLastLine: false,
            automaticLayout: true,
            lineNumbers: 'on',
            wordWrap: 'on',
        });
    });

    function copiarCodigo() {
        const codigo = @json($script->codigo);
        navigator.clipboard.writeText(codigo).then(() => {
            const btn = document.getElementById('btnCopiar');
            btn.innerHTML = '<i class="bi bi-check me-1"></i> Copiado';
            btn.classList.replace('btn-outline-secondary', 'btn-success');
            setTimeout(() => {
                btn.innerHTML = '<i class="bi bi-clipboard me-1"></i> Copiar';
                btn.classList.replace('btn-success', 'btn-outline-secondary');
            }, 2000);
        });
    }
</script>
@endpush