-- MySQL dump 10.13  Distrib 5.5.30, for osx10.9 (x86_64)
--
-- Host: localhost    Database: countries
-- ------------------------------------------------------
-- Server version	5.5.30-log

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
-- Table structure for table `region`
--

DROP TABLE IF EXISTS `region`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `region` (
  `id` int(11) NOT NULL,
  `name` varchar(32) DEFAULT NULL,
  `is_unep` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `region`
--

LOCK TABLES `region` WRITE;
/*!40000 ALTER TABLE `region` DISABLE KEYS */;
INSERT INTO `region` VALUES (1,'Africa',1),(2,'Asia and the Pacific',1),(3,'Europe',1),(4,'Latin America and the Caribbean',1),(5,'North America',1),(6,'Polar: Arctic',1),(7,'West Asia',1);
/*!40000 ALTER TABLE `region` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country_region`
--

DROP TABLE IF EXISTS `country_region`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country_region` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `region_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `country_id` (`country_id`,`region_id`)
) ENGINE=MyISAM AUTO_INCREMENT=260 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country_region`
--

LOCK TABLES `country_region` WRITE;
/*!40000 ALTER TABLE `country_region` DISABLE KEYS */;
INSERT INTO `country_region` VALUES (2,1,2),(3,199,3),(4,2,3),(5,3,1),(6,197,2),(7,4,3),(8,5,1),(9,195,4),(252,30,6),(11,6,4),(12,7,4),(13,8,3),(14,198,4),(15,9,2),(16,10,3),(17,11,3),(18,12,4),(19,13,7),(20,14,2),(21,15,4),(22,16,3),(23,17,3),(24,18,4),(25,19,1),(26,201,5),(27,20,2),(28,182,4),(29,202,4),(30,21,3),(31,22,1),(33,23,4),(35,24,2),(36,25,3),(37,26,1),(38,27,1),(39,28,2),(40,29,1),(41,30,5),(42,31,1),(43,222,4),(44,32,1),(45,33,1),(46,34,4),(47,35,2),(50,36,4),(51,37,1),(52,38,1),(53,181,2),(54,39,4),(55,44,1),(56,40,3),(57,41,4),(58,205,4),(59,42,3),(60,43,3),(61,183,1),(62,45,6),(63,46,1),(64,47,4),(65,48,4),(66,49,4),(67,50,1),(68,51,4),(69,52,1),(70,53,1),(71,54,3),(72,55,1),(73,184,3),(74,208,4),(75,209,6),(76,56,2),(77,57,6),(78,58,3),(79,210,3),(80,230,2),(82,59,1),(83,61,3),(84,62,3),(85,63,1),(86,212,3),(87,64,3),(88,213,6),(89,65,4),(90,214,4),(91,216,2),(92,66,4),(93,211,3),(94,67,1),(95,68,1),(96,69,4),(97,70,4),(99,71,4),(100,217,2),(101,72,3),(102,73,6),(103,74,2),(104,75,2),(105,187,2),(106,76,7),(107,77,3),(108,219,3),(109,78,3),(110,79,3),(111,80,4),(112,81,2),(113,221,1),(114,82,7),(115,83,3),(116,84,1),(117,85,2),(118,86,7),(119,87,3),(120,88,2),(121,89,3),(122,90,7),(123,91,1),(124,92,1),(125,93,1),(126,94,3),(127,95,3),(128,96,3),(129,224,2),(130,191,3),(131,97,1),(132,98,1),(133,99,2),(134,100,2),(135,101,1),(136,102,3),(137,103,2),(138,226,4),(139,104,1),(140,105,1),(141,249,1),(142,106,4),(143,185,2),(144,190,3),(145,107,3),(146,108,2),(147,109,3),(148,227,4),(149,110,1),(150,111,1),(151,112,2),(152,113,1),(153,114,2),(154,115,2),(155,116,3),(156,228,2),(157,117,2),(158,118,4),(159,119,1),(160,120,1),(161,192,2),(162,229,2),(163,188,2),(164,225,2),(165,121,6),(166,122,7),(167,123,2),(168,124,2),(169,234,7),(170,125,4),(171,126,2),(172,127,4),(173,128,4),(174,129,2),(175,232,2),(176,130,3),(177,131,3),(178,233,4),(179,132,7),(180,235,1),(181,133,3),(182,134,6),(183,135,1),(184,200,4),(185,236,1),(186,136,4),(187,137,4),(188,223,4),(189,231,5),(190,138,4),(191,139,2),(192,140,3),(193,141,1),(194,142,7),(195,143,1),(196,144,3),(197,145,1),(198,146,1),(199,147,2),(200,238,4),(201,148,3),(202,149,3),(203,150,2),(204,151,1),(205,152,1),(207,189,2),(208,250,1),(209,153,3),(210,154,2),(211,155,1),(212,156,4),(213,237,3),(214,157,1),(215,158,6),(216,159,3),(217,160,7),(219,161,3),(220,193,1),(221,162,2),(222,60,1),(223,163,2),(224,164,1),(225,241,2),(226,165,2),(227,166,4),(228,167,1),(229,168,3),(230,169,3),(231,239,4),(232,170,2),(233,171,1),(234,172,3),(235,173,7),(236,186,3),(237,244,5),(239,247,4),(240,174,4),(241,175,3),(242,176,2),(243,245,1),(244,194,4),(245,177,2),(246,246,4),(247,248,2),(248,207,1),(249,178,7),(250,179,1),(251,180,1),(253,244,6),(254,45,3),(255,57,3),(256,73,3),(257,121,3),(258,134,3),(259,158,3);
/*!40000 ALTER TABLE `country_region` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-12-03 22:04:49
