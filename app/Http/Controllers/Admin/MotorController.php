<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Motor;
use Illuminate\Http\Request;

class MotorController extends Controller
{
    public function index()
    {
        $motores = Motor::orderBy('nombre')->paginate(10);
        return view('admin.motores.index', compact('motores'));
    }

    public function create()
    {
        return view('admin.motores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:50|unique:motores,nombre',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max'      => 'El nombre no puede superar 50 caracteres.',
            'nombre.unique'   => 'Ya existe un motor con ese nombre.',
        ]);

        Motor::create(['nombre' => $request->nombre]);

        return redirect()->route('admin.motores.index')
            ->with('success', 'Motor creado exitosamente.');
    }

    public function edit(Motor $motor)
    {
        return view('admin.motores.edit', compact('motor'));
    }

    public function update(Request $request, Motor $motor)
    {
        $request->validate([
            'nombre' => 'required|max:50|unique:motores,nombre,' . $motor->id,
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.unique'   => 'Ya existe un motor con ese nombre.',
        ]);

        $motor->update(['nombre' => $request->nombre]);

        return redirect()->route('admin.motores.index')
            ->with('success', 'Motor actualizado exitosamente.');
    }

    public function destroy(Motor $motor)
    {
        if ($motor->scripts()->count() > 0) {
            return redirect()->route('admin.motores.index')
                ->with('error', 'No se puede eliminar el motor porque tiene scripts asociados.');
        }

        $motor->delete();

        return redirect()->route('admin.motores.index')
            ->with('success', 'Motor eliminado exitosamente.');
    }
}