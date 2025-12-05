@extends('layouts.app')

@section('title', 'Reporte de Proveedores - Wurger')
@section('page-title', 'Reporte de Proveedores')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Reporte de Proveedores</h2>
                <a href="{{ route('reportes.proveedores', ['export' => true]) }}" class="btn btn-primary">
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
                    @if($proveedores->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Proveedor</th>
                                        <th>Contacto</th>
                                        <th>Email</th>
                                        <th>Dirección</th>
                                        <th>Estado</th>
                                        <th>Usuario</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($proveedores as $index => $proveedor)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-truck text-primary me-2"></i>
                                                <strong>{{ $proveedor->nombre }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            @if($proveedor->telefono)
                                                <i class="fas fa-phone text-muted me-1"></i>
                                                {{ $proveedor->telefono }}
                                            @else
                                                <span class="text-muted">No especificado</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($proveedor->email)
                                                <i class="fas fa-envelope text-muted me-1"></i>
                                                {{ $proveedor->email }}
                                            @else
                                                <span class="text-muted">No especificado</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($proveedor->direccion)
                                                <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                                {{ Str::limit($proveedor->direccion, 30) }}
                                            @else
                                                <span class="text-muted">No especificada</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $proveedor->estado == 'Activo' ? 'success' : 'secondary' }}">
                                                {{ $proveedor->estado }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($proveedor->usuario)
                                                {{ $proveedor->usuario->usuarioInfo->nombre ?? $proveedor->usuario->email }}
                                            @else
                                                <span class="text-muted">Sin asignar</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('proveedores.show', $proveedor->id_proveedor) }}" class="btn btn-sm btn-outline-primary">
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
                            <i class="fas fa-truck fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No hay proveedores registrados</h4>
                            <p class="text-muted">No se encontraron proveedores para mostrar en este reporte.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
