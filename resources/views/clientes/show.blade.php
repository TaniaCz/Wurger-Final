@extends('layouts.app')

@section('title', 'Detalle del Cliente - Wurger')
@section('page-title', 'Detalle del Cliente')

<style>
.cliente-header {
    background: var(--wurger-gradient);
    color: white;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
}

.cliente-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    font-weight: 700;
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

.pedido-item {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 15px;
    padding: 1rem;
    margin-bottom: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.pedido-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
}

.status-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-size: 0.8rem;
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

.no-data {
    text-align: center;
    padding: 3rem;
    color: #6b7280;
}

.no-data i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}
</style>

@section('content')
<div class="cliente-header">
    <div class="d-flex align-items-center">
        <div class="cliente-avatar">
            {{ substr($cliente->Nom_cliente, 0, 1) }}
        </div>
        <div>
            <h1 class="mb-2">{{ $cliente->Nom_cliente }}</h1>
            <p class="mb-0 opacity-75">Cliente desde {{ $cliente->created_at->format('d/m/Y') }}</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Información de Contacto -->
        <div class="info-card">
            <h5 class="mb-3">
                <i class="fas fa-address-card me-2"></i>
                Información de Contacto
            </h5>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="info-label">Nombre Completo</div>
                    <div class="info-value">{{ $cliente->Nom_cliente }}</div>
                </div>
                
                <div class="col-md-6">
                    <div class="info-label">Teléfono</div>
                    <div class="info-value">
                        @if($cliente->Tel_cliente)
                            <i class="fas fa-phone me-1"></i>
                            {{ $cliente->Tel_cliente }}
                        @else
                            <span class="text-muted">No registrado</span>
                        @endif
                    </div>
                </div>
            </div>
            
            @if($cliente->direccion)
            <hr class="my-3">
            <div class="row">
                <div class="col-12">
                    <div class="info-label">Dirección</div>
                    <div class="info-value">
                        <i class="fas fa-map-marker-alt me-1"></i>
                        {{ $cliente->direccion }}
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Estadísticas del Cliente -->
        <div class="info-card">
            <h5 class="mb-3">
                <i class="fas fa-chart-bar me-2"></i>
                Estadísticas de Pedidos
            </h5>
            
            @php
                $pedidos = $cliente->pedidos;
                $totalPedidos = $pedidos->count();
                
                // Obtener ventas relacionadas a través de los pedidos
                $ventas = collect();
                foreach ($pedidos as $pedido) {
                    $ventas = $ventas->merge($pedido->ventas);
                }
                
                $totalGastado = $ventas->sum('Total_venta');
                $pedidosPagados = $ventas->where('estado', 'Pagada')->count();
                $pedidosPendientes = $ventas->where('estado', 'Pendiente')->count();
                $pedidosAnulados = $ventas->where('estado', 'Anulada')->count();
            @endphp
            
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-value">{{ $totalPedidos }}</div>
                    <div class="stat-label">Total Pedidos</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">${{ number_format($totalGastado, 2) }}</div>
                    <div class="stat-label">Total Gastado</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $pedidosPagados }}</div>
                    <div class="stat-label">Pedidos Pagados</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $pedidosPendientes }}</div>
                    <div class="stat-label">Pedidos Pendientes</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $pedidosAnulados }}</div>
                    <div class="stat-label">Pedidos Anulados</div>
                </div>
            </div>
        </div>
        
        <!-- Historial de Pedidos -->
        <div class="info-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i>
                    Historial de Pedidos
                </h5>
                <a href="{{ route('ventas.create') }}?cliente_id={{ $cliente->id_usuario_info }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Nuevo Pedido
                </a>
            </div>
            
            @php
                $pedidosRecientes = $cliente->pedidos()->with('usuario')->orderBy('created_at', 'desc')->limit(10)->get();
            @endphp
            
            @forelse($pedidosRecientes as $pedido)
                <div class="pedido-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1">Pedido #{{ $pedido->id_venta }}</h6>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $pedido->created_at->format('d/m/Y H:i') }}
                                @if($pedido->usuario)
                                    | <i class="fas fa-user me-1"></i>
                                    {{ $pedido->usuario->email }}
                                @endif
                            </small>
                        </div>
                        <div class="text-end">
                            @php
                                $ventasDelPedido = $pedido->ventas;
                                $totalVentas = $ventasDelPedido->sum('Total_venta');
                                $estadoVenta = $ventasDelPedido->isNotEmpty() ? $ventasDelPedido->first()->estado : 'Sin venta';
                            @endphp
                            <div class="fw-bold text-success mb-1">
                                ${{ number_format($totalVentas, 2) }}
                            </div>
                            <span class="status-badge status-{{ strtolower($estadoVenta) }}">
                                {{ $estadoVenta }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="no-data">
                    <i class="fas fa-shopping-cart"></i>
                    <h5>Sin pedidos registrados</h5>
                    <p>Este cliente aún no ha realizado ningún pedido.</p>
                    <a href="{{ route('ventas.create') }}?cliente_id={{ $cliente->id_usuario_info }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Crear Primer Pedido
                    </a>
                </div>
            @endforelse
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
                <a href="{{ route('clientes.edit', $cliente->id_usuario_info) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>
                    Editar Cliente
                </a>
                
                <a href="{{ route('ventas.create') }}?cliente_id={{ $cliente->id_usuario_info }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Nuevo Pedido
                </a>
                
                <a href="{{ route('ventas.index') }}?cliente={{ $cliente->id_usuario_info }}" class="btn btn-info">
                    <i class="fas fa-list me-2"></i>
                    Ver Todos los Pedidos
                </a>
                
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
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
                <div class="info-label">ID del Cliente</div>
                <div class="info-value">#{{ $cliente->id_usuario_info }}</div>
            </div>
            
            <div class="mb-3">
                <div class="info-label">Fecha de Registro</div>
                <div class="info-value">{{ $cliente->created_at->format('d/m/Y H:i:s') }}</div>
            </div>
            
            <div class="mb-3">
                <div class="info-label">Última Actualización</div>
                <div class="info-value">{{ $cliente->updated_at->format('d/m/Y H:i:s') }}</div>
            </div>
            
            @if($cliente->pedidos()->count() > 0)
            <div class="mb-3">
                <div class="info-label">Último Pedido</div>
                <div class="info-value">
                    @php
                        $ultimoPedido = $cliente->pedidos()->latest()->first();
                    @endphp
                    @if($ultimoPedido)
                        #{{ $ultimoPedido->id_venta }} - {{ $ultimoPedido->created_at->format('d/m/Y') }}
                    @else
                        N/A
                    @endif
                </div>
            </div>
            @endif
        </div>
        
        <!-- Eliminar Cliente -->
        <div class="info-card">
            <h5 class="mb-3 text-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Zona de Peligro
            </h5>
            
            <p class="text-muted small mb-3">
                Esta acción no se puede deshacer. Se eliminará permanentemente el cliente y todos sus datos asociados.
            </p>
            
            <form action="{{ route('clientes.destroy', $cliente->id_usuario_info) }}" method="POST" 
                  onsubmit="return confirm('¿Estás seguro de eliminar este cliente? Esta acción no se puede deshacer.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger w-100">
                    <i class="fas fa-trash me-2"></i>
                    Eliminar Cliente
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
