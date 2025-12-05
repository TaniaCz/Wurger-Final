<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\UsuarioInfo;
use App\Models\Producto;
use App\Models\PedidoProducto;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function __construct()
    {
        // El middleware se aplicará individualmente a cada método
    }

    public function adminIndex()
    {
        $this->middleware('role:Administrador');
        
        $pedidos = Pedido::with(['usuarioInfo.usuario'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function index()
    {
        $this->middleware('role:Usuario');
        
        $usuario = auth()->user();
        
        $pedidos = Pedido::whereHas('usuarioInfo', function($query) use ($usuario) {
            $query->where('id_usuario', $usuario->id_usuario);
        })->with('usuarioInfo.usuario')->paginate(10);

        return view('user.pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $productos = Producto::where('estado', 'Activo')
                            ->where('stock', '>', 0)
                            ->with('categoria')
                            ->get()
                            ->groupBy('categoria.nombre_categoria');
        
        return view('user.pedidos.create', compact('productos'));
    }

    public function store(Request $request)
    {
        // Validación básica
        $request->validate([
            'fecha' => 'required|date|before_or_equal:today',
            'observaciones' => 'nullable|string|max:255',
            'productos' => 'required|array|min:1',
            'cantidades' => 'required|array'
        ], [
            'fecha.required' => 'La fecha del pedido es obligatoria.',
            'fecha.date' => 'La fecha debe tener un formato válido.',
            'fecha.before_or_equal' => 'La fecha no puede ser futura.',
            'productos.required' => 'Debes seleccionar al menos un producto.',
            'productos.min' => 'Debes seleccionar al menos un producto.',
            'cantidades.required' => 'Las cantidades son obligatorias.'
        ]);

        $usuario = auth()->user();
        $usuarioInfo = $usuario->usuarioInfo;

        if (!$usuarioInfo) {
            return redirect()->back()->with('error', 'No se encontró información del usuario.');
        }

        try {
            DB::beginTransaction();

            // Crear el pedido
            $pedido = Pedido::create([
                'fecha' => $request->fecha,
                'observaciones' => $request->observaciones,
                'estado' => 'Pendiente',
                'id_usuario_info' => $usuarioInfo->id_usuario_info
            ]);

            // Procesar productos seleccionados
            $productosIds = $request->productos;
            $cantidades = $request->cantidades;

            foreach ($productosIds as $productoId) {
                $producto = Producto::find($productoId);
                
                if (!$producto) {
                    DB::rollback();
                    return redirect()->back()->with('error', "El producto con ID {$productoId} no existe.");
                }

                $cantidad = $cantidades[$productoId] ?? 1;
                
                // Validar stock
                if ($cantidad > $producto->stock) {
                    DB::rollback();
                    return redirect()->back()->with('error', "No hay suficiente stock para {$producto->nombre_producto}. Stock disponible: {$producto->stock}");
                }

                // Crear relación pedido-producto
                PedidoProducto::create([
                    'id_pedido' => $pedido->id_pedido,
                    'id_producto' => $productoId,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $producto->precio_venta,
                    'subtotal' => $producto->precio_venta * $cantidad
                ]);
            }

            DB::commit();
            
            return redirect()->route('user.pedidos.index')
                ->with('success', 'Pedido creado exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error al crear el pedido: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $usuario = auth()->user();
        
        $pedido = Pedido::whereHas('usuarioInfo', function($query) use ($usuario) {
            $query->where('id_usuario', $usuario->id_usuario);
        })->with(['usuarioInfo.usuario', 'pedidoProductos.producto'])->findOrFail($id);

        return view('user.pedidos.show', compact('pedido'));
    }

}