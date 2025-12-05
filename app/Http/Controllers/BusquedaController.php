<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\CategoriaProducto;

class BusquedaController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $tipo = $request->get('type', 'todos');
        
        $resultados = collect();
        
        if ($query) {
            switch ($tipo) {
                case 'empleados':
                case 'usuarios':
                    $resultados = $this->buscarUsuarios($query);
                    break;
                case 'platos':
                case 'productos':
                    $resultados = $this->buscarProductos($query);
                    break;
                case 'pedidos':
                case 'ventas':
                    $resultados = $this->buscarVentas($query);
                    break;
                case 'clientes':
                    $resultados = $this->buscarClientes($query);
                    break;
                case 'categorias':
                    $resultados = $this->buscarCategorias($query);
                    break;
                default:
                    $resultados = $this->buscarTodo($query);
                    break;
            }
        }
        
        return view('busqueda.index', compact('resultados', 'query', 'tipo'));
    }
    
    private function buscarUsuarios($query)
    {
        return Usuario::where('Nom_usuario', 'like', "%{$query}%")
            ->orWhere('Apellido_usuario', 'like', "%{$query}%")
            ->orWhere('Email_usuario', 'like', "%{$query}%")
            ->orWhere('Cedula_usuario', 'like', "%{$query}%")
            ->with('rol')
            ->get()
            ->map(function ($usuario) {
                return [
                    'tipo' => 'empleado',
                    'titulo' => $usuario->Nom_usuario . ' ' . $usuario->Apellido_usuario,
                    'subtitulo' => $usuario->Email_usuario,
                    'descripcion' => 'Rol: ' . ($usuario->rol->Nombre_rol ?? 'Sin rol') . ' | Estado: ' . $usuario->Estado_usuario,
                    'url' => route('usuarios.show', $usuario->id_usuario),
                    'icono' => 'fas fa-user-tie',
                    'color' => 'primary'
                ];
            });
    }
    
    private function buscarProductos($query)
    {
        return Producto::where('Nombre_producto', 'like', "%{$query}%")
            ->orWhere('Tipo_producto', 'like', "%{$query}%")
            ->with('categoria')
            ->get()
            ->map(function ($producto) {
                return [
                    'tipo' => 'plato',
                    'titulo' => $producto->Nombre_producto,
                    'subtitulo' => $producto->Tipo_producto,
                    'descripcion' => 'Categoría: ' . ($producto->categoria->Nombre_categoria ?? 'Sin categoría') . ' | Stock: ' . $producto->Stock_producto . ' | Precio: $' . number_format($producto->Precio_venta, 2),
                    'url' => route('productos.show', $producto->id_producto),
                    'icono' => 'fas fa-utensils',
                    'color' => 'success'
                ];
            });
    }
    
    private function buscarVentas($query)
    {
        return Venta::where('id_venta', 'like', "%{$query}%")
            ->orWhere('Estado_venta', 'like', "%{$query}%")
            ->with('usuario')
            ->get()
            ->map(function ($venta) {
                return [
                    'tipo' => 'pedido',
                    'titulo' => 'Pedido #' . $venta->id_venta,
                    'subtitulo' => $venta->Estado_venta,
                    'descripcion' => 'Empleado: ' . ($venta->usuario->Nom_usuario ?? 'N/A') . ' | Fecha: ' . $venta->created_at->format('d/m/Y') . ' | Total: $' . number_format($venta->Total_venta, 2),
                    'url' => route('ventas.show', $venta->id_venta),
                    'icono' => 'fas fa-shopping-cart',
                    'color' => 'info'
                ];
            });
    }
    
    private function buscarClientes($query)
    {
        return Cliente::where('Nom_cliente', 'like', "%{$query}%")
            ->orWhere('Tel_cliente', 'like', "%{$query}%")
            ->orWhere('Direc_cliente', 'like', "%{$query}%")
            ->get()
            ->map(function ($cliente) {
                return [
                    'tipo' => 'cliente',
                    'titulo' => $cliente->Nom_cliente,
                    'subtitulo' => $cliente->Tel_cliente ?? 'Sin teléfono',
                    'descripcion' => 'Dirección: ' . ($cliente->Direc_cliente ?? 'No especificada'),
                    'url' => route('clientes.show', $cliente->id_cliente),
                    'icono' => 'fas fa-user-tie',
                    'color' => 'warning'
                ];
            });
    }
    
    private function buscarCategorias($query)
    {
        return CategoriaProducto::where('Nombre_categoria', 'like', "%{$query}%")
            ->withCount('productos')
            ->get()
            ->map(function ($categoria) {
                return [
                    'tipo' => 'categoria',
                    'titulo' => $categoria->Nombre_categoria,
                    'subtitulo' => $categoria->productos_count . ' productos',
                    'descripcion' => 'Cantidad: ' . ($categoria->cantidad_categoria ?? 0),
                    'url' => route('categorias.show', $categoria->id_categoria),
                    'icono' => 'fas fa-tags',
                    'color' => 'secondary'
                ];
            });
    }
    
    private function buscarTodo($query)
    {
        $usuarios = $this->buscarUsuarios($query)->take(3);
        $productos = $this->buscarProductos($query)->take(3);
        $ventas = $this->buscarVentas($query)->take(3);
        $clientes = $this->buscarClientes($query)->take(3);
        $categorias = $this->buscarCategorias($query)->take(3);
        
        return $usuarios->concat($productos)->concat($ventas)->concat($clientes)->concat($categorias);
    }
}
