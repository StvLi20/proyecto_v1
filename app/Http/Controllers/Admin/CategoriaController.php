<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoriasScript;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = CategoriasScript::orderBy('nombre')->get();
        return view('admin.categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('admin.categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|max:100|unique:categorias_script,nombre',
            'descripcion' => 'nullable|max:255',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max'      => 'El nombre no puede superar 100 caracteres.',
            'nombre.unique'   => 'Ya existe una categoría con ese nombre.',
        ]);

        CategoriasScript::create([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría creada exitosamente.');
    }

    public function edit(CategoriasScript $categoria)
    {
        return view('admin.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, CategoriasScript $categoria)
    {
        $request->validate([
            'nombre'      => 'required|max:100|unique:categorias_script,nombre,' . $categoria->id,
            'descripcion' => 'nullable|max:255',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.unique'   => 'Ya existe una categoría con ese nombre.',
        ]);

        $categoria->update([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría actualizada exitosamente.');
    }

    public function destroy(CategoriasScript $categoria)
    {
        // Verificar si tiene scripts asociados
        if ($categoria->scripts()->count() > 0) {
            return redirect()->route('admin.categorias.index')
                ->with('error', 'No se puede eliminar la categoría porque tiene scripts asociados.');
        }

        $categoria->delete();

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría eliminada exitosamente.');
    }
}