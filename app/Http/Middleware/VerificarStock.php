<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Producto;

class VerificarStock
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('POST') && $request->routeIs('ventas.store')) {
            $productos = $request->input('productos', []);
            
            foreach ($productos as $productoData) {
                $producto = Producto::find($productoData['id_producto']);
                
                if (!$producto) {
                    return back()->withErrors([
                        'productos' => 'Uno o más productos no existen.'
                    ])->withInput();
                }
                
                if ($producto->Stock_producto < $productoData['cantidad']) {
                    return back()->withErrors([
                        'productos' => "El producto '{$producto->Nombre_producto}' no tiene suficiente stock. Stock disponible: {$producto->Stock_producto}"
                    ])->withInput();
                }
            }
        }
        
        return $next($request);
    }
}