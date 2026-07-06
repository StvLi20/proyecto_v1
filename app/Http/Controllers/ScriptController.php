<?php

namespace App\Http\Controllers;

use App\Models\Script;
use App\Models\Motor;
use App\Models\CategoriasScript;
use App\Models\Etiqueta;
use App\Models\VersionScript;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScriptController extends Controller
{
    /**
     * Lista todos los scripts con filtros
     */
    public function index(Request $request)
    {
        $query = Script::with(['motores', 'categoria', 'autor']);

        // Filtro por motor
if ($request->filled('motor_id')) {
    $query->whereHas('motores', function ($q) use ($request) {
        $q->where('motores.id', $request->motor_id);
    });
}

        // Filtro por categoría
        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        // Búsqueda por palabra clave
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('titulo', 'like', "%$buscar%")
                  ->orWhere('descripcion', 'like', "%$buscar%")
                  ->orWhere('codigo', 'like', "%$buscar%");
            });
        }

        $scripts    = $query->orderBy('created_at', 'desc')->paginate(10);
        $motores    = Motor::all();
        $categorias = CategoriasScript::all();

        return view('scripts.index', compact('scripts', 'motores', 'categorias'));
    }

    /**
     * Muestra el formulario para crear un script
     */
    public function create()
    {
        $motores    = Motor::all();
        $categorias = CategoriasScript::all();
        $etiquetas  = Etiqueta::all();

        return view('scripts.create', compact('motores', 'categorias', 'etiquetas'));
    }

    /**
     * Guarda un nuevo script
     */
    public function store(Request $request)
    {
        $request->validate([
    'titulo'       => 'required|max:200',
    'descripcion'  => 'nullable|max:500',
    'codigo'       => 'required',
    'motores'      => 'required|array|min:1',
    'motores.*'    => 'exists:motores,id',
    'categoria_id' => 'required|exists:categorias_script,id',
    'etiquetas'    => 'nullable|array',
    'etiquetas.*'  => 'exists:etiquetas,id',
], [
    'titulo.required'       => 'El título es obligatorio.',
    'titulo.max'            => 'El título no puede superar 200 caracteres.',
    'codigo.required'       => 'El código SQL es obligatorio.',
    'motores.required'      => 'Seleccioná al menos un motor.',
    'motores.min'           => 'Seleccioná al menos un motor.',
    'categoria_id.required' => 'Seleccioná una categoría.',
]);

$script = Script::create([
    'titulo'       => $request->titulo,
    'descripcion'  => $request->descripcion,
    'codigo'       => $request->codigo,
    'categoria_id' => $request->categoria_id,
    'creado_por'   => Auth::id(),
]);

// Asignar motores
$script->motores()->attach($request->motores);

// Asignar etiquetas si hay
if ($request->filled('etiquetas')) {
    $script->etiquetas()->attach($request->etiquetas);
}

return redirect()->route('scripts.index')
    ->with('success', 'Script registrado exitosamente.');
    }

    /**
     * Muestra el detalle de un script
     */
    public function show(Script $script)
    {
        $script->load(['motores', 'categoria', 'autor', 'etiquetas', 'versiones.modificadoPor']);
        return view('scripts.show', compact('script'));
    }

    /**
     * Muestra el formulario para editar un script
     */
    public function edit(Script $script)
    {
        // Solo el autor o admin puede editar
         if (Auth::id() !== $script->creado_por && Auth::user()->rol !== 'admin' && Auth::user()->rol !== 'dba') {
            return redirect()->route('scripts.index')
                ->with('error', 'No tenés permiso para editar este script.');
        }

        $motores    = Motor::all();
        $categorias = CategoriasScript::all();
        $etiquetas  = Etiqueta::all();

        return view('scripts.edit', compact('script', 'motores', 'categorias', 'etiquetas'));
    }

    /**
     * Actualiza un script guardando la versión anterior
     */
    public function update(Request $request, Script $script)
    {
        $request->validate([
    'titulo'       => 'required|max:200',
    'descripcion'  => 'nullable|max:500',
    'codigo'       => 'required',
    'motores'      => 'required|array|min:1',
    'motores.*'    => 'exists:motores,id',
    'categoria_id' => 'required|exists:categorias_script,id',
    'etiquetas'    => 'nullable|array',
    'etiquetas.*'  => 'exists:etiquetas,id',
]);

// Guardar versión anterior
VersionScript::create([
    'script_id'       => $script->id,
    'codigo_anterior' => $script->codigo,
    'modificado_por'  => Auth::id(),
]);

$script->update([
    'titulo'       => $request->titulo,
    'descripcion'  => $request->descripcion,
    'codigo'       => $request->codigo,
    'categoria_id' => $request->categoria_id,
]);

// Sincronizar motores y etiquetas
$script->motores()->sync($request->motores);
$script->etiquetas()->sync($request->etiquetas ?? []);
return redirect()->route('scripts.show', $script)
    ->with('success', 'Script actualizado. Versión anterior guardada.');

    }

    /**
     * Elimina un script
     */
    public function destroy(Script $script)
{
    // Solo el autor, DBA o admin puede eliminar
    if (Auth::id() !== $script->creado_por && Auth::user()->rol !== 'admin' && Auth::user()->rol !== 'dba') {
        return redirect()->route('scripts.index')
            ->with('error', 'No tenés permiso para eliminar este script.');
    }

    // Eliminar favoritos asociados antes del soft delete
    \App\Models\Favorito::where('script_id', $script->id)->delete();

    $script->delete();

    return redirect()->route('scripts.index')
        ->with('success', 'Script eliminado exitosamente.');
}
}