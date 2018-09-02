-- MySQL dump 10.13  Distrib 5.7.12, for osx10.11 (x86_64)
--
-- Host: localhost    Database: csci6221
-- ------------------------------------------------------
-- Server version	5.7.12

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
-- Table structure for table `AccountType`
--

DROP TABLE IF EXISTS `AccountType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AccountType` (
  `AccountType_id` int(11) NOT NULL AUTO_INCREMENT,
  `AccountType_name` varchar(15) NOT NULL,
  PRIMARY KEY (`AccountType_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AccountType`
--

LOCK TABLES `AccountType` WRITE;
/*!40000 ALTER TABLE `AccountType` DISABLE KEYS */;
INSERT INTO `AccountType` VALUES (1,'Debit Card'),(2,'Credit Card'),(3,'Bank Account');
/*!40000 ALTER TABLE `AccountType` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BankAccount`
--

DROP TABLE IF EXISTS `BankAccount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BankAccount` (
  `BankAccount_id` int(11) NOT NULL AUTO_INCREMENT,
  `Account_name` varchar(50) NOT NULL,
  `AccountType_id` int(11) NOT NULL,
  `User_id` int(11) NOT NULL,
  PRIMARY KEY (`BankAccount_id`),
  KEY `fk_UsrBankAcc` (`User_id`),
  KEY `fk_AccTypeBankAcc` (`AccountType_id`),
  CONSTRAINT `fk_AccTypeBankAcc` FOREIGN KEY (`AccountType_id`) REFERENCES `AccountType` (`AccountType_id`),
  CONSTRAINT `fk_UsrBankAcc` FOREIGN KEY (`User_id`) REFERENCES `User` (`User_id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BankAccount`
--

LOCK TABLES `BankAccount` WRITE;
/*!40000 ALTER TABLE `BankAccount` DISABLE KEYS */;
INSERT INTO `BankAccount` VALUES (18,'FatherAccount',3,18),(21,'CitibankMom',1,18),(22,'Citibank Mothers',1,18),(48,'account(father)',1,1),(49,'account(father)',3,25),(50,'debit(mother)',1,25),(51,'credit(shan)',2,25),(52,'account(mother)',3,25);
/*!40000 ALTER TABLE `BankAccount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CategoryOfExpenses`
--

DROP TABLE IF EXISTS `CategoryOfExpenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CategoryOfExpenses` (
  `CategoryExpense_id` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryExpense_name` varchar(30) NOT NULL,
  PRIMARY KEY (`CategoryExpense_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CategoryOfExpenses`
--

LOCK TABLES `CategoryOfExpenses` WRITE;
/*!40000 ALTER TABLE `CategoryOfExpenses` DISABLE KEYS */;
INSERT INTO `CategoryOfExpenses` VALUES (1,'True Expenses'),(2,'Debt Payments'),(3,'Quality of Life Goals'),(4,'Just for Fun'),(5,'Immediate Obligations');
/*!40000 ALTER TABLE `CategoryOfExpenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CurrencyType`
--

DROP TABLE IF EXISTS `CurrencyType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CurrencyType` (
  `Currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `Currency_name` varchar(45) NOT NULL,
  `Abbreviation` varchar(10) NOT NULL,
  PRIMARY KEY (`Currency_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CurrencyType`
--

LOCK TABLES `CurrencyType` WRITE;
/*!40000 ALTER TABLE `CurrencyType` DISABLE KEYS */;
INSERT INTO `CurrencyType` VALUES (1,'USA Dollar','USD'),(2,'China Yuan','CNY'),(3,'Great Britain Pound','GBP'),(4,'Euro','EUR'),(5,'Canadian Dollar','CAD');
/*!40000 ALTER TABLE `CurrencyType` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ExpenseTypes`
--

DROP TABLE IF EXISTS `ExpenseTypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ExpenseTypes` (
  `ExpenseType_id` int(11) NOT NULL AUTO_INCREMENT,
  `ExpenseType_name` varchar(30) NOT NULL,
  `CategoryExpense_id` int(11) NOT NULL,
  PRIMARY KEY (`ExpenseType_id`),
  KEY `fk_cateType_idx` (`CategoryExpense_id`),
  CONSTRAINT `fk_cateType` FOREIGN KEY (`CategoryExpense_id`) REFERENCES `CategoryOfExpenses` (`CategoryExpense_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ExpenseTypes`
--

LOCK TABLES `ExpenseTypes` WRITE;
/*!40000 ALTER TABLE `ExpenseTypes` DISABLE KEYS */;
INSERT INTO `ExpenseTypes` VALUES (1,'Clothing',1),(2,'Gifts',1),(3,'Giving',1),(4,'Medical',1),(5,'Home Insurance',1),(6,'Rent',5),(7,'Electric',5),(8,'Water',5),(9,'Internet',5),(10,'Groceries',5),(11,'Transportation',5),(12,'Student Loan',2),(13,'Auto Loan',2),(14,'Vacation',3),(16,'Fitness',3),(17,'Education',3),(18,'Dining Out',4),(19,'Gaming',4),(20,'Music',4),(21,'Fun Money',4);
/*!40000 ALTER TABLE `ExpenseTypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Expenses`
--

DROP TABLE IF EXISTS `Expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Expenses` (
  `Expense_id` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryExpense_id` int(11) NOT NULL,
  `Expense_sum` float(10,2) NOT NULL,
  `User_id` int(11) NOT NULL,
  `ExpenseType_id` int(11) NOT NULL,
  `Date_expenses` date NOT NULL,
  `Budget_amount` float(10,2) NOT NULL,
  PRIMARY KEY (`Expense_id`),
  KEY `fk_UsrExpenses` (`User_id`),
  KEY `fk_CateExpense_idx` (`CategoryExpense_id`),
  KEY `fkTypeExpense_idx` (`ExpenseType_id`),
  CONSTRAINT `fkTypeExpense` FOREIGN KEY (`ExpenseType_id`) REFERENCES `ExpenseTypes` (`ExpenseType_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_CateExpense` FOREIGN KEY (`CategoryExpense_id`) REFERENCES `CategoryOfExpenses` (`CategoryExpense_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_UsrExpenses` FOREIGN KEY (`User_id`) REFERENCES `User` (`User_id`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Expenses`
--

LOCK TABLES `Expenses` WRITE;
/*!40000 ALTER TABLE `Expenses` DISABLE KEYS */;
INSERT INTO `Expenses` VALUES (38,1,20.00,11,1,'2018-04-01',100.00),(40,1,800.00,18,1,'2018-04-08',700.00),(44,2,200.00,1,12,'2018-04-14',1000.00),(45,1,50.00,1,3,'2018-04-14',200.00),(46,1,60.00,1,4,'2018-04-14',200.00),(47,1,90.00,1,5,'2018-04-14',200.00),(48,2,1000.00,1,12,'2018-04-14',10000.00),(49,3,3000.00,1,16,'2018-04-14',5000.00),(50,4,2000.00,1,18,'2018-04-14',3000.00),(51,5,3000.00,1,7,'2018-04-14',7000.00),(52,4,200.00,1,21,'2018-04-16',300.00),(54,1,10.00,1,1,'2018-04-20',20.00),(55,1,10.00,1,1,'2018-04-20',20.00),(78,2,10.00,1,13,'2018-04-22',10.00),(79,1,23.00,1,2,'2018-04-22',23.00),(80,5,12.00,1,7,'2018-04-22',12.00),(82,1,300.00,25,1,'2018-01-18',500.00),(83,1,50.00,25,2,'2018-01-18',100.00),(84,1,10.00,25,3,'2018-01-18',20.00),(85,1,200.00,25,4,'2018-01-25',1000.00),(86,1,50.00,25,5,'2018-01-05',50.00),(87,2,500.00,25,13,'2018-01-02',500.00),(88,2,383.00,25,12,'2018-01-07',383.00),(89,3,19.95,25,16,'2018-01-22',25.00),(90,3,49.47,25,17,'2018-01-22',100.00),(91,4,435.00,25,18,'2018-01-30',600.00),(92,4,59.99,25,19,'2018-01-18',200.00),(93,4,14.99,25,20,'2018-01-30',14.99),(94,4,950.00,25,21,'2018-01-30',1000.00),(95,5,2280.00,25,6,'2018-01-01',2280.00),(96,5,85.32,25,7,'2018-01-01',100.00),(97,5,70.00,25,8,'2018-01-01',104.00),(98,5,39.99,25,9,'2018-01-01',39.99),(99,5,724.60,25,10,'2018-01-30',800.00),(100,5,380.00,25,11,'2018-01-30',380.00),(101,1,300.00,25,1,'2018-04-22',1000.00),(102,1,55.54,25,2,'2018-04-18',100.00),(103,1,0.00,25,3,'2018-04-01',10.00),(104,1,20.00,25,4,'2018-04-11',200.00),(105,1,50.00,25,5,'2018-04-01',50.00),(106,2,383.00,25,12,'2018-04-12',383.00),(107,2,500.00,25,13,'2018-04-03',500.00),(108,3,14.95,25,16,'2018-04-05',25.00),(109,3,30.00,25,17,'2018-04-15',100.00),(110,4,254.34,25,18,'2018-04-22',800.00),(111,4,125.89,25,19,'2018-04-14',100.00),(112,4,14.89,25,20,'2018-04-05',14.89),(113,4,543.65,25,21,'2018-04-22',1000.00),(114,5,2250.00,25,6,'2018-04-01',2250.00),(115,5,70.00,25,7,'2018-04-02',70.00),(116,5,68.80,25,8,'2018-04-02',104.00),(117,5,39.99,25,9,'2018-04-04',39.99),(118,5,53.54,25,10,'2018-04-21',100.00),(119,5,359.32,25,11,'2018-04-22',900.00),(120,4,58.99,25,19,'2018-04-23',58.99);
/*!40000 ALTER TABLE `Expenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `IncomeType`
--

DROP TABLE IF EXISTS `IncomeType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `IncomeType` (
  `IncomeType_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Income_name` varchar(15) NOT NULL,
  PRIMARY KEY (`IncomeType_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `IncomeType`
--

LOCK TABLES `IncomeType` WRITE;
/*!40000 ALTER TABLE `IncomeType` DISABLE KEYS */;
INSERT INTO `IncomeType` VALUES (1,'Salary(father)'),(2,'Salart(mother)'),(17,'Part Time Job'),(18,'Investment');
/*!40000 ALTER TABLE `IncomeType` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Incomes`
--

DROP TABLE IF EXISTS `Incomes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Incomes` (
  `Income_id` int(11) NOT NULL AUTO_INCREMENT,
  `IncomeType_id` int(11) NOT NULL,
  `Date` date NOT NULL,
  `BankAccount_id` int(11) NOT NULL,
  `User_id` int(11) NOT NULL,
  `Income_sum` float(10,2) NOT NULL,
  PRIMARY KEY (`Income_id`),
  KEY `fk_IncTypeIncomes` (`IncomeType_id`),
  KEY `fk_BanklAccIncomes` (`BankAccount_id`),
  KEY `fk_UsrIncomes` (`User_id`),
  CONSTRAINT `fk_BanklAccIncomes` FOREIGN KEY (`BankAccount_id`) REFERENCES `BankAccount` (`BankAccount_id`),
  CONSTRAINT `fk_UsrIncomes` FOREIGN KEY (`User_id`) REFERENCES `User` (`User_id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Incomes`
--

LOCK TABLES `Incomes` WRITE;
/*!40000 ALTER TABLE `Incomes` DISABLE KEYS */;
INSERT INTO `Incomes` VALUES (33,1,'2018-04-08',18,18,600.00),(57,1,'2018-05-10',48,1,10000.00),(58,1,'2018-01-01',49,25,5000.00),(59,2,'2018-01-01',52,25,5000.00),(60,17,'2018-01-01',51,25,500.00),(61,1,'2018-04-01',49,25,5000.00),(62,2,'2018-04-01',52,25,5000.00),(63,17,'2018-04-01',51,25,550.00),(64,18,'2018-04-23',52,25,8000.00);
/*!40000 ALTER TABLE `Incomes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Notification`
--

DROP TABLE IF EXISTS `Notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Notification` (
  `Notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `Notification_info` varchar(25) NOT NULL,
  `Notification_date` date NOT NULL,
  `User_id` int(11) NOT NULL,
  `Notification_type` int(11) NOT NULL,
  PRIMARY KEY (`Notification_id`),
  KEY `fk_userNotifi_idx` (`User_id`),
  CONSTRAINT `fk_userNotifi` FOREIGN KEY (`User_id`) REFERENCES `User` (`User_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Notification`
--

LOCK TABLES `Notification` WRITE;
/*!40000 ALTER TABLE `Notification` DISABLE KEYS */;
INSERT INTO `Notification` VALUES (16,'Pay for yeah ea','2018-04-28',1,1),(19,'pay for holy water','2018-05-02',1,1),(21,'testme','2018-04-22',1,1),(22,'testete','2018-04-22',1,1),(23,'testete','2018-04-22',1,1),(24,'water','2018-04-22',1,1),(25,'q we','2018-04-22',1,1),(27,'pay for rent','2018-05-01',25,1);
/*!40000 ALTER TABLE `Notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User` (
  `User_id` int(11) NOT NULL AUTO_INCREMENT,
  `User_name` varchar(30) NOT NULL,
  `User_phone` varchar(15) NOT NULL,
  `User_email` varchar(30) NOT NULL,
  `User_password` varchar(15) NOT NULL,
  `Currency_id` int(11) NOT NULL,
  PRIMARY KEY (`User_id`),
  KEY `fk_currUser_idx` (`Currency_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES (1,'SHAN HAN','2022477177','2319012176@qq.com','hs20131312',2),(11,'hs','123123123','123@qq.com','123456',0),(12,'test1','2022477189','12345@gwu.com','4321',0),(13,'han','2022134124','456@gwu.edu','7890',0),(14,'as','123','asd@qq.com','123',0),(15,'das','216','rgvs@qq.com','456',0),(17,'shanshan','2022477177','shan@gwu.edu','hs20131312',0),(18,'sapar','3235431635','nsapar@mail.ru','2012',0),(19,'shan','2022477177','sgshann3@gwu.edu','hs20131312',2),(20,'ss','22222','test@gwu.com','123',2),(21,'gg','22232','qq@qwe.com','1234',1),(22,'test','22221','yy@gwu.edu','1223',1),(24,'finaltesteditname','222222222','wangzhiq@gwu.edu','finaltest',2),(25,'Shan Han','2022477177','sgshan3@gwu.edu','hs20131312',1);
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-23 14:35:23
