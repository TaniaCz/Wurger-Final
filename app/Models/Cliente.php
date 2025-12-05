<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'cliente';
    protected $primaryKey = 'id_cliente';

    protected $fillable = [
        'Nom_cliente',
        'Tel_cliente',
        'Direc_cliente'
    ];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_cliente_FK', 'id_cliente');
    }
}
