<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VersionScript extends Model
{
    protected $table = 'versiones_script';
    protected $fillable = [
        'script_id',
        'codigo_anterior',
        'modificado_por'
    ];
    protected $casts = [
    'created_at' => 'datetime',
    ];
    public $timestamps = false;

    // Script al que pertenece esta versión
    public function script()
    {
        return $this->belongsTo(Script::class, 'script_id');
    }

    // Usuario que hizo el cambio
    public function modificadoPor()
    {
        return $this->belongsTo(Usuario::class, 'modificado_por');
    }
}