@extends('layouts.app')

@section('title', 'Gestión de Usuarios - Wurger')
@section('page-title', 'Gestión de Usuarios')

<style>
.user-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.user-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 48px rgba(0,0,0,0.15);
}

.user-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: var(--wurger-gradient);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    font-weight: 600;
    margin-right: 1rem;
    box-shadow: 0 4px 15px rgba(30, 64, 175, 0.3);
}

.user-info h6 {
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 0.25rem;
}

.user-info small {
    color: var(--secondary-color);
    font-size: 0.875rem;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-activo {
    background: #d1fae5;
    color: #065f46;
}

.status-inactivo {
    background: #fee2e2;
    color: #991b1b;
}

.role-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    background: #dbeafe;
    color: #1e40af;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.btn-action {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.btn-view {
    background: #3b82f6;
    color: white;
}

.btn-view:hover {
    background: #2563eb;
    color: white;
    text-decoration: none;
}

.btn-edit {
    background: #f59e0b;
    color: white;
}

.btn-edit:hover {
    background: #d97706;
    color: white;
    text-decoration: none;
}

.btn-delete {
    background: #ef4444;
    color: white;
}

.btn-delete:hover {
    background: #dc2626;
    color: white;
    text-decoration: none;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.empty-icon {
    font-size: 4rem;
    color: #6b7280;
    margin-bottom: 1rem;
}

.stats-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 1.5rem;
    text-align: center;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    margin-bottom: 2rem;
}

.stats-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--wurger-primary);
    margin-bottom: 0.5rem;
}

.stats-label {
    color: #6b7280;
    font-weight: 500;
}
</style>

@section('content')
<div class="container-fluid">
    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ $usuarios->total() }}</div>
                <div class="stats-label">Total Usuarios</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ $usuarios->where('estado', 'Activo')->count() }}</div>
                <div class="stats-label">Usuarios Activos</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ $usuarios->where('estado', 'Inactivo')->count() }}</div>
                <div class="stats-label">Usuarios Inactivos</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ $usuarios->where('created_at', '>=', now()->subMonth())->count() }}</div>
                <div class="stats-label">Nuevos este Mes</div>
            </div>
        </div>
    </div>

    <!-- Lista de Usuarios -->
    @if($usuarios->count() > 0)
        <div class="row">
            @foreach($usuarios as $usuario)
            <div class="col-lg-6 mb-4">
                <div class="user-card p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="user-avatar">
                            {{ substr($usuario->usuarioInfo->nombre ?? $usuario->email, 0, 1) }}
                        </div>
                        <div class="user-info flex-grow-1">
                            <h6 class="mb-1">{{ $usuario->usuarioInfo->nombre ?? 'Sin nombre' }}</h6>
                            <small class="text-muted">{{ $usuario->email }}</small>
                        </div>
                        <div class="text-end">
                            <span class="status-badge status-{{ strtolower($usuario->estado) }}">
                                {{ $usuario->estado }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted">Rol:</small>
                            <div class="role-badge d-inline-block ms-1">{{ $usuario->rol }}</div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Registrado:</small>
                            <div class="small">{{ $usuario->created_at->format('d/m/Y') }}</div>
                        </div>
                    </div>

                    @if($usuario->usuarioInfo)
                    <div class="row mb-3">
                        @if($usuario->usuarioInfo->telefono)
                        <div class="col-6">
                            <small class="text-muted">Teléfono:</small>
                            <div class="small">{{ $usuario->usuarioInfo->telefono }}</div>
                        </div>
                        @endif
                        @if($usuario->usuarioInfo->direccion)
                        <div class="col-6">
                            <small class="text-muted">Dirección:</small>
                            <div class="small">{{ Str::limit($usuario->usuarioInfo->direccion, 30) }}</div>
                        </div>
                        @endif
                    </div>
                    @endif

                    <div class="action-buttons">
                        <a href="{{ route('usuarios.show', $usuario->id_usuario) }}" class="btn-action btn-view">
                            <i class="fas fa-eye"></i>
                            Ver
                        </a>
                        <a href="{{ route('usuarios.edit', $usuario->id_usuario) }}" class="btn-action btn-edit">
                            <i class="fas fa-edit"></i>
                            Editar
                        </a>
                        <form action="{{ route('usuarios.destroy', $usuario->id_usuario) }}" method="POST" 
                              onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action btn-delete">
                                <i class="fas fa-trash"></i>
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="d-flex justify-content-center mt-4">
            {{ $usuarios->links() }}
        </div>
    @else
        <!-- Estado Vacío -->
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-users"></i>
            </div>
            <h4 class="text-muted mb-3">No hay usuarios registrados</h4>
            <h5 class="text-muted mb-3">en el sistema</h5>
            <p class="text-muted mb-4">
                Los usuarios aparecerán aquí cuando se registren en el sistema.
                Solo se muestran usuarios regulares, no administradores.
            </p>
            <a href="{{ route('clientes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Crear Cliente
            </a>
        </div>
    @endif
</div>
@endsection