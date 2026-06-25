CREATE DATABASE IF NOT EXISTS Wurger;
USE Wurger;

CREATE TABLE usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(150) NOT NULL,
    rol ENUM('Administrador','Usuario') NOT NULL DEFAULT 'Usuario',
    estado ENUM('Activo','Inactivo') DEFAULT 'Activo'
);

CREATE TABLE usuario_info (
    id_usuario_info INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    direccion VARCHAR(100),
    id_usuario INT UNIQUE NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON DELETE CASCADE
);

CREATE TABLE proveedor (
    id_proveedor INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    email VARCHAR(100),
    direccion VARCHAR(100),
    categoria_proveedor VARCHAR(150),
    estado ENUM('Activo','Inactivo') DEFAULT 'Activo',
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
);

CREATE TABLE categoria_producto (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre_categoria VARCHAR(50) NOT NULL,
    cantidad_categoria INT DEFAULT 0
);

CREATE TABLE unidad_medida (
    id_unidad INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    cantidad INT
);

CREATE TABLE producto (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre_producto VARCHAR(100) NOT NULL,
    stock INT DEFAULT 0,
    stock_min INT,
    stock_max INT,
    precio_compra DECIMAL(10,2),
    tipo_producto VARCHAR(50),
    estado ENUM('Activo','Inactivo') DEFAULT 'Activo',
    fecha_ingreso DATE,
    fecha_vencimiento DATE,
    id_categoria INT,
    id_unidad INT,
    id_proveedor INT,
    FOREIGN KEY (id_categoria) REFERENCES categoria_producto(id_categoria),
    FOREIGN KEY (id_unidad) REFERENCES unidad_medida(id_unidad),
    FOREIGN KEY (id_proveedor) REFERENCES proveedor(id_proveedor)
);

CREATE TABLE producto_terminado (
    id_producto_terminado INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255),
    categoria VARCHAR(50),
    costo DECIMAL(10,2),
    precio DECIMAL(10,2),
    stock_actual INT DEFAULT 0,
    stock_min INT,
    estado ENUM('Activo','Inactivo') DEFAULT 'Activo',
    fecha_ingreso DATE
);

CREATE TABLE receta (
    id_receta INT AUTO_INCREMENT PRIMARY KEY,
    cantidad_usada DECIMAL(10,2) NOT NULL,
    id_producto_terminado INT NOT NULL,
    id_producto INT NOT NULL,
    FOREIGN KEY (id_producto_terminado) REFERENCES producto_terminado(id_producto_terminado),
    FOREIGN KEY (id_producto) REFERENCES producto(id_producto)
);

CREATE TABLE movimiento (
    id_movimiento INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('Entrada','Salida') NOT NULL,
    cantidad INT NOT NULL,
    fecha DATE NOT NULL,
    descripcion VARCHAR(100),
    id_producto INT,
    FOREIGN KEY (id_producto) REFERENCES producto(id_producto)
);

CREATE TABLE detalle_movimiento (
    id_detalle_movimiento INT AUTO_INCREMENT PRIMARY KEY,
    cantidad INT NOT NULL,
    id_movimiento INT NOT NULL,
    FOREIGN KEY (id_movimiento) REFERENCES movimiento(id_movimiento)
);

CREATE TABLE pedido (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE NOT NULL,
    observaciones VARCHAR(255),
    estado ENUM('Pendiente','Entregado','Cancelado') DEFAULT 'Pendiente',
    id_usuario_info INT NOT NULL,
    FOREIGN KEY (id_usuario_info) REFERENCES usuario_info(id_usuario_info)
);

CREATE TABLE caja_sesion (
    id_caja_sesion INT AUTO_INCREMENT PRIMARY KEY,
    estado VARCHAR(20),
    fecha_apertura DATETIME,
    fecha_cierre DATETIME,
    id_usuario_apertura INT,
    id_usuario_cierre INT,
    monto_apertura DECIMAL(10,2),
    monto_cierre DECIMAL(10,2),
    observaciones VARCHAR(255)
);

CREATE TABLE venta (
    id_venta INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATETIME NOT NULL,
    estado VARCHAR(20) DEFAULT 'Pendiente',
    Total_venta DECIMAL(10,2) DEFAULT 0.00,
    id_usuario INT NOT NULL,
    direccion VARCHAR(500),
    observaciones VARCHAR(500),
    id_caja_sesion INT,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario),
    FOREIGN KEY (id_caja_sesion) REFERENCES caja_sesion(id_caja_sesion)
);

CREATE TABLE detalle_venta (
    id_detalle_venta INT AUTO_INCREMENT PRIMARY KEY,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    descuento DECIMAL(10,2) DEFAULT 0,
    id_venta INT NOT NULL,
    id_producto INT,
    id_promocion INT,
    FOREIGN KEY (id_venta) REFERENCES venta(id_venta)
    -- Asumimos que id_producto aquí se refería antes a producto, pero en realidad debería apuntar a producto_terminado para ventas. Lo dejamos suelto o lo corregimos:
    -- FOREIGN KEY (id_producto) REFERENCES producto_terminado(id_producto_terminado)
);

CREATE TABLE forma_pago (
    id_fp INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    id_venta INT NOT NULL,
    FOREIGN KEY (id_venta) REFERENCES venta(id_venta)
);

CREATE TABLE tipo_descuento (
    id_tipo_descuento INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    id_fp INT NOT NULL,
    FOREIGN KEY (id_fp) REFERENCES forma_pago(id_fp)
);

CREATE TABLE gasto (
    id_gasto INT AUTO_INCREMENT PRIMARY KEY,
    categoria VARCHAR(50),
    fecha DATE,
    descripcion VARCHAR(255),
    id_caja_sesion INT,
    medio_pago VARCHAR(50),
    monto DECIMAL(10,2),
    id_proveedor INT,
    FOREIGN KEY (id_caja_sesion) REFERENCES caja_sesion(id_caja_sesion),
    FOREIGN KEY (id_proveedor) REFERENCES proveedor(id_proveedor)
);

CREATE TABLE promocion (
    id_promocion INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    inicio DATE NOT NULL,
    fin DATE,
    cantidad_usos INT DEFAULT 0,
    estado ENUM('Activa','Inactiva') DEFAULT 'Activa',
    descripcion VARCHAR(255),
    id_producto INT,
    tipo_descuento VARCHAR(255),
    descuento DOUBLE,
    FOREIGN KEY (id_producto) REFERENCES producto_terminado(id_producto_terminado)
);

INSERT INTO usuario (email, password, rol) VALUES ('Wurger@admin.com', '$2a$10$X0zoiei0Q6fBXZRHlWGpQ.ux8gypV6BEAQLvriv6rYIdsgt8Sm/gi', 'Administrador');