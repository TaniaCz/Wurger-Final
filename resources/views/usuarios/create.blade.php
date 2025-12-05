@extends('layouts.app')

@section('title', 'Crear Usuario - Wurger')
@section('page-title', 'Crear Usuario')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user-plus me-2"></i>
                    Nuevo Usuario
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('usuarios.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="Nom_usuario" class="form-label">Nombre *</label>
                                <input type="text" 
                                       class="form-control @error('Nom_usuario') is-invalid @enderror" 
                                       id="Nom_usuario" 
                                       name="Nom_usuario" 
                                       value="{{ old('Nom_usuario') }}" 
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
                                       value="{{ old('Apellido_usuario') }}">
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
                                       value="{{ old('Cedula_usuario') }}" 
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
                                       value="{{ old('Email_usuario') }}" 
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
                                <label for="Password_usuario" class="form-label">Contraseña *</label>
                                <input type="password" 
                                       class="form-control @error('Password_usuario') is-invalid @enderror" 
                                       id="Password_usuario" 
                                       name="Password_usuario" 
                                       required>
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
                                       value="{{ old('Tel_usuario') }}">
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
                                       value="{{ old('Salario_usuario') }}">
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
                                    <option value="M" {{ old('Sexo_usuario') == 'M' ? 'selected' : '' }}>Masculino</option>
                                    <option value="F" {{ old('Sexo_usuario') == 'F' ? 'selected' : '' }}>Femenino</option>
                                    <option value="Otro" {{ old('Sexo_usuario') == 'Otro' ? 'selected' : '' }}>Otro</option>
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
                                    <option value="Activo" {{ old('Estado_usuario') == 'Activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="Inactivo" {{ old('Estado_usuario') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
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
                                       value="{{ old('Fecha_ingreso_usuario') }}">
                                @error('Fecha_ingreso_usuario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="Fecha_nac_usuario" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" 
                                       class="form-control @error('Fecha_nac_usuario') is-invalid @enderror" 
                                       id="Fecha_nac_usuario" 
                                       name="Fecha_nac_usuario" 
                                       value="{{ old('Fecha_nac_usuario') }}">
                                @error('Fecha_nac_usuario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-4">
                        <label for="id_rol_FK" class="form-label">Rol *</label>
                        <select class="form-control @error('id_rol_FK') is-invalid @enderror" 
                                id="id_rol_FK" 
                                name="id_rol_FK" 
                                required>
                            <option value="">Seleccionar rol...</option>
                            @foreach($roles as $rol)
                                <option value="{{ $rol->id_rol }}" {{ old('id_rol_FK') == $rol->id_rol ? 'selected' : '' }}>
                                    {{ $rol->Nombre_rol }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_rol_FK')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-arrow-left me-2"></i>
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Crear Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
