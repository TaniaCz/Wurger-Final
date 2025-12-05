<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Ejecutar seeder de usuario administrador
        $this->call(UsuarioSeeder::class);
    }
}