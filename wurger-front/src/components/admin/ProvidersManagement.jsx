import { useState, useEffect } from 'react';

const API_URL = `\${import.meta.env.VITE_API_URL || 'http://localhost:8080'}/api/proveedores`;

function ProvidersManagement() {
    const [proveedores, setProveedores] = useState([]);
    const [insumos, setInsumos] = useState([]);
    const [formData, setFormData] = useState({ nombre: '', telefono: '', email: '', direccion: '', categoriaProveedor: '', estado: 'Activo' });
    const [editingId, setEditingId] = useState(null);
    const [loading, setLoading] = useState(true);
    const [formErrors, setFormErrors] = useState({});

    // Modal state for Inventory
    const [selectedProvider, setSelectedProvider] = useState(null);

    useEffect(() => {
        fetchProveedores();
        fetchInsumos();
    }, []);

    const fetchInsumos = async () => {
        try {
            const response = await fetch(`\${import.meta.env.VITE_API_URL || 'http://localhost:8080'}/api/productos`);
            if (response.ok) {
                const data = await response.json();
                setInsumos(data);
            }
        } catch (error) {
            console.error('Error fetching insumos:', error);
        }
    };

    const fetchProveedores = async () => {
        try {
            const response = await fetch(API_URL);
            if (!response.ok) throw new Error('Error en la red');
            const data = await response.json();
            setProveedores(data);
            setLoading(false);
        } catch (error) {
            console.error('Error al cargar proveedores:', error);
            setLoading(false);
        }
    };

    const handleInputChange = (e) => {
        let { name, value } = e.target;
        // Telefono: solo numeros, max 10 digitos
        if (name === 'telefono') {
            value = value.replace(/\D/g, '').slice(0, 10);
        }
        setFormData({ ...formData, [name]: value });
        // Limpiar error del campo al escribir
        if (formErrors[name]) {
            setFormErrors({ ...formErrors, [name]: '' });
        }
    };

    const validateForm = () => {
        const errors = {};
        if (!formData.nombre || formData.nombre.trim().length < 2)
            errors.nombre = 'El nombre es obligatorio (mínimo 2 caracteres).';
        if (formData.telefono && !/^\d{10}$/.test(formData.telefono))
            errors.telefono = 'El teléfono debe tener exactamente 10 dígitos.';
        if (formData.email && !/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/.test(formData.email))
            errors.email = 'Ingresa un correo electrónico válido.';
        if (!formData.categoriaProveedor || formData.categoriaProveedor.trim().length < 2)
            errors.categoriaProveedor = 'La categoría es obligatoria (indica qué provee).';
        return errors;
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        const errors = validateForm();
        if (Object.keys(errors).length > 0) {
            setFormErrors(errors);
            return;
        }
        setFormErrors({});
        try {
            const requestOptions = {
                method: editingId ? 'PUT' : 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(formData)
            };
            const url = editingId ? `${API_URL}/${editingId}` : API_URL;
            const response = await fetch(url, requestOptions);
            if (response.ok) {
                setFormData({ nombre: '', telefono: '', email: '', direccion: '', categoriaProveedor: '', estado: 'Activo' });
                setEditingId(null);
                fetchProveedores();
            } else {
                alert('Error al guardar el proveedor');
            }
        } catch (error) {
            console.error('Error al guardar proveedor:', error);
        }
    };

    const handleEdit = (proveedor) => {
        setFormData(proveedor);
        setEditingId(proveedor.id);
    };

    const handleDelete = async (id) => {
        if (window.confirm('¿Estás seguro de que quieres eliminar este proveedor?')) {
            try {
                await fetch(`${API_URL}/${id}`, { method: 'DELETE' });
                fetchProveedores();
            } catch (error) {
                console.error('Error al eliminar proveedor:', error);
            }
        }
    };

    if (loading) return <div className="text-center p-5"><div className="spinner-border text-primary" role="status"></div></div>;

    return (
        <div className="container-fluid py-4">
            <h2 className="mb-4 fw-bold text-primary">Gestión de Proveedores</h2>

            <div className="row">
                <div className="col-lg-4 mb-4">
                    <div className="glass-panel p-4 rounded-4">
                        <h5 className="mb-3">{editingId ? 'Editar Proveedor' : 'Nuevo Proveedor'}</h5>
                        <form onSubmit={handleSubmit}>
                            <div className="mb-3">
                                <label className="form-label">Nombre <span className="text-danger">*</span></label>
                                <input type="text" className={`form-control bg-transparent border ${formErrors.nombre ? 'border-danger' : ''}`} name="nombre" value={formData.nombre} onChange={handleInputChange} required />
                                {formErrors.nombre && <small className="text-danger d-block mt-1"><i className="bi bi-exclamation-circle me-1"></i>{formErrors.nombre}</small>}
                            </div>
                            <div className="mb-3">
                                <label className="form-label">Teléfono <small className="text-muted">(10 dígitos)</small></label>
                                <input
                                    type="text"
                                    inputMode="numeric"
                                    className={`form-control bg-transparent border ${formErrors.telefono ? 'border-danger' : ''}`}
                                    name="telefono"
                                    value={formData.telefono}
                                    onChange={handleInputChange}
                                    placeholder="Ej: 3001234567"
                                />
                                {formErrors.telefono && <small className="text-danger d-block mt-1"><i className="bi bi-exclamation-circle me-1"></i>{formErrors.telefono}</small>}
                                {formData.telefono && !formErrors.telefono && (
                                    <small className={`d-block mt-1 ${formData.telefono.length === 10 ? 'text-success' : 'text-warning'}`}>
                                        {formData.telefono.length}/10 dígitos
                                    </small>
                                )}
                            </div>
                            <div className="mb-3">
                                <label className="form-label">Email</label>
                                <input type="text" className={`form-control bg-transparent border ${formErrors.email ? 'border-danger' : ''}`} name="email" value={formData.email} onChange={handleInputChange} placeholder="Ej: proveedor@email.com" />
                                {formErrors.email && <small className="text-danger d-block mt-1"><i className="bi bi-exclamation-circle me-1"></i>{formErrors.email}</small>}
                            </div>
                            <div className="mb-3">
                                <label className="form-label">Dirección</label>
                                <input type="text" className="form-control bg-transparent border" name="direccion" value={formData.direccion} onChange={handleInputChange} />
                            </div>
                            <div className="mb-3">
                                <label className="form-label">Categoría / Qué provee <span className="text-danger">*</span></label>
                                <input
                                    type="text"
                                    className={`form-control bg-transparent border ${formErrors.categoriaProveedor ? 'border-danger' : ''}`}
                                    name="categoriaProveedor"
                                    value={formData.categoriaProveedor}
                                    onChange={handleInputChange}
                                    placeholder="Ej: Carnes, Verduras, Empaques"
                                />
                                {formErrors.categoriaProveedor && <small className="text-danger d-block mt-1"><i className="bi bi-exclamation-circle me-1"></i>{formErrors.categoriaProveedor}</small>}
                            </div>
                            <div className="mb-3">
                                <label className="form-label">Estado</label>
                                <select className="form-select bg-transparent border" name="estado" value={formData.estado} onChange={handleInputChange}>
                                    <option value="Activo">Activo</option>
                                    <option value="Inactivo">Inactivo</option>
                                </select>
                            </div>
                            <button type="submit" className="btn btn-primary w-100 rounded-3">
                                {editingId ? 'Actualizar' : 'Guardar'}
                            </button>
                            {editingId && (
                                <button type="button" className="btn btn-outline-secondary w-100 rounded-3 mt-2" onClick={() => { setEditingId(null); setFormData({ nombre: '', telefono: '', email: '', direccion: '', categoriaProveedor: '', estado: 'Activo' }); setFormErrors({}); }}>
                                    Cancelar
                                </button>
                            )}
                        </form>
                    </div>
                </div>

                <div className="col-lg-8">
                    <div className="glass-panel p-4 rounded-4">
                        <div className="table-responsive">
                            <table className="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th style={{color: 'var(--text-color)', opacity: 0.8}}>Nombre</th>
                                        <th style={{color: 'var(--text-color)', opacity: 0.8}}>Especialidad</th>
                                        <th style={{color: 'var(--text-color)', opacity: 0.8}}>Contacto</th>
                                        <th style={{color: 'var(--text-color)', opacity: 0.8}}>Inventario</th>
                                        <th style={{color: 'var(--text-color)', opacity: 0.8}} className="text-end">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {proveedores.map(p => {
                                        const provInsumos = insumos.filter(ins => ins.proveedor?.id === p.id);
                                        const totalStock = provInsumos.reduce((sum, current) => sum + current.stock, 0);
                                        return (
                                        <tr key={p.id}>
                                            <td className="fw-medium text-body">{p.nombre}</td>
                                            <td><span className="badge bg-secondary bg-opacity-25 text-body border rounded-pill">{p.categoriaProveedor || 'General'}</span></td>
                                            <td>
                                                <small className="d-block text-muted"><i className="bi bi-telephone me-1"></i> {p.telefono || 'N/A'}</small>
                                                <small className="d-block text-muted"><i className="bi bi-envelope me-1"></i> {p.email || 'N/A'}</small>
                                            </td>
                                            <td>
                                                <button className="btn btn-sm btn-outline-info rounded-pill" onClick={() => setSelectedProvider(p)}>
                                                    <i className="bi bi-box-seam me-1"></i> {provInsumos.length} Insumos
                                                </button>
                                                <small className="d-block text-muted mt-1">Total stock: {totalStock}</small>
                                            </td>
                                            <td className="text-end">
                                                <button className="btn btn-sm btn-outline-primary me-2 rounded-circle" onClick={() => handleEdit(p)}><i className="bi bi-pencil"></i></button>
                                                <button className="btn btn-sm btn-outline-danger rounded-circle" onClick={() => handleDelete(p.id)}><i className="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    )})}
                                    {proveedores.length === 0 && (
                                        <tr><td colSpan="4" className="text-center py-4 text-muted">No hay proveedores registrados</td></tr>
                                    )}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {/* Modal de Inventario */}
            {selectedProvider && (
                <div className="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center animate-fade-in" style={{backgroundColor: 'rgba(0,0,0,0.6)', zIndex: 1050}}>
                    <div className="glass-panel rounded-4 p-4 w-100 shadow-lg border border-secondary border-opacity-25" style={{maxWidth: '700px', maxHeight: '90vh', overflowY: 'auto', background: 'var(--bg-color)'}}>
                        <div className="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                            <div>
                                <h4 className="mb-1 fw-bold text-primary">Inventario de {selectedProvider.nombre}</h4>
                                <span className="text-muted small"><i className="bi bi-telephone"></i> {selectedProvider.telefono}</span>
                            </div>
                            <button className="btn-close" onClick={() => setSelectedProvider(null)}></button>
                        </div>
                        
                        <div className="alert py-2 small border-0" style={{background: 'rgba(13,110,253,0.1)', color: 'var(--text-color)'}}>
                            <i className="bi bi-info-circle text-primary me-2"></i>
                            Aquí puedes ver todos los insumos que te vende este proveedor y cuánto stock te queda de cada uno para que sepas exactamente qué pedirle.
                        </div>

                        <div className="list-group list-group-flush mt-3">
                            {insumos.filter(ins => ins.proveedor?.id === selectedProvider.id).map(ins => (
                                <div key={ins.id} className="list-group-item d-flex justify-content-between align-items-center bg-transparent border-bottom border-secondary-subtle py-3 px-1">
                                    <div>
                                        <h6 className="mb-1 fw-bold" style={{color: 'var(--text-color)'}}>{ins.nombreProducto}</h6>
                                        <small className="text-muted">Minimo requerido: {ins.stockMin || 'N/A'}</small>
                                    </div>
                                    <div className="text-end">
                                        <span className={`badge rounded-pill fs-6 ${ins.stock <= (ins.stockMin || 10) ? 'bg-danger text-white' : 'bg-success text-white'}`}>
                                            Stock: {ins.stock} {ins.unidad?.nombre || ''}
                                        </span>
                                        {ins.fechaVencimiento && (
                                            <small className="d-block text-muted mt-1" style={{fontSize: '0.7rem'}}>
                                                Vence: {ins.fechaVencimiento}
                                            </small>
                                        )}
                                    </div>
                                </div>
                            ))}
                            {insumos.filter(ins => ins.proveedor?.id === selectedProvider.id).length === 0 && (
                                <div className="text-center py-5 text-muted">
                                    <i className="bi bi-box-seam display-4 opacity-25 d-block mb-3"></i>
                                    Aún no tienes insumos asociados a este proveedor.<br/>Ve a la pestaña "Insumos" y créalos asignando a {selectedProvider.nombre}.
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
}

export default ProvidersManagement;
