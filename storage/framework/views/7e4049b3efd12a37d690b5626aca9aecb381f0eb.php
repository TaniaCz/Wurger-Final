<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Wurger - Sistema de Gestión'); ?></title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/logo.png')); ?>">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Wurger Theme -->
    <link rel="stylesheet" href="<?php echo e(asset('css/wurger-theme.css')); ?>">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        :root {
            --primary-color: #1e40af;
            --secondary-color: #64748b;
            --success-color: #059669;
            --warning-color: #d97706;
            --danger-color: #dc2626;
            --dark-color: #0f172a;
            --light-color: #f8fafc;
            --border-color: #e2e8f0;
            --wurger-blue: #1e40af;
            --wurger-orange: #ea580c;
            --wurger-gradient: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            --wurger-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --wurger-shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --wurger-glass: rgba(255, 255, 255, 0.95);
            --wurger-glass-border: rgba(255, 255, 255, 0.2);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            background: var(--wurger-gradient);
            min-height: 100vh;
            width: 280px;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
        }

        .logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .logo-wrapper {
            position: relative;
            display: inline-block;
            margin-bottom: 0.75rem;
        }

        .logo-container img {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 3px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .logo-container:hover img {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        }

        .logo-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80px;
            height: 80px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
            border-radius: 50%;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .logo-container:hover .logo-glow {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1.2);
        }

        .sidebar-title {
            color: white;
            font-size: 1.75rem;
            font-weight: 800;
            margin: 0;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
        }

        .sidebar-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.85rem;
            font-weight: 500;
            margin: 0.25rem 0 0 0;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            letter-spacing: 0.3px;
        }

        .sidebar-status {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 0.75rem;
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
            margin-right: 0.5rem;
            animation: pulse 2s infinite;
        }

        .status-text {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .sidebar.collapsed .sidebar-title,
        .sidebar.collapsed .sidebar-subtitle,
        .sidebar.collapsed .sidebar-status {
            opacity: 0;
            transform: translateY(-10px);
        }

        .sidebar.collapsed .logo-container {
            margin-bottom: 0;
        }

        .sidebar.collapsed .logo-container img {
            width: 50px;
            height: 50px;
        }

        .sidebar.collapsed .sidebar-title {
            opacity: 0;
            transform: translateX(-20px);
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-item {
            margin: 0.25rem 1rem;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            padding: 1rem 1.5rem;
            border-radius: 15px;
            display: flex;
            align-items: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s ease;
        }

        .nav-link:hover::before {
            left: 100%;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
            text-decoration: none;
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .nav-link i {
            width: 24px;
            font-size: 1.2rem;
            margin-right: 1rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .nav-link:hover i {
            transform: scale(1.1);
        }

        .sidebar.collapsed .nav-link span {
            opacity: 0;
            transform: translateX(-20px);
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 1rem;
        }

        .sidebar.collapsed .nav-link i {
            margin-right: 0;
        }

        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: transparent;
        }

        .main-content.expanded {
            margin-left: 80px;
        }

        .top-bar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 1rem 2rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .top-bar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            margin-right: 1rem;
        }

        .user-name {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 0.9rem;
        }

        .user-role {
            font-size: 0.8rem;
            color: var(--secondary-color);
            text-transform: capitalize;
        }

        .user-dropdown {
            position: relative;
        }

        .user-btn {
            background: none;
            border: none;
            color: var(--primary-color);
            font-size: 1.5rem;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .user-btn:hover {
            background: rgba(30, 64, 175, 0.1);
            transform: scale(1.05);
        }

        .user-btn i:last-child {
            font-size: 0.8rem;
            transition: transform 0.3s ease;
        }

        .user-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            border: 1px solid var(--border-color);
            min-width: 200px;
            z-index: 1000;
            overflow: hidden;
        }

        .user-menu-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--secondary-color);
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .user-menu-item:hover {
            background: rgba(30, 64, 175, 0.1);
            color: var(--primary-color);
        }

        .user-menu-item i {
            margin-right: 0.75rem;
            width: 16px;
        }

        .user-menu-divider {
            margin: 0.5rem 0;
            border: none;
            border-top: 1px solid var(--border-color);
        }

        .logout-btn {
            color: var(--danger-color) !important;
        }

        .logout-btn:hover {
            background: rgba(220, 38, 38, 0.1) !important;
            color: var(--danger-color) !important;
        }

        .navbar {
            background: var(--wurger-glass);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--wurger-glass-border);
            padding: 1rem 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .navbar-brand img {
            width: 40px;
            height: 40px;
            margin-right: 0.75rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .navbar-nav {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-left: auto;
        }

        .navbar-search {
            position: relative;
            margin-right: 1rem;
        }

        .navbar-search input {
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid var(--border-color);
            border-radius: 25px;
            padding: 0.75rem 1rem 0.75rem 3rem;
            width: 300px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .navbar-search input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
            background: white;
        }

        .navbar-search i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary-color);
        }

        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(0, 0, 0, 0.1);
            z-index: 1000;
            margin-top: 0.5rem;
            overflow: hidden;
            backdrop-filter: blur(20px);
        }

        .suggestion-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            cursor: pointer;
            transition: all 0.2s ease;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .suggestion-item:last-child {
            border-bottom: none;
        }

        .suggestion-item:hover {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .suggestion-item i {
            margin-right: 0.75rem;
            color: #6b7280;
            width: 20px;
            text-align: center;
        }

        .suggestion-item:hover i {
            color: #3b82f6;
        }

        .suggestion-item span {
            font-weight: 500;
            font-size: 0.9rem;
        }

        .notification-dropdown {
            position: relative;
        }

        .notification-btn {
            background: none;
            border: none;
            color: var(--secondary-color);
            font-size: 1.2rem;
            padding: 0.75rem;
            border-radius: 50%;
            transition: all 0.3s ease;
            position: relative;
        }

        .notification-btn:hover {
            background: rgba(30, 64, 175, 0.1);
            color: var(--primary-color);
        }

        .notification-badge {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .user-dropdown {
            position: relative;
        }

        .user-btn {
            background: none;
            border: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            transition: all 0.3s ease;
            color: var(--secondary-color);
        }

        .user-btn:hover {
            background: rgba(30, 64, 175, 0.1);
            color: var(--primary-color);
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: var(--wurger-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .content-wrapper {
            padding: 2rem;
            min-height: calc(100vh - 80px);
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-color);
            margin: 0 0 0.5rem 0;
            background: var(--wurger-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-subtitle {
            color: var(--secondary-color);
            font-size: 1.1rem;
            margin: 0;
            font-weight: 500;
        }

        .card {
            background: var(--wurger-glass);
            backdrop-filter: blur(20px);
            border: 1px solid var(--wurger-glass-border);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background: rgba(248, 250, 252, 0.8);
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem 2rem;
            font-weight: 700;
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        .card-body {
            padding: 2rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 15px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: var(--wurger-gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(30, 64, 175, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 64, 175, 0.4);
            color: white;
        }

        .btn-success {
            background: linear-gradient(135deg, #059669, #10b981);
            color: white;
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.4);
            color: white;
        }

        .btn-warning {
            background: linear-gradient(135deg, #d97706, #f59e0b);
            color: white;
            box-shadow: 0 4px 15px rgba(217, 119, 6, 0.3);
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(217, 119, 6, 0.4);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            color: white;
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
            color: white;
        }

        .table {
            background: var(--wurger-glass);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--wurger-glass-border);
        }

        .table thead th {
            background: var(--wurger-gradient);
            color: white;
            border: none;
            padding: 1.5rem 1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 0.9rem;
        }

        .table tbody td {
            padding: 1.25rem 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background: rgba(30, 64, 175, 0.05);
        }

        .stats-card {
            background: var(--wurger-glass);
            backdrop-filter: blur(20px);
            border: 1px solid var(--wurger-glass-border);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--wurger-gradient);
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .stats-card .icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
            transition: all 0.3s ease;
        }

        .stats-card:hover .icon {
            transform: scale(1.1) rotate(5deg);
        }

        .stats-card .number {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            background: var(--wurger-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stats-card .label {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--secondary-color);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--primary-color);
            font-size: 1.5rem;
            padding: 0.5rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .sidebar-toggle:hover {
            background: rgba(30, 64, 175, 0.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .main-content.expanded {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: block;
            }

            .navbar-search input {
                width: 200px;
            }

            .content-wrapper {
                padding: 1rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .stats-card {
                padding: 1.5rem;
            }

            .stats-card .number {
                font-size: 2rem;
            }

            .stats-card .icon {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .navbar {
                padding: 1rem;
            }

            .navbar-search {
                display: none;
            }

            .content-wrapper {
                padding: 0.5rem;
            }

            .page-title {
                font-size: 1.75rem;
            }

            .card-body {
                padding: 1rem;
            }

            .stats-card {
                padding: 1rem;
            }

            .stats-card .number {
                font-size: 1.75rem;
            }

            .stats-card .icon {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-container">
                <div class="logo-wrapper">
                    <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Wurger Logo">
                    <div class="logo-glow"></div>
                </div>
                <h2 class="sidebar-title">Wurger</h2>
                <p class="sidebar-subtitle">Sistema de Gestión</p>
                <div class="sidebar-status">
                    <div class="status-dot"></div>
                    <span class="status-text">Sistema Activo</span>
                </div>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <?php if(auth()->guard()->check()): ?>
            <div class="nav-item">
                <?php if(auth()->user()->rol === 'Administrador'): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('user.dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('user.dashboard') ? 'active' : ''); ?>">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                <?php endif; ?>
            </div>

            <?php if(auth()->user()->rol === 'Administrador'): ?>
                <div class="nav-item">
                    <a href="<?php echo e(route('usuarios.index')); ?>" class="nav-link <?php echo e(request()->routeIs('usuarios.*') ? 'active' : ''); ?>">
                        <i class="fas fa-users"></i>
                        <span>Usuarios</span>
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="<?php echo e(route('productos.index')); ?>" class="nav-link <?php echo e(request()->routeIs('productos.*') ? 'active' : ''); ?>">
                        <i class="fas fa-box"></i>
                        <span>Productos</span>
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="<?php echo e(route('ventas.index')); ?>" class="nav-link <?php echo e(request()->routeIs('ventas.*') ? 'active' : ''); ?>">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Ventas</span>
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="<?php echo e(route('clientes.index')); ?>" class="nav-link <?php echo e(request()->routeIs('clientes.*') ? 'active' : ''); ?>">
                        <i class="fas fa-user-tie"></i>
                        <span>Clientes</span>
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="<?php echo e(route('categorias.index')); ?>" class="nav-link <?php echo e(request()->routeIs('categorias.*') ? 'active' : ''); ?>">
                        <i class="fas fa-tags"></i>
                        <span>Categorías</span>
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="<?php echo e(route('inventario.index')); ?>" class="nav-link <?php echo e(request()->routeIs('inventario.*') ? 'active' : ''); ?>">
                        <i class="fas fa-warehouse"></i>
                        <span>Inventario</span>
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="<?php echo e(route('busqueda.index')); ?>" class="nav-link <?php echo e(request()->routeIs('busqueda.*') ? 'active' : ''); ?>">
                        <i class="fas fa-search"></i>
                        <span>Búsqueda</span>
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="<?php echo e(route('reportes.index')); ?>" class="nav-link <?php echo e(request()->routeIs('reportes.*') ? 'active' : ''); ?>">
                        <i class="fas fa-chart-bar"></i>
                        <span>Reportes</span>
                    </a>
                </div>
            <?php else: ?>
                <div class="nav-item">
                    <a href="<?php echo e(route('user.productos.index')); ?>" class="nav-link <?php echo e(request()->routeIs('user.productos.*') ? 'active' : ''); ?>">
                        <i class="fas fa-box"></i>
                        <span>Productos</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="<?php echo e(route('user.pedidos.index')); ?>" class="nav-link <?php echo e(request()->routeIs('user.pedidos.*') ? 'active' : ''); ?>">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Mis Pedidos</span>
                    </a>
                </div>
            <?php endif; ?>
            <?php endif; ?>
        </nav>
    </div>

    <div class="main-content" id="mainContent">
        <div class="top-bar">
            <button class="sidebar-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            
            <?php if(auth()->guard()->check()): ?>
            <div class="top-bar-right">
                <div class="user-info">
                    <span class="user-name"><?php echo e(auth()->user()->usuarioInfo->nombre ?? auth()->user()->email); ?></span>
                    <span class="user-role"><?php echo e(auth()->user()->rol); ?></span>
                </div>
                
                <div class="user-dropdown">
                    <button class="user-btn" onclick="toggleUserMenu()">
                        <i class="fas fa-user-circle"></i>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    
                    <div class="user-menu" id="userMenu" style="display: none;">
                        <a href="#" class="user-menu-item">
                            <i class="fas fa-user"></i>
                            <span>Perfil</span>
                        </a>
                        <a href="#" class="user-menu-item">
                            <i class="fas fa-cog"></i>
                            <span>Configuración</span>
                        </a>
                        <hr class="user-menu-divider">
                        <form action="<?php echo e(route('logout')); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="user-menu-item logout-btn">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Cerrar Sesión</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="content-wrapper">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        }

        function toggleNotifications() {
            const menu = document.getElementById('notificationMenu');
            menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
        }

        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
        }

        // Cerrar menús al hacer clic fuera
        document.addEventListener('click', function(event) {
            const notificationMenu = document.getElementById('notificationMenu');
            const userMenu = document.getElementById('userMenu');
            
            if (!event.target.closest('.notification-dropdown')) {
                notificationMenu.style.display = 'none';
            }
            
            if (!event.target.closest('.user-dropdown')) {
                userMenu.style.display = 'none';
            }
        });

        // Búsqueda en tiempo real
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const query = e.target.value;
            if (query.length > 2) {
                // Implementar búsqueda en tiempo real
                console.log('Buscando:', query);
            }
        });

        // Responsive sidebar
        function handleResize() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            if (window.innerWidth <= 768) {
                sidebar.classList.remove('collapsed');
                mainContent.classList.remove('expanded');
            }
        }

        window.addEventListener('resize', handleResize);
        handleResize();

        // Funcionalidad de búsqueda
        const searchInput = document.getElementById('searchInput');
        const searchSuggestions = document.getElementById('searchSuggestions');

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
                    // Redirigir a la página de búsqueda con parámetros
                    window.location.href = `/busqueda?q=${encodeURIComponent(query)}&type=${type}`;
                } else {
                    // Redirigir a la página de búsqueda general
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
    </script>
</body>
</html><?php /**PATH C:\Users\IBZAN\Desktop\Wurger-act2\resources\views/layouts/app.blade.php ENDPATH**/ ?>