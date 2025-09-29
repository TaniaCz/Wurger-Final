<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedido';
    protected $primaryKey = 'id_pedido';

    protected $fillable = [
        'fecha',
        'observaciones',
        'estado',
        'id_usuario_info'
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function usuarioInfo()
    {
        return $this->belongsTo(UsuarioInfo::class, 'id_usuario_info', 'id_usuario_info');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'pedido_producto', 'id_pedido', 'id_producto')
                    ->withPivot('cantidad', 'precio_unitario', 'subtotal')
                    ->withTimestamps();
    }

    public function pedidoProductos()
    {
        return $this->hasMany(PedidoProducto::class, 'id_pedido', 'id_pedido');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'id_pedido', 'id_pedido');
    }
}
