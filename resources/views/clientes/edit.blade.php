@extends('layouts.app')

@section('title', 'Editar Cliente - Wurger')
@section('page-title', 'Editar Cliente')

<style>
.form-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.cliente-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: var(--wurger-gradient);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 700;
    margin-right: 1rem;
    border: 3px solid rgba(255, 255, 255, 0.3);
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

.help-text {
    font-size: 0.875rem;
    color: #6b7280;
    margin-top: 0.25rem;
}

.required {
    color: #ef4444;
}

.section-title {
    color: #374151;
    font-weight: 700;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e5e7eb;
}

.info-card {
    background: rgba(59, 130, 246, 0.05);
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 1.5rem;
}

.info-icon {
    color: #3b82f6;
    margin-right: 0.5rem;
}

.password-toggle {
    position: relative;
}

.password-toggle .form-control {
    padding-right: 3rem;
}

.password-toggle-btn {
    position: absolute;
    right: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #6b7280;
    cursor: pointer;
    z-index: 10;
}

.password-toggle-btn:hover {
    color: #374151;
}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="form-card">
                <div class="d-flex align-items-center mb-4">
                    <div class="cliente-avatar">
                        {{ substr($cliente->nombre, 0, 1) }}
                    </div>
                    <div>
                        <h4 class="mb-0">Editar Cliente</h4>
                        <p class="text-muted mb-0">Actualizar información de {{ $cliente->nombre }}</p>
                    </div>
                </div>

                <div class="info-card">
                    <h5 class="mb-2">
                        <i class="fas fa-info-circle info-icon"></i>
                        Información del Cliente
                    </h5>
                    <p class="mb-0 text-muted">
                        Modifique los campos necesarios. Deje la contraseña en blanco si no desea cambiarla.
                    </p>
                </div>

                <form action="{{ route('clientes.update', $cliente->id_usuario_info) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Información Personal -->
                    <div class="mb-4">
                        <h6 class="section-title">
                            <i class="fas fa-user me-2"></i>
                            Información Personal
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">
                                    Nombre Completo <span class="required">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('nombre') is-invalid @enderror" 
                                       id="nombre" 
                                       name="nombre" 
                                       value="{{ old('nombre', $cliente->nombre) }}" 
                                       placeholder="Ej: Juan Pérez"
                                       required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="help-text">Nombre completo del cliente</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" 
                                       class="form-control @error('telefono') is-invalid @enderror" 
                                       id="telefono" 
                                       name="telefono" 
                                       value="{{ old('telefono', $cliente->telefono) }}" 
                                       placeholder="Ej: +1 234 567 8900">
                                @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="help-text">Número de teléfono (opcional)</div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <textarea class="form-control @error('direccion') is-invalid @enderror" 
                                          id="direccion" 
                                          name="direccion" 
                                          rows="3" 
                                          placeholder="Ej: Calle 123, Ciudad, País">{{ old('direccion', $cliente->direccion) }}</textarea>
                                @error('direccion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="help-text">Dirección completa (opcional)</div>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Acceso -->
                    <div class="mb-4">
                        <h6 class="section-title">
                            <i class="fas fa-key me-2"></i>
                            Información de Acceso
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    Email <span class="required">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $cliente->usuario->email) }}" 
                                       placeholder="Ej: cliente@ejemplo.com"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="help-text">Email único para acceder al sistema</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Nueva Contraseña</label>
                                <div class="password-toggle">
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Dejar en blanco para no cambiar">
                                    <button type="button" class="password-toggle-btn" onclick="togglePassword()">
                                        <i class="fas fa-eye" id="password-icon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="help-text">Dejar en blanco para mantener la contraseña actual</div>
                            </div>
                        </div>
                    </div>

                    <!-- Estado del Cliente -->
                    <div class="mb-4">
                        <h6 class="section-title">
                            <i class="fas fa-toggle-on me-2"></i>
                            Estado del Cliente
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="estado" class="form-label">
                                    Estado <span class="required">*</span>
                                </label>
                                <select class="form-control @error('estado') is-invalid @enderror" 
                                        id="estado" 
                                        name="estado" 
                                        required>
                                    <option value="">Seleccionar estado</option>
                                    <option value="Activo" {{ old('estado', $cliente->usuario->estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="Inactivo" {{ old('estado', $cliente->usuario->estado) == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="help-text">Estado del cliente en el sistema</div>
                            </div>
                        </div>
                    </div>

                    <!-- Información del Sistema -->
                    <div class="mb-4">
                        <h6 class="section-title">
                            <i class="fas fa-info-circle me-2"></i>
                            Información del Sistema
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">ID del Cliente</label>
                                <input type="text" class="form-control" value="#{{ $cliente->id_usuario_info }}" readonly>
                                <div class="help-text">Identificador único del cliente</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fecha de Registro</label>
                                <input type="text" class="form-control" value="{{ $cliente->created_at->format('d/m/Y H:i:s') }}" readonly>
                                <div class="help-text">Fecha de creación del cliente</div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('clientes.show', $cliente->id_usuario_info) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Actualizar Cliente
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Panel de Ayuda -->
        <div class="col-lg-4">
            <div class="form-card">
                <h5 class="mb-3">
                    <i class="fas fa-question-circle me-2"></i>
                    Ayuda
                </h5>
                
                <div class="mb-3">
                    <h6 class="text-primary">Campos Obligatorios</h6>
                    <ul class="list-unstyled small text-muted">
                        <li><i class="fas fa-check text-success me-1"></i> Nombre completo</li>
                        <li><i class="fas fa-check text-success me-1"></i> Email único</li>
                        <li><i class="fas fa-check text-success me-1"></i> Estado del cliente</li>
                    </ul>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-primary">Campos Opcionales</h6>
                    <ul class="list-unstyled small text-muted">
                        <li><i class="fas fa-phone text-info me-1"></i> Teléfono</li>
                        <li><i class="fas fa-map-marker-alt text-info me-1"></i> Dirección</li>
                        <li><i class="fas fa-key text-info me-1"></i> Nueva contraseña</li>
                    </ul>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-primary">Información Importante</h6>
                    <ul class="list-unstyled small text-muted">
                        <li><i class="fas fa-info text-warning me-1"></i> El cliente mantendrá su rol de "Usuario"</li>
                        <li><i class="fas fa-info text-warning me-1"></i> Si cambia el email, deberá usarlo para acceder</li>
                        <li><i class="fas fa-info text-warning me-1"></i> Si no cambia la contraseña, mantendrá la actual</li>
                        <li><i class="fas fa-info text-warning me-1"></i> Los cambios se aplicarán inmediatamente</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle para mostrar/ocultar contraseña
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const passwordIcon = document.getElementById('password-icon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordIcon.classList.remove('fa-eye');
        passwordIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        passwordIcon.classList.remove('fa-eye-slash');
        passwordIcon.classList.add('fa-eye');
    }
}

// Validación en tiempo real
document.getElementById('email').addEventListener('blur', function() {
    const email = this.value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (email && !emailRegex.test(email)) {
        this.classList.add('is-invalid');
        if (!this.nextElementSibling.classList.contains('invalid-feedback')) {
            const feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            feedback.textContent = 'El formato del email no es válido.';
            this.parentNode.insertBefore(feedback, this.nextElementSibling);
        }
    } else {
        this.classList.remove('is-invalid');
        const feedback = this.parentNode.querySelector('.invalid-feedback');
        if (feedback) {
            feedback.remove();
        }
    }
});

document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    
    if (password.length > 0 && password.length < 6) {
        this.classList.add('is-invalid');
        if (!this.nextElementSibling.classList.contains('invalid-feedback')) {
            const feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            feedback.textContent = 'La contraseña debe tener al menos 6 caracteres.';
            this.parentNode.insertBefore(feedback, this.nextElementSibling);
        }
    } else {
        this.classList.remove('is-invalid');
        const feedback = this.parentNode.querySelector('.invalid-feedback');
        if (feedback) {
            feedback.remove();
        }
    }
});
</script>
@endsection