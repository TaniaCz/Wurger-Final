<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoTerminado extends Model
{
    use HasFactory;

    protected $table = 'producto_terminado';
    protected $primaryKey = 'id_producto_terminado';

    protected $fillable = [
        'nombre',
        'descripcion',
        'categoria',
        'costo',
        'precio',
        'stock_actual',
        'stock_min',
        'estado',
        'fecha_ingreso',
        'id_producto'
    ];

    protected $casts = [
        'fecha_ingreso' => 'date',
        'costo' => 'decimal:2',
        'precio' => 'decimal:2',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }
}
