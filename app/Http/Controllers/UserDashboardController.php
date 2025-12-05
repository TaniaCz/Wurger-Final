<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\Pedido;
use App\Models\CategoriaProducto;

class UserDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Usuario');
    }

    public function index()
    {
        $usuario = auth()->user();
        
        // Obtener productos activos
        $productos = Producto::where('estado', 'Activo')
            ->orderBy('created_at', 'desc')
            ->get();

        // Obtener pedidos del usuario
        $pedidos = Pedido::with('usuarioInfo.usuario')
            ->whereHas('usuarioInfo', function($query) use ($usuario) {
                $query->where('id_usuario', $usuario->id_usuario);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.dashboard', compact('productos', 'pedidos'));
    }
}
