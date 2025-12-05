import { useState } from 'react';
import { useNavigate } from 'react-router-dom';

function Login() {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [showPassword, setShowPassword] = useState(false);
    const [error, setError] = useState('');
    const navigate = useNavigate();

    const handleSubmit = async (e) => {
        e.preventDefault();
        setError('');

        try {
            const response = await fetch('http://localhost:8080/api/auth/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, password })
            });

            if (response.ok) {
                const usuario = await response.json();
                localStorage.setItem('usuario', JSON.stringify(usuario));

                // Prevent back button navigation
                window.history.pushState(null, '', window.location.href);
                window.onpopstate = () => {
                    window.history.pushState(null, '', window.location.href);
                };

                if (usuario.rol === 'Administrador') {
                    navigate('/admin', { replace: true });
                } else {
                    navigate('/client-dashboard', { replace: true });
                }
            } else {
                const errorText = await response.text();
                setError(errorText || 'Usuario o contraseña incorrectos');
            }
        } catch (error) {
            console.error('Login error:', error);
            setError('Error de conexión');
        }
    };

    return (
        <div className="login-container" style={{
            minHeight: '100vh',
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'center',
            backgroundImage: 'url(/login_background.png)',
            backgroundSize: 'cover',
            backgroundPosition: 'center',
            position: 'relative'
        }}>
            {/* Dark overlay */}
            <div style={{
                position: 'absolute',
                top: 0,
                left: 0,
                right: 0,
                bottom: 0,
                backgroundColor: 'rgba(0, 0, 0, 0.6)'
            }}></div>

            {/* Login Card */}
            <div className="card shadow-lg" style={{
                maxWidth: '450px',
                width: '100%',
                margin: '20px',
                borderRadius: '20px',
                overflow: 'hidden',
                position: 'relative',
                zIndex: 1,
                backgroundColor: 'rgba(30, 30, 30, 0.85)',
                border: '1px solid rgba(255,255,255,0.1)'
            }}>
                <div className="card-body p-5">
                    {/* Logo */}
                    <div className="text-center mb-4">
                        <img
                            src="/logo.png"
                            alt="Wurger Logo"
                            style={{ height: '80px', marginBottom: '10px' }}
                        />
                        {/* Removed blue text as requested */}
                    </div>

                    {error && (
                        <div className="alert alert-danger" role="alert">
                            {error}
                        </div>
                    )}

                    <form onSubmit={handleSubmit}>
                        <div className="mb-3">
                            <label htmlFor="email" className="form-label fw-semibold text-white">
                                Correo Electrónico
                            </label>
                            <input
                                type="email"
                                className="form-control form-control-lg"
                                id="email"
                                value={email}
                                onChange={(e) => setEmail(e.target.value)}
                                required
                                placeholder="ejemplo@correo.com"
                                style={{ borderRadius: '10px' }}
                            />
                        </div>

                        <div className="mb-3">
                            <label htmlFor="password" className="form-label fw-semibold text-white">
                                Contraseña
                            </label>
                            <div className="input-group">
                                <input
                                    type={showPassword ? 'text' : 'password'}
                                    className="form-control form-control-lg"
                                    id="password"
                                    value={password}
                                    onChange={(e) => setPassword(e.target.value)}
                                    required
                                    placeholder="••••••••"
                                    style={{ borderRadius: '10px 0 0 10px' }}
                                />
                                <button
                                    className="btn btn-outline-secondary"
                                    type="button"
                                    onClick={() => setShowPassword(!showPassword)}
                                    style={{ borderRadius: '0 10px 10px 0' }}
                                >
                                    <i className={`bi bi-eye${showPassword ? '-slash' : ''}`}></i>
                                </button>
                            </div>
                        </div>

                        <div className="d-flex justify-content-end mb-4">
                            <a href="#" className="text-decoration-none small text-white-50" style={{ transition: 'color 0.3s' }} onMouseOver={(e) => e.target.style.color = '#fff'} onMouseOut={(e) => e.target.style.color = 'rgba(255,255,255,0.5)'}>
                                ¿Olvidaste tu contraseña?
                            </a>
                        </div>

                        <button
                            type="submit"
                            className="btn btn-primary btn-lg w-100 mb-3"
                            style={{ borderRadius: '10px', fontWeight: '600' }}
                        >
                            Ingresar
                        </button>

                        <div className="text-center">
                            <p className="text-white mb-0">
                                ¿No tienes cuenta?{' '}
                                <a href="/register" className="text-primary fw-semibold text-decoration-none">
                                    Regístrate aquí
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
}

export default Login;