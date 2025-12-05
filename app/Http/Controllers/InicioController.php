<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\UsuarioInfo;

class InicioController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        return $this->dashboard();
    }

    public function dashboard()
    {
        // Estadísticas principales
        $totalEmpleados = Usuario::where('estado', 'Activo')->count();
        $totalPlatos = Producto::where('estado', 'Activo')->count();
        $totalPedidos = Venta::count();
        $totalClientes = UsuarioInfo::count();
        
        // Estadísticas del día
        $pedidosHoy = Venta::whereDate('created_at', today())->count();
        $ingresosHoy = Venta::where('estado', 'Pagada')
            ->whereDate('created_at', today())
            ->sum('Total_venta') ?: 0;
        
        // Estadísticas por estado
        $pedidosPendientes = Venta::where('estado', 'Pendiente')->count();
        $pedidosPagados = Venta::where('estado', 'Pagada')->count();
        $pedidosAnulados = Venta::where('estado', 'Anulada')->count();
        
        // Ingresos por período
        $ingresosSemana = Venta::where('estado', 'Pagada')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('Total_venta') ?: 0;
            
        $ingresosMes = Venta::where('estado', 'Pagada')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('Total_venta') ?: 0;
        
        // Pedidos recientes
        $pedidosRecientes = Venta::with('usuario')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Platos con stock bajo
        $platosBajoStock = Producto::whereColumn('stock', '<=', 'stock_min')
            ->where('estado', 'Activo')
            ->limit(5)
            ->get();
            
        // Platos más vendidos (simulado)
        $platosMasVendidos = Producto::where('estado', 'Activo')
            ->orderBy('stock', 'desc')
            ->limit(5)
            ->get();
            
        // Clientes frecuentes
        $clientesFrecuentes = UsuarioInfo::withCount('pedidos')
            ->orderBy('pedidos_count', 'desc')
            ->limit(5)
            ->get();
            
        // Empleados más activos
        $empleadosActivos = Usuario::withCount('ventas')
            ->where('estado', 'Activo')
            ->orderBy('ventas_count', 'desc')
            ->limit(5)
            ->get();
            
        // Estadísticas de inventario
        $totalStock = Producto::where('estado', 'Activo')->sum('stock');
        $valorInventario = Producto::where('estado', 'Activo')
            ->sum(\DB::raw('stock * precio_compra'));
            
        // Tendencias (últimos 7 días)
        $tendenciasVentas = [];
        for ($i = 6; $i >= 0; $i--) {
            $fecha = now()->subDays($i);
            $ventasDia = Venta::where('estado', 'Pagada')
                ->whereDate('created_at', $fecha)
                ->sum('Total_venta') ?: 0;
            $tendenciasVentas[] = [
                'fecha' => $fecha->format('d/m'),
                'ventas' => $ventasDia
            ];
        }

        return view('dashboard', compact(
            'totalEmpleados',
            'totalPlatos', 
            'totalPedidos',
            'totalClientes',
            'pedidosHoy',
            'ingresosHoy',
            'pedidosPendientes',
            'pedidosPagados',
            'pedidosAnulados',
            'ingresosSemana',
            'ingresosMes',
            'pedidosRecientes',
            'platosBajoStock',
            'platosMasVendidos',
            'clientesFrecuentes',
            'empleadosActivos',
            'totalStock',
            'valorInventario',
            'tendenciasVentas'
        ));
    }
}
