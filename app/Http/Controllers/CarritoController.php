<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrito;
use App\Models\Producto;
use Illuminate\Support\Facades\Session;

class CarritoController extends Controller
{
    // Mostrar el carrito
    public function index()
    {
        $carritoItems = Carrito::getCartItems();
        $total = Carrito::getCartTotal();
        $itemsCount = Carrito::getCartItemsCount();
        
        return view('carrito.index', compact('carritoItems', 'total', 'itemsCount'));
    }

    // Agregar producto al carrito
    public function add(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:producto,id_producto',
            'cantidad' => 'required|integer|min:1'
        ]);

        $producto = Producto::find($request->producto_id);
        
        if (!$producto) {
            return response()->json(['success' => false, 'message' => 'Producto no encontrado'], 404);
        }

        if ($producto->stock < $request->cantidad) {
            return response()->json(['success' => false, 'message' => 'Stock insuficiente'], 400);
        }

        $success = Carrito::addToCart($request->producto_id, $request->cantidad);
        
        if ($success) {
            $itemsCount = Carrito::getCartItemsCount();
            $total = Carrito::getCartTotal();
            
            return response()->json([
                'success' => true,
                'message' => 'Producto agregado al carrito',
                'itemsCount' => $itemsCount,
                'total' => number_format($total, 2)
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Error al agregar producto'], 500);
    }

    // Actualizar cantidad en el carrito
    public function update(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:producto,id_producto',
            'cantidad' => 'required|integer|min:0'
        ]);

        $success = Carrito::updateQuantity($request->producto_id, $request->cantidad);
        
        if ($success) {
            $itemsCount = Carrito::getCartItemsCount();
            $total = Carrito::getCartTotal();
            
            return response()->json([
                'success' => true,
                'message' => 'Cantidad actualizada',
                'itemsCount' => $itemsCount,
                'total' => number_format($total, 2)
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Error al actualizar cantidad'], 500);
    }

    // Remover producto del carrito
    public function remove(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:producto,id_producto'
        ]);

        $success = Carrito::removeFromCart($request->producto_id);
        
        if ($success) {
            $itemsCount = Carrito::getCartItemsCount();
            $total = Carrito::getCartTotal();
            
            return response()->json([
                'success' => true,
                'message' => 'Producto removido del carrito',
                'itemsCount' => $itemsCount,
                'total' => number_format($total, 2)
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Error al remover producto'], 500);
    }

    // Limpiar carrito
    public function clear()
    {
        Carrito::clearCart();
        
        return response()->json([
            'success' => true,
            'message' => 'Carrito limpiado',
            'itemsCount' => 0,
            'total' => '0.00'
        ]);
    }

    // Obtener información del carrito (para AJAX)
    public function info()
    {
        $itemsCount = Carrito::getCartItemsCount();
        $total = Carrito::getCartTotal();
        
        return response()->json([
            'itemsCount' => $itemsCount,
            'total' => number_format($total, 2)
        ]);
    }

    // Migrar carrito de sesión a usuario (cuando se autentica)
    public function migrateToUser()
    {
        if (auth()->check()) {
            $sessionId = session()->getId();
            
            // Migrar items del carrito de sesión al usuario
            Carrito::where('session_id', $sessionId)
                ->whereNull('user_id')
                ->update([
                    'user_id' => auth()->id(),
                    'session_id' => null
                ]);
        }
        
        return response()->json(['success' => true]);
    }
}
