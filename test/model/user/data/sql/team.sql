-- MySQL dump 10.19  Distrib 10.3.37-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: zentaotmp0104
-- ------------------------------------------------------
-- Server version	10.3.34-MariaDB-0ubuntu0.20.04.1

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
-- Table structure for table `zt_team`
--

DROP TABLE IF EXISTS `zt_team`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zt_team` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `root` mediumint(8) unsigned NOT NULL DEFAULT 0,
  `type` enum('project','task','execution') NOT NULL DEFAULT 'project',
  `account` char(30) NOT NULL DEFAULT '',
  `role` char(30) NOT NULL DEFAULT '',
  `position` varchar(30) NOT NULL,
  `limited` char(8) NOT NULL DEFAULT 'no',
  `join` date NOT NULL DEFAULT '0000-00-00',
  `days` smallint(5) unsigned NOT NULL,
  `hours` float(3,1) unsigned NOT NULL DEFAULT 0.0,
  `estimate` decimal(12,2) unsigned NOT NULL DEFAULT 0.00,
  `consumed` decimal(12,2) unsigned NOT NULL DEFAULT 0.00,
  `left` decimal(12,2) unsigned NOT NULL DEFAULT 0.00,
  `order` tinyint(3) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `team` (`root`,`type`,`account`)
) ENGINE=InnoDB AUTO_INCREMENT=931 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zt_team`
--

