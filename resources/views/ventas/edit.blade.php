@extends('layouts.app')

@section('title', 'Editar Pedido - Wurger')
@section('page-title', 'Editar Pedido')

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

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-pagada {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.status-pendiente {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.status-anulada {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}
</style>

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="form-card">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-edit me-3" style="font-size: 1.5rem; color: var(--wurger-primary);"></i>
                <h4 class="mb-0">Editar Pedido #{{ $venta->id_venta }}</h4>
            </div>
            
            <form action="{{ route('ventas.update', $venta->id_venta) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="Fecha_venta" class="form-label">Fecha del Pedido *</label>
                            <input type="date" 
                                   class="form-control @error('Fecha_venta') is-invalid @enderror" 
                                   id="Fecha_venta" 
                                   name="Fecha_venta" 
                                   value="{{ old('Fecha_venta', $venta->Fecha_venta ? $venta->Fecha_venta->format('Y-m-d') : '') }}" 
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
                                <option value="Pendiente" {{ old('Estado_venta', $venta->Estado_venta) == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="Pagada" {{ old('Estado_venta', $venta->Estado_venta) == 'Pagada' ? 'selected' : '' }}>Pagada</option>
                                <option value="Anulada" {{ old('Estado_venta', $venta->Estado_venta) == 'Anulada' ? 'selected' : '' }}>Anulada</option>
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
                                       class="form-control @error('Total_venta') is-invalid @enderror" 
                                       id="Total_venta" 
                                       name="Total_venta" 
                                       value="{{ old('Total_venta', $venta->Total_venta) }}"
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
                            <label for="id_usuario_FK" class="form-label">Empleado Responsable *</label>
                            <select class="form-control @error('id_usuario_FK') is-invalid @enderror" 
                                    id="id_usuario_FK" 
                                    name="id_usuario_FK" 
                                    required>
                                <option value="">Seleccionar empleado...</option>
                                @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->id_usuario }}" {{ old('id_usuario_FK', $venta->id_usuario_FK) == $usuario->id_usuario ? 'selected' : '' }}>
                                        {{ $usuario->Nom_usuario }} {{ $usuario->Apellido_usuario }} - {{ $usuario->rol->Nombre_rol ?? 'Sin rol' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_usuario_FK')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('ventas.show', $venta->id_venta) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Actualizar Pedido
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="form-card">
            <h5 class="mb-3">
                <i class="fas fa-info-circle me-2"></i>
                Información Actual
            </h5>
            
            <div class="mb-3">
                <div class="form-label">Estado Actual</div>
                <div>
                    <span class="status-badge status-{{ strtolower($venta->Estado_venta) }}">
                        {{ $venta->Estado_venta }}
                    </span>
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-label">Total Actual</div>
                <div class="fw-bold text-success">
                    ${{ number_format($venta->Total_venta ?? 0, 2) }}
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-label">Empleado Actual</div>
                <div>
                    {{ $venta->usuario->Nom_usuario ?? 'N/A' }} {{ $venta->usuario->Apellido_usuario ?? '' }}
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-label">Fecha de Creación</div>
                <div>
                    {{ $venta->created_at->format('d/m/Y H:i') }}
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-label">Última Actualización</div>
                <div>
                    {{ $venta->updated_at->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>
        
        <div class="form-card">
            <h5 class="mb-3">
                <i class="fas fa-lightbulb me-2"></i>
                Consejos
            </h5>
            
            <ul class="list-unstyled">
                <li class="mb-2">
                    <i class="fas fa-check text-success me-2"></i>
                    <small>Verifica que el total sea correcto</small>
                </li>
                <li class="mb-2">
                    <i class="fas fa-check text-success me-2"></i>
                    <small>Asigna el empleado correcto</small>
                </li>
                <li class="mb-2">
                    <i class="fas fa-check text-success me-2"></i>
                    <small>Actualiza el estado según corresponda</small>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
