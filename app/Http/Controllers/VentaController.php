<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Usuario;
use App\Models\UsuarioInfo;
use App\Models\Producto;
use App\Models\Pedido;
use App\Http\Requests\VentaRequest;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventas = Venta::with('usuario')->paginate(10);
        return view('ventas.index', compact('ventas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pedidos = Pedido::with(['usuarioInfo.usuario'])
                         ->where('estado', 'Pendiente')
                         ->orderBy('fecha', 'desc')
                         ->get();
        $clientes = UsuarioInfo::with('usuario')->get();
        $productos = Producto::where('estado', 'Activo')->get();
        return view('ventas.create', compact('pedidos', 'clientes', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Fecha_venta' => 'required|date|before_or_equal:today',
            'Estado_venta' => 'required|in:Pendiente,Pagada,Anulada',
            'Total_venta' => 'required|numeric|min:0.01|max:99999999.99',
            'id_pedido' => 'required|exists:pedido,id_pedido'
        ], [
            'Fecha_venta.required' => 'La fecha del pedido es obligatoria.',
            'Fecha_venta.date' => 'La fecha debe tener un formato válido.',
            'Fecha_venta.before_or_equal' => 'La fecha no puede ser futura.',
            'Estado_venta.required' => 'El estado del pedido es obligatorio.',
            'Estado_venta.in' => 'El estado debe ser Pendiente, Pagada o Anulada.',
            'Total_venta.required' => 'El total del pedido es obligatorio.',
            'Total_venta.numeric' => 'El total debe ser un número válido.',
            'Total_venta.min' => 'El total debe ser mayor a $0.00.',
            'Total_venta.max' => 'El total no puede exceder $99,999,999.99.',
            'id_pedido.required' => 'El pedido es obligatorio.',
            'id_pedido.exists' => 'El pedido seleccionado no existe.'
        ]);

        $venta = Venta::create([
            'fecha' => $request->Fecha_venta,
            'estado' => $request->Estado_venta,
            'Total_venta' => $request->Total_venta,
            'id_usuario' => auth()->id(),
            'id_pedido' => $request->id_pedido
        ]);

        return redirect()->route('ventas.index')
            ->with('success', 'Venta creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $venta = Venta::with(['usuario', 'detalles', 'pedido.pedidoProductos.producto'])->findOrFail($id);
        return view('ventas.show', compact('venta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $venta = Venta::findOrFail($id);
        $pedidos = Pedido::with(['usuarioInfo.usuario'])
                         ->where('estado', 'Pendiente')
                         ->orderBy('fecha', 'desc')
                         ->get();
        return view('ventas.edit', compact('venta', 'pedidos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $venta = Venta::findOrFail($id);
        
        $request->validate([
            'Fecha_venta' => 'required|date|before_or_equal:today',
            'Estado_venta' => 'required|in:Pendiente,Pagada,Anulada',
            'Total_venta' => 'required|numeric|min:0.01|max:99999999.99',
            'id_pedido' => 'required|exists:pedido,id_pedido'
        ], [
            'Fecha_venta.required' => 'La fecha del pedido es obligatoria.',
            'Fecha_venta.date' => 'La fecha debe tener un formato válido.',
            'Fecha_venta.before_or_equal' => 'La fecha no puede ser futura.',
            'Estado_venta.required' => 'El estado del pedido es obligatorio.',
            'Estado_venta.in' => 'El estado debe ser Pendiente, Pagada o Anulada.',
            'Total_venta.required' => 'El total del pedido es obligatorio.',
            'Total_venta.numeric' => 'El total debe ser un número válido.',
            'Total_venta.min' => 'El total debe ser mayor a $0.00.',
            'Total_venta.max' => 'El total no puede exceder $99,999,999.99.',
            'id_pedido.required' => 'El pedido es obligatorio.',
            'id_pedido.exists' => 'El pedido seleccionado no existe.'
        ]);

        $venta->update([
            'fecha' => $request->Fecha_venta,
            'estado' => $request->Estado_venta,
            'Total_venta' => $request->Total_venta,
            'id_pedido' => $request->id_pedido
        ]);

        return redirect()->route('ventas.index')
            ->with('success', 'Venta actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $venta = Venta::findOrFail($id);
        $venta->delete();

        return redirect()->route('ventas.index')
            ->with('success', 'Pedido eliminado exitosamente.');
    }
}
