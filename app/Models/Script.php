<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Script extends Model
{
    use SoftDeletes;
    protected $table = 'scripts';
    const UPDATED_AT = null;
    protected $fillable = [
        'titulo',
        'descripcion',
        'codigo',
        'motor_id',
        'categoria_id',
        'creado_por'
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    // Motor al que pertenece
    public function motor()
    {
        return $this->belongsTo(Motor::class, 'motor_id');
    }

    // Categoría a la que pertenece
    public function categoria()
    {
        return $this->belongsTo(CategoriasScript::class, 'categoria_id');
    }

    // Usuario que lo creó
    public function autor()
    {
        return $this->belongsTo(Usuario::class, 'creado_por');
    }

    // Versiones anteriores del script
    public function versiones()
    {
        return $this->hasMany(VersionScript::class, 'script_id');
    }

    // Etiquetas asignadas (muchos a muchos)
    public function etiquetas()
    {
        return $this->belongsToMany(
            Etiqueta::class,
            'script_etiqueta',
            'script_id',
            'etiqueta_id'
        );
    }

    // Usuarios que lo marcaron como favorito
    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'script_id');
    }
}