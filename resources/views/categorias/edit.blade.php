@extends('layouts.app')

@section('title', 'Editar Categoría - Wurger')
@section('page-title', 'Editar Categoría')

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
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    outline: none;
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

.required {
    color: #ef4444;
}

.help-text {
    font-size: 0.875rem;
    color: #6b7280;
    margin-top: 0.25rem;
}
</style>

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="form-card">
                <div class="d-flex align-items-center mb-4">
                    <div class="me-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-edit text-white"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="mb-1">Editar Categoría</h4>
                        <p class="text-muted mb-0">Actualizar información de {{ $categoria->nombre_categoria }}</p>
                    </div>
                </div>
                
                <form action="{{ route('categorias.update', $categoria->id_categoria) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group mb-3">
                        <label for="nombre_categoria" class="form-label">
                            Nombre de la Categoría <span class="required">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nombre_categoria') is-invalid @enderror" 
                               id="nombre_categoria" 
                               name="nombre_categoria" 
                               value="{{ old('nombre_categoria', $categoria->nombre_categoria) }}" 
                               placeholder="Ej: Hamburguesas, Bebidas, Postres..."
                               maxlength="50"
                               required>
                        @error('nombre_categoria')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="help-text">Máximo 50 caracteres</div>
                    </div>
                    
                    <div class="form-group mb-4">
                        <label for="cantidad_categoria" class="form-label">
                            <i class="fas fa-hashtag me-2"></i>
                            Cantidad de Platos
                        </label>
                        <input type="number" 
                               class="form-control @error('cantidad_categoria') is-invalid @enderror" 
                               id="cantidad_categoria" 
                               name="cantidad_categoria" 
                               value="{{ old('cantidad_categoria', $categoria->cantidad_categoria) }}" 
                               placeholder="0"
                               min="0">
                        @error('cantidad_categoria')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="help-text">Número de platos en esta categoría (opcional)</div>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('categorias.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Actualizar Categoría
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación en tiempo real
    const nombreInput = document.getElementById('nombre_categoria');
    const cantidadInput = document.getElementById('cantidad_categoria');
    
    // Validar nombre
    nombreInput.addEventListener('input', function() {
        const value = this.value.trim();
        if (value.length < 2) {
            this.setCustomValidity('El nombre debe tener al menos 2 caracteres');
        } else if (value.length > 50) {
            this.setCustomValidity('El nombre no puede exceder 50 caracteres');
        } else {
            this.setCustomValidity('');
        }
    });
    
    // Validar cantidad
    cantidadInput.addEventListener('input', function() {
        const value = parseInt(this.value);
        if (this.value && value < 0) {
            this.setCustomValidity('La cantidad no puede ser negativa');
        } else {
            this.setCustomValidity('');
        }
    });
    
    // Validar formulario antes de enviar
    document.querySelector('form').addEventListener('submit', function(e) {
        const nombre = nombreInput.value.trim();
        const cantidad = cantidadInput.value;
        
        if (nombre.length < 2) {
            e.preventDefault();
            alert('El nombre de la categoría debe tener al menos 2 caracteres');
            nombreInput.focus();
            return;
        }
        
        if (cantidad && parseInt(cantidad) < 0) {
            e.preventDefault();
            alert('La cantidad no puede ser negativa');
            cantidadInput.focus();
            return;
        }
    });
});
</script>
@endsection
