@extends('layouts.app')

@section('title', 'Gestión de Pedidos - Wurger')
@section('page-title', 'Gestión de Pedidos')

<style>
.sale-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
}

.sale-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 48px rgba(0,0,0,0.15);
}

.sale-header {
    background: var(--wurger-gradient);
    color: white;
    padding: 1rem 1.5rem;
    margin: -1.5rem -1.5rem 1rem -1.5rem;
}

.sale-id {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.sale-date {
    font-size: 0.875rem;
    opacity: 0.9;
}

.sale-amount {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 20px;
    font-size: 1.25rem;
    font-weight: 700;
    text-align: center;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.status-paid {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.status-pending {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.status-cancelled {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.customer-info {
    background: rgba(30, 64, 175, 0.05);
    padding: 0.75rem 1rem;
    border-radius: 12px;
    margin-bottom: 1rem;
}

.customer-info h6 {
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 0.25rem;
}

.customer-info small {
    color: var(--secondary-color);
    font-size: 0.875rem;
}
</style>

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">
        <i class="fas fa-shopping-cart me-2"></i>
        Lista de Ventas
    </h5>
    <a href="{{ route('ventas.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        Nueva Venta
    </a>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Ventas</h6>
                        <h3 class="mb-0">{{ $ventas->total() }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-shopping-cart fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Pagadas</h6>
                        <h3 class="mb-0">{{ $ventas->where('Estado_venta', 'Pagada')->count() }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Pendientes</h6>
                        <h3 class="mb-0">{{ $ventas->where('Estado_venta', 'Pendiente')->count() }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Anuladas</h6>
                        <h3 class="mb-0">{{ $ventas->where('Estado_venta', 'Anulada')->count() }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-times-circle fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($ventas->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Estado</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ventas as $venta)
                            <tr>
                                <td>
                                    <span class="badge bg-light text-dark">#{{ $venta->id_venta }}</span>
                                </td>
                                <td>
                                    <div>
                                        <div class="fw-bold">{{ $venta->Fecha_venta ? $venta->Fecha_venta->format('d/m/Y') : 'N/A' }}</div>
                                        <small class="text-muted">{{ $venta->created_at->format('H:i') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center">
                                            {{ substr($venta->usuario->Nom_usuario ?? 'U', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $venta->usuario->Nom_usuario ?? 'N/A' }}</div>
                                            <small class="text-muted">{{ $venta->usuario->Email_usuario ?? '' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $venta->Estado_venta == 'Pagada' ? 'success' : ($venta->Estado_venta == 'Pendiente' ? 'warning' : 'danger') }}">
                                        {{ $venta->Estado_venta }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-success">
                                        ${{ number_format($venta->Total_venta ?? 0, 2) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('ventas.show', $venta->id_venta) }}" 
                                           class="btn btn-sm btn-outline-info" 
                                           title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('ventas.edit', $venta->id_venta) }}" 
                                           class="btn btn-sm btn-outline-warning" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('ventas.destroy', $venta->id_venta) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Estás seguro de eliminar esta venta?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $ventas->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No hay ventas registradas</h5>
                <p class="text-muted">Comienza creando tu primera venta</p>
                <a href="{{ route('ventas.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Nueva Venta
                </a>
            </div>
        @endif
    </div>
</div>

<style>
.avatar-sm {
    width: 40px;
    height: 40px;
    font-size: 14px;
    font-weight: 600;
}
</style>
@endsection
