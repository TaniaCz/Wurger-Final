import { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';

function Menu() {
    const [productos, setProductos] = useState([]);
    const navigate = useNavigate();
    const usuario = JSON.parse(localStorage.getItem('usuario'));

    useEffect(() => {
        // Cargar productos del Backend
        fetch('http://localhost:8080/api/productos')
            .then(res => res.json())
            .then(data => setProductos(data))
            .catch(err => console.error(err));
    }, []);

    const handleLogout = () => {
        localStorage.removeItem('usuario');
        navigate('/login');
    };

    return (
        <div className="container mt-4">
            <div className="d-flex justify-content-between align-items-center mb-4">
                <h2>🍔 Hola, {usuario?.email}</h2>
                <button onClick={handleLogout} className="btn btn-danger">Cerrar Sesión</button>
            </div>

            <div className="row">
                {productos.map(prod => (
                    <div key={prod.id} className="col-md-4 mb-4">
                        <div className="card h-100 shadow-sm">
                            <div className="card-body">
                                <h5 className="card-title">{prod.nombreProducto}</h5>
                                <p className="text-muted">{prod.categoria?.nombreCategoria}</p>
                                <h4 className="text-primary">${prod.precioVenta}</h4>
                                <p className={`badge ${prod.stock > 0 ? 'bg-success' : 'bg-danger'}`}>
                                    Stock: {prod.stock}
                                </p>
                            </div>
                            <div className="card-footer bg-white border-0">
                                <button className="btn btn-warning w-100" disabled={prod.stock === 0}>
                                    {prod.stock > 0 ? 'Agregar al Carrito' : 'Agotado'}
                                </button>
                            </div>
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
}

export default Menu;