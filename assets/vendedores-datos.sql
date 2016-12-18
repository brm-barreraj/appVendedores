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
  `nombre` varchar(150) DEFAULT NULL,
  `imagen` varchar(150) DEFAULT NULL,
  `idPadre` int(11) DEFAULT NULL,
  `estado` enum('A','I') DEFAULT 'A',
  `fechaMod` datetime DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`idCategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ven_categoria`
--

LOCK TABLES `ven_categoria` WRITE;
/*!40000 ALTER TABLE `ven_categoria` DISABLE KEYS */;
INSERT INTO `ven_categoria` VALUES (1,'Ventas',NULL,0,'A','2016-12-15 15:10:00','2016-12-15 15:10:00'),(2,'Marketing',NULL,0,'A','2016-12-15 15:10:00','2016-12-15 15:10:00'),(3,'CONSUMO AL DÍA',NULL,1,'A','2016-12-15 15:10:00','2016-12-16 17:33:28'),(4,'CONSUMO EN MOVIMIENTO',NULL,1,'A','2016-12-15 15:10:00','2016-12-15 15:10:00'),(5,'ENTRETENIMIENTO',NULL,1,'A','2016-12-15 15:10:00','2016-12-15 15:10:00'),(6,'CONCURSOS ALENJANDRÍA MÓVIL',NULL,2,'A','2016-12-15 15:10:00','2016-12-15 15:10:00'),(7,'CONCURSOS ALENJANDRÍA MÓVIL',NULL,1,'A','2016-12-15 15:10:00','2016-12-15 15:10:00'),(8,'CONCURSOS ALENJANDRÍA',NULL,1,'A','2016-12-15 15:10:00','2016-12-15 15:10:00'),(9,'CONCURSOS',NULL,2,'A','2016-12-15 15:10:00','2016-12-15 15:10:00');
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
  `titulo` varchar(150) DEFAULT NULL,
  `subtitulo` varchar(150) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ven_noticia`
--

LOCK TABLES `ven_noticia` WRITE;
/*!40000 ALTER TABLE `ven_noticia` DISABLE KEYS */;
INSERT INTO `ven_noticia` VALUES (1,3,1,'CitiBusiness: un aliado para el desarrollo de su Pyme.','Conozca los productos y servicios que apoyan el crecimiento de su empresa','1.jpg',1,'A','2016-12-15 15:10:00','2016-12-15 15:10:00'),(2,6,1,'Citibank suspendió su proceso de venta de la Banca de Consumo en Colombia','El banco explicó que las ofertas recibidas no reflejan el valor','1.jpg',1,'A','2016-12-16 17:55:16','2016-12-15 22:14:07'),(6,6,1,'Citi suspende la venta de banca de consumo en el país','La compañía señaló que la posibilidad sigue abierta pero depende de ','3.png',1,'A','2016-12-16 17:55:16','2016-12-16 17:55:16'),(7,9,1,'Citigroup pospone venta de dos de sus unidades de negocios en Colombia','Directivas de la entidad informaron que no hallaron inversionista que pagara el precio establecido.','3.png',1,'A','2016-12-16 17:55:16','2016-12-16 17:55:16'),(8,3,1,'Grupo Aval, Citibank y Claro anuncian alianza de banca móvil','Para acelerar bancarización en el país, lanzaron el producto Transfer, que permite hacer transacciones bancarias desde el celular.','4.jpeg',1,'A','2016-12-16 17:55:16','2016-12-16 17:55:16');
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
  `titulo` varchar(150) DEFAULT NULL,
  `imagen` varchar(150) DEFAULT NULL,
  `contenido` text,
  `estado` enum('A','I') DEFAULT 'A',
  `fechaMod` datetime DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`idSeccionNoticia`),
  KEY `fk_ven_seccion_noticia_ven_noticia1_idx` (`idNoticia`),
  CONSTRAINT `fk_ven_seccion_noticia_ven_noticia1` FOREIGN KEY (`idNoticia`) REFERENCES `ven_noticia` (`idNoticia`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ven_seccion_noticia`
--

