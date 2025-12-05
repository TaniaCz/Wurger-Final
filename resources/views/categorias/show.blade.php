@extends('layouts.app')

@section('title', 'Detalles de Categoría - Wurger')
@section('page-title', 'Detalles de Categoría')

<style>
.detail-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid #e5e7eb;
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 600;
    color: #374151;
    display: flex;
    align-items: center;
}

.info-value {
    color: #6b7280;
    font-size: 1.1rem;
}

.product-card {
    background: #f8fafc;
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 0.5rem;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
}

.product-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 12px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3);
}

.btn-secondary {
    background: #6b7280;
    border: none;
    border-radius: 12px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: #4b5563;
    transform: translateY(-2px);
}

.btn-danger {
    background: #ef4444;
    border: none;
    border-radius: 12px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-danger:hover {
    background: #dc2626;
    transform: translateY(-2px);
}

.empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: #6b7280;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}
</style>

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="detail-card">
                <div class="d-flex align-items-center mb-4">
                    <div class="me-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-tag text-white"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="mb-1">{{ $categoria->nombre_categoria }}</h4>
                        <p class="text-muted mb-0">Detalles de la categoría</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-tag me-2"></i>
                        Nombre de la Categoría
                    </div>
                    <div class="info-value">{{ $categoria->nombre_categoria }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-hashtag me-2"></i>
                        Cantidad de Platos
                    </div>
                    <div class="info-value">{{ $categoria->cantidad_categoria ?? 0 }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-calendar me-2"></i>
                        Fecha de Creación
                    </div>
                    <div class="info-value">{{ $categoria->created_at->format('d/m/Y H:i') }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-clock me-2"></i>
                        Última Actualización
                    </div>
                    <div class="info-value">{{ $categoria->updated_at->format('d/m/Y H:i') }}</div>
                </div>
                
                <div class="d-flex justify-content-end gap-3 mt-4">
                    <a href="{{ route('categorias.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Volver
                    </a>
                    <a href="{{ route('categorias.edit', $categoria->id_categoria) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>
                        Editar
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="detail-card">
                <h5 class="mb-3">
                    <i class="fas fa-utensils me-2"></i>
                    Platos en esta Categoría
                </h5>
                
                @if($categoria->productos->count() > 0)
                    @foreach($categoria->productos as $producto)
                        <div class="product-card">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ $producto->nombre_producto }}</h6>
                                    <small class="text-muted">
                                        Stock: {{ $producto->stock }} | 
                                        Precio: ${{ number_format($producto->precio_venta, 2) }}
                                    </small>
                                </div>
                                <span class="badge bg-{{ $producto->estado == 'Activo' ? 'success' : 'danger' }}">
                                    {{ $producto->estado }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="fas fa-utensils"></i>
                        <h6>No hay platos en esta categoría</h6>
                        <p>Los platos aparecerán aquí cuando se asignen a esta categoría.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
