<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaPago extends Model
{
    use HasFactory;

    protected $table = 'forma_pago';
    protected $primaryKey = 'id_fp';

    protected $fillable = [
        'nombre',
        'id_venta'
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'id_venta', 'id_venta');
    }

    public function tipoDescuentos()
    {
        return $this->hasMany(TipoDescuento::class, 'id_fp', 'id_fp');
    }
}
