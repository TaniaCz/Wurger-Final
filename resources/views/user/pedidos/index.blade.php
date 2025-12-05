@extends('layouts.app')

@section('title', 'Mis Pedidos - Wurger')
@section('page-title', 'Mis Pedidos')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-shopping-bag me-2"></i>
                    Mis Pedidos
                </h5>
                <a href="{{ route('user.pedidos.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Nuevo Pedido
                </a>
            </div>
            <div class="card-body">
                @if($pedidos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-primary">
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Observaciones</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pedidos as $pedido)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary">#{{ $pedido->id_pedido }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $pedido->fecha->format('d/m/Y') }}</span>
                                        <br>
                                        <small class="text-muted">{{ $pedido->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        @if($pedido->estado == 'Entregado')
                                            <span class="badge bg-success">{{ $pedido->estado }}</span>
                                        @elseif($pedido->estado == 'Pendiente')
                                            <span class="badge bg-warning">{{ $pedido->estado }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $pedido->estado }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($pedido->observaciones)
                                            <span class="text-muted">{{ Str::limit($pedido->observaciones, 50) }}</span>
                                        @else
                                            <span class="text-muted">Sin observaciones</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('user.pedidos.show', $pedido->id_pedido) }}" class="btn btn-sm btn-outline-primary" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Paginación -->
                    <div class="d-flex justify-content-center">
                        {{ $pedidos->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No tienes pedidos registrados</h5>
                        <p class="text-muted">Crea tu primer pedido para comenzar a gestionar tus compras.</p>
                        <a href="{{ route('user.pedidos.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>
                            Crear Primer Pedido
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
