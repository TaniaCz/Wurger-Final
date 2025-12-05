@extends('layouts.app')

@section('title', 'Nuevo Pedido - Wurger')
@section('page-title', 'Nuevo Pedido')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-utensils me-2"></i>
                    Nuevo Pedido
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('ventas.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="Fecha_venta" class="form-label">Fecha del Pedido *</label>
                                <input type="date" 
                                       class="form-control @error('Fecha_venta') is-invalid @enderror" 
                                       id="Fecha_venta" 
                                       name="Fecha_venta" 
                                       value="{{ old('Fecha_venta') }}" 
                                       required>
                                @error('Fecha_venta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="Estado_venta" class="form-label">Estado *</label>
                                <select class="form-control @error('Estado_venta') is-invalid @enderror" 
                                        id="Estado_venta" 
                                        name="Estado_venta" 
                                        required>
                                    <option value="">Seleccionar estado...</option>
                                    <option value="Pendiente" {{ old('Estado_venta') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="Pagada" {{ old('Estado_venta') == 'Pagada' ? 'selected' : '' }}>Pagada</option>
                                    <option value="Anulada" {{ old('Estado_venta') == 'Anulada' ? 'selected' : '' }}>Anulada</option>
                                </select>
                                @error('Estado_venta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="Total_venta" class="form-label">Total del Pedido *</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" 
                                           step="0.01" 
                                           min="0" 
                                           max="99999999.99"
                                           class="form-control @error('Total_venta') is-invalid @enderror" 
                                           id="Total_venta" 
                                           name="Total_venta" 
                                           value="{{ old('Total_venta') }}"
                                           placeholder="0.00"
                                           required>
                                    @error('Total_venta')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="id_pedido" class="form-label">Pedido *</label>
                                <select class="form-control @error('id_pedido') is-invalid @enderror" 
                                        id="id_pedido" 
                                        name="id_pedido" 
                                        required>
                                    <option value="">Seleccionar pedido...</option>
                                    @foreach($pedidos as $pedido)
                                        <option value="{{ $pedido->id_pedido }}" {{ old('id_pedido') == $pedido->id_pedido ? 'selected' : '' }}>
                                            Pedido #{{ $pedido->id_pedido }} - {{ $pedido->usuarioInfo->usuario->email ?? 'Sin cliente' }} - {{ $pedido->fecha }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_pedido')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('ventas.index') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-arrow-left me-2"></i>
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-shopping-cart me-2"></i>
                            Crear Venta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Información
                </h6>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    <i class="fas fa-lightbulb me-2"></i>
                    <strong>Consejo:</strong> Selecciona un pedido pendiente y registra la venta con el total correspondiente. El sistema te ayudará a gestionar el estado de la venta.
                </p>
                
                <div class="mt-3">
                    <h6>Estados de la Venta:</h6>
                    <ul class="list-unstyled">
                        <li><span class="badge bg-warning me-2">Pendiente</span> Venta en proceso</li>
                        <li><span class="badge bg-success me-2">Pagada</span> Venta completada y pagada</li>
                        <li><span class="badge bg-danger me-2">Anulada</span> Venta cancelada</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
