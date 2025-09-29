@extends('layouts.app')

@section('title', 'Nuestro Menú - Wurger')
@section('page-title', 'Nuestro Menú')

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
    cursor: pointer;
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

.stock-disponible {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.stock-agotado {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.price-tag {
    font-size: 1.4rem;
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

.category-section {
    margin-bottom: 3rem;
}

.category-title {
    color: var(--wurger-primary);
    font-weight: 700;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--wurger-primary);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.empty-state i {
    font-size: 4rem;
    color: #9ca3af;
    margin-bottom: 1rem;
}

.empty-state h4 {
    color: #6b7280;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #9ca3af;
    margin-bottom: 0;
}
</style>

@section('content')
<div class="productos-header">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h1 class="mb-2">
                <i class="fas fa-utensils me-3"></i>
                Nuestro Menú
            </h1>
            <p class="mb-0 opacity-75">Descubre los deliciosos platos que tenemos para ti</p>
        </div>
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
                <button class="filter-btn" data-filter="disponible">Disponibles</button>
                <button class="filter-btn" data-filter="agotado">Agotados</button>
            </div>
        </div>
    </div>
</div>

<!-- Lista de Productos -->
@if($productos->count() > 0)
    @php
        $productosPorCategoria = $productos->groupBy('categoria.Nombre_categoria');
    @endphp
    
    @foreach($productosPorCategoria as $categoria => $productosCategoria)
        <div class="category-section">
            <h3 class="category-title">
                <i class="fas fa-tag"></i>
                {{ $categoria ?? 'Sin Categoría' }}
            </h3>
            
            <div class="row" id="productosList">
                @foreach($productosCategoria as $producto)
                    @php
                        $disponible = $producto->estado === 'Activo' && $producto->stock > 0;
                    @endphp
                    <div class="col-lg-4 col-md-6 producto-item" 
                         data-name="{{ strtolower($producto->nombre_producto) }}" 
                         data-type="{{ strtolower($producto->tipo_producto) }}" 
                         data-category="{{ strtolower($producto->categoria->nombre_categoria ?? '') }}"
                         data-available="{{ $disponible ? 'disponible' : 'agotado' }}">
                        <div class="product-card" onclick="showProductDetails('{{ $producto->id_producto }}')">
                            <div class="d-flex align-items-start">
                                <div class="product-image">
                                    <i class="fas fa-utensils"></i>
                                </div>
                                <div class="product-info flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5>{{ $producto->nombre_producto }}</h5>
                                        <span class="stock-badge {{ $disponible ? 'stock-disponible' : 'stock-agotado' }}">
                                            {{ $disponible ? 'Disponible' : 'Agotado' }}
                                        </span>
                                    </div>
                                    
                                    <p class="mb-2">
                                        <i class="fas fa-cube me-1"></i>
                                        {{ $producto->tipo_producto }}
                                    </p>
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="price-tag">${{ number_format($producto->precio_venta, 2) }}</span>
                                        @if($disponible)
                                            <small class="text-muted">
                                                Stock: {{ $producto->stock }}
                                            </small>
                                        @endif
                                    </div>
                                    
                                    @if($disponible)
                                        <div class="progress mb-3" style="height: 6px;">
                                            @php
                                                $porcentaje = $producto->stock_max > 0 ? 
                                                    ($producto->stock / $producto->stock_max) * 100 : 0;
                                            @endphp
                                            <div class="progress-bar bg-success" 
                                                 style="width: {{ min($porcentaje, 100) }}%">
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('user.productos.show', $producto->id_producto) }}" 
                                           class="btn btn-primary w-100">
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
        </div>
    @endforeach
@else
    <div class="empty-state">
        <i class="fas fa-utensils"></i>
        <h4>No hay platos disponibles</h4>
        <p>Pronto tendremos deliciosas opciones para ti.</p>
    </div>
@endif

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
            const available = producto.dataset.available;
            
            let show = false;
            
            switch(filter) {
                case 'all':
                    show = true;
                    break;
                case 'disponible':
                    show = available === 'disponible';
                    break;
                case 'agotado':
                    show = available === 'agotado';
                    break;
            }
            
            producto.style.display = show ? 'block' : 'none';
        });
    });
});

function showProductDetails(productId) {
    window.location.href = `/user-productos/${productId}`;
}
</script>
@endsection
