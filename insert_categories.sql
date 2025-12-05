-- Script para insertar categorías faltantes en Wurger
-- Ejecutar en MySQL Workbench o consola MySQL

USE wurger;

-- Verificar categorías existentes
SELECT * FROM categoria_producto;

-- Insertar categorías si no existen
INSERT INTO categoria_producto (nombre_categoria, cantidad_categoria)
SELECT 'Comida Rápida', 0
WHERE NOT EXISTS (SELECT 1 FROM categoria_producto WHERE nombre_categoria = 'Comida Rápida');

INSERT INTO categoria_producto (nombre_categoria, cantidad_categoria)
SELECT 'Bebidas', 0
WHERE NOT EXISTS (SELECT 1 FROM categoria_producto WHERE nombre_categoria = 'Bebidas');

INSERT INTO categoria_producto (nombre_categoria, cantidad_categoria)
SELECT 'Postres', 0
WHERE NOT EXISTS (SELECT 1 FROM categoria_producto WHERE nombre_categoria = 'Postres');

INSERT INTO categoria_producto (nombre_categoria, cantidad_categoria)
SELECT 'Acompañamientos', 0
WHERE NOT EXISTS (SELECT 1 FROM categoria_producto WHERE nombre_categoria = 'Acompañamientos');

-- Verificar que se insertaron
SELECT * FROM categoria_producto;
