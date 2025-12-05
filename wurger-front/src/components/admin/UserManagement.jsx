import { useState, useEffect } from 'react';

const UserManagement = () => {
    const [users, setUsers] = useState([]);
    const [filteredUsers, setFilteredUsers] = useState([]);
    const [selectedUser, setSelectedUser] = useState(null);
    const [userOrders, setUserOrders] = useState([]);
    const [statusFilter, setStatusFilter] = useState('Todos');
    const [searchTerm, setSearchTerm] = useState('');
    const [roleFilter, setRoleFilter] = useState('');

    useEffect(() => {
        fetchUsers();
    }, []);

    useEffect(() => {
        filterUsers();
    }, [users, statusFilter, searchTerm, roleFilter]);

    const filterUsers = () => {
        if (!Array.isArray(users)) {
            setFilteredUsers([]);
            return;
        }

        let filtered = [...users];

        if (searchTerm) {
            filtered = filtered.filter(user =>
                user.email && user.email.toLowerCase().includes(searchTerm.toLowerCase())
            );
        }

        if (statusFilter !== 'Todos') {
            filtered = filtered.filter(user =>
                user.estado && user.estado.toLowerCase() === statusFilter.toLowerCase()
            );
        }

        if (roleFilter) {
            const role = roleFilter.toLowerCase();
            filtered = filtered.filter(user => {
                if (!user.rol) return false;
                const userRole = user.rol.toLowerCase();

                if (role === 'administrador') {
                    return userRole === 'administrador' || userRole === 'admin';
                }
                if (role === 'cliente') {
                    return userRole === 'cliente' || userRole === 'usuario';
                }
                return userRole === role;
            });
        }

        setFilteredUsers(filtered);
    };

    const clearFilters = () => {
        setSearchTerm('');
        setStatusFilter('Todos');
        setRoleFilter('');
    };

    const fetchUsers = async () => {
        try {
            const response = await fetch('http://localhost:8080/api/usuarios');
            if (!response.ok) throw new Error('Error fetching users');
            const data = await response.json();
            setUsers(Array.isArray(data) ? data : []);
        } catch (error) {
            console.error('Error fetching users:', error);
            setUsers([]);
        }
    };

    const fetchUserOrders = async (userId) => {
        try {
            const response = await fetch(`http://localhost:8080/api/ventas/usuario/${userId}`);
            const data = await response.json();
            setUserOrders(data);
        } catch (error) {
            console.error('Error fetching user orders:', error);
        }
    };

    const handleViewUser = (user) => {
        setSelectedUser(user);
        fetchUserOrders(user.id);
    };

    const toggleUserStatus = async (user) => {
        const newStatus = user.estado === 'Activo' ? 'Inactivo' : 'Activo';

        try {
            const response = await fetch(`http://localhost:8080/api/usuarios/${user.id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ ...user, estado: newStatus })
            });

            if (response.ok) {
                fetchUsers();
                if (selectedUser && selectedUser.id === user.id) {
                    setSelectedUser({ ...selectedUser, estado: newStatus });
                }
            } else {
                alert('Error al actualizar estado');
            }
        } catch (error) {
            console.error('Error updating user:', error);
        }
    };

    const formatCOP = (value) => {
        return new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 0
        }).format(value);
    };

    return (
        <div className="container-fluid animate-fade-in">
            <h2 className="mb-4">Gestión de Usuarios</h2>

            {/* Panel de Búsqueda y Filtros */}
            <div className="glass-panel p-4 rounded-4 mb-4">
                <div className="row g-3">
                    <div className="col-md-5">
                        <div className="input-group">
                            <span className="input-group-text bg-transparent border-end-0">
                                <i className="bi bi-search text-muted"></i>
                            </span>
                            <input
                                type="text"
                                className="form-control border-start-0 ps-0"
                                placeholder="Buscar por email..."
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                            />
                        </div>
                    </div>
                    <div className="col-md-2">
                        <select
                            className="form-select"
                            value={roleFilter}
                            onChange={(e) => setRoleFilter(e.target.value)}
                        >
                            <option value="">Todos los roles</option>
                            <option value="Administrador">Administrador</option>
                            <option value="Cliente">Cliente</option>
                        </select>
                    </div>
                    <div className="col-md-3">
                        <select
                            className="form-select"
                            value={statusFilter}
                            onChange={(e) => setStatusFilter(e.target.value)}
                        >
                            <option value="Todos">Todos los estados</option>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
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
                <div className="mt-3 text-muted small">
                    <i className="bi bi-info-circle me-1"></i>
                    Mostrando {filteredUsers.length} de {users.length} usuarios
                </div>
            </div>

            <div className="row g-4">
                <div className="col-md-7">
                    <div className="glass-panel rounded-4 overflow-hidden h-100">
                        <div className="p-4 border-bottom border-secondary-subtle">
                            <h5 className="mb-0 fw-bold">Lista de Usuarios</h5>
                        </div>
                        <div className="table-responsive">
                            <table className="table table-hover mb-0 align-middle">
                                <thead className="bg-light bg-opacity-50">
                                    <tr>
                                        <th className="border-0 px-4 py-3 text-muted small text-uppercase">Email</th>
                                        <th className="border-0 px-4 py-3 text-muted small text-uppercase">Rol</th>
                                        <th className="border-0 px-4 py-3 text-muted small text-uppercase">Estado</th>
                                        <th className="border-0 px-4 py-3 text-muted small text-uppercase text-end">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {filteredUsers.map((user) => (
                                        <tr key={user.id} className={selectedUser?.id === user.id ? 'table-active' : ''}>
                                            <td className="px-4 py-3">
                                                <div className="d-flex align-items-center">
                                                    <div className="rounded-circle bg-primary bg-opacity-10 text-primary d-flex justify-content-center align-items-center me-3" style={{ width: 32, height: 32 }}>
                                                        <i className="bi bi-person"></i>
                                                    </div>
                                                    <div>
                                                        <div className="fw-medium">{user.email}</div>
                                                        <div className="small text-muted">ID: {user.id}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td className="px-4 py-3">
                                                <span className={`badge rounded-pill ${user.rol === 'Administrador' ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary'}`}>
                                                    {user.rol}
                                                </span>
                                            </td>
                                            <td className="px-4 py-3">
                                                <span className={`badge rounded-pill ${user.estado === 'Activo' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary'}`}>
                                                    {user.estado}
                                                </span>
                                            </td>
                                            <td className="px-4 py-3 text-end">
                                                <button
                                                    className="btn btn-sm btn-light me-2"
                                                    onClick={() => handleViewUser(user)}
                                                    title="Ver detalles"
                                                >
                                                    <i className="bi bi-eye"></i>
                                                </button>
                                                <button
                                                    className={`btn btn-sm ${user.estado === 'Activo' ? 'btn-light text-warning' : 'btn-light text-success'}`}
                                                    onClick={() => toggleUserStatus(user)}
                                                    disabled={user.rol === 'Administrador'}
                                                    title={user.rol === 'Administrador' ? 'No se puede desactivar a un administrador' : (user.estado === 'Activo' ? 'Desactivar' : 'Activar')}
                                                >
                                                    <i className={`bi ${user.estado === 'Activo' ? 'bi-slash-circle' : 'bi-check-circle'}`}></i>
                                                </button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div className="col-md-5">
                    <div className="glass-panel rounded-4 h-100 d-flex flex-column">
                        {selectedUser ? (
                            <>
                                <div className="p-4 border-bottom border-secondary-subtle">
                                    <h5 className="mb-0 fw-bold">Detalles de Usuario</h5>
                                </div>
                                <div className="p-4 flex-grow-1 overflow-auto">
                                    <div className="text-center mb-4">
                                        <div className="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex justify-content-center align-items-center mb-3" style={{ width: 80, height: 80 }}>
                                            <i className="bi bi-person fs-1"></i>
                                        </div>
                                        <h5 className="mb-1">{selectedUser.email}</h5>
                                        <div className="d-flex justify-content-center gap-2">
                                            <span className={`badge rounded-pill ${selectedUser.rol === 'Administrador' ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary'}`}>
                                                {selectedUser.rol}
                                            </span>
                                            <span className={`badge rounded-pill ${selectedUser.estado === 'Activo' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary'}`}>
                                                {selectedUser.estado}
                                            </span>
                                        </div>
                                    </div>

                                    <h6 className="fw-bold mb-3">Historial de Pedidos ({userOrders.length})</h6>
                                    {userOrders.length === 0 ? (
                                        <div className="text-center text-muted py-4 bg-light bg-opacity-50 rounded-3">
                                            <i className="bi bi-cart-x fs-4 d-block mb-2"></i>
                                            No tiene pedidos registrados
                                        </div>
                                    ) : (
                                        <div className="d-flex flex-column gap-3">
                                            {userOrders.map((order) => (
                                                <div key={order.id} className="glass-card p-3 border border-secondary-subtle">
                                                    <div className="d-flex justify-content-between align-items-center mb-2">
                                                        <span className="fw-bold">#{order.id}</span>
                                                        <span className={`badge rounded-pill ${order.estado === 'Completada' ? 'bg-success-subtle text-success' :
                                                            order.estado === 'EnProceso' ? 'bg-info-subtle text-info' :
                                                                order.estado === 'Pendiente' ? 'bg-warning-subtle text-warning' : 'bg-danger-subtle text-danger'
                                                            }`}>
                                                            {order.estado === 'EnProceso' ? 'En Proceso' : order.estado}
                                                        </span>
                                                    </div>
                                                    <div className="d-flex justify-content-between align-items-center text-muted small mb-2">
                                                        <span><i className="bi bi-calendar3 me-1"></i>{new Date(order.fecha).toLocaleString()}</span>
                                                        <span className="fw-bold text-body">{formatCOP(order.totalVenta || order.total)}</span>
                                                    </div>

                                                    <div className="bg-light bg-opacity-50 p-2 rounded-2 small">
                                                        <ul className="list-unstyled mb-0">
                                                            {order.detalles && order.detalles.map((detalle, idx) => (
                                                                <li key={idx} className="text-truncate">
                                                                    • {detalle.producto?.nombreProducto || 'Producto'} <span className="text-muted">x{detalle.cantidad}</span>
                                                                </li>
                                                            ))}
                                                        </ul>
                                                    </div>
                                                </div>
                                            ))}
                                        </div>
                                    )}
                                </div>
                            </>
                        ) : (
                            <div className="h-100 d-flex flex-column justify-content-center align-items-center text-muted p-5">
                                <i className="bi bi-person-lines-fill fs-1 mb-3 opacity-50"></i>
                                <p className="mb-0">Selecciona un usuario para ver sus detalles</p>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </div>
    );
};

export default UserManagement;