LOCK TABLES `ven_seccion_noticia` WRITE;
/*!40000 ALTER TABLE `ven_seccion_noticia` DISABLE KEYS */;
INSERT INTO `ven_seccion_noticia` VALUES (1,2,NULL,'2.jpg','El Citibank mantendrá todas sus operaciones en Colombia, reportó la propia entidad, al suspender el proceso anunciado el 19 de febrero de este año 2016, que pretendía la venta de la Banca de Consumo en el país.\n\n\nSegún el informe entregado por el Citibank a sus clientes, este proceso de venta fue suspendido porque “las ofertas recibidas no reflejan el significativo valor que tienen nuestras operaciones y no cumplieron con los objetivos que nos trazamos al lanzar este proceso en cuanto a la preservación de los intereses de nuestros clientes, empleados y accionistas”.\n\nLuego añade que el Citibank seguirá operando normalmente con los servicios que viene prestando en Colombia. Esta entidad lleva 100 años en el país.','A','2016-12-15 15:10:00','2016-12-15 15:10:00'),(2,1,'','','-0% en la tasa de comisiones por los fondos recaudados por las ventas realizadas en sus establecimientos de comercio, a través de las tarjetas débito y/o crédito.  -$0 en la tarifa de recaudo identificado que le permite conocer el nombre de la entidad o la persona pagadora, las facturas canceladas, los valores pagados y el medio de pago de forma inmediata Para mayor información acérquese a nuestras oficinas y disfrute de todos los beneficios.   Reconocemos la importancia de su PYME y su rol fundamental en la generación de valor a la industria colombiana.','A','2016-12-15 15:10:00','2016-12-15 15:10:00'),(3,6,NULL,'3.png','Citigroup anunció que suspende la venta de sus unidades de banca de consumo y comercial en Colombia. Sin embargo, la posibilidad sigue abierta pero depende de que haya ofertas que reflejen lo que ellos consideran el valor apropiado de esos negocios.\n\n“Citigroup ha decidido suspender el proceso de venta de su banca de consumo y comercial en Colombia anunciado el pasado 19 de febrero del 2016… Como cualquier otra compañía, no descartamos la posibilidad de vender estas operaciones a un precio que refleje su valor significativo, pero se evaluará esta decisión en el futuro, si se da la oportunidad y si sigue siendo consistente con la estrategia global del Banco”, informó la entidad al mercado.\n\nHasta ahora, es el único país, de los anunciados a comienzos de año, en los que la multinacional financiera no ha concretado la operación anunciada.\n\nAl cierre de septiembre, la cartera de créditos del Citibank en Colombia superaba los 7,5 billones de pesos, lo que le da una cuota de mercado de poco más del 2 por ciento, frente a otros bancos que cuentan con una participación cercana al 23 por ciento.\n\n(Le puede interesar: Lo que se preguntan los clientes del Citibank en Colombia)\n\nSolo en cartera de consumo la entidad mantenía un saldo cercano a los 4,3 billones de pesos, según los más recientes datos publicados por la Superintendencia Financiera.\n\nSus clientes en el negocio de tarjetas de crédito rondan los 650.000 con un promedio de consumo mensual de 350.000 millones de pesos.\n\nComo se recuerda, a mediados de febrero pasado, el máximo vocero del Citigroup sorprendió al mercado con el anuncio de su salida de la banca minorista y de consumo del banco en Argentina, Brasil y Colombia.\n\nBrasil y Argentina\n\nA comienzos de octubre pasado se anunció que el gigante brasileño Itaú se quedaría con las operaciones que el Citibank tiene en Brasil, que incluyen 71 sucursales, así como la cartera de créditos y seguros y su negocio de tarjetas de crédito. El negocio fue tasado por unos 198 millones de dólares.\n\nSolo unos días después de este anuncio, la multinacional financiera estadounidense dio a conocer que el Banco Santander se quedaba con sus operaciones en Argentina, por el que pagaría una suma cercana a los 300 millones de dólares.','A','2016-12-15 15:10:00','2016-12-15 15:10:00'),(4,7,NULL,NULL,'Citigroup anunció que, ante la imposibilidad de hallar un inversionista que se quedara con sus unidades de banca de consumo y comercial en Colombia, mantendrá estos negocios junto con las demás operaciones (banca corporativa) en el país.\n\n“Citigroup ha decidido suspender el proceso de venta de su banca de consumo y comercial en Colombia anunciado el pasado 19 de febrero de 2016… Como cualquier otra compañía, no descartamos la posibilidad de vender estas operaciones a un precio que refleje su valor significativo, pero se evaluará esta decisión a futuro, si se da la oportunidad y si sigue siendo consistente con la estrategia global del Banco”, informó la entidad al mercado.\n\nHasta ahora es el único país, de los anunciados a comienzos de año, en los que la multinacional financiera no ha podido hallar un comprador.\n\nAl cierre de septiembre la cartera de créditos del Citibank en Colombia superaba los 7,5 billones de pesos, lo que le da una cuota de mercado de poco más del 2 por ciento, frente a otros bancos que cuentan con una participación cercana al 23 por ciento.\n\nSolo en cartera de consumo la entidad mantenía un saldo cercano a los 4,3 billones de pesos, según los más recientes datos publicados por la Superintendencia Financiera.\n\nSus clientes en el negocio de tarjetas de crédito rondan los 650.000 con un promedio de consumo mensual de 350.000 millones de pesos.\n\nComo se recuerda, a mediados de febrero pasado, el máximo vocero del Citigroup sorprendió al mercado con el anuncio de su salida de la banca minorista y de consumo del banco en Argentina, Brasil y Colombia.\n\n“Asignamos nuestros recursos donde pueden generar los mejores rendimientos posibles para nuestros accionistas. Estas medidas simplificarán aún más nuestra banca de consumo global, lo cual nos permite desplegar más efectivamente los recursos en donde tenemos la capacidad para lograr escala dentro de nuestros segmentos objetivos, y de captar las mayores oportunidades para el crecimiento”, dijo en su momento Michael Corbat, presidente mundial del Citi, quien estuvo de paso por Colombia hace una semanas.\n\nA comienzos de octubre pasado se anunció que el gigante brasileño Itaú se quedaría con las operaciones que el Citibank tiene en Brasil, que incluyen 71 sucursales, así como la cartera de créditos y seguros y su negocio de tarjetas de crédito. El negocio fue tasado en su momento por unos 198 millones de dólares.\n\nSolo unos días después de este anuncio, la multinacional financiera estadounidense dio a conocer que el Banco Santander se quedaba con sus operaciones en Argentina, por el que pagaría una suma cercana a los 300 millones de dólares.\n\nEn su proceso de organización mundial, el Citigroup ha salido de otros mercados tanto en Latinoamérica y Europa. Entre esos mercados están Panamá, Guatemala, Costa Rica, Honduras, Nicaragua, Perú, Checa, Hungría, Egipto, Guam y Japón.\n\nPor ejemplo, en junio pasado el Citigroup cerró un acuerdo con el Grupo Terra, del empresario Fredy Nasser, para vender su operación en El Salvador, operación que ya cuenta con el aval de las autoridades de ese país.\n\nEl negocio incluye el Banco Citibank de El Salvador y cinco de sus subsidiarias, Seguros e Inversiones y Cititarjetas, por parte de Imperia Intercontinental Inc. e Inversiones Imperia El Salvador.\n\nA su vez, el Banco Ficohsa adquirió el negocio de tarjetas del Citibank en Honduras; el Grupo Promérica hizo lo propio Guatemala tras adquirir en septiembre de 2015, la cartera de préstamos personales, tarjetas de crédito, cuentas de depósitos, así como todos los servicios de la banca individual y la banca comercial de banco estadounidense.\n\nA mediados del año pasado, Scotiabank informó que se quedaba con esas unidades de negocios del Citi en Panamá y Costa Rica, que incluyeron 27 sucursales y más de 250.000 clientes de banca personal y comercial.\n\nDos años atrás, a finales del 2014 el mismo banco canadiense compró, por 295 millones de dólares de su momento, esos mismos negocios del Citibank en Perú.','A','2016-12-15 15:10:00','2016-12-15 15:10:00'),(5,8,NULL,'3.png','La  idea es que más usuarios accedan a servicios financieros desde sus teléfonos celulares. Las compañías involucradas anunciaron que es un producto que \"revolucionará la forma de acceder a los servicios bancarios\" y que por ende contribuiría con el desarrollo socioeconómico del país.  En principio, Transfer operarará solo con los productos financieros del Banco AV Villas; le seguirá Citibank y luego los demás bancos del país, incluso aquellos que no pertenezcan al Grupo Aval.  El presidente de AV Villas, Juan Camilo Angel, dijo que la mayoría de las operaciones que se pueden hacer a traves de este nuevo producto no tendrán ningun costo. Sin embargo, las que sí se van a cobrar tendrán una tarifa máxima de 200 pesos.  Entre las operaciones que permite realizar el servicio se encuentran la transferencia de dinero de persona a persona, recargas de tiempo para los celulares, depósitos de dinero, consultas de saldo y pagos de servicios públicos.','A','2016-12-15 15:10:00','2016-12-15 15:10:00');
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
  `nombre` varchar(150) DEFAULT NULL,
  `apellido` varchar(150) DEFAULT NULL,
  `email` varchar(75) DEFAULT NULL,
  `usuario` varchar(75) DEFAULT NULL,
  `contrasena` varchar(75) DEFAULT NULL,
  `puntos` varchar(10) DEFAULT NULL,
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
  `nombre` varchar(150) DEFAULT NULL,
  `apellido` varchar(150) DEFAULT NULL,
  `email` varchar(75) DEFAULT NULL,
  `usuario` varchar(75) DEFAULT NULL,
  `contrasena` varchar(75) DEFAULT NULL,
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

-- Dump completed on 2016-12-17 19:35:32
