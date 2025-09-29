<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    protected $table = 'movimiento';
    protected $primaryKey = 'id_movimiento';

    protected $fillable = [
        'tipo',
        'cantidad',
        'fecha',
        'descripcion',
        'id_producto'
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleMovimiento::class, 'id_movimiento', 'id_movimiento');
    }
}
