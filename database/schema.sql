-- =====================================================
-- WURGER DATABASE EXPORT
-- Fecha de exportación: 2025-12-05
-- Base de datos: Wurger
-- =====================================================

-- NOTA: Este archivo contiene la estructura de la base de datos.
-- Para importar datos de ejemplo, ejecuta primero este archivo
-- y luego ejecuta los scripts de datos en la carpeta /database/data/

-- Crear base de datos si no existe
CREATE DATABASE IF NOT EXISTS Wurger;
USE Wurger;

-- =====================================================
-- TABLAS
-- =====================================================

-- Tabla: usuario
CREATE TABLE IF NOT EXISTS usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol VARCHAR(20) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla: usuario_info
CREATE TABLE IF NOT EXISTS usuario_info (
    id_usuario_info INT AUTO_INCREMENT PRIMARY KEY,
    direccion VARCHAR(255),
    telefono VARCHAR(20),
    id_usuario INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla: categoria_producto
CREATE TABLE IF NOT EXISTS categoria_producto (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre_categoria VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla: producto
CREATE TABLE IF NOT EXISTS producto (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre_producto VARCHAR(150) NOT NULL,
    descripcion TEXT,
    precio_venta DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    imagen VARCHAR(500),
    id_categoria INT,
    FOREIGN KEY (id_categoria) REFERENCES categoria_producto(id_categoria) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla: promocion
CREATE TABLE IF NOT EXISTS promocion (
    id_promocion INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    descuento DECIMAL(10,2) NOT NULL,
    tipo_descuento VARCHAR(20) NOT NULL,
    inicio DATE NOT NULL,
    fin DATE NOT NULL,
    estado VARCHAR(20) NOT NULL,
    id_producto INT,
    FOREIGN KEY (id_producto) REFERENCES producto(id_producto) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla: venta
CREATE TABLE IF NOT EXISTS venta (
    id_venta INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATETIME NOT NULL,
    estado VARCHAR(20),
    Total_venta DECIMAL(10,2),
    observaciones VARCHAR(500),
    direccion VARCHAR(500),
    id_usuario INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla: detalle_venta
CREATE TABLE IF NOT EXISTS detalle_venta (
    id_detalle_venta INT AUTO_INCREMENT PRIMARY KEY,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    descuento DECIMAL(10,2) DEFAULT 0,
    subtotal DECIMAL(10,2) NOT NULL,
    id_venta INT NOT NULL,
    id_producto INT NOT NULL,
    FOREIGN KEY (id_venta) REFERENCES venta(id_venta) ON DELETE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES producto(id_producto) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla: pedido
CREATE TABLE IF NOT EXISTS pedido (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATETIME NOT NULL,
    observaciones VARCHAR(255),
    estado VARCHAR(20),
    id_usuario_info INT NOT NULL,
    FOREIGN KEY (id_usuario_info) REFERENCES usuario_info(id_usuario_info) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- ÍNDICES ADICIONALES (Opcional para mejor rendimiento)
-- =====================================================

CREATE INDEX idx_usuario_email ON usuario(email);
CREATE INDEX idx_producto_categoria ON producto(id_categoria);
CREATE INDEX idx_venta_usuario ON venta(id_usuario);
CREATE INDEX idx_venta_fecha ON venta(fecha);
CREATE INDEX idx_promocion_producto ON promocion(id_producto);
CREATE INDEX idx_promocion_fechas ON promocion(inicio, fin);

-- =====================================================
-- FIN DEL SCRIPT
-- =====================================================
