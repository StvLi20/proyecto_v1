<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etiqueta extends Model
{
    protected $table = 'etiquetas';
    protected $fillable = ['nombre'];
    public $timestamps = false;

    public function scripts()
    {
        return $this->belongsToMany(
            Script::class,
            'script_etiqueta',
            'etiqueta_id',
            'script_id'
        );
    }
}