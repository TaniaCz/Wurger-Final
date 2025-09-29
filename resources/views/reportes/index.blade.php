@extends('layouts.app')

@section('title', 'Reportes y Estadísticas - Wurger')
@section('page-title', 'Reportes y Estadísticas')

@section('content')
<style>
    .report-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 20px;
        color: white;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .report-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }
    
    .report-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        z-index: 1;
    }
    
    .report-card .card-body {
        position: relative;
        z-index: 2;
    }
    
    .quick-export-btn {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }
    
    .quick-export-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        text-decoration: none;
        transform: scale(1.05);
    }
    
    .report-section {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .section-title {
        color: #374151;
        font-weight: 700;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .report-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .report-item {
        background: rgba(255, 255, 255, 0.8);
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: transform 0.3s ease;
    }
    
    .report-item:hover {
        transform: translateY(-3px);
    }
    
    .report-item-title {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .report-item-desc {
        color: #6b7280;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
    
    .report-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .btn-report {
        padding: 0.5rem 1rem;
        border-radius: 10px;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-view {
        background: #3b82f6;
        color: white;
    }
    
    .btn-view:hover {
        background: #2563eb;
        color: white;
        text-decoration: none;
    }
    
    .btn-export {
        background: #10b981;
        color: white;
    }
    
    .btn-export:hover {
        background: #059669;
        color: white;
        text-decoration: none;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 2rem;
        color: white;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        z-index: 1;
    }
    
    .stat-card .content {
        position: relative;
        z-index: 2;
    }
    
    .stat-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.8;
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        font-size: 1rem;
        opacity: 0.9;
    }
    
    .chart-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    @media (max-width: 768px) {
        .report-grid {
            grid-template-columns: 1fr;
        }
        
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .report-actions {
            flex-direction: column;
        }
    }
    
    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container-fluid">
    <!-- Estadísticas Principales -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="content">
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-number">{{ $totalVentas }}</div>
                <div class="stat-label">Total Ventas</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="content">
                <div class="stat-icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="stat-number">{{ $ventasHoy }}</div>
                <div class="stat-label">Ventas Hoy</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="content">
                <div class="stat-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-number">{{ $ventasMes }}</div>
                <div class="stat-label">Ventas del Mes</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="content">
                <div class="stat-icon">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-number">{{ $totalProductos }}</div>
                <div class="stat-label">Productos</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="content">
                <div class="stat-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-number">{{ $productosBajoStock }}</div>
                <div class="stat-label">Bajo Stock</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="content">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number">{{ $totalUsuarios }}</div>
                <div class="stat-label">Usuarios</div>
            </div>
        </div>
    </div>

    <!-- Exportación Rápida -->
    <div class="report-section">
        <h3 class="section-title">
            <i class="fas fa-download"></i>
            Exportación Rápida
        </h3>
        <div class="row">
            <div class="col-md-3 mb-3">
                <a href="{{ route('reportes.ventas', ['export' => 1]) }}" class="btn btn-success w-100">
                    <i class="fas fa-file-excel me-2"></i>
                    Exportar Ventas
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="{{ route('reportes.productos', ['export' => 1]) }}" class="btn btn-success w-100">
                    <i class="fas fa-file-excel me-2"></i>
                    Exportar Productos
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="{{ route('reportes.usuarios', ['export' => 1]) }}" class="btn btn-success w-100">
                    <i class="fas fa-file-excel me-2"></i>
                    Exportar Usuarios
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="{{ route('reportes.valor-inventario', ['export' => 1]) }}" class="btn btn-success w-100">
                    <i class="fas fa-file-excel me-2"></i>
                    Exportar Inventario
                </a>
            </div>
        </div>
    </div>

    <!-- Reportes de Ventas -->
    <div class="report-section">
        <h3 class="section-title">
            <i class="fas fa-chart-line"></i>
            Reportes de Ventas
        </h3>
        <div class="report-grid">
            <div class="report-item">
                <div class="report-item-title">
                    <i class="fas fa-calendar-day text-primary"></i>
                    Ventas Diarias
                </div>
                <div class="report-item-desc">
                    Análisis detallado de ventas por día con filtros de fecha
                </div>
                <div class="report-actions">
                    <a href="{{ route('reportes.ventas-diarias') }}" class="btn-report btn-view">
                        <i class="fas fa-eye"></i>
                        Ver Reporte
                    </a>
                    <a href="{{ route('reportes.ventas-diarias', ['export' => 1]) }}" class="btn-report btn-export">
                        <i class="fas fa-download"></i>
                        Exportar
                    </a>
                </div>
            </div>

            <div class="report-item">
                <div class="report-item-title">
                    <i class="fas fa-calendar-alt text-info"></i>
                    Ventas Mensuales
                </div>
                <div class="report-item-desc">
                    Resumen de ventas por mes con estadísticas comparativas
                </div>
                <div class="report-actions">
                    <a href="{{ route('reportes.ventas-mensuales') }}" class="btn-report btn-view">
                        <i class="fas fa-eye"></i>
                        Ver Reporte
                    </a>
                    <a href="{{ route('reportes.ventas-mensuales', ['export' => 1]) }}" class="btn-report btn-export">
                        <i class="fas fa-download"></i>
                        Exportar
                    </a>
                </div>
            </div>

            <div class="report-item">
                <div class="report-item-title">
                    <i class="fas fa-chart-bar text-success"></i>
                    Ventas Anuales
                </div>
                <div class="report-item-desc">
                    Análisis completo de ventas por año con tendencias
                </div>
                <div class="report-actions">
                    <a href="{{ route('reportes.ventas-anuales') }}" class="btn-report btn-view">
                        <i class="fas fa-eye"></i>
                        Ver Reporte
                    </a>
                    <a href="{{ route('reportes.ventas-anuales', ['export' => 1]) }}" class="btn-report btn-export">
                        <i class="fas fa-download"></i>
                        Exportar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Reportes de Productos -->
    <div class="report-section">
        <h3 class="section-title">
            <i class="fas fa-box"></i>
            Reportes de Productos
        </h3>
        <div class="report-grid">
            <div class="report-item">
                <div class="report-item-title">
                    <i class="fas fa-star text-warning"></i>
                    Productos Más Vendidos
                </div>
                <div class="report-item-desc">
                    Ranking de productos con mayor volumen de ventas
                </div>
                <div class="report-actions">
                    <a href="{{ route('reportes.productos-mas-vendidos') }}" class="btn-report btn-view">
                        <i class="fas fa-eye"></i>
                        Ver Reporte
                    </a>
                    <a href="{{ route('reportes.productos-mas-vendidos', ['export' => 1]) }}" class="btn-report btn-export">
                        <i class="fas fa-download"></i>
                        Exportar
                    </a>
                </div>
            </div>

            <div class="report-item">
                <div class="report-item-title">
                    <i class="fas fa-exclamation-triangle text-danger"></i>
                    Productos Bajo Stock
                </div>
                <div class="report-item-desc">
                    Productos que requieren reposición urgente
                </div>
                <div class="report-actions">
                    <a href="{{ route('reportes.productos-bajo-stock') }}" class="btn-report btn-view">
                        <i class="fas fa-eye"></i>
                        Ver Reporte
                    </a>
                    <a href="{{ route('reportes.productos-bajo-stock', ['export' => 1]) }}" class="btn-report btn-export">
                        <i class="fas fa-download"></i>
                        Exportar
                    </a>
                </div>
            </div>

            <div class="report-item">
                <div class="report-item-title">
                    <i class="fas fa-tags text-info"></i>
                    Productos por Categoría
                </div>
                <div class="report-item-desc">
                    Distribución de productos según su categoría
                </div>
                <div class="report-actions">
                    <a href="{{ route('reportes.productos-por-categoria') }}" class="btn-report btn-view">
                        <i class="fas fa-eye"></i>
                        Ver Reporte
                    </a>
                    <a href="{{ route('reportes.productos-por-categoria', ['export' => 1]) }}" class="btn-report btn-export">
                        <i class="fas fa-download"></i>
                        Exportar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Reportes de Inventario -->
    <div class="report-section">
        <h3 class="section-title">
            <i class="fas fa-warehouse"></i>
            Reportes de Inventario
        </h3>
        <div class="report-grid">
            <div class="report-item">
                <div class="report-item-title">
                    <i class="fas fa-exchange-alt text-primary"></i>
                    Movimientos de Inventario
                </div>
                <div class="report-item-desc">
                    Registro de entradas y salidas de productos
                </div>
                <div class="report-actions">
                    <a href="{{ route('reportes.movimientos-inventario') }}" class="btn-report btn-view">
                        <i class="fas fa-eye"></i>
                        Ver Reporte
                    </a>
                    <a href="{{ route('reportes.movimientos-inventario', ['export' => 1]) }}" class="btn-report btn-export">
                        <i class="fas fa-download"></i>
                        Exportar
                    </a>
                </div>
            </div>

            <div class="report-item">
                <div class="report-item-title">
                    <i class="fas fa-dollar-sign text-success"></i>
                    Valor del Inventario
                </div>
                <div class="report-item-desc">
                    Evaluación económica del stock actual
                </div>
                <div class="report-actions">
                    <a href="{{ route('reportes.valor-inventario') }}" class="btn-report btn-view">
                        <i class="fas fa-eye"></i>
                        Ver Reporte
                    </a>
                    <a href="{{ route('reportes.valor-inventario', ['export' => 1]) }}" class="btn-report btn-export">
                        <i class="fas fa-download"></i>
                        Exportar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Reportes de Pedidos y Otros -->
    <div class="report-section">
        <h3 class="section-title">
            <i class="fas fa-shopping-bag"></i>
            Reportes de Pedidos y Otros
        </h3>
        <div class="report-grid">
            <div class="report-item">
                <div class="report-item-title">
                    <i class="fas fa-list-alt text-info"></i>
                    Pedidos por Estado
                </div>
                <div class="report-item-desc">
                    Distribución de pedidos según su estado actual
                </div>
                <div class="report-actions">
                    <a href="{{ route('reportes.pedidos-por-estado') }}" class="btn-report btn-view">
                        <i class="fas fa-eye"></i>
                        Ver Reporte
                    </a>
                    <a href="{{ route('reportes.pedidos-por-estado', ['export' => 1]) }}" class="btn-report btn-export">
                        <i class="fas fa-download"></i>
                        Exportar
                    </a>
                </div>
            </div>

            <div class="report-item">
                <div class="report-item-title">
                    <i class="fas fa-truck text-warning"></i>
                    Proveedores
                </div>
                <div class="report-item-desc">
                    Información completa de proveedores registrados
                </div>
                <div class="report-actions">
                    <a href="{{ route('reportes.proveedores') }}" class="btn-report btn-view">
                        <i class="fas fa-eye"></i>
                        Ver Reporte
                    </a>
                    <a href="{{ route('reportes.proveedores', ['export' => 1]) }}" class="btn-report btn-export">
                        <i class="fas fa-download"></i>
                        Exportar
                    </a>
                </div>
            </div>

            <div class="report-item">
                <div class="report-item-title">
                    <i class="fas fa-percentage text-success"></i>
                    Promociones
                </div>
                <div class="report-item-desc">
                    Estado y efectividad de promociones activas
                </div>
                <div class="report-actions">
                    <a href="{{ route('reportes.promociones') }}" class="btn-report btn-view">
                        <i class="fas fa-eye"></i>
                        Ver Reporte
                    </a>
                    <a href="{{ route('reportes.promociones', ['export' => 1]) }}" class="btn-report btn-export">
                        <i class="fas fa-download"></i>
                        Exportar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos y Estadísticas -->
    <div class="chart-container">
        <h3 class="section-title">
            <i class="fas fa-chart-pie"></i>
            Estadísticas Generales
        </h3>
        <div class="row">
            <div class="col-md-6">
                <h5>Ventas por Mes</h5>
                <canvas id="ventasPorMesChart" width="400" height="200"></canvas>
            </div>
            <div class="col-md-6">
                <h5>Productos por Categoría</h5>
                <canvas id="productosPorCategoriaChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de Ventas por Mes
    const ventasPorMesData = @json($ventasPorMes);
    const meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
    const ventasData = new Array(12).fill(0);
    
    ventasPorMesData.forEach(item => {
        ventasData[item.mes - 1] = item.total;
    });

    new Chart(document.getElementById('ventasPorMesChart'), {
        type: 'line',
        data: {
            labels: meses,
            datasets: [{
                label: 'Ventas',
                data: ventasData,
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Gráfico de Productos por Categoría
    const productosPorCategoriaData = @json($productosPorCategoria);
    const categorias = productosPorCategoriaData.map(item => item.nombre_categoria);
    const cantidades = productosPorCategoriaData.map(item => item.productos_count);

    new Chart(document.getElementById('productosPorCategoriaChart'), {
        type: 'doughnut',
        data: {
            labels: categorias,
            datasets: [{
                data: cantidades,
                backgroundColor: [
                    '#667eea',
                    '#764ba2',
                    '#f093fb',
                    '#f5576c',
                    '#4facfe',
                    '#00f2fe'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endsection