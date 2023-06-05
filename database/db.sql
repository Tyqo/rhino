-- MariaDB dump 10.19  Distrib 10.6.12-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: tusk
-- ------------------------------------------------------
-- Server version	10.6.12-MariaDB-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'Maxi'),(2,'Carsten'),(3,'Stuff');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phinxlog`
--

DROP TABLE IF EXISTS `phinxlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phinxlog`
--

LOCK TABLES `phinxlog` WRITE;
/*!40000 ALTER TABLE `phinxlog` DISABLE KEYS */;
/*!40000 ALTER TABLE `phinxlog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tusk_apps`
--

DROP TABLE IF EXISTS `tusk_apps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tusk_apps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `tusk_group_id` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tusk_apps`
--

LOCK TABLES `tusk_apps` WRITE;
/*!40000 ALTER TABLE `tusk_apps` DISABLE KEYS */;
INSERT INTO `tusk_apps` VALUES (1,'customers','Kunden',1,1,'2023-05-02 13:41:12','2023-05-02 13:41:12');
/*!40000 ALTER TABLE `tusk_apps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tusk_contents`
--

DROP TABLE IF EXISTS `tusk_contents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tusk_contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `element_id` int(11) NOT NULL,
  `text` varchar(255) DEFAULT NULL,
  `html` text DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `position` int(11) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tusk_contents`
--

LOCK TABLES `tusk_contents` WRITE;
/*!40000 ALTER TABLE `tusk_contents` DISABLE KEYS */;
INSERT INTO `tusk_contents` VALUES (1,1,1,'Welcome to Rhino 🦏','<p>The fast but stable Application-Framwork.<br/>Powered by <a href=\"https://cakephp.org/\">CakePHP</a>.</p>',1,1,'2023-05-02 13:32:22','2023-05-02 13:38:02'),(2,1,1,'More Text','<p>Some <b>HTML</b>.</p>',1,2,'2023-05-02 13:33:31','2023-05-02 13:38:02');
/*!40000 ALTER TABLE `tusk_contents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tusk_elements`
--

DROP TABLE IF EXISTS `tusk_elements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tusk_elements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `element` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tusk_elements`
--

LOCK TABLES `tusk_elements` WRITE;
/*!40000 ALTER TABLE `tusk_elements` DISABLE KEYS */;
INSERT INTO `tusk_elements` VALUES (1,'Text','text',1,'2023-05-02 13:32:22','2023-05-02 13:32:22');
/*!40000 ALTER TABLE `tusk_elements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tusk_groups`
--

DROP TABLE IF EXISTS `tusk_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tusk_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tusk_groups`
--

LOCK TABLES `tusk_groups` WRITE;
/*!40000 ALTER TABLE `tusk_groups` DISABLE KEYS */;
INSERT INTO `tusk_groups` VALUES (1,'My Stuff',1,'2023-05-02 13:40:56','2023-05-02 13:40:56');
/*!40000 ALTER TABLE `tusk_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tusk_layouts`
--

DROP TABLE IF EXISTS `tusk_layouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tusk_layouts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `layout` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tusk_layouts`
--

LOCK TABLES `tusk_layouts` WRITE;
/*!40000 ALTER TABLE `tusk_layouts` DISABLE KEYS */;
INSERT INTO `tusk_layouts` VALUES (1,'Default','default',1,'2023-05-02 13:32:22','2023-05-02 13:32:22');
/*!40000 ALTER TABLE `tusk_layouts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tusk_pages`
--

DROP TABLE IF EXISTS `tusk_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tusk_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `is_homepage` tinyint(1) NOT NULL DEFAULT 0,
  `type` int(11) NOT NULL DEFAULT 0,
  `parent` int(11) NOT NULL DEFAULT 0,
  `layout_id` int(11) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tusk_pages`
--

LOCK TABLES `tusk_pages` WRITE;
/*!40000 ALTER TABLE `tusk_pages` DISABLE KEYS */;
INSERT INTO `tusk_pages` VALUES (1,'Home',1,1,0,0,1,'2023-05-02 13:32:22','2023-05-02 13:32:22');
/*!40000 ALTER TABLE `tusk_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tusk_phinxlog`
--

DROP TABLE IF EXISTS `tusk_phinxlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tusk_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tusk_phinxlog`
--

LOCK TABLES `tusk_phinxlog` WRITE;
/*!40000 ALTER TABLE `tusk_phinxlog` DISABLE KEYS */;
INSERT INTO `tusk_phinxlog` VALUES (20230411070244,'TuskInit','2023-05-02 11:32:22','2023-05-02 11:32:22',0);
/*!40000 ALTER TABLE `tusk_phinxlog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tusk_users`
--

DROP TABLE IF EXISTS `tusk_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tusk_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tusk_users`
--

LOCK TABLES `tusk_users` WRITE;
/*!40000 ALTER TABLE `tusk_users` DISABLE KEYS */;
INSERT INTO `tusk_users` VALUES (1,'Carsten Coull','carsten.coull@swu.de','$2y$10$ir6eCGhZ/F9Ah0pSRDJ05.4z0hfHQaV.3W20XCqaqNqoY1T7wSxQK',1,'2023-05-02 13:32:22','2023-05-02 13:32:22');
/*!40000 ALTER TABLE `tusk_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-06-05 14:15:09
