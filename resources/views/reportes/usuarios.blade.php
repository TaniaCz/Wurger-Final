@extends('layouts.app')

@section('title', 'Reporte de Usuarios - Wurger')
@section('page-title', 'Reporte de Usuarios')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Reporte de Usuarios</h2>
                <a href="{{ route('reportes.usuarios', ['export' => true]) }}" class="btn btn-primary">
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
                    @if($usuarios->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Usuario</th>
                                        <th>Email</th>
                                        <th>Rol</th>
                                        <th>Estado</th>
                                        <th>Ventas</th>
                                        <th>Registro</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($usuarios as $index => $usuario)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                    {{ substr($usuario->usuarioInfo->nombre ?? $usuario->email, 0, 1) }}
                                                </div>
                                                <div>
                                                    <strong>{{ $usuario->usuarioInfo->nombre ?? 'Sin nombre' }}</strong>
                                                    @if($usuario->usuarioInfo && $usuario->usuarioInfo->telefono)
                                                        <br><small class="text-muted">{{ $usuario->usuarioInfo->telefono }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $usuario->email }}</td>
                                        <td>
                                            <span class="badge bg-{{ $usuario->rol == 'Administrador' ? 'danger' : 'info' }}">
                                                {{ $usuario->rol }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $usuario->estado == 'Activo' ? 'success' : 'secondary' }}">
                                                {{ $usuario->estado }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">{{ $usuario->ventas_count ?? 0 }}</span>
                                        </td>
                                        <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('usuarios.show', $usuario->id_usuario) }}" class="btn btn-sm btn-outline-primary">
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
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No hay usuarios registrados</h4>
                            <p class="text-muted">No se encontraron usuarios para mostrar en este reporte.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 0.875rem;
}
</style>
@endsection
