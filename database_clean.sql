-- Limpiar base de datos completamente
DROP DATABASE IF EXISTS Wurger;
CREATE DATABASE Wurger;
USE Wurger;

-- Tabla de roles
CREATE TABLE rol (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    Nombre_rol VARCHAR(30) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de usuarios
CREATE TABLE usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    Nom_usuario VARCHAR(30) NOT NULL,
    Apellido_usuario VARCHAR(30),
    Cedula_usuario VARCHAR(20) UNIQUE,
    Salario_usuario DECIMAL(10,2),
    Fecha_ingreso_usuario DATE,
    Fecha_nac_usuario DATE,
    Sexo_usuario ENUM('M','F','Otro'),
    Tel_usuario VARCHAR(20),
    Email_usuario VARCHAR(50) UNIQUE,
    Password_usuario VARCHAR(100) NOT NULL,
    Estado_usuario ENUM('Activo','Inactivo') DEFAULT 'Activo',
    id_rol_FK INT,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_rol_FK) REFERENCES rol(id_rol)
);

-- Tabla de categorías de productos
CREATE TABLE categoria_producto (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    Nombre_categoria VARCHAR(30),
    cantidad_categoria INT,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de productos
CREATE TABLE producto (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    Nombre_producto VARCHAR(30) NOT NULL,
    Stock_producto INT,
    Stock_min_producto INT,
    Stock_max_producto INT,
    Precio_recibimiento DECIMAL(10,2),
    Precio_venta DECIMAL(10,2),
    Tipo_producto VARCHAR(30),
    Estado_producto ENUM('Activo','Inactivo'),
    Fecha_ingreso_producto DATE,
    id_categoria_FK INT,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_categoria_FK) REFERENCES categoria_producto(id_categoria)
);

-- Tabla de clientes
CREATE TABLE cliente (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    Nom_cliente VARCHAR(30),
    Tel_cliente VARCHAR(20),
    Direc_cliente VARCHAR(30),
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de ventas
CREATE TABLE venta (
    id_venta INT AUTO_INCREMENT PRIMARY KEY,
    Fecha_venta DATE,
    Estado_venta ENUM('Pendiente','Pagada','Anulada'),
    id_usuario_FK INT,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario_FK) REFERENCES usuario(id_usuario)
);

-- Insertar datos iniciales
INSERT INTO rol (Nombre_rol) VALUES 
('Administrador'),
('Vendedor'),
('Almacenista');

INSERT INTO usuario (Nom_usuario, Apellido_usuario, Cedula_usuario, Email_usuario, Password_usuario, Estado_usuario, id_rol_FK, Fecha_ingreso_usuario) VALUES 
('Administrador', 'Sistema', '12345678', 'admin@wurger.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Activo', 1, CURDATE());

INSERT INTO categoria_producto (Nombre_categoria, cantidad_categoria) VALUES 
('Electrónicos', 0),
('Ropa', 0),
('Hogar', 0),
('Deportes', 0);

INSERT INTO producto (Nombre_producto, Stock_producto, Stock_min_producto, Stock_max_producto, Precio_recibimiento, Precio_venta, Tipo_producto, Estado_producto, Fecha_ingreso_producto, id_categoria_FK) VALUES 
('Laptop HP', 10, 5, 50, 800.00, 1200.00, 'Electrónico', 'Activo', CURDATE(), 1),
('Camiseta Nike', 25, 10, 100, 15.00, 25.00, 'Ropa', 'Activo', CURDATE(), 2);

INSERT INTO cliente (Nom_cliente, Tel_cliente, Direc_cliente) VALUES 
('Juan Pérez', '555-1234', 'Calle Principal 123'),
('María García', '555-5678', 'Avenida Central 456');
