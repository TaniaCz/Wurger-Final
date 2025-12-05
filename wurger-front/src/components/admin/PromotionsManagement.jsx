import { useState, useEffect } from 'react';

const PromotionsManagement = () => {
    const [promotions, setPromotions] = useState([]);
    const [products, setProducts] = useState([]);
    const [showModal, setShowModal] = useState(false);
    const [editingPromo, setEditingPromo] = useState(null);
    const [formData, setFormData] = useState({
        nombre: '',
        descripcion: '',
        inicio: '',
        fin: '',
        cantidadUsos: 0,
        estado: 'Activa',
        descuento: 0,
        tipoDescuento: 'PORCENTAJE', // PORCENTAJE o FIJO
        idProducto: ''
    });

    useEffect(() => {
        fetchPromotions();
        fetchProducts();
    }, []);

    const fetchPromotions = async () => {
        try {
            const response = await fetch('http://localhost:8080/api/promociones');
            if (response.ok) {
                const data = await response.json();
                setPromotions(data);
            }
        } catch (error) {
            console.error('Error fetching promotions:', error);
        }
    };

    const fetchProducts = async () => {
        try {
            const response = await fetch('http://localhost:8080/api/productos');
            if (response.ok) {
                const data = await response.json();
                setProducts(data);
            }
        } catch (error) {
            console.error('Error fetching products:', error);
        }
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        const url = editingPromo
            ? `http://localhost:8080/api/promociones/${editingPromo.id}`
            : 'http://localhost:8080/api/promociones';

        const method = editingPromo ? 'PUT' : 'POST';

        try {
            const response = await fetch(url, {
                method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(formData)
            });

            if (response.ok) {
                fetchPromotions();
                setShowModal(false);
                resetForm();
            } else {
                alert('Error al guardar la promoción');
            }
        } catch (error) {
            console.error('Error saving promotion:', error);
        }
    };

    const handleDelete = async (id) => {
        if (!window.confirm('¿Estás seguro de eliminar esta promoción?')) return;

        try {
            const response = await fetch(`http://localhost:8080/api/promociones/${id}`, {
                method: 'DELETE'
            });

            if (response.ok) {
                fetchPromotions();
            } else {
                alert('Error al eliminar la promoción');
            }
        } catch (error) {
            console.error('Error deleting promotion:', error);
        }
    };

    const resetForm = () => {
        setFormData({
            nombre: '',
            descripcion: '',
            inicio: '',
            fin: '',
            cantidadUsos: 0,
            estado: 'Activa',
            descuento: 0,
            tipoDescuento: 'PORCENTAJE',
            idProducto: ''
        });
        setEditingPromo(null);
    };

    const handleEdit = (promo) => {
        setEditingPromo(promo);
        setFormData({
            nombre: promo.nombre,
            descripcion: promo.descripcion,
            inicio: promo.inicio,
            fin: promo.fin,
            cantidadUsos: promo.cantidadUsos,
            estado: promo.estado,
            descuento: promo.descuento || 0,
            tipoDescuento: promo.tipoDescuento || 'PORCENTAJE',
            idProducto: promo.producto?.id || ''
        });
        setShowModal(true);
    };

    const formatCOP = (value) => {
        const price = value < 1000 ? value * 1000 : value;
        return new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(price);
    };

    return (
        <div className="container-fluid animate-fade-in">
            <div className="d-flex justify-content-between align-items-center mb-4">
                <h2 className="mb-0">Gestión de Promociones</h2>
                <button
                    className="btn btn-primary rounded-pill px-4 shadow-sm"
                    onClick={() => { resetForm(); setShowModal(true); }}
                >
                    <i className="bi bi-plus-lg me-2"></i>
                    Nueva Promoción
                </button>
            </div>

            <div className="glass-panel rounded-4 overflow-hidden">
                <div className="table-responsive">
                    <table className="table table-hover mb-0 align-middle">
                        <thead className="bg-light bg-opacity-50">
                            <tr>
                                <th className="border-0 px-4 py-3 text-muted small text-uppercase">Nombre</th>
                                <th className="border-0 px-4 py-3 text-muted small text-uppercase">Producto</th>
                                <th className="border-0 px-4 py-3 text-muted small text-uppercase">Descuento</th>
                                <th className="border-0 px-4 py-3 text-muted small text-uppercase">Vigencia</th>
                                <th className="border-0 px-4 py-3 text-muted small text-uppercase">Estado</th>
                                <th className="border-0 px-4 py-3 text-muted small text-uppercase text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            {promotions.map(promo => (
                                <tr key={promo.id}>
                                    <td className="px-4 py-3">
                                        <div className="fw-bold">{promo.nombre}</div>
                                        <small className="text-muted">{promo.descripcion}</small>
                                    </td>
                                    <td className="px-4 py-3">
                                        <span className="badge bg-light text-dark border">
                                            {promo.producto?.nombreProducto || 'Todos'}
                                        </span>
                                    </td>
                                    <td className="px-4 py-3">
                                        <span className="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">
                                            {promo.tipoDescuento === 'PORCENTAJE'
                                                ? `${promo.descuento}% OFF`
                                                : `${formatCOP(promo.descuento)} OFF`}
                                        </span>
                                    </td>
                                    <td className="px-4 py-3">
                                        <div className="small">
                                            <i className="bi bi-calendar-event me-1 text-muted"></i>
                                            {promo.inicio}
                                        </div>
                                        <div className="small text-muted">
                                            <i className="bi bi-arrow-right me-1"></i>
                                            {promo.fin}
                                        </div>
                                    </td>
                                    <td className="px-4 py-3">
                                        <span className={`badge rounded-pill ${promo.estado === 'Activa' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary'}`}>
                                            {promo.estado}
                                        </span>
                                    </td>
                                    <td className="px-4 py-3 text-end">
                                        <button
                                            className="btn btn-sm btn-light me-2"
                                            onClick={() => handleEdit(promo)}
                                            title="Editar"
                                        >
                                            <i className="bi bi-pencil"></i>
                                        </button>
                                        <button
                                            className="btn btn-sm btn-light text-danger"
                                            onClick={() => handleDelete(promo.id)}
                                            title="Eliminar"
                                        >
                                            <i className="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>

            {/* Modal */}
            {showModal && (
                <>
                    <div className="modal fade show" style={{ display: 'block' }} tabIndex="-1">
                        <div className="modal-dialog modal-lg modal-dialog-centered">
                            <div className="modal-content glass-panel border-0 shadow-lg">
                                <div className="modal-header border-bottom border-secondary-subtle">
                                    <h5 className="modal-title fw-bold">
                                        {editingPromo ? 'Editar Promoción' : 'Nueva Promoción'}
                                    </h5>
                                    <button
                                        type="button"
                                        className="btn-close"
                                        onClick={() => setShowModal(false)}
                                    ></button>
                                </div>
                                <form onSubmit={handleSubmit}>
                                    <div className="modal-body p-4">
                                        <div className="row g-3">
                                            <div className="col-md-6">
                                                <label className="form-label small text-muted">Nombre</label>
                                                <input
                                                    type="text"
                                                    className="form-control"
                                                    required
                                                    value={formData.nombre}
                                                    onChange={e => setFormData({ ...formData, nombre: e.target.value })}
                                                />
                                            </div>
                                            <div className="col-md-6">
                                                <label className="form-label small text-muted">Producto</label>
                                                <select
                                                    className="form-select"
                                                    required
                                                    value={formData.idProducto}
                                                    onChange={e => setFormData({ ...formData, idProducto: e.target.value })}
                                                >
                                                    <option value="">Seleccionar producto...</option>
                                                    {products.map(p => (
                                                        <option key={p.id} value={p.id}>
                                                            {p.nombreProducto} - {formatCOP(p.precioVenta)}
                                                        </option>
                                                    ))}
                                                </select>
                                            </div>
                                            <div className="col-md-6">
                                                <label className="form-label small text-muted">Tipo Descuento</label>
                                                <select
                                                    className="form-select"
                                                    value={formData.tipoDescuento}
                                                    onChange={e => setFormData({ ...formData, tipoDescuento: e.target.value })}
                                                >
                                                    <option value="PORCENTAJE">Porcentaje (%)</option>
                                                    <option value="FIJO">Monto Fijo ($)</option>
                                                </select>
                                            </div>
                                            <div className="col-md-6">
                                                <label className="form-label small text-muted">Valor Descuento</label>
                                                <input
                                                    type="number"
                                                    className="form-control"
                                                    required
                                                    min="0"
                                                    value={formData.descuento}
                                                    onChange={e => setFormData({ ...formData, descuento: parseFloat(e.target.value) })}
                                                />
                                            </div>
                                            <div className="col-md-6">
                                                <label className="form-label small text-muted">Fecha Inicio</label>
                                                <input
                                                    type="date"
                                                    className="form-control"
                                                    required
                                                    value={formData.inicio}
                                                    onChange={e => setFormData({ ...formData, inicio: e.target.value })}
                                                />
                                            </div>
                                            <div className="col-md-6">
                                                <label className="form-label small text-muted">Fecha Fin</label>
                                                <input
                                                    type="date"
                                                    className="form-control"
                                                    required
                                                    value={formData.fin}
                                                    onChange={e => setFormData({ ...formData, fin: e.target.value })}
                                                />
                                            </div>
                                            <div className="col-12">
                                                <label className="form-label small text-muted">Descripción</label>
                                                <textarea
                                                    className="form-control"
                                                    rows="2"
                                                    value={formData.descripcion}
                                                    onChange={e => setFormData({ ...formData, descripcion: e.target.value })}
                                                ></textarea>
                                            </div>
                                            <div className="col-md-6">
                                                <label className="form-label small text-muted">Estado</label>
                                                <select
                                                    className="form-select"
                                                    value={formData.estado}
                                                    onChange={e => setFormData({ ...formData, estado: e.target.value })}
                                                >
                                                    <option value="Activa">Activa</option>
                                                    <option value="Inactiva">Inactiva</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="modal-footer border-top border-secondary-subtle">
                                        <button
                                            type="button"
                                            className="btn btn-secondary"
                                            onClick={() => setShowModal(false)}
                                        >
                                            Cancelar
                                        </button>
                                        <button type="submit" className="btn btn-primary px-4">
                                            Guardar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div className="modal-backdrop fade show" style={{ backdropFilter: 'blur(5px)' }}></div>
                </>
            )}
        </div>
    );
};

export default PromotionsManagement;
