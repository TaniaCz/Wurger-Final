<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioInfo extends Model
{
    use HasFactory;

    protected $table = 'usuario_info';
    protected $primaryKey = 'id_usuario_info';

    protected $fillable = [
        'nombre',
        'telefono',
        'direccion',
        'id_usuario'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_usuario_info', 'id_usuario_info');
    }
}
