import { useEffect, useState } from 'react';

const OrderHistory = ({ userId }) => {
    const [orders, setOrders] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchOrders = async () => {
            try {
                const response = await fetch(`http://localhost:8080/api/ventas/usuario/${userId}`);
                if (response.ok) {
                    const data = await response.json();
                    setOrders(data);
                }
            } catch (error) {
                console.error("Error fetching orders:", error);
            } finally {
                setLoading(false);
            }
        };

        if (userId) {
            fetchOrders();
        }
    }, [userId]);

    const formatPrice = (value) => {
        const price = value < 1000 ? value * 1000 : value;
        return new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(price);
    };

    if (loading) return <p>Cargando historial...</p>;

    if (orders.length === 0) {
        return (
            <div className="text-center py-5">
                <i className="bi bi-clock-history display-1 text-muted"></i>
                <p className="mt-3 text-muted">No tienes pedidos aún.</p>
            </div>
        );
    }

    return (
        <div className="list-group">
            {orders.map((order) => (
                <div key={order.id} className="list-group-item list-group-item-action flex-column align-items-start border-0 shadow-sm mb-3 rounded">
                    <div className="d-flex w-100 justify-content-between">
                        <h5 className="mb-1">Pedido #{order.id}</h5>
                        <small className="text-muted">{new Date(order.fecha).toLocaleString()}</small>
                    </div>
                    <p className="mb-1">Total: {formatPrice(order.totalVenta)}</p>
                    {order.direccion && (
                        <p className="mb-1 small text-muted">
                            <i className="bi bi-geo-alt-fill me-1"></i>
                            {order.direccion}
                        </p>
                    )}
                    {order.observaciones && (
                        <p className="mb-2 small">
                            <i className="bi bi-chat-left-text-fill me-1"></i>
                            <strong>Notas:</strong> {order.observaciones}
                        </p>
                    )}
                    <span className={`badge ${order.estado === 'Pagada' ? 'bg-success' : 'bg-warning text-dark'}`}>
                        {order.estado}
                    </span>
                </div>
            ))}
        </div>
    );
};

export default OrderHistory;
