@extends('layouts.app')

@section('title', 'Movimientos de Inventario - Wurger')
@section('page-title', 'Movimientos de Inventario')

<style>
.movimientos-header {
    background: var(--wurger-gradient);
    color: white;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
}

.movimiento-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
}

.movimiento-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
}

.movimiento-icon {
    width: 50px;
    height: 50px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    margin-right: 1rem;
    flex-shrink: 0;
}

.movimiento-entrada {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.movimiento-salida {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.movimiento-ajuste {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.movimiento-info h6 {
    margin: 0;
    color: #1f2937;
    font-weight: 700;
}

.movimiento-info p {
    margin: 0;
    color: #6b7280;
    font-size: 0.9rem;
}

.movimiento-cantidad {
    font-size: 1.2rem;
    font-weight: 800;
    text-align: center;
}

.movimiento-tipo {
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.tipo-entrada {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.tipo-salida {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
}

.tipo-ajuste {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
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
<div class="movimientos-header">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h1 class="mb-2">
                <i class="fas fa-exchange-alt me-3"></i>
                Movimientos de Inventario
            </h1>
            <p class="mb-0 opacity-75">Historial de entradas, salidas y ajustes de stock</p>
        </div>
        <a href="{{ route('inventario.index') }}" class="btn btn-light">
            <i class="fas fa-arrow-left me-2"></i>
            Volver al Inventario
        </a>
    </div>
</div>

<!-- Lista de Movimientos -->
@forelse($movimientos as $movimiento)
    <div class="movimiento-card">
        <div class="d-flex align-items-start">
            <div class="movimiento-icon 
                @if($movimiento->tipo === 'Entrada') movimiento-entrada
                @elseif($movimiento->tipo === 'Salida') movimiento-salida
                @else movimiento-ajuste
                @endif">
                @if($movimiento->tipo === 'Entrada')
                    <i class="fas fa-arrow-up"></i>
                @elseif($movimiento->tipo === 'Salida')
                    <i class="fas fa-arrow-down"></i>
                @else
                    <i class="fas fa-adjust"></i>
                @endif
            </div>
            
            <div class="movimiento-info flex-grow-1">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6>{{ $movimiento->producto->nombre_producto ?? 'Producto no encontrado' }}</h6>
                    <span class="movimiento-tipo 
                        @if($movimiento->tipo === 'Entrada') tipo-entrada
                        @elseif($movimiento->tipo === 'Salida') tipo-salida
                        @else tipo-ajuste
                        @endif">
                        {{ $movimiento->tipo }}
                    </span>
                </div>
                
                <p class="mb-2">
                    <i class="fas fa-calendar me-1"></i>
                    {{ \Carbon\Carbon::parse($movimiento->fecha)->format('d/m/Y') }}
                </p>
                
                <p class="mb-1">
                    <i class="fas fa-info-circle me-1"></i>
                    <strong>Cantidad:</strong> {{ $movimiento->cantidad }}
                </p>
                
                @if($movimiento->descripcion)
                    <p class="mb-0">
                        <i class="fas fa-comment me-1"></i>
                        <strong>Descripción:</strong> {{ $movimiento->descripcion }}
                    </p>
                @endif
            </div>
            
            <div class="movimiento-cantidad">
                <div class="fw-bold">
                    @if($movimiento->tipo === 'Entrada')
                        +{{ $movimiento->cantidad }}
                    @elseif($movimiento->tipo === 'Salida')
                        -{{ $movimiento->cantidad }}
                    @else
                        {{ $movimiento->cantidad }}
                    @endif
                </div>
                <small class="text-muted">Unidades</small>
            </div>
        </div>
    </div>
@empty
    <div class="no-data">
        <i class="fas fa-exchange-alt"></i>
        <h4>No hay movimientos registrados</h4>
        <p>Los movimientos de inventario aparecerán aquí cuando se realicen ajustes de stock.</p>
        <a href="{{ route('inventario.index') }}" class="btn btn-primary">
            <i class="fas fa-warehouse me-2"></i>
            Gestionar Inventario
        </a>
    </div>
@endforelse

<!-- Paginación -->
@if($movimientos->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $movimientos->links() }}
    </div>
@endif
@endsection