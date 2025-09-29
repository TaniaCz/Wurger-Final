@extends('layouts.app')

@section('title', 'Reporte de Stock - Wurger')
@section('page-title', 'Reporte de Stock')

<style>
.reporte-header {
    background: var(--wurger-gradient);
    color: white;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
}

.resumen-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.resumen-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    text-align: center;
    transition: all 0.3s ease;
}

.resumen-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
}

.resumen-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin: 0 auto 1rem;
}

.resumen-total {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.resumen-bajo {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.resumen-normal {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.resumen-alto {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    color: white;
}

.resumen-value {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
}

.resumen-label {
    font-size: 0.9rem;
    opacity: 0.8;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.producto-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
}

.producto-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
}

.producto-header {
    display: flex;
    justify-content: between;
    align-items: center;
    margin-bottom: 1rem;
}

.producto-name {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.stock-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.stock-bajo {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
}

.stock-normal {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.stock-alto {
    background: rgba(139, 92, 246, 0.1);
    color: #7c3aed;
}

.stock-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 1rem;
    margin-bottom: 1rem;
}

.stock-item {
    text-align: center;
    padding: 0.5rem;
    background: rgba(59, 130, 246, 0.05);
    border-radius: 10px;
}

.stock-value {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--wurger-primary);
}

.stock-label {
    font-size: 0.8rem;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.progress-custom {
    height: 8px;
    border-radius: 4px;
    background: #e5e7eb;
    overflow: hidden;
    margin-bottom: 1rem;
}

.progress-bar-custom {
    height: 100%;
    border-radius: 4px;
    transition: width 0.3s ease;
}

.progress-success {
    background: linear-gradient(90deg, #10b981, #059669);
}

.progress-warning {
    background: linear-gradient(90deg, #f59e0b, #d97706);
}

.progress-info {
    background: linear-gradient(90deg, #8b5cf6, #7c3aed);
}

.valor-total {
    font-size: 1.1rem;
    font-weight: 700;
    color: #059669;
    text-align: right;
}
</style>

@section('content')
<div class="reporte-header">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h1 class="mb-2">
                <i class="fas fa-chart-bar me-3"></i>
                Reporte de Stock
            </h1>
            <p class="mb-0 opacity-75">Análisis detallado del inventario actual</p>
        </div>
        <a href="{{ route('inventario.index') }}" class="btn btn-light">
            <i class="fas fa-arrow-left me-2"></i>
            Volver al Inventario
        </a>
    </div>
</div>

<!-- Resumen General -->
<div class="resumen-grid">
    <div class="resumen-card">
        <div class="resumen-icon resumen-total">
            <i class="fas fa-boxes"></i>
        </div>
        <div class="resumen-value">{{ $resumen['total_productos'] }}</div>
        <div class="resumen-label">Total Productos</div>
    </div>
    
    <div class="resumen-card">
        <div class="resumen-icon resumen-bajo">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="resumen-value">{{ $resumen['stock_bajo'] }}</div>
        <div class="resumen-label">Stock Bajo</div>
    </div>
    
    <div class="resumen-card">
        <div class="resumen-icon resumen-normal">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="resumen-value">{{ $resumen['stock_normal'] }}</div>
        <div class="resumen-label">Stock Normal</div>
    </div>
    
    <div class="resumen-card">
        <div class="resumen-icon resumen-alto">
            <i class="fas fa-arrow-up"></i>
        </div>
        <div class="resumen-value">{{ $resumen['stock_alto'] }}</div>
        <div class="resumen-label">Stock Alto</div>
    </div>
</div>

<!-- Lista de Productos -->
@forelse($productos as $producto)
    <div class="producto-card">
        <div class="producto-header">
            <h5 class="producto-name">{{ $producto->Nombre_producto }}</h5>
            <span class="stock-badge 
                @if($producto->estado_stock === 'Bajo') stock-bajo
                @elseif($producto->estado_stock === 'Alto') stock-alto
                @else stock-normal
                @endif">
                {{ $producto->estado_stock }}
            </span>
        </div>
        
        <div class="stock-info">
            <div class="stock-item">
                <div class="stock-value">{{ $producto->Stock_producto }}</div>
                <div class="stock-label">Stock Actual</div>
            </div>
            <div class="stock-item">
                <div class="stock-value">{{ $producto->Stock_min_producto }}</div>
                <div class="stock-label">Stock Mínimo</div>
            </div>
            <div class="stock-item">
                <div class="stock-value">{{ $producto->Stock_max_producto }}</div>
                <div class="stock-label">Stock Máximo</div>
            </div>
            <div class="stock-item">
                <div class="stock-value">${{ number_format($producto->Precio_venta, 2) }}</div>
                <div class="stock-label">Precio Unitario</div>
            </div>
        </div>
        
        <div class="progress-custom">
            @php
                $porcentaje = $producto->Stock_max_producto > 0 ? 
                    ($producto->Stock_producto / $producto->Stock_max_producto) * 100 : 0;
            @endphp
            <div class="progress-bar-custom 
                @if($producto->estado_stock === 'Bajo') progress-warning
                @elseif($producto->estado_stock === 'Alto') progress-info
                @else progress-success
                @endif" 
                style="width: {{ min($porcentaje, 100) }}%">
            </div>
        </div>
        
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <small class="text-muted">
                    <i class="fas fa-tag me-1"></i>
                    {{ $producto->categoria->Nombre_categoria ?? 'Sin categoría' }}
                </small>
            </div>
            <div class="valor-total">
                ${{ number_format($producto->valor_total, 2) }}
            </div>
        </div>
    </div>
@empty
    <div class="text-center py-5">
        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
        <h4 class="text-muted">No hay productos en el inventario</h4>
        <p class="text-muted">Comienza agregando productos al sistema.</p>
        <a href="{{ route('productos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            Agregar Producto
        </a>
    </div>
@endforelse

<!-- Resumen de Valor Total -->
@if($productos->count() > 0)
    <div class="resumen-card">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1">Valor Total del Inventario</h5>
                <p class="text-muted mb-0">Suma del valor de todos los productos en stock</p>
            </div>
            <div class="text-end">
                <div class="resumen-value text-success">${{ number_format($resumen['valor_total'], 2) }}</div>
                <div class="resumen-label">Valor Total</div>
            </div>
        </div>
    </div>
@endif
@endsection