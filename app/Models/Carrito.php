<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'subtotal'
    ];

    protected $casts = [
        'precio_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id', 'id_producto');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'user_id', 'id_usuario');
    }

    // Calcular subtotal automáticamente
    public function setCantidadAttribute($value)
    {
        $this->attributes['cantidad'] = $value;
        $this->attributes['subtotal'] = $this->precio_unitario * $value;
    }

    // Obtener el identificador del carrito (user_id o session_id)
    public static function getCartIdentifier()
    {
        if (auth()->check()) {
            return ['user_id' => auth()->id()];
        } else {
            return ['session_id' => session()->getId()];
        }
    }

    // Obtener todos los items del carrito
    public static function getCartItems()
    {
        $identifier = self::getCartIdentifier();
        return self::with('producto')->where($identifier)->get();
    }

    // Agregar producto al carrito
    public static function addToCart($productoId, $cantidad = 1)
    {
        $producto = Producto::find($productoId);
        if (!$producto) {
            return false;
        }

        $identifier = self::getCartIdentifier();
        $carritoItem = self::where($identifier)
            ->where('producto_id', $productoId)
            ->first();

        if ($carritoItem) {
            $carritoItem->cantidad += $cantidad;
            $carritoItem->save();
        } else {
            self::create(array_merge($identifier, [
                'producto_id' => $productoId,
                'cantidad' => $cantidad,
                'precio_unitario' => $producto->precio_venta,
                'subtotal' => $producto->precio_venta * $cantidad
            ]));
        }

        return true;
    }

    // Actualizar cantidad en el carrito
    public static function updateQuantity($productoId, $cantidad)
    {
        $identifier = self::getCartIdentifier();
        $carritoItem = self::where($identifier)
            ->where('producto_id', $productoId)
            ->first();

        if ($carritoItem) {
            if ($cantidad <= 0) {
                $carritoItem->delete();
            } else {
                $carritoItem->cantidad = $cantidad;
                $carritoItem->save();
            }
            return true;
        }

        return false;
    }

    // Remover producto del carrito
    public static function removeFromCart($productoId)
    {
        $identifier = self::getCartIdentifier();
        return self::where($identifier)
            ->where('producto_id', $productoId)
            ->delete();
    }

    // Limpiar carrito
    public static function clearCart()
    {
        $identifier = self::getCartIdentifier();
        return self::where($identifier)->delete();
    }

    // Obtener total del carrito
    public static function getCartTotal()
    {
        $identifier = self::getCartIdentifier();
        return self::where($identifier)->sum('subtotal');
    }

    // Obtener cantidad total de items
    public static function getCartItemsCount()
    {
        $identifier = self::getCartIdentifier();
        return self::where($identifier)->sum('cantidad');
    }
}
