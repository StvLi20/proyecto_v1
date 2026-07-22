<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller
{
    /**
     * Muestra la página de perfil
     */
    public function index()
    {
        return view('perfil.index', ['usuario' => Auth::user()]);
    }

    /**
     * Actualiza la foto de perfil
     */
    public function actualizarFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'foto.required' => 'Seleccioná una imagen.',
            'foto.image'    => 'El archivo debe ser una imagen.',
            'foto.mimes'    => 'La imagen debe ser JPG o PNG.',
            'foto.max'      => 'La imagen no puede superar 2MB.',
        ]);

        $usuario = Auth::user();

        // Eliminar foto anterior si existe
        if ($usuario->foto && file_exists(public_path('storage/' . $usuario->foto))) {
            unlink(public_path('storage/' . $usuario->foto));
        }

        // Guardar nueva foto
        $path = $request->file('foto')->store('fotos-perfil', 'public');

        $usuario->foto = $path;
        $usuario->save();

        return back()->with('success', 'Foto de perfil actualizada.');
    }

    /**
     * Actualiza la contraseña
     */
   public function actualizarPassword(Request $request)
{
    $request->validate([
        'password_actual' => 'required',
        'password_nuevo'  => 'required|min:14|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_\-#]).+$/',
    ], [
        'password_actual.required' => 'Ingresá tu contraseña actual.',
        'password_nuevo.required'  => 'Ingresá la nueva contraseña.',
        'password_nuevo.min'       => 'La contraseña debe tener al menos 14 caracteres.',
        'password_nuevo.confirmed' => 'Las contraseñas no coinciden.',
        'password_nuevo.regex'     => 'La contraseña debe contener mayúsculas, minúsculas, números y un carácter especial (@$!%*?&_-#).',
    ]);

    $usuario = \App\Models\Usuario::find(Auth::id());

    if (!Hash::check($request->password_actual, $usuario->password)) {
        return back()->withErrors(['password_actual' => 'La contraseña actual es incorrecta.']);
    }

    $usuario->password = Hash::make($request->password_nuevo);
    $usuario->save();

    return back()->with('success', 'Contraseña actualizada exitosamente.');
}
}