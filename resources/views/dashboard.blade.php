@extends('layouts.app')

@section('title', 'Dashboard - Wurger')
@section('page-title', 'Dashboard')

<style>
.dashboard-header {
    background: var(--wurger-gradient);
    color: white;
    border-radius: 25px;
    padding: 2.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
    overflow: hidden;
}

.dashboard-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0.1) 100%);
}

.dashboard-title {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.dashboard-title h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin: 0;
    color: white;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}

.dashboard-title i {
    font-size: 2rem;
    margin-right: 1rem;
    color: rgba(255, 255, 255, 0.9);
}

.dashboard-subtitle {
    font-size: 1.1rem;
    color: rgba(255, 255, 255, 0.8);
    margin: 0;
    font-weight: 500;
}

.dashboard-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2rem;
    padding: 1.5rem 2rem;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.toolbar-search {
    position: relative;
    flex: 1;
    max-width: 400px;
}

.toolbar-search input {
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 25px;
    padding: 0.75rem 1rem 0.75rem 3rem;
    width: 100%;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.toolbar-search input:focus {
    outline: none;
    border-color: var(--wurger-primary);
    box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
    background: white;
}

.toolbar-search i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
    font-size: 0.9rem;
}

.toolbar-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.notification-dropdown {
    position: relative;
}

.notification-btn {
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 50%;
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6b7280;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    position: relative;
}

.notification-btn:hover {
    background: white;
    color: var(--wurger-primary);
    transform: scale(1.05);
}

.notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #ef4444;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    font-size: 0.7rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 25px;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
}

