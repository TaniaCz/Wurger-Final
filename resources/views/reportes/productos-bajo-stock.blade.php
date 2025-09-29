@extends('layouts.app')

@section('title', 'Productos Bajo Stock - Wurger')
@section('page-title', 'Productos Bajo Stock')

@section('content')
<style>
    .alert-section {
        background: linear-gradient(135deg, #fef3c7 0%, #f59e0b 100%);
        color: #92400e;
        padding: 1.5rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(245, 158, 11, 0.2);
    }
    
    .product-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: transform 0.3s ease;
    }
    
    .product-card:hover {
        transform: translateY(-3px);
    }
    
    .product-header {
        display: flex;
        justify-content: between;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .product-name {
        font-size: 1.2rem;
        font-weight: 700;
        color: #374151;
        margin-bottom: 0.5rem;
    }
    
    .product-category {
        color: #6b7280;
        font-size: 0.9rem;
    }
    
    .stock-info {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .stock-item {
        text-align: center;
        padding: 0.75rem;
        border-radius: 10px;
        background: rgba(0, 0, 0, 0.05);
    }
    
    .stock-number {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    
    .stock-label {
        font-size: 0.8rem;
        color: #6b7280;
        text-transform: uppercase;
        font-weight: 600;
    }
    
    .stock-actual {
        color: #dc2626;
    }
    
    .stock-min {
        color: #f59e0b;
    }
    
    .stock-diff {
        color: #dc2626;
        font-weight: 700;
    }
    
    .priority-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .priority-critica {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .priority-alta {
        background: #fef3c7;
        color: #92400e;
    }
    
    .priority-media {
        background: #dbeafe;
        color: #1e40af;
    }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .btn-action {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .btn-reorder {
        background: #3b82f6;
        color: white;
    }
    
    .btn-reorder:hover {
        background: #2563eb;
        color: white;
        text-decoration: none;
    }
    
    .btn-details {
        background: #6b7280;
        color: white;
    }
    
    .btn-details:hover {
        background: #4b5563;
        color: white;
        text-decoration: none;
    }
    
    .export-btn {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .export-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        color: white;
        text-decoration: none;
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .empty-icon {
        font-size: 4rem;
        color: #10b981;
        margin-bottom: 1rem;
    }
</style>

<div class="container-fluid">
    <!-- Header del Reporte -->
    <div class="alert-section">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="mb-2">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Productos Bajo Stock
                </h2>
                <p class="mb-0">
                    Productos que requieren reposición urgente. El stock actual es menor o igual al stock mínimo.
                </p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('reportes.productos-bajo-stock', ['export' => 1]) }}" class="export-btn">
                    <i class="fas fa-file-excel"></i>
                    Exportar Excel
                </a>
            </div>
        </div>
    </div>

    @if($productos->count() > 0)
        <!-- Estadísticas Rápidas -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="product-card text-center">
                    <div class="stock-number text-danger">{{ $productos->count() }}</div>
                    <div class="stock-label">Productos Bajo Stock</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="product-card text-center">
                    <div class="stock-number text-warning">{{ $productos->where('stock', 0)->count() }}</div>
                    <div class="stock-label">Sin Stock</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="product-card text-center">
                    <div class="stock-number text-info">{{ $productos->where('stock', '>', 0)->count() }}</div>
                    <div class="stock-label">Con Stock Mínimo</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="product-card text-center">
                    <div class="stock-number text-success">${{ number_format($productos->sum(function($p) { return $p->stock * $p->precio_venta; }), 2) }}</div>
                    <div class="stock-label">Valor Total</div>
                </div>
            </div>
        </div>

        <!-- Lista de Productos -->
        <div class="row">
            @foreach($productos as $producto)
            @php
                $diferencia = $producto->stock - $producto->stock_min;
                $porcentaje = $producto->stock_min > 0 ? ($producto->stock / $producto->stock_min) * 100 : 0;
                
                if ($producto->stock == 0) {
                    $prioridad = 'critica';
                } elseif ($porcentaje <= 25) {
                    $prioridad = 'alta';
                } else {
                    $prioridad = 'media';
                }
            @endphp
            <div class="col-lg-6 mb-3">
                <div class="product-card">
                    <div class="product-header">
                        <div class="flex-grow-1">
                            <div class="product-name">{{ $producto->nombre_producto }}</div>
                            <div class="product-category">
                                <i class="fas fa-tag me-1"></i>
                                {{ $producto->categoria->nombre_categoria ?? 'Sin categoría' }}
                            </div>
                        </div>
                        <div>
                            <span class="priority-badge priority-{{ $prioridad }}">
                                @if($prioridad == 'critica')
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    Crítica
                                @elseif($prioridad == 'alta')
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    Alta
                                @else
                                    <i class="fas fa-info-circle me-1"></i>
                                    Media
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="stock-info">
                        <div class="stock-item">
                            <div class="stock-number stock-actual">{{ $producto->stock }}</div>
                            <div class="stock-label">Stock Actual</div>
                        </div>
                        <div class="stock-item">
                            <div class="stock-number stock-min">{{ $producto->stock_min ?? 0 }}</div>
                            <div class="stock-label">Stock Mínimo</div>
                        </div>
                        <div class="stock-item">
                            <div class="stock-number stock-diff">{{ $diferencia }}</div>
                            <div class="stock-label">Diferencia</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <i class="fas fa-dollar-sign me-1"></i>
                                Precio: ${{ number_format($producto->precio_venta, 2) }}
                            </small>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">
                                <i class="fas fa-cube me-1"></i>
                                Valor: ${{ number_format($producto->stock * $producto->precio_venta, 2) }}
                            </small>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <a href="#" class="btn-action btn-reorder">
                            <i class="fas fa-plus-circle"></i>
                            Reponer Stock
                        </a>
                        <a href="{{ route('productos.show', $producto->id_producto) }}" class="btn-action btn-details">
                            <i class="fas fa-eye"></i>
                            Ver Detalles
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Resumen por Categoría -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="product-card">
                    <h5 class="mb-3">
                        <i class="fas fa-chart-pie me-2"></i>
                        Resumen por Categoría
                    </h5>
                    <div class="row">
                        @php
                            $categorias = $productos->groupBy(function($producto) {
                                return $producto->categoria->nombre_categoria ?? 'Sin categoría';
                            });
                        @endphp
                        @foreach($categorias as $categoria => $productosCategoria)
                        <div class="col-md-3 mb-2">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="h5 mb-1">{{ $productosCategoria->count() }}</div>
                                <div class="text-muted small">{{ $categoria }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Estado Vacío -->
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h4 class="text-success mb-3">¡Excelente!</h4>
            <h5 class="text-muted mb-3">No hay productos bajo stock</h5>
            <p class="text-muted mb-4">
                Todos los productos tienen stock suficiente. Mantén este nivel de inventario.
            </p>
            <a href="{{ route('inventario.index') }}" class="btn btn-primary">
                <i class="fas fa-warehouse me-1"></i>
                Ver Inventario Completo
            </a>
        </div>
    @endif
</div>
@endsection
