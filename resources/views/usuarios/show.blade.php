@extends('layouts.app')

@section('title', 'Detalle de Usuario - Wurger')
@section('page-title', 'Detalle de Usuario')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user me-2"></i>
                    Información del Usuario
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center mb-4">
                        <div class="avatar-large bg-primary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3">
                            <i class="fas fa-user fa-3x"></i>
                        </div>
                        <h4>{{ $usuario->Nom_usuario }} {{ $usuario->Apellido_usuario }}</h4>
                        <span class="badge bg-{{ $usuario->Estado_usuario == 'Activo' ? 'success' : 'danger' }} fs-6">
                            {{ $usuario->Estado_usuario }}
                        </span>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label class="form-label fw-bold">Cédula:</label>
                                <p class="text-muted">{{ $usuario->Cedula_usuario }}</p>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label fw-bold">Email:</label>
                                <p class="text-muted">{{ $usuario->Email_usuario }}</p>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label fw-bold">Teléfono:</label>
                                <p class="text-muted">{{ $usuario->Tel_usuario ?? 'No especificado' }}</p>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label fw-bold">Sexo:</label>
                                <p class="text-muted">
                                    @if($usuario->Sexo_usuario == 'M')
                                        Masculino
                                    @elseif($usuario->Sexo_usuario == 'F')
                                        Femenino
                                    @else
                                        {{ $usuario->Sexo_usuario ?? 'No especificado' }}
                                    @endif
                                </p>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label fw-bold">Salario:</label>
                                <p class="text-muted">
                                    @if($usuario->Salario_usuario)
                                        ${{ number_format($usuario->Salario_usuario, 2) }}
                                    @else
                                        No especificado
                                    @endif
                                </p>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label fw-bold">Rol:</label>
                                <p class="text-muted">
                                    <span class="badge bg-info">
                                        {{ $usuario->rol->Nombre_rol ?? 'Sin rol' }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label fw-bold">Fecha de Ingreso:</label>
                                <p class="text-muted">
                                    {{ $usuario->Fecha_ingreso_usuario ? $usuario->Fecha_ingreso_usuario->format('d/m/Y') : 'No especificada' }}
                                </p>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label fw-bold">Fecha de Nacimiento:</label>
                                <p class="text-muted">
                                    {{ $usuario->Fecha_nac_usuario ? $usuario->Fecha_nac_usuario->format('d/m/Y') : 'No especificada' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>
                        Volver
                    </a>
                    <a href="{{ route('usuarios.edit', $usuario->id_usuario) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>
                        Editar Usuario
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    Estadísticas
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="border-end">
                            <h4 class="text-primary">{{ $usuario->ventas->count() }}</h4>
                            <small class="text-muted">Ventas</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <h4 class="text-success">{{ $usuario->proveedores->count() }}</h4>
                        <small class="text-muted">Proveedores</small>
                    </div>
                </div>
                
                <div class="mt-3">
                    <h6>Información del Sistema:</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-calendar text-muted me-2"></i>Registrado: {{ $usuario->created_at->format('d/m/Y') }}</li>
                        <li><i class="fas fa-clock text-muted me-2"></i>Última actualización: {{ $usuario->updated_at->format('d/m/Y H:i') }}</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-history me-2"></i>
                    Actividad Reciente
                </h6>
            </div>
            <div class="card-body">
                @if($usuario->ventas->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($usuario->ventas->take(5) as $venta)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">Venta #{{ $venta->id_venta }}</h6>
                                        <small class="text-muted">{{ $venta->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <span class="badge bg-{{ $venta->Estado_venta == 'Pagada' ? 'success' : ($venta->Estado_venta == 'Pendiente' ? 'warning' : 'danger') }}">
                                        {{ $venta->Estado_venta }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center">No hay actividad reciente</p>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.avatar-large {
    width: 120px;
    height: 120px;
    font-size: 48px;
}
</style>
@endsection
