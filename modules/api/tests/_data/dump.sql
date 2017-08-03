-- MySQL dump 10.13  Distrib 5.7.17, for Linux (x86_64)
--
-- Host: localhost    Database: database_name
-- ------------------------------------------------------
-- Server version	5.7.17

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
  `access_token` varchar(40) NOT NULL,
  `exp_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

----
-- Dumping data for table `api_auth_access_tokens`
--

-- LOCK TABLES `api_auth_access_tokens` WRITE;
-- /*!40000 ALTER TABLE `api_auth_access_tokens` DISABLE KEYS */;
-- INSERT INTO `api_auth_access_tokens` (`id`, `user_id`, `access_token`, `exp_date`)
-- VALUES (1,1,'Qo_uuBxPQC_Dpcn20Vh1wLm5prAO_y7MFMch9Vc','2016-11-05 02:19:44');
-- /*!40000 ALTER TABLE `api_auth_access_tokens` ENABLE KEYS */;
-- UNLOCK TABLES;

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

----
-- Dumping data for table `api_auth_access_tokens`
--

LOCK TABLES `careers` WRITE;
/*!40000 ALTER TABLE `careers` DISABLE KEYS */;
INSERT INTO `careers` (`id`, `title`, `description`, `is_active`)
VALUES (1,'careers test','career description, career description, career description',1);
/*!40000 ALTER TABLE `careers` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=518 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contract_templates`
--

DROP TABLE IF EXISTS `contract_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contract_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contract_templates`
--

