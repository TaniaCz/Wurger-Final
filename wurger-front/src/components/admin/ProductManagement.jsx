import { useState, useEffect } from 'react';

const ProductManagement = () => {
    const [products, setProducts] = useState([]);
    const [categories, setCategories] = useState([]);
    const [providers, setProviders] = useState([]);
    const [units, setUnits] = useState([]);
    const [showForm, setShowForm] = useState(false);
    const [editingProduct, setEditingProduct] = useState(null);
    const [formData, setFormData] = useState({
        nombreProducto: '',
        stock: '',
        stockMin: '',
        stockMax: '',
        precioCompra: '',
        estado: 'Activo',
        idCategoria: '',
        idProveedor: '',
        idUnidad: '',
        fechaVencimiento: '',
        imagen: ''
    });

    const [calcValues, setCalcValues] = useState({ cantidad: '', total: '' });

    // Search and filter states
    const [searchTerm, setSearchTerm] = useState('');
    const [filterCategory, setFilterCategory] = useState('');
    const [filterStatus, setFilterStatus] = useState('');
    const [filterStock, setFilterStock] = useState('');
    const [uploading, setUploading] = useState(false);

    const handleFileUpload = async (e) => {
        const file = e.target.files[0];
        if (!file) return;

        const uploadData = new FormData();
        uploadData.append('file', file);

        setUploading(true);
        try {
            const response = await fetch(`\${import.meta.env.VITE_API_URL || 'http://localhost:8080'}/api/upload`, {
                method: 'POST',
                body: uploadData
            });

            if (response.ok) {
                const data = await response.json();
                setFormData(prev => ({ ...prev, imagen: data.url }));
            } else {
                let errorMsg = 'Error desconocido';
                try {
                    const error = await response.json();
                    errorMsg = error.error || errorMsg;
                } catch (err) {
                    try {
                        errorMsg = await response.text();
                    } catch (txtErr) {}
                }
                alert('Error al subir imagen: ' + errorMsg);
            }
        } catch (error) {
            console.error('Error uploading file:', error);
            alert('Error al conectar con el servidor de subida');
        } finally {
            setUploading(false);
        }
    };

    useEffect(() => {
        fetchProducts();
        fetchCategories();
        fetchProviders();
        fetchUnits();
    }, []);

    const fetchCategories = async () => {
        try {
            const response = await fetch(`\${import.meta.env.VITE_API_URL || 'http://localhost:8080'}/api/categorias`);
            const data = await response.json();
            setCategories(data);
        } catch (error) {
            console.error('Error fetching categories:', error);
        }
    };

    const fetchProviders = async () => {
        try {
            const response = await fetch(`\${import.meta.env.VITE_API_URL || 'http://localhost:8080'}/api/proveedores`);
            const data = await response.json();
            setProviders(data);
        } catch (error) {
            console.error('Error fetching providers:', error);
        }
    };

    const fetchUnits = async () => {
        try {
            const response = await fetch(`\${import.meta.env.VITE_API_URL || 'http://localhost:8080'}/api/unidades-medida`);
            const data = await response.json();
            setUnits(data);
        } catch (error) {
            console.error('Error fetching units:', error);
        }
    };

    const fetchProducts = async () => {
        try {
            const response = await fetch(`\${import.meta.env.VITE_API_URL || 'http://localhost:8080'}/api/productos`);
            const data = await response.json();
            setProducts(data);
        } catch (error) {
            console.error('Error fetching products:', error);
        }
    };

    const formatCOP = (value) => {
        if (!value) return '$0';
        const price = value < 1000 ? value * 1000 : value;
        return new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(price);
    };

    const handleCalc = (cantidad, total) => {
        // Limpiar separadores de miles (puntos) para obtener el numero real
        const cleanTotal = String(total).replace(/\./g, '').replace(',', '.');
        const cleanCantidad = String(cantidad).replace(/\./g, '').replace(',', '.');
        setCalcValues({ cantidad, total });
        const t = parseFloat(cleanTotal);
        const c = parseFloat(cleanCantidad);
        if (c > 0 && t > 0) {
            const unitPrice = t / c;
            setFormData(prev => ({ ...prev, precioCompra: unitPrice.toFixed(4) }));
        }
    };

    const formatCalcPreview = (val) => {
        const clean = String(val).replace(/\./g, '').replace(',', '.');
        const n = parseFloat(clean);
        if (isNaN(n)) return '';
        return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', minimumFractionDigits: 0 }).format(n);
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        const url = editingProduct
            ? `\${import.meta.env.VITE_API_URL || 'http://localhost:8080'}/api/productos/${editingProduct.id}`
            : `\${import.meta.env.VITE_API_URL || 'http://localhost:8080'}/api/productos`;
        const method = editingProduct ? 'PUT' : 'POST';

        try {
            const payload = {
                ...formData,
                idCategoria: formData.idCategoria ? parseInt(formData.idCategoria) : null,
                idProveedor: formData.idProveedor ? parseInt(formData.idProveedor) : null,
                idUnidad: formData.idUnidad ? parseInt(formData.idUnidad) : null,
                stock: parseInt(formData.stock),
                stockMin: parseInt(formData.stockMin || 0),
                stockMax: parseInt(formData.stockMax || 0),
                precioCompra: parseFloat(formData.precioCompra || 0),
                fechaVencimiento: formData.fechaVencimiento || null,
                imagen: formData.imagen || null
            };

            const response = await fetch(url, {
                method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            if (response.ok) {
                // Si es un insumo NUEVO, registrar automaticamente el gasto de compra
                if (!editingProduct) {
                    // Usar el total de la calculadora si se uso, sino precio_unitario * stock
                    const totalCompra = calcValues.total
                        ? parseFloat(calcValues.total)
                        : parseFloat(formData.precioCompra || 0) * parseInt(formData.stock || 0);

                    const proveedorNombre = providers.find(p => p.id === parseInt(formData.idProveedor))?.nombre || 'Proveedor';

                    if (totalCompra > 0) {
                        const gastoPayload = {
                            descripcion: `Compra de insumo: ${formData.nombreProducto} (Proveedor: ${proveedorNombre})`,
                            monto: totalCompra,
                            fecha: new Date().toISOString().split('T')[0],
                            categoria: 'Insumos',
                            medioPago: 'Efectivo',
                            idCajaSesion: null
                        };
                        await fetch(`\${import.meta.env.VITE_API_URL || 'http://localhost:8080'}/api/gastos`, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify(gastoPayload)
                        });
                    }
                }

                fetchProducts();
                resetForm();
                alert(editingProduct ? 'Insumo actualizado exitosamente' : 'Insumo creado y gasto registrado automaticamente ✓');
            } else {
                const error = await response.text();
                alert('Error: ' + error);
            }
        } catch (error) {
            console.error('Error saving product:', error);
            alert('Error al guardar insumo');
        }
    };

    const handleDelete = async (id) => {
        if (window.confirm('¿Estás seguro de eliminar este insumo?')) {
            try {
                const response = await fetch(`\${import.meta.env.VITE_API_URL || 'http://localhost:8080'}/api/productos/${id}`, {
                    method: 'DELETE'
                });
                if (response.ok) {
                    fetchProducts();
                    alert('Insumo eliminado');
                }
            } catch (error) {
                console.error('Error deleting product:', error);
            }
        }
    };

    const handleEdit = (product) => {
        setEditingProduct(product);
        setFormData({
            nombreProducto: product.nombreProducto,
            stock: product.stock,
            stockMin: product.stockMin || '',
            stockMax: product.stockMax || '',
            precioCompra: product.precioCompra || '',
            estado: product.estado,
            idCategoria: product.categoria?.id || '',
            idProveedor: product.proveedor?.id || '',
            idUnidad: product.unidad?.id || '',
            fechaVencimiento: product.fechaVencimiento || '',
            imagen: product.imagen || ''
        });
        setShowForm(true);
    };

    const resetForm = () => {
        setShowForm(false);
        setEditingProduct(null);
        setFormData({
            nombreProducto: '',
            stock: '',
            stockMin: '',
            stockMax: '',
            precioCompra: '',
            estado: 'Activo',
            idCategoria: '',
            idProveedor: '',
            idUnidad: '',
            fechaVencimiento: '',
            imagen: ''
        });
        setCalcValues({ cantidad: '', total: '' });
    };

    const getFilteredProducts = () => {
        return products.filter(product => {
            const matchesSearch = product.nombreProducto.toLowerCase().includes(searchTerm.toLowerCase());
            const matchesCategory = filterCategory === '' || product.categoria?.id === parseInt(filterCategory);
            const matchesStatus = filterStatus === '' || product.estado === filterStatus;
            let matchesStock = true;
            if (filterStock === 'bajo') {
                matchesStock = product.stock < (product.stockMin || 10);
            } else if (filterStock === 'normal') {
                matchesStock = product.stock >= (product.stockMin || 10);
            }
            return matchesSearch && matchesCategory && matchesStatus && matchesStock;
        });
    };

    const clearFilters = () => {
        setSearchTerm('');
        setFilterCategory('');
        setFilterStatus('');
        setFilterStock('');
    };

    return (
        <div className="container-fluid animate-fade-in">
            <div className="d-flex justify-content-between align-items-center mb-4">
                <h2 className="mb-0">Gestión de Insumos</h2>
                <button
                    className="btn btn-primary rounded-pill px-4 shadow-sm"
                    onClick={() => setShowForm(!showForm)}
                >
                    <i className={`bi ${showForm ? 'bi-x-lg' : 'bi-plus-lg'} me-2`}></i>
                    {showForm ? 'Cancelar' : 'Nuevo Insumo'}
                </button>
            </div>

            {/* Search and Filters */}
            <div className="glass-panel p-4 rounded-4 mb-4">
                <div className="row g-3">
                    <div className="col-md-4">
                        <div className="input-group">
                            <span className="input-group-text bg-transparent border-end-0">
                                <i className="bi bi-search" style={{color: 'var(--text-color)'}}></i>
                            </span>
                            <input
                                type="text"
                                className="form-control bg-transparent border-start-0 ps-0"
                                placeholder="Buscar por nombre..."
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                                style={{color: 'var(--text-color)'}}
                            />
                        </div>
                    </div>
                    <div className="col-md-2">
                        <select
                            className="form-select bg-transparent"
                            value={filterCategory}
                            onChange={(e) => setFilterCategory(e.target.value)}
                            style={{color: 'var(--text-color)'}}
                        >
                            <option value="" className="text-dark">Todas las categorías</option>
                            {categories.map(cat => (
                                <option key={cat.id} value={cat.id} className="text-dark">{cat.nombreCategoria}</option>
                            ))}
                        </select>
                    </div>
                    <div className="col-md-2">
                        <select
                            className="form-select bg-transparent"
                            value={filterStatus}
                            onChange={(e) => setFilterStatus(e.target.value)}
                            style={{color: 'var(--text-color)'}}
                        >
                            <option value="" className="text-dark">Todos los estados</option>
                            <option value="Activo" className="text-dark">Activo</option>
                            <option value="Inactivo" className="text-dark">Inactivo</option>
                        </select>
                    </div>
                    <div className="col-md-2">
                        <select
                            className="form-select bg-transparent"
                            value={filterStock}
                            onChange={(e) => setFilterStock(e.target.value)}
                            style={{color: 'var(--text-color)'}}
                        >
                            <option value="" className="text-dark">Todos los stocks</option>
                            <option value="bajo" className="text-dark">Stock Bajo</option>
                            <option value="normal" className="text-dark">Stock Normal</option>
                        </select>
                    </div>
                    <div className="col-md-2">
                        <button
                            className="btn btn-outline-secondary w-100"
                            onClick={clearFilters}
                        >
                            <i className="bi bi-x-circle me-1"></i>
                            Limpiar
                        </button>
                    </div>
                </div>
                <div className="mt-3 small" style={{color: 'var(--text-color)', opacity: 0.7}}>
                    <i className="bi bi-info-circle me-1"></i>
                    Mostrando {getFilteredProducts().length} de {products.length} insumos
                </div>
            </div>

            {showForm && (
                <div className="glass-panel p-4 rounded-4 mb-4 animate-fade-in">
                    <h4 className="mb-4">{editingProduct ? 'Editar Insumo' : 'Nuevo Insumo'}</h4>
                    <form onSubmit={handleSubmit}>
                        <div className="row g-3">
                            <div className="col-md-6">
                                <label className="form-label small" style={{opacity: 0.8}}>Nombre del Insumo *</label>
                                <input
                                    type="text"
                                    className="form-control bg-transparent"
                                    value={formData.nombreProducto}
                                    onChange={(e) => setFormData({ ...formData, nombreProducto: e.target.value })}
                                    style={{color: 'var(--text-color)'}}
                                    required
                                />
                            </div>
                            <div className="col-md-3">
                                <label className="form-label small" style={{opacity: 0.8}}>Categoría *</label>
                                <select
                                    className="form-select bg-transparent"
                                    value={formData.idCategoria}
                                    onChange={(e) => setFormData({ ...formData, idCategoria: e.target.value })}
                                    style={{color: 'var(--text-color)'}}
                                    required
                                >
                                    <option value="" className="text-dark">Seleccionar...</option>
                                    {categories.map(cat => (
                                        <option key={cat.id} value={cat.id} className="text-dark">
                                            {cat.nombreCategoria}
                                        </option>
                                    ))}
                                </select>
                            </div>
                            <div className="col-md-3">
                                <label className="form-label small" style={{opacity: 0.8}}>Proveedor *</label>
                                <select
                                    className="form-select bg-transparent"
                                    value={formData.idProveedor}
                                    onChange={(e) => setFormData({ ...formData, idProveedor: e.target.value })}
                                    style={{color: 'var(--text-color)'}}
                                >
                                    <option value="" className="text-dark">Seleccionar...</option>
                                    {providers.map(prov => (
                                        <option key={prov.id} value={prov.id} className="text-dark">
                                            {prov.nombre}
                                        </option>
                                    ))}
                                </select>
                            </div>
                            
                            <div className="col-md-3">
                                <label className="form-label small" style={{opacity: 0.8}}>Stock *</label>
                                <input
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    className="form-control bg-transparent"
                                    value={formData.stock}
                                    onChange={(e) => setFormData({ ...formData, stock: e.target.value })}
                                    style={{color: 'var(--text-color)'}}
                                    required
                                />
                            </div>
                            <div className="col-md-3">
                                <label className="form-label small" style={{opacity: 0.8}}>Unidad Medida *</label>
                                <select
                                    className="form-select bg-transparent"
                                    value={formData.idUnidad}
                                    onChange={(e) => setFormData({ ...formData, idUnidad: e.target.value })}
                                    style={{color: 'var(--text-color)'}}
                                >
                                    <option value="" className="text-dark">Seleccionar...</option>
                                    {units.map(uni => (
                                        <option key={uni.id} value={uni.id} className="text-dark">
                                            {uni.nombre} ({uni.cantidad})
                                        </option>
                                    ))}
                                </select>
                            </div>
                            <div className="col-md-3">
                                <label className="form-label small text-danger fw-bold" style={{opacity: 0.8}}>Costo por Unidad *</label>
                                <div className="input-group">
                                    <span className="input-group-text bg-transparent text-danger">$</span>
                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        className="form-control bg-transparent text-danger fw-bold"
                                        value={formData.precioCompra}
                                        onChange={(e) => setFormData({ ...formData, precioCompra: e.target.value })}
                                        style={{color: 'var(--text-color)'}}
                                        required
                                    />
                                </div>
                                <div className="mt-2 p-2 border rounded-3 bg-light bg-opacity-10 border-info">
                                    <small className="d-block mb-1 fw-bold text-info" style={{fontSize: '0.70rem'}}><i className="bi bi-calculator"></i> Calculadora Automática</small>
                                    <div className="d-flex flex-column gap-1">
                                        <div>
                                            <input
                                                type="text"
                                                inputMode="numeric"
                                                className="form-control form-control-sm bg-transparent"
                                                style={{color: 'var(--text-color)', fontSize: '0.75rem'}}
                                                placeholder="Total pagado ($) ej: 600000"
                                                value={calcValues.total}
                                                onChange={e => handleCalc(calcValues.cantidad, e.target.value)}
                                            />
                                            {calcValues.total && <small className="text-info" style={{fontSize:'0.65rem'}}>{formatCalcPreview(calcValues.total)}</small>}
                                        </div>
                                        <div>
                                            <input
                                                type="text"
                                                inputMode="numeric"
                                                className="form-control form-control-sm bg-transparent"
                                                style={{color: 'var(--text-color)', fontSize: '0.75rem'}}
                                                placeholder="Cantidad comprada ej: 10000"
                                                value={calcValues.cantidad}
                                                onChange={e => handleCalc(e.target.value, calcValues.total)}
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className="col-md-3">
                                <label className="form-label small" style={{opacity: 0.8}}>Fecha Vencimiento</label>
                                <input
                                    type="date"
                                    className="form-control bg-transparent"
                                    value={formData.fechaVencimiento ? formData.fechaVencimiento.substring(0, 10) : ''}
                                    onChange={(e) => setFormData({ ...formData, fechaVencimiento: e.target.value })}
                                    style={{color: 'var(--text-color)'}}
                                />
                            </div>

                            <div className="col-md-3">
                                <label className="form-label small" style={{opacity: 0.8}}>Stock Mínimo</label>
                                <input
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    className="form-control bg-transparent"
                                    value={formData.stockMin}
                                    onChange={(e) => setFormData({ ...formData, stockMin: e.target.value })}
                                    style={{color: 'var(--text-color)'}}
                                />
                            </div>
                            <div className="col-md-3">
                                <label className="form-label small" style={{opacity: 0.8}}>Stock Máximo</label>
                                <input
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    className="form-control bg-transparent"
                                    value={formData.stockMax}
                                    onChange={(e) => setFormData({ ...formData, stockMax: e.target.value })}
                                    style={{color: 'var(--text-color)'}}
                                />
                            </div>
                            <div className="col-md-3">
                                <label className="form-label small" style={{opacity: 0.8}}>Estado *</label>
                                <select
                                    className="form-select bg-transparent"
                                    value={formData.estado}
                                    onChange={(e) => setFormData({ ...formData, estado: e.target.value })}
                                    style={{color: 'var(--text-color)'}}
                                    required
                                >
                                    <option value="Activo" className="text-dark">Activo</option>
                                    <option value="Inactivo" className="text-dark">Inactivo</option>
                                </select>
                            </div>
                            
                            <div className="col-md-6">
                                <label className="form-label small" style={{opacity: 0.8}}>Imagen del Insumo</label>
                                <div className="d-flex flex-column gap-2">
                                    <div className="input-group">
                                        <input
                                            type="file"
                                            className="form-control bg-transparent"
                                            accept="image/*"
                                            onChange={handleFileUpload}
                                            style={{color: 'var(--text-color)'}}
                                            disabled={uploading}
                                        />
                                        {uploading && (
                                            <span className="input-group-text">
                                                <span className="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span>
                                            </span>
                                        )}
                                    </div>
                                    <div className="input-group">
                                        <span className="input-group-text bg-transparent small" style={{color: 'var(--text-color)'}}>URL</span>
                                        <input
                                            type="text"
                                            className="form-control bg-transparent form-control-sm"
                                            value={formData.imagen}
                                            onChange={(e) => setFormData({ ...formData, imagen: e.target.value })}
                                            style={{color: 'var(--text-color)'}}
                                            placeholder="O ingresa la URL de la imagen..."
                                        />
                                    </div>
                                    {formData.imagen && (
                                        <div className="position-relative mt-1 border rounded-3 p-1 bg-transparent d-inline-block" style={{ maxWidth: '120px' }}>
                                            <img 
                                                src={formData.imagen} 
                                                alt="Preview" 
                                                className="img-thumbnail object-fit-cover w-100" 
                                                style={{ height: '80px' }}
                                                onError={(e) => { e.target.src = 'https://placehold.co/120x80?text=Error'; }}
                                            />
                                            <button 
                                                type="button" 
                                                className="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 rounded-circle p-1 d-flex align-items-center justify-content-center" 
                                                style={{ width: '20px', height: '20px', fontSize: '10px' }}
                                                onClick={() => setFormData({ ...formData, imagen: '' })}
                                            >
                                                <i className="bi bi-x"></i>
                                            </button>
                                        </div>
                                    )}
                                </div>
                            </div>
                        </div>
                        <div className="mt-4 d-flex gap-2 justify-content-end">
                            <button type="button" className="btn btn-outline-secondary" onClick={resetForm}>
                                Cancelar
                            </button>
                            <button type="submit" className="btn btn-success px-4">
                                {editingProduct ? 'Actualizar' : 'Crear'} Insumo
                            </button>
                        </div>
                    </form>
                </div>
            )}

            <div className="glass-panel rounded-4 overflow-hidden">
                <div className="table-responsive">
                    <table className="table table-hover mb-0 align-middle" style={{color: 'var(--text-color)'}}>
                        <thead className="bg-transparent bg-opacity-50 border-bottom">
                            <tr>
                                <th className="border-0 px-4 py-3 small text-uppercase" style={{opacity: 0.8}}>Insumo</th>
                                <th className="border-0 px-4 py-3 small text-uppercase" style={{opacity: 0.8}}>Unidad</th>
                                <th className="border-0 px-4 py-3 small text-uppercase" style={{opacity: 0.8}}>Proveedor</th>
                                <th className="border-0 px-4 py-3 small text-uppercase" style={{opacity: 0.8}}>Stock</th>
                                <th className="border-0 px-4 py-3 small text-uppercase" style={{opacity: 0.8}}>Estado</th>
                                <th className="border-0 px-4 py-3 small text-uppercase text-end" style={{opacity: 0.8}}>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            {getFilteredProducts().map((product) => (
                                <tr key={product.id}>
                                    <td className="px-4 py-3">
                                        <div className="d-flex align-items-center">
                                            {product.imagen && (
                                                <img src={product.imagen} alt="" className="rounded-3 me-3 object-fit-cover" style={{ width: 40, height: 40 }} />
                                            )}
                                            <div>
                                                <div className="fw-bold">{product.nombreProducto}</div>
                                                <div className="small" style={{opacity: 0.7}}>Vence: {product.fechaVencimiento ? new Date(product.fechaVencimiento).toLocaleDateString() : 'N/A'}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td className="px-4 py-3">
                                        <span className="badge border" style={{color: 'var(--text-color)', borderColor: 'var(--text-color)'}}>
                                            {product.unidad ? `${product.unidad.nombre} (${product.unidad.cantidad})` : 'N/A'}
                                        </span>
                                    </td>
                                    <td className="px-4 py-3">
                                        {product.proveedor?.nombre || 'N/A'}
                                    </td>
                                    <td className="px-4 py-3">
                                        <div className="d-flex align-items-center">
                                            <div className={`rounded-circle me-2 ${product.stock < (product.stockMin||10) ? 'bg-danger' : 'bg-success'}`} style={{ width: 8, height: 8 }}></div>
                                            {product.stock}
                                        </div>
                                    </td>
                                    <td className="px-4 py-3">
                                        <span className={`badge rounded-pill ${product.estado === 'Activo' ? 'bg-success' : 'bg-secondary'}`}>
                                            {product.estado}
                                        </span>
                                    </td>
                                    <td className="px-4 py-3 text-end">
                                        <button
                                            className="btn btn-sm btn-outline-primary me-2 rounded-circle"
                                            onClick={() => handleEdit(product)}
                                            title="Editar"
                                        >
                                            <i className="bi bi-pencil"></i>
                                        </button>
                                        <button
                                            className="btn btn-sm btn-outline-danger rounded-circle"
                                            onClick={() => handleDelete(product.id)}
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
        </div>
    );
};

export default ProductManagement;
