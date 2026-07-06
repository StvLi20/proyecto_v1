<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Etiqueta extends Model
{
    use SoftDeletes;
    protected $table = 'etiquetas';
    protected $fillable = ['nombre'];
    public $timestamps = false;

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

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