LOCK TABLES `contract_templates` WRITE;
/*!40000 ALTER TABLE `contract_templates` DISABLE KEYS */;
INSERT INTO `contract_templates` (`id`, `name`, `content`)
VALUES (1,'Default template','\n<!doctype html>\n<html lang=\"en\">\n<head>\n    <meta charset=\"utf-8\">\n    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n</head>\n<body>\n<table width=\"570\" style=\" margin-left: auto; margin-right: auto; border-collapse: collapse;\">\n    <tr style = \"height: 100%; box-sizing: border-box; border-collapse: collapse; \">\n        <td style =\" vertical-align: top; border: 1px solid black; border-bottom:none; height: 100%; box-sizing: border-box; border-collapse: collapse; padding: 5px 4px 5px 4px;\">\n            <table width=\"285\" style=\"margin:0;border-collapse: collapse;border: 0;\">\n                <tr>\n                    <td align=\"center\" style=\"margin: 0; font-family:\'Times New Roman\';font-size:10px;\"><strong>╨Ъ╨Ю╨Э╨в╨а╨Р╨Ъ╨в тДЦvar_contract_id</strong></strong></td>\n                </tr>\n                <tr>\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>╨Э╨Р ╨Э╨Р╨Ф╨Р╨Э╨Э╨п ╨Я╨Ю╨б╨Ы╨г╨У</strong></td>\n                </tr>\n                <tr>\n                    <td align=\"right\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">var_start_date</td>\n                </tr>\n                <tr>\n                    <td align=\"right\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><span style=\"color: #ffffff;\">.</span></td>\n                </tr>\n                <tr>\n                    <td align=\"justify\" style=\"margin: 0;\">\n                        <p style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">\n                            <span style=\"color: #ffffff;\">.....</span>╨Ъ╨╛╨╝╨┐╨░╨╜╤Ц╤П \"var_company_name\" ╨┤╨░╨╗╤Ц\n                            ╨┐╨╛ ╤В╨╡╨║╤Б╤В╤Г \"╨Ч╨░╨╝╨╛╨▓╨╜╨╕╨║\" ╤Ц ╨Ъ╨╛╨╝╨┐╨░╨╜╤Ц╤П ╨д╨Ю╨Я ╨Я╤А╨╛╨╢╨╛╨│╨░ ╨Ю.╨о.,\n                            ╨г╨║╤А╨░╤Ч╨╜╨░,╨▓ ╨╛╤Б╨╛╨▒╤Ц ╨Я╤А╨╛╨╢╨╛╨│╨╕ ╨Ю╨╗╨╡╨║╤Б╤Ц╤П ╨о╤А╤Ц╨╣╨╛╨▓╨╕╤З╨░,\n                            ╨┤╤Ц╤О╤З╨╛╨│╨╛ ╨╜╨░ ╨┐╤Ц╨┤╤Б╤В╨░╨▓╤Ц ╤А╨╡╤Ф╤Б╤В╤А╨░╤Ж╤Ц╤Ч\n                            тДЦ22570000000001891 ╨▓╤Ц╨┤ 01.05.2001╤А. ╨┤╨░╨╗╤Ц ╨┐╨╛\n                            ╤В╨╡╨║╤Б╤В╤Г \"╨Т╨╕╨║╨╛╨╜╨░╨▓╨╡╤Ж╤М\", ╨┤╨░╨╗╤Ц ╨┐╨╛ ╤В╨╡╨║╤Б╤В╤Г ╨б╤В╨╛╤А╨╛╨╜╨╕,\n                            ╤Г╨║╨╗╨░╨╗╨╕ ╤Ж╨╡╨╣ ╨Ъ╨╛╨╜╤В╤А╨░╨║╤В ╨┐╤А╨╛ ╨╜╨░╤Б╤В╤Г╨┐╨╜╨╡:<br><span style=\"color: #ffffff;\">.</span><br>\n                        </p>\n                    </td>\n                </tr>\n                <tr>\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>1. ╨Я╤А╨╡╨┤╨╝╨╡╤В ╨Ъ╨╛╨╜╤В╤А╨░╨║╤В╤Г</strong></td>\n                </tr>\n                <tr>\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"> 1.1.╨Т╨╕╨║╨╛╨╜╨░╨▓╨╡╤Ж╤М ╨╖╨╛╨▒╨╛╨▓\'╤П╨╖╤Г╤Ф╤В╤М╤Б╤П ╨╖╨░ ╨╖╨░╨▓╨┤╨░╨╜╨╜╤П╨╝\n                        ╨Ч╨░╨╝╨╛╨▓╨╜╨╕╨║╨░ ╨╜╨░╨┤╨░╤В╨╕ ╨╜╨░╤Б╤В╤Г╨┐╨╜╤Ц ╨┐╨╛╤Б╨╗╤Г╨│╨╕:\n                        ╨а╨╛╨╖╤А╨╛╨▒╨║╨░ ╨┐╤А╨╛╨│╤А╨░╨╝╨╜╨╛╨│╨╛ ╨╖╨░╨▒╨╡╨╖╨┐╨╡╤З╨╡╨╜╨╜╤П(╨▓╨╡╨▒\n                        ╤Б╨░╨╣╤В╤Г)\n                    </td>\n                </tr>\n                <tr>\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>2. ╨ж╤Ц╨╜╨░ ╤Ц ╨╖╨░╨│╨░╨╗╤М╨╜╨░ ╤Б╤Г╨╝╨░ ╨Ъ╨╛╨╜╤В╤А╨░╨║╤В╤Г</strong></td>\n                </tr>\n                <tr>\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">2.1. ╨Т╨░╤А╤В╤Ц╤Б╤В╤М ╨┐╨╛╤Б╨╗╤Г╨│╨╕ ╨▓╤Б╤В╨░╨╜╨╛╨▓╨╗╤О╤Ф╤В╤М╤Б╤П ╨▓ <strong>$var_total</strong></td>\n                </tr>\n                <tr>\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">2.2.  ╨Ч╨░╨│╨░╨╗╤М╨╜╨░ ╤Б╤Г╨╝╨░ ╨Ъ╨╛╨╜╤В╤А╨░╨║╤В╤Г ╤Б╤В╨░╨╜╨╛╨▓╨╕╤В╤М <strong>$var_total</strong></td>\n                </tr>\n                <tr>\n                    <td align=\"left\" style=\"margin: 0;letter-spacing:0px;font-family:\'Times New Roman\';font-size:10px;\">\n                        2.3.╨г ╤А╨░╨╖╤Ц ╨╖╨╝╤Ц╨╜╨╕ ╤Б╤Г╨╝╨╕ ╨Ъ╨╛╨╜╤В╤А╨░╨║╤В╤Г ╨╖╨░ ╨╖╨│╨╛╨┤╨╛╤О\n                        ╤Б╤В╨╛╤А╤Ц╨╜, ╨б╤В╨╛╤А╨╛╨╜╨╕ ╨╖╨╛╨▒╨╛╨▓\'╤П╨╖╤Г╤О╤В╤М╤Б╤П ╨┐╤Ц╨┤╨┐╨╕╤Б╨░╤В╨╕ ╨┤╨╛╨┤╨░╤В╨║╨╛╨▓╤Г ╤Г╨│╨╛╨┤╤Г ╨┤╨╛ ╨┤╨░╨╜╨╛╨│╨╛ ╨Ъ╨╛╨╜╤В╤А╨░╨║╤В╤Г ╨┐╤А╨╛\n                        ╨╖╨▒╤Ц╨╗╤М╤И╨╡╨╜╨╜╤П ╨░╨▒╨╛ ╨╖╨╝╨╡╨╜╤И╨╡╨╜╨╜╤П ╨╖╨░╨│╨░╨╗╤М╨╜╨╛╤Ч ╤Б╤Г╨╝╨╕ ╨Ъ╨╛╨╜╤В╤А╨░╨║╤В╤Г.<br><span style=\"color: #ffffff;\">.</span></td>\n                </tr>\n                <tr>\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>3. ╨г╨╝╨╛╨▓╨╕ ╨┐╨╗╨░╤В╨╡╨╢╤Г</strong></td>\n                </tr>\n                <tr>\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">3.1.╨Ч╨░╨╝╨╛╨▓╨╜╨╕╨║ ╨╖╨┤╤Ц╨╣╤Б╨╜╤О╤Ф ╨╛╨┐╨╗╨░╤В╤Г ╨▒╨░╨╜╨║╤Ц╨▓╤Б╤М╨║╨╕╨╝\n                        ╨┐╨╡╤А╨╡╨║╨░╨╖╨╛╨╝ ╨╜╨░ ╤А╨░╤Е╤Г╨╜╨╛╨║ ╨Т╨╕╨║╨╛╨╜╨░╨▓╤Ж╤П ╨┐╤А╨╛╤В╤П╨│╨╛╨╝ 5\n                        ╨║╨░╨╗╨╡╨╜╨┤╨░╤А╨╜╨╕╤Е ╨┤╨╜╤Ц╨▓ ╨╖ ╨╝╨╛╨╝╨╡╨╜╤В╤Г ╨┐╤Ц╨┤╨┐╨╕╤Б╨░╨╜╨╜╤П ╨Р╨║╤В╤Г\n                        ╨┐╤А╨╕╨╣╨╛╨╝╤Г-╨┐╨╡╤А╨╡╨┤╨░╤З╤Ц ╨╜╨░╨┤╨░╨╜╨╕╤Е ╨┐╨╛╤Б╨╗╤Г╨│.</td>\n                </tr>\n                <tr>\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">\n                        3.2. ╨С╨░╨╜╨║╤Ц╨▓╤Б╤М╨║╤Ц ╨▓╨╕╤В╤А╨░╤В╨╕ ╨╛╨┐╨╗╨░╤З╤Г╤Ф ╨╖╨░╨╝╨╛╨▓╨╜╨╕╨║</td>\n                </tr>\n                <tr>\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">\n                        3.3. ╨Т╨░╨╗╤О╤В╨░ ╨┐╨╗╨░╤В╨╡╨╢╤Г тАУ USD.</td>\n                </tr>\n                <tr>\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>4. ╨г╨╝╨╛╨▓╨╕ ╨╜╨░╨┤╨░╨╜╨╜╤П ╨┐╨╛╤Б╨╗╤Г╨│</strong></td>\n                </tr>\n                <tr>\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">4.1.╨Т╨╕╨║╨╛╨╜╨░╨▓╨╡╤Ж╤М ╨╜╨░╨┤╨░╤Ф ╨┐╨╛╤Б╨╗╤Г╨│╨╕ ╨╜╨░ ╤Г╨╝╨╛╨▓╨░╤Е\n                        ╤Ж╤М╨╛╨│╨╛ ╨Ъ╨╛╨╜╤В╤А╨░╨║╤В╤Г ╤Ц ╨Ф╨╛╨┤╨░╤В╨║╤Ц╨▓ ╨┤╨╛ ╨╜╤М╨╛╨│╨╛.</td>\n                </tr>\n                <tr>\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>5. ╨Т╤Ц╨┤╨┐╨╛╨▓╤Ц╨┤╨░╨╗╤М╨╜╤Ц╤Б╤В╤М ╤Б╤В╨╛╤А╤Ц╨╜</strong></td>\n                </tr>\n                <tr>\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">5.1.╨б╤В╨╛╤А╨╛╨╜╨╕ ╨╖╨╛╨▒╨╛╨▓\'╤П╨╖╤Г╤О╤В╤М╤Б╤П ╨╜╨╡╤Б╤В╨╕\n                        ╨▓╤Ц╨┤╨┐╨╛╨▓╤Ц╨┤╨░╨╗╤М╨╜╤Ц╤Б╤В╤М ╨╖╨░ ╨╜╨╡╨▓╨╕╨║╨╛╨╜╨░╨╜╨╜╤П ╨░╨▒╨╛\n                        ╨╜╨╡╨╜╨░╨╗╨╡╨╢╨╜╨╡ ╨▓╨╕╨║╨╛╨╜╨░╨╜╨╜╤П ╨╖╨╛╨▒╨╛╨▓\'╤П╨╖╨░╨╜╤М ╨╖╨░ ╤Ж╨╕╨╝\n                        ╨Ъ╨╛╨╜╤В╤А╨░╨║╤В╨╛╨╝.</td>\n                </tr>\n                <tr>\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>6. ╨Я╤А╨╡╤В╨╡╨╜╨╖╤Ц╤Ч</strong></td>\n                </tr>\n                <tr>\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">6.1 ╨Я╤А╨╡╤В╨╡╨╜╨╖╤Ц╤Ч ╤Й╨╛╨┤╨╛ ╤П╨║╨╛╤Б╤В╤Ц ╨╜╨░╨┤╨░╨╜╨╕╤Е ╨╖╨░ ╨┤╨░╨╜╨╕╨╝\n                        ╨Ъ╨╛╨╜╤В╤А╨░╨║╤В╨╛╨╝ ╨┐╨╛╤Б╨╗╤Г╨│ ╨╝╨╛╨╢╤Г╤В╤М ╨▒╤Г╤В╨╕ ╨┐╤А╨╡╨┤\'╤П╨▓╨╗╨╡╨╜╤Ц\n                        ╨╜╨╡ ╨┐╤Ц╨╖╨╜╤Ц╤И╨╡ 3 ╤А╨╛╨▒╨╛╤З╨╕╤Е ╨┤╨╜╤Ц╨▓ ╨╖ ╨┤╨╜╤П ╨┐╤Ц╨┤╨┐╨╕╤Б╨░╨╜╨╜╤П\n                        ╨Р╨║╤В╤Г ╨┐╤А╨╕╨╣╨╛╨╝╤Г-╨┐╨╡╤А╨╡╨┤╨░╤З╤Ц ╨╜╨░╨┤╨░╨╜╨╕╤Е ╨┐╨╛╤Б╨╗╤Г╨│.</td>\n                </tr>\n            </table>\n        </td>\n        <td style =\" vertical-align: top; border-collapse: collapse; border: 1px solid black; border-bottom:none; height: 100%; box-sizing: border-box; padding: 5px 4px 5px 4px;\">\n            <table width=\"285\" style=\"margin:0;border-collapse: collapse;border: 0;\">\n                <tr>\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>CONTRACT тДЦvar_contract_id</strong></td>\n                </tr>\n                <tr>\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>FOR SERVICES</strong></td>\n                </tr>\n                <tr>\n                    <td align=\"right\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">var_start_date</td>\n                </tr>\n                <tr>\n                    <td align=\"right\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><span style=\"color: #ffffff;\">.</span></td>\n                </tr>\n                <tr>\n                    <td align=\"justify\" style=\"margin: 0;\">\n                        <p style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">\n                            <span style=\"color: #ffffff;\">.....</span>The company \"var_company_name\"\n                            hereinafter referred to as \"Customer\" and the\n                            company \"<strong>FOP Prozhoga O.Y.</strong>\" Ukraine,\n                            represented by Prozhoga Oleksii Yuriyovich, who is\n                            authorized by check тДЦ22570000000001891 from\n                            01.05.2001, hereinafter referred to as \"Contractor\",\n                            and both Companies hereinafter referred to as\n                            \"Parties\", have c╨░ ╤Пoncluded the present Contract as\n                            follows:\n                        </p>\n                    </td>\n                </tr>\n                <tr>\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>1. Subject of the Contract</strong></td>\n                </tr>\n                <tr>\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">1.1.The Contractor undertakes to provide the\n                        following services to Customer: Software\n                        development (web site)<br><span style=\"color: #ffffff;\">.</span></td>\n                </tr>\n                <tr>\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>2. Contract Price and total sum</strong></td>\n                </tr>\n                <tr>\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">2.1.The price for the Services is established in\n                        <strong>$var_total</strong></td>\n                </tr>\n                <tr>\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">\n                        2.2.The preliminary total sum of the Contract\n                        makes <strong>$var_total</strong></td>\n                </tr>\n                <tr>\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">\n                        2.3.In case of change of the sum of the Contract,\n                        the Parties undertake to sign the additional\n                        agreement to the given Contract on increase or\n                        reduction of a total sum of the Contract.</td>\n                </tr>\n                <tr>\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>3. Payment Conditions</strong></td>\n                </tr>\n                <tr>\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">3.1.The Customer shall pay by bank transfer to\n                        the account within 5 calendar days from the date\n                        of signing the acceptance of the Services.</td>\n                </tr>\n                <tr>\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">\n                        3.2. Bank charges are paid by customer.</td>\n                </tr>\n                <tr>\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">\n                        3.3. The currency of payment is USD.<br><span style=\"color: #ffffff;\">.</span><br></td>\n                </tr>\n                <tr>\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>4. Realisation Terms</strong></td>\n                </tr>\n                <tr>\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">4.1.The Contractor shall deliver of the services on\n                        consulting services terms.</td>\n                </tr>\n                <tr>\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>5. The responsibility of the Parties</strong></td>\n                </tr>\n                <tr>\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">5.1. The Parties under take to bear the\n                        responsibility for default or inadequate\n                        performance of obligations under the present\n                        contract</td>\n                </tr>\n                <tr>\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>6. Claims</strong></td>\n                </tr>\n                <tr>\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">6.1.Claims of quality and quantity of the services\n                        delivered according to the present Contract can be\n                        made not later 3 days upon the receiving of the\n                        Goods.</td>\n                </tr>\n            </table>\n        </td>\n    </tr>\n</table>\n');
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
) ENGINE=InnoDB AUTO_INCREMENT=228 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `extensions`
--

