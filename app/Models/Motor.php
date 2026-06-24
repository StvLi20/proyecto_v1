<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Motor extends Model
{
    protected $table = 'motores';
    protected $fillable = ['nombre'];
    public $timestamps = false;
}