<?php

namespace App\Http\Controllers;

use App\Models\Script;
use App\Models\Usuario;
use App\Models\CategoriasScript;
use App\Models\Motor;
use App\Models\Favorito;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Tarjetas
        $totalScripts = Script::count();
        $totalCategorias = CategoriasScript::count();
        $totalUsuarios = Usuario::count();
        $totalFavoritos = Favorito::where('usuario_id', Auth::id())->count();

        // Últimos 5 scripts
        $ultimosScripts = Script::with(['motores', 'categoria', 'autor'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Scripts por motor para gráfica
        $scriptsPorMotor = Motor::withCount('scripts')
            ->orderBy('scripts_count', 'desc')
            ->get()
            ->map(fn($m) => ['nombre' => $m->nombre, 'total' => $m->scripts_count]);

        // Scripts por categoría para gráfica
        $scriptsPorCategoria = CategoriasScript::withCount('scripts')
            ->orderBy('scripts_count', 'desc')
            ->get()
            ->map(fn($c) => ['nombre' => $c->nombre, 'total' => $c->scripts_count]);

        // Scripts por tipo
        $scriptsPorTipo = Script::select('tipo', DB::raw('count(*) as total'))
            ->groupBy('tipo')
            ->get()
            ->map(fn($s) => ['tipo' => strtoupper($s->tipo), 'total' => $s->total]);

        // Top 5 scripts más favoriteados
        $topFavoritos = Script::with(['motores', 'categoria'])
            ->withCount('favoritos')
            ->orderBy('favoritos_count', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalScripts',
            'totalCategorias',
            'totalUsuarios',
            'totalFavoritos',
            'ultimosScripts',
            'scriptsPorMotor',
            'scriptsPorCategoria',
            'scriptsPorTipo',
            'topFavoritos'
        ));
    }
}