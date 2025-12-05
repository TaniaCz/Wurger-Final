@extends('layouts.app')

@section('title', 'Reporte de Promociones - Wurger')
@section('page-title', 'Reporte de Promociones')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Reporte de Promociones</h2>
                <a href="{{ route('reportes.promociones', ['export' => true]) }}" class="btn btn-primary">
                    <i class="fas fa-download me-2"></i>
                    Exportar Excel
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if($promociones->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Promoción</th>
                                        <th>Producto</th>
                                        <th>Período</th>
                                        <th>Usos</th>
                                        <th>Estado</th>
                                        <th>Descripción</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($promociones as $index => $promocion)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-tag text-warning me-2"></i>
                                                <strong>{{ $promocion->nombre }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            @if($promocion->producto)
                                                <span class="badge bg-info">{{ $promocion->producto->nombre_producto }}</span>
                                            @else
                                                <span class="text-muted">Sin producto</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="small">
                                                <strong>Inicio:</strong> {{ $promocion->inicio->format('d/m/Y') }}<br>
                                                <strong>Fin:</strong> {{ $promocion->fin ? $promocion->fin->format('d/m/Y') : 'Sin límite' }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $promocion->cantidad_usos }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $promocion->estado == 'Activa' ? 'success' : 'secondary' }}">
                                                {{ $promocion->estado }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($promocion->descripcion)
                                                {{ Str::limit($promocion->descripcion, 50) }}
                                            @else
                                                <span class="text-muted">Sin descripción</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('promociones.show', $promocion->id_promocion) }}" class="btn btn-sm btn-outline-primary">
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
                            <i class="fas fa-tag fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No hay promociones registradas</h4>
                            <p class="text-muted">No se encontraron promociones para mostrar en este reporte.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
