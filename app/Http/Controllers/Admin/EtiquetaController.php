<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Etiqueta;
use Illuminate\Http\Request;

class EtiquetaController extends Controller
{
    public function index()
    {
        $etiquetas = Etiqueta::orderBy('nombre')->paginate(10);
        return view('admin.etiquetas.index', compact('etiquetas'));
    }

    public function create()
    {
        return view('admin.etiquetas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:50|unique:etiquetas,nombre',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max'      => 'El nombre no puede superar 50 caracteres.',
            'nombre.unique'   => 'Ya existe una etiqueta con ese nombre.',
        ]);

        Etiqueta::create(['nombre' => $request->nombre]);

        return redirect()->route('admin.etiquetas.index')
            ->with('success', 'Etiqueta creada exitosamente.');
    }

    public function edit(Etiqueta $etiqueta)
    {
        return view('admin.etiquetas.edit', compact('etiqueta'));
    }

    public function update(Request $request, Etiqueta $etiqueta)
    {
        $request->validate([
            'nombre' => 'required|max:50|unique:etiquetas,nombre,' . $etiqueta->id,
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.unique'   => 'Ya existe una etiqueta con ese nombre.',
        ]);

        $etiqueta->update(['nombre' => $request->nombre]);

        return redirect()->route('admin.etiquetas.index')
            ->with('success', 'Etiqueta actualizada exitosamente.');
    }

    public function destroy(Etiqueta $etiqueta)
    {
        // Desasociar de todos los scripts antes de eliminar
        $etiqueta->scripts()->detach();
        $etiqueta->delete();

        return redirect()->route('admin.etiquetas.index')
            ->with('success', 'Etiqueta eliminada exitosamente.');
    }
}