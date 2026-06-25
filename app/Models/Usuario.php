<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'nombre',
        'correo',
        'password',
        'rol',
        'primer_login',
        'creado_por'
    ];

    protected $casts = [
        'primer_login' => 'boolean',
        
    ];

    // Laravel usa 'email' por defecto, nosotros usamos 'correo'
    public function getAuthIdentifierName()
    {
        return 'correo';
    }

    // El admin que creó este usuario
    public function creadoPor()
    {
        return $this->belongsTo(Usuario::class, 'creado_por');
    }

    // Usuarios que este admin ha creado
    public function usuariosCreados()
    {
        return $this->hasMany(Usuario::class, 'creado_por');
    }

    // Scripts que ha creado
    public function scripts()
    {
        return $this->hasMany(Script::class, 'creado_por');
    }

    // Scripts marcados como favoritos
    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'usuario_id');
    }

    // Devolver siempre el id numérico
    public function getAuthIdentifier()
    {
        return $this->id;
    }
}