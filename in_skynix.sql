-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 26, 2017 at 05:30 PM
-- Server version: 5.7.17-0ubuntu0.16.04.1
-- PHP Version: 7.0.14-2+deb.sury.org~xenial+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `in.skynix`
--

-- --------------------------------------------------------

--
-- Table structure for table `api_auth_access_tokens`
--

CREATE TABLE `api_auth_access_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `access_token` varchar(40) NOT NULL,
  `exp_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `id` int(11) NOT NULL,
  `contract_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `act_number` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `act_date` date DEFAULT NULL,
  `total` decimal(19,4) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `contract_template_id` int(11) DEFAULT NULL,
  `contract_payment_method_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contracts`
--

INSERT INTO `contracts` (`id`, `contract_id`, `customer_id`, `act_number`, `start_date`, `end_date`, `act_date`, `total`, `created_by`, `contract_template_id`, `contract_payment_method_id`) VALUES
(1, 14, 6, 14, '2017-01-01', '2017-01-12', '2017-01-12', '213.0000', 1, NULL, NULL),
(15, 4, 25, 4, '2016-12-01', '2016-12-30', '2016-12-30', '44545.0000', 1, NULL, NULL),
(16, 5, 5, 5, '2016-12-01', '2016-12-30', '2016-12-30', '898989.0000', 1, NULL, NULL),
(17, 6, 6, 6, '2017-01-01', '2017-01-03', '2017-01-03', '14214.0000', 1, NULL, NULL),
(18, 7, 6, 7, '2017-01-01', '2017-01-03', '2017-01-03', '213.0000', 1, NULL, NULL),
(19, 8, 9, 8, '2017-01-01', '2017-01-03', '2017-01-03', '1212.0000', 1, NULL, NULL),
(20, 9, 6, 9, '2017-01-01', '2017-01-03', '2017-01-03', '1231.0000', 1, NULL, NULL),
(22, 11, 9, 11, '2017-01-01', '2017-01-05', '2017-01-05', '1241.0000', 49, NULL, NULL),
(23, 12, 15, 12, '2017-01-01', '2017-01-05', '2017-01-05', '41.0000', 49, NULL, NULL),
(24, 13, 9, 13, '2017-01-01', '2017-01-06', '2017-01-06', '23.0000', 19, NULL, NULL),
(25, 15, 5, 15, '2017-01-01', '2017-01-12', '2017-01-12', '232.0000', 1, NULL, NULL),
(26, 16, 5, 16, '2017-01-01', '2017-01-12', '2017-01-12', '75.0000', 1, NULL, NULL),
(27, 17, 6, 17, '2017-01-01', '2017-01-12', '2017-01-12', '65656.0000', 1, NULL, NULL),
(28, 18, 5, 18, '2017-01-01', '2017-01-12', '2017-01-12', '23.0000', 1, NULL, NULL),
(32, 22, 6, 22, '2017-01-01', '2017-01-12', '2017-01-12', '232323.0000', 1, NULL, 1),
(33, 23, 6, 23, '2017-01-01', '2017-01-12', '2017-01-12', '232.0000', 1, NULL, NULL),
(97, 24, 23, 24, '2017-01-01', '2017-01-23', '2017-01-23', '23.0000', 1, 27, 22);

-- --------------------------------------------------------

--
-- Table structure for table `contract_templates`
--

CREATE TABLE `contract_templates` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `content` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contract_templates`
--

INSERT INTO `contract_templates` (`id`, `name`, `content`) VALUES
(27, 'Default template', '\n        <!doctype html>\n<html lang="en">\n<head>\n    <meta charset="utf-8">\n    <meta http-equiv="X-UA-Compatible" content="IE=edge">\n    <meta name="viewport" content="width=device-width, initial-scale=1">\n\n</head>\n<body>\n<table width="570"\n       style=" margin-left: auto; margin-right: auto; border-collapse: collapse;">\n\n    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">\n        <td style =" vertical-align: top; border: 1px solid black; height: 100%; box-sizing: border-box; border-collapse: collapse; padding: 5px;">\n            <p style="margin: 0;"><center><strong>КОНТРАКТ №var_contract_id</strong></center></p>\n            <p style="margin: 0;"><center><strong>НА НАДАННЯ ПОСЛУГ</strong></center></p>\n            <p align="right">var_start_date</p>\n            <p>\n                Компанія "var_company_name" далі\n                по тексту "Замовник" і Компанія ФОП Прожога О.Ю.,\n                Україна,в особі Прожоги Олексія Юрійовича,\n                діючого на підставі реєстрації\n                №22570000000001891 від 01.05.2001р. далі по\n                тексту "Виконавець", далі по тексту Сторони,\n                уклали цей Контракт про наступне:\n            </p>\n            <br>\n            <p style="margin: 0;"><center><strong>1. Предмет Контракту</strong></center></p>\n            <p style="margin: 0;"> 1.1.Виконавець зобов\'язується за завданням\n                Замовника надати наступні послуги:\n                Розробка програмного забезпечення(веб\n                сайту)\n            </p>\n            <p style="margin: 0;"><center><strong>2. Ціна і загальна сума Контракту</strong></center></p>\n            <p style="margin: 0;">2.1. Вартість послуги встановлюється в</p>\n            <p style="margin: 0;"><strong>$var_total</strong></p>\n            <p style="margin: 0;">\n                2.2.  Загальна сума Контракту становить\n            </p>\n            <p style="margin: 0;"><strong>$var_total</strong></p>\n            <p style="margin: 0;">\n                2.3.У разі зміни суми Контракту за згодою\n                сторін, Сторони зобов\'язуються підписати\n                додаткову угоду до даного Контракту про\n                збільшення або зменшення загальної суми\n                Контракту.\n            </p>\n            <p style="margin: 0;"><center><strong>3. Умови платежу</strong></center></p>\n            <p style="margin: 0;">\n                3.1.Замовник здійснює оплату банківським\n                переказом на рахунок Виконавця протягом 5\n                календарних днів з моменту підписання Акту\n                прийому-передачі наданих послуг.\n                3.2. Банківські витрати оплачує замовник <br>\n                3.3. Валюта платежу – USD.\n            </p>\n            <p style="margin: 0;"><center><strong>4. Умови надання послуг</strong><center></p>\n            <p style="margin: 0;">\n\n                4.1.Виконавець надає послуги на умовах\n                цього Контракту і Додатків до нього.\n            </p>\n            <p style="margin: 0;"><center><strong>5. Відповідальність сторін</strong></center></p>\n            <p style="margin: 0;">\n\n                5.1.Сторони зобов\'язуються нести\n                відповідальність за невиконання або\n                неналежне виконання зобов\'язань за цим\n                Контрактом.\n            </p>\n            <p style="margin: 0;"><center><strong>6. Претензії</strong></center></p>\n            <p style="margin: 0;">\n\n                6.1 Претензії щодо якості наданих за даним\n                Контрактом послуг можуть бути пред\'явлені\n                не пізніше 3 робочих днів з дня підписання\n                Акту прийому-передачі наданих послуг.\n            </p>\n        </td>\n        <td style =" vertical-align: top; border-collapse: collapse; border: 1px solid black; height: 100%; box-sizing: border-box; padding: 5px;">\n            <p style="margin: 0;">\n                <center><strong>CONTRACT №var_contract_id</strong></center>\n            </p>\n            <p style="margin: 0;">\n                <center><strong>FOR SERVICES</strong></center>\n            </p>\n            <p>\n                var_start_date\n            </p>\n            <p>\n                The company "var_company_name"\n                hereinafter referred to as "Customer" and the\n                company "<strong>FOP Prozhoga O.Y.</strong>" Ukraine,\n                represented by Prozhoga Oleksii Yuriyovich, who is\n                authorized by check №22570000000001891 from\n                01.05.2001, hereinafter referred to as "Contractor",\n                and both Companies hereinafter referred to as\n                "Parties", have cа яoncluded the present Contract as\n                follows:\n            </p>\n            <br>\n            <p style="margin: 0;"><center><strong>1. Subject of the Contract</strong></center></p>\n            <p style="margin: 0;">\n\n                1.1.The Contractor undertakes to provide the\n                following services to Customer: Software\n                development (web site)\n            </p>\n            <p style="margin: 0;"><center><strong>2. Contract Price and total sum</strong></center></p>\n            <p style="margin: 0;">\n\n                2.1.The price for the Services is established in\n                <strong>$var_total</strong><br>\n                2.2.The preliminary total sum of the Contract\n                makes <strong>$var_total</strong><br>\n                2.3.In case of change of the sum of the Contract,\n                the Party undertake to sign the additional\n                agreement to the given Contract on increase or\n                reduction of a total sum of the Contract.\n            </p>\n            <br>\n            <p style="margin: 0;"><center><strong>3. Payment Conditions</strong></center></p>\n            <p style="margin: 0;">\n\n                3.1.The Customer shall pay by bank transfer to\n                the account within 5 calendar days from the date\n                of signing the acceptance of the Services. <br>\n                3.2. Bank charges are paid by customer. <br>\n                3.3. The currency of payment is USD.\n            </p>\n            <p style="margin: 0;"><center><strong>4. Realisation Terms</strong></center></p>\n            <p style="margin: 0;">\n\n                4.1.The Contractor shall deliver of the services on\n                consulting services terms.\n            </p>\n            <p style="text-align: center; margin: 0;"><strong>5. The responsibility of the Parties</strong></p>\n            <p style="margin: 0;">\n\n                5.1. The Parties under take to bear the\n                responsibility for default or inadequate\n                performance of obligations under the present\n                contract\n            </p>\n            <p style="margin: 0;"><center><strong>6. Claims</strong></center></p>\n            <p style="margin: 0;">\n\n                6.1.Claims of quality and quantity of the services\n                delivered according to the present Contract can be\n                made not later 3 days upon the receiving of the\n                Goods.\n            </p>\n\n        </td>\n    </tr>\n\n</table>\n        ');

-- --------------------------------------------------------

--
-- Table structure for table `extensions`
--

