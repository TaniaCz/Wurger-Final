# 🚀 Sistema Wurger - Relaciones Completas y Funcionales

## 📊 **Diagrama de Relaciones del Sistema**

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│     Usuario     │    │  UsuarioInfo    │    │     Pedido      │
│   (auth table)  │◄──►│  (user details) │◄──►│   (orders)      │
└─────────────────┘    └─────────────────┘    └─────────────────┘
         │                       │                       │
         │                       │                       │
         ▼                       ▼                       ▼
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│     Venta       │    │  PedidoProducto │    │    Producto     │
│   (sales)       │◄──►│ (order items)   │◄──►│   (products)    │
└─────────────────┘    └─────────────────┘    └─────────────────┘
         │                       │                       │
         │                       │                       │
         ▼                       ▼                       ▼
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│  DetalleVenta   │    │    Movimiento   │    │CategoriaProducto│
│ (sale details)  │    │  (inventory)    │    │  (categories)   │
└─────────────────┘    └─────────────────┘    └─────────────────┘
```

## 🔗 **Relaciones Implementadas**

### **1. Usuario ↔ UsuarioInfo**
```php
// Usuario.php
public function usuarioInfo() {
    return $this->hasOne(UsuarioInfo::class, 'id_usuario', 'id_usuario');
}

// UsuarioInfo.php
public function usuario() {
    return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
}
```

### **2. UsuarioInfo ↔ Pedido**
```php
// UsuarioInfo.php
public function pedidos() {
    return $this->hasMany(Pedido::class, 'id_usuario_info', 'id_usuario_info');
}

// Pedido.php
public function usuarioInfo() {
    return $this->belongsTo(UsuarioInfo::class, 'id_usuario_info', 'id_usuario_info');
}
```

### **3. Pedido ↔ PedidoProducto ↔ Producto**
```php
// Pedido.php
public function pedidoProductos() {
    return $this->hasMany(PedidoProducto::class, 'id_pedido', 'id_pedido');
}

public function productos() {
    return $this->belongsToMany(Producto::class, 'pedido_producto', 'id_pedido', 'id_producto')
                ->withPivot('cantidad', 'precio_unitario', 'subtotal');
}

// PedidoProducto.php
public function pedido() {
    return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');
}

public function producto() {
    return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
}

// Producto.php
public function pedidoProductos() {
    return $this->hasMany(PedidoProducto::class, 'id_producto', 'id_producto');
}

public function pedidos() {
    return $this->belongsToMany(Pedido::class, 'pedido_producto', 'id_producto', 'id_pedido')
                ->withPivot('cantidad', 'precio_unitario', 'subtotal');
}
```

### **4. Venta ↔ Pedido**
```php
// Venta.php
public function pedido() {
    return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');
}

// Pedido.php
public function ventas() {
    return $this->hasMany(Venta::class, 'id_pedido', 'id_pedido');
}
```

### **5. Usuario ↔ Venta**
```php
// Usuario.php
public function ventas() {
    return $this->hasMany(Venta::class, 'id_usuario', 'id_usuario');
}

// Venta.php
public function usuario() {
    return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
}
```

### **6. Producto ↔ CategoriaProducto**
```php
// Producto.php
public function categoria() {
    return $this->belongsTo(CategoriaProducto::class, 'id_categoria', 'id_categoria');
}

// CategoriaProducto.php
public function productos() {
    return $this->hasMany(Producto::class, 'id_categoria', 'id_categoria');
}
```

### **7. Producto ↔ Movimiento**
```php
// Producto.php
public function movimientos() {
    return $this->hasMany(Movimiento::class, 'id_producto', 'id_producto');
}

