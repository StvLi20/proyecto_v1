<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriasScript extends Model
{
    use SoftDeletes;
    protected $table = 'categorias_script';
    protected $fillable = ['nombre', 'descripcion'];
    public $timestamps = false;

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function scripts()
{
    return $this->hasMany(Script::class, 'categoria_id');
}
}

