@extends('layouts.app')

@section('title', 'Editar Usuario - Wurger')
@section('page-title', 'Editar Usuario')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user-edit me-2"></i>
                    Editar Usuario
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('usuarios.update', $usuario->id_usuario) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="Nom_usuario" class="form-label">Nombre *</label>
                                <input type="text" 
                                       class="form-control @error('Nom_usuario') is-invalid @enderror" 
                                       id="Nom_usuario" 
                                       name="Nom_usuario" 
                                       value="{{ old('Nom_usuario', $usuario->Nom_usuario) }}" 
                                       required>
                                @error('Nom_usuario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="Apellido_usuario" class="form-label">Apellido</label>
                                <input type="text" 
                                       class="form-control @error('Apellido_usuario') is-invalid @enderror" 
                                       id="Apellido_usuario" 
                                       name="Apellido_usuario" 
                                       value="{{ old('Apellido_usuario', $usuario->Apellido_usuario) }}">
                                @error('Apellido_usuario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="Cedula_usuario" class="form-label">Cédula *</label>
                                <input type="text" 
                                       class="form-control @error('Cedula_usuario') is-invalid @enderror" 
                                       id="Cedula_usuario" 
                                       name="Cedula_usuario" 
                                       value="{{ old('Cedula_usuario', $usuario->Cedula_usuario) }}" 
                                       required>
                                @error('Cedula_usuario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="Email_usuario" class="form-label">Email *</label>
                                <input type="email" 
                                       class="form-control @error('Email_usuario') is-invalid @enderror" 
                                       id="Email_usuario" 
                                       name="Email_usuario" 
                                       value="{{ old('Email_usuario', $usuario->Email_usuario) }}" 
                                       required>
                                @error('Email_usuario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="Password_usuario" class="form-label">Nueva Contraseña</label>
                                <input type="password" 
                                       class="form-control @error('Password_usuario') is-invalid @enderror" 
                                       id="Password_usuario" 
                                       name="Password_usuario"
                                       placeholder="Dejar vacío para mantener la actual">
                                @error('Password_usuario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="Tel_usuario" class="form-label">Teléfono</label>
                                <input type="text" 
                                       class="form-control @error('Tel_usuario') is-invalid @enderror" 
                                       id="Tel_usuario" 
                                       name="Tel_usuario" 
                                       value="{{ old('Tel_usuario', $usuario->Tel_usuario) }}">
                                @error('Tel_usuario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="Salario_usuario" class="form-label">Salario</label>
                                <input type="number" 
                                       step="0.01" 
                                       class="form-control @error('Salario_usuario') is-invalid @enderror" 
                                       id="Salario_usuario" 
                                       name="Salario_usuario" 
                                       value="{{ old('Salario_usuario', $usuario->Salario_usuario) }}">
                                @error('Salario_usuario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="Sexo_usuario" class="form-label">Sexo</label>
                                <select class="form-control @error('Sexo_usuario') is-invalid @enderror" 
                                        id="Sexo_usuario" 
                                        name="Sexo_usuario">
                                    <option value="">Seleccionar...</option>
                                    <option value="M" {{ old('Sexo_usuario', $usuario->Sexo_usuario) == 'M' ? 'selected' : '' }}>Masculino</option>
                                    <option value="F" {{ old('Sexo_usuario', $usuario->Sexo_usuario) == 'F' ? 'selected' : '' }}>Femenino</option>
                                    <option value="Otro" {{ old('Sexo_usuario', $usuario->Sexo_usuario) == 'Otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                @error('Sexo_usuario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="Estado_usuario" class="form-label">Estado *</label>
                                <select class="form-control @error('Estado_usuario') is-invalid @enderror" 
                                        id="Estado_usuario" 
                                        name="Estado_usuario" 
                                        required>
                                    <option value="">Seleccionar...</option>
                                    <option value="Activo" {{ old('Estado_usuario', $usuario->Estado_usuario) == 'Activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="Inactivo" {{ old('Estado_usuario', $usuario->Estado_usuario) == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                                @error('Estado_usuario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="Fecha_ingreso_usuario" class="form-label">Fecha de Ingreso</label>
                                <input type="date" 
                                       class="form-control @error('Fecha_ingreso_usuario') is-invalid @enderror" 
                                       id="Fecha_ingreso_usuario" 
                                       name="Fecha_ingreso_usuario" 
                                       value="{{ old('Fecha_ingreso_usuario', $usuario->Fecha_ingreso_usuario ? $usuario->Fecha_ingreso_usuario->format('Y-m-d') : '') }}">
                                @error('Fecha_ingreso_usuario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="form-group mb-4">
                        <label for="rol" class="form-label">Rol</label>
                        <input type="text" 
                               class="form-control" 
                               id="rol" 
                               value="{{ $usuario->rol }}" 
                               readonly
                               style="background-color: #f8f9fa; cursor: not-allowed;">
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            El rol no se puede modificar por seguridad
                        </small>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-arrow-left me-2"></i>
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Actualizar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
