<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorito extends Model
{
    protected $table = 'favoritos';
    protected $fillable = ['usuario_id', 'script_id'];
    public $timestamps = false;

    // Usuario que marcó el favorito
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // Script marcado
    public function script()
    {
        return $this->belongsTo(Script::class, 'script_id');
    }
}