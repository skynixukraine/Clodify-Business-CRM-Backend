-- MySQL dump 10.13  Distrib 5.7.23, for Linux (x86_64)
--
-- Host: localhost    Database: skynixcrm_db
-- ------------------------------------------------------
-- Server version	5.7.23

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
  `crowd_exp_date` int(11) DEFAULT NULL,
  `crowd_token` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_auth_access_tokens`
--

LOCK TABLES `api_auth_access_tokens` WRITE;
/*!40000 ALTER TABLE `api_auth_access_tokens` DISABLE KEYS */;
INSERT INTO `api_auth_access_tokens` (`id`, `user_id`, `access_token`, `exp_date`, `crowd_exp_date`, `crowd_token`) VALUES (2,1,'hrOGLFSUvK3F3ppyG8-hzue_3Jr5xO4nNWQLiz2','2018-08-21 16:32:58',NULL,NULL);
INSERT INTO `api_auth_access_tokens` (`id`, `user_id`, `access_token`, `exp_date`, `crowd_exp_date`, `crowd_token`) VALUES (3,8,'LMgMg58VRVF0gfGULDrUIxYJBS7YAY37DE83MdD','2018-08-02 17:14:02',1533221042,'gR1Dv15GHWgRVOL4XUzs5Q00');
/*!40000 ALTER TABLE `api_auth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_types`
--

DROP TABLE IF EXISTS `auth_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_types`
--

LOCK TABLES `auth_types` WRITE;
/*!40000 ALTER TABLE `auth_types` DISABLE KEYS */;
INSERT INTO `auth_types` (`id`, `type_name`) VALUES (1,'crowd_atlassian');
INSERT INTO `auth_types` (`id`, `type_name`) VALUES (2,'local_mysql');
/*!40000 ALTER TABLE `auth_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `availability_logs`
--

DROP TABLE IF EXISTS `availability_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `availability_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_availability_logs_users` (`user_id`),
  CONSTRAINT `fk_availability_logs_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `availability_logs`
--

LOCK TABLES `availability_logs` WRITE;
/*!40000 ALTER TABLE `availability_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `availability_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `busineses`
--

DROP TABLE IF EXISTS `busineses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `busineses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `director_id` int(11) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `busineses`
--

LOCK TABLES `busineses` WRITE;
/*!40000 ALTER TABLE `busineses` DISABLE KEYS */;
INSERT INTO `busineses` (`id`, `name`, `address`, `director_id`, `is_default`, `is_delete`) VALUES (1,'Skynix LLC','6 Bohdana Khmelnytskogo Blvd, Apt. 132, Bucha, Kyiv obl., 08292, UKRAINE',5,1,0);
/*!40000 ALTER TABLE `busineses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `candidates`
--

DROP TABLE IF EXISTS `candidates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `candidates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `career_id` int(11) DEFAULT NULL,
  `first_name` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_applied` timestamp NULL DEFAULT NULL,
  `date_interview` timestamp NULL DEFAULT NULL,
  `is_interviewed` tinyint(1) DEFAULT '0',
  `skills` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `backend_skills` int(11) DEFAULT '0',
  `frontend_skills` int(11) DEFAULT '0',
  `system_skills` int(11) DEFAULT '0',
  `other_skills` int(11) DEFAULT '0',
  `desired_salary` int(11) DEFAULT '0',
  `interviewer_notes` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `fk-post-career_id` (`career_id`),
  CONSTRAINT `fk-post-career_id` FOREIGN KEY (`career_id`) REFERENCES `careers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `candidates`
--

LOCK TABLES `candidates` WRITE;
/*!40000 ALTER TABLE `candidates` DISABLE KEYS */;
/*!40000 ALTER TABLE `candidates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `careers`
--

DROP TABLE IF EXISTS `careers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `careers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `is_active` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `careers`
--

LOCK TABLES `careers` WRITE;
/*!40000 ALTER TABLE `careers` DISABLE KEYS */;
/*!40000 ALTER TABLE `careers` ENABLE KEYS */;
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
INSERT INTO `contract_templates` (`id`, `name`, `content`) VALUES (2,'Default template Skynix','<!doctype html>\r\n<html lang=\"en\">\r\n<head>\r\n    <meta charset=\"utf-8\">\r\n    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\r\n</head>\r\n<body>\r\n<table width=\"570\" style=\" margin-left: auto; margin-right: auto; border-collapse: collapse;\">\r\n    <tr style = \"height: 100%; box-sizing: border-box; border-collapse: collapse; \">\r\n      	<td style =\" vertical-align: top; border-collapse: collapse; border: 1px solid black; border-bottom:none; height: 100%; box-sizing: border-box; padding: 5px 4px 5px 4px;\">\r\n            <table width=\"285\" style=\"margin:0;border-collapse: collapse;border: 0;\">\r\n                <tr>\r\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>CONTRACT №var_contract_id</strong></td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>FOR SERVICES</strong></td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"right\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">var_start_date</td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"right\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><span style=\"color: #ffffff;\">.</span></td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"justify\" style=\"margin: 0;\">\r\n                        <p style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">\r\n                            <span style=\"color: #ffffff;\">.....</span>The company \"var_company_name\"\r\n                            hereinafter referred to as \"Customer\" and the\r\n                            company \"<strong>Skynix Ltd</strong>\",\r\n                            represented by CEO, who is\r\n                            authorized by check #438000980 from\r\n                            01.05.2017, hereinafter referred to as \"Contractor\",\r\n                            and both Companies hereinafter referred to as\r\n                            \"Parties\", have cа oncluded the present Contract as\r\n                            follows:\r\n                        </p>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>1. Subject of the Contract</strong></td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">1.1.The Contractor undertakes to provide the\r\n                        following services to Customer: Software\r\n                        development (web site)<br><span style=\"color: #ffffff;\">.</span></td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>2. Contract Price and total sum</strong></td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">2.1.The price for the Services is established in\r\n                        <strong>$var_total</strong></td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">\r\n                        2.2.The preliminary total sum of the Contract\r\n                        makes <strong>$var_total</strong></td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">\r\n                        2.3.In case of change of the sum of the Contract,\r\n                        the Parties undertake to sign the additional\r\n                        agreement to the given Contract on increase or\r\n                        reduction of a total sum of the Contract.</td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>3. Payment Conditions</strong></td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">3.1.The Customer shall pay by bank transfer to\r\n                        the account within 5 calendar days from the date\r\n                        of signing the acceptance of the Services.</td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">\r\n                        3.2. Bank charges are paid by customer.</td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">\r\n                        3.3. The currency of payment is USD.<br><span style=\"color: #ffffff;\">.</span><br></td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>4. Realisation Terms</strong></td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">4.1.The Contractor shall deliver of the services on\r\n                        consulting services terms.</td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>5. The responsibility of the Parties</strong></td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">5.1. The Parties under take to bear the\r\n                        responsibility for default or inadequate\r\n                        performance of obligations under the present\r\n                        contract</td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>6. Claims</strong></td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">6.1.Claims of quality and quantity of the services\r\n                        delivered according to the present Contract can be\r\n                        made not later 3 days upon the receiving of the\r\n                        Goods.</td>\r\n                </tr>\r\n            </table>\r\n        </td>\r\n    </tr>\r\n</table>\r\n');
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
  CONSTRAINT `fk-contracts-contract_template_id` FOREIGN KEY (`contract_template_id`) REFERENCES `contract_templates` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-contracts-created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `fk-contracts-customer_id` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contracts`
--

LOCK TABLES `contracts` WRITE;
/*!40000 ALTER TABLE `contracts` DISABLE KEYS */;
/*!40000 ALTER TABLE `contracts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `counterparties`
--

DROP TABLE IF EXISTS `counterparties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `counterparties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `counterparties`
--

