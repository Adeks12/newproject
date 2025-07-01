-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2025 at 05:17 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory1_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `bank_code` varchar(7) NOT NULL DEFAULT '',
  `bank_name` varchar(30) DEFAULT NULL,
  `bank_type` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`bank_code`, `bank_name`, `bank_type`) VALUES
('011', 'First Bank of Nigeria', 0),
('023', 'CitiBank', 0),
('030', 'Heritage', 0),
('032', 'Union Bank', 0),
('033', 'United Bank for Africa', 0),
('035', 'Wema Bank', 0),
('044', 'Access Bank', 0),
('050', 'Ecobank Plc', 0),
('057', 'Zenith Bank', 0),
('058', 'GTBank Plc', 0),
('063', 'Diamond Bank', 0),
('068', 'Standard Chartered Bank', 0),
('070', 'Fidelity Bank', 0),
('076', 'Skye Bank', 0),
('082', 'Keystone Bank', 0),
('084', 'Enterprise Bank', 0),
('100', 'SunTrust Bank', 0),
('214', 'First City Monument Bank', 0),
('215', 'Unity Bank', 0),
('221', 'Stanbic IBTC Bank', 0),
('232', 'Sterling Bank', 0),
('301', 'JAIZ Bank', 0),
('302', 'Eartholeum', 0),
('303', 'ChamsMobile', 0),
('304', 'Stanbic Mobile Money', 0),
('305', 'Paycom', 0),
('306', 'eTranzact', 0),
('307', 'EcoMobile', 0),
('308', 'FortisMobile', 0),
('309', 'FBNMobile', 0),
('311', 'ReadyCash (Parkway)', 0),
('313', 'Mkudi', 0),
('314', 'FET', 0),
('315', 'GTMobile', 0),
('317', 'Cellulant', 0),
('318', 'Fidelity Mobile', 0),
('319', 'TeasyMobile', 0),
('320', 'VTNetworks', 0),
('322', 'ZenithMobile', 0),
('323', 'Access Money', 0),
('324', 'Hedonmark', 0),
('325', 'MoneyBox', 0),
('326', 'Sterling Mobile', 0),
('327', 'Pagatech', 0),
('328', 'TagPay', 0),
('329', 'PayAttitude Online', 0),
('401', 'ASO Savings and & Loans', 0),
('402', 'Jubilee Life Mortgage Bank', 0),
('403', 'SafeTrust Mortgage Bank', 0),
('415', 'Imperial Homes Mortgage Bank', 0),
('501', 'Fortis Microfinance Bank', 0),
('523', 'Trustbond', 0),
('526', 'Parralex', 0),
('551', 'Covenant Microfinance Bank', 0),
('552', 'NPF MicroFinance Bank', 0),
('559', 'Coronation Merchant Bank', 0),
('560', 'Page MFBank', 0),
('601', 'FSDH', 0),
('990', 'Omoluabi Mortgage Bank', 0),
('999', 'NIP Virtual Bank', 0);

-- --------------------------------------------------------

--
-- Table structure for table `church_table`
--

