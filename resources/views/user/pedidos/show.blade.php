@extends('layouts.app')

@section('title', 'Detalles del Pedido - Wurger')
@section('page-title', 'Detalles del Pedido')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-shopping-bag me-2"></i>
                    Pedido #{{ $pedido->id_pedido }}
                </h5>
                <div>
                    @if($pedido->estado == 'Entregado')
                        <span class="badge bg-success fs-6">{{ $pedido->estado }}</span>
                    @elseif($pedido->estado == 'Pendiente')
                        <span class="badge bg-warning fs-6">{{ $pedido->estado }}</span>
                    @else
                        <span class="badge bg-danger fs-6">{{ $pedido->estado }}</span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">Información del Pedido</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>ID del Pedido:</strong></td>
                                <td>#{{ $pedido->id_pedido }}</td>
                            </tr>
                            <tr>
                                <td><strong>Fecha:</strong></td>
                                <td>{{ $pedido->fecha->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Estado:</strong></td>
                                <td>
                                    @if($pedido->estado == 'Entregado')
                                        <span class="badge bg-success">{{ $pedido->estado }}</span>
                                    @elseif($pedido->estado == 'Pendiente')
                                        <span class="badge bg-warning">{{ $pedido->estado }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $pedido->estado }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Creado:</strong></td>
                                <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">Observaciones</h6>
                        @if($pedido->observaciones)
                            <div class="alert alert-light">
                                <p class="mb-0">{{ $pedido->observaciones }}</p>
                            </div>
                        @else
                            <p class="text-muted">Sin observaciones</p>
                        @endif
                    </div>
                </div>

                <hr>

                <!-- Productos del Pedido -->
                @if($pedido->pedidoProductos->count() > 0)
                    <h6 class="text-muted mb-3">
                        <i class="fas fa-shopping-cart me-2"></i>
                        Productos del Pedido
                    </h6>
                    
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Producto</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-end">Precio Unit.</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalPedido = 0; @endphp
                                @foreach($pedido->pedidoProductos as $pedidoProducto)
                                    @php $totalPedido += $pedidoProducto->subtotal; @endphp
                                    <tr>
                                        <td>
                                            <strong>{{ $pedidoProducto->producto->nombre_producto }}</strong>
                                            @if($pedidoProducto->producto->categoria)
                                                <br><small class="text-muted">{{ $pedidoProducto->producto->categoria->nombre_categoria }}</small>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">{{ $pedidoProducto->cantidad }}</span>
                                        </td>
                                        <td class="text-end">${{ number_format($pedidoProducto->precio_unitario, 2) }}</td>
                                        <td class="text-end">
                                            <strong>${{ number_format($pedidoProducto->subtotal, 2) }}</strong>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="3" class="text-end">Total del Pedido:</th>
                                    <th class="text-end text-primary">${{ number_format($totalPedido, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <hr>
                @endif

                <div class="d-flex justify-content-between">
                    <a href="{{ route('user.pedidos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Volver a Mis Pedidos
                    </a>
                    <div>
                        <a href="{{ route('user.pedidos.index') }}" class="btn btn-primary">
                            <i class="fas fa-list me-1"></i>
                            Ver Todos los Pedidos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