LOCK TABLES `counterparties` WRITE;
/*!40000 ALTER TABLE `counterparties` DISABLE KEYS */;
/*!40000 ALTER TABLE `counterparties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delayed_salary`
--

DROP TABLE IF EXISTS `delayed_salary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `delayed_salary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  `raised_by` int(11) DEFAULT NULL,
  `is_applied` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delayed_salary`
--

LOCK TABLES `delayed_salary` WRITE;
/*!40000 ALTER TABLE `delayed_salary` DISABLE KEYS */;
/*!40000 ALTER TABLE `delayed_salary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_templates`
--

DROP TABLE IF EXISTS `email_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reply_to` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `body` mediumtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_templates`
--

LOCK TABLES `email_templates` WRITE;
/*!40000 ALTER TABLE `email_templates` DISABLE KEYS */;
INSERT INTO `email_templates` (`id`, `subject`, `reply_to`, `body`) VALUES (1,'Skynix CRM: Change password','{adminEmail}','<tr>\n    <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n    <td colspan = \"3\"  height=\"36\" style=\"padding: 0; margin: 0;\">\n        <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"512\" style=\"border-collapse: collapse;\n     mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto;\">\n            <tr>\n                <td colspan = \"2\" width = \"125\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"></td>\n                <td rowspan = \"2\" width = \"262\" height=\"25\" style=\"padding: 0; margin: 0;\n             font-family: \'HelveticaNeue UltraLight\', sans-serif; font-size: 24px; text-align: center;\n              vertical-align: middle;\"> Hello, <span>{username},</span> </td>\n<td colspan = \"2\" width = \"125\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"></td>\n</tr>\n<tr>\n    <td colspan = \"2\" width = \"125\" height=\"0\" valign=\"top\" style=\"padding: 6px 0; margin: 0; border-top: solid 1px #a3d8f0;\"></td>\n    <td colspan = \"2\" width = \"125\" height=\"0\" valign=\"top\" style=\"padding: 6px 0; margin: 0; border-top: solid 1px #a3d8f0;\"></td>\n</tr>\n</table>\n</td>\n\n<td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n</tr>\n\n<tr>\n    <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n    <td colspan = \"3\"  height=\"15\" style=\"padding: 10px 0 4px 0; margin: 0;\n     font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px;\n     font-weight: normal; text-align: center;\">{username}, go through the link to reset your password.</td>\n    <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n</tr>\n\n<tr>\n    <td colspan = \"5\"  height=\"35\" style=\"padding: 8px 0 5px 0; margin: 0; background-color: #a3d8f0;\n        font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px; text-align: center; color: #fffefe;\">\n        THANK YOU FOR YOUR COLLABORATION WE APPRECIATE YOUR BUSINESS </td>\n</tr>\n<tr>\n    <td colspan = \"2\" width = \"237\" height=\"34\" style=\"padding: 0; margin: 0; background-color: #a3d8f0;\"></td>\n\n    <td width = \"96\"  valign=\"top\" style=\"padding:0; margin: 0; text-align: center; background-color: #a3d8f0;\n        vertical-align: middle;\">\n        <a href={url_crm}/site/code/{token}> title=\"CLICK HERE\" target=\"_blank\" style=\"text-align: center; text-decoration: none;\">\n        <img src=\"http://cdn.skynix.co/skynix/btn-click.png\" width=\"95\" height = \"34\"  border=\"0\"\n             alt = \"CLICK HERE\" style=\"display: block; padding: 0px; margin: 0px; border: none;\"/>\n        </a>\n    </td>\n\n    <td colspan = \"2\" width = \"237\" height=\"34\" style=\"padding: 0; margin: 0; background-color: #a3d8f0;\"></td>\n</tr>\n\n<tr>\n    <td colspan = \"5\"  height=\"13\" style=\"padding: 0; margin: 0; background-color: #a3d8f0;\"></td>\n</tr>');
INSERT INTO `email_templates` (`id`, `subject`, `reply_to`, `body`) VALUES (2,'Skynix Invoice # {dataPdf->id}','{adminEmail}','<tr>\n<td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n<td colspan = \"3\"  height=\"36\" style=\"padding: 0; margin: 0;\">\n    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"512\" style=\"border-collapse: collapse;\n     mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto;\">\n        <tr>\n            <td colspan = \"2\" width = \"125\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"></td>\n            <td rowspan = \"2\" width = \"262\" height=\"25\" style=\"padding: 0; margin: 0;\n             font-family: \'HelveticaNeue UltraLight\', sans-serif; font-size: 24px; text-align: center;\n              vertical-align: middle;\"> Hello, <span>{nameCustomer}</span> </td>\n            <td colspan = \"2\" width = \"125\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"></td>\n        </tr>\n        <tr>\n            <td colspan = \"2\" width = \"125\" height=\"0\" valign=\"top\" style=\"padding: 6px 0; margin: 0; border-top: solid 1px #a3d8f0;\"></td>\n            <td colspan = \"2\" width = \"125\" height=\"0\" valign=\"top\" style=\"padding: 6px 0; margin: 0; border-top: solid 1px #a3d8f0;\"></td>\n        </tr>\n    </table>\n</td>\n\n    <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n</tr>\n<tr>\n    <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n    <td colspan = \"3\"  height=\"16\" style=\"padding: 19px 0 10px 0; margin: 0; font-family: \'HelveticaNeue Regular\',\n    sans-serif; font-size: 16px; font-weight: normal; text-align: center;\">Your invoice #\n    <strong style=\" font-family: \'HelveticaNeue Bold\', sans-serif; font-size: 16px; font-weight: bold;\">{id}</strong></td>\n    <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n</tr>\n<tr>\n    <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n    <td colspan = \"3\"  height=\"15\" style=\"padding: 10px 0 4px 0; margin: 0;\n     font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px;\n     font-weight: normal; text-align: center;\">This invoice has been generated by Skynix company for the period:</td>\n    <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n</tr>\n<tr>\n    <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n    <td colspan = \"3\"  height=\"15\" style=\"padding: 0 0 4px 0; margin: 0;\n     font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px;\n     font-weight: normal; text-align: center;\"><strong style=\" font-family: \'HelveticaNeue Bold\', sans-serif;\n     font-size: 16px; font-weight: bold;\">{dataFrom}  ~ {dataTo}</strong>\n    </td>\n    <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n</tr>\n<tr>\n    <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n    <td colspan = \"3\"  height=\"15\" style=\"padding: 10px 0 28px 0; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif;\n    font-size: 15px; font-weight: normal; text-align: center;\">The PDF invoice with payment details is attached</td>\n    <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n</tr>\n<tr>\n    <td colspan = \"5\"  height=\"35\" style=\"padding: 8px 0 5px 0; margin: 0; background-color: #a3d8f0;\n        font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px; text-align: center; color: #fffefe;\">\n        THANK YOU FOR YOUR COLLABORATION <br/> WE APPRECIATE YOUR BUSINESS </td>\n</tr>\n\n<tr>\n    <td colspan = \"5\"  height=\"13\" style=\"padding: 0; margin: 0; background-color: #a3d8f0;\"></td>\n</tr>');
/*!40000 ALTER TABLE `email_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emergencies`
--

DROP TABLE IF EXISTS `emergencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emergencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `date_registered` int(11) DEFAULT NULL,
  `summary` text COLLATE utf8_bin,
  PRIMARY KEY (`id`),
  KEY `fk_emergencies_users` (`user_id`),
  CONSTRAINT `fk_emergencies_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emergencies`
--

LOCK TABLES `emergencies` WRITE;
/*!40000 ALTER TABLE `emergencies` DISABLE KEYS */;
/*!40000 ALTER TABLE `emergencies` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `extensions`
--

LOCK TABLES `extensions` WRITE;
/*!40000 ALTER TABLE `extensions` DISABLE KEYS */;
/*!40000 ALTER TABLE `extensions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financial_income`
--

DROP TABLE IF EXISTS `financial_income`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financial_income` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` int(11) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `description` text,
  `project_id` int(11) DEFAULT NULL,
  `added_by_user_id` int(11) DEFAULT NULL,
  `developer_user_id` int(11) DEFAULT NULL,
  `financial_report_id` int(11) DEFAULT NULL,
  `from_date` int(11) DEFAULT NULL,
  `to_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_financial_income_users` (`added_by_user_id`),
  KEY `fk_financial_income_projects` (`project_id`),
  KEY `fk_financial_income_fin` (`financial_report_id`),
  CONSTRAINT `fk_financial_income_fin` FOREIGN KEY (`financial_report_id`) REFERENCES `financial_reports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_financial_income_projects` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_financial_income_users` FOREIGN KEY (`added_by_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financial_income`
--

LOCK TABLES `financial_income` WRITE;
/*!40000 ALTER TABLE `financial_income` DISABLE KEYS */;
/*!40000 ALTER TABLE `financial_income` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financial_reports`
--

DROP TABLE IF EXISTS `financial_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financial_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_date` int(11) DEFAULT NULL,
  `currency` double DEFAULT NULL,
  `expense_constant` text COLLATE utf8_unicode_ci,
  `expense_salary` double DEFAULT NULL,
  `investments` text COLLATE utf8_unicode_ci,
  `is_locked` int(11) DEFAULT '0',
  `spent_corp_events` text COLLATE utf8_unicode_ci,
  `num_of_working_days` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financial_reports`
--

LOCK TABLES `financial_reports` WRITE;
/*!40000 ALTER TABLE `financial_reports` DISABLE KEYS */;
INSERT INTO `financial_reports` (`id`, `report_date`, `currency`, `expense_constant`, `expense_salary`, `investments`, `is_locked`, `spent_corp_events`, `num_of_working_days`) VALUES (1,1515535200,NULL,NULL,NULL,NULL,0,NULL,NULL);
INSERT INTO `financial_reports` (`id`, `report_date`, `currency`, `expense_constant`, `expense_salary`, `investments`, `is_locked`, `spent_corp_events`, `num_of_working_days`) VALUES (2,1518213600,26.15,'[{\"amount\":\"4500\",\"description\":\"Office Rent\",\"date\":\"15\"},{\"amount\":\"800\",\"description\":\"Internet\",\"date\":\"20\"},{\"amount\":\"2800\",\"description\":\"Taxes\",\"date\":\"28\"}]',12000,'[{\"amount\":\"1800\",\"description\":\"PC + Other equipment\",\"date\":\"5\"}]',0,'[{\"amount\":\"100\",\"description\":\"Birthdays\",\"date\":\"10\"}]',23);
/*!40000 ALTER TABLE `financial_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financial_yearly_reports`
--

DROP TABLE IF EXISTS `financial_yearly_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financial_yearly_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(11) DEFAULT NULL,
  `income` double DEFAULT NULL,
  `expense_constant` double DEFAULT NULL,
  `investments` double DEFAULT NULL,
  `expense_salary` double DEFAULT NULL,
  `difference` double DEFAULT NULL,
  `bonuses` double DEFAULT NULL,
  `corp_events` double DEFAULT NULL,
  `profit` double DEFAULT NULL,
  `balance` double DEFAULT NULL,
  `spent_corp_events` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financial_yearly_reports`
--

LOCK TABLES `financial_yearly_reports` WRITE;
/*!40000 ALTER TABLE `financial_yearly_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `financial_yearly_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fixed_assets`
--

DROP TABLE IF EXISTS `fixed_assets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fixed_assets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cost` float DEFAULT NULL,
  `inventory_number` int(11) DEFAULT NULL,
  `amortization_method` enum('LINEAR','50/50') COLLATE utf8_unicode_ci DEFAULT 'LINEAR',
  `date_of_purchase` date DEFAULT NULL,
  `date_write_off` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fixed_assets`
--

LOCK TABLES `fixed_assets` WRITE;
/*!40000 ALTER TABLE `fixed_assets` DISABLE KEYS */;
/*!40000 ALTER TABLE `fixed_assets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fixed_assets_operations`
--

DROP TABLE IF EXISTS `fixed_assets_operations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fixed_assets_operations` (
  `fixed_asset_id` int(11) NOT NULL,
  `operation_id` int(11) NOT NULL,
  `operation_business_id` int(11) NOT NULL,
  PRIMARY KEY (`fixed_asset_id`,`operation_id`,`operation_business_id`),
  KEY `fk_fixed_assets_operations_operations1_idx` (`operation_id`,`operation_business_id`),
  CONSTRAINT `fk_fixed_assets_operations_fixed_assets1` FOREIGN KEY (`fixed_asset_id`) REFERENCES `fixed_assets` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_fixed_assets_operations_operations1` FOREIGN KEY (`operation_id`, `operation_business_id`) REFERENCES `operations` (`id`, `business_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fixed_assets_operations`
--

LOCK TABLES `fixed_assets_operations` WRITE;
/*!40000 ALTER TABLE `fixed_assets_operations` DISABLE KEYS */;
/*!40000 ALTER TABLE `fixed_assets_operations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_templates`
--

DROP TABLE IF EXISTS `invoice_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `body` mediumtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_templates`
--

LOCK TABLES `invoice_templates` WRITE;
/*!40000 ALTER TABLE `invoice_templates` DISABLE KEYS */;
INSERT INTO `invoice_templates` (`id`, `name`, `body`) VALUES (1,'invoicePDF','<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">\n<html lang=\"en\">\n<head>\n    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n\n    <title>&#9993;Skynix Invoice #{id}</title>\n    <style>\n        a,\n        a:hover,\n        a:active,\n        a:focus{\n            outline: 0;\n        }\n\n    </style>\n    <!--style=\"border: solid 1px red\"-->\n</head>\n<body style=\"background-color: #ffffff;\">\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"570\" style=\"border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;\">\n    <tr>\n        <td colspan = \"2\"  height=\"17\" width = \"570\" style=\"padding: 0; margin: 0; font-size: 10px\">\n            Page <b>1</b>\n        </td>\n    </tr>\n    <tr>\n        <td width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"></td>\n        <td width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"></td>\n    </tr>\n\n    <tr>\n        <td colspan = \"2\" width = \"570\"  valign=\"top\" style=\"padding: 0; margin: 0;\">\n            <a href=\"https://skynix.co\" title=\"logo Skynix\" target=\"_blank\">\n                <img src=\"{appAlias}/web/img/logo_skynix_color_horizontal.png\" alt=\"Skynix\" border=\"0\" width=\"105\" height=\"28\" style=\"display: block; padding: 0px; margin: 0px; border: none; background-color: white;\">\n            </a>\n        </td>\n    </tr>\n\n    <tr>\n        <td colspan = \"2\"  height=\"30\" width = \"570\" style=\"padding: 0; margin: 0;\"></td>\n    </tr>\n\n    <tr>\n        <td colspan = \"2\" width = \"570\" height=\"23\" valign=\"top\" style=\"padding: 0 0 23px 0; margin: 0; font-size: 23px; font-family: \"HelveticaNeue UltraLight\", sans-serif; font-weight: 600; text-align: center;\">\n            <span style=\"font-weight: 600;\">Invoice (offer) / Інвойс (оферта) # </span>{id}\n        </td>\n    </tr>\n\n    <tr>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Date: </span>{dateInvoiced}\n        </td>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Дата: </span>{dateInvoiced}\n        </td>\n    </tr>\n    <tr>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Supplier: </span>{supplierName} {supplierAddress} Represented by the Director, {supplierDirector}, who acts according to articles of organization\n        </td>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Виконавець: </span>{supplierNameUa} {supplierAddressUa} У особі директора {supplierDirectorUa}, діючої на підставі Статуту\n        </td>\n    </tr>\n    <tr>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Customer: </span>{customerCompany}, {customerAddress} Represented by the Director, {customerName}\n        </td>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Замовник: </span>{customerCompany}, {customerAddress} Represented by the Director, {customerName}\n        </td>\n    </tr>\n    <tr>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Subject matter: </span>Software Development\n        </td>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Предмет: </span>Розробка програмного забезпечення\n        </td>\n    </tr>\n    <tr>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Currency: </span>{currency}\n        </td>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Валюта: </span>{currency}\n        </td>\n    </tr>\n    <tr>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Price (amount) of the goods/services: </span>{priceTotal} {currency}\n        </td>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Ціна (загальна вартість) товарів/послуг: </span>{priceTotal} {currency}\n        </td>\n    </tr>\n    <tr>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Terms of payments and acceptation: </span>Postpayment of 100% upon the services delivery. The services being rendered at the location of the Supplier.\n        </td>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Умови оплати та передачі: </span>100% післяплата за фактом виконання послуг. Послуги надаються за місцем реєстрації Виконавця.\n        </td>\n    </tr>\n    <tr>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb; border-bottom: none;\">\n            <span style=\"font-weight: 900;\">SupplierBank information: </span>\n        </td>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb; border-bottom: none;\">\n            <span style=\"font-weight: 900;\">Реквізити Виконавця: </span>\n        </td>\n    </tr>\n    <tr>\n        <td width = \"285\" valign=\"top\" align=\"left\" style=\"padding: 0; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb; border-top: none;\">\n            {supplierBank}\n        </td>\n        <td width = \"285\" valign=\"top\" align=\"left\" style=\"padding: 0; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb; border-top: none;\">\n            {supplierBankUa}\n        </td>\n    </tr>\n    <tr>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb; border-bottom: none;\">\n            <span style=\"font-weight: 900;\">Customer Bank Information: </span>\n        </td>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb; border-bottom: none;\">\n            <span style=\"font-weight: 900;\">Реквізити Замовника: </span>\n        </td>\n    </tr>\n    <tr>\n        <td width = \"285\" valign=\"top\" align=\"left\" style=\"padding: 0; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb; border-top: none;\">\n            {customerBank}\n        </td>\n        <td width = \"285\" valign=\"top\" align=\"left\" style=\"padding: 0; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb; border-top: none;\">\n            {customerBankUa}\n        </td>\n    </tr>\n    <tr>\n        <td colspan = \"2\"  height=\"17\" width = \"570\" style=\"padding: 0; margin: 0;\">\n\n        </td>\n    </tr>\n</table>\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"570\" style=\"font-size: 12px; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;\">\n\n    <tr>\n        <td colspan = \"2\" width = \"570\" style=\"padding: 0; margin: 0;\">\n            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"570\" style=\"border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;\">\n                <tr>\n                    <td colspan = \"2\"  height=\"17\" width = \"570\" style=\"padding: 0; margin: 0; text-align: left; padding-bottom: 20px; font-size: 10px;\">\n                        Page <b>2</b>\n                    </td>\n                </tr>\n                <tr>\n                    <td width = \"48\" height=\"100\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb; font-style: italic;\">№</td>\n                    <td width = \"244\" height=\"100\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb; font-style: italic;\"><div>Descripion /</div><div>Опис</div></td>\n                    <td width = \"72\" height=\"100\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb; font-style: italic;\"><div>Quantity /</div><div>Кількість</div></td>\n                    <td width = \"105\" height=\"100\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb; font-style: italic;\"><div>Price,{currency} /</div><div>Ціна, {currency}</div></td>\n                    <td width = \"101\" height=\"100\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb; font-style: italic;\"><div>Amount, {currency} /</div><div>Загальна</div><div>вартість,</div><div>{currency}</div></td>\n                </tr>\n                <tr>\n                    <td height=\"17\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;\">1</td>\n                    <td height=\"17\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;\">\n                        Software Development from {dataFrom} to {dataTo}<br>\n                        /Розробка програмного забезпечення\n                        від {dataFromUkr} до {dataToUkr}\n                    </td>\n                    <td height=\"17\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;\">1</td>\n                    <td height=\"17\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;\">{priceTotal} {currency}</td>\n                    <td height=\"17\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;\">{priceTotal} {currency}</td>\n                </tr>\n                <tr>\n                    <td height=\"17\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;\"></td>\n                    <td height=\"17\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;\"></td>\n                    <td height=\"17\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;\"></td>\n                    <td height=\"17\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;\"><span style=\"font-weight: 900;\">Total/Усього: </span></td>\n                    <td height=\"17\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;\"><span style=\"font-weight: 900;\">{priceTotal}</span> {currency}</td>\n                </tr>\n            </table >\n        </td>\n    </tr>\n    <tr>\n        <td colspan = \"2\"  height=\"17\" width = \"570\" style=\"padding: 0; margin: 0; text-align: left\">\n\n        </td>\n    </tr>\n</table>\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"570\" style=\"font-size: 12px; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;\">\n    <tr>\n        <td width = \"285\" height=\"1\" style=\"padding: 0; margin: 0;\"></td>\n        <td width = \"285\" height=\"1\" style=\"padding: 0; margin: 0;\"></td>\n    </tr>\n    <tr>\n        <td colspan=\"2\" width = \"570\"  valign=\"top\" style=\"padding: 10px; margin: 0;\">\n            <a href=\"https://skynix.co\" title=\"logo Skynix\" target=\"_blank\">\n                <img src=\"{appAlias}/web/img/logo_skynix_color_horizontal.png\" alt=\"Skynix\" border=\"0\" width=\"105\" height=\"28\" style=\"display: block; padding: 0px; margin: 0px; border: none; background-color: white;\">\n            </a>\n        </td>\n    </tr>\n    <tr>\n        <td colspan = \"2\" width = \"570\" style=\"padding: 0; margin: 0;\">\n            All charges of correspondent banks are at the Customer’s expenses. / Усі комісії банків-кореспондентів сплачує Замовник.\n        </td>\n    </tr>\n\n    <tr>\n        <td colspan = \"2\" width = \"570\" style=\"padding: 0; margin: 0;\">\n            This Invoice is an offer to enter into the agreement. Payment according hereto shall be deemed as an acceptation of the offer to enter into the agreement on the terms and conditions set out herein.\n            Payment according hereto may be made not later than <span style=\"font-weight: 900;\">{dateToPay}</span>. / Цей Інвойс є пропозицією укласти договір.\n            Оплата за цим Інвойсом є прийняттям пропозиції укласти договір на умовах, викладених в цьому Інвойсі. Оплата за цим інвойсом може бути здійснена не пізніше <span style=\"font-weight: 900;\">{dateToPay}</span>.\n        </td>\n    </tr>\n    <tr>\n        <td colspan = \"2\" height=\"17\" width = \"570\" style=\"padding: 0; margin: 0;\">\n        </td>\n    </tr>\n    <tr>\n        <td colspan = \"2\" width = \"570\" style=\"padding: 0; margin: 0;\">\n            Please note, that payment according hereto at the same time is the evidence of the work performance and the service delivery in full scope, acceptation thereof and the confirmation of final mutual installments between\n            Parties. / Оплата згідно цього Інвойсу одночасно є свідченням виконання робіт та надання послуг в повному обсязі, їх прийняття, а також підтвердженням кінцевих розрахунків між Сторонами.\n        </td>\n    </tr>\n    <tr>\n        <td colspan = \"2\" height=\"17\" width = \"570\" style=\"padding: 0; margin: 0;\">\n        </td>\n    </tr>\n    <tr>\n        <td colspan = \"2\" width = \"570\" style=\"padding: 0; margin: 0;\">\n            Payment according hereto shall be also the confirmation that Parties have no claims to each other and have no intention to submit any claims. The agreement shall not include penalty and fine clauses. / Оплата згідно цього Інвойсу є підтвердженням того, що Сторони не мають взаємних претензій та не мають наміру направляти рекламації. Договір не передбачає штрафних санкцій.\n        </td>\n    </tr>\n    <tr>\n        <td colspan = \"2\" height=\"17\" width = \"570\" style=\"padding: 0; margin: 0;\">\n        </td>\n    </tr>\n    <tr>\n        <td colspan = \"2\" width = \"570\" style=\"padding: 0; margin: 0;\">\n            The Parties shall not be liable for non-performance or improper performance of the obligations under the agreement during the term of insuperable force circumstances. / Сторони звільняються від відповідальності за невиконання чи неналежне виконаннязобов’язань за договором на час дії форс-мажорних обставин.\n        </td>\n    </tr>\n    <tr>\n        <td colspan = \"2\" height=\"17\" width = \"570\" style=\"padding: 0; margin: 0;\">\n        </td>\n    </tr>\n    <tr>\n        <td colspan = \"2\" width = \"570\" style=\"padding: 0; margin: 0;\">\n            Any disputes arising out of the agreement between the Parties shall be settled by the competent court at the location of a defendant. / Всі спори, що виникнуть між Сторонами по договору будуть розглядатись компетентним судом за місцезнаходження відповідача.\n        </td>\n    </tr>\n    <tr>\n        <td colspan = \"2\" height=\"30\" width = \"570\" style=\"padding: 0; margin: 0;\">\n        </td>\n    </tr>\n    <tr>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left;\">\n            <span style=\"font-weight: 900;\">Supplier/Виконавець: </span>\n        </td>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left;\">\n            <span style=\"font-weight: 900;\">Customer/Замовник: </span>\n        </td>\n    </tr>\n</table>\n\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"570\" style=\"border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;\">\n\n    <tr>\n        <td width=\"200\" height=\"17\" style=\"padding: 0; margin: 0;\"></td>\n        <td width=\"100\" height=\"17\" style=\"padding: 0; margin: 0;\"></td>\n        <td width=\"200\" height=\"17\" style=\"padding: 0; margin: 0;\"></td>\n        <td width=\"70\" height=\"17\" style=\"padding: 0; margin: 0;\"></td>\n    </tr>\n    <tr>\n        <td width = \"200\" valign=\"middle\" align=\"right\" style=\"padding: 0; margin: 0; vertical-align: middle;\">\n            <img src=\"{signatureContractor}\" alt=\"signatures contractor\" border=\"0\"  style=\"padding: 0px; margin: 0px; border: none; display: block; max-width: 120px; \">\n        </td>\n        <td width=\"100\" height=\"75\" style=\"padding: 0; margin: 0;\"></td>\n        <td width=\"200\" valign=\"middle\" align=\"right\" style=\"padding: 0; margin: 0;\">\n            <img src=\"{signatureCustomer}\" alt=\"signatures customer\" border=\"0\" style=\"padding: 0px; margin: 0px; border: none; display: block; max-width: 120px; \">\n        </td>\n        <td width = \"70\" style=\"padding: 0; margin: 0;\">\n        </td>\n    </tr>\n    <tr>\n        <td width=\"200\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0; border-bottom: solid 2px #343434;\"></td>\n        <td width=\"100\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"></td>\n        <td width=\"200\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0; border-bottom: solid 2px #343434;\"></td>\n        <td width=\"70\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"></td>\n    </tr>\n    <tr>\n        <td width=\"200\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"><div>{supplierDirector}</div><div>Director of {supplierName}</div></td>\n        <td width=\"100\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"></td>\n        <td width=\"200\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"><div>{customerName}</div><div>Director of {customerCompany}</div></td>\n        <td width=\"70\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"></td>\n    </tr>\n</table >\n</body>\n</html>\n');
/*!40000 ALTER TABLE `invoice_templates` ENABLE KEYS */;
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
  `project_id` int(11) DEFAULT NULL,
  `contract_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `currency` varchar(5) COLLATE utf8_unicode_ci DEFAULT 'USD',
  `invoice_id` int(11) DEFAULT '0',
  `payment_method_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `idx-invoice_contract` (`contract_id`),
  KEY `idx-invoices-created_by` (`created_by`),
  CONSTRAINT `fk-invoice_contract` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk-invoices-created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
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
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m000000_000000_base',1455021189);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160125_170036_alter_reports_hours',1455021190);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160127_130244_users_role_add_fin',1455021190);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160128_121751_users_add_invite_hash',1455021190);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160128_144305_users_phone_is_null',1455021190);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160201_104354_user_add_is_deleted',1455021190);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160203_093008_projects_add_is_deleted',1455021190);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160204_083656_projects_id_AUTO_INCREMENT',1455021190);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160204_160915_projects_date_start_date_end_DATE',1455021190);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160208_165328_reports_add_is_deleted',1455105861);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160217_092401_invoices_add_note',1456088295);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160219_101829_invoices_id_AUTO_INCREMENT',1456088759);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160219_150941_invoices_date_to_DATE',1456167462);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160219_155225_invoices_add_total_hours',1456167462);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160226_113724_users_date_signup_date_login_date_salary_up_DATE',1456667132);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160301_141851_create_table_paiment_methods',1457670979);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160301_144739_invoices_add_contract_number_and_act_of_work',1457670979);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160302_052720_gopa',1456896447);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160302_101023_payment_methods_insert_bank_transfer',1457878959);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160302_101913_payment_methods_description',1457878959);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160302_103718_payment_methods_add_description',1457878959);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160311_091242_payment_methods_update_description',1457878959);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160316_103526_table_users_timestamp_data_signup_data_login',1458635908);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160317_071410_usercontroller_date_login_and_date_signup_time',1458635913);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160317_095404_create_table_teams_and_teammates',1458635913);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160317_130740_invoices_add_is_delete',1458635913);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160322_081059_add_key_table_users_and_teams',1458635913);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160322_090400_fix_ref',1458637923);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160322_101526_add_key_pk__teammates_and_add_key_table_users_team_teammates',1460101808);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160414_082424_teammate_add_is_deleted',1460645711);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160414_105046_teams_add_column_team_leader_id',1460645711);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160504_151046_surveys',1462376708);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160504_153333_survey_options',1462376708);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160507_135846_add_is_delete_surveys',1462639507);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160515_062903_survey_foraign_keys',1463305506);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160515_081552_survey_voter_option_id',1463305507);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160517_131145_add_column_photo_and_sign',1463558587);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160526_111906_create_table_extensions',1464361748);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160526_132832_rename_table_table_extensions',1464361748);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160527_053653_table_support_tickets_support_ticket_comments',1464330426);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160601_074725_add_key_support_users',1465222329);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160606_100011_change_surveys_question',1465222329);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160613_121331_add_column_date_cancelled_table_support_ticket',1465828389);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160712_135515_api_auth_access_tokens',1485078314);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160811_103916_add_column_table_invoice_paymet_method',1470919510);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160829_125553_chenge_table_invoice_type',1472545370);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160925_134505_create_table_projects_total_hours',1474813629);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160929_185544_add_role_sales_table_users',1475223142);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m160929_193333_add_id_sales_table_project_developers',1475223143);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m161130_082130_project_id_column_in_invoice_table',1481187740);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m161201_091313_public_profile_key_in_users_table',1481187740);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m161202_142913_cost_column_in_project_table',1481187741);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m161220_132038_added',1482324313);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m161222_135151_new_table_contracts',1482751517);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m161226_153339_created_by_column_in_contracts_table',1483110011);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170105_105052_new_column_in_table_invoice',1483713012);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170107_074133_invoice_contract',1483780375);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170111_123813_contract_templates_table_create',1484139613);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170112_092909_contract_template_id_column_in_Contracts_table',1484225112);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170112_100123_new_column_contract_payment_method_id_in_contracts_table',1484225113);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170112_125354_new_columns_bank_account_enUa_in_users_table',1484231116);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170121_110057_insert_in_contractr_template',1485181513);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170121_132013_insert_in_payment_methods',1485181513);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170126_113509_modified_insert_in_CONTRACT_TEMPLATE_and_PAYMENT_METHODS',1485523817);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170130_130822_updated_payment_method_deleted_sign_from_template',1485791718);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170201_134821_update_contract_template',1486030511);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170202_135748_update_contract_template_simply_edits',1486049417);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170203_104959_update_contract_template__deleted_border_bottom',1486124277);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170213_133256_new_table_contact_form',1488385608);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170216_164829_alter_table_contract_total',1488385609);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170220_091553_added_created_by_column_in_invoices_table',1488385610);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170301_170626_ON_DELETE_action_for_invoices_when_delete_related_contract',1491914106);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170316_141047_alter_contact_table_encoding',1491914107);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170404_081923_users_add_password_reset_token',1491914107);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170404_140151_users_remove_not_null_for_invite_hash',1491914108);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170405_133928_create_table_careers',1491914108);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170405_134435_create_table_candidates',1491914108);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170419_091723_add_columns_users_table',1493203693);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170419_093831_add_columns_projects_table',1493203693);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170419_095059_create_work_history_table',1493203693);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170426_080723_add_slug_column_to_users',1493216253);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170721_083953_create_financial_reports_table',1500630570);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170721_142534_rename_report_date_column',1500896273);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170801_112518_add_spent_corp_events_col_to_finreport',1502459546);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170802_113430_add_column_is_locked_tofinrep_table',1501857273);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170804_063417_create_financial_yearly_reports_tab',1501856127);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170823_091142_create_salary_reports_tab',1503654146);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170823_092953_create_salary_report_lists_tab',1503654147);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170825_081149_add_num_of_working_days_column_to_financial_reports_table',1503906695);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170825_104725_add_foreign_keys_for_salary_report_lists',1504074562);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170825_105204_add_official_salary_column_to_users_table',1504023126);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170829_063540_change_type_of_actually_worked_out_salary',1504271483);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m170914_080452_change_type_of_columns_in_fin_yearly_report',1505482675);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m171019_065952_create_settings_table',1508406015);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m171019_070303_insert_into_settings_corpevents_and_bonuses',1508406015);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m171102_112931_add_is_approved_reports',1509950629);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m171103_072238_create_report_actions_tbl',1509968236);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m171107_065613_create_counterparties_table',1510052164);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m171107_152204_create_busineses_table',1510131527);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m171108_104332_create_operation_types_table',1510237937);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m171108_120214_create_reference_book_tbl',1510237022);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m171109_093535_alter_column_id_in_operations',1510846528);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m171109_093636_create_transactions_table',1510846528);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m171109_132006_alter_column_id_in_transactions',1510846528);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m171109_135702_alter_column_code_in_reference_book',1510846528);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m171219_141221_create_access_keys_table',1514380777);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180118_094617_create_auth_types_table',1517472938);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180118_094629_add_column_authtype_to_users',1517472938);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180302_085003_add_new_columns_to_businesses_tbl',1520927210);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180302_091459_add_modify_columns_of_invoices_table',1520927210);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180321_095840_projects_total_approved_hours',1521654364);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180328_100625_create_fixed_assets_tbl',1522306458);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180328_111012_create_fixed_assets_operations_tbl',1522306458);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180328_130334_not_required_fields_in_transactions',1522318925);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180329_163123_operation_type_amortization',1522936839);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180405_124521_add_is_avaialble_to_users',1522937326);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180405_125642_create_availability_logs_tbl',1522937326);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180415_063408_emergencies',1523789495);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180418_111016_add_is_deleted_col_to_operations_tbl',1524143348);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180418_152343_add_new_operation_types',1524132416);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180426_133721_create_delayed_salary_tbl',1524756412);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180427_080045_alter_table_delayed_salary',1524823336);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180427_080046_labor_expenses_ratio',1525616583);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180606_144521_incoice_id',1528296404);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180606_160830_business_ua_information',1528373454);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180607_101217_user_address',1528373454);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180607_183036_salary_list_vacations',1528397514);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180607_195455_financial_income',1528401621);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180607_205300_financial_income_migration',1528452136);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180611_170241_work_history_dates',1528737246);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180626_095445_add_from_to_dates_for_income',1530008233);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180626_185114_refactor_crowd_token',1530047003);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180627_075434_sso_settings',1530089903);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180629_093330_add_guest_role',1530269959);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180705_022523_work_history_postedby',1530783688);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180705_023535_create_system_user',1530783688);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180714_072024_project_type',1531666457);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180802_111639_refactor_payment_methods_database',1533633694);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180804_114438_only_approved_hours',1533633699);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180804_125259_salary_report_non_approved_hours',1533633700);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180810_125648_payment_methods_set_business_id',1534178933);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180821_132253_business_add_is_deleted_field',1534857935);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180821_133517_business_set_is_default',1534858579);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180822_092951_create_email_templates_table',1534930469);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180822_122257_refactor_all_emails_sent_by_system',1534942663);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180823_082338_create_invoice_template_table',1535014842);
INSERT INTO `migration` (`version`, `apply_time`) VALUES ('m180823_093706_refactor_invoice_pdf_template',1535026142);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `milestones`
--

