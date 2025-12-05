<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mi Carrito - Wurger</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background: #f8fafc;
        }
        
        .cart-item {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 1rem;
            overflow: hidden;
        }
        
        .cart-item-image {
            width: 80px;
            height: 80px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
        }
        
        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .quantity-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 1px solid #dee2e6;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .quantity-btn:hover {
            background: #e9ecef;
            border-color: #adb5bd;
        }
        
        .quantity-input {
            width: 60px;
            text-align: center;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 0.25rem;
        }
        
        .remove-btn {
            color: #dc3545;
            cursor: pointer;
            transition: color 0.2s;
        }
        
        .remove-btn:hover {
            color: #c82333;
        }
        
        .empty-cart {
            text-align: center;
            padding: 3rem 1rem;
        }
        
        .empty-cart i {
            font-size: 4rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-shopping-cart me-2"></i>Mi Carrito</h2>
                    <a href="{{ route('inicio') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Continuar Comprando
                    </a>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-8">
                <div id="cartContent">
                    @if($carritoItems->count() > 0)
                        @foreach($carritoItems as $item)
                        <div class="cart-item">
                            <div class="row align-items-center p-3">
                                <div class="col-md-2">
                                    <div class="cart-item-image">
                                        <i class="fas fa-box fa-2x"></i>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="mb-1">{{ $item->producto->nombre_producto }}</h6>
                                    <small class="text-muted">
                                        Categoría: {{ $item->producto->categoria->nombre_categoria ?? 'Sin categoría' }}
                                    </small>
                                </div>
                                <div class="col-md-2">
                                    <span class="fw-bold">${{ number_format($item->precio_unitario, 2) }}</span>
                                </div>
                                <div class="col-md-3">
                                    <div class="quantity-controls">
                                        <button class="quantity-btn" onclick="updateQuantity({{ $item->producto_id }}, -1)">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" class="quantity-input" id="qty_{{ $item->producto_id }}" 
                                               value="{{ $item->cantidad }}" min="1" max="{{ $item->producto->stock }}"
                                               onchange="updateQuantity({{ $item->producto_id }}, 0)">
                                        <button class="quantity-btn" onclick="updateQuantity({{ $item->producto_id }}, 1)">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-1 text-end">
                                    <div class="d-flex flex-column align-items-end">
                                        <span class="fw-bold text-primary">${{ number_format($item->subtotal, 2) }}</span>
                                        <i class="fas fa-trash remove-btn" onclick="removeItem({{ $item->producto_id }})" title="Eliminar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="empty-cart">
                            <i class="fas fa-shopping-cart"></i>
                            <h4>Tu carrito está vacío</h4>
                            <p class="text-muted">Agrega algunos productos para comenzar</p>
                            <a href="{{ route('inicio') }}" class="btn btn-primary">
                                <i class="fas fa-shopping-bag me-2"></i>Ir a la Tienda
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Resumen del Pedido</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Items ({{ $itemsCount }}):</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Envío:</span>
                            <span class="text-success">Gratis</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total:</strong>
                            <strong class="text-primary">${{ number_format($total, 2) }}</strong>
                        </div>
                    </div>
                    <div class="card-footer">
                        @if($carritoItems->count() > 0)
                            <button class="btn btn-success w-100 mb-2" onclick="proceedToCheckout()">
                                <i class="fas fa-credit-card me-2"></i>Proceder al Pago
                            </button>
                            <button class="btn btn-outline-danger w-100" onclick="clearCart()">
                                <i class="fas fa-trash me-2"></i>Limpiar Carrito
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Actualizar cantidad
        function updateQuantity(productId, change) {
            const input = document.getElementById(`qty_${productId}`);
            let newQuantity = parseInt(input.value);
            
            if (change !== 0) {
                newQuantity = Math.max(1, Math.min(input.max, newQuantity + change));
                input.value = newQuantity;
            }
            
            // Enviar actualización al servidor
            fetch('/carrito/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    producto_id: productId,
                    cantidad: newQuantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Recargar para mostrar cambios
                } else {
                    alert('Error al actualizar cantidad');
                }
            });
        }

        // Remover item
        function removeItem(productId) {
            if (confirm('¿Estás seguro de que quieres eliminar este producto del carrito?')) {
                fetch('/carrito/remove', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        producto_id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error al eliminar producto');
                    }
                });
            }
        }

        // Limpiar carrito
        function clearCart() {
            if (confirm('¿Estás seguro de que quieres limpiar todo el carrito?')) {
                fetch('/carrito/clear', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error al limpiar carrito');
                    }
                });
            }
        }

        // Proceder al pago
        function proceedToCheckout() {
            alert('Funcionalidad de pago en desarrollo. Próximamente disponible.');
        }
    </script>
</body>
</html>