DROP TABLE IF EXISTS `extensions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `extensions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `repository` varchar(250) DEFAULT NULL,
  `type` enum('EXTENSION','THEME','LANGUAGE') DEFAULT NULL,
  `version` varchar(250) DEFAULT NULL,
  `package` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `financial_reports`
--

DROP TABLE IF EXISTS `financial_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financial_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_date` int null,
  `income` text null,
  `currency` double null,
  `expense_constant` text null,
  `expense_salary` double null,
  `investments` text null,
  `spent_corp_events` text null,
  `is_locked` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `status` enum('NEW','PAID','CANCELED') DEFAULT 'NEW',
  `note` varchar(1000) DEFAULT NULL,
  `total_hours` double DEFAULT NULL,
  `contract_number` int(11) DEFAULT NULL,
  `act_of_work` int(11) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT '0',
  `payment_method_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `user_projects` varchar(255) DEFAULT NULL,
  `contract_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `idx-invoice_contract` (`contract_id`),
  KEY `idx-invoices-created_by` (`created_by`),
  CONSTRAINT `fk-invoice_contract` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk-invoices-created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=401 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `status` enum('NEW','CONFIRMED') DEFAULT 'NEW',
  `note` text,
  PRIMARY KEY (`id`),
  KEY `fk_monthly_reports_users1_idx` (`user_id`),
  CONSTRAINT `fk_monthly_reports_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_methods`
