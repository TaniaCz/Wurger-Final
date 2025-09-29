<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'rol';
    protected $primaryKey = 'id_rol';

    protected $fillable = [
        'Nombre_rol'
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'id_rol_FK', 'id_rol');
    }
}