DROP TABLE IF EXISTS `milestones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `milestones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `name` text,
  `status` enum('NEW','CLOSED') DEFAULT NULL,
  `estimated_amount` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `closed_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_milestones_projects` (`project_id`),
  CONSTRAINT `fk_milestones_projects` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `milestones`
--

LOCK TABLES `milestones` WRITE;
/*!40000 ALTER TABLE `milestones` DISABLE KEYS */;
/*!40000 ALTER TABLE `milestones` ENABLE KEYS */;
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
-- Table structure for table `operation_types`
--

DROP TABLE IF EXISTS `operation_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `operation_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `operation_types`
--

LOCK TABLES `operation_types` WRITE;
/*!40000 ALTER TABLE `operation_types` DISABLE KEYS */;
INSERT INTO `operation_types` (`id`, `name`) VALUES (1,'Bank Operations');
INSERT INTO `operation_types` (`id`, `name`) VALUES (2,'Currency Operations');
INSERT INTO `operation_types` (`id`, `name`) VALUES (3,'Taxes');
INSERT INTO `operation_types` (`id`, `name`) VALUES (4,'Salary Taxes');
INSERT INTO `operation_types` (`id`, `name`) VALUES (5,'Statutory fund\r\n');
INSERT INTO `operation_types` (`id`, `name`) VALUES (6,'Acquisition of fixed assets');
INSERT INTO `operation_types` (`id`, `name`) VALUES (7,'Calculation of Salaries');
INSERT INTO `operation_types` (`id`, `name`) VALUES (8,'Amortization');
INSERT INTO `operation_types` (`id`, `name`) VALUES (9,'Implementation of services');
INSERT INTO `operation_types` (`id`, `name`) VALUES (10,'Receipt of goods (services)');
/*!40000 ALTER TABLE `operation_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `operations`
--

DROP TABLE IF EXISTS `operations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `operations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('DONE','CANCELED') COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_created` int(11) DEFAULT NULL,
  `date_updated` int(11) DEFAULT NULL,
  `operation_type_id` int(11) NOT NULL,
  `is_deleted` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`id`,`business_id`),
  KEY `fk_operations_busineses1_idx` (`business_id`),
  KEY `fk_operations_operation_types1_idx` (`operation_type_id`),
  CONSTRAINT `fk_operations_busineses1` FOREIGN KEY (`business_id`) REFERENCES `busineses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_operations_operation_types1` FOREIGN KEY (`operation_type_id`) REFERENCES `operation_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `operations`
--

LOCK TABLES `operations` WRITE;
/*!40000 ALTER TABLE `operations` DISABLE KEYS */;
/*!40000 ALTER TABLE `operations` ENABLE KEYS */;
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
  `name_alt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_alt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `represented_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `represented_by_alt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_information` text COLLATE utf8_unicode_ci,
  `bank_information_alt` text COLLATE utf8_unicode_ci,
  `is_default` tinyint(1) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `business_id` (`business_id`),
  CONSTRAINT `business_id` FOREIGN KEY (`business_id`) REFERENCES `busineses` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_methods`
--

LOCK TABLES `payment_methods` WRITE;
/*!40000 ALTER TABLE `payment_methods` DISABLE KEYS */;
INSERT INTO `payment_methods` (`id`, `name`, `name_alt`, `address`, `address_alt`, `represented_by`, `represented_by_alt`, `bank_information`, `bank_information_alt`, `is_default`, `business_id`) VALUES (1,'Skynix LLC','ТОВ Скайнікс','6 Bohdana Khmelnytskogo Blvd, Apt. 132, Bucha, Kyiv obl., 08292, UKRAINE','бул. Богдана Хмельницького 6, кв.132, м Буча, Київська обл., 08292, Україна','Krystyna\r\nAntypova','Антипової Кристини Миколаївни','<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"282\" style=\"border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;\">\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Beneficiary:  </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">KYNIX” LLC</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Account # :</td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">26007056216480</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"><span>Beneficiary\'s bank: </span>SC CB \"PRIVATBANK\" 1D HRUSHEVSKOHO STR., KYIV, 01001, UKRAINE</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">SWIFT code: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">BANUA2X</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\">IBAN Code:</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\">UA393802690000026007056216480</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"></td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"> <span style=\"font-weight: 900; text-decoration: underline;\">Correspondent bank #1: </span></td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\">JP Morgan Chase Bank, New York, USA</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Account No.: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">001-1-000080</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">SWIFT code: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">CHASUS33</td>\r\n                </tr>\r\n            </table >','<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"282\" style=\"border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;\">\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Бенефіциар: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">ТОВ \"СКАЙНІКС\"</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Account # :</td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">26007056216480</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"><span>Банк бенефіциара: </span>ПАТ КБ «ПРИВАТБАНК», вул. Грушевського 1Д, Київ, 01001, Україна</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">SWIFT код :</td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">PBANUA2X</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\">IBAN код: </td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\">UA393802690000026007056216480</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"></td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"> <span style=\"font-weight: 900; text-decoration: underline;\">Банк-корреспондент #1: </span></td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\">JP Morgan Chase Bank, New York, USA</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Account No.: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">001-1-000080</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">SWIFT code: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">CHASUS33</td>\r\n                </tr>\r\n            </table >',NULL,1);
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
INSERT INTO `project_customers` (`user_id`, `project_id`, `receive_invoices`) VALUES (4,1,1);
INSERT INTO `project_customers` (`user_id`, `project_id`, `receive_invoices`) VALUES (4,2,1);
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
INSERT INTO `project_developers` (`user_id`, `project_id`, `alias_user_id`, `is_pm`, `status`, `is_sales`) VALUES (1,1,NULL,0,'ACTIVE',0);
INSERT INTO `project_developers` (`user_id`, `project_id`, `alias_user_id`, `is_pm`, `status`, `is_sales`) VALUES (1,2,NULL,0,'ACTIVE',0);
INSERT INTO `project_developers` (`user_id`, `project_id`, `alias_user_id`, `is_pm`, `status`, `is_sales`) VALUES (2,2,NULL,0,'ACTIVE',0);
INSERT INTO `project_developers` (`user_id`, `project_id`, `alias_user_id`, `is_pm`, `status`, `is_sales`) VALUES (3,1,NULL,0,'ACTIVE',0);
INSERT INTO `project_developers` (`user_id`, `project_id`, `alias_user_id`, `is_pm`, `status`, `is_sales`) VALUES (3,2,NULL,0,'ACTIVE',0);
INSERT INTO `project_developers` (`user_id`, `project_id`, `alias_user_id`, `is_pm`, `status`, `is_sales`) VALUES (5,1,NULL,0,'ACTIVE',1);
INSERT INTO `project_developers` (`user_id`, `project_id`, `alias_user_id`, `is_pm`, `status`, `is_sales`) VALUES (5,2,NULL,0,'ACTIVE',1);
INSERT INTO `project_developers` (`user_id`, `project_id`, `alias_user_id`, `is_pm`, `status`, `is_sales`) VALUES (6,1,NULL,1,'ACTIVE',0);
INSERT INTO `project_developers` (`user_id`, `project_id`, `alias_user_id`, `is_pm`, `status`, `is_sales`) VALUES (6,2,NULL,1,'ACTIVE',0);
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
  `description` text COLLATE utf8_unicode_ci,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT '0',
  `total_approved_hours` int(11) DEFAULT NULL,
  `type` enum('HOURLY','FIXED_PRICE') COLLATE utf8_unicode_ci DEFAULT 'HOURLY',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` (`id`, `name`, `jira_code`, `total_logged_hours`, `total_paid_hours`, `status`, `date_start`, `date_end`, `is_delete`, `cost`, `description`, `photo`, `is_published`, `total_approved_hours`, `type`) VALUES (1,'Magento 2 Enterprise Edition - Theme Development','M2EET',1208,1200,'INPROGRESS','2018-05-01',NULL,0,3170.00,NULL,NULL,0,0,'HOURLY');
