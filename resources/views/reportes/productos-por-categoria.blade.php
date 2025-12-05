@extends('layouts.app')

@section('title', 'Productos por Categoría - Wurger')
@section('page-title', 'Productos por Categoría')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Productos por Categoría</h2>
                <a href="{{ route('reportes.productos-por-categoria', ['export' => true]) }}" class="btn btn-primary">
                    <i class="fas fa-download me-2"></i>
                    Exportar Excel
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($categorias as $categoria)
        <div class="col-lg-6 col-xl-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-tags me-2"></i>
                            {{ $categoria->nombre_categoria }}
                        </h5>
                        <span class="badge bg-light text-dark">
                            {{ $categoria->productos_count }} productos
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    @if($categoria->productos->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Stock</th>
                                        <th>Precio</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categoria->productos->take(5) as $producto)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-box text-muted me-2"></i>
                                                <div>
                                                    <strong class="small">{{ $producto->nombre_producto }}</strong>
                                                    @if($producto->tipo_producto)
                                                        <br><small class="text-muted">{{ $producto->tipo_producto }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $producto->stock <= $producto->stock_min ? 'danger' : 'success' }} badge-sm">
                                                {{ $producto->stock }}
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-success fw-bold">${{ number_format($producto->precio_venta, 2) }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $producto->estado == 'Activo' ? 'success' : 'secondary' }} badge-sm">
                                                {{ $producto->estado }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($categoria->productos->count() > 5)
                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    Y {{ $categoria->productos->count() - 5 }} productos más...
                                </small>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-box-open fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">No hay productos en esta categoría</p>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-light">
                    <div class="row text-center">
                        <div class="col-6">
                            <small class="text-muted">Total Productos</small>
                            <div class="fw-bold">{{ $categoria->productos_count }}</div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Cantidad Categoría</small>
                            <div class="fw-bold">{{ $categoria->cantidad_categoria }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No hay categorías disponibles</h4>
                    <p class="text-muted">No se encontraron categorías para mostrar en este reporte.</p>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Resumen general -->
    @if($categorias->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie me-2"></i>
                        Resumen General
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="text-center">
                                <div class="h3 text-primary">{{ $categorias->count() }}</div>
                                <small class="text-muted">Total Categorías</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="text-center">
                                <div class="h3 text-success">{{ $categorias->sum('productos_count') }}</div>
                                <small class="text-muted">Total Productos</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="text-center">
                                <div class="h3 text-warning">{{ number_format($categorias->avg('productos_count'), 1) }}</div>
                                <small class="text-muted">Promedio por Categoría</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="text-center">
                                <div class="h3 text-info">{{ $categorias->max('productos_count') }}</div>
                                <small class="text-muted">Máximo Productos</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.badge-sm {
    font-size: 0.7rem;
    padding: 0.25rem 0.5rem;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.table-sm th,
.table-sm td {
    padding: 0.5rem;
    font-size: 0.875rem;
}
</style>
@endsection
