@extends('layouts.app')

@section('title', 'Ventas Anuales - Wurger')
@section('page-title', 'Ventas Anuales')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Ventas Anuales - {{ $año }}</h2>
                <a href="{{ route('reportes.ventas-anuales', ['export' => true]) }}" class="btn btn-primary">
                    <i class="fas fa-download me-2"></i>
                    Exportar Excel
                </a>
            </div>
        </div>
    </div>

    <!-- Resumen del año -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <i class="fas fa-calendar fa-2x mb-2"></i>
                    <h4>{{ $año }}</h4>
                    <small>Año</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                    <h4>{{ $totalCantidad }}</h4>
                    <small>Total Ventas</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <i class="fas fa-dollar-sign fa-2x mb-2"></i>
                    <h4>${{ number_format($totalVentas, 2) }}</h4>
                    <small>Total Ingresos</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line fa-2x mb-2"></i>
                    <h4>${{ number_format($totalVentas / max($totalCantidad, 1), 2) }}</h4>
                    <small>Promedio por Venta</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if($ventas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha</th>
                                        <th>Cliente</th>
                                        <th>Estado</th>
                                        <th>Total</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ventas as $index => $venta)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $venta->fecha->format('d/m/Y') }}</td>
                                        <td>
                                            @if($venta->usuario && $venta->usuario->usuarioInfo)
                                                {{ $venta->usuario->usuarioInfo->nombre }}
                                            @else
                                                <span class="text-muted">Sin información</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $venta->estado == 'Pagada' ? 'success' : ($venta->estado == 'Pendiente' ? 'warning' : 'danger') }}">
                                                {{ $venta->estado }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong class="text-success">${{ number_format($venta->Total_venta, 2) }}</strong>
                                        </td>
                                        <td>
                                            <a href="{{ route('ventas.show', $venta->id_venta) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No hay ventas registradas</h4>
                            <p class="text-muted">No se encontraron ventas para el año {{ $año }}.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
