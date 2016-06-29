-- MySQL dump 10.13  Distrib 5.6.19, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: prostir
-- ------------------------------------------------------
-- Server version	5.6.19-0ubuntu0.14.04.1


CREATE DATABASE /*!32312 IF NOT EXISTS*/ `prostir` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `prostir`;

--
-- Table structure for table `data`
--

DROP TABLE IF EXISTS `data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(255) DEFAULT NULL,
  `data` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `name` varchar(50) DEFAULT NULL,
  `day` int(2) DEFAULT NULL,
  `month` int(2) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data`
--

LOCK TABLES `data` WRITE;
/*!40000 ALTER TABLE `data` DISABLE KEYS */;
INSERT INTO `data` VALUES (1,'about_1',' lectoru ','2016-05-18 15:12:23','0000-00-00 00:00:00',NULL,NULL,NULL,NULL),(2,'about_2','  2B.GROUP is an architectural bureau from Kyiv, Ukraine owed by two young architects, Viacheslav Balbek and Olga Bogdanova.','2016-05-18 14:53:02','0000-00-00 00:00:00',NULL,NULL,NULL,NULL),(3,'coworking_1','This is not a lecture, but a place to meet like-minded people, it does not store the furniture, and free exposition of the best Ukrainian design objects.','2016-05-18 14:59:45','0000-00-00 00:00:00',NULL,NULL,NULL,NULL),(4,'coworking_1','asdqwe12    w  gfg f gf ','2016-05-20 12:03:00','0000-00-00 00:00:00','CIKLUM 22',NULL,NULL,NULL),(5,'coworking_1','Playtech is the world’s largest online software supplier traded on the London Stock Exchange Main Market, ','2016-05-18 14:54:36','0000-00-00 00:00:00','PLAYTECH',NULL,NULL,NULL),(6,'coworking_1','rrr','2016-05-20 11:25:16','0000-00-00 00:00:00','44',NULL,NULL,NULL),(7,'coworking_1','  Danish company, founded in 2002, working in the field of software development outsourcing. ','2016-05-18 14:55:13','0000-00-00 00:00:00','CIKLUM',NULL,NULL,NULL),(8,'coworking_1','  Danish company, founded in 2002, working in the field of software development outsourcing. ','2016-05-18 14:55:28','0000-00-00 00:00:00','CIKLUM',NULL,NULL,NULL),(9,'coworking_1','  Playtech is the world’s largest online software supplier traded on the London Stock Exchange Main Market, ','2016-05-18 14:55:42','0000-00-00 00:00:00','PLAYTECH',NULL,NULL,NULL),(10,'coworking_1','Grammarly is a bootstrapped company with 4+ million registered users that improves communication. ','2016-05-18 14:55:55','0000-00-00 00:00:00','GRAMMARLY',NULL,NULL,NULL),(11,'coworking_1','Danish company, founded in 2002, working in the field of software development outsourcing. ','2016-05-18 14:56:13','0000-00-00 00:00:00','CIKLUM',NULL,NULL,NULL),(12,'lectorium_1','asdasd','2016-05-18 15:12:33','0000-00-00 00:00:00',NULL,NULL,NULL,NULL),(13,'coworking_1','  333','2016-05-20 09:36:29','0000-00-00 00:00:00','12312',NULL,NULL,NULL),(19,'lectorium','Play \"play or DREAMS Mexico butterfly\" Polish counterculture theater   4','2016-05-20 12:58:59','0000-00-00 00:00:00','1',4,1,1451858400),(20,'lectorium','asdsadas saaaaaaaaaaa 1','2016-05-20 12:57:22','0000-00-00 00:00:00','2',1,1,1451599200),(21,'lectorium','  Play \"play or DREAMS Mexico butterfly\" Polish counterculture theate 3','2016-05-20 12:57:15','0000-00-00 00:00:00','44',3,1,1451772000),(24,'lectorium','  Play \"play or DREAMS Mexico butterfly\" Polish counterculture theate 3','2016-05-20 13:13:07','0000-00-00 00:00:00','PLAYTECH',12,9,1473627600),(26,'lectorium','  asadasda','2016-05-20 13:14:56','0000-00-00 00:00:00','sdad',22,11,1479765600);
/*!40000 ALTER TABLE `data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `img`
--

DROP TABLE IF EXISTS `img`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(255) DEFAULT NULL,
  `dest` varchar(255) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `img`
--

LOCK TABLES `img` WRITE;
/*!40000 ALTER TABLE `img` DISABLE KEYS */;
INSERT INTO `img` VALUES (75,'coworking','../../src/img/coworking/imgs/11.jpg','GRAMMARLY',10),(76,'coworking','../../src/img/coworking/imgs/11.jpg','CIKLUM',11),(77,'coworking','../../src/img/coworking/imgs/22.jpg','PLAYTECH',5),(79,'c1','../../src/img/about/imgs/c1/3.jpg',NULL,NULL),(80,'c1','../../src/img/about/imgs/c1/3.jpg',NULL,NULL),(81,'c1','../../src/img/about/imgs/c1/6.jpg',NULL,NULL),(82,'c1','../../src/img/about/imgs/c1/5.jpg',NULL,NULL),(83,'lectorium','../../src/img/lectorium/imgs/3.jpg','ddd',NULL),(84,'coworking','../../src/img/coworking/imgs/4.jpg','12312',13),(118,'coworking','../../src/img/coworking/imgs/33.jpg','44',6),(121,'lectorium','../../src/img/lectorium/imgs/3.jpg','1',14),(122,'lectorium','../../src/img/lectorium/imgs/4.jpg','2',15),(123,'lectorium','../../src/img/lectorium/imgs/11.jpg','3',16),(131,'lectorium','../../src/img/lectorium/imgs/2.jpg','1',18),(132,'lectorium','../../src/img/lectorium/imgs/3.jpg','1',19),(135,'lectorium','../../src/img/lectorium/imgs/2.jpg','44',21),(143,'lectorium','../../src/img/lectorium/imgs/1.jpg','2',20),(145,'lectorium','../../src/img/lectorium/imgs/3.jpg','sdad',26),(148,'shop','../../src/img/shop/imgs/5.jpg','name',3),(149,'shop','../../src/img/shop/imgs/5.jpg','name',4),(150,'shop','../../src/img/shop/imgs/2.jpg','name',9);
/*!40000 ALTER TABLE `img` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lector`
--

DROP TABLE IF EXISTS `lector`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lector` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `data` varchar(255) DEFAULT NULL,
  `day` int(2) DEFAULT NULL,
  `month` int(2) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lector`
--

LOCK TABLES `lector` WRITE;
/*!40000 ALTER TABLE `lector` DISABLE KEYS */;
/*!40000 ALTER TABLE `lector` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `is3d` int(1) DEFAULT NULL,
  `descr` varchar(255) DEFAULT NULL,
  `type` int(1) DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `is_popular` int(4) DEFAULT NULL,
  `is_concept` int(4) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (3,'name',3213,0,'      ',4,NULL,1,1),(4,'name',3213,0,'  ',4,NULL,0,0),(5,'name',3213,0,'desc',4,NULL,0,NULL),(6,'name',3213,0,'desc',4,NULL,0,NULL),(9,'name',223,1,'   descr ',3,2014,1,0),(10,'asd',123,0,'  123',NULL,123,1,1);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

-- Dump completed on 2016-06-29 21:24:05
