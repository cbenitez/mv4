CREATE DATABASE  IF NOT EXISTS `datos` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `datos`;
-- MySQL dump 10.13  Distrib 5.7.12, for linux-glibc2.5 (x86_64)
--
-- Host: localhost    Database: datos
-- ------------------------------------------------------
-- Server version	5.7.19-0ubuntu0.16.04.1

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
-- Table structure for table `admin_login_attempts`
--

DROP TABLE IF EXISTS `admin_login_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_login_attempts` (
  `admin_login_attempt_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `admin_login_ip_address` varchar(16) NOT NULL,
  `admin_login_response` text NOT NULL,
  `admin_login_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`admin_login_attempt_id`),
  KEY `fk_admin_login_attempts_admins1_idx` (`admin_id`),
  CONSTRAINT `fk_admin_login_attempts_admins1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`admin_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_login_attempts`
--

LOCK TABLES `admin_login_attempts` WRITE;
/*!40000 ALTER TABLE `admin_login_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_login_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `admin_names` varchar(128) DEFAULT NULL,
  `admin_email` varchar(128) DEFAULT NULL,
  `admin_password` varchar(32) DEFAULT NULL,
  `admin_random_key` varchar(16) DEFAULT NULL,
  `admin_random_seed` text,
  `admin_status` tinyint(1) NOT NULL DEFAULT '1',
  `admin_hidden` tinyint(1) NOT NULL DEFAULT '0',
  `admin_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `admin_last_login` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`admin_id`),
  KEY `fk_admins_admins_groups_idx` (`group_id`),
  CONSTRAINT `fk_admins_admins_groups` FOREIGN KEY (`group_id`) REFERENCES `admins_groups` (`group_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,1,'Root Admin','admin@getmapper.xyz','e7c81491f36438d07a861abd6aaa56e7',')-5.)6042)3O.gnX','AP8eyyqW6Nko7BrOnMbLQup4qsQB2dPUTAr7q7g/nMo=',1,0,'2017-07-06 15:49:11',NULL);
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admins_groups`
--

DROP TABLE IF EXISTS `admins_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins_groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(128) DEFAULT NULL,
  `group_permission` text,
  `group_isroot` tinyint(1) NOT NULL DEFAULT '0',
  `group_status` tinyint(1) NOT NULL DEFAULT '1',
  `group_hidden` tinyint(1) NOT NULL DEFAULT '0',
  `group_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins_groups`
--

LOCK TABLES `admins_groups` WRITE;
/*!40000 ALTER TABLE `admins_groups` DISABLE KEYS */;
INSERT INTO `admins_groups` VALUES (1,'Administrador',NULL,1,1,0,'2017-07-06 15:49:10');
/*!40000 ALTER TABLE `admins_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personas`
--

DROP TABLE IF EXISTS `personas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personas` (
  `persona_id` int(11) NOT NULL AUTO_INCREMENT,
  `persona_nombre` varchar(150) DEFAULT NULL COMMENT '{"label":"Nombre y apellido","required":"true","type":"text","maxlenght":"30","placeholder":"Aqui el nombre","list":true}',
  `persona_fechanacimiento` varchar(60) DEFAULT NULL COMMENT '{"label":"Fecha de nacimiento","required":"true","type":"date","maxlenght":"10","placeholder":"dd/mm/yyyy","list":true}',
  `persona_cedula` int(11) DEFAULT '0' COMMENT '{"label":"Cedula","required":"true","type":"number","min":"0","maxlenght":"6","list":true}',
  `persona_sexo` varchar(45) DEFAULT NULL COMMENT '{"label":"Sexo","required":"true","type":"radio","value":"hombre,mujer","list":false}',
  `persona_localidad` varchar(100) DEFAULT NULL COMMENT '{"label":"Localidad","required":"true","type":"text","placeholder":"La direccion aqui","list":false}',
  `persona_departamento` varchar(100) DEFAULT NULL COMMENT '{"label":"Departamento","required":"true","type":"text","placeholder":"El departamento aqui","list":false}',
  `persona_pais` varchar(100) DEFAULT NULL COMMENT '{"label":"Pais","required":"true","type":"text","placeholder":"El pais aqui","list":false}',
  `persona_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '{"label":"Activo","type":"checkbox","value":"1","required":"false","list":true}',
  `persona_hidden` tinyint(1) NOT NULL DEFAULT '0',
  `persona_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '{"required":"false","list":true}',
  PRIMARY KEY (`persona_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='{"icon":"user","name":"Personas"}';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personas`
--

LOCK TABLES `personas` WRITE;
/*!40000 ALTER TABLE `personas` DISABLE KEYS */;
INSERT INTO `personas` VALUES (1,'Christian Benitez','24-12-1983',654321,'M','San Lorenzo','Central','PY',1,0,'2017-05-05 14:10:10'),(2,'Christian Benitez','24-12-1983',654321,'M','San Lorenzo','Central','PY',1,0,'2017-05-05 14:10:10'),(4,'Christian Benitez','24-12-1983',654321,'M','San Lorenzo','Central','PY',1,0,'2017-05-05 14:10:10'),(5,'Christian Benitez','24-12-1983',654321,'M','San Lorenzo','Central','PY',1,0,'2017-05-05 14:10:10');
/*!40000 ALTER TABLE `personas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-08-14 17:04:19