INSERT INTO `projects` (`id`, `name`, `jira_code`, `total_logged_hours`, `total_paid_hours`, `status`, `date_start`, `date_end`, `is_delete`, `cost`, `description`, `photo`, `is_published`, `total_approved_hours`, `type`) VALUES (2,'Internal (Non Paid) Tasks',NULL,10000,120,'INPROGRESS','2016-04-04',NULL,0,33000.00,NULL,NULL,0,120,'HOURLY');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reference_book`
--

DROP TABLE IF EXISTS `reference_book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reference_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=331 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reference_book`
--

LOCK TABLES `reference_book` WRITE;
/*!40000 ALTER TABLE `reference_book` DISABLE KEYS */;
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (1,'Основні засоби ','10');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (2,'Земельні ділянки ','101');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (3,'Капітальні витрати на поліпшення земель ','102');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (4,'Будинки та споруди ','103');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (5,'Машини та обладнання ','104');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (6,'Транспортні засоби ','105');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (7,'Інструменти, прилади та інвентар ','106');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (8,'Робоча і продуктивна худоба ','107');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (9,'Багаторічні насадження ','108');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (10,'Інші основні засоби ','109');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (11,'Інші необоротні матеріальні активи ','11');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (12,'Бібліотечні фонди ','111');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (13,'Малоцінні необоротні матеріальні активи ','112');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (14,'Тимчасові (нетитульні) споруди ','113');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (15,'Природні ресурси ','114');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (16,'Інвентарна тара ','115');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (17,'Предмети прокату ','116');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (18,'Інші необоротні матеріальні активи ','117');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (19,'Нематеріальні активи ','12');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (20,'Права користування природними ресурсами ','121');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (21,'Права користування майном ','122');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (22,'Права на знаки для товарів і послуг ','123');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (23,'Права на об\'єкти промислової власності ','124');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (24,'Авторські та суміжні з ними права ','125');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (25,'Інші нематеріальні активи ','127');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (26,'Знос (амортизація) необоротних активів ','13');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (27,'Знос основних засобів ','131');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (28,'Знос інших необоротних матеріальних активів ','132');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (29,'Накопичена амортизація нематеріальних активів ','133');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (30,'Довгострокові фінансові інвестиції ','14');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (31,'Інвестиції пов\'язаним сторонам за методом обліку участі в капіталі ','141');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (32,'Інші інвестиції пов\'язаним сторонам ','142');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (33,'Інвестиції непов\'язаним сторонам ','143');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (34,'Капітальні інвестиції ','15');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (35,'Капітальне будівництво ','151');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (36,'Придбання (виготовлення) основних засобів ','152');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (37,'Придбання (виготовлення) інших необоротних матеріальних активів ','153');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (38,'Придбання (створення) нематеріальних активів ','154');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (39,'Формування основного стада ','155');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (40,'Довгострокова дебіторська заборгованість ','16');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (41,'Заборгованість за майно, що передано у фінансову оренду ','161');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (42,'Довгострокові векселі одержані ','162');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (43,'Інша дебіторська заборгованість ','163');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (44,'Відстрочені податкові активи ','17');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (45,'Інші необоротні активи ','18');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (46,'Гудвіл при придбанні ','19');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (47,'Гудвіл ','191');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (48,'Негативний гудвіл ','192');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (49,'Виробничі запаси ','20');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (50,'Сировина й матеріали ','201');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (51,'Купівельні напівфабрикати та комплектуючі вироби ','202');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (52,'Паливо ','203');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (53,'Тара й тарні матеріали ','204');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (54,'Будівельні матеріали ','205');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (55,'Матеріали, передані в переробку ','206');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (56,'Запасні частини ','207');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (57,'Матеріали сільськогосподарського призначення ','208');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (58,'Інші матеріали ','209');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (59,'Тварини на вирощуванні та відгодівлі ','21');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (60,'Молодняк тварин на вирощуванні ','211');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (61,'Тварини на відгодівлі ','212');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (62,'Птиця ','213');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (63,'Звірі ','214');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (64,'Кролі ','215');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (65,'Сім\'ї бджіл ','216');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (66,'Доросла худоба, що вибракувана з основного стада ','217');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (67,'Худоба, що прийнята від населення для реалізації ','218');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (68,'Малоцінні та швидкозношувані предмети ','22');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (69,'Виробництво ','23');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (70,'Брак у виробництві ','24');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (71,'Напівфабрикати ','25');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (72,'Готова продукція ','26');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (73,'Продукція сільськогосподарського виробництва','27');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (74,'Товари ','28');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (75,'Товари на складі ','281');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (76,'Товари в торгівлі ','282');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (77,'Товари на комісії ','283');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (78,'Тара під товарами ','284');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (79,'Торгова націнка ','285');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (80,'Каса ','30');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (81,'Каса в національній валюті ','301');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (82,'Каса в іноземній валюті ','302');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (83,'Рахунки в банках ','31');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (84,'Поточні рахунки в національній валюті ','311');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (85,'Поточні рахунки в іноземній валюті ','312');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (86,'Інші рахунки в банку в національній валюті ','313');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (87,'Інші рахунки в банку в іноземній валюті ','314');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (88,'Інші кошти ','33');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (89,'Грошові документи в національній валюті ','331');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (90,'Грошові документи в іноземній валюті ','332');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (91,'Грошові кошти в дорозі в національній валюті ','333');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (92,'Грошові кошти в дорозі в іноземній валюті ','334');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (93,'Короткострокові векселі одержані ','34');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (94,'Короткострокові векселі, одержані в національній валюті ','341');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (95,'Короткострокові векселі, одержані в іноземній валюті ','342');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (96,'Поточні фінансові інвестиції ','35');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (97,'Еквіваленти грошових коштів ','351');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (98,'Інші поточні фінансові інвестиції ','352');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (99,'Розрахунки з покупцями та замовниками ','36');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (100,'Розрахунки з вітчизняними покупцями ','361');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (101,'Розрахунки з іноземними покупцями ','362');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (102,'Розрахунки з учасниками ПФГ ','363');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (103,'Розрахунки з різними дебіторами ','37');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (104,'Розрахунки за виданими авансами ','371');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (105,'Розрахунки з підзвітними особами ','372');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (106,'Розрахунки за нарахованими доходами ','373');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (107,'Розрахунки за претензіями ','374');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (108,'Розрахунки за відшкодуванням завданих збитків ','375');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (109,'Розрахунки за позиками членам кредитних спілок ','376');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (110,'Розрахунки з іншими дебіторами ','377');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (111,'Резерв сумнівних боргів ','38');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (112,'Витрати майбутніх періодів ','39');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (113,'Статутний капітал ','40');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (114,'Пайовий капітал ','41');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (115,'Додатковий капітал ','42');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (116,'Емісійний дохід ','421');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (117,'Інший вкладений капітал ','422');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (118,'Дооцінка активів ','423');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (119,'Безоплатно одержані необоротні активи ','424');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (120,'Інший додатковий капітал ','425');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (121,'Резервний капітал ','43');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (122,'Нерозподілені прибутки (непокриті збитки) ','44');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (123,'Прибуток нерозподілений ','441');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (124,'Непокриті збитки ','442');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (125,'Прибуток, використаний у звітному періоді ','443');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (126,'Вилучений капітал ','45');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (127,'Вилучені акції ','451');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (128,'Вилучені вклади й паї ','452');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (129,'Інший вилучений капітал ','453');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (130,'Неоплачений капітал ','46');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (131,'Забезпечення майбутніх витрат і платежів ','47');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (132,'Забезпечення виплат відпусток ','471');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (133,'Додаткове пенсійне забезпечення ','472');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (134,'Забезпечення гарантійних зобов\'язань ','473');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (135,'Забезпечення інших витрат і платежів ','474');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (136,'Цільове фінансування і цільові надходження ','48');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (137,'Страхові резерви ','49');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (138,'Технічні резерви ','491');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (139,'Резерви із страхування життя ','492');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (140,'Частка перестраховиків у технічних резервах ','493');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (141,'Частка перестраховиків у резервах із страхування життя ','494');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (142,'Результат зміни технічних резервів ','495');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (143,'Результат зміни резервів із страхування життя ','496');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (144,'Результат зміни резервів незароблених премій ','497');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (145,'Результат зміни резервів збитків ','498');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (146,'Довгострокові позики ','50');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (147,'Довгострокові кредити банків у національній валюті ','501');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (148,'Довгострокові кредити банків в іноземній валюті ','502');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (149,'Відстрочені довгострокові кредити банків у національній валюті ','503');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (150,'Відстрочені довгострокові кредити банків в іноземній валюті ','504');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (151,'Інші довгострокові позики в національній валюті ','505');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (152,'Інші довгострокові позики в іноземній валюті ','506');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (153,'Довгострокові векселі видані ','51');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (154,'Довгострокові векселі, видані в національній валюті ','511');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (155,'Довгострокові векселі, видані в іноземній валюті ','512');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (156,'Довгострокові зобов\'язання за облігаціями ','52');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (157,'Зобов\'язання за облігаціями ','521');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (158,'Премія за випущеними облігаціями ','522');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (159,'Дисконт за випущеними облігаціями ','523');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (160,'Довгострокові зобов\'язання з оренди ','53');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (161,'Зобов\'язання з фінансової оренди ','531');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (162,'Зобов\'язання з оренди цілісних майнових комплексів ','532');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (163,'Відстрочені податкові зобов\'язання ','54');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (164,'Інші довгострокові зобов\'язання ','55');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (165,'Короткострокові позики ','60');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (166,'Короткострокові кредити банків у національній валюті ','601');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (167,'Короткострокові кредити банків в іноземній валюті ','602');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (168,'Відстрочені короткострокові кредити банків у національній валюті ','603');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (169,'Відстрочені короткострокові кредити банків в іноземній валюті ','604');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (170,'Прострочені позики в національній валюті ','605');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (171,'Прострочені позики в іноземній валюті ','606');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (172,'Поточна заборгованість за довгостроковими зобов\'язаннями ','61');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (173,'Поточна заборгованість за довгостроковими зобов\'язаннями в національній валюті ','611');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (174,'Поточна заборгованість за довгостроковими зобов\'язаннями в іноземній валюті ','612');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (175,'Короткострокові векселі видані ','62');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (176,'Короткострокові векселі, видані в національній валюті ','621');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (177,'Короткострокові векселі, видані в іноземній валюті ','622');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (178,'Розрахунки з постачальниками та підрядниками','63');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (179,'Розрахунки з вітчизняними постачальниками ','631');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (180,'Розрахунки з іноземними постачальниками ','632');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (181,'Розрахунки з учасниками ПФГ ','633');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (182,'Розрахунки за податками й платежами ','64');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (183,'Розрахунки за податками ','641');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (184,'Розрахунки за обов\'язковими платежами ','642');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (185,'Податкові зобов\'язання ','643');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (186,'Податковий кредит ','644');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (187,'Розрахунки за страхування ','65');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (188,'За пенсійним забезпеченням ','651');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (189,'За соціальним страхуванням ','652');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (190,'За страхуванням на випадок безробіття ','653');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (191,'За індивідуальним страхуванням ','654');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (192,'За страхуванням майна ','655');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (193,'Розрахунки з оплати праці ','66');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (194,'Розрахунки за заробітною платою ','661');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (195,'Розрахунки з депонентами ','662');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (196,'Розрахунки з учасниками ','67');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (197,'Розрахунки за нарахованими дивідендами ','671');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (198,'Розрахунки за іншими виплатами ','672');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (199,'Розрахунки за іншими операціями ','68');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (200,'Розрахунки за авансами одержаними ','681');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (201,'Внутрішні розрахунки ','682');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (202,'Внутрішньогосподарські розрахунки ','683');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (203,'Розрахунки за нарахованими відсотками ','684');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (204,'Розрахунки з іншими кредиторами ','685');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (205,'Доходи майбутніх періодів ','69');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (206,'Доходи від реалізації ','70');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (207,'Дохід від реалізації готової продукції ','701');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (208,'Дохід від реалізації товарів ','702');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (209,'Дохід від реалізації робіт і послуг ','703');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (210,'Вирахування з доходу ','704');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (211,'Перестрахування ','705');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (212,'Інший операційний дохід ','71');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (213,'Дохід від реалізації іноземної валюти ','711');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (214,'Дохід від реалізації інших оборотних активів ','712');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (215,'Дохід від операційної оренди активів ','713');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (216,'Дохід від операційної курсової різниці ','714');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (217,'Одержані штрафи, пені, неустойки ','715');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (218,'Відшкодування раніше списаних активів ','716');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (219,'Дохід від списання кредиторської заборгованості ','717');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (220,'Дохід від безоплатно одержаних оборотних активів ','718');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (221,'Інші доходи від операційної діяльності ','719');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (222,'Дохід від участі в капіталі ','72');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (223,'Дохід від інвестицій в асоційовані підприємства ','721');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (224,'Дохід від спільної діяльності ','722');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (225,'Дохід від інвестицій в дочірні підприємства ','723');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (226,'Інші фінансові доходи ','73');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (227,'Дивіденди одержані ','731');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (228,'Відсотки одержані ','732');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (229,'Інші доходи від фінансових операцій ','733');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (230,'Інші доходи ','74');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (231,'Дохід від реалізації фінансових інвестицій ','741');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (232,'Дохід від реалізації необоротних активів ','742');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (233,'Дохід від реалізації майнових комплексів ','743');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (234,'Дохід від неопераційної курсової різниці ','744');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (235,'Дохід від безоплатно одержаних активів ','745');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (236,'Інші доходи від звичайної діяльності ','746');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (237,'Надзвичайні доходи ','75');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (238,'Відшкодування збитків від надзвичайних подій ','751');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (239,'Інші надзвичайні доходи ','752');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (240,'Страхові платежі ','76');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (241,'Фінансові результати ','79');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (242,'Результат операційної діяльності ','791');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (243,'Результат фінансових операцій ','792');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (244,'Результат іншої звичайної діяльності ','793');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (245,'Результат надзвичайних подій ','794');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (246,'Матеріальні витрати ','80');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (247,'Витрати сировини й матеріалів ','801');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (248,'Витрати купівельних напівфабрикатів та комплектуючих виробів ','802');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (249,'Витрати палива й енергії ','803');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (250,'Витрати тари й тарних матеріалів ','804');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (251,'Витрати будівельних матеріалів ','805');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (252,'Витрати запасних частин ','806');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (253,'Витрати матеріалів сільськогосподарського призначення ','807');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (254,'Витрати товарів ','808');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (255,'Інші матеріальні витрати ','809');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (256,'Витрати на оплату праці ','81');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (257,'Виплати за окладами й тарифами ','811');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (258,'Премії та заохочення ','812');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (259,'Компенсаційні виплати ','813');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (260,'Оплата відпусток ','814');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (261,'Оплата іншого невідпрацьованого часу ','815');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (262,'Інші витрати на оплату праці ','816');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (263,'Відрахування на соціальні заходи ','82');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (264,'Відрахування на пенсійне забезпечення ','821');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (265,'Відрахування на соціальне страхування ','822');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (266,'Страхування на випадок безробіття ','823');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (267,'Відрахування на індивідуальне страхування ','824');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (268,'Амортизація ','83');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (269,'Амортизація основних засобів ','831');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (270,'Амортизація інших необоротних матеріальних активів ','832');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (271,'Амортизація нематеріальних активів ','833');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (272,'Інші операційні витрати ','84');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (273,'Інші затрати ','85');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (274,'Собівартість реалізації ','90');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (275,'Собівартість реалізованої готової продукції ','901');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (276,'Собівартість реалізованих товарів ','902');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (277,'Собівартість реалізованих робіт і послуг ','903');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (278,'Страхові виплати ','904');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (279,'Загальновиробничі витрати ','91');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (280,'Адміністративні витрати ','92');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (281,'Витрати на збут ','93');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (282,'Інші витрати операційної діяльності ','94');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (283,'Витрати на дослідження і розробки ','941');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (284,'Собівартість реалізованої іноземної валюти ','942');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (285,'Собівартість реалізованих виробничих запасів ','943');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (286,'Сумнівні та безнадійні борги ','944');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (287,'Втрати від операційної курсової різниці ','945');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (288,'Втрати від знецінення запасів ','946');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (289,'Нестачі і втрати від псування цінностей ','947');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (290,'Визнані штрафи, пені, неустойки ','948');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (291,'Інші витрати операційної діяльності ','949');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (292,'Фінансові витрати ','95');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (293,'Відсотки за кредит ','951');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (294,'Інші фінансові витрати ','952');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (295,'Втрати від участі в капіталі ','96');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (296,'Втрати від інвестицій в асоційовані підприємства ','961');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (297,'Втрати від спільної діяльності ','962');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (298,'Втрати від інвестицій в дочірні підприємства ','963');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (299,'Інші витрати ','97');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (300,'Собівартість реалізованих фінансових інвестицій ','971');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (301,'Собівартість реалізованих необоротних активів ','972');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (302,'Собівартість реалізованих майнових комплексів ','973');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (303,'Втрати від неопераційних курсових різниць ','974');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (304,'Уцінка необоротних активів і фінансових інвестицій ','975');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (305,'Списання необоротних активів ','976');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (306,'Інші витрати звичайної діяльності ','977');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (307,'Податок на прибуток ','98');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (308,'Податок на прибуток від звичайної діяльності ','981');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (309,'Податок на прибуток від надзвичайних подій ','982');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (310,'Надзвичайні витрати ','99');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (311,'Втрати від стихійного лиха ','991');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (312,'Втрати від техногенних катастроф і аварій ','992');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (313,'Інші надзвичайні витрати ','993');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (314,'Орендовані необоротні активи ','1');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (315,'Активи на відповідальному зберіганні ','2');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (316,'Устаткування, прийняте для монтажу ','21');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (317,'Матеріали, прийняті для переробки ','22');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (318,'Матеріальні цінності на відповідальному зберіганні ','23');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (319,'Товари, прийняті на комісію ','24');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (320,'Майно в довірчому управлінні ','25');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (321,'Контрактні зобов\'язання ','3');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (322,'Непередбачені активи й зобов\'язання ','4');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (323,'Непередбачені активи ','41');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (324,'Непередбачені зобов\'язання ','42');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (325,'Гарантії та забезпечення надані ','5');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (326,'Гарантії та забезпечення отримані ','6');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (327,'Списані активи ','7');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (328,'Списана дебіторська заборгованість ','71');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (329,'Невідшкодовані нестачі і втрати від псування цінностей ','72');
INSERT INTO `reference_book` (`id`, `name`, `code`) VALUES (330,'Бланки суворого обліку ','8');
/*!40000 ALTER TABLE `reference_book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_actions`
--

DROP TABLE IF EXISTS `report_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datetime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_actions`
--

LOCK TABLES `report_actions` WRITE;
/*!40000 ALTER TABLE `report_actions` DISABLE KEYS */;
/*!40000 ALTER TABLE `report_actions` ENABLE KEYS */;
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
  `is_approved` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_reports_projects1_idx` (`project_id`),
  KEY `fk_reports_users1_idx` (`user_id`),
  KEY `fk_reports_invoices1_idx` (`invoice_id`),
  CONSTRAINT `fk_reports_invoices1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_reports_projects1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_reports_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
INSERT INTO `reports` (`id`, `project_id`, `user_id`, `invoice_id`, `reporter_name`, `hours`, `task`, `date_added`, `date_paid`, `date_report`, `status`, `is_working_day`, `is_delete`, `cost`, `is_approved`) VALUES (1,1,1,NULL,'John Doe',8,'Super Task 132434324353','2018-08-02',NULL,'2018-08-02','NEW',NULL,0,170.00,1);
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
-- Table structure for table `salary_report_lists`
--

DROP TABLE IF EXISTS `salary_report_lists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salary_report_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `salary_report_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `salary` int(11) DEFAULT NULL,
  `worked_days` int(11) DEFAULT NULL,
  `actually_worked_out_salary` double DEFAULT NULL,
  `official_salary` double DEFAULT NULL,
  `hospital_days` int(11) DEFAULT NULL,
  `hospital_value` double DEFAULT NULL,
  `bonuses` double DEFAULT NULL,
  `day_off` int(11) DEFAULT NULL,
  `overtime_days` int(11) DEFAULT NULL,
  `overtime_value` double DEFAULT NULL,
  `other_surcharges` double DEFAULT NULL,
  `subtotal` double DEFAULT NULL,
  `currency_rate` double DEFAULT NULL,
  `subtotal_uah` double DEFAULT NULL,
  `total_to_pay` double DEFAULT NULL,
  `vacation_days` int(11) DEFAULT NULL,
  `vacation_value` double DEFAULT NULL,
  `non_approved_hours` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx-salary_report_lists-user_id` (`user_id`),
  KEY `idx-salary_report_lists-salary_report_id` (`salary_report_id`),
  CONSTRAINT `fk-salary_report_lists-salary_report_id` FOREIGN KEY (`salary_report_id`) REFERENCES `salary_reports` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-salary_report_lists-user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salary_report_lists`
--

LOCK TABLES `salary_report_lists` WRITE;
/*!40000 ALTER TABLE `salary_report_lists` DISABLE KEYS */;
/*!40000 ALTER TABLE `salary_report_lists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salary_reports`
--

DROP TABLE IF EXISTS `salary_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salary_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_date` int(11) DEFAULT NULL,
  `total_salary` double DEFAULT NULL,
  `official_salary` double DEFAULT NULL,
  `bonuses` double DEFAULT NULL,
  `hospital` double DEFAULT NULL,
  `day_off` double DEFAULT NULL,
  `overtime` double DEFAULT NULL,
  `other_surcharges` double DEFAULT NULL,
  `subtotal` double DEFAULT NULL,
  `currency_rate` double DEFAULT NULL,
  `total_to_pay` double DEFAULT NULL,
  `number_of_working_days` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salary_reports`
