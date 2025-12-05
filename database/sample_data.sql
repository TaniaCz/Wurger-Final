-- =====================================================
-- DATOS DE EJEMPLO PARA WURGER
-- =====================================================

USE Wurger;

-- =====================================================
-- USUARIOS DE PRUEBA
-- =====================================================

-- Admin (password: admin123)
INSERT INTO usuario (nombre, email, password, rol) VALUES
('Administrador', 'admin@wurger.com', '$2a$10$XYZ...', 'Administrador');

-- Cliente de prueba (password: cliente123)
INSERT INTO usuario (nombre, email, password, rol) VALUES
('Juan Pérez', 'juan@example.com', '$2a$10$ABC...', 'Cliente');

-- Información adicional del cliente
INSERT INTO usuario_info (direccion, telefono, id_usuario) VALUES
('Calle 123 #45-67, Bogotá', '3001234567', 2);

-- =====================================================
-- CATEGORÍAS
-- =====================================================

INSERT INTO categoria_producto (nombre_categoria, descripcion) VALUES
('Hamburguesas Clásicas', 'Nuestras hamburguesas tradicionales con los mejores ingredientes'),
('Hamburguesas Premium', 'Hamburguesas gourmet con ingredientes selectos'),
('Bebidas', 'Refrescos, jugos y bebidas especiales'),
('Acompañamientos', 'Papas, aros de cebolla y más'),
('Postres', 'Deliciosos postres para completar tu comida');

-- =====================================================
-- PRODUCTOS DE EJEMPLO
-- =====================================================

-- Hamburguesas Clásicas
INSERT INTO producto (nombre_producto, descripcion, precio_venta, stock, imagen, id_categoria) VALUES
('Wurger Clásica', 'Carne de res, lechuga, tomate, cebolla y salsa especial', 15000, 50, '/images/clasica.jpg', 1),
('Wurger con Queso', 'Nuestra clásica con doble queso cheddar', 17000, 45, '/images/queso.jpg', 1),
('Wurger BBQ', 'Carne, queso, tocino y salsa BBQ', 19000, 40, '/images/bbq.jpg', 1);

-- Hamburguesas Premium
INSERT INTO producto (nombre_producto, descripcion, precio_venta, stock, imagen, id_categoria) VALUES
('Wurger Premium', 'Carne Angus, queso azul, cebolla caramelizada', 25000, 30, '/images/premium.jpg', 2),
('Wurger Deluxe', 'Doble carne, queso suizo, champiñones salteados', 28000, 25, '/images/deluxe.jpg', 2);

-- Bebidas
INSERT INTO producto (nombre_producto, descripcion, precio_venta, stock, imagen, id_categoria) VALUES
('Coca-Cola 400ml', 'Refresco de cola', 3000, 100, '/images/coca.jpg', 3),
('Jugo Natural', 'Jugo de frutas naturales', 5000, 50, '/images/jugo.jpg', 3),
('Limonada', 'Limonada natural con hierbabuena', 4000, 60, '/images/limonada.jpg', 3);

-- Acompañamientos
INSERT INTO producto (nombre_producto, descripcion, precio_venta, stock, imagen, id_categoria) VALUES
('Papas Fritas', 'Papas crujientes con sal', 6000, 80, '/images/papas.jpg', 4),
('Aros de Cebolla', 'Aros de cebolla empanizados', 7000, 60, '/images/aros.jpg', 4);

-- Postres
INSERT INTO producto (nombre_producto, descripcion, precio_venta, stock, imagen, id_categoria) VALUES
('Brownie con Helado', 'Brownie de chocolate con helado de vainilla', 8000, 40, '/images/brownie.jpg', 5),
('Milkshake', 'Batido de chocolate, vainilla o fresa', 9000, 50, '/images/milkshake.jpg', 5);

-- =====================================================
-- PROMOCIONES DE EJEMPLO
-- =====================================================

-- Promoción activa
INSERT INTO promocion (nombre, descripcion, descuento, tipo_descuento, inicio, fin, estado, id_producto) VALUES
('Promo Wurger Clásica', '20% de descuento en hamburguesa clásica', 20, 'PORCENTAJE', '2025-12-01', '2025-12-31', 'Activa', 1);

-- =====================================================
-- NOTA IMPORTANTE
-- =====================================================
-- Las contraseñas mostradas arriba son ejemplos.
-- En producción, debes usar BCrypt para hashear las contraseñas.
-- Ejemplo en Java: BCryptPasswordEncoder().encode("password")
