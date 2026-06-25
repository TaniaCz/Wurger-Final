import { useState, useEffect } from 'react';

const API_URL = `\${import.meta.env.VITE_API_URL || 'http://localhost:8080'}/api/unidades-medida`;

function UnitsManagement() {
    const [unidades, setUnidades] = useState([]);
    const [formData, setFormData] = useState({ nombre: '', cantidad: '' });
    const [editingId, setEditingId] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        fetchUnidades();
    }, []);

    const fetchUnidades = async () => {
        try {
            const response = await fetch(API_URL);
            if (!response.ok) throw new Error('Error en la red');
            const data = await response.json();
            setUnidades(data);
            setLoading(false);
        } catch (error) {
            console.error('Error al cargar unidades:', error);
            setLoading(false);
        }
    };

    const handleInputChange = (e) => {
        setFormData({ ...formData, [e.target.name]: e.target.value });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const requestOptions = {
                method: editingId ? 'PUT' : 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    nombre: formData.nombre,
                    cantidad: parseInt(formData.cantidad) || 0
                })
            };
            const url = editingId ? `${API_URL}/${editingId}` : API_URL;
            await fetch(url, requestOptions);
            
            setFormData({ nombre: '', cantidad: '' });
            setEditingId(null);
            fetchUnidades();
        } catch (error) {
            console.error('Error al guardar unidad:', error);
        }
    };

    const handleEdit = (unidad) => {
        setFormData({ nombre: unidad.nombre, cantidad: unidad.cantidad });
        setEditingId(unidad.id);
    };

    const handleDelete = async (id) => {
        if (window.confirm('¿Estás seguro de que quieres eliminar esta unidad de medida?')) {
            try {
                await fetch(`${API_URL}/${id}`, { method: 'DELETE' });
                fetchUnidades();
            } catch (error) {
                console.error('Error al eliminar unidad:', error);
            }
        }
    };

    if (loading) return <div className="text-center p-5"><div className="spinner-border text-primary" role="status"></div></div>;

    return (
        <div className="container-fluid py-4 animate-fade-in">
            <h2 className="mb-4 fw-bold text-primary">Gestión de Unidades de Medida</h2>

            <div className="row">
                <div className="col-lg-4 mb-4">
                    <div className="glass-panel p-4 rounded-4">
                        <h5 className="mb-3">{editingId ? 'Editar Unidad' : 'Nueva Unidad'}</h5>
                        <form onSubmit={handleSubmit}>
                            <div className="mb-3">
                                <label className="form-label" style={{opacity: 0.8}}>Nombre de la Unidad <span className="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    className="form-control bg-transparent border" 
                                    name="nombre" 
                                    value={formData.nombre} 
                                    onChange={handleInputChange} 
                                    placeholder="Ej: Gramos, Mililitros, Unidades"
                                    style={{color: 'var(--text-color)'}}
                                    required 
                                />
                            </div>
                            <div className="mb-3">
                                <label className="form-label" style={{opacity: 0.8}}>Valor base / Cantidad <span className="text-danger">*</span></label>
                                <input 
                                    type="number" 
                                    className="form-control bg-transparent border" 
                                    name="cantidad" 
                                    value={formData.cantidad} 
                                    onChange={handleInputChange} 
                                    placeholder="Ej: 1000 (para representar 1 KG)"
                                    style={{color: 'var(--text-color)'}}
                                    required 
                                />
                                <small className="text-muted mt-1 d-block">La cantidad te ayuda a hacer equivalencias (Ej: Nombre: Gramos, Cantidad: 1000 = 1 Kilo).</small>
                            </div>
                            
                            <button type="submit" className="btn btn-primary w-100 rounded-3 mt-3">
                                {editingId ? 'Actualizar' : 'Guardar'}
                            </button>
                            {editingId && (
                                <button type="button" className="btn btn-outline-secondary w-100 rounded-3 mt-2" onClick={() => { setEditingId(null); setFormData({ nombre: '', cantidad: '' }); }}>
                                    Cancelar
                                </button>
                            )}
                        </form>
                    </div>
                </div>

                <div className="col-lg-8">
                    <div className="glass-panel p-4 rounded-4">
                        <div className="table-responsive">
                            <table className="table table-hover align-middle" style={{color: 'var(--text-color)'}}>
                                <thead className="bg-transparent border-bottom">
                                    <tr>
                                        <th style={{opacity: 0.8}}>ID</th>
                                        <th style={{opacity: 0.8}}>Nombre de Unidad</th>
                                        <th style={{opacity: 0.8}}>Cantidad Base</th>
                                        <th className="text-end" style={{opacity: 0.8}}>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {unidades.map(u => (
                                        <tr key={u.id}>
                                            <td className="text-muted">#{u.id}</td>
                                            <td className="fw-medium">{u.nombre}</td>
                                            <td><span className="badge border" style={{color: 'var(--text-color)', borderColor: 'var(--text-color)'}}>{u.cantidad}</span></td>
                                            <td className="text-end">
                                                <button className="btn btn-sm btn-outline-primary me-2 rounded-circle" onClick={() => handleEdit(u)}><i className="bi bi-pencil"></i></button>
                                                <button className="btn btn-sm btn-outline-danger rounded-circle" onClick={() => handleDelete(u.id)}><i className="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    ))}
                                    {unidades.length === 0 && (
                                        <tr><td colSpan="4" className="text-center py-4" style={{opacity: 0.5}}>No hay unidades de medida registradas</td></tr>
                                    )}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default UnitsManagement;
