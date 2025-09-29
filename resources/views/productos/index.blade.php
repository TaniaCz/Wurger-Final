@extends('layouts.app')

@section('title', 'Platos - Wurger')
@section('page-title', 'Gestión de Platos')

<style>
.productos-header {
    background: var(--wurger-gradient);
    color: white;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
}

.product-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
}

.product-image {
    width: 80px;
    height: 80px;
    border-radius: 15px;
    background: var(--wurger-gradient);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    margin-right: 1rem;
    flex-shrink: 0;
}

.product-info h5 {
    margin: 0;
    color: #1f2937;
    font-weight: 700;
}

.product-info p {
    margin: 0;
    color: #6b7280;
    font-size: 0.9rem;
}

.stock-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.stock-bajo {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.stock-normal {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.stock-alto {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.price-tag {
    font-size: 1.2rem;
    font-weight: 800;
    color: var(--wurger-primary);
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

.filter-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.filter-btn {
    padding: 0.5rem 1rem;
    border: 1px solid #d1d5db;
    background: white;
    border-radius: 20px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.filter-btn.active {
    background: var(--wurger-primary);
    color: white;
    border-color: var(--wurger-primary);
}

.filter-btn:hover {
    background: var(--wurger-primary);
    color: white;
    border-color: var(--wurger-primary);
}
</style>

@section('content')
<div class="productos-header">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h1 class="mb-2">
                <i class="fas fa-utensils me-3"></i>
                Gestión de Platos
            </h1>
            <p class="mb-0 opacity-75">Administra el menú de tu restaurante</p>
        </div>
        <a href="{{ route('productos.create') }}" class="btn btn-light">
            <i class="fas fa-plus me-2"></i>
            Nuevo Plato
        </a>
    </div>
</div>

<!-- Búsqueda y Filtros -->
<div class="search-box">
    <div class="row">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <i class="fas fa-search me-3 text-muted"></i>
                <input type="text" class="search-input" placeholder="Buscar platos por nombre, tipo o categoría..." id="searchInput">
            </div>
        </div>
        <div class="col-md-4">
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">Todos</button>
                <button class="filter-btn" data-filter="activo">Activos</button>
                <button class="filter-btn" data-filter="inactivo">Inactivos</button>
                <button class="filter-btn" data-filter="bajo-stock">Bajo Stock</button>
            </div>
        </div>
    </div>
</div>

<!-- Lista de Productos -->
<div class="row" id="productosList">
    @forelse($productos as $producto)
        @php
            $estadoStock = $producto->stock <= $producto->stock_min ? 'bajo' : 
                          ($producto->stock >= $producto->stock_max ? 'alto' : 'normal');
        @endphp
        <div class="col-lg-4 col-md-6 producto-item" 
             data-name="{{ strtolower($producto->nombre_producto) }}" 
             data-type="{{ strtolower($producto->tipo_producto) }}" 
             data-category="{{ strtolower($producto->categoria->nombre_categoria ?? '') }}"
             data-status="{{ strtolower($producto->estado) }}"
             data-stock="{{ $estadoStock }}">
            <div class="product-card">
                <div class="d-flex align-items-start">
                    <div class="product-image">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div class="product-info flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5>{{ $producto->nombre_producto }}</h5>
                            <span class="stock-badge stock-{{ $estadoStock }}">
                                {{ ucfirst($estadoStock) }}
                            </span>
                        </div>
                        
                        <p class="mb-2">
                            <i class="fas fa-tag me-1"></i>
                            {{ $producto->categoria->Nombre_categoria ?? 'Sin categoría' }}
                        </p>
                        
                        <p class="mb-2">
                            <i class="fas fa-cube me-1"></i>
                            {{ $producto->tipo_producto }}
                        </p>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="price-tag">${{ number_format($producto->precio_venta, 2) }}</span>
                            <small class="text-muted">
                                Stock: {{ $producto->stock }}
                            </small>
                        </div>
                        
                        <div class="progress mb-3" style="height: 6px;">
                            @php
                                $porcentaje = $producto->stock_max > 0 ? 
                                    ($producto->stock / $producto->stock_max) * 100 : 0;
                            @endphp
                            <div class="progress-bar 
                                @if($estadoStock === 'bajo') bg-warning
                                @elseif($estadoStock === 'alto') bg-info
                                @else bg-success
                                @endif" 
                                style="width: {{ min($porcentaje, 100) }}%">
                            </div>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <a href="{{ route('productos.show', $producto->id_producto) }}" class="btn btn-outline-primary flex-fill">
                                <i class="fas fa-eye me-1"></i>
                                Ver
                            </a>
                            <a href="{{ route('productos.edit', $producto->id_producto) }}" class="btn btn-outline-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('productos.destroy', $producto->id_producto) }}" method="POST" 
                                  onsubmit="return confirm('¿Estás seguro de eliminar este plato?')" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-utensils fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No hay platos en el menú</h4>
                <p class="text-muted">Comienza agregando platos a tu restaurante.</p>
                <a href="{{ route('productos.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Agregar Primer Plato
                </a>
            </div>
        </div>
    @endforelse
</div>

<!-- Paginación -->
@if($productos->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $productos->links() }}
    </div>
@endif

<script>
// Búsqueda en tiempo real
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const productos = document.querySelectorAll('.producto-item');
    
    productos.forEach(producto => {
        const name = producto.dataset.name;
        const type = producto.dataset.type;
        const category = producto.dataset.category;
        
        if (name.includes(searchTerm) || type.includes(searchTerm) || category.includes(searchTerm)) {
            producto.style.display = 'block';
        } else {
            producto.style.display = 'none';
        }
    });
});

// Filtros
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        // Remover clase active de todos los botones
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        // Agregar clase active al botón clickeado
        this.classList.add('active');
        
        const filter = this.dataset.filter;
        const productos = document.querySelectorAll('.producto-item');
        
        productos.forEach(producto => {
            const status = producto.dataset.status;
            const stock = producto.dataset.stock;
            
            let show = false;
            
            switch(filter) {
                case 'all':
                    show = true;
                    break;
                case 'activo':
                    show = status === 'activo';
                    break;
                case 'inactivo':
                    show = status === 'inactivo';
                    break;
                case 'bajo-stock':
                    show = stock === 'bajo';
                    break;
            }
            
            producto.style.display = show ? 'block' : 'none';
        });
    });
});
</script>
@endsection