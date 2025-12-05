@extends('layouts.app')

@section('title', 'Alertas de Stock - Wurger')
@section('page-title', 'Alertas de Stock')

<style>
.alertas-header {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
}

.alerta-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(245, 158, 11, 0.2);
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
    border-left: 5px solid #f59e0b;
}

.alerta-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
    border-left-color: #d97706;
}

.alerta-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-right: 1rem;
    flex-shrink: 0;
}

.alerta-info h6 {
    margin: 0;
    color: #1f2937;
    font-weight: 700;
}

.alerta-info p {
    margin: 0;
    color: #6b7280;
    font-size: 0.9rem;
}

.stock-urgente {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.stock-critico {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.stock-bajo {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: white;
}

.stock-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.urgente {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
}

.critico {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
}

.bajo {
    background: rgba(251, 191, 36, 0.1);
    color: #f59e0b;
}

.accion-btn {
    padding: 0.5rem 1rem;
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-reabastecer {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.btn-reabastecer:hover {
    background: linear-gradient(135deg, #059669, #047857);
    color: white;
    transform: translateY(-2px);
}

.btn-editar {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.btn-editar:hover {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: white;
    transform: translateY(-2px);
}

.no-alertas {
    text-align: center;
    padding: 3rem;
    color: #6b7280;
}

.no-alertas i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.resumen-alertas {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    margin-bottom: 2rem;
}

.resumen-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
}

.resumen-item {
    text-align: center;
    padding: 1rem;
    background: rgba(245, 158, 11, 0.05);
    border-radius: 15px;
    border: 1px solid rgba(245, 158, 11, 0.1);
}

.resumen-value {
    font-size: 1.5rem;
    font-weight: 800;
    color: #f59e0b;
    margin-bottom: 0.25rem;
}

.resumen-label {
    font-size: 0.8rem;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
</style>

@section('content')
<div class="alertas-header">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h1 class="mb-2">
                <i class="fas fa-exclamation-triangle me-3"></i>
                Alertas de Stock
            </h1>
            <p class="mb-0 opacity-75">Productos que requieren atención inmediata</p>
        </div>
        <a href="{{ route('inventario.index') }}" class="btn btn-light">
            <i class="fas fa-arrow-left me-2"></i>
            Volver al Inventario
        </a>
    </div>
</div>

@if($alertas->count() > 0)
    <!-- Resumen de Alertas -->
    <div class="resumen-alertas">
        <h5 class="mb-3">
            <i class="fas fa-chart-pie me-2"></i>
            Resumen de Alertas
        </h5>
        
        <div class="resumen-grid">
            <div class="resumen-item">
                <div class="resumen-value">{{ $alertas->count() }}</div>
                <div class="resumen-label">Total Alertas</div>
            </div>
            <div class="resumen-item">
                <div class="resumen-value">{{ $alertas->where('Stock_producto', 0)->count() }}</div>
                <div class="resumen-label">Sin Stock</div>
            </div>
            <div class="resumen-item">
                <div class="resumen-value">{{ $alertas->where('Stock_producto', '>', 0)->where('Stock_producto', '<=', 5)->count() }}</div>
                <div class="resumen-label">Stock Crítico</div>
            </div>
            <div class="resumen-item">
                <div class="resumen-value">{{ $alertas->where('Stock_producto', '>', 5)->count() }}</div>
                <div class="resumen-label">Stock Bajo</div>
            </div>
        </div>
    </div>

    <!-- Lista de Alertas -->
    @foreach($alertas as $alerta)
        @php
            $nivelAlerta = $alerta->Stock_producto == 0 ? 'urgente' : 
                          ($alerta->Stock_producto <= 5 ? 'critico' : 'bajo');
        @endphp
        <div class="alerta-card">
            <div class="d-flex align-items-start">
                <div class="alerta-icon 
                    @if($nivelAlerta === 'urgente') stock-urgente
                    @elseif($nivelAlerta === 'critico') stock-critico
                    @else stock-bajo
                    @endif">
                    @if($nivelAlerta === 'urgente')
                        <i class="fas fa-times-circle"></i>
                    @elseif($nivelAlerta === 'critico')
                        <i class="fas fa-exclamation-triangle"></i>
                    @else
                        <i class="fas fa-exclamation-circle"></i>
                    @endif
                </div>
                
                <div class="alerta-info flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6>{{ $alerta->Nombre_producto }}</h6>
                        <span class="stock-badge {{ $nivelAlerta }}">
                            @if($nivelAlerta === 'urgente')
                                Sin Stock
                            @elseif($nivelAlerta === 'critico')
                                Crítico
                            @else
                                Bajo Stock
                            @endif
                        </span>
                    </div>
                    
                    <p class="mb-2">
                        <i class="fas fa-tag me-1"></i>
                        {{ $alerta->categoria->Nombre_categoria ?? 'Sin categoría' }}
                    </p>
                    
                    <div class="row">
                        <div class="col-md-3">
                            <p class="mb-1">
                                <strong>Stock Actual:</strong> 
                                <span class="text-danger fw-bold">{{ $alerta->Stock_producto }}</span>
                            </p>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-1">
                                <strong>Stock Mínimo:</strong> {{ $alerta->Stock_min_producto }}
                            </p>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-1">
                                <strong>Precio:</strong> ${{ number_format($alerta->Precio_venta, 2) }}
                            </p>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-1">
                                <strong>Diferencia:</strong> 
                                <span class="text-danger">
                                    {{ $alerta->Stock_min_producto - $alerta->Stock_producto }} unidades
                                </span>
                            </p>
                        </div>
                    </div>
                    
                    <div class="progress-custom">
                        @php
                            $porcentaje = $alerta->Stock_max_producto > 0 ? 
                                ($alerta->Stock_producto / $alerta->Stock_max_producto) * 100 : 0;
                        @endphp
                        <div class="progress-bar-custom progress-warning" 
                             style="width: {{ min($porcentaje, 100) }}%">
                        </div>
                    </div>
                </div>
                
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('productos.edit', $alerta->id_producto) }}" class="accion-btn btn-editar">
                        <i class="fas fa-edit"></i>
                        Editar
                    </a>
                    <a href="{{ route('inventario.index') }}?reabastecer={{ $alerta->id_producto }}" class="accion-btn btn-reabastecer">
                        <i class="fas fa-plus"></i>
                        Reabastecer
                    </a>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="no-alertas">
        <i class="fas fa-check-circle"></i>
        <h4>¡Excelente!</h4>
        <p>No hay alertas de stock en este momento.</p>
        <p class="text-muted">Todos los productos tienen stock suficiente.</p>
        <a href="{{ route('inventario.index') }}" class="btn btn-primary">
            <i class="fas fa-warehouse me-2"></i>
            Ver Inventario Completo
        </a>
    </div>
@endif
@endsection