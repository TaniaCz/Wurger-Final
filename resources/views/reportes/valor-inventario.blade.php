@extends('layouts.app')

@section('title', 'Valor del Inventario - Wurger')
@section('page-title', 'Valor del Inventario')

@section('content')
<style>
    .summary-card {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(16, 185, 129, 0.2);
    }
    
    .value-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: transform 0.3s ease;
    }
    
    .value-card:hover {
        transform: translateY(-3px);
    }
    
    .product-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }
    
    .product-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: #374151;
        margin-bottom: 0.25rem;
    }
    
    .product-category {
        color: #6b7280;
        font-size: 0.9rem;
    }
    
    .value-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .value-item {
        text-align: center;
        padding: 0.75rem;
        border-radius: 10px;
        background: rgba(0, 0, 0, 0.05);
    }
    
    .value-number {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    
    .value-label {
        font-size: 0.8rem;
        color: #6b7280;
        text-transform: uppercase;
        font-weight: 600;
    }
    
    .stock-count {
        color: #3b82f6;
    }
    
    .unit-price {
        color: #6b7280;
    }
    
    .total-value {
        color: #10b981;
        font-size: 1.3rem;
    }
    
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .status-activo {
        background: #d1fae5;
        color: #065f46;
    }
    
    .status-inactivo {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .chart-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
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
    
    .filter-section {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .sort-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .btn-sort {
        padding: 0.5rem 1rem;
        border: 1px solid #d1d5db;
        background: white;
        color: #374151;
        border-radius: 8px;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    
    .btn-sort:hover,
    .btn-sort.active {
        background: #3b82f6;
        color: white;
        border-color: #3b82f6;
        text-decoration: none;
    }
</style>

<div class="container-fluid">
    <!-- Resumen General -->
    <div class="summary-card">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="mb-2">
                    <i class="fas fa-dollar-sign me-2"></i>
                    Valor Total del Inventario
                </h2>
                <p class="mb-0 opacity-75">
                    Evaluación económica completa del stock actual
                </p>
            </div>
            <div class="col-md-4 text-end">
                <div class="h1 mb-0">${{ number_format($valorTotalInventario, 2) }}</div>
                <small class="opacity-75">{{ $productos->count() }} productos</small>
            </div>
        </div>
    </div>

    <!-- Filtros y Ordenamiento -->
    <div class="filter-section">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h6 class="mb-2">Ordenar por:</h6>
                <div class="sort-buttons">
                    <a href="?sort=valor" class="btn-sort {{ request('sort') == 'valor' ? 'active' : '' }}">
                        <i class="fas fa-dollar-sign me-1"></i>
                        Valor Total
                    </a>
                    <a href="?sort=nombre" class="btn-sort {{ request('sort') == 'nombre' ? 'active' : '' }}">
                        <i class="fas fa-sort-alpha-down me-1"></i>
                        Nombre
                    </a>
                    <a href="?sort=stock" class="btn-sort {{ request('sort') == 'stock' ? 'active' : '' }}">
                        <i class="fas fa-cube me-1"></i>
                        Stock
                    </a>
                    <a href="?sort=precio" class="btn-sort {{ request('sort') == 'precio' ? 'active' : '' }}">
                        <i class="fas fa-tag me-1"></i>
                        Precio
                    </a>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('reportes.valor-inventario', ['export' => 1]) }}" class="export-btn">
                    <i class="fas fa-file-excel"></i>
                    Exportar Excel
                </a>
            </div>
        </div>
    </div>

    <!-- Estadísticas Rápidas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="value-card text-center">
                <div class="value-number text-primary">{{ $productos->count() }}</div>
                <div class="value-label">Total Productos</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="value-card text-center">
                <div class="value-number text-success">{{ $productos->where('estado', 'Activo')->count() }}</div>
                <div class="value-label">Productos Activos</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="value-card text-center">
                <div class="value-number text-info">{{ $productos->sum('stock') }}</div>
                <div class="value-label">Total Unidades</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="value-card text-center">
                <div class="value-number text-warning">${{ number_format($productos->avg('precio_venta'), 2) }}</div>
                <div class="value-label">Precio Promedio</div>
            </div>
        </div>
    </div>

    <!-- Gráfico de Distribución -->
    <div class="chart-container">
        <h5 class="mb-3">
            <i class="fas fa-chart-pie me-2"></i>
            Distribución del Valor por Categoría
        </h5>
        <canvas id="valorPorCategoriaChart" width="400" height="200"></canvas>
    </div>

    <!-- Lista de Productos -->
    <div class="row">
        @foreach($productos as $producto)
        <div class="col-lg-6 mb-3">
            <div class="value-card">
                <div class="product-header">
                    <div class="flex-grow-1">
                        <div class="product-name">{{ $producto->nombre_producto }}</div>
                        <div class="product-category">
                            <i class="fas fa-tag me-1"></i>
                            {{ $producto->categoria->nombre_categoria ?? 'Sin categoría' }}
                        </div>
                    </div>
                    <div>
                        <span class="status-badge status-{{ strtolower($producto->estado) }}">
                            {{ $producto->estado }}
                        </span>
                    </div>
                </div>

                <div class="value-info">
                    <div class="value-item">
                        <div class="value-number stock-count">{{ $producto->stock }}</div>
                        <div class="value-label">Stock</div>
                    </div>
                    <div class="value-item">
                        <div class="value-number unit-price">${{ number_format($producto->precio_venta, 2) }}</div>
                        <div class="value-label">Precio Unit.</div>
                    </div>
                    <div class="value-item">
                        <div class="value-number total-value">${{ number_format($producto->valor_total, 2) }}</div>
                        <div class="value-label">Valor Total</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>
                            Ingreso: {{ $producto->fecha_ingreso ? \Carbon\Carbon::parse($producto->fecha_ingreso)->format('d/m/Y') : 'No especificado' }}
                        </small>
                    </div>
                    <div class="col-md-6 text-end">
                        <small class="text-muted">
                            <i class="fas fa-percentage me-1"></i>
                            {{ $productos->count() > 0 ? number_format(($producto->valor_total / $valorTotalInventario) * 100, 1) : 0 }}% del total
                        </small>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Resumen por Categoría -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="value-card">
                <h5 class="mb-3">
                    <i class="fas fa-chart-bar me-2"></i>
                    Resumen por Categoría
                </h5>
                <div class="row">
                    @php
                        $categorias = $productos->groupBy(function($producto) {
                            return $producto->categoria->nombre_categoria ?? 'Sin categoría';
                        })->map(function($productosCategoria) {
                            return [
                                'count' => $productosCategoria->count(),
                                'valor' => $productosCategoria->sum('valor_total'),
                                'stock' => $productosCategoria->sum('stock')
                            ];
                        })->sortByDesc('valor');
                    @endphp
                    @foreach($categorias as $categoria => $data)
                    <div class="col-md-4 mb-3">
                        <div class="p-3 bg-light rounded">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">{{ $categoria }}</h6>
                                <span class="badge bg-primary">{{ $data['count'] }} productos</span>
                            </div>
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="h6 mb-1 text-success">${{ number_format($data['valor'], 2) }}</div>
                                    <small class="text-muted">Valor Total</small>
                                </div>
                                <div class="col-6">
                                    <div class="h6 mb-1 text-info">{{ $data['stock'] }}</div>
                                    <small class="text-muted">Unidades</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de Distribución por Categoría
    const categorias = @json($productos->groupBy(function($p) { return $p->categoria->nombre_categoria ?? 'Sin categoría'; })->keys());
    const valores = @json($productos->groupBy(function($p) { return $p->categoria->nombre_categoria ?? 'Sin categoría'; })->map(function($productos) { return $productos->sum('valor_total'); }));

    new Chart(document.getElementById('valorPorCategoriaChart'), {
        type: 'doughnut',
        data: {
            labels: categorias,
            datasets: [{
                data: Object.values(valores),
                backgroundColor: [
                    '#667eea',
                    '#764ba2',
                    '#f093fb',
                    '#f5576c',
                    '#4facfe',
                    '#00f2fe',
                    '#43e97b',
                    '#38f9d7'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.parsed;
                            const total = Object.values(valores).reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return context.label + ': $' + value.toLocaleString() + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
