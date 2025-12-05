<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - Wurger</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --wurger-primary: #1e40af;
            --wurger-secondary: #3b82f6;
            --wurger-accent: #ea580c;
            --wurger-light: #dbeafe;
            --wurger-dark: #1e3a8a;
            --wurger-gradient: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            --wurger-shadow: 0 20px 40px rgba(30, 64, 175, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }

        .page-header {
            background: var(--wurger-gradient);
            color: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--wurger-shadow);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
            opacity: 0.3;
        }

        .page-header h1 {
            position: relative;
            z-index: 2;
            margin: 0;
            font-size: 2.5rem;
            font-weight: 800;
        }

        .page-header p {
            position: relative;
            z-index: 2;
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .back-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            transform: translateY(-2px);
        }

        .client-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .client-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--wurger-gradient);
        }

        .client-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
        }

        .client-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .client-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--wurger-gradient);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 700;
            margin-right: 1.5rem;
            box-shadow: 0 8px 25px rgba(30, 64, 175, 0.3);
        }

        .client-info h3 {
            margin: 0;
            color: #1f2937;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .client-info p {
            margin: 0.5rem 0 0 0;
            color: #6b7280;
            font-size: 1rem;
        }

        .client-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .detail-item {
            background: rgba(59, 130, 246, 0.05);
            border-radius: 12px;
            padding: 1rem;
            border-left: 4px solid var(--wurger-primary);
        }

        .detail-item h6 {
            color: var(--wurger-primary);
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-item p {
            margin: 0;
            color: #374151;
            font-weight: 500;
        }

        .client-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(59, 130, 246, 0.1);
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--wurger-primary);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.8rem;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 500;
        }

        .search-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 2rem;
        }

        .search-input {
            border: none;
            background: transparent;
            font-size: 1.1rem;
            padding: 0.75rem 0;
            width: 100%;
            color: #374151;
        }

        .search-input:focus {
            outline: none;
        }

        .search-input::placeholder {
            color: #9ca3af;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .empty-state i {
            font-size: 4rem;
            color: #9ca3af;
            margin-bottom: 1rem;
        }

        .empty-state h4 {
            color: #6b7280;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #9ca3af;
            margin-bottom: 0;
        }

        .container {
            max-width: 1200px;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem 0;
            }
            
            .page-header {
                padding: 1.5rem;
                margin-bottom: 1.5rem;
            }
            
            .page-header h1 {
                font-size: 2rem;
            }
            
            .back-btn {
                position: static;
                margin-top: 1rem;
                display: inline-block;
            }
            
            .client-header {
                flex-direction: column;
                text-align: center;
            }
            
            .client-avatar {
                margin-right: 0;
                margin-bottom: 1rem;
            }
            
            .client-details {
                grid-template-columns: 1fr;
            }
            
            .client-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="page-header">
            <a href="{{ route('admin.dashboard') }}" class="back-btn">
                <i class="fas fa-arrow-left me-2"></i>
                Volver al Dashboard
            </a>
            <h1>
                <i class="fas fa-user-friends me-3"></i>
                Clientes Registrados
            </h1>
            <p>Gestiona y visualiza la información de tus clientes</p>
        </div>

        <!-- Búsqueda -->
        <div class="search-container">
            <div class="d-flex align-items-center">
                <i class="fas fa-search me-3 text-muted"></i>
                <input type="text" class="search-input" placeholder="Buscar clientes por nombre, teléfono o dirección..." id="searchInput">
            </div>
        </div>

        <!-- Lista de Clientes -->
        <div class="row" id="clientesList">
            @forelse($clientes as $cliente)
                <div class="col-lg-6 col-xl-4 cliente-item" 
                     data-name="{{ strtolower($cliente->Nom_cliente) }}" 
                     data-phone="{{ strtolower($cliente->Tel_cliente ?? '') }}" 
                     data-address="{{ strtolower($cliente->Direc_cliente ?? '') }}">
                    <div class="client-card">
                        <div class="client-header">
                            <div class="client-avatar">
                                {{ substr($cliente->Nom_cliente, 0, 1) }}
                            </div>
                            <div class="client-info">
                                <h3>{{ $cliente->Nom_cliente }}</h3>
                                <p>{{ $cliente->usuario->email }}</p>
                            </div>
                        </div>
                        
                        <div class="client-details">
                            @if($cliente->Tel_cliente)
                                <div class="detail-item">
                                    <h6><i class="fas fa-phone me-2"></i>Teléfono</h6>
                                    <p>{{ $cliente->Tel_cliente }}</p>
                                </div>
                            @endif
                            
                            @if($cliente->Direc_cliente)
                                <div class="detail-item">
                                    <h6><i class="fas fa-map-marker-alt me-2"></i>Dirección</h6>
                                    <p>{{ $cliente->Direc_cliente }}</p>
                                </div>
                            @endif
                            
                            <div class="detail-item">
                                <h6><i class="fas fa-calendar me-2"></i>Registrado</h6>
                                <p>{{ $cliente->usuario->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        
                        <div class="client-stats">
                            <div class="stat-card">
                                <div class="stat-value">{{ $cliente->pedidos()->count() }}</div>
                                <div class="stat-label">Pedidos</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value">${{ number_format($cliente->usuario->ventas()->sum('Total_venta') ?? 0, 0) }}</div>
                                <div class="stat-label">Total Gastado</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value">{{ $cliente->usuario->ventas()->count() }}</div>
                                <div class="stat-label">Compras</div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fas fa-user-friends"></i>
                        <h4>No hay clientes registrados</h4>
                        <p>Los clientes aparecerán aquí cuando se registren en el sistema.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Paginación -->
        @if($clientes->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $clientes->links() }}
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const clientes = document.querySelectorAll('.cliente-item');
            
            clientes.forEach(cliente => {
                const name = cliente.dataset.name;
                const phone = cliente.dataset.phone;
                const address = cliente.dataset.address;
                
                if (name.includes(searchTerm) || phone.includes(searchTerm) || address.includes(searchTerm)) {
                    cliente.style.display = 'block';
                } else {
                    cliente.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
