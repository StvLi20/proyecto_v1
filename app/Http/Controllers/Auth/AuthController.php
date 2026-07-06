<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Muestra el formulario de login
     */
    public function showLogin()
    {
        // Si ya está autenticado, redirigir al dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    /**
     * Procesa el intento de login
     */
    public function login(Request $request)
{
    // Validar los campos del formulario
    $request->validate([
        'correo'   => 'required|email',
        'password' => 'required|min:1',
    ], [
        'correo.required'   => 'El correo es obligatorio.',
        'correo.email'      => 'Ingresá un correo válido.',
        'password.required' => 'La contraseña es obligatoria.',
        'password.min'      => 'La contraseña debe tener al menos 14 caracteres.',
    ]);

    // Buscar usuario por correo manualmente
    $usuario = \App\Models\Usuario::where('correo', $request->correo)->first();

    if ($usuario && \Illuminate\Support\Facades\Hash::check($request->password, $usuario->password)) {
        Auth::login($usuario);
        $request->session()->regenerate();

        // Si es primer login, forzar cambio de contraseña
        if (Auth::user()->primer_login) {
            return redirect()->route('auth.cambiar-password');
        }

        return redirect('/dashboard');
    }

    // Credenciales incorrectas
    return back()->withErrors([
        'correo' => 'Correo o contraseña incorrectos.',
    ])->onlyInput('correo');
}

    /**
     * Cierra la sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    /**
     * Muestra el formulario de cambio de contraseña obligatorio
     */
    public function showCambiarPassword()
    {
        // Solo accesible si es primer login
        if (!Auth::user()->primer_login) {
            return redirect()->route('dashboard');
        }
        return view('auth.cambiar-password');
    }

    /**
     * Procesa el cambio de contraseña obligatorio
     */
    public function cambiarPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:14|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        ], [
            'password.required'  => 'La contraseña es obligatoria.',
            'password.min'       => 'La contraseña debe tener al menos 14 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.regex'     => 'La contraseña debe contener mayúsculas, minúsculas y números.',
        ]);

        // Actualizar password y marcar primer_login como false
        $usuario = Auth::user();
        $usuario->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $usuario->primer_login = false;
        $usuario->save();

        return redirect()->route('dashboard');
    }
}