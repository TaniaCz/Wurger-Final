<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'venta';
    protected $primaryKey = 'id_venta';

    protected $fillable = [
        'fecha',
        'estado',
        'Total_venta',
        'id_usuario',
        'id_pedido'
    ];

    protected $casts = [
        'fecha' => 'date',
        'Total_venta' => 'decimal:2',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'id_venta', 'id_venta');
    }

    public function formaPagos()
    {
        return $this->hasMany(FormaPago::class, 'id_venta', 'id_venta');
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');
    }
}
