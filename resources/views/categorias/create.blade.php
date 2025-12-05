@extends('layouts.app')

@section('title', 'Nueva Categoría - Wurger')
@section('page-title', 'Nueva Categoría')

<style>
.form-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.form-control {
    border-radius: 12px;
    border: 1px solid #d1d5db;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: var(--wurger-primary);
    box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
}

.btn-primary {
    background: var(--wurger-gradient);
    border: none;
    border-radius: 12px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(30, 64, 175, 0.3);
}

.help-text {
    font-size: 0.875rem;
    color: #6b7280;
    margin-top: 0.25rem;
}

.required {
    color: #ef4444;
}

.categoria-preview {
    background: rgba(59, 130, 246, 0.05);
    border: 1px solid rgba(59, 130, 246, 0.1);
    border-radius: 12px;
    padding: 1rem;
    margin-top: 1rem;
    text-align: center;
}

.categoria-preview h6 {
    color: var(--wurger-primary);
    margin-bottom: 0.5rem;
}

.categoria-preview small {
    color: #6b7280;
}
</style>

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="form-card">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-tag me-3" style="font-size: 1.5rem; color: var(--wurger-primary);"></i>
                <h4 class="mb-0">Crear Nueva Categoría</h4>
            </div>
            
            <form action="{{ route('categorias.store') }}" method="POST">
                @csrf
                
                <div class="form-group mb-3">
                    <label for="nombre_categoria" class="form-label">
                        Nombre de la Categoría <span class="required">*</span>
                    </label>
                    <input type="text" 
                           class="form-control @error('nombre_categoria') is-invalid @enderror" 
                           id="nombre_categoria" 
                           name="nombre_categoria" 
                           value="{{ old('nombre_categoria') }}" 
                           placeholder="Ej: Hamburguesas, Bebidas, Postres..."
                           maxlength="50"
                           required>
                    @error('nombre_categoria')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="help-text">Máximo 50 caracteres</div>
                </div>
                
                <div class="form-group mb-3">
                    <label for="cantidad_categoria" class="form-label">
                        Cantidad Inicial
                    </label>
                    <input type="number" 
                           class="form-control @error('cantidad_categoria') is-invalid @enderror" 
                           id="cantidad_categoria" 
                           name="cantidad_categoria" 
                           value="{{ old('cantidad_categoria', 0) }}" 
                           min="0"
                           placeholder="0">
                    @error('cantidad_categoria')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="help-text">Número inicial de platos en esta categoría (opcional)</div>
                </div>
                
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('categorias.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Crear Categoría
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Vista Previa -->
        <div class="form-card">
            <h5 class="mb-3">
                <i class="fas fa-eye me-2"></i>
                Vista Previa
            </h5>
            
            <div class="categoria-preview" id="categoriaPreview">
                <div class="mb-2">
                    <i class="fas fa-tag fa-2x text-primary"></i>
                </div>
                <h6 id="previewNombre">Nombre de la Categoría</h6>
                <small id="previewCantidad">0 Platos</small>
            </div>
        </div>
        
        <!-- Información -->
        <div class="form-card">
            <h5 class="mb-3">
                <i class="fas fa-info-circle me-2"></i>
                Información
            </h5>
            
            <div class="mb-3">
                <div class="form-label">Campos Requeridos</div>
                <ul class="list-unstyled">
                    <li class="mb-1">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Nombre de la categoría</small>
                    </li>
                </ul>
            </div>
            
            <div class="mb-3">
                <div class="form-label">Campos Opcionales</div>
                <ul class="list-unstyled">
                    <li class="mb-1">
                        <i class="fas fa-hashtag text-muted me-2"></i>
                        <small>Cantidad inicial de platos</small>
                    </li>
                </ul>
            </div>
            
            <div class="alert alert-info">
                <i class="fas fa-lightbulb me-2"></i>
                <small>
                    <strong>Consejo:</strong> Las categorías te ayudan a organizar y filtrar tus platos de manera más eficiente.
                </small>
            </div>
        </div>
        
        <!-- Estadísticas -->
        <div class="form-card">
            <h5 class="mb-3">
                <i class="fas fa-chart-line me-2"></i>
                Estadísticas
            </h5>
            
            <div class="row text-center">
                <div class="col-6">
                    <div class="fw-bold text-primary">{{ \App\Models\CategoriaProducto::count() }}</div>
                    <small class="text-muted">Categorías</small>
                </div>
                <div class="col-6">
                    <div class="fw-bold text-success">{{ \App\Models\Producto::count() }}</div>
                    <small class="text-muted">Platos Totales</small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Actualizar vista previa en tiempo real
document.getElementById('nombre_categoria').addEventListener('input', function() {
    const nombre = this.value.trim() || 'Nombre de la Categoría';
    document.getElementById('previewNombre').textContent = nombre;
});

document.getElementById('cantidad_categoria').addEventListener('input', function() {
    const cantidad = this.value || 0;
    const texto = cantidad == 1 ? '1 Plato' : `${cantidad} Platos`;
    document.getElementById('previewCantidad').textContent = texto;
});

// Validación en tiempo real
document.getElementById('nombre_categoria').addEventListener('input', function() {
    const value = this.value.trim();
    const maxLength = 50;
    
    if (value.length > maxLength) {
        this.value = value.substring(0, maxLength);
    }
});

document.getElementById('cantidad_categoria').addEventListener('input', function() {
    const value = parseInt(this.value);
    
    if (isNaN(value) || value < 0) {
        this.value = 0;
    }
});
</script>
@endsection
