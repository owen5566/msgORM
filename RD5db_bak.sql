-- MySQL dump 10.13  Distrib 5.7.26, for osx10.10 (x86_64)
--
-- Host: localhost    Database: RD5_db
-- ------------------------------------------------------
-- Server version	5.7.26

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
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `transId` int(11) NOT NULL AUTO_INCREMENT,
  `uId` int(11) NOT NULL,
  `transMode` enum('1','0') NOT NULL,
  `transName` varchar(10) NOT NULL,
  `transDate` datetime NOT NULL,
  `transUId` int(11) DEFAULT NULL,
  `transAmount` int(11) NOT NULL,
  `transNote` varchar(30) DEFAULT NULL,
  `transBalance` int(11) NOT NULL,
  PRIMARY KEY (`transId`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (1,1,'1','存款','2020-08-03 07:27:46',NULL,35000,NULL,35000),(2,1,'0','提款','2020-08-06 07:56:54',NULL,5000,NULL,30000),(3,1,'1','存款','2020-08-10 08:46:54',NULL,5000,NULL,35000),(4,1,'1','存款','2020-08-27 08:50:05',NULL,5000,NULL,40000),(5,1,'0','提款','2020-08-31 10:06:52',NULL,6000,NULL,34000),(6,1,'0','提款','2020-09-01 01:24:04',NULL,2000,NULL,32000),(7,1,'0','提款','2020-09-01 01:24:20',NULL,2000,NULL,30000),(8,1,'0','提款','2020-09-01 01:24:33',NULL,5000,NULL,25000),(9,1,'0','提款','2020-09-01 03:38:31',NULL,5000,NULL,20000),(10,1,'0','提款','2020-09-01 03:39:35',NULL,1000,NULL,19000),(11,1,'1','存款','2020-09-01 03:42:58',NULL,5000,NULL,24000),(12,1,'1','存款','2020-09-01 03:43:12',NULL,6000,NULL,30000),(13,1,'0','提款','2020-09-01 03:44:35',NULL,9656,NULL,20344),(14,1,'0','提款','2020-09-01 03:44:45',NULL,344,NULL,20000),(15,1,'1','存款','2020-09-02 08:12:59',NULL,35000,NULL,55000),(16,1,'0','提款','2020-09-03 16:13:43',NULL,14000,NULL,41000),(17,1,'0','提款','2020-09-08 17:00:21',NULL,5000,NULL,36000),(18,1,'1','存款','2020-09-08 17:00:37',NULL,6000,NULL,42000),(19,8,'1','存款','2020-09-08 17:08:03',NULL,235923592,NULL,235923592),(20,8,'1','存款','2020-09-08 17:08:12',NULL,99996,NULL,236023588),(21,8,'1','存款','2020-09-08 17:08:15',NULL,100,NULL,236023688),(22,8,'1','存款','2020-09-08 17:08:17',NULL,100,NULL,236023788);
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `uId` int(11) NOT NULL AUTO_INCREMENT,
  `uAccountName` varchar(20) NOT NULL,
  `uPass` varchar(64) NOT NULL,
  `uName` varchar(10) NOT NULL,
  `uBirth` varchar(11) NOT NULL,
  `uAddress` varchar(50) NOT NULL,
  `uEmail` varchar(50) NOT NULL,
  `uDateOpen` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uBalance` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uId`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'owen5566','be41b7f1fa56ba2b0582910053c86cf6ee7e311efc51300220df0918bb9a287b','owen_huang','2020-01-01','台中市南屯區','owen@mail.com','2020-08-31 01:19:08',42000),(2,'paul5566','be41b7f1fa56ba2b0582910053c86cf6ee7e311efc51300220df0918bb9a287b','paul_cheng','2020-08-31','台中市南屯區','lopin@kkk.org','2020-08-31 05:19:22',0),(8,'lopin123','be41b7f1fa56ba2b0582910053c86cf6ee7e311efc51300220df0918bb9a287b','123','2020-01-01','123','123','2020-09-08 09:07:05',236023788);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-09-08 17:14:41
