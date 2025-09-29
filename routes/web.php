<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\BusquedaController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Ruta principal - Página pública de Wurger primero
Route::get('/', [HomeController::class, 'index'])->name('home');

// Ruta de prueba
Route::get('/test', function () {
    return 'El servidor está funcionando correctamente!';
});

// Ruta para redireccionar a dashboard si está autenticado
Route::get('/dashboard', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->rol === 'Administrador') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }
    return redirect()->route('login');
})->name('dashboard');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// Ruta para la versión estática original (si se necesita)
Route::get('/static-index', function () {
    return response()->file(public_path('../index/index.php'));
})->name('static.index');

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout.post');

// Dashboards separados por rol
Route::middleware(['auth'])->group(function () {
    // Dashboard de Administrador
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // Dashboard de Usuario
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
});

// Rutas protegidas para administradores
Route::middleware(['auth', 'role:Administrador'])->group(function () {
    // Usuarios
    Route::resource('usuarios', UsuarioController::class);
    
    // Productos
    Route::resource('productos', ProductoController::class);
    
    // Categorías
    Route::resource('categorias', CategoriaController::class);
    
    // Ventas (con verificación de stock)
    Route::resource('ventas', VentaController::class)->middleware('verificar.stock');
    
    // Clientes
    Route::resource('clientes', ClienteController::class);
    Route::get('clientes-ver', [ClienteController::class, 'ver'])->name('clientes.ver');
    
    // Pedidos para administradores
    Route::get('pedidos', [PedidoController::class, 'adminIndex'])->name('pedidos.index');
    
    // Reportes
    Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('reportes/ventas', [ReporteController::class, 'ventas'])->name('reportes.ventas');
    Route::get('reportes/productos', [ReporteController::class, 'productos'])->name('reportes.productos');
    Route::get('reportes/usuarios', [ReporteController::class, 'usuarios'])->name('reportes.usuarios');
    
    // Reportes de Ventas
    Route::get('reportes/ventas-diarias', [ReporteController::class, 'ventasDiarias'])->name('reportes.ventas-diarias');
    Route::get('reportes/ventas-mensuales', [ReporteController::class, 'ventasMensuales'])->name('reportes.ventas-mensuales');
    Route::get('reportes/ventas-anuales', [ReporteController::class, 'ventasAnuales'])->name('reportes.ventas-anuales');
    
    // Reportes de Productos
    Route::get('reportes/productos-mas-vendidos', [ReporteController::class, 'productosMasVendidos'])->name('reportes.productos-mas-vendidos');
    Route::get('reportes/productos-bajo-stock', [ReporteController::class, 'productosBajoStock'])->name('reportes.productos-bajo-stock');
    Route::get('reportes/productos-por-categoria', [ReporteController::class, 'productosPorCategoria'])->name('reportes.productos-por-categoria');
    
    // Reportes de Inventario
    Route::get('reportes/movimientos-inventario', [ReporteController::class, 'movimientosInventario'])->name('reportes.movimientos-inventario');
    Route::get('reportes/valor-inventario', [ReporteController::class, 'valorInventario'])->name('reportes.valor-inventario');
    
    // Reportes de Pedidos
    Route::get('reportes/pedidos-por-estado', [ReporteController::class, 'pedidosPorEstado'])->name('reportes.pedidos-por-estado');
    
    // Reportes de Proveedores y Promociones
    Route::get('reportes/proveedores', [ReporteController::class, 'proveedores'])->name('reportes.proveedores');
    Route::get('reportes/promociones', [ReporteController::class, 'promociones'])->name('reportes.promociones');
    
    // Búsqueda
    Route::get('busqueda', [BusquedaController::class, 'index'])->name('busqueda.index');
    
    // Notificaciones
    Route::get('notificaciones', [NotificacionController::class, 'index'])->name('notificaciones.index');
    
    // Inventario
    Route::get('inventario', [InventarioController::class, 'index'])->name('inventario.index');
    Route::get('inventario/movimientos', [InventarioController::class, 'movimientos'])->name('inventario.movimientos');
    Route::post('inventario/ajuste-stock', [InventarioController::class, 'ajusteStock'])->name('inventario.ajuste-stock');
    Route::get('inventario/reporte-stock', [InventarioController::class, 'reporteStock'])->name('inventario.reporteStock');
    Route::get('inventario/alertas-stock', [InventarioController::class, 'alertasStock'])->name('inventario.alertasStock');
});

// Rutas protegidas para usuarios
Route::middleware(['auth', 'role:Usuario'])->group(function () {
    // Los usuarios pueden ver productos y hacer pedidos
    Route::get('user-productos', [ProductoController::class, 'index'])->name('user.productos.index');
    Route::get('user-productos/{id}', [ProductoController::class, 'show'])->name('user.productos.show');
    
    // Pedidos de usuario
    Route::get('mis-pedidos', [PedidoController::class, 'index'])->name('user.pedidos.index');
    Route::get('mis-pedidos/create', [PedidoController::class, 'create'])->name('user.pedidos.create');
    Route::post('mis-pedidos', [PedidoController::class, 'store'])->name('user.pedidos.store');
    Route::get('mis-pedidos/{id}', [PedidoController::class, 'show'])->name('user.pedidos.show');
});
