<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleMovimiento extends Model
{
    use HasFactory;

    protected $table = 'detalle_movimiento';
    protected $primaryKey = 'id_detalle_movimiento';

    protected $fillable = [
        'cantidad',
        'id_movimiento'
    ];

    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class, 'id_movimiento', 'id_movimiento');
    }
}
