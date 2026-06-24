<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación
|--------------------------------------------------------------------------
*/

// Ruta raíz redirige al login
Route::get('/', function () {
    return redirect()->route('login');
});

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login.post');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Cambio de contraseña obligatorio (primer login)
Route::get('/cambiar-password', [AuthController::class, 'showCambiarPassword'])->name('auth.cambiar-password');
Route::post('/cambiar-password', [AuthController::class, 'cambiarPassword'])->name('auth.cambiar-password.post');

/*
|--------------------------------------------------------------------------
| Rutas Protegidas (requieren autenticación)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

});