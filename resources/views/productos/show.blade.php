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

.stock-bajo {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.stock-normal {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.stock-alto {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
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
</style>

@section('content')
<div class="producto-header">
    <div class="d-flex align-items-center">
        <div class="producto-image">
            <i class="fas fa-utensils"></i>
        </div>
        <div>
            <h1 class="mb-2">{{ $producto->Nombre_producto }}</h1>
            <p class="mb-0 opacity-75">
                {{ $producto->categoria->Nombre_categoria ?? 'Sin categoría' }} • 
                {{ $producto->Tipo_producto }}
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
                    <div class="info-value">{{ $producto->Nombre_producto }}</div>
                </div>
                
                <div class="col-md-6">
                    <div class="info-label">Tipo</div>
                    <div class="info-value">{{ $producto->Tipo_producto }}</div>
                </div>
            </div>
            
            <hr class="my-3">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="info-label">Categoría</div>
                    <div class="info-value">
                        {{ $producto->categoria->Nombre_categoria ?? 'Sin categoría' }}
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
                        {{ $producto->Fecha_ingreso_producto ? $producto->Fecha_ingreso_producto->format('d/m/Y') : 'No especificada' }}
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
                Control de Inventario
            </h5>
            
            @php
                $estadoStock = $producto->Stock_producto <= $producto->Stock_min_producto ? 'bajo' : 
                              ($producto->Stock_producto >= $producto->Stock_max_producto ? 'alto' : 'normal');
                $porcentaje = $producto->Stock_max_producto > 0 ? 
                    ($producto->Stock_producto / $producto->Stock_max_producto) * 100 : 0;
            @endphp
            
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-value">{{ $producto->Stock_producto }}</div>
                        <div class="stat-label">Stock Actual</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-value">{{ $producto->Stock_min_producto }}</div>
                        <div class="stat-label">Stock Mínimo</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-value">{{ $producto->Stock_max_producto }}</div>
                        <div class="stat-label">Stock Máximo</div>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="info-label">Nivel de Stock</span>
                    <span class="stock-badge stock-{{ $estadoStock }}">
                        {{ ucfirst($estadoStock) }}
                    </span>
                </div>
                <div class="progress-custom">
                    <div class="progress-bar-custom 
                        @if($estadoStock === 'bajo') progress-bar-warning
                        @elseif($estadoStock === 'alto') progress-bar-info
                        @else progress-bar-success
                        @endif" 
                        style="width: {{ min($porcentaje, 100) }}%">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Información de Precios -->
        <div class="info-card">
            <h5 class="mb-3">
                <i class="fas fa-dollar-sign me-2"></i>
                Información de Precios
            </h5>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="text-center">
                        <div class="price-display">
                            ${{ number_format($producto->Precio_venta, 2) }}
                        </div>
                        <div class="info-label">Precio de Venta</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <div class="price-display">
                            ${{ number_format($producto->Precio_recibimiento, 2) }}
                        </div>
                        <div class="info-label">Precio de Costo</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        @php
                            $margen = $producto->Precio_venta - $producto->Precio_recibimiento;
                            $porcentajeMargen = $producto->Precio_recibimiento > 0 ? 
                                (($margen / $producto->Precio_recibimiento) * 100) : 0;
                        @endphp
                        <div class="price-display">
                            ${{ number_format($margen, 2) }}
                        </div>
                        <div class="info-label">Margen ({{ number_format($porcentajeMargen, 1) }}%)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Acciones -->
        <div class="info-card">
            <h5 class="mb-3">
                <i class="fas fa-cog me-2"></i>
                Acciones
            </h5>
            
            <div class="d-grid gap-2">
                <a href="{{ route('productos.edit', $producto->id_producto) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>
                    Editar Plato
                </a>
                
                <a href="{{ route('inventario.index') }}" class="btn btn-primary">
                    <i class="fas fa-warehouse me-2"></i>
                    Gestionar Inventario
                </a>
                
                <a href="{{ route('ventas.create') }}?producto_id={{ $producto->id_producto }}" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>
                    Crear Pedido
                </a>
                
                <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Volver a la Lista
                </a>
            </div>
        </div>
        
        <!-- Información del Sistema -->
        <div class="info-card">
            <h5 class="mb-3">
                <i class="fas fa-info-circle me-2"></i>
                Información del Sistema
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
        
        <!-- Alertas de Stock -->
        @if($estadoStock === 'bajo')
        <div class="info-card">
            <h5 class="mb-3 text-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Alerta de Stock
            </h5>
            
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Stock Bajo:</strong> Este plato necesita reabastecimiento urgente.
            </div>
            
            <a href="{{ route('inventario.index') }}" class="btn btn-warning w-100">
                <i class="fas fa-warehouse me-2"></i>
                Reabastecer Stock
            </a>
        </div>
        @endif
        
        <!-- Eliminar Plato -->
        <div class="info-card">
            <h5 class="mb-3 text-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Zona de Peligro
            </h5>
            
            <p class="text-muted small mb-3">
                Esta acción no se puede deshacer. Se eliminará permanentemente el plato y todos sus datos asociados.
            </p>
            
            <form action="{{ route('productos.destroy', $producto->id_producto) }}" method="POST" 
                  onsubmit="return confirm('¿Estás seguro de eliminar este plato? Esta acción no se puede deshacer.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger w-100">
                    <i class="fas fa-trash me-2"></i>
                    Eliminar Plato
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
