<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Movimiento;
use App\Models\CategoriaProducto;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    public function index()
    {
        $productos = Producto::with(['categoria'])
            ->orderBy('nombre_producto')
            ->paginate(20);
            
        $categorias = CategoriaProducto::all();
        
        $estadisticas = [
            'total_productos' => Producto::count(),
            'productos_activos' => Producto::where('estado', 'Activo')->count(),
            'productos_bajo_stock' => Producto::whereColumn('stock', '<=', 'stock_min')->count(),
            'valor_total_inventario' => Producto::sum(DB::raw('stock * precio_venta'))
        ];
        
        return view('inventario.index', compact('productos', 'categorias', 'estadisticas'));
    }
    
    public function movimientos()
    {
        $movimientos = Movimiento::with('producto')
            ->orderBy('fecha', 'desc')
            ->paginate(20);
            
        return view('inventario.movimientos', compact('movimientos'));
    }
    
    public function ajusteStock(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:producto,id_producto',
            'tipo_movimiento' => 'required|in:entrada,salida,ajuste',
            'cantidad' => 'required|integer|min:1',
            'motivo' => 'required|string|max:255',
            'observaciones' => 'nullable|string|max:500'
        ]);
        
        DB::beginTransaction();
        
        try {
            $producto = Producto::findOrFail($request->producto_id);
            
            // Determinar el tipo de movimiento según el SQL
            $tipoMovimiento = $request->tipo_movimiento === 'entrada' ? 'Entrada' : 'Salida';
            
            $movimiento = Movimiento::create([
                'tipo' => $tipoMovimiento,
                'cantidad' => $request->cantidad,
                'fecha' => now()->toDateString(),
                'descripcion' => $request->motivo,
                'id_producto' => $producto->id_producto
            ]);
            
            // Actualizar stock del producto
            if ($request->tipo_movimiento === 'entrada') {
                $producto->increment('stock', $request->cantidad);
            } elseif ($request->tipo_movimiento === 'salida') {
                $producto->decrement('stock', $request->cantidad);
            } else {
                $producto->update(['stock' => $request->cantidad]);
            }
            
            DB::commit();
            
            return redirect()->route('inventario.index')
                ->with('success', 'Movimiento de inventario registrado exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Error al registrar el movimiento: ' . $e->getMessage());
        }
    }
    
    public function reporteStock()
    {
        $productos = Producto::with('categoria')
            ->selectRaw('
                id_producto,
                nombre_producto,
                stock,
                stock_min,
                stock_max,
                precio_venta,
                (stock * precio_venta) as valor_total,
                CASE 
                    WHEN stock <= stock_min THEN "Bajo"
                    WHEN stock >= stock_max THEN "Alto"
                    ELSE "Normal"
                END as estado_stock
            ')
            ->orderBy('estado_stock')
            ->orderBy('stock')
            ->get();
            
        $resumen = [
            'total_productos' => $productos->count(),
            'stock_bajo' => $productos->where('estado_stock', 'Bajo')->count(),
            'stock_normal' => $productos->where('estado_stock', 'Normal')->count(),
            'stock_alto' => $productos->where('estado_stock', 'Alto')->count(),
            'valor_total' => $productos->sum('valor_total')
        ];
        
        return view('inventario.reporte-stock', compact('productos', 'resumen'));
    }
    
    public function alertasStock()
    {
        $alertas = Producto::with('categoria')
            ->whereColumn('stock', '<=', 'stock_min')
            ->where('estado', 'Activo')
            ->orderBy('stock')
            ->get();
            
        return view('inventario.alertas-stock', compact('alertas'));
    }
}
