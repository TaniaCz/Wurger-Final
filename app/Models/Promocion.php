<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    use HasFactory;

    protected $table = 'promocion';
    protected $primaryKey = 'id_promocion';

    protected $fillable = [
        'nombre',
        'inicio',
        'fin',
        'cantidad_usos',
        'estado',
        'descripcion',
        'id_producto'
    ];

    protected $casts = [
        'inicio' => 'date',
        'fin' => 'date',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }
}
