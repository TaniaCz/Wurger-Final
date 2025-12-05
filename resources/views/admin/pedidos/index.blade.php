@extends('layouts.app')

@section('title', 'Gestión de Pedidos - Wurger')
@section('page-title', 'Gestión de Pedidos')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-shopping-bag me-2"></i>
                    Lista de Pedidos
                </h5>
            </div>
            <div class="card-body">
                @if($pedidos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-primary">
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
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
                                        <div>
                                            <strong>{{ $pedido->usuarioInfo->nombre ?? 'N/A' }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $pedido->usuarioInfo->usuario->email ?? '' }}</small>
                                        </div>
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
                                            @if($pedido->estado == 'Pendiente')
                                                <form action="{{ route('user.pedidos.update', $pedido->id_pedido) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="estado" value="Entregado">
                                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Marcar como entregado">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
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
                        <h5 class="text-muted">No hay pedidos registrados</h5>
                        <p class="text-muted">Los pedidos aparecerán aquí cuando los usuarios los realicen.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
