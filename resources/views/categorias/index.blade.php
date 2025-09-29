@extends('layouts.app')

@section('title', 'Categorías - Wurger')
@section('page-title', 'Gestión de Categorías')

<style>
.categorias-header {
    background: var(--wurger-gradient);
    color: white;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
}

.categoria-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
}

.categoria-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
}

.categoria-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    background: var(--wurger-gradient);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-right: 1rem;
    flex-shrink: 0;
}

.categoria-info h5 {
    margin: 0;
    color: #1f2937;
    font-weight: 700;
}

.categoria-info p {
    margin: 0;
    color: #6b7280;
    font-size: 0.9rem;
}

.platos-count {
    background: rgba(59, 130, 246, 0.1);
    color: var(--wurger-primary);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    text-align: center;
}

.search-box {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    margin-bottom: 2rem;
}

.search-input {
    border: none;
    background: transparent;
    font-size: 1.1rem;
    padding: 0.5rem 0;
    width: 100%;
}

.search-input:focus {
    outline: none;
}

.search-input::placeholder {
    color: #9ca3af;
}
</style>

@section('content')
<div class="categorias-header">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h1 class="mb-2">
                <i class="fas fa-tags me-3"></i>
                Gestión de Categorías
            </h1>
            <p class="mb-0 opacity-75">Organiza tus platos por categorías</p>
        </div>
        <a href="{{ route('categorias.create') }}" class="btn btn-light">
            <i class="fas fa-plus me-2"></i>
            Nueva Categoría
        </a>
    </div>
</div>

<!-- Búsqueda -->
<div class="search-box">
    <div class="d-flex align-items-center">
        <i class="fas fa-search me-3 text-muted"></i>
        <input type="text" class="search-input" placeholder="Buscar categorías por nombre..." id="searchInput">
    </div>
</div>

<!-- Lista de Categorías -->
<div class="row" id="categoriasList">
    @forelse($categorias as $categoria)
        <div class="col-lg-4 col-md-6 categoria-item" data-name="{{ strtolower($categoria->nombre_categoria) }}">
            <div class="categoria-card">
                <div class="d-flex align-items-start">
                    <div class="categoria-icon">
                        <i class="fas fa-tag"></i>
                    </div>
                    <div class="categoria-info flex-grow-1">
                        <h5>{{ $categoria->nombre_categoria }}</h5>
                        <p class="mb-3">Categoría de platos</p>
                        
                        <div class="platos-count">
                            {{ $categoria->productos()->count() }} 
                            {{ $categoria->productos()->count() == 1 ? 'Plato' : 'Platos' }}
                        </div>
                    </div>
                </div>
                
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('categorias.show', $categoria->id_categoria) }}" class="btn btn-outline-primary flex-fill">
                        <i class="fas fa-eye me-1"></i>
                        Ver Detalles
                    </a>
                    <a href="{{ route('categorias.edit', $categoria->id_categoria) }}" class="btn btn-outline-warning">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('categorias.destroy', $categoria->id_categoria) }}" method="POST" 
                          onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?')" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No hay categorías registradas</h4>
                <p class="text-muted">Comienza creando categorías para organizar tus platos.</p>
                <a href="{{ route('categorias.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Crear Primera Categoría
                </a>
            </div>
        </div>
    @endforelse
</div>

<!-- Paginación -->
@if($categorias->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $categorias->links() }}
    </div>
@endif

<script>
// Búsqueda en tiempo real
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const categorias = document.querySelectorAll('.categoria-item');
    
    categorias.forEach(categoria => {
        const name = categoria.dataset.name;
        
        if (name.includes(searchTerm)) {
            categoria.style.display = 'block';
        } else {
            categoria.style.display = 'none';
        }
    });
});
</script>
@endsection