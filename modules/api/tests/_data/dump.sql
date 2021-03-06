
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS api_auth_access_tokens;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE api_auth_access_tokens (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) DEFAULT NULL,
  access_token varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  exp_date datetime DEFAULT NULL,
  crowd_exp_date int(11) DEFAULT NULL,
  crowd_token varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE api_auth_access_tokens DISABLE KEYS */;
INSERT INTO api_auth_access_tokens VALUES (2,1,'GcfVWZzq6pYwnxSo6QzBdJrJFpQa5-Tn9Um5WSF','2019-07-18 13:48:41',NULL,NULL),(3,5,'rKtlhIR9d8yLClqTL7QbGcnTgORsFT4A23GG5HR','2019-03-12 15:08:47',NULL,NULL);
/*!40000 ALTER TABLE api_auth_access_tokens ENABLE KEYS */;
DROP TABLE IF EXISTS auth_types;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE auth_types (
  id int(11) NOT NULL AUTO_INCREMENT,
  type_name varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE auth_types DISABLE KEYS */;
INSERT INTO auth_types VALUES (1,'crowd_atlassian'),(2,'local_mysql');
/*!40000 ALTER TABLE auth_types ENABLE KEYS */;
DROP TABLE IF EXISTS availability_logs;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE availability_logs (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  is_available tinyint(1) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY fk_availability_logs_users (user_id),
  CONSTRAINT fk_availability_logs_users FOREIGN KEY (user_id) REFERENCES `users` (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE availability_logs DISABLE KEYS */;
/*!40000 ALTER TABLE availability_logs ENABLE KEYS */;
DROP TABLE IF EXISTS busineses;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE busineses (
  id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  invoice_increment_id int(11) DEFAULT '0',
  address varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  director_id int(11) DEFAULT NULL,
  is_default tinyint(1) DEFAULT NULL,
  is_delete tinyint(1) DEFAULT '0',
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE busineses DISABLE KEYS */;
INSERT INTO busineses VALUES (1,'Skynix LLC',2,'6 Bohdana Khmelnytskogo Blvd, Apt. 132, Bucha, Kyiv obl., 08292, UKRAINE',5,1,0),(2,'Synpass LLC',0,'Hlybochytska St, 17D, Kyiv, 04050',4,0,0);
/*!40000 ALTER TABLE busineses ENABLE KEYS */;
DROP TABLE IF EXISTS candidates;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE candidates (
  id int(11) NOT NULL AUTO_INCREMENT,
  career_id int(11) DEFAULT NULL,
  first_name varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  last_name varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  email varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  date_applied timestamp NULL DEFAULT NULL,
  date_interview timestamp NULL DEFAULT NULL,
  is_interviewed tinyint(1) DEFAULT '0',
  skills varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  backend_skills int(11) DEFAULT '0',
  frontend_skills int(11) DEFAULT '0',
  system_skills int(11) DEFAULT '0',
  other_skills int(11) DEFAULT '0',
  desired_salary int(11) DEFAULT '0',
  interviewer_notes text COLLATE utf8_unicode_ci,
  PRIMARY KEY (id),
  KEY `fk-post-career_id` (career_id),
  CONSTRAINT `fk-post-career_id` FOREIGN KEY (career_id) REFERENCES careers (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE candidates DISABLE KEYS */;
/*!40000 ALTER TABLE candidates ENABLE KEYS */;
DROP TABLE IF EXISTS careers;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE careers (
  id int(11) NOT NULL AUTO_INCREMENT,
  title varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  description text COLLATE utf8_unicode_ci,
  is_active tinyint(1) DEFAULT '0',
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE careers DISABLE KEYS */;
/*!40000 ALTER TABLE careers ENABLE KEYS */;
DROP TABLE IF EXISTS contact;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE contact (
  id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  email varchar(150) DEFAULT NULL,
  message varchar(150) DEFAULT NULL,
  `subject` varchar(45) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE contact DISABLE KEYS */;
/*!40000 ALTER TABLE contact ENABLE KEYS */;
DROP TABLE IF EXISTS contract_templates;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE contract_templates (
  id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  content text COLLATE utf8_unicode_ci,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE contract_templates DISABLE KEYS */;
INSERT INTO contract_templates VALUES (2,'Default template Skynix','<!doctype html>\r\n<html lang=\"en\">\r\n<head>\r\n    <meta charset=\"utf-8\">\r\n    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\r\n</head>\r\n<body>\r\n<table width=\"570\" style=\" margin-left: auto; margin-right: auto; border-collapse: collapse;\">\r\n    <tr style = \"height: 100%; box-sizing: border-box; border-collapse: collapse; \">\r\n      	<td style =\" vertical-align: top; border-collapse: collapse; border: 1px solid black; border-bottom:none; height: 100%; box-sizing: border-box; padding: 5px 4px 5px 4px;\">\r\n            <table width=\"285\" style=\"margin:0;border-collapse: collapse;border: 0;\">\r\n                <tr>\r\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>CONTRACT №var_contract_id</strong></td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>FOR SERVICES</strong></td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"right\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">var_start_date</td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"right\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><span style=\"color: #ffffff;\">.</span></td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"justify\" style=\"margin: 0;\">\r\n                        <p style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">\r\n                            <span style=\"color: #ffffff;\">.....</span>The company \"var_company_name\"\r\n                            hereinafter referred to as \"Customer\" and the\r\n                            company \"<strong>Skynix Ltd</strong>\",\r\n                            represented by CEO, who is\r\n                            authorized by check #438000980 from\r\n                            01.05.2017, hereinafter referred to as \"Contractor\",\r\n                            and both Companies hereinafter referred to as\r\n                            \"Parties\", have cа oncluded the present Contract as\r\n                            follows:\r\n                        </p>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>1. Subject of the Contract</strong></td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">1.1.The Contractor undertakes to provide the\r\n                        following services to Customer: Software\r\n                        development (web site)<br><span style=\"color: #ffffff;\">.</span></td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>2. Contract Price and total sum</strong></td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">2.1.The price for the Services is established in\r\n                        <strong>$var_total</strong></td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">\r\n                        2.2.The preliminary total sum of the Contract\r\n                        makes <strong>$var_total</strong></td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">\r\n                        2.3.In case of change of the sum of the Contract,\r\n                        the Parties undertake to sign the additional\r\n                        agreement to the given Contract on increase or\r\n                        reduction of a total sum of the Contract.</td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>3. Payment Conditions</strong></td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">3.1.The Customer shall pay by bank transfer to\r\n                        the account within 5 calendar days from the date\r\n                        of signing the acceptance of the Services.</td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">\r\n                        3.2. Bank charges are paid by customer.</td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">\r\n                        3.3. The currency of payment is USD.<br><span style=\"color: #ffffff;\">.</span><br></td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>4. Realisation Terms</strong></td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">4.1.The Contractor shall deliver of the services on\r\n                        consulting services terms.</td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>5. The responsibility of the Parties</strong></td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">5.1. The Parties under take to bear the\r\n                        responsibility for default or inadequate\r\n                        performance of obligations under the present\r\n                        contract</td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"center\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\"><strong>6. Claims</strong></td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\"justify\" style=\"margin: 0;font-family:\'Times New Roman\';font-size:10px;\">6.1.Claims of quality and quantity of the services\r\n                        delivered according to the present Contract can be\r\n                        made not later 3 days upon the receiving of the\r\n                        Goods.</td>\r\n                </tr>\r\n            </table>\r\n        </td>\r\n    </tr>\r\n</table>\r\n');
/*!40000 ALTER TABLE contract_templates ENABLE KEYS */;
DROP TABLE IF EXISTS contracts;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE contracts (
  id int(11) NOT NULL AUTO_INCREMENT,
  contract_id int(11) DEFAULT NULL,
  customer_id int(11) DEFAULT NULL,
  act_number int(11) DEFAULT NULL,
  start_date date DEFAULT NULL,
  end_date date DEFAULT NULL,
  act_date date DEFAULT NULL,
  total decimal(19,2) DEFAULT NULL,
  created_by int(11) DEFAULT NULL,
  contract_template_id int(11) DEFAULT NULL,
  contract_payment_method_id int(11) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY `idx-contracts-customer_id` (customer_id),
  KEY `idx-contracts-created_by` (created_by),
  KEY `idx-contracts-contract_template_id` (contract_template_id),
  KEY `idx-contracts-contract_payment_method_id` (contract_payment_method_id),
  CONSTRAINT `fk-contracts-contract_template_id` FOREIGN KEY (contract_template_id) REFERENCES contract_templates (id) ON DELETE CASCADE,
  CONSTRAINT `fk-contracts-created_by` FOREIGN KEY (created_by) REFERENCES `users` (id),
  CONSTRAINT `fk-contracts-customer_id` FOREIGN KEY (customer_id) REFERENCES `users` (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE contracts DISABLE KEYS */;
/*!40000 ALTER TABLE contracts ENABLE KEYS */;
DROP TABLE IF EXISTS counterparties;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE counterparties (
  id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE counterparties DISABLE KEYS */;
/*!40000 ALTER TABLE counterparties ENABLE KEYS */;
DROP TABLE IF EXISTS delayed_salary;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE delayed_salary (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  raised_by int(11) DEFAULT NULL,
  is_applied int(11) DEFAULT '0',
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE delayed_salary DISABLE KEYS */;
/*!40000 ALTER TABLE delayed_salary ENABLE KEYS */;
DROP TABLE IF EXISTS email_templates;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE email_templates (
  id int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  reply_to varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  body text COLLATE utf8_unicode_ci,
  template varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE email_templates DISABLE KEYS */;
INSERT INTO email_templates VALUES (1,'Skynix CRM: Change password','{adminEmail}','<tr>\n    <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n    <td colspan = \"3\"  height=\"36\" style=\"padding: 0; margin: 0;\">\n        <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"512\" style=\"border-collapse: collapse;\n     mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto;\">\n            <tr>\n                <td colspan = \"2\" width = \"125\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"></td>\n                <td rowspan = \"2\" width = \"262\" height=\"25\" style=\"padding: 0; margin: 0;\n             font-family: \'HelveticaNeue UltraLight\', sans-serif; font-size: 24px; text-align: center;\n              vertical-align: middle;\"> Hello, <span>{username},</span> </td>\n<td colspan = \"2\" width = \"125\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"></td>\n</tr>\n<tr>\n    <td colspan = \"2\" width = \"125\" height=\"0\" valign=\"top\" style=\"padding: 6px 0; margin: 0; border-top: solid 1px #a3d8f0;\"></td>\n    <td colspan = \"2\" width = \"125\" height=\"0\" valign=\"top\" style=\"padding: 6px 0; margin: 0; border-top: solid 1px #a3d8f0;\"></td>\n</tr>\n</table>\n</td>\n\n<td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n</tr>\n\n<tr>\n    <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n    <td colspan = \"3\"  height=\"15\" style=\"padding: 10px 0 4px 0; margin: 0;\n     font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px;\n     font-weight: normal; text-align: center;\">{username}, go through the link to reset your password.</td>\n    <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n</tr>\n\n<tr>\n    <td colspan = \"5\"  height=\"35\" style=\"padding: 8px 0 5px 0; margin: 0; background-color: #a3d8f0;\n        font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px; text-align: center; color: #fffefe;\">\n        THANK YOU FOR YOUR COLLABORATION WE APPRECIATE YOUR BUSINESS </td>\n</tr>\n<tr>\n    <td colspan = \"2\" width = \"237\" height=\"34\" style=\"padding: 0; margin: 0; background-color: #a3d8f0;\"></td>\n\n    <td width = \"96\"  valign=\"top\" style=\"padding:0; margin: 0; text-align: center; background-color: #a3d8f0;\n        vertical-align: middle;\">\n        <a href={url_crm}/site/code/{token}> title=\"CLICK HERE\" target=\"_blank\" style=\"text-align: center; text-decoration: none;\">\n        <img src=\"http://cdn.skynix.co/skynix/btn-click.png\" width=\"95\" height = \"34\"  border=\"0\"\n             alt = \"CLICK HERE\" style=\"display: block; padding: 0px; margin: 0px; border: none;\"/>\n        </a>\n    </td>\n\n    <td colspan = \"2\" width = \"237\" height=\"34\" style=\"padding: 0; margin: 0; background-color: #a3d8f0;\"></td>\n</tr>\n\n<tr>\n    <td colspan = \"5\"  height=\"13\" style=\"padding: 0; margin: 0; background-color: #a3d8f0;\"></td>\n</tr>','change-password'),(2,'Skynix Invoice # {dataPdf->id}','{adminEmail}','<tr>\n<td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n<td colspan = \"3\"  height=\"36\" style=\"padding: 0; margin: 0;\">\n    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"512\" style=\"border-collapse: collapse;\n     mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto;\">\n        <tr>\n            <td colspan = \"2\" width = \"125\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"></td>\n            <td rowspan = \"2\" width = \"262\" height=\"25\" style=\"padding: 0; margin: 0;\n             font-family: \'HelveticaNeue UltraLight\', sans-serif; font-size: 24px; text-align: center;\n              vertical-align: middle;\"> Hello, <span>{nameCustomer}</span> </td>\n            <td colspan = \"2\" width = \"125\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"></td>\n        </tr>\n        <tr>\n            <td colspan = \"2\" width = \"125\" height=\"0\" valign=\"top\" style=\"padding: 6px 0; margin: 0; border-top: solid 1px #a3d8f0;\"></td>\n            <td colspan = \"2\" width = \"125\" height=\"0\" valign=\"top\" style=\"padding: 6px 0; margin: 0; border-top: solid 1px #a3d8f0;\"></td>\n        </tr>\n    </table>\n</td>\n\n    <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n</tr>\n<tr>\n    <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n    <td colspan = \"3\"  height=\"16\" style=\"padding: 19px 0 10px 0; margin: 0; font-family: \'HelveticaNeue Regular\',\n    sans-serif; font-size: 16px; font-weight: normal; text-align: center;\">Your invoice #\n    <strong style=\" font-family: \'HelveticaNeue Bold\', sans-serif; font-size: 16px; font-weight: bold;\">{id}</strong></td>\n    <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n</tr>\n<tr>\n    <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n    <td colspan = \"3\"  height=\"15\" style=\"padding: 10px 0 4px 0; margin: 0;\n     font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px;\n     font-weight: normal; text-align: center;\">This invoice has been generated by Skynix company for the period:</td>\n    <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n</tr>\n<tr>\n    <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n    <td colspan = \"3\"  height=\"15\" style=\"padding: 0 0 4px 0; margin: 0;\n     font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px;\n     font-weight: normal; text-align: center;\"><strong style=\" font-family: \'HelveticaNeue Bold\', sans-serif;\n     font-size: 16px; font-weight: bold;\">{dataFrom}  ~ {dataTo}</strong>\n    </td>\n    <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n</tr>\n<tr>\n    <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n    <td colspan = \"3\"  height=\"15\" style=\"padding: 10px 0 28px 0; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif;\n    font-size: 15px; font-weight: normal; text-align: center;\">The PDF invoice with payment details is attached</td>\n    <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n</tr>\n<tr>\n    <td colspan = \"5\"  height=\"35\" style=\"padding: 8px 0 5px 0; margin: 0; background-color: #a3d8f0;\n        font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px; text-align: center; color: #fffefe;\">\n        THANK YOU FOR YOUR COLLABORATION <br/> WE APPRECIATE YOUR BUSINESS </td>\n</tr>\n\n<tr>\n    <td colspan = \"5\"  height=\"13\" style=\"padding: 0; margin: 0; background-color: #a3d8f0;\"></td>\n</tr>','invoice'),(3,'{FirstName} edited a report #{ReportID}','{adminEmail}','<tr>\n                            <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                            <td colspan = \"3\"  height=\"36\" style=\"padding: 0; margin: 0;\">\n                                <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"512\" style=\"border-collapse: collapse;\n                                 mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto;\">\n                                    <tr>\n                                        <td colspan = \"2\" width = \"125\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"></td>\n                                        <td rowspan = \"2\" width = \"262\" height=\"25\" style=\"padding: 0; margin: 0;\n                                         font-family: \'HelveticaNeue UltraLight\', sans-serif; font-size: 24px; text-align: center;\n                                          vertical-align: middle;\"> Hello, <span>{SalesFirstName}</span> </td>\n                                        <td colspan = \"2\" width = \"125\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"></td>\n                                    </tr>\n                                    <tr>\n                                        <td colspan = \"2\" width = \"125\" height=\"0\" valign=\"top\" style=\"padding: 6px 0; margin: 0; border-top: solid 1px #a3d8f0;\"></td>\n                                        <td colspan = \"2\" width = \"125\" height=\"0\" valign=\"top\" style=\"padding: 6px 0; margin: 0; border-top: solid 1px #a3d8f0;\"></td>\n                                    </tr>\n                                </table>\n                            </td>\n                            \n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                            </tr>\n                            <tr>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                                <td colspan = \"3\"  height=\"16\" style=\"padding: 19px 0 10px 0; margin: 0; font-family: \'HelveticaNeue Regular\',\n                                sans-serif; font-size: 16px; font-weight: normal; text-align: center;\">The report: #\n                                <strong style=\" font-family: \'HelveticaNeue Bold\', sans-serif; font-size: 16px; font-weight: bold;\">{ReportID}</strong>\n                                {OldReportDate} {OldReportProject} -> {OldReportText} - {OldReportHours}h\n                                </td>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                            </tr>\n                            <tr>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                                <td colspan = \"3\"  height=\"15\" style=\"padding: 10px 0 4px 0; margin: 0;\n                                 font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px;\n                                 font-weight: normal; text-align: center;\">has just been changed to:</td>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                            </tr>\n                            <tr>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                                <td colspan = \"3\"  height=\"15\" style=\"padding: 0 0 4px 0; margin: 0;\n                                 font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px;\n                                 font-weight: normal; text-align: center;\">\n                                 {NewReportDate} {NewReportProject} -> {NewReportText} - {NewReportHours}h\n                                </td>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                            </tr>\n                         \n                            <tr>\n                                <td colspan = \"5\"  height=\"35\" style=\"padding: 8px 0 5px 0; margin: 0; background-color: #a3d8f0;\n                                    font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px; text-align: center; color: #fffefe;\">\n                                    \n                                    <a href=\"{SiteUrl}/dashboard/reports/management?from_date={NewReportDate}&limit=10&p=1&project_id={NewReportProjectID}&to_date={NewReportDate}\">Click here to review and approve</a>   \n                                </td>\n                            </tr>\n                            \n                            <tr>\n                                <td colspan = \"5\"  height=\"13\" style=\"padding: 0; margin: 0; background-color: #a3d8f0;\"></td>\n                            </tr>','review_report'),(5,'{FirstName} approved your report #{ReportID}','{ApproverEmail}','<tr>\n                            <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                            <td colspan = \"3\"  height=\"36\" style=\"padding: 0; margin: 0;\">\n                                <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"512\" style=\"border-collapse: collapse;\n                                 mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto;\">\n                                    <tr>\n                                        <td colspan = \"2\" width = \"125\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"></td>\n                                        <td rowspan = \"2\" width = \"262\" height=\"25\" style=\"padding: 0; margin: 0;\n                                         font-family: \'HelveticaNeue UltraLight\', sans-serif; font-size: 24px; text-align: center;\n                                          vertical-align: middle;\"> Hi, <span>{OwnerFirstName}</span> </td>\n                                        <td colspan = \"2\" width = \"125\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"></td>\n                                    </tr>\n                                    <tr>\n                                        <td colspan = \"2\" width = \"125\" height=\"0\" valign=\"top\" style=\"padding: 6px 0; margin: 0; border-top: solid 1px #a3d8f0;\"></td>\n                                        <td colspan = \"2\" width = \"125\" height=\"0\" valign=\"top\" style=\"padding: 6px 0; margin: 0; border-top: solid 1px #a3d8f0;\"></td>\n                                    </tr>\n                                </table>\n                            </td>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                            </tr>\n                            <tr>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                                <td colspan = \"3\"  height=\"16\" style=\"padding: 19px 0 10px 0; margin: 0; font-family: \'HelveticaNeue Regular\',\n                                sans-serif; font-size: 16px; font-weight: normal; text-align: center;\">The report:\n                                {ReportDate} {ReportProject} -> {ReportText} - {ReportHours}h\n                                </td>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                            </tr>\n                            <tr>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                                <td colspan = \"3\"  height=\"15\" style=\"padding: 10px 0 4px 0; margin: 0;\n                                 font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px;\n                                 font-weight: normal; text-align: center;\">has just been approved by {FirstName} {LastName}</td>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                            </tr>\n                            <tr>\n                                <td colspan = \"5\"  height=\"13\" style=\"padding: 0; margin: 0; background-color: #a3d8f0;\"></td>\n                            </tr>','approve_report'),(6,'{FirstName} disapproved your report #{ReportID}','{ApproverEmail}','<tr>\n                            <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                            <td colspan = \"3\"  height=\"36\" style=\"padding: 0; margin: 0;\">\n                                <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"512\" style=\"border-collapse: collapse;\n                                 mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto;\">\n                                    <tr>\n                                        <td colspan = \"2\" width = \"125\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"></td>\n                                        <td rowspan = \"2\" width = \"262\" height=\"25\" style=\"padding: 0; margin: 0;\n                                         font-family: \'HelveticaNeue UltraLight\', sans-serif; font-size: 24px; text-align: center;\n                                          vertical-align: middle;\"> Hi, <span>{OwnerFirstName}</span> </td>\n                                        <td colspan = \"2\" width = \"125\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"></td>\n                                    </tr>\n                                    <tr>\n                                        <td colspan = \"2\" width = \"125\" height=\"0\" valign=\"top\" style=\"padding: 6px 0; margin: 0; border-top: solid 1px #a3d8f0;\"></td>\n                                        <td colspan = \"2\" width = \"125\" height=\"0\" valign=\"top\" style=\"padding: 6px 0; margin: 0; border-top: solid 1px #a3d8f0;\"></td>\n                                    </tr>\n                                </table>\n                            </td>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                            </tr>\n                            <tr>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                                <td colspan = \"3\"  height=\"16\" style=\"padding: 19px 0 10px 0; margin: 0; font-family: \'HelveticaNeue Regular\',\n                                sans-serif; font-size: 16px; font-weight: normal; text-align: center;\">The report:\n                                {ReportDate} {ReportProject} -> {ReportText} - {ReportHours}h\n                                </td>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                            </tr>\n                            <tr>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                                <td colspan = \"3\"  height=\"15\" style=\"padding: 10px 0 4px 0; margin: 0;\n                                 font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px;\n                                 font-weight: normal; text-align: center;\">has just been disapproved by {FirstName} {LastName}</td>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                            </tr>\n                            <tr>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                                <td colspan = \"3\"  height=\"15\" style=\"padding: 10px 0 4px 0; margin: 0;\n                                 font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px;\n                                 font-weight: normal; text-align: center;\">If you are unsure about the reason of this disapproval please communicate to the manager</td>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                            </tr>\n                            <tr>\n                                <td colspan = \"5\"  height=\"13\" style=\"padding: 0; margin: 0; background-color: #a3d8f0;\"></td>\n                            </tr>','disapprove_report'),(8,'{SalesFirstName} created a new project','{SalesEmail}','<tr>\n                            <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                            <td colspan = \"3\"  height=\"36\" style=\"padding: 0; margin: 0;\">\n                                <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"512\" style=\"border-collapse: collapse;\n                                 mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto;\">\n                                    <tr>\n                                        <td colspan = \"2\" width = \"125\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"></td>\n                                        <td rowspan = \"2\" width = \"262\" height=\"25\" style=\"padding: 0; margin: 0;\n                                         font-family: \'HelveticaNeue UltraLight\', sans-serif; font-size: 24px; text-align: center;\n                                          vertical-align: middle;\"> Hi, <span>{AdminFirstName}</span> </td>\n                                        <td colspan = \"2\" width = \"125\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"></td>\n                                    </tr>\n                                    <tr>\n                                        <td colspan = \"2\" width = \"125\" height=\"0\" valign=\"top\" style=\"padding: 6px 0; margin: 0; border-top: solid 1px #a3d8f0;\"></td>\n                                        <td colspan = \"2\" width = \"125\" height=\"0\" valign=\"top\" style=\"padding: 6px 0; margin: 0; border-top: solid 1px #a3d8f0;\"></td>\n                                    </tr>\n                                </table>\n                            </td>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                            </tr>\n                            <tr>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                                <td colspan = \"3\"  height=\"16\" style=\"padding: 19px 0 10px 0; margin: 0; font-family: \'HelveticaNeue Regular\',\n                                sans-serif; font-size: 16px; font-weight: normal; text-align: center;\">\n                                {SalesFirstName} has created a new project: {ProjectName}\n                                </td>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                            </tr>\n                            <tr>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                                <td colspan = \"3\"  height=\"15\" style=\"padding: 10px 0 4px 0; margin: 0;\n                                 font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px;\n                                 font-weight: normal; text-align: center;\">Start Date: {ProjectDateStart}</td>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                            </tr>\n                            <tr>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                                <td colspan = \"3\"  height=\"15\" style=\"padding: 10px 0 4px 0; margin: 0;\n                                 font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px;\n                                 font-weight: normal; text-align: center;\">End Date: {ProjectDateEnd}</td>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                            </tr>\n                            <tr>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                                <td colspan = \"3\"  height=\"15\" style=\"padding: 10px 0 4px 0; margin: 0;\n                                 font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px;\n                                 font-weight: normal; text-align: center;\">Customers: {ProjectCustomers}</td>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                            </tr>\n                            <tr>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                                <td colspan = \"3\"  height=\"15\" style=\"padding: 10px 0 4px 0; margin: 0;\n                                 font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px;\n                                 font-weight: normal; text-align: center;\">Developers: {ProjectDevelopers}</td>\n                                <td width = \"29\" style=\"padding: 0; margin: 0;\"></td>\n                            </tr>\n                            <tr>\n                                <td colspan = \"5\"  height=\"13\" style=\"padding: 0; margin: 0; background-color: #a3d8f0;\"></td>\n                            </tr>','create_project');
/*!40000 ALTER TABLE email_templates ENABLE KEYS */;
DROP TABLE IF EXISTS emergencies;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE emergencies (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) DEFAULT NULL,
  date_registered int(11) DEFAULT NULL,
  summary text COLLATE utf8_bin,
  PRIMARY KEY (id),
  KEY fk_emergencies_users (user_id),
  CONSTRAINT fk_emergencies_users FOREIGN KEY (user_id) REFERENCES `users` (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE emergencies DISABLE KEYS */;
/*!40000 ALTER TABLE emergencies ENABLE KEYS */;
DROP TABLE IF EXISTS extensions;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE extensions (
  id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  repository varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('EXTENSION','THEME','LANGUAGE') COLLATE utf8_unicode_ci DEFAULT NULL,
  version varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  package varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE extensions DISABLE KEYS */;
/*!40000 ALTER TABLE extensions ENABLE KEYS */;
DROP TABLE IF EXISTS financial_income;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE financial_income (
  id int(11) NOT NULL AUTO_INCREMENT,
  `date` int(11) DEFAULT NULL,
  amount double DEFAULT NULL,
  description text,
  project_id int(11) DEFAULT NULL,
  added_by_user_id int(11) DEFAULT NULL,
  developer_user_id int(11) DEFAULT NULL,
  financial_report_id int(11) DEFAULT NULL,
  from_date int(11) DEFAULT NULL,
  to_date int(11) DEFAULT NULL,
  invoice_id int(11) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY fk_financial_income_users (added_by_user_id),
  KEY fk_financial_income_projects (project_id),
  KEY fk_financial_income_fin (financial_report_id),
  KEY `idx-financial_income-invoice_id` (invoice_id),
  CONSTRAINT `fk-financial_income-invoice_id` FOREIGN KEY (invoice_id) REFERENCES invoices (id) ON DELETE NO ACTION,
  CONSTRAINT fk_financial_income_fin FOREIGN KEY (financial_report_id) REFERENCES financial_reports (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_financial_income_projects FOREIGN KEY (project_id) REFERENCES projects (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_financial_income_users FOREIGN KEY (added_by_user_id) REFERENCES `users` (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE financial_income DISABLE KEYS */;
/*!40000 ALTER TABLE financial_income ENABLE KEYS */;
DROP TABLE IF EXISTS financial_reports;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE financial_reports (
  id int(11) NOT NULL AUTO_INCREMENT,
  report_date date DEFAULT NULL,
  currency double DEFAULT NULL,
  expense_constant text COLLATE utf8_unicode_ci,
  expense_salary double DEFAULT NULL,
  investments text COLLATE utf8_unicode_ci,
  is_locked int(11) DEFAULT '0',
  spent_corp_events text COLLATE utf8_unicode_ci,
  num_of_working_days int(11) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE financial_reports DISABLE KEYS */;
INSERT INTO financial_reports VALUES (1,'2018-01-10',NULL,NULL,NULL,NULL,0,NULL,NULL),(2,'2018-02-10',26.15,'[{\"amount\":\"4500\",\"description\":\"Office Rent\",\"date\":\"15\"},{\"amount\":\"800\",\"description\":\"Internet\",\"date\":\"20\"},{\"amount\":\"2800\",\"description\":\"Taxes\",\"date\":\"28\"}]',12000,'[{\"amount\":\"1800\",\"description\":\"PC + Other equipment\",\"date\":\"5\"}]',0,'[{\"amount\":\"100\",\"description\":\"Birthdays\",\"date\":\"10\"}]',23);
/*!40000 ALTER TABLE financial_reports ENABLE KEYS */;
DROP TABLE IF EXISTS financial_yearly_reports;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE financial_yearly_reports (
  id int(11) NOT NULL AUTO_INCREMENT,
  `year` int(11) DEFAULT NULL,
  income double DEFAULT NULL,
  expense_constant double DEFAULT NULL,
  investments double DEFAULT NULL,
  expense_salary double DEFAULT NULL,
  difference double DEFAULT NULL,
  bonuses double DEFAULT NULL,
  corp_events double DEFAULT NULL,
  profit double DEFAULT NULL,
  balance double DEFAULT NULL,
  spent_corp_events double DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE financial_yearly_reports DISABLE KEYS */;
/*!40000 ALTER TABLE financial_yearly_reports ENABLE KEYS */;
DROP TABLE IF EXISTS fixed_assets;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE fixed_assets (
  id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  cost float DEFAULT NULL,
  inventory_number int(11) DEFAULT NULL,
  amortization_method enum('LINEAR','50/50') COLLATE utf8_unicode_ci DEFAULT 'LINEAR',
  date_of_purchase date DEFAULT NULL,
  date_write_off date DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE fixed_assets DISABLE KEYS */;
/*!40000 ALTER TABLE fixed_assets ENABLE KEYS */;
DROP TABLE IF EXISTS fixed_assets_operations;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE fixed_assets_operations (
  fixed_asset_id int(11) NOT NULL,
  operation_id int(11) NOT NULL,
  operation_business_id int(11) NOT NULL,
  PRIMARY KEY (fixed_asset_id,operation_id,operation_business_id),
  KEY fk_fixed_assets_operations_operations1_idx (operation_id,operation_business_id),
  CONSTRAINT fk_fixed_assets_operations_fixed_assets1 FOREIGN KEY (fixed_asset_id) REFERENCES fixed_assets (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT fk_fixed_assets_operations_operations1 FOREIGN KEY (operation_id, operation_business_id) REFERENCES operations (id, business_id) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE fixed_assets_operations DISABLE KEYS */;
/*!40000 ALTER TABLE fixed_assets_operations ENABLE KEYS */;
DROP TABLE IF EXISTS invoice_templates;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE invoice_templates (
  id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  body text COLLATE utf8_unicode_ci,
  `variables` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE invoice_templates DISABLE KEYS */;
INSERT INTO invoice_templates VALUES (1,'invoicePDF','<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">\n<html lang=\"en\">\n<head>\n    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n\n    <title>&#9993;Skynix Invoice #{id}</title>\n    <style>\n        a,\n        a:hover,\n        a:active,\n        a:focus{\n            outline: 0;\n        }\n\n    </style>\n    <!--style=\"border: solid 1px red\"-->\n</head>\n<body style=\"background-color: #ffffff;\">\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"570\" style=\"border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;\">\n    <tr>\n        <td colspan = \"2\"  height=\"17\" width = \"570\" style=\"padding: 0; margin: 0; font-size: 10px\">\n            Page <b>1</b>\n        </td>\n    </tr>\n    <tr>\n        <td width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"></td>\n        <td width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"></td>\n    </tr>\n\n    <tr>\n        <td colspan = \"2\" width = \"570\"  valign=\"top\" style=\"padding: 0; margin: 0;\">\n            <a href=\"https://skynix.co\" title=\"logo Skynix\" target=\"_blank\">\n                <img src=\"{appAlias}/web/img/logo_skynix_color_horizontal.png\" alt=\"Skynix\" border=\"0\" width=\"105\" height=\"28\" style=\"display: block; padding: 0px; margin: 0px; border: none; background-color: white;\">\n            </a>\n        </td>\n    </tr>\n\n    <tr>\n        <td colspan = \"2\"  height=\"30\" width = \"570\" style=\"padding: 0; margin: 0;\"></td>\n    </tr>\n\n    <tr>\n        <td colspan = \"2\" width = \"570\" height=\"23\" valign=\"top\" style=\"padding: 0 0 23px 0; margin: 0; font-size: 23px; font-family: \"HelveticaNeue UltraLight\", sans-serif; font-weight: 600; text-align: center;\">\n            <span style=\"font-weight: 600;\">Invoice (offer) / Інвойс (оферта) # </span>{id}\n        </td>\n    </tr>\n\n    <tr>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Date: </span>{dateInvoiced}\n        </td>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Дата: </span>{dateInvoiced}\n        </td>\n    </tr>\n    <tr>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Supplier: </span>{supplierName} {supplierAddress} Represented by the Director, {supplierDirector}, who acts according to articles of organization\n        </td>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Виконавець: </span>{supplierNameUa} {supplierAddressUa} У особі директора {supplierDirectorUa}, діючої на підставі Статуту\n        </td>\n    </tr>\n    <tr>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Customer: </span>{customerCompany}, {customerAddress} Represented by the Director, {customerName}\n        </td>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Замовник: </span>{customerCompany}, {customerAddress} Represented by the Director, {customerName}\n        </td>\n    </tr>\n    <tr>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Subject matter: </span>Software Development\n        </td>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Предмет: </span>Розробка програмного забезпечення\n        </td>\n    </tr>\n    <tr>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Currency: </span>{currency}\n        </td>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Валюта: </span>{currency}\n        </td>\n    </tr>\n    <tr>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Price (amount) of the goods/services: </span>{priceTotal} {currency}\n        </td>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Ціна (загальна вартість) товарів/послуг: </span>{priceTotal} {currency}\n        </td>\n    </tr>\n    <tr>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Terms of payments and acceptation: </span>Postpayment of 100% upon the services delivery. The services being rendered at the location of the Supplier.\n        </td>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;\">\n            <span style=\"font-weight: 900;\">Умови оплати та передачі: </span>100% післяплата за фактом виконання послуг. Послуги надаються за місцем реєстрації Виконавця.\n        </td>\n    </tr>\n    <tr>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb; border-bottom: none;\">\n            <span style=\"font-weight: 900;\">SupplierBank information: </span>\n        </td>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb; border-bottom: none;\">\n            <span style=\"font-weight: 900;\">Реквізити Виконавця: </span>\n        </td>\n    </tr>\n    <tr>\n        <td width = \"285\" valign=\"top\" align=\"left\" style=\"padding: 0; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb; border-top: none;\">\n            {supplierBank}\n        </td>\n        <td width = \"285\" valign=\"top\" align=\"left\" style=\"padding: 0; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb; border-top: none;\">\n            {supplierBankUa}\n        </td>\n    </tr>\n    <tr>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb; border-bottom: none;\">\n            <span style=\"font-weight: 900;\">Customer Bank Information: </span>\n        </td>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb; border-bottom: none;\">\n            <span style=\"font-weight: 900;\">Реквізити Замовника: </span>\n        </td>\n    </tr>\n    <tr>\n        <td width = \"285\" valign=\"top\" align=\"left\" style=\"padding: 0; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb; border-top: none;\">\n            {customerBank}\n        </td>\n        <td width = \"285\" valign=\"top\" align=\"left\" style=\"padding: 0; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb; border-top: none;\">\n            {customerBankUa}\n        </td>\n    </tr>\n    <tr>\n        <td colspan = \"2\"  height=\"17\" width = \"570\" style=\"padding: 0; margin: 0;\">\n\n        </td>\n    </tr>\n</table>\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"570\" style=\"font-size: 12px; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;\">\n\n    <tr>\n        <td colspan = \"2\" width = \"570\" style=\"padding: 0; margin: 0;\">\n            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"570\" style=\"border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;\">\n                <tr>\n                    <td colspan = \"2\"  height=\"17\" width = \"570\" style=\"padding: 0; margin: 0; text-align: left; padding-bottom: 20px; font-size: 10px;\">\n                        Page <b>2</b>\n                    </td>\n                </tr>\n                <tr>\n                    <td width = \"48\" height=\"100\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb; font-style: italic;\">№</td>\n                    <td width = \"244\" height=\"100\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb; font-style: italic;\"><div>Descripion /</div><div>Опис</div></td>\n                    <td width = \"72\" height=\"100\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb; font-style: italic;\"><div>Quantity /</div><div>Кількість</div></td>\n                    <td width = \"105\" height=\"100\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb; font-style: italic;\"><div>Price,{currency} /</div><div>Ціна, {currency}</div></td>\n                    <td width = \"101\" height=\"100\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb; font-style: italic;\"><div>Amount, {currency} /</div><div>Загальна</div><div>вартість,</div><div>{currency}</div></td>\n                </tr>\n                <tr>\n                    <td height=\"17\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;\">1</td>\n                    <td height=\"17\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;\">\n                        Software Development from {dataFrom} to {dataTo}<br>\n                        /Розробка програмного забезпечення\n                        від {dataFromUkr} до {dataToUkr}\n                    </td>\n                    <td height=\"17\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;\">1</td>\n                    <td height=\"17\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;\">{priceTotal} {currency}</td>\n                    <td height=\"17\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;\">{priceTotal} {currency}</td>\n                </tr>\n                <tr>\n                    <td height=\"17\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;\"></td>\n                    <td height=\"17\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;\"></td>\n                    <td height=\"17\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;\"></td>\n                    <td height=\"17\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;\"><span style=\"font-weight: 900;\">Total/Усього: </span></td>\n                    <td height=\"17\" style=\"padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;\"><span style=\"font-weight: 900;\">{priceTotal}</span> {currency}</td>\n                </tr>\n            </table >\n        </td>\n    </tr>\n    <tr>\n        <td colspan = \"2\"  height=\"17\" width = \"570\" style=\"padding: 0; margin: 0; text-align: left\">\n\n        </td>\n    </tr>\n</table>\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"570\" style=\"font-size: 12px; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;\">\n    <tr>\n        <td width = \"285\" height=\"1\" style=\"padding: 0; margin: 0;\"></td>\n        <td width = \"285\" height=\"1\" style=\"padding: 0; margin: 0;\"></td>\n    </tr>\n    <tr>\n        <td colspan=\"2\" width = \"570\"  valign=\"top\" style=\"padding: 10px; margin: 0;\">\n            <a href=\"https://skynix.co\" title=\"logo Skynix\" target=\"_blank\">\n                <img src=\"{appAlias}/web/img/logo_skynix_color_horizontal.png\" alt=\"Skynix\" border=\"0\" width=\"105\" height=\"28\" style=\"display: block; padding: 0px; margin: 0px; border: none; background-color: white;\">\n            </a>\n        </td>\n    </tr>\n    <tr>\n        <td colspan = \"2\" width = \"570\" style=\"padding: 0; margin: 0;\">\n            All charges of correspondent banks are at the Customer’s expenses. / Усі комісії банків-кореспондентів сплачує Замовник.\n        </td>\n    </tr>\n\n    <tr>\n        <td colspan = \"2\" width = \"570\" style=\"padding: 0; margin: 0;\">\n            This Invoice is an offer to enter into the agreement. Payment according hereto shall be deemed as an acceptation of the offer to enter into the agreement on the terms and conditions set out herein.\n            Payment according hereto may be made not later than <span style=\"font-weight: 900;\">{dateToPay}</span>. / Цей Інвойс є пропозицією укласти договір.\n            Оплата за цим Інвойсом є прийняттям пропозиції укласти договір на умовах, викладених в цьому Інвойсі. Оплата за цим інвойсом може бути здійснена не пізніше <span style=\"font-weight: 900;\">{dateToPay}</span>.\n        </td>\n    </tr>\n    <tr>\n        <td colspan = \"2\" height=\"17\" width = \"570\" style=\"padding: 0; margin: 0;\">\n        </td>\n    </tr>\n    <tr>\n        <td colspan = \"2\" width = \"570\" style=\"padding: 0; margin: 0;\">\n            Please note, that payment according hereto at the same time is the evidence of the work performance and the service delivery in full scope, acceptation thereof and the confirmation of final mutual installments between\n            Parties. / Оплата згідно цього Інвойсу одночасно є свідченням виконання робіт та надання послуг в повному обсязі, їх прийняття, а також підтвердженням кінцевих розрахунків між Сторонами.\n        </td>\n    </tr>\n    <tr>\n        <td colspan = \"2\" height=\"17\" width = \"570\" style=\"padding: 0; margin: 0;\">\n        </td>\n    </tr>\n    <tr>\n        <td colspan = \"2\" width = \"570\" style=\"padding: 0; margin: 0;\">\n            Payment according hereto shall be also the confirmation that Parties have no claims to each other and have no intention to submit any claims. The agreement shall not include penalty and fine clauses. / Оплата згідно цього Інвойсу є підтвердженням того, що Сторони не мають взаємних претензій та не мають наміру направляти рекламації. Договір не передбачає штрафних санкцій.\n        </td>\n    </tr>\n    <tr>\n        <td colspan = \"2\" height=\"17\" width = \"570\" style=\"padding: 0; margin: 0;\">\n        </td>\n    </tr>\n    <tr>\n        <td colspan = \"2\" width = \"570\" style=\"padding: 0; margin: 0;\">\n            The Parties shall not be liable for non-performance or improper performance of the obligations under the agreement during the term of insuperable force circumstances. / Сторони звільняються від відповідальності за невиконання чи неналежне виконаннязобов’язань за договором на час дії форс-мажорних обставин.\n        </td>\n    </tr>\n    <tr>\n        <td colspan = \"2\" height=\"17\" width = \"570\" style=\"padding: 0; margin: 0;\">\n        </td>\n    </tr>\n    <tr>\n        <td colspan = \"2\" width = \"570\" style=\"padding: 0; margin: 0;\">\n            Any disputes arising out of the agreement between the Parties shall be settled by the competent court at the location of a defendant. / Всі спори, що виникнуть між Сторонами по договору будуть розглядатись компетентним судом за місцезнаходження відповідача.\n        </td>\n    </tr>\n    <tr>\n        <td colspan = \"2\" height=\"30\" width = \"570\" style=\"padding: 0; margin: 0;\">\n        </td>\n    </tr>\n    <tr>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left;\">\n            <span style=\"font-weight: 900;\">Supplier/Виконавець: </span>\n        </td>\n        <td width = \"285\" height=\"12\" valign=\"top\" style=\"padding: 4px 5px; margin: 0; font-size: 12px; font-family: \"HelveticaNeue Regular\", sans-serif; font-weight: normal; text-align: left;\">\n            <span style=\"font-weight: 900;\">Customer/Замовник: </span>\n        </td>\n    </tr>\n</table>\n\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"570\" style=\"border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;\">\n\n    <tr>\n        <td width=\"200\" height=\"17\" style=\"padding: 0; margin: 0;\"></td>\n        <td width=\"100\" height=\"17\" style=\"padding: 0; margin: 0;\"></td>\n        <td width=\"200\" height=\"17\" style=\"padding: 0; margin: 0;\"></td>\n        <td width=\"70\" height=\"17\" style=\"padding: 0; margin: 0;\"></td>\n    </tr>\n    <tr>\n        <td width = \"200\" valign=\"middle\" align=\"right\" style=\"padding: 0; margin: 0; vertical-align: middle;\">\n            <img src=\"{signatureContractor}\" alt=\"signatures contractor\" border=\"0\"  style=\"padding: 0px; margin: 0px; border: none; display: block; max-width: 120px; \">\n        </td>\n        <td width=\"100\" height=\"75\" style=\"padding: 0; margin: 0;\"></td>\n        <td width=\"200\" valign=\"middle\" align=\"right\" style=\"padding: 0; margin: 0;\">\n            <img src=\"{signatureCustomer}\" alt=\"signatures customer\" border=\"0\" style=\"padding: 0px; margin: 0px; border: none; display: block; max-width: 120px; \">\n        </td>\n        <td width = \"70\" style=\"padding: 0; margin: 0;\">\n        </td>\n    </tr>\n    <tr>\n        <td width=\"200\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0; border-bottom: solid 2px #343434;\"></td>\n        <td width=\"100\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"></td>\n        <td width=\"200\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0; border-bottom: solid 2px #343434;\"></td>\n        <td width=\"70\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"></td>\n    </tr>\n    <tr>\n        <td width=\"200\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"><div>{supplierDirector}</div><div>Director of {supplierName}</div></td>\n        <td width=\"100\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"></td>\n        <td width=\"200\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"><div>{customerName}</div><div>Director of {customerCompany}</div></td>\n        <td width=\"70\" height=\"12\" valign=\"top\" style=\"padding: 0; margin: 0;\"></td>\n    </tr>\n</table >\n</body>\n</html>\n','{id} - the invoice id\n{appAlias} - the link to application alias\n{dateInvoiced} - the date when was invoiced\n{supplierName} - the name of a supplier\n{supplierAddress} - the address of a supplier\n{supplierDirector} - the name of supplier director\n{supplierNameUa} - the name of supplier in Ukrainian\n{supplierAddressUa} - the address of a supplier in Ukrainian\n{supplierDirectorUa} - the name of supplier director in Ukrainian\n{customerCompany} - the name of a customer\'s company\n{customerAddress} - the address of a customer\n{customerName} - the customer name\n{currency} - the currency\n{priceTotal} - the total price\n{supplierBank} - the bank of a supplier\n{supplierBankUa} - the bank of a supplier in Ukrainian\n{customerBank} - the bank of a customer\n{customerBankUa} - the bank of a customer in Ukrainian\n{dataFrom} - the start data of software development \n{dataTo} - the end date of software development\n{dataFromUkr} - the start data of software development in Ukrainian\n{dataToUkr} - the end date of software development in Ukrainian\n{dateToPay} - the payment date\n{signatureContractor} - the signature of contractor\n{signatureCustomer} - the signature of customer');
/*!40000 ALTER TABLE invoice_templates ENABLE KEYS */;
DROP TABLE IF EXISTS invoices;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE invoices (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) DEFAULT NULL,
  subtotal double DEFAULT NULL,
  discount decimal(10,2) DEFAULT NULL,
  total double DEFAULT NULL,
  date_start date DEFAULT NULL,
  date_end date DEFAULT NULL,
  date_created date DEFAULT NULL,
  date_paid date DEFAULT NULL,
  date_sent date DEFAULT NULL,
  `status` enum('NEW','PAID','CANCELED') COLLATE utf8_unicode_ci DEFAULT 'NEW',
  note varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  total_hours double DEFAULT NULL,
  contract_number int(11) DEFAULT NULL,
  act_of_work int(11) DEFAULT NULL,
  is_delete tinyint(1) DEFAULT '0',
  project_id int(11) DEFAULT NULL,
  contract_id int(11) DEFAULT NULL,
  created_by int(11) DEFAULT NULL,
  currency varchar(5) COLLATE utf8_unicode_ci DEFAULT 'USD',
  invoice_id int(11) DEFAULT '0',
  payment_method_id int(11) DEFAULT NULL,
  is_withdrawn tinyint(1) DEFAULT '0',
  exchange_rate float DEFAULT NULL,
  PRIMARY KEY (id),
  KEY user_id (user_id),
  KEY `idx-invoice_contract` (contract_id),
  KEY `idx-invoices-created_by` (created_by),
  CONSTRAINT `fk-invoice_contract` FOREIGN KEY (contract_id) REFERENCES contracts (id) ON DELETE SET NULL,
  CONSTRAINT `fk-invoices-created_by` FOREIGN KEY (created_by) REFERENCES `users` (id)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE invoices DISABLE KEYS */;
INSERT INTO invoices VALUES (1,1,500,0.00,500,'2019-07-05','2019-07-16','2019-07-18',NULL,NULL,'NEW','some note',NULL,NULL,NULL,0,2,NULL,1,'USD',1,1,1,NULL),(2,1,500,0.00,500,'2019-07-05','2019-07-16','2019-07-18',NULL,NULL,'NEW','some note',NULL,NULL,NULL,0,2,NULL,1,'USD',2,1,0,NULL),(3,1,500,0.00,500,'2019-07-05','2019-07-16','2019-07-18',NULL,NULL,'NEW','some note',NULL,NULL,NULL,0,1,NULL,1,'USD',2,1,0,NULL),(4,1,500,0.00,500,'2019-07-05','2019-07-16','2019-07-18',NULL,NULL,'NEW','some note',NULL,NULL,NULL,0,1,NULL,1,'USD',2,1,0,NULL),(5,1,500,0.00,500,'2019-07-05','2019-07-16','2019-07-18',NULL,NULL,'NEW','some note',NULL,NULL,NULL,0,1,NULL,1,'USD',2,1,0,NULL);
/*!40000 ALTER TABLE invoices ENABLE KEYS */;
DROP TABLE IF EXISTS migration;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE migration (
  version varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  apply_time int(11) DEFAULT NULL,
  PRIMARY KEY (version)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE migration DISABLE KEYS */;
INSERT INTO migration VALUES ('m000000_000000_base',1455021189),('m160125_170036_alter_reports_hours',1455021190),('m160127_130244_users_role_add_fin',1455021190),('m160128_121751_users_add_invite_hash',1455021190),('m160128_144305_users_phone_is_null',1455021190),('m160201_104354_user_add_is_deleted',1455021190),('m160203_093008_projects_add_is_deleted',1455021190),('m160204_083656_projects_id_AUTO_INCREMENT',1455021190),('m160204_160915_projects_date_start_date_end_DATE',1455021190),('m160208_165328_reports_add_is_deleted',1455105861),('m160217_092401_invoices_add_note',1456088295),('m160219_101829_invoices_id_AUTO_INCREMENT',1456088759),('m160219_150941_invoices_date_to_DATE',1456167462),('m160219_155225_invoices_add_total_hours',1456167462),('m160226_113724_users_date_signup_date_login_date_salary_up_DATE',1456667132),('m160301_141851_create_table_paiment_methods',1457670979),('m160301_144739_invoices_add_contract_number_and_act_of_work',1457670979),('m160302_052720_gopa',1456896447),('m160302_101023_payment_methods_insert_bank_transfer',1457878959),('m160302_101913_payment_methods_description',1457878959),('m160302_103718_payment_methods_add_description',1457878959),('m160311_091242_payment_methods_update_description',1457878959),('m160316_103526_table_users_timestamp_data_signup_data_login',1458635908),('m160317_071410_usercontroller_date_login_and_date_signup_time',1458635913),('m160317_095404_create_table_teams_and_teammates',1458635913),('m160317_130740_invoices_add_is_delete',1458635913),('m160322_081059_add_key_table_users_and_teams',1458635913),('m160322_090400_fix_ref',1458637923),('m160322_101526_add_key_pk__teammates_and_add_key_table_users_team_teammates',1460101808),('m160414_082424_teammate_add_is_deleted',1460645711),('m160414_105046_teams_add_column_team_leader_id',1460645711),('m160504_151046_surveys',1462376708),('m160504_153333_survey_options',1462376708),('m160507_135846_add_is_delete_surveys',1462639507),('m160515_062903_survey_foraign_keys',1463305506),('m160515_081552_survey_voter_option_id',1463305507),('m160517_131145_add_column_photo_and_sign',1463558587),('m160526_111906_create_table_extensions',1464361748),('m160526_132832_rename_table_table_extensions',1464361748),('m160527_053653_table_support_tickets_support_ticket_comments',1464330426),('m160601_074725_add_key_support_users',1465222329),('m160606_100011_change_surveys_question',1465222329),('m160613_121331_add_column_date_cancelled_table_support_ticket',1465828389),('m160712_135515_api_auth_access_tokens',1485078314),('m160811_103916_add_column_table_invoice_paymet_method',1470919510),('m160829_125553_chenge_table_invoice_type',1472545370),('m160925_134505_create_table_projects_total_hours',1474813629),('m160929_185544_add_role_sales_table_users',1475223142),('m160929_193333_add_id_sales_table_project_developers',1475223143),('m161130_082130_project_id_column_in_invoice_table',1481187740),('m161201_091313_public_profile_key_in_users_table',1481187740),('m161202_142913_cost_column_in_project_table',1481187741),('m161220_132038_added',1482324313),('m161222_135151_new_table_contracts',1482751517),('m161226_153339_created_by_column_in_contracts_table',1483110011),('m170105_105052_new_column_in_table_invoice',1483713012),('m170107_074133_invoice_contract',1483780375),('m170111_123813_contract_templates_table_create',1484139613),('m170112_092909_contract_template_id_column_in_Contracts_table',1484225112),('m170112_100123_new_column_contract_payment_method_id_in_contracts_table',1484225113),('m170112_125354_new_columns_bank_account_enUa_in_users_table',1484231116),('m170121_110057_insert_in_contractr_template',1485181513),('m170121_132013_insert_in_payment_methods',1485181513),('m170126_113509_modified_insert_in_CONTRACT_TEMPLATE_and_PAYMENT_METHODS',1485523817),('m170130_130822_updated_payment_method_deleted_sign_from_template',1485791718),('m170201_134821_update_contract_template',1486030511),('m170202_135748_update_contract_template_simply_edits',1486049417),('m170203_104959_update_contract_template__deleted_border_bottom',1486124277),('m170213_133256_new_table_contact_form',1488385608),('m170216_164829_alter_table_contract_total',1488385609),('m170220_091553_added_created_by_column_in_invoices_table',1488385610),('m170301_170626_ON_DELETE_action_for_invoices_when_delete_related_contract',1491914106),('m170316_141047_alter_contact_table_encoding',1491914107),('m170404_081923_users_add_password_reset_token',1491914107),('m170404_140151_users_remove_not_null_for_invite_hash',1491914108),('m170405_133928_create_table_careers',1491914108),('m170405_134435_create_table_candidates',1491914108),('m170419_091723_add_columns_users_table',1493203693),('m170419_093831_add_columns_projects_table',1493203693),('m170419_095059_create_work_history_table',1493203693),('m170426_080723_add_slug_column_to_users',1493216253),('m170721_083953_create_financial_reports_table',1500630570),('m170721_142534_rename_report_date_column',1500896273),('m170801_112518_add_spent_corp_events_col_to_finreport',1502459546),('m170802_113430_add_column_is_locked_tofinrep_table',1501857273),('m170804_063417_create_financial_yearly_reports_tab',1501856127),('m170823_091142_create_salary_reports_tab',1503654146),('m170823_092953_create_salary_report_lists_tab',1503654147),('m170825_081149_add_num_of_working_days_column_to_financial_reports_table',1503906695),('m170825_104725_add_foreign_keys_for_salary_report_lists',1504074562),('m170825_105204_add_official_salary_column_to_users_table',1504023126),('m170829_063540_change_type_of_actually_worked_out_salary',1504271483),('m170914_080452_change_type_of_columns_in_fin_yearly_report',1505482675),('m171019_065952_create_settings_table',1508406015),('m171019_070303_insert_into_settings_corpevents_and_bonuses',1508406015),('m171102_112931_add_is_approved_reports',1509950629),('m171103_072238_create_report_actions_tbl',1509968236),('m171107_065613_create_counterparties_table',1510052164),('m171107_152204_create_busineses_table',1510131527),('m171108_104332_create_operation_types_table',1510237937),('m171108_120214_create_reference_book_tbl',1510237022),('m171109_093535_alter_column_id_in_operations',1510846528),('m171109_093636_create_transactions_table',1510846528),('m171109_132006_alter_column_id_in_transactions',1510846528),('m171109_135702_alter_column_code_in_reference_book',1510846528),('m171219_141221_create_access_keys_table',1514380777),('m180118_094617_create_auth_types_table',1517472938),('m180118_094629_add_column_authtype_to_users',1517472938),('m180302_085003_add_new_columns_to_businesses_tbl',1520927210),('m180302_091459_add_modify_columns_of_invoices_table',1520927210),('m180321_095840_projects_total_approved_hours',1521654364),('m180328_100625_create_fixed_assets_tbl',1522306458),('m180328_111012_create_fixed_assets_operations_tbl',1522306458),('m180328_130334_not_required_fields_in_transactions',1522318925),('m180329_163123_operation_type_amortization',1522936839),('m180405_124521_add_is_avaialble_to_users',1522937326),('m180405_125642_create_availability_logs_tbl',1522937326),('m180415_063408_emergencies',1523789495),('m180418_111016_add_is_deleted_col_to_operations_tbl',1524143348),('m180418_152343_add_new_operation_types',1524132416),('m180426_133721_create_delayed_salary_tbl',1524756412),('m180427_080045_alter_table_delayed_salary',1524823336),('m180427_080046_labor_expenses_ratio',1525616583),('m180606_144521_incoice_id',1528296404),('m180606_160830_business_ua_information',1528373454),('m180607_101217_user_address',1528373454),('m180607_183036_salary_list_vacations',1528397514),('m180607_195455_financial_income',1528401621),('m180607_205300_financial_income_migration',1528452136),('m180611_170241_work_history_dates',1528737246),('m180626_095445_add_from_to_dates_for_income',1530008233),('m180626_185114_refactor_crowd_token',1530047003),('m180627_075434_sso_settings',1530089903),('m180629_093330_add_guest_role',1530269959),('m180705_022523_work_history_postedby',1530783688),('m180705_023535_create_system_user',1530783688),('m180714_072024_project_type',1531666457),('m180802_111639_refactor_payment_methods_database',1533649038),('m180804_114438_only_approved_hours',1533389995),('m180804_125259_salary_report_non_approved_hours',1533389995),('m180810_125648_payment_methods_set_business_id',1533912267),('m180821_132253_business_add_is_deleted_field',1534860647),('m180821_133517_business_set_is_default',1534860647),('m180822_092951_create_email_templates_table',1534948042),('m180822_122257_refactor_all_emails_sent_by_system',1535009663),('m180823_082338_create_invoice_template_table',1535015245),('m180823_093706_refactor_invoice_pdf_template',1535029811),('m180917_071155_convert_fin_report_date',1537169247),('m180925_101326_add_invoice_increment_id',1538885710),('m180927_153514_add_invoice_template_vars',1538885710),('m181006_125826_is_system_user',1538885710),('m181008_103502_add_reviews_table',1540378797),('m181008_133324_project_debts',1539023093),('m181031_152433_correct_project_status_canceled',1541170417),('m181102_144946_increase_crowd_token_length',1541170417),('m181105_193840_core_clients',1541659757),('m181105_194841_core_client_orders',1541659757),('m181105_195338_core_client_keys',1541659757),('m181105_195543_core_first_client',1541659757),('m181108_064311_client_access_keys_setting',1541659757),('m181113_132958_core_orders_modifications',1546548428),('m190103_203015_change_salary_report_date',1546548878),('m190116_104519_vacation_history_items_table',1547639228),('m190116_113012_add_vacation_days_column_to_users_table',1547639229),('m190116_114852_add_vacation_days_available_column_to_users_table',1547639409),('m190116_115814_vacation_days_setting',1547640053),('m190116_121849_update_value_vacation_days',1547647694),('m190208_160053_alter_email_templates',1549642628),('m190304_100421_add_total_employees_column_to_salary_reports_table',1551694296),('m190305_065705_alter_approve_report_email_template',1551775698),('m190305_093107_alter_approve_report_email_template',1551778355),('m190305_104247_alter_disapprove_report_email_template',1551783020),('m190305_112930_alter_disapprove_report_email_template',1551785443),('m190312_130437_create_project_email_template',1552396096),('m190702_073755_add_api_key_column_to_projects_table',1562241012),('m190702_073842_create_project_environments_table',1562241012),('m190703_100845_create_project_environment_variables_table',1562241012),('m190703_102632_add_encryption_key_setting',1562241012),('m190711_070602_create_monitoring_services_table',1562933699),('m190711_070623_create_monitoring_service_queue_table',1562933700),('m190712_111401_change_results_column_to_mediumtext',1562933700),('m190717_100923_add_is_withdrawn_column_to_invoices_table',1563365556),('m190717_124158_add_invoice_id_column_to_financial_income_table',1563437106),('m190814_144954_add_exchange_rate_column_to_invoices_table',1566983406);
/*!40000 ALTER TABLE migration ENABLE KEYS */;
DROP TABLE IF EXISTS milestones;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE milestones (
  id int(11) NOT NULL AUTO_INCREMENT,
  project_id int(11) DEFAULT NULL,
  `name` text,
  `status` enum('NEW','CLOSED') DEFAULT NULL,
  estimated_amount int(11) DEFAULT NULL,
  start_date date DEFAULT NULL,
  end_date date DEFAULT NULL,
  closed_date date DEFAULT NULL,
  PRIMARY KEY (id),
  KEY fk_milestones_projects (project_id),
  CONSTRAINT fk_milestones_projects FOREIGN KEY (project_id) REFERENCES projects (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE milestones DISABLE KEYS */;
/*!40000 ALTER TABLE milestones ENABLE KEYS */;
DROP TABLE IF EXISTS monitoring_service_queue;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE monitoring_service_queue (
  id int(11) NOT NULL AUTO_INCREMENT,
  service_id int(11) DEFAULT NULL,
  `status` enum('new','in progress','completed','failed') DEFAULT NULL,
  results mediumtext,
  PRIMARY KEY (id),
  KEY `fk-monitoring_service_queue-service_id` (service_id),
  CONSTRAINT `fk-monitoring_service_queue-service_id` FOREIGN KEY (service_id) REFERENCES monitoring_services (id) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE monitoring_service_queue DISABLE KEYS */;
INSERT INTO monitoring_service_queue VALUES (1,1,'new',NULL),(2,1,'new',NULL),(3,1,'new',NULL),(4,1,'new',NULL),(5,1,'new',NULL),(6,1,'new',NULL),(7,1,'new',NULL),(8,1,'new',NULL),(9,1,'new',NULL),(10,1,'new',NULL),(11,1,'new',NULL),(12,1,'new',NULL),(13,1,'new',NULL),(14,1,'new',NULL),(15,1,'new',NULL);
/*!40000 ALTER TABLE monitoring_service_queue ENABLE KEYS */;
DROP TABLE IF EXISTS monitoring_services;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE monitoring_services (
  id int(11) NOT NULL AUTO_INCREMENT,
  project_id int(11) DEFAULT NULL,
  url varchar(250) DEFAULT NULL,
  is_enabled tinyint(1) DEFAULT '1',
  `status` enum('new','ready','failed') DEFAULT NULL,
  notification_emails varchar(250) DEFAULT NULL,
  notification_sent_date datetime DEFAULT NULL,
  PRIMARY KEY (id),
  KEY `idx-monitoring_services-project_id` (project_id),
  KEY `idx-monitoring_service_queue-service_id` (project_id),
  CONSTRAINT `fk-monitoring_services-project_id` FOREIGN KEY (project_id) REFERENCES projects (id) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE monitoring_services DISABLE KEYS */;
INSERT INTO monitoring_services VALUES (1,2,'http://skynix.co',1,'new','test@gmail.com',NULL);
/*!40000 ALTER TABLE monitoring_services ENABLE KEYS */;
DROP TABLE IF EXISTS monthly_reports;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE monthly_reports (
  id int(11) NOT NULL,
  date_created timestamp NULL DEFAULT NULL,
  date_reported date DEFAULT NULL,
  user_id int(11) NOT NULL COMMENT 'Accountant ID (Who creates reports)',
  income decimal(10,2) DEFAULT '0.00',
  salary decimal(10,2) DEFAULT NULL,
  rent decimal(10,2) DEFAULT NULL,
  tax decimal(10,2) DEFAULT NULL,
  extra_outcome decimal(10,2) DEFAULT NULL,
  profit decimal(10,2) DEFAULT NULL COMMENT 'profit=income - salary - rent - tax - extra_outcome',
  `status` enum('NEW','CONFIRMED') COLLATE utf8_unicode_ci DEFAULT 'NEW',
  note text COLLATE utf8_unicode_ci,
  PRIMARY KEY (id),
  KEY fk_monthly_reports_users1_idx (user_id),
  CONSTRAINT fk_monthly_reports_users1 FOREIGN KEY (user_id) REFERENCES `users` (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE monthly_reports DISABLE KEYS */;
/*!40000 ALTER TABLE monthly_reports ENABLE KEYS */;
DROP TABLE IF EXISTS operation_types;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE operation_types (
  id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE operation_types DISABLE KEYS */;
INSERT INTO operation_types VALUES (1,'Bank Operations'),(2,'Currency Operations'),(3,'Taxes'),(4,'Salary Taxes'),(5,'Statutory fund\r\n'),(6,'Acquisition of fixed assets'),(7,'Calculation of Salaries'),(8,'Amortization'),(9,'Implementation of services'),(10,'Receipt of goods (services)');
/*!40000 ALTER TABLE operation_types ENABLE KEYS */;
DROP TABLE IF EXISTS operations;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE operations (
  id int(11) NOT NULL AUTO_INCREMENT,
  business_id int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('DONE','CANCELED') COLLATE utf8_unicode_ci DEFAULT NULL,
  date_created int(11) DEFAULT NULL,
  date_updated int(11) DEFAULT NULL,
  operation_type_id int(11) NOT NULL,
  is_deleted tinyint(3) DEFAULT '0',
  PRIMARY KEY (id,business_id),
  KEY fk_operations_busineses1_idx (business_id),
  KEY fk_operations_operation_types1_idx (operation_type_id),
  CONSTRAINT fk_operations_busineses1 FOREIGN KEY (business_id) REFERENCES busineses (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT fk_operations_operation_types1 FOREIGN KEY (operation_type_id) REFERENCES operation_types (id) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE operations DISABLE KEYS */;
/*!40000 ALTER TABLE operations ENABLE KEYS */;
DROP TABLE IF EXISTS payment_methods;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE payment_methods (
  id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  name_alt varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  address varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  address_alt varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  represented_by varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  represented_by_alt varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  bank_information text COLLATE utf8_unicode_ci,
  bank_information_alt text COLLATE utf8_unicode_ci,
  is_default tinyint(1) DEFAULT NULL,
  business_id int(11) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY business_id (business_id),
  CONSTRAINT business_id FOREIGN KEY (business_id) REFERENCES busineses (id)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE payment_methods DISABLE KEYS */;
INSERT INTO payment_methods VALUES (1,'Skynix LLC','ТОВ Скайнікс','6 Bohdana Khmelnytskogo Blvd, Apt. 132, Bucha, Kyiv obl., 08292, UKRAINE','бул. Богдана Хмельницького 6, кв.132, м Буча, Київська обл., 08292, Україна','Krystyna\r\nAntypova','Антипової Кристини Миколаївни','<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"282\" style=\"border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;\">\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Beneficiary:  </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">KYNIX” LLC</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Account # :</td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">26007056216480</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"><span>Beneficiary\'s bank: </span>SC CB \"PRIVATBANK\" 1D HRUSHEVSKOHO STR., KYIV, 01001, UKRAINE</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">SWIFT code: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">BANUA2X</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\">IBAN Code:</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\">UA393802690000026007056216480</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"></td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"> <span style=\"font-weight: 900; text-decoration: underline;\">Correspondent bank #1: </span></td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\">JP Morgan Chase Bank, New York, USA</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Account No.: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">001-1-000080</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">SWIFT code: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">CHASUS33</td>\r\n                </tr>\r\n            </table >','<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"282\" style=\"border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;\">\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Бенефіциар: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">ТОВ \"СКАЙНІКС\"</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Account # :</td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">26007056216480</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"><span>Банк бенефіциара: </span>ПАТ КБ «ПРИВАТБАНК», вул. Грушевського 1Д, Київ, 01001, Україна</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">SWIFT код :</td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">PBANUA2X</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\">IBAN код: </td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\">UA393802690000026007056216480</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"></td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"> <span style=\"font-weight: 900; text-decoration: underline;\">Банк-корреспондент #1: </span></td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\">JP Morgan Chase Bank, New York, USA</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Account No.: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">001-1-000080</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">SWIFT code: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">CHASUS33</td>\r\n                </tr>\r\n            </table >',NULL,1),(2,'Synpass LLC','ТОВ Синпас','6 Bohdana Khmelnytskogo Blvd, Apt. 132, Bucha, Kyiv obl., 08292, UKRAINE','бул. Богдана Хмельницького 6, кв.132, м Буча, Київська обл., 08292, Україна','Krystyna\r\nAntypova','Антипової Кристини Миколаївни','<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"282\" style=\"border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;\">\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Beneficiary:  </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">KYNIX” LLC</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Account # :</td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">26007056216480</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"><span>Beneficiary\'s bank: </span>SC CB \"PRIVATBANK\" 1D HRUSHEVSKOHO STR., KYIV, 01001, UKRAINE</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">SWIFT code: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">BANUA2X</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\">IBAN Code:</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\">UA393802690000026007056216480</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"></td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"> <span style=\"font-weight: 900; text-decoration: underline;\">Correspondent bank #1: </span></td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\">JP Morgan Chase Bank, New York, USA</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Account No.: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">001-1-000080</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">SWIFT code: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">CHASUS33</td>\r\n                </tr>\r\n            </table >','<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"282\" style=\"border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;\">\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Бенефіциар: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">ТОВ \"СКАЙНІКС\"</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Account # :</td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">26007056216480</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"><span>Банк бенефіциара: </span>ПАТ КБ «ПРИВАТБАНК», вул. Грушевського 1Д, Київ, 01001, Україна</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">SWIFT код :</td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">PBANUA2X</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\">IBAN код: </td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\">UA393802690000026007056216480</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"></td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"> <span style=\"font-weight: 900; text-decoration: underline;\">Банк-корреспондент #1: </span></td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\">JP Morgan Chase Bank, New York, USA</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Account No.: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">001-1-000080</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">SWIFT code: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">CHASUS33</td>\r\n                </tr>\r\n            </table >',NULL,2);
/*!40000 ALTER TABLE payment_methods ENABLE KEYS */;
DROP TABLE IF EXISTS project_customers;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE project_customers (
  user_id int(11) NOT NULL,
  project_id int(11) NOT NULL,
  receive_invoices tinyint(1) DEFAULT '0',
  PRIMARY KEY (user_id,project_id),
  KEY fk_project_customers_projects1_idx (project_id),
  CONSTRAINT fk_project_customers_projects1 FOREIGN KEY (project_id) REFERENCES projects (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT fk_project_customers_users1 FOREIGN KEY (user_id) REFERENCES `users` (id) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE project_customers DISABLE KEYS */;
INSERT INTO project_customers VALUES (4,1,1),(4,2,1);
/*!40000 ALTER TABLE project_customers ENABLE KEYS */;
DROP TABLE IF EXISTS project_debts;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE project_debts (
  id int(11) NOT NULL AUTO_INCREMENT,
  project_id int(11) DEFAULT NULL,
  amount int(11) DEFAULT NULL,
  financial_report_id int(11) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY fk_project_debts_financial_reports (financial_report_id),
  KEY fk_project_debts_projects (project_id),
  CONSTRAINT fk_project_debts_financial_reports FOREIGN KEY (financial_report_id) REFERENCES financial_reports (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_project_debts_projects FOREIGN KEY (project_id) REFERENCES projects (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE project_debts DISABLE KEYS */;
/*!40000 ALTER TABLE project_debts ENABLE KEYS */;
DROP TABLE IF EXISTS project_developers;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE project_developers (
  user_id int(11) NOT NULL,
  project_id int(11) NOT NULL,
  alias_user_id int(11) DEFAULT NULL,
  is_pm tinyint(1) DEFAULT '0',
  `status` enum('ACTIVE','INACTIVE','HIDDEN') COLLATE utf8_unicode_ci DEFAULT 'ACTIVE',
  is_sales tinyint(1) DEFAULT '0',
  PRIMARY KEY (user_id,project_id),
  KEY fk_project_developers_projects1_idx (project_id),
  CONSTRAINT fk_project_developers_projects1 FOREIGN KEY (project_id) REFERENCES projects (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT fk_project_developers_users FOREIGN KEY (user_id) REFERENCES `users` (id) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE project_developers DISABLE KEYS */;
INSERT INTO project_developers VALUES (1,1,NULL,0,'ACTIVE',0),(1,2,NULL,0,'ACTIVE',0),(2,2,NULL,0,'ACTIVE',0),(3,1,NULL,0,'ACTIVE',0),(3,2,NULL,0,'ACTIVE',0),(5,1,NULL,0,'ACTIVE',1),(5,2,NULL,0,'ACTIVE',1),(6,1,NULL,1,'ACTIVE',0),(6,2,NULL,1,'ACTIVE',0),(6,4,NULL,0,'ACTIVE',0);
/*!40000 ALTER TABLE project_developers ENABLE KEYS */;
DROP TABLE IF EXISTS project_environment_variables;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE project_environment_variables (
  id int(11) NOT NULL AUTO_INCREMENT,
  project_environment_id int(11) DEFAULT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (id),
  KEY `idx-project_environment_variables-project_environment_id` (project_environment_id),
  CONSTRAINT `fk-project_environment_variables-project_environment_id` FOREIGN KEY (project_environment_id) REFERENCES project_environments (id) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE project_environment_variables DISABLE KEYS */;
INSERT INTO project_environment_variables VALUES (1,1,'test','czu9lRu7F23PY+0IZjJI9g=='),(2,2,'test','czu9lRu7F23PY+0IZjJI9g=='),(3,1,'test variable','czu9lRu7F23PY+0IZjJI9g=='),(4,2,'test variable','czu9lRu7F23PY+0IZjJI9g=='),(5,1,'test variable2','czu9lRu7F23PY+0IZjJI9g=='),(6,1,'test variable3','czu9lRu7F23PY+0IZjJI9g=='),(7,1,'test variable4','czu9lRu7F23PY+0IZjJI9g=='),(8,1,'test variable5','czu9lRu7F23PY+0IZjJI9g=='),(9,1,'test variable6','czu9lRu7F23PY+0IZjJI9g=='),(10,2,'test variable2','czu9lRu7F23PY+0IZjJI9g=='),(11,2,'test variable3','czu9lRu7F23PY+0IZjJI9g=='),(12,2,'test variable4','czu9lRu7F23PY+0IZjJI9g=='),(13,2,'test variable5','czu9lRu7F23PY+0IZjJI9g=='),(14,2,'test variable6','czu9lRu7F23PY+0IZjJI9g=='),(15,2,'test variable7','czu9lRu7F23PY+0IZjJI9g==');
/*!40000 ALTER TABLE project_environment_variables ENABLE KEYS */;
DROP TABLE IF EXISTS project_environments;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE project_environments (
  id int(11) NOT NULL AUTO_INCREMENT,
  project_id int(11) DEFAULT NULL,
  branch varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  access_roles varchar(25) COLLATE utf8_unicode_ci DEFAULT 'ADMIN, SALES, PM',
  last_updated datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY `idx-project_environments-project_id` (project_id),
  CONSTRAINT `fk-project_environments-project_id` FOREIGN KEY (project_id) REFERENCES projects (id) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE project_environments DISABLE KEYS */;
INSERT INTO project_environments VALUES (1,2,'master','FIN, ADMIN, CLIENT','2019-07-08 13:18:04'),(2,2,'staging','DEV, PM, SALES','2019-07-10 17:33:59');
/*!40000 ALTER TABLE project_environments ENABLE KEYS */;
DROP TABLE IF EXISTS projects;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE projects (
  id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  jira_code varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  total_logged_hours double DEFAULT NULL,
  total_paid_hours double DEFAULT NULL,
  `status` enum('NEW','ONHOLD','INPROGRESS','DONE','CANCELLED') COLLATE utf8_unicode_ci DEFAULT 'NEW',
  date_start date DEFAULT NULL,
  date_end date DEFAULT NULL,
  is_delete tinyint(1) DEFAULT '0',
  cost decimal(10,2) DEFAULT '0.00',
  description text COLLATE utf8_unicode_ci,
  photo varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  is_published tinyint(1) DEFAULT '0',
  total_approved_hours int(11) DEFAULT NULL,
  `type` enum('HOURLY','FIXED_PRICE') COLLATE utf8_unicode_ci DEFAULT 'HOURLY',
  api_key varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE projects DISABLE KEYS */;
INSERT INTO projects VALUES (1,'Magento 2 Enterprise Edition - Theme Development','M2EET',1218,1200,'INPROGRESS','2018-05-01',NULL,0,3192.84,NULL,NULL,0,0,'HOURLY',NULL),(2,'Internal (Non Paid) Tasks',NULL,10105,120,'INPROGRESS','2016-04-04',NULL,0,34839.28,NULL,NULL,0,0,'HOURLY','gz0dAtV6pzojiDhrzF6xN1DVmCrFuPXa'),(4,'New test project','M3EET',1232,1000,'INPROGRESS','2019-08-30',NULL,0,3100.55,NULL,NULL,0,0,'HOURLY',NULL);
/*!40000 ALTER TABLE projects ENABLE KEYS */;
DROP TABLE IF EXISTS reference_book;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE reference_book (
  id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=331 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE reference_book DISABLE KEYS */;
INSERT INTO reference_book VALUES (1,'Основні засоби ','10'),(2,'Земельні ділянки ','101'),(3,'Капітальні витрати на поліпшення земель ','102'),(4,'Будинки та споруди ','103'),(5,'Машини та обладнання ','104'),(6,'Транспортні засоби ','105'),(7,'Інструменти, прилади та інвентар ','106'),(8,'Робоча і продуктивна худоба ','107'),(9,'Багаторічні насадження ','108'),(10,'Інші основні засоби ','109'),(11,'Інші необоротні матеріальні активи ','11'),(12,'Бібліотечні фонди ','111'),(13,'Малоцінні необоротні матеріальні активи ','112'),(14,'Тимчасові (нетитульні) споруди ','113'),(15,'Природні ресурси ','114'),(16,'Інвентарна тара ','115'),(17,'Предмети прокату ','116'),(18,'Інші необоротні матеріальні активи ','117'),(19,'Нематеріальні активи ','12'),(20,'Права користування природними ресурсами ','121'),(21,'Права користування майном ','122'),(22,'Права на знаки для товарів і послуг ','123'),(23,'Права на об\'єкти промислової власності ','124'),(24,'Авторські та суміжні з ними права ','125'),(25,'Інші нематеріальні активи ','127'),(26,'Знос (амортизація) необоротних активів ','13'),(27,'Знос основних засобів ','131'),(28,'Знос інших необоротних матеріальних активів ','132'),(29,'Накопичена амортизація нематеріальних активів ','133'),(30,'Довгострокові фінансові інвестиції ','14'),(31,'Інвестиції пов\'язаним сторонам за методом обліку участі в капіталі ','141'),(32,'Інші інвестиції пов\'язаним сторонам ','142'),(33,'Інвестиції непов\'язаним сторонам ','143'),(34,'Капітальні інвестиції ','15'),(35,'Капітальне будівництво ','151'),(36,'Придбання (виготовлення) основних засобів ','152'),(37,'Придбання (виготовлення) інших необоротних матеріальних активів ','153'),(38,'Придбання (створення) нематеріальних активів ','154'),(39,'Формування основного стада ','155'),(40,'Довгострокова дебіторська заборгованість ','16'),(41,'Заборгованість за майно, що передано у фінансову оренду ','161'),(42,'Довгострокові векселі одержані ','162'),(43,'Інша дебіторська заборгованість ','163'),(44,'Відстрочені податкові активи ','17'),(45,'Інші необоротні активи ','18'),(46,'Гудвіл при придбанні ','19'),(47,'Гудвіл ','191'),(48,'Негативний гудвіл ','192'),(49,'Виробничі запаси ','20'),(50,'Сировина й матеріали ','201'),(51,'Купівельні напівфабрикати та комплектуючі вироби ','202'),(52,'Паливо ','203'),(53,'Тара й тарні матеріали ','204'),(54,'Будівельні матеріали ','205'),(55,'Матеріали, передані в переробку ','206'),(56,'Запасні частини ','207'),(57,'Матеріали сільськогосподарського призначення ','208'),(58,'Інші матеріали ','209'),(59,'Тварини на вирощуванні та відгодівлі ','21'),(60,'Молодняк тварин на вирощуванні ','211'),(61,'Тварини на відгодівлі ','212'),(62,'Птиця ','213'),(63,'Звірі ','214'),(64,'Кролі ','215'),(65,'Сім\'ї бджіл ','216'),(66,'Доросла худоба, що вибракувана з основного стада ','217'),(67,'Худоба, що прийнята від населення для реалізації ','218'),(68,'Малоцінні та швидкозношувані предмети ','22'),(69,'Виробництво ','23'),(70,'Брак у виробництві ','24'),(71,'Напівфабрикати ','25'),(72,'Готова продукція ','26'),(73,'Продукція сільськогосподарського виробництва','27'),(74,'Товари ','28'),(75,'Товари на складі ','281'),(76,'Товари в торгівлі ','282'),(77,'Товари на комісії ','283'),(78,'Тара під товарами ','284'),(79,'Торгова націнка ','285'),(80,'Каса ','30'),(81,'Каса в національній валюті ','301'),(82,'Каса в іноземній валюті ','302'),(83,'Рахунки в банках ','31'),(84,'Поточні рахунки в національній валюті ','311'),(85,'Поточні рахунки в іноземній валюті ','312'),(86,'Інші рахунки в банку в національній валюті ','313'),(87,'Інші рахунки в банку в іноземній валюті ','314'),(88,'Інші кошти ','33'),(89,'Грошові документи в національній валюті ','331'),(90,'Грошові документи в іноземній валюті ','332'),(91,'Грошові кошти в дорозі в національній валюті ','333'),(92,'Грошові кошти в дорозі в іноземній валюті ','334'),(93,'Короткострокові векселі одержані ','34'),(94,'Короткострокові векселі, одержані в національній валюті ','341'),(95,'Короткострокові векселі, одержані в іноземній валюті ','342'),(96,'Поточні фінансові інвестиції ','35'),(97,'Еквіваленти грошових коштів ','351'),(98,'Інші поточні фінансові інвестиції ','352'),(99,'Розрахунки з покупцями та замовниками ','36'),(100,'Розрахунки з вітчизняними покупцями ','361'),(101,'Розрахунки з іноземними покупцями ','362'),(102,'Розрахунки з учасниками ПФГ ','363'),(103,'Розрахунки з різними дебіторами ','37'),(104,'Розрахунки за виданими авансами ','371'),(105,'Розрахунки з підзвітними особами ','372'),(106,'Розрахунки за нарахованими доходами ','373'),(107,'Розрахунки за претензіями ','374'),(108,'Розрахунки за відшкодуванням завданих збитків ','375'),(109,'Розрахунки за позиками членам кредитних спілок ','376'),(110,'Розрахунки з іншими дебіторами ','377'),(111,'Резерв сумнівних боргів ','38'),(112,'Витрати майбутніх періодів ','39'),(113,'Статутний капітал ','40'),(114,'Пайовий капітал ','41'),(115,'Додатковий капітал ','42'),(116,'Емісійний дохід ','421'),(117,'Інший вкладений капітал ','422'),(118,'Дооцінка активів ','423'),(119,'Безоплатно одержані необоротні активи ','424'),(120,'Інший додатковий капітал ','425'),(121,'Резервний капітал ','43'),(122,'Нерозподілені прибутки (непокриті збитки) ','44'),(123,'Прибуток нерозподілений ','441'),(124,'Непокриті збитки ','442'),(125,'Прибуток, використаний у звітному періоді ','443'),(126,'Вилучений капітал ','45'),(127,'Вилучені акції ','451'),(128,'Вилучені вклади й паї ','452'),(129,'Інший вилучений капітал ','453'),(130,'Неоплачений капітал ','46'),(131,'Забезпечення майбутніх витрат і платежів ','47'),(132,'Забезпечення виплат відпусток ','471'),(133,'Додаткове пенсійне забезпечення ','472'),(134,'Забезпечення гарантійних зобов\'язань ','473'),(135,'Забезпечення інших витрат і платежів ','474'),(136,'Цільове фінансування і цільові надходження ','48'),(137,'Страхові резерви ','49'),(138,'Технічні резерви ','491'),(139,'Резерви із страхування життя ','492'),(140,'Частка перестраховиків у технічних резервах ','493'),(141,'Частка перестраховиків у резервах із страхування життя ','494'),(142,'Результат зміни технічних резервів ','495'),(143,'Результат зміни резервів із страхування життя ','496'),(144,'Результат зміни резервів незароблених премій ','497'),(145,'Результат зміни резервів збитків ','498'),(146,'Довгострокові позики ','50'),(147,'Довгострокові кредити банків у національній валюті ','501'),(148,'Довгострокові кредити банків в іноземній валюті ','502'),(149,'Відстрочені довгострокові кредити банків у національній валюті ','503'),(150,'Відстрочені довгострокові кредити банків в іноземній валюті ','504'),(151,'Інші довгострокові позики в національній валюті ','505'),(152,'Інші довгострокові позики в іноземній валюті ','506'),(153,'Довгострокові векселі видані ','51'),(154,'Довгострокові векселі, видані в національній валюті ','511'),(155,'Довгострокові векселі, видані в іноземній валюті ','512'),(156,'Довгострокові зобов\'язання за облігаціями ','52'),(157,'Зобов\'язання за облігаціями ','521'),(158,'Премія за випущеними облігаціями ','522'),(159,'Дисконт за випущеними облігаціями ','523'),(160,'Довгострокові зобов\'язання з оренди ','53'),(161,'Зобов\'язання з фінансової оренди ','531'),(162,'Зобов\'язання з оренди цілісних майнових комплексів ','532'),(163,'Відстрочені податкові зобов\'язання ','54'),(164,'Інші довгострокові зобов\'язання ','55'),(165,'Короткострокові позики ','60'),(166,'Короткострокові кредити банків у національній валюті ','601'),(167,'Короткострокові кредити банків в іноземній валюті ','602'),(168,'Відстрочені короткострокові кредити банків у національній валюті ','603'),(169,'Відстрочені короткострокові кредити банків в іноземній валюті ','604'),(170,'Прострочені позики в національній валюті ','605'),(171,'Прострочені позики в іноземній валюті ','606'),(172,'Поточна заборгованість за довгостроковими зобов\'язаннями ','61'),(173,'Поточна заборгованість за довгостроковими зобов\'язаннями в національній валюті ','611'),(174,'Поточна заборгованість за довгостроковими зобов\'язаннями в іноземній валюті ','612'),(175,'Короткострокові векселі видані ','62'),(176,'Короткострокові векселі, видані в національній валюті ','621'),(177,'Короткострокові векселі, видані в іноземній валюті ','622'),(178,'Розрахунки з постачальниками та підрядниками','63'),(179,'Розрахунки з вітчизняними постачальниками ','631'),(180,'Розрахунки з іноземними постачальниками ','632'),(181,'Розрахунки з учасниками ПФГ ','633'),(182,'Розрахунки за податками й платежами ','64'),(183,'Розрахунки за податками ','641'),(184,'Розрахунки за обов\'язковими платежами ','642'),(185,'Податкові зобов\'язання ','643'),(186,'Податковий кредит ','644'),(187,'Розрахунки за страхування ','65'),(188,'За пенсійним забезпеченням ','651'),(189,'За соціальним страхуванням ','652'),(190,'За страхуванням на випадок безробіття ','653'),(191,'За індивідуальним страхуванням ','654'),(192,'За страхуванням майна ','655'),(193,'Розрахунки з оплати праці ','66'),(194,'Розрахунки за заробітною платою ','661'),(195,'Розрахунки з депонентами ','662'),(196,'Розрахунки з учасниками ','67'),(197,'Розрахунки за нарахованими дивідендами ','671'),(198,'Розрахунки за іншими виплатами ','672'),(199,'Розрахунки за іншими операціями ','68'),(200,'Розрахунки за авансами одержаними ','681'),(201,'Внутрішні розрахунки ','682'),(202,'Внутрішньогосподарські розрахунки ','683'),(203,'Розрахунки за нарахованими відсотками ','684'),(204,'Розрахунки з іншими кредиторами ','685'),(205,'Доходи майбутніх періодів ','69'),(206,'Доходи від реалізації ','70'),(207,'Дохід від реалізації готової продукції ','701'),(208,'Дохід від реалізації товарів ','702'),(209,'Дохід від реалізації робіт і послуг ','703'),(210,'Вирахування з доходу ','704'),(211,'Перестрахування ','705'),(212,'Інший операційний дохід ','71'),(213,'Дохід від реалізації іноземної валюти ','711'),(214,'Дохід від реалізації інших оборотних активів ','712'),(215,'Дохід від операційної оренди активів ','713'),(216,'Дохід від операційної курсової різниці ','714'),(217,'Одержані штрафи, пені, неустойки ','715'),(218,'Відшкодування раніше списаних активів ','716'),(219,'Дохід від списання кредиторської заборгованості ','717'),(220,'Дохід від безоплатно одержаних оборотних активів ','718'),(221,'Інші доходи від операційної діяльності ','719'),(222,'Дохід від участі в капіталі ','72'),(223,'Дохід від інвестицій в асоційовані підприємства ','721'),(224,'Дохід від спільної діяльності ','722'),(225,'Дохід від інвестицій в дочірні підприємства ','723'),(226,'Інші фінансові доходи ','73'),(227,'Дивіденди одержані ','731'),(228,'Відсотки одержані ','732'),(229,'Інші доходи від фінансових операцій ','733'),(230,'Інші доходи ','74'),(231,'Дохід від реалізації фінансових інвестицій ','741'),(232,'Дохід від реалізації необоротних активів ','742'),(233,'Дохід від реалізації майнових комплексів ','743'),(234,'Дохід від неопераційної курсової різниці ','744'),(235,'Дохід від безоплатно одержаних активів ','745'),(236,'Інші доходи від звичайної діяльності ','746'),(237,'Надзвичайні доходи ','75'),(238,'Відшкодування збитків від надзвичайних подій ','751'),(239,'Інші надзвичайні доходи ','752'),(240,'Страхові платежі ','76'),(241,'Фінансові результати ','79'),(242,'Результат операційної діяльності ','791'),(243,'Результат фінансових операцій ','792'),(244,'Результат іншої звичайної діяльності ','793'),(245,'Результат надзвичайних подій ','794'),(246,'Матеріальні витрати ','80'),(247,'Витрати сировини й матеріалів ','801'),(248,'Витрати купівельних напівфабрикатів та комплектуючих виробів ','802'),(249,'Витрати палива й енергії ','803'),(250,'Витрати тари й тарних матеріалів ','804'),(251,'Витрати будівельних матеріалів ','805'),(252,'Витрати запасних частин ','806'),(253,'Витрати матеріалів сільськогосподарського призначення ','807'),(254,'Витрати товарів ','808'),(255,'Інші матеріальні витрати ','809'),(256,'Витрати на оплату праці ','81'),(257,'Виплати за окладами й тарифами ','811'),(258,'Премії та заохочення ','812'),(259,'Компенсаційні виплати ','813'),(260,'Оплата відпусток ','814'),(261,'Оплата іншого невідпрацьованого часу ','815'),(262,'Інші витрати на оплату праці ','816'),(263,'Відрахування на соціальні заходи ','82'),(264,'Відрахування на пенсійне забезпечення ','821'),(265,'Відрахування на соціальне страхування ','822'),(266,'Страхування на випадок безробіття ','823'),(267,'Відрахування на індивідуальне страхування ','824'),(268,'Амортизація ','83'),(269,'Амортизація основних засобів ','831'),(270,'Амортизація інших необоротних матеріальних активів ','832'),(271,'Амортизація нематеріальних активів ','833'),(272,'Інші операційні витрати ','84'),(273,'Інші затрати ','85'),(274,'Собівартість реалізації ','90'),(275,'Собівартість реалізованої готової продукції ','901'),(276,'Собівартість реалізованих товарів ','902'),(277,'Собівартість реалізованих робіт і послуг ','903'),(278,'Страхові виплати ','904'),(279,'Загальновиробничі витрати ','91'),(280,'Адміністративні витрати ','92'),(281,'Витрати на збут ','93'),(282,'Інші витрати операційної діяльності ','94'),(283,'Витрати на дослідження і розробки ','941'),(284,'Собівартість реалізованої іноземної валюти ','942'),(285,'Собівартість реалізованих виробничих запасів ','943'),(286,'Сумнівні та безнадійні борги ','944'),(287,'Втрати від операційної курсової різниці ','945'),(288,'Втрати від знецінення запасів ','946'),(289,'Нестачі і втрати від псування цінностей ','947'),(290,'Визнані штрафи, пені, неустойки ','948'),(291,'Інші витрати операційної діяльності ','949'),(292,'Фінансові витрати ','95'),(293,'Відсотки за кредит ','951'),(294,'Інші фінансові витрати ','952'),(295,'Втрати від участі в капіталі ','96'),(296,'Втрати від інвестицій в асоційовані підприємства ','961'),(297,'Втрати від спільної діяльності ','962'),(298,'Втрати від інвестицій в дочірні підприємства ','963'),(299,'Інші витрати ','97'),(300,'Собівартість реалізованих фінансових інвестицій ','971'),(301,'Собівартість реалізованих необоротних активів ','972'),(302,'Собівартість реалізованих майнових комплексів ','973'),(303,'Втрати від неопераційних курсових різниць ','974'),(304,'Уцінка необоротних активів і фінансових інвестицій ','975'),(305,'Списання необоротних активів ','976'),(306,'Інші витрати звичайної діяльності ','977'),(307,'Податок на прибуток ','98'),(308,'Податок на прибуток від звичайної діяльності ','981'),(309,'Податок на прибуток від надзвичайних подій ','982'),(310,'Надзвичайні витрати ','99'),(311,'Втрати від стихійного лиха ','991'),(312,'Втрати від техногенних катастроф і аварій ','992'),(313,'Інші надзвичайні витрати ','993'),(314,'Орендовані необоротні активи ','1'),(315,'Активи на відповідальному зберіганні ','2'),(316,'Устаткування, прийняте для монтажу ','21'),(317,'Матеріали, прийняті для переробки ','22'),(318,'Матеріальні цінності на відповідальному зберіганні ','23'),(319,'Товари, прийняті на комісію ','24'),(320,'Майно в довірчому управлінні ','25'),(321,'Контрактні зобов\'язання ','3'),(322,'Непередбачені активи й зобов\'язання ','4'),(323,'Непередбачені активи ','41'),(324,'Непередбачені зобов\'язання ','42'),(325,'Гарантії та забезпечення надані ','5'),(326,'Гарантії та забезпечення отримані ','6'),(327,'Списані активи ','7'),(328,'Списана дебіторська заборгованість ','71'),(329,'Невідшкодовані нестачі і втрати від псування цінностей ','72'),(330,'Бланки суворого обліку ','8');
/*!40000 ALTER TABLE reference_book ENABLE KEYS */;
DROP TABLE IF EXISTS report_actions;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE report_actions (
  id int(11) NOT NULL AUTO_INCREMENT,
  report_id int(11) DEFAULT NULL,
  user_id int(11) DEFAULT NULL,
  `action` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datetime` int(11) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE report_actions DISABLE KEYS */;
/*!40000 ALTER TABLE report_actions ENABLE KEYS */;
DROP TABLE IF EXISTS reports;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE reports (
  id int(11) NOT NULL AUTO_INCREMENT,
  project_id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  invoice_id int(11) DEFAULT NULL,
  reporter_name varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  hours double DEFAULT NULL,
  task varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  date_added date DEFAULT NULL,
  date_paid date DEFAULT NULL,
  date_report date DEFAULT NULL,
  `status` enum('NEW','INVOICED','DELETED','PAID','WONTPAID') COLLATE utf8_unicode_ci DEFAULT 'NEW',
  is_working_day tinyint(1) DEFAULT NULL,
  is_delete tinyint(1) DEFAULT '0',
  cost decimal(10,2) DEFAULT '0.00',
  is_approved tinyint(1) DEFAULT '0',
  PRIMARY KEY (id),
  KEY fk_reports_projects1_idx (project_id),
  KEY fk_reports_users1_idx (user_id),
  KEY fk_reports_invoices1_idx (invoice_id),
  CONSTRAINT fk_reports_invoices1 FOREIGN KEY (invoice_id) REFERENCES invoices (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT fk_reports_projects1 FOREIGN KEY (project_id) REFERENCES projects (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT fk_reports_users1 FOREIGN KEY (user_id) REFERENCES `users` (id) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE reports DISABLE KEYS */;
INSERT INTO reports VALUES (2,2,3,2,'Wess Wilson',5,'task description','2019-07-18',NULL,'2019-07-08','INVOICED',1,0,100.00,1),(3,2,3,2,'Wess Wilson',5,'some task description','2019-07-18',NULL,'2019-07-16','INVOICED',NULL,0,89.29,1),(4,2,2,2,'Vess Jonson',5,'some task description','2019-07-18',NULL,'2019-07-15','INVOICED',NULL,0,89.29,1),(5,2,2,2,'Vess Jonson',5,'some task description','2019-07-18',NULL,'2019-07-14','INVOICED',NULL,0,89.29,1),(6,2,10,2,'Wess Wilson',7,'some task description','2019-07-18',NULL,'2019-07-13','INVOICED',NULL,0,125.00,1),(7,2,10,2,'Wess Wilson',7,'some task description','2019-07-18',NULL,'2019-07-12','INVOICED',NULL,0,125.00,1),(8,2,1,2,'John Doe',7,'some task description','2019-07-18',NULL,'2019-07-11','INVOICED',NULL,0,125.00,1),(9,2,1,2,'John Doe',7,'some task description','2019-07-18',NULL,'2019-07-10','INVOICED',NULL,0,125.00,1),(10,2,1,2,'John Doe',8,'some task description','2019-07-18',NULL,'2019-07-09','INVOICED',NULL,0,142.86,0),(12,4,6,2,'Gary Madison',NULL,'some task description','2019-07-18',NULL,'2019-07-09','INVOICED',NULL,0,142.86,1);
/*!40000 ALTER TABLE reports ENABLE KEYS */;
DROP TABLE IF EXISTS reviews;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE reviews (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) DEFAULT NULL,
  date_from date DEFAULT NULL,
  date_to date DEFAULT NULL,
  score_loyalty int(11) DEFAULT '0',
  score_performance int(11) DEFAULT '0',
  score_earnings int(11) DEFAULT '0',
  score_total int(11) DEFAULT '0',
  notes text COLLATE utf8_unicode_ci,
  PRIMARY KEY (id),
  KEY fk_user_id (user_id),
  CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES `users` (id) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE reviews DISABLE KEYS */;
INSERT INTO reviews VALUES (1,1,'2018-11-01','2018-11-30',90,90,80,83,'Note'),(2,3,'2018-11-01','2018-11-30',50,80,80,76,NULL),(3,2,'2018-11-01','2018-11-30',60,80,90,78,NULL),(4,6,'2018-11-01','2018-11-30',100,90,100,99,NULL),(5,5,'2018-11-01','2018-11-30',100,90,90,98,NULL);
/*!40000 ALTER TABLE reviews ENABLE KEYS */;
DROP TABLE IF EXISTS salary_history;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE salary_history (
  id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  amount decimal(10,2) DEFAULT NULL,
  extra_amount decimal(10,2) DEFAULT NULL,
  note text COLLATE utf8_unicode_ci,
  PRIMARY KEY (id),
  KEY fk_salary_history_users1_idx (user_id),
  CONSTRAINT fk_salary_history_users1 FOREIGN KEY (user_id) REFERENCES `users` (id) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE salary_history DISABLE KEYS */;
/*!40000 ALTER TABLE salary_history ENABLE KEYS */;
DROP TABLE IF EXISTS salary_report_lists;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE salary_report_lists (
  id int(11) NOT NULL AUTO_INCREMENT,
  salary_report_id int(11) DEFAULT NULL,
  user_id int(11) DEFAULT NULL,
  salary int(11) DEFAULT NULL,
  worked_days int(11) DEFAULT NULL,
  actually_worked_out_salary double DEFAULT NULL,
  official_salary double DEFAULT NULL,
  hospital_days int(11) DEFAULT NULL,
  hospital_value double DEFAULT NULL,
  bonuses double DEFAULT NULL,
  day_off int(11) DEFAULT NULL,
  overtime_days int(11) DEFAULT NULL,
  overtime_value double DEFAULT NULL,
  other_surcharges double DEFAULT NULL,
  subtotal double DEFAULT NULL,
  currency_rate double DEFAULT NULL,
  subtotal_uah double DEFAULT NULL,
  total_to_pay double DEFAULT NULL,
  vacation_days int(11) DEFAULT NULL,
  vacation_value double DEFAULT NULL,
  non_approved_hours int(11) DEFAULT '0',
  PRIMARY KEY (id),
  KEY `idx-salary_report_lists-user_id` (user_id),
  KEY `idx-salary_report_lists-salary_report_id` (salary_report_id),
  CONSTRAINT `fk-salary_report_lists-salary_report_id` FOREIGN KEY (salary_report_id) REFERENCES salary_reports (id) ON DELETE CASCADE,
  CONSTRAINT `fk-salary_report_lists-user_id` FOREIGN KEY (user_id) REFERENCES `users` (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE salary_report_lists DISABLE KEYS */;
/*!40000 ALTER TABLE salary_report_lists ENABLE KEYS */;
DROP TABLE IF EXISTS salary_reports;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE salary_reports (
  id int(11) NOT NULL AUTO_INCREMENT,
  report_date date DEFAULT NULL,
  total_salary double DEFAULT NULL,
  official_salary double DEFAULT NULL,
  bonuses double DEFAULT NULL,
  hospital double DEFAULT NULL,
  day_off double DEFAULT NULL,
  overtime double DEFAULT NULL,
  other_surcharges double DEFAULT NULL,
  subtotal double DEFAULT NULL,
  currency_rate double DEFAULT NULL,
  total_to_pay double DEFAULT NULL,
  number_of_working_days int(11) DEFAULT NULL,
  total_employees int(11) DEFAULT '0',
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE salary_reports DISABLE KEYS */;
INSERT INTO salary_reports VALUES (1,'2018-02-28',10000,9000,10,10,0,0,0,9000,27,1200,21,0);
/*!40000 ALTER TABLE salary_reports ENABLE KEYS */;
DROP TABLE IF EXISTS settings;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE settings (
  id int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('INT','STRING') COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE settings DISABLE KEYS */;
INSERT INTO settings VALUES (1,'corp_events_percentage','15','INT'),(2,'bonuses_percentage','10','INT'),(3,'LABOR_EXPENSES_RATIO','20','INT'),(4,'SSO_COOKIE_COMAIN_NAME','crowd.token_key','STRING'),(5,'client_id','1','INT'),(6,'access_key','XbqNXlRzSNG6n6cURGjo1-VC5Q7PTNYRLmoONut7-RGBz','STRING'),(7,'vacation_days','10','INT'),(8,'vacation_days_upgrade_years','3','INT'),(9,'vacation_days_upgraded','21','INT'),(10,'encryption_key','$2y$10$Sb7ffeuTQ4i59a.F/qq6qOrIId3FPO/PZRD3hjZfDYiU8Fr0LUC1m','STRING');
/*!40000 ALTER TABLE settings ENABLE KEYS */;
DROP TABLE IF EXISTS support_ticket_comments;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE support_ticket_comments (
  id int(11) NOT NULL AUTO_INCREMENT,
  `comment` text COLLATE utf8_unicode_ci,
  date_added datetime DEFAULT NULL,
  user_id int(11) DEFAULT NULL,
  support_ticket_id int(11) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE support_ticket_comments DISABLE KEYS */;
/*!40000 ALTER TABLE support_ticket_comments ENABLE KEYS */;
DROP TABLE IF EXISTS support_tickets;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE support_tickets (
  id int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  description text COLLATE utf8_unicode_ci,
  is_private tinyint(1) DEFAULT '0',
  assignet_to int(11) DEFAULT NULL,
  `status` enum('NEW','ASSIGNED','COMPLETED','CANCELLED') COLLATE utf8_unicode_ci DEFAULT NULL,
  client_id int(11) DEFAULT NULL,
  date_added datetime DEFAULT NULL,
  date_completed datetime DEFAULT NULL,
  date_cancelled datetime DEFAULT NULL,
  PRIMARY KEY (id),
  KEY fk_support_tickets_users (client_id),
  CONSTRAINT fk_support_tickets_users FOREIGN KEY (client_id) REFERENCES `users` (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE support_tickets DISABLE KEYS */;
/*!40000 ALTER TABLE support_tickets ENABLE KEYS */;
DROP TABLE IF EXISTS survey_voters;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE survey_voters (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) DEFAULT NULL,
  ip varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  ua_hash varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  survey_id int(11) DEFAULT NULL,
  option_id int(11) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY fk_survey_voters_users (user_id),
  KEY fk_survey_voters_surveys (survey_id),
  KEY fk_survey_voters_surveys_options (option_id),
  CONSTRAINT fk_survey_voters_surveys FOREIGN KEY (survey_id) REFERENCES surveys (id),
  CONSTRAINT fk_survey_voters_surveys_options FOREIGN KEY (option_id) REFERENCES surveys_options (id),
  CONSTRAINT fk_survey_voters_users FOREIGN KEY (user_id) REFERENCES `users` (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE survey_voters DISABLE KEYS */;
/*!40000 ALTER TABLE survey_voters ENABLE KEYS */;
DROP TABLE IF EXISTS surveys;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE surveys (
  id int(11) NOT NULL AUTO_INCREMENT,
  shortcode varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  question varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  description text COLLATE utf8_unicode_ci,
  date_start datetime DEFAULT NULL,
  date_end datetime DEFAULT NULL,
  is_private tinyint(1) DEFAULT NULL,
  user_id int(11) DEFAULT NULL,
  total_votes int(11) DEFAULT NULL,
  is_delete tinyint(1) DEFAULT '0',
  PRIMARY KEY (id),
  KEY fk_surveys_users (user_id),
  CONSTRAINT fk_surveys_users FOREIGN KEY (user_id) REFERENCES `users` (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE surveys DISABLE KEYS */;
/*!40000 ALTER TABLE surveys ENABLE KEYS */;
DROP TABLE IF EXISTS surveys_options;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE surveys_options (
  id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  description text COLLATE utf8_unicode_ci,
  survey_id int(11) DEFAULT NULL,
  votes int(11) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY fk_surveys_options_users (survey_id),
  CONSTRAINT fk_surveys_options_users FOREIGN KEY (survey_id) REFERENCES surveys (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE surveys_options DISABLE KEYS */;
/*!40000 ALTER TABLE surveys_options ENABLE KEYS */;
DROP TABLE IF EXISTS teammates;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE teammates (
  team_id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  testcol varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  is_deleted tinyint(1) DEFAULT '0',
  PRIMARY KEY (user_id,team_id),
  KEY teammates_team_id (team_id),
  CONSTRAINT teammates_team_id FOREIGN KEY (team_id) REFERENCES teams (id),
  CONSTRAINT teammates_users_id FOREIGN KEY (user_id) REFERENCES `users` (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE teammates DISABLE KEYS */;
/*!40000 ALTER TABLE teammates ENABLE KEYS */;
DROP TABLE IF EXISTS teams;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE teams (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  date_created date DEFAULT NULL,
  is_deleted tinyint(1) NOT NULL,
  team_leader_id int(11) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY teams_users_id (user_id),
  CONSTRAINT teams_users_id FOREIGN KEY (user_id) REFERENCES `users` (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE teams DISABLE KEYS */;
/*!40000 ALTER TABLE teams ENABLE KEYS */;
DROP TABLE IF EXISTS transactions;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE transactions (
  id int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('DEBIT','CREDIT') COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  amount decimal(15,2) DEFAULT NULL,
  currency enum('USD','UAH') COLLATE utf8_unicode_ci DEFAULT NULL,
  reference_book_id int(11) NOT NULL,
  counterparty_id int(11) DEFAULT NULL,
  operation_id int(11) NOT NULL,
  operation_business_id int(11) NOT NULL,
  PRIMARY KEY (id,operation_id,operation_business_id),
  KEY fk_transactions_reference_book_idx (reference_book_id),
  KEY fk_transactions_counterparties1_idx (counterparty_id),
  KEY fk_transactions_operations1_idx (operation_id,operation_business_id),
  CONSTRAINT fk_transactions_counterparties1 FOREIGN KEY (counterparty_id) REFERENCES counterparties (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT fk_transactions_operations1 FOREIGN KEY (operation_id, operation_business_id) REFERENCES operations (id, business_id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT fk_transactions_reference_book FOREIGN KEY (reference_book_id) REFERENCES reference_book (id) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE transactions DISABLE KEYS */;
/*!40000 ALTER TABLE transactions ENABLE KEYS */;
DROP TABLE IF EXISTS users;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE users (
  id int(11) NOT NULL AUTO_INCREMENT,
  role enum('ADMIN','PM','DEV','CLIENT','FIN','SALES','GUEST') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'DEV',
  phone varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  email varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  first_name varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  last_name varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  middle_name varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  company varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  tags varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  about varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  date_signup timestamp NULL DEFAULT NULL,
  date_login timestamp NULL DEFAULT NULL,
  date_salary_up date DEFAULT NULL,
  is_active tinyint(1) DEFAULT '1',
  salary int(11) DEFAULT '0',
  official_salary double DEFAULT NULL,
  month_logged_hours int(11) DEFAULT '0',
  year_logged_hours int(11) DEFAULT '0',
  total_logged_hours int(11) DEFAULT '0',
  month_paid_hours int(11) DEFAULT '0',
  year_paid_hours int(11) DEFAULT '0',
  total_paid_hours int(11) DEFAULT '0',
  invite_hash varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  is_delete tinyint(1) DEFAULT '0',
  photo varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  sing varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  public_profile_key varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  bank_account_en text COLLATE utf8_unicode_ci,
  bank_account_ua text COLLATE utf8_unicode_ci,
  password_reset_token varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  languages varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  position varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  birthday timestamp NULL DEFAULT NULL,
  experience_year int(11) DEFAULT '0',
  degree varchar(255) COLLATE utf8_unicode_ci DEFAULT 'No Degree',
  residence varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  link_linkedin varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  link_video varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  is_published tinyint(1) DEFAULT '0',
  slug varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  auth_type int(11) DEFAULT '1',
  is_available tinyint(1) DEFAULT NULL,
  address varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  pay_only_approved_hours int(1) DEFAULT '0',
  is_system tinyint(1) DEFAULT '0',
  vacation_days int(11) DEFAULT '0',
  vacation_days_available int(11) DEFAULT '0',
  PRIMARY KEY (id),
  UNIQUE KEY password_reset_token (password_reset_token),
  KEY fk_users_auth_type (auth_type),
  CONSTRAINT fk_users_auth_type FOREIGN KEY (auth_type) REFERENCES auth_types (id) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE users DISABLE KEYS */;
INSERT INTO users VALUES (1,'ADMIN','+380 (066) 304-32-01','crm-admin@skynix.co','2de2b770e4c198bb413550d031d0ca52','John','Doe',NULL,'Skynix Ltd','PHP, JAVA, DevOps, System Architect, System Administrator ',NULL,'2017-03-07 00:00:00','2019-02-08 04:02:56',NULL,1,3000,15000,168,2016,8670,168,2015,8340,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'CEO','1981-01-03 00:00:00',0,'Mater',NULL,NULL,NULL,0,'crm-admin',2,NULL,NULL,0,0,10,0),(2,'FIN','+38 (044) 434-55-64','crm-fin@skynix.co','8384386dd789da8c222fa9d3b1b3e435','Vess','Jonson',NULL,'Skynix Ltd',NULL,NULL,'2018-12-03 00:00:00',NULL,NULL,1,1000,8000,130,1200,4500,130,1200,4300,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'No Degree',NULL,NULL,NULL,0,NULL,2,NULL,NULL,0,0,10,0),(3,'DEV','+380 (050) 403-33-01','crm-dev@skynix.co','9ef7f207f0853694610afdad81ebe5ec','Wess','Wilson',NULL,'Skynix Ltd',NULL,NULL,'2019-01-15 00:00:00',NULL,NULL,1,1800,25000,0,0,0,0,0,0,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'No Degree',NULL,NULL,NULL,0,NULL,2,NULL,NULL,0,0,9,0),(4,'CLIENT','+380 (043) 323-33-44','crm-client@skynix.co','3c2997aaf9841e37d96e639ca17a6f94','Eli','Ho',NULL,'Skynix Ltd',NULL,NULL,'2016-09-06 00:00:00',NULL,NULL,1,800,6000,0,0,0,0,0,0,NULL,0,NULL,NULL,NULL,'<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"282\" style=\"border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;\">\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Beneficiary:  </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Colourways Limited</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Account # :</td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">5096104</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"><span>Beneficiary\'s bank: </span>Barclays Bank,Barclays, 745 7th Avenue,New York, NY 10019, United States</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"></td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Sort cod: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">20-20-37</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">SWIFT code: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">BARCGB2</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">IBAN code: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">GB98BARC2020375096104</td>\r\n                </tr>\r\n            </table >','<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"282\" style=\"border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;\">\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Beneficiary: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Colourways Limited</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Account # :</td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">50961043</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"><span>Beneficiary\'s bank: </span>Barclays Bank,Barclays, 745 7th Avenue,New York, NY 10019, United States</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"></td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Sort cod: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">20-20-37</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">SWIFT code: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">BARCGB2</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">IBAN code: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">GB98BARC2020375096104</td>\r\n                </tr>\r\n\r\n\r\n            </table >',NULL,NULL,NULL,NULL,0,'No Degree',NULL,NULL,NULL,0,NULL,2,NULL,NULL,0,0,21,0),(5,'SALES','+38 (066) 434-44-33','crm-sales@skynix.co','a22744b22823e056902271e60a41d530','Terry','Brown',NULL,'Skynix Ltd',NULL,NULL,NULL,'2019-03-12 15:08:34',NULL,1,3500,35000,0,0,0,0,0,0,NULL,0,NULL,'Sign-clean-128.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'No Degree',NULL,NULL,NULL,0,NULL,2,NULL,NULL,0,0,0,0),(6,'PM','+38 (322) 232-33-21','crm-pm@skynix.co','6e3369cd7e96ca11e7d7a78fccaa661f','Gary','Madison',NULL,'Skynix Ltd',NULL,NULL,NULL,NULL,NULL,1,1900,3200,0,0,0,0,0,0,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'No Degree',NULL,NULL,NULL,0,NULL,2,NULL,NULL,0,0,0,0),(7,'GUEST',NULL,'apps@skynix.co','','SKYNIX','SYSTEM',NULL,'Skynix LLC',NULL,NULL,NULL,NULL,NULL,0,0,NULL,0,0,0,0,0,0,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'No Degree',NULL,NULL,NULL,0,NULL,2,NULL,NULL,0,0,0,0),(8,'CLIENT','+380 (043) 323-33-55','crm-client2@skynix.co','3c2997aaf9841e37d96e639ca17a6f94','Eli','Ho',NULL,'Skynix Ltd',NULL,NULL,'2016-09-06 00:00:00',NULL,NULL,1,800,6000,0,0,0,0,0,0,NULL,0,NULL,NULL,NULL,'<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"282\" style=\"border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;\">\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Beneficiary:  </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Colourways Limited</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Account # :</td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">5096104</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"><span>Beneficiary\'s bank: </span>Barclays Bank,Barclays, 745 7th Avenue,New York, NY 10019, United States</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"></td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Sort cod: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">20-20-37</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">SWIFT code: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">BARCGB2</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">IBAN code: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">GB98BARC2020375096104</td>\r\n                </tr>\r\n            </table >','<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"282\" style=\"border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;\">\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Beneficiary: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Colourways Limited</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Account # :</td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">50961043</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"><span>Beneficiary\'s bank: </span>Barclays Bank,Barclays, 745 7th Avenue,New York, NY 10019, United States</td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan = \"2\" width = \"285\" height=\"17\" style=\"padding: 0; margin: 0;\"></td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">Sort cod: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">20-20-37</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">SWIFT code: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">BARCGB2</td>\r\n                </tr>\r\n                <tr>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">IBAN code: </td>\r\n                    <td width = \"141\" height=\"17\" style=\"padding: 0; margin: 0;\">GB98BARC2020375096104</td>\r\n                </tr>\r\n\r\n\r\n            </table >',NULL,NULL,NULL,NULL,0,'No Degree',NULL,NULL,NULL,0,NULL,2,NULL,NULL,0,0,21,0),(9,'FIN','+38 (044) 434-55-64','crm-fin2@skynix.co','8384386dd789da8c222fa9d3b1b3e435','Vess','Jonson',NULL,'Skynix Ltd',NULL,NULL,'2018-12-03 00:00:00',NULL,NULL,1,1000,8000,130,1200,4500,130,1200,4300,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'No Degree',NULL,NULL,NULL,0,NULL,2,NULL,NULL,0,0,10,0),(10,'DEV','+380 (050) 403-33-01','crm-dev2@skynix.co','9ef7f207f0853694610afdad81ebe5ec','Wess','Wilson',NULL,'Skynix Ltd',NULL,NULL,'2019-01-15 00:00:00',NULL,NULL,1,1800,25000,0,0,0,0,0,0,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'No Degree',NULL,NULL,NULL,0,NULL,2,NULL,NULL,0,0,9,0),(11,'SALES','+38 (066) 434-44-33','crm-sales2@skynix.co','a22744b22823e056902271e60a41d530','Terry','Brown',NULL,'Skynix Ltd',NULL,NULL,NULL,'2019-03-12 15:08:34',NULL,1,3500,35000,0,0,0,0,0,0,NULL,0,NULL,'Sign-clean-128.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'No Degree',NULL,NULL,NULL,0,NULL,2,NULL,NULL,0,0,0,0),(12,'PM','+38 (322) 232-33-21','crm-pm2@skynix.co','6e3369cd7e96ca11e7d7a78fccaa661f','Gary','Madison',NULL,'Skynix Ltd',NULL,NULL,NULL,NULL,NULL,1,1900,3200,0,0,0,0,0,0,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'No Degree',NULL,NULL,NULL,0,NULL,2,NULL,NULL,0,0,0,0);
/*!40000 ALTER TABLE users ENABLE KEYS */;
DROP TABLE IF EXISTS vacation_history_items;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE vacation_history_items (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) DEFAULT NULL,
  days int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (id),
  KEY fk_user_id1 (user_id),
  CONSTRAINT fk_user_id1 FOREIGN KEY (user_id) REFERENCES `users` (id) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE vacation_history_items DISABLE KEYS */;
/*!40000 ALTER TABLE vacation_history_items ENABLE KEYS */;
DROP TABLE IF EXISTS work_history;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE work_history (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) DEFAULT NULL,
  date_start date DEFAULT NULL,
  date_end date DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  title varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  added_by_user_id int(11) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY fk_work_history_users (user_id),
  KEY fk_work_history_postedby_users (added_by_user_id),
  CONSTRAINT fk_work_history_postedby_users FOREIGN KEY (added_by_user_id) REFERENCES `users` (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_work_history_users FOREIGN KEY (user_id) REFERENCES `users` (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE work_history DISABLE KEYS */;
/*!40000 ALTER TABLE work_history ENABLE KEYS */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

