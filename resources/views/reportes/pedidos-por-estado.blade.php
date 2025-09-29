@extends('layouts.app')

@section('title', 'Pedidos por Estado - Wurger')
@section('page-title', 'Pedidos por Estado')

@section('content')
<style>
    .summary-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .summary-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: transform 0.3s ease;
    }
    
    .summary-card:hover {
        transform: translateY(-5px);
    }
    
    .summary-card.pendiente {
        background: linear-gradient(135deg, #fef3c7 0%, #f59e0b 100%);
        color: #92400e;
    }
    
    .summary-card.entregado {
        background: linear-gradient(135deg, #d1fae5 0%, #10b981 100%);
        color: #065f46;
    }
    
    .summary-card.cancelado {
        background: linear-gradient(135deg, #fee2e2 0%, #ef4444 100%);
        color: #991b1b;
    }
    
    .summary-number {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .summary-label {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .summary-percentage {
        font-size: 0.9rem;
        opacity: 0.8;
    }
    
    .order-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: transform 0.3s ease;
    }
    
    .order-card:hover {
        transform: translateY(-3px);
    }
    
    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .order-id {
        font-size: 1.2rem;
        font-weight: 700;
        color: #374151;
    }
    
    .order-date {
        color: #6b7280;
        font-size: 0.9rem;
    }
    
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .status-pendiente {
        background: #fef3c7;
        color: #92400e;
    }
    
    .status-entregado {
        background: #d1fae5;
        color: #065f46;
    }
    
    .status-cancelado {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .client-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .client-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.2rem;
    }
    
    .client-details {
        flex-grow: 1;
    }
    
    .client-name {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.25rem;
    }
    
    .client-email {
        color: #6b7280;
        font-size: 0.9rem;
    }
    
    .order-observations {
        background: rgba(0, 0, 0, 0.05);
        padding: 1rem;
        border-radius: 10px;
        margin-bottom: 1rem;
    }
    
    .observations-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }
    
    .observations-text {
        color: #6b7280;
        font-size: 0.9rem;
        margin: 0;
    }
    
    .export-btn {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .export-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        color: white;
        text-decoration: none;
    }
    
    .chart-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .empty-icon {
        font-size: 4rem;
        color: #6b7280;
        margin-bottom: 1rem;
    }
</style>

<div class="container-fluid">
    <!-- Header del Reporte -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="order-card">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="mb-2">
                            <i class="fas fa-list-alt me-2"></i>
                            Pedidos por Estado
                        </h2>
                        <p class="mb-0 text-muted">
                            Distribución y análisis de pedidos según su estado actual
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        <a href="{{ route('reportes.pedidos-por-estado', ['export' => 1]) }}" class="export-btn">
                            <i class="fas fa-file-excel"></i>
                            Exportar Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($pedidos->count() > 0)
        <!-- Resumen por Estado -->
        <div class="summary-cards">
            <div class="summary-card pendiente">
                <div class="summary-number">{{ $estadisticas['Pendiente'] }}</div>
                <div class="summary-label">Pendientes</div>
                <div class="summary-percentage">
                    {{ $pedidos->count() > 0 ? number_format(($estadisticas['Pendiente'] / $pedidos->count()) * 100, 1) : 0 }}% del total
                </div>
            </div>
            <div class="summary-card entregado">
                <div class="summary-number">{{ $estadisticas['Entregado'] }}</div>
                <div class="summary-label">Entregados</div>
                <div class="summary-percentage">
                    {{ $pedidos->count() > 0 ? number_format(($estadisticas['Entregado'] / $pedidos->count()) * 100, 1) : 0 }}% del total
                </div>
            </div>
            <div class="summary-card cancelado">
                <div class="summary-number">{{ $estadisticas['Cancelado'] }}</div>
                <div class="summary-label">Cancelados</div>
                <div class="summary-percentage">
                    {{ $pedidos->count() > 0 ? number_format(($estadisticas['Cancelado'] / $pedidos->count()) * 100, 1) : 0 }}% del total
                </div>
            </div>
        </div>

        <!-- Gráfico de Distribución -->
        <div class="chart-container">
            <h5 class="mb-3">
                <i class="fas fa-chart-pie me-2"></i>
                Distribución de Pedidos por Estado
            </h5>
            <canvas id="pedidosPorEstadoChart" width="400" height="200"></canvas>
        </div>

        <!-- Lista de Pedidos por Estado -->
        @foreach($pedidos as $estado => $pedidosEstado)
        @if($pedidosEstado->count() > 0)
        <div class="row mb-4">
            <div class="col-12">
                <div class="order-card">
                    <h4 class="mb-3">
                        <i class="fas fa-{{ $estado == 'Pendiente' ? 'clock' : ($estado == 'Entregado' ? 'check-circle' : 'times-circle') }} me-2"></i>
                        Pedidos {{ $estado }}s
                        <span class="badge bg-{{ $estado == 'Pendiente' ? 'warning' : ($estado == 'Entregado' ? 'success' : 'danger') }} ms-2">
                            {{ $pedidosEstado->count() }}
                        </span>
                    </h4>
                    
                    <div class="row">
                        @foreach($pedidosEstado as $pedido)
                        <div class="col-lg-6 mb-3">
                            <div class="order-card">
                                <div class="order-header">
                                    <div>
                                        <div class="order-id">Pedido #{{ $pedido->id_pedido }}</div>
                                        <div class="order-date">
                                            {{ \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y') }} - 
                                            {{ \Carbon\Carbon::parse($pedido->created_at)->format('H:i') }}
                                        </div>
                                    </div>
                                    <div>
                                        <span class="status-badge status-{{ strtolower($pedido->estado) }}">
                                            {{ $pedido->estado }}
                                        </span>
                                    </div>
                                </div>

                                <div class="client-info">
                                    <div class="client-avatar">
                                        {{ substr($pedido->usuarioInfo->usuario->usuarioInfo->nombre ?? $pedido->usuarioInfo->usuario->email, 0, 1) }}
                                    </div>
                                    <div class="client-details">
                                        <div class="client-name">
                                            {{ $pedido->usuarioInfo->usuario->usuarioInfo->nombre ?? 'Sin nombre' }}
                                        </div>
                                        <div class="client-email">
                                            {{ $pedido->usuarioInfo->usuario->email }}
                                        </div>
                                    </div>
                                </div>

                                @if($pedido->observaciones)
                                <div class="order-observations">
                                    <div class="observations-label">Observaciones:</div>
                                    <p class="observations-text">{{ $pedido->observaciones }}</p>
                                </div>
                                @endif

                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        Creado: {{ \Carbon\Carbon::parse($pedido->created_at)->format('d/m/Y H:i') }}
                                    </small>
                                    <div>
                                        <a href="{{ route('user.pedidos.show', $pedido->id_pedido) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i>
                                            Ver Detalles
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endforeach

        <!-- Resumen General -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="order-card">
                    <h5 class="mb-3">
                        <i class="fas fa-chart-bar me-2"></i>
                        Resumen General
                    </h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="h4 mb-1 text-primary">{{ $pedidos->count() }}</div>
                                <div class="text-muted">Total Pedidos</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="h4 mb-1 text-warning">{{ $estadisticas['Pendiente'] }}</div>
                                <div class="text-muted">Pendientes</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="h4 mb-1 text-success">{{ $estadisticas['Entregado'] }}</div>
                                <div class="text-muted">Entregados</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="h4 mb-1 text-danger">{{ $estadisticas['Cancelado'] }}</div>
                                <div class="text-muted">Cancelados</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Estado Vacío -->
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <h4 class="text-muted mb-3">No hay pedidos</h4>
            <h5 class="text-muted mb-3">en el sistema</h5>
            <p class="text-muted mb-4">
                No se han registrado pedidos aún. Los pedidos aparecerán aquí cuando los usuarios los creen.
            </p>
            <a href="{{ route('pedidos.index') }}" class="btn btn-primary">
                <i class="fas fa-list me-1"></i>
                Ver Todos los Pedidos
            </a>
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de Distribución por Estado
    const estados = ['Pendiente', 'Entregado', 'Cancelado'];
    const cantidades = [
        {{ $estadisticas['Pendiente'] }},
        {{ $estadisticas['Entregado'] }},
        {{ $estadisticas['Cancelado'] }}
    ];

    new Chart(document.getElementById('pedidosPorEstadoChart'), {
        type: 'doughnut',
        data: {
            labels: estados,
            datasets: [{
                data: cantidades,
                backgroundColor: [
                    '#f59e0b',
                    '#10b981',
                    '#ef4444'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.parsed;
                            const total = cantidades.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return context.label + ': ' + value + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
