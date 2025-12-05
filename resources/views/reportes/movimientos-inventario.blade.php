@extends('layouts.app')

@section('title', 'Movimientos de Inventario - Wurger')
@section('page-title', 'Movimientos de Inventario')

@section('content')
<style>
    .filter-section {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .movement-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: transform 0.3s ease;
    }
    
    .movement-card:hover {
        transform: translateY(-3px);
    }
    
    .movement-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .movement-type {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .type-entrada {
        background: #d1fae5;
        color: #065f46;
    }
    
    .type-salida {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .product-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .product-details {
        flex-grow: 1;
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
    
    .movement-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .detail-item {
        text-align: center;
        padding: 0.75rem;
        border-radius: 10px;
        background: rgba(0, 0, 0, 0.05);
    }
    
    .detail-number {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    
    .detail-label {
        font-size: 0.8rem;
        color: #6b7280;
        text-transform: uppercase;
        font-weight: 600;
    }
    
    .cantidad {
        color: #3b82f6;
    }
    
    .fecha {
        color: #6b7280;
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
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 15px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        color: #6b7280;
        font-weight: 500;
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
        color: #6b7280;
        margin-bottom: 1rem;
    }
</style>

<div class="container-fluid">
    <!-- Header del Reporte -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="movement-card">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="mb-2">
                            <i class="fas fa-exchange-alt me-2"></i>
                            Movimientos de Inventario
                        </h2>
                        <p class="mb-0 text-muted">
                            Registro completo de entradas y salidas de productos
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        <a href="{{ route('reportes.movimientos-inventario', ['export' => 1, 'fecha_inicio' => $fechaInicio, 'fecha_fin' => $fechaFin]) }}" class="export-btn">
                            <i class="fas fa-file-excel"></i>
                            Exportar Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="filter-section">
        <form method="GET" action="{{ route('reportes.movimientos-inventario') }}">
            <div class="row align-items-end">
                <div class="col-md-3">
                    <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ $fechaInicio }}">
                </div>
                <div class="col-md-3">
                    <label for="fecha_fin" class="form-label">Fecha Fin</label>
                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="{{ $fechaFin }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i>
                        Filtrar
                    </button>
                    <a href="{{ route('reportes.movimientos-inventario') }}" class="btn btn-outline-secondary ms-2">
                        <i class="fas fa-refresh me-1"></i>
                        Limpiar
                    </a>
                </div>
                <div class="col-md-3 text-end">
                    <a href="{{ route('reportes.movimientos-inventario', ['export' => 1, 'fecha_inicio' => $fechaInicio, 'fecha_fin' => $fechaFin]) }}" class="export-btn">
                        <i class="fas fa-download me-1"></i>
                        Exportar con Filtro
                    </a>
                </div>
            </div>
        </form>
    </div>

    @if($movimientos->count() > 0)
        <!-- Estadísticas -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number text-primary">{{ $movimientos->count() }}</div>
                <div class="stat-label">Total Movimientos</div>
            </div>
            <div class="stat-card">
                <div class="stat-number text-success">{{ $movimientos->where('tipo', 'Entrada')->count() }}</div>
                <div class="stat-label">Entradas</div>
            </div>
            <div class="stat-card">
                <div class="stat-number text-danger">{{ $movimientos->where('tipo', 'Salida')->count() }}</div>
                <div class="stat-label">Salidas</div>
            </div>
            <div class="stat-card">
                <div class="stat-number text-info">{{ $movimientos->sum('cantidad') }}</div>
                <div class="stat-label">Total Unidades</div>
            </div>
        </div>

        <!-- Lista de Movimientos -->
        <div class="row">
            @foreach($movimientos as $movimiento)
            <div class="col-12 mb-3">
                <div class="movement-card">
                    <div class="movement-header">
                        <div>
                            <h5 class="mb-1">Movimiento #{{ $movimiento->id_movimiento }}</h5>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($movimiento->fecha)->format('d/m/Y') }} - 
                                {{ \Carbon\Carbon::parse($movimiento->created_at)->format('H:i') }}
                            </small>
                        </div>
                        <div>
                            <span class="movement-type type-{{ strtolower($movimiento->tipo) }}">
                                <i class="fas fa-{{ $movimiento->tipo == 'Entrada' ? 'arrow-up' : 'arrow-down' }} me-1"></i>
                                {{ $movimiento->tipo }}
                            </span>
                        </div>
                    </div>

                    <div class="product-info">
                        <div class="product-details">
                            <div class="product-name">
                                {{ $movimiento->producto->nombre_producto ?? 'Producto eliminado' }}
                            </div>
                            <div class="product-category">
                                <i class="fas fa-tag me-1"></i>
                                {{ $movimiento->producto->categoria->nombre_categoria ?? 'Sin categoría' }}
                            </div>
                        </div>
                    </div>

                    <div class="movement-details">
                        <div class="detail-item">
                            <div class="detail-number cantidad">{{ $movimiento->cantidad }}</div>
                            <div class="detail-label">Cantidad</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-number fecha">{{ \Carbon\Carbon::parse($movimiento->fecha)->format('d/m/Y') }}</div>
                            <div class="detail-label">Fecha Movimiento</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-number text-muted">
                                {{ $movimiento->producto->stock ?? 0 }}
                            </div>
                            <div class="detail-label">Stock Actual</div>
                        </div>
                    </div>

                    @if($movimiento->descripcion)
                    <div class="mt-3">
                        <strong>Descripción:</strong>
                        <p class="text-muted mb-0">{{ $movimiento->descripcion }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Resumen por Tipo -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="movement-card">
                    <h5 class="mb-3">
                        <i class="fas fa-chart-pie me-2"></i>
                        Resumen por Tipo de Movimiento
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="p-3 bg-success bg-opacity-10 rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1 text-success">Entradas</h6>
                                        <small class="text-muted">Movimientos de ingreso de productos</small>
                                    </div>
                                    <div class="text-end">
                                        <div class="h4 mb-1 text-success">{{ $movimientos->where('tipo', 'Entrada')->count() }}</div>
                                        <small class="text-muted">{{ $movimientos->where('tipo', 'Entrada')->sum('cantidad') }} unidades</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-danger bg-opacity-10 rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1 text-danger">Salidas</h6>
                                        <small class="text-muted">Movimientos de egreso de productos</small>
                                    </div>
                                    <div class="text-end">
                                        <div class="h4 mb-1 text-danger">{{ $movimientos->where('tipo', 'Salida')->count() }}</div>
                                        <small class="text-muted">{{ $movimientos->where('tipo', 'Salida')->sum('cantidad') }} unidades</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Estado Vacío -->
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <h4 class="text-muted mb-3">No hay movimientos</h4>
            <h5 class="text-muted mb-3">en el período seleccionado</h5>
            <p class="text-muted mb-4">
                No se encontraron movimientos de inventario para las fechas especificadas.
                Intenta con un rango de fechas diferente.
            </p>
            <a href="{{ route('inventario.index') }}" class="btn btn-primary">
                <i class="fas fa-warehouse me-1"></i>
                Ver Inventario
            </a>
        </div>
    @endif
</div>

<script>
    // Auto-submit del formulario cuando cambien las fechas
    document.getElementById('fecha_inicio').addEventListener('change', function() {
        this.form.submit();
    });
    
    document.getElementById('fecha_fin').addEventListener('change', function() {
        this.form.submit();
    });
</script>
@endsection
