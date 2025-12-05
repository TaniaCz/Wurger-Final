<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Wurger</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            --wurger-shadow-lg: 0 25px 50px rgba(30, 64, 175, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--wurger-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }

        /* Animaciones de fondo */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
            animation: backgroundMove 20s linear infinite;
        }

        @keyframes backgroundMove {
            0% { transform: translateX(0) translateY(0); }
            100% { transform: translateX(-20px) translateY(-20px); }
        }

        /* Partículas flotantes */
        .floating-particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .particle:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .particle:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }

        .particle:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        .particle:nth-child(4) {
            width: 100px;
            height: 100px;
            top: 40%;
            right: 30%;
            animation-delay: 1s;
        }

        .particle:nth-child(5) {
            width: 40px;
            height: 40px;
            bottom: 40%;
            left: 60%;
            animation-delay: 3s;
        }

        @keyframes float {
            0%, 100% { 
                transform: translateY(0px) rotate(0deg); 
                opacity: 0.7;
            }
            50% { 
                transform: translateY(-20px) rotate(180deg); 
                opacity: 1;
            }
        }

        .register-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            box-shadow: var(--wurger-shadow-lg);
            overflow: hidden;
            width: 100%;
            max-width: 600px;
            margin: 20px;
            position: relative;
            z-index: 2;
            animation: slideInUp 0.8s ease-out;
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-height: 90vh;
            overflow-y: auto;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .register-header {
            background: var(--wurger-gradient);
            color: white;
            padding: 2rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .register-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
            animation: grainMove 15s linear infinite;
        }

        @keyframes grainMove {
            0% { transform: translateX(0) translateY(0); }
            100% { transform: translateX(-100px) translateY(-100px); }
        }

        .logo-container {
            position: relative;
            z-index: 2;
            margin-bottom: 2rem;
            animation: logoPulse 3s ease-in-out infinite;
        }

        @keyframes logoPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .logo-container img {
            width: 100px;
            height: 100px;
            filter: brightness(1.2) contrast(1.1);
            transition: transform 0.3s ease;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .logo-container img:hover {
            transform: scale(1.1) rotate(5deg);
        }

        .register-header h2 {
            margin: 0;
            font-weight: 800;
            font-size: 2.2rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            animation: fadeInDown 1s ease-out 0.3s both;
        }

        .register-header p {
            margin: 1rem 0 0 0;
            opacity: 0.9;
            font-size: 1.1rem;
            font-weight: 500;
            animation: fadeInUp 1s ease-out 0.5s both;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .register-body {
            padding: 2rem 2.5rem;
            animation: fadeIn 1s ease-out 0.7s both;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .form-group {
            margin-bottom: 1.25rem;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #374151;
            font-size: 0.95rem;
        }

        .input-group {
            position: relative;
        }

        .input-group .form-control {
            padding-left: 3.5rem;
            padding-right: 1.25rem;
            height: 50px;
            border: 2px solid #e5e7eb;
            border-radius: 15px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }

        .input-group .form-control:focus {
            outline: none;
            border-color: var(--wurger-primary);
            box-shadow: 0 0 0 4px rgba(30, 64, 175, 0.1);
            background: white;
            transform: translateY(-2px);
        }

        .input-group-icon {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--wurger-primary);
            z-index: 10;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .input-group .form-control:focus + .input-group-icon {
            color: var(--wurger-dark);
            transform: translateY(-50%) scale(1.1);
        }

        .btn-register {
            width: 100%;
            background: var(--wurger-gradient);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 15px;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            height: 55px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .btn-register::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-register:hover::before {
            left: 100%;
        }

        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(30, 64, 175, 0.4);
        }

        .btn-register:active {
            transform: translateY(-1px);
        }

        .btn-register:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .alert {
            padding: 1.25rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            font-size: 1rem;
            animation: shake 0.5s ease-in-out;
            border: none;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .alert-success {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
            border: 1px solid #6ee7b7;
            animation: slideInDown 0.5s ease-out;
        }

        .register-footer {
            text-align: center;
            padding: 1.5rem 2.5rem 2rem;
            color: #6b7280;
            font-size: 0.95rem;
            border-top: 1px solid #e5e7eb;
        }

        .loading {
            display: none;
        }

        .loading.show {
            display: inline-block;
        }

        .form-row {
            display: flex;
            gap: 0.75rem;
        }

        .form-row .form-group {
            flex: 1;
        }

        .forgot-link {
            color: var(--wurger-primary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .forgot-link:hover {
            color: var(--wurger-dark);
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .register-container {
                margin: 10px;
                border-radius: 25px;
                max-width: 100%;
                max-height: 95vh;
            }
            
            .register-header {
                padding: 1.5rem 1.5rem;
            }
            
            .register-body {
                padding: 1.5rem 1.5rem;
            }
            
            .logo-container img {
                width: 70px;
                height: 70px;
            }
            
            .register-header h2 {
                font-size: 1.6rem;
            }
            
            .register-header p {
                font-size: 0.9rem;
            }
            
            .form-group {
                margin-bottom: 1rem;
            }
            
            .input-group .form-control {
                height: 45px;
                font-size: 0.9rem;
            }
            
            .btn-register {
                height: 50px;
                font-size: 1rem;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }
        }

        @media (max-width: 480px) {
            .register-container {
                margin: 5px;
                border-radius: 20px;
                max-height: 98vh;
            }
            
            .register-header {
                padding: 1rem 1rem;
            }
            
            .register-body {
                padding: 1rem 1rem;
            }
            
            .logo-container img {
                width: 60px;
                height: 60px;
            }
            
            .register-header h2 {
                font-size: 1.4rem;
            }
            
            .register-header p {
                font-size: 0.85rem;
            }
            
            .input-group .form-control {
                height: 45px;
                font-size: 0.9rem;
                padding-left: 3rem;
            }
            
            .input-group-icon {
                left: 1rem;
                font-size: 0.9rem;
            }
            
            .btn-register {
                height: 45px;
                font-size: 0.95rem;
                padding: 0.75rem 1.5rem;
            }
            
            .particle {
                display: none;
            }
        }

        /* Efectos de hover en el contenedor */
        .register-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px rgba(30, 64, 175, 0.25);
        }
    </style>
</head>
<body>
    <div class="floating-particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>
    
    <div class="register-container">
        <div class="register-header">
            <div class="logo-container">
                <img src="{{ asset('images/logo.png') }}" alt="Wurger Logo">
            </div>
            <h2>Únete a Wurger</h2>
            <p>Crea tu cuenta y comienza a gestionar</p>
        </div>

        <div class="register-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}" id="registerForm">
                @csrf
                
                <div class="form-group">
                    <label for="nombre" class="form-label">Nombre Completo</label>
                    <div class="input-group">
                        <i class="fas fa-user input-group-icon"></i>
                        <input type="text" 
                               class="form-control" 
                               id="nombre" 
                               name="nombre" 
                               value="{{ old('nombre') }}" 
                               required 
                               autofocus
                               placeholder="Tu nombre completo">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <div class="input-group">
                        <i class="fas fa-envelope input-group-icon"></i>
                        <input type="email" 
                               class="form-control" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               placeholder="tu@email.com">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <i class="fas fa-lock input-group-icon"></i>
                            <input type="password" 
                                   class="form-control" 
                                   id="password" 
                                   name="password" 
                                   required
                                   placeholder="••••••••">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="form-label">Confirmar</label>
                        <div class="input-group">
                            <i class="fas fa-lock input-group-icon"></i>
                            <input type="password" 
                                   class="form-control" 
                                   id="password-confirm" 
                                   name="password_confirmation" 
                                   required
                                   placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <div class="input-group">
                            <i class="fas fa-phone input-group-icon"></i>
                            <input type="text" 
                                   class="form-control" 
                                   id="telefono" 
                                   name="telefono" 
                                   value="{{ old('telefono') }}"
                                   placeholder="+1 234 567 8900">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="direccion" class="form-label">Dirección</label>
                        <div class="input-group">
                            <i class="fas fa-map-marker-alt input-group-icon"></i>
                            <input type="text" 
                                   class="form-control" 
                                   id="direccion" 
                                   name="direccion" 
                                   value="{{ old('direccion') }}"
                                   placeholder="Tu dirección">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-register" id="registerBtn">
                    <span class="btn-text">Crear Cuenta</span>
                    <span class="loading">
                        <i class="fas fa-spinner fa-spin"></i> Creando...
                    </span>
                </button>
            </form>
        </div>

        <div class="register-footer">
            <p>¿Ya tienes cuenta? <a href="{{ route('login') }}" class="forgot-link">Inicia sesión aquí</a></p>
            <p>&copy; {{ date('Y') }} Wurger. Todos los derechos reservados.</p>
        </div>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function() {
            const btn = document.getElementById('registerBtn');
            const btnText = btn.querySelector('.btn-text');
            const loading = btn.querySelector('.loading');
            
            btn.disabled = true;
            btnText.style.display = 'none';
            loading.classList.add('show');
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('nombre').focus();
        });

        // Validación de contraseñas
        document.getElementById('password-confirm').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if (password !== confirmPassword) {
                this.setCustomValidity('Las contraseñas no coinciden');
            } else {
                this.setCustomValidity('');
            }
        });

        document.getElementById('password').addEventListener('input', function() {
            const confirmPassword = document.getElementById('password-confirm');
            if (confirmPassword.value) {
                if (this.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity('Las contraseñas no coinciden');
                } else {
                    confirmPassword.setCustomValidity('');
                }
            }
        });
    </script>
</body>
</html>
