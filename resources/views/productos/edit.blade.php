@extends('layouts.app')

@section('title', 'Editar Plato - Wurger')
@section('page-title', 'Editar Plato')

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

.form-control, .form-select {
    border-radius: 12px;
    border: 1px solid #d1d5db;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
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

.producto-avatar {
    width: 80px;
    height: 80px;
    border-radius: 20px;
    background: var(--wurger-gradient);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    margin-right: 1.5rem;
    border: 3px solid rgba(255, 255, 255, 0.3);
}

.stock-info {
    background: rgba(59, 130, 246, 0.05);
    border-radius: 15px;
    padding: 1.5rem;
    border: 1px solid rgba(59, 130, 246, 0.1);
}

.stock-info h6 {
    color: var(--wurger-primary);
    margin-bottom: 1rem;
}

.stock-info small {
    color: #6b7280;
}
</style>

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="form-card">
            <div class="d-flex align-items-center mb-4">
                <div class="producto-avatar">
                    <i class="fas fa-utensils"></i>
                </div>
                <div>
                    <h4 class="mb-0">Editar Plato</h4>
                    <p class="text-muted mb-0">Actualizar información de {{ $producto->nombre_producto }}</p>
                </div>
            </div>
            
            <form action="{{ route('productos.update', $producto->id_producto) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label for="nombre_producto" class="form-label">
                                Nombre del Plato <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nombre_producto') is-invalid @enderror" 
                                   id="nombre_producto" 
                                   name="nombre_producto" 
                                   value="{{ old('nombre_producto', $producto->nombre_producto) }}" 
                                   placeholder="Ej: Hamburguesa Clásica"
                                   maxlength="50"
                                   required>
                            @error('nombre_producto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="help-text">Máximo 50 caracteres</div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="tipo_producto" class="form-label">
                                Tipo
                            </label>
                            <select class="form-select @error('tipo_producto') is-invalid @enderror" 
                                    id="tipo_producto" 
                                    name="tipo_producto">
                                <option value="">Seleccionar...</option>
                                <option value="Comida" {{ old('tipo_producto', $producto->tipo_producto) == 'Comida' ? 'selected' : '' }}>Comida</option>
                                <option value="Bebida" {{ old('tipo_producto', $producto->tipo_producto) == 'Bebida' ? 'selected' : '' }}>Bebida</option>
                                <option value="Postre" {{ old('tipo_producto', $producto->tipo_producto) == 'Postre' ? 'selected' : '' }}>Postre</option>
                                <option value="Acompañamiento" {{ old('tipo_producto', $producto->tipo_producto) == 'Acompañamiento' ? 'selected' : '' }}>Acompañamiento</option>
                            </select>
                            @error('tipo_producto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="id_categoria" class="form-label">
                                Categoría <span class="required">*</span>
                            </label>
                            <select class="form-select @error('id_categoria') is-invalid @enderror" 
                                    id="id_categoria" 
                                    name="id_categoria" 
                                    required>
                                <option value="">Seleccionar categoría...</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id_categoria }}" {{ old('id_categoria', $producto->id_categoria) == $categoria->id_categoria ? 'selected' : '' }}>
                                        {{ $categoria->nombre_categoria }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_categoria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="estado" class="form-label">
                                Estado <span class="required">*</span>
                            </label>
                            <select class="form-select @error('estado') is-invalid @enderror" 
                                    id="estado" 
                                    name="estado" 
                                    required>
                                <option value="Activo" {{ old('estado', $producto->estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
                                <option value="Inactivo" {{ old('estado', $producto->estado) == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="stock" class="form-label">
                                Stock Actual <span class="required">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('stock') is-invalid @enderror" 
                                   id="stock" 
                                   name="stock" 
                                   value="{{ old('stock', $producto->stock) }}" 
                                   min="0"
                                   max="999999"
                                   required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="stock_min" class="form-label">
                                Stock Mínimo
                            </label>
                            <input type="number" 
                                   class="form-control @error('stock_min') is-invalid @enderror" 
                                   id="stock_min" 
                                   name="stock_min" 
                                   value="{{ old('stock_min', $producto->stock_min) }}" 
                                   min="0"
                                   max="999999">
                            @error('stock_min')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="stock_max" class="form-label">
                                Stock Máximo
                            </label>
                            <input type="number" 
                                   class="form-control @error('stock_max') is-invalid @enderror" 
                                   id="stock_max" 
                                   name="stock_max" 
                                   value="{{ old('stock_max', $producto->stock_max) }}" 
                                   min="1"
                                   max="999999">
                            @error('stock_max')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="precio_compra" class="form-label">
                                Precio de Costo
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" 
                                       step="0.01" 
                                       min="0" 
                                       max="99999999.99"
                                       class="form-control @error('precio_compra') is-invalid @enderror" 
                                       id="precio_compra" 
                                       name="precio_compra" 
                                       value="{{ old('precio_compra', $producto->precio_compra) }}" 
                                       placeholder="0.00">
                            </div>
                            @error('precio_compra')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="help-text">Precio de compra</div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="precio_venta" class="form-label">
                                Precio de Venta <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" 
                                       step="0.01" 
                                       min="0" 
                                       max="99999999.99"
                                       class="form-control @error('precio_venta') is-invalid @enderror" 
                                       id="precio_venta" 
                                       name="precio_venta" 
                                       value="{{ old('precio_venta', $producto->precio_venta) }}" 
                                       placeholder="0.00"
                                       required>
                            </div>
                            @error('precio_venta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="help-text">Precio al cliente</div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="fecha_ingreso" class="form-label">
                                Fecha de Ingreso
                            </label>
                            <input type="date" 
                                   class="form-control @error('fecha_ingreso') is-invalid @enderror" 
                                   id="fecha_ingreso" 
                                   name="fecha_ingreso" 
                                   value="{{ old('fecha_ingreso', $producto->fecha_ingreso ? $producto->fecha_ingreso->format('Y-m-d') : '') }}">
                            @error('fecha_ingreso')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Actualizar Plato
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Validación en tiempo real
document.getElementById('nombre_producto').addEventListener('input', function() {
    const value = this.value.trim();
    const maxLength = 50;
    
    if (value.length > maxLength) {
        this.value = value.substring(0, maxLength);
    }
});

// Validar que el stock máximo sea mayor al mínimo
document.getElementById('stock_max').addEventListener('input', function() {
    const maxStock = parseInt(this.value);
    const minStock = parseInt(document.getElementById('stock_min').value);
    
    if (minStock && maxStock <= minStock) {
        this.setCustomValidity('El stock máximo debe ser mayor al stock mínimo');
    } else {
        this.setCustomValidity('');
    }
});

document.getElementById('stock_min').addEventListener('input', function() {
    const minStock = parseInt(this.value);
    const maxStock = parseInt(document.getElementById('stock_max').value);
    
    if (maxStock && minStock >= maxStock) {
        document.getElementById('stock_max').setCustomValidity('El stock máximo debe ser mayor al stock mínimo');
    } else {
        document.getElementById('stock_max').setCustomValidity('');
    }
});

// Validar que el precio de venta sea mayor al de costo
document.getElementById('precio_venta').addEventListener('input', function() {
    const precioVenta = parseFloat(this.value);
    const precioCosto = parseFloat(document.getElementById('precio_compra').value);
    
    if (precioCosto && precioVenta <= precioCosto) {
        this.setCustomValidity('El precio de venta debe ser mayor al precio de costo');
    } else {
        this.setCustomValidity('');
    }
});

document.getElementById('precio_compra').addEventListener('input', function() {
    const precioCosto = parseFloat(this.value);
    const precioVenta = parseFloat(document.getElementById('precio_venta').value);
    
    if (precioVenta && precioCosto >= precioVenta) {
        document.getElementById('precio_venta').setCustomValidity('El precio de venta debe ser mayor al precio de costo');
    } else {
        document.getElementById('precio_venta').setCustomValidity('');
    }
});
</script>
@endsection