<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDescuento extends Model
{
    use HasFactory;

    protected $table = 'tipo_descuento';
    protected $primaryKey = 'id_tipo_descuento';

    protected $fillable = [
        'nombre',
        'id_fp'
    ];

    public function formaPago()
    {
        return $this->belongsTo(FormaPago::class, 'id_fp', 'id_fp');
    }
}
