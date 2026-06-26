<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriasScript extends Model
{
    protected $table = 'categorias_script';
    protected $fillable = ['nombre', 'descripcion'];
    public $timestamps = false;

    public function scripts()
{
    return $this->hasMany(Script::class, 'categoria_id');
}
}

