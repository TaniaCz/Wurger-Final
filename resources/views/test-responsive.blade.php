@extends('layouts.app')

@section('title', 'Test Responsive - Wurger')

@section('content')
<div class="container-responsive">
    <div class="page-header">
        <h1 class="page-title">Test de Diseño Responsive</h1>
        <p class="page-subtitle">Verificando la adaptabilidad en diferentes dispositivos</p>
    </div>

    <!-- Test Grid -->
    <div class="responsive-grid mb-4">
        <div class="card-responsive">
            <h3>Card 1</h3>
            <p class="text-responsive">Este es un ejemplo de contenido que se adapta a diferentes tamaños de pantalla.</p>
            <button class="btn btn-primary btn-responsive">Botón Responsive</button>
        </div>
        
        <div class="card-responsive">
            <h3>Card 2</h3>
            <p class="text-responsive">El diseño se ajusta automáticamente para móviles, tablets y escritorio.</p>
            <button class="btn btn-success btn-responsive">Otro Botón</button>
        </div>
        
        <div class="card-responsive">
            <h3>Card 3</h3>
            <p class="text-responsive">Los elementos se reorganizan según el espacio disponible.</p>
            <button class="btn btn-warning btn-responsive">Tercer Botón</button>
        </div>
    </div>

    <!-- Test Form -->
    <div class="card-responsive mb-4">
        <h3>Formulario Responsive</h3>
        <form class="form-responsive">
            <div class="form-group-responsive">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" class="form-control form-control-responsive" placeholder="Tu nombre">
            </div>
            
            <div class="form-group-responsive">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" class="form-control form-control-responsive" placeholder="tu@email.com">
            </div>
            
            <div class="form-group-responsive">
                <label for="mensaje" class="form-label">Mensaje:</label>
                <textarea id="mensaje" class="form-control form-control-responsive" rows="4" placeholder="Tu mensaje"></textarea>
            </div>
            
            <div class="flex-mobile-wrap">
                <button type="submit" class="btn btn-primary btn-responsive">Enviar</button>
                <button type="reset" class="btn btn-secondary btn-responsive">Limpiar</button>
            </div>
        </form>
    </div>

    <!-- Test Table -->
    <div class="card-responsive mb-4">
        <h3>Tabla Responsive</h3>
        <div class="table-responsive-wrapper">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Juan Pérez</td>
                        <td>juan@email.com</td>
                        <td><span class="badge bg-success">Activo</span></td>
                        <td>
                            <button class="btn btn-sm btn-primary">Editar</button>
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>María García</td>
                        <td>maria@email.com</td>
                        <td><span class="badge bg-warning">Pendiente</span></td>
                        <td>
                            <button class="btn btn-sm btn-primary">Editar</button>
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Carlos López</td>
                        <td>carlos@email.com</td>
                        <td><span class="badge bg-success">Activo</span></td>
                        <td>
                            <button class="btn btn-sm btn-primary">Editar</button>
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Test Navigation -->
    <div class="card-responsive mb-4">
        <h3>Navegación Responsive</h3>
        <nav class="nav-responsive">
            <div class="nav-brand">
                <strong>Wurger</strong>
            </div>
            <ul class="nav-menu-responsive">
                <li><a href="#" class="nav-link">Inicio</a></li>
                <li><a href="#" class="nav-link">Productos</a></li>
                <li><a href="#" class="nav-link">Ventas</a></li>
                <li><a href="#" class="nav-link">Reportes</a></li>
            </ul>
        </nav>
    </div>

    <!-- Test Buttons -->
    <div class="card-responsive mb-4">
        <h3>Botones Responsive</h3>
        <div class="flex-mobile-wrap gap-2">
            <button class="btn btn-primary btn-responsive">Primario</button>
            <button class="btn btn-secondary btn-responsive">Secundario</button>
            <button class="btn btn-success btn-responsive">Éxito</button>
            <button class="btn btn-warning btn-responsive">Advertencia</button>
            <button class="btn btn-danger btn-responsive">Peligro</button>
        </div>
    </div>

    <!-- Test Visibility -->
    <div class="card-responsive mb-4">
        <h3>Visibilidad Responsive</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="alert alert-info hide-mobile">
                    <strong>Visible en escritorio:</strong> Este mensaje solo se muestra en pantallas grandes.
                </div>
            </div>
            <div class="col-md-6">
                <div class="alert alert-warning show-mobile">
                    <strong>Visible en móvil:</strong> Este mensaje solo se muestra en dispositivos móviles.
                </div>
            </div>
        </div>
    </div>

    <!-- Test Stats Cards -->
    <div class="responsive-grid mb-4">
        <div class="card-responsive text-center">
            <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); width: 60px; height: 60px; margin: 0 auto 1rem; border-radius: 15px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                <i class="fas fa-users"></i>
            </div>
            <h2 class="stat-number">1,234</h2>
            <p class="stat-label">Usuarios Activos</p>
        </div>
        
        <div class="card-responsive text-center">
            <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #059669); width: 60px; height: 60px; margin: 0 auto 1rem; border-radius: 15px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <h2 class="stat-number">567</h2>
            <p class="stat-label">Pedidos Hoy</p>
        </div>
        
        <div class="card-responsive text-center">
            <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706); width: 60px; height: 60px; margin: 0 auto 1rem; border-radius: 15px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <h2 class="stat-number">$12,345</h2>
            <p class="stat-label">Ingresos</p>
        </div>
    </div>

    <!-- Instructions -->
    <div class="card-responsive">
        <h3>Instrucciones para Probar</h3>
        <ol class="text-responsive">
            <li><strong>Redimensiona la ventana del navegador</strong> para ver cómo se adapta el diseño</li>
            <li><strong>Usa las herramientas de desarrollador</strong> (F12) para simular dispositivos móviles</li>
            <li><strong>Prueba en diferentes orientaciones</strong> (portrait/landscape) en móviles</li>
            <li><strong>Verifica la navegación</strong> en el sidebar en dispositivos móviles</li>
            <li><strong>Comprueba que los botones</strong> sean fáciles de tocar en pantallas táctiles</li>
        </ol>
        
        <div class="alert alert-success mt-3">
            <i class="fas fa-check-circle me-2"></i>
            <strong>¡Diseño Responsive Implementado!</strong> La aplicación ahora se adapta perfectamente a todos los tamaños de pantalla.
        </div>
    </div>
</div>

<style>
.gap-2 > * + * {
    margin-left: 0.5rem;
}

@media (max-width: 768px) {
    .gap-2 > * + * {
        margin-left: 0;
        margin-top: 0.5rem;
    }
}

.stat-number {
    font-size: 2rem;
    font-weight: 800;
    margin: 0.5rem 0;
    color: #1f2937;
}

.stat-label {
    font-size: 0.9rem;
    color: #6b7280;
    margin: 0;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

@media (max-width: 768px) {
    .stat-number {
        font-size: 1.5rem;
    }
    
    .stat-label {
        font-size: 0.8rem;
    }
}
</style>
@endsection

