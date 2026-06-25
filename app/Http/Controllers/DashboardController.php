<?php

namespace App\Http\Controllers;

use App\Models\Script;
use App\Models\Usuario;
use App\Models\CategoriasScript;
use App\Models\Motor;
use App\Models\Favorito;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Total de scripts en el catálogo
        $totalScripts = Script::count();

        // Total de categorías
        $totalCategorias = CategoriasScript::count();

        // Total de usuarios
        $totalUsuarios = Usuario::count();

        // Favoritos del usuario autenticado
        $totalFavoritos = Favorito::where('usuario_id', Auth::id())->count();

        // Últimos 5 scripts agregados
        $ultimosScripts = Script::with(['motor', 'categoria', 'autor'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalScripts',
            'totalCategorias',
            'totalUsuarios',
            'totalFavoritos',
            'ultimosScripts'
        ));
    }
}