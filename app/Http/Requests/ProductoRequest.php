<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'Nombre_producto' => 'required|string|max:100',
            'Stock_producto' => 'required|integer|min:0',
            'Stock_min_producto' => 'required|integer|min:0',
            'Stock_max_producto' => 'required|integer|min:0|gt:Stock_min_producto',
            'Precio_recibimiento' => 'required|numeric|min:0',
            'Precio_venta' => 'required|numeric|min:0|gte:Precio_recibimiento',
            'Tipo_producto' => 'nullable|string|max:50',
            'Estado_producto' => 'required|in:Activo,Inactivo',
            'Fecha_ingreso_producto' => 'required|date',
            'id_categoria_FK' => 'required|exists:categoria_producto,id_categoria'
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['Stock_max_producto'] = 'required|integer|min:0|gt:Stock_min_producto';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'Nombre_producto.required' => 'El nombre del producto es obligatorio.',
            'Nombre_producto.max' => 'El nombre no puede tener más de 100 caracteres.',
            'Stock_producto.required' => 'El stock actual es obligatorio.',
            'Stock_producto.integer' => 'El stock debe ser un número entero.',
            'Stock_producto.min' => 'El stock no puede ser negativo.',
            'Stock_min_producto.required' => 'El stock mínimo es obligatorio.',
            'Stock_min_producto.integer' => 'El stock mínimo debe ser un número entero.',
            'Stock_min_producto.min' => 'El stock mínimo no puede ser negativo.',
            'Stock_max_producto.required' => 'El stock máximo es obligatorio.',
            'Stock_max_producto.integer' => 'El stock máximo debe ser un número entero.',
            'Stock_max_producto.min' => 'El stock máximo no puede ser negativo.',
            'Stock_max_producto.gt' => 'El stock máximo debe ser mayor al stock mínimo.',
            'Precio_recibimiento.required' => 'El precio de recibimiento es obligatorio.',
            'Precio_recibimiento.numeric' => 'El precio de recibimiento debe ser un número.',
            'Precio_recibimiento.min' => 'El precio de recibimiento no puede ser negativo.',
            'Precio_venta.required' => 'El precio de venta es obligatorio.',
            'Precio_venta.numeric' => 'El precio de venta debe ser un número.',
            'Precio_venta.min' => 'El precio de venta no puede ser negativo.',
            'Precio_venta.gte' => 'El precio de venta debe ser mayor o igual al precio de recibimiento.',
            'Tipo_producto.max' => 'El tipo de producto no puede tener más de 50 caracteres.',
            'Estado_producto.required' => 'El estado es obligatorio.',
            'Estado_producto.in' => 'El estado debe ser Activo o Inactivo.',
            'Fecha_ingreso_producto.required' => 'La fecha de ingreso es obligatoria.',
            'Fecha_ingreso_producto.date' => 'La fecha de ingreso debe ser una fecha válida.',
            'id_categoria_FK.required' => 'La categoría es obligatoria.',
            'id_categoria_FK.exists' => 'La categoría seleccionada no es válida.'
        ];
    }
}
