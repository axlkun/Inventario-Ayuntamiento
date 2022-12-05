-- MySQL dump 10.13  Distrib 8.0.29, for Win64 (x86_64)
--
-- Host: localhost    Database: bd_ayuntamiento
-- ------------------------------------------------------
-- Server version	8.0.29

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
-- Table structure for table `nodos`
--

DROP TABLE IF EXISTS `nodos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nodos` (
  `idnodos` int NOT NULL AUTO_INCREMENT,
  `dependencia` varchar(45) NOT NULL,
  `red` varchar(45) NOT NULL,
  `informacionNodo` varchar(500) NOT NULL,
  PRIMARY KEY (`idnodos`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nodos`
--

LOCK TABLES `nodos` WRITE;
/*!40000 ALTER TABLE `nodos` DISABLE KEYS */;
INSERT INTO `nodos` VALUES (2,'Secretaria','infinitum','El nodo en la parte de la escritorio del model entrada v1 abastece de buen internet para todo el departamento, aun que a veces esta intermitente'),(3,'Secretaria','infinitum','El nodo en la parte de la escritorio del model entrada v1 abastece de buen internet para todo el departamento'),(4,'Secretaria','infinitum','El nodo en la parte de la escritorio del model entrada v1 abastece de buen internet para todo el departamento, aun que a veces esta intermitente, probar con la parte de arriba del nodo');
/*!40000 ALTER TABLE `nodos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personalsistemas`
--

DROP TABLE IF EXISTS `personalsistemas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personalsistemas` (
  `idPersona` int NOT NULL AUTO_INCREMENT,
  `nombrePersona` varchar(45) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  PRIMARY KEY (`idPersona`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personalsistemas`
--

LOCK TABLES `personalsistemas` WRITE;
/*!40000 ALTER TABLE `personalsistemas` DISABLE KEYS */;
INSERT INTO `personalsistemas` VALUES (1,'Persona1','Persona1'),(2,'Persona2','Persona2');
/*!40000 ALTER TABLE `personalsistemas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recordatorios`
--

DROP TABLE IF EXISTS `recordatorios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recordatorios` (
  `idrecordatorios` int NOT NULL AUTO_INCREMENT,
  `asunto` varchar(100) NOT NULL,
  `texto` varchar(1000) NOT NULL,
  PRIMARY KEY (`idrecordatorios`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recordatorios`
--

LOCK TABLES `recordatorios` WRITE;
/*!40000 ALTER TABLE `recordatorios` DISABLE KEYS */;
INSERT INTO `recordatorios` VALUES (1,'PRESTAMO LAPTOP','Se prestó la laptop mini a secretaria el 20/10/2022'),(3,'PRESTAMO PROYECTOR','Prestamo durante todo el mes de octubre'),(4,'RECOGER IMPRESORA','Ir a educacion a recoger la impresora epson');
/*!40000 ALTER TABLE `recordatorios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registroequipo`
--

DROP TABLE IF EXISTS `registroequipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registroequipo` (
  `idDispositivo` int NOT NULL AUTO_INCREMENT,
  `numeroSerie` varchar(45) NOT NULL,
  `nombreDispositivo` varchar(80) NOT NULL,
  `estado` tinyint NOT NULL,
  `fechaEntrega` date NOT NULL,
  `nombreRecibio` varchar(80) NOT NULL,
  `PersonalSistemas_idPersona` int NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `dependencia` varchar(45) NOT NULL,
  `dependencia2` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idDispositivo`),
  KEY `fk_RegistroEquipo_PersonalSistemas1_idx` (`PersonalSistemas_idPersona`),
  CONSTRAINT `fk_RegistroEquipo_PersonalSistemas1` FOREIGN KEY (`PersonalSistemas_idPersona`) REFERENCES `personalsistemas` (`idPersona`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registroequipo`
--

LOCK TABLES `registroequipo` WRITE;
/*!40000 ALTER TABLE `registroequipo` DISABLE KEYS */;
INSERT INTO `registroequipo` VALUES (64,'MTE-2021-SITE-RES-0032','Impresora',1,'2022-09-16','Felipe',1,'','Secretaria','Oficialia'),(65,'MTE-2021-SITE-RES-0032','Computadora',1,'2022-09-16','Gerardo',2,'','Secretaria','Registro Civil'),(67,'MTE-2021-SITE-RES-0032','Teclado',1,'2022-09-12','Felipe',2,'','Secretaria','Oficialia'),(68,'MTE-2021-SITE-RES-0032','Router',1,'2022-09-12','Julian',1,NULL,'Sistemas','Adquisiciones'),(69,'MTE-2021-SITE-RES-0032','Computadora',1,'2022-09-12','Julian',1,NULL,'Sistemas','Adquisiciones'),(70,'MTE-2021-SITE-RES-01','Mouse',1,'2022-09-12','Julian',1,NULL,'Sistemas','Adquisiciones'),(71,'MTE-2021-SITE-RES-0031','Monitor',1,'2022-09-12','Julian',1,NULL,'Adquisiciones','Sistemas'),(72,'MTE-2021-SITE-RES-0033','Teclado',1,'2022-09-12','Julian',1,NULL,'Secretaria','Adquisiciones'),(73,'MTE-2021-SITE-RES-0032','Impresora',1,'2022-09-12','Julian',1,NULL,'Sistemas','Regiduria 1'),(74,'MTE-2021-SITE-RES-0034','PC',1,'2022-09-12','Julian',1,NULL,'Regiduria 2','Adquisiciones'),(75,'MTE-2021-SITE-RES-0035','Cable',1,'2022-09-12','Julian',1,NULL,'Regiduria 3','Comunicacion'),(76,'MTE-2021-SITE-RES-0036','Ethernet',1,'2022-09-12','Julian',1,NULL,'Regiduria 4','Adquisiciones'),(77,'MTE-2021-SITE-RES-0037','Monitor',1,'2022-09-12','Julian',1,NULL,'Obras publicas','Adquisiciones'),(78,'MTE-2021-SITE-RES-0038','Proyector',1,'2022-09-12','Julian',1,NULL,'Sistemas','Fuerza Civil'),(79,'MTE-2021-SITE-RES-0032','Computadora',1,'2022-09-12','Julian',1,NULL,'Sistemas','Adquisiciones'),(80,'SITE-RES-01','Mouse',1,'2022-09-12','Julian',1,NULL,'Fuerza Civil','Adquisiciones'),(81,'SITE-RES-0031','Monitor',1,'2022-09-12','Julian',1,NULL,'Seguridad Publica','Sistemas'),(82,'SITE-RES-0033','Teclado',1,'2022-09-12','Julian',1,NULL,'DIF','Adquisiciones'),(83,'SITE-RES-0032','Impresora',1,'2022-09-12','Julian',1,NULL,'Educacion','Regiduria 1'),(84,'SITE-RES-0034','PC',1,'2022-09-12','Julian',1,NULL,'Regiduria 5','Adquisiciones'),(85,'SITE-RES-0035','Cable',1,'2022-09-12','Julian',1,NULL,'Regiduria 6','Comunicacion'),(86,'SITE-RES-0036','Ethernet',1,'2022-09-12','Julian',1,NULL,'Regiduria 7','Adquisiciones'),(87,'SITE-RES-0037','Monitor',1,'2022-09-12','Julian',1,NULL,'Radio y Disfusion','Adquisiciones'),(88,'SITE-RES-0038','Proyector',1,'2022-09-12','Julian',1,NULL,'Sistemas','Fuerza Civil'),(90,'123E-10','VGA',1,'2022-09-19','Carlos',2,'Se reemplazó el cable','Regiduria 3','Oficialia'),(91,'MTE-2021-SITE-RES-0032','Teclado',1,'2022-09-28','Trent Alexander Arnold Beckerman',2,'','Secretaria','Oficialia'),(93,'123E-05','Tintas',1,'2022-10-01','Mauro',2,'','Secretaria','Registro Civil'),(94,'dsfdfds1','ddsfds',1,'2022-10-10','dsfsdf',1,'dffdsf','dfsds','sdfsd');
/*!40000 ALTER TABLE `registroequipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `idusuarios` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) DEFAULT NULL,
  `password` char(60) DEFAULT NULL,
  `rol` int DEFAULT NULL,
  PRIMARY KEY (`idusuarios`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (2,'correo@correo.com','$2y$10$l956fmn8qi0xeC6kbKl5n.cpieMyxhPebx4ACZO2b83a0Dwd5k/WG',1),(3,'correo2@correo.com','$2y$10$TTD/hvLY9ixE5jPyqlq2NeoKdntrQ7.b0sdvGRyGqfxZSCUZDmBv6',2),(4,'admin@sistemas.com','$2y$10$PV.Zp/23m8t9viDO4pZ8EOJx4vrtskOGropUt7QC0wUN3cwRhc8Oi',1),(5,'user@sistemas.com','$2y$10$X2ixEy/DVn9Zk4VW0A1RJOZl6c03ApG4Fl5pPHTy23xcqJttazaoi',2),(6,'user1@sistemas.com','$2y$10$SXmfh51gq5UFK/lOXZvAsuAjoRBJjdnVcEKkphdxHweIjkO44Ipvm',2),(7,'user2@sistemas.com','$2y$10$CyIApO1FEX4gORSc/.cdrev0p24RLhxsoqzNmx5VHSgbtW/cLZ3wi',2);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wifi`
--

DROP TABLE IF EXISTS `wifi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wifi` (
  `idwifi` int NOT NULL AUTO_INCREMENT,
  `nombrewifi` varchar(45) NOT NULL,
  `contraseña` varchar(45) NOT NULL,
  `pertenece` varchar(45) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idwifi`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wifi`
--

LOCK TABLES `wifi` WRITE;
/*!40000 ALTER TABLE `wifi` DISABLE KEYS */;
INSERT INTO `wifi` VALUES (1,'nohaysistema','123456','sistemas',''),(2,'infinitum','contraseña','adquisiciones','router cisco'),(6,'cablealamo','nuevopass','secretaria','router nuevo'),(7,'departamento','holamundo','regiduria',NULL),(8,'departamento2','holamundo','regiduria',NULL),(9,'departamento3','holamundo','Adquisiciones',NULL),(10,'departamento4','holamundo','Fuerza Civil',NULL),(11,'departamento5','holamundo','Seguridad',NULL),(12,'departamento6','holamundo','DIF',NULL),(13,'TPLINK','holamundo','Instituto a la mujer',NULL),(14,'TPLINKAD','holamundo','Obras Publicas',NULL),(15,'TPLINK23','holamundo','Direccion y caminos',NULL),(16,'TPLINK1','holamundo','Transparencia',NULL),(17,'Control','holamundo','Registro Civil',NULL),(18,'Infinitum','holamundo','Contabilidad1',NULL),(19,'SIDDDDD','holamundo','Contabilidad2',NULL),(20,'departamento18','holamundo','Contabilidad3',NULL),(21,'departamento11','holamundo','regiduria1',NULL),(22,'departamento12','holamundo','regiduria2',NULL),(23,'departamento1','holamundo','regiduria3',NULL),(24,'sysadmin','holamundo','regiduria4',NULL),(25,'oculta','holamundo','regiduria5',NULL),(26,'publica','holamundo','regiduria6',NULL);
/*!40000 ALTER TABLE `wifi` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-12-04 23:19:21