--

LOCK TABLES `payment_methods` WRITE;
/*!40000 ALTER TABLE `payment_methods` DISABLE KEYS */;
INSERT INTO `payment_methods` (`id`, `name`, `description`)
VALUES (1,'bank_transfer','<tr>\n                                <td colspan = \"8\" width = \"570\" style=\"padding: 0; margin: 0;\">\n                                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"570\" style=\"border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;\">\n\n                                        <tr>\n                                            <td width = \"285\" valign=\"top\" height=\"25\" style=\"padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;\">\n\n                                                    Company Name\n\n                                            </td>\n                                            <td height=\"25\" valign=\"top\" style=\"width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;\">\nFOP Prozhoga Oleksii                                          \n\n                                            </td>\n                                        </tr>\n\n                                        <tr style=\"background-color: #eeeeee;\">\n                                            <td width = \"285\" valign=\"top\" height=\"25\" style=\"padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;\">\n                                                <div style=\"width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;\">\n                                                    The bank account of the company\n                                                </div>\n                                            </td>\n                                            <td height=\"25\" valign=\"top\" style=\"width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;\">\n                                                26002057002108\n                                            </td>\n                                        </tr>\n\n                                        <tr>\n                                            <td width = \"285\" valign=\"top\" height=\"25\" style=\"padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;\">\n                                                <div style=\"width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;\">\n                                                    Name of the bank\n                                                </div>\n                                            </td>\n                                            <td height=\"25\" valign=\"top\" style=\"width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;\">\n                                                Privatbank, Dnipropetrovsk, Ukraine\n                                            </td>\n                                        </tr>\n\n                                        <tr style=\"background-color: #eeeeee;\">\n                                            <td width = \"285\" valign=\"top\" height=\"25\" style=\"padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;\">\n                                                <div style=\"width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;\">\n                                                    Bank SWIFT Code\n                                                </div>\n                                            </td>\n                                            <td height=\"25\" valign=\"top\" style=\"width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;\">\n                                                PBANUA2X\n                                            </td>\n                                        </tr>\n\n                                        <tr>\n                                            <td width = \"285\" valign=\"top\" height=\"25\" style=\"padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;\">\n                                                <div style=\"width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;\">\n                                                    Company address\n                                                </div>\n                                            </td>\n                                            <td height=\"25\" valign=\"top\" style=\"width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;\">\n                                                UA 08294 Kyiv\'s Region, Buch, Tarasivska 8╨░/128\n                                            </td>\n                                        </tr>\n\n                                        <tr style=\"background-color: #eeeeee;\">\n                                            <td width = \"285\" valign=\"top\" height=\"25\" style=\"padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;\">\n                                                <div style=\"width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;\">\n                                                    IBAN Code\n                                                </div>\n                                            </td>\n                                            <td height=\"25\" valign=\"top\" style=\"width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;\">\n                                                UA323515330000026002057002108\n                                            </td>\n                                        </tr>\n\n                                        <tr>\n                                            <td width = \"285\" valign=\"top\" height=\"25\" style=\"padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;\">\n                                                <div style=\"width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;\">\n                                                    Correspondent banks\n                                                </div>\n                                                <div style=\"width: 100%; padding: 18px 0 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;\">\n                                                    Account in the correspondent bank\n                                                </div>\n                                            </td>\n                                            <td height=\"25\" valign=\"top\" style=\"width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;\">\n                                                001-1-000080\n                                            </td>\n                                        </tr>\n\n                                        <tr style=\"background-color: #eeeeee;\">\n                                            <td width = \"285\" valign=\"top\" height=\"25\" style=\"padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;\">\n\n                                                    SWIFT-code of the correspondent bank\n\n                                            </td>\n                                            <td height=\"25\" valign=\"top\" style=\"width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;\">\n                                                CHASUS33\n                                            </td>\n                                        </tr>\n\n                                        <tr>\n                                            <td width = \"285\" valign=\"top\" height=\"25\" style=\"padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;\">\n                                                <div style=\"width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;\">\n                                                    Correspondent bank\n                                                </div>\n                                            </td>\n                                            <td height=\"25\" valign=\"top\" style=\"width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;\">\n                                                JP Morgan Chase Bank,New York ,USA\n                                            </td>\n                                        </tr>\n\n                                    </table>\n                                </td>\n                            </tr>');
INSERT INTO `payment_methods` (`id`, `name`, `description`)
VALUES (2,'Default payment method','<table width=\"570\" style=\"max-width: 570px; margin-left: auto; margin-right: auto; border-collapse: collapse;\">\n\n<tr style = \"height: 100%; box-sizing: border-box; border-collapse: collapse;\">\n    <td width=\"285\" style =\" vertical-align: top; border-left: 1px solid black; border-right: 1px solid black; height: 100%; box-sizing: border-box; border-collapse: collapse; padding: 5px; font-family:\'Times New Roman\';font-size:10px; padding: 5px;\">\n        <table width=\"285\" style=\"margin:0;border-collapse: collapse;border: 0;\">\n            <tr>\n                <td align=\"center\" style=\"margin: 0; font-family:\'Times New Roman\';font-size:10px;\">╨Т╨╕╨║╨╛╨╜╨░╨▓╨╡╤Ж╤М</td>\n            </tr>\n            <tr>\n                <td align=\"justify\" style=\"margin: 0; font-family:\'Times New Roman\';font-size:10px;\">\n                    <p><span style=\"color: #ffffff;\">.</span></p>\n                    <p>╨С╨╡╨╜╨╡╤Д╤Ц╤Ж╨╕╨░╤А: <strong>╨Я╤А╨╛╨╢╨╛╨│╨░ ╨Ю╨╗╨╡╨║╤Б╤Ц╨╣ ╨о╤А╤Ц╨╣╨╛╨▓╨╕╤З</strong></p>\n                    <p>╨Р╨┤╤А╨╡╤Б╨░ ╨▒╨╡╨╜╨╡╤Д╤Ц╤Ж╨╕╨░╤А╨░: <strong>UA 08294</strong></p>\n                    <p><strong>╨Ъ╨╕╤Ч╨▓╤Б╤М╨║╨░ ╨╛╨▒╨╗., ╨╝. ╨С╤Г╤З╨░</strong></p>\n                    <p><strong>╨▓╤Г╨╗. ╨в╨░╤А╨░╤Бi╨▓╤Б╤М╨║╨░ ╨┤.8╨░ ╨║╨▓.128</strong></p>\n                    <p>╨а╨░╤Е╤Г╨╜╨╛╨║ ╨▒╨╡╨╜╨╡╤Д╤Ц╤Ж╨╕╨░╤А╨░: <strong>26002057002108</strong></p>\n                    <p>SWIFT ╨║╨╛╨┤: <strong>PBANUA2X</strong></p>\n                    <p>╨С╨░╨╜╨║ ╨▒╨╡╨╜╨╡╤Д╤Ц╤Ж╨╕╨░╤А╨░: <strong>Privatbank, Dnipropetrovsk, Ukraine</strong></p>\n                    <p>IBAN Code: <strong>UA323515330000026002057002108</strong></p>\n                    <p>╨С╨░╨╜╨║-╨║╨╛╤А╤А╨╡╤Б╨┐╨╛╨╜╨┤╨╡╨╜╤В: <strong>JP Morgan</strong></p>\n                    <p><strong>Chase Bank,New York ,USA</strong></p>\n                    <p>╨а╨░╤Е╤Г╨╜╨╛╨║ ╤Г ╨▒╨░╨╜╨║╤Г-╨║╨╛╤А╨╡╤Б╨┐╨╛╨╜╨┤╨╡╨╜╤В╤Г: <strong>001-1-000080</strong></p>\n                    <p>SWIFT ╨║╨╛╨┤ ╨║╨╛╤А╨╡╤Б╨┐╨╛╨╜╨┤╨╡╨╜╤В╨░: <strong>CHASUS33</strong></p>\n                </td>\n            </tr>\n        </table>\n    </td>\n    <td width=\"284\" style =\" vertical-align: top; border-collapse: collapse; border-left: 1px solid black; border-right: 1px solid black; height: 100%; box-sizing: border-box; padding: 5px; font-family:\'Times New Roman\'; font-size:10px; padding: 5px;\">\n        <table width=\"284\" style=\"margin:0;border-collapse: collapse;border: 0;\">\n            <tr>\n                <td align=\"center\" style=\"margin: 0; font-family:\'Times New Roman\';font-size:10px;\">Contractor</td>\n            </tr>\n            <tr>\n                <td align=\"justify\" style=\"margin: 0; font-family:\'Times New Roman\';font-size:10px;\">\n                    <p><span style=\"color: #ffffff;\">.</span></p>\n                    <p>BENEFICIARY: <strong>Prozhoga Oleksii Yuriyovich</strong></p>\n                    <p>BENEFICIARY ADDRESS: <strong>UA 08294 Kiyv,</strong></p>\n                    <p><strong>Bucha, Tarasivska st. 8a/128</strong></p>\n                    <p><span style=\"color: #ffffff;\">.</span></p>\n                    <p>BENEFICIARY ACCOUNT: <strong>26002057002108</strong></p>\n                    <p>SWIFT CODE: <strong>PBANUA2X</strong></p>\n                    <p>BANK OF BENEFICIARY: <strong>Privatbank,</strong></p>\n                    <p><strong>Dnipropetrovsk, Ukraine</strong></p>\n                    <p>IBAN Code: <strong>UA323515330000026002057002108</strong></p>\n                    <p>CORRESPONDENT BANK: <strong>JP Morgan</strong></p>\n                    <p><strong>Chase Bank,New York ,USA</strong></p>\n                    <p>CORRESPONDENT ACCOUNT: <strong>001-1-000080</strong></p>\n                    <p>SWIFT Code of correspondent bank: <strong>CHASUS33</strong></p>\n                </td>\n            </tr>\n        </table>\n    </td>\n</tr>\n</table>');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `status` enum('ACTIVE','INACTIVE','HIDDEN') DEFAULT 'ACTIVE',
  `is_sales` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`user_id`,`project_id`),
  KEY `fk_project_developers_projects1_idx` (`project_id`),
  CONSTRAINT `fk_project_developers_projects1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_project_developers_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `jira_code` varchar(15) DEFAULT NULL,
  `total_logged_hours` double DEFAULT NULL,
  `total_paid_hours` double DEFAULT NULL,
  `status` enum('NEW','ONHOLD','INPROGRESS','DONE','CANCELED') DEFAULT 'NEW',
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT '0',
  `cost` decimal(10,2) DEFAULT '0.00',
  `description` text,
  `photo` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=603 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `reporter_name` varchar(150) DEFAULT NULL,
  `hours` double DEFAULT NULL,
  `task` varchar(500) DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  `date_paid` date DEFAULT NULL,
  `date_report` date DEFAULT NULL,
  `status` enum('NEW','INVOICED','DELETED','PAID','WONTPAID') DEFAULT 'NEW',
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
) ENGINE=InnoDB AUTO_INCREMENT=695 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
INSERT INTO `reports` (`id`, `user_id`, `is_delete`, `invoice_id`)
VALUES (1,0,0,null);
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
  `note` text,
  PRIMARY KEY (`id`),
  KEY `fk_salary_history_users1_idx` (`user_id`),
  CONSTRAINT `fk_salary_history_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `support_ticket_comments`
