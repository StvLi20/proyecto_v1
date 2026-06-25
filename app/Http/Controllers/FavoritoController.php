<?php

namespace App\Http\Controllers;

use App\Models\Favorito;
use App\Models\Script;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritoController extends Controller
{
    /**
     * Lista los scripts favoritos del usuario autenticado
     */
    public function index()
    {
        $favoritos = Favorito::with(['script.motor', 'script.categoria', 'script.autor'])
            ->where('usuario_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('favoritos.index', compact('favoritos'));
    }

    /**
     * Agrega o quita un script de favoritos (toggle)
     */
    public function toggle(Script $script)
    {
        $favorito = Favorito::where('usuario_id', Auth::id())
            ->where('script_id', $script->id)
            ->first();

        if ($favorito) {
            // Ya existe — quitarlo
            $favorito->delete();
            $mensaje = 'Script eliminado de favoritos.';
        } else {
            // No existe — agregarlo
            Favorito::create([
                'usuario_id' => Auth::id(),
                'script_id'  => $script->id,
            ]);
            $mensaje = 'Script agregado a favoritos.';
        }

        // Si la petición es AJAX devolver JSON, si no redirigir
        if (request()->ajax()) {
            return response()->json(['message' => $mensaje]);
        }

        return back()->with('success', $mensaje);
    }
}