<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriaProducto;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = CategoriaProducto::withCount('productos')->paginate(10);
        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_categoria' => 'required|string|max:50|min:2|unique:categoria_producto,nombre_categoria',
            'cantidad_categoria' => 'nullable|integer|min:0'
        ], [
            'nombre_categoria.required' => 'El nombre de la categoría es obligatorio.',
            'nombre_categoria.max' => 'El nombre no puede exceder 50 caracteres.',
            'nombre_categoria.min' => 'El nombre debe tener al menos 2 caracteres.',
            'nombre_categoria.unique' => 'Ya existe una categoría con este nombre.',
            'cantidad_categoria.integer' => 'La cantidad debe ser un número entero.',
            'cantidad_categoria.min' => 'La cantidad no puede ser negativa.'
        ]);

        CategoriaProducto::create($request->all());

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría de platos creada exitosamente.');
    }

    public function show($id)
    {
        $categoria = CategoriaProducto::with('productos')->findOrFail($id);
        return view('categorias.show', compact('categoria'));
    }

    public function edit($id)
    {
        $categoria = CategoriaProducto::findOrFail($id);
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $categoria = CategoriaProducto::findOrFail($id);
        
        $request->validate([
            'nombre_categoria' => 'required|string|max:50|min:2|unique:categoria_producto,nombre_categoria,' . $categoria->id_categoria . ',id_categoria',
            'cantidad_categoria' => 'nullable|integer|min:0'
        ], [
            'nombre_categoria.required' => 'El nombre de la categoría es obligatorio.',
            'nombre_categoria.max' => 'El nombre no puede exceder 50 caracteres.',
            'nombre_categoria.min' => 'El nombre debe tener al menos 2 caracteres.',
            'nombre_categoria.unique' => 'Ya existe una categoría con este nombre.',
            'cantidad_categoria.integer' => 'La cantidad debe ser un número entero.',
            'cantidad_categoria.min' => 'La cantidad no puede ser negativa.'
        ]);

        $categoria->update($request->all());

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría de platos actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $categoria = CategoriaProducto::findOrFail($id);
        
        if($categoria->productos()->count() > 0) {
            return redirect()->route('categorias.index')
                ->with('error', 'No se puede eliminar la categoría porque tiene platos asociados.');
        }
        
        $categoria->delete();

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría de platos eliminada exitosamente.');
    }
}
