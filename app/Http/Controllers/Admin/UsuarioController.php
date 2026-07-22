<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    /**
     * Lista todos los usuarios
     */
    public function index()
    {
        $usuarios = Usuario::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.usuarios.index', compact('usuarios'));
    }

    /**
     * Muestra el formulario para crear un usuario
     */
    public function create()
    {
        return view('admin.usuarios.create');
    }

    /**
     * Guarda un nuevo usuario
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'correo' => 'required|email|unique:usuarios,correo|regex:/@bancatlan\.hn$/',
            'rol' => 'required|in:admin,dba,consulta',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede superar 100 caracteres.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'Ingresá un correo válido.',
            'correo.unique' => 'Este correo ya está registrado.',
            'correo.regex' => 'El correo debe estar en dominio @bancatlan.hn.',
            'rol.required' => 'Seleccioná un rol.',
            'rol.in' => 'El rol seleccionado no es válido.',
        ]);

        // Generar contraseña temporal aleatoria
        $passwordTemporal = Str::random(10) . 'A1@#';

        Usuario::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'password' => Hash::make($passwordTemporal),
            'rol' => $request->rol,
            'primer_login' => true,
            'creado_por' => auth()->id(),
        ]);

        return redirect()->route('admin.usuarios.index')
            ->with('success', "Usuario creado. Contraseña temporal: $passwordTemporal");
    }

    /**
     * Muestra el formulario para editar un usuario
     */
    public function edit(Usuario $usuario)
    {
        return view('admin.usuarios.edit', compact('usuario'));
    }

    /**
     * Actualiza un usuario
     */
    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'correo' => 'required|email|unique:usuarios,correo,' . $usuario->id . '|regex:/@bancatlan\.hn$/',
            'rol' => 'required|in:admin,dba,consulta',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'Ingresá un correo válido.',
            'correo.unique' => 'Este correo ya está registrado.',
            'correo.regex' => 'El correo debe estar en dominio @bancatlan.hn.',
            'rol.required' => 'Seleccioná un rol.',
        ]);

        $usuario->update([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'rol' => $request->rol,
        ]);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Resetea la contraseña de un usuario
     */
    public function resetPassword(Usuario $usuario)
    {
        $passwordTemporal = Str::random(10) . 'A1@#';

        $usuario->password = Hash::make($passwordTemporal);
        $usuario->primer_login = true;
        $usuario->save();

        return redirect()->route('admin.usuarios.index')
            ->with('success', "Contraseña reseteada. Nueva contraseña temporal: $passwordTemporal");
    }

    /**
     * Elimina un usuario
     */
    public function destroy(Usuario $usuario)
    {
        // No permitir eliminar el propio usuario
        if ($usuario->id === auth()->id()) {
            return redirect()->route('admin.usuarios.index')
                ->with('error', 'No podés eliminar tu propio usuario.');
        }

        $usuario->delete();

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }

    /**
     * Lista los usuarios eliminados
     */
    public function eliminados()
    {
        $usuarios = Usuario::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('admin.usuarios.eliminados', compact('usuarios'));
    }

    /**
     * Restaura un usuario eliminado
     */
    public function restaurar($id)
    {
        $usuario = Usuario::onlyTrashed()->findOrFail($id);
        $usuario->restore();

        return redirect()->route('admin.usuarios.eliminados')
            ->with('success', 'Usuario restaurado exitosamente.');
    }
}