.user-info:hover {
    background: white;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.user-avatar {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: var(--wurger-gradient);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.9rem;
}

.user-details {
    display: flex;
    flex-direction: column;
}

.user-name {
    font-weight: 600;
    color: #1f2937;
    font-size: 0.9rem;
    margin: 0;
}

.user-role {
    color: #6b7280;
    font-size: 0.75rem;
    margin: 0;
}

.logout-btn {
    color: #6b7280;
    padding: 0.5rem;
    border-radius: 50%;
    transition: all 0.3s ease;
    text-decoration: none;
}

.logout-btn:hover {
    color: #ef4444;
    background: rgba(239, 68, 68, 0.1);
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    border: 1px solid rgba(0, 0, 0, 0.1);
    z-index: 1000;
    margin-top: 0.5rem;
    min-width: 300px;
    overflow: hidden;
    backdrop-filter: blur(20px);
}

.dropdown-header {
    padding: 1rem 1.5rem;
    background: rgba(59, 130, 246, 0.05);
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.dropdown-header h6 {
    margin: 0;
    color: #1f2937;
    font-weight: 600;
}

.dropdown-content {
    max-height: 300px;
    overflow-y: auto;
}

.notification-item {
    display: flex;
    align-items: flex-start;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.2s ease;
}

.notification-item:last-child {
    border-bottom: none;
}

.notification-item:hover {
    background: rgba(59, 130, 246, 0.05);
}

.notification-item i {
    margin-right: 0.75rem;
    margin-top: 0.25rem;
    font-size: 1rem;
}

.notification-item div {
    flex: 1;
}

.notification-item strong {
    display: block;
    color: #1f2937;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.notification-item p {
    margin: 0;
    color: #6b7280;
    font-size: 0.85rem;
}

.notification-loading {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    color: #6b7280;
}

.notification-loading i {
    margin-right: 0.5rem;
}

@media (max-width: 768px) {
    .dashboard-toolbar {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
    
    .toolbar-search {
        max-width: none;
    }
    
    .toolbar-actions {
        justify-content: space-between;
    }
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--wurger-gradient);
}

.stat-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    margin: 0;
    color: #1f2937;
}

.stat-label {
    font-size: 0.9rem;
    color: #6b7280;
    margin: 0;
    font-weight: 500;
}

.stat-trend {
    display: flex;
    align-items: center;
    font-size: 0.8rem;
    font-weight: 600;
}

.stat-trend.positive {
    color: #10b981;
}

.stat-trend.negative {
    color: #ef4444;
}

.widgets-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.widget {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.widget-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.widget-title {
    font-size: 1.2rem;
    font-weight: 700;
    margin: 0;
    color: #1f2937;
    display: flex;
    align-items: center;
}

.widget-title i {
    margin-right: 0.5rem;
    color: var(--wurger-primary);
}

.widget-content {
    max-height: 300px;
    overflow-y: auto;
}

.list-item {
    display: flex;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.list-item:last-child {
    border-bottom: none;
}

.list-item-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1rem;
    color: white;
}

.list-item-content {
    flex: 1;
}

.list-item-title {
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.25rem 0;
    font-size: 0.9rem;
}

.list-item-subtitle {
    color: #6b7280;
    margin: 0;
    font-size: 0.8rem;
}

.list-item-value {
    font-weight: 700;
    color: var(--wurger-primary);
    font-size: 0.9rem;
}

.chart-container {
    height: 200px;
    margin-top: 1rem;
}

.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.quick-action-btn {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    border-radius: 15px;
    padding: 1.5rem;
    text-decoration: none;
    color: #1f2937;
    text-align: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.quick-action-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    color: var(--wurger-primary);
}

.quick-action-btn i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    display: block;
    color: var(--wurger-primary);
}

.quick-action-btn h6 {
    margin: 0;
    font-weight: 600;
    font-size: 0.9rem;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-pendiente {
    background: #fef3c7;
    color: #92400e;
}

.status-pagada {
    background: #d1fae5;
    color: #065f46;
}

.status-anulada {
    background: #fee2e2;
    color: #991b1b;
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .widgets-grid {
        grid-template-columns: 1fr;
    }
    
    .quick-actions {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .dashboard-header {
        padding: 1.5rem;
    }
    
    .dashboard-title h1 {
        font-size: 2rem;
    }
}
</style>

@section('content')
<div class="dashboard-header">
    <div class="dashboard-title">
        <i class="fas fa-tachometer-alt"></i>
        <h1>Dashboard Wurger</h1>
    </div>
    <p class="dashboard-subtitle">Sistema de Gestión de Pedidos - Restaurante Wurger</p>
</div>

<!-- Barra de herramientas del dashboard -->
<div class="dashboard-toolbar">
    <div class="toolbar-search">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Buscar platos, clientes, pedidos, empleados..." id="dashboardSearchInput" autocomplete="off">
        <div class="search-suggestions" id="dashboardSearchSuggestions" style="display: none;">
            <div class="suggestion-item" data-type="platos">
                <i class="fas fa-utensils"></i>
                <span>Buscar en Platos</span>
            </div>
            <div class="suggestion-item" data-type="clientes">
                <i class="fas fa-user-friends"></i>
                <span>Buscar en Clientes</span>
            </div>
            <div class="suggestion-item" data-type="pedidos">
                <i class="fas fa-shopping-cart"></i>
                <span>Buscar en Pedidos</span>
            </div>
            <div class="suggestion-item" data-type="empleados">
                <i class="fas fa-users"></i>
                <span>Buscar en Empleados</span>
            </div>
        </div>
    </div>
    
    <div class="toolbar-actions">
        <div class="notification-dropdown">
            <button class="notification-btn" onclick="toggleDashboardNotifications()">
                <i class="fas fa-bell"></i>
                <span class="notification-badge" id="notificationCount">0</span>
            </button>
            <div class="dropdown-menu" id="dashboardNotificationMenu" style="display: none;">
                <div class="dropdown-header">
                    <h6><i class="fas fa-bell me-2"></i>Notificaciones del Sistema</h6>
                </div>
                <div class="dropdown-content" id="notificationContent">
                    <div class="notification-loading">
                        <i class="fas fa-spinner fa-spin"></i>
                        <span>Cargando notificaciones...</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="user-info">
            <div class="user-avatar">
                {{ substr(Auth::user()->Nom_usuario ?? 'A', 0, 1) }}
            </div>
            <div class="user-details">
                <span class="user-name">{{ Auth::user()->Nom_usuario ?? 'Usuario' }}</span>
                <small class="user-role">{{ Auth::user()->rol->Nombre_rol ?? 'Administrador' }}</small>
            </div>
            <a href="{{ route('logout') }}" class="logout-btn" title="Cerrar Sesión">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </div>
</div>

<!-- Estadísticas Principales -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="stat-number">{{ $totalEmpleados ?? 0 }}</div>
        <div class="stat-label">Empleados Activos</div>
        <div class="stat-trend positive">
            <i class="fas fa-arrow-up"></i>
            <span>+12%</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                <i class="fas fa-utensils"></i>
            </div>
        </div>
        <div class="stat-number">{{ $totalPlatos ?? 0 }}</div>
        <div class="stat-label">Platos en Menú</div>
        <div class="stat-trend positive">
            <i class="fas fa-arrow-up"></i>
            <span>+5%</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
        <div class="stat-number">{{ $totalPedidos ?? 0 }}</div>
        <div class="stat-label">Total de Pedidos</div>
        <div class="stat-trend positive">
            <i class="fas fa-arrow-up"></i>
            <span>+23%</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                <i class="fas fa-user-friends"></i>
            </div>
        </div>
        <div class="stat-number">{{ $totalClientes ?? 0 }}</div>
        <div class="stat-label">Clientes Registrados</div>
        <div class="stat-trend positive">
            <i class="fas fa-arrow-up"></i>
            <span>+8%</span>
        </div>
    </div>
</div>

<!-- Estadísticas del Día -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                <i class="fas fa-calendar-day"></i>
            </div>
        </div>
        <div class="stat-number">{{ $pedidosHoy ?? 0 }}</div>
        <div class="stat-label">Pedidos Hoy</div>
        <div class="stat-trend positive">
            <i class="fas fa-arrow-up"></i>
            <span>+15%</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
        <div class="stat-number">${{ number_format($ingresosHoy ?: 0, 2) }}</div>
        <div class="stat-label">Ingresos Hoy</div>
        <div class="stat-trend positive">
            <i class="fas fa-arrow-up"></i>
            <span>+18%</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                <i class="fas fa-clock"></i>
            </div>
        </div>
        <div class="stat-number">{{ $pedidosPendientes ?? 0 }}</div>
        <div class="stat-label">Pedidos Pendientes</div>
        <div class="stat-trend negative">
            <i class="fas fa-arrow-down"></i>
            <span>-5%</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
        <div class="stat-number">{{ $pedidosPagados ?? 0 }}</div>
        <div class="stat-label">Pedidos Completados</div>
        <div class="stat-trend positive">
            <i class="fas fa-arrow-up"></i>
            <span>+12%</span>
        </div>
    </div>
</div>

<!-- Acciones Rápidas -->
<div class="quick-actions">
    <a href="{{ route('ventas.create') }}" class="quick-action-btn">
        <i class="fas fa-plus-circle"></i>
        <h6>Nuevo Pedido</h6>
    </a>
    
    <a href="{{ route('productos.create') }}" class="quick-action-btn">
        <i class="fas fa-utensils"></i>
        <h6>Agregar Plato</h6>
    </a>
    
    <a href="{{ route('clientes.create') }}" class="quick-action-btn">
        <i class="fas fa-user-plus"></i>
        <h6>Nuevo Cliente</h6>
    </a>
    
    <a href="{{ route('ventas.index') }}" class="quick-action-btn">
        <i class="fas fa-list"></i>
        <h6>Ver Pedidos</h6>
    </a>
    
    <a href="{{ route('inventario.index') }}" class="quick-action-btn">
        <i class="fas fa-boxes"></i>
        <h6>Inventario</h6>
    </a>
    
    <a href="{{ route('reportes.index') }}" class="quick-action-btn">
        <i class="fas fa-chart-bar"></i>
        <h6>Reportes</h6>
    </a>
</div>

<!-- Widgets de Información -->
<div class="widgets-grid">
    <!-- Pedidos Recientes -->
    <div class="widget">
        <div class="widget-header">
            <h5 class="widget-title">
                <i class="fas fa-clock"></i>
                Pedidos Recientes
            </h5>
        </div>
        <div class="widget-content">
            @forelse($pedidosRecientes ?? [] as $pedido)
            <div class="list-item">
                <div class="list-item-icon" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="list-item-content">
                    <div class="list-item-title">Pedido #{{ $pedido->id_venta }}</div>
                    <div class="list-item-subtitle">
                        {{ $pedido->usuario->Nom_usuario ?? 'Sin empleado' }} - 
                        {{ $pedido->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>
                <div class="list-item-value">
                    <span class="status-badge status-{{ strtolower($pedido->Estado_venta) }}">
                        {{ $pedido->Estado_venta }}
                    </span>
                </div>
            </div>
            @empty
            <div class="text-center text-muted py-3">
                <i class="fas fa-inbox fa-2x mb-2"></i>
                <p>No hay pedidos recientes</p>
            </div>
            @endforelse
        </div>
    </div>
    
    <!-- Platos con Stock Bajo -->
    <div class="widget">
        <div class="widget-header">
            <h5 class="widget-title">
                <i class="fas fa-exclamation-triangle"></i>
                Stock Bajo
            </h5>
        </div>
        <div class="widget-content">
            @forelse($platosBajoStock ?? [] as $plato)
            <div class="list-item">
                <div class="list-item-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    <i class="fas fa-utensils"></i>
                </div>
                <div class="list-item-content">
                    <div class="list-item-title">{{ $plato->Nombre_producto }}</div>
                    <div class="list-item-subtitle">
                        Stock: {{ $plato->Stock_producto }} / Mín: {{ $plato->Stock_min_producto }}
                    </div>
                </div>
                <div class="list-item-value">
                    <span class="status-badge" style="background: #fef3c7; color: #92400e;">
                        Crítico
                    </span>
                </div>
            </div>
            @empty
            <div class="text-center text-muted py-3">
                <i class="fas fa-check-circle fa-2x mb-2 text-success"></i>
                <p>Todo el stock está en orden</p>
            </div>
            @endforelse
        </div>
    </div>
    
    <!-- Clientes Frecuentes -->
    <div class="widget">
        <div class="widget-header">
            <h5 class="widget-title">
                <i class="fas fa-star"></i>
                Clientes Frecuentes
            </h5>
        </div>
        <div class="widget-content">
            @forelse($clientesFrecuentes ?? [] as $cliente)
            <div class="list-item">
                <div class="list-item-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                    <i class="fas fa-user"></i>
                </div>
                <div class="list-item-content">
                    <div class="list-item-title">{{ $cliente->Nom_cliente }}</div>
                    <div class="list-item-subtitle">{{ $cliente->Tel_cliente ?? 'Sin teléfono' }}</div>
                </div>
                <div class="list-item-value">
                    {{ $cliente->pedidos_count ?? 0 }} pedidos
                </div>
            </div>
            @empty
            <div class="text-center text-muted py-3">
                <i class="fas fa-users fa-2x mb-2"></i>
                <p>No hay clientes registrados</p>
            </div>
            @endforelse
        </div>
    </div>
    
    <!-- Empleados Más Activos -->
    <div class="widget">
        <div class="widget-header">
            <h5 class="widget-title">
                <i class="fas fa-trophy"></i>
                Empleados Activos
            </h5>
        </div>
        <div class="widget-content">
            @forelse($empleadosActivos ?? [] as $empleado)
            <div class="list-item">
                <div class="list-item-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="list-item-content">
                    <div class="list-item-title">{{ $empleado->Nom_usuario }} {{ $empleado->Apellido_usuario }}</div>
                    <div class="list-item-subtitle">{{ $empleado->rol->Nombre_rol ?? 'Sin rol' }}</div>
                </div>
                <div class="list-item-value">
                    {{ $empleado->ventas_count ?? 0 }} pedidos
                </div>
            </div>
            @empty
            <div class="text-center text-muted py-3">
                <i class="fas fa-user-slash fa-2x mb-2"></i>
                <p>No hay empleados activos</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Gráfico de Tendencias -->
<div class="widget">
    <div class="widget-header">
        <h5 class="widget-title">
            <i class="fas fa-chart-line"></i>
            Tendencias de Ventas (Últimos 7 días)
        </h5>
    </div>
    <div class="chart-container">
        <canvas id="tendenciasChart"></canvas>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de tendencias
    const ctx = document.getElementById('tendenciasChart').getContext('2d');
    const tendenciasData = @json($tendenciasVentas ?? []);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: tendenciasData.map(item => item.fecha),
            datasets: [{
                label: 'Ventas ($)',
                data: tendenciasData.map(item => item.ventas),
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Funcionalidad de búsqueda del dashboard
    const searchInput = document.getElementById('dashboardSearchInput');
    const searchSuggestions = document.getElementById('dashboardSearchSuggestions');

    searchInput.addEventListener('focus', function() {
        searchSuggestions.style.display = 'block';
    });

    searchInput.addEventListener('blur', function() {
        setTimeout(() => {
            searchSuggestions.style.display = 'none';
        }, 200);
    });

    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        if (query.length > 0) {
            searchSuggestions.style.display = 'block';
        } else {
            searchSuggestions.style.display = 'none';
        }
    });

    // Manejar clics en sugerencias
    document.querySelectorAll('.suggestion-item').forEach(item => {
        item.addEventListener('click', function() {
            const type = this.dataset.type;
            const query = searchInput.value.trim();
            
            if (query) {
                window.location.href = `/busqueda?q=${encodeURIComponent(query)}&type=${type}`;
            } else {
                window.location.href = `/busqueda?type=${type}`;
            }
        });
    });

    // Manejar Enter en el input de búsqueda
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const query = this.value.trim();
            if (query) {
                window.location.href = `/busqueda?q=${encodeURIComponent(query)}`;
            }
        }
    });

    // Cargar notificaciones al cargar la página
    loadNotifications();
});

