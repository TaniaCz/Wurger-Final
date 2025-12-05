import { useState } from 'react';
import { useNavigate, Link } from 'react-router-dom';

const Register = () => {
    const [formData, setFormData] = useState({
        email: '',
        password: '',
        nombre: '',
        telefono: '',
        direccion: ''
    });
    const [error, setError] = useState('');
    const [showPassword, setShowPassword] = useState(false);
    const navigate = useNavigate();

    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value
        });
    };

    const getPasswordStrength = (password) => {
        let strength = 0;
        if (password.length >= 8) strength += 1;
        if (/[A-Z]/.test(password)) strength += 1;
        if (/[0-9]/.test(password)) strength += 1;
        if (/[^A-Za-z0-9]/.test(password)) strength += 1;
        return strength;
    };

    const getStrengthColor = (strength) => {
        if (strength === 0) return 'bg-secondary';
        if (strength < 3) return 'bg-danger';
        if (strength === 3) return 'bg-warning';
        return 'bg-success';
    };

    const getStrengthText = (strength) => {
        if (strength === 0) return '';
        if (strength < 3) return 'Débil';
        if (strength === 3) return 'Media';
        return 'Fuerte';
    };

    const validateForm = () => {
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        const phoneRegex = /^\d{10}$/;

        if (formData.nombre.length < 3) {
            return 'El nombre debe tener al menos 3 caracteres.';
        }
        if (!emailRegex.test(formData.email)) {
            return 'Por favor, ingresa un correo electrónico válido.';
        }
        if (formData.password.length < 8) {
            return 'La contraseña debe tener al menos 8 caracteres.';
        }
        if (!/[A-Z]/.test(formData.password)) {
            return 'La contraseña debe tener al menos una mayúscula.';
        }
        if (!/[0-9]/.test(formData.password)) {
            return 'La contraseña debe tener al menos un número.';
        }
        if (!/[^A-Za-z0-9]/.test(formData.password)) {
            return 'La contraseña debe tener al menos un carácter especial.';
        }
        if (!phoneRegex.test(formData.telefono)) {
            return 'El teléfono debe tener exactamente 10 dígitos numéricos.';
        }
        if (formData.direccion.length < 10) {
            return 'La dirección debe tener al menos 10 caracteres.';
        }
        return null;
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        const validationError = validateForm();
        if (validationError) {
            setError(validationError);
            return;
        }

        try {
            const response = await fetch('http://localhost:8080/api/auth/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            if (response.ok) {
                navigate('/');
            } else {
                const text = await response.text();
                setError(text || 'Error en el registro');
            }
        } catch (error) {
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

            <div className="card shadow-lg" style={{
                maxWidth: '500px',
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
                    <div className="text-center mb-4">
                        <img
                            src="/logo.png"
                            alt="Wurger Logo"
                            style={{ height: '60px', marginBottom: '10px' }}
                        />
                        <h2 className="text-white mb-4">Registro</h2>
                    </div>

                    {error && <div className="alert alert-danger">{error}</div>}

                    <form onSubmit={handleSubmit}>
                        <div className="mb-3">
                            <label className="form-label text-white">Nombre Completo</label>
                            <input
                                type="text"
                                className="form-control"
                                name="nombre"
                                value={formData.nombre}
                                onChange={handleChange}
                                required
                            />
                        </div>
                        <div className="mb-3">
                            <label className="form-label text-white">Email</label>
                            <input
                                type="email"
                                className="form-control"
                                name="email"
                                value={formData.email}
                                onChange={handleChange}
                                required
                            />
                        </div>
                        <div className="mb-3">
                            <label className="form-label text-white">Contraseña</label>
                            <div className="input-group">
                                <input
                                    type={showPassword ? "text" : "password"}
                                    className="form-control"
                                    name="password"
                                    value={formData.password}
                                    onChange={handleChange}
                                    required
                                />
                                <button
                                    className="btn btn-outline-secondary"
                                    type="button"
                                    onClick={() => setShowPassword(!showPassword)}
                                    style={{ backgroundColor: 'rgba(255,255,255,0.1)', color: 'white' }}
                                >
                                    {showPassword ? '' : ''}
                                </button>
                            </div>
                            {formData.password && (
                                <div className="mt-2">
                                    <div className="progress" style={{ height: '5px' }}>
                                        <div
                                            className={`progress-bar ${getStrengthColor(getPasswordStrength(formData.password))}`}
                                            role="progressbar"
                                            style={{ width: `${(getPasswordStrength(formData.password) / 4) * 100}%` }}
                                        ></div>
                                    </div>
                                    <small className="text-white-50">{getStrengthText(getPasswordStrength(formData.password))}</small>
                                </div>
                            )}
                        </div>
                        <div className="mb-3">
                            <label className="form-label text-white">Teléfono</label>
                            <input
                                type="text"
                                className="form-control"
                                name="telefono"
                                value={formData.telefono}
                                onChange={handleChange}
                                required
                            />
                        </div>
                        <div className="mb-3">
                            <label className="form-label text-white">Dirección</label>
                            <textarea
                                className="form-control"
                                name="direccion"
                                value={formData.direccion}
                                onChange={handleChange}
                                required
                            />
                        </div>
                        <button type="submit" className="btn btn-primary w-100 py-2 fw-bold">
                            Registrarse
                        </button>
                    </form>
                    <div className="mt-3 text-center">
                        <p className="text-white-50">¿Ya tienes cuenta? <Link to="/" className="text-primary text-decoration-none fw-bold">Inicia Sesión</Link></p>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Register;
