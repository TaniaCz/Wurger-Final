<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productos = [
            [
                'nombre_producto' => 'Hamburguesa Clásica',
                'stock' => 50,
                'stock_min' => 10,
                'stock_max' => 100,
                'precio_compra' => 5.00,
                'precio_venta' => 8.50,
                'tipo_producto' => 'Comida',
                'estado' => 'Activo',
                'fecha_ingreso' => now(),
                'id_categoria' => 1
            ],
            [
                'nombre_producto' => 'Hamburguesa con Queso',
                'stock' => 45,
                'stock_min' => 10,
                'stock_max' => 100,
                'precio_compra' => 6.00,
                'precio_venta' => 9.50,
                'tipo_producto' => 'Comida',
                'estado' => 'Activo',
                'fecha_ingreso' => now(),
                'id_categoria' => 1
            ],
            [
                'nombre_producto' => 'Papas Fritas',
                'stock' => 80,
                'stock_min' => 20,
                'stock_max' => 150,
                'precio_compra' => 2.00,
                'precio_venta' => 4.00,
                'tipo_producto' => 'Acompañamiento',
                'estado' => 'Activo',
                'fecha_ingreso' => now(),
                'id_categoria' => 2
            ],
            [
                'nombre_producto' => 'Refresco Cola',
                'stock' => 60,
                'stock_min' => 15,
                'stock_max' => 120,
                'precio_compra' => 1.50,
                'precio_venta' => 3.00,
                'tipo_producto' => 'Bebida',
                'estado' => 'Activo',
                'fecha_ingreso' => now(),
                'id_categoria' => 3
            ],
            [
                'nombre_producto' => 'Agua Mineral',
                'stock' => 100,
                'stock_min' => 25,
                'stock_max' => 200,
                'precio_compra' => 0.80,
                'precio_venta' => 2.00,
                'tipo_producto' => 'Bebida',
                'estado' => 'Activo',
                'fecha_ingreso' => now(),
                'id_categoria' => 3
            ],
            [
                'nombre_producto' => 'Ensalada César',
                'stock' => 30,
                'stock_min' => 8,
                'stock_max' => 60,
                'precio_compra' => 4.00,
                'precio_venta' => 7.50,
                'tipo_producto' => 'Comida',
                'estado' => 'Activo',
                'fecha_ingreso' => now(),
                'id_categoria' => 4
            ],
            [
                'nombre_producto' => 'Pizza Margherita',
                'stock' => 25,
                'stock_min' => 5,
                'stock_max' => 50,
                'precio_compra' => 8.00,
                'precio_venta' => 12.00,
                'tipo_producto' => 'Comida',
                'estado' => 'Activo',
                'fecha_ingreso' => now(),
                'id_categoria' => 1
            ],
            [
                'nombre_producto' => 'Helado de Vainilla',
                'stock' => 40,
                'stock_min' => 10,
                'stock_max' => 80,
                'precio_compra' => 2.50,
                'precio_venta' => 4.50,
                'tipo_producto' => 'Postre',
                'estado' => 'Activo',
                'fecha_ingreso' => now(),
                'id_categoria' => 5
            ]
        ];

        foreach ($productos as $producto) {
            \App\Models\Producto::create($producto);
        }
    }
}
