@extends('layouts.app')

@section('title', 'Editar Script')
@section('page-title', 'Editar Script')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 pt-3">
        <h6 class="fw-bold mb-0">
            <i class="bi bi-pencil me-2 text-muted"></i>Editar script
        </h6>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('scripts.update', $script) }}" id="formScript">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <div class="col-md-8">
                    <label class="form-label fw-semibold">Título <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('titulo') is-invalid @enderror"
                        name="titulo" value="{{ old('titulo', $script->titulo) }}" required>
                    @error('titulo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Motores <span class="text-danger">*</span></label>
                    <div class="d-flex flex-wrap gap-2 @error('motores') is-invalid @enderror">
                        @foreach($motores as $motor)
                        <input type="checkbox" class="btn-check" name="motores[]"
                            value="{{ $motor->id }}" id="motor_{{ $motor->id }}"
                            {{ in_array($motor->id, old('motores', $script->motores->pluck('id')->toArray())) ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary btn-sm" for="motor_{{ $motor->id }}">
                            {{ $motor->nombre }}
                        </label>
                        @endforeach
                    </div>
                    @error('motores')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Categoría <span class="text-danger">*</span></label>
                    <select class="form-select @error('categoria_id') is-invalid @enderror" name="categoria_id" required>
                        <option value="">Seleccioná una categoría</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}"
                                {{ old('categoria_id', $script->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoria_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Etiquetas</label>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($etiquetas as $etiqueta)
                        <input type="checkbox" class="btn-check" name="etiquetas[]"
                            value="{{ $etiqueta->id }}" id="etiqueta_{{ $etiqueta->id }}"
                            {{ in_array($etiqueta->id, old('etiquetas', $script->etiquetas->pluck('id')->toArray())) ? 'checked' : '' }}>
                        <label class="btn btn-outline-secondary btn-sm" for="etiqueta_{{ $etiqueta->id }}">
                            {{ $etiqueta->nombre }}
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Descripción</label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror"
                        name="descripcion" rows="2">{{ old('descripcion', $script->descripcion) }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Código <span class="text-danger">*</span></label>

                    <input type="hidden" name="tipo" id="tipo" value="{{ old('tipo', $script->tipo) }}">
                    <ul class="nav nav-tabs mb-0" id="tabsTipo">
                        <li class="nav-item">
                            <button type="button" class="nav-link {{ old('tipo', $script->tipo) === 'sql' ? 'active' : '' }}" id="tab-sql" onclick="cambiarTipo('sql')">
                                <i class="bi bi-database me-1"></i> SQL
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link {{ old('tipo', $script->tipo) === 'bash' ? 'active' : '' }}" id="tab-bash" onclick="cambiarTipo('bash')">
                                <i class="bi bi-terminal me-1"></i> Bash
                            </button>
                        </li>
                    </ul>

                    <div id="monacoEditor" style="height:350px; border:1px solid #333; border-top:none; border-radius:0 0 6px 6px;"></div>
                    <textarea name="codigo" id="codigoHidden" style="display:none;">{{ old('codigo', $script->codigo) }}</textarea>
                    @error('codigo')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="button" class="btn btn-primary" onclick="guardarScript()">
                    <i class="bi bi-save me-2"></i>Guardar Cambios
                </button>
                <a href="{{ route('scripts.show', $script) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x me-2"></i>Cancelar
                </a>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/monaco-editor@0.44.0/min/vs/loader.js"></script>
<script>
    require.config({ paths: { vs: 'https://cdn.jsdelivr.net/npm/monaco-editor@0.44.0/min/vs' } });

    let editor = null;

    require(['vs/editor/editor.main'], function() {
        const tipoInicial = document.getElementById('tipo').value;
        const lenguaje    = tipoInicial === 'bash' ? 'shell' : 'sql';

        editor = monaco.editor.create(document.getElementById('monacoEditor'), {
            value: document.getElementById('codigoHidden').value,
            language: lenguaje,
            theme: 'vs-dark',
            fontSize: 14,
            minimap: { enabled: false },
            scrollBeyondLastLine: false,
            automaticLayout: true,
            lineNumbers: 'on',
            roundedSelection: true,
            wordWrap: 'on',
        });
    });

    window.guardarScript = function() {
        if (editor) {
            document.getElementById('codigoHidden').value = editor.getValue();
        }
        document.getElementById('formScript').requestSubmit();
    }

    function cambiarTipo(tipo) {
        document.getElementById('tipo').value = tipo;

        const tabSql  = document.getElementById('tab-sql');
        const tabBash = document.getElementById('tab-bash');

        if (tipo === 'sql') {
            tabSql.classList.add('active');
            tabBash.classList.remove('active');
            if (editor) monaco.editor.setModelLanguage(editor.getModel(), 'sql');
        } else {
            tabBash.classList.add('active');
            tabSql.classList.remove('active');
            if (editor) monaco.editor.setModelLanguage(editor.getModel(), 'shell');
        }
    }
</script>
@endpush