// Función para alternar notificaciones del dashboard
function toggleDashboardNotifications() {
    const menu = document.getElementById('dashboardNotificationMenu');
    if (menu.style.display === 'none' || menu.style.display === '') {
        menu.style.display = 'block';
        loadNotifications();
    } else {
        menu.style.display = 'none';
    }
}

// Función para cargar notificaciones
function loadNotifications() {
    const content = document.getElementById('notificationContent');
    const count = document.getElementById('notificationCount');
    
    // Mostrar loading
    content.innerHTML = `
        <div class="notification-loading">
            <i class="fas fa-spinner fa-spin"></i>
            <span>Cargando notificaciones...</span>
        </div>
    `;
    
    // Cargar notificaciones desde el servidor
    fetch('/notificaciones')
        .then(response => response.json())
        .then(data => {
            if (data.length === 0) {
                content.innerHTML = `
                    <div class="notification-loading">
                        <i class="fas fa-check-circle text-success"></i>
                        <span>No hay notificaciones</span>
                    </div>
                `;
                count.textContent = '0';
            } else {
                let html = '';
                data.forEach(notification => {
                    const iconClass = getNotificationIcon(notification.tipo);
                    const colorClass = getNotificationColor(notification.tipo);
                    
                    html += `
                        <div class="notification-item" onclick="window.location.href='${notification.url}'">
                            <i class="${iconClass} ${colorClass}"></i>
                            <div>
                                <strong>${notification.titulo}</strong>
                                <p>${notification.mensaje}</p>
                            </div>
                        </div>
                    `;
                });
                content.innerHTML = html;
                count.textContent = data.length;
            }
        })
        .catch(error => {
            content.innerHTML = `
                <div class="notification-loading">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    <span>Error al cargar notificaciones</span>
                </div>
            `;
            count.textContent = '!';
        });
}

// Función para obtener el icono de la notificación
function getNotificationIcon(tipo) {
    const icons = {
        'warning': 'fas fa-exclamation-triangle',
        'success': 'fas fa-check-circle',
        'info': 'fas fa-info-circle',
        'danger': 'fas fa-times-circle'
    };
    return icons[tipo] || 'fas fa-bell';
}

// Función para obtener el color de la notificación
function getNotificationColor(tipo) {
    const colors = {
        'warning': 'text-warning',
        'success': 'text-success',
        'info': 'text-info',
        'danger': 'text-danger'
    };
    return colors[tipo] || 'text-primary';
}

// Cerrar notificaciones al hacer clic fuera
document.addEventListener('click', function(e) {
    const menu = document.getElementById('dashboardNotificationMenu');
    const btn = document.querySelector('.notification-btn');
    
    if (!menu.contains(e.target) && !btn.contains(e.target)) {
        menu.style.display = 'none';
    }
});
</script>
@endpush