--

LOCK TABLES `salary_reports` WRITE;
/*!40000 ALTER TABLE `salary_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `salary_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('INT','STRING') COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` (`id`, `key`, `value`, `type`) VALUES (1,'corp_events_percentage','15','INT');
INSERT INTO `settings` (`id`, `key`, `value`, `type`) VALUES (2,'bonuses_percentage','10','INT');
INSERT INTO `settings` (`id`, `key`, `value`, `type`) VALUES (3,'LABOR_EXPENSES_RATIO','20','INT');
INSERT INTO `settings` (`id`, `key`, `value`, `type`) VALUES (4,'SSO_COOKIE_COMAIN_NAME','crowd.token_key','STRING');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('DEBIT','CREDIT') COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `currency` enum('USD','UAH') COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference_book_id` int(11) NOT NULL,
  `counterparty_id` int(11) DEFAULT NULL,
  `operation_id` int(11) NOT NULL,
  `operation_business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`operation_id`,`operation_business_id`),
  KEY `fk_transactions_reference_book_idx` (`reference_book_id`),
  KEY `fk_transactions_counterparties1_idx` (`counterparty_id`),
  KEY `fk_transactions_operations1_idx` (`operation_id`,`operation_business_id`),
  CONSTRAINT `fk_transactions_counterparties1` FOREIGN KEY (`counterparty_id`) REFERENCES `counterparties` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_transactions_operations1` FOREIGN KEY (`operation_id`, `operation_business_id`) REFERENCES `operations` (`id`, `business_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_transactions_reference_book` FOREIGN KEY (`reference_book_id`) REFERENCES `reference_book` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` enum('ADMIN','PM','DEV','CLIENT','FIN','SALES','GUEST') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'DEV',
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
  `official_salary` double DEFAULT NULL,
  `month_logged_hours` int(11) DEFAULT '0',
  `year_logged_hours` int(11) DEFAULT '0',
  `total_logged_hours` int(11) DEFAULT '0',
  `month_paid_hours` int(11) DEFAULT '0',
  `year_paid_hours` int(11) DEFAULT '0',
  `total_paid_hours` int(11) DEFAULT '0',
  `invite_hash` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT '0',
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sing` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `public_profile_key` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_account_en` text COLLATE utf8_unicode_ci,
  `bank_account_ua` text COLLATE utf8_unicode_ci,
  `password_reset_token` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `languages` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday` timestamp NULL DEFAULT NULL,
  `experience_year` int(11) DEFAULT '0',
  `degree` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'No Degree',
  `residence` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link_linkedin` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link_video` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT '0',
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_type` int(11) DEFAULT '1',
  `is_available` tinyint(1) DEFAULT NULL,
  `address` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pay_only_approved_hours` int(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`),
  KEY `fk_users_auth_type` (`auth_type`),
  CONSTRAINT `fk_users_auth_type` FOREIGN KEY (`auth_type`) REFERENCES `auth_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `role`, `phone`, `email`, `password`, `first_name`, `last_name`, `middle_name`, `company`, `tags`, `about`, `date_signup`, `date_login`, `date_salary_up`, `is_active`, `salary`, `official_salary`, `month_logged_hours`, `year_logged_hours`, `total_logged_hours`, `month_paid_hours`, `year_paid_hours`, `total_paid_hours`, `invite_hash`, `is_delete`, `photo`, `sing`, `public_profile_key`, `bank_account_en`, `bank_account_ua`, `password_reset_token`, `languages`, `position`, `birthday`, `experience_year`, `degree`, `residence`, `link_linkedin`, `link_video`, `is_published`, `slug`, `auth_type`, `is_available`, `address`, `pay_only_approved_hours`) VALUES (1,'ADMIN','+380 (066) 304-32-01','crm-admin@skynix.co','2de2b770e4c198bb413550d031d0ca52','John','Doe',NULL,'Skynix Ltd','PHP, JAVA, DevOps, System Architect, System Administrator ',NULL,'2017-03-07 00:00:00','2018-08-21 16:31:24',NULL,1,3000,15000,168,2016,8670,168,2015,8340,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'CEO','1981-01-03 00:00:00',0,'Mater',NULL,NULL,NULL,0,'crm-admin',2,NULL,NULL,0);
INSERT INTO `users` (`id`, `role`, `phone`, `email`, `password`, `first_name`, `last_name`, `middle_name`, `company`, `tags`, `about`, `date_signup`, `date_login`, `date_salary_up`, `is_active`, `salary`, `official_salary`, `month_logged_hours`, `year_logged_hours`, `total_logged_hours`, `month_paid_hours`, `year_paid_hours`, `total_paid_hours`, `invite_hash`, `is_delete`, `photo`, `sing`, `public_profile_key`, `bank_account_en`, `bank_account_ua`, `password_reset_token`, `languages`, `position`, `birthday`, `experience_year`, `degree`, `residence`, `link_linkedin`, `link_video`, `is_published`, `slug`, `auth_type`, `is_available`, `address`, `pay_only_approved_hours`) VALUES (2,'FIN','+38 (044) 434-55-64','crm-fin@skynix.co','8384386dd789da8c222fa9d3b1b3e435','Vess','Jonson',NULL,'Skynix Ltd',NULL,NULL,NULL,NULL,NULL,1,1000,8000,130,1200,4500,130,1200,4300,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'No Degree',NULL,NULL,NULL,0,NULL,2,NULL,NULL,0);
INSERT INTO `users` (`id`, `role`, `phone`, `email`, `password`, `first_name`, `last_name`, `middle_name`, `company`, `tags`, `about`, `date_signup`, `date_login`, `date_salary_up`, `is_active`, `salary`, `official_salary`, `month_logged_hours`, `year_logged_hours`, `total_logged_hours`, `month_paid_hours`, `year_paid_hours`, `total_paid_hours`, `invite_hash`, `is_delete`, `photo`, `sing`, `public_profile_key`, `bank_account_en`, `bank_account_ua`, `password_reset_token`, `languages`, `position`, `birthday`, `experience_year`, `degree`, `residence`, `link_linkedin`, `link_video`, `is_published`, `slug`, `auth_type`, `is_available`, `address`, `pay_only_approved_hours`) VALUES (3,'DEV','+380 (050) 403-33-01','crm-dev@skynix.co','9ef7f207f0853694610afdad81ebe5ec','Wess','Wilson',NULL,'Skynix Ltd',NULL,NULL,NULL,NULL,NULL,1,1800,25000,0,0,0,0,0,0,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'No Degree',NULL,NULL,NULL,0,NULL,2,NULL,NULL,0);
INSERT INTO `users` (`id`, `role`, `phone`, `email`, `password`, `first_name`, `last_name`, `middle_name`, `company`, `tags`, `about`, `date_signup`, `date_login`, `date_salary_up`, `is_active`, `salary`, `official_salary`, `month_logged_hours`, `year_logged_hours`, `total_logged_hours`, `month_paid_hours`, `year_paid_hours`, `total_paid_hours`, `invite_hash`, `is_delete`, `photo`, `sing`, `public_profile_key`, `bank_account_en`, `bank_account_ua`, `password_reset_token`, `languages`, `position`, `birthday`, `experience_year`, `degree`, `residence`, `link_linkedin`, `link_video`, `is_published`, `slug`, `auth_type`, `is_available`, `address`, `pay_only_approved_hours`) VALUES (4,'CLIENT','+380 (043) 323-33-44','crm-client@skynix.co','3c2997aaf9841e37d96e639ca17a6f94','Eli','Ho',NULL,'Skynix Ltd',NULL,NULL,NULL,NULL,NULL,1,800,6000,0,0,0,0,0,0,NULL,0,NULL,NULL,NULL,'<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"282\" style=\"border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;\">\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Beneficiary:  </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Colourways Limited</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Account # :</td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">5096104</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"><span>Beneficiary\'s bank: </span>Barclays Bank,Barclays, 745 7th Avenue,New York, NY 10019, United States</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"></td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Sort cod: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">20-20-37</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">SWIFT code: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">BARCGB2</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">IBAN code: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">GB98BARC2020375096104</td>\r\n                </tr>\r\n            </table >','<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"282\" style=\"border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;\">\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Beneficiary: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Colourways Limited</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Account # :</td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">50961043</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"><span>Beneficiary\'s bank: </span>Barclays Bank,Barclays, 745 7th Avenue,New York, NY 10019, United States</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"></td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Sort cod: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">20-20-37</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">SWIFT code: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">BARCGB2</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">IBAN code: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">GB98BARC2020375096104</td>\r\n                </tr>\r\n\r\n\r\n            </table >',NULL,NULL,NULL,NULL,0,'No Degree',NULL,NULL,NULL,0,NULL,2,NULL,NULL,0);
INSERT INTO `users` (`id`, `role`, `phone`, `email`, `password`, `first_name`, `last_name`, `middle_name`, `company`, `tags`, `about`, `date_signup`, `date_login`, `date_salary_up`, `is_active`, `salary`, `official_salary`, `month_logged_hours`, `year_logged_hours`, `total_logged_hours`, `month_paid_hours`, `year_paid_hours`, `total_paid_hours`, `invite_hash`, `is_delete`, `photo`, `sing`, `public_profile_key`, `bank_account_en`, `bank_account_ua`, `password_reset_token`, `languages`, `position`, `birthday`, `experience_year`, `degree`, `residence`, `link_linkedin`, `link_video`, `is_published`, `slug`, `auth_type`, `is_available`, `address`, `pay_only_approved_hours`) VALUES (5,'SALES','+38 (066) 434-44-33','crm-sales@skynix.co','a22744b22823e056902271e60a41d530','Terry','Brown',NULL,'Skynix Ltd',NULL,NULL,NULL,NULL,NULL,1,3500,35000,0,0,0,0,0,0,NULL,0,NULL,'Sign-clean-128.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'No Degree',NULL,NULL,NULL,0,NULL,2,NULL,NULL,0);
INSERT INTO `users` (`id`, `role`, `phone`, `email`, `password`, `first_name`, `last_name`, `middle_name`, `company`, `tags`, `about`, `date_signup`, `date_login`, `date_salary_up`, `is_active`, `salary`, `official_salary`, `month_logged_hours`, `year_logged_hours`, `total_logged_hours`, `month_paid_hours`, `year_paid_hours`, `total_paid_hours`, `invite_hash`, `is_delete`, `photo`, `sing`, `public_profile_key`, `bank_account_en`, `bank_account_ua`, `password_reset_token`, `languages`, `position`, `birthday`, `experience_year`, `degree`, `residence`, `link_linkedin`, `link_video`, `is_published`, `slug`, `auth_type`, `is_available`, `address`, `pay_only_approved_hours`) VALUES (6,'PM','+38 (322) 232-33-21','crm-pm@skynix.co','6e3369cd7e96ca11e7d7a78fccaa661f','Gary','Madison',NULL,'Skynix Ltd',NULL,NULL,NULL,NULL,NULL,1,1900,3200,0,0,0,0,0,0,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'No Degree',NULL,NULL,NULL,0,NULL,2,NULL,NULL,0);
INSERT INTO `users` (`id`, `role`, `phone`, `email`, `password`, `first_name`, `last_name`, `middle_name`, `company`, `tags`, `about`, `date_signup`, `date_login`, `date_salary_up`, `is_active`, `salary`, `official_salary`, `month_logged_hours`, `year_logged_hours`, `total_logged_hours`, `month_paid_hours`, `year_paid_hours`, `total_paid_hours`, `invite_hash`, `is_delete`, `photo`, `sing`, `public_profile_key`, `bank_account_en`, `bank_account_ua`, `password_reset_token`, `languages`, `position`, `birthday`, `experience_year`, `degree`, `residence`, `link_linkedin`, `link_video`, `is_published`, `slug`, `auth_type`, `is_available`, `address`, `pay_only_approved_hours`) VALUES (7,'GUEST',NULL,'apps@skynix.co','','SKYNIX','SYSTEM',NULL,'Skynix LLC',NULL,NULL,NULL,NULL,NULL,0,0,NULL,0,0,0,0,0,0,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'No Degree',NULL,NULL,NULL,0,NULL,2,NULL,NULL,0);
INSERT INTO `users` (`id`, `role`, `phone`, `email`, `password`, `first_name`, `last_name`, `middle_name`, `company`, `tags`, `about`, `date_signup`, `date_login`, `date_salary_up`, `is_active`, `salary`, `official_salary`, `month_logged_hours`, `year_logged_hours`, `total_logged_hours`, `month_paid_hours`, `year_paid_hours`, `total_paid_hours`, `invite_hash`, `is_delete`, `photo`, `sing`, `public_profile_key`, `bank_account_en`, `bank_account_ua`, `password_reset_token`, `languages`, `position`, `birthday`, `experience_year`, `degree`, `residence`, `link_linkedin`, `link_video`, `is_published`, `slug`, `auth_type`, `is_available`, `address`, `pay_only_approved_hours`) VALUES (8,'DEV',NULL,'admin@skynix.co','8d81c0359d8662bd79fb0c0869330abb','admin','admin',NULL,NULL,NULL,NULL,'2018-08-02 17:05:08','2018-08-02 17:13:56',NULL,1,0,NULL,0,0,0,0,0,0,'b82133d713fed9ecce46644cf8e5cc52',0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'No Degree',NULL,NULL,NULL,0,NULL,1,NULL,NULL,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `work_history`
--

DROP TABLE IF EXISTS `work_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `work_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `added_by_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_work_history_users` (`user_id`),
  KEY `fk_work_history_postedby_users` (`added_by_user_id`),
  CONSTRAINT `fk_work_history_postedby_users` FOREIGN KEY (`added_by_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_work_history_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `work_history`
--

LOCK TABLES `work_history` WRITE;
/*!40000 ALTER TABLE `work_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `work_history` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-08-23 12:09:23
