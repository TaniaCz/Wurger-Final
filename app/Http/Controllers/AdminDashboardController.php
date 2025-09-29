<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\UsuarioInfo;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\Pedido;
use App\Models\CategoriaProducto;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Administrador');
    }

    public function index()
    {
        // Estadísticas principales
        $stats = [
            'total_usuarios' => Usuario::count(),
            'total_clientes' => UsuarioInfo::count(),
            'total_productos' => Producto::count(),
            'total_ventas' => Venta::count(),
            'total_pedidos' => Pedido::count(),
            'total_categorias' => CategoriaProducto::count(),
            'ventas_hoy' => Venta::whereDate('fecha', today())->count(),
            'ventas_mes' => Venta::whereMonth('fecha', now()->month)->count(),
            'pedidos_pendientes' => Pedido::where('estado', 'Pendiente')->count(),
            'productos_bajo_stock' => Producto::whereColumn('stock', '<=', 'stock_min')->where('estado', 'Activo')->count(),
            'ingresos_hoy' => Venta::whereDate('fecha', today())->sum('Total_venta'),
            'ingresos_mes' => Venta::whereMonth('fecha', now()->month)->sum('Total_venta'),
        ];

        // Datos recientes
        $ventas_recientes = Venta::with('usuario.usuarioInfo')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $pedidos_recientes = Pedido::with('usuarioInfo.usuario')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $productos_bajo_stock = Producto::whereColumn('stock', '<=', 'stock_min')
            ->where('estado', 'Activo')
            ->limit(5)
            ->get();

        // Usuarios recientes
        $usuarios_recientes = Usuario::with('usuarioInfo')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Productos recientes (últimos 5 productos activos)
        $productos_mas_vendidos = Producto::with('categoria')
            ->where('estado', 'Activo')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function($producto) {
                return (object) [
                    'nombre_producto' => $producto->nombre_producto,
                    'stock' => $producto->stock
                ];
            });

        // Ventas por día (últimos 7 días)
        $ventas_por_dia = Venta::selectRaw('DATE(fecha) as fecha, COUNT(*) as cantidad, SUM(Total_venta) as total')
            ->where('fecha', '>=', now()->subDays(7))
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        return view('admin.dashboard', compact(
            'stats', 
            'ventas_recientes', 
            'pedidos_recientes', 
            'productos_bajo_stock',
            'usuarios_recientes',
            'productos_mas_vendidos',
            'ventas_por_dia'
        ));
    }
}
