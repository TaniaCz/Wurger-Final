@extends('layouts.app')

@section('title', 'Clientes - Wurger')
@section('page-title', 'Gestión de Clientes')

<style>
.clientes-header {
    background: var(--wurger-gradient);
    color: white;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
}

.client-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
}

.client-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
}

.client-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: var(--wurger-gradient);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 700;
    margin-right: 1rem;
}

.client-info h5 {
    margin: 0;
    color: #1f2937;
    font-weight: 700;
}

.client-info p {
    margin: 0;
    color: #6b7280;
    font-size: 0.9rem;
}

.client-stats {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.stat-item {
    text-align: center;
    flex: 1;
}

.stat-value {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--wurger-primary);
}

.stat-label {
    font-size: 0.8rem;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-primary {
    background: var(--wurger-gradient);
    border: none;
    border-radius: 12px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(30, 64, 175, 0.3);
}

.search-box {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    margin-bottom: 2rem;
}

.search-input {
    border: none;
    background: transparent;
    font-size: 1.1rem;
    padding: 0.5rem 0;
    width: 100%;
}

.search-input:focus {
    outline: none;
}

.search-input::placeholder {
    color: #9ca3af;
}
</style>

@section('content')
<div class="clientes-header">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h1 class="mb-2">
                <i class="fas fa-user-friends me-3"></i>
                Clientes Registrados
            </h1>
            <p class="mb-0 opacity-75">Visualiza la información de tus clientes</p>
        </div>
    </div>
</div>

<!-- Búsqueda -->
<div class="search-box">
    <div class="d-flex align-items-center">
        <i class="fas fa-search me-3 text-muted"></i>
        <input type="text" class="search-input" placeholder="Buscar clientes por nombre, teléfono o dirección..." id="searchInput">
    </div>
</div>

<!-- Lista de Clientes -->
<div class="row" id="clientesList">
    @forelse($clientes as $cliente)
        <div class="col-lg-4 col-md-6 cliente-item" data-name="{{ strtolower($cliente->Nom_cliente) }}" 
             data-phone="{{ strtolower($cliente->Tel_cliente ?? '') }}" 
             data-address="{{ strtolower($cliente->Direc_cliente ?? '') }}">
            <div class="client-card">
                <div class="d-flex align-items-start">
                    <div class="client-avatar">
                        {{ substr($cliente->Nom_cliente, 0, 1) }}
                    </div>
                    <div class="client-info flex-grow-1">
                        <h5>{{ $cliente->Nom_cliente }}</h5>
                        @if($cliente->Tel_cliente)
                            <p><i class="fas fa-phone me-1"></i> {{ $cliente->Tel_cliente }}</p>
                        @endif
                        @if($cliente->Direc_cliente)
                            <p><i class="fas fa-map-marker-alt me-1"></i> {{ $cliente->Direc_cliente }}</p>
                        @endif
                    </div>
                </div>
                
                <div class="client-stats">
                    <div class="stat-item">
                        <div class="stat-value">{{ $cliente->pedidos()->count() }}</div>
                        <div class="stat-label">Pedidos</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">${{ number_format($cliente->usuario->ventas()->sum('Total_venta') ?? 0, 2) }}</div>
                        <div class="stat-label">Total Gastado</div>
                    </div>
                </div>
                
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('clientes.show', $cliente->id_usuario_info) }}" class="btn btn-outline-primary flex-fill">
                        <i class="fas fa-eye me-1"></i>
                        Ver Detalles
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-user-friends fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No hay clientes registrados</h4>
                <p class="text-muted">Los clientes aparecerán aquí cuando se registren en el sistema.</p>
            </div>
        </div>
    @endforelse
</div>

<!-- Paginación -->
@if($clientes->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $clientes->links() }}
    </div>
@endif

<script>
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const clientes = document.querySelectorAll('.cliente-item');
    
    clientes.forEach(cliente => {
        const name = cliente.dataset.name;
        const phone = cliente.dataset.phone;
        const address = cliente.dataset.address;
        
        if (name.includes(searchTerm) || phone.includes(searchTerm) || address.includes(searchTerm)) {
            cliente.style.display = 'block';
        } else {
            cliente.style.display = 'none';
        }
    });
});
</script>
@endsection
