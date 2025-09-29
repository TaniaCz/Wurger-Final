<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\CategoriaProducto;
use App\Http\Requests\ProductoRequest;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Verificar si el usuario es administrador
        if (auth()->check() && auth()->user()->rol === 'Administrador') {
            $productos = Producto::with('categoria')->paginate(10);
            return view('productos.index', compact('productos'));
        } else {
            // Vista para usuarios regulares (solo lectura)
            $productos = Producto::with('categoria')->where('estado', 'Activo')->paginate(12);
            return view('productos.user-index', compact('productos'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = CategoriaProducto::all();
        return view('productos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_producto' => 'required|string|max:50',
            'stock' => 'required|integer|min:0|max:999999',
            'stock_min' => 'nullable|integer|min:0|max:999999',
            'stock_max' => 'nullable|integer|min:1|max:999999',
            'precio_compra' => 'nullable|numeric|min:0|max:99999999.99',
            'precio_venta' => 'required|numeric|min:0|max:99999999.99',
            'tipo_producto' => 'nullable|string|max:30',
            'estado' => 'required|in:Activo,Inactivo',
            'fecha_ingreso' => 'nullable|date',
            'id_categoria' => 'required|exists:categoria_producto,id_categoria'
        ], [
            'nombre_producto.required' => 'El nombre del plato es obligatorio.',
            'nombre_producto.max' => 'El nombre no puede exceder 50 caracteres.',
            'stock.required' => 'El stock inicial es obligatorio.',
            'stock.min' => 'El stock no puede ser negativo.',
            'stock.max' => 'El stock no puede exceder 999,999 unidades.',
            'stock_min.min' => 'El stock mínimo no puede ser negativo.',
            'stock_min.max' => 'El stock mínimo no puede exceder 999,999 unidades.',
            'stock_max.min' => 'El stock máximo debe ser al menos 1.',
            'stock_max.max' => 'El stock máximo no puede exceder 999,999 unidades.',
            'precio_compra.min' => 'El precio de costo no puede ser negativo.',
            'precio_compra.max' => 'El precio de costo no puede exceder $99,999,999.99.',
            'precio_venta.required' => 'El precio de venta es obligatorio.',
            'precio_venta.min' => 'El precio de venta no puede ser negativo.',
            'precio_venta.max' => 'El precio de venta no puede exceder $99,999,999.99.',
            'estado.required' => 'El estado es obligatorio.',
            'id_categoria.required' => 'La categoría es obligatoria.',
            'id_categoria.exists' => 'La categoría seleccionada no existe.'
        ]);

        // Validación adicional: stock máximo debe ser mayor al mínimo
        if ($request->stock_max && $request->stock_min && $request->stock_max <= $request->stock_min) {
            return back()->withErrors(['stock_max' => 'El stock máximo debe ser mayor al stock mínimo.'])->withInput();
        }

        // Validación adicional: precio de venta debe ser mayor al de costo
        if ($request->precio_compra && $request->precio_venta <= $request->precio_compra) {
            return back()->withErrors(['precio_venta' => 'El precio de venta debe ser mayor al precio de costo.'])->withInput();
        }

        $producto = Producto::create($request->all());

        return redirect()->route('productos.index')
            ->with('success', 'Plato agregado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $producto = Producto::with('categoria')->findOrFail($id);
        
        // Verificar si el usuario es administrador
        if (auth()->check() && auth()->user()->rol === 'Administrador') {
            return view('productos.show', compact('producto'));
        } else {
            // Vista para usuarios regulares (solo lectura)
            return view('productos.user-show', compact('producto'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = CategoriaProducto::all();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        
        $request->validate([
            'nombre_producto' => 'required|string|max:50',
            'stock' => 'required|integer|min:0|max:999999',
            'stock_min' => 'nullable|integer|min:0|max:999999',
            'stock_max' => 'nullable|integer|min:1|max:999999',
            'precio_compra' => 'nullable|numeric|min:0|max:99999999.99',
            'precio_venta' => 'required|numeric|min:0|max:99999999.99',
            'tipo_producto' => 'nullable|string|max:30',
            'estado' => 'required|in:Activo,Inactivo',
            'fecha_ingreso' => 'nullable|date',
            'id_categoria' => 'required|exists:categoria_producto,id_categoria'
        ], [
            'nombre_producto.required' => 'El nombre del plato es obligatorio.',
            'nombre_producto.max' => 'El nombre no puede exceder 50 caracteres.',
            'stock.required' => 'El stock actual es obligatorio.',
            'stock.min' => 'El stock no puede ser negativo.',
            'stock.max' => 'El stock no puede exceder 999,999 unidades.',
            'stock_min.min' => 'El stock mínimo no puede ser negativo.',
            'stock_min.max' => 'El stock mínimo no puede exceder 999,999 unidades.',
            'stock_max.min' => 'El stock máximo debe ser al menos 1.',
            'stock_max.max' => 'El stock máximo no puede exceder 999,999 unidades.',
            'precio_compra.min' => 'El precio de costo no puede ser negativo.',
            'precio_compra.max' => 'El precio de costo no puede exceder $99,999,999.99.',
            'precio_venta.required' => 'El precio de venta es obligatorio.',
            'precio_venta.min' => 'El precio de venta no puede ser negativo.',
            'precio_venta.max' => 'El precio de venta no puede exceder $99,999,999.99.',
            'estado.required' => 'El estado es obligatorio.',
            'id_categoria.required' => 'La categoría es obligatoria.',
            'id_categoria.exists' => 'La categoría seleccionada no existe.'
        ]);

        // Validación adicional: stock máximo debe ser mayor al mínimo
        if ($request->stock_max && $request->stock_min && $request->stock_max <= $request->stock_min) {
            return back()->withErrors(['stock_max' => 'El stock máximo debe ser mayor al stock mínimo.'])->withInput();
        }

        // Validación adicional: precio de venta debe ser mayor al de costo
        if ($request->precio_compra && $request->precio_venta <= $request->precio_compra) {
            return back()->withErrors(['precio_venta' => 'El precio de venta debe ser mayor al precio de costo.'])->withInput();
        }

        $producto->update($request->all());

        return redirect()->route('productos.index')
            ->with('success', 'Plato actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Plato eliminado exitosamente.');
    }
}
