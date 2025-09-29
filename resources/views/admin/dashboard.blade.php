@extends('layouts.app')

@section('title', 'Dashboard Administrador - Wurger')
@section('page-title', 'Dashboard Administrador')

@section('content')
<!-- Estadísticas principales -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Usuarios</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $stats['total_usuarios'] }}</div>
                        <small class="text-white-50">Sistema completo</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Ventas Hoy</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $stats['ventas_hoy'] }}</div>
                        <small class="text-white-50">${{ number_format($stats['ingresos_hoy'], 2) }}</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-shopping-cart fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card bg-info text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Productos</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $stats['total_productos'] }}</div>
                        <small class="text-white-50">{{ $stats['productos_bajo_stock'] }} bajo stock</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-box fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card bg-warning text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Pedidos Pendientes</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $stats['pedidos_pendientes'] }}</div>
                        <small class="text-white-50">Requieren atención</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Acciones Rápidas -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Acciones Rápidas
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                        <a href="{{ route('clientes.ver') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="fas fa-users fa-2x mb-2"></i>
                            <span>Ver Clientes</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                        <a href="{{ route('productos.create') }}" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="fas fa-plus-circle fa-2x mb-2"></i>
                            <span>Nuevo Producto</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                        <a href="{{ route('ventas.create') }}" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                            <span>Nueva Venta</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                        <a href="{{ route('home') }}" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="fas fa-home fa-2x mb-2"></i>
                            <span>Ir a Inicio</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                        <a href="{{ route('inventario.index') }}" class="btn btn-outline-secondary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="fas fa-warehouse fa-2x mb-2"></i>
                            <span>Inventario</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                        <a href="{{ route('reportes.index') }}" class="btn btn-outline-dark w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="fas fa-chart-bar fa-2x mb-2"></i>
                            <span>Reportes</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Ventas Recientes -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-shopping-cart me-2"></i>
                    Ventas Recientes
                </h6>
                <a href="{{ route('ventas.index') }}" class="btn btn-sm btn-outline-primary">Ver Todas</a>
            </div>
            <div class="card-body">
                @if($ventas_recientes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ventas_recientes as $venta)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary">#{{ $venta->id_venta }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $venta->usuario->usuarioInfo->nombre ?? $venta->usuario->email }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $venta->fecha->format('d/m/Y H:i') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>${{ number_format($venta->Total_venta, 2) }}</strong>
                                    </td>
                                    <td>
                                        @if($venta->estado == 'Pagada')
                                            <span class="badge bg-success">{{ $venta->estado }}</span>
                                        @elseif($venta->estado == 'Pendiente')
                                            <span class="badge bg-warning">{{ $venta->estado }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $venta->estado }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No hay ventas recientes</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Pedidos Recientes -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-shopping-bag me-2"></i>
                    Pedidos Recientes
                </h6>
                <a href="{{ route('pedidos.index') }}" class="btn btn-sm btn-outline-primary">Ver Todos</a>
            </div>
            <div class="card-body">
                @if($pedidos_recientes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pedidos_recientes as $pedido)
                                <tr>
                                    <td>
                                        <span class="badge bg-info">#{{ $pedido->id_pedido }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $pedido->usuarioInfo->nombre ?? 'N/A' }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $pedido->usuarioInfo->usuario->email ?? '' }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <small>{{ $pedido->fecha->format('d/m/Y') }}</small>
                                    </td>
                                    <td>
                                        @if($pedido->estado == 'Entregado')
                                            <span class="badge bg-success">{{ $pedido->estado }}</span>
                                        @elseif($pedido->estado == 'Pendiente')
                                            <span class="badge bg-warning">{{ $pedido->estado }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $pedido->estado }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No hay pedidos recientes</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Productos con Stock Bajo -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Productos con Stock Bajo
                </h6>
                <a href="{{ route('reportes.productos-bajo-stock') }}" class="btn btn-sm btn-outline-warning">Ver Reporte</a>
            </div>
            <div class="card-body">
                @if($productos_bajo_stock->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Stock</th>
                                    <th>Mínimo</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productos_bajo_stock as $producto)
                                <tr>
                                    <td>
                                        <strong>{{ $producto->nombre_producto }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $producto->categoria->nombre_categoria ?? 'Sin categoría' }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger">{{ $producto->stock }}</span>
                                    </td>
                                    <td>{{ $producto->stock_min }}</td>
                                    <td>
                                        <a href="{{ route('productos.edit', $producto->id_producto) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <p class="text-success">Todos los productos tienen stock suficiente</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Productos Más Vendidos -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-star me-2"></i>
                    Productos Recientes
                </h6>
                <a href="{{ route('productos.index') }}" class="btn btn-sm btn-outline-success">Ver Todos</a>
            </div>
            <div class="card-body">
                @if($productos_mas_vendidos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Producto</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productos_mas_vendidos as $index => $producto)
                                <tr>
                                    <td>
                                        <span class="text-muted">{{ $index + 1 }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $producto->nombre_producto }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $producto->stock ?? 0 }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No hay datos de ventas recientes</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas Adicionales -->
<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-info">
                    <i class="fas fa-chart-pie me-2"></i>
                    Resumen del Mes
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <h4 class="text-primary">{{ $stats['ventas_mes'] }}</h4>
                            <small class="text-muted">Ventas</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success">${{ number_format($stats['ingresos_mes'], 2) }}</h4>
                        <small class="text-muted">Ingresos</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-warning">
                    <i class="fas fa-users me-2"></i>
                    Usuarios Recientes
                </h6>
            </div>
            <div class="card-body">
                @if($usuarios_recientes->count() > 0)
                    @foreach($usuarios_recientes as $usuario)
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-circle fa-2x text-muted"></i>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <div class="fw-bold">{{ $usuario->usuarioInfo->nombre ?? $usuario->email }}</div>
                            <small class="text-muted">{{ $usuario->created_at->diffForHumans() }}</small>
                        </div>
                        <div>
                            <span class="badge bg-{{ $usuario->rol == 'Administrador' ? 'primary' : 'success' }}">
                                {{ $usuario->rol }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted text-center">No hay usuarios recientes</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-line me-2"></i>
                    Ventas (7 días)
                </h6>
            </div>
            <div class="card-body">
                @if($ventas_por_dia->count() > 0)
                    @foreach($ventas_por_dia as $venta)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m') }}</small>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold">{{ $venta->cantidad }}</div>
                            <small class="text-muted">${{ number_format($venta->total, 2) }}</small>
                        </div>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted text-center">No hay datos de ventas</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection