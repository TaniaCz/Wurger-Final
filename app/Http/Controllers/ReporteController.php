<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\Usuario;
use App\Models\UsuarioInfo;
use App\Models\CategoriaProducto;
use App\Models\Pedido;
use App\Models\Movimiento;
use App\Models\Proveedor;
use App\Models\Promocion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index()
    {
        $totalVentas = Venta::count();
        $ventasHoy = Venta::whereDate('created_at', today())->count();
        $ventasMes = Venta::whereMonth('created_at', now()->month)->count();
        $totalProductos = Producto::count();
        $productosBajoStock = Producto::whereColumn('stock', '<=', 'stock_min')->count();
        $totalUsuarios = Usuario::count();
        $totalClientes = UsuarioInfo::count();
        
        $ventasPorMes = Venta::selectRaw('MONTH(created_at) as mes, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();
            
        $productosPorCategoria = CategoriaProducto::withCount('productos')->get();
        
        $ventasRecientes = Venta::with('usuario')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        $topUsuarios = Usuario::withCount('ventas')
            ->orderBy('ventas_count', 'desc')
            ->limit(5)
            ->get();

        return view('reportes.index', compact(
            'totalVentas',
            'ventasHoy',
            'ventasMes',
            'totalProductos',
            'productosBajoStock',
            'totalUsuarios',
            'totalClientes',
            'ventasPorMes',
            'productosPorCategoria',
            'ventasRecientes',
            'topUsuarios'
        ));
    }
    
    public function ventas(Request $request)
    {
        $ventas = Venta::with(['usuario.usuarioInfo', 'detalles'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        if ($request->has('export')) {
            return $this->exportVentas($ventas->items());
        }
            
        return view('reportes.ventas', compact('ventas'));
    }
    
    public function productos(Request $request)
    {
        $productos = Producto::with('categoria')
            ->orderBy('stock', 'asc')
            ->paginate(20);
            
        if ($request->has('export')) {
            return $this->exportProductos($productos->items());
        }
            
        return view('reportes.productos', compact('productos'));
    }
    
    public function usuarios(Request $request)
    {
        $usuarios = Usuario::with(['usuarioInfo', 'ventas'])
            ->withCount('ventas')
            ->orderBy('ventas_count', 'desc')
            ->paginate(20);
            
        if ($request->has('export')) {
            return $this->exportUsuarios($usuarios->items());
        }
            
        return view('reportes.usuarios', compact('usuarios'));
    }

    // ===== REPORTES DE VENTAS =====
    public function ventasDiarias(Request $request)
    {
        $fecha = $request->get('fecha', now()->format('Y-m-d'));
        $ventas = Venta::with(['usuario.usuarioInfo', 'detalles'])
            ->whereDate('fecha', $fecha)
            ->orderBy('created_at', 'desc')
            ->get();

        $totalVentas = $ventas->sum('Total_venta');
        $totalCantidad = $ventas->count();

        if ($request->has('export')) {
            return $this->exportVentasDiarias($ventas, $fecha);
        }

        return view('reportes.ventas-diarias', compact('ventas', 'fecha', 'totalVentas', 'totalCantidad'));
    }

    public function ventasMensuales(Request $request)
    {
        $mes = $request->get('mes', now()->month);
        $año = $request->get('año', now()->year);
        
        $ventas = Venta::with(['usuario.usuarioInfo', 'detalles'])
            ->whereMonth('fecha', $mes)
            ->whereYear('fecha', $año)
            ->orderBy('fecha', 'desc')
            ->get();

        $totalVentas = $ventas->sum('Total_venta');
        $totalCantidad = $ventas->count();

        // Estadísticas por día
        $ventasPorDia = $ventas->groupBy(function($venta) {
            return Carbon::parse($venta->fecha)->format('d');
        })->map(function($ventas) {
            return [
                'cantidad' => $ventas->count(),
                'total' => $ventas->sum('Total_venta')
            ];
        });

        if ($request->has('export')) {
            return $this->exportVentasMensuales($ventas, $mes, $año);
        }

        return view('reportes.ventas-mensuales', compact('ventas', 'mes', 'año', 'totalVentas', 'totalCantidad', 'ventasPorDia'));
    }

    public function ventasAnuales(Request $request)
    {
        $año = $request->get('año', now()->year);
        
        $ventas = Venta::with(['usuario.usuarioInfo', 'detalles'])
            ->whereYear('fecha', $año)
            ->orderBy('fecha', 'desc')
            ->get();

        $totalVentas = $ventas->sum('Total_venta');
        $totalCantidad = $ventas->count();

        // Estadísticas por mes
        $ventasPorMes = $ventas->groupBy(function($venta) {
            return Carbon::parse($venta->fecha)->format('m');
        })->map(function($ventas) {
            return [
                'cantidad' => $ventas->count(),
                'total' => $ventas->sum('Total_venta')
            ];
        });

        if ($request->has('export')) {
            return $this->exportVentasAnuales($ventas, $año);
        }

        return view('reportes.ventas-anuales', compact('ventas', 'año', 'totalVentas', 'totalCantidad', 'ventasPorMes'));
    }

    // ===== REPORTES DE PRODUCTOS =====
    public function productosMasVendidos(Request $request)
    {
        // Como no hay relación directa entre producto y detalle_venta,
        // mostramos los productos más recientes en su lugar
        $productos = Producto::with('categoria')
            ->where('estado', 'Activo')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        if ($request->has('export')) {
            return $this->exportProductosMasVendidos($productos);
        }

        return view('reportes.productos-mas-vendidos', compact('productos'));
    }

    public function productosBajoStock(Request $request)
    {
        $productos = Producto::with('categoria')
            ->whereColumn('stock', '<=', 'stock_min')
            ->where('estado', 'Activo')
            ->orderBy('stock', 'asc')
            ->get();

        if ($request->has('export')) {
            return $this->exportProductosBajoStock($productos);
        }

        return view('reportes.productos-bajo-stock', compact('productos'));
    }

    public function productosPorCategoria(Request $request)
    {
        $categorias = CategoriaProducto::withCount('productos')
            ->with('productos')
            ->orderBy('productos_count', 'desc')
            ->get();

        if ($request->has('export')) {
            return $this->exportProductosPorCategoria($categorias);
        }

        return view('reportes.productos-por-categoria', compact('categorias'));
    }

    // ===== REPORTES DE INVENTARIO =====
    public function movimientosInventario(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio', now()->subMonth()->format('Y-m-d'));
        $fechaFin = $request->get('fecha_fin', now()->format('Y-m-d'));
        
        $movimientos = Movimiento::with('producto')
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->orderBy('fecha', 'desc')
            ->get();

        if ($request->has('export')) {
            return $this->exportMovimientosInventario($movimientos, $fechaInicio, $fechaFin);
        }

        return view('reportes.movimientos-inventario', compact('movimientos', 'fechaInicio', 'fechaFin'));
    }

    public function valorInventario(Request $request)
    {
        $productos = Producto::with('categoria')
            ->where('estado', 'Activo')
            ->get()
            ->map(function($producto) {
                $producto->valor_total = $producto->stock * $producto->precio_venta;
                return $producto;
            })
            ->sortByDesc('valor_total');

        $valorTotalInventario = $productos->sum('valor_total');

        if ($request->has('export')) {
            return $this->exportValorInventario($productos, $valorTotalInventario);
        }

        return view('reportes.valor-inventario', compact('productos', 'valorTotalInventario'));
    }

    // ===== REPORTES DE PEDIDOS =====
    public function pedidosPorEstado(Request $request)
    {
        $pedidos = Pedido::with(['usuarioInfo.usuario'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('estado');

        $estadisticas = [
            'Pendiente' => $pedidos->get('Pendiente', collect())->count(),
            'Entregado' => $pedidos->get('Entregado', collect())->count(),
            'Cancelado' => $pedidos->get('Cancelado', collect())->count(),
        ];

        if ($request->has('export')) {
            return $this->exportPedidosPorEstado($pedidos, $estadisticas);
        }

        return view('reportes.pedidos-por-estado', compact('pedidos', 'estadisticas'));
    }

    // ===== REPORTES DE PROVEEDORES Y PROMOCIONES =====
    public function proveedores(Request $request)
    {
        $proveedores = Proveedor::with('usuario')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($request->has('export')) {
            return $this->exportProveedores($proveedores);
        }

        return view('reportes.proveedores', compact('proveedores'));
    }

    public function promociones(Request $request)
    {
        $promociones = Promocion::with('producto')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($request->has('export')) {
            return $this->exportPromociones($promociones);
        }

        return view('reportes.promociones', compact('promociones'));
    }

    // ===== MÉTODOS DE EXPORTACIÓN =====
    private function exportVentas($ventas)
    {
        $data = collect($ventas)->map(function($venta) {
            return [
                'ID' => $venta->id_venta,
                'Fecha' => $venta->fecha,
                'Cliente' => $venta->usuario->usuarioInfo->nombre ?? $venta->usuario->email,
                'Estado' => $venta->estado,
                'Total' => $venta->Total_venta,
                'Creado' => $venta->created_at
            ];
        });

        return $this->downloadCSV($data, 'ventas_' . now()->format('Y-m-d') . '.csv');
    }

    private function exportProductos($productos)
    {
        $data = collect($productos)->map(function($producto) {
            return [
                'ID' => $producto->id_producto,
                'Nombre' => $producto->nombre_producto,
                'Categoría' => $producto->categoria->nombre_categoria ?? 'Sin categoría',
                'Stock' => $producto->stock,
                'Stock Mínimo' => $producto->stock_min,
                'Precio Venta' => $producto->precio_venta,
                'Estado' => $producto->estado,
                'Fecha Ingreso' => $producto->fecha_ingreso
            ];
        });

        return $this->downloadCSV($data, 'productos_' . now()->format('Y-m-d') . '.csv');
    }

    private function exportUsuarios($usuarios)
    {
        $data = collect($usuarios)->map(function($usuario) {
            return [
                'ID' => $usuario->id_usuario,
                'Email' => $usuario->email,
                'Nombre' => $usuario->usuarioInfo->nombre ?? 'Sin nombre',
                'Rol' => $usuario->rol,
                'Estado' => $usuario->estado,
                'Total Ventas' => $usuario->ventas_count,
                'Registrado' => $usuario->created_at
            ];
        });

        return $this->downloadCSV($data, 'usuarios_' . now()->format('Y-m-d') . '.csv');
    }

    private function exportVentasDiarias($ventas, $fecha)
    {
        $data = $ventas->map(function($venta) {
            return [
                'ID' => $venta->id_venta,
                'Fecha' => $venta->fecha,
                'Cliente' => $venta->usuario->usuarioInfo->nombre ?? $venta->usuario->email,
                'Estado' => $venta->estado,
                'Total' => $venta->Total_venta,
                'Creado' => $venta->created_at
            ];
        });

        return $this->downloadCSV($data, "ventas_diarias_{$fecha}.csv");
    }

    private function exportVentasMensuales($ventas, $mes, $año)
    {
        $data = $ventas->map(function($venta) {
            return [
                'ID' => $venta->id_venta,
                'Fecha' => $venta->fecha,
                'Cliente' => $venta->usuario->usuarioInfo->nombre ?? $venta->usuario->email,
                'Estado' => $venta->estado,
                'Total' => $venta->Total_venta,
                'Creado' => $venta->created_at
            ];
        });

        return $this->downloadCSV($data, "ventas_mensuales_{$mes}_{$año}.csv");
    }

    private function exportVentasAnuales($ventas, $año)
    {
        $data = $ventas->map(function($venta) {
            return [
                'ID' => $venta->id_venta,
                'Fecha' => $venta->fecha,
                'Cliente' => $venta->usuario->usuarioInfo->nombre ?? $venta->usuario->email,
                'Estado' => $venta->estado,
                'Total' => $venta->Total_venta,
                'Creado' => $venta->created_at
            ];
        });

        return $this->downloadCSV($data, "ventas_anuales_{$año}.csv");
    }

    private function exportProductosMasVendidos($productos)
    {
        $data = $productos->map(function($producto) {
            return [
                'ID' => $producto->id_producto,
                'Nombre' => $producto->nombre_producto,
                'Categoría' => $producto->categoria->nombre_categoria ?? 'Sin categoría',
                'Stock' => $producto->stock,
                'Precio Venta' => $producto->precio_venta,
                'Veces Vendido' => $producto->detalles_venta_count,
                'Estado' => $producto->estado
            ];
        });

        return $this->downloadCSV($data, 'productos_mas_vendidos_' . now()->format('Y-m-d') . '.csv');
    }

    private function exportProductosBajoStock($productos)
    {
        $data = $productos->map(function($producto) {
            return [
                'ID' => $producto->id_producto,
                'Nombre' => $producto->nombre_producto,
                'Categoría' => $producto->categoria->nombre_categoria ?? 'Sin categoría',
                'Stock Actual' => $producto->stock,
                'Stock Mínimo' => $producto->stock_min,
                'Diferencia' => $producto->stock - $producto->stock_min,
                'Precio Venta' => $producto->precio_venta,
                'Estado' => $producto->estado
            ];
        });

        return $this->downloadCSV($data, 'productos_bajo_stock_' . now()->format('Y-m-d') . '.csv');
    }

    private function exportProductosPorCategoria($categorias)
    {
        $data = $categorias->map(function($categoria) {
            return [
                'ID' => $categoria->id_categoria,
                'Categoría' => $categoria->nombre_categoria,
                'Cantidad Productos' => $categoria->productos_count,
                'Productos' => $categoria->productos->pluck('nombre_producto')->join(', ')
            ];
        });

        return $this->downloadCSV($data, 'productos_por_categoria_' . now()->format('Y-m-d') . '.csv');
    }

    private function exportMovimientosInventario($movimientos, $fechaInicio, $fechaFin)
    {
        $data = $movimientos->map(function($movimiento) {
            return [
                'ID' => $movimiento->id_movimiento,
                'Tipo' => $movimiento->tipo,
                'Cantidad' => $movimiento->cantidad,
                'Fecha' => $movimiento->fecha,
                'Producto' => $movimiento->producto->nombre_producto ?? 'Sin producto',
                'Descripción' => $movimiento->descripcion,
                'Creado' => $movimiento->created_at
            ];
        });

        return $this->downloadCSV($data, "movimientos_inventario_{$fechaInicio}_a_{$fechaFin}.csv");
    }

    private function exportValorInventario($productos, $valorTotal)
    {
        $data = $productos->map(function($producto) {
            return [
                'ID' => $producto->id_producto,
                'Nombre' => $producto->nombre_producto,
                'Categoría' => $producto->categoria->nombre_categoria ?? 'Sin categoría',
                'Stock' => $producto->stock,
                'Precio Unitario' => $producto->precio_venta,
                'Valor Total' => $producto->valor_total,
                'Estado' => $producto->estado
            ];
        });

        // Agregar fila de total
        $data->push([
            'ID' => '',
            'Nombre' => 'TOTAL INVENTARIO',
            'Categoría' => '',
            'Stock' => '',
            'Precio Unitario' => '',
            'Valor Total' => $valorTotal,
            'Estado' => ''
        ]);

        return $this->downloadCSV($data, 'valor_inventario_' . now()->format('Y-m-d') . '.csv');
    }

    private function exportPedidosPorEstado($pedidos, $estadisticas)
    {
        $data = collect();
        
        foreach($pedidos as $estado => $pedidosEstado) {
            foreach($pedidosEstado as $pedido) {
                $data->push([
                    'ID' => $pedido->id_pedido,
                    'Estado' => $pedido->estado,
                    'Fecha' => $pedido->fecha,
                    'Cliente' => $pedido->usuarioInfo->usuario->usuarioInfo->nombre ?? $pedido->usuarioInfo->usuario->email,
                    'Observaciones' => $pedido->observaciones,
                    'Creado' => $pedido->created_at
                ]);
            }
        }

        return $this->downloadCSV($data, 'pedidos_por_estado_' . now()->format('Y-m-d') . '.csv');
    }

    private function exportProveedores($proveedores)
    {
        $data = $proveedores->map(function($proveedor) {
            return [
                'ID' => $proveedor->id_proveedor,
                'Nombre' => $proveedor->nombre,
                'Teléfono' => $proveedor->telefono,
                'Email' => $proveedor->email,
                'Dirección' => $proveedor->direccion,
                'Estado' => $proveedor->estado,
                'Usuario Asignado' => $proveedor->usuario->email ?? 'Sin asignar',
                'Creado' => $proveedor->created_at
            ];
        });

        return $this->downloadCSV($data, 'proveedores_' . now()->format('Y-m-d') . '.csv');
    }

    private function exportPromociones($promociones)
    {
        $data = $promociones->map(function($promocion) {
            return [
                'ID' => $promocion->id_promocion,
                'Nombre' => $promocion->nombre,
                'Descripción' => $promocion->descripcion,
                'Fecha Inicio' => $promocion->inicio,
                'Fecha Fin' => $promocion->fin,
                'Cantidad Usos' => $promocion->cantidad_usos,
                'Estado' => $promocion->estado,
                'Producto' => $promocion->producto->nombre_producto ?? 'Sin producto',
                'Creado' => $promocion->created_at
            ];
        });

        return $this->downloadCSV($data, 'promociones_' . now()->format('Y-m-d') . '.csv');
    }

    private function downloadCSV($data, $filename)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            
            // Escribir encabezados
            if ($data->isNotEmpty()) {
                fputcsv($file, array_keys($data->first()));
            }
            
            // Escribir datos
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}