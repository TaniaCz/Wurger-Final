CREATE DATABASE  IF NOT EXISTS `wurger` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `wurger`;
-- MySQL dump 10.13  Distrib 8.0.44, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: wurger
-- ------------------------------------------------------
-- Server version	8.0.44

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categoria_producto`
--

DROP TABLE IF EXISTS `categoria_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria_producto` (
  `id_categoria` int NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(50) NOT NULL,
  `cantidad_categoria` int DEFAULT '0',
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria_producto`
--

LOCK TABLES `categoria_producto` WRITE;
/*!40000 ALTER TABLE `categoria_producto` DISABLE KEYS */;
INSERT INTO `categoria_producto` VALUES (1,'Comida Rápida',0),(2,'Bebidas',0),(3,'Postres',0),(4,'Acompañamientos',0);
/*!40000 ALTER TABLE `categoria_producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_movimiento`
--

DROP TABLE IF EXISTS `detalle_movimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_movimiento` (
  `id_detalle_movimiento` int NOT NULL AUTO_INCREMENT,
  `cantidad` int NOT NULL,
  `id_movimiento` int NOT NULL,
  PRIMARY KEY (`id_detalle_movimiento`),
  KEY `id_movimiento` (`id_movimiento`),
  CONSTRAINT `detalle_movimiento_ibfk_1` FOREIGN KEY (`id_movimiento`) REFERENCES `movimiento` (`id_movimiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_movimiento`
--

LOCK TABLES `detalle_movimiento` WRITE;
/*!40000 ALTER TABLE `detalle_movimiento` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalle_movimiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_venta`
--

DROP TABLE IF EXISTS `detalle_venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_venta` (
  `id_detalle_venta` int NOT NULL AUTO_INCREMENT,
  `cantidad` int NOT NULL,
  `precio_unitario` decimal(38,2) NOT NULL,
  `subtotal` decimal(38,2) NOT NULL,
  `descuento` decimal(38,2) DEFAULT NULL,
  `id_venta` int NOT NULL,
  `id_producto` int NOT NULL,
  PRIMARY KEY (`id_detalle_venta`),
  KEY `id_venta` (`id_venta`),
  CONSTRAINT `detalle_venta_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `venta` (`id_venta`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_venta`
--

LOCK TABLES `detalle_venta` WRITE;
/*!40000 ALTER TABLE `detalle_venta` DISABLE KEYS */;
INSERT INTO `detalle_venta` VALUES (1,2,20.00,40.00,0.00,1,0),(2,1,20.00,20.00,0.00,2,0),(3,1,20.00,20.00,0.00,3,1),(4,1,9.50,9.50,0.00,3,4),(5,1,9.50,9.50,0.00,4,4),(6,1,15.00,15.00,0.00,5,3),(7,1,15.00,15.00,0.00,6,3),(8,1,6.50,6.50,0.00,7,5),(9,1,9.50,9.50,0.00,7,4),(10,1,15.00,15.00,0.00,7,3),(11,1,15.00,15.00,0.00,8,3),(12,1,9.50,9.50,0.00,8,4),(13,1,6.50,6.50,0.00,8,5),(14,1,9.50,9.50,0.00,9,4),(15,1,9.50,9.50,0.00,10,4),(16,1,9.50,9.12,0.38,11,4),(17,2,15.00,30.00,0.00,12,3),(18,2,9.50,18.24,0.76,13,4),(19,2,9.50,18.24,0.76,14,4),(20,1,15.00,15.00,0.00,15,3);
/*!40000 ALTER TABLE `detalle_venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forma_pago`
--

DROP TABLE IF EXISTS `forma_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `forma_pago` (
  `id_fp` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `id_venta` int NOT NULL,
  PRIMARY KEY (`id_fp`),
  KEY `id_venta` (`id_venta`),
  CONSTRAINT `forma_pago_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `venta` (`id_venta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forma_pago`
--

LOCK TABLES `forma_pago` WRITE;
/*!40000 ALTER TABLE `forma_pago` DISABLE KEYS */;
/*!40000 ALTER TABLE `forma_pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movimiento`
--

DROP TABLE IF EXISTS `movimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `movimiento` (
  `id_movimiento` int NOT NULL AUTO_INCREMENT,
  `tipo` enum('Entrada','Salida') NOT NULL,
  `cantidad` int NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `id_producto` int DEFAULT NULL,
  PRIMARY KEY (`id_movimiento`),
  KEY `id_producto` (`id_producto`),
  CONSTRAINT `movimiento_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movimiento`
--

LOCK TABLES `movimiento` WRITE;
/*!40000 ALTER TABLE `movimiento` DISABLE KEYS */;
/*!40000 ALTER TABLE `movimiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido`
--

DROP TABLE IF EXISTS `pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedido` (
  `id_pedido` int NOT NULL AUTO_INCREMENT,
  `fecha` datetime(6) NOT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `estado` enum('Cancelado','Entregado','Pendiente') DEFAULT NULL,
  `id_usuario_info` int NOT NULL,
  PRIMARY KEY (`id_pedido`),
  KEY `id_usuario_info` (`id_usuario_info`),
  CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`id_usuario_info`) REFERENCES `usuario_info` (`id_usuario_info`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido`
--

LOCK TABLES `pedido` WRITE;
/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto` (
  `id_producto` int NOT NULL AUTO_INCREMENT,
  `nombre_producto` varchar(100) NOT NULL,
  `stock` int DEFAULT '0',
  `stock_min` int DEFAULT NULL,
  `stock_max` int DEFAULT NULL,
  `precio_compra` decimal(38,2) DEFAULT NULL,
  `precio_venta` decimal(38,2) DEFAULT NULL,
  `tipo_producto` varchar(50) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `id_categoria` int DEFAULT NULL,
  `imagen` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_producto`),
  KEY `id_categoria` (`id_categoria`),
  CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria_producto` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (3,'Hamburgesa todo terreno ',96,10,100,120.00,15.00,NULL,'Activo',NULL,1,'https://static.vecteezy.com/system/resources/previews/030/683/552/large_2x/burgers-high-quality-4k-hdr-free-photo.jpg'),(4,'Limonada de coco',23,10,45,50.00,9.50,NULL,'Activo',NULL,2,'https://cocinarepublic.com/wp-content/uploads/2023/08/Limonada-de-Coco.jpg'),(5,'Brownie con Helado',55,10,50,60.00,6.50,NULL,'Activo',NULL,3,'https://bing.com/th?id=OSK.1f55e372a9980e8cc77b1ca9f84f3b54');
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto_terminado`
--

DROP TABLE IF EXISTS `producto_terminado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto_terminado` (
  `id_producto_terminado` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `costo` decimal(38,2) DEFAULT NULL,
  `precio` decimal(38,2) DEFAULT NULL,
  `stock_actual` int DEFAULT '0',
  `stock_min` int DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `id_producto` int DEFAULT NULL,
  PRIMARY KEY (`id_producto_terminado`),
  KEY `id_producto` (`id_producto`),
  CONSTRAINT `producto_terminado_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_terminado`
--

LOCK TABLES `producto_terminado` WRITE;
/*!40000 ALTER TABLE `producto_terminado` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto_terminado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promocion`
--

DROP TABLE IF EXISTS `promocion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `promocion` (
  `id_promocion` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `inicio` date NOT NULL,
  `fin` date DEFAULT NULL,
  `cantidad_usos` int DEFAULT '0',
  `estado` enum('Activa','Inactiva') DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `id_producto` int DEFAULT NULL,
  `descuento` double NOT NULL,
  `tipo_descuento` varchar(20) NOT NULL,
  PRIMARY KEY (`id_promocion`),
  KEY `id_producto` (`id_producto`),
  CONSTRAINT `promocion_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promocion`
--

LOCK TABLES `promocion` WRITE;
/*!40000 ALTER TABLE `promocion` DISABLE KEYS */;
INSERT INTO `promocion` VALUES (1,'limonata','2025-12-04','2025-12-08',0,'Activa','',4,4,'PORCENTAJE');
/*!40000 ALTER TABLE `promocion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proveedor` (
  `id_proveedor` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT NULL,
  `id_usuario` int DEFAULT NULL,
  PRIMARY KEY (`id_proveedor`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `proveedor_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedor`
--

LOCK TABLES `proveedor` WRITE;
/*!40000 ALTER TABLE `proveedor` DISABLE KEYS */;
/*!40000 ALTER TABLE `proveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_descuento`
--

DROP TABLE IF EXISTS `tipo_descuento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_descuento` (
  `id_tipo_descuento` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `id_fp` int NOT NULL,
  PRIMARY KEY (`id_tipo_descuento`),
  KEY `id_fp` (`id_fp`),
  CONSTRAINT `tipo_descuento_ibfk_1` FOREIGN KEY (`id_fp`) REFERENCES `forma_pago` (`id_fp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_descuento`
--

LOCK TABLES `tipo_descuento` WRITE;
/*!40000 ALTER TABLE `tipo_descuento` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipo_descuento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unidad_medida`
--

DROP TABLE IF EXISTS `unidad_medida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `unidad_medida` (
  `id_unidad` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `cantidad` int DEFAULT NULL,
  `id_producto` int DEFAULT NULL,
  PRIMARY KEY (`id_unidad`),
  KEY `id_producto` (`id_producto`),
  CONSTRAINT `unidad_medida_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unidad_medida`
--

LOCK TABLES `unidad_medida` WRITE;
/*!40000 ALTER TABLE `unidad_medida` DISABLE KEYS */;
/*!40000 ALTER TABLE `unidad_medida` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `rol` enum('Administrador','Usuario') NOT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'Wurger@admin.com','$2a$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhCm','Administrador','Activo'),(2,'nuevo@test.com','$2a$10$mHDftCrAG7d.K5NFNegiP.1zLXfLzR/4epCiBbtNeulDzOel75ip6','Usuario','Inactivo'),(3,'t@gamil','$2a$10$rUo2S.xQPDhL.nbFqDiBF.H6X6FVQTxJR2AVAyXDi2JKp1be3fPAS','Usuario','Inactivo'),(4,'tania@gmail.com','$2a$10$xkUjJlvPIx.7EHAeoPGRw.RtgyA9DvrwDA0VJIMLJXye5bXVazcC2','Usuario','Inactivo'),(5,'test@admin.com','$2a$10$Efp3BZYKc9mFpVVBn.CC1OVJik2CrJp7rqT96Zrx8BYD/lhvNj4qq','Administrador','Activo'),(6,'Salo@gmail.com','$2a$10$TF9IEqHZVtXx04lUc/ehNu9hsMq.biM3VUBgVejdIbP5MvkCQuhWC','Usuario','Activo'),(7,'sandra@gmail.com','$2a$10$0sk/SAy7zyBC4iI2P9yOVuR3/Ob4pXltCGCsQwW678nm0vMG0Y.C2','Usuario','Activo'),(8,'Marcela@gamil.com','$2a$10$.KYe4.5.axVlfk1iWJJEuOyit4N6vF6KayiPndb77/MhPCzNzfok6','Usuario','Activo'),(9,'M@GAMIL.COM','$2a$10$er5NuhQgy6SRsrJZZ3U80O96UYpybuZx3DM31Pn7rU6VXtpYTm6Em','Usuario','Activo'),(10,'milena@gmail.com','$2a$10$mko3lucWzAb87sT1nCME5.p3k8Ucg3gMmrMlG9OVJ9hJfNquv.XpG','Usuario','Activo');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario_info`
--

DROP TABLE IF EXISTS `usuario_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario_info` (
  `id_usuario_info` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `id_usuario` int NOT NULL,
  PRIMARY KEY (`id_usuario_info`),
  UNIQUE KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `usuario_info_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_info`
--

LOCK TABLES `usuario_info` WRITE;
/*!40000 ALTER TABLE `usuario_info` DISABLE KEYS */;
INSERT INTO `usuario_info` VALUES (1,'Gran Administrador','3001234567','Calle Falsa 123',1),(3,'t','3','q\n',3),(4,'Tania ','3012578388','Calle 1025',4),(5,'admin','1234567890','Test Address 123',5),(6,'SALOME','1234567890','Calle 1025',6),(7,'Sandra','1234567890','Test Address 123',7),(8,'Taniaa','1234567890','Calle 1025',8),(9,'Marcela ','1234567890','Test Address 123',9),(10,'MILENA','1234567890','Test Address 123',10);
/*!40000 ALTER TABLE `usuario_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venta`
--

DROP TABLE IF EXISTS `venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `venta` (
  `id_venta` int NOT NULL AUTO_INCREMENT,
  `fecha` datetime(6) NOT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `total_venta` decimal(38,2) DEFAULT NULL,
  `id_usuario` int NOT NULL,
  `direccion` varchar(500) DEFAULT NULL,
  `observaciones` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_venta`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venta`
--

LOCK TABLES `venta` WRITE;
/*!40000 ALTER TABLE `venta` DISABLE KEYS */;
INSERT INTO `venta` VALUES (1,'2025-12-03 00:00:00.000000','Cancelada',40.00,1,NULL,NULL),(2,'2025-12-04 00:00:00.000000','Cancelada',20.00,4,NULL,NULL),(3,'2025-12-04 00:00:00.000000','Cancelada',29.50,6,NULL,NULL),(4,'2025-12-04 00:00:00.000000','Completada',9.50,8,NULL,NULL),(5,'2025-12-04 00:00:00.000000','Completada',15.00,8,NULL,NULL),(6,'2025-12-04 00:00:00.000000','Cancelada',15.00,9,NULL,NULL),(7,'2025-12-04 00:00:00.000000','Completada',31.00,10,NULL,NULL),(8,'2025-12-04 00:00:00.000000','Cancelada',31.00,8,NULL,NULL),(9,'2025-12-04 00:00:00.000000','Completada',9.50,8,NULL,NULL),(10,'2025-12-04 00:00:00.000000','Completada',9.50,8,NULL,NULL),(11,'2025-12-04 00:00:00.000000','Pendiente',9.12,8,NULL,NULL),(12,'2025-12-04 00:00:00.000000','Pendiente',30.00,8,NULL,NULL),(13,'2025-12-05 04:50:34.704942','Pendiente',18.24,8,NULL,NULL),(14,'2025-12-05 04:51:35.708297','Pendiente',18.24,8,NULL,NULL),(15,'2025-12-05 04:55:29.334345','Pendiente',15.00,8,'calle','BQQ');
/*!40000 ALTER TABLE `venta` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-05  0:11:32