// Movimiento.php
public function producto() {
    return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
}
```

## 🛠️ **Funcionalidades Implementadas**

### **✅ Sistema de Pedidos Completo**
1. **Creación de Pedidos** - Usuarios pueden crear pedidos con múltiples productos
2. **Selección de Cantidades** - Control de cantidades por producto con validación de stock
3. **Resumen Dinámico** - Cálculo automático de totales y subtotales
4. **Validación de Stock** - No permite pedir más de lo disponible

### **✅ Sistema de Ventas Integrado**
1. **Venta desde Pedidos** - Las ventas se crean a partir de pedidos existentes
2. **Información Completa** - Muestra cliente, productos y totales del pedido relacionado
3. **Estados de Venta** - Pendiente, Pagada, Anulada
4. **Trazabilidad** - Relación bidireccional entre ventas y pedidos

### **✅ Control de Inventario**
1. **Movimientos de Stock** - Entrada, Salida, Ajuste
2. **Validación de Stock** - Control automático en pedidos
3. **Alertas de Stock** - Productos bajo stock mínimo
4. **Historial de Movimientos** - Seguimiento completo de cambios

### **✅ Gestión de Usuarios**
1. **Roles Separados** - Administrador y Usuario
2. **Información Completa** - UsuarioInfo para datos adicionales
3. **Restricciones CRUD** - Usuarios solo pueden ver/crear, no modificar
4. **Autenticación** - Sistema de login/registro funcional

## 🔄 **Flujo de Trabajo Completo**

### **1. Usuario Crea Pedido**
```
Usuario → Selecciona Productos → Especifica Cantidades → Crea Pedido
```

### **2. Administrador Procesa Venta**
```
Administrador → Selecciona Pedido → Crea Venta → Actualiza Estado
```

### **3. Sistema Actualiza Inventario**
```
Venta → Reduce Stock → Registra Movimiento → Actualiza Producto
```

## 📋 **Rutas Implementadas**

### **Rutas Públicas**
- `GET /` - Página principal de Wurger
- `GET /login` - Formulario de login
- `GET /register` - Formulario de registro

### **Rutas de Usuario**
- `GET /user/dashboard` - Dashboard de usuario
- `GET /user-productos` - Ver productos (solo lectura)
- `GET /mis-pedidos` - Lista de pedidos del usuario
- `GET /mis-pedidos/create` - Crear nuevo pedido
- `POST /mis-pedidos` - Guardar pedido
- `GET /mis-pedidos/{id}` - Ver detalle del pedido

### **Rutas de Administrador**
- `GET /admin/dashboard` - Dashboard de administrador
- `GET /productos` - Gestión de productos (CRUD)
- `GET /ventas` - Gestión de ventas (CRUD)
- `GET /pedidos` - Ver todos los pedidos
- `GET /clientes` - Ver clientes registrados
- `GET /inventario` - Control de inventario
- `GET /reportes` - Reportes del sistema

## 🎯 **Validaciones Implementadas**

### **Pedidos**
- ✅ Al menos un producto requerido
- ✅ Cantidad mínima: 1 por producto
- ✅ Cantidad máxima: stock disponible
- ✅ Productos deben existir y estar activos

### **Ventas**
- ✅ Pedido debe existir
- ✅ Total debe ser mayor a $0.00
- ✅ Total no puede exceder $99,999,999.99
- ✅ Fecha no puede ser futura

### **Productos**
- ✅ Nombre máximo 50 caracteres
- ✅ Stock no puede ser negativo
- ✅ Precios no pueden exceder $99,999,999.99
- ✅ Categoría es obligatoria

## 🚀 **Estado del Sistema**

### **✅ Completamente Funcional**
- [x] Autenticación y autorización
- [x] Gestión de usuarios y roles
- [x] Sistema de pedidos con múltiples productos
- [x] Sistema de ventas integrado
- [x] Control de inventario
- [x] Reportes y estadísticas
- [x] Validaciones completas
- [x] Interfaz responsive

### **✅ Relaciones de Base de Datos**
- [x] Todas las foreign keys implementadas
- [x] Migraciones ejecutadas correctamente
- [x] Modelos con relaciones bidireccionales
- [x] Datos consistentes y validados

### **✅ Funcionalidades por Usuario**
- [x] Usuarios: Ver productos, crear pedidos, ver sus pedidos
- [x] Administradores: CRUD completo, reportes, inventario, ventas

## 🎉 **Sistema Listo para Producción**

El sistema Wurger está completamente funcional con:
- ✅ **Relaciones completas** entre todos los modelos
- ✅ **Validaciones robustas** en frontend y backend
- ✅ **Interfaz intuitiva** para todos los usuarios
- ✅ **Flujo de trabajo completo** desde pedido hasta venta
- ✅ **Control de inventario** automático
- ✅ **Sistema de roles** bien definido
- ✅ **Base de datos** normalizada y consistente

¡El sistema está listo para ser usado en producción! 🚀
