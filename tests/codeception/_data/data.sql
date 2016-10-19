SET @PREVIOUS_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS;
SET FOREIGN_KEY_CHECKS = 0;

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
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
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;


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
INSERT INTO `migration` VALUES ('m000000_000000_base',1455021189),('m160125_170036_alter_reports_hours',1455021190),('m160127_130244_users_role_add_fin',1455021190),('m160128_121751_users_add_invite_hash',1455021190),('m160128_144305_users_phone_is_null',1455021190),('m160201_104354_user_add_is_deleted',1455021190),('m160203_093008_projects_add_is_deleted',1455021190),('m160204_083656_projects_id_AUTO_INCREMENT',1455021190),('m160204_160915_projects_date_start_date_end_DATE',1455021190),('m160208_165328_reports_add_is_deleted',1455105861),('m160217_092401_invoices_add_note',1456088295),('m160219_101829_invoices_id_AUTO_INCREMENT',1456088759),('m160219_150941_invoices_date_to_DATE',1456167462),('m160219_155225_invoices_add_total_hours',1456167462),('m160226_113724_users_date_signup_date_login_date_salary_up_DATE',1456667132),('m160301_141851_create_table_paiment_methods',1457670979),('m160301_144739_invoices_add_contract_number_and_act_of_work',1457670979),('m160302_052720_gopa',1456896447),('m160302_101023_payment_methods_insert_bank_transfer',1457878959),('m160302_101913_payment_methods_description',1457878959),('m160302_103718_payment_methods_add_description',1457878959),('m160311_091242_payment_methods_update_description',1457878959),('m160316_103526_table_users_timestamp_data_signup_data_login',1458635908),('m160317_071410_usercontroller_date_login_and_date_signup_time',1458635913),('m160317_095404_create_table_teams_and_teammates',1458635913),('m160317_130740_invoices_add_is_delete',1458635913),('m160322_081059_add_key_table_users_and_teams',1458635913),('m160322_090400_fix_ref',1458637923),('m160322_101526_add_key_pk__teammates_and_add_key_table_users_team_teammates',1460101808),('m160414_082424_teammate_add_is_deleted',1460645711),('m160414_105046_teams_add_column_team_leader_id',1460645711),('m160504_151046_surveys',1462376708),('m160504_153333_survey_options',1462376708),('m160507_135846_add_is_delete_surveys',1462639507),('m160515_062903_survey_foraign_keys',1463305506),('m160515_081552_survey_voter_option_id',1463305507),('m160517_131145_add_column_photo_and_sign',1463558587),('m160526_111906_create_table_extensions',1464361748),('m160526_132832_rename_table_table_extensions',1464361748),('m160527_053653_table_support_tickets_support_ticket_comments',1464330426),('m160601_074725_add_key_support_users',1465222329),('m160606_100011_change_surveys_question',1465222329),('m160613_121331_add_column_date_cancelled_table_support_ticket',1465828389),('m160811_103916_add_column_table_invoice_paymet_method',1470919510),('m160829_125553_chenge_table_invoice_type',1472545370),('m160925_134505_create_table_projects_total_hours',1474813629),('m160929_185544_add_role_sales_table_users',1475223142),('m160929_193333_add_id_sales_table_project_developers',1475223143);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_methods`
--

LOCK TABLES `payment_methods` WRITE;
/*!40000 ALTER TABLE `payment_methods` DISABLE KEYS */;
INSERT INTO `payment_methods` VALUES (1,'bank_transfer','<tr>\n                                <td colspan = \"8\" width = \"570\" style=\"padding: 0; margin: 0;\">\n                                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"570\" style=\"border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;\">\n\n                                        <tr>\n                                            <td width = \"285\" valign=\"top\" height=\"25\" style=\"padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;\">\n                                                <div style=\"width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;\">\n                                                    Реквизиты предприятия/Company details\n                                                </div>\n                                                <div style=\"width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;\">\n                                                    Наименоваение предприятия/company Name\n                                                </div>\n                                            </td>\n                                            <td height=\"25\" valign=\"top\" style=\"width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;\">\n                                                Прожога Олексiй Юрiйович пiдприємец\n                                            </td>\n                                        </tr>\n\n                                        <tr style=\"background-color: #eeeeee;\">\n                                            <td width = \"285\" valign=\"top\" height=\"25\" style=\"padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;\">\n                                                <div style=\"width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;\">\n                                                    Счет предприятия в банке/The bank account of the company\n                                                </div>\n                                            </td>\n                                            <td height=\"25\" valign=\"top\" style=\"width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;\">\n                                                26002057002108\n                                            </td>\n                                        </tr>\n\n                                        <tr>\n                                            <td width = \"285\" valign=\"top\" height=\"25\" style=\"padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;\">\n                                                <div style=\"width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;\">\n                                                    Наименование банка/Name of the bank\n                                                </div>\n                                            </td>\n                                            <td height=\"25\" valign=\"top\" style=\"width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;\">\n                                                Privatbank, Dnipropetrovsk, Ukraine\n                                            </td>\n                                        </tr>\n\n                                        <tr style=\"background-color: #eeeeee;\">\n                                            <td width = \"285\" valign=\"top\" height=\"25\" style=\"padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;\">\n                                                <div style=\"width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;\">\n                                                    SWIFT Code банка/Bank SWIFT Code\n                                                </div>\n                                            </td>\n                                            <td height=\"25\" valign=\"top\" style=\"width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;\">\n                                                PBANUA2X\n                                            </td>\n                                        </tr>\n\n                                        <tr>\n                                            <td width = \"285\" valign=\"top\" height=\"25\" style=\"padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;\">\n                                                <div style=\"width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;\">\n                                                    Адрес предприятия/Company address\n                                                </div>\n                                            </td>\n                                            <td height=\"25\" valign=\"top\" style=\"width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;\">\n                                                UA 08294 Київська м Буча вул Тарасiвська д.8а кв.128\n                                            </td>\n                                        </tr>\n\n                                        <tr style=\"background-color: #eeeeee;\">\n                                            <td width = \"285\" valign=\"top\" height=\"25\" style=\"padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;\">\n                                                <div style=\"width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;\">\n                                                    IBAN Code\n                                                </div>\n                                            </td>\n                                            <td height=\"25\" valign=\"top\" style=\"width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;\">\n                                                UA323515330000026002057002108\n                                            </td>\n                                        </tr>\n\n                                        <tr>\n                                            <td width = \"285\" valign=\"top\" height=\"25\" style=\"padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;\">\n                                                <div style=\"width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;\">\n                                                    Банки-корреспонденты/correspondent banks\n                                                </div>\n                                                <div style=\"width: 100%; padding: 18px 0 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;\">\n                                                    Счет в банке-корреспонденте/Account in the correspondent bank\n                                                </div>\n                                            </td>\n                                            <td height=\"25\" valign=\"top\" style=\"width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;\">\n                                                001-1-000080\n                                            </td>\n                                        </tr>\n\n                                        <tr style=\"background-color: #eeeeee;\">\n                                            <td width = \"285\" valign=\"top\" height=\"25\" style=\"padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;\">\n                                                <div style=\"width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;\">\n                                                    SWIFT Code\n                                                </div>\n                                                <div style=\"width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;\">\n                                                    банка-корреспондента/SWIFT-code of the correspondent bank\n                                                </div>\n                                            </td>\n                                            <td height=\"25\" valign=\"top\" style=\"width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;\">\n                                                CHASUS33\n                                            </td>\n                                        </tr>\n\n                                        <tr>\n                                            <td width = \"285\" valign=\"top\" height=\"25\" style=\"padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;\">\n                                                <div style=\"width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;\">\n                                                    Банк-корреспондент/correspondent bank\n                                                </div>\n                                            </td>\n                                            <td height=\"25\" valign=\"top\" style=\"width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;\">\n                                                JP Morgan Chase Bank,New York ,USA\n                                            </td>\n                                        </tr>\n\n                                    </table>\n                                </td>\n                            </tr>');
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=156 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
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
  `reporter_name` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hours` double DEFAULT NULL,
  `task` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  `date_paid` date DEFAULT NULL,
  `date_report` date DEFAULT NULL,
  `status` enum('NEW','INVOICED','DELETED','PAID','WONTPAID') COLLATE utf8_unicode_ci DEFAULT 'NEW',
  `is_working_day` tinyint(1) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_reports_projects1_idx` (`project_id`),
  KEY `fk_reports_users1_idx` (`user_id`),
  KEY `fk_reports_invoices1_idx` (`invoice_id`),
  CONSTRAINT `fk_reports_invoices1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_reports_projects1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_reports_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1098 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;


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
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;


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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=170 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'ADMIN','1234567896','maryt@skynix.co','21232f297a57a5a743894a0e4a801fc3','Oleksiy','Prozhoga',NULL,NULL,'php, mysql, yii2','test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test  test test test test test test test test test test test test test test test test test test test test  test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test  test test test test test test test test test test test test test test test test test test test test  test test test test test test test test test test test test test test test test test test test test  test test test test test test test test test test test test test test test test test test test test  test test test test test test test test test test test test test test test test test test test test  test\r\n','2016-03-19 12:46:07','2016-10-18 14:07:46',NULL,1,0,0,0,0,0,0,0,'',0,'104.jpg','signatures1.gif');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;


SET FOREIGN_KEY_CHECKS = @PREVIOUS_FOREIGN_KEY_CHECKS;