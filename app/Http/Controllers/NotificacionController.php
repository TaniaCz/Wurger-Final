<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Producto;
use App\Models\Venta;

class NotificacionController extends Controller
{
    public function index()
    {
        $notificaciones = $this->generarNotificaciones();
        return response()->json($notificaciones);
    }
    
    private function generarNotificaciones()
    {
        $notificaciones = collect();
        
        // Platos con stock bajo
        $productosBajoStock = Producto::whereColumn('Stock_producto', '<=', 'Stock_min_producto')
            ->where('Estado_producto', 'Activo')
            ->get();
            
        foreach ($productosBajoStock as $producto) {
            $notificaciones->push([
                'id' => 'stock_bajo_' . $producto->id_producto,
                'tipo' => 'warning',
                'titulo' => 'Ingrediente Agotándose',
                'mensaje' => "El plato '{$producto->Nombre_producto}' necesita reabastecimiento ({$producto->Stock_producto} disponibles)",
                'fecha' => now()->format('d/m/Y H:i'),
                'url' => route('productos.show', $producto->id_producto),
                'icono' => 'fas fa-exclamation-triangle'
            ]);
        }
        
        // Pedidos pendientes
        $pedidosPendientes = Venta::where('Estado_venta', 'Pendiente')
            ->with('usuario')
            ->get();
            
        foreach ($pedidosPendientes as $pedido) {
            $notificaciones->push([
                'id' => 'pedido_pendiente_' . $pedido->id_venta,
                'tipo' => 'info',
                'titulo' => 'Pedido Pendiente',
                'mensaje' => "Pedido #{$pedido->id_venta} esperando preparación - Total: $" . number_format($pedido->Total_venta, 2),
                'fecha' => $pedido->created_at->format('d/m/Y H:i'),
                'url' => route('ventas.show', $pedido->id_venta),
                'icono' => 'fas fa-clock'
            ]);
        }
        
        // Pedidos completados recientemente
        $pedidosCompletados = Venta::where('Estado_venta', 'Pagada')
            ->where('created_at', '>=', now()->subHours(2))
            ->with('usuario')
            ->get();
            
        foreach ($pedidosCompletados as $pedido) {
            $notificaciones->push([
                'id' => 'pedido_completado_' . $pedido->id_venta,
                'tipo' => 'success',
                'titulo' => 'Pedido Completado',
                'mensaje' => "Pedido #{$pedido->id_venta} listo para entrega - Total: $" . number_format($pedido->Total_venta, 2),
                'fecha' => $pedido->created_at->format('d/m/Y H:i'),
                'url' => route('ventas.show', $pedido->id_venta),
                'icono' => 'fas fa-check-circle'
            ]);
        }
        
        // Empleados inactivos
        $empleadosInactivos = Usuario::where('Estado_usuario', 'Inactivo')
            ->where('updated_at', '>=', now()->subDays(7))
            ->get();
            
        foreach ($empleadosInactivos as $empleado) {
            $notificaciones->push([
                'id' => 'empleado_inactivo_' . $empleado->id_usuario,
                'tipo' => 'info',
                'titulo' => 'Empleado Inactivo',
                'mensaje' => "El empleado '{$empleado->Nom_usuario}' está inactivo",
                'fecha' => $empleado->updated_at->format('d/m/Y H:i'),
                'url' => route('usuarios.show', $empleado->id_usuario),
                'icono' => 'fas fa-user-slash'
            ]);
        }
        
        // Alertas de inventario crítico
        $productosCriticos = Producto::where('Stock_producto', 0)
            ->where('Estado_producto', 'Activo')
            ->get();
            
        foreach ($productosCriticos as $producto) {
            $notificaciones->push([
                'id' => 'stock_critico_' . $producto->id_producto,
                'tipo' => 'danger',
                'titulo' => 'Stock Agotado',
                'mensaje' => "El plato '{$producto->Nombre_producto}' está agotado - URGENTE",
                'fecha' => now()->format('d/m/Y H:i'),
                'url' => route('productos.show', $producto->id_producto),
                'icono' => 'fas fa-times-circle'
            ]);
        }
        
        return $notificaciones->sortByDesc('fecha')->values();
    }
}
