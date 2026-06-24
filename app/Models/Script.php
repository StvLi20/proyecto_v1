<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Script extends Model
{
    protected $table = 'scripts';
    protected $fillable = [
        'titulo',
        'descripcion',
        'codigo',
        'motor_id',
        'categoria_id',
        'creado_por'
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