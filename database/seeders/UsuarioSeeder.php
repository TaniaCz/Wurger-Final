<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\UsuarioInfo;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear usuario administrador
        $usuario = Usuario::create([
            'email' => 'Wurger@admin.com',
            'password' => Hash::make('123456789'),
            'rol' => 'Administrador',
            'estado' => 'Activo'
        ]);

        // Crear información del usuario administrador
        UsuarioInfo::create([
            'nombre' => 'Administrador Wurger',
            'telefono' => '0000000000',
            'direccion' => 'Sistema',
            'id_usuario' => $usuario->id_usuario
        ]);
    }
}