CREATE TABLE `church_table` (
  `church_id` int(11) NOT NULL,
  `church_type` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `church_name` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `church_type`
--

CREATE TABLE `church_type` (
  `id` int(11) NOT NULL,
  `church_type` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `depmt_id` int(11) NOT NULL,
  `merchant_id` varchar(100) NOT NULL,
  `depmt_code` varchar(50) NOT NULL,
  `depmt_name` varchar(100) NOT NULL,
  `depmt_status` enum('0','1') NOT NULL,
  `depmt_head` varchar(100) NOT NULL,
  `depmt_description` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_officer` varchar(100) NOT NULL,
  `updated_officer` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`depmt_id`, `merchant_id`, `depmt_code`, `depmt_name`, `depmt_status`, `depmt_head`, `depmt_description`, `created_at`, `updated_at`, `created_officer`, `updated_officer`) VALUES
(3, 'PRO-773289', 'PUB090', 'Publicity Department', '1', '4', 'Publicity', '2025-06-20 12:19:54', '2025-06-20 12:19:54', 'Jesuslovestestimony@gmail.com', 'Jesuslovestestimony@gmail.com'),
(4, 'PRO-773289', 'TEC565', 'Technology Department', '1', '2', 'Tech Geniuses coming up with cutting edge solutions', '2025-06-20 10:03:51', '2025-06-20 10:03:51', 'Jesuslovestestimony@gmail.com', 'Jesuslovestestimony@gmail.com'),
(5, 'PRO-283008', 'QUA567', 'Quality Control', '1', '', 'Checks the quality of every product.', '2025-06-20 14:59:21', NULL, 'adekanmi001247@gmail.com', '');

-- --------------------------------------------------------

--
-- Table structure for table `font_awsome`
--

CREATE TABLE `font_awsome` (
  `font_id` int(11) NOT NULL,
  `code` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `font_awsome`
--

INSERT INTO `font_awsome` (`font_id`, `code`) VALUES
(1, 'bi-pencil-square'),
(2, 'bi-trash-fill'),
(3, 'bi-list toggle-sidebar-btn'),
(4, 'bi-search'),
(5, ' bi-person'),
(6, 'bi-box-arrow-right'),
(7, 'bi-grid'),
(8, 'bi-menu-button-wide'),
(9, 'bi-circle'),
(10, 'bi-chevron-down'),
(11, 'bi-briefcase-fill'),
(12, 'bi-border-width'),
(13, 'bi-display'),
(14, 'bi-gear-fill'),
(15, 'bi-people-fill'),
(16, 'bi-person-plus'),
(17, 'bi-view-list'),
(18, 'bi-house');

-- --------------------------------------------------------

--
-- Table structure for table `gendata`
--

CREATE TABLE `gendata` (
  `table_name` varchar(30) NOT NULL,
  `table_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `gendata`
--

INSERT INTO `gendata` (`table_name`, `table_id`) VALUES
('menu', 144),
('transaction_table', 1),
('users', 22),
('staff', 95),
('loans', 13),
('allowance', 12),
('designation', 4),
('deduction', 22),
('loan_setup', 148),
('payroll', 26),
('leave', 1),
('staff_leave', 4),
('role', 14);

-- --------------------------------------------------------

--
-- Table structure for table `grade_level`
--

CREATE TABLE `grade_level` (
  `merchant_id` varchar(50) NOT NULL,
  `grade_id` varchar(50) NOT NULL,
  `grade_level_id` varchar(100) NOT NULL,
  `grade_level_name` varchar(50) NOT NULL,
  `grade_level_status` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_officer` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `merchant_id` varchar(50) NOT NULL,
  `item_code` varchar(50) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_cond` enum('fairly_used','new','old','') NOT NULL,
  `item_cat_id` int(50) NOT NULL,
  `item_color` varchar(50) NOT NULL,
  `allocation_status` enum('allocated','not_allocated','','') NOT NULL,
  `usage_status` varchar(100) NOT NULL,
  `delete_status` varchar(100) NOT NULL,
  `allocated_officer` varchar(100) NOT NULL,
  `allocated_date` varchar(50) NOT NULL,
  `allocated_by` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_officer` varchar(50) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_officer` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`merchant_id`, `item_code`, `item_id`, `item_cond`, `item_cat_id`, `item_color`, `allocation_status`, `usage_status`, `delete_status`, `allocated_officer`, `allocated_date`, `allocated_by`, `created_at`, `created_officer`, `updated_at`, `updated_officer`) VALUES
('PRO-773289', 'ITM927327', 1, 'new', 6, 'Green', 'not_allocated', 'Maintenance', '0', '', '', 'Jesuslovestestimony@gmail.com', '2025-06-20 12:16:13', 'Jesuslovestestimony@gmail.com', '2025-06-20 12:16:13', 'Jesuslovestestimony@gmail.com'),
('PRO-283008', 'ITM510407', 2, 'new', 10, 'Black', 'allocated', 'Maintenance', '0', '3', '2025-06-20', 'adekanmi001247@gmail.com', '2025-06-20 15:48:13', 'adekanmi001247@gmail.com', '2025-06-20 15:48:13', 'adekanmi001247@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `merchant_id` varchar(100) NOT NULL,
  `item_id` int(20) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `category_id` int(20) NOT NULL,
  `item_code` varchar(100) NOT NULL,
  `item_condition` varchar(100) NOT NULL,
  `color` varchar(100) NOT NULL,
  `quantity` int(50) NOT NULL,
  `allocation_status` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `warranty` varchar(100) NOT NULL,
  `purchase_date` date NOT NULL,
  `location` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_officer` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`merchant_id`, `item_id`, `item_name`, `category_id`, `item_code`, `item_condition`, `color`, `quantity`, `allocation_status`, `status`, `warranty`, `purchase_date`, `location`, `created_at`, `created_officer`) VALUES
('PRO-773289', 0, 'Mouse', 6, 'ITM862455', 'Good', 'Blue', 12, '', 'Available', '2 years', '2025-06-11', 'Abuja', '2025-06-25 10:49:46', 'Jesuslovestestimony@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `item_allocation_history`
--

CREATE TABLE `item_allocation_history` (
  `allocation_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `allocated_date` datetime NOT NULL,
  `returned_date` datetime DEFAULT NULL,
  `status` enum('active','returned') NOT NULL DEFAULT 'active',
  `notes` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_allocation_history`
--

INSERT INTO `item_allocation_history` (`allocation_id`, `item_id`, `staff_id`, `department_id`, `allocated_date`, `returned_date`, `status`, `notes`, `created_at`) VALUES
(1, 1, 2, 3, '2025-06-20 00:00:00', '2025-06-20 12:13:34', 'returned', '', '2025-06-20 11:18:56'),
(2, 1, 4, 0, '2025-06-20 00:00:00', '2025-06-20 13:19:13', 'returned', '', '2025-06-20 11:19:11'),
(3, 1, 2, 0, '2025-06-20 00:00:00', '2025-06-20 16:52:46', 'returned', '', '2025-06-20 11:24:42'),
(4, 1, 4, 0, '2025-06-20 00:00:00', '2025-06-20 16:54:46', 'returned', '', '2025-06-20 11:27:18'),
(5, 1, 2, 0, '2025-06-20 00:00:00', '2025-06-20 17:16:03', 'returned', '', '2025-06-20 11:35:52'),
(6, 1, 4, 0, '2025-06-20 00:00:00', '2025-06-25 11:30:50', 'returned', '', '2025-06-20 11:51:43'),
(7, 1, 2, 0, '2025-06-20 00:00:00', '2025-06-27 14:00:23', 'returned', '', '2025-06-20 12:13:22'),
(8, 1, 2, 0, '2025-06-20 00:00:00', '2025-06-27 14:02:56', 'returned', '', '2025-06-20 12:16:30'),
(9, 1, 4, 0, '2025-06-20 00:00:00', NULL, 'active', '', '2025-06-20 13:18:34'),
(10, 2, 3, 0, '2025-06-20 00:00:00', '2025-06-20 15:10:53', 'returned', '', '2025-06-20 14:43:40'),
(11, 2, 3, 0, '2025-06-20 00:00:00', NULL, 'active', '', '2025-06-20 15:32:19'),
(12, 2, 3, 0, '2025-06-20 00:00:00', NULL, 'active', '', '2025-06-20 16:27:46');

-- --------------------------------------------------------

--
-- Table structure for table `item_category`
--

CREATE TABLE `item_category` (
  `merchant_id` varchar(50) NOT NULL,
  `item_cat_id` int(11) NOT NULL,
  `item_code` varchar(50) NOT NULL,
  `item_cat_description` varchar(100) NOT NULL,
  `parent_cat_id` int(50) NOT NULL,
  `item_cat_name` varchar(50) NOT NULL,
  `item_status` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_officer` varchar(50) NOT NULL,
  `updated_officer` varchar(100) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_category`
--

INSERT INTO `item_category` (`merchant_id`, `item_cat_id`, `item_code`, `item_cat_description`, `parent_cat_id`, `item_cat_name`, `item_status`, `created_at`, `created_officer`, `updated_officer`, `updated_at`) VALUES
('0', 1, 'MIN476', 'Electrically powered', 0, 'Electronics', '1', '2025-06-02 16:30:33', 'Jesuslovestestimony@gmail.com', '', '0000-00-00 00:00:00'),
('PRO-773289', 2, 'ELE817', 'Gadgets that use electricity, e.g. Phones, laptops e.t.c', 0, 'Electronic devices', '1', '2025-06-19 12:03:13', 'Jesuslovestestimony@gmail.com', 'Jesuslovestestimony@gmail.com', '2025-06-19 12:03:13'),
('PRO-773289', 3, 'LAP592', 'Laptops only used in the office.', 2, 'Laptops', '1', '2025-06-19 15:49:33', 'Jesuslovestestimony@gmail.com', 'Jesuslovestestimony@gmail.com', '2025-06-19 15:49:33'),
('PRO-773289', 6, 'LAP109', 'This are the peripherals of the laptop, e.g, mouse, keyboard etc', 0, ' Laptop Accessories', '1', '2025-06-03 13:20:28', 'Jesuslovestestimony@gmail.com', '', '0000-00-00 00:00:00'),
('PRO-773289', 7, 'MOU605', 'Office Mouse', 6, 'Mouse', '0', '2025-06-03 13:23:40', 'Jesuslovestestimony@gmail.com', '', '0000-00-00 00:00:00'),
('PRO-773289', 8, 'OFF787', 'utilities used in the office e.g Air-condition', 0, 'Office utilities', '1', '2025-06-03 13:31:46', 'Jesuslovestestimony@gmail.com', '', '0000-00-00 00:00:00'),
('PRO-773289', 9, 'AIR576', 'Air condition', 8, 'Air condition', '1', '2025-06-03 13:32:28', 'Jesuslovestestimony@gmail.com', '', '0000-00-00 00:00:00'),
('PRO-283008', 10, 'LAP044', 'Laptops from different offices', 0, 'Laptops', '1', '2025-06-20 14:31:21', 'adekanmi001247@gmail.com', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `item_maintenance_log`
--

CREATE TABLE `item_maintenance_log` (
  `maintenance_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `reported_by` varchar(100) DEFAULT NULL,
  `reported_date` datetime NOT NULL,
  `issue_description` varchar(255) DEFAULT NULL,
  `repair_date` datetime DEFAULT NULL,
  `repair_cost` decimal(10,2) DEFAULT NULL,
  `maintenance_status` enum('pending','in_progress','completed') NOT NULL DEFAULT 'pending',
  `notes` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_maintenance_log`
--

INSERT INTO `item_maintenance_log` (`maintenance_id`, `item_id`, `reported_by`, `reported_date`, `issue_description`, `repair_date`, `repair_cost`, `maintenance_status`, `notes`, `created_at`) VALUES
(1, 2, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0.00, '', 'We have to change the screen.', '2025-06-20 15:54:21'),
(2, 2, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0.00, '', 'Pugi', '2025-06-20 16:18:57');

-- --------------------------------------------------------

--
-- Table structure for table `lga`
--

CREATE TABLE `lga` (
  `stateid` varchar(3) DEFAULT NULL,
  `State` varchar(50) DEFAULT NULL,
  `Lga` varchar(50) DEFAULT NULL,
  `Lgaid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `lga`
--

INSERT INTO `lga` (`stateid`, `State`, `Lga`, `Lgaid`) VALUES
('033', 'RIVERS', 'Asaritoru', 2),
('017', 'IMO', 'Aboh mbaise', 3),
('031', 'OYO', 'Oluyole', 5),
('009', 'CROSS RIVERS', 'Bekwara', 6),
('028', 'OGUN', 'Abeokuta east', 7),
('028', 'OGUN', 'Yemoji', 8),
('012', 'EDO', 'Etsakor', 9),
('010', 'DELTA', 'Ethiope west', 10),
('004', 'ANAMBRA', 'Idemili', 11),
('023', 'KOGI', 'Ijumu iyara', 12),
('023', 'KOGI', 'Mopa-muro', 13),
('001', 'ABIA', 'Aba north', 14),
('001', 'ABIA', 'Aba south', 15),
('001', 'ABIA', 'Arochukwu', 16),
('001', 'ABIA', 'Bende', 17),
('001', 'ABIA', 'Ikwuano', 18),
('001', 'ABIA', 'Isiala-ngwa north', 19),
('001', 'ABIA', 'Isiala-ngwa south', 20),
('001', 'ABIA', 'Isukwuato', 21),
('001', 'ABIA', 'Obiomangwa', 22),
('001', 'ABIA', 'Ohafia', 23),
('001', 'ABIA', 'Osisioma ngwa', 24),
('001', 'ABIA', 'Ugwunagbo', 25),
('001', 'ABIA', 'Ukwa east', 26),
('001', 'ABIA', 'Ukwa west', 27),
('001', 'ABIA', 'Umuahia north', 28),
('001', 'ABIA', 'Umuahia south', 29),
('001', 'ABIA', 'Umu-nneochi', 30),
('002', 'ADAMAWA', 'Demsa', 31),
('002', 'ADAMAWA', 'Fufore', 32),
('002', 'ADAMAWA', 'Ganye', 33),
('002', 'ADAMAWA', 'Girei', 34),
('002', 'ADAMAWA', 'Gombi', 35),
('002', 'ADAMAWA', 'Guyuk', 36),
('002', 'ADAMAWA', 'Hong', 37),
('002', 'ADAMAWA', 'Jada', 38),
('002', 'ADAMAWA', 'Lamurde', 39),
('002', 'ADAMAWA', 'Madagali', 40),
('002', 'ADAMAWA', 'Maiha', 41),
('002', 'ADAMAWA', 'Mayo-belwa', 42),
('002', 'ADAMAWA', 'Michika', 43),
('002', 'ADAMAWA', 'Mubi north', 44),
('002', 'ADAMAWA', 'Mubi south', 45),
('002', 'ADAMAWA', 'Numan', 46),
('002', 'ADAMAWA', 'Shelleng', 47),
('002', 'ADAMAWA', 'Song', 48),
('002', 'ADAMAWA', 'Toungo', 49),
('002', 'ADAMAWA', 'Yola north', 50),
('002', 'ADAMAWA', 'Yola south', 51),
('003', 'AKWA IBOM', 'Abak', 52),
('003', 'AKWA IBOM', 'Eastern obolo', 53),
('003', 'AKWA IBOM', 'Eket', 54),
('003', 'AKWA IBOM', 'Esit eket', 55),
('003', 'AKWA IBOM', 'Essien udim', 56),
('003', 'AKWA IBOM', 'Etim ekpo', 57),
('003', 'AKWA IBOM', 'Etinan', 58),
('003', 'AKWA IBOM', 'Ibeno', 59),
('003', 'AKWA IBOM', 'Ibesikpo asutan', 60),
('003', 'AKWA IBOM', 'Ibiono ibom', 61),
('003', 'AKWA IBOM', 'Ika', 62),
('003', 'AKWA IBOM', 'Ikono', 63),
('003', 'AKWA IBOM', 'Ikot abasi', 64),
('003', 'AKWA IBOM', 'Ikot ekpene', 65),
('003', 'AKWA IBOM', 'Ini', 66),
('003', 'AKWA IBOM', 'Itu', 67),
('003', 'AKWA IBOM', 'Mbo', 68),
('003', 'AKWA IBOM', 'Mkpat enin', 69),
('003', 'AKWA IBOM', 'Nsit atai', 70),
('003', 'AKWA IBOM', 'Nsit ibom', 71),
('003', 'AKWA IBOM', 'Nsit ubium', 72),
('003', 'AKWA IBOM', 'Uruan', 73),
('003', 'AKWA IBOM', 'Urue-offong/oruko', 74),
('003', 'AKWA IBOM', 'Uyo', 75),
('004', 'ANAMBRA', 'Aguata', 76),
('004', 'ANAMBRA', 'Anambra east', 77),
('004', 'ANAMBRA', 'Anambra west', 78),
('004', 'ANAMBRA', 'Anaocha', 79),
('004', 'ANAMBRA', 'Awka north', 80),
('004', 'ANAMBRA', 'Awka south', 81),
('004', 'ANAMBRA', 'Ayamelum', 82),
('004', 'ANAMBRA', 'Dunukofia', 83),
('004', 'ANAMBRA', 'Ekwusigo', 84),
('004', 'ANAMBRA', 'Idemili north', 85),
('004', 'ANAMBRA', 'Idemili south', 86),
('004', 'ANAMBRA', 'Ihiala', 87),
('004', 'ANAMBRA', 'Njikoka', 88),
('004', 'ANAMBRA', 'Nnewi north', 89),
('009', 'CROSS RIVERS', 'Obanliku', 90),
('009', 'CROSS RIVERS', 'Obubra', 91),
('009', 'CROSS RIVERS', 'Obudu', 92),
('009', 'CROSS RIVERS', 'Odukpani', 93),
('009', 'CROSS RIVERS', 'Ogoja', 94),
('009', 'CROSS RIVERS', 'Yakurr', 95),
('009', 'CROSS RIVERS', 'Yala', 96),
('010', 'DELTA', 'Aniocha north', 97),
('010', 'DELTA', 'Aniocha south', 98),
('010', 'DELTA', 'Bomadi', 99),
('010', 'DELTA', 'Burutu', 100),
('010', 'DELTA', 'Ethiope east', 101),
('010', 'DELTA', 'Ethiope west', 102),
('010', 'DELTA', 'Ika north', 103),
('010', 'DELTA', 'Ika south', 104),
('010', 'DELTA', 'Isoko north', 105),
('010', 'DELTA', 'Isoko south', 106),
('010', 'DELTA', 'Ndokwa east', 107),
('010', 'DELTA', 'Ndokwa west', 108),
('010', 'DELTA', 'Okpe', 109),
('010', 'DELTA', 'Oshimili north', 110),
('010', 'DELTA', 'Oshimili south', 111),
('010', 'DELTA', 'Patani', 112),
('010', 'DELTA', 'Sapele', 113),
('010', 'DELTA', 'Udu', 114),
('010', 'DELTA', 'Ughelli north', 115),
('010', 'DELTA', 'Ughelli south', 116),
('010', 'DELTA', 'Ukwuani', 117),
('010', 'DELTA', 'Uvwie', 118),
('010', 'DELTA', 'Warri north', 119),
('010', 'DELTA', 'Warri south', 120),
('010', 'DELTA', 'Warri south west', 121),
('011', 'EBONYI', 'Abakaliki', 122),
('011', 'EBONYI', 'Afikpo north', 123),
('011', 'EBONYI', 'Afikpo south', 124),
('011', 'EBONYI', 'Ebonyi', 125),
('011', 'EBONYI', 'Ezza north', 126),
('011', 'EBONYI', 'Ezza south', 127),
('011', 'EBONYI', 'Ikwo', 128),
('011', 'EBONYI', 'Ishielu', 129),
('011', 'EBONYI', 'Ivo', 130),
('011', 'EBONYI', 'Izzi', 131),
('011', 'EBONYI', 'Ohaozara', 132),
('011', 'EBONYI', 'Ohaukwu', 133),
('011', 'EBONYI', 'Onicha', 134),
('012', 'EDO', 'Akoko-edo', 135),
('012', 'EDO', 'Egor', 136),
('012', 'EDO', 'Esan central', 137),
('012', 'EDO', 'Esan north east', 138),
('012', 'EDO', 'Esan south east', 139),
('012', 'EDO', 'Esan west', 140),
('012', 'EDO', 'Etsako central', 141),
('012', 'EDO', 'Etsako east', 142),
('012', 'EDO', 'Etsako west', 143),
('012', 'EDO', 'Igueben', 144),
('012', 'EDO', 'Ikpoba-okha', 145),
('012', 'EDO', 'Oredo', 146),
('012', 'EDO', 'Orhionmwon', 147),
('012', 'EDO', 'Ovia north east', 148),
('012', 'EDO', 'Ovia south west', 149),
('012', 'EDO', 'Owan east', 150),
('012', 'EDO', 'Owan west', 151),
('012', 'EDO', 'Uhunmwonde', 152),
('013', 'EKITI', 'ADK', 153),
('013', 'EKITI', 'DEA', 154),
('013', 'EKITI', 'EFY', 155),
('013', 'EKITI', 'MUE', 156),
('013', 'EKITI', 'LAW', 157),
('013', 'EKITI', 'AMK', 158),
('013', 'EKITI', 'EMR', 159),
('013', 'EKITI', 'DEK', 160),
('013', 'EKITI', 'JER', 161),
('013', 'EKITI', 'KER', 162),
('013', 'EKITI', 'KLE', 163),
('013', 'EKITI', 'YEK', 164),
('013', 'EKITI', 'GED', 165),
('013', 'EKITI', 'SSE', 166),
('013', 'EKITI', 'TUN', 167),
('013', 'EKITI', 'YEE', 168),
('014', 'ENUGU', 'Aninri', 169),
('014', 'ENUGU', 'Awgu', 170),
('014', 'ENUGU', 'Enugu east', 171),
('014', 'ENUGU', 'Enugu north', 172),
('014', 'ENUGU', 'Enugu south', 173),
('014', 'ENUGU', 'Ezeagu', 174),
('014', 'ENUGU', 'Enugu', 175),
('014', 'ENUGU', 'Igbo-etit', 176),
('014', 'ENUGU', 'Igbo-eze north', 177),
('014', 'ENUGU', 'Igho-eze south', 178),
('014', 'ENUGU', 'Isi-uzo', 179),
('014', 'ENUGU', 'Nkanu east', 180),
('014', 'ENUGU', 'Nkanu west', 181),
('004', 'ANAMBRA', 'Nnewi south', 182),
('004', 'ANAMBRA', 'Ogbaru', 183),
('004', 'ANAMBRA', 'Onitsha north', 184),
('004', 'ANAMBRA', 'Onitsha south', 185),
('004', 'ANAMBRA', 'Orumba north', 186),
('004', 'ANAMBRA', 'Orumba south', 187),
('004', 'ANAMBRA', 'Oyi', 188),
('005', 'BAUCHI', 'Alkaleri', 189),
('005', 'BAUCHI', 'Bauchi', 190),
('005', 'BAUCHI', 'Bogoro', 191),
('005', 'BAUCHI', 'Damban', 192),
('005', 'BAUCHI', 'Darazo', 193),
('005', 'BAUCHI', 'Dass', 194),
('005', 'BAUCHI', 'Gamawa', 195),
('005', 'BAUCHI', 'Ganjuwa', 196),
('005', 'BAUCHI', 'Giade', 197),
('005', 'BAUCHI', 'Itas/gadau', 198),
('005', 'BAUCHI', 'Jama\'are', 199),
('005', 'BAUCHI', 'Katagun', 200),
('037', 'ZAMFARA', 'Gusau', 201),
('005', 'BAUCHI', 'Kirfi', 202),
('005', 'BAUCHI', 'Misau', 203),
('005', 'BAUCHI', 'Ningi', 204),
('005', 'BAUCHI', 'Shira', 205),
('005', 'BAUCHI', 'Tafawa-balewa', 206),
('005', 'BAUCHI', 'Toro', 207),
('005', 'BAUCHI', 'Warji', 208),
('005', 'BAUCHI', 'Zaki', 209),
('006', 'BAYELSA', 'Brass', 210),
('006', 'BAYELSA', 'Ekeremor', 211),
('006', 'BAYELSA', 'Kolokuma/opokuma', 212),
('006', 'BAYELSA', 'Nembe', 213),
('006', 'BAYELSA', 'Ogbia', 214),
('006', 'BAYELSA', 'Sagbama', 215),
('006', 'BAYELSA', 'Southern ijaw', 216),
('006', 'BAYELSA', 'Yenegoa', 217),
('007', 'BENUE', 'Ado', 218),
('007', 'BENUE', 'Agatu', 219),
('007', 'BENUE', 'Apa', 220),
('007', 'BENUE', 'Buruku', 221),
('007', 'BENUE', 'Gboko', 222),
('007', 'BENUE', 'Guma', 223),
('007', 'BENUE', 'Gwer east', 224),
('007', 'BENUE', 'Gwer west', 225),
('007', 'BENUE', 'Katsina-ala', 226),
('007', 'BENUE', 'Konshisha', 227),
('007', 'BENUE', 'Kwande', 228),
('007', 'BENUE', 'Logo', 229),
('007', 'BENUE', 'Makurdi', 230),
('007', 'BENUE', 'Obi', 231),
('007', 'BENUE', 'Ogbadibo', 232),
('007', 'BENUE', 'Oju', 233),
('007', 'BENUE', 'Okpokwu', 234),
('007', 'BENUE', 'Ohimini', 235),
('007', 'BENUE', 'Oturkpo', 236),
('007', 'BENUE', 'Tarka', 237),
('007', 'BENUE', 'Ukum', 238),
('007', 'BENUE', 'Ushongo', 239),
('007', 'BENUE', 'Vandeikya', 240),
('008', 'BORNO', 'Abadam', 241),
('008', 'BORNO', 'Askira/uba', 242),
('008', 'BORNO', 'Bama', 243),
('008', 'BORNO', 'Bayo', 244),
('008', 'BORNO', 'Biu', 245),
('008', 'BORNO', 'Chibok', 246),
('008', 'BORNO', 'Damboa', 247),
('008', 'BORNO', 'Dikwa', 248),
('008', 'BORNO', 'Gubio', 249),
('008', 'BORNO', 'Guzamala', 250),
('008', 'BORNO', 'Gwoza', 251),
('008', 'BORNO', 'Hawul', 252),
('008', 'BORNO', 'Jere', 253),
('008', 'BORNO', 'Kaga', 254),
('008', 'BORNO', 'Kala/balge', 255),
('008', 'BORNO', 'Konduga', 256),
('008', 'BORNO', 'Kukawa', 257),
('008', 'BORNO', 'Kwaya kusar', 258),
('008', 'BORNO', 'Mafa', 259),
('008', 'BORNO', 'Magumeri', 260),
('008', 'BORNO', 'Maiduguri', 261),
('008', 'BORNO', 'Marte', 262),
('008', 'BORNO', 'Mobbar', 263),
('008', 'BORNO', 'Monguno', 264),
('008', 'BORNO', 'Ngala', 265),
('008', 'BORNO', 'Nganzai', 266),
('008', 'BORNO', 'Shani', 267),
('009', 'CROSS RIVERS', 'Abi', 268),
('009', 'CROSS RIVERS', 'Akamkpa', 269),
('009', 'CROSS RIVERS', 'Akpabuyo', 270),
('009', 'CROSS RIVERS', 'Bakassi', 271),
('009', 'CROSS RIVERS', 'Bekwara', 272),
('009', 'CROSS RIVERS', 'Biase', 273),
('009', 'CROSS RIVERS', 'Boki', 274),
('009', 'CROSS RIVERS', 'Calabar-municipal', 275),
('009', 'CROSS RIVERS', 'Calabar south', 276),
('009', 'CROSS RIVERS', 'Etung', 277),
('009', 'CROSS RIVERS', 'Ikom', 278),
('014', 'ENUGU', 'Nsukka', 279),
('014', 'ENUGU', 'Oji-river', 280),
('014', 'ENUGU', 'Udenu', 281),
('014', 'ENUGU', 'Udi', 282),
('014', 'ENUGU', 'Uzo-uwani', 283),
('016', 'GOMBE', 'Akko', 284),
('016', 'GOMBE', 'Balanga', 285),
('016', 'GOMBE', 'Billiri', 286),
('016', 'GOMBE', 'Dukku', 287),
('016', 'GOMBE', 'Funakaye', 288),
('016', 'GOMBE', 'Gombe', 289),
('016', 'GOMBE', 'Kaltungo', 290),
('016', 'GOMBE', 'Kwami', 291),
('016', 'GOMBE', 'Nafada', 292),
('016', 'GOMBE', 'Shomgom', 293),
('016', 'GOMBE', 'Yamaltu/deba', 294),
('017', 'IMO', 'Ahiazu-mbaise', 295),
('017', 'IMO', 'Ehime-mbano', 296),
('017', 'IMO', 'Ezinihitte', 297),
('017', 'IMO', 'Ideato north', 298),
('017', 'IMO', 'Ideato south', 299),
('017', 'IMO', 'Ihitte-uboma', 300),
('017', 'IMO', 'Ikeduru', 301),
('017', 'IMO', 'Isiala mbano', 302),
('017', 'IMO', 'Isu', 303),
('017', 'IMO', 'Mbaitoli', 304),
('017', 'IMO', 'Ngor-okpala', 305),
('017', 'IMO', 'Njaba', 306),
('017', 'IMO', 'Nwangele', 307),
('017', 'IMO', 'Nkwerre', 308),
('017', 'IMO', 'Obowo', 309),
('017', 'IMO', 'Oguta', 310),
('017', 'IMO', 'Ohaji/egbema', 311),
('017', 'IMO', 'Okigwe', 312),
('017', 'IMO', 'Orlu', 313),
('017', 'IMO', 'Orsu', 314),
('017', 'IMO', 'Oru east', 315),
('017', 'IMO', 'Oru west', 316),
('017', 'IMO', 'Owerri muni.', 317),
('017', 'IMO', 'Owerri north', 318),
('017', 'IMO', 'Owerri west', 319),
('017', 'IMO', 'Onuimo', 320),
('018', 'JIGAWA', 'Auyo', 321),
('018', 'JIGAWA', 'Babura', 322),
('018', 'JIGAWA', 'Birnin kudu', 323),
('018', 'JIGAWA', 'Biriniwa', 324),
('018', 'JIGAWA', 'Buji', 325),
('018', 'JIGAWA', 'Dutse', 326),
('018', 'JIGAWA', 'Gagarawa', 327),
('018', 'JIGAWA', 'Garki', 328),
('018', 'JIGAWA', 'Gumel', 329),
('018', 'JIGAWA', 'Guri', 330),
('018', 'JIGAWA', 'Gwaram', 331),
('018', 'JIGAWA', 'Gwiwa', 332),
('018', 'JIGAWA', 'Hadejia', 333),
('018', 'JIGAWA', 'Jahun', 334),
('018', 'JIGAWA', 'Kafin', 335),
('018', 'JIGAWA', 'Hausa', 336),
('018', 'JIGAWA', 'Kaugama', 337),
('018', 'JIGAWA', 'Kazaure', 338),
('018', 'JIGAWA', 'Kiri kasamma', 339),
('018', 'JIGAWA', 'Kiyawa', 340),
('018', 'JIGAWA', 'Maigatari', 341),
('018', 'JIGAWA', 'Malam madori', 342),
('018', 'JIGAWA', 'Miga', 343),
('018', 'JIGAWA', 'Ringim', 344),
('018', 'JIGAWA', 'Roni', 345),
('018', 'JIGAWA', 'Sule-tankarkar', 346),
('018', 'JIGAWA', 'Taura', 347),
('018', 'JIGAWA', 'Yankwashi', 348),
('019', 'KADUNA', 'Birnin-gwari', 349),
('019', 'KADUNA', 'Chikun', 350),
('019', 'KADUNA', 'Giwa', 351),
('019', 'KADUNA', 'Igabi', 352),
('019', 'KADUNA', 'Ikara', 353),
('019', 'KADUNA', 'Jaba', 354),
('019', 'KADUNA', 'Jema\'a', 355),
('019', 'KADUNA', 'Kachia', 356),
('019', 'KADUNA', 'Kaduna north', 357),
('019', 'KADUNA', 'Kaduna south', 358),
('019', 'KADUNA', 'Kagarko', 359),
('019', 'KADUNA', 'Kajuru', 360),
('019', 'KADUNA', 'Kaura', 361),
('019', 'KADUNA', 'Kubau', 362),
('019', 'KADUNA', 'Kudan', 363),
('019', 'KADUNA', 'Lere', 364),
('019', 'KADUNA', 'Makarfi', 365),
('019', 'KADUNA', 'Sabon-gari', 366),
('019', 'KADUNA', 'Sanga', 367),
('019', 'KADUNA', 'Soba', 368),
('019', 'KADUNA', 'Zangon-kataf', 369),
('019', 'KADUNA', 'Zaria', 370),
('020', 'KANO', 'Ajingi', 371),
('020', 'KANO', 'Albasu', 372),
('020', 'KANO', 'Bagwai', 373),
('020', 'KANO', 'Bebeji', 374),
('020', 'KANO', 'Bichi', 375),
('020', 'KANO', 'Bunkure', 376),
('020', 'KANO', 'Dala', 377),
('020', 'KANO', 'Dambatta', 378),
('020', 'KANO', 'Dawakin kudu', 379),
('020', 'KANO', 'Dawakin tofa', 380),
('020', 'KANO', 'Doguwa', 381),
('020', 'KANO', 'Fagge', 382),
('020', 'KANO', 'Gabasawa', 383),
('020', 'KANO', 'Garko', 384),
('020', 'KANO', 'Garum mallarn', 385),
('020', 'KANO', 'Gaya', 386),
('020', 'KANO', 'Gezawa', 387),
('020', 'KANO', 'Gwale', 388),
('020', 'KANO', 'Gwarzo', 389),
('020', 'KANO', 'Kabo', 390),
('020', 'KANO', 'Kano municipal', 391),
('020', 'KANO', 'Karaye', 392),
('020', 'KANO', 'Kibiya', 393),
('020', 'KANO', 'Kiru', 394),
('020', 'KANO', 'Kumbotso', 395),
('020', 'KANO', 'Kunchi', 396),
('020', 'KANO', 'Kura', 397),
('020', 'KANO', 'Madobi', 398),
('020', 'KANO', 'Makoda', 399),
('020', 'KANO', 'Minjibir', 400),
('020', 'KANO', 'Nasarawa', 401),
('020', 'KANO', 'Rano', 402),
('020', 'KANO', 'Rimin gado', 403),
('020', 'KANO', 'Rogo', 404),
('020', 'KANO', 'Shanono', 405),
('020', 'KANO', 'Sumaila', 406),
('020', 'KANO', 'Takai', 407),
('020', 'KANO', 'Tarauni', 408),
('020', 'KANO', 'Tofa', 409),
('020', 'KANO', 'Tsanyawa', 410),
('020', 'KANO', 'Tudun wada', 411),
('020', 'KANO', 'Ungogo', 412),
('020', 'KANO', 'Warawa', 413),
('020', 'KANO', 'Wudil', 414),
('021', 'KATSINA', 'Bakori', 415),
('021', 'KATSINA', 'Batagarawa', 416),
('021', 'KATSINA', 'Batsari', 417),
('021', 'KATSINA', 'Baure', 418),
('021', 'KATSINA', 'Bindawa', 419),
('021', 'KATSINA', 'Charanchi', 420),
('021', 'KATSINA', 'Dandume', 421),
('021', 'KATSINA', 'Danja', 422),
('021', 'KATSINA', 'Dan musa', 423),
('021', 'KATSINA', 'Daura', 424),
('021', 'KATSINA', 'Dutsi', 425),
('021', 'KATSINA', 'Dutsin-ma', 426),
('021', 'KATSINA', 'Faskari', 427),
('021', 'KATSINA', 'Funtua', 428),
('021', 'KATSINA', 'Ingawa', 429),
('021', 'KATSINA', 'Jibia', 430),
('021', 'KATSINA', 'Kafur', 431),
('021', 'KATSINA', 'Kaita', 432),
('021', 'KATSINA', 'Kankara', 433),
('021', 'KATSINA', 'Kankia', 434),
('021', 'KATSINA', 'Katsina', 435),
('021', 'KATSINA', 'Kurfi', 436),
('021', 'KATSINA', 'Kusada', 437),
('021', 'KATSINA', 'Mai\'adua', 438),
('021', 'KATSINA', 'Malumfashi', 439),
('021', 'KATSINA', 'Mani', 440),
('021', 'KATSINA', 'Mashi', 441),
('021', 'KATSINA', 'Matazu', 442),
('021', 'KATSINA', 'Musawa', 443),
('021', 'KATSINA', 'Rimi', 444),
('021', 'KATSINA', 'Sabuwa', 445),
('021', 'KATSINA', 'Safana', 446),
('021', 'KATSINA', 'Sandamu', 447),
('021', 'KATSINA', 'Zongo', 448),
('022', 'KEBBI', 'Aleiro', 449),
('022', 'KEBBI', 'Arewa-dandi', 450),
('022', 'KEBBI', 'Argungu', 451),
('022', 'KEBBI', 'Augie', 452),
('022', 'KEBBI', 'Bagudo', 453),
('022', 'KEBBI', 'Birnin kebbi', 454),
('022', 'KEBBI', 'Bunza', 455),
('022', 'KEBBI', 'Dandi', 456),
('022', 'KEBBI', 'Fakai', 457),
('022', 'KEBBI', 'Gwandu', 458),
('022', 'KEBBI', 'Jega', 459),
('022', 'KEBBI', 'Kalgo', 460),
('022', 'KEBBI', 'Koko/besse', 461),
('022', 'KEBBI', 'Maiyama', 462),
('022', 'KEBBI', 'Ngaski', 463),
('022', 'KEBBI', 'Sakaba', 464),
('022', 'KEBBI', 'Shanga', 465),
('022', 'KEBBI', 'Suru', 466),
('022', 'KEBBI', 'Wasagu/danko', 467),
('022', 'KEBBI', 'Yauri', 468),
('022', 'KEBBI', 'Zuru', 469),
('023', 'KOGI', 'Adavi', 470),
('023', 'KOGI', 'Ajaojuta', 471),
('023', 'KOGI', 'Ankpa', 472),
('023', 'KOGI', 'Bassa', 473),
('023', 'KOGI', 'Dekina', 474),
('023', 'KOGI', 'Ibaji', 475),
('023', 'KOGI', 'Igalamela-odolu', 476),
('023', 'KOGI', 'Ijumu', 477),
('023', 'KOGI', 'Ijumu', 478),
('023', 'KOGI', 'Kabba/bunu', 479),
('023', 'KOGI', 'Kogi', 480),
('023', 'KOGI', 'Lokoja', 481),
('023', 'KOGI', 'Mopa-muro', 482),
('023', 'KOGI', 'Ofu', 483),
('023', 'KOGI', 'Ogori/megongo', 484),
('023', 'KOGI', 'Okehi', 485),
('023', 'KOGI', 'Olamabolo', 486),
('023', 'KOGI', 'Omala', 487),
('023', 'KOGI', 'Yagba east', 488),
('023', 'KOGI', 'Yagba west', 489),
('024', 'KWARA', 'Asa', 490),
('024', 'KWARA', 'Baruten', 491),
('024', 'KWARA', 'Edu', 492),
('024', 'KWARA', 'Ekiti', 493),
('024', 'KWARA', 'Ifelodun', 494),
('024', 'KWARA', 'Ilorin south', 495),
('024', 'KWARA', 'Ilorin west', 496),
('024', 'KWARA', 'Irepodun', 497),
('024', 'KWARA', 'Isin', 498),
('024', 'KWARA', 'Kaiama', 499),
('024', 'KWARA', 'Moro', 500),
('024', 'KWARA', 'Offa', 501),
('024', 'KWARA', 'Oke-ero', 502),
('024', 'KWARA', 'Oyun', 503),
('024', 'KWARA', 'Pategi', 504),
('025', 'LAGOS', 'Agege', 505),
('025', 'LAGOS', 'Ajeromi-ifelodun', 506),
('025', 'LAGOS', 'Alimosho', 507),
('025', 'LAGOS', 'Amuwo-odofin', 508),
('025', 'LAGOS', 'Apapa', 509),
('025', 'LAGOS', 'Badagry', 510),
('025', 'LAGOS', 'Epe', 511),
('025', 'LAGOS', 'Eti-osa', 512),
('025', 'LAGOS', 'Ibeju/lekki', 513),
('025', 'LAGOS', 'Ifako-ijaye', 514),
('025', 'LAGOS', 'Ikeja', 515),
('025', 'LAGOS', 'Ikorodu', 516),
('025', 'LAGOS', 'Kosofe', 517),
('025', 'LAGOS', 'Lagos island', 518),
('025', 'LAGOS', 'Lagos mainland', 519),
('025', 'LAGOS', 'Mushin', 520),
('025', 'LAGOS', 'Ojo', 521),
('025', 'LAGOS', 'Oshodi-isolo', 522),
('025', 'LAGOS', 'Shomolu', 523),
('025', 'LAGOS', 'Surulere', 524),
('026', 'NASARAWA', 'Akwanga', 525),
('026', 'NASARAWA', 'Awe', 526),
('026', 'NASARAWA', 'Doma', 527),
('026', 'NASARAWA', 'Karu', 528),
('026', 'NASARAWA', 'Keana', 529),
('026', 'NASARAWA', 'Keffi', 530),
('026', 'NASARAWA', 'Kokona', 531),
('026', 'NASARAWA', 'Lafia', 532),
('026', 'NASARAWA', 'Nasarawa', 533),
('026', 'NASARAWA', 'Nasarawa-eggon', 534),
('026', 'NASARAWA', 'Obi', 535),
('026', 'NASARAWA', 'Toto', 536),
('026', 'NASARAWA', 'Wamba', 537),
('027', 'NIGER', 'Agaie', 538),
('027', 'NIGER', 'Agwara', 539),
('027', 'NIGER', 'Bida', 540),
('027', 'NIGER', 'Borgu', 541),
('027', 'NIGER', 'Bosso', 542),
('027', 'NIGER', 'Chanchaga', 543),
('027', 'NIGER', 'Edati', 544),
('027', 'NIGER', 'Gbako', 545),
('027', 'NIGER', 'Gurara', 546),
('027', 'NIGER', 'Katcha', 547),
('027', 'NIGER', 'Kontagora', 548),
('027', 'NIGER', 'Lapai', 549),
('027', 'NIGER', 'Lavun', 550),
('027', 'NIGER', 'Magama', 551),
('027', 'NIGER', 'Mariga', 552),
('027', 'NIGER', 'Mashegu', 553),
('027', 'NIGER', 'Mokwa', 554),
('027', 'NIGER', 'Muya', 555),
('027', 'NIGER', 'Paikoro', 556),
('027', 'NIGER', 'Rafi', 557),
('027', 'NIGER', 'Rajau', 558),
('027', 'NIGER', 'Shiroro', 559),
('027', 'NIGER', 'Suleja', 560),
('027', 'NIGER', 'Tafa', 561),
('027', 'NIGER', 'Wushishi', 562),
('028', 'OGUN', 'Abeokuta north', 563),
('028', 'OGUN', 'Abeokuta south', 564),
('028', 'OGUN', 'Ado-odo/ota', 565),
('028', 'OGUN', 'Egbado north', 566),
('028', 'OGUN', 'Egbado south', 567),
('028', 'OGUN', 'Ekwekoro', 568),
('028', 'OGUN', 'Ifo', 569),
('028', 'OGUN', 'Ijebu east', 570),
('028', 'OGUN', 'Ijebu north', 571),
('028', 'OGUN', 'Ijebu north east', 572),
('028', 'OGUN', 'Ijebu-ode', 573),
('028', 'OGUN', 'Ikenne', 574),
('028', 'OGUN', 'Imeko-afon', 575),
('028', 'OGUN', 'Ipokia', 576),
('028', 'OGUN', 'Obafemi-owode', 577),
('028', 'OGUN', 'Ogun waterside', 578),
('028', 'OGUN', 'Odeda', 579),
('028', 'OGUN', 'Odogbolu', 580),
('028', 'OGUN', 'Remo north', 581),
('028', 'OGUN', 'Shagamu', 582),
('029', 'ONDO', 'Akoko north east', 583),
('029', 'ONDO', 'Akoko north west', 584),
('029', 'ONDO', 'Akoko south east', 585),
('029', 'ONDO', 'Akoko south west', 586),
('029', 'ONDO', 'Akure north', 587),
('029', 'ONDO', 'Akuresouth', 588),
('029', 'ONDO', 'Ese-odo', 589),
('029', 'ONDO', 'Idanre', 590),
('029', 'ONDO', 'Ifedore', 591),
('029', 'ONDO', 'Ilaje', 592),
('029', 'ONDO', 'Ile-oluji-okeigbo', 593),
('029', 'ONDO', 'Irele', 594),
('029', 'ONDO', 'Odigbo', 595),
('029', 'ONDO', 'Okitipupa', 596),
('029', 'ONDO', 'Ondo east', 597),
('029', 'ONDO', 'Ondo west', 598),
('029', 'ONDO', 'Ose-owo', 599),
('030', 'OSUN', 'Aiyedade', 600),
('030', 'OSUN', 'Aiyedire', 601),
('030', 'OSUN', 'Atakumosa east', 602),
('030', 'OSUN', 'Atakumose-west', 603),
('030', 'OSUN', 'Boluwaduro', 604),
('030', 'OSUN', 'Boripe', 605),
('030', 'OSUN', 'Ede north', 606),
('030', 'OSUN', 'Ede south', 607),
('030', 'OSUN', 'Egbedore', 608),
('030', 'OSUN', 'Ejigbo', 609),
('030', 'OSUN', 'Ife central', 610),
('030', 'OSUN', 'Ife east', 611),
('030', 'OSUN', 'Ife north', 612),
('030', 'OSUN', 'Ife south', 613),
('030', 'OSUN', 'Ifedayo', 614),
('030', 'OSUN', 'Ifelodun', 615),
('030', 'OSUN', 'Ila', 616),
('030', 'OSUN', 'Ilasha east', 617),
('030', 'OSUN', 'Ilesha west', 618),
('030', 'OSUN', 'Irepodun', 619),
('030', 'OSUN', 'Irewole', 620),
('030', 'OSUN', 'Isokan', 621),
('030', 'OSUN', 'Iwo', 622),
('030', 'OSUN', 'Obokun', 623),
('030', 'OSUN', 'Odo-otin', 624),
('030', 'OSUN', 'Ola-oluwa', 625),
('030', 'OSUN', 'Olorunda', 626),
('030', 'OSUN', 'Oriade', 627),
('030', 'OSUN', 'Orolu', 628),
('030', 'OSUN', 'Osogbo', 629),
('031', 'OYO', 'Afijio', 630),
('031', 'OYO', 'Akinyele', 631),
('031', 'OYO', 'Atiba', 632),
('031', 'OYO', 'Atigbo', 633),
('031', 'OYO', 'Egbeda', 634),
('031', 'OYO', 'Ibadan central', 635),
('031', 'OYO', 'Ibadan north', 636),
('031', 'OYO', 'Ibadan north west', 637),
('031', 'OYO', 'Ibadan south west', 638),
('031', 'OYO', 'Ibadan south east', 639),
('031', 'OYO', 'Ibarapa central', 640),
('031', 'OYO', 'Ibarapa east', 641),
('031', 'OYO', 'Ibarapa north', 642),
('031', 'OYO', 'Ido', 643),
('031', 'OYO', 'Irepo', 644),
('031', 'OYO', 'Iseyin', 645),
('031', 'OYO', 'Itesiwaju', 646),
('031', 'OYO', 'Iwajowa', 647),
('031', 'OYO', 'Kajola', 648),
('031', 'OYO', 'Lagelu', 649),
('031', 'OYO', 'Ogbomoso north', 650),
('031', 'OYO', 'Ogbomoso south', 651),
('031', 'OYO', 'Ogo oluwa', 652),
('031', 'OYO', 'Olorunsogo', 653),
('031', 'OYO', 'Oluyole', 654),
('031', 'OYO', 'Ona-ara', 655),
('031', 'OYO', 'Orelope', 656),
('031', 'OYO', 'Ori ire', 657),
('031', 'OYO', 'Oyo east', 658),
('031', 'OYO', 'Oyo west', 659),
('031', 'OYO', 'Saki east', 660),
('031', 'OYO', 'Saki west', 661),
('031', 'OYO', 'Surelere', 662),
('032', 'PLATEAU', 'Barikin ladi', 663),
('032', 'PLATEAU', 'Bassa', 664),
('032', 'PLATEAU', 'Bokkos', 665),
('032', 'PLATEAU', 'Jos east', 666),
('032', 'PLATEAU', 'Jos north', 667),
('032', 'PLATEAU', 'Jos south', 668),
('032', 'PLATEAU', 'Kanam', 669),
('032', 'PLATEAU', 'Kanke', 670),
('032', 'PLATEAU', 'Langtang north', 671),
('032', 'PLATEAU', 'Langtang south', 672),
('032', 'PLATEAU', 'Mangu', 673),
('032', 'PLATEAU', 'Mikang', 674),
('032', 'PLATEAU', 'Pankshin', 675),
('032', 'PLATEAU', 'Qua\'an pan', 676),
('032', 'PLATEAU', 'Riyom', 677),
('032', 'PLATEAU', 'Shendam', 678),
('032', 'PLATEAU', 'Wase', 679),
('033', 'RIVERS', 'Abua/odual', 680),
('033', 'RIVERS', 'Ahoada east', 681),
('033', 'RIVERS', 'Ahoada west', 682),
('033', 'RIVERS', 'Akuku toru', 683),
('033', 'RIVERS', 'Andoni', 684),
('033', 'RIVERS', 'Asari-toru', 685),
('033', 'RIVERS', 'Bonny', 686),
('033', 'RIVERS', 'Degema', 687),
('033', 'RIVERS', 'Emohua', 688),
('033', 'RIVERS', 'Eleme', 689),
('033', 'RIVERS', 'Etche', 690),
('033', 'RIVERS', 'Gokana', 691),
('033', 'RIVERS', 'Ikwerre', 692),
('033', 'RIVERS', 'Khana', 693),
('033', 'RIVERS', 'Obia/akpor', 694),
('033', 'RIVERS', 'Ogba/egbema/ndoni', 695),
('033', 'RIVERS', 'Ogu/bolo', 696),
('033', 'RIVERS', 'Okrika', 697),
('033', 'RIVERS', 'Omumma', 698),
('033', 'RIVERS', 'Opobo/nkoro', 699),
('033', 'RIVERS', 'Oyigbo', 700),
('033', 'RIVERS', 'Port harcourt', 701),
('033', 'RIVERS', 'Tai', 702),
('034', 'SOKOTO', 'Binji', 703),
('034', 'SOKOTO', 'Bodinga', 704),
('034', 'SOKOTO', 'Dange-shuni', 705),
('034', 'SOKOTO', 'Gada', 706),
('034', 'SOKOTO', 'Goronyo', 707),
('034', 'SOKOTO', 'Gudu', 708),
('034', 'SOKOTO', 'Gwadabawa', 709),
('034', 'SOKOTO', 'Illela', 710),
('034', 'SOKOTO', 'Isa', 711),
('034', 'SOKOTO', 'Kware', 712),
('034', 'SOKOTO', 'Kebbe', 713),
('034', 'SOKOTO', 'Rabah', 714),
('034', 'SOKOTO', 'Sabon birni', 715),
('034', 'SOKOTO', 'Shagari', 716),
('034', 'SOKOTO', 'Silame', 717),
('034', 'SOKOTO', 'Sokoto north', 718),
('034', 'SOKOTO', 'Sokoto south', 719),
('034', 'SOKOTO', 'Tambuwal', 720),
('034', 'SOKOTO', 'Tangaza', 721),
('034', 'SOKOTO', 'Tureta', 722),
('034', 'SOKOTO', 'Wamakko', 723),
('034', 'SOKOTO', 'Wurno', 724),
('034', 'SOKOTO', 'Yabo', 725),
('035', 'TARABA', 'Ardo-kola', 726),
('035', 'TARABA', 'Bali', 727),
('035', 'TARABA', 'Donga', 728),
('035', 'TARABA', 'Gashaka', 729),
('035', 'TARABA', 'Gassol', 730),
('035', 'TARABA', 'Ibi', 731),
('035', 'TARABA', 'Jalingo', 732),
('035', 'TARABA', 'Karim-lamido', 733),
('035', 'TARABA', 'Kurmi', 734),
('035', 'TARABA', 'Lau', 735),
('035', 'TARABA', 'Sarduana', 736),
('035', 'TARABA', 'Takum', 737),
('035', 'TARABA', 'Ussa', 738),
('035', 'TARABA', 'Wukari', 739),
('035', 'TARABA', 'Yorro', 740),
('035', 'TARABA', 'Zing', 741),
('036', 'YOBE', 'Bade', 742),
('036', 'YOBE', 'Bursari', 743),
('036', 'YOBE', 'Damaturu', 744),
('036', 'YOBE', 'Fika', 745),
('036', 'YOBE', 'Fune', 746),
('036', 'YOBE', 'Geidam', 747),
('036', 'YOBE', 'Gujba', 748),
('036', 'YOBE', 'Gulani', 749),
('036', 'YOBE', 'Jakusko', 750),
('036', 'YOBE', 'Karasuwa', 751),
('036', 'YOBE', 'Machina', 752),
('036', 'YOBE', 'Nangere', 753),
('036', 'YOBE', 'Nguru', 754),
('036', 'YOBE', 'Potiskum', 755),
('036', 'YOBE', 'Tarmua', 756),
('036', 'YOBE', 'Yunusari', 757),
('036', 'YOBE', 'Yusufari', 758),
('037', 'ZAMFARA', 'Anka', 759),
('037', 'ZAMFARA', 'Bakurna', 760),
('037', 'ZAMFARA', 'Birnin magaji', 761),
('037', 'ZAMFARA', 'Bukkuyum', 762),
('037', 'ZAMFARA', 'Bungudu', 763),
('037', 'ZAMFARA', 'Gummi', 764),
('037', 'ZAMFARA', 'Kaura namoda', 765),
('037', 'ZAMFARA', 'Maradun', 766),
('037', 'ZAMFARA', 'Maru', 767),
('037', 'ZAMFARA', 'Shinkafi', 768),
('037', 'ZAMFARA', 'Talata', 769),
('037', 'ZAMFARA', 'Mafara', 770),
('037', 'ZAMFARA', 'Tsafe', 771),
('037', 'ZAMFARA', 'Zumi', 772),
('026', 'NASARAWA', 'Eggon', 773),
('029', 'ONDO', 'Ile oluji', 774),
('028', 'OGUN', 'Sagamu', 775),
('028', 'OGUN', 'Opeji', 776),
('028', 'OGUN', 'Ijebu ode', 777),
('012', 'EDO', 'Ishan', 778),
('029', 'ONDO', 'Ondo central', 779),
('007', 'BENUE', 'Otukpo', 780),
('015', 'FCT', 'Abaji', 781),
('015', 'FCT', 'Abuja Municipal', 782),
('015', 'FCT', 'Bwari', 783),
('015', 'FCT', 'Gwagwalada', 784),
('015', 'FCT', 'Kuje', 785),
('015', 'FCT', 'Kwali', 786),
('017', 'IMO', 'Ehime mbano', 787),
('014', 'ENUGU', 'Oji river', 788),
('031', 'OYO', 'Ogbomosho', 789),
('029', 'ONDO', 'Akure south', 790),
('009', 'CROSS RIVERS', 'Odupani', 791),
('017', 'IMO', 'Ngor okpala', 792),
('007', 'BENUE', 'Ador', 793),
('003', 'AKWA IBOM', 'Okobo', 794),
('023', 'KOGI', 'Idah', 795),
('001', 'ABIA', 'Ugwunagbor', 796),
('033', 'RIVERS', 'Ogba/Egbem/Noom', 797),
('023', 'KOGI', 'Okene', 798),
('029', 'ONDO', 'Akoko', 799),
('029', 'ONDO', 'Owo', 800),
('022', 'KEBBI', 'Kamba', 801),
('028', 'OGUN', 'Water side', 802),
('028', 'OGUN', 'Egado South', 803),
('028', 'OGUN', 'Imeko Afon', 804),
('032', 'PLATEAU', 'Panilshin', 805),
('029', 'ONDO', 'Ikalo', 806),
('025', 'LAGOS', 'Eredo', 807),
('021', 'KATSINA', 'Manufanoti', 808),
('034', 'SOKOTO', 'Kofa atiku', 809),
('003', 'AKWA IBOM', 'Onna', 811),
('003', 'AKWA IBOM', 'Udium', 812),
('028', 'OGUN', 'Ake', 813),
('012', 'EDO', 'Uromi', 814),
('003', 'AKWA IBOM', 'Oron', 815),
('003', 'AKWA IBOM', 'Oruk', 816),
('010', 'DELTA', 'Aniocha', 817),
('029', 'ONDO', 'Ose', 818),
('024', 'KWARA', 'Oro', 819),
('028', 'OGUN', 'Yewa', 820),
('028', 'OGUN', 'Yewa South', 821),
('028', 'OGUN', 'Yewa North', 822),
('033', 'RIVERS', 'Opobo/Nkoro', 823),
('033', 'RIVERS', 'Onelga', 824),
('008', 'BORNO', 'Maiduguri .M.C', 826);

-- --------------------------------------------------------

--
-- Table structure for table `log_details`
--

CREATE TABLE `log_details` (
  `id` int(11) NOT NULL,
  `log_id` varchar(80) NOT NULL,
  `field_name` varchar(80) DEFAULT NULL,
  `previous_data` text DEFAULT NULL,
  `current_data` text DEFAULT NULL,
  `field_alias` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `log_table`
--

CREATE TABLE `log_table` (
  `id` int(11) NOT NULL,
  `username` varchar(80) NOT NULL,
  `table_name` varchar(150) NOT NULL,
  `table_id` varchar(80) NOT NULL,
  `table_alias` varchar(150) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` varchar(5) NOT NULL,
  `menu_name` varchar(50) NOT NULL,
  `menu_url` varchar(60) DEFAULT '',
  `parent_id` varchar(5) DEFAULT '#',
  `parent_id2` varchar(5) NOT NULL DEFAULT ' ',
  `menu_level` char(1) DEFAULT '0',
  `created` datetime NOT NULL,
  `menu_order` int(3) NOT NULL DEFAULT 0,
  `status` int(1) DEFAULT 0,
  `icon` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `menu_name`, `menu_url`, `parent_id`, `parent_id2`, `menu_level`, `created`, `menu_order`, `status`, `icon`) VALUES
('004', 'Administrative Tools', '#', '#', ' ', '0', '0000-00-00 00:00:00', 0, 0, ''),
('006', 'Role', 'role_list.php', '004', ' ', '1', '2018-02-15 14:55:23', 0, 0, NULL),
('007', 'Menu', 'menu_list.php', '004', ' ', '1', '2018-02-22 14:56:12', 0, 0, NULL),
('008', 'Setups', '#', '#', ' ', '0', '2018-01-27 15:31:54', 1, 1, NULL),
('017', 'Change Password', 'change_password.php', '008', ' ', '1', '2018-04-10 14:34:40', 0, 0, NULL),
('019', 'Company Management', '#', '#', ' ', '0', '2025-06-02 17:23:02', 0, 0, ''),
('020', 'Staffs & Account', '#', '#', ' ', '0', '2025-06-23 12:19:18', 0, 0, NULL),
('021', 'Inventory', '#', '#', ' ', '0', '2025-06-03 14:14:55', 0, 0, NULL),
('022', 'Allocation', '#', '#', ' ', '0', '2025-06-02 13:01:00', 0, 0, NULL),
('023', 'Reports', '#', '#', ' ', '0', '2025-06-30 16:46:40', 0, 0, NULL),
('024', 'Audits Logs', '#', '#', ' ', '0', '2025-06-30 16:46:40', 0, 0, NULL),
('025', 'Store', '#', '#', ' ', '0', '2025-06-30 16:46:04', 0, 0, NULL),
('026', 'Overview Cards', 'overview_cards.php', '018', ' ', '1', '2025-06-30 16:51:28', 0, 0, NULL),
('027', 'Quick Charts', 'quick_charts.php', '018', ' ', '1', '2025-06-30 16:51:28', 0, 0, NULL),
('028', 'Users', 'user_list.php', '004', ' ', '1', '2018-10-21 23:44:22', 0, 0, NULL),
('029', 'Profile', 'profile.php', '019', ' ', '1', '2025-06-30 16:53:58', 0, 0, NULL),
('030', 'Settings', 'settings.php', '019', ' ', '1', '2025-06-30 16:53:58', 0, 0, NULL),
('031', 'Manage Staff', 'manage_staff.php', '020', ' ', '1', '2025-06-30 16:56:34', 0, 0, NULL),
('033', 'Manage Departments', 'department.php', '020', ' ', '1', '2025-06-30 16:59:58', 0, 0, NULL),
('034', 'Item Categories', 'item_cat.php', '021', ' ', '1', '2025-06-30 16:59:58', 0, 0, NULL),
('035', 'All Items', 'allitems.php', '021', ' ', '1', '2025-06-30 17:02:24', 0, 0, NULL),
('036', 'Restock/ Replenish', 'restock.php', '021', ' ', '1', '2025-06-30 17:02:24', 0, 0, NULL),
('037', 'Damaged Items', 'Damaged.php', '021', ' ', '1', '2025-06-30 17:08:36', 0, 0, NULL),
('038', 'Allocate Items', 'allocate.php', '022', ' ', '1', '2025-06-30 17:08:36', 0, 0, NULL),
('039', 'View Allocations', 'view_allocation.php', '022', ' ', '1', '2025-06-30 17:12:41', 0, 0, NULL),
('040', 'Manage Store', 'manage_store.php', '025', ' ', '1', '2025-06-30 17:12:41', 0, 0, NULL),
('041', 'Manage Store Sections', 'store_section.php', '025', ' ', '1', '2025-06-30 17:18:01', 0, 0, NULL),
('042', 'Allocation Reports', 'alocatereport.php', '023', ' ', '1', '2025-06-30 17:18:01', 0, 0, NULL),
('043', 'Staff Usage Reports', 'staffusagerep.php', '023', ' ', '1', '2025-06-30 17:22:09', 0, 0, NULL),
('044', 'All User Actions', 'alluseractions.php', '024', ' ', '1', '2025-06-30 17:23:53', 0, 0, NULL),
('045', 'Inventory Logs', 'inventorylogs.php', '024', ' ', '1', '2025-06-30 17:23:53', 0, 0, NULL),
('046', 'Roles & Permission', 'managerole.php', '#', ' ', '0', '2025-06-30 17:32:41', 0, 0, NULL),
('047', 'Change Password', 'changepsw.php', '#', ' ', '0', '2025-06-30 17:32:41', 0, 0, NULL),
('049', 'Logout', 'logout.php', '#', ' ', '0', '2025-06-30 17:35:13', 0, 0, NULL),
('051', 'Staff', 'staff_list.php', '139', '', '1', '2018-12-11 11:50:18', 0, 0, NULL),
('054', 'Request Loan', 'loan_list.php', '140', '', '1', '2018-12-13 11:28:35', 0, 0, NULL),
('112', 'Loan Item', 'loan_item_list.php', '140', '', '1', '2018-12-13 21:41:44', 0, 0, NULL),
('130', 'Deduction List', 'deduction_list.php', '140', '', '1', '2018-12-14 11:48:27', 0, 0, NULL),
('131', 'Deduction Rate List', 'deduction_rate_list.php', '140', '', '1', '2018-12-14 11:49:31', 0, 0, NULL),
('132', 'Designation List', 'designation_list.php', '140', '', '1', '2018-12-14 11:50:03', 0, 0, NULL),
('133', 'Allowance List', 'allowance_list.php', '140', '', '1', '2018-12-14 11:50:50', 0, 0, NULL),
('134', 'Allowance Rate Setup', 'allowance_rate_list.php', '140', '', '1', '2018-12-14 11:51:32', 0, 0, NULL),
('139', 'Payroll', '#', '#', '', '0', '2018-12-14 13:09:59', 0, 0, NULL),
('140', 'Payroll Setup', '#', '#', '', '0', '2018-12-14 13:12:52', 0, 0, NULL),
('141', 'Payroll List', 'payroll_list.php', '139', '', '1', '2018-12-15 07:37:21', 0, 0, NULL),
('142', 'State Payroll', 'payroll_state.php', '143', '', '1', '2018-12-17 10:54:51', 0, 0, NULL),
('144', 'Employee Payroll', 'payroll_employee.php', '143', '', '1', '2018-12-17 10:56:31', 0, 0, NULL),
('145', 'Staff Movement', 'staff_movement_national.php', '008', ' ', '1', '2019-01-22 13:56:09', 0, 0, NULL),
('146', 'Staff Leave', 'leave_item_list.php', '140', ' ', '1', '2019-01-23 14:54:48', 0, 0, NULL),
('147', 'Manage Permissions', 'permissions_list.php', '004', '', '1', '2022-08-01 16:22:24', 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `menugroup`
--

CREATE TABLE `menugroup` (
  `role_id` varchar(5) NOT NULL,
  `menu_id` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='InnoDB free: 6144 kB; InnoDB free: 6144 kB; InnoDB free: 614' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `menugroup`
--

INSERT INTO `menugroup` (`role_id`, `menu_id`) VALUES
('', ''),
('001', '004'),
('001', '006'),
('001', '007'),
('001', '008'),
('001', '017'),
('001', '028'),
('001', '051'),
('001', '054'),
('001', '112'),
('001', '130'),
('001', '131'),
('001', '132'),
('001', '133'),
('001', '134'),
('001', '139'),
('001', '140'),
('001', '141'),
('001', '142'),
('001', '143'),
('001', '144'),
('001', '145'),
('001', '146'),
('001', '147'),
('002', '014'),
('002', '018'),
('002', '019'),
('002', '020'),
('002', '021'),
('002', '022'),
('002', '025'),
('002', '026'),
('002', '027'),
('002', '029'),
('002', '030'),
('002', '031'),
('002', '032'),
('002', '033'),
('002', '034'),
('002', '035'),
('002', '036'),
('002', '037'),
('002', '038'),
('002', '039'),
('002', '040'),
('002', '041'),
('002', '042'),
('002', '043'),
('002', '044'),
('002', '045'),
('002', '046'),
('002', '047'),
('002', '048'),
('002', '049'),
('002', '144'),
('002', '146'),
('003', '004'),
('003', '017'),
('003', '131'),
('003', '134');

-- --------------------------------------------------------

--
-- Table structure for table `merchant_reg`
--

CREATE TABLE `merchant_reg` (
  `merchant_id` varchar(20) NOT NULL,
  `merchant_address` text NOT NULL,
  `merchant_first_name` varchar(50) NOT NULL,
  `merchant_last_name` varchar(50) NOT NULL,
  `merchant_phone` varchar(20) NOT NULL,
  `merchant_email` varchar(50) NOT NULL,
  `merchant_dob` varchar(50) DEFAULT NULL,
  `merchant_response_url` varchar(200) NOT NULL,
  `merchant_response_url_hashkey` varchar(255) DEFAULT NULL,
  `merchant_response_url_flag` int(11) NOT NULL,
  `merchant_details` varchar(150) NOT NULL,
  `merchant_logo_path` varchar(150) NOT NULL,
  `merchant_category` varchar(20) NOT NULL,
  `top_merchant_flag` tinyint(1) DEFAULT NULL,
  `multiple_item_check` tinyint(1) DEFAULT NULL,
  `predefined_amount` int(11) DEFAULT NULL,
  `posted_ip` varchar(50) DEFAULT NULL,
  `created` datetime NOT NULL,
  `posted_user` varchar(20) DEFAULT NULL,
  `trans_charge_bearer` int(11) NOT NULL,
  `charge_mode` int(11) NOT NULL,
  `charge_rate_vuvaa` decimal(10,2) DEFAULT NULL,
  `charge_rate_etranzact` decimal(10,2) DEFAULT NULL,
  `charge_rate_interswitch` decimal(10,2) DEFAULT NULL,
  `fundgate_description` varchar(20) DEFAULT NULL,
  `individual_item_display` tinyint(1) DEFAULT 0,
  `active_merchant` tinyint(1) NOT NULL DEFAULT 1,
  `order_merchant` int(11) NOT NULL,
  `charge_rate_card` double UNSIGNED NOT NULL,
  `charge_rate_verve` varchar(20) NOT NULL,
  `verve_added_fee` varchar(10) DEFAULT NULL,
  `charge_rate_micro` varchar(20) DEFAULT NULL,
  `micro_added_fee` varchar(10) DEFAULT NULL,
  `charge_rate_internet` double NOT NULL,
  `is_bvn_profiled` tinyint(1) DEFAULT 0,
  `merchant_bvn` varchar(20) DEFAULT NULL,
  `bvn_attempts` varchar(10) DEFAULT '0',
  `account_name` varchar(255) DEFAULT NULL,
  `account_no` varchar(20) NOT NULL,
  `bank_code` varchar(100) NOT NULL,
  `white_label` int(11) DEFAULT NULL,
  `charge_rate_wallet` decimal(15,2) DEFAULT NULL,
  `secret_key` varchar(255) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `flat_charge` varchar(255) DEFAULT NULL,
  `percentage_charge` varchar(255) DEFAULT NULL,
  `aggregator_commission` varchar(50) NOT NULL DEFAULT '0.00',
  `reg_status` tinyint(1) DEFAULT 0 COMMENT 'This is Zero by default until the merchant''s BVN is validates',
  `cac_number` varchar(50) DEFAULT NULL,
  `cac_document_path` varchar(255) DEFAULT NULL,
  `is_cac_verified` tinyint(1) DEFAULT 0,
  `merchant_support_email` varchar(50) DEFAULT NULL,
  `merchant_business_name` varchar(50) DEFAULT NULL,
  `merchant_state` varchar(50) DEFAULT NULL,
  `merchant_lga` varchar(50) DEFAULT NULL,
  `merchant_business_description` text DEFAULT NULL,
  `merchant_business_details_flag` tinyint(1) DEFAULT 0,
  `merchant_business_phone` varchar(20) NOT NULL,
  `merchant_business_address_flag` tinyint(1) DEFAULT 0,
  `merchant_business_contact_flag` tinyint(1) DEFAULT 0,
  `is_approved` tinyint(1) DEFAULT 0,
  `reason_for_declining_approval` text DEFAULT NULL,
  `date_declined` datetime DEFAULT NULL,
  `aggregator_id` varchar(50) NOT NULL DEFAULT 'VA-AGGRE0001',
  `registration_completed` enum('0','1','','') NOT NULL,
  `profile_completed_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='InnoDB free: 4096 kB; InnoDB free: 4096 kB; InnoDB free: 409' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `merchant_reg`
--

INSERT INTO `merchant_reg` (`merchant_id`, `merchant_address`, `merchant_first_name`, `merchant_last_name`, `merchant_phone`, `merchant_email`, `merchant_dob`, `merchant_response_url`, `merchant_response_url_hashkey`, `merchant_response_url_flag`, `merchant_details`, `merchant_logo_path`, `merchant_category`, `top_merchant_flag`, `multiple_item_check`, `predefined_amount`, `posted_ip`, `created`, `posted_user`, `trans_charge_bearer`, `charge_mode`, `charge_rate_vuvaa`, `charge_rate_etranzact`, `charge_rate_interswitch`, `fundgate_description`, `individual_item_display`, `active_merchant`, `order_merchant`, `charge_rate_card`, `charge_rate_verve`, `verve_added_fee`, `charge_rate_micro`, `micro_added_fee`, `charge_rate_internet`, `is_bvn_profiled`, `merchant_bvn`, `bvn_attempts`, `account_name`, `account_no`, `bank_code`, `white_label`, `charge_rate_wallet`, `secret_key`, `is_active`, `flat_charge`, `percentage_charge`, `aggregator_commission`, `reg_status`, `cac_number`, `cac_document_path`, `is_cac_verified`, `merchant_support_email`, `merchant_business_name`, `merchant_state`, `merchant_lga`, `merchant_business_description`, `merchant_business_details_flag`, `merchant_business_phone`, `merchant_business_address_flag`, `merchant_business_contact_flag`, `is_approved`, `reason_for_declining_approval`, `date_declined`, `aggregator_id`, `registration_completed`, `profile_completed_at`, `updated_at`) VALUES
('PRO-120888', 'Rayfield Jos', 'Adekanmi', 'Victor', '09115465645', 'adekanmi@gmail.com', '2007-05-09', '', NULL, 0, '', 'uploads/merchants/PRO-120888/logo_1748533497.jpg', '', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, '', NULL, NULL, NULL, 0, 0, NULL, '0', NULL, '', '', NULL, NULL, '', 1, NULL, NULL, '0.00', 0, '90221122', 'uploads/merchants/PRO-120888/cac_1748533497.jpg', 0, 'Creatives@gmail.com', 'Creatives Enterprizes', '032', '032', 'Creating opportunities through Innovation', 0, '09115465645', 0, 0, 0, NULL, NULL, 'VA-AGGRE0001', '1', '2025-05-29 16:44:57', '2025-05-29 16:44:57'),
('PRO-283008', 'Rayfield Jos', 'Adekanmi', 'Victor', '09115465645', 'honour@mail.com', '2007-03-20', '', NULL, 0, '', 'uploads/merchants/PRO-283008/logo_1748875208.jpg', '', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, '', NULL, NULL, NULL, 0, 0, NULL, '0', NULL, '', '', NULL, NULL, '', 1, NULL, NULL, '0.00', 0, '9238942323', 'uploads/merchants/PRO-283008/cac_1748875208.jpg', 0, 'Honour@gmail.com', 'Honour', '034', '034', 'Honour', 0, '0091121121223', 0, 0, 0, NULL, NULL, 'VA-AGGRE0001', '1', '2025-06-02 15:40:08', '2025-06-02 15:40:08'),
('PRO-773289', 'Mazaram', 'Adekanmi', 'Testimony', '09030642134', 'adekanmi001247@gmail.com', '2007-05-08', '', NULL, 0, '', 'uploads/merchants/PRO-773289/logo_1748534752.jpg', '', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, '', NULL, NULL, NULL, 0, 0, NULL, '0', NULL, '', '', NULL, NULL, '', 1, NULL, NULL, '0.00', 0, '1234552312', 'uploads/merchants/PRO-773289/cac_1748534752.jpg', 0, 'Minds@gmail.com', 'Creatives Enterprizes', '015', '015', 'Minds', 0, '09012345622', 0, 0, 0, NULL, NULL, 'VA-AGGRE0001', '1', '2025-05-29 17:05:52', '2025-05-29 17:05:52'),
('VA-MERCH0001', 'Access Solution Ltd', 'Hugh Ifeanyichukwu', '', '08031372994', 'hughi.obeni@gmail.com', '2023-06-25', 'http://localhost/core_mfb/repo/cron/cron_webhook.php', 'bU12YS9ENkFFaDlwMGVoalFIQ1NXNUJKZkxkZUxYdm0xV3ZaU25xUGxEcHZXNXYrZWpiaTA4Y205RVBPZjRmSFZZWHl5VFdUcmorNHNBTGtOaHIxeXc9PQ==', 1, '', 'http://localhost/virtual/admin/uploads/vamerch0001.png', '', NULL, NULL, NULL, '::1', '2023-03-27 11:55:58', 'VA-MERCH0001', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, '0', NULL, NULL, NULL, 0, 1, '102457863654', '0', 'OBENI IFEANYICHUKWU HUGH', '3065732279', 'First Bank of Nigeria', NULL, NULL, 'sk_4j5oSGAeDm0njU8sW4RcJo7wTyihVC9TlQMA3NJ0x7o', 1, '10', '0', '0.00', 0, 'RC457552', 'http://localhost/virtual/admin/uploads/cacdocuments/vamerch0001.jpg', 1, 'hughi.obeni@gmail.com', 'Access Solutions Limited', '15', '782', 'IT Firm', 1, '', 1, 1, 1, 'No valid information', '2023-07-18 14:13:15', 'VA-AGGRE0001', '0', NULL, NULL),
('VA-MERCH0007', 'Zik\'s Avenue', 'Doris Kiptie', '', '07081111188', 'madekwe.chibuzor@accessng.com', '1954-10-12', '', NULL, 1, '', 'https://nectapay.com/npd/admin/uploads/vamerch0007.png', '', NULL, NULL, NULL, '41.242.60.189', '2023-07-24 11:38:43', 'VA-MERCH0007', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, '0', NULL, NULL, NULL, 0, 1, '22287654321', '1', 'MADEKWE CHIBUZO ANAYO', '0046841859', '058', NULL, NULL, 'sk_0a7f458bfaa4decffcb78cb3ab186a98e', 1, NULL, NULL, '0.00', 1, 'RC1234567', 'https://nectapay.com/npd/admin/uploads/cacdocuments/vamerch0007.jpg', 1, 'vuvaamobile@gmail.com', 'Unique Chops', '4', '80', 'We are your plug for confectioneries, contact us to spice us your event with unique taste.', 1, '', 1, 1, 1, 'Invalid CAC Registration Number', '2023-07-24 13:09:28', 'VA-AGGRE0001', '0', NULL, NULL),
('VA-MERCH2037', '', 'Ken  Nedy', '', '09066653532', 'mecrha@yahoo.com', '', '', NULL, 1, '', '', '0', NULL, NULL, NULL, '41.242.60.189', '2023-09-29 14:27:41', 'VA-MERCH2037', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, '0', NULL, NULL, NULL, 0, 0, '', '0', NULL, '0', '0', NULL, NULL, 'sk_eTFiL21DNkozeENpSEVVZjVSTkZ0QT09', 1, '50', '0', '10.00', 1, 'RC1987645', 'https://nectapay.com/npd/admin/uploads/cacdocuments/vaaggre3302.jpg', 1, NULL, NULL, NULL, NULL, NULL, 0, '', 0, 0, 0, NULL, NULL, 'VA-AGGRE3302', '0', NULL, NULL),
('VA-MERCH2746', '', 'Bob  Steve', '', '07067676767', 'nectamercha@gmail.com', '', '', NULL, 1, '', '', '0', NULL, NULL, NULL, '41.242.60.189', '2023-09-21 15:21:03', 'VA-MERCH2746', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, '0', NULL, NULL, NULL, 0, 0, '', '0', NULL, '0', '0', NULL, NULL, 'sk_K090RUCNzZUZFdiTURZbm5DN0d1Zz09', 1, '50', '0', '10.00', 1, 'RC1987645', 'https://nectapay.com/npd/admin/uploads/cacdocuments/vaaggre3302.jpg', 1, NULL, NULL, NULL, NULL, NULL, 0, '', 0, 0, 0, NULL, NULL, 'VA-AGGRE3302', '0', NULL, NULL),
('VA-MERCH5788', '', 'Check  Again', '', '08066778877', 'heet000@gmail.com', '', '', NULL, 1, '', '', '', NULL, NULL, NULL, '41.242.60.189', '2023-09-19 13:51:08', 'VA-MERCH5788', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, '0', NULL, NULL, NULL, 0, 0, '', '0', NULL, '0', '0', NULL, NULL, 'sk_elBDdHBzdEorQThHOUg0ZHFrV3BUZz09', 1, '50', '0', '10.00', 1, 'RC1987645', 'https://nectapay.com/npd/admin/uploads/cacdocuments/vaaggre3302.jpg', 1, NULL, NULL, NULL, NULL, NULL, 0, '', 0, 0, 0, NULL, NULL, 'VA-AGGRE3302', '0', NULL, NULL),
('VA-MERCH6655', 'Road 69 Gwarimpa, 5th Avenue', 'Chibuzo  Madekwe', '', '09035465763', 'nectamerchatwo@gmail.com', '1983-11-29', '', NULL, 1, '', 'https://nectapay.com/npd/admin/uploads/vamerch6655.png', '0', NULL, NULL, NULL, '41.242.60.189', '2023-09-29 15:05:40', 'VA-MERCH6655', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, '0', NULL, NULL, NULL, 0, 1, '22220773739', '1', NULL, '0', '0', NULL, NULL, 'sk_ZkYrNFF6Qkp0V0ZneHBSUytJY1FQdz09', 1, '50', '0', '10.00', 1, 'RC1987645', 'https://nectapay.com/npd/admin/uploads/cacdocuments/vaaggre3302.jpg', 1, 'nectamerchatwo@gmail.com', 'House of Choice', '15', '782', 'We touch your house for your choice.', 1, '', 1, 1, 0, NULL, NULL, 'VA-AGGRE3302', '0', NULL, NULL),
('VA-MERCH9639', '', 'Ifeanyichukwu Obeni', '', '08031372997', 'hugh.i.obeni@gmail.com', '', '', NULL, 1, '', '', '', NULL, NULL, NULL, '41.242.60.189', '2023-08-21 11:54:14', 'VA-MERCH9639', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, '0', NULL, NULL, NULL, 0, 0, '', '0', NULL, '0', '0', NULL, NULL, 'sk_dlM4MlpKbjlhbFhoT0ZycDZyQpEdz09', 1, '50', NULL, '0.00', 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, '', 0, 0, 0, NULL, NULL, 'VA-AGGRE0001', '0', NULL, NULL),
('VA-MERCH9867', '22 Kwameh Nkrumah way Asokoro.', 'Christian Okoye', '', '9034343433', 'testm2023@yahoo.com', '1983-11-29', '', NULL, 1, '', 'https://nectapay.com/npd/admin/uploads/vamerch9867.png', '', NULL, NULL, NULL, '41.242.60.189', '2023-08-21 11:50:59', 'VA-MERCH9867', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, '0', NULL, NULL, NULL, 0, 0, '', '1', NULL, '0', '0', NULL, NULL, 'sk_NGRaEg0WTFDYktpVlpTNm40NkZSUT09', 1, '50', NULL, '0.00', 1, NULL, NULL, 0, 'testm2023@yahoo.com', 'Chris Surveillance Limited', '15', '782', 'Dealers on all kinds of security gadgets and set up.', 1, '', 1, 1, 0, NULL, NULL, 'VA-AGGRE0001', '0', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `parameter`
--

CREATE TABLE `parameter` (
  `parameter_name` varchar(50) DEFAULT NULL,
  `parameter_value` text DEFAULT NULL,
  `privilege_flag` char(1) DEFAULT NULL,
  `parameter_description` varchar(150) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `parameter`
--

INSERT INTO `parameter` (`parameter_name`, `parameter_value`, `privilege_flag`, `parameter_description`, `created`) VALUES
('working_hours', '00:00-23:59', '0', 'Allotted working hours of the day', '2009-10-31 00:00:00'),
('no_of_pin_misses', '5', '1', 'Available number of pin misses allowed', '2009-11-16 12:44:27'),
('password_expiry_days', '360', '1', 'Number of days for password expiry', '2009-12-04 13:05:30'),
('Convient Fee Setup', '500', '0', 'Convient Fee Setup', '2016-10-26 18:38:44'),
('ticket_reservation_holding_max_time', '5', '1', 'Minutes the a Ticket is to be left reserved for payment to be done otherwise opened for purchase', '2018-07-23 12:04:24'),
('teasypay_api_buygoods_soapaction', 'http://41.220.65.180:8080/axis2/services/HRestAPITSHA/buyGoods', '1', 'Teasy Pay Api URL', '2018-07-30 16:35:52'),
('teasypay_api_apipass', 'qQgGbv6Hj684p0', '1', 'Hash Key', '2018-07-30 18:15:41'),
('teasypay_api_apiuser', 'gWtIgw29tks1kz', '1', 'Api User', '2018-07-30 18:46:52'),
('teasypay_api_soapurl', 'http://41.220.65.180:8080/axis2/services/HRestAPITSHA?wsdl', NULL, NULL, NULL),
('teasypay_api_balance_soapaction', 'http://41.220.65.180:8080/axis2/services/HRestAPITSHA/queryBalanceCustomer', NULL, NULL, NULL),
('boarding_time_before_departure_time', '2000', NULL, 'Minutes to Allow For Booking before a schedule departure time', '2018-08-04 16:49:30'),
('login_keep_alive', '300', '1', 'Expiration time for a keep alive of user session', '2018-08-06 18:17:28'),
('softcom_api_push_ticket', 'https://abuja-metro.appspot.com/api/v1/tickets/new', NULL, 'Send New Tickets to the Validation System', '2018-08-14 16:56:35'),
('site_local_url', 'http://localhost:85/access_framework/demo/', '0', 'Page Live Url', '2022-08-15 22:11:11'),
('site_live_url', 'https://vpurse.vuvaa.com/', '0', 'Page Local URL', '2022-08-15 22:12:54');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `label` varchar(50) DEFAULT NULL,
  `operation_type` varchar(20) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `posted_user` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `posted_ip` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `posted_userid` bigint(20) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  `lastmodified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `action`, `label`, `operation_type`, `description`, `created`, `posted_user`, `posted_ip`, `posted_userid`, `is_deleted`, `lastmodified`) VALUES
(1, 'Role.role_list', 'Role List', 'all_op', '', '2022-07-14 04:30:04', 'adakj', '127.0.0.1', NULL, 0, NULL),
(2, 'Role.delete_role', 'Delete Role', 'all_op', '', '2022-07-14 04:34:17', 'adakj', '127.0.0.1', NULL, 0, NULL),
(3, 'Role.saveRole', 'Save New Role', 'new', 'User Role Creation', '2022-07-14 04:35:11', 'sam@mail.com', '127.0.0.1', NULL, 0, '2022-09-28 03:23:28'),
(4, 'Role.saveRole', 'Update Role', 'edit', '', '2022-07-14 04:36:08', 'adakj', '127.0.0.1', NULL, 0, NULL),
(5, 'Permissions.savePermissions', 'Save New Permissions', 'new', '', '2022-07-14 04:47:34', 'adakj', '127.0.0.1', NULL, 0, NULL),
(6, 'Permissions.savePermissions', 'Update Permissions', 'edit', '', '2022-07-14 04:48:04', 'adakj', '127.0.0.1', NULL, 0, '2022-07-14 04:48:39'),
(13, 'Permissions.permission_list', 'Permissions List', 'all_op', '', '2022-07-15 10:56:44', 'adakj', '127.0.0.1', NULL, 0, NULL),
(14, 'Permissions.loadPermissions', 'Load Permissions', 'all_op', 'Load Permissions', '2022-07-15 10:57:31', 'adakj', '127.0.0.1', NULL, 0, '2022-07-15 11:04:07'),
(15, 'Permissions.saveActions', 'Save Permission Map', 'all_op', 'Save Permission Map', '2022-07-15 10:58:15', 'adakj', '127.0.0.1', NULL, 0, NULL),
(16, 'Permissions.deletePermission', 'Delete Permissions', 'all_op', 'Delete Permissions', '2022-07-15 11:00:05', 'adakj', '127.0.0.1', NULL, 0, NULL),
(17, 'Permissions.inVisibleActions', 'Load Visible Permissions', 'all_op', 'Load Visible Permissions', '2022-07-15 11:01:28', 'adakj', '127.0.0.1', NULL, 0, NULL),
(18, 'Permissions.visibleActions', 'Load Invisible Permissions', 'all_op', 'Load Invisible Permissions', '2022-07-15 11:02:31', 'adakj', '127.0.0.1', NULL, 0, NULL),
(19, 'Menu.loadmenus', 'Load Menus', 'all_op', NULL, '2022-07-15 12:33:14', 'nnpcretail', '127.0.0.1', NULL, 0, NULL),
(20, 'users.getActivityLog', 'Activity Logs', 'all_op', 'Load All Activities', '2022-07-15 13:04:17', 'nnpcretail', '127.0.0.1', NULL, 0, NULL),
(23, 'Users.userlist', 'User List', 'all_op', 'Load User List', '2022-07-15 13:55:34', 'nnpcretail', '127.0.0.1', NULL, 0, NULL),
(25, 'menu.saveMenu', 'Save Menu', 'new', 'Save Menu', '2022-07-15 13:59:39', 'nnpcretail', '127.0.0.1', NULL, 0, NULL),
(27, 'Users.saveUser', 'Save User', 'new', 'Save User', '2022-07-15 15:34:07', 'nnpcretail', '41.242.60.178', NULL, 0, '2022-07-15 03:49:59'),
(28, 'Menu.generateMenu', 'Generate Navigation Menu', 'all_op', 'Generate Navigation Menu', '2022-07-15 12:53:14', 'adakj', '127.0.0.1', NULL, 0, NULL),
(29, 'Menu.saveMenu', 'Update Menu', 'edit', 'Update Menu', '2022-07-15 12:55:07', 'adakj', '127.0.0.1', NULL, 0, NULL),
(30, 'Menu.loadParentMenu', 'Load Parent Menu', 'all_op', '', '2022-07-15 01:16:14', 'adakj', '127.0.0.1', NULL, 0, NULL),
(31, 'Menu.deleteMenu', 'Delete Menu', 'all_op', '', '2022-07-15 01:17:17', 'adakj', '127.0.0.1', NULL, 0, NULL),
(32, 'Menu.menuList', 'Menu List', 'all_op', 'Menu List', '2022-07-15 01:18:13', 'adakj', '127.0.0.1', NULL, 0, NULL),
(33, 'Menu.visibleMenus', 'Load Visible Menu', 'all_op', 'Load Invisible Menu', '2022-07-15 01:23:44', 'adakj', '127.0.0.1', NULL, 0, '2022-07-15 01:25:11'),
(34, 'Menu.inVisibleMenus', 'Load Invisible Menu', 'all_op', '', '2022-07-15 01:25:51', 'adakj', '127.0.0.1', NULL, 0, NULL),
(35, 'Menu.saveMenuGroup', 'Save Menu Group', 'all_op', '', '2022-07-15 02:19:49', 'adakj', '127.0.0.1', NULL, 0, NULL),
(78, 'Role.generateInvoice', 'Generate Invoice', 'all_op', '', '2022-07-15 04:41:28', 'adakj', '127.0.0.1', NULL, 0, NULL),
(116, 'Users.saveUser', 'Update User Profile', 'edit', '', '2022-07-15 06:59:16', 'adakj', '127.0.0.1', NULL, 0, NULL),
(117, 'Users.confirmCurrent', 'Confirm Current Password', 'all_op', '', '2022-07-15 07:02:42', 'adakj', '127.0.0.1', NULL, 0, NULL),
(120, 'Users.resetPassword', 'Users Reset Password', 'all_op', '', '2022-07-15 07:32:59', 'adakj', '127.0.0.1', NULL, 0, NULL),
(121, 'Users.doForgotPasswordChange', 'User Forgot Password Change', 'all_op', '', '2022-07-15 07:34:52', 'adakj', '127.0.0.1', NULL, 0, NULL),
(122, 'Users.generatePwdLink', 'Generate Password Link', 'all_op', '', '2022-07-15 07:36:12', 'adakj', '127.0.0.1', NULL, 0, NULL),
(123, 'Users.verifyLink', 'Verify Password Link', 'all_op', '', '2022-07-15 07:37:00', 'adakj', '127.0.0.1', NULL, 0, '2022-07-15 07:39:05'),
(124, 'Users.getLgas', 'Get All LGAs', 'all_op', '', '2022-07-15 07:40:43', 'adakj', '127.0.0.1', NULL, 0, NULL),
(125, 'Users.profileEdit', 'User Profile Edit', 'edit', '', '2022-07-15 07:44:37', 'adakj', '127.0.0.1', NULL, 0, NULL),
(126, 'Users.emailPasswordReset', 'User Email Password Reset', 'all_op', '', '2022-07-15 08:00:09', 'adakj', '127.0.0.1', NULL, 0, NULL),
(127, 'Users.changeUserStatus', 'Disable/Enable Users', 'all_op', '', '2022-07-15 08:01:46', 'adakj', '127.0.0.1', NULL, 0, NULL),
(128, 'Users.unLockUser', 'Unlock Users Account', 'all_op', '', '2022-07-15 08:02:26', 'adakj', '127.0.0.1', NULL, 0, NULL),
(129, 'Users.passwordChange', 'Users Change Password', 'all_op', '', '2022-07-15 08:03:40', 'adakj', '127.0.0.1', NULL, 0, NULL),
(133, 'Users.userProfileUpdate', 'All User Profile Update ', 'edit', 'All User Profile Update', '2022-07-25 06:54:24', 'one@demo.com', '127.0.0.1', NULL, 0, NULL),
(134, 'Dashboard.carousel', 'Dashboard Carousel', 'all_op', '', '2022-08-01 07:56:11', '', '127.0.0.1', NULL, 0, NULL),
(135, 'Dashboard.remittance', 'Dashboard Remittance', 'all_op', '', '2022-08-01 07:57:42', '', '127.0.0.1', NULL, 0, NULL),
(136, 'Dashboard.topFiveChurches', 'Dashboard Top Churches', 'all_op', '', '2022-08-01 07:58:21', '', '127.0.0.1', NULL, 0, NULL),
(137, 'Users.sackUser', 'Sack Users', 'all_op', '', '2022-08-05 11:29:45', '', '127.0.0.1', NULL, 0, NULL),
(138, 'Users.sackUsers', 'Sack Usersrrr', 'edit', 'test', '2022-08-05 11:41:55', 'sam@mail.com', '127.0.0.1', NULL, 1, NULL),
(139, 'Users.doPasswordChange', 'User Password Change', 'all_op', '', '2022-08-06 08:23:48', 'sam@mail.com', '127.0.0.1', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions_map`
--

CREATE TABLE `permissions_map` (
  `role_id` varchar(5) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `posted_user` varchar(50) DEFAULT NULL,
  `posted_ip` varchar(30) DEFAULT NULL,
  `posted_userid` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `permissions_map`
--

INSERT INTO `permissions_map` (`role_id`, `permission_id`, `created`, `posted_user`, `posted_ip`, `posted_userid`) VALUES
('001', 1, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 2, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 3, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 4, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 5, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 6, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 13, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 14, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 15, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 16, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 17, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 18, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 19, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 20, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 23, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 25, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 27, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 28, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 29, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 30, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 31, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 32, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 33, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 34, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 35, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 78, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 116, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 117, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 120, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 121, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 122, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 123, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 124, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 125, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 126, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 127, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 128, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 129, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 133, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 134, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 135, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 136, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 137, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('001', 139, '2022-08-06 08:24:11', 'sam@mail.com', '127.0.0.1', NULL),
('0011', 134, '2022-09-14 11:49:16', 'sam@mail.com', '127.0.0.1', NULL),
('0011', 136, '2022-09-14 11:49:16', 'sam@mail.com', '127.0.0.1', NULL),
('002', 134, '2022-08-11 04:02:26', 'sam@mail.com', '127.0.0.1', NULL),
('005', 134, '2022-08-15 11:37:03', 'sam@mail.com', '127.0.0.1', NULL),
('005', 135, '2022-08-15 11:37:03', 'sam@mail.com', '127.0.0.1', NULL),
('006', 6, '2022-09-14 11:54:35', 'sam@mail.com', '127.0.0.1', NULL),
('006', 15, '2022-09-14 11:54:35', 'sam@mail.com', '127.0.0.1', NULL),
('006', 18, '2022-09-14 11:54:35', 'sam@mail.com', '127.0.0.1', NULL),
('006', 78, '2022-09-14 11:54:35', 'sam@mail.com', '127.0.0.1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `professional_qualification`
--

CREATE TABLE `professional_qualification` (
  `qualification_id` int(20) NOT NULL,
  `merchant_id` varchar(100) NOT NULL,
  `staff_id` varchar(50) NOT NULL,
  `qualification_name` varchar(50) NOT NULL,
  `year_obtained` varchar(50) NOT NULL,
  `date_created` datetime(6) NOT NULL,
  `created_officer` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qualification`
--

CREATE TABLE `qualification` (
  `merchant_id` varchar(20) NOT NULL,
  `qualification_id` varchar(50) NOT NULL,
  `qualification_name` varchar(100) NOT NULL,
  `qualification_status` varchar(20) NOT NULL,
  `created_at` datetime(6) NOT NULL,
  `created_officer` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `merchant_id` varchar(100) NOT NULL,
  `role_id` varchar(5) NOT NULL DEFAULT '',
  `role_name` varchar(60) DEFAULT NULL,
  `role_enabled` char(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`merchant_id`, `role_id`, `role_name`, `role_enabled`, `created`) VALUES
('', '001', 'Super Administrator', '', '2009-10-31 18:54:57'),
('', '002', 'Merchant', '1', '2025-06-19 10:00:33'),
('', '012', 'Sub_admin', '1', '2025-06-19 09:59:59'),
('', '013', 'Manager', '1', '2025-06-19 10:00:33'),
('', '014', 'Staff', '1', '2025-06-19 10:00:44');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `merchant_id` varchar(100) NOT NULL,
  `section_id` int(11) NOT NULL,
  `section_name` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `store_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `merchant_id` varchar(50) NOT NULL,
  `staff_id` int(50) NOT NULL,
  `staff_code` varchar(50) NOT NULL,
  `staff_first_name` varchar(100) NOT NULL,
  `staff_middle_name` varchar(50) NOT NULL,
  `staff_last_name` varchar(50) NOT NULL,
  `depmt_id` int(100) NOT NULL,
  `depmt_head` varchar(100) NOT NULL,
  `staff_email` varchar(20) NOT NULL,
  `staff_phone_no` varchar(20) NOT NULL,
  `staff_description` varchar(100) NOT NULL,
  `staff_address` text NOT NULL,
  `staff_status` enum('0','1') NOT NULL,
  `created_at` datetime NOT NULL,
  `created_officer` varchar(100) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_officer` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`merchant_id`, `staff_id`, `staff_code`, `staff_first_name`, `staff_middle_name`, `staff_last_name`, `depmt_id`, `depmt_head`, `staff_email`, `staff_phone_no`, `staff_description`, `staff_address`, `staff_status`, `created_at`, `created_officer`, `updated_at`, `updated_officer`) VALUES
('PRO-773289', 2, 'MIN761', 'Adekanmi', '', 'Victor', 4, '1', 'Jesuslovestestimony@', '09030642134', 'Web Developer', 'Rayfield Jos', '1', '2025-06-19 23:24:36', 'Jesuslovestestimony@gmail.com', '2025-06-19 23:24:36', 'Jesuslovestestimony@gmail.com'),
('PRO-283008', 3, 'HON977', 'Adekanmi', '', 'Victor', 0, '', 'Majesty@gmail.com', '0912838392', 'Network administrator', 'Rayfield Jos', '1', '2025-06-02 15:43:50', 'adekanmi001247@gmail.com', '0000-00-00 00:00:00', ''),
('PRO-773289', 4, 'STA787', 'Adekanmi', '', 'Testimony', 3, '', 'Jesuslovestestimony@', '09030642134', 'Web developer', 'Mazaram Topp', '0', '2025-06-04 21:20:07', 'Jesuslovestestimony@gmail.com', '2025-06-04 21:20:07', 'Jesuslovestestimony@gmail.com'),
('PRO-511023', 5, 'NEW824', 'Adekanmi', '', 'Victor', 5, '', 'Jesuslovestestimony@', '09030642134', 'Web Developer', 'Rayfield Jos', '1', '2025-07-01 12:10:28', 'ugo.malu@accessng.com', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `merchant_id` varchar(100) NOT NULL,
  `store_id` int(11) NOT NULL,
  `store_name` varchar(100) NOT NULL,
  `item_id` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_table`
--

CREATE TABLE `transaction_table` (
  `transaction_id` varchar(50) NOT NULL DEFAULT '0',
  `source_acct` varchar(100) DEFAULT NULL,
  `destination_acct` varchar(100) DEFAULT NULL,
  `trans_type` varchar(50) DEFAULT NULL,
  `transaction_desc` text DEFAULT NULL,
  `transaction_amount` decimal(50,2) DEFAULT NULL,
  `response_code` varchar(100) DEFAULT NULL,
  `payment_mode` varchar(50) DEFAULT NULL,
  `posted_ip` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `posted_user` varchar(100) DEFAULT NULL,
  `merchant_category` varchar(4) DEFAULT NULL,
  `settlement_status` int(1) UNSIGNED ZEROFILL DEFAULT 0,
  `settlement_id` varchar(80) DEFAULT NULL,
  `session_id` varchar(200) DEFAULT NULL,
  `debit_flag` int(11) NOT NULL,
  `debit_flag_date` date NOT NULL,
  `reversal_flag` int(11) NOT NULL,
  `reversal_flag_date` date NOT NULL,
  `trans_query_id` int(11) DEFAULT NULL,
  `merchant_commission` decimal(50,2) DEFAULT NULL,
  `chargefee` decimal(50,2) DEFAULT NULL,
  `response_message` varchar(100) DEFAULT NULL,
  `charge_currency` varchar(10) DEFAULT NULL,
  `payment_gateway` varchar(80) DEFAULT NULL,
  `request_reversal` tinyint(1) DEFAULT 0,
  `reversal_request_date` datetime DEFAULT NULL,
  `reversal_approval_date` datetime DEFAULT NULL,
  `reversal_approved_by` varchar(200) DEFAULT NULL,
  `is_processed` tinyint(1) DEFAULT 0,
  `merchant_trans_id` varchar(225) DEFAULT NULL,
  `ussd_code` varchar(25) DEFAULT NULL,
  `revenue` decimal(50,2) DEFAULT NULL,
  `church_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='InnoDB free: 4096 kB; InnoDB free: 3072 kB; InnoDB free: 307' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `transaction_table`
--

INSERT INTO `transaction_table` (`transaction_id`, `source_acct`, `destination_acct`, `trans_type`, `transaction_desc`, `transaction_amount`, `response_code`, `payment_mode`, `posted_ip`, `created`, `posted_user`, `merchant_category`, `settlement_status`, `settlement_id`, `session_id`, `debit_flag`, `debit_flag_date`, `reversal_flag`, `reversal_flag_date`, `trans_query_id`, `merchant_commission`, `chargefee`, `response_message`, `charge_currency`, `payment_gateway`, `request_reversal`, `reversal_request_date`, `reversal_approval_date`, `reversal_approved_by`, `is_processed`, `merchant_trans_id`, `ussd_code`, `revenue`, `church_id`) VALUES
('000000036181031012110', 'chimalupaul@gmail.com', 'USS-VUVAA000000036', '', 'Purchase of GLO airtime', 200.00, '00', 'USSD', NULL, '2018-10-31 13:21:10', NULL, NULL, 1, 'SETL-181031015243', 'jhhbjv7cff', 0, '0000-00-00', 0, '0000-00-00', NULL, NULL, 0.00, 'Successful', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, 'ACC00000323', NULL, NULL),
('000000036181031012802', 'chimalupaul@gmail.com', 'USS-VUVAA000000036', '', 'Purchase of GLO airtime', 200.00, '99', 'USSD', NULL, '2018-10-31 13:28:03', NULL, NULL, 1, 'SETL-181031015243', NULL, 0, '0000-00-00', 0, '0000-00-00', NULL, NULL, 0.00, 'Intialized', NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, 'ACC00000423', NULL, NULL),
('000000036181031012847', 'chimalupaul@gmail.com', 'USS-VUVAA000000036', '', 'Purchase of MTN airtime', 200.00, '99', 'USSD', NULL, '2018-10-31 13:28:47', NULL, NULL, 1, 'SETL-181031015243', NULL, 0, '0000-00-00', 0, '0000-00-00', NULL, NULL, 0.00, 'Intialized', NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, 'ACC00000523', NULL, NULL),
('000000036181031015058', 'chimalupaul@gmail.com', 'USS-VUVAA000000036', '', 'Purchase of GLO airtime', 500.00, '00', 'USSD', NULL, '2018-10-31 13:50:58', NULL, NULL, 1, 'SETL-181031015243', 'jhhbjv7cff', 0, '0000-00-00', 0, '0000-00-00', NULL, NULL, 0.00, 'Successful', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, 'ACC00000723', NULL, NULL),
('000000036181031060239', 'chimalupaul@gmail.com', 'USS-VUVAA000000036', '', 'Purchase of GLO airtime', 200.00, '99', 'USSD', NULL, '2018-10-31 18:02:40', NULL, NULL, 0, NULL, NULL, 0, '0000-00-00', 0, '0000-00-00', NULL, NULL, 0.00, 'Intialized', NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, 'ACC00001823', 0.00, NULL),
('000000036181031111901', 'chimalupaul@gmail.com', 'USS-VUVAA000000036', '', 'Purchase of MTN airtime', 500.00, '00', 'USSD', NULL, '2018-10-31 11:19:02', NULL, NULL, 1, 'SETL-181031015243', 'jhhbjv7cff', 0, '0000-00-00', 0, '0000-00-00', NULL, NULL, NULL, 'Successful', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, 'ACC00000223', NULL, NULL),
('000000086181023034733', 'okon@gmail.com', 'ACC-OPMHT000000086', '', 'Purchase of GLO airtime', 200.00, '99', 'USSD', NULL, '2018-10-29 10:29:35', NULL, NULL, 0, NULL, NULL, 0, '0000-00-00', 0, '0000-00-00', NULL, NULL, NULL, 'Intialized', NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, 'ACC00000802', NULL, NULL),
('000000086181023055759', 'okon@gmail.com', 'ACC-OPMHT000000086', '', 'Purchase of GLO airtime', 200.00, '00', 'USSD', NULL, '2018-10-24 13:40:00', NULL, NULL, 0, NULL, '477383uss', 0, '0000-00-00', 0, '0000-00-00', NULL, NULL, NULL, 'Successful', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
('000000086181023070027', 'chimalupaul@gmail.com', 'ACC-OPMHT000000086', '', 'Purchase of GLO airtime', 200.00, '99', 'USSD', NULL, '2018-10-23 19:00:27', NULL, NULL, 0, NULL, NULL, 0, '0000-00-00', 0, '0000-00-00', NULL, NULL, NULL, 'Intialized', NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
('000000086181024022011', 'chimalupaul@gmail.com', 'ACC-OPMHT000000086', '', 'Purchase of GLO airtime', 200.00, '00', 'USSD', NULL, '2018-10-29 14:20:12', NULL, NULL, 0, NULL, 'jhhbjv7cff', 0, '0000-00-00', 0, '0000-00-00', NULL, NULL, NULL, 'Successful', NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
('000000086181024031325', 'chimalupaul@gmail.com', 'ACC-OPMHT000000086', '', 'Purchase of GLO airtime', 200.00, '00', 'USSD', NULL, '2018-10-29 15:34:25', NULL, NULL, 0, NULL, 'jhhbjv7cff', 0, '0000-00-00', 0, '0000-00-00', NULL, NULL, NULL, 'Successful', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
('000000086181024040127', 'chimalupaul@gmail.com', 'ACC-OPMHT000000087', '', 'Purchase of MTN airtime', 200.00, '00', 'USSD', NULL, '2018-10-29 16:01:28', NULL, NULL, 1, 'SETL-181031104315', 'jhhbjv7cff', 0, '0000-00-00', 0, '0000-00-00', NULL, NULL, NULL, 'Successful', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
('000000086181024042836', 'chimalupaul@gmail.com', 'USS-VUVAA000000036', '', 'Purchase of MTN airtime', 500.00, '00', 'USSD', NULL, '2018-10-29 16:28:36', NULL, NULL, 1, NULL, 'jhhbjv7cff', 0, '0000-00-00', 0, '0000-00-00', NULL, NULL, NULL, 'Successful', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
('000000086181025083508', 'chimalupaul@gmail.com', 'ACC-OPMHT000000086', '', 'Purchase of MTN airtime', 200.00, '99', 'USSD', NULL, '2018-10-25 20:35:10', NULL, NULL, 0, NULL, NULL, 0, '0000-00-00', 0, '0000-00-00', NULL, NULL, NULL, 'Intialized', NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, 'ACC102', NULL, NULL),
('000000086181025083849', 'chimalupaul@gmail.com', 'ACC-OPMHT000000086', '', 'Purchase of GLO airtime', 200.00, '99', 'USSD', NULL, '2018-10-25 20:38:50', NULL, NULL, 0, NULL, NULL, 0, '0000-00-00', 0, '0000-00-00', NULL, NULL, NULL, 'Intialized', NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, 'ACC00000002', NULL, NULL),
('000000086181025084033', 'chimalupaul@gmail.com', 'ACC-OPMHT000000086', '', 'Purchase of GLO airtime', 200.00, '00', 'USSD', NULL, '2018-10-25 20:40:34', NULL, NULL, 0, NULL, 'jhhbjv7cff', 0, '0000-00-00', 0, '0000-00-00', NULL, NULL, NULL, 'Successful', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, 'ACC00000102', NULL, NULL),
('000000086181025084913', 'chimalupaul@gmail.com', 'ACC-OPMHT000000086', '', 'Purchase of MTN airtime', 200.00, '00', 'USSD', NULL, '2018-10-25 20:49:14', NULL, NULL, 0, NULL, 'jhhbjv7cff', 0, '0000-00-00', 0, '0000-00-00', NULL, NULL, NULL, 'Successful', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, 'ACC00000202', NULL, NULL),
('000000086181025085006', 'chimalupaul@gmail.com', 'ACC-OPMHT000000086', '', 'Purchase of MTN airtime', 200.00, '00', 'USSD', NULL, '2018-10-25 20:50:06', NULL, NULL, 0, NULL, 'jhhbjv7cff', 0, '0000-00-00', 0, '0000-00-00', NULL, NULL, NULL, 'Successful', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, 'ACC00000302', NULL, NULL),
('000000086181025085115', 'chimalupaul@gmail.com', 'ACC-OPMHT000000086', '', 'Purchase of GLO airtime', 200.00, '00', 'USSD', NULL, '2018-10-25 20:51:15', NULL, NULL, 0, NULL, 'jhhbjv7cff', 0, '0000-00-00', 0, '0000-00-00', NULL, NULL, NULL, 'Successful', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, 'ACC00000402', NULL, NULL),
('000000086181025085159', 'chimalupaul@gmail.com', 'ACC-OPMHT000000086', '', 'Purchase of ZAIN airtime', 100.00, '00', 'USSD', NULL, '2018-10-25 20:51:59', NULL, NULL, 0, NULL, 'jhhbjv7cff', 0, '0000-00-00', 0, '0000-00-00', NULL, NULL, NULL, 'Successful', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, 'ACC00000502', NULL, NULL),
('000000086181025085446', 'chimalupaul@gmail.com', 'ACC-OPMHT000000086', '', 'Purchase of MTN airtime', 100.00, '00', 'USSD', NULL, '2018-10-25 20:54:46', NULL, NULL, 0, NULL, 'jhhbjv7cff', 0, '0000-00-00', 0, '0000-00-00', NULL, NULL, NULL, 'Successful', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, 'ACC00000602', NULL, NULL),
('000000086181025085550', 'chimalupaul@gmail.com', 'ACC-OPMHT000000086', '', 'Purchase of GLO airtime', 100.00, '00', 'USSD', NULL, '2018-10-25 20:55:50', NULL, NULL, 0, NULL, 'jhhbjv7cff', 0, '0000-00-00', 0, '0000-00-00', NULL, NULL, NULL, 'Successful', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, 'ACC00000702', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `userdata`
--

CREATE TABLE `userdata` (
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role_id` varchar(20) NOT NULL,
  `role_name` varchar(40) DEFAULT NULL,
  `firstname` varchar(60) NOT NULL,
  `lastname` varchar(60) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile_phone` varchar(20) NOT NULL,
  `merchant_id` varchar(20) NOT NULL,
  `verification_code` int(255) NOT NULL,
  `verification_date_created` datetime(6) NOT NULL,
  `expiry` datetime DEFAULT NULL,
  `used` tinyint(1) NOT NULL,
  `depmt_id` int(11) NOT NULL,
  `depmt_head` int(11) NOT NULL,
  `profile_completed_at` datetime DEFAULT NULL,
  `verification_status` enum('0','1','','') DEFAULT NULL,
  `registration_completed` enum('0','1','','') NOT NULL,
  `passchg_logon` char(1) NOT NULL,
  `pass_expire` varchar(1) DEFAULT NULL,
  `pass_dateexpire` date DEFAULT NULL,
  `pass_change` char(1) DEFAULT '0',
  `user_disabled` char(1) NOT NULL DEFAULT '0',
  `user_locked` char(1) NOT NULL DEFAULT '0',
  `day_1` char(1) NOT NULL,
  `day_2` char(1) NOT NULL,
  `day_3` char(1) NOT NULL,
  `day_4` char(1) NOT NULL,
  `day_5` char(1) NOT NULL,
  `day_6` char(1) NOT NULL,
  `day_7` char(1) NOT NULL,
  `pin_missed` int(2) NOT NULL DEFAULT 0,
  `last_used` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `authorize_status` char(1) DEFAULT '0',
  `user_type` char(1) DEFAULT NULL,
  `hint_question` varchar(100) DEFAULT NULL,
  `hint_answer` varchar(100) DEFAULT NULL,
  `override_wh` char(1) DEFAULT NULL,
  `extend_wh` varchar(11) DEFAULT NULL,
  `login_status` char(1) DEFAULT NULL,
  `account_no` varchar(11) DEFAULT NULL,
  `account_name` text DEFAULT NULL,
  `super_agent_id` varchar(100) DEFAULT NULL,
  `contact_address` varchar(200) DEFAULT NULL,
  `office_address` varchar(200) DEFAULT NULL,
  `bank_name` varchar(30) DEFAULT NULL,
  `posted_user` varchar(50) DEFAULT NULL,
  `office_state` varchar(30) DEFAULT NULL,
  `office_lga` varchar(30) DEFAULT NULL,
  `reg_status` char(1) DEFAULT '0',
  `user_id` varchar(20) DEFAULT NULL,
  `status` varchar(1) DEFAULT '0',
  `sex` varchar(10) DEFAULT NULL,
  `church_id` varchar(40) DEFAULT NULL,
  `parish_pastor` char(1) NOT NULL DEFAULT '0',
  `modified_date` datetime DEFAULT NULL,
  `photo` varchar(50) DEFAULT NULL,
  `reset_pwd_link` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='InnoDB free: 11264 kB; InnoDB free: 11264 kB; InnoDB free: 1' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `userdata`
--

INSERT INTO `userdata` (`username`, `password`, `role_id`, `role_name`, `firstname`, `lastname`, `email`, `mobile_phone`, `merchant_id`, `verification_code`, `verification_date_created`, `expiry`, `used`, `depmt_id`, `depmt_head`, `profile_completed_at`, `verification_status`, `registration_completed`, `passchg_logon`, `pass_expire`, `pass_dateexpire`, `pass_change`, `user_disabled`, `user_locked`, `day_1`, `day_2`, `day_3`, `day_4`, `day_5`, `day_6`, `day_7`, `pin_missed`, `last_used`, `created`, `modified`, `authorize_status`, `user_type`, `hint_question`, `hint_answer`, `override_wh`, `extend_wh`, `login_status`, `account_no`, `account_name`, `super_agent_id`, `contact_address`, `office_address`, `bank_name`, `posted_user`, `office_state`, `office_lga`, `reg_status`, `user_id`, `status`, `sex`, `church_id`, `parish_pastor`, `modified_date`, `photo`, `reset_pwd_link`) VALUES
('', '0x33792f2db2dba53a', '012', NULL, '', '', '', '', 'PRO-410806', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 1, NULL, '', '0', '0', NULL, NULL, '0', '0', '0', '', '', '', '', '', '', '', 0, NULL, '2025-05-19 15:48:48', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '0', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL),
('abuja_accountant@mail.com', '0x86a2db382977b94e', '002', '', 'Abujas', 'accountant', 'abuja_accountant@mail.com', '0705555542', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '1', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-11-02 06:34:00', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'male', 'TLC-020015', '1', '2022-08-11 04:02:02', NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('abuja_monitoring@mail.com', '0xa2c109e258d028c7', '008', '', 'abuja', 'monitoring unit', 'abuja_monitoring@mail.com', '0800055578', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '0', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-11-02 06:35:18', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'male', 'TLC-020015', '1', '2022-02-02 01:01:28', NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('abuja_pastor@mail.com', '0x650ac6b0e9a96483', '003', '', 'abuja', 'pastor', 'abuja_pastor@mail.com', '07068855214', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '0', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 1, NULL, '2019-11-02 06:23:27', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '0045512298', 'MALU JOSEPH UGO', NULL, NULL, NULL, '044', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'male', 'TLC-020015', '0', NULL, NULL, ''),
('abuja_usher@mail.com', '0xad25c399450175f5', '004', '', 'abuja', 'usher', 'abuja_usher@mail.com', '08073624675', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '0', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-11-02 06:34:39', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 'abuja_pastor@mail.com', NULL, NULL, '0', NULL, '0', 'male', 'TLC-020015', '0', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('acc@mail.com', '0x13bf1080493306b1', '002', '', 'Ikechukwu', 'Chimalu', 'acc@mail.com', '08073624675', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '0', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-10-16 05:36:57', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 'chimalupaul@gmail.com', NULL, NULL, '0', NULL, '1', 'male', 'TLC-011003', '1', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('chaza_accountant@mail.com', '0xa2712594b6a54fc9', '002', '', 'chaza', 'accountant', 'chaza_accountant@mail.com', '07888855556', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '0', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-11-01 07:11:33', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 'chaza_pastor@mail.com', NULL, NULL, '0', NULL, '0', 'male', 'TLC-019015', '0', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('chaza_monitoring_unit@mail.com', '0xf059a56617a96729', '008', '', 'Chaza', 'monitoring unit', 'chaza_monitoring_unit@mail.com', '07055555448', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '0', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-11-01 07:17:58', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 'chaza_pastor@mail.com', NULL, NULL, '0', NULL, '0', 'male', 'TLC-019015', '0', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('chaza_pastor@mail.com', '0x147f73f90b66d0b8', '003', '', 'chaza', 'pastor', 'chaza_pastor@mail.com', '07060464666', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '0', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-11-01 07:03:39', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '0045512298', 'MALU JOSEPH UGO', NULL, NULL, NULL, '044', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'male', 'TLC-019015', '0', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('chaza_usher@mail.com', '0x5720b8e7008bfc1e', '004', '', 'chaza', 'usher', 'chaza_usher@mail.com', '07060760508899', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '0', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-11-01 07:16:33', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 'chaza_pastor@mail.com', NULL, NULL, '0', NULL, '0', 'male', 'TLC-019015', '0', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('chimalupaul@gmail.com', '0x04ea295aeb2b2ef1', '003', '', 'Ikechukwu', 'Chimalu', 'chimalupaul@gmail.com', '08073624675', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '0', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-10-16 05:36:07', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '0045512298', 'MALU JOSEPH UGO', NULL, NULL, NULL, '044', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'male', 'TLC-011003', '1', '2019-10-23 12:51:18', 'chimalupaul@gmail.com.jpg', '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('chimalupaul@gmail.comaa', '0xee18b6ee64267792', '005', '', 'Ikechukwu', 'Chimalu', 'chimalupaul@gmail.comaa', '08073624675', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '1', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2020-05-06 11:02:47', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'male', NULL, '1', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('holla@mail.com', '0xd9baa11df92eddd6', '003', '', 'Ikechukwu', 'Chimalu', 'holla@mail.com', '08073624675', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '0', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-10-29 09:51:47', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '0045512298', 'MALU JOSEPH UGO', NULL, NULL, NULL, '044', 'hq@mail.com', NULL, NULL, '0', NULL, '0', 'male', 'TLC-015003', '0', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('hq@mail.com', '0xfa2754e5206604bd', '005', '', 'hqadmin', 'hqadmin', 'hq@mail.com', '08065555471', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '0', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-10-29 04:33:46', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'male', 'TLC-013003', '0', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('Jesuslovestestimony@gmail.com', '0x7afd0351df5d2ba1', '002', NULL, '', '', 'Jesuslovestestimony@gmail.com', '', 'PRO-773289', 0, '2025-05-29 16:55:11.000000', '0000-00-00 00:00:00', 0, 0, 0, '2025-05-29 17:05:52', '1', '1', '0', NULL, NULL, '0', '0', '0', '', '', '', '', '', '', '', 0, NULL, '2025-05-29 16:54:47', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL),
('okon@mail.com', '0x0b69394d5a8e0eb5', '003', '', 'Ikechukwu', 'Chimalu', 'okon@mail.com', '08073624675', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '0', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-10-18 11:37:47', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'male', '99', '1', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('sam@mail.com', '0x3dd8ba2b49be532d', '001', '', 'Sam', 'James', 'sam@mail.com', '08035153080', 'PRO-773289', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, '2025-05-29 16:44:58', '', '1', '0', NULL, '2024-07-18', '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, '2018-04-06 16:59:19', '2018-03-09 16:32:05', '2022-08-05 19:00:40', NULL, NULL, 'jddjjjd', 'jdjdjjdd', '0', '1', NULL, '09874625477', 'jdjdjd', '', 'skajjs', 'hdhdhhf', 'GTB', 'sam@mail.com', 'FCT', 'AMAC', '1', '0001', '0', 'male', NULL, '', NULL, 'sam@mail.com.jpg', ''),
('sam@mail.comm', '0x3dd8ba2b49be532d', '006', NULL, 'Name', 'Empty', 'sam@mail.comm', '0349393939', 'PRO-773289', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '1', '1', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2022-08-18 09:39:47', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, '', '<br />\r\n<b>Notice</b>:  Undefined variable: user in <b>C:\\laragon\\www\\access_framework\\setup\\pastor.php</b> on line <b>72</b><br />\r\n<br />\r\n<b>Notice</b>:  Trying to access array offset on value of type null in <b>C:\\laragon\\www\\access_framework\\setup\\pastor.php</b> on line <b>72</b><br />\r\n<br />\r\n<b>Notice</b>:  Trying to access array offset on value of type null in <b>C:\\laragon\\www\\access_framework\\setup\\pastor.php</b> on line <b>72</b><br />\r\n', NULL, NULL, NULL, '', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'male', NULL, '1', NULL, NULL, NULL),
('sam_prosper@mail.com', '0x22770ec5b051cb39', '006', NULL, 'Prosper', 'Adakole', 'sam_prosper@mail.com', '90393939393', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '0', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2022-08-05 07:01:32', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, '', '<br />\r\n<b>Warning</b>:  Undefined variable $user in <b>C:\\laragon\\www\\framework\\framework\\setup\\pastor.php</b> on line <b>73</b><br />\r\n<br />\r\n<b>Warning</b>:  Trying to access array offset on value of type null in <b>C:\\laragon\\www\\framework\\framework\\setup\\pastor.php</b> on line <b>73</b><br />\r\n<br />\r\n<b>Warning</b>:  Trying to access array offset on value of type null in <b>C:\\laragon\\www\\framework\\framework\\setup\\pastor.php</b> on line <b>73</b><br />\r\n', NULL, NULL, NULL, '', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'male', NULL, '1', NULL, NULL, NULL),
('sasssm@mail.com', '0x3a46391500cbf610', '005', NULL, 'Mercy', 'John', 'sasssm@mail.com', '0904949494', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '1', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2023-01-23 12:49:46', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'male', NULL, '1', NULL, NULL, NULL),
('state_admin@mail.com', '0x036e826be07ed7c5', '006', '', 'Ikechukwu', 'Chimalu', 'state_admin@mail.com', '08073624675', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '0', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-10-30 09:26:55', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'male', 'TLC-013003', '0', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('test1@mail.com', '0x6e1d02c9bd721da3', '002', '', 'adsfdgfg', 'sdfgg', 'test1@mail.com', '025852222226', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '0', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-12-03 11:11:34', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 'tlc01220pastor@tlc.com', NULL, NULL, '0', NULL, '0', 'male', 'TLC-047012', '1', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('test2@mail.com', '0x82e70b4331819111', '004', '', 'jh', 'gcfhvj', 'test2@mail.com', '0581052', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '0', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-12-03 11:12:22', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 'tlc01220pastor@tlc.com', NULL, NULL, '0', NULL, '0', 'male', 'TLC-047012', '1', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('test3@mail.com', '0x82e70b4331819111', '008', '', 'ghjkl,mn', 'ghjknbvghj', 'test3@mail.com', '0205841205', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '0', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-12-03 11:12:55', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 'tlc01220pastor@tlc.com', NULL, NULL, '0', NULL, '0', 'male', 'TLC-047012', '1', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('tlc00110pastor@tlc.com', '0x204379ec193a4e10', '003', '', 'default_name', 'default_name', 'tlc00110pastor@tlc.com', '07060000000', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '1', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-11-12 07:48:42', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '00000000000', 'unknown', NULL, NULL, NULL, '00', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'm', 'TLC-036001', '1', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('tlc00111pastor@tlc.com', '0x8e70a90ba86bcb6d', '003', '', 'default_name', 'default_name', 'tlc00111pastor@tlc.com', '07060000000', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '1', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-11-12 07:49:09', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '00000000000', 'unknown', NULL, NULL, NULL, '00', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'm', 'TLC-037001', '1', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('tlc00112pastor@tlc.com', '0x2a3ada1f153940ef', '003', '', 'default_name', 'default_name', 'tlc00112pastor@tlc.com', '07060000000', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '1', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-11-12 07:49:20', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '00000000000', 'unknown', NULL, NULL, NULL, '00', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'm', 'TLC-038001', '1', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('tlc00113pastor@tlc.com', '0x24dd930d4556d90d', '003', '', 'default_name', 'default_name', 'tlc00113pastor@tlc.com', '07060000000', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '1', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-11-12 08:24:26', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '00000000000', 'unknown', NULL, NULL, NULL, '00', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'm', 'TLC-040001', '1', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('tlc00116pastor@tlc.com', '0xb77aa57fe03465b2', '003', '', 'default_name', 'default_name', 'tlc00116pastor@tlc.com', '07060000000', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '1', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-11-15 02:30:24', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '00000000000', 'unknown', NULL, NULL, NULL, '00', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'm', 'TLC-043001', '1', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('tlc00117pastor@tlc.com', '0x41357be1ca2a5b82', '003', '', 'default_name', 'default_name', 'tlc00117pastor@tlc.com', '07060000000', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '1', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-11-15 02:35:33', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '00000000000', 'unknown', NULL, NULL, NULL, '00', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'm', 'TLC-044001', '1', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('tlc0013pastor@tlc.com', '0x253502bd56f0ea3163486462e0d6ab7b', '003', '', 'default_name', 'default_name', 'tlc0013pastor@tlc.com', '07060000000', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '1', NULL, NULL, '0', '1', '1', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-11-12 07:07:24', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '00000000000', 'unknown', NULL, NULL, NULL, '00', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'm', 'TLC-029001', '1', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('tlc0015pastor@tlc.com', '0xd646e5cd6187e92f66e01a5d9cdf2b64', '003', '', 'default_name', 'default_name', 'tlc0015pastor@tlc.com', '07060000000', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '1', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-11-12 07:14:32', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '00000000000', 'unknown', NULL, NULL, NULL, '', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'male', 'TLC-031001', '1', '2019-11-13 06:42:05', NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('tlc0016pastor@tlc.com', '0xb5e02f133489bfb6ed202ca628d9c98a', '003', '', 'default_name', 'default_name', 'tlc0016pastor@tlc.com', '07060000000', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '1', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-11-12 07:44:05', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '00000000000', 'unknown', NULL, NULL, NULL, '00', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'm', 'TLC-032001', '1', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('tlc0017pastor@tlc.com', '0x8ef9621cd75d9641bd852d8e9406509e', '003', '', 'default_name', 'default_name', 'tlc0017pastor@tlc.com', '07060000000', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '1', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-11-12 07:47:01', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '00000000000', 'unknown', NULL, NULL, NULL, '00', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'm', 'TLC-033001', '1', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('tlc0019pastor@tlc.com', '0x387db30f4ab25f9c', '003', '', 'default_name', 'default_name', 'tlc0019pastor@tlc.com', '07060000000', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '1', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-11-12 07:48:21', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '00000000000', 'unknown', NULL, NULL, NULL, '00', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'm', 'TLC-035001', '1', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('tlc00214pastor@tlc.com', '0x9703deb303769b8f', '003', '', 'default_name', 'default_name', 'tlc00214pastor@tlc.com', '07060000000', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '1', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-11-13 09:26:17', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '', 'unknown', NULL, NULL, NULL, '', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'male', 'TLC-042002', '1', '2019-11-13 07:12:09', NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('tlc00218pastor@tlc.com', '0xa2868718743504a2', '003', '', 'default_name', 'default_name', 'tlc00218pastor@tlc.com', '07060000000', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '0', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-11-15 02:37:24', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '0045512298', 'MALU JOSEPH UGO', NULL, NULL, NULL, '044', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'm', 'TLC-045002', '1', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('tlc00219pastor@tlc.com', '0xa2868718743504a2', '003', '', 'default_name', 'default_name', 'tlc00219pastor@tlc.com', '07060000000', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '0', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-11-15 05:38:29', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '0045512298', 'MALU JOSEPH UGO', NULL, NULL, NULL, '044', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'm', 'TLC-046002', '1', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('tlc0021pastor@tlc.com', '0x2814d4a3425d8e82686a8036d2fec454', '003', '', 'default_name', 'default_name', 'tlc0021pastor@tlc.com', '07060000000', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '1', NULL, NULL, '0', '1', '1', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-11-12 07:05:44', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '00000000000', 'unknown', NULL, NULL, NULL, '00', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'm', 'TLC-027002', '1', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('tlc0022pastor@tlc.com', '0xb15fca6d59033b0da652162c3d383c7f', '003', '', 'default_name', 'default_name', 'tlc0022pastor@tlc.com', '07060000000', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '1', NULL, NULL, '0', '1', '1', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-11-12 07:06:03', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '00000000000', 'unknown', NULL, NULL, NULL, '00', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'm', 'TLC-028002', '1', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('tlc0034pastor@tlc.com', '0x2eeb5a211c6b4afc24e0dafacd161199', '003', '', 'ugo c ugo', 'default_name', 'tlc0034pastor@tlc.com', '0706999999999', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '1', NULL, NULL, '0', '0', '1', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-11-12 07:09:30', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '0045512298', 'MALU JOSEPH UGO', NULL, NULL, NULL, '044', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'male', 'TLC-030003', '1', '2020-03-18 03:06:32', NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('tlc01220pastor@tlc.com', '0x143604d46bd69e23', '003', '', 'Joe', 'malu', 'tlc01220pastor@tlc.com', '07066665842', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '0', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-12-03 06:33:24', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '0045512298', 'Could not resolve host: live.moneywaveapi.coUnable to verify account, try again.', NULL, NULL, NULL, '044', 'sam@mail.com', NULL, NULL, '0', NULL, '0', 'male', 'TLC-047012', '1', NULL, '', '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9'),
('wleader@mail.com', '0xc20f668ff50fd07d', '004', '', 'women', 'leader', 'wleader@mail.com', '07060760578', '', 0, '0000-00-00 00:00:00.000000', NULL, 0, 0, 0, NULL, '', '0', '0', NULL, NULL, '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', 0, NULL, '2019-10-22 02:46:39', '2022-08-05 19:00:40', '0', NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 'chimalupaul@gmail.com', NULL, NULL, '0', NULL, '0', 'female', 'TLC-011003', '1', NULL, NULL, '0xf2adcf9db6eb6ce291c4f9c7e1c29aeda09aae3a0b23bb39a51e1ccb63b2c955abd285015048a913ec2c7b4a161608e591426ec6c9de62b9');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`bank_code`) USING BTREE;

--
-- Indexes for table `church_table`
--
ALTER TABLE `church_table`
  ADD PRIMARY KEY (`church_id`) USING BTREE;

--
-- Indexes for table `church_type`
--
ALTER TABLE `church_type`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`depmt_id`),
  ADD KEY `merchant_id` (`merchant_id`);

--
-- Indexes for table `font_awsome`
--
ALTER TABLE `font_awsome`
  ADD PRIMARY KEY (`font_id`) USING BTREE;

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `merchant_id` (`merchant_id`);

--
-- Indexes for table `item_allocation_history`
--
ALTER TABLE `item_allocation_history`
  ADD PRIMARY KEY (`allocation_id`);

--
-- Indexes for table `item_category`
--
ALTER TABLE `item_category`
  ADD PRIMARY KEY (`item_cat_id`),
  ADD UNIQUE KEY `item_code` (`item_code`);

--
-- Indexes for table `item_maintenance_log`
--
ALTER TABLE `item_maintenance_log`
  ADD PRIMARY KEY (`maintenance_id`);

--
-- Indexes for table `lga`
--
ALTER TABLE `lga`
  ADD PRIMARY KEY (`Lgaid`) USING BTREE;

--
-- Indexes for table `log_details`
--
ALTER TABLE `log_details`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `log_table`
--
ALTER TABLE `log_table`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`) USING BTREE;

--
-- Indexes for table `menugroup`
--
ALTER TABLE `menugroup`
  ADD PRIMARY KEY (`role_id`,`menu_id`) USING BTREE;

--
-- Indexes for table `merchant_reg`
--
ALTER TABLE `merchant_reg`
  ADD PRIMARY KEY (`merchant_id`) USING BTREE,
  ADD UNIQUE KEY `merchant_id` (`merchant_id`),
  ADD KEY `idx_merchant_business_details_flag` (`merchant_business_details_flag`) USING BTREE,
  ADD KEY `idx_merchant_business_address_flag` (`merchant_business_address_flag`) USING BTREE,
  ADD KEY `idx_is_cac_verified` (`is_cac_verified`) USING BTREE,
  ADD KEY `idx_is_bvn_profiled` (`is_bvn_profiled`) USING BTREE;

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `permissions_map`
--
ALTER TABLE `permissions_map`
  ADD PRIMARY KEY (`role_id`,`permission_id`) USING BTREE,
  ADD KEY `permission_id_fk` (`permission_id`) USING BTREE;

--
-- Indexes for table `professional_qualification`
--
ALTER TABLE `professional_qualification`
  ADD PRIMARY KEY (`qualification_id`),
  ADD KEY `merchant_id` (`merchant_id`);

--
-- Indexes for table `qualification`
--
ALTER TABLE `qualification`
  ADD KEY `merchant_id` (`merchant_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`) USING BTREE,
  ADD KEY `merchant_id` (`merchant_id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD KEY `merchant_id` (`merchant_id`),
  ADD KEY `staff_number` (`staff_code`),
  ADD KEY `staff_first_name` (`staff_first_name`,`staff_last_name`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`store_id`);

--
-- Indexes for table `transaction_table`
--
ALTER TABLE `transaction_table`
  ADD PRIMARY KEY (`transaction_id`) USING BTREE,
  ADD KEY `typeT` (`trans_type`) USING BTREE,
  ADD KEY `RCI` (`response_code`) USING BTREE,
  ADD KEY `cDai` (`created`) USING BTREE,
  ADD KEY `PuI` (`posted_user`) USING BTREE,
  ADD KEY `mCI` (`merchant_category`) USING BTREE,
  ADD KEY `SSi` (`settlement_status`) USING BTREE;

--
-- Indexes for table `userdata`
--
ALTER TABLE `userdata`
  ADD PRIMARY KEY (`username`) USING BTREE,
  ADD UNIQUE KEY `username` (`username`,`merchant_id`),
  ADD KEY `US2` (`password`) USING BTREE,
  ADD KEY `US3` (`pass_expire`) USING BTREE,
  ADD KEY `US4` (`role_id`) USING BTREE,
  ADD KEY `US5` (`user_locked`) USING BTREE,
  ADD KEY `merchant_id` (`merchant_id`),
  ADD KEY `depmt_id` (`depmt_id`),
  ADD KEY `depmt_head` (`depmt_head`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `depmt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `item_allocation_history`
--
ALTER TABLE `item_allocation_history`
  MODIFY `allocation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `item_category`
--
ALTER TABLE `item_category`
  MODIFY `item_cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `item_maintenance_log`
--
ALTER TABLE `item_maintenance_log`
  MODIFY `maintenance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lga`
--
ALTER TABLE `lga`
  MODIFY `Lgaid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=827;

--
-- AUTO_INCREMENT for table `log_details`
--
ALTER TABLE `log_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `log_table`
--
ALTER TABLE `log_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `professional_qualification`
--
ALTER TABLE `professional_qualification`
  MODIFY `qualification_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `store_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
