@extends('layouts.app')

@section('title', 'Reporte de Productos - Wurger')
@section('page-title', 'Reporte de Productos')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Reporte de Productos</h2>
                <a href="{{ route('reportes.productos', ['export' => true]) }}" class="btn btn-primary">
                    <i class="fas fa-download me-2"></i>
                    Exportar Excel
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if($productos->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Producto</th>
                                        <th>Categoría</th>
                                        <th>Stock</th>
                                        <th>Precio Venta</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productos as $index => $producto)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-box text-primary me-2"></i>
                                                <div>
                                                    <strong>{{ $producto->nombre_producto }}</strong>
                                                    @if($producto->tipo_producto)
                                                        <br><small class="text-muted">{{ $producto->tipo_producto }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($producto->categoria)
                                                <span class="badge bg-info">{{ $producto->categoria->nombre_categoria }}</span>
                                            @else
                                                <span class="text-muted">Sin categoría</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $producto->stock <= $producto->stock_min ? 'danger' : 'success' }}">
                                                {{ $producto->stock }}
                                            </span>
                                            @if($producto->stock_min)
                                                <br><small class="text-muted">Mín: {{ $producto->stock_min }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <strong class="text-success">${{ number_format($producto->precio_venta, 2) }}</strong>
                                            @if($producto->precio_compra)
                                                <br><small class="text-muted">Costo: ${{ number_format($producto->precio_compra, 2) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $producto->estado == 'Activo' ? 'success' : 'secondary' }}">
                                                {{ $producto->estado }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('productos.show', $producto->id_producto) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-box fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No hay productos disponibles</h4>
                            <p class="text-muted">No se encontraron productos para mostrar en este reporte.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
