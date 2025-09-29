@extends('layouts.app')

@section('title', 'Nuevo Pedido - Wurger')
@section('page-title', 'Nuevo Pedido')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-utensils me-2"></i>
                    Crear Nuevo Pedido
                </h5>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('user.pedidos.store') }}" id="pedidoForm">
                    @csrf
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="fecha" class="form-label">Fecha del Pedido</label>
                            <input type="date" 
                                   class="form-control @error('fecha') is-invalid @enderror" 
                                   id="fecha" 
                                   name="fecha" 
                                   value="{{ old('fecha', date('Y-m-d')) }}" 
                                   required>
                            @error('fecha')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Selección de Productos -->
                    <div class="mb-4">
                        <h6 class="mb-3">
                            <i class="fas fa-list me-2"></i>
                            Selecciona tus platos favoritos
                        </h6>
                        
                        @if($productos->count() > 0)
                            @foreach($productos as $categoria => $productosCategoria)
                                <div class="mb-4">
                                    <h6 class="text-primary border-bottom pb-2">
                                        <i class="fas fa-tag me-2"></i>
                                        {{ $categoria ?? 'Sin Categoría' }}
                                    </h6>
                                    
                                    <div class="row">
                                        @foreach($productosCategoria as $producto)
                                            <div class="col-md-6 col-lg-4 mb-3">
                                                <div class="card h-100 producto-card">
                                                    <div class="card-body text-center">
                                                        <div class="form-check mb-3">
                                                            <input type="checkbox" 
                                                                   class="form-check-input producto-checkbox" 
                                                                   id="producto_{{ $producto->id_producto }}"
                                                                   value="{{ $producto->id_producto }}"
                                                                   data-nombre="{{ $producto->nombre_producto }}"
                                                                   data-precio="{{ $producto->precio_venta }}"
                                                                   data-stock="{{ $producto->stock }}"
                                                                   onchange="toggleProducto({{ $producto->id_producto }})">
                                                            <label class="form-check-label" for="producto_{{ $producto->id_producto }}">
                                                                <i class="fas fa-plus-circle fa-2x text-muted"></i>
                                                            </label>
                                                        </div>
                                                        
                                                        <h6 class="card-title">{{ $producto->nombre_producto }}</h6>
                                                        <p class="text-success fw-bold mb-2">${{ number_format($producto->precio_venta, 2) }}</p>
                                                        <small class="text-muted mb-3 d-block">
                                                            Stock: {{ $producto->stock }}
                                                        </small>
                                                        
                                                        <!-- Selector de cantidad -->
                                                        <div class="cantidad-selector" id="cantidad_{{ $producto->id_producto }}" style="display: none;">
                                                            <label class="form-label small">Cantidad:</label>
                                                            <div class="input-group input-group-sm">
                                                                <button type="button" class="btn btn-outline-secondary" onclick="decrementarCantidad({{ $producto->id_producto }})">
                                                                    <i class="fas fa-minus"></i>
                                                                </button>
                                                                <input type="number" 
                                                                       class="form-control text-center cantidad-input" 
                                                                       id="input_cantidad_{{ $producto->id_producto }}"
                                                                       name="cantidades[{{ $producto->id_producto }}]"
                                                                       value="1" 
                                                                       min="1" 
                                                                       max="{{ $producto->stock }}"
                                                                       readonly>
                                                                <button type="button" class="btn btn-outline-secondary" onclick="incrementarCantidad({{ $producto->id_producto }})">
                                                                    <i class="fas fa-plus"></i>
                                                                </button>
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
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                No hay productos disponibles en este momento.
                            </div>
                        @endif
                    </div>

                    <!-- Resumen del Pedido -->
                    <div class="mb-4" id="resumenPedido" style="display: none;">
                        <div class="card bg-light">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="fas fa-shopping-cart me-2"></i>
                                    Resumen del Pedido
                                </h6>
                            </div>
                            <div class="card-body">
                                <div id="listaProductos"></div>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong>Total:</strong>
                                    <strong class="text-primary" id="totalPedido">$0.00</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                  id="observaciones" 
                                  name="observaciones" 
                                  rows="3" 
                                  placeholder="Agrega comentarios especiales para tu pedido...">{{ old('observaciones') }}</textarea>
                        @error('observaciones')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('user.pedidos.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary" id="btnCrearPedido" disabled>
                            <i class="fas fa-save me-1"></i>
                            Crear Pedido
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.producto-card {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.producto-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.producto-card.selected {
    border-color: #0d6efd;
    background-color: #f8f9ff;
}

.producto-checkbox:checked + label i {
    color: #0d6efd !important;
}

.cantidad-selector {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #e9ecef;
}

.cantidad-selector .input-group {
    max-width: 120px;
    margin: 0 auto;
}

.cantidad-input {
    border-left: 0;
    border-right: 0;
}

.btn-outline-secondary {
    border-color: #6c757d;
    color: #6c757d;
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    border-color: #6c757d;
    color: white;
}

.producto-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #dee2e6;
}

.producto-item:last-child {
    border-bottom: none;
}
</style>

<script>
let productosSeleccionados = {};
let totalPedido = 0;

function toggleProducto(productoId) {
    const checkbox = document.getElementById(`producto_${productoId}`);
    const cantidadSelector = document.getElementById(`cantidad_${productoId}`);
    const cantidadInput = document.getElementById(`input_cantidad_${productoId}`);
    const card = checkbox.closest('.producto-card');
    
    if (checkbox.checked) {
        // Seleccionar producto
        card.classList.add('selected');
        cantidadSelector.style.display = 'block';
        
        // Agregar a la lista
        const nombre = checkbox.dataset.nombre;
        const precio = parseFloat(checkbox.dataset.precio);
        const stock = parseInt(checkbox.dataset.stock);
        
        productosSeleccionados[productoId] = {
            id: productoId,
            nombre: nombre,
            precio: precio,
            cantidad: 1,
            stock: stock
        };
        
        cantidadInput.value = 1;
    } else {
        // Deseleccionar producto
        card.classList.remove('selected');
        cantidadSelector.style.display = 'none';
        
        // Remover de la lista
        delete productosSeleccionados[productoId];
    }
    
    actualizarResumen();
}

function incrementarCantidad(productoId) {
    const cantidadInput = document.getElementById(`input_cantidad_${productoId}`);
    const producto = productosSeleccionados[productoId];
    
    if (!producto) return;
    
    let cantidad = parseInt(cantidadInput.value);
    
    if (cantidad < producto.stock) {
        cantidad++;
        cantidadInput.value = cantidad;
        producto.cantidad = cantidad;
        actualizarResumen();
    }
}

function decrementarCantidad(productoId) {
    const cantidadInput = document.getElementById(`input_cantidad_${productoId}`);
    const producto = productosSeleccionados[productoId];
    
    if (!producto) return;
    
    let cantidad = parseInt(cantidadInput.value);
    
    if (cantidad > 1) {
        cantidad--;
        cantidadInput.value = cantidad;
        producto.cantidad = cantidad;
        actualizarResumen();
    }
}

function actualizarResumen() {
    const resumenDiv = document.getElementById('resumenPedido');
    const listaDiv = document.getElementById('listaProductos');
    const totalDiv = document.getElementById('totalPedido');
    const btnCrear = document.getElementById('btnCrearPedido');
    
    const productosArray = Object.values(productosSeleccionados);
    
    if (productosArray.length === 0) {
        resumenDiv.style.display = 'none';
        btnCrear.disabled = true;
        return;
    }
    
    resumenDiv.style.display = 'block';
    btnCrear.disabled = false;
    
    // Calcular total
    totalPedido = productosArray.reduce((sum, producto) => sum + (producto.precio * producto.cantidad), 0);
    
    // Mostrar lista
    listaDiv.innerHTML = productosArray.map(producto => {
        const subtotal = producto.precio * producto.cantidad;
        return `
            <div class="producto-item">
                <div>
                    <span class="fw-bold">${producto.nombre}</span>
                    <br>
                    <small class="text-muted">Cantidad: ${producto.cantidad} × $${producto.precio.toFixed(2)}</small>
                </div>
                <span class="text-primary fw-bold">$${subtotal.toFixed(2)}</span>
            </div>
        `;
    }).join('');
    
    totalDiv.textContent = `$${totalPedido.toFixed(2)}`;
}

// Validar formulario antes de enviar
document.getElementById('pedidoForm').addEventListener('submit', function(e) {
    const productosArray = Object.values(productosSeleccionados);
    
    if (productosArray.length === 0) {
        e.preventDefault();
        alert('Por favor selecciona al menos un producto.');
        return false;
    }
    
    // Agregar productos seleccionados como campos ocultos
    productosArray.forEach(producto => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'productos[]';
        input.value = producto.id;
        this.appendChild(input);
    });
});
</script>
@endsection