<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VentaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'Fecha_venta' => 'required|date',
            'Total_venta' => 'required|numeric|min:0',
            'Estado_venta' => 'required|in:Pendiente,Pagada,Cancelada',
            'id_usuario_FK' => 'required|exists:usuario,id_usuario',
            'productos' => 'required|array|min:1',
            'productos.*.id_producto' => 'required|exists:producto,id_producto',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio_unitario' => 'required|numeric|min:0'
        ];
    }

    public function messages()
    {
        return [
            'Fecha_venta.required' => 'La fecha de venta es obligatoria.',
            'Fecha_venta.date' => 'La fecha de venta debe ser una fecha válida.',
            'Total_venta.required' => 'El total de la venta es obligatorio.',
            'Total_venta.numeric' => 'El total debe ser un número.',
            'Total_venta.min' => 'El total no puede ser negativo.',
            'Estado_venta.required' => 'El estado de la venta es obligatorio.',
            'Estado_venta.in' => 'El estado debe ser Pendiente, Pagada o Cancelada.',
            'id_usuario_FK.required' => 'El usuario es obligatorio.',
            'id_usuario_FK.exists' => 'El usuario seleccionado no es válido.',
            'productos.required' => 'Debe agregar al menos un producto.',
            'productos.array' => 'Los productos deben ser una lista.',
            'productos.min' => 'Debe agregar al menos un producto.',
            'productos.*.id_producto.required' => 'El producto es obligatorio.',
            'productos.*.id_producto.exists' => 'El producto seleccionado no es válido.',
            'productos.*.cantidad.required' => 'La cantidad es obligatoria.',
            'productos.*.cantidad.integer' => 'La cantidad debe ser un número entero.',
            'productos.*.cantidad.min' => 'La cantidad debe ser al menos 1.',
            'productos.*.precio_unitario.required' => 'El precio unitario es obligatorio.',
            'productos.*.precio_unitario.numeric' => 'El precio unitario debe ser un número.',
            'productos.*.precio_unitario.min' => 'El precio unitario no puede ser negativo.'
        ];
    }
}
