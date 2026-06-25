import { useState, useEffect } from 'react';

const API_PLATOS = 'http://localhost:8080/api/productos-terminados';
const API_RECETAS = 'http://localhost:8080/api/recetas';
const API_INSUMOS = 'http://localhost:8080/api/productos';

function DishesManagement() {
    const [platos, setPlatos] = useState([]);
    const [insumos, setInsumos] = useState([]);
    const [showForm, setShowForm] = useState(false);
    const [editingPlato, setEditingPlato] = useState(null);
    const [loading, setLoading] = useState(true);
    const [uploading, setUploading] = useState(false);

    // Form data for Plato
    const [formData, setFormData] = useState({
        nombre: '',
        descripcion: '',
        categoria: 'Comida Rápida',
        costo: '',
        precio: '',
        estado: 'Activo',
        imagen: '',
        recetasLocal: []
    });

    const [tempReceta, setTempReceta] = useState({ idProducto: '', cantidadUsada: '' });
    const [margen, setMargen] = useState(50); // % de ganancia por defecto

    useEffect(() => {
        fetchPlatos();
        fetchInsumos();
    }, []);

    const fetchPlatos = async () => {
        try {
            const response = await fetch(API_PLATOS);
            if(response.ok) {
                const data = await response.json();
                setPlatos(data);
            }
        } catch (error) {
            console.error('Error fetching platos:', error);
        } finally {
            setLoading(false);
        }
    };

    const fetchInsumos = async () => {
        try {
            const response = await fetch(API_INSUMOS);
            if(response.ok) {
                const data = await response.json();
                setInsumos(data);
            }
        } catch (error) {
            console.error('Error fetching insumos:', error);
        }
    };

    const fetchRecetasByPlato = async (idPlato) => {
        try {
            const response = await fetch(`${API_RECETAS}/producto-terminado/${idPlato}`);
            if(response.ok) {
                return await response.json();
            }
        } catch (error) {
            console.error('Error fetching recetas:', error);
        }
        return [];
    };

    const handleFileUpload = async (e) => {
        const file = e.target.files[0];
        if (!file) return;

        const uploadData = new FormData();
        uploadData.append('file', file);

        setUploading(true);
        try {
            const response = await fetch('http://localhost:8080/api/upload', {
                method: 'POST',
                body: uploadData
            });

            if (response.ok) {
                const data = await response.json();
                setFormData(prev => ({ ...prev, imagen: data.url }));
            } else {
                alert('Error al subir imagen');
            }
        } catch (error) {
            console.error('Error uploading file:', error);
            alert('Error de red al subir imagen');
        } finally {
            setUploading(false);
        }
    };

    const handleInputChange = (e) => {
        let { name, value } = e.target;
        if (name === 'precio') {
            // Remove everything except numbers
            value = value.replace(/\D/g, '');
        }
        setFormData({ ...formData, [name]: value });
    };

    const handleAddLocalIngredient = (e) => {
        e.preventDefault();
        if (!tempReceta.idProducto || !tempReceta.cantidadUsada) return;

        const productoObj = insumos.find(i => i.id === parseInt(tempReceta.idProducto));
        if (!productoObj) return;

        const newRecetaLocal = {
            idProducto: parseInt(tempReceta.idProducto),
            cantidadUsada: parseFloat(tempReceta.cantidadUsada),
            productoObj: productoObj
        };

        const newRecetasLocal = [...formData.recetasLocal, newRecetaLocal];
        const totalCosto = newRecetasLocal.reduce((sum, rec) => sum + (rec.productoObj.precioCompra * rec.cantidadUsada), 0);
        const suggestedPrecio = totalCosto * (1 + margen / 100);

        setFormData({ ...formData, recetasLocal: newRecetasLocal, costo: totalCosto, precio: Math.round(suggestedPrecio) });
        setTempReceta({ idProducto: '', cantidadUsada: '' });
    };

    const handleRemoveLocalIngredient = (index) => {
        const itemToRemove = formData.recetasLocal[index];
        const newRecetasLocal = formData.recetasLocal.filter((_, i) => i !== index);

        const totalCosto = newRecetasLocal.reduce((sum, rec) => sum + (rec.productoObj.precioCompra * rec.cantidadUsada), 0);
        const suggestedPrecio = totalCosto * (1 + margen / 100);

        setFormData({ ...formData, recetasLocal: newRecetasLocal, costo: totalCosto, precio: Math.round(suggestedPrecio) });

        if (itemToRemove.id) {
            fetch(`${API_RECETAS}/${itemToRemove.id}`, { method: 'DELETE' }).catch(e => console.error(e));
        }
    };

    const handleSubmitPlato = async (e) => {
        e.preventDefault();
        const url = editingPlato ? `${API_PLATOS}/${editingPlato.id}` : API_PLATOS;
        const method = editingPlato ? 'PUT' : 'POST';

        const payload = {
            nombre: formData.nombre,
            descripcion: formData.descripcion,
            categoria: formData.categoria,
            estado: formData.estado,
            imagen: formData.imagen,
            costo: parseFloat(formData.costo) || 0,
            precio: parseFloat(String(formData.precio).replace(/\D/g, '')) || 0
        };

        try {
            const response = await fetch(url, {
                method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            if (response.ok) {
                const savedPlato = await response.json();
                
                // Save any new recipes
                for (const rec of formData.recetasLocal) {
                    if (!rec.id) {
                        const recPayload = {
                            productoTerminado: { id: savedPlato.id },
                            producto: { id: rec.idProducto },
                            cantidadUsada: rec.cantidadUsada
                        };
                        await fetch(API_RECETAS, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify(recPayload)
                        });
                    }
                }

                fetchPlatos();
                resetForm();
            } else {
                const errText = await response.text();
                alert(`Error al guardar plato: ${response.status} - ${errText}`);
                console.error('Error del servidor:', errText);
            }
        } catch (error) {
            console.error('Error saving plato:', error);
        }
    };

    const handleDeletePlato = async (id) => {
        if (window.confirm('¿Eliminar este plato? (Se perderá su receta)')) {
            try {
                await fetch(`${API_PLATOS}/${id}`, { method: 'DELETE' });
                fetchPlatos();
            } catch (error) {
                console.error('Error al eliminar plato:', error);
            }
        }
    };

    const handleEditPlato = async (plato) => {
        setEditingPlato(plato);
        setFormData({
            nombre: plato.nombre,
            descripcion: plato.descripcion || '',
            categoria: plato.categoria || 'Comida Rápida',
            costo: plato.costo || '',
            precio: plato.precio || '',
            estado: plato.estado || 'Activo',
            imagen: plato.imagen || '',
            recetasLocal: []
        });
        setShowForm(true);

        const recetas = await fetchRecetasByPlato(plato.id);
        const mapped = recetas.map(r => ({
            id: r.id,
            idProducto: r.producto.id,
            cantidadUsada: r.cantidadUsada,
            productoObj: r.producto
        }));
        setFormData(prev => ({ ...prev, recetasLocal: mapped }));
    };

    const resetForm = () => {
        setShowForm(false);
        setEditingPlato(null);
        setFormData({
            nombre: '', descripcion: '', categoria: 'Comida Rápida',
            costo: '', precio: '', estado: 'Activo', imagen: '', recetasLocal: []
        });
        setTempReceta({ idProducto: '', cantidadUsada: '' });
    };

    const formatCOP = (value) => {
        if (!value) return '$0';
        return new Intl.NumberFormat('es-CO', {
            style: 'currency', currency: 'COP', minimumFractionDigits: 0
        }).format(value);
    };

    if (loading) return <div className="text-center p-5"><div className="spinner-border text-primary"></div></div>;

    return (
        <div className="container-fluid animate-fade-in">
            <div className="d-flex justify-content-between align-items-center mb-4">
                <h2 className="mb-0 text-primary fw-bold">Platos y Recetas</h2>
                <button className="btn btn-primary rounded-pill px-4" onClick={() => {
                    if (showForm) resetForm();
                    else setShowForm(true);
                }}>
                    <i className={`bi ${showForm ? 'bi-x-lg' : 'bi-plus-lg'} me-2`}></i>
                    {showForm ? 'Cancelar' : 'Nuevo Plato'}
                </button>
            </div>

            {showForm && (
                <div className="glass-panel p-4 rounded-4 mb-4">
                    <h5 className="mb-3 border-bottom pb-2">{editingPlato ? 'Editar Plato' : 'Crear Plato'}</h5>
                    
                    <div className="row g-4">
                        {/* LEFT COLUMN: Dish Info */}
                        <div className="col-lg-6">
                            <h6 className="fw-bold mb-3 text-primary"><i className="bi bi-info-circle me-2"></i>Información del Plato</h6>
                            <div className="row g-3">
                                <div className="col-md-12">
                                    <label className="form-label" style={{opacity: 0.8}}>Nombre del Plato *</label>
                                    <input type="text" className="form-control bg-transparent" name="nombre" value={formData.nombre} onChange={handleInputChange} style={{color: 'var(--text-color)'}} required />
                                </div>
                                <div className="col-md-6">
                                    <label className="form-label" style={{opacity: 0.8}}>Categoría</label>
                                    <select className="form-select bg-transparent" name="categoria" value={formData.categoria} onChange={handleInputChange} style={{color: 'var(--text-color)'}}>
                                        <option value="Comida Rápida" className="text-dark">Comida Rápida</option>
                                        <option value="Bebidas" className="text-dark">Bebidas</option>
                                        <option value="Postres" className="text-dark">Postres</option>
                                        <option value="Adicionales" className="text-dark">Adicionales</option>
                                    </select>
                                </div>
                                <div className="col-md-6">
                                    <label className="form-label" style={{opacity: 0.8}}>Estado *</label>
                                    <select className="form-select bg-transparent" name="estado" value={formData.estado} onChange={handleInputChange} style={{color: 'var(--text-color)'}} required>
                                        <option value="Activo" className="text-dark">Activo</option>
                                        <option value="Inactivo" className="text-dark">Inactivo</option>
                                    </select>
                                </div>
                                <div className="col-md-12">
                                    <label className="form-label" style={{opacity: 0.8}}>Imagen del Plato</label>
                                    <div className="d-flex flex-column gap-2">
                                        <div className="input-group">
                                            <input type="file" className="form-control bg-transparent" accept="image/*" onChange={handleFileUpload} style={{color: 'var(--text-color)'}} disabled={uploading} />
                                            {uploading && (
                                                <span className="input-group-text">
                                                    <span className="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span>
                                                </span>
                                            )}
                                        </div>
                                        <div className="input-group">
                                            <span className="input-group-text bg-transparent small" style={{color: 'var(--text-color)'}}>URL</span>
                                            <input type="text" className="form-control bg-transparent form-control-sm" name="imagen" value={formData.imagen} onChange={handleInputChange} style={{color: 'var(--text-color)'}} placeholder="O ingresa la URL de la imagen..." />
                                        </div>
                                        {formData.imagen && (
                                            <div className="position-relative mt-1 border rounded-3 p-1 bg-transparent d-inline-block" style={{ maxWidth: '120px' }}>
                                                <img src={formData.imagen} alt="Preview" className="img-thumbnail object-fit-cover w-100" style={{ height: '80px' }} onError={(e) => { e.target.src = 'https://placehold.co/120x80?text=Error'; }} />
                                                <button type="button" className="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 rounded-circle p-1 d-flex align-items-center justify-content-center" style={{ width: '20px', height: '20px', fontSize: '10px' }} onClick={() => setFormData({ ...formData, imagen: '' })}><i className="bi bi-x"></i></button>
                                            </div>
                                        )}
                                    </div>
                                </div>
                                <div className="col-md-12">
                                    <label className="form-label" style={{opacity: 0.8}}>Descripción</label>
                                    <textarea className="form-control bg-transparent" name="descripcion" value={formData.descripcion} onChange={handleInputChange} style={{color: 'var(--text-color)'}} rows="2"></textarea>
                                </div>
                                <div className="col-md-6">
                                    <label className="form-label text-danger" style={{opacity: 0.8}}>Costo Preparación *</label>
                                    <div className="input-group">
                                        <span className="input-group-text bg-transparent text-danger fw-bold">
                                            {formatCOP(formData.costo)}
                                        </span>
                                        <input type="hidden" name="costo" value={formData.costo} />
                                    </div>
                                    <small className="text-muted" style={{fontSize: '0.75rem'}}>Autocalculado por insumos</small>
                                </div>
                                <div className="col-md-6">
                                    <label className="form-label text-success" style={{opacity: 0.8}}>Precio Venta *</label>
                                    <div className="input-group">
                                        <span className="input-group-text bg-transparent text-success">$</span>
                                        <input
                                            type="text"
                                            inputMode="numeric"
                                            className="form-control bg-transparent text-success fw-bold"
                                            name="precio"
                                            value={formData.precio ? new Intl.NumberFormat('es-CO').format(String(formData.precio).replace(/\D/g, '')) : ''}
                                            onChange={handleInputChange}
                                            style={{color: 'var(--text-color)'}}
                                            required
                                        />
                                    </div>
                                    <div className="d-flex align-items-center gap-2 mt-1">
                                        <small className="text-muted" style={{fontSize: '0.72rem'}}>Margen:</small>
                                        {[25, 50, 75, 100].map(m => (
                                            <button
                                                key={m}
                                                type="button"
                                                className={`btn btn-sm py-0 px-1 ${margen === m ? 'btn-success' : 'btn-outline-secondary'}`}
                                                style={{fontSize: '0.68rem'}}
                                                onClick={() => {
                                                    setMargen(m);
                                                    if (formData.costo) {
                                                        setFormData(prev => ({ ...prev, precio: Math.round(prev.costo * (1 + m / 100)) }));
                                                    }
                                                }}
                                            >{m}%</button>
                                        ))}
                                        <small className="text-success ms-auto fw-bold" style={{fontSize: '0.72rem'}}>
                                            {formatCOP(formData.precio)}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* RIGHT COLUMN: Ingredients */}
                        <div className="col-lg-6 border-start">
                            <h6 className="fw-bold mb-3 text-warning"><i className="bi bi-list-check me-2"></i>Insumos de la Receta</h6>
                            
                            <div className="p-3 border rounded-3 mb-3 bg-light bg-opacity-10">
                                <div className="row g-2 align-items-end">
                                    <div className="col-md-7">
                                        <label className="form-label small" style={{opacity: 0.8}}>Seleccionar Insumo</label>
                                        <select className="form-select form-select-sm bg-transparent" style={{color: 'var(--text-color)'}} value={tempReceta.idProducto} onChange={(e) => setTempReceta({...tempReceta, idProducto: e.target.value})}>
                                            <option value="" className="text-dark">Buscar insumo...</option>
                                            {insumos.map(ins => (
                                                <option key={ins.id} value={ins.id} className="text-dark">
                                                    {ins.nombreProducto} ({ins.unidad ? ins.unidad.nombre : 'Und'})
                                                </option>
                                            ))}
                                        </select>
                                    </div>
                                    <div className="col-md-5">
                                        <label className="form-label small" style={{opacity: 0.8}}>Cantidad</label>
                                        <div className="input-group input-group-sm">
                                            <input type="number" step="0.01" min="0.01" className="form-control bg-transparent" style={{color: 'var(--text-color)'}} value={tempReceta.cantidadUsada} onChange={(e) => setTempReceta({...tempReceta, cantidadUsada: e.target.value})} placeholder="Ej: 200" />
                                            <span className="input-group-text bg-transparent" style={{color: 'var(--text-color)'}}>
                                                {tempReceta.idProducto ? insumos.find(i => i.id == tempReceta.idProducto)?.unidad?.nombre || 'Und' : 'Und'}
                                            </span>
                                        </div>
                                    </div>
                                    <div className="col-12 mt-2 text-end">
                                        <button type="button" className="btn btn-sm btn-outline-warning w-100" onClick={handleAddLocalIngredient} disabled={!tempReceta.idProducto || !tempReceta.cantidadUsada}>
                                            <i className="bi bi-plus-circle me-1"></i> Añadir Insumo
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <ul className="list-group list-group-flush border rounded-3 overflow-hidden" style={{maxHeight: '300px', overflowY: 'auto'}}>
                                {formData.recetasLocal.map((rec, index) => (
                                    <li key={index} className="list-group-item d-flex justify-content-between align-items-center bg-transparent" style={{color: 'var(--text-color)'}}>
                                        <div className="d-flex flex-column">
                                            <span className="fw-medium small"><i className="bi bi-dot text-warning"></i> {rec.productoObj.nombreProducto}</span>
                                            <small className="text-muted ms-3" style={{fontSize: '0.75rem'}}>
                                                Costo ud: {formatCOP(rec.productoObj.precioCompra)}
                                            </small>
                                        </div>
                                        <div className="d-flex align-items-center gap-2">
                                            <span className="badge border text-body">
                                                {rec.cantidadUsada} {rec.productoObj.unidad?.nombre || 'Und'}
                                            </span>
                                            <button type="button" className="btn btn-sm btn-outline-danger border-0" onClick={() => handleRemoveLocalIngredient(index)}>
                                                <i className="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </li>
                                ))}
                                {formData.recetasLocal.length === 0 && (
                                    <li className="list-group-item bg-transparent text-center text-muted small py-4">No se han añadido insumos a esta receta.</li>
                                )}
                            </ul>

                        </div>
                    </div>

                    <div className="mt-4 pt-3 border-top text-end">
                        <button type="button" className="btn btn-light me-2 px-4" onClick={resetForm}>Cancelar</button>
                        <button type="button" className="btn btn-success px-5 fw-bold" onClick={handleSubmitPlato}>
                            {editingPlato ? 'Actualizar Plato' : 'Guardar Plato'}
                        </button>
                    </div>
                </div>
            )}

            <div className="glass-panel p-4 rounded-4 mb-4">
                <div className="table-responsive">
                    <table className="table table-hover align-middle" style={{color: 'var(--text-color)'}}>
                        <thead className="bg-transparent border-bottom">
                            <tr>
                                <th style={{opacity: 0.8}}>Plato</th>
                                <th style={{opacity: 0.8}}>Categoría</th>
                                <th style={{opacity: 0.8}}>Costo</th>
                                <th style={{opacity: 0.8}}>Precio Venta</th>
                                <th className="text-end" style={{opacity: 0.8}}>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            {platos.map(plato => (
                                <tr key={plato.id}>
                                    <td className="fw-medium">
                                        <div className="d-flex align-items-center">
                                            {plato.imagen && <img src={plato.imagen} alt="plato" className="rounded me-2 object-fit-cover" style={{width: '40px', height: '40px'}} />}
                                            <div>
                                                {plato.nombre}
                                                <small className="d-block text-muted">{plato.descripcion}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span className="badge border text-body">{plato.categoria || 'Sin Cat'}</span></td>
                                    <td className="fw-bold text-danger">{formatCOP(plato.costo)}</td>
                                    <td className="fw-bold text-success">{formatCOP(plato.precio)}</td>
                                    <td className="text-end">
                                        <button className="btn btn-sm btn-outline-primary me-2 rounded-circle" onClick={() => handleEditPlato(plato)}><i className="bi bi-pencil"></i></button>
                                        <button className="btn btn-sm btn-outline-danger rounded-circle" onClick={() => handleDeletePlato(plato.id)}><i className="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            ))}
                            {platos.length === 0 && (
                                <tr><td colSpan="5" className="text-center py-4" style={{opacity: 0.5}}>No hay platos registrados</td></tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
}

export default DishesManagement;