--

DROP TABLE IF EXISTS `support_ticket_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `support_ticket_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` text,
  `date_added` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `support_ticket_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `support_tickets`
--

DROP TABLE IF EXISTS `support_tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `support_tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(250) DEFAULT NULL,
  `description` text,
  `is_private` tinyint(1) DEFAULT '0',
  `assignet_to` int(11) DEFAULT NULL,
  `status` enum('NEW','ASSIGNED','COMPLETED','CANCELLED') DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_completed` datetime DEFAULT NULL,
  `date_cancelled` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_support_tickets_users` (`client_id`),
  CONSTRAINT `fk_support_tickets_users` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=328 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=671 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `surveys_options`
--

DROP TABLE IF EXISTS `surveys_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `surveys_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `description` text,
  `survey_id` int(11) DEFAULT NULL,
  `votes` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_surveys_options_users` (`survey_id`),
  CONSTRAINT `fk_surveys_options_users` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1161 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
INSERT INTO `teams` (`id`, `user_id`, `name`, `date_created`, `is_deleted`, `team_leader_id`)
VALUES (1,1,'Skynix Team','2016-06-07',0,1);
INSERT INTO `teams` (`id`, `user_id`, `name`, `date_created`, `is_deleted`, `team_leader_id`)
VALUES (2,1,'EMAC Team','2016-06-07',0,1);
INSERT INTO `teams` (`id`, `user_id`, `name`, `date_created`, `is_deleted`, `team_leader_id`)
VALUES (3,1,'Bikebiz','2016-07-08',0,1);
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
  `role` enum('ADMIN','PM','DEV','CLIENT','FIN','SALES') NOT NULL DEFAULT 'DEV',
  `phone` varchar(45) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(45) DEFAULT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `middle_name` varchar(45) DEFAULT NULL,
  `company` varchar(150) DEFAULT NULL,
  `tags` varchar(500) DEFAULT NULL,
  `about` varchar(1000) DEFAULT NULL,
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
  `invite_hash` varchar(45) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT '0',
  `photo` varchar(255) DEFAULT NULL,
  `sing` varchar(255) DEFAULT NULL,
  `public_profile_key` varchar(45) DEFAULT NULL,
  `bank_account_en` text,
  `bank_account_ua` text,
  `password_reset_token` varchar(45) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `birthday` timestamp NULL DEFAULT NULL,
  `experience_year` int(11) DEFAULT '0',
  `degree` varchar(255) DEFAULT 'No Degree',
  `residence` varchar(255) DEFAULT NULL,
  `link_linkedin` varchar(255) DEFAULT NULL,
  `link_video` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT '0',
  `languages` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=1493 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `role`, `phone`, `email`, `password`, `first_name`, `last_name`, `middle_name`, `company`, `tags`, `about`, `date_signup`, `date_login`, `date_salary_up`, `is_active`, `salary`, `month_logged_hours`, `year_logged_hours`, `total_logged_hours`, `month_paid_hours`, `year_paid_hours`, `total_paid_hours`, `invite_hash`, `is_delete`, `photo`, `sing`, `public_profile_key`, `bank_account_en`, `bank_account_ua`, `is_published`, `slug`)
VALUES (1,'ADMIN','0662050652','maryt@skynix.co','21232f297a57a5a743894a0e4a801fc3','Oleksii','Prozhoga','','FOP Prozhoha O.Y.','apache, nginx, php, java, Objective C, c++, mysql, zf2, yii2, magento 2, javascript, html5, css3, sencha, angularjs, phonegap, server administration','I have been working about 15 years with different versions of PHP. \r\n Last 8 years I have been a technical leader for different well known companies such as Citrix.\r\n Currently, I provide services for projecting & modeling complex systems, configuring web servers and solving complex programming tasks.','2016-03-17 09:00:10','2017-02-25 13:27:10','2017-02-25',1,1500,0,0,0,0,0,0,'',0,'Oleksii-round.png','Sign-clean-128.png',NULL,NULL,NULL, 1,'oleksii-prozhoga');
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
  `date_start` timestamp NULL DEFAULT NULL,
  `date_end` timestamp NULL DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_work_history_users` (`user_id`),
  CONSTRAINT `fk_work_history_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `work_history` WRITE;
/*!40000 ALTER TABLE `work_history` DISABLE KEYS */;
INSERT INTO `work_history` (`id`, `user_id`, `date_start`, `date_end`, `type`, `title`)
VALUES (1,1,'2017-02-25','2017-02-25','link/type','FOP Prozhoha O.Y.');
/*!40000 ALTER TABLE `work_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_commentmeta`
--

DROP TABLE IF EXISTS `wp_commentmeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_commentmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`meta_id`),
  KEY `comment_id` (`comment_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wp_comments`
--

DROP TABLE IF EXISTS `wp_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_comments` (
  `comment_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_post_ID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `comment_author` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_author_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT '0',
  `comment_approved` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_ID`),
  KEY `comment_post_ID` (`comment_post_ID`),
  KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  KEY `comment_date_gmt` (`comment_date_gmt`),
  KEY `comment_parent` (`comment_parent`),
  KEY `comment_author_email` (`comment_author_email`(10))
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wp_layerslider`
--

DROP TABLE IF EXISTS `wp_layerslider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_layerslider` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `author` int(10) NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_c` int(10) NOT NULL,
  `date_m` int(11) NOT NULL,
  `flag_hidden` tinyint(1) NOT NULL DEFAULT '0',
  `flag_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wp_links`
--

DROP TABLE IF EXISTS `wp_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_links` (
  `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_target` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_visible` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) unsigned NOT NULL DEFAULT '1',
  `link_rating` int(11) NOT NULL DEFAULT '0',
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_notes` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_rss` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`link_id`),
  KEY `link_visible` (`link_visible`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wp_options`
--

DROP TABLE IF EXISTS `wp_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `option_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `autoload` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3729 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wp_postmeta`
--

DROP TABLE IF EXISTS `wp_postmeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_postmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`meta_id`),
  KEY `post_id` (`post_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB AUTO_INCREMENT=199 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wp_posts`
--

DROP TABLE IF EXISTS `wp_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_posts` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) unsigned NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_excerpt` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `post_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `post_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `to_ping` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pinged` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `guid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT '0',
  `post_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `post_name` (`post_name`(191)),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  KEY `post_parent` (`post_parent`),
  KEY `post_author` (`post_author`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wp_term_relationships`
--

DROP TABLE IF EXISTS `wp_term_relationships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_term_relationships` (
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wp_term_taxonomy`
--

DROP TABLE IF EXISTS `wp_term_taxonomy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_term_taxonomy` (
  `term_taxonomy_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wp_termmeta`
--

DROP TABLE IF EXISTS `wp_termmeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_termmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`meta_id`),
  KEY `term_id` (`term_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wp_terms`
--

DROP TABLE IF EXISTS `wp_terms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_id`),
  KEY `slug` (`slug`(191)),
  KEY `name` (`name`(191))
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wp_usermeta`
--

DROP TABLE IF EXISTS `wp_usermeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_usermeta` (
  `umeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wp_users`
--

DROP TABLE IF EXISTS `wp_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_users` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_nicename` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`),
  KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-27  6:31:28
