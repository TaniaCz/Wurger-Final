import { useState, useEffect } from 'react';

const StockAlerts = () => {
    const [productos, setProductos] = useState([]);
    const [recetas, setRecetas] = useState([]);
    const [platos, setPlatos] = useState([]);
    const [threshold, setThreshold] = useState(10);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        fetchData();
    }, [threshold]);

    const fetchData = async () => {
        try {
            const [prodRes, recRes, platRes] = await Promise.all([
                fetch(`\${import.meta.env.VITE_API_URL || 'http://localhost:8080'}/api/productos`),
                fetch(`\${import.meta.env.VITE_API_URL || 'http://localhost:8080'}/api/recetas`),
                fetch(`\${import.meta.env.VITE_API_URL || 'http://localhost:8080'}/api/productos-terminados`)
            ]);
            const prods = await prodRes.json();
            const recs = await recRes.json();
            const plats = await platRes.json();

            setProductos(prods);
            setRecetas(recs);
            setPlatos(plats);
            setLoading(false);
        } catch (error) {
            console.error('Error fetching data:', error);
            setLoading(false);
        }
    };

    const updateStock = async (productId, newStock) => {
        try {
            const product = productos.find(p => p.id === productId);
            await fetch(`\${import.meta.env.VITE_API_URL || 'http://localhost:8080'}/api/productos/${productId}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    ...product,
                    stock: newStock,
                    idCategoria: product.categoria?.id,
                    idProveedor: product.proveedor?.id,
                    idUnidad: product.unidad?.id
                })
            });
            fetchData();
        } catch (error) {
            console.error('Error updating stock:', error);
        }
    };

    // Derived states
    const lowStockProducts = productos.filter(p => p.stock < (p.stockMin || threshold));
    
    const today = new Date();
    const daysToAlert = 3; // Alert if expiring in 3 days or less
    const expiringProducts = productos.filter(p => {
        if (!p.fechaVencimiento) return false;
        // Parse date properly to avoid timezone issues
        const [year, month, day] = p.fechaVencimiento.split('-');
        const vDate = new Date(year, month - 1, day);
        const todayNoTime = new Date(today.getFullYear(), today.getMonth(), today.getDate());
        
        const diffTime = vDate.getTime() - todayNoTime.getTime();
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        return diffDays <= daysToAlert;
    }).sort((a,b) => new Date(a.fechaVencimiento) - new Date(b.fechaVencimiento));

    // Helper to find affected dishes
    const getAffectedDishes = (productId) => {
        const affectedRecetas = recetas.filter(r => r.producto?.id === productId);
        const dishIds = affectedRecetas.map(r => r.productoTerminado?.id);
        const uniqueDishIds = [...new Set(dishIds)];
        return uniqueDishIds.map(id => platos.find(p => p.id === id)?.nombre).filter(n => n);
    };

    if (loading) return <div className="text-center p-5"><div className="spinner-border text-primary"></div></div>;

    return (
        <div className="container-fluid animate-fade-in pb-5">
            <h2 className="mb-4 fw-bold text-primary">Alertas del Sistema</h2>

            {/* Vencimiento Alerts */}
            <h5 className="mb-3 fw-bold text-danger">
                <i className="bi bi-calendar-x me-2"></i> Insumos por Vencer (Próximos {daysToAlert} días)
            </h5>
            {expiringProducts.length === 0 ? (
                <div className="glass-panel p-4 rounded-4 mb-5 text-center">
                    <i className="bi bi-shield-check text-success mb-2" style={{ fontSize: '2rem' }}></i>
                    <h5 className="mb-0">Todo en orden</h5>
                    <p className="text-muted small">No hay insumos próximos a vencer.</p>
                </div>
            ) : (
                <div className="row g-3 mb-5">
                    {expiringProducts.map(product => {
                        const affected = getAffectedDishes(product.id);
                        const [year, month, day] = product.fechaVencimiento.split('-');
                        const vDate = new Date(year, month - 1, day);
                        const todayNoTime = new Date(today.getFullYear(), today.getMonth(), today.getDate());
                        const daysLeft = Math.ceil((vDate.getTime() - todayNoTime.getTime()) / (1000 * 60 * 60 * 24));
                        
                        return (
                            <div key={product.id} className="col-md-6 col-lg-4">
                                <div className={`glass-card h-100 p-4 border-start border-4 ${daysLeft < 0 ? 'border-danger bg-danger bg-opacity-10' : 'border-warning'}`}>
                                    <div className="d-flex justify-content-between align-items-center mb-2">
                                        <h6 className="fw-bold mb-0" style={{color: 'var(--text-color)'}}>{product.nombreProducto}</h6>
                                        <span className={`badge ${daysLeft < 0 ? 'bg-danger' : 'bg-warning text-dark'}`}>
                                            {daysLeft < 0 ? '¡Vencido!' : `Vence en ${daysLeft} días`}
                                        </span>
                                    </div>
                                    <small className="text-muted d-block mb-3">Fecha: {product.fechaVencimiento}</small>
                                    
                                    {affected.length > 0 && (
                                        <div className="alert alert-danger py-2 px-3 small mb-0 border-0" style={{background: 'rgba(220,53,69,0.15)', color: 'var(--danger-color)'}}>
                                            <i className="bi bi-exclamation-circle me-1"></i> <strong>Platos en riesgo:</strong>
                                            <ul className="mb-0 mt-1 ps-3 text-start">
                                                {affected.map(dish => <li key={dish}>{dish}</li>)}
                                            </ul>
                                        </div>
                                    )}
                                </div>
                            </div>
                        )
                    })}
                </div>
            )}

            {/* Stock Alerts */}
            <div className="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 gap-2">
                <h5 className="fw-bold text-warning mb-0">
                    <i className="bi bi-box-seam me-2"></i> Insumos con Stock Bajo
                </h5>
                <div className="d-flex align-items-center glass-panel px-3 py-1 rounded-pill">
                    <label className="me-2 mb-0 small text-muted">Umbral global:</label>
                    <input
                        type="number"
                        className="form-control form-control-sm border-0 bg-transparent text-end fw-bold"
                        style={{ width: '60px', color: 'var(--text-color)' }}
                        value={threshold}
                        onChange={(e) => setThreshold(parseInt(e.target.value) || 0)}
                        min="1"
                    />
                </div>
            </div>

            {lowStockProducts.length === 0 ? (
                <div className="glass-panel p-4 rounded-4 text-center">
                    <i className="bi bi-check-circle text-success mb-2" style={{ fontSize: '2rem' }}></i>
                    <h5 className="mb-0">Inventario Saludable</h5>
                    <p className="text-muted small">Todos los insumos tienen stock suficiente.</p>
                </div>
            ) : (
                <div className="row g-3">
                    {lowStockProducts.map(product => {
                        const affected = getAffectedDishes(product.id);
                        return (
                            <div key={product.id} className="col-md-6 col-lg-4">
                                <div className="glass-card h-100 p-4 border-start border-4 border-warning">
                                    <div className="d-flex justify-content-between align-items-start mb-2">
                                        <h6 className="fw-bold mb-0" style={{color: 'var(--text-color)'}}>{product.nombreProducto}</h6>
                                        <span className="badge bg-warning text-dark rounded-pill">
                                            Quedan {product.stock} {product.unidad?.nombre || ''}
                                        </span>
                                    </div>
                                    <p className="text-muted small mb-3">Mínimo requerido: {product.stockMin || threshold}</p>
                                    
                                    {affected.length > 0 && (
                                        <div className="alert alert-warning py-2 px-3 small mb-3 border-0" style={{background: 'rgba(255,193,7,0.15)', color: 'var(--warning-color)'}}>
                                            <i className="bi bi-exclamation-triangle me-1"></i> <strong>Pausa en Platos:</strong>
                                            <ul className="mb-0 mt-1 ps-3 text-start">
                                                {affected.map(dish => <li key={dish}>{dish}</li>)}
                                            </ul>
                                        </div>
                                    )}

                                    <div className="d-flex gap-2 mt-auto pt-3 border-top border-secondary-subtle">
                                        <button className="btn btn-sm btn-outline-success flex-grow-1" onClick={() => updateStock(product.id, product.stock + 50)}>+50</button>
                                        <button className="btn btn-sm btn-outline-success flex-grow-1" onClick={() => updateStock(product.id, product.stock + 100)}>+100</button>
                                        <button className="btn btn-sm btn-outline-primary" onClick={() => {
                                            const newStock = window.prompt('Ingrese nuevo stock:', product.stock);
                                            if (newStock) updateStock(product.id, parseInt(newStock));
                                        }}><i className="bi bi-pencil"></i></button>
                                    </div>
                                </div>
                            </div>
                        )
                    })}
                </div>
            )}
        </div>
    );
};

export default StockAlerts;
