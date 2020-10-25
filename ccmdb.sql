-- MySQL dump 10.13  Distrib 8.0.21, for Linux (x86_64)
--
-- Host: localhost    Database: ccmdb
-- ------------------------------------------------------
-- Server version	8.0.21-0ubuntu0.20.04.4

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ccm_admins`
--

DROP TABLE IF EXISTS `ccm_admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ccm_admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf16;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ccm_admins`
--

LOCK TABLES `ccm_admins` WRITE;
/*!40000 ALTER TABLE `ccm_admins` DISABLE KEYS */;
INSERT INTO `ccm_admins` VALUES (1,'admin001','$2y$10$wP6ZlkDZQAHi4fMvIJFuAu06EjgxxFqvg.NpdkScDBbNeoDGGDb0O');
/*!40000 ALTER TABLE `ccm_admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ccm_advisors`
--

DROP TABLE IF EXISTS `ccm_advisors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ccm_advisors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(64) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `approved` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf16;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ccm_advisors`
--

LOCK TABLES `ccm_advisors` WRITE;
/*!40000 ALTER TABLE `ccm_advisors` DISABLE KEYS */;
INSERT INTO `ccm_advisors` VALUES (1,'Test User','advisor001','','$2y$10$ZSn27Ra3F1zsPrKtBTksQee6s9I4RxDupgbG9Jq4mD2bR.oRkygfW',1),(2,'Zablon Nyakundi','Nya','','$2y$10$813txgmrj29vfhXoyGLWn.tno/cqagKe4mIp7wMRwoNMFY9VRrhgS',1),(3,'Zablon Nyakundi','nyaku','','$2y$10$F5HtXNF4B/GxBZ.Uw2ynhOfX4dt5pRf.laosCHSpYl4a1Dk/8ALrG',1),(4,'test advisor','emai@mil.com','emai@mil.com','$2y$10$0/2sNY6tFsx0GnhJUcMoxuJ1/ydwHPEMOipnMFb0qBDZaw4I5UQ3K',0);
/*!40000 ALTER TABLE `ccm_advisors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ccm_alerts`
--

DROP TABLE IF EXISTS `ccm_alerts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ccm_alerts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `made_by` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `made_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `made_by_fk_id` (`made_by`),
  CONSTRAINT `made_by_fk_id` FOREIGN KEY (`made_by`) REFERENCES `ccm_advisors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf16;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ccm_alerts`
--

LOCK TABLES `ccm_alerts` WRITE;
/*!40000 ALTER TABLE `ccm_alerts` DISABLE KEYS */;
INSERT INTO `ccm_alerts` VALUES (1,1,'Fertilizer Availbable','Fertilizer is now Availbable. Advising all farmers to make bookings','2020-10-03 11:51:39'),(2,1,'Lorem Ipsum','Fertilizer is now Availbable. Advising all farmers to make bookings','2020-10-03 11:52:33');
/*!40000 ALTER TABLE `ccm_alerts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ccm_appointments`
--

DROP TABLE IF EXISTS `ccm_appointments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ccm_appointments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `made_by` int NOT NULL,
  `farm_input` int NOT NULL,
  `quantity` int NOT NULL,
  `pick_date` date NOT NULL,
  `made_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `confirmed_on` date DEFAULT NULL,
  `confirmed` int NOT NULL DEFAULT '0',
  `paid` int NOT NULL DEFAULT '0',
  `total_cost` double DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `request_by_fk_id` (`made_by`),
  KEY `input_fk_id` (`farm_input`),
  CONSTRAINT `ccm_appointments_ibfk_1` FOREIGN KEY (`farm_input`) REFERENCES `ccm_farm_inputs` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `input_fk_id` FOREIGN KEY (`farm_input`) REFERENCES `ccm_farm_inputs` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `request_by_fk_id` FOREIGN KEY (`made_by`) REFERENCES `ccm_farmers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf16;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ccm_appointments`
--

LOCK TABLES `ccm_appointments` WRITE;
/*!40000 ALTER TABLE `ccm_appointments` DISABLE KEYS */;
INSERT INTO `ccm_appointments` VALUES (1,2,1,23,'2020-10-14','2020-10-03 10:34:29','2020-10-03',1,1,0),(2,2,1,56,'2020-10-08','2020-10-05 11:13:08','2020-10-05',1,0,0),(3,2,1,78,'2020-10-09','2020-10-05 11:44:45','2020-10-05',1,1,2652),(4,2,1,68,'2020-10-08','2020-10-05 12:19:04','2020-10-05',1,1,2312),(5,2,1,67,'2020-10-16','2020-10-10 16:37:07','2020-10-10',1,1,2278);
/*!40000 ALTER TABLE `ccm_appointments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ccm_bookings`
--

DROP TABLE IF EXISTS `ccm_bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ccm_bookings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `booked_by` int NOT NULL,
  `product_to_deliver` int NOT NULL,
  `quantity_to_deliver` float NOT NULL,
  `date_booked` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delivery_date` date NOT NULL,
  `approved_on` datetime DEFAULT NULL,
  `approved` int NOT NULL DEFAULT '0',
  `paid` int NOT NULL DEFAULT '0',
  `total_cost` double DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `booked_by_fk` (`booked_by`),
  KEY `grain_fk_id` (`product_to_deliver`),
  CONSTRAINT `booked_by_fk` FOREIGN KEY (`booked_by`) REFERENCES `ccm_farmers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `grain_fk_id` FOREIGN KEY (`product_to_deliver`) REFERENCES `ccm_cereals` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf16;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ccm_bookings`
--

LOCK TABLES `ccm_bookings` WRITE;
/*!40000 ALTER TABLE `ccm_bookings` DISABLE KEYS */;
INSERT INTO `ccm_bookings` VALUES (1,2,3,3,'2020-10-03 10:06:39','2020-10-16','2020-10-03 10:41:50',1,0,0),(2,2,8,45,'2020-10-05 12:13:48','2020-10-08','2020-10-05 12:17:19',1,1,2025),(3,2,9,45,'2020-10-05 12:14:05','2020-10-14','2020-10-05 12:17:20',1,0,9990);
/*!40000 ALTER TABLE `ccm_bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ccm_cereals`
--

DROP TABLE IF EXISTS `ccm_cereals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ccm_cereals` (
  `id` int NOT NULL AUTO_INCREMENT,
  `grain` varchar(255) NOT NULL,
  `cost` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf16;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ccm_cereals`
