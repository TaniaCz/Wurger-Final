@extends('layouts.app')

@section('title', 'Inventario - Wurger')
@section('page-title', 'Gestión de Inventario')

<style>
.inventario-header {
    background: var(--wurger-gradient);
    color: white;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
}

.stats-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    text-align: center;
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
}

.stats-icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.stats-value {
    font-size: 2rem;
    font-weight: 800;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.stats-label {
    color: #6b7280;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.9rem;
    letter-spacing: 0.5px;
}

.product-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
}

.product-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
}

.stock-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
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

.btn-ajuste {
    background: var(--wurger-gradient);
    border: none;
    border-radius: 12px;
    padding: 0.5rem 1rem;
    color: white;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-ajuste:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(30, 64, 175, 0.3);
    color: white;
}
</style>

@section('content')
<div class="inventario-header">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h1 class="mb-2">
                <i class="fas fa-warehouse me-3"></i>
                Gestión de Inventario
            </h1>
            <p class="mb-0 opacity-75">Control y seguimiento de stock de platos</p>
        </div>
        <div>
            <a href="{{ route('inventario.movimientos') }}" class="btn btn-light me-2">
                <i class="fas fa-exchange-alt me-2"></i>
                Ver Movimientos
            </a>
            <a href="{{ route('inventario.reporteStock') }}" class="btn btn-outline-light">
                <i class="fas fa-chart-bar me-2"></i>
                Reporte de Stock
            </a>
        </div>
    </div>
</div>

<!-- Estadísticas del Inventario -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-icon text-primary">
                <i class="fas fa-utensils"></i>
            </div>
            <div class="stats-value">{{ $estadisticas['total_productos'] }}</div>
            <div class="stats-label">Total Platos</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-icon text-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stats-value">{{ $estadisticas['productos_activos'] }}</div>
            <div class="stats-label">Activos</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-icon text-warning">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stats-value">{{ $estadisticas['productos_bajo_stock'] }}</div>
            <div class="stats-label">Bajo Stock</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-icon text-info">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stats-value">${{ number_format($estadisticas['valor_total_inventario'], 2) }}</div>
            <div class="stats-label">Valor Total</div>
        </div>
    </div>
</div>

<!-- Lista de Productos -->
<div class="row">
    @forelse($productos as $producto)
        <div class="col-lg-4 col-md-6">
            <div class="product-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h5 class="mb-0">{{ $producto->nombre_producto }}</h5>
                    @php
                        $estadoStock = $producto->stock <= $producto->stock_min ? 'bajo' : 
                                      ($producto->stock >= $producto->stock_max ? 'alto' : 'normal');
                    @endphp
                    <span class="stock-badge stock-{{ $estadoStock }}">
                        {{ ucfirst($estadoStock) }}
                    </span>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted">
                        <i class="fas fa-tag me-1"></i>
                        {{ $producto->categoria->nombre_categoria ?? 'Sin categoría' }}
                    </small>
                </div>
                
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="text-center">
                            <div class="fw-bold text-primary">{{ $producto->stock }}</div>
                            <small class="text-muted">Stock Actual</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center">
                            <div class="fw-bold text-success">${{ number_format($producto->precio_venta, 2) }}</div>
                            <small class="text-muted">Precio Venta</small>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="progress" style="height: 8px;">
                        @php
                            $porcentaje = $producto->stock_max > 0 ? 
                                ($producto->stock / $producto->stock_max) * 100 : 0;
                        @endphp
                        <div class="progress-bar 
                            @if($estadoStock === 'bajo') bg-warning
                            @elseif($estadoStock === 'alto') bg-info
                            @else bg-success
                            @endif" 
                            style="width: {{ min($porcentaje, 100) }}%">
                        </div>
                    </div>
                    <small class="text-muted">
                        Min: {{ $producto->stock_min }} | Max: {{ $producto->stock_max }}
                    </small>
                </div>
                
                <div class="d-flex gap-2">
                    <button class="btn btn-ajuste flex-fill" 
                            onclick="abrirModalAjuste({{ $producto->id_producto }}, '{{ $producto->nombre_producto }}')">
                        <i class="fas fa-edit me-1"></i>
                        Ajustar Stock
                    </button>
                    <a href="{{ route('productos.show', $producto->id_producto) }}" 
                       class="btn btn-outline-primary">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-utensils fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No hay platos en el inventario</h4>
                <p class="text-muted">Agrega algunos platos para comenzar a gestionar el inventario.</p>
                <a href="{{ route('productos.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Agregar Primer Plato
                </a>
            </div>
        </div>
    @endforelse
</div>

<!-- Paginación -->
@if($productos->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $productos->links() }}
    </div>
@endif

<!-- Modal de Ajuste de Stock -->
<div class="modal fade" id="modalAjusteStock" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>
                    Ajustar Stock
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('inventario.ajuste-stock') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="producto_id" name="producto_id">
                    
                    <div class="mb-3">
                        <label class="form-label">Plato</label>
                        <input type="text" id="producto_nombre" class="form-control" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="tipo_movimiento" class="form-label">Tipo de Movimiento *</label>
                        <select class="form-control" id="tipo_movimiento" name="tipo_movimiento" required>
                            <option value="">Seleccionar...</option>
                            <option value="entrada">Entrada (Agregar stock)</option>
                            <option value="salida">Salida (Reducir stock)</option>
                            <option value="ajuste">Ajuste (Establecer stock exacto)</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad *</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="motivo" class="form-label">Motivo *</label>
                        <input type="text" class="form-control" id="motivo" name="motivo" 
                               placeholder="Ej: Compra de ingredientes, Pérdida por vencimiento..." required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" 
                                  rows="3" placeholder="Detalles adicionales del movimiento..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Registrar Movimiento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function abrirModalAjuste(productoId, productoNombre) {
    document.getElementById('producto_id').value = productoId;
    document.getElementById('producto_nombre').value = productoNombre;
    
    // Limpiar formulario
    document.getElementById('tipo_movimiento').value = '';
    document.getElementById('cantidad').value = '';
    document.getElementById('motivo').value = '';
    document.getElementById('observaciones').value = '';
    
    // Mostrar modal
    new bootstrap.Modal(document.getElementById('modalAjusteStock')).show();
}
</script>
@endsection