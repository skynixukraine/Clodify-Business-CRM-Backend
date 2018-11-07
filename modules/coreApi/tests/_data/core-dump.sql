/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS clients;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE clients (
  id int(11) NOT NULL AUTO_INCREMENT,
  domain varchar(80) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  email varchar(255) DEFAULT NULL,
  first_name varchar(255) DEFAULT NULL,
  last_name varchar(255) DEFAULT NULL,
  trial_expires date DEFAULT NULL,
  prepaid_for date DEFAULT NULL,
  mysql_user varchar(45) DEFAULT NULL,
  mysql_password varchar(45) DEFAULT NULL,
  is_active tinyint(1) DEFAULT '1',
  is_confirmed tinyint(1) DEFAULT '1',
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE clients DISABLE KEYS */;
INSERT INTO clients VALUES (1,'skynix_llc','Skynix LLC','admin@skynix.co','Skynix','Admin','2021-11-07',NULL,'develop_skynix','NGY0ODYzZWFjMGViMzA2OGYwMTlmMmY1',1,1);
/*!40000 ALTER TABLE clients ENABLE KEYS */;
DROP TABLE IF EXISTS client_keys;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client_keys` (
  id int(11) NOT NULL AUTO_INCREMENT,
  client_id int(11) DEFAULT NULL,
  access_key varchar(45) DEFAULT NULL,
  valid_until date DEFAULT NULL,
  PRIMARY KEY (id),
  KEY client_keys_fk (client_id),
  CONSTRAINT client_keys_fk FOREIGN KEY (client_id) REFERENCES `clients` (id)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE client_keys DISABLE KEYS */;
INSERT INTO client_keys VALUES (1,1,'XDGAC20m7IxrP5KuqXVDXBHU-3YWqa8c7IBxHS8BVJZgK','2021-11-07');
/*!40000 ALTER TABLE client_keys ENABLE KEYS */;
DROP TABLE IF EXISTS migration;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE migration (
  version varchar(180) NOT NULL,
  apply_time int(11) DEFAULT NULL,
  PRIMARY KEY (version)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE migration DISABLE KEYS */;
INSERT INTO migration VALUES ('m000000_000000_base',1541582874),('m160125_170036_alter_reports_hours',1541582958),('m160127_130244_users_role_add_fin',1541582958),('m160128_121751_users_add_invite_hash',1541582958),('m160128_144305_users_phone_is_null',1541582958),('m160201_104354_user_add_is_deleted',1541582958),('m160203_093008_projects_add_is_deleted',1541582958),('m160204_083656_projects_id_AUTO_INCREMENT',1541582958),('m160204_160915_projects_date_start_date_end_DATE',1541582958),('m160208_165328_reports_add_is_deleted',1541582958),('m160217_092401_invoices_add_note',1541582958),('m160219_101829_invoices_id_AUTO_INCREMENT',1541582958),('m160219_150941_invoices_date_to_DATE',1541582958),('m160219_155225_invoices_add_total_hours',1541582958),('m160226_113724_users_date_signup_date_login_date_salary_up_DATE',1541582958),('m160301_141851_create_table_paiment_methods',1541582958),('m160301_144739_invoices_add_contract_number_and_act_of_work',1541582958),('m160302_101023_payment_methods_insert_bank_transfer',1541582958),('m160302_101913_payment_methods_description',1541582958),('m160302_103718_payment_methods_add_description',1541582958),('m160311_091242_payment_methods_update_description',1541582958),('m160316_103526_table_users_timestamp_data_signup_data_login',1541582958),('m160317_071410_usercontroller_date_login_and_date_signup_time',1541582958),('m160317_095404_create_table_teams_and_teammates',1541582958),('m160317_130740_invoices_add_is_delete',1541582958),('m160322_081059_add_key_table_users_and_teams',1541582958),('m160322_090400_fix_ref',1541582958),('m160322_101526_add_key_pk__teammates_and_add_key_table_users_team_teammates',1541582958),('m160414_082424_teammate_add_is_deleted',1541582958),('m160414_105046_teams_add_column_team_leader_id',1541582958),('m160504_151046_surveys',1541582958),('m160504_153333_survey_options',1541582958),('m160507_135846_add_is_delete_surveys',1541582958),('m160515_062903_survey_foraign_keys',1541582958),('m160515_081552_survey_voter_option_id',1541582958),('m160517_131145_add_column_photo_and_sign',1541582958),('m160526_111906_create_table_extensions',1541582958),('m160526_132832_rename_table_table_extensions',1541582958),('m160527_053653_table_support_tickets_support_ticket_comments',1541582958),('m160601_074725_add_key_support_users',1541582958),('m160606_100011_change_surveys_question',1541582958),('m160613_121331_add_column_date_cancelled_table_support_ticket',1541582958),('m160712_135515_api_auth_access_tokens',1541582958),('m160811_103916_add_column_table_invoice_paymet_method',1541582958),('m160829_125553_chenge_table_invoice_type',1541582958),('m160925_134505_create_table_projects_total_hours',1541582958),('m160929_185544_add_role_sales_table_users',1541582958),('m160929_193333_add_id_sales_table_project_developers',1541582958),('m161130_082130_project_id_column_in_invoice_table',1541582958),('m161201_091313_public_profile_key_in_users_table',1541582958),('m161202_142913_cost_column_in_project_table',1541582958),('m161220_132038_added',1541582958),('m170105_105052_new_column_in_table_invoice',1541582958),('m170107_074133_invoice_contract',1541582958),('m170111_123813_contract_templates_table_create',1541582958),('m170112_092909_contract_template_id_column_in_Contracts_table',1541582958),('m170112_100123_new_column_contract_payment_method_id_in_contracts_table',1541582958),('m170112_125354_new_columns_bank_account_enUa_in_users_table',1541582958),('m170121_110057_insert_in_contractr_template',1541582958),('m170121_132013_insert_in_payment_methods',1541582958),('m170126_113509_modified_insert_in_CONTRACT_TEMPLATE_and_PAYMENT_METHODS',1541582958),('m170130_130822_updated_payment_method_deleted_sign_from_template',1541582958),('m170201_134821_update_contract_template',1541582958),('m170202_135748_update_contract_template_simply_edits',1541582958),('m170203_104959_update_contract_template__deleted_border_bottom',1541582958),('m170213_133256_new_table_contact_form',1541582958),('m170216_164829_alter_table_contract_total',1541582958),('m170220_091553_added_created_by_column_in_invoices_table',1541582958),('m170301_170626_ON_DELETE_action_for_invoices_when_delete_related_contract',1541582958),('m170316_141047_alter_contact_table_encoding',1541582958),('m170404_081923_users_add_password_reset_token',1541582958),('m170404_140151_users_remove_not_null_for_invite_hash',1541582958),('m170405_133928_create_table_careers',1541582958),('m170405_134435_create_table_candidates',1541582958),('m170419_091723_add_columns_users_table',1541582958),('m170419_093831_add_columns_projects_table',1541582958),('m170419_095059_create_work_history_table',1541582958),('m170426_080723_add_slug_column_to_users',1541582958),('m170721_083953_create_financial_reports_table',1541582958),('m170721_142534_rename_report_date_column',1541582959),('m170801_112518_add_spent_corp_events_col_to_finreport',1541582959),('m170802_113430_add_column_is_locked_tofinrep_table',1541582959),('m170804_063417_create_financial_yearly_reports_tab',1541582959),('m170823_091142_create_salary_reports_tab',1541582959),('m170823_092953_create_salary_report_lists_tab',1541582959),('m170825_081149_add_num_of_working_days_column_to_financial_reports_table',1541582959),('m170825_104725_add_foreign_keys_for_salary_report_lists',1541582959),('m170825_105204_add_official_salary_column_to_users_table',1541582959),('m170829_063540_change_type_of_actually_worked_out_salary',1541582959),('m170914_080452_change_type_of_columns_in_fin_yearly_report',1541582959),('m171019_065952_create_settings_table',1541582959),('m171019_070303_insert_into_settings_corpevents_and_bonuses',1541582959),('m171102_112931_add_is_approved_reports',1541582959),('m171103_072238_create_report_actions_tbl',1541582959),('m171107_065613_create_counterparties_table',1541582959),('m171107_152204_create_busineses_table',1541582959),('m171108_104332_create_operation_types_table',1541582959),('m171108_120214_create_reference_book_tbl',1541582959),('m171109_093535_alter_column_id_in_operations',1541582959),('m171109_093636_create_transactions_table',1541582959),('m171109_132006_alter_column_id_in_transactions',1541582959),('m171109_135702_alter_column_code_in_reference_book',1541582959),('m171219_141221_create_access_keys_table',1541582959),('m180118_094617_create_auth_types_table',1541582959),('m180118_094629_add_column_authtype_to_users',1541582959),('m180302_085003_add_new_columns_to_businesses_tbl',1541582959),('m180302_091459_add_modify_columns_of_invoices_table',1541582959),('m180321_095840_projects_total_approved_hours',1541582959),('m180328_100625_create_fixed_assets_tbl',1541582959),('m180328_111012_create_fixed_assets_operations_tbl',1541582959),('m180328_130334_not_required_fields_in_transactions',1541582959),('m180329_163123_operation_type_amortization',1541582959),('m180405_124521_add_is_avaialble_to_users',1541582959),('m180405_125642_create_availability_logs_tbl',1541582959),('m180415_063408_emergencies',1541582959),('m180418_111016_add_is_deleted_col_to_operations_tbl',1541582959),('m180418_152343_add_new_operation_types',1541582959),('m180426_133721_create_delayed_salary_tbl',1541582959),('m180427_080045_alter_table_delayed_salary',1541582959),('m180427_080046_labor_expenses_ratio',1541582959),('m180606_144521_incoice_id',1541582959),('m180606_160830_business_ua_information',1541582959),('m180607_101217_user_address',1541582959),('m180607_183036_salary_list_vacations',1541582959),('m180607_195455_financial_income',1541582959),('m180607_205300_financial_income_migration',1541582959),('m180611_170241_work_history_dates',1541582959),('m180626_095445_add_from_to_dates_for_income',1541582959),('m180626_185114_refactor_crowd_token',1541582959),('m180627_075434_sso_settings',1541582959),('m180629_093330_add_guest_role',1541582959),('m180705_022523_work_history_postedby',1541582959),('m180705_023535_create_system_user',1541582959),('m180714_072024_project_type',1541582959),('m180802_111639_refactor_payment_methods_database',1541582959),('m180804_114438_only_approved_hours',1541582959),('m180804_125259_salary_report_non_approved_hours',1541582959),('m180810_125648_payment_methods_set_business_id',1541582959),('m180821_132253_business_add_is_deleted_field',1541582959),('m180821_133517_business_set_is_default',1541582959),('m180822_092951_create_email_templates_table',1541582959),('m180822_122257_refactor_all_emails_sent_by_system',1541582959),('m180823_082338_create_invoice_template_table',1541582959),('m180823_093706_refactor_invoice_pdf_template',1541582959),('m180917_071155_convert_fin_report_date',1541582959),('m180925_101326_add_invoice_increment_id',1541582959),('m180927_153514_add_invoice_template_vars',1541582959),('m181006_125826_is_system_user',1541582959),('m181008_103502_add_reviews_table',1541582959),('m181008_133324_project_debts',1541582959),('m181031_152433_correct_project_status_canceled',1541582959),('m181102_144946_increase_crowd_token_length',1541582959),('m181105_193840_core_clients',1541582959),('m181105_194841_core_client_orders',1541582959),('m181105_195338_core_client_keys',1541582959),('m181105_195543_core_first_client',1541582959);
/*!40000 ALTER TABLE migration ENABLE KEYS */;
DROP TABLE IF EXISTS orders;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE orders (
  id int(11) NOT NULL AUTO_INCREMENT,
  client_id int(11) DEFAULT NULL,
  `status` enum('NEW','ONREVIEW','PAID','CANCELED') DEFAULT NULL,
  amount float DEFAULT NULL,
  payment_id int(11) DEFAULT NULL,
  recurrent_id int(11) DEFAULT NULL,
  created date DEFAULT NULL,
  paid date DEFAULT NULL,
  notes text,
  PRIMARY KEY (id),
  KEY client_orders_fk (client_id),
  CONSTRAINT client_orders_fk FOREIGN KEY (client_id) REFERENCES `clients` (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE orders DISABLE KEYS */;
/*!40000 ALTER TABLE orders ENABLE KEYS */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