--

LOCK TABLES `ccm_cereals` WRITE;
/*!40000 ALTER TABLE `ccm_cereals` DISABLE KEYS */;
INSERT INTO `ccm_cereals` VALUES (1,'Maize',23),(2,'Rice',0),(3,'Sorghum',0),(4,'Millet',0),(5,'Wheat',0),(6,'Beans',0),(8,'new',45),(9,'old',222);
/*!40000 ALTER TABLE `ccm_cereals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ccm_complaints`
--

DROP TABLE IF EXISTS `ccm_complaints`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ccm_complaints` (
  `id` int NOT NULL AUTO_INCREMENT,
  `raised_by` int NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `made_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `handled` int NOT NULL DEFAULT '0',
  `handled_by` int DEFAULT NULL,
  `handled_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `handler_fk_id` (`handled_by`),
  KEY `rasier_fk_id` (`raised_by`),
  CONSTRAINT `handler_fk_id` FOREIGN KEY (`handled_by`) REFERENCES `ccm_advisors` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `rasier_fk_id` FOREIGN KEY (`raised_by`) REFERENCES `ccm_farmers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf16;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ccm_complaints`
--

LOCK TABLES `ccm_complaints` WRITE;
/*!40000 ALTER TABLE `ccm_complaints` DISABLE KEYS */;
/*!40000 ALTER TABLE `ccm_complaints` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ccm_counties`
--

DROP TABLE IF EXISTS `ccm_counties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ccm_counties` (
  `id` int NOT NULL AUTO_INCREMENT,
  `county` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf16;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ccm_counties`
--

LOCK TABLES `ccm_counties` WRITE;
/*!40000 ALTER TABLE `ccm_counties` DISABLE KEYS */;
INSERT INTO `ccm_counties` VALUES (1,'Mombasa4'),(2,'ER');
/*!40000 ALTER TABLE `ccm_counties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ccm_farm_input_payments`
--

DROP TABLE IF EXISTS `ccm_farm_input_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ccm_farm_input_payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `paying_for` int NOT NULL,
  `staff` int NOT NULL,
  `amount` int NOT NULL,
  `mode_of_payment` varchar(64) NOT NULL,
  `paid_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `picked_fk_id` (`paying_for`),
  KEY `staff_fk_id` (`staff`),
  CONSTRAINT `picked_fk_id` FOREIGN KEY (`paying_for`) REFERENCES `ccm_appointments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `staff_fk_id` FOREIGN KEY (`staff`) REFERENCES `ccm_staff` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf16;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ccm_farm_input_payments`
--

LOCK TABLES `ccm_farm_input_payments` WRITE;
/*!40000 ALTER TABLE `ccm_farm_input_payments` DISABLE KEYS */;
INSERT INTO `ccm_farm_input_payments` VALUES (1,3,1,0,'Cash','2020-10-05 11:51:34'),(2,1,1,0,'Cash','2020-10-05 13:06:22'),(3,4,1,0,'M-Pesa','2020-10-05 13:21:38'),(4,5,1,0,'Cash','2020-10-10 16:37:51');
/*!40000 ALTER TABLE `ccm_farm_input_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ccm_farm_inputs`
--

DROP TABLE IF EXISTS `ccm_farm_inputs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ccm_farm_inputs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `farm_input` varchar(255) NOT NULL,
  `cost` double DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf16;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ccm_farm_inputs`
--

LOCK TABLES `ccm_farm_inputs` WRITE;
/*!40000 ALTER TABLE `ccm_farm_inputs` DISABLE KEYS */;
INSERT INTO `ccm_farm_inputs` VALUES (1,'Top Dressing Fertilizer2',34),(2,'Planting Fertilizer',56);
/*!40000 ALTER TABLE `ccm_farm_inputs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ccm_farm_produce_payments`
--

DROP TABLE IF EXISTS `ccm_farm_produce_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ccm_farm_produce_payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `staff` int NOT NULL,
  `paying_for` int NOT NULL,
  `amount` int NOT NULL,
  `mode_of_payment` varchar(64) NOT NULL,
  `paid_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `staff__fk_id` (`staff`),
  KEY `booking_fk_id` (`paying_for`),
  CONSTRAINT `booking_fk_id` FOREIGN KEY (`paying_for`) REFERENCES `ccm_bookings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `staff__fk_id` FOREIGN KEY (`staff`) REFERENCES `ccm_staff` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf16;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ccm_farm_produce_payments`
--

LOCK TABLES `ccm_farm_produce_payments` WRITE;
/*!40000 ALTER TABLE `ccm_farm_produce_payments` DISABLE KEYS */;
INSERT INTO `ccm_farm_produce_payments` VALUES (1,1,2,0,'Cash','2020-10-05 13:20:00');
/*!40000 ALTER TABLE `ccm_farm_produce_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ccm_farmers`
--

DROP TABLE IF EXISTS `ccm_farmers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ccm_farmers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(64) NOT NULL,
  `national_id` varchar(64) DEFAULT NULL,
  `mobile_number` varchar(20) NOT NULL,
  `email` varchar(64) NOT NULL,
  `location` int NOT NULL,
  `pic` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `approved` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `county_fk_id` (`location`),
  CONSTRAINT `ccm_farmers_ibfk_1` FOREIGN KEY (`location`) REFERENCES `ccm_counties` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `county_fk_id` FOREIGN KEY (`location`) REFERENCES `ccm_counties` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf16;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ccm_farmers`
--

LOCK TABLES `ccm_farmers` WRITE;
/*!40000 ALTER TABLE `ccm_farmers` DISABLE KEYS */;
INSERT INTO `ccm_farmers` VALUES (2,'Test Farmer','test','234322323','0818171811','test@email.com',1,'../profileImages/profileDefault.png','password',1),(3,'Test Farmer2','farmer002','2838389238','232323232','exampl@exam.ple',1,'../profileImages/profileDefault.png','$2y$10$fk0/y3BDBS5SgjVghsHuLe1WLfON5Sk76EzxzlLjLLlC40MhjM/0i',0);
/*!40000 ALTER TABLE `ccm_farmers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ccm_land`
--

DROP TABLE IF EXISTS `ccm_land`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ccm_land` (
  `id` int NOT NULL AUTO_INCREMENT,
  `owner` int NOT NULL,
  `land_size` float NOT NULL,
  `cereal` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `owner_id_fk` (`owner`),
  KEY `cereal_id_fk` (`cereal`),
  CONSTRAINT `cereal_id_fk` FOREIGN KEY (`cereal`) REFERENCES `ccm_cereals` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `owner_id_fk` FOREIGN KEY (`owner`) REFERENCES `ccm_farmers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf16;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ccm_land`
--

LOCK TABLES `ccm_land` WRITE;
/*!40000 ALTER TABLE `ccm_land` DISABLE KEYS */;
INSERT INTO `ccm_land` VALUES (15,2,12,1),(16,2,23,2),(17,2,42,3),(18,2,45,5),(19,2,23,4),(20,2,33,6),(21,2,23,6),(22,2,0,2),(23,2,0,2);
/*!40000 ALTER TABLE `ccm_land` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ccm_messages`
--

DROP TABLE IF EXISTS `ccm_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ccm_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `asked_by` int NOT NULL,
  `message` text NOT NULL,
  `asked_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `replied` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `asked_fk_id` (`asked_by`),
  CONSTRAINT `asked_fk_id` FOREIGN KEY (`asked_by`) REFERENCES `ccm_farmers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf16;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ccm_messages`
--

LOCK TABLES `ccm_messages` WRITE;
/*!40000 ALTER TABLE `ccm_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `ccm_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ccm_password_resets`
--

DROP TABLE IF EXISTS `ccm_password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ccm_password_resets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(64) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token_UNIQUE` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ccm_password_resets`
--

LOCK TABLES `ccm_password_resets` WRITE;
/*!40000 ALTER TABLE `ccm_password_resets` DISABLE KEYS */;
INSERT INTO `ccm_password_resets` VALUES (1,'test@email.com','3051b35274950182b26ce23eca2e4fd98b11e2a191e0ec0017ff787cb4ce5400148bd65ca38db47da04e6ce059ed7eca342c'),(2,'exampl@exam.ple','cae9fa8dd835fc0cf1be17e3b9b8c321c1812f8045fb51c4cf9dfb257199657f8ce73f580cd47215adf92002a7b011c74e8b');
/*!40000 ALTER TABLE `ccm_password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ccm_replies`
--

DROP TABLE IF EXISTS `ccm_replies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ccm_replies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question` int NOT NULL,
  `replied_by` int NOT NULL,
  `who_asked` int NOT NULL,
  `reply` text NOT NULL,
  `replied_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `question_fk_id` (`question`),
  KEY `advisor_fk_id` (`replied_by`),
  KEY `who_asked_fk` (`who_asked`),
  CONSTRAINT `advisor_fk_id` FOREIGN KEY (`replied_by`) REFERENCES `ccm_advisors` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `question_fk_id` FOREIGN KEY (`question`) REFERENCES `ccm_messages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `who_asked_fk` FOREIGN KEY (`who_asked`) REFERENCES `ccm_messages` (`asked_by`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf16;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ccm_replies`
--

LOCK TABLES `ccm_replies` WRITE;
/*!40000 ALTER TABLE `ccm_replies` DISABLE KEYS */;
/*!40000 ALTER TABLE `ccm_replies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ccm_staff`
--

DROP TABLE IF EXISTS `ccm_staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ccm_staff` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(64) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `approved` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf16;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ccm_staff`
--

LOCK TABLES `ccm_staff` WRITE;
/*!40000 ALTER TABLE `ccm_staff` DISABLE KEYS */;
INSERT INTO `ccm_staff` VALUES (1,'test staff','staff001','','$2y$10$8ypil407bWk4wpozlhZCN.HAhDjaFI1/uo2p.LjQCqdEIWGll0wMu',1);
/*!40000 ALTER TABLE `ccm_staff` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-10-25 12:59:42
