@extends('layouts.app')

@section('title', 'Búsqueda - Wurger')
@section('page-title', 'Búsqueda Avanzada')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('busqueda.index') }}" class="row g-3">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" 
                                   class="form-control form-control-lg" 
                                   name="q" 
                                   value="{{ $query }}" 
                                   placeholder="Buscar en todo el sistema..."
                                   autofocus>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select form-select-lg" name="tipo">
                            <option value="todos" {{ $tipo == 'todos' ? 'selected' : '' }}>Todos</option>
                            <option value="usuarios" {{ $tipo == 'usuarios' ? 'selected' : '' }}>Usuarios</option>
                            <option value="productos" {{ $tipo == 'productos' ? 'selected' : '' }}>Productos</option>
                            <option value="ventas" {{ $tipo == 'ventas' ? 'selected' : '' }}>Ventas</option>
                            <option value="clientes" {{ $tipo == 'clientes' ? 'selected' : '' }}>Clientes</option>
                            <option value="categorias" {{ $tipo == 'categorias' ? 'selected' : '' }}>Categorías</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if($query)
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-search me-2"></i>
                    Resultados para "{{ $query }}"
                </h5>
                <span class="badge bg-primary fs-6">{{ $resultados->count() }} resultados</span>
            </div>
        </div>
    </div>
    
    @if($resultados->count() > 0)
        <div class="row">
            @foreach($resultados as $resultado)
                <div class="col-lg-6 col-xl-4 mb-4">
                    <div class="card h-100 search-result-card">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <div class="search-icon me-3">
                                    <i class="{{ $resultado['icono'] }} fa-2x text-{{ $resultado['color'] }}"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="card-title mb-0">{{ $resultado['titulo'] }}</h6>
                                        <span class="badge bg-{{ $resultado['color'] }}">{{ ucfirst($resultado['tipo']) }}</span>
                                    </div>
                                    <p class="card-text text-muted mb-2">{{ $resultado['subtitulo'] }}</p>
                                    <p class="card-text small">{{ $resultado['descripcion'] }}</p>
                                    <a href="{{ $resultado['url'] }}" class="btn btn-outline-{{ $resultado['color'] }} btn-sm">
                                        <i class="fas fa-eye me-1"></i>
                                        Ver Detalles
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No se encontraron resultados</h5>
                        <p class="text-muted">Intenta con otros términos de búsqueda o verifica la ortografía</p>
                        <a href="{{ route('busqueda.index') }}" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>
                            Nueva Búsqueda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@else
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-search fa-3x text-primary mb-3"></i>
                    <h5 class="text-primary">Búsqueda Avanzada</h5>
                    <p class="text-muted">Busca usuarios, productos, ventas, clientes y categorías en todo el sistema</p>
                    
                    <div class="row mt-4">
                        <div class="col-md-3 mb-3">
                            <div class="search-category">
                                <i class="fas fa-users fa-2x text-primary mb-2"></i>
                                <h6>Usuarios</h6>
                                <small class="text-muted">Buscar por nombre, email o cédula</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="search-category">
                                <i class="fas fa-box fa-2x text-success mb-2"></i>
                                <h6>Productos</h6>
                                <small class="text-muted">Buscar por nombre o tipo</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="search-category">
                                <i class="fas fa-shopping-cart fa-2x text-info mb-2"></i>
                                <h6>Ventas</h6>
                                <small class="text-muted">Buscar por ID o estado</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="search-category">
                                <i class="fas fa-user-tie fa-2x text-warning mb-2"></i>
                                <h6>Clientes</h6>
                                <small class="text-muted">Buscar por nombre o teléfono</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<style>
.search-result-card {
    transition: all 0.3s ease;
    border: 1px solid #e5e7eb;
}

.search-result-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    border-color: var(--wurger-primary);
}

.search-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(30, 64, 175, 0.1);
    border-radius: 10px;
}

.search-category {
    padding: 1.5rem;
    border-radius: 10px;
    background: rgba(30, 64, 175, 0.05);
    transition: all 0.3s ease;
}

.search-category:hover {
    background: rgba(30, 64, 175, 0.1);
    transform: translateY(-3px);
}

.input-group-text {
    background: var(--wurger-light);
    border-color: #e5e7eb;
    color: var(--wurger-primary);
}

.form-control:focus {
    border-color: var(--wurger-primary);
    box-shadow: 0 0 0 0.2rem rgba(30, 64, 175, 0.25);
}

.form-select:focus {
    border-color: var(--wurger-primary);
    box-shadow: 0 0 0 0.2rem rgba(30, 64, 175, 0.25);
}
</style>
@endsection
