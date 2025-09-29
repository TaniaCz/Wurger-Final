<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'producto';
    protected $primaryKey = 'id_producto';

    protected $fillable = [
        'nombre_producto',
        'stock',
        'stock_min',
        'stock_max',
        'precio_compra',
        'precio_venta',
        'tipo_producto',
        'estado',
        'fecha_ingreso',
        'id_categoria'
    ];

    protected $casts = [
        'fecha_ingreso' => 'date',
        'precio_compra' => 'decimal:2',
        'precio_venta' => 'decimal:2',
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaProducto::class, 'id_categoria', 'id_categoria');
    }

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class, 'id_producto', 'id_producto');
    }

    public function unidadesMedida()
    {
        return $this->hasMany(UnidadMedida::class, 'id_producto', 'id_producto');
    }

    public function productosTerminados()
    {
        return $this->hasMany(ProductoTerminado::class, 'id_producto', 'id_producto');
    }

    public function promociones()
    {
        return $this->hasMany(Promocion::class, 'id_producto', 'id_producto');
    }

    public function pedidoProductos()
    {
        return $this->hasMany(PedidoProducto::class, 'id_producto', 'id_producto');
    }

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'pedido_producto', 'id_producto', 'id_pedido')
                    ->withPivot('cantidad', 'precio_unitario', 'subtotal')
                    ->withTimestamps();
    }
}
