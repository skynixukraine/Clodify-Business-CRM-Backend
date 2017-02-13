-- MySQL dump 10.13  Distrib 5.7.17, for Linux (x86_64)
--
-- Host: localhost    Database: newschema
-- ------------------------------------------------------
-- Server version	5.7.17-0ubuntu0.16.04.1

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
-- Table structure for table `api_auth_access_tokens`
--

DROP TABLE IF EXISTS `api_auth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `api_auth_access_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `access_token` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `exp_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_auth_access_tokens`
--

LOCK TABLES `api_auth_access_tokens` WRITE;
/*!40000 ALTER TABLE `api_auth_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `api_auth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `message` varchar(150) DEFAULT NULL,
  `subject` varchar(45) DEFAULT NULL,
  `verifyCode` varchar(250) DEFAULT NULL,
  `attachments` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contract_templates`
--

DROP TABLE IF EXISTS `contract_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contract_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contract_templates`
--

LOCK TABLES `contract_templates` WRITE;
/*!40000 ALTER TABLE `contract_templates` DISABLE KEYS */;
/*!40000 ALTER TABLE `contract_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contracts`
--

DROP TABLE IF EXISTS `contracts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contracts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contract_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `act_number` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `act_date` date DEFAULT NULL,
  `total` decimal(19,2) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `contract_template_id` int(11) DEFAULT NULL,
  `contract_payment_method_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-contracts-customer_id` (`customer_id`),
  KEY `idx-contracts-created_by` (`created_by`),
  KEY `idx-contracts-contract_template_id` (`contract_template_id`),
  KEY `idx-contracts-contract_payment_method_id` (`contract_payment_method_id`),
  CONSTRAINT `fk-contracts-contract_payment_method_id` FOREIGN KEY (`contract_payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-contracts-contract_template_id` FOREIGN KEY (`contract_template_id`) REFERENCES `contract_templates` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-contracts-created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `fk-contracts-customer_id` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contracts`
--

LOCK TABLES `contracts` WRITE;
/*!40000 ALTER TABLE `contracts` DISABLE KEYS */;
/*!40000 ALTER TABLE `contracts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `extensions`
--

DROP TABLE IF EXISTS `extensions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `extensions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `repository` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('EXTENSION','THEME','LANGUAGE') COLLATE utf8_unicode_ci DEFAULT NULL,
  `version` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `package` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `extensions`
--

LOCK TABLES `extensions` WRITE;
/*!40000 ALTER TABLE `extensions` DISABLE KEYS */;
/*!40000 ALTER TABLE `extensions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `subtotal` double DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `date_paid` date DEFAULT NULL,
  `date_sent` date DEFAULT NULL,
  `status` enum('NEW','PAID','CANCELED') COLLATE utf8_unicode_ci DEFAULT 'NEW',
  `note` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_hours` double DEFAULT NULL,
  `contract_number` int(11) DEFAULT NULL,
  `act_of_work` int(11) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT '0',
  `payment_method_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `user_projects` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contract_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `idx-invoice_contract` (`contract_id`),
  CONSTRAINT `fk-invoice_contract` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=266 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `monthly_reports`
--

DROP TABLE IF EXISTS `monthly_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `monthly_reports` (
  `id` int(11) NOT NULL,
  `date_created` timestamp NULL DEFAULT NULL,
  `date_reported` date DEFAULT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Accountant ID (Who creates reports)',
  `income` decimal(10,2) DEFAULT '0.00',
  `salary` decimal(10,2) DEFAULT NULL,
  `rent` decimal(10,2) DEFAULT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `extra_outcome` decimal(10,2) DEFAULT NULL,
  `profit` decimal(10,2) DEFAULT NULL COMMENT 'profit=income - salary - rent - tax - extra_outcome',
  `status` enum('NEW','CONFIRMED') COLLATE utf8_unicode_ci DEFAULT 'NEW',
  `note` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `fk_monthly_reports_users1_idx` (`user_id`),
  CONSTRAINT `fk_monthly_reports_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `monthly_reports`
--

LOCK TABLES `monthly_reports` WRITE;
/*!40000 ALTER TABLE `monthly_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `monthly_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_methods`
--

LOCK TABLES `payment_methods` WRITE;
/*!40000 ALTER TABLE `payment_methods` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_methods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_customers`
--

DROP TABLE IF EXISTS `project_customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_customers` (
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `receive_invoices` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`user_id`,`project_id`),
  KEY `fk_project_customers_projects1_idx` (`project_id`),
  CONSTRAINT `fk_project_customers_projects1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_project_customers_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_customers`
--

LOCK TABLES `project_customers` WRITE;
/*!40000 ALTER TABLE `project_customers` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_developers`
--

DROP TABLE IF EXISTS `project_developers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_developers` (
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `alias_user_id` int(11) DEFAULT NULL,
  `is_pm` tinyint(1) DEFAULT '0',
  `status` enum('ACTIVE','INACTIVE','HIDDEN') COLLATE utf8_unicode_ci DEFAULT 'ACTIVE',
  `is_sales` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`user_id`,`project_id`),
  KEY `fk_project_developers_projects1_idx` (`project_id`),
  CONSTRAINT `fk_project_developers_projects1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_project_developers_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_developers`
--

LOCK TABLES `project_developers` WRITE;
/*!40000 ALTER TABLE `project_developers` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_developers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jira_code` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_logged_hours` double DEFAULT NULL,
  `total_paid_hours` double DEFAULT NULL,
  `status` enum('NEW','ONHOLD','INPROGRESS','DONE','CANCELED') COLLATE utf8_unicode_ci DEFAULT 'NEW',
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT '0',
  `cost` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=298 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `reporter_name` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hours` double DEFAULT NULL,
  `task` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  `date_paid` date DEFAULT NULL,
  `date_report` date DEFAULT NULL,
  `status` enum('NEW','INVOICED','DELETED','PAID','WONTPAID') COLLATE utf8_unicode_ci DEFAULT 'NEW',
  `is_working_day` tinyint(1) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT '0',
  `cost` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `fk_reports_projects1_idx` (`project_id`),
  KEY `fk_reports_users1_idx` (`user_id`),
  KEY `fk_reports_invoices1_idx` (`invoice_id`),
  CONSTRAINT `fk_reports_invoices1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_reports_projects1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_reports_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=364 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salary_history`
--

DROP TABLE IF EXISTS `salary_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salary_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `extra_amount` decimal(10,2) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `fk_salary_history_users1_idx` (`user_id`),
  CONSTRAINT `fk_salary_history_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salary_history`
--

LOCK TABLES `salary_history` WRITE;
/*!40000 ALTER TABLE `salary_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `salary_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support_ticket_comments`
--

DROP TABLE IF EXISTS `support_ticket_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `support_ticket_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` text COLLATE utf8_unicode_ci,
  `date_added` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `support_ticket_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_ticket_comments`
--

LOCK TABLES `support_ticket_comments` WRITE;
/*!40000 ALTER TABLE `support_ticket_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `support_ticket_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support_tickets`
--

DROP TABLE IF EXISTS `support_tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `support_tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `is_private` tinyint(1) DEFAULT '0',
  `assignet_to` int(11) DEFAULT NULL,
  `status` enum('NEW','ASSIGNED','COMPLETED','CANCELLED') COLLATE utf8_unicode_ci DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_completed` datetime DEFAULT NULL,
  `date_cancelled` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_support_tickets_users` (`client_id`),
  CONSTRAINT `fk_support_tickets_users` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=328 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_tickets`
--

LOCK TABLES `support_tickets` WRITE;
/*!40000 ALTER TABLE `support_tickets` DISABLE KEYS */;
/*!40000 ALTER TABLE `support_tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `survey_voters`
--

DROP TABLE IF EXISTS `survey_voters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `survey_voters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `ip` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ua_hash` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `survey_id` int(11) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_survey_voters_users` (`user_id`),
  KEY `fk_survey_voters_surveys` (`survey_id`),
  KEY `fk_survey_voters_surveys_options` (`option_id`),
  CONSTRAINT `fk_survey_voters_surveys` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`),
  CONSTRAINT `fk_survey_voters_surveys_options` FOREIGN KEY (`option_id`) REFERENCES `surveys_options` (`id`),
  CONSTRAINT `fk_survey_voters_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `survey_voters`
--

LOCK TABLES `survey_voters` WRITE;
/*!40000 ALTER TABLE `survey_voters` DISABLE KEYS */;
/*!40000 ALTER TABLE `survey_voters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surveys`
--

DROP TABLE IF EXISTS `surveys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `surveys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shortcode` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `question` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `is_private` tinyint(1) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_votes` int(11) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_surveys_users` (`user_id`),
  CONSTRAINT `fk_surveys_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surveys`
--

LOCK TABLES `surveys` WRITE;
/*!40000 ALTER TABLE `surveys` DISABLE KEYS */;
/*!40000 ALTER TABLE `surveys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surveys_options`
--

DROP TABLE IF EXISTS `surveys_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `surveys_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `survey_id` int(11) DEFAULT NULL,
  `votes` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_surveys_options_users` (`survey_id`),
  CONSTRAINT `fk_surveys_options_users` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surveys_options`
--

LOCK TABLES `surveys_options` WRITE;
/*!40000 ALTER TABLE `surveys_options` DISABLE KEYS */;
/*!40000 ALTER TABLE `surveys_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teammates`
--

DROP TABLE IF EXISTS `teammates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teammates` (
  `team_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `testcol` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`user_id`,`team_id`),
  KEY `teammates_team_id` (`team_id`),
  CONSTRAINT `teammates_team_id` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`),
  CONSTRAINT `teammates_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teammates`
--

LOCK TABLES `teammates` WRITE;
/*!40000 ALTER TABLE `teammates` DISABLE KEYS */;
/*!40000 ALTER TABLE `teammates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `date_created` date DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `team_leader_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `teams_users_id` (`user_id`),
  CONSTRAINT `teams_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` enum('ADMIN','PM','DEV','CLIENT','FIN','SALES') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'DEV',
  `phone` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `middle_name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tags` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `about` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_signup` timestamp NULL DEFAULT NULL,
  `date_login` timestamp NULL DEFAULT NULL,
  `date_salary_up` date DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `salary` int(11) DEFAULT '0',
  `month_logged_hours` int(11) DEFAULT '0',
  `year_logged_hours` int(11) DEFAULT '0',
  `total_logged_hours` int(11) DEFAULT '0',
  `month_paid_hours` int(11) DEFAULT '0',
  `year_paid_hours` int(11) DEFAULT '0',
  `total_paid_hours` int(11) DEFAULT '0',
  `invite_hash` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `is_delete` tinyint(1) DEFAULT '0',
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sing` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `public_profile_key` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_account_en` text COLLATE utf8_unicode_ci,
  `bank_account_ua` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=202 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'ADMIN',NULL,'admin@skynix.co','21232f297a57a5a743894a0e4a801fc3','Admin','User',NULL,NULL,NULL,NULL,'2017-02-12 22:00:00','2017-02-12 22:00:00','2017-02-13',1,100,0,0,0,0,0,0,'',0,NULL,NULL,NULL,NULL,NULL),(2,'DEV',NULL,'dev@skynix.co','21232f297a57a5a743894a0e4a801fc3','Dev','User',NULL,NULL,NULL,NULL,'2017-02-12 22:00:00','2017-02-12 22:00:00','2017-02-13',1,100,0,0,0,0,0,0,'',0,NULL,NULL,NULL,NULL,NULL),(3,'PM',NULL,'pm@skynix.co','21232f297a57a5a743894a0e4a801fc3','PM','user',NULL,NULL,NULL,NULL,'2017-02-12 22:00:00','2017-02-12 22:00:00','2017-02-13',1,100,0,0,0,0,0,0,'',0,NULL,NULL,NULL,NULL,NULL),(4,'CLIENT',NULL,'client@gmail.com','21232f297a57a5a743894a0e4a801fc3','Client','User',NULL,NULL,NULL,NULL,'2017-02-12 22:00:00','2017-02-12 22:00:00','2017-02-13',1,0,0,0,0,0,0,0,'',0,NULL,NULL,NULL,NULL,NULL),(5,'FIN',NULL,'fin@skynix.co','21232f297a57a5a743894a0e4a801fc3','Fin','User',NULL,NULL,NULL,NULL,'2017-02-12 22:00:00','2017-02-12 22:00:00','2017-02-13',1,100,0,0,0,0,0,0,'',0,NULL,NULL,NULL,NULL,NULL),(6,'SALES',NULL,'sales@skynix.co','21232f297a57a5a743894a0e4a801fc3','Sales','User',NULL,NULL,NULL,NULL,'2017-02-12 22:00:00','2017-02-12 22:00:00','2017-02-13',1,100,0,0,0,0,0,0,'',0,NULL,NULL,NULL,NULL,NULL);
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

-- Dump completed on 2017-02-13 16:12:03
