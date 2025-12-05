@extends('layouts.app')

@section('title', 'Nuevo Plato - Wurger')
@section('page-title', 'Nuevo Plato')

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

.price-input-group {
    position: relative;
}

.price-input-group .input-group-text {
    background: #f8fafc;
    border: 1px solid #d1d5db;
    border-right: none;
    border-radius: 12px 0 0 12px;
}

.price-input-group .form-control {
    border-left: none;
    border-radius: 0 12px 12px 0;
}

.stock-info {
    background: rgba(59, 130, 246, 0.05);
    border: 1px solid rgba(59, 130, 246, 0.1);
    border-radius: 12px;
    padding: 1rem;
    margin-top: 1rem;
}

.stock-info h6 {
    color: var(--wurger-primary);
    margin-bottom: 0.5rem;
}

.stock-info small {
    color: #6b7280;
}
</style>

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="form-card">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-utensils me-3" style="font-size: 1.5rem; color: var(--wurger-primary);"></i>
                <h4 class="mb-0">Registrar Nuevo Plato</h4>
            </div>
            
            <form action="{{ route('productos.store') }}" method="POST">
                @csrf
                
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
                                   value="{{ old('nombre_producto') }}" 
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
                            <label for="Tipo_producto" class="form-label">
                                Tipo <span class="required">*</span>
                            </label>
                            <select class="form-select @error('Tipo_producto') is-invalid @enderror" 
                                    id="Tipo_producto" 
                                    name="Tipo_producto" 
                                    required>
                                <option value="">Seleccionar...</option>
                                <option value="Comida" {{ old('Tipo_producto') == 'Comida' ? 'selected' : '' }}>Comida</option>
                                <option value="Bebida" {{ old('Tipo_producto') == 'Bebida' ? 'selected' : '' }}>Bebida</option>
                                <option value="Postre" {{ old('Tipo_producto') == 'Postre' ? 'selected' : '' }}>Postre</option>
                                <option value="Acompañamiento" {{ old('Tipo_producto') == 'Acompañamiento' ? 'selected' : '' }}>Acompañamiento</option>
                            </select>
                            @error('Tipo_producto')
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
                                    <option value="{{ $categoria->id_categoria }}" {{ old('id_categoria') == $categoria->id_categoria ? 'selected' : '' }}>
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
                                <option value="">Seleccionar...</option>
                                <option value="Activo" {{ old('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
                                <option value="Inactivo" {{ old('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
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
                                Stock Inicial <span class="required">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('stock') is-invalid @enderror" 
                                   id="stock" 
                                   name="stock" 
                                   value="{{ old('stock', 0) }}" 
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
                            <label for="Stock_min_producto" class="form-label">
                                Stock Mínimo <span class="required">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('Stock_min_producto') is-invalid @enderror" 
                                   id="Stock_min_producto" 
                                   name="Stock_min_producto" 
                                   value="{{ old('Stock_min_producto', 5) }}" 
                                   min="0"
                                   required>
                            @error('Stock_min_producto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="Stock_max_producto" class="form-label">
                                Stock Máximo <span class="required">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('Stock_max_producto') is-invalid @enderror" 
                                   id="Stock_max_producto" 
                                   name="Stock_max_producto" 
                                   value="{{ old('Stock_max_producto', 100) }}" 
                                   min="1"
                                   required>
                            @error('Stock_max_producto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="Precio_recibimiento" class="form-label">
                                Precio de Costo <span class="required">*</span>
                            </label>
                            <div class="price-input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" 
                                       step="0.01" 
                                       min="0" 
                                       max="99999999.99"
                                       class="form-control @error('Precio_recibimiento') is-invalid @enderror" 
                                       id="Precio_recibimiento" 
                                       name="Precio_recibimiento" 
                                       value="{{ old('Precio_recibimiento') }}" 
                                       placeholder="0.00"
                                       required>
                            </div>
                            @error('Precio_recibimiento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="help-text">Costo de ingredientes</div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="precio_venta" class="form-label">
                                Precio de Venta <span class="required">*</span>
                            </label>
                            <div class="price-input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" 
                                       step="0.01" 
                                       min="0" 
                                       max="99999999.99"
                                       class="form-control @error('precio_venta') is-invalid @enderror" 
                                       id="precio_venta" 
                                       name="precio_venta" 
                                       value="{{ old('precio_venta') }}" 
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
                
                <div class="form-group mb-3">
                    <label for="Fecha_ingreso_producto" class="form-label">
                        Fecha de Ingreso <span class="required">*</span>
                    </label>
                    <input type="date" 
                           class="form-control @error('Fecha_ingreso_producto') is-invalid @enderror" 
                           id="Fecha_ingreso_producto" 
                           name="Fecha_ingreso_producto" 
                           value="{{ old('Fecha_ingreso_producto', date('Y-m-d')) }}" 
                           required>
                    @error('Fecha_ingreso_producto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Registrar Plato
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Información de Stock -->
        <div class="form-card">
            <h5 class="mb-3">
                <i class="fas fa-info-circle me-2"></i>
                Configuración de Stock
            </h5>
            
            <div class="stock-info">
                <h6>Stock Mínimo</h6>
                <small>Cuando el stock llegue a este nivel, se generará una alerta para reabastecer.</small>
            </div>
            
            <div class="stock-info">
                <h6>Stock Máximo</h6>
                <small>Límite superior para evitar sobreabastecimiento y desperdicio.</small>
            </div>
            
            <div class="stock-info">
                <h6>Stock Inicial</h6>
                <small>Cantidad con la que comienza el plato en el inventario.</small>
            </div>
        </div>
        
        <!-- Información de Precios -->
        <div class="form-card">
            <h5 class="mb-3">
                <i class="fas fa-dollar-sign me-2"></i>
                Configuración de Precios
            </h5>
            
            <div class="mb-3">
                <div class="form-label">Precio de Costo</div>
                <small class="text-muted">Costo de los ingredientes y preparación</small>
            </div>
            
            <div class="mb-3">
                <div class="form-label">Precio de Venta</div>
                <small class="text-muted">Precio que paga el cliente</small>
            </div>
            
            <div class="alert alert-info">
                <i class="fas fa-lightbulb me-2"></i>
                <small>
                    <strong>Consejo:</strong> El margen de ganancia se calcula automáticamente.
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
                    <div class="fw-bold text-primary">{{ \App\Models\Producto::count() }}</div>
                    <small class="text-muted">Platos Totales</small>
                </div>
                <div class="col-6">
                    <div class="fw-bold text-success">{{ \App\Models\Producto::where('estado', 'Activo')->count() }}</div>
                    <small class="text-muted">Activos</small>
                </div>
            </div>
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
document.getElementById('Stock_max_producto').addEventListener('input', function() {
    const maxStock = parseInt(this.value);
    const minStock = parseInt(document.getElementById('Stock_min_producto').value);
    
    if (maxStock <= minStock) {
        this.setCustomValidity('El stock máximo debe ser mayor al stock mínimo');
    } else {
        this.setCustomValidity('');
    }
});

document.getElementById('Stock_min_producto').addEventListener('input', function() {
    const minStock = parseInt(this.value);
    const maxStock = parseInt(document.getElementById('Stock_max_producto').value);
    
    if (maxStock <= minStock) {
        document.getElementById('Stock_max_producto').setCustomValidity('El stock máximo debe ser mayor al stock mínimo');
    } else {
        document.getElementById('Stock_max_producto').setCustomValidity('');
    }
});

// Validar que el precio de venta sea mayor al de costo
document.getElementById('precio_venta').addEventListener('input', function() {
    const precioVenta = parseFloat(this.value);
    const precioCosto = parseFloat(document.getElementById('Precio_recibimiento').value);
    
    if (precioVenta <= precioCosto) {
        this.setCustomValidity('El precio de venta debe ser mayor al precio de costo');
    } else {
        this.setCustomValidity('');
    }
});

document.getElementById('Precio_recibimiento').addEventListener('input', function() {
    const precioCosto = parseFloat(this.value);
    const precioVenta = parseFloat(document.getElementById('precio_venta').value);
    
    if (precioVenta <= precioCosto) {
        document.getElementById('precio_venta').setCustomValidity('El precio de venta debe ser mayor al precio de costo');
    } else {
        document.getElementById('precio_venta').setCustomValidity('');
    }
});
</script>
@endsection