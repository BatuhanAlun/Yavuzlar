-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: php_proje
-- ------------------------------------------------------
-- Server version	8.0.39

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
-- Table structure for table `basket`
--

DROP TABLE IF EXISTS `basket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `basket` (
  `id` int NOT NULL AUTO_INCREMENT,
  `meal_id` int NOT NULL,
  `user_id` int NOT NULL,
  `quantity` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `basket`
--

LOCK TABLES `basket` WRITE;
/*!40000 ALTER TABLE `basket` DISABLE KEYS */;
/*!40000 ALTER TABLE `basket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `res_id` int NOT NULL,
  `username` varchar(45) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `score` decimal(10,0) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,1,1,'batuhanal','aefd',4,'2024-09-20 23:28:16'),(2,1,1,'batuhanal','yemeyin cok kotu',0,'2024-09-20 23:50:21');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `company` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cname` varchar(45) NOT NULL,
  `description` varchar(255) DEFAULT 'Not Set',
  `logo_path` varchar(255) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `company_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company`
--

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` VALUES (1,'123','Not Set',NULL,NULL,14),(2,'asdasda','Not Set',NULL,NULL,16);
/*!40000 ALTER TABLE `company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meals`
--

DROP TABLE IF EXISTS `meals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `meals` (
  `id` int NOT NULL AUTO_INCREMENT,
  `res_id` int NOT NULL,
  `company_id` int NOT NULL,
  `meal_des` varchar(255) NOT NULL,
  `meal_price` decimal(10,2) NOT NULL,
  `meal_name` varchar(45) NOT NULL,
  `meal_logo` varchar(255) DEFAULT './uploaded_files/Default_pfp.jpg',
  `meal_discount` decimal(11,0) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meals`
--

LOCK TABLES `meals` WRITE;
/*!40000 ALTER TABLE `meals` DISABLE KEYS */;
INSERT INTO `meals` VALUES (2,1,4,'hello',100000.00,'yemek 2','./uploaded_files/1274564.jpg',5),(3,1,4,'123',123.00,'123','./uploaded_files/wallpaperflare.com_wallpaper.jpg',0),(5,5,4,'asdasdass',12524312.00,'sdasdasda','./uploaded_files/wallpaperflare.com_wallpaper.jpg',0);
/*!40000 ALTER TABLE `meals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `onetime_coupon`
--

DROP TABLE IF EXISTS `onetime_coupon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `onetime_coupon` (
  `id` int NOT NULL AUTO_INCREMENT,
  `c_name` varchar(45) DEFAULT NULL,
  `percentage` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `onetime_coupon`
--

LOCK TABLES `onetime_coupon` WRITE;
/*!40000 ALTER TABLE `onetime_coupon` DISABLE KEYS */;
INSERT INTO `onetime_coupon` VALUES (2,'WELCOME50',0.5),(3,'WELCOME40',0.4);
/*!40000 ALTER TABLE `onetime_coupon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `meal_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `res_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `meal_id` (`meal_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`meal_id`) REFERENCES `meals` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (3,4,2,2,100000.00,1),(4,4,3,1,123.00,1),(5,7,2,1,100000.00,1);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `order_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('Pending','Processing','Completed','Cancelled') DEFAULT 'Pending',
  `notes` text,
  `res_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (4,1,'2024-09-20 23:26:19',100061.50,'Completed','Hello Pls Help me',NULL),(7,1,'2024-09-26 19:06:43',100000.00,'Pending','',NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restoran`
--

DROP TABLE IF EXISTS `restoran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `restoran` (
  `id` int NOT NULL AUTO_INCREMENT,
  `company_id` int NOT NULL,
  `res_des` varchar(255) NOT NULL,
  `logo_path` varchar(255) NOT NULL,
  `res_name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restoran`
--

LOCK TABLES `restoran` WRITE;
/*!40000 ALTER TABLE `restoran` DISABLE KEYS */;
INSERT INTO `restoran` VALUES (1,4,'merhaba','./uploaded_files/programming-code-minimalism-wallpaper-preview.jpg','Cokıırestoran'),(2,4,'1231231','./uploaded_files/wallpaperflare.com_wallpaper.jpg','123123'),(3,4,'omgguys hhlelo','./uploaded_files/programming-code-minimalism-wallpaper-preview.jpg','hellorestorana;lska'),(4,4,'asdadasda','./uploaded_files/1274564.jpg','sdfsdfs'),(5,4,'123456','./uploaded_files/1274564.jpg','alfdkjalkjl');
/*!40000 ALTER TABLE `restoran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `used_coupon`
--

DROP TABLE IF EXISTS `used_coupon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `used_coupon` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `used_coupon_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `used_coupon`
--

LOCK TABLES `used_coupon` WRITE;
/*!40000 ALTER TABLE `used_coupon` DISABLE KEYS */;
INSERT INTO `used_coupon` VALUES (3,1,0),(4,1,2),(5,1,0),(6,1,0);
/*!40000 ALTER TABLE `used_coupon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `company_id` int DEFAULT NULL,
  `rolee` varchar(45) NOT NULL,
  `fname` varchar(45) NOT NULL,
  `surname` varchar(45) NOT NULL,
  `username` varchar(45) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `balance` decimal(15,2) NOT NULL DEFAULT '5000.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `is_admin` int NOT NULL DEFAULT '0',
  `pp_path` varchar(255) DEFAULT NULL,
  `deleted` int DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,NULL,'user','Batuhanala','Aluns','batuhanal','$argon2id$v=19$m=65536,t=4,p=1$OW8ybE0ub2hnU0Nyai5OTw$R5VACpOOmOVabQ3jOWF5TqkCB/oIxIMWWTEuFSH9+cs',999000994.50,'2024-09-10 15:07:05','2024-09-10 18:07:05',0,'./uploaded_files/CaptureA.PNG',0),(3,NULL,'user','batuhan','altun','batuhanaltun','$argon2id$v=19$m=65536,t=4,p=1$dy42dUxIZHBJRWl0VExjcA$F26Jq3Huh8Pgyd1Ft3NSL+NiV1/Cq6fcWadP06V0n3A',5000.00,'2024-09-10 15:26:14',NULL,0,NULL,1),(4,4,'company','companya','companya','companyname','$argon2id$v=19$m=65536,t=4,p=1$Z1d6Q292Z1ZFRzVlSXNmaQ$/7u7ao3o8xWuc1x+aYOMdlo1XhOLA934o/7/RhBMaAU',15100.00,'2024-09-10 15:30:22','2024-09-21 14:53:02',0,'./uploaded_files/AA.PNG',0),(9,9,'company','hello','hello','hewloafpo','$argon2id$v=19$m=65536,t=4,p=1$Q2JKUm1FM2VBYjZkaGdydg$9smjozPJTPha0+W3q9RmX6mEGN0ysSwH4rdiTQ8C1GQ',5000.00,'2024-09-10 16:08:20',NULL,0,NULL,0),(10,10,'company','HelloCOmp','comp','welcomecomp','$argon2id$v=19$m=65536,t=4,p=1$TndkY1UyMVpRYndTTnJjaw$R6C5icsGFtN5lNxxTpCeXfCDbjeUoJIGeIe2iebdl1U',5000.00,'2024-09-10 16:31:15',NULL,0,NULL,0),(11,11,'company','company','cadfa','asdasd','$argon2id$v=19$m=65536,t=4,p=1$cnB1d3ZrZS5xcnhNcXhMUg$ket1G3sBmAMsSHXHNmR6HfMUwcvIJzlAX3snDFU7tk4',5000.00,'2024-09-10 16:31:40',NULL,0,NULL,0),(13,13,'company','123123','1231231','321231','$argon2id$v=19$m=65536,t=4,p=1$cUtQbHdidTlRcFdBeS80Tw$fGMporqJMrIvWnbYxAxzfzyQEk8OSFckWyWetHRev0Y',5000.00,'2024-09-10 16:34:25',NULL,0,NULL,0),(14,14,'company','123','123','123','$argon2id$v=19$m=65536,t=4,p=1$L21yVDZsMGlmOGdEQmxrUw$ILHX8U8EhhwNp5QuB1G7WfwqgJkWwKX16UC0kPlYhZQ',5000.00,'2024-09-10 16:35:12',NULL,0,NULL,0),(15,NULL,'admin','admina','admin','admin','$argon2id$v=19$m=65536,t=4,p=1$OW9aTklIczN4aVNaT0F2MQ$8vENfKwwD+qTnak3Ko3NrAnDnBlK7WiPLRcyNbfUlYk',5000.00,'2024-09-10 22:03:10',NULL,1,'./uploaded_files/2.PNG',0),(16,16,'company','asdasda','sdasda','asdasdad','$argon2id$v=19$m=65536,t=4,p=1$ZFMzYmtDWExWc1ZjRXAweg$6MhNVuN0Q4SBWEPrrjF8y8KPr4IOy/tbh2kib/Lqe2s',5000.00,'2024-09-21 12:04:33',NULL,0,NULL,0);
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

-- Dump completed on 2024-09-28 17:21:25
