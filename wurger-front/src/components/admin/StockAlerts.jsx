import { useState, useEffect } from 'react';
import { Bar, Doughnut } from 'react-chartjs-2';
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend,
    ArcElement
} from 'chart.js';

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend, ArcElement);

const StockAlerts = () => {
    const [lowStockProducts, setLowStockProducts] = useState([]);
    const [allProducts, setAllProducts] = useState([]);
    const [threshold, setThreshold] = useState(10);

    useEffect(() => {
        fetchProducts();
    }, [threshold]);

    const fetchProducts = async () => {
        try {
            const response = await fetch('http://localhost:8080/api/productos');
            const data = await response.json();
            setAllProducts(data);
            const filtered = data.filter(product => product.stock < threshold);
            setLowStockProducts(filtered);
        } catch (error) {
            console.error('Error fetching products:', error);
        }
    };

    const updateStock = async (productId, newStock) => {
        try {
            const product = allProducts.find(p => p.id === productId);
            await fetch(`http://localhost:8080/api/productos/${productId}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    nombreProducto: product.nombreProducto,
                    stock: newStock,
                    stockMin: product.stockMin,
                    stockMax: product.stockMax,
                    precioCompra: product.precioCompra,
                    precioVenta: product.precioVenta,
                    tipoProducto: product.tipoProducto,
                    estado: product.estado,
                    idCategoria: product.categoria?.id
                })
            });
            fetchProducts();
        } catch (error) {
            console.error('Error updating stock:', error);
        }
    };

    const isDarkMode = document.documentElement.getAttribute('data-bs-theme') === 'dark';
    const textColor = isDarkMode ? '#fff' : '#000';
    const gridColor = isDarkMode ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.1)';

    const stockChartData = {
        labels: lowStockProducts.slice(0, 10).map(p => p.nombreProducto),
        datasets: [
            {
                label: 'Stock Actual',
                data: lowStockProducts.slice(0, 10).map(p => p.stock),
                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2,
                borderRadius: 8
            },
            {
                label: 'Stock Mínimo',
                data: lowStockProducts.slice(0, 10).map(p => p.stockMin || threshold),
                backgroundColor: 'rgba(255, 206, 86, 0.6)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 2,
                borderRadius: 8
            }
        ]
    };

    const stockChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
                labels: { color: textColor }
            },
            title: {
                display: true,
                text: 'Productos con Stock Bajo (Top 10)',
                color: textColor,
                font: { size: 16, weight: 'bold' }
            }
        },
        scales: {
            x: {
                ticks: { color: textColor },
                grid: { color: gridColor, display: false }
            },
            y: {
                ticks: { color: textColor },
                grid: { color: gridColor, borderDash: [5, 5] }
            }
        }
    };

    const statusChartData = {
        labels: ['Stock Bajo', 'Stock Normal'],
        datasets: [{
            data: [
                lowStockProducts.length,
                allProducts.length - lowStockProducts.length
            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.8)',
                'rgba(75, 192, 192, 0.8)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 2
        }]
    };

    const statusChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: { color: textColor, padding: 15 }
            },
            title: {
                display: true,
                text: 'Distribución de Stock',
                color: textColor,
                font: { size: 16, weight: 'bold' }
            }
        }
    };

    return (
        <div className="container-fluid animate-fade-in">
            <div className="d-flex justify-content-between align-items-center mb-4">
                <h2 className="mb-0">Alertas de Stock</h2>
                <div className="d-flex align-items-center glass-panel px-3 py-2 rounded-pill">
                    <label className="me-2 mb-0 small text-muted">Umbral de alerta:</label>
                    <input
                        type="number"
                        className="form-control form-control-sm border-0 bg-transparent text-end fw-bold"
                        style={{ width: '60px' }}
                        value={threshold}
                        onChange={(e) => setThreshold(parseInt(e.target.value))}
                        min="1"
                    />
                </div>
            </div>

            {/* Summary Cards */}
            <div className="row mb-4 g-3">
                <div className="col-md-4">
                    <div className={`glass-card h-100 p-4 text-white ${lowStockProducts.length === 0 ? 'bg-success bg-gradient' : 'bg-warning bg-gradient'}`} style={{ '--glass-bg': 'rgba(255,255,255,0.1)' }}>
                        <div className="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 className="mb-1 opacity-75">Productos con Stock Bajo</h6>
                                <h2 className="mb-0 fw-bold">{lowStockProducts.length}</h2>
                            </div>
                            <i className={`bi ${lowStockProducts.length === 0 ? 'bi-check-circle' : 'bi-exclamation-triangle'} fs-1 opacity-50`}></i>
                        </div>
                    </div>
                </div>
                <div className="col-md-4">
                    <div className="glass-card h-100 p-4 text-white bg-info bg-gradient" style={{ '--glass-bg': 'rgba(255,255,255,0.1)' }}>
                        <div className="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 className="mb-1 opacity-75">Total Productos</h6>
                                <h2 className="mb-0 fw-bold">{allProducts.length}</h2>
                            </div>
                            <i className="bi bi-box-seam fs-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div className="col-md-4">
                    <div className="glass-card h-100 p-4 text-white bg-primary bg-gradient" style={{ '--glass-bg': 'rgba(255,255,255,0.1)' }}>
                        <div className="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 className="mb-1 opacity-75">Umbral de Alerta</h6>
                                <h2 className="mb-0 fw-bold">{threshold}</h2>
                            </div>
                            <i className="bi bi-sliders fs-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            {/* Charts Section */}
            <div className="row mb-4 g-4">
                <div className="col-md-8">
                    <div className="glass-panel p-4 rounded-4 h-100">
                        <div style={{ height: '350px' }}>
                            <Bar data={stockChartData} options={stockChartOptions} />
                        </div>
                    </div>
                </div>
                <div className="col-md-4">
                    <div className="glass-panel p-4 rounded-4 h-100">
                        <div style={{ height: '350px' }}>
                            <Doughnut data={statusChartData} options={statusChartOptions} />
                        </div>
                    </div>
                </div>
            </div>

            {/* Products Grid */}
            <h5 className="mb-3 fw-bold">
                <i className="bi bi-box-seam me-2 text-primary"></i>
                Productos con Stock Bajo
            </h5>
            {lowStockProducts.length === 0 ? (
                <div className="glass-panel p-5 rounded-4 text-center">
                    <i className="bi bi-check-circle text-success mb-3" style={{ fontSize: '4rem' }}></i>
                    <h4 className="fw-bold">¡Excelente!</h4>
                    <p className="text-muted">Todos los productos tienen stock suficiente</p>
                </div>
            ) : (
                <div className="row g-3">
                    {lowStockProducts.map((product) => (
                        <div key={product.id} className="col-md-6 col-lg-4">
                            <div className="glass-card h-100 p-3 border-start border-4 border-warning">
                                <div className="d-flex justify-content-between align-items-start mb-3">
                                    <div className="flex-grow-1">
                                        <h6 className="fw-bold mb-1 text-truncate">{product.nombreProducto}</h6>
                                        <p className="text-muted mb-0 small">
                                            {product.categoria?.nombreCategoria || 'Sin categoría'}
                                        </p>
                                    </div>
                                    <span className="badge bg-warning text-dark rounded-pill">
                                        {product.stock} un.
                                    </span>
                                </div>

                                <div className="mb-3">
                                    <div className="d-flex justify-content-between mb-1 small">
                                        <span className="text-muted">Progreso</span>
                                        <span className="text-muted">Min: {product.stockMin || threshold}</span>
                                    </div>
                                    <div className="progress bg-secondary bg-opacity-10" style={{ height: '6px' }}>
                                        <div
                                            className={`progress-bar rounded-pill ${product.stock < (product.stockMin || threshold) / 2 ? 'bg-danger' : 'bg-warning'}`}
                                            role="progressbar"
                                            style={{ width: `${Math.min((product.stock / (product.stockMin || threshold)) * 100, 100)}%` }}
                                        ></div>
                                    </div>
                                </div>

                                <div className="d-flex gap-2">
                                    <button
                                        className="btn btn-sm btn-success flex-grow-1 rounded-pill shadow-sm"
                                        onClick={() => updateStock(product.id, product.stock + 50)}
                                    >
                                        <i className="bi bi-plus-lg me-1"></i>50
                                    </button>
                                    <button
                                        className="btn btn-sm btn-success flex-grow-1 rounded-pill shadow-sm"
                                        onClick={() => updateStock(product.id, product.stock + 100)}
                                    >
                                        <i className="bi bi-plus-lg me-1"></i>100
                                    </button>
                                    <button
                                        className="btn btn-sm btn-light rounded-circle shadow-sm"
                                        style={{ width: 32, height: 32, padding: 0 }}
                                        onClick={() => {
                                            const newStock = window.prompt('Ingrese nuevo stock:', product.stock);
                                            if (newStock) updateStock(product.id, parseInt(newStock));
                                        }}
                                    >
                                        <i className="bi bi-pencil"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            )}
        </div>
    );
};

export default StockAlerts;
