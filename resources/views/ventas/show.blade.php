@extends('layouts.app')

@section('title', 'Detalle del Pedido - Wurger')
@section('page-title', 'Detalle del Pedido')

<style>
.pedido-header {
    background: var(--wurger-gradient);
    color: white;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
}

.pedido-id {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
}

.pedido-status {
    font-size: 1.1rem;
    opacity: 0.9;
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
}

.info-value {
    font-size: 1.1rem;
    color: #1f2937;
    font-weight: 500;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-pagada {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.status-pendiente {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.status-anulada {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.total-amount {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    padding: 1.5rem;
    border-radius: 20px;
    text-align: center;
    font-size: 2rem;
    font-weight: 800;
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
}
</style>

@section('content')
<div class="pedido-header">
    <div class="pedido-id">Pedido #{{ $venta->id_venta }}</div>
    <div class="pedido-status">
        <span class="status-badge status-{{ strtolower($venta->Estado_venta) }}">
            {{ $venta->Estado_venta }}
        </span>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="info-card">
            <h5 class="mb-3">
                <i class="fas fa-info-circle me-2"></i>
                Información del Pedido
            </h5>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="info-label">Fecha del Pedido</div>
                    <div class="info-value">
                        {{ $venta->Fecha_venta ? $venta->Fecha_venta->format('d/m/Y') : 'No especificada' }}
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="info-label">Hora de Creación</div>
                    <div class="info-value">
                        {{ $venta->created_at->format('H:i:s') }}
                    </div>
                </div>
            </div>
            
            <hr class="my-3">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="info-label">Cliente</div>
                    <div class="info-value">
                        @if($venta->pedido && $venta->pedido->usuarioInfo)
                            {{ $venta->pedido->usuarioInfo->nombre ?? 'N/A' }}
                        @else
                            No especificado
                        @endif
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="info-label">Email del Cliente</div>
                    <div class="info-value">
                        @if($venta->pedido && $venta->pedido->usuarioInfo && $venta->pedido->usuarioInfo->usuario)
                            {{ $venta->pedido->usuarioInfo->usuario->email ?? 'N/A' }}
                        @else
                            No especificado
                        @endif
                    </div>
                </div>
            </div>
            
            @if($venta->pedido)
            <hr class="my-3">
            <div class="row">
                <div class="col-md-6">
                    <div class="info-label">Pedido Relacionado</div>
                    <div class="info-value">
                        <a href="#" class="text-decoration-none">
                            Pedido #{{ $venta->pedido->id_pedido }}
                        </a>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="info-label">Estado del Pedido</div>
                    <div class="info-value">
                        <span class="badge bg-info">{{ $venta->pedido->estado }}</span>
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <div class="info-card">
            <h5 class="mb-3">
                <i class="fas fa-clock me-2"></i>
                Historial de Cambios
            </h5>
            
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-marker bg-primary"></div>
                    <div class="timeline-content">
                        <h6>Pedido Creado</h6>
                        <p class="text-muted mb-0">{{ $venta->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>
                
                @if($venta->updated_at != $venta->created_at)
                <div class="timeline-item">
                    <div class="timeline-marker bg-warning"></div>
                    <div class="timeline-content">
                        <h6>Última Actualización</h6>
                        <p class="text-muted mb-0">{{ $venta->updated_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="total-amount">
            <div class="mb-2">Total del Pedido</div>
            <div>${{ number_format($venta->Total_venta ?? 0, 2) }}</div>
        </div>
        
        <div class="info-card">
            <h5 class="mb-3">
                <i class="fas fa-cog me-2"></i>
                Acciones
            </h5>
            
            <div class="d-grid gap-2">
                <a href="{{ route('ventas.edit', $venta->id_venta) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>
                    Editar Pedido
                </a>
                
                <form action="{{ route('ventas.destroy', $venta->id_venta) }}" method="POST" 
                      onsubmit="return confirm('¿Estás seguro de eliminar este pedido?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-trash me-2"></i>
                        Eliminar Pedido
                    </button>
                </form>
                
                <a href="{{ route('ventas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Volver a la Lista
                </a>
            </div>
        </div>
        
        @if($venta->pedido && $venta->pedido->pedidoProductos->count() > 0)
        <div class="info-card">
            <h5 class="mb-3">
                <i class="fas fa-shopping-cart me-2"></i>
                Productos del Pedido
            </h5>
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-end">Precio Unit.</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($venta->pedido->pedidoProductos as $pedidoProducto)
                            <tr>
                                <td>
                                    <strong>{{ $pedidoProducto->producto->nombre_producto }}</strong>
                                    @if($pedidoProducto->producto->categoria)
                                        <br><small class="text-muted">{{ $pedidoProducto->producto->categoria->nombre_categoria }}</small>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary">{{ $pedidoProducto->cantidad }}</span>
                                </td>
                                <td class="text-end">${{ number_format($pedidoProducto->precio_unitario, 2) }}</td>
                                <td class="text-end">
                                    <strong>${{ number_format($pedidoProducto->subtotal, 2) }}</strong>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="3" class="text-end">Total del Pedido:</th>
                            <th class="text-end text-primary">
                                ${{ number_format($venta->pedido->pedidoProductos->sum('subtotal'), 2) }}
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 0.75rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e5e7eb;
}

.timeline-item {
    position: relative;
    margin-bottom: 1.5rem;
}

.timeline-marker {
    position: absolute;
    left: -2rem;
    top: 0.25rem;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 0 0 3px #e5e7eb;
}

.timeline-content h6 {
    margin-bottom: 0.25rem;
    font-weight: 600;
    color: #1f2937;
}

.timeline-content p {
    font-size: 0.875rem;
}
</style>
@endsection
