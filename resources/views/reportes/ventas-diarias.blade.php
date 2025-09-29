@extends('layouts.app')

@section('title', 'Reporte de Ventas Diarias - Wurger')
@section('page-title', 'Reporte de Ventas Diarias')

@section('content')
<style>
    .report-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
    
    .stats-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        text-align: center;
    }
    
    .stats-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #374151;
        margin-bottom: 0.5rem;
    }
    
    .stats-label {
        color: #6b7280;
        font-weight: 500;
    }
    
    .filter-section {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .table-modern {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .table-modern thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .table-modern thead th {
        border: none;
        padding: 1rem;
        font-weight: 600;
    }
    
    .table-modern tbody td {
        padding: 1rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        vertical-align: middle;
    }
    
    .table-modern tbody tr:hover {
        background: rgba(102, 126, 234, 0.05);
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
    
    .status-pagada {
        background: #d1fae5;
        color: #065f46;
    }
    
    .status-anulada {
        background: #fee2e2;
        color: #991b1b;
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
</style>

<div class="container-fluid">
    <!-- Header del Reporte -->
    <div class="report-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="mb-2">
                    <i class="fas fa-calendar-day me-2"></i>
                    Reporte de Ventas Diarias
                </h2>
                <p class="mb-0 opacity-75">
                    Análisis detallado de ventas para el {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}
                </p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('reportes.ventas-diarias', ['export' => 1]) }}" class="export-btn">
                    <i class="fas fa-file-excel"></i>
                    Exportar Excel
                </a>
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="stats-card">
                <div class="stats-number">{{ $totalCantidad }}</div>
                <div class="stats-label">Total de Ventas</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stats-card">
                <div class="stats-number">${{ number_format($totalVentas, 2) }}</div>
                <div class="stats-label">Valor Total</div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="filter-section">
        <form method="GET" action="{{ route('reportes.ventas-diarias') }}">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label for="fecha" class="form-label">Seleccionar Fecha</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" value="{{ $fecha }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i>
                        Filtrar
                    </button>
                    <a href="{{ route('reportes.ventas-diarias') }}" class="btn btn-outline-secondary ms-2">
                        <i class="fas fa-refresh me-1"></i>
                        Limpiar
                    </a>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('reportes.ventas-diarias', ['export' => 1, 'fecha' => $fecha]) }}" class="export-btn">
                        <i class="fas fa-download me-1"></i>
                        Exportar con Filtro
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabla de Ventas -->
    <div class="table-modern">
        @if($ventas->count() > 0)
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Total</th>
                        <th>Detalles</th>
                        <th>Creado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventas as $venta)
                    <tr>
                        <td>
                            <strong>#{{ $venta->id_venta }}</strong>
                        </td>
                        <td>
                            <div>
                                <div class="fw-bold">{{ $venta->usuario->usuarioInfo->nombre ?? 'Sin nombre' }}</div>
                                <small class="text-muted">{{ $venta->usuario->email }}</small>
                            </div>
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}
                        </td>
                        <td>
                            <span class="status-badge status-{{ strtolower($venta->estado) }}">
                                {{ $venta->estado }}
                            </span>
                        </td>
                        <td>
                            <strong class="text-success">${{ number_format($venta->Total_venta, 2) }}</strong>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $venta->detalles->count() }} items</span>
                        </td>
                        <td>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($venta->created_at)->format('H:i') }}
                            </small>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center py-5">
                <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No hay ventas para esta fecha</h5>
                <p class="text-muted">Selecciona otra fecha para ver las ventas correspondientes.</p>
            </div>
        @endif
    </div>

    <!-- Resumen por Estado -->
    @if($ventas->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="stats-card">
                <h5 class="mb-3">Resumen por Estado</h5>
                <div class="row">
                    @php
                        $estados = $ventas->groupBy('estado');
                    @endphp
                    @foreach($estados as $estado => $ventasEstado)
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="h4 mb-1">{{ $ventasEstado->count() }}</div>
                            <div class="text-muted">{{ $estado }}</div>
                            <div class="small text-success">
                                ${{ number_format($ventasEstado->sum('Total_venta'), 2) }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
    // Auto-submit del formulario cuando cambie la fecha
    document.getElementById('fecha').addEventListener('change', function() {
        this.form.submit();
    });
</script>
@endsection