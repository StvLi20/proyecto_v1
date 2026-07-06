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
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Scripts
    Route::resource('scripts', App\Http\Controllers\ScriptController::class);

    // Favoritos
    Route::get('/favoritos', [App\Http\Controllers\FavoritoController::class, 'index'])->name('favoritos.index');
    Route::post('/favoritos/{script}/toggle', [App\Http\Controllers\FavoritoController::class, 'toggle'])->name('favoritos.toggle');

    // Perfil
    Route::get('/perfil', [App\Http\Controllers\PerfilController::class, 'index'])->name('perfil.index');
    Route::post('/perfil/foto', [App\Http\Controllers\PerfilController::class, 'actualizarFoto'])->name('perfil.foto');
    Route::post('/perfil/password', [App\Http\Controllers\PerfilController::class, 'actualizarPassword'])->name('perfil.password');

    // Administración - solo admin
    Route::prefix('admin')->name('admin.')->middleware(['auth', 'rol:admin'])->group(function () {
    Route::resource('usuarios', App\Http\Controllers\Admin\UsuarioController::class)->except(['show']);
    Route::post('usuarios/{usuario}/reset-password', [App\Http\Controllers\Admin\UsuarioController::class, 'resetPassword'])->name('usuarios.reset-password');
    Route::resource('categorias', App\Http\Controllers\Admin\CategoriaController::class)->except(['show']);
    Route::resource('motores', App\Http\Controllers\Admin\MotorController::class)->except(['show']);
    Route::resource('etiquetas', App\Http\Controllers\Admin\EtiquetaController::class)->except(['show']);
});

});