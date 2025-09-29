<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Wurger</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/wurger-theme.css') }}" rel="stylesheet">
    <style>
        .app-container {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 25%, #60a5fa 50%, #3b82f6 75%, #1e3a8a 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            min-height: 100vh;
            padding: 0;
            margin: 0;
            position: relative;
            overflow: hidden;
        }
        
        .app-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(59, 130, 246, 0.4) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(96, 165, 250, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(147, 197, 253, 0.2) 0%, transparent 50%);
            animation: floatingBubbles 20s ease-in-out infinite;
        }
        
        .app-container::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 60% 30%, rgba(30, 58, 138, 0.3) 0%, transparent 40%),
                radial-gradient(circle at 30% 70%, rgba(59, 130, 246, 0.2) 0%, transparent 40%),
                radial-gradient(circle at 70% 60%, rgba(96, 165, 250, 0.25) 0%, transparent 40%);
            animation: floatingBubbles 25s ease-in-out infinite reverse;
        }
        
        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
        
        @keyframes floatingBubbles {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
                opacity: 0.7;
            }
            33% {
                transform: translateY(-30px) rotate(120deg);
                opacity: 0.4;
            }
            66% {
                transform: translateY(20px) rotate(240deg);
                opacity: 0.6;
            }
        }
        
        .container {
            position: relative;
            z-index: 10;
        }
        
        .logo-section {
            text-align: center;
            padding: 2rem 0 1rem 0;
            position: relative;
        }
        
        .user-profile-section {
            position: absolute;
            top: 2rem;
            right: 0;
            display: flex;
            align-items: center;
            gap: 1rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .user-avatar-profile {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #ff8c00;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1rem;
        }
        
        .logo-section img {
            height: 120px;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
            transition: transform 0.3s ease;
        }
        
        .logo-section img:hover {
            transform: scale(1.05);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff6b6b 0%, #4ecdc4 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .welcome-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 3rem 2rem;
            margin: 2rem 0;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .welcome-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            animation: shimmer 3s infinite;
        }
        
        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem 1.5rem;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #ff6b6b, #4ecdc4, #45b7d1);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .stat-card:hover::before {
            opacity: 1;
        }
        
        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #ff8c00;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: #6b7280;
            font-weight: 500;
        }
        
        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        
        .action-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem 1.5rem;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            position: relative;
            overflow: hidden;
        }
        
        .action-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            color: inherit;
            text-decoration: none;
        }
        
        .action-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s ease;
        }
        
        .action-card:hover::after {
            left: 100%;
        }
        
        .action-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #ff8c00;
        }
        
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin: 2rem 0;
        }
        
        .content-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .product-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .product-item:hover {
            background: #e2e8f0;
            transform: translateX(5px);
        }
        
        .product-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #ff8c00;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 1rem;
        }
        
        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .order-item:hover {
            background: #e2e8f0;
        }
        
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-pendiente {
            background: #fef3c7;
            color: #92400e;
        }
        
        .status-entregado {
            background: #d1fae5;
            color: #065f46;
        }
        
        .status-cancelado {
            background: #fee2e2;
            color: #991b1b;
        }
        
        
        .btn-primary {
            background: #ff8c00;
            border: none;
            border-radius: 8px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: #e67e00;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 140, 0, 0.3);
        }
        
        .btn-logout {
            background: #ef4444;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-logout:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }
        
        .logout-floating {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }
        
        .logout-floating:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
        }
        
        .user-info-floating {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .user-avatar-floating {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: #ff8c00;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .actions-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="app-container">
        <div class="container">
            <!-- Logo centrado con perfil de usuario -->
            <div class="logo-section">
                <img src="{{ asset('images/logo.png') }}" alt="Wurger">
                <div class="user-profile-section">
                    <div class="user-avatar-profile">
                        {{ substr(auth()->user()->usuarioInfo->nombre ?? auth()->user()->email, 0, 1) }}
                    </div>
                    <div>
                        <div class="fw-bold text-dark">{{ auth()->user()->usuarioInfo->nombre ?? 'Usuario' }}</div>
                        <small class="text-muted">{{ auth()->user()->rol }}</small>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="ms-2">
                        @csrf
                        <button type="submit" class="btn btn-logout btn-sm">
                            <i class="fas fa-sign-out-alt me-1"></i>
                            Salir
                        </button>
                    </form>
                </div>
            </div>
            <!-- Tarjeta de bienvenida -->
            <div class="welcome-card">
                <h2 class="mb-3">¡Bienvenido, {{ auth()->user()->usuarioInfo->nombre ?? 'Usuario' }}!</h2>
                <p class="text-muted mb-4">Gestiona tus pedidos de manera fácil y rápida</p>
                <a href="{{ route('user.pedidos.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>
                    Nuevo Pedido
                </a>
            </div>

            <!-- Estadísticas -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="stat-number">{{ $pedidos->count() }}</div>
                    <div class="stat-label">Total Pedidos</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-number">{{ $pedidos->where('estado', 'Pendiente')->count() }}</div>
                    <div class="stat-label">Pendientes</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-number">{{ $pedidos->where('estado', 'Entregado')->count() }}</div>
                    <div class="stat-label">Entregados</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div class="stat-number">{{ $productos->count() }}</div>
                    <div class="stat-label">Productos</div>
                </div>
            </div>

            <!-- Acciones rápidas -->
            <div class="actions-grid">
                <a href="{{ route('user.pedidos.create') }}" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <h5>Nuevo Pedido</h5>
                    <p class="text-muted mb-0">Crear un nuevo pedido</p>
                </a>
                <a href="{{ route('user.pedidos.index') }}" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-list"></i>
                    </div>
                    <h5>Mis Pedidos</h5>
                    <p class="text-muted mb-0">Ver todos mis pedidos</p>
                </a>
                <a href="{{ route('user.productos.index') }}" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h5>Ver Productos</h5>
                    <p class="text-muted mb-0">Explorar el menú</p>
                </a>
            </div>

            <!-- Contenido principal -->
            <div class="content-grid">
                <!-- Productos destacados -->
                <div class="content-card">
                    <h5 class="mb-3">
                        <i class="fas fa-star me-2"></i>
                        Productos Destacados
                    </h5>
                    @forelse($productos->take(5) as $producto)
                        <div class="product-item">
                            <div class="product-icon">
                                <i class="fas fa-utensils"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $producto->nombre_producto }}</h6>
                                <small class="text-muted">${{ number_format($producto->precio_venta, 2) }}</small>
                            </div>
                            <span class="badge bg-success">{{ $producto->estado }}</span>
                        </div>
                    @empty
                        <p class="text-muted text-center">No hay productos disponibles</p>
                    @endforelse
                </div>

                <!-- Pedidos recientes -->
                <div class="content-card">
                    <h5 class="mb-3">
                        <i class="fas fa-clock me-2"></i>
                        Mis Pedidos Recientes
                    </h5>
                    @forelse($pedidos->take(5) as $pedido)
                        <div class="order-item">
                            <div>
                                <h6 class="mb-1">Pedido #{{ $pedido->id_pedido }}</h6>
                                <small class="text-muted">{{ $pedido->fecha->format('d/m/Y') }}</small>
                            </div>
                            <span class="status-badge status-{{ strtolower($pedido->estado) }}">
                                {{ $pedido->estado }}
                            </span>
                        </div>
                    @empty
                        <p class="text-muted text-center">No tienes pedidos aún</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>