CREATE TABLE `extensions` (
  `id` int(11) NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `repository` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('EXTENSION','THEME','LANGUAGE') COLLATE utf8_unicode_ci DEFAULT NULL,
  `version` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `package` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `extensions`
--

INSERT INTO `extensions` (`id`, `name`, `repository`, `type`, `version`, `package`) VALUES
(2, 'Skynix/BankTransfer', 'git@bitbucket.org:in-skynix/m2-bank-transfer', 'EXTENSION', '1.0.0', NULL),
(3, 'Skynix/BankTransfer', 'git@bitbucket.org:in-skynix/m2-bank-transfer', 'EXTENSION', '1.0.0', NULL),
(4, 'Skynix/BankTransfer', 'git@bitbucket.org:in-skynix/m2-bank-transfer', 'EXTENSION', '1.0.0', NULL),
(5, 'Skynix/BankTransfer', 'git@bitbucket.org:in-skynix/m2-bank-transfer', 'THEME', '1.0.0', NULL),
(6, 'Skynix/BankTransfer', 'git@bitbucket.org:in-skynix/m2-bank-transfer', 'THEME', '1.0.0', NULL),
(7, 'Skynix/BankTransfer', 'git@bitbucket.org:in-skynix/m2-bank-transfer', 'LANGUAGE', '1.0.0', NULL),
(8, 'Skynix/BankTransfer', 'git@bitbucket.org:in-skynix/m2-bank-transfer', 'LANGUAGE', '1.0.0', NULL),
(9, 'Skynix/BankTransfer', 'git@bitbucket.org:in-skynix/m2-bank-transfer', 'LANGUAGE', '1.0.0', NULL),
(10, 'Skynix/BankTransfer', 'git@bitbucket.org:in-skynix/m2-bank-transfer', 'EXTENSION', '1.0.0', NULL),
(11, 'Skynix/BankTransfer', 'git@bitbucket.org:in-skynix/m2-bank-transfer', 'EXTENSION', '1.0.0', NULL),
(12, 'Skynix/BankTransfer', 'git@bitbucket.org:in-skynix/m2-bank-transfer', 'EXTENSION', '1.0.0', NULL),
(13, 'Skynix/BankTransfer', 'git@bitbucket.org:in-skynix/m2-bank-transfer', 'EXTENSION', '1.0.0', NULL),
(14, 'Skynix/BankTransfer', 'git@bitbucket.org:in-skynix/m2-bank-transfer', 'THEME', '1.0.0', NULL),
(15, 'Skynix/BankTransfer', 'git@bitbucket.org:in-skynix/m2-bank-transfer', 'EXTENSION', '1.0.0', NULL),
(16, 'Skynix/BankTransfer', 'git@bitbucket.org:in-skynix/m2-bank-transfer', 'LANGUAGE', '1.0.0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
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
  `contract_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `user_id`, `subtotal`, `discount`, `total`, `date_start`, `date_end`, `date_created`, `date_paid`, `date_sent`, `status`, `note`, `total_hours`, `contract_number`, `act_of_work`, `is_delete`, `payment_method_id`, `project_id`, `user_projects`, `contract_id`) VALUES
(77, 6, 123123, '0.00', 123123, '2017-01-01', '2017-01-03', NULL, NULL, NULL, 'PAID', '213123', NULL, NULL, NULL, 0, 1, 65, NULL, NULL),
(78, 6, 11, '11.00', 0, '2017-01-01', '2017-01-03', NULL, '2017-01-04', NULL, 'PAID', '11', NULL, 11, 11, 0, 1, 65, NULL, NULL),
(79, 5, 1212, '0.00', 1212, '2017-01-01', '2017-01-03', NULL, '2017-01-04', NULL, 'PAID', '', NULL, 15, 14, 0, 1, 67, NULL, NULL),
(80, NULL, 132123123, '0.00', 132123123, '2017-01-01', '2017-01-04', NULL, NULL, NULL, 'PAID', '', 5, NULL, NULL, 0, 1, 64, NULL, NULL),
(81, NULL, 1423, '0.00', 1423, '2017-01-01', '2017-01-04', NULL, NULL, NULL, 'PAID', 'trest', 6, NULL, NULL, 0, 1, 77, NULL, NULL),
(82, 6, 121, '0.00', 121, '2017-01-01', '2017-01-04', NULL, NULL, NULL, 'NEW', '121', NULL, NULL, NULL, 1, 1, 65, NULL, NULL),
(83, NULL, 1211, '0.00', 1211, '2017-01-01', '2017-01-04', NULL, '2017-01-04', NULL, 'PAID', '4r5', NULL, NULL, NULL, 0, 1, 48, NULL, NULL),
(84, NULL, 453, '0.00', 453, '2017-01-01', '2017-01-04', NULL, '2017-01-04', NULL, 'PAID', '', NULL, NULL, NULL, 0, 1, 72, NULL, NULL),
(85, 6, 121, '0.00', 121, '2017-01-01', '2017-01-04', NULL, '2017-01-04', NULL, 'PAID', '', NULL, NULL, NULL, 0, 1, NULL, NULL, NULL),
(86, NULL, 232323, '0.00', 232323, '2017-01-01', '2017-01-05', NULL, NULL, NULL, 'NEW', '', NULL, NULL, NULL, 0, 1, 65, NULL, NULL),
(87, NULL, 141, '0.00', 141, '2017-01-01', '2017-01-05', NULL, NULL, NULL, 'NEW', '', NULL, NULL, NULL, 0, 1, 65, NULL, NULL),
(88, NULL, 5467, '0.00', 5467, '2017-01-01', '2017-01-05', NULL, NULL, NULL, 'NEW', '', NULL, NULL, NULL, 0, 1, 65, NULL, NULL),
(89, NULL, 55344, '0.00', 55344, '2017-01-01', '2017-01-05', NULL, NULL, NULL, 'NEW', '', NULL, NULL, NULL, 0, 1, 65, NULL, NULL),
(90, NULL, 13131, '0.00', 13131, '2017-01-01', '2017-01-06', NULL, NULL, NULL, 'NEW', '', 3, NULL, NULL, 0, 1, 72, NULL, NULL),
(91, 25, 12414, '0.00', 12414, '2017-01-01', '2017-01-06', NULL, NULL, NULL, 'NEW', '4545', 3, NULL, NULL, 0, 1, NULL, NULL, NULL),
(92, NULL, 121, '0.00', 121, '2017-01-01', '2017-01-06', NULL, NULL, NULL, 'NEW', '', 3, 4, 4, 0, 1, 72, NULL, NULL),
(93, NULL, 2323, '0.00', 2323, '2017-01-01', '2017-01-06', NULL, NULL, NULL, 'NEW', '', NULL, 13, 13, 0, 1, 52, NULL, NULL),
(94, 15, 2323, '0.00', 2323, '2017-01-01', '2017-01-06', NULL, NULL, NULL, 'NEW', '', 1, NULL, NULL, 0, 1, 48, NULL, NULL),
(95, 6, 121, '0.00', 121, '2016-11-01', '2017-01-06', NULL, '2017-01-06', NULL, 'PAID', '', 2, NULL, NULL, 0, 1, NULL, NULL, NULL),
(96, 15, 41, '0.00', 41, '2017-01-01', '2017-01-11', NULL, NULL, NULL, 'NEW', '', 10, 12, 12, 0, 1, NULL, NULL, 23),
(97, 9, 23, '0.00', 23, '2017-01-01', '2017-01-11', NULL, NULL, NULL, 'NEW', '', 10, 13, 13, 0, 1, NULL, NULL, 24),
(102, 9, 23, '0.00', 23, '2017-01-01', '2017-01-23', NULL, NULL, NULL, 'NEW', '', NULL, NULL, NULL, 0, 1, 49, NULL, NULL),
(103, 6, 2323, '0.00', 2323, '2017-01-01', '2017-01-23', NULL, NULL, NULL, 'NEW', '', NULL, NULL, NULL, 0, 7, 65, NULL, NULL),
(104, 5, 2323, '0.00', 2323, '2017-01-01', '2017-01-23', NULL, NULL, NULL, 'NEW', '', 13, NULL, NULL, 0, 1, NULL, NULL, NULL),
(105, 6, 232, '0.00', 232, '2017-01-01', '2017-01-23', NULL, NULL, NULL, 'NEW', '', 45, 23, 23, 0, 8, NULL, NULL, 33),
(121, 23, 23, '0.00', 23, '2017-01-01', '2017-01-23', NULL, NULL, NULL, 'NEW', '', 24, 24, 24, 0, 22, NULL, NULL, 97),
(122, 6, 2323, '0.00', 2323, '2017-01-01', '2017-01-24', NULL, NULL, NULL, 'NEW', '', NULL, NULL, NULL, 0, 22, 65, NULL, NULL),
(123, 6, 2323, '0.00', 2323, '2017-01-01', '2017-01-24', NULL, NULL, NULL, 'NEW', '', NULL, NULL, NULL, 0, 22, 65, NULL, NULL),
(124, 6, 232, '0.00', 232, '2017-01-01', '2017-01-24', NULL, NULL, NULL, 'NEW', '', NULL, NULL, NULL, 0, 22, 65, NULL, NULL),
(125, 6, 232, '0.00', 232, '2017-01-01', '2017-01-24', NULL, NULL, NULL, 'NEW', '', NULL, NULL, NULL, 0, 22, 65, NULL, NULL),
(126, 23, 23, '0.00', 23, '2017-01-01', '2017-01-24', NULL, NULL, NULL, 'NEW', '', 28, 24, 24, 0, 22, NULL, NULL, 97),
(127, 6, 2323, '0.00', 2323, '2017-01-01', '2017-01-26', NULL, NULL, NULL, 'NEW', '', NULL, NULL, NULL, 0, 22, NULL, NULL, NULL),
(128, 23, 23, '0.00', 23, '2017-01-01', '2017-01-26', NULL, NULL, NULL, 'NEW', '', 2930, 24, 24, 0, 22, 57, NULL, 97),
(129, 23, 23, '0.00', 23, '2017-01-10', '2017-01-26', NULL, NULL, NULL, 'NEW', '', 18.3, 24, 24, 0, 1, NULL, NULL, 97);

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1455021189),
('m160125_170036_alter_reports_hours', 1455021190),
('m160127_130244_users_role_add_fin', 1455021190),
('m160128_121751_users_add_invite_hash', 1455021190),
('m160128_144305_users_phone_is_null', 1455021190),
('m160201_104354_user_add_is_deleted', 1455021190),
('m160203_093008_projects_add_is_deleted', 1455021190),
('m160204_083656_projects_id_AUTO_INCREMENT', 1455021190),
('m160204_160915_projects_date_start_date_end_DATE', 1455021190),
('m160208_165328_reports_add_is_deleted', 1455105861),
('m160217_092401_invoices_add_note', 1456088295),
('m160219_101829_invoices_id_AUTO_INCREMENT', 1456088759),
('m160219_150941_invoices_date_to_DATE', 1456167462),
('m160219_155225_invoices_add_total_hours', 1456167462),
('m160226_113724_users_date_signup_date_login_date_salary_up_DATE', 1456667132),
('m160301_141851_create_table_paiment_methods', 1457670979),
('m160301_144739_invoices_add_contract_number_and_act_of_work', 1457670979),
('m160302_052720_gopa', 1456896447),
('m160302_101023_payment_methods_insert_bank_transfer', 1457878959),
('m160302_101913_payment_methods_description', 1457878959),
('m160302_103718_payment_methods_add_description', 1457878959),
('m160311_091242_payment_methods_update_description', 1457878959),
('m160316_103526_table_users_timestamp_data_signup_data_login', 1458635908),
('m160317_071410_usercontroller_date_login_and_date_signup_time', 1458635913),
('m160317_095404_create_table_teams_and_teammates', 1458635913),
('m160317_130740_invoices_add_is_delete', 1458635913),
('m160322_081059_add_key_table_users_and_teams', 1458635913),
('m160322_090400_fix_ref', 1458637923),
('m160322_101526_add_key_pk__teammates_and_add_key_table_users_team_teammates', 1461577155),
('m160414_082424_teammate_add_is_deleted', 1461577156),
('m160414_105046_teams_add_column_team_leader_id', 1461577156),
('m160504_151046_surveys', 1463306589),
('m160504_153333_survey_options', 1463306589),
('m160507_135846_add_is_delete_surveys', 1463306589),
('m160515_062903_survey_foraign_keys', 1463306590),
('m160515_081552_survey_voter_option_id', 1463306590),
('m160517_131145_add_column_photo_and_sign', 1464331815),
('m160526_111906_create_table_extensions', 1466701809),
('m160526_132832_rename_table_table_extensions', 1466701809),
('m160527_053653_table_support_tickets_support_ticket_comments', 1464331815),
('m160601_074725_add_key_support_users', 1466701809),
('m160606_100011_change_surveys_question', 1466701810),
('m160613_121331_add_column_date_cancelled_table_support_ticket', 1466701810),
('m160712_135515_api_auth_access_tokens', 1485267255),
('m160811_103916_add_column_table_invoice_paymet_method', 1479042015),
('m160829_125553_chenge_table_invoice_type', 1479042016),
('m160925_134505_create_table_projects_total_hours', 1479042016),
('m160929_185544_add_role_sales_table_users', 1479042016),
('m160929_193333_add_id_sales_table_project_developers', 1479042017),
('m161130_081830_new', 1480494028),
('m161130_082130_project_id_column_in_invoice_table', 1480495104),
('m161201_091313_public_profile_key_in_users_table', 1481303329),
('m161202_142913_cost_column_in_project_table', 1481303329),
('m161220_132038_added', 1482240699),
('m161226_153339_created_by_column_in_contracts_table', 1482837803),
('m170105_105052_new_column_in_table_invoice', 1483614081),
('m170107_074133_invoice_contract', 1484120526),
('m170111_123813_contract_templates_table_create', 1484139040),
('m170112_092909_contract_template_id_column_in_Contracts_table', 1484213607),
('m170112_100123_new_column_contract_payment_method_id_in_contracts_table', 1484215469),
('m170112_125354_new_columns_bank_account_enUa_in_users_table', 1484225734),
('m170121_110057_insert_in_contractr_template', 1485178446),
('m170121_132013_insert_in_payment_methods', 1485178446),
('m170126_113509_modified_insert_in_CONTRACT_TEMPLATE_and_PAYMENT_METHODS', 1485434817);

-- --------------------------------------------------------

--
-- Table structure for table `monthly_reports`
--

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
  `note` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `description`) VALUES
(1, 'bank_transfer', '<tr>\n                                <td colspan = "8" width = "570" style="padding: 0; margin: 0;">\n                                    <table border="0" cellpadding="0" cellspacing="0" width="570" style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">\n\n                                        <tr>\n                                            <td width = "285" valign="top" height="25" style="padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;">\n                                                <div style="width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;">\n                                                    Реквизиты предприятия/Company details\n                                                </div>\n                                                <div style="width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;">\n                                                    Наименоваение предприятия/company Name\n                                                </div>\n                                            </td>\n                                            <td height="25" valign="top" style="width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;">\n                                                Прожога Олексiй Юрiйович пiдприємец\n                                            </td>\n                                        </tr>\n\n                                        <tr style="background-color: #eeeeee;">\n                                            <td width = "285" valign="top" height="25" style="padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;">\n                                                <div style="width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;">\n                                                    Счет предприятия в банке/The bank account of the company\n                                                </div>\n                                            </td>\n                                            <td height="25" valign="top" style="width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;">\n                                                26002057002108\n                                            </td>\n                                        </tr>\n\n                                        <tr>\n                                            <td width = "285" valign="top" height="25" style="padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;">\n                                                <div style="width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;">\n                                                    Наименование банка/Name of the bank\n                                                </div>\n                                            </td>\n                                            <td height="25" valign="top" style="width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;">\n                                                Privatbank, Dnipropetrovsk, Ukraine\n                                            </td>\n                                        </tr>\n\n                                        <tr style="background-color: #eeeeee;">\n                                            <td width = "285" valign="top" height="25" style="padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;">\n                                                <div style="width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;">\n                                                    SWIFT Code банка/Bank SWIFT Code\n                                                </div>\n                                            </td>\n                                            <td height="25" valign="top" style="width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;">\n                                                PBANUA2X\n                                            </td>\n                                        </tr>\n\n                                        <tr>\n                                            <td width = "285" valign="top" height="25" style="padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;">\n                                                <div style="width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;">\n                                                    Адрес предприятия/Company address\n                                                </div>\n                                            </td>\n                                            <td height="25" valign="top" style="width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;">\n                                                UA 08294 Київська м Буча вул Тарасiвська д.8а кв.128\n                                            </td>\n                                        </tr>\n\n                                        <tr style="background-color: #eeeeee;">\n                                            <td width = "285" valign="top" height="25" style="padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;">\n                                                <div style="width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;">\n                                                    IBAN Code\n                                                </div>\n                                            </td>\n                                            <td height="25" valign="top" style="width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;">\n                                                UA323515330000026002057002108\n                                            </td>\n                                        </tr>\n\n                                        <tr>\n                                            <td width = "285" valign="top" height="25" style="padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;">\n                                                <div style="width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;">\n                                                    Банки-корреспонденты/correspondent banks\n                                                </div>\n                                                <div style="width: 100%; padding: 18px 0 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;">\n                                                    Счет в банке-корреспонденте/Account in the correspondent bank\n                                                </div>\n                                            </td>\n                                            <td height="25" valign="top" style="width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;">\n                                                001-1-000080\n                                            </td>\n                                        </tr>\n\n                                        <tr style="background-color: #eeeeee;">\n                                            <td width = "285" valign="top" height="25" style="padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;">\n                                                <div style="width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;">\n                                                    SWIFT Code\n                                                </div>\n                                                <div style="width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;">\n                                                    банка-корреспондента/SWIFT-code of the correspondent bank\n                                                </div>\n                                            </td>\n                                            <td height="25" valign="top" style="width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;">\n                                                CHASUS33\n                                            </td>\n                                        </tr>\n\n                                        <tr>\n                                            <td width = "285" valign="top" height="25" style="padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;">\n                                                <div style="width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;">\n                                                    Банк-корреспондент/correspondent bank\n                                                </div>\n                                            </td>\n                                            <td height="25" valign="top" style="width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;">\n                                                JP Morgan Chase Bank,New York ,USA\n                                            </td>\n                                        </tr>\n\n                                    </table>\n                                </td>\n                            </tr>'),
(22, 'Default payment method', '\n        <table width="570"\n       style=" margin-left: auto; margin-right: auto; border-collapse: collapse;">\n\n    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">\n        <td style =" vertical-align: top; border: 1px solid black; height: 100%; box-sizing: border-box; border-collapse: collapse; padding: 5px;">\n            <p><center><strong>Виконавець</strong></center></p>\n            <p>Бенефіциар: <strong>Прожога Олексій Юрійович</strong></p>\n            <p>Адреса бенефіциара: <strong>UA 08294 Київська обл., м. Буча</strong></p>\n            <p><strong>вул. Тарасiвська д.8а кв.128</strong></p>\n            <p>Рахунок бенефіциара: <strong>26002057002108</strong></p>\n            <p>SWIFT код: <strong>PBANUA2X</strong></p>\n            <p>Банк бенефіциара: <strong>Privatbank, Dnipropetrovsk, Ukraine</strong></p>\n            <p>IBAN Code: <strong>UA323515330000026002057002108</strong></p>\n            <p>Банк-корреспондент: <strong>JP Morgan</strong></p>\n            <p><strong>Chase Bank, New York,USA</strong></p>\n            <p>Рахунок у банку-кореспонденту: <strong>001-1-000080</strong></p>\n            <p>SWIFT код кореспондента: <strong>CHASUS33</strong></p>\n            <p>Прожога О.Ю.</p>\n            <img src="var_signature_Prozhoga" width="250px" height="150px">\n            <p>Підпис</p>\n        </td>\n        <td style =" vertical-align: top; border-collapse: collapse; border: 1px solid black; height: 100%; box-sizing: border-box; padding: 5px;">\n            <p><center><strong>Contractor</strong></center></p>\n            <p>BENEFICIARY: <strong>Prozhoga Oleksii Yuriyovich</strong></p>\n            <p>BENEFICIARY ADDRESS: <strong>UA 08294 Kiyv,</strong></p>\n            <p><strong>Bucha, Tarasivska st. 8a/128</strong></p>\n            <p>BENEFICIARY ACCOUNT: <strong>26002057002108</strong></p>\n            <p>SWIFT CODE: <strong>PBANUA2X</strong></p>\n            <p>BANK OF BENEFICIARY: <strong>Privatbank,</strong></p>\n            <p><strong>Dnipropetrovsk, Ukraine</strong></p>\n            <p>IBAN Code: <strong>UA323515330000026002057002108</strong></p>\n            <p>CORRESPONDENT BANK: <strong>JP Morgan</strong></p>\n            <p><strong>Chase Bank, New York,USA</strong></p>\n            <p>CORRESPONDENT ACCOUNT: <strong>001-1-000080</strong></p>\n            <p>SWIFT Code of correspondent bank: <strong>CHASUS33</strong></p>\n            <p>Prozhoga O.Y.</p>\n            <img src="var_signature_Prozhoga" width="250px" height="150px">\n            <p>Signature</p>\n        </td>\n    </tr>\n\n</table>\n        ');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jira_code` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_logged_hours` double DEFAULT NULL,
  `total_paid_hours` double DEFAULT NULL,
  `status` enum('NEW','ONHOLD','INPROGRESS','DONE','CANCELED') COLLATE utf8_unicode_ci DEFAULT 'NEW',
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT '0',
  `cost` decimal(10,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `jira_code`, `total_logged_hours`, `total_paid_hours`, `status`, `date_start`, `date_end`, `is_delete`, `cost`) VALUES
(1, 'Internal Skynix', 'INS', 0, NULL, 'INPROGRESS', '2016-01-11', '2016-05-01', 1, '0.00'),
(2, 'Marketplace Magento 2', 'MARM', 0, NULL, 'INPROGRESS', '2015-12-01', '2016-03-01', 1, NULL),
(3, 'Climatstore', 'CS', 0, NULL, 'DONE', '2015-01-01', '2015-02-01', 1, '0.00'),
(4, 'Facebook Platform', 'FPP', 0, NULL, 'NEW', '2015-05-01', '2015-05-07', 1, '0.00'),
(5, 'Terradash', 'TER', 0, NULL, 'INPROGRESS', '2014-05-01', '2016-02-26', 1, '0.00'),
(6, 'Skynix Test', '', 0, NULL, 'NEW', NULL, NULL, 1, '0.00'),
(7, 'QWERTY', '', 0, NULL, 'NEW', '2016-04-26', NULL, 1, '0.00'),
(8, 'TEST PTOJECT', '', 0, NULL, 'NEW', '2016-04-26', NULL, 1, '0.00'),
(9, 'Terradash', '', 0, NULL, 'NEW', '2016-04-26', NULL, 1, '0.00'),
(10, 'Facebook', '', 0, NULL, 'NEW', '2016-04-26', NULL, 1, '0.00'),
(11, 'Test MN', '', 0, NULL, 'INPROGRESS', NULL, NULL, 1, '0.00'),
(12, 'Magento', '', 0, NULL, 'INPROGRESS', NULL, NULL, 1, '0.00'),
(13, 'DEV Project', '', 0, NULL, 'NEW', NULL, NULL, 1, '0.00'),
(14, 'Facebook Platform', '', 0, NULL, 'NEW', NULL, NULL, 1, '0.00'),
(15, 'Magento2', '', 0, NULL, 'INPROGRESS', NULL, NULL, 1, '0.00'),
(16, 'Project Skynix', '', 0, NULL, 'NEW', NULL, NULL, 1, NULL),
(17, 'Magento Project', '', 0, NULL, 'INPROGRESS', NULL, NULL, 1, '0.00'),
(18, 'testingPDF', 'ааа', 0, NULL, 'INPROGRESS', '2016-04-20', '2016-04-29', 1, NULL),
(19, 'Sky', '', 0, NULL, 'NEW', NULL, NULL, 1, NULL),
(20, 'SKynix PM', 'ggg', 0, NULL, 'INPROGRESS', '2016-04-12', '2016-04-30', 1, NULL),
(21, 'SKynix PM2', 'ааа', 0, NULL, 'NEW', '2016-04-20', '2016-04-30', 1, NULL),
(22, 'SKynix PM3', 'ааа', 0, NULL, 'INPROGRESS', '2016-04-11', '2016-04-23', 1, NULL),
(23, 'SKynix4', 'ggg', 0, NULL, 'NEW', '2016-04-18', '2016-05-04', 1, NULL),
(24, 'Skynix5', 'ааа', 0, NULL, 'NEW', '2016-04-19', '2016-04-29', 1, NULL),
(25, 'Skynix Maryana', '', 0, NULL, 'NEW', NULL, NULL, 1, NULL),
(26, 'Magento Maryana', '', 0, NULL, 'NEW', NULL, NULL, 1, NULL),
(27, 'Handmade Theme', '', 0, NULL, 'NEW', NULL, NULL, 1, '0.00'),
(28, 'Dima Project', '', 0, NULL, 'NEW', NULL, NULL, 1, NULL),
(29, 'Client Project', '', 0, NULL, 'NEW', NULL, NULL, 1, NULL),
(30, 'Project Project', '', 0, NULL, 'NEW', NULL, NULL, 1, NULL),
(31, 'PM Project', '', 0, NULL, 'INPROGRESS', NULL, NULL, 1, '0.00'),
(32, 'Anya Client', '', 0, NULL, 'NEW', NULL, NULL, 1, NULL),
(33, 'testtesttest', '', 0, NULL, 'INPROGRESS', '2016-04-12', '2016-04-27', 1, NULL),
(34, 'PM Project Test', '', 0, NULL, 'NEW', NULL, NULL, 1, NULL),
(35, 'Skynix Project PM', '', 0, NULL, 'NEW', NULL, NULL, 1, NULL),
(36, '123456789', '', 0, NULL, 'NEW', NULL, NULL, 1, NULL),
(37, 'Test Project', '', 0, NULL, 'ONHOLD', NULL, NULL, 1, '0.00'),
(38, 'Project Admin', '', 0, NULL, 'NEW', NULL, NULL, 1, '0.00'),
(39, 'Project', '', 0, NULL, 'NEW', NULL, NULL, 1, '0.00'),
(40, '1234567', '', 0, NULL, 'NEW', NULL, NULL, 1, '0.00'),
(41, '12345467', '', 0, NULL, 'INPROGRESS', NULL, NULL, 1, NULL),
(42, 'АБВГД', '', 0, NULL, 'NEW', NULL, NULL, 1, NULL),
(43, 'ПРОЕКТ', '', 0, NULL, 'NEW', NULL, NULL, 1, NULL),
(44, 'ПРОЕКТ ПРОЕКТ', '', 0, NULL, 'NEW', NULL, NULL, 1, '0.00'),
(45, 'Report project', '', 1, NULL, 'NEW', '2016-06-30', NULL, 1, '0.00'),
(46, 'Support Project', '', 16, NULL, 'ONHOLD', '2016-06-15', NULL, 0, '0.90'),
(47, 'KAIA PROJECT', '', 5, NULL, 'DONE', NULL, NULL, 0, '0.00'),
(48, 'AD ptoject', '', 10, NULL, 'INPROGRESS', '2016-11-04', NULL, 0, '0.36'),
(49, 'Valuedestates', '', NULL, NULL, 'INPROGRESS', '2016-11-01', NULL, 0, NULL),
(50, 'New Project', '', 3, NULL, 'INPROGRESS', '2016-11-01', NULL, 0, '0.06'),
(51, 'Test Project', '', NULL, NULL, 'NEW', NULL, NULL, 0, NULL),
(52, 'PM Sales project', '', NULL, NULL, 'INPROGRESS', '2016-11-14', NULL, 0, NULL),
(53, 'Report Project', '', NULL, NULL, 'INPROGRESS', '2016-11-14', NULL, 1, NULL),
(54, 'All devs project', '', NULL, NULL, 'NEW', '2016-11-14', NULL, 1, NULL),
(55, 'Big project', '', NULL, NULL, 'NEW', '2016-11-14', NULL, 1, NULL),
(56, 'My Test PM', '', NULL, NULL, 'DONE', '2016-11-15', NULL, 0, NULL),
(57, 'My Sales test', '', NULL, NULL, 'ONHOLD', '2016-11-15', NULL, 0, NULL),
(58, 'Test for Sales', '', NULL, NULL, 'NEW', '2016-11-15', NULL, 0, NULL),
(59, 'Project test', '', NULL, NULL, 'NEW', '2016-11-15', NULL, 0, NULL),
(60, 'CRM project', '', NULL, NULL, 'NEW', '2016-11-15', NULL, 0, NULL),
(61, 'Test Dev', '', NULL, NULL, 'INPROGRESS', '2016-11-08', NULL, 0, NULL),
(62, 'FEI project', '', NULL, NULL, 'NEW', '2016-11-15', NULL, 0, NULL),
(63, 'Adversent', '', 9, NULL, 'INPROGRESS', '2016-11-02', NULL, 0, '0.18'),
(64, 'Client project', '', 7.5, 5, 'ONHOLD', '2016-11-23', NULL, 0, '0.39'),
(65, 'SI-385', '', 8, 1, 'INPROGRESS', NULL, NULL, 0, '0.12'),
(66, 'Radio project', '', NULL, NULL, 'ONHOLD', '2016-11-25', NULL, 0, NULL),
(67, 'test prohecty', '', 2, NULL, 'NEW', NULL, NULL, 0, '0.00'),
(68, 'test1', '', 11.73, NULL, 'INPROGRESS', NULL, NULL, 0, '0.00'),
(69, 'testPMsales', '', NULL, NULL, 'INPROGRESS', NULL, NULL, 0, NULL),
(70, 'test99', 'qwe', NULL, NULL, 'INPROGRESS', '2016-12-21', '2017-03-10', 1, '0.00'),
(71, 'SI-412 project', '1', 3, NULL, 'NEW', NULL, NULL, 0, '0.00'),
(72, 'AAAAAAAAAAAAAAAAAAAAAAA DOMOI', '1', 4, NULL, 'INPROGRESS', NULL, NULL, 0, '0.18'),
(73, 'ChangeDate1', '', NULL, NULL, 'NEW', '2016-12-22', '2016-12-23', 0, '0.00'),
(74, 'test', '', 6, NULL, 'NEW', '2016-12-01', '2016-12-02', 0, '0.36'),
(75, 'phpmyadmin', '1', NULL, NULL, 'NEW', '2016-12-02', '2016-12-09', 0, '0.00'),
(76, 'phpmyadmin', '1', NULL, NULL, 'NEW', '2016-12-02', '2016-12-09', 0, '0.00'),
(77, 'tralala', '1', 0, 6, 'NEW', '2016-12-01', '2016-12-02', 0, '0.00'),
(78, 'FINAL TEST', '1', NULL, NULL, 'NEW', '2016-11-30', '2016-12-01', 0, '0.00'),
(79, 'SI-409 project', '1', 7, NULL, 'NEW', NULL, NULL, 0, '0.18'),
(80, 'another one', '1', 8, NULL, 'INPROGRESS', NULL, NULL, 0, '0.30'),
(81, 'tralala', '1', 0.7, NULL, 'NEW', NULL, NULL, 1, '0.00'),
(82, 'test SI-412', '1', 3, NULL, 'INPROGRESS', NULL, NULL, 1, '0.00'),
(83, 'customer one', '1', NULL, NULL, 'NEW', NULL, NULL, 1, '0.00'),
(84, '21', 'asdasd', NULL, NULL, 'ONHOLD', NULL, NULL, 1, '0.00'),
(85, 'sadrfasd', '11', NULL, NULL, 'NEW', NULL, NULL, 0, '0.00'),
(86, '121', '', 3, NULL, 'NEW', NULL, NULL, 0, '0.18'),
(87, 'gf1', '213123', NULL, NULL, 'NEW', NULL, NULL, 0, '0.00'),
(88, 'gf2', '', NULL, NULL, 'NEW', '2017-01-01', '2017-01-18', 0, '0.00'),
(89, 'uyguyguyg', '102030', 0, NULL, 'INPROGRESS', NULL, NULL, 0, '0.00'),
(90, '213213', '', 2, NULL, 'NEW', NULL, NULL, 0, '0.12'),
(91, 'si400', '', NULL, NULL, 'NEW', NULL, NULL, 0, '0.00'),
(92, 'SI-564', '', 1, NULL, 'NEW', NULL, NULL, 0, '0.06');

-- --------------------------------------------------------

--
-- Table structure for table `project_customers`
--

CREATE TABLE `project_customers` (
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `receive_invoices` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `project_customers`
--

INSERT INTO `project_customers` (`user_id`, `project_id`, `receive_invoices`) VALUES
(1, 4, 0),
(1, 5, 0),
(5, 4, 0),
(5, 5, 0),
(5, 19, 1),
(5, 23, 0),
(5, 66, 1),
(5, 67, 1),
(5, 68, 1),
(5, 69, 1),
(5, 71, 1),
(5, 73, 1),
(5, 74, 1),
(5, 78, 1),
(5, 79, 1),
(5, 80, 1),
(5, 81, 1),
(5, 82, 1),
(5, 83, 1),
(5, 84, 1),
(5, 85, 1),
(5, 86, 1),
(5, 87, 1),
(5, 88, 1),
(5, 89, 1),
(5, 90, 1),
(5, 91, 1),
(5, 92, 0),
(6, 2, 0),
(6, 3, 0),
(6, 4, 0),
(6, 19, 0),
(6, 65, 1),
(6, 83, 0),
(7, 1, 0),
(7, 5, 0),
(7, 19, 0),
(7, 92, 1),
(8, 2, 1),
(8, 19, 0),
(8, 21, 1),
(8, 70, 1),
(9, 3, 0),
(9, 49, 1),
(9, 52, 1),
(9, 53, 0),
(9, 54, 0),
(9, 58, 1),
(9, 61, 1),
(9, 62, 1),
(15, 6, 1),
(15, 7, 1),
(15, 10, 1),
(15, 15, 0),
(15, 17, 0),
(15, 20, 0),
(15, 25, 1),
(15, 27, 1),
(15, 29, 1),
(15, 31, 0),
(15, 33, 1),
(15, 34, 1),
(15, 35, 1),
(15, 36, 1),
(15, 38, 1),
(15, 41, 1),
(15, 42, 1),
(15, 43, 1),
(15, 44, 1),
(15, 45, 1),
(15, 47, 1),
(15, 48, 1),
(15, 50, 1),
(15, 52, 0),
(15, 53, 1),
(15, 54, 1),
(15, 55, 1),
(15, 56, 1),
(15, 59, 1),
(15, 60, 1),
(15, 63, 1),
(15, 92, 0),
(16, 8, 1),
(16, 9, 1),
(16, 11, 0),
(16, 12, 0),
(16, 14, 1),
(16, 16, 1),
(18, 18, 1),
(19, 13, 1),
(19, 18, 0),
(19, 20, 1),
(19, 24, 1),
(19, 26, 1),
(19, 28, 1),
(19, 30, 1),
(19, 40, 1),
(20, 22, 0),
(20, 23, 1),
(23, 32, 1),
(23, 37, 1),
(23, 46, 1),
(23, 51, 1),
(23, 57, 1),
(23, 64, 1),
(25, 39, 1),
(25, 72, 1),
(25, 77, 1);

-- --------------------------------------------------------

--
-- Table structure for table `project_developers`
--

CREATE TABLE `project_developers` (
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `alias_user_id` int(11) DEFAULT NULL,
  `is_pm` tinyint(1) DEFAULT '0',
  `status` enum('ACTIVE','INACTIVE','HIDDEN') COLLATE utf8_unicode_ci DEFAULT 'ACTIVE',
  `is_sales` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `project_developers`
--

INSERT INTO `project_developers` (`user_id`, `project_id`, `alias_user_id`, `is_pm`, `status`, `is_sales`) VALUES
(1, 3, NULL, 0, 'ACTIVE', 0),
(1, 4, NULL, 0, 'INACTIVE', 0),
(1, 5, NULL, 0, 'INACTIVE', 0),
(1, 6, NULL, 1, 'ACTIVE', 0),
(1, 7, NULL, 1, 'ACTIVE', 0),
(1, 8, NULL, 1, 'ACTIVE', 0),
(1, 9, NULL, 1, 'ACTIVE', 0),
(1, 10, NULL, 1, 'ACTIVE', 0),
(1, 11, NULL, 0, 'ACTIVE', 0),
(1, 15, NULL, 0, 'ACTIVE', 0),
(1, 19, NULL, 1, 'ACTIVE', 0),
(1, 27, NULL, 1, 'ACTIVE', 0),
(1, 28, NULL, 1, 'ACTIVE', 0),
(1, 38, NULL, 1, 'ACTIVE', 0),
(1, 39, NULL, 1, 'ACTIVE', 0),
(1, 40, NULL, 1, 'ACTIVE', 0),
(1, 41, 2, 1, 'ACTIVE', 0),
(1, 42, NULL, 1, 'ACTIVE', 0),
(1, 43, NULL, 1, 'ACTIVE', 0),
(1, 44, NULL, 1, 'ACTIVE', 0),
(1, 45, NULL, 1, 'ACTIVE', 0),
(1, 46, NULL, 1, 'ACTIVE', 0),
(1, 47, 28, 1, 'ACTIVE', 0),
(1, 48, NULL, 0, 'ACTIVE', 0),
(1, 50, NULL, 0, 'ACTIVE', 0),
(1, 53, NULL, 0, 'ACTIVE', 0),
(1, 54, NULL, 0, 'ACTIVE', 0),
(1, 55, NULL, 0, 'ACTIVE', 0),
(1, 63, NULL, 0, 'ACTIVE', 0),
(1, 64, NULL, 1, 'ACTIVE', 1),
(1, 65, NULL, 0, 'ACTIVE', 0),
(1, 66, NULL, 1, 'ACTIVE', 0),
(1, 67, NULL, 1, 'ACTIVE', 1),
(1, 68, NULL, 1, 'ACTIVE', 1),
(1, 70, NULL, 0, 'ACTIVE', 0),
(1, 71, NULL, 1, 'ACTIVE', 1),
(1, 72, NULL, 0, 'ACTIVE', 0),
(1, 73, NULL, 1, 'ACTIVE', 1),
(1, 74, NULL, 1, 'ACTIVE', 1),
(1, 77, NULL, 1, 'ACTIVE', 1),
(1, 78, NULL, 1, 'ACTIVE', 1),
(1, 79, NULL, 1, 'ACTIVE', 0),
(1, 80, NULL, 0, 'ACTIVE', 0),
(1, 81, NULL, 1, 'ACTIVE', 1),
(1, 82, NULL, 1, 'ACTIVE', 0),
(1, 83, NULL, 1, 'ACTIVE', 1),
(1, 84, NULL, 1, 'ACTIVE', 1),
(1, 85, NULL, 1, 'ACTIVE', 1),
(1, 86, NULL, 1, 'ACTIVE', 1),
(1, 88, NULL, 1, 'ACTIVE', 1),
(1, 89, NULL, 1, 'ACTIVE', 1),
(1, 90, NULL, 1, 'ACTIVE', 1),
(1, 91, NULL, 1, 'ACTIVE', 0),
(1, 92, NULL, 0, 'ACTIVE', 1),
(2, 1, NULL, 0, 'ACTIVE', 0),
(2, 3, NULL, 0, 'ACTIVE', 0),
(2, 4, NULL, 0, 'ACTIVE', 0),
(2, 5, NULL, 0, 'ACTIVE', 0),
(2, 18, NULL, 1, 'ACTIVE', 0),
(2, 41, 3, 0, 'ACTIVE', 0),
(2, 50, NULL, 0, 'ACTIVE', 0),
(2, 53, NULL, 0, 'ACTIVE', 0),
(2, 54, NULL, 0, 'ACTIVE', 0),
(2, 55, NULL, 0, 'ACTIVE', 0),
(2, 60, NULL, 0, 'ACTIVE', 0),
(2, 67, NULL, 0, 'ACTIVE', 0),
(2, 70, NULL, 0, 'ACTIVE', 0),
(2, 81, NULL, 0, 'ACTIVE', 0),
(2, 87, NULL, 0, 'ACTIVE', 0),
(2, 92, NULL, 1, 'ACTIVE', 0),
(3, 2, NULL, 0, 'ACTIVE', 0),
(3, 4, NULL, 0, 'ACTIVE', 0),
(3, 18, NULL, 0, 'ACTIVE', 0),
(3, 19, NULL, 0, 'ACTIVE', 0),
(4, 2, NULL, 0, 'ACTIVE', 0),
(4, 5, NULL, 0, 'ACTIVE', 0),
(4, 50, NULL, 0, 'ACTIVE', 0),
(4, 53, NULL, 0, 'ACTIVE', 0),
(4, 54, NULL, 0, 'ACTIVE', 0),
(4, 55, NULL, 0, 'ACTIVE', 0),
(4, 60, NULL, 0, 'ACTIVE', 0),
(10, 19, NULL, 0, 'ACTIVE', 0),
(10, 49, NULL, 0, 'ACTIVE', 0),
(10, 53, NULL, 0, 'ACTIVE', 0),
(10, 54, NULL, 0, 'ACTIVE', 0),
(10, 55, NULL, 0, 'ACTIVE', 0),
(10, 70, NULL, 1, 'ACTIVE', 0),
(11, 34, NULL, 0, 'ACTIVE', 0),
(11, 53, NULL, 0, 'ACTIVE', 0),
(11, 54, NULL, 0, 'ACTIVE', 0),
(11, 55, NULL, 0, 'ACTIVE', 0),
(11, 62, NULL, 0, 'ACTIVE', 0),
(12, 12, NULL, 0, 'ACTIVE', 0),
(12, 13, NULL, 1, 'ACTIVE', 0),
(12, 14, NULL, 1, 'ACTIVE', 0),
(12, 15, NULL, 0, 'ACTIVE', 0),
(12, 26, NULL, 1, 'ACTIVE', 0),
(12, 45, NULL, 0, 'INACTIVE', 0),
(12, 46, NULL, 0, 'ACTIVE', 0),
(12, 53, NULL, 0, 'ACTIVE', 0),
(12, 54, NULL, 0, 'ACTIVE', 0),
(12, 55, NULL, 0, 'ACTIVE', 0),
(12, 59, NULL, 0, 'ACTIVE', 0),
(12, 60, NULL, 0, 'ACTIVE', 0),
(12, 61, NULL, 0, 'ACTIVE', 0),
(12, 64, NULL, 0, 'ACTIVE', 0),
(12, 79, NULL, 0, 'ACTIVE', 0),
(12, 91, NULL, 0, 'ACTIVE', 0),
(12, 92, NULL, 0, 'ACTIVE', 0),
(14, 16, NULL, 1, 'ACTIVE', 0),
(14, 17, NULL, 0, 'ACTIVE', 0),
(14, 25, NULL, 1, 'ACTIVE', 0),
(14, 31, NULL, 0, 'ACTIVE', 0),
(14, 34, NULL, 1, 'ACTIVE', 0),
(14, 35, NULL, 1, 'ACTIVE', 0),
(14, 36, NULL, 1, 'ACTIVE', 0),
(14, 37, NULL, 1, 'ACTIVE', 0),
(14, 46, NULL, 0, 'ACTIVE', 0),
(14, 48, NULL, 1, 'ACTIVE', 1),
(14, 50, NULL, 1, 'ACTIVE', 1),
(14, 52, NULL, 1, 'ACTIVE', 1),
(14, 53, NULL, 0, 'ACTIVE', 0),
(14, 54, NULL, 0, 'ACTIVE', 0),
(14, 55, NULL, 0, 'ACTIVE', 0),
(14, 56, NULL, 1, 'ACTIVE', 1),
(14, 60, NULL, 0, 'ACTIVE', 0),
(14, 62, NULL, 1, 'ACTIVE', 1),
(14, 65, NULL, 1, 'INACTIVE', 0),
(14, 70, NULL, 0, 'ACTIVE', 1),
(14, 79, NULL, 0, 'ACTIVE', 1),
(14, 80, NULL, 1, 'INACTIVE', 0),
(14, 87, NULL, 1, 'ACTIVE', 1),
(14, 91, NULL, 0, 'ACTIVE', 1),
(16, 52, NULL, 0, 'ACTIVE', 0),
(16, 53, NULL, 0, 'ACTIVE', 0),
(16, 54, NULL, 0, 'ACTIVE', 0),
(16, 55, NULL, 0, 'ACTIVE', 0),
(17, 12, 1, 0, 'ACTIVE', 0),
(17, 23, NULL, 1, 'ACTIVE', 0),
(17, 29, NULL, 1, 'ACTIVE', 0),
(17, 48, NULL, 0, 'ACTIVE', 0),
(17, 53, NULL, 0, 'ACTIVE', 0),
(17, 54, NULL, 0, 'ACTIVE', 0),
(17, 55, NULL, 0, 'ACTIVE', 0),
(17, 68, NULL, 0, 'ACTIVE', 0),
(18, 17, NULL, 0, 'ACTIVE', 0),
(18, 20, NULL, 1, 'ACTIVE', 0),
(18, 21, NULL, 1, 'ACTIVE', 0),
(18, 22, NULL, 0, 'ACTIVE', 0),
(18, 24, NULL, 1, 'ACTIVE', 0),
(18, 52, NULL, 0, 'ACTIVE', 0),
(18, 53, NULL, 0, 'ACTIVE', 0),
(18, 54, NULL, 0, 'ACTIVE', 0),
(18, 55, NULL, 0, 'ACTIVE', 0),
(22, 32, NULL, 1, 'ACTIVE', 0),
(22, 33, NULL, 1, 'ACTIVE', 0),
(22, 49, NULL, 0, 'ACTIVE', 0),
(22, 53, NULL, 0, 'ACTIVE', 0),
(22, 54, NULL, 0, 'ACTIVE', 0),
(22, 55, NULL, 0, 'ACTIVE', 0),
(23, 30, NULL, 1, 'ACTIVE', 0),
(24, 31, NULL, 0, 'ACTIVE', 0),
(24, 48, NULL, 0, 'ACTIVE', 0),
(24, 53, NULL, 0, 'ACTIVE', 0),
(24, 54, NULL, 0, 'ACTIVE', 0),
(24, 55, NULL, 0, 'ACTIVE', 0),
(24, 69, NULL, 0, 'ACTIVE', 0),
(26, 51, NULL, 0, 'ACTIVE', 0),
(26, 53, NULL, 0, 'ACTIVE', 0),
(26, 54, NULL, 0, 'ACTIVE', 0),
(26, 55, NULL, 0, 'ACTIVE', 0),
(26, 69, NULL, 1, 'ACTIVE', 0),
(27, 51, NULL, 0, 'ACTIVE', 0),
(27, 53, NULL, 0, 'ACTIVE', 0),
(27, 54, NULL, 0, 'ACTIVE', 0),
(27, 55, NULL, 0, 'ACTIVE', 0),
(27, 56, NULL, 0, 'ACTIVE', 0),
(27, 69, NULL, 0, 'ACTIVE', 1),
(28, 53, NULL, 0, 'ACTIVE', 0),
(28, 54, NULL, 0, 'ACTIVE', 0),
(28, 55, NULL, 0, 'ACTIVE', 0),
(30, 53, NULL, 0, 'ACTIVE', 0),
(30, 54, NULL, 0, 'ACTIVE', 0),
(30, 55, NULL, 0, 'ACTIVE', 0),
(31, 53, NULL, 0, 'ACTIVE', 0),
(31, 54, NULL, 0, 'ACTIVE', 0),
(31, 55, NULL, 0, 'ACTIVE', 0),
(32, 53, NULL, 0, 'ACTIVE', 0),
(32, 54, NULL, 0, 'ACTIVE', 0),
(32, 55, NULL, 0, 'ACTIVE', 0),
(48, 49, NULL, 1, 'ACTIVE', 1),
(48, 51, NULL, 1, 'ACTIVE', 1),
(48, 53, NULL, 1, 'ACTIVE', 1),
(48, 54, NULL, 1, 'ACTIVE', 1),
(48, 55, NULL, 1, 'ACTIVE', 1),
(48, 56, NULL, 0, 'ACTIVE', 0),
(48, 57, NULL, 1, 'ACTIVE', 1),
(48, 58, 2, 1, 'ACTIVE', 1),
(48, 59, NULL, 1, 'ACTIVE', 1),
(48, 60, NULL, 1, 'ACTIVE', 1),
(48, 61, NULL, 1, 'ACTIVE', 1),
(48, 63, NULL, 1, 'ACTIVE', 1),
(48, 66, NULL, 0, 'ACTIVE', 1),
(48, 82, NULL, 0, 'ACTIVE', 0),
(49, 58, NULL, 0, 'ACTIVE', 0),
(49, 63, NULL, 0, 'ACTIVE', 0),
(49, 65, NULL, 0, 'ACTIVE', 1),
(49, 82, NULL, 0, 'ACTIVE', 1),
(54, 68, NULL, 0, 'ACTIVE', 1),
(54, 80, NULL, 0, 'ACTIVE', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
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
  `cost` decimal(10,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `project_id`, `user_id`, `invoice_id`, `reporter_name`, `hours`, `task`, `date_added`, `date_paid`, `date_report`, `status`, `is_working_day`, `is_delete`, `cost`) VALUES
(1, 5, 4, NULL, 'Test User', 8, NULL, '2015-12-01', NULL, '2016-01-01', 'NEW', 1, 0, '0.00'),
(2, 5, 4, NULL, 'Test User', 8, 'Done task 3', '2015-12-02', NULL, '2015-12-02', 'NEW', 1, 0, '0.00'),
(3, 5, 4, NULL, 'Test User', 8, 'Done task 4', '2015-12-03', NULL, '2015-12-03', 'NEW', 1, 0, '0.00'),
(4, 5, 4, NULL, 'Test User', 8, 'Done task 5', '2015-12-04', NULL, '2015-12-04', 'NEW', 1, 0, '0.00'),
(6, 5, 5, NULL, 'Test User', 8, 'Done task 6', '2016-01-12', NULL, '2016-01-12', 'NEW', 1, 0, '0.00'),
(7, 1, 5, NULL, 'Test User', 8, 'Done task 7', '2016-01-12', NULL, '2016-01-12', 'NEW', 1, 0, '0.00'),
(8, 1, 5, NULL, 'Test User', 8, 'Done task 8', '2016-01-12', NULL, '2016-01-12', 'NEW', 1, 0, '0.00'),
(14, 3, 6, NULL, 'Test User', 4, 'Done task 10', '2016-01-12', NULL, '2016-01-13', 'NEW', 1, 0, '0.00'),
(15, 1, 2, NULL, 'Employee 1 ', 1.5, 'Configured DNS server', '2016-02-09', NULL, '2016-02-09', 'NEW', NULL, 0, '0.00'),
(16, 1, 2, NULL, 'Employee 1 ', 1, 'Tested core', '2016-02-09', NULL, '2016-02-09', 'NEW', NULL, 0, '0.00'),
(17, 1, 2, NULL, 'Employee 1 ', 0.25, 'UI hotfix', '2016-02-09', NULL, '2016-02-09', 'NEW', NULL, 0, '0.00'),
(18, 3, 2, NULL, 'Employee 1 ', 0.4, 'qqfgjn', '2016-02-10', NULL, '2016-02-10', 'NEW', NULL, 0, '0.00'),
(19, 1, 2, NULL, 'Employee 1 ', 2, 'fgsds', '2016-02-10', NULL, '2016-02-10', 'NEW', NULL, 0, '0.00'),
(21, 3, 2, NULL, 'Employee 1 ', 10, 'ww', '2016-02-10', NULL, '2016-02-10', 'NEW', NULL, 0, '0.00'),
(22, 1, 2, NULL, 'Employee 1 ', 5, 'qwerty', '2016-02-11', NULL, '2016-02-11', 'NEW', NULL, 0, '0.00'),
(23, 3, 2, NULL, 'Employee 1 ', 4, 'trewqq а', '2016-02-11', NULL, '2016-02-11', 'NEW', NULL, 0, '0.00'),
(25, 1, 2, NULL, 'Employee 1 ', 6, ' ва', '2016-02-11', NULL, '2016-02-11', 'NEW', NULL, 1, '0.00'),
(26, 4, 1, NULL, 'Oleksii Prozhoga', 1.6, 'Configured web server', '2016-02-16', NULL, '2016-02-16', 'NEW', NULL, 1, '0.00'),
(27, 5, 1, NULL, 'Oleksii Prozhoga', 3, 'Test repo ', '2016-02-16', NULL, '2016-02-16', 'NEW', NULL, 1, '0.00'),
(31, 5, 1, NULL, 'Oleksii Prozhoga', 5, 'Test', '2016-02-16', NULL, '2016-02-16', 'NEW', NULL, 1, '0.00'),
(32, 5, 1, NULL, 'Oleksii Prozhoga', 5, 'ttt', '2016-02-16', NULL, '2016-02-16', 'NEW', NULL, 1, '0.00'),
(33, 5, 1, NULL, 'Oleksii Prozhoga', 4, 'ttt', '2016-02-16', NULL, '2016-02-16', 'NEW', NULL, 1, '0.00'),
(34, 5, 1, NULL, 'Oleksii Prozhoga', 4, 'ееее', '2016-02-16', NULL, '2016-02-16', 'NEW', NULL, 1, '0.00'),
(35, 5, 1, NULL, 'Oleksii Prozhoga', 6, 'tttt', '2016-02-16', NULL, '2016-02-16', 'NEW', NULL, 1, '0.00'),
(36, 5, 1, NULL, 'Oleksii Prozhoga', 4, 'ttt', '2016-02-16', NULL, '2016-02-16', 'NEW', NULL, 1, '0.00'),
(37, 4, 1, NULL, 'Oleksii Prozhoga', 4, 'tttttt', '2016-02-16', NULL, '2016-02-16', 'NEW', NULL, 1, '0.00'),
(38, 4, 1, NULL, 'Oleksii Prozhoga', 5, 'r', '2016-02-16', NULL, '2016-02-16', 'NEW', NULL, 1, '0.00'),
(39, 4, 1, NULL, 'Oleksii Prozhoga', 6, 'r', '2016-02-16', NULL, '2016-02-16', 'NEW', NULL, 1, '0.00'),
(40, 5, 1, NULL, 'Oleksii Prozhoga', 1, 'Test ', '2016-02-21', NULL, '2016-02-21', 'NEW', NULL, 1, '0.00'),
(47, 4, 1, NULL, 'Oleksii Prozhoga', 2, ' My Report', '2016-02-29', NULL, '2016-02-29', 'NEW', NULL, 1, '0.00'),
(49, 4, 1, NULL, 'Oleksii Prozhoga', 2, 'My Reportfgh', '2016-03-01', NULL, '2016-03-01', 'NEW', NULL, 1, '0.00'),
(53, 8, 1, NULL, 'Oleksii Prozhoga', 1, 'test test test test test test test test test test', '2016-04-26', NULL, '2016-04-26', 'NEW', NULL, 1, '0.00'),
(54, 8, 1, NULL, 'Oleksii Prozhoga', 1, 'test test test test test test test test test test', '2016-04-26', NULL, '2016-04-26', 'NEW', NULL, 1, '0.00'),
(55, 9, 1, NULL, 'Oleksii Prozhoga', 1, 'test test test test test test test test test test', '2016-04-26', NULL, '2016-04-26', 'NEW', NULL, 1, '0.00'),
(56, 4, 1, NULL, 'Oleksii Prozhoga', 10, 'test test test test test test test test test test', '2016-04-26', NULL, '2016-04-26', 'NEW', NULL, 1, '0.00'),
(61, 11, 1, NULL, 'Oleksii Prozhoga', 0.1, 'test test test test test test test test test test', '2016-04-26', NULL, '2016-04-01', 'NEW', NULL, 1, '0.00'),
(63, 4, 1, NULL, 'Oleksii Prozhoga', 10, 'test test test test test test test test test test', '2016-04-26', NULL, '2016-04-26', 'NEW', NULL, 1, '0.00'),
(67, 4, 1, NULL, 'Oleksii Prozhoga', 1, 'test test test test test test test test test test', '2016-04-26', NULL, '2016-04-26', 'NEW', NULL, 1, '0.00'),
(78, 4, 1, NULL, 'Oleksii Prozhoga', 1, 'test test test test test test test test test test', '2016-04-26', NULL, '2016-04-26', 'NEW', NULL, 1, '0.00'),
(92, 28, 1, NULL, 'Oleksii Prozhoga', 1, 'test test test test test test test test test test', '2016-04-29', NULL, '2016-04-29', 'NEW', NULL, 1, '0.00'),
(96, 38, 1, NULL, 'Oleksii Prozhoga', 1, 'test test test test test test test test test test', '2016-04-29', NULL, '2016-04-29', 'NEW', NULL, 1, '0.00'),
(99, 37, 14, NULL, 'PM USER', 1, 'test test test test test test test test test test', '2016-04-29', NULL, '2016-04-29', 'NEW', NULL, 0, '0.00'),
(102, 37, 14, NULL, 'PM USER', 1, 'rtydfgjjk;.kl/;hk\'szerdtuhjljkl;k\'', '2016-04-29', NULL, '2016-04-29', 'NEW', NULL, 0, '0.00'),
(104, 42, 1, NULL, 'Oleksii Prozhoga', 1, 'Reading Magento2 User Guide', '2016-04-29', NULL, '2016-04-29', 'NEW', NULL, 1, '0.00'),
(106, 43, 1, NULL, 'Oleksii Prozhoga', 1, 'test test test test test test test test test test', '2016-04-29', NULL, '2016-04-29', 'NEW', NULL, 1, '0.00'),
(107, 44, 1, NULL, 'Oleksii Prozhoga', 1, 'test test test test test test test test test test', '2016-04-29', NULL, '2016-04-29', 'NEW', NULL, 1, '0.00'),
(108, 44, 1, NULL, 'Oleksii Prozhoga', 1, 'test test test test test test test test test test', '2016-04-29', NULL, '2016-04-29', 'NEW', NULL, 1, '0.00'),
(109, 44, 1, NULL, 'Oleksii Prozhoga', 1, 'test test test test test test test test test test', '2016-04-29', NULL, '2016-04-29', 'NEW', NULL, 1, '0.00'),
(110, 44, 1, NULL, 'Oleksii Prozhoga', 1, 'test test test test test test test test test test', '2016-04-29', NULL, '2016-04-29', 'NEW', NULL, 1, '0.00'),
(112, 4, 1, NULL, 'Oleksii Prozhoga', 10, 'test project 12332323', '2016-05-15', NULL, '2016-05-15', 'NEW', NULL, 0, '0.00'),
(113, 11, 1, NULL, 'Oleksii Prozhoga', 4, 'с ки пипп п п паипа усу2', '2016-05-27', NULL, '2016-05-27', 'NEW', NULL, 0, '0.00'),
(114, 8, 1, NULL, 'Oleksii Prozhoga', 3, 'авівмfd f df sdffadvdfvadfvfadv', '2016-05-27', NULL, '2016-05-27', 'NEW', NULL, 0, '0.00'),
(115, 7, 1, NULL, 'Oleksii Prozhoga', 4, 'Test eport ev egf sgf gf sgf ffff', '2016-05-31', NULL, '2016-05-31', 'NEW', NULL, 0, '0.00'),
(116, 9, 1, NULL, 'Oleksii Prozhoga', 1, 'eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeekk', '2016-05-31', NULL, '2016-05-25', 'NEW', NULL, 0, '0.00'),
(117, 7, 1, NULL, 'Oleksii Prozhoga', 3, 'Test Report 123 4566', '2016-05-31', NULL, '2016-05-31', 'NEW', NULL, 0, '0.00'),
(118, 8, 1, NULL, 'Oleksii Prozhoga', 5, 'dddddddddddddddddddddddddd', '2016-05-31', NULL, '2016-05-31', 'NEW', NULL, 0, '0.00'),
(120, 39, 1, NULL, 'Oleksii Prozhoga', 3, 'Internal meeting with developers on tasks in Jira (Surveys, Profile), testing tasks from QA column in Jira', '2016-06-30', NULL, '2016-06-30', 'NEW', NULL, 1, '0.00'),
(121, 44, 1, NULL, 'Oleksii Prozhoga', 5, 'Internal meeting with developers on tasks in Jira (Surveys, Profile), testing tasks from QA column in Jira', '2016-06-30', NULL, '2016-06-29', 'NEW', NULL, 1, '0.00'),
(122, 39, 1, NULL, 'Oleksii Prozhoga', 1, 'Testing Time Reporting System', '2016-06-30', NULL, '2016-06-30', 'NEW', NULL, 1, '0.00'),
(123, 28, 1, NULL, 'Oleksii Prozhoga', 7, 'Testing Time Reporting System/My Report, Support', '2016-06-30', NULL, '2016-06-30', 'NEW', NULL, 1, '0.00'),
(124, 45, 1, NULL, 'Oleksii Prozhoga', 9, 'Time Reporting System', '2016-06-30', NULL, '2016-06-29', 'NEW', NULL, 1, '0.00'),
(125, 45, 12, NULL, 'DEV USER', 2, 'Ukrainian Localization of Magento2 (Stores, System)', '2016-06-30', NULL, '2016-06-30', 'NEW', NULL, 0, '0.00'),
(126, 45, 1, NULL, 'Oleksii Prozhoga', 10, 'Testing Time Reporting System', '2016-06-30', NULL, '2016-06-30', 'NEW', NULL, 1, '0.00'),
(127, 45, 1, NULL, 'Oleksii Prozhoga', 9, 'Testing Time Reporting System', '2016-06-30', NULL, '2016-06-30', 'NEW', NULL, 1, '0.00'),
(128, 45, 1, NULL, 'Oleksii Prozhoga', 9, 'Time Reporting System', '2016-06-30', NULL, '2016-06-30', 'NEW', NULL, 1, '0.00'),
(129, 45, 1, NULL, 'Oleksii Prozhoga', 1, 'Testing Time Reporting System', '2016-06-30', NULL, '2016-06-30', 'NEW', NULL, 1, '0.00'),
(130, 45, 1, NULL, 'Oleksii Prozhoga', 10, 'Time Reporting System', '2016-06-30', NULL, '2016-06-29', 'NEW', NULL, 1, '0.00'),
(131, 45, 1, NULL, 'Oleksii Prozhoga', 1, 'Testing Time Reporting System', '2016-06-30', NULL, '2016-06-29', 'NEW', NULL, 1, '0.00'),
(132, 45, 1, NULL, 'Oleksii Prozhoga', 1, 'Testing Time Reporting System', '2016-06-30', NULL, '2016-06-29', 'NEW', NULL, 1, '0.00'),
(133, 46, 1, NULL, 'Oleksii Prozhoga', 5, 'Testing Time Reporting System/My Report, Support', '2016-06-30', NULL, '2016-06-14', 'NEW', NULL, 1, '0.00'),
(134, 45, 1, NULL, 'Oleksii Prozhoga', 0.1, 'Test test Test test Test test Test test Test test Report project', '2016-06-30', NULL, '2016-06-30', 'NEW', NULL, 1, '0.00'),
(135, 45, 1, NULL, 'Oleksii Prozhoga', 10, 'Testing Time Reporting System', '2016-06-30', NULL, '2016-06-30', 'NEW', NULL, 1, '0.00'),
(136, 45, 1, NULL, 'Oleksii Prozhoga', 1, 'Testing Time Reporting System', '2016-07-01', NULL, '2016-07-01', 'NEW', NULL, 1, '0.00'),
(137, 45, 1, NULL, 'Oleksii Prozhoga', 1, 'Test teasrt test tewatr', '2016-07-01', NULL, '2016-07-01', 'NEW', NULL, 1, '0.00'),
(138, 45, 1, NULL, 'Oleksii Prozhoga', 2, 'hjfkdjk s;kldfjks;lfks;lfk; ;slfk;lfk;kf;kl', '2016-07-01', NULL, '2016-07-01', 'NEW', NULL, 1, '0.00'),
(139, 47, 1, NULL, 'Oleksii Prozhoga', 1, 'aaaaaaaaaaaaaaaaaaaaaaa', '2016-11-27', NULL, '2016-11-27', 'NEW', NULL, 0, '0.00'),
(140, 45, 1, NULL, 'Oleksii Prozhoga', 2, 'aaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-11-27', NULL, '2016-11-27', 'NEW', NULL, 0, '0.00'),
(141, 50, 1, NULL, 'Oleksii Prozhoga', 1, 'aaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-11-27', NULL, '2016-11-27', 'NEW', NULL, 0, '0.00'),
(142, 47, 1, NULL, 'Oleksii Prozhoga', 2, 'aaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-11-27', NULL, '2016-11-27', 'NEW', NULL, 0, '0.00'),
(143, 45, 1, NULL, 'Oleksii Prozhoga', 1, 'aaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-11-27', NULL, '2016-11-27', 'NEW', NULL, 0, '0.00'),
(144, 47, 1, NULL, 'Oleksii Prozhoga', 1, 'aaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-11-27', NULL, '2016-11-27', 'NEW', NULL, 0, '0.00'),
(146, 64, 1, NULL, 'Oleksii Prozhoga', 1, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-11-27', NULL, '2016-11-27', 'NEW', NULL, 0, '0.00'),
(147, 67, 1, NULL, 'Oleksii Prozhoga', 2, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-11-27', NULL, '2016-11-27', 'NEW', NULL, 0, '0.00'),
(148, 46, 1, NULL, 'Oleksii Prozhoga', 1, 'aaaaaaaaaaaaaaaaaaaa1', '2016-11-30', NULL, '2016-11-30', 'NEW', NULL, 0, '0.00'),
(149, 47, 1, NULL, 'Oleksii Prozhoga', 1, 'aaaaaaaaaaaaaaaaaaaa2', '2016-11-30', NULL, '2016-11-30', 'NEW', NULL, 1, '0.00'),
(150, 50, 1, NULL, 'Oleksii Prozhoga', 1, 'aaaaaaaaaaaaaaaaaaaa', '2016-11-30', NULL, '2016-11-30', 'NEW', NULL, 0, '0.00'),
(151, 50, 1, NULL, 'Oleksii Prozhoga', 1, 'aaaaaaaaaaaaaaaaaaaa1', '2016-11-30', NULL, '2016-11-30', 'NEW', NULL, 0, '0.00'),
(152, 71, 1, NULL, 'Oleksii Prozhoga', 3, 'tralalalalalalalalalaa', '2016-12-10', NULL, '2016-12-10', 'NEW', NULL, 0, '0.00'),
(153, 47, 1, NULL, 'Oleksii Prozhoga', 1, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-12-10', NULL, '2016-12-10', 'NEW', NULL, 0, '0.00'),
(154, 68, 1, NULL, 'Oleksii Prozhoga', 6, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-12-10', NULL, '2016-12-10', 'NEW', NULL, 0, '0.00'),
(155, 68, 2, NULL, 'Employee 1 ', 4, 'emploemploemploemploemploemplo', '2016-12-10', NULL, '2016-12-10', 'NEW', NULL, 0, '0.00'),
(156, 72, 1, NULL, 'Oleksii Prozhoga', 1, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-12-10', NULL, '2016-12-10', 'NEW', NULL, 0, '0.00'),
(157, 72, 1, NULL, 'Oleksii Prozhoga', 1, '2222222222222222222222222222222222', '2016-12-10', NULL, '2016-12-10', 'NEW', NULL, 0, '0.00'),
(158, 79, 12, NULL, 'DEV USER', 1, 'report SI-409report SI-409report SI-409report SI-409', '2016-12-14', NULL, '2016-12-14', 'NEW', NULL, 0, '0.00'),
(159, 80, 1, NULL, 'Oleksii Prozhoga', 1, 'tralalalalalalaaaaaaaaa', '2016-12-14', NULL, '2016-12-14', 'NEW', NULL, 0, '0.00'),
(160, 81, 1, NULL, 'Oleksii Prozhoga', 0.5, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-12-14', NULL, '2016-12-14', 'NEW', NULL, 0, '0.00'),
(161, 81, 1, NULL, 'Oleksii Prozhoga', 0.2, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-12-14', NULL, '2016-12-14', 'NEW', NULL, 0, '0.00'),
(162, 68, 1, NULL, 'Oleksii Prozhoga', 0.23, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-12-14', NULL, '2016-12-14', 'NEW', NULL, 0, '0.00'),
(163, 82, 1, NULL, 'Oleksii Prozhoga', 1, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-12-14', NULL, '2016-12-14', 'NEW', NULL, 0, '0.00'),
(164, 82, 1, NULL, 'Oleksii Prozhoga', 2, '222222222222222222222222222222222222222222222222222222', '2016-12-14', NULL, '2016-12-14', 'NEW', NULL, 0, '0.00'),
(166, 48, 1, NULL, 'Oleksii Prozhoga', 2, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-12-15', NULL, '2016-12-15', 'NEW', NULL, 0, '0.00'),
(167, 63, 1, NULL, 'Oleksii Prozhoga', 1, 'aaaaaaaaaaaaaaaaaaaaadver', '2016-12-15', NULL, '2016-12-15', 'NEW', NULL, 0, '0.00'),
(168, 80, 1, NULL, 'Oleksii Prozhoga', 1, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-12-15', NULL, '2016-12-15', 'NEW', NULL, 0, '0.00'),
(169, 79, 1, NULL, 'Oleksii Prozhoga', 1, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-12-15', NULL, '2016-12-15', 'NEW', NULL, 0, '0.00'),
(170, 80, 1, NULL, 'Oleksii Prozhoga', 2, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-12-15', NULL, '2016-12-15', 'NEW', NULL, 0, '0.00'),
(171, 46, 1, NULL, 'Oleksii Prozhoga', 1, 'aaaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-12-16', NULL, '2016-12-16', 'NEW', NULL, 1, '0.00'),
(172, 48, 1, NULL, 'Oleksii Prozhoga', 1, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-12-16', NULL, '2016-12-16', 'NEW', NULL, 0, '0.00'),
(173, 63, 1, NULL, 'Oleksii Prozhoga', 1, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-12-19', NULL, '2016-12-19', 'NEW', NULL, 0, '0.00'),
(174, 63, 1, NULL, 'Oleksii Prozhoga', 2, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-12-19', NULL, '2016-12-19', 'NEW', NULL, 0, '0.00'),
(175, 47, 1, NULL, 'Oleksii Prozhoga', 1, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-12-19', NULL, '2016-12-19', 'NEW', NULL, 0, '0.00'),
(177, 63, 1, NULL, 'Oleksii Prozhoga', 1, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-12-19', NULL, '2016-12-19', 'NEW', NULL, 0, '0.00'),
(178, 68, 1, NULL, 'Oleksii Prozhoga', 1.5, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-12-20', NULL, '2016-12-20', 'NEW', NULL, 0, '0.00'),
(179, 48, 1, NULL, 'Oleksii Prozhoga', 5, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-12-20', NULL, '2016-12-20', 'NEW', NULL, 0, '0.00'),
(180, 63, 1, NULL, 'Oleksii Prozhoga', 2, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-12-20', NULL, '2016-12-20', 'NEW', NULL, 0, '0.00'),
(181, 79, 1, NULL, 'Oleksii Prozhoga', 1, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-12-20', NULL, '2016-12-20', 'NEW', NULL, 0, '0.00'),
(182, 79, 1, NULL, 'Oleksii Prozhoga', 1, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-12-20', NULL, '2016-12-20', 'NEW', NULL, 0, '1.00'),
(183, 79, 1, NULL, 'Oleksii Prozhoga', 1, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-12-20', NULL, '2016-12-20', 'NEW', NULL, 0, '0.06'),
(184, 79, 12, NULL, 'DEV USER', 2, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2016-12-28', NULL, '2016-12-22', 'NEW', NULL, 0, '0.00'),
(185, 63, 1, NULL, 'Oleksii Prozhoga', 1, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2017-01-03', NULL, '2016-12-12', 'NEW', NULL, 0, '0.06'),
(186, 80, 1, NULL, 'Oleksii Prozhoga', 5, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2017-01-03', NULL, '2016-12-12', 'NEW', NULL, 0, '0.30'),
(187, 65, 1, 95, 'Oleksii Prozhoga', 2, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2017-01-03', NULL, '2016-12-12', 'INVOICED', NULL, 0, '0.12'),
(189, 77, 1, NULL, 'Oleksii Prozhoga', 6, 'STATUS_PAIDSTATUS_PAIDSTATUS_PAIDSTATUS_PAIDSTATUS_PAIDSTATUS_PAIDSTATUS_PAIDSTATUS_PAIDSTATUS_PAIDSTATUS_PAID', '2017-01-04', NULL, '2017-01-01', 'NEW', NULL, 1, '0.36'),
(190, 48, 1, 96, 'Oleksii Prozhoga', 8, 'ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff', '2017-01-06', NULL, '2017-01-02', 'INVOICED', NULL, 0, '0.06'),
(191, 72, 1, 91, 'Oleksii Prozhoga', 3, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2017-01-06', NULL, '2017-01-06', 'INVOICED', NULL, 0, '0.18'),
(192, 89, 1, NULL, 'Oleksii Prozhoga', 2, 'ojuigigyfttdrfjhtfyujf yuty ut8ytuyt jvkljhguyh`', '2017-01-10', NULL, '2017-01-10', 'NEW', NULL, 1, '0.12'),
(193, 89, 1, NULL, 'Oleksii Prozhoga', 1, 'ojuigigyfttdrfjhtfyujf yuty ut8ytuyt jvkljhguyh`', '2017-01-10', NULL, '2017-01-10', 'NEW', NULL, 1, '0.06'),
(194, 47, 1, NULL, 'Oleksii Prozhoga', 2, 'asdadasaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2017-01-10', NULL, '2017-01-10', 'NEW', NULL, 1, '0.12'),
(195, 47, 1, NULL, 'Oleksii Prozhoga', 3, 'asdadasaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2017-01-10', NULL, '2017-01-10', 'NEW', NULL, 1, '0.18'),
(196, 89, 1, NULL, 'Oleksii Prozhoga', 2, 'asdadasaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2017-01-10', NULL, '2017-01-10', 'NEW', NULL, 1, '0.12'),
(197, 90, 1, NULL, 'Oleksii Prozhoga', 1, '7b182db9c1f98b52570f6713e2111229c6f7ab05', '2017-01-10', NULL, '2017-01-10', 'NEW', NULL, 1, '0.06'),
(198, 90, 1, 104, 'Oleksii Prozhoga', 1, '7b182db9c1f98b52570f6713e2111229c6f7ab057b182db9c1f98b52570f6713e2111229c6f7ab05', '2017-01-10', NULL, '2017-01-10', 'INVOICED', NULL, 0, '0.06'),
(199, 80, 1, 104, 'Oleksii Prozhoga', 5, 'git fetch && git checkout SI-532-date-filter-selector-on-my-reportgit fetch && git checkout SI-532-date-filter-selector-on-my-report', '2017-01-11', NULL, '2017-01-11', 'INVOICED', NULL, 0, '0.06'),
(200, 46, 1, NULL, 'Oleksii Prozhoga', 2, 'git fetch && git checkout SI-532-date-filter-selector-on-my-reportgit fetch && git checkout SI-532-date-filter-selector-on-my-report', '2017-01-11', NULL, '2016-11-08', 'NEW', NULL, 1, '0.12'),
(202, 92, 1, 104, 'Oleksii Prozhoga', 1, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2017-01-20', NULL, '2017-01-20', 'INVOICED', NULL, 0, '0.06'),
(203, 74, 1, 104, 'Oleksii Prozhoga', 1, 'You can not add/edit this report. Maximum total hours is 12You can not add/edit this report. Maximum total hours is 12', '2017-01-20', NULL, '2017-01-20', 'INVOICED', NULL, 0, '0.06'),
(204, 74, 1, 104, 'Oleksii Prozhoga', 1, 'You can not add/edit this report. Maximum total hours is 12', '2017-01-20', NULL, '2017-01-20', 'INVOICED', NULL, 0, '0.06'),
(205, 74, 1, 104, 'Oleksii Prozhoga', 1, 'You can not add/edit this report. Maximum total hours is 12', '2017-01-20', NULL, '2017-01-20', 'INVOICED', NULL, 0, '0.06'),
(206, 74, 1, 104, 'Oleksii Prozhoga', 1, 'You can not add/edit this report. Maximum total hours is 12', '2017-01-20', NULL, '2017-01-20', 'INVOICED', NULL, 0, '0.06'),
(207, 74, 1, 104, 'Oleksii Prozhoga', 1, 'You can not add/edit this report. Maximum total hours is 12', '2017-01-20', NULL, '2017-01-20', 'INVOICED', NULL, 0, '0.06'),
(208, 74, 1, 104, 'Oleksii Prozhoga', 1, 'You can not add/edit this report. Maximum total hours is 12', '2017-01-20', NULL, '2017-01-20', 'INVOICED', NULL, 0, '0.06'),
(209, 86, 1, NULL, 'Oleksii Prozhoga', 1, 'git fetch && git checkout SI-608-reports-total-hours-is-wrong-calcgit fetch && git checkout SI-608-reports-total-hours-is-wrong-calcgit fetch && git checkout SI-608-reports-total-hours-is-wrong-calc', '2017-01-24', NULL, '2017-01-24', 'NEW', NULL, 0, '0.06'),
(210, 86, 1, NULL, 'Oleksii Prozhoga', 2.8, 'git fetch && git checkout SI-608-reports-total-hours-is-wrong-calcgit fetch && git checkout SI-608-reports-total-hours-is-wrong-calcgit fetch && git checkout SI-608-reports-total-hours-is-wrong-calc', '2017-01-24', NULL, '2017-01-24', 'NEW', NULL, 0, '0.12'),
(211, 50, 1, NULL, 'Oleksii Prozhoga', 1.5, 'git fetch && git checkout SI-608-reports-total-hours-is-wrong-calcgit fetch && git checkout SI-608-reports-total-hours-is-wrong-calc', '2017-01-24', NULL, '2017-01-22', 'NEW', NULL, 0, '0.06');

-- --------------------------------------------------------

--
-- Table structure for table `salary_history`
--

CREATE TABLE `salary_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `extra_amount` decimal(10,2) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` int(11) NOT NULL,
  `subject` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `is_private` tinyint(1) DEFAULT '0',
  `assignet_to` int(11) DEFAULT NULL,
  `status` enum('NEW','ASSIGNED','COMPLETED','CANCELLED') COLLATE utf8_unicode_ci DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_completed` datetime DEFAULT NULL,
  `date_cancelled` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `support_tickets`
--

INSERT INTO `support_tickets` (`id`, `subject`, `description`, `is_private`, `assignet_to`, `status`, `client_id`, `date_added`, `date_completed`, `date_cancelled`) VALUES
(1, 'guest support page', 'support page', 0, NULL, 'COMPLETED', 33, '2016-06-24 11:38:32', NULL, NULL),
(2, 'new account', 'new account', 0, NULL, 'COMPLETED', 34, '2016-06-24 11:59:47', NULL, NULL),
(3, 'again and again', 'description', 0, NULL, 'COMPLETED', 34, '2016-06-24 12:27:13', NULL, NULL),
(4, 'subject ticket', 'subject subject', 0, NULL, 'COMPLETED', 35, '2016-06-24 12:38:47', NULL, NULL),
(5, 'test test test', 'тест', 1, NULL, 'NEW', 33, '2016-06-24 14:51:05', NULL, NULL),
(6, 'ski project', 'test test', 1, NULL, 'NEW', 33, '2016-06-24 14:57:04', NULL, NULL),
(7, 'forbidden ticket', 'test test ', 1, NULL, 'NEW', 34, '2016-06-24 14:59:01', NULL, NULL),
(8, 'weather weather weathe', 'test test test', 0, NULL, 'NEW', 36, '2016-06-24 15:04:16', NULL, NULL),
(9, 'task task', 'test test', 1, NULL, 'NEW', 37, '2016-06-24 15:10:06', NULL, NULL),
(10, 'my ticket', 'test test ', 1, NULL, 'NEW', 34, '2016-06-24 15:21:48', NULL, NULL),
(11, 'staging test', 'test', 0, NULL, 'NEW', 38, '2016-06-24 15:55:48', NULL, NULL),
(12, 'mmmmmmmmmmmmmmmmmmm', 'test', 1, NULL, 'NEW', 39, '2016-06-24 16:11:31', NULL, NULL),
(13, 'ttttttttttttttttttttttttttttttttttttttttt', 'test', 1, NULL, 'NEW', 39, '2016-06-24 16:48:13', NULL, NULL),
(14, 'test test test test', 'gfdgdgdgdgdgd', 1, NULL, 'NEW', 39, '2016-06-24 17:01:13', NULL, NULL),
(15, 'kevin spacey', 'test', 1, NULL, 'NEW', 40, '2016-06-24 17:27:47', NULL, NULL),
(16, 'bug bug bug', 'test test', 1, NULL, 'NEW', 40, '2016-06-24 17:52:00', NULL, NULL),
(17, 'tra ta ta', 'test', 1, NULL, 'NEW', 40, '2016-06-24 18:07:57', NULL, NULL),
(18, 'blank field', 'test', 1, NULL, 'NEW', 34, '2016-06-24 18:28:33', NULL, NULL),
(19, 'Maryana test', 'test test', 1, NULL, 'NEW', 34, '2016-06-29 10:52:25', NULL, NULL),
(20, 'brum brum brum', 'test', 1, NULL, 'NEW', 34, '2016-06-29 11:00:34', NULL, NULL),
(21, 'gfhfhfhfhfhghg', 'test', 1, NULL, 'NEW', 34, '2016-06-29 11:02:50', NULL, NULL),
(22, 'dfgdgdgdgdg', 'dgfdgdgdd', 1, 14, 'CANCELLED', 34, '2016-06-29 11:04:39', NULL, '2016-06-29 17:37:10'),
(23, 'not existing user', 'timur test', 1, NULL, 'NEW', 41, '2016-06-29 12:55:56', NULL, NULL),
(24, 'not active user', 'test test', 1, NULL, 'NEW', 42, '2016-06-29 13:49:26', NULL, NULL),
(25, 'my request', 'test', 1, NULL, 'NEW', 41, '2016-06-29 13:52:14', NULL, NULL),
(26, 'so so so', 'test', 1, NULL, 'NEW', 43, '2016-06-29 13:58:36', NULL, NULL),
(27, 'true task', 'test task', 1, NULL, 'CANCELLED', 44, '2016-06-29 14:10:42', NULL, '2016-06-29 16:31:33'),
(28, 'test test test', 'test', 1, 17, 'ASSIGNED', 45, '2016-06-29 14:27:28', NULL, NULL),
(29, 'enter the text', 'test', 0, NULL, 'COMPLETED', 45, '2016-06-29 14:40:56', '2016-06-29 16:23:31', NULL),
(30, 'qwety pass', 'test', 1, NULL, 'COMPLETED', 45, '2016-06-29 14:52:23', '2016-06-29 16:20:34', NULL),
(31, 'staging', 'test', 1, NULL, 'NEW', 45, '2016-06-29 15:35:32', NULL, NULL),
(32, 'testing testing testing testing', 'test', 1, NULL, 'NEW', 45, '2016-06-29 15:51:15', NULL, NULL),
(33, 'silence', 'test', 1, 24, 'ASSIGNED', 46, '2016-06-29 15:57:21', NULL, NULL),
(34, 'question', 'test', 1, NULL, 'CANCELLED', 45, '2016-06-29 16:32:10', NULL, '2016-06-29 16:35:02'),
(35, 'cancelled', '123456789', 1, 22, 'ASSIGNED', 45, '2016-06-29 16:37:17', NULL, NULL),
(36, 'user test', 'test', 1, 26, 'ASSIGNED', 45, '2016-06-29 16:54:35', NULL, NULL),
(37, 'assign function', 'test', 1, 26, 'ASSIGNED', 45, '2016-06-29 17:11:33', NULL, NULL),
(38, 'tirdeldlklkj', 'test', 1, NULL, 'NEW', 45, '2016-06-29 17:55:48', NULL, NULL),
(39, 'tryryrtyry', 'test', 1, NULL, 'NEW', 34, '2016-06-29 18:00:30', NULL, NULL),
(40, 'Terradash project', 'test', 1, 24, 'ASSIGNED', 34, '2016-07-11 11:10:48', NULL, NULL),
(41, 'link', 'test', 1, 1, 'ASSIGNED', 47, '2016-08-10 11:03:17', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `support_ticket_comments`
--

CREATE TABLE `support_ticket_comments` (
  `id` int(11) NOT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  `date_added` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `support_ticket_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `support_ticket_comments`
--

INSERT INTO `support_ticket_comments` (`id`, `comment`, `date_added`, `user_id`, `support_ticket_id`) VALUES
(1, 'ticket for Admin', '2016-06-29 16:38:28', 45, 35),
(2, 'ticket for PM', '2016-06-29 16:38:52', 45, 35),
(3, 'ticket to Katya', '2016-06-29 17:03:58', 1, 33),
(4, 'reretetete', '2016-06-29 17:19:07', 1, 28);

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

CREATE TABLE `surveys` (
  `id` int(11) NOT NULL,
  `shortcode` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `question` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `is_private` tinyint(1) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_votes` int(11) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `surveys`
--

INSERT INTO `surveys` (`id`, `shortcode`, `question`, `description`, `date_start`, `date_end`, `is_private`, `user_id`, `total_votes`, `is_delete`) VALUES
(1, 'pm', 'Test Survey?', 'this is a test surbvey', '2016-05-15 05:50:00', '2016-05-19 05:45:00', 1, 1, 2, 1),
(2, 'ts', 'x', 's', '2016-05-16 11:45:00', '2016-05-17 05:25:00', 0, 1, 1, 1),
(3, 'xe', 'Do you like your job?', '', '2016-05-16 05:55:00', '2016-05-17 06:00:00', 1, 1, 0, 0),
(4, 'k3', 'test', 'ref', '2016-05-27 04:00:00', '2016-05-31 08:25:00', 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `surveys_options`
--

CREATE TABLE `surveys_options` (
  `id` int(11) NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `survey_id` int(11) DEFAULT NULL,
  `votes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `surveys_options`
--

INSERT INTO `surveys_options` (`id`, `name`, `description`, `survey_id`, `votes`) VALUES
(1, 'Option 1', '', 1, 0),
(2, 'Option 2', '', 1, 2),
(3, 'x', '', 2, 1),
(4, 't', '', 2, 0),
(5, 'y', '', 2, 0),
(6, 'option 1', '', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `survey_voters`
--

CREATE TABLE `survey_voters` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ip` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ua_hash` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `survey_id` int(11) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `survey_voters`
--

INSERT INTO `survey_voters` (`id`, `user_id`, `ip`, `ua_hash`, `survey_id`, `option_id`) VALUES
(1, 1, '95.158.49.141', 'd1f8260ba886b3cab55ace017841db8c', 1, 2),
(2, 1, '213.159.251.248', 'ba66035174a362f0da1cefa47695b0dd', 2, 3),
(3, 14, '192.168.1.1', 'ba66035174a362f0da1cefa47695b0dd', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `teammates`
--

CREATE TABLE `teammates` (
  `team_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `testcol` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `teammates`
--

INSERT INTO `teammates` (`team_id`, `user_id`, `testcol`, `is_deleted`) VALUES
(5, 2, NULL, 1),
(7, 2, NULL, 0),
(7, 3, NULL, 0),
(13, 3, NULL, 0),
(11, 10, NULL, 0),
(2, 11, NULL, 0),
(3, 11, NULL, 0),
(16, 11, NULL, 0),
(19, 11, NULL, 0),
(2, 12, NULL, 0),
(4, 12, NULL, 0),
(8, 12, NULL, 0),
(11, 12, NULL, 0),
(12, 12, NULL, 0),
(13, 12, NULL, 0),
(20, 12, NULL, 0),
(1, 14, NULL, 0),
(2, 14, NULL, 1),
(3, 14, NULL, 0),
(4, 14, NULL, 0),
(5, 14, NULL, 0),
(10, 14, NULL, 0),
(11, 14, NULL, 0),
(12, 14, NULL, 0),
(13, 14, NULL, 0),
(15, 14, NULL, 0),
(20, 14, NULL, 0),
(20, 16, NULL, 0),
(2, 17, NULL, 1),
(3, 17, NULL, 0),
(6, 17, NULL, 0),
(13, 17, NULL, 0),
(1, 18, NULL, 0),
(3, 18, NULL, 0),
(7, 18, NULL, 0),
(16, 18, NULL, 0),
(18, 18, NULL, 0),
(9, 22, NULL, 0),
(16, 22, NULL, 0),
(14, 24, NULL, 0),
(15, 24, NULL, 0),
(17, 24, NULL, 0),
(18, 24, NULL, 0),
(20, 24, NULL, 0),
(19, 27, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `date_created` date DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `team_leader_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `user_id`, `name`, `date_created`, `is_deleted`, `team_leader_id`) VALUES
(1, 1, 'Test Team', '2016-04-26', 1, 18),
(2, 1, 'Test1', '2016-04-26', 0, 11),
(3, 1, 'Skynix Co', '2016-04-27', 1, 14),
(4, 1, 'Skynix', '2016-04-27', 1, 14),
(5, 1, 'Skynix Test', '2016-04-27', 1, 14),
(6, 1, '1', '2016-04-27', 1, 17),
(7, 1, 'Green', '2016-04-27', 0, 18),
(8, 1, 'Test2', '2016-04-27', 0, 12),
(9, 1, 'PM Company', '2016-04-28', 1, 22),
(10, 1, 'PM Company', '2016-04-28', 1, 14),
(11, 1, 'PM Company Test', '2016-04-29', 1, 14),
(12, 1, 'Skynix Test', '2016-04-29', 1, 14),
(13, 1, 'Test Team', '2016-04-29', 1, 14),
(14, 1, 'Katya Team', '2016-04-29', 0, 24),
(15, 1, 'PM Team', '2016-04-29', 0, 14),
(16, 1, 'TeamsPM', '2016-04-29', 0, 18),
(17, 1, '123', '2016-04-29', 0, 24),
(18, 1, 'brbrbrbrbr', '2016-04-29', 0, 18),
(19, 1, 'testteamsPM', '2016-04-29', 0, 27),
(20, 1, 'Test Team РМ', '2016-04-29', 0, 14);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
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
  `bank_account_ua` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `phone`, `email`, `password`, `first_name`, `last_name`, `middle_name`, `company`, `tags`, `about`, `date_signup`, `date_login`, `date_salary_up`, `is_active`, `salary`, `month_logged_hours`, `year_logged_hours`, `total_logged_hours`, `month_paid_hours`, `year_paid_hours`, `total_paid_hours`, `invite_hash`, `is_delete`, `photo`, `sing`, `public_profile_key`, `bank_account_en`, `bank_account_ua`) VALUES
(1, 'ADMIN', '0662050652', 'maryt@skynix.co', '21232f297a57a5a743894a0e4a801fc3', 'Oleksii', 'Prozhoga', NULL, NULL, '', '', '2016-03-19 12:46:07', '2017-01-26 09:21:06', NULL, 1, 10, 0, 0, 0, 0, 0, 0, '', 0, '1457393-carnage_1.png', '', NULL, NULL, NULL),
(2, 'DEV', '0505434434', 'employee@example.com', '0500b2ab42f89e6307060d3f45458c97', 'Employee 1', '', NULL, NULL, NULL, NULL, '2016-03-19 12:46:07', NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(3, 'DEV', '0974343432', '', NULL, 'Employee 2', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 1, NULL, NULL, NULL, NULL, NULL),
(4, 'DEV', '0443423233', '', NULL, 'Employee 3', '', NULL, NULL, NULL, NULL, '2016-03-19 12:46:07', NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(5, 'CLIENT', '', '', NULL, 'Sheena', 'Kфів', NULL, '', '', '', '2016-03-19 12:46:07', NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, '', '', NULL, '<p>Замовник</p>\r\n\r\n<p>Бенефіциар <strong>Colourways Limited</strong></p>\r\n\r\n<p>Адреса бенефіциара <strong>31 Chambers Street,</strong></p>\r\n\r\n<p><strong>Hertford, SG14 1PL, UK</strong></p>\r\n\r\n<p>Рахунок бенефіциара: <strong>50961043</strong></p>\r\n\r\n<p>Sort code: <strong>20-20-37</strong></p>\r\n\r\n<p>SWIFT CODE - BARCGB22</p>\r\n\r\n<p>IBAN - GB98 BARC 2020 3750 9610 43</p>\r\n\r\n<p>Банк бенефіциара: <strong>Barclays Bank</strong></p>\r\n\r\n<p>Банк-корреспондент: <strong>Barclays, 745 7th Avenue,</strong></p>\r\n\r\n<p><strong>New York, NY 10019, United States</strong></p>\r\n\r\n<p>Підпис</p>\r\n', '<p>Customer</p>\r\n\r\n<p>BENEFICIARY: <strong>Colourways Limited</strong></p>\r\n\r\n<p>BENEFICIARY ADDRESS:<strong>31 Chambers Street,</strong></p>\r\n\r\n<p><strong>Hertford, SG14 1PL, UK</strong></p>\r\n\r\n<p>BENEFICIARY ACCOUNT: <strong>50961043</strong></p>\r\n\r\n<p>Sort code: <strong>20-20-37</strong></p>\r\n\r\n<p>SWIFT CODE - BARCGB22</p>\r\n\r\n<p>IBAN - GB98 BARC 2020 3750 9610 43</p>\r\n\r\n<p>BANK OF BENEFICIARY: <strong>Barclays Bank</strong></p>\r\n\r\n<p>CORRESPONDENT BANK: <strong>Barclays, 745 7th</strong></p>\r\n\r\n<p><strong>Avenue, New York, NY 10019, United States</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Signature</p>\r\n'),
(6, 'CLIENT', '', '', NULL, 'Ian', 'Holman', NULL, NULL, NULL, NULL, '2016-03-19 12:46:07', NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(7, 'CLIENT', '', '', NULL, 'Eugene', 'Der', NULL, NULL, NULL, NULL, '2016-03-19 12:46:07', NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(8, 'CLIENT', '', '', NULL, 'Alexey', 'Terekov', NULL, NULL, NULL, NULL, '2016-03-19 12:46:07', NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(9, 'CLIENT', '', 'korets.web@gmail.com', NULL, 'Sanzhar', 'Abishev', NULL, NULL, NULL, NULL, '2016-03-19 12:46:07', NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(10, 'DEV', NULL, 'alekseyyp@gmail.com', '02317bf5e899fbc721d5fa6847241976', 'Test', 'User', NULL, NULL, NULL, NULL, '2016-02-27 22:00:00', NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(11, 'DEV', NULL, 'alekseyy.p@gmail.com', '0b95a556d317d98f3ea7b6b83ef72a0d', 'Ivan', 'Developer', NULL, NULL, NULL, NULL, '2016-03-19 12:46:07', NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(12, 'DEV', NULL, 'maryt2902@gmail.com', 'a8e270e4d5780e5137327129b8db6815', 'DEV', 'USER', NULL, '', NULL, NULL, '2016-04-25 09:37:57', '2016-04-29 10:25:27', NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(13, 'PM', NULL, 'm.aryt2902@gmail.com', '9750cc4a1436adb36f2897d430187f7a', 'PM', 'User', NULL, NULL, NULL, NULL, '2016-03-19 12:46:07', NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '652b2bbb8844d61be372f4726f222499', 1, NULL, NULL, NULL, NULL, NULL),
(14, 'PM', '', 'pmtest2902@gmail.com', 'eca13c76cbf454539a7a5e59fec34685', 'PM', 'USER', NULL, '', '', '', '2016-04-25 09:45:46', '2016-06-29 14:35:37', NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, '', '', NULL, NULL, NULL),
(15, 'CLIENT', '', 'client2902@gmail.com', '5748ac7d1582ee00fbb9b334f1b645db', '', '', NULL, '', '', '', '2016-04-27 07:29:15', '2016-06-24 08:47:35', NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, '', 'Matt-Sign.png', NULL, NULL, NULL),
(16, 'DEV', NULL, 'fintest0103@gmail.com', 'a5cc41ab2c6a14e90bfad491e7e7e749', 'Maryana', 'Fin', NULL, '', NULL, NULL, '2016-04-29 04:33:58', '2016-06-29 13:14:17', NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(17, 'DEV', NULL, 'maryt.2902@gmail.com', '4672e9e67b0d727b850bc46f35c0dfa2', 'Maryana', 'Test', NULL, '', NULL, NULL, '2016-04-29 04:17:15', '2016-06-30 08:36:57', NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(18, 'PM', NULL, 'valeriyagodlevskaya@gmail.com', '2604e0079ac8e3cfff72ecaa9c60ce7f', 'PM tester', 'testing', NULL, 'param', NULL, NULL, '2016-04-29 09:35:21', '2016-04-28 06:53:46', NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(19, 'FIN', NULL, 'dimatest2902@yandex.ua', 'eb4d00839b71471f9e85c008a1bdcac7', 'Dima', 'Test', NULL, '', NULL, NULL, '2016-04-29 04:42:30', '2016-04-29 10:32:16', NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(20, 'CLIENT', NULL, 'valeriya@skynix.co', 'd55ed414b37a54e343f96127303e5c02', 'Client Skynix ', 'testing', NULL, 'skynix', NULL, NULL, '2016-04-27 09:46:26', NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 1, NULL, NULL, NULL, NULL, NULL),
(21, 'ADMIN', NULL, 'new_user_test@gmail.com', 'd3138f9e9d645d4a44a2182dde60e179', 'MaryanaMaryana', 'MaryanaMaryana', NULL, '', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2e7834701aee24de25710efb1e6225f1', 1, NULL, NULL, NULL, NULL, NULL),
(22, 'DEV', NULL, 'm.aryt.test2902@gmail.com', 'fbb941597d0b44869dc3920a66474b90', 'User', 'Test', NULL, '', NULL, NULL, '2016-04-29 12:11:56', '2016-04-29 12:12:18', NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(23, 'CLIENT', '', 'anya.test2016@yandex.ru', '63523b671460f05e4b68081ff9d63908', 'Anya', 'Test', NULL, 'Anya\'s Company', '', '', '2016-04-29 04:55:59', '2016-04-29 04:56:16', NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, '', '', NULL, NULL, NULL),
(24, 'DEV', NULL, 'katya.test2016@yandex.ru', 'dd09cc7c76404bbe16078c424c228d81', 'Katya', 'Test', NULL, '', NULL, NULL, '2016-04-29 12:15:11', '2016-06-29 14:09:38', NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(25, 'CLIENT', NULL, 'maryana.test2016@yandex.ru', 'e3f22d565a24648456513bcdad9788b9', 'Аня', 'Тест', NULL, '', NULL, NULL, '2016-04-29 12:31:07', '2016-04-29 12:31:27', NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(26, 'PM', NULL, 'newuser0@ukr.net', '783515ede1a5a087b252ce312913ab98', 'User', 'One', NULL, '', NULL, NULL, '2016-04-29 09:29:55', '2016-04-29 09:32:28', NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(27, 'PM', NULL, 'chubaki1111111111@mail.ru', 'ceccc1d3bf35012cc004d70cc369f074', 'PMtesterPM', 'last', NULL, 'param', NULL, NULL, '2016-04-29 09:45:20', NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(28, 'DEV', NULL, 'a.l.ekseyyp@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'Oleksii', 'Prozhoga', NULL, 'FLP Prozhoga', NULL, NULL, '2016-05-27 12:29:06', '2016-05-27 12:29:06', NULL, 1, 0, 0, 0, 0, 0, 0, 0, '498192b28d5a35fdc2a9f9a3e8c678df', 0, NULL, NULL, NULL, NULL, NULL),
(29, 'DEV', NULL, 'a.l.e.kseyyp@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'Oleksii', 'Prozhoga', NULL, 'FLP Prozhoga', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '1fefb3c81eb4ffcb4790ce9a57b6ab86', 0, NULL, NULL, NULL, NULL, NULL),
(30, 'DEV', NULL, 'a.l.e.k.seyyp@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'Oleksii', 'Prozhoga', NULL, 'FLP Prozhoga', NULL, NULL, '2016-04-30 13:08:08', NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(31, 'DEV', NULL, 'ale.ksey.yp@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'Oleksii', 'Prozhoga', NULL, 'FLP Prozhoga', NULL, NULL, '2016-04-30 13:59:29', '2016-04-30 13:59:36', NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(32, 'DEV', NULL, 'alek.se.yyp@gmail.com', '2138d26cbd515ddb2e9b35409f4bb06f', 'Oleksii', 'Prozhoga', NULL, 'FLP Prozhoga', NULL, NULL, '2016-04-30 14:10:37', NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(33, '', NULL, 'tortseva.evgeniya@yandex.ru', '1f9dddf2bfa09f392f8070027021e6d4', 'GUEST', 'GUEST', NULL, NULL, NULL, NULL, '2016-06-24 08:38:32', '2016-06-24 09:02:10', NULL, 0, 0, 0, 0, 0, 0, 0, 0, '4674bcc995143757ffe13cee239a4c5c', 0, NULL, NULL, NULL, NULL, NULL),
(34, '', NULL, 'huryn.svitlana@yandex.ru', 'eb4bee6dad0e841cc228f1e629ee963e', 'GUEST', 'GUEST', NULL, NULL, NULL, NULL, '2016-06-24 08:59:47', '2016-06-24 15:50:22', NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(35, '', NULL, 'svitlana.sklyarova@yandex.ru', 'e8b42eb857ed6d98003e00a53fff21a5', 'GUEST', 'GUEST', NULL, NULL, NULL, NULL, '2016-06-24 09:38:47', '2016-06-24 10:51:47', NULL, 0, 0, 0, 0, 0, 0, 0, 0, '36acc8f6276144a3495fa1d2ae79c9a8', 0, NULL, NULL, NULL, NULL, NULL),
(36, '', NULL, 'andriy.huryn@mail.ru', 'b96aeba15db3acb943b086c67549e720', 'GUEST', 'GUEST', NULL, NULL, NULL, NULL, '2016-06-24 12:04:16', NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '5cb2ad550b120c6f918719b803df199f', 0, NULL, NULL, NULL, NULL, NULL),
(37, '', NULL, 'sonya.koshkina.test@mail.ru', '87a49c4ca773e851293befe3350a70a8', 'GUEST', 'GUEST', NULL, NULL, NULL, NULL, '2016-06-24 12:10:06', NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '27da35c36a25eb1bb386bfe4adb805a7', 0, NULL, NULL, NULL, NULL, NULL),
(38, '', NULL, 'vika.derid.test@mail.ru', 'e09b01310676f43a04cd6cee34560e76', 'GUEST', 'GUEST', NULL, NULL, NULL, NULL, '2016-06-24 12:55:48', '2016-06-24 12:58:02', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 'c19bdd8426fe4649dd354b71dc55c481', 0, NULL, NULL, NULL, NULL, NULL),
(39, '', NULL, 'marta.sobko@mail.ru', '4d33c0c82e745f638c0013001fe8fcf7', 'GUEST', 'GUEST', NULL, NULL, NULL, NULL, '2016-06-24 13:11:31', '2016-06-24 13:13:05', NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(40, '', NULL, 'kspacey@mail.ua', 'a9026c65ab498530798fc6f094ceaa8e', 'GUEST', 'GUEST', NULL, NULL, NULL, NULL, '2016-06-24 14:27:47', NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(41, '', NULL, 'timur.timur-test@yandex.ru', 'c1ab849a8d2d08d85333991f36ffeff9', 'GUEST', 'GUEST', NULL, NULL, NULL, NULL, '2016-06-29 10:52:14', NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '16543e0ff8e1a46b2d5620555e30e0d6', 0, NULL, NULL, NULL, NULL, NULL),
(42, '', NULL, 'gagarina.test@yandex.ru', 'f5625b2cfacdc9081501924088f861c4', 'GUEST', 'GUEST', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 'fc558784c9ce5ae0d5530dcdff0f10e7', 1, NULL, NULL, NULL, NULL, NULL),
(43, '', NULL, 'my_test_new@mail.ru', 'bd68b1225c5ae3eef2ea2d3d93678ec4', 'GUEST', 'GUEST', NULL, NULL, NULL, NULL, '2016-06-29 10:58:36', NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 'ea2ff2bc52bb0f8eafdf6e9fd7b8655b', 0, NULL, NULL, NULL, NULL, NULL),
(44, '', NULL, 'i_am_test@mail.ru', '3cc9a39216ec985574b0c57a8099aa7e', 'GUEST', 'GUEST', NULL, NULL, NULL, NULL, '2016-06-29 11:10:42', NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 'c8f25e41c8050d129cc2bfedc8a17e0f', 0, NULL, NULL, NULL, NULL, NULL),
(45, '', NULL, 'kovalenko_olya_test@mail.ru', '21232f297a57a5a743894a0e4a801fc3', 'GUEST', 'GUEST', NULL, NULL, NULL, NULL, '2016-06-29 11:27:28', '2016-06-29 13:41:26', NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(46, '', NULL, 'derid.sergey@mail.ru', '46d76d56e097430fc97d2ec347fb53db', 'GUEST', 'GUEST', NULL, NULL, NULL, NULL, '2016-06-29 12:57:21', NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '056437375f45a5920a1c9b1e4636d216', 0, NULL, NULL, NULL, NULL, NULL),
(47, '', NULL, 'g.valeriya92@mail.ru', '3fc03c099751626fa7cc4aa0bdc809ba', 'GUEST', 'GUEST', NULL, NULL, NULL, NULL, '2016-08-10 08:03:17', NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '523d8b9bdcf854ee0bfc7aedd88f0e92', 0, NULL, NULL, NULL, NULL, NULL),
(48, 'SALES', NULL, 'mysel@mail.ua', '21232f297a57a5a743894a0e4a801fc3', 'Sales', 'User', NULL, 'Skynix', NULL, NULL, '2016-11-14 09:10:36', '2016-11-30 14:52:37', NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(49, 'SALES', '', 'sales.test@mail.ru', 'e6f97b0070caf2ac14be679f6917078d', 'Test', 'Sales', NULL, 'Skynix', '', '', '2016-11-14 13:21:32', '2016-11-14 13:28:24', NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, '', '', NULL, NULL, NULL),
(50, 'ADMIN', NULL, 'korets.web@gmail.com', '9c63a7b805f0010736dededcdf8cc3b2', 'dima', 'korets', NULL, 'skynix', NULL, NULL, '2016-11-14 14:55:55', NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 'bda5587a462fb792d479369c9872d125', 0, NULL, NULL, NULL, NULL, NULL),
(51, 'SALES', NULL, 'dmytro@skynix.com', '29707a2d9ecc50a2219b2bae53ff7b3e', 'dima', 'korets', NULL, 'skynix', NULL, NULL, '2016-11-14 14:56:23', NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 'a83047bacef09c1e8d66c6623dc84d4a', 0, NULL, NULL, NULL, NULL, NULL),
(52, 'SALES', NULL, 'dmytro@skynix.co', 'edd05810c96cfbd3227b8f0a79629de2', 'dimka', 'korets', NULL, 'skynix1', NULL, NULL, '2016-11-14 14:57:20', '2016-11-14 15:13:53', NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(53, 'SALES', NULL, 'lou.sales@mail.ru', 'c9f278b2d38f821bc04523a9266f8798', 'Lou', 'Sales', NULL, 'Skynix', NULL, NULL, '2016-11-23 08:17:00', '2016-11-23 08:18:28', NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(54, 'SALES', '', '', 'a34465e7cf5a78b03deebeea299497a8', 'Maryana', '', '', '', NULL, NULL, '2016-11-23 08:38:44', '2016-11-23 08:39:29', NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, NULL, NULL, NULL, NULL),
(55, 'CLIENT', '', 'vulolur@rootfest.net', 'e7f20974adfd6dbf7b5e9a07184caa97', 'Dmytro', 'Client', '', '', NULL, NULL, '2017-01-06 10:24:47', NULL, NULL, 0, NULL, 0, 0, 0, 0, 0, 0, '8b2e0a9ced4ecf8e8c35aba789d855ab', 0, NULL, NULL, NULL, NULL, NULL),
(56, 'CLIENT', '', 'korets.web1@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'dimaClient', 'korets', NULL, 'skynix', '', '', NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 0, '', 0, '', '', NULL, '<p>asdasdasdsdada111</p>\r\n', '<p>ukraina!</p>\r\n');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api_auth_access_tokens`
--
ALTER TABLE `api_auth_access_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-contracts-customer_id` (`customer_id`),
  ADD KEY `idx-contracts-created_by` (`created_by`),
  ADD KEY `idx-contracts-contract_template_id` (`contract_template_id`),
  ADD KEY `idx-contracts-contract_payment_method_id` (`contract_payment_method_id`);

--
-- Indexes for table `contract_templates`
--
ALTER TABLE `contract_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extensions`
--
ALTER TABLE `extensions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx-invoice_contract` (`contract_id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `monthly_reports`
--
ALTER TABLE `monthly_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_monthly_reports_users1_idx` (`user_id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_customers`
--
ALTER TABLE `project_customers`
  ADD PRIMARY KEY (`user_id`,`project_id`),
  ADD KEY `fk_project_customers_projects1_idx` (`project_id`);

--
-- Indexes for table `project_developers`
--
ALTER TABLE `project_developers`
  ADD PRIMARY KEY (`user_id`,`project_id`),
  ADD KEY `fk_project_developers_projects1_idx` (`project_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reports_projects1_idx` (`project_id`),
  ADD KEY `fk_reports_users1_idx` (`user_id`),
  ADD KEY `fk_reports_invoices1_idx` (`invoice_id`);

--
-- Indexes for table `salary_history`
--
ALTER TABLE `salary_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_salary_history_users1_idx` (`user_id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_ticket_comments`
--
ALTER TABLE `support_ticket_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surveys`
--
ALTER TABLE `surveys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_surveys_users` (`user_id`);

--
-- Indexes for table `surveys_options`
--
ALTER TABLE `surveys_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_surveys_options_users` (`survey_id`);

--
-- Indexes for table `survey_voters`
--
ALTER TABLE `survey_voters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_survey_voters_users` (`user_id`),
  ADD KEY `fk_survey_voters_surveys` (`survey_id`),
  ADD KEY `fk_survey_voters_surveys_options` (`option_id`);

--
-- Indexes for table `teammates`
--
ALTER TABLE `teammates`
  ADD PRIMARY KEY (`user_id`,`team_id`),
  ADD KEY `teammates_team_id` (`team_id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teams_users_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `api_auth_access_tokens`
--
ALTER TABLE `api_auth_access_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;
--
-- AUTO_INCREMENT for table `contract_templates`
--
ALTER TABLE `contract_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `extensions`
--
ALTER TABLE `extensions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;
--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;
--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;
--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `support_ticket_comments`
--
ALTER TABLE `support_ticket_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `surveys`
--
ALTER TABLE `surveys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `surveys_options`
--
ALTER TABLE `surveys_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `survey_voters`
--
ALTER TABLE `survey_voters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `contracts`
--
ALTER TABLE `contracts`
  ADD CONSTRAINT `fk-contracts-contract_payment_method_id` FOREIGN KEY (`contract_payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-contracts-contract_template_id` FOREIGN KEY (`contract_template_id`) REFERENCES `contract_templates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-contracts-created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk-contracts-customer_id` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `fk-invoice_contract` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `monthly_reports`
--
ALTER TABLE `monthly_reports`
  ADD CONSTRAINT `fk_monthly_reports_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `project_customers`
--
ALTER TABLE `project_customers`
  ADD CONSTRAINT `fk_project_customers_projects1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_project_customers_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `project_developers`
--
ALTER TABLE `project_developers`
  ADD CONSTRAINT `fk_project_developers_projects1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_project_developers_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `fk_reports_invoices1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reports_projects1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_reports_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `salary_history`
--
ALTER TABLE `salary_history`
  ADD CONSTRAINT `fk_salary_history_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `surveys`
--
ALTER TABLE `surveys`
  ADD CONSTRAINT `fk_surveys_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `surveys_options`
--
ALTER TABLE `surveys_options`
  ADD CONSTRAINT `fk_surveys_options_users` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`);

--
-- Constraints for table `survey_voters`
--
ALTER TABLE `survey_voters`
  ADD CONSTRAINT `fk_survey_voters_surveys` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`),
  ADD CONSTRAINT `fk_survey_voters_surveys_options` FOREIGN KEY (`option_id`) REFERENCES `surveys_options` (`id`),
  ADD CONSTRAINT `fk_survey_voters_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `teammates`
--
ALTER TABLE `teammates`
  ADD CONSTRAINT `teammates_team_id` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`),
  ADD CONSTRAINT `teammates_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
