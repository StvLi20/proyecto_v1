<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Motor extends Model
{
    use SoftDeletes;
    protected $table = 'motores';
    protected $fillable = ['nombre'];
    public $timestamps = false;

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

 public function scripts()
{
    return $this->belongsToMany(
        Script::class,
        'script_motor',
        'motor_id',
        'script_id'
    );
}
}