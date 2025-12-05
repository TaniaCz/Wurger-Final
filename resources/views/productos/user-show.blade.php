@extends('layouts.app')

@section('title', 'Detalle del Plato - Wurger')
@section('page-title', 'Detalle del Plato')

<style>
.producto-header {
    background: var(--wurger-gradient);
    color: white;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
}

.producto-image {
    width: 100px;
    height: 100px;
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    margin-right: 1.5rem;
    border: 3px solid rgba(255, 255, 255, 0.3);
}

.info-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    margin-bottom: 1.5rem;
}

.info-label {
    font-weight: 600;
    color: #6b7280;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    font-size: 1.1rem;
    color: #1f2937;
    font-weight: 500;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.stat-item {
    text-align: center;
    padding: 1rem;
    background: rgba(59, 130, 246, 0.05);
    border-radius: 15px;
    border: 1px solid rgba(59, 130, 246, 0.1);
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--wurger-primary);
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.8rem;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stock-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
}

.stock-disponible {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.stock-agotado {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.price-display {
    font-size: 2rem;
    font-weight: 800;
    color: var(--wurger-primary);
    text-align: center;
    padding: 1rem;
    background: rgba(59, 130, 246, 0.05);
    border-radius: 15px;
    border: 1px solid rgba(59, 130, 246, 0.1);
}

.progress-custom {
    height: 10px;
    border-radius: 5px;
    background: #e5e7eb;
    overflow: hidden;
}

.progress-bar-custom {
    height: 100%;
    border-radius: 5px;
    transition: width 0.3s ease;
}

.progress-bar-success {
    background: linear-gradient(90deg, #10b981, #059669);
}

.progress-bar-warning {
    background: linear-gradient(90deg, #f59e0b, #d97706);
}

.progress-bar-info {
    background: linear-gradient(90deg, #3b82f6, #2563eb);
}

.order-btn {
    background: linear-gradient(135deg, #10b981, #059669);
    border: none;
    color: white;
    padding: 1rem 2rem;
    border-radius: 15px;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
}

.order-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
    color: white;
}

.order-btn:disabled {
    background: #9ca3af;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}
</style>

@section('content')
<div class="producto-header">
    <div class="d-flex align-items-center">
        <div class="producto-image">
            <i class="fas fa-utensils"></i>
        </div>
        <div>
            <h1 class="mb-2">{{ $producto->nombre_producto }}</h1>
            <p class="mb-0 opacity-75">
                {{ $producto->categoria->nombre_categoria ?? 'Sin categoría' }} • 
                {{ $producto->tipo_producto }}
            </p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Información Básica -->
        <div class="info-card">
            <h5 class="mb-3">
                <i class="fas fa-info-circle me-2"></i>
                Información del Plato
            </h5>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="info-label">Nombre del Plato</div>
                    <div class="info-value">{{ $producto->nombre_producto }}</div>
                </div>
                
                <div class="col-md-6">
                    <div class="info-label">Tipo</div>
                    <div class="info-value">{{ $producto->tipo_producto }}</div>
                </div>
            </div>
            
            <hr class="my-3">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="info-label">Categoría</div>
                    <div class="info-value">
                        {{ $producto->categoria->nombre_categoria ?? 'Sin categoría' }}
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="info-label">Estado</div>
                    <div class="info-value">
                        <span class="badge {{ $producto->estado == 'Activo' ? 'bg-success' : 'bg-secondary' }}">
                            {{ $producto->estado }}
                        </span>
                    </div>
                </div>
            </div>
            
            <hr class="my-3">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="info-label">Fecha de Ingreso</div>
                    <div class="info-value">
                        {{ $producto->fecha_ingreso ? $producto->fecha_ingreso->format('d/m/Y') : 'No especificada' }}
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="info-label">Última Actualización</div>
                    <div class="info-value">{{ $producto->updated_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        </div>
        
        <!-- Información de Stock -->
        <div class="info-card">
            <h5 class="mb-3">
                <i class="fas fa-warehouse me-2"></i>
                Disponibilidad
            </h5>
            
            @php
                $disponible = $producto->estado === 'Activo' && $producto->stock > 0;
                $estadoStock = $producto->stock <= ($producto->stock_min ?? 0) ? 'bajo' : 
                              ($producto->stock >= ($producto->stock_max ?? 0) ? 'alto' : 'normal');
                $porcentaje = $producto->stock_max > 0 ? 
                    ($producto->stock / $producto->stock_max) * 100 : 0;
            @endphp
            
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-value">{{ $producto->stock }}</div>
                        <div class="stat-label">Stock Disponible</div>
                    </div>
                </div>
                @if($producto->stock_min)
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-value">{{ $producto->stock_min }}</div>
                        <div class="stat-label">Stock Mínimo</div>
                    </div>
                </div>
                @endif
                @if($producto->stock_max)
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-value">{{ $producto->stock_max }}</div>
                        <div class="stat-label">Stock Máximo</div>
                    </div>
                </div>
                @endif
            </div>
            
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="info-label">Estado de Disponibilidad</span>
                    <span class="stock-badge {{ $disponible ? 'stock-disponible' : 'stock-agotado' }}">
                        {{ $disponible ? 'Disponible' : 'Agotado' }}
                    </span>
                </div>
                @if($producto->stock_max > 0)
                <div class="progress-custom">
                    <div class="progress-bar-custom 
                        @if($estadoStock === 'bajo') progress-bar-warning
                        @elseif($estadoStock === 'alto') progress-bar-info
                        @else progress-bar-success
                        @endif" 
                        style="width: {{ min($porcentaje, 100) }}%">
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Información de Precios -->
        <div class="info-card">
            <h5 class="mb-3">
                <i class="fas fa-dollar-sign me-2"></i>
                Precio
            </h5>
            
            <div class="text-center">
                <div class="price-display">
                    ${{ number_format($producto->precio_venta, 2) }}
                </div>
                <div class="info-label">Precio de Venta</div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Acciones para Usuario -->
        <div class="info-card">
            <h5 class="mb-3">
                <i class="fas fa-shopping-cart me-2"></i>
                Acciones
            </h5>
            
            <div class="d-grid gap-2">
                @if($disponible)
                    <a href="{{ route('user.pedidos.create') }}" class="order-btn">
                        <i class="fas fa-plus me-2"></i>
                        Agregar a Pedido
                    </a>
                @else
                    <button class="order-btn" disabled>
                        <i class="fas fa-times me-2"></i>
                        No Disponible
                    </button>
                @endif
                
                <a href="{{ route('user.productos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Volver al Menú
                </a>
            </div>
        </div>
        
        <!-- Información del Plato -->
        <div class="info-card">
            <h5 class="mb-3">
                <i class="fas fa-info-circle me-2"></i>
                Información del Plato
            </h5>
            
            <div class="mb-3">
                <div class="info-label">ID del Plato</div>
                <div class="info-value">#{{ $producto->id_producto }}</div>
            </div>
            
            <div class="mb-3">
                <div class="info-label">Fecha de Creación</div>
                <div class="info-value">{{ $producto->created_at->format('d/m/Y H:i:s') }}</div>
            </div>
            
            <div class="mb-3">
                <div class="info-label">Última Actualización</div>
                <div class="info-value">{{ $producto->updated_at->format('d/m/Y H:i:s') }}</div>
            </div>
        </div>
        
        @if(!$disponible)
        <div class="info-card">
            <h5 class="mb-3 text-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                No Disponible
            </h5>
            
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Agotado:</strong> Este plato no está disponible en este momento.
            </div>
            
            <p class="text-muted small mb-0">
                Te notificaremos cuando vuelva a estar disponible.
            </p>
        </div>
        @endif
    </div>
</div>
@endsection
