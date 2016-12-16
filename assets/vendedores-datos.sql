-- MySQL dump 10.13  Distrib 5.6.24, for osx10.8 (x86_64)
--
-- Host: 127.0.0.1    Database: vendedores
-- ------------------------------------------------------
-- Server version	5.6.25

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ven_cargo`
--

DROP TABLE IF EXISTS `ven_cargo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ven_cargo` (
  `idCargo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) DEFAULT NULL,
  `estado` enum('A','I') DEFAULT 'A',
  `fechaMod` datetime DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`idCargo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ven_cargo`
--

LOCK TABLES `ven_cargo` WRITE;
/*!40000 ALTER TABLE `ven_cargo` DISABLE KEYS */;
INSERT INTO `ven_cargo` VALUES (1,'Desarrollador','A','2016-12-15 15:10:00','2016-12-15 15:10:00');
/*!40000 ALTER TABLE `ven_cargo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ven_categoria`
--

DROP TABLE IF EXISTS `ven_categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ven_categoria` (
  `idCategoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) DEFAULT NULL,
  `imagen` varchar(150) DEFAULT NULL,
  `idPadre` int(11) DEFAULT NULL,
  `estado` enum('A','I') DEFAULT 'A',
  `fechaMod` datetime DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`idCategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ven_categoria`
--

LOCK TABLES `ven_categoria` WRITE;
/*!40000 ALTER TABLE `ven_categoria` DISABLE KEYS */;
INSERT INTO `ven_categoria` VALUES (1,'Ventas',NULL,0,'A','2016-12-15 15:10:00','2016-12-15 15:10:00'),(2,'Marketing',NULL,0,'A','2016-12-15 15:10:00','2016-12-15 15:10:00'),(3,'pepito',NULL,1,'I','2016-12-15 15:10:00','2016-12-16 17:33:28');
/*!40000 ALTER TABLE `ven_categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ven_noticia`
--

DROP TABLE IF EXISTS `ven_noticia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ven_noticia` (
  `idNoticia` int(11) NOT NULL AUTO_INCREMENT,
  `idCategoria` int(11) NOT NULL,
  `idUsuarioAdmin` int(11) NOT NULL,
  `titulo` varchar(75) DEFAULT NULL,
  `subtitulo` varchar(75) DEFAULT NULL,
  `imagen` varchar(150) DEFAULT NULL,
  `tipoTemplate` int(11) DEFAULT NULL,
  `estado` enum('A','I') DEFAULT 'A',
  `fechaMod` datetime DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`idNoticia`),
  KEY `fk_noticia_categoria_idx` (`idCategoria`),
  KEY `fk_noticia_usuario_admin1_idx` (`idUsuarioAdmin`),
  CONSTRAINT `fk_noticia_categoria` FOREIGN KEY (`idCategoria`) REFERENCES `ven_categoria` (`idCategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_noticia_usuario_admin1` FOREIGN KEY (`idUsuarioAdmin`) REFERENCES `ven_usuario_admin` (`idUsuarioAdmin`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ven_noticia`
--

LOCK TABLES `ven_noticia` WRITE;
/*!40000 ALTER TABLE `ven_noticia` DISABLE KEYS */;
INSERT INTO `ven_noticia` VALUES (1,3,1,'Mi primera noticia','esta es una noticia','6.jpg',1,'A','2016-12-15 15:10:00','2016-12-15 15:10:00'),(2,1,1,'Mi primera noticia 2','subtitulo','6.jpg',1,'I','2016-12-16 17:55:16','2016-12-15 22:14:07');
/*!40000 ALTER TABLE `ven_noticia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ven_seccion_noticia`
--

DROP TABLE IF EXISTS `ven_seccion_noticia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ven_seccion_noticia` (
  `idSeccionNoticia` int(11) NOT NULL AUTO_INCREMENT,
  `idNoticia` int(11) NOT NULL,
  `titulo` varchar(120) DEFAULT NULL,
  `imagen` varchar(150) DEFAULT NULL,
  `contenido` text,
  `estado` enum('A','I') DEFAULT 'A',
  `fechaMod` datetime DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`idSeccionNoticia`),
  KEY `fk_ven_seccion_noticia_ven_noticia1_idx` (`idNoticia`),
  CONSTRAINT `fk_ven_seccion_noticia_ven_noticia1` FOREIGN KEY (`idNoticia`) REFERENCES `ven_noticia` (`idNoticia`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ven_seccion_noticia`
--

LOCK TABLES `ven_seccion_noticia` WRITE;
/*!40000 ALTER TABLE `ven_seccion_noticia` DISABLE KEYS */;
INSERT INTO `ven_seccion_noticia` VALUES (1,1,NULL,'6.jpg','Prueba contenido','A','2016-12-15 15:10:00','2016-12-15 15:10:00'),(2,1,'sub titulo','6.jpg','Prueba 2','A','2016-12-15 15:10:00','2016-12-15 15:10:00');
/*!40000 ALTER TABLE `ven_seccion_noticia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ven_usuario`
--

DROP TABLE IF EXISTS `ven_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ven_usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `idCargo` int(11) NOT NULL,
  `nombre` varchar(75) DEFAULT NULL,
  `apellido` varchar(75) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `usuario` varchar(45) DEFAULT NULL,
  `contrasena` varchar(45) DEFAULT NULL,
  `puntos` varchar(45) DEFAULT NULL,
  `estado` enum('A','I') DEFAULT 'A',
  `fechaMod` datetime DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`idUsuario`),
  KEY `fk_ven_usuario_ven_cargo1_idx` (`idCargo`),
  CONSTRAINT `fk_ven_usuario_ven_cargo1` FOREIGN KEY (`idCargo`) REFERENCES `ven_cargo` (`idCargo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ven_usuario`
--

LOCK TABLES `ven_usuario` WRITE;
/*!40000 ALTER TABLE `ven_usuario` DISABLE KEYS */;
INSERT INTO `ven_usuario` VALUES (1,1,'Julian','Barrera','julian.barrera@a3bpo.co','julian.barrera@a3bpo.co','123456','15','A','2016-12-16 18:29:01','2016-12-15 15:10:00'),(2,1,'asd','asd','asd','asd','asd','150','A','2016-12-16 18:30:34','2016-12-16 18:30:34'),(3,1,'asd','asd','asd','asd','asd','150','A','2016-12-16 18:31:04','2016-12-16 18:31:04');
/*!40000 ALTER TABLE `ven_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ven_usuario_admin`
--

DROP TABLE IF EXISTS `ven_usuario_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ven_usuario_admin` (
  `idUsuarioAdmin` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `usuario` varchar(45) DEFAULT NULL,
  `contrasena` varchar(45) DEFAULT NULL,
  `estado` enum('A','I') DEFAULT 'A',
  `fechaMod` datetime DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`idUsuarioAdmin`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ven_usuario_admin`
--

LOCK TABLES `ven_usuario_admin` WRITE;
/*!40000 ALTER TABLE `ven_usuario_admin` DISABLE KEYS */;
INSERT INTO `ven_usuario_admin` VALUES (1,'Julian','Barrera','julian.barrera@a3bpo.co','julian.barrera','123456','A','2016-12-15 15:10:00','2016-12-15 15:10:00');
/*!40000 ALTER TABLE `ven_usuario_admin` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-12-16 15:26:10
