<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorias = [
            [
                'nombre_categoria' => 'Hamburguesas',
                'cantidad_categoria' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre_categoria' => 'Acompañamientos',
                'cantidad_categoria' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre_categoria' => 'Bebidas',
                'cantidad_categoria' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre_categoria' => 'Ensaladas',
                'cantidad_categoria' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre_categoria' => 'Postres',
                'cantidad_categoria' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($categorias as $categoria) {
            \App\Models\CategoriaProducto::create($categoria);
        }
    }
}