LOCK TABLES `zt_team` WRITE;
/*!40000 ALTER TABLE `zt_team` DISABLE KEYS */;
INSERT INTO `zt_team` VALUES (1,11,'project','admin','研发','','yes','2023-01-14',1,1.0,0.00,0.00,0.00,0),(2,12,'project','user3','研发','','no','2023-01-14',2,2.0,0.00,0.00,0.00,0),(3,13,'project','user4','研发','','yes','2023-01-14',3,3.0,0.00,0.00,0.00,0),(4,14,'project','user5','研发','','no','2023-01-14',4,4.0,0.00,0.00,0.00,0),(5,15,'project','user6','研发','','yes','2023-01-14',5,5.0,0.00,0.00,0.00,0),(6,16,'project','user7','研发','','no','2023-01-14',6,6.0,0.00,0.00,0.00,0),(7,17,'project','user8','研发','','yes','2023-01-14',7,7.0,0.00,0.00,0.00,0),(8,18,'project','user9','研发','','no','2023-01-14',8,8.0,0.00,0.00,0.00,0),(9,19,'project','user10','研发','','yes','2023-01-14',9,1.0,0.00,0.00,0.00,0),(10,20,'project','user11','研发','','no','2023-01-14',10,2.0,0.00,0.00,0.00,0),(11,21,'project','user12','研发','','yes','2023-01-14',11,3.0,0.00,0.00,0.00,0),(12,22,'project','user13','研发','','no','2023-01-14',12,4.0,0.00,0.00,0.00,0),(13,23,'project','user14','研发','','yes','2023-01-14',13,5.0,0.00,0.00,0.00,0),(14,24,'project','user15','研发','','no','2023-01-14',14,6.0,0.00,0.00,0.00,0),(15,25,'project','user16','研发','','yes','2023-01-14',15,7.0,0.00,0.00,0.00,0),(16,26,'project','user17','研发','','no','2023-01-14',16,8.0,0.00,0.00,0.00,0),(17,27,'project','user18','研发','','yes','2023-01-14',17,1.0,0.00,0.00,0.00,0),(18,28,'project','user19','研发','','no','2023-01-14',18,2.0,0.00,0.00,0.00,0),(19,29,'project','user20','研发','','yes','2023-01-14',19,3.0,0.00,0.00,0.00,0),(20,30,'project','user21','研发','','no','2023-01-14',20,4.0,0.00,0.00,0.00,0),(21,31,'project','user22','研发','','yes','2023-01-14',21,5.0,0.00,0.00,0.00,0),(22,32,'project','user23','研发','','no','2023-01-14',22,6.0,0.00,0.00,0.00,0),(23,33,'project','user24','研发','','yes','2023-01-14',23,7.0,0.00,0.00,0.00,0),(24,34,'project','user25','研发','','no','2023-01-14',24,8.0,0.00,0.00,0.00,0),(25,35,'project','user26','研发','','yes','2023-01-14',25,1.0,0.00,0.00,0.00,0),(26,36,'project','user27','研发','','no','2023-01-14',26,2.0,0.00,0.00,0.00,0),(27,37,'project','user28','研发','','yes','2023-01-14',27,3.0,0.00,0.00,0.00,0),(28,38,'project','user29','研发','','no','2023-01-14',28,4.0,0.00,0.00,0.00,0),(29,39,'project','user30','研发','','yes','2023-01-14',29,5.0,0.00,0.00,0.00,0),(30,40,'project','user31','研发','','no','2023-01-14',30,6.0,0.00,0.00,0.00,0),(31,41,'project','user32','研发','','yes','2023-01-14',31,7.0,0.00,0.00,0.00,0),(32,42,'project','user33','研发','','no','2023-01-14',32,8.0,0.00,0.00,0.00,0),(33,43,'project','user34','研发','','yes','2023-01-14',33,1.0,0.00,0.00,0.00,0),(34,44,'project','user35','研发','','no','2023-01-14',34,2.0,0.00,0.00,0.00,0),(35,45,'project','user36','研发','','yes','2023-01-14',35,3.0,0.00,0.00,0.00,0),(36,46,'project','user37','研发','','no','2023-01-14',36,4.0,0.00,0.00,0.00,0),(37,47,'project','user38','研发','','yes','2023-01-14',37,5.0,0.00,0.00,0.00,0),(38,48,'project','user39','研发','','no','2023-01-14',38,6.0,0.00,0.00,0.00,0),(39,49,'project','user40','研发','','yes','2023-01-14',39,7.0,0.00,0.00,0.00,0),(40,50,'project','user41','研发','','no','2023-01-14',40,8.0,0.00,0.00,0.00,0),(41,51,'project','user42','研发','','yes','2023-01-14',41,1.0,0.00,0.00,0.00,0),(42,52,'project','user43','研发','','no','2023-01-14',42,2.0,0.00,0.00,0.00,0),(43,53,'project','user44','研发','','yes','2023-01-14',43,3.0,0.00,0.00,0.00,0),(44,54,'project','user45','研发','','no','2023-01-14',44,4.0,0.00,0.00,0.00,0),(45,55,'project','user46','研发','','yes','2023-01-14',45,5.0,0.00,0.00,0.00,0),(46,56,'project','user47','研发','','no','2023-01-14',46,6.0,0.00,0.00,0.00,0),(47,57,'project','user48','研发','','yes','2023-01-14',47,7.0,0.00,0.00,0.00,0),(48,58,'project','user49','研发','','no','2023-01-14',48,8.0,0.00,0.00,0.00,0),(49,59,'project','user50','研发','','yes','2023-01-14',49,1.0,0.00,0.00,0.00,0),(50,60,'project','user51','研发','','no','2023-01-14',50,2.0,0.00,0.00,0.00,0),(51,61,'project','user52','研发','','yes','2023-01-14',1,3.0,0.00,0.00,0.00,0),(52,62,'project','user53','研发','','no','2023-01-14',2,4.0,0.00,0.00,0.00,0),(53,63,'project','user54','研发','','yes','2023-01-14',3,5.0,0.00,0.00,0.00,0),(54,64,'project','user55','研发','','no','2023-01-14',4,6.0,0.00,0.00,0.00,0),(55,65,'project','user56','研发','','yes','2023-01-14',5,7.0,0.00,0.00,0.00,0),(56,66,'project','user57','研发','','no','2023-01-14',6,8.0,0.00,0.00,0.00,0),(57,67,'project','user58','研发','','yes','2023-01-14',7,1.0,0.00,0.00,0.00,0),(58,68,'project','user59','研发','','no','2023-01-14',8,2.0,0.00,0.00,0.00,0),(59,69,'project','user60','研发','','yes','2023-01-14',9,3.0,0.00,0.00,0.00,0),(60,70,'project','user61','研发','','no','2023-01-14',10,4.0,0.00,0.00,0.00,0),(61,71,'project','user62','研发','','yes','2023-01-14',11,5.0,0.00,0.00,0.00,0),(62,72,'project','user63','研发','','no','2023-01-14',12,6.0,0.00,0.00,0.00,0),(63,73,'project','user64','研发','','yes','2023-01-14',13,7.0,0.00,0.00,0.00,0),(64,74,'project','user65','研发','','no','2023-01-14',14,8.0,0.00,0.00,0.00,0),(65,75,'project','user66','研发','','yes','2023-01-14',15,1.0,0.00,0.00,0.00,0),(66,76,'project','user67','研发','','no','2023-01-14',16,2.0,0.00,0.00,0.00,0),(67,77,'project','user68','研发','','yes','2023-01-14',17,3.0,0.00,0.00,0.00,0),(68,78,'project','user69','研发','','no','2023-01-14',18,4.0,0.00,0.00,0.00,0),(69,79,'project','user70','研发','','yes','2023-01-14',19,5.0,0.00,0.00,0.00,0),(70,80,'project','user71','研发','','no','2023-01-14',20,6.0,0.00,0.00,0.00,0),(71,81,'project','user72','研发','','yes','2023-01-14',21,7.0,0.00,0.00,0.00,0),(72,82,'project','user73','研发','','no','2023-01-14',22,8.0,0.00,0.00,0.00,0),(73,83,'project','user74','研发','','yes','2023-01-14',23,1.0,0.00,0.00,0.00,0),(74,84,'project','user75','研发','','no','2023-01-14',24,2.0,0.00,0.00,0.00,0),(75,85,'project','user76','研发','','yes','2023-01-14',25,3.0,0.00,0.00,0.00,0),(76,86,'project','user77','研发','','no','2023-01-14',26,4.0,0.00,0.00,0.00,0),(77,87,'project','user78','研发','','yes','2023-01-14',27,5.0,0.00,0.00,0.00,0),(78,88,'project','user79','研发','','no','2023-01-14',28,6.0,0.00,0.00,0.00,0),(79,89,'project','user80','研发','','yes','2023-01-14',29,7.0,0.00,0.00,0.00,0),(80,90,'project','user81','研发','','no','2023-01-14',30,8.0,0.00,0.00,0.00,0),(81,91,'project','user82','研发','','yes','2023-01-14',31,1.0,0.00,0.00,0.00,0),(82,92,'project','user83','研发','','no','2023-01-14',32,2.0,0.00,0.00,0.00,0),(83,93,'project','user84','研发','','yes','2023-01-14',33,3.0,0.00,0.00,0.00,0),(84,94,'project','user85','研发','','no','2023-01-14',34,4.0,0.00,0.00,0.00,0),(85,95,'project','user86','研发','','yes','2023-01-14',35,5.0,0.00,0.00,0.00,0),(86,96,'project','user87','研发','','no','2023-01-14',36,6.0,0.00,0.00,0.00,0),(87,97,'project','user88','研发','','yes','2023-01-14',37,7.0,0.00,0.00,0.00,0),(88,98,'project','user89','研发','','no','2023-01-14',38,8.0,0.00,0.00,0.00,0),(89,99,'project','user90','研发','','yes','2023-01-14',39,1.0,0.00,0.00,0.00,0),(90,100,'project','user91','研发','','no','2023-01-14',40,2.0,0.00,0.00,0.00,0),(91,101,'execution','user92','研发','','yes','2023-01-14',41,3.0,0.00,0.00,0.00,0),(92,102,'execution','user93','研发','','no','2023-01-14',42,4.0,0.00,0.00,0.00,0),(93,103,'execution','user94','研发','','yes','2023-01-14',43,5.0,0.00,0.00,0.00,0),(94,104,'execution','user95','研发','','no','2023-01-14',44,6.0,0.00,0.00,0.00,0),(95,105,'execution','user96','研发','','yes','2023-01-14',45,7.0,0.00,0.00,0.00,0),(96,106,'execution','user97','研发','','no','2023-01-14',46,8.0,0.00,0.00,0.00,0),(97,107,'execution','user98','研发','','yes','2023-01-14',47,1.0,0.00,0.00,0.00,0),(98,108,'execution','user99','研发','','no','2023-01-14',48,2.0,0.00,0.00,0.00,0),(99,109,'execution','user100','研发','','yes','2023-01-14',49,3.0,0.00,0.00,0.00,0),(100,110,'execution','test1','测试','','no','2023-01-14',50,4.0,0.00,0.00,0.00,0),(101,111,'execution','test2','测试','','yes','2023-01-14',1,5.0,0.00,0.00,0.00,0),(102,112,'execution','test3','测试','','no','2023-01-14',2,6.0,0.00,0.00,0.00,0),(103,113,'execution','test4','测试','','yes','2023-01-14',3,7.0,0.00,0.00,0.00,0),(104,114,'execution','test5','测试','','no','2023-01-14',4,8.0,0.00,0.00,0.00,0),(105,115,'execution','test6','测试','','yes','2023-01-14',5,1.0,0.00,0.00,0.00,0),(106,116,'execution','test7','测试','','no','2023-01-14',6,2.0,0.00,0.00,0.00,0),(107,117,'execution','test8','测试','','yes','2023-01-14',7,3.0,0.00,0.00,0.00,0),(108,118,'execution','test9','测试','','no','2023-01-14',8,4.0,0.00,0.00,0.00,0),(109,119,'execution','test10','测试','','yes','2023-01-14',9,5.0,0.00,0.00,0.00,0),(110,120,'execution','test11','测试','','no','2023-01-14',10,6.0,0.00,0.00,0.00,0),(111,121,'execution','test12','测试','','yes','2023-01-14',11,7.0,0.00,0.00,0.00,0),(112,122,'execution','test13','测试','','no','2023-01-14',12,8.0,0.00,0.00,0.00,0),(113,123,'execution','test14','测试','','yes','2023-01-14',13,1.0,0.00,0.00,0.00,0),(114,124,'execution','test15','测试','','no','2023-01-14',14,2.0,0.00,0.00,0.00,0),(115,125,'execution','test16','测试','','yes','2023-01-14',15,3.0,0.00,0.00,0.00,0),(116,126,'execution','test17','测试','','no','2023-01-14',16,4.0,0.00,0.00,0.00,0),(117,127,'execution','test18','测试','','yes','2023-01-14',17,5.0,0.00,0.00,0.00,0),(118,128,'execution','test19','测试','','no','2023-01-14',18,6.0,0.00,0.00,0.00,0),(119,129,'execution','test20','测试','','yes','2023-01-14',19,7.0,0.00,0.00,0.00,0),(120,130,'execution','test21','测试','','no','2023-01-14',20,8.0,0.00,0.00,0.00,0),(121,131,'execution','test22','测试','','yes','2023-01-14',21,1.0,0.00,0.00,0.00,0),(122,132,'execution','test23','测试','','no','2023-01-14',22,2.0,0.00,0.00,0.00,0),(123,133,'execution','test24','测试','','yes','2023-01-14',23,3.0,0.00,0.00,0.00,0),(124,134,'execution','test25','测试','','no','2023-01-14',24,4.0,0.00,0.00,0.00,0),(125,135,'execution','test26','测试','','yes','2023-01-14',25,5.0,0.00,0.00,0.00,0),(126,136,'execution','test27','测试','','no','2023-01-14',26,6.0,0.00,0.00,0.00,0),(127,137,'execution','test28','测试','','yes','2023-01-14',27,7.0,0.00,0.00,0.00,0),(128,138,'execution','test29','测试','','no','2023-01-14',28,8.0,0.00,0.00,0.00,0),(129,139,'execution','test30','测试','','yes','2023-01-14',29,1.0,0.00,0.00,0.00,0),(130,140,'execution','test31','测试','','no','2023-01-14',30,2.0,0.00,0.00,0.00,0),(131,141,'execution','test32','测试','','yes','2023-01-14',31,3.0,0.00,0.00,0.00,0),(132,142,'execution','test33','测试','','no','2023-01-14',32,4.0,0.00,0.00,0.00,0),(133,143,'execution','test34','测试','','yes','2023-01-14',33,5.0,0.00,0.00,0.00,0),(134,144,'execution','test35','测试','','no','2023-01-14',34,6.0,0.00,0.00,0.00,0),(135,145,'execution','test36','测试','','yes','2023-01-14',35,7.0,0.00,0.00,0.00,0),(136,146,'execution','test37','测试','','no','2023-01-14',36,8.0,0.00,0.00,0.00,0),(137,147,'execution','test38','测试','','yes','2023-01-14',37,1.0,0.00,0.00,0.00,0),(138,148,'execution','test39','测试','','no','2023-01-14',38,2.0,0.00,0.00,0.00,0),(139,149,'execution','test40','测试','','yes','2023-01-14',39,3.0,0.00,0.00,0.00,0),(140,150,'execution','test41','测试','','no','2023-01-14',40,4.0,0.00,0.00,0.00,0),(141,151,'execution','test42','测试','','yes','2023-01-14',41,5.0,0.00,0.00,0.00,0),(142,152,'execution','test43','测试','','no','2023-01-14',42,6.0,0.00,0.00,0.00,0),(143,153,'execution','test44','测试','','yes','2023-01-14',43,7.0,0.00,0.00,0.00,0),(144,154,'execution','test45','测试','','no','2023-01-14',44,8.0,0.00,0.00,0.00,0),(145,155,'execution','test46','测试','','yes','2023-01-14',45,1.0,0.00,0.00,0.00,0),(146,156,'execution','test47','测试','','no','2023-01-14',46,2.0,0.00,0.00,0.00,0),(147,157,'execution','test48','测试','','yes','2023-01-14',47,3.0,0.00,0.00,0.00,0),(148,158,'execution','test49','测试','','no','2023-01-14',48,4.0,0.00,0.00,0.00,0),(149,159,'execution','test50','测试','','yes','2023-01-14',49,5.0,0.00,0.00,0.00,0),(150,160,'execution','test51','测试','','no','2023-01-14',50,6.0,0.00,0.00,0.00,0),(151,161,'execution','test52','测试','','yes','2023-01-14',1,7.0,0.00,0.00,0.00,0),(152,162,'execution','test53','测试','','no','2023-01-14',2,8.0,0.00,0.00,0.00,0),(153,163,'execution','test54','测试','','yes','2023-01-14',3,1.0,0.00,0.00,0.00,0),(154,164,'execution','test55','测试','','no','2023-01-14',4,2.0,0.00,0.00,0.00,0),(155,165,'execution','test56','测试','','yes','2023-01-14',5,3.0,0.00,0.00,0.00,0),(156,166,'execution','test57','测试','','no','2023-01-14',6,4.0,0.00,0.00,0.00,0),(157,167,'execution','test58','测试','','yes','2023-01-14',7,5.0,0.00,0.00,0.00,0),(158,168,'execution','test59','测试','','no','2023-01-14',8,6.0,0.00,0.00,0.00,0),(159,169,'execution','test60','测试','','yes','2023-01-14',9,7.0,0.00,0.00,0.00,0),(160,170,'execution','test61','测试','','no','2023-01-14',10,8.0,0.00,0.00,0.00,0),(161,171,'execution','test62','测试','','yes','2023-01-14',11,1.0,0.00,0.00,0.00,0),(162,172,'execution','test63','测试','','no','2023-01-14',12,2.0,0.00,0.00,0.00,0),(163,173,'execution','test64','测试','','yes','2023-01-14',13,3.0,0.00,0.00,0.00,0),(164,174,'execution','test65','测试','','no','2023-01-14',14,4.0,0.00,0.00,0.00,0),(165,175,'execution','test66','测试','','yes','2023-01-14',15,5.0,0.00,0.00,0.00,0),(166,176,'execution','test67','测试','','no','2023-01-14',16,6.0,0.00,0.00,0.00,0),(167,177,'execution','test68','测试','','yes','2023-01-14',17,7.0,0.00,0.00,0.00,0),(168,178,'execution','test69','测试','','no','2023-01-14',18,8.0,0.00,0.00,0.00,0),(169,179,'execution','test70','测试','','yes','2023-01-14',19,1.0,0.00,0.00,0.00,0),(170,180,'execution','test71','测试','','no','2023-01-14',20,2.0,0.00,0.00,0.00,0),(171,181,'execution','test72','测试','','yes','2023-01-14',21,3.0,0.00,0.00,0.00,0),(172,182,'execution','test73','测试','','no','2023-01-14',22,4.0,0.00,0.00,0.00,0),(173,183,'execution','test74','测试','','yes','2023-01-14',23,5.0,0.00,0.00,0.00,0),(174,184,'execution','test75','测试','','no','2023-01-14',24,6.0,0.00,0.00,0.00,0),(175,185,'execution','test76','测试','','yes','2023-01-14',25,7.0,0.00,0.00,0.00,0),(176,186,'execution','test77','测试','','no','2023-01-14',26,8.0,0.00,0.00,0.00,0),(177,187,'execution','test78','测试','','yes','2023-01-14',27,1.0,0.00,0.00,0.00,0),(178,188,'execution','test79','测试','','no','2023-01-14',28,2.0,0.00,0.00,0.00,0),(179,189,'execution','test80','测试','','yes','2023-01-14',29,3.0,0.00,0.00,0.00,0),(180,190,'execution','test81','测试','','no','2023-01-14',30,4.0,0.00,0.00,0.00,0),(181,191,'execution','test82','测试','','yes','2023-01-14',31,5.0,0.00,0.00,0.00,0),(182,192,'execution','test83','测试','','no','2023-01-14',32,6.0,0.00,0.00,0.00,0),(183,193,'execution','test84','测试','','yes','2023-01-14',33,7.0,0.00,0.00,0.00,0),(184,194,'execution','test85','测试','','no','2023-01-14',34,8.0,0.00,0.00,0.00,0),(185,195,'execution','test86','测试','','yes','2023-01-14',35,1.0,0.00,0.00,0.00,0),(186,196,'execution','test87','测试','','no','2023-01-14',36,2.0,0.00,0.00,0.00,0),(187,197,'execution','test88','测试','','yes','2023-01-14',37,3.0,0.00,0.00,0.00,0),(188,198,'execution','test89','测试','','no','2023-01-14',38,4.0,0.00,0.00,0.00,0),(189,199,'execution','test90','测试','','yes','2023-01-14',39,5.0,0.00,0.00,0.00,0),(190,200,'execution','test91','测试','','no','2023-01-14',40,6.0,0.00,0.00,0.00,0),(191,201,'execution','test92','测试','','yes','2023-01-14',41,7.0,0.00,0.00,0.00,0),(192,202,'execution','test93','测试','','no','2023-01-14',42,8.0,0.00,0.00,0.00,0),(193,203,'execution','test94','测试','','yes','2023-01-14',43,1.0,0.00,0.00,0.00,0),(194,204,'execution','test95','测试','','no','2023-01-14',44,2.0,0.00,0.00,0.00,0),(195,205,'execution','test96','测试','','yes','2023-01-14',45,3.0,0.00,0.00,0.00,0),(196,206,'execution','test97','测试','','no','2023-01-14',46,4.0,0.00,0.00,0.00,0),(197,207,'execution','test98','测试','','yes','2023-01-14',47,5.0,0.00,0.00,0.00,0),(198,208,'execution','test99','测试','','no','2023-01-14',48,6.0,0.00,0.00,0.00,0),(199,209,'execution','test100','测试','','yes','2023-01-14',49,7.0,0.00,0.00,0.00,0),(200,210,'execution','pm1','项目经理','','no','2023-01-14',50,8.0,0.00,0.00,0.00,0),(201,211,'execution','pm2','项目经理','','yes','2023-01-14',1,1.0,0.00,0.00,0.00,0),(202,212,'execution','pm3','项目经理','','no','2023-01-14',2,2.0,0.00,0.00,0.00,0),(203,213,'execution','pm4','项目经理','','yes','2023-01-14',3,3.0,0.00,0.00,0.00,0),(204,214,'execution','pm5','项目经理','','no','2023-01-14',4,4.0,0.00,0.00,0.00,0),(205,215,'execution','pm6','项目经理','','yes','2023-01-14',5,5.0,0.00,0.00,0.00,0),(206,216,'execution','pm7','项目经理','','no','2023-01-14',6,6.0,0.00,0.00,0.00,0),(207,217,'execution','pm8','项目经理','','yes','2023-01-14',7,7.0,0.00,0.00,0.00,0),(208,218,'execution','pm9','项目经理','','no','2023-01-14',8,8.0,0.00,0.00,0.00,0),(209,219,'execution','pm10','项目经理','','yes','2023-01-14',9,1.0,0.00,0.00,0.00,0),(210,220,'execution','pm11','项目经理','','no','2023-01-14',10,2.0,0.00,0.00,0.00,0),(211,221,'execution','pm12','项目经理','','yes','2023-01-14',11,3.0,0.00,0.00,0.00,0),(212,222,'execution','pm13','项目经理','','no','2023-01-14',12,4.0,0.00,0.00,0.00,0),(213,223,'execution','pm14','项目经理','','yes','2023-01-14',13,5.0,0.00,0.00,0.00,0),(214,224,'execution','pm15','项目经理','','no','2023-01-14',14,6.0,0.00,0.00,0.00,0),(215,225,'execution','pm16','项目经理','','yes','2023-01-14',15,7.0,0.00,0.00,0.00,0),(216,226,'execution','pm17','项目经理','','no','2023-01-14',16,8.0,0.00,0.00,0.00,0),(217,227,'execution','pm18','项目经理','','yes','2023-01-14',17,1.0,0.00,0.00,0.00,0),(218,228,'execution','pm19','项目经理','','no','2023-01-14',18,2.0,0.00,0.00,0.00,0),(219,229,'execution','pm20','项目经理','','yes','2023-01-14',19,3.0,0.00,0.00,0.00,0),(220,230,'execution','pm21','项目经理','','no','2023-01-14',20,4.0,0.00,0.00,0.00,0),(221,231,'execution','pm22','项目经理','','yes','2023-01-14',21,5.0,0.00,0.00,0.00,0),(222,232,'execution','pm23','项目经理','','no','2023-01-14',22,6.0,0.00,0.00,0.00,0),(223,233,'execution','pm24','项目经理','','yes','2023-01-14',23,7.0,0.00,0.00,0.00,0),(224,234,'execution','pm25','项目经理','','no','2023-01-14',24,8.0,0.00,0.00,0.00,0),(225,235,'execution','pm26','项目经理','','yes','2023-01-14',25,1.0,0.00,0.00,0.00,0),(226,236,'execution','pm27','项目经理','','no','2023-01-14',26,2.0,0.00,0.00,0.00,0),(227,237,'execution','pm28','项目经理','','yes','2023-01-14',27,3.0,0.00,0.00,0.00,0),(228,238,'execution','pm29','项目经理','','no','2023-01-14',28,4.0,0.00,0.00,0.00,0),(229,239,'execution','pm30','项目经理','','yes','2023-01-14',29,5.0,0.00,0.00,0.00,0),(230,240,'execution','pm31','项目经理','','no','2023-01-14',30,6.0,0.00,0.00,0.00,0),(231,241,'execution','pm32','项目经理','','yes','2023-01-14',31,7.0,0.00,0.00,0.00,0),(232,242,'execution','pm33','项目经理','','no','2023-01-14',32,8.0,0.00,0.00,0.00,0),(233,243,'execution','pm34','项目经理','','yes','2023-01-14',33,1.0,0.00,0.00,0.00,0),(234,244,'execution','pm35','项目经理','','no','2023-01-14',34,2.0,0.00,0.00,0.00,0),(235,245,'execution','pm36','项目经理','','yes','2023-01-14',35,3.0,0.00,0.00,0.00,0),(236,246,'execution','pm37','项目经理','','no','2023-01-14',36,4.0,0.00,0.00,0.00,0),(237,247,'execution','pm38','项目经理','','yes','2023-01-14',37,5.0,0.00,0.00,0.00,0),(238,248,'execution','pm39','项目经理','','no','2023-01-14',38,6.0,0.00,0.00,0.00,0),(239,249,'execution','pm40','项目经理','','yes','2023-01-14',39,7.0,0.00,0.00,0.00,0),(240,250,'execution','pm41','项目经理','','no','2023-01-14',40,8.0,0.00,0.00,0.00,0),(241,251,'execution','pm42','项目经理','','yes','2023-01-14',41,1.0,0.00,0.00,0.00,0),(242,252,'execution','pm43','项目经理','','no','2023-01-14',42,2.0,0.00,0.00,0.00,0),(243,253,'execution','pm44','项目经理','','yes','2023-01-14',43,3.0,0.00,0.00,0.00,0),(244,254,'execution','pm45','项目经理','','no','2023-01-14',44,4.0,0.00,0.00,0.00,0),(245,255,'execution','pm46','项目经理','','yes','2023-01-14',45,5.0,0.00,0.00,0.00,0),(246,256,'execution','pm47','项目经理','','no','2023-01-14',46,6.0,0.00,0.00,0.00,0),(247,257,'execution','pm48','项目经理','','yes','2023-01-14',47,7.0,0.00,0.00,0.00,0),(248,258,'execution','pm49','项目经理','','no','2023-01-14',48,8.0,0.00,0.00,0.00,0),(249,259,'execution','pm50','项目经理','','yes','2023-01-14',49,1.0,0.00,0.00,0.00,0),(250,260,'execution','pm51','项目经理','','no','2023-01-14',50,2.0,0.00,0.00,0.00,0),(251,261,'execution','pm52','项目经理','','yes','2023-01-14',1,3.0,0.00,0.00,0.00,0),(252,262,'execution','pm53','项目经理','','no','2023-01-14',2,4.0,0.00,0.00,0.00,0),(253,263,'execution','pm54','项目经理','','yes','2023-01-14',3,5.0,0.00,0.00,0.00,0),(254,264,'execution','pm55','项目经理','','no','2023-01-14',4,6.0,0.00,0.00,0.00,0),(255,265,'execution','pm56','项目经理','','yes','2023-01-14',5,7.0,0.00,0.00,0.00,0),(256,266,'execution','pm57','项目经理','','no','2023-01-14',6,8.0,0.00,0.00,0.00,0),(257,267,'execution','pm58','项目经理','','yes','2023-01-14',7,1.0,0.00,0.00,0.00,0),(258,268,'execution','pm59','项目经理','','no','2023-01-14',8,2.0,0.00,0.00,0.00,0),(259,269,'execution','pm60','项目经理','','yes','2023-01-14',9,3.0,0.00,0.00,0.00,0),(260,270,'execution','pm61','项目经理','','no','2023-01-14',10,4.0,0.00,0.00,0.00,0),(261,271,'execution','pm62','项目经理','','yes','2023-01-14',11,5.0,0.00,0.00,0.00,0),(262,272,'execution','pm63','项目经理','','no','2023-01-14',12,6.0,0.00,0.00,0.00,0),(263,273,'execution','pm64','项目经理','','yes','2023-01-14',13,7.0,0.00,0.00,0.00,0),(264,274,'execution','pm65','项目经理','','no','2023-01-14',14,8.0,0.00,0.00,0.00,0),(265,275,'execution','pm66','项目经理','','yes','2023-01-14',15,1.0,0.00,0.00,0.00,0),(266,276,'execution','pm67','项目经理','','no','2023-01-14',16,2.0,0.00,0.00,0.00,0),(267,277,'execution','pm68','项目经理','','yes','2023-01-14',17,3.0,0.00,0.00,0.00,0),(268,278,'execution','pm69','项目经理','','no','2023-01-14',18,4.0,0.00,0.00,0.00,0),(269,279,'execution','pm70','项目经理','','yes','2023-01-14',19,5.0,0.00,0.00,0.00,0),(270,280,'execution','pm71','项目经理','','no','2023-01-14',20,6.0,0.00,0.00,0.00,0),(271,281,'execution','pm72','项目经理','','yes','2023-01-14',21,7.0,0.00,0.00,0.00,0),(272,282,'execution','pm73','项目经理','','no','2023-01-14',22,8.0,0.00,0.00,0.00,0),(273,283,'execution','pm74','项目经理','','yes','2023-01-14',23,1.0,0.00,0.00,0.00,0),(274,284,'execution','pm75','项目经理','','no','2023-01-14',24,2.0,0.00,0.00,0.00,0),(275,285,'execution','pm76','项目经理','','yes','2023-01-14',25,3.0,0.00,0.00,0.00,0),(276,286,'execution','pm77','项目经理','','no','2023-01-14',26,4.0,0.00,0.00,0.00,0),(277,287,'execution','pm78','项目经理','','yes','2023-01-14',27,5.0,0.00,0.00,0.00,0),(278,288,'execution','pm79','项目经理','','no','2023-01-14',28,6.0,0.00,0.00,0.00,0),(279,289,'execution','pm80','项目经理','','yes','2023-01-14',29,7.0,0.00,0.00,0.00,0),(280,290,'execution','pm81','项目经理','','no','2023-01-14',30,8.0,0.00,0.00,0.00,0),(281,291,'execution','pm82','项目经理','','yes','2023-01-14',31,1.0,0.00,0.00,0.00,0),(282,292,'execution','pm83','项目经理','','no','2023-01-14',32,2.0,0.00,0.00,0.00,0),(283,293,'execution','pm84','项目经理','','yes','2023-01-14',33,3.0,0.00,0.00,0.00,0),(284,294,'execution','pm85','项目经理','','no','2023-01-14',34,4.0,0.00,0.00,0.00,0),(285,295,'execution','pm86','项目经理','','yes','2023-01-14',35,5.0,0.00,0.00,0.00,0),(286,296,'execution','pm87','项目经理','','no','2023-01-14',36,6.0,0.00,0.00,0.00,0),(287,297,'execution','pm88','项目经理','','yes','2023-01-14',37,7.0,0.00,0.00,0.00,0),(288,298,'execution','pm89','项目经理','','no','2023-01-14',38,8.0,0.00,0.00,0.00,0),(289,299,'execution','pm90','项目经理','','yes','2023-01-14',39,1.0,0.00,0.00,0.00,0),(290,300,'execution','pm91','项目经理','','no','2023-01-14',40,2.0,0.00,0.00,0.00,0),(291,11,'project','pm92','项目经理','','yes','2023-01-14',41,3.0,0.00,0.00,0.00,0),(292,12,'project','pm93','项目经理','','no','2023-01-14',42,4.0,0.00,0.00,0.00,0),(293,13,'project','pm94','项目经理','','yes','2023-01-14',43,5.0,0.00,0.00,0.00,0),(294,14,'project','pm95','项目经理','','no','2023-01-14',44,6.0,0.00,0.00,0.00,0),(295,15,'project','pm96','项目经理','','yes','2023-01-14',45,7.0,0.00,0.00,0.00,0),(296,16,'project','pm97','项目经理','','no','2023-01-14',46,8.0,0.00,0.00,0.00,0),(297,17,'project','pm98','项目经理','','yes','2023-01-14',47,1.0,0.00,0.00,0.00,0),(298,18,'project','pm99','项目经理','','no','2023-01-14',48,2.0,0.00,0.00,0.00,0),(299,19,'project','pm100','项目经理','','yes','2023-01-14',49,3.0,0.00,0.00,0.00,0),(300,20,'project','po1','产品经理','','no','2023-01-14',50,4.0,0.00,0.00,0.00,0),(301,21,'project','po2','产品经理','','yes','2023-01-14',1,5.0,0.00,0.00,0.00,0),(302,22,'project','po3','产品经理','','no','2023-01-14',2,6.0,0.00,0.00,0.00,0),(303,23,'project','po4','产品经理','','yes','2023-01-14',3,7.0,0.00,0.00,0.00,0),(304,24,'project','po5','产品经理','','no','2023-01-14',4,8.0,0.00,0.00,0.00,0),(305,25,'project','po6','研发','','yes','2023-01-14',5,1.0,0.00,0.00,0.00,0),(306,26,'project','po7','研发','','no','2023-01-14',6,2.0,0.00,0.00,0.00,0),(307,27,'project','po8','研发','','yes','2023-01-14',7,3.0,0.00,0.00,0.00,0),(308,28,'project','po9','研发','','no','2023-01-14',8,4.0,0.00,0.00,0.00,0),(309,29,'project','po10','研发','','yes','2023-01-14',9,5.0,0.00,0.00,0.00,0),(310,30,'project','po11','研发','','no','2023-01-14',10,6.0,0.00,0.00,0.00,0),(311,31,'project','po12','研发','','yes','2023-01-14',11,7.0,0.00,0.00,0.00,0),(312,32,'project','po13','研发','','no','2023-01-14',12,8.0,0.00,0.00,0.00,0),(313,33,'project','po14','研发','','yes','2023-01-14',13,1.0,0.00,0.00,0.00,0),(314,34,'project','po15','研发','','no','2023-01-14',14,2.0,0.00,0.00,0.00,0),(315,35,'project','po16','研发','','yes','2023-01-14',15,3.0,0.00,0.00,0.00,0),(316,36,'project','po17','研发','','no','2023-01-14',16,4.0,0.00,0.00,0.00,0),(317,37,'project','po18','研发','','yes','2023-01-14',17,5.0,0.00,0.00,0.00,0),(318,38,'project','po19','研发','','no','2023-01-14',18,6.0,0.00,0.00,0.00,0),(319,39,'project','po20','研发','','yes','2023-01-14',19,7.0,0.00,0.00,0.00,0),(320,40,'project','po21','研发','','no','2023-01-14',20,8.0,0.00,0.00,0.00,0),(321,41,'project','po22','研发','','yes','2023-01-14',21,1.0,0.00,0.00,0.00,0),(322,42,'project','po23','研发','','no','2023-01-14',22,2.0,0.00,0.00,0.00,0),(323,43,'project','po24','研发','','yes','2023-01-14',23,3.0,0.00,0.00,0.00,0),(324,44,'project','po25','研发','','no','2023-01-14',24,4.0,0.00,0.00,0.00,0),(325,45,'project','po26','研发','','yes','2023-01-14',25,5.0,0.00,0.00,0.00,0),(326,46,'project','po27','研发','','no','2023-01-14',26,6.0,0.00,0.00,0.00,0),(327,47,'project','po28','研发','','yes','2023-01-14',27,7.0,0.00,0.00,0.00,0),(328,48,'project','po29','研发','','no','2023-01-14',28,8.0,0.00,0.00,0.00,0),(329,49,'project','po30','研发','','yes','2023-01-14',29,1.0,0.00,0.00,0.00,0),(330,50,'project','po31','研发','','no','2023-01-14',30,2.0,0.00,0.00,0.00,0),(331,51,'project','po32','研发','','yes','2023-01-14',31,3.0,0.00,0.00,0.00,0),(332,52,'project','po33','研发','','no','2023-01-14',32,4.0,0.00,0.00,0.00,0),(333,53,'project','po34','研发','','yes','2023-01-14',33,5.0,0.00,0.00,0.00,0),(334,54,'project','po35','研发','','no','2023-01-14',34,6.0,0.00,0.00,0.00,0),(335,55,'project','po36','研发','','yes','2023-01-14',35,7.0,0.00,0.00,0.00,0),(336,56,'project','po37','研发','','no','2023-01-14',36,8.0,0.00,0.00,0.00,0),(337,57,'project','po38','研发','','yes','2023-01-14',37,1.0,0.00,0.00,0.00,0),(338,58,'project','po39','研发','','no','2023-01-14',38,2.0,0.00,0.00,0.00,0),(339,59,'project','po40','研发','','yes','2023-01-14',39,3.0,0.00,0.00,0.00,0),(340,60,'project','po41','研发','','no','2023-01-14',40,4.0,0.00,0.00,0.00,0),(341,61,'project','po42','研发','','yes','2023-01-14',41,5.0,0.00,0.00,0.00,0),(342,62,'project','po43','研发','','no','2023-01-14',42,6.0,0.00,0.00,0.00,0),(343,63,'project','po44','研发','','yes','2023-01-14',43,7.0,0.00,0.00,0.00,0),(344,64,'project','po45','研发','','no','2023-01-14',44,8.0,0.00,0.00,0.00,0),(345,65,'project','po46','研发','','yes','2023-01-14',45,1.0,0.00,0.00,0.00,0),(346,66,'project','po47','研发','','no','2023-01-14',46,2.0,0.00,0.00,0.00,0),(347,67,'project','po48','研发','','yes','2023-01-14',47,3.0,0.00,0.00,0.00,0),(348,68,'project','po49','研发','','no','2023-01-14',48,4.0,0.00,0.00,0.00,0),(349,69,'project','po50','研发','','yes','2023-01-14',49,5.0,0.00,0.00,0.00,0),(350,70,'project','po51','研发','','no','2023-01-14',50,6.0,0.00,0.00,0.00,0),(351,71,'project','po52','研发','','yes','2023-01-14',1,7.0,0.00,0.00,0.00,0),(352,72,'project','po53','研发','','no','2023-01-14',2,8.0,0.00,0.00,0.00,0),(353,73,'project','po54','研发','','yes','2023-01-14',3,1.0,0.00,0.00,0.00,0),(354,74,'project','po55','研发','','no','2023-01-14',4,2.0,0.00,0.00,0.00,0),(355,75,'project','po56','研发','','yes','2023-01-14',5,3.0,0.00,0.00,0.00,0),(356,76,'project','po57','研发','','no','2023-01-14',6,4.0,0.00,0.00,0.00,0),(357,77,'project','po58','研发','','yes','2023-01-14',7,5.0,0.00,0.00,0.00,0),(358,78,'project','po59','研发','','no','2023-01-14',8,6.0,0.00,0.00,0.00,0),(359,79,'project','po60','研发','','yes','2023-01-14',9,7.0,0.00,0.00,0.00,0),(360,80,'project','po61','研发','','no','2023-01-14',10,8.0,0.00,0.00,0.00,0),(361,81,'project','po62','研发','','yes','2023-01-14',11,1.0,0.00,0.00,0.00,0),(362,82,'project','po63','研发','','no','2023-01-14',12,2.0,0.00,0.00,0.00,0),(363,83,'project','po64','研发','','yes','2023-01-14',13,3.0,0.00,0.00,0.00,0),(364,84,'project','po65','研发','','no','2023-01-14',14,4.0,0.00,0.00,0.00,0),(365,85,'project','po66','研发','','yes','2023-01-14',15,5.0,0.00,0.00,0.00,0),(366,86,'project','po67','研发','','no','2023-01-14',16,6.0,0.00,0.00,0.00,0),(367,87,'project','po68','研发','','yes','2023-01-14',17,7.0,0.00,0.00,0.00,0),(368,88,'project','po69','研发','','no','2023-01-14',18,8.0,0.00,0.00,0.00,0),(369,89,'project','po70','研发','','yes','2023-01-14',19,1.0,0.00,0.00,0.00,0),(370,90,'project','po71','研发','','no','2023-01-14',20,2.0,0.00,0.00,0.00,0),(371,91,'project','po72','研发','','yes','2023-01-14',21,3.0,0.00,0.00,0.00,0),(372,92,'project','po73','研发','','no','2023-01-14',22,4.0,0.00,0.00,0.00,0),(373,93,'project','po74','研发','','yes','2023-01-14',23,5.0,0.00,0.00,0.00,0),(374,94,'project','po75','研发','','no','2023-01-14',24,6.0,0.00,0.00,0.00,0),(375,95,'project','po76','研发','','yes','2023-01-14',25,7.0,0.00,0.00,0.00,0),(376,96,'project','po77','研发','','no','2023-01-14',26,8.0,0.00,0.00,0.00,0),(377,97,'project','po78','研发','','yes','2023-01-14',27,1.0,0.00,0.00,0.00,0),(378,98,'project','po79','研发','','no','2023-01-14',28,2.0,0.00,0.00,0.00,0),(379,99,'project','po80','研发','','yes','2023-01-14',29,3.0,0.00,0.00,0.00,0),(380,100,'project','po81','研发','','no','2023-01-14',30,4.0,0.00,0.00,0.00,0),(381,101,'execution','po82','研发','','yes','2023-01-14',31,5.0,0.00,0.00,0.00,0),(382,102,'execution','po83','研发','','no','2023-01-14',32,6.0,0.00,0.00,0.00,0),(383,103,'execution','po84','研发','','yes','2023-01-14',33,7.0,0.00,0.00,0.00,0),(384,104,'execution','po85','研发','','no','2023-01-14',34,8.0,0.00,0.00,0.00,0),(385,105,'execution','po86','研发','','yes','2023-01-14',35,1.0,0.00,0.00,0.00,0),(386,106,'execution','po87','研发','','no','2023-01-14',36,2.0,0.00,0.00,0.00,0),(387,107,'execution','po88','研发','','yes','2023-01-14',37,3.0,0.00,0.00,0.00,0),(388,108,'execution','po89','研发','','no','2023-01-14',38,4.0,0.00,0.00,0.00,0),(389,109,'execution','po90','研发','','yes','2023-01-14',39,5.0,0.00,0.00,0.00,0),(390,110,'execution','po91','研发','','no','2023-01-14',40,6.0,0.00,0.00,0.00,0),(391,111,'execution','po92','研发','','yes','2023-01-14',41,7.0,0.00,0.00,0.00,0),(392,112,'execution','po93','研发','','no','2023-01-14',42,8.0,0.00,0.00,0.00,0),(393,113,'execution','po94','研发','','yes','2023-01-14',43,1.0,0.00,0.00,0.00,0),(394,114,'execution','po95','研发','','no','2023-01-14',44,2.0,0.00,0.00,0.00,0),(395,115,'execution','po96','研发','','yes','2023-01-14',45,3.0,0.00,0.00,0.00,0),(396,116,'execution','po97','研发','','no','2023-01-14',46,4.0,0.00,0.00,0.00,0),(397,117,'execution','po98','研发','','yes','2023-01-14',47,5.0,0.00,0.00,0.00,0),(398,118,'execution','po99','研发','','no','2023-01-14',48,6.0,0.00,0.00,0.00,0),(399,119,'execution','po100','研发','','yes','2023-01-14',49,7.0,0.00,0.00,0.00,0),(400,120,'execution','admin','研发','','no','2023-01-14',50,8.0,0.00,0.00,0.00,0);
/*!40000 ALTER TABLE `zt_team` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-01-14 15:53:41