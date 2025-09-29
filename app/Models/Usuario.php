<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'email',
        'password',
        'rol',
        'estado'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function usuarioInfo()
    {
        return $this->hasOne(UsuarioInfo::class, 'id_usuario', 'id_usuario');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'id_usuario', 'id_usuario');
    }

    public function proveedores()
    {
        return $this->hasMany(Proveedor::class, 'id_usuario', 'id_usuario');
    }
}
