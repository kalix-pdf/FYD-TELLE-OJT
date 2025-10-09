-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2024 at 05:09 PM
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
-- Database: `eac_findyourdoctor_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_accounts`
--

CREATE TABLE `admin_accounts` (
  `admin_id` int(11) NOT NULL,
  `admin_username` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_account_status` varchar(255) NOT NULL COMMENT '"NEW" "OLD"',
  `admin_status` varchar(255) NOT NULL DEFAULT 'ACTIVE' COMMENT '"ACTIVE, INACTIVE"',
  `account_access` varchar(255) NOT NULL,
  `account_created_timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_accounts`
--

INSERT INTO `admin_accounts` (`admin_id`, `admin_username`, `admin_password`, `admin_name`, `admin_email`, `admin_account_status`, `admin_status`, `account_access`, `account_created_timestamp`) VALUES
(1, 'marc', '$2y$10$ZkgThNp4XqRGDaXyuXVtr.5RGI0DsFW3Bop9MW1m.ZE7WVT6AnHvO', '', '', '', 'Active', 'Super Admin', '0000-00-00 00:00:00'),
(2, 'lee', '$2y$10$ipHz8QTqeErxQ5yHq9mvc.kNT4Byd7l4Zy5g.M6vIz.CdgR.7luJ2', '', '', '', 'Active', 'Admin', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `admin_activity_logs`
--

CREATE TABLE `admin_activity_logs` (
  `admin_activity_logs_id` int(11) NOT NULL,
  `activity_logs_admin_id` varchar(255) NOT NULL,
  `event_type` varchar(255) NOT NULL,
  `edit_details` varchar(1000) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_activity_logs`
--

INSERT INTO `admin_activity_logs` (`admin_activity_logs_id`, `activity_logs_admin_id`, `event_type`, `edit_details`, `time_stamp`) VALUES
(1, '20241213-781133', '', 'd', '2024-12-13 09:37:59'),
(2, '1', 'New Account', 'Create Account of Dr. marce dee reyas', '2024-12-13 10:06:34'),
(3, '1', 'New Account', 'Create Account of Dr. carl john mendoza', '2024-12-13 10:16:25'),
(4, '1', 'New Account', 'Create Account of Dr. fsadf sdfas sadf', '2024-12-13 10:25:53'),
(5, '1', 'New Account', 'Create Account of Dr. asdf sadf sdfa', '2024-12-13 10:31:19'),
(6, '1', 'New Account', 'Create Account of Dr. asdf sdf asdf', '2024-12-13 10:38:02'),
(7, '1', 'New Account', 'Create Account of Dr. asdf sdf df', '2024-12-13 10:39:54'),
(8, '1', 'New Account', 'Create Account of Dr. ASDF ASF SADF', '2024-12-13 10:56:00'),
(9, '1', 'Remove Account', 'Remove Account of Dr.   ', '2024-12-14 09:30:23'),
(10, '1', 'Remove Account', 'Remove Account of Dr.   ', '2024-12-14 09:31:43'),
(11, '1', 'Remove Account', 'Remove Account of Dr.   ', '2024-12-14 09:31:51'),
(12, '1', 'Remove Account', 'Remove Account of Dr.   ', '2024-12-14 09:32:37'),
(13, '1', 'Remove Account', 'Remove Account of Dr. asdf asdfasdf asdfasdfasdf', '2024-12-14 09:42:04'),
(14, '1', 'Remove Account', 'Remove Account of Dr. VCXVDS sdfdf dfsdfsd', '2024-12-14 09:48:07'),
(15, '1', 'Remove Account', 'Remove Account of Dr. fsdfdf dfsdfsd sdfsdfsdf', '2024-12-14 09:50:59'),
(16, '1', 'Remove Account', 'Remove Account of Dr. asdfewrwfsgvbc sadfsdfs asdf', '2024-12-14 09:52:12'),
(17, '1', 'Remove Account', 'Remove Account of Dr. asdff sdfdf sdff', '2024-12-14 09:52:41'),
(18, '1', 'Remove Account', 'Remove Account of Dr. zxc vcxv cxv', '2024-12-14 09:54:22'),
(19, '1', 'Restore Account', 'Remove Account of Dr. ASDF ASF SADF', '2024-12-14 09:56:55'),
(20, '1', 'Remove Account', 'Remove Account of Dr. ASDF ASF SADF', '2024-12-14 10:52:37'),
(21, '1', 'Remove Account', 'Remove Account of Dr. sadf asdf asdf', '2024-12-14 10:54:20'),
(22, '1', 'Update Account', 'Update Account of Dr. asdfsdffdsgb gsdgsdg sdff', '2024-12-14 11:35:04'),
(23, '1', 'Restore Account', 'Restore Account of Dr. ASDF ASF SADF', '2024-12-14 11:36:11'),
(24, '1', 'Update Account', 'Update Account of Dr. ASDF ASF SADF', '2024-12-14 11:36:41'),
(25, '1', 'Update Account', 'Update Account of Dr. ASDF ASF ', '2024-12-14 11:39:07');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `doctor_id` int(11) NOT NULL,
  `doctor_account_id` varchar(255) NOT NULL,
  `doctor_name` varchar(255) NOT NULL,
  `doctor_firstname` varchar(255) NOT NULL,
  `doctor_middlename` varchar(255) NOT NULL,
  `doctor_lastname` varchar(255) NOT NULL,
  `doctor_sex` varchar(255) NOT NULL,
  `doctor_category` varchar(255) NOT NULL,
  `doctor_status` varchar(255) NOT NULL DEFAULT 'INACTIVE' COMMENT '"ACTIVE, INACTIVE"',
  `doctor_archive_status` varchar(255) NOT NULL DEFAULT 'VISIBLE' COMMENT '"UNHIDE, HIDDEN"',
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`doctor_id`, `doctor_account_id`, `doctor_name`, `doctor_firstname`, `doctor_middlename`, `doctor_lastname`, `doctor_sex`, `doctor_category`, `doctor_status`, `doctor_archive_status`, `profile_image`) VALUES
(1, '20241209-163461', 'Angeline D. Santos', 'Angeline', 'Domingo', 'Santos', 'Female', 'Regular Consultant', 'ACTIVE', 'VISIBLE', 'Doctor2.png'),
(2, '20241209-163462', 'Eduardo C. Garcia', 'Eduardo', 'Carding', 'Garcia', 'Male', 'Regular Consultant', 'ACTIVE', 'VISIBLE', 'Doctor1.png'),
(3, '20241209-163463', 'Rosario U. Santiago', 'Rosario', 'Uganda', 'Santiago', 'Male', 'Regular Consultant', 'ACTIVE', 'VISIBLE', 'Doctor1.png'),
(4, '20241209-163465', 'May Ann J. Tan', 'May Ann', 'Jeminez', 'Tan', 'Female', 'Regular Consultant', 'ACTIVE', 'VISIBLE', 'Doctor2.png'),
(5, '20241209-163466', 'Pedro S. Villanueva', 'Pedro', 'Santaigo', 'Villanueva', 'Male', 'Regular Consultant', 'ACTIVE', 'VISIBLE', 'Doctor1.png'),
(6, '20241209-163467', 'Nelia L. Reyes', 'Neila', 'Lara', 'Reyes', 'Female', 'Regular Consultant', 'ACTIVE', 'VISIBLE', 'Doctor2.png'),
(7, '20241209-163468', 'Felicia D. Espinosa', 'Felicia', 'Domingo', 'Espinosa', 'Female', 'Regular Consultant', 'ACTIVE', 'VISIBLE', 'Doctor2.png'),
(8, '20241209-163469', 'Danica R. Dela Cruz', 'Danica', 'Ricardo', 'Dela Cruz', 'Female', 'Regular Consultant', 'ACTIVE', 'VISIBLE', 'Doctor2.png'),
(9, '20241209-163410', 'Oliver H. Dadole', 'Oliver', 'Howrad', 'Dadole', 'Male', 'Visiting Consultant', 'ACTIVE', 'VISIBLE', 'Doctor1.png'),
(10, '20241209-163411', 'Nathan R. Lee', 'Nathan', 'Roberto', 'Lee', 'Male', 'Visiting Consultant', 'ACTIVE', 'VISIBLE', 'Doctor1.png'),
(83, '20241212-336265', '', 'France', 'Joshua', 'alfelor', 'Male', 'Regular Consultant', 'INACTIVE', 'HIDDEN', 'Doctor1.png'),
(84, '20241212-112356', '', 'Joshua', 'f', 'alfelor', 'Male', 'Visiting Consultant', 'INACTIVE', 'VISIBLE', 'Doctor1.png'),
(85, '20241212-531091', '', 'marc', 'lee', 'reyes', 'Male', 'Regular Consultant', 'INACTIVE', 'VISIBLE', 'Doctor1.png'),
(86, '20241213-803003', '', 'd1', 'd1', 'd1', 'Male', 'Regular Consultant', 'INACTIVE', 'VISIBLE', 'Doctor1.png'),
(87, '20241213-443100', '', 'sadf', 'asdf', 'asdf', 'Male', 'Regular Consultant', 'INACTIVE', 'HIDDEN', 'Doctor1.png'),
(88, '20241213-281442', '', 'asdfewrwfsgvbc', 'sadfsdfs', 'asdf', 'Male', 'Regular Consultant', 'INACTIVE', 'HIDDEN', 'Doctor1.png'),
(89, '20241213-202795', '', 'asdfsdffdsgb', 'gsdgsdg', 'wala', 'Male', 'Regular Consultant', 'INACTIVE', 'VISIBLE', 'Doctor1.png'),
(90, '20241213-409201', '', 'zxc', 'vcxv', 'cxv', 'Female', 'Regular Consultant', 'INACTIVE', 'HIDDEN', 'Doctor2.png'),
(91, '20241213-005198', '', 'VCXVDS', 'sdfdf', 'dfsdfsd', 'Male', 'Regular Consultant', 'INACTIVE', 'HIDDEN', 'Doctor1.png'),
(92, '20241213-685947', '', 'asdff', 'sdfdf', 'sdff', 'Male', 'Regular Consultant', 'INACTIVE', 'HIDDEN', 'Doctor1.png'),
(93, '20241213-745088', '', 'fsdfdf', 'dfsdfsd', 'sdfsdfsdf', 'Male', 'Regular Consultant', 'INACTIVE', 'HIDDEN', 'Doctor1.png'),
(94, '20241213-697001', '', 'asdf', 'asdfasdf', 'asdfasdfasdf', 'Male', 'Regular Consultant', 'INACTIVE', 'HIDDEN', 'Doctor1.png'),
(95, '20241213-781133', '', 'sdfx', 'cvx', 'xcv', 'Female', 'Waiting Consultant', 'INACTIVE', 'HIDDEN', 'Doctor2.png'),
(96, '20241213-013246', '', 'marce', 'dee', 'reyas', 'Male', 'Regular Consultant', 'INACTIVE', 'HIDDEN', 'Doctor1.png'),
(97, '20241213-420079', '', 'carl', 'john', 'mendoza', 'Male', 'Regular Consultant', 'INACTIVE', 'HIDDEN', 'Doctor1.png'),
(98, '20241213-396860', '', 'fsadf', 'sdfas', 'sadf', 'Male', 'Regular Consultant', 'INACTIVE', 'HIDDEN', 'Doctor1.png'),
(99, '20241213-722798', '', 'asdf', 'sadf', 'sdfa', 'Male', 'Regular Consultant', 'INACTIVE', 'HIDDEN', 'Doctor1.png'),
(100, '20241213-912737', '', 'asdf', 'sdf', 'asdf', 'Female', 'Waiting Consultant', 'INACTIVE', 'HIDDEN', 'Doctor2.png'),
(101, '20241213-480590', '', 'asdf', 'sdf', 'df', 'Female', 'Waiting Consultant', 'INACTIVE', 'HIDDEN', 'Doctor2.png'),
(102, '20241213-745417', '', 'france Joshua', 'bayo', 'alfelor', 'Male', 'Visiting Consultant', 'INACTIVE', 'VISIBLE', 'Doctor1.png');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_archive`
--

CREATE TABLE `doctor_archive` (
  `doctor_archive_id` int(11) NOT NULL,
  `archive_doctor_id` int(11) NOT NULL,
  `archive_admin_id` int(11) NOT NULL,
  `archive_admin_name` varchar(255) NOT NULL,
  `archive_time` varchar(255) NOT NULL,
  `archive_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_category`
--

CREATE TABLE `doctor_category` (
  `category_id` int(11) NOT NULL,
  `category_doctor_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_hmo`
--

CREATE TABLE `doctor_hmo` (
  `doctor_hmo_id` int(11) NOT NULL,
  `hmo_doctor_id` varchar(255) NOT NULL,
  `hmo_id_2` int(11) NOT NULL,
  `doctor_hmo_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_hmo`
--

INSERT INTO `doctor_hmo` (`doctor_hmo_id`, `hmo_doctor_id`, `hmo_id_2`, `doctor_hmo_name`) VALUES
(1, '20241209-163461', 13, 'Allianz PNB Life Insurance Inc'),
(2, '20241209-163461', 15, 'Carewell Health Systems, Inc.'),
(3, '20241209-163461', 18, 'Avega Managed Care, Inc.'),
(4, '20241209-163461', 17, 'Etiqa Life And General Assurance Philippines, Inc.'),
(5, '20241209-163461', 4, 'KAISER International Healthgroup, Inc.'),
(6, '20241209-163462', 13, 'Allianz PNB Life Insurance Inc'),
(7, '20241209-163462', 15, 'Carewell Health Systems, Inc.'),
(8, '20241209-163462', 2, 'Intellicare'),
(9, '20241209-163462', 11, 'Pacific Cross Health Care, Inc.'),
(10, '20241209-163463', 5, 'IMS Wellth Care, Inc.'),
(11, '20241209-163463', 21, 'EastWest Health Care, Inc.'),
(12, '20241209-163463', 22, 'Generali Life Assurance Philippines Inc.'),
(13, '20241209-163464', 2, 'Intellicare'),
(14, '20241209-163464', 15, 'Carewell Health Systems, Inc.'),
(15, '20241209-163464', 18, 'Avega Managed Care, Inc.'),
(16, '20241209-163465', 10, 'MedoCare Health Systems, Inc.'),
(17, '20241209-163465', 2, 'Intellicare'),
(18, '20241209-163465', 11, 'Pacific Cross Health Care, Inc.'),
(19, '20241209-163466', 7, 'Medasia Philippines Inc.'),
(20, '20241209-163466', 3, 'Insular Life Assurance Co., Ltd.'),
(21, '20241209-163466', 16, 'AsianCare Health Systems Inc.'),
(22, '20241209-163466', 10, 'MedoCare Health Systems, Inc.'),
(23, '20241209-163466', 19, 'Beneficial Life Insurance Company, Inc.'),
(24, '20241209-163467', 13, 'Allianz PNB Life Insurance Inc'),
(25, '20241209-163468', 19, 'Beneficial Life Insurance Company, Inc.'),
(26, '20241209-163468', 5, 'IMS Wellth Care, Inc.'),
(27, '20241209-163468', 6, 'Maxicare Healthcare Corporation'),
(28, '20241209-163468', 12, 'Value Care Health Systems Inc.'),
(29, '20241209-163469', 23, 'Getwell Health Systems, Inc.'),
(30, '20241209-163469', 14, 'Advanced Medical Access Philippines, Inc.'),
(31, '20241209-163469', 25, 'Health Plan Philippines, Inc.'),
(32, '20241209-163469', 2, 'Intellicare'),
(33, '20241209-163469', 11, 'Pacific Cross Health Care, Inc.'),
(34, '20241209-163469', 13, 'Allianz PNB Life Insurance Inc'),
(35, '20241209-163410', 4, 'KAISER International Healthgroup, Inc.'),
(36, '20241209-163410', 5, 'IMS Wellth Care, Inc.'),
(37, '20241209-163410', 17, 'Etiqa Life And General Assurance Philippines, Inc.'),
(38, '20241209-163410', 14, 'Advanced Medical Access Philippines, Inc.'),
(39, '20241209-163410', 14, 'Advanced Medical Access Philippines, Inc.'),
(45, '20241212-336265', 1, 'Healthway Medi-Access'),
(46, '20241212-336265', 2, 'Intellicare'),
(47, '20241212-336265', 3, 'Insular Life Assurance Co., Ltd.'),
(48, '20241212-336265', 5, 'IMS Wellth Care, Inc.'),
(49, '20241212-336265', 13, 'Allianz PNB Life Insurance Inc'),
(50, '20241212-336265', 14, 'Advanced Medical Access Philippines, Inc.'),
(51, '20241212-336265', 17, 'Etiqa Life And General Assurance Philippines, Inc.'),
(52, '20241212-336265', 18, 'Avega Managed Care, Inc.'),
(53, '20241212-336265', 24, 'Health Maintenance, Inc.'),
(54, '20241212-112356', 7, 'Medasia Philippines Inc.'),
(55, '20241212-112356', 15, 'Carewell Health Systems, Inc.'),
(56, '20241212-531091', 14, 'Advanced Medical Access Philippines, Inc.'),
(57, '20241213-803003', 1, 'Healthway Medi-Access'),
(58, '20241213-281442', 17, 'Etiqa Life And General Assurance Philippines, Inc.'),
(59, '20241213-202795', 3, 'Insular Life Assurance Co., Ltd.'),
(60, '20241213-409201', 3, 'Insular Life Assurance Co., Ltd.'),
(61, '20241213-005198', 7, 'Medasia Philippines Inc.'),
(62, '20241213-685947', 3, 'Insular Life Assurance Co., Ltd.'),
(63, '20241213-745088', 22, 'Generali Life Assurance Philippines Inc.'),
(64, '20241213-697001', 8, 'Medicard Philippines Inc.'),
(65, '20241213-697001', 10, 'MedoCare Health Systems, Inc.'),
(66, '20241213-781133', 7, 'Medasia Philippines Inc.'),
(67, '20241213-013246', 13, 'Allianz PNB Life Insurance Inc'),
(68, '20241213-420079', 2, 'Intellicare'),
(69, '20241213-420079', 3, 'Insular Life Assurance Co., Ltd.'),
(70, '20241213-420079', 4, 'KAISER International Healthgroup, Inc.'),
(71, '20241213-420079', 18, 'Avega Managed Care, Inc.'),
(72, '20241213-420079', 22, 'Generali Life Assurance Philippines Inc.'),
(73, '20241213-396860', 7, 'Medasia Philippines Inc.'),
(74, '20241213-722798', 13, 'Allianz PNB Life Insurance Inc'),
(75, '20241213-912737', 1, 'Healthway Medi-Access'),
(76, '20241213-480590', 8, 'Medicard Philippines Inc.'),
(77, '20241213-745417', 2, 'Intellicare'),
(78, '20241213-745417', 3, 'Insular Life Assurance Co., Ltd.');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_notes`
--

CREATE TABLE `doctor_notes` (
  `doctor_notes_id` int(11) NOT NULL,
  `notes_doctor_id` varchar(255) NOT NULL,
  `doctor_notes_details` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_notes`
--

INSERT INTO `doctor_notes` (`doctor_notes_id`, `notes_doctor_id`, `doctor_notes_details`) VALUES
(1, '20241209-163461', 'Walk-ins are accepted.'),
(2, '20241209-163462', '20 patients per day.'),
(3, '20241209-163463', '15 patients per day.'),
(4, '20241209-163464', '8 - 10 patients per day.'),
(5, '20241209-163465', 'By appointment.'),
(6, '20241209-163466', '10 patients per day.'),
(7, '20241209-163467', '* First come first serve/walk-in.'),
(8, '20241209-163468', '6 patients per day.'),
(9, '20241209-163469', '2 to 5 patients per day'),
(10, '20241209-163410', 'Strictly BY APPOINTMENT. You can email for more information at biancalatorres@eacmed.org.ph'),
(11, '20241213-803003', 'd1'),
(12, '20241213-443100', ''),
(13, '20241213-281442', ''),
(14, '20241213-202795', ''),
(15, '20241213-409201', ''),
(16, '20241213-005198', ''),
(17, '20241213-685947', ''),
(18, '20241213-745088', 'sdafasdf'),
(19, '20241213-697001', 'asdf'),
(20, '20241213-781133', 'd'),
(21, '20241213-013246', 'dsdfa'),
(22, '20241213-420079', 'note lang'),
(23, '20241213-396860', 'd'),
(24, '20241213-722798', 'd'),
(25, '20241213-912737', 'd'),
(26, '20241213-480590', 'd'),
(27, '20241213-745417', 'D');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_room`
--

CREATE TABLE `doctor_room` (
  `doctor_room_id` int(11) NOT NULL,
  `room_doctor_id` varchar(255) NOT NULL,
  `doctor_room_floor` varchar(255) NOT NULL,
  `doctor_room_number` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_room`
--

INSERT INTO `doctor_room` (`doctor_room_id`, `room_doctor_id`, `doctor_room_floor`, `doctor_room_number`) VALUES
(24, '20241209-163461', '', '2nd Floor - Room 2208'),
(25, '20241209-163461', '', '2nd Floor - Room 2307'),
(26, '20241209-163462', '', '3rd Floor - Room 3306'),
(27, '20241209-163463', '', '2nd Floor - Room 2408'),
(28, '20241209-163464', '', '2nd Floor - Room 2221'),
(29, '20241209-163464', '', '2nd Floor - Room 2231'),
(30, '20241209-163465', '', '2nd Floor - Room 2251'),
(31, '20241209-163466', '', '3rd Floor - Room 3405'),
(32, '20241209-163467', '', '3rd Floor - Room 3406'),
(33, '20241209-163468', '', '4th Floor - Room 4102'),
(34, '20241209-163468', '', '2nd Floor - Room 2405'),
(35, '20241209-163410', '', '2nd Floor - Room 2342'),
(60, '20241212-336265', '', '2nd Floor - Room 2221'),
(61, '20241212-336265', '', '2nd Floor - Room 2251'),
(62, '20241212-112356', '', '2nd Floor - Room 2221'),
(63, '20241212-531091', '', '3rd Floor - Room 3306'),
(64, '20241213-803003', '', '2nd Floor - Room 2408'),
(65, '20241213-281442', '', '2nd Floor - Room 2408'),
(66, '20241213-202795', '', '3rd Floor - Room 3306'),
(67, '20241213-409201', '', '2nd Floor - Room 2221'),
(68, '20241213-005198', '', '2nd Floor - Room 2251'),
(69, '20241213-685947', '', '2nd Floor - Room 2408'),
(70, '20241213-745088', '', '2nd Floor - Room 2408'),
(71, '20241213-697001', '', '3rd Floor - Room 3306'),
(72, '20241213-697001', '', '2nd Floor - Room 2221'),
(73, '20241213-781133', '', '2nd Floor - Room 2221'),
(74, '20241213-013246', '', '2nd Floor - Room 2221'),
(75, '20241213-420079', '', '2nd Floor - Room 2408'),
(76, '20241213-420079', '', '2nd Floor - Room 2251'),
(77, '20241213-396860', '', '3rd Floor - Room 3306'),
(78, '20241213-722798', '', '2nd Floor - Room 2221'),
(79, '20241213-912737', '', '2nd Floor - Room 2408'),
(80, '20241213-480590', '', '2nd Floor - Room 2221'),
(81, '20241213-745417', '', '2nd Floor - Room 2408');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_schedule`
--

CREATE TABLE `doctor_schedule` (
  `doctor_schedule_id` int(11) NOT NULL,
  `schedule_doctor_id` varchar(255) NOT NULL,
  `doctor_schedule_day` varchar(255) NOT NULL,
  `doctor_schedule_time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_schedule`
--

INSERT INTO `doctor_schedule` (`doctor_schedule_id`, `schedule_doctor_id`, `doctor_schedule_day`, `doctor_schedule_time`) VALUES
(1, '20241209-163461', 'Monday', '8:00 AM - 12:00 PM'),
(2, '20241209-163461', 'Tuesday', '8:00 AM - 12:00 PM'),
(3, '20241209-163461', 'Wednesday', '1:00 PM - 4:00 PM'),
(4, '20241209-163462', 'Monday', '8:00 AM - 12:00 PM'),
(5, '20241209-163462', 'Wednesday', '8:00 AM - 12:00 PM'),
(6, '20241209-163463', 'Thursday', '1:00 PM - 3:00 PM'),
(7, '320241209-163463', 'Friday', '8:00 AM - 12:00 PM'),
(8, '20241209-163463', 'Saturday', '1:00 AM - 5:00 PM'),
(9, '20241209-163464', 'Monday', '1:00 PM - 5:00 PM'),
(10, '20241209-163464', 'Wednesday', '1:00 PM - 5:00 PM'),
(11, '20241209-163465', 'Tuesday', '11:00 AM - 1:00 PM'),
(12, '20241209-163465', 'Thursday', '9:00 AM - 11:00 AM'),
(13, '20241209-163466', 'Monday', '9:30 AM - 3:00 PM'),
(14, '20241209-163466', 'Tuesday', '9:30 AM - 3:00 PM'),
(15, '20241209-163466', 'Thursday', '1:00 PM - 3:00 PM'),
(16, '20241209-163466', 'Friday', '1:00 PM - 3:00 PM'),
(17, '20241209-163467', 'Tuesday', '9:00 AM - 12:00 PM'),
(18, '20241209-163467', 'Wednesday', '10:00 AM - 1:00 PM'),
(19, '20241209-163467', 'Saturday', '9:00 AM - 5:00 PM'),
(20, '20241209-163468', 'Monday', '9:00 AM - 11:00 PM'),
(21, '20241209-163468', 'Friday', '9:00 AM - 11:00 PM'),
(22, '20241209-163469', 'Wednesday', '10:00 AM - 12:00 PM'),
(23, '20241209-163469', 'Thursday', '12:00 PM - 3:00 PM'),
(24, '20241209-163469', 'Friday', '12:00 PM - 3:00 PM'),
(25, '20241209-163410', 'Thursday', '9:00 AM - 12:00 PM'),
(26, '20241209-163410', 'Friday', '1:00 PM - 5:00 PM'),
(27, '20241209-163410', 'Saturday', '1:00 PM - 5:00 PM'),
(28, '20241210-499639', 'Monday', '6:10AM - 6:10PM'),
(29, '20241210-499639', 'Tuesday', '6:10AM - 6:10PM'),
(30, '20241210-008918', 'Friday', '9:16AM - 6:16PM'),
(31, '20241210-008918', 'Saturday', '9:16AM - 6:16PM'),
(32, '20241210-708315', 'Saturday', '9:16AM - 6:16PM'),
(33, '20241210-708315', 'Wednesday', '9:16AM - 6:16PM'),
(34, '20241210-319039', 'Monday', '11:23AM - 9:24PM'),
(35, '20241210-062221', 'Monday', '7:24AM - 8:24PM'),
(36, '20241211-209726', 'Tuesday', '4:56AM - 4:56PM'),
(37, '20241211-275277', 'Tuesday', '5:01AM - 5:01PM'),
(38, '20241211-911207', 'Tuesday', '5:09AM - 5:04PM'),
(39, '20241211-654245', 'Monday', '5:05AM - 5:05PM'),
(40, '20241211-826180', 'Monday', '5:08AM - 5:08PM'),
(41, '20241211-060504', 'Monday', '8:37AM - 5:39PM'),
(42, '20241211-357273', 'Monday', '5:39AM - 5:39PM'),
(44, '20241211-248333', 'Wednesday', '5:49AM - 5:49PM'),
(46, '20241211-276691', 'Friday', '7:53AM - 7:53PM'),
(47, '20241211-276691', 'Saturday', '7:53AM - 7:53PM'),
(48, '20241212-336265', 'Monday', '11:37AM - 11:37PM'),
(49, '20241212-336265', 'Tuesday', '2:37AM - 11:37PM'),
(50, '20241212-336265', 'Wednesday', '2:37AM - 11:40PM'),
(51, '20241212-112356', 'Tuesday', '2:34AM - 2:34PM'),
(52, '20241212-531091', 'Tuesday', '6:07AM - 5:07PM'),
(53, '20241213-803003', 'Tuesday', '2:06AM - 2:06PM'),
(54, '20241213-905145', 'Tuesday', '4:42AM - 4:42PM'),
(55, '20241213-866807', 'Tuesday', '4:54AM - 4:54PM'),
(56, '20241213-571014', 'Wednesday', '4:57AM - 4:57PM'),
(57, '20241213-281442', 'Wednesday', '5:02AM - 5:02PM'),
(58, '20241213-202795', 'Monday', '5:04AM - 5:04PM'),
(59, '20241213-409201', 'Thursday', '5:07AM - 5:07PM'),
(60, '20241213-005198', 'Friday', '5:11AM - 5:11PM'),
(61, '20241213-685947', 'Monday', '5:18AM - 5:18PM'),
(62, '20241213-745088', 'Wednesday', '5:20AM - 5:20PM'),
(63, '20241213-697001', 'Wednesday', '5:23AM - 5:23PM'),
(64, '20241213-781133', 'Friday', '5:37AM - 5:37PM'),
(65, '20241213-013246', 'Monday', '8:06AM - 6:06PM'),
(66, '20241213-420079', 'Wednesday', '6:15AM - 6:15PM'),
(67, '20241213-420079', 'Friday', '6:15AM - 6:15PM'),
(68, '20241213-396860', 'Wednesday', '6:25AM - 6:25PM'),
(69, '20241213-722798', 'Monday', '6:30AM - 6:30PM'),
(70, '20241213-912737', 'Wednesday', '6:37AM - 6:37PM'),
(71, '20241213-480590', 'Thursday', '6:39AM - 6:39PM'),
(72, '20241213-745417', 'Tuesday', '6:53AM - 6:53PM');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_secretary`
--

CREATE TABLE `doctor_secretary` (
  `doctor_secretary_id` int(11) NOT NULL,
  `secretary_doctor_id` varchar(255) NOT NULL,
  `doctor_secretary_first_name` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `doctor_secretary_first_network` varchar(255) NOT NULL,
  `doctor_secretary_first_number` varchar(255) NOT NULL,
  `doctor_secretary_second_network` varchar(255) NOT NULL,
  `doctor_secretary_second_number` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_secretary`
--

INSERT INTO `doctor_secretary` (`doctor_secretary_id`, `secretary_doctor_id`, `doctor_secretary_first_name`, `sex`, `doctor_secretary_first_network`, `doctor_secretary_first_number`, `doctor_secretary_second_network`, `doctor_secretary_second_number`) VALUES
(1, '20241209-163461', 'Luis V. Ramirez', 'Male', 'SMART', '0912 345 6789.', 'GLOBE', '0917 123 4567'),
(2, '20241209-163462', 'Janine Joy D. Gonzales', 'Female', 'SMART', '0912 345 6789', '', ''),
(3, '20241209-163462', 'Angelique C. Martinez', 'Female', 'GLOBE', '0935 678 9012', '', ''),
(4, '20241209-163463', 'Sophia Marie L. Cruz', 'Female', 'SMART', '0938 765 4321', '', ''),
(5, '20241209-163464', 'Emmanuel D. Holgado', 'Male', 'SMART', '0928 765 4321', '', ''),
(6, '20241209-163465', 'Francisco S. Mendoza', 'Male', 'GLOBE', '0927 567 8901', '', ''),
(7, '20241209-163465', 'Joshika S. Salvador', 'Male', 'GLOBE', '0935 345 6789', 'SMART', '0917 890 1234'),
(8, '20241209-163466', 'Janine Joy D. Golveo', 'Female', 'GLOBE', '0927 567 8901', '', ''),
(9, '20241209-163467', 'Russel Art S. Espiña', 'Male', 'SMART', '0933 210 9876', '', ''),
(10, '20241209-163468', 'Francine J. Alfelor', 'Female', 'SMART', '0939 876 5432', 'DITO', '0917 789 0123'),
(11, '20241209-163469', 'Lea Anne C. Toledo', 'Female', 'GLOBE', '0935 901 2345', '', ''),
(12, '20241209-163410', 'Bianca Louise A. Torres', 'Female', 'GLOBE', '0935 345 6789', '', ''),
(13, '20241213-685947', 'd', '', '324234', 'Globe', '344234', 'Smart'),
(14, '20241213-745088', 'sdfsdf', '', 'Smart', '324234', 'DITO', '234234'),
(15, '20241213-697001', 'france', '', 'Smart', '012387126313', 'DITO', '17236876123'),
(16, '20241213-697001', 'Joshua', '', 'Smart', '234234', 'Cherry Prepaid', '2342344'),
(17, '20241213-781133', 'd', '', 'Globe', '324', 'Globe', '34'),
(18, '20241213-013246', 'dsdfa', '', 'Globe', '32423', 'DITO', '2344'),
(19, '20241213-420079', 'carl', '', 'Smart', '9283479234', 'Sun', '2387462344'),
(20, '20241213-396860', 'd', '', 'Globe', '234234', 'Globe', '234234'),
(21, '20241213-722798', 'ad', '', 'Smart', '234234', 'Smart', '3434'),
(22, '20241213-912737', 'sdff', '', 'Smart', '2134', 'Globe', '123'),
(23, '20241213-480590', 'asdf', '', 'Smart', '234234', 'Smart', '234234'),
(24, '20241213-745417', 'd', '', 'Smart', '234', 'Smart', '234');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_specialization`
--

CREATE TABLE `doctor_specialization` (
  `doctor_specialization_id` int(11) NOT NULL,
  `specialization_doctor_id` varchar(255) NOT NULL,
  `specialization_id_2` int(10) NOT NULL,
  `doctor_specialization_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_specialization`
--

INSERT INTO `doctor_specialization` (`doctor_specialization_id`, `specialization_doctor_id`, `specialization_id_2`, `doctor_specialization_name`) VALUES
(1, '20241209-163461', 1, 'Internal Medicine'),
(2, '20241209-163462', 2, 'Orthopedics'),
(3, '20241209-163463', 3, 'Pediatrics'),
(4, '20241209-163465', 4, 'Surgery'),
(5, '20241209-163466', 5, 'Psychiatry'),
(6, '20241209-163467', 6, 'Obstetrics & Gynecology'),
(7, '20241209-163468', 7, 'Opthalmology'),
(8, '20241209-163469', 10, 'Radiology'),
(9, '20241209-163410', 8, 'Family and Community Medicine'),
(10, '20241209-163411', 9, 'Anesthesia'),
(20, '20241209-814861', 1, 'Internal Medicine'),
(21, '20241209-814861', 8, 'Family and Community Medicine'),
(22, '20241210-343859', 14, 'asdf'),
(23, '20241210-729728', 2, 'Orthopedics'),
(24, '20241210-818669', 2, 'Orthopedics'),
(25, '20241210-683587', 3, 'Pediatrics'),
(26, '20241210-107664', 3, 'Pediatrics'),
(27, '20241210-499639', 14, 'asdf'),
(28, '20241210-008918', 3, 'Pediatrics'),
(29, '20241210-708315', 1, 'Internal Medicine'),
(30, '20241210-319039', 1, 'Internal Medicine'),
(31, '20241210-062221', 1, 'Internal Medicine'),
(32, '20241211-209726', 3, 'Pediatrics'),
(33, '20241211-275277', 1, 'Internal Medicine'),
(34, '20241211-911207', 2, 'Orthopedics'),
(35, '20241211-654245', 2, 'Orthopedics'),
(36, '20241211-826180', 5, 'Psychiatry'),
(37, '20241211-826180', 21, 'saf'),
(38, '20241211-060504', 3, 'Pediatrics'),
(39, '20241211-357273', 4, 'Surgery'),
(40, '20241211-925047', 1, 'Internal Medicine'),
(41, '20241211-248333', 6, 'Obstetrics & Gynecology'),
(42, '20241211-276691', 5, 'Psychiatry'),
(43, '20241211-276691', 12, 's'),
(44, '20241212-336265', 4, 'Surgery'),
(45, '20241212-336265', 8, 'Family and Community Medicine'),
(46, '20241212-336265', 10, 'Radiology'),
(47, '20241212-112356', 4, 'Surgery'),
(48, '20241212-531091', 4, 'Surgery'),
(49, '20241213-803003', 1, 'Internal Medicine'),
(50, '20241213-905145', 2, 'Orthopedics'),
(51, '20241213-866807', 8, 'Family and Community Medicine'),
(52, '20241213-571014', 1, 'Internal Medicine'),
(53, '20241213-281442', 2, 'Orthopedics'),
(54, '20241213-202795', 2, 'Orthopedics'),
(55, '20241213-409201', 3, 'Pediatrics'),
(56, '20241213-005198', 2, 'Orthopedics'),
(57, '20241213-685947', 1, 'Internal Medicine'),
(58, '20241213-745088', 1, 'Internal Medicine'),
(59, '20241213-697001', 2, 'Orthopedics'),
(60, '20241213-781133', 3, 'Pediatrics'),
(61, '20241213-013246', 3, 'Pediatrics'),
(62, '20241213-420079', 4, 'Surgery'),
(63, '20241213-420079', 8, 'Family and Community Medicine'),
(64, '20241213-420079', 10, 'Radiology'),
(65, '20241213-396860', 8, 'Family and Community Medicine'),
(66, '20241213-722798', 2, 'Orthopedics'),
(67, '20241213-912737', 1, 'Internal Medicine'),
(68, '20241213-480590', 8, 'Family and Community Medicine'),
(69, '20241213-745417', 1, 'Internal Medicine'),
(70, 'France', 1, 'Updated'),
(71, 'France', 1, 'Updated');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_sub_specialization`
--

CREATE TABLE `doctor_sub_specialization` (
  `doctor_sub_specialization_id` int(11) NOT NULL,
  `sub_specialization_doctor_id` varchar(255) NOT NULL,
  `sub_specialization_id_2` int(10) NOT NULL,
  `doctor_sub_specialization_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_sub_specialization`
--

INSERT INTO `doctor_sub_specialization` (`doctor_sub_specialization_id`, `sub_specialization_doctor_id`, `sub_specialization_id_2`, `doctor_sub_specialization_name`) VALUES
(1, '20241209-163461', 1, 'Cardiology'),
(2, '20241209-163461', 2, 'Dermatology'),
(3, '20241209-163461', 5, 'Rheumatology'),
(4, '20241209-163461', 4, 'Nephrology'),
(5, '20241209-163462', 6, 'Arthroplasty'),
(6, '20241209-163462', 7, 'Hand Surgery'),
(7, '20241209-163463', 11, 'Gastroenterology'),
(8, '20241209-163463', 13, 'General Pediatrics'),
(9, '20241209-163463', 12, 'Immunology'),
(10, '20241209-163464', 14, 'Audiology'),
(11, '20241209-163464', 17, 'Colon and Rectal'),
(12, '20241209-163465', 16, 'Pediatric Urology'),
(13, '20241209-163465', 18, 'Biological Psychiatry'),
(14, '20241209-163466', 20, 'Colposcopic'),
(15, '20241209-163466', 22, 'Ultrasound'),
(16, '20241209-163467', 21, 'Oncology'),
(17, '20241209-163467', 25, 'Retina'),
(18, '20241209-163468', 26, 'Cornea'),
(19, '20241209-163468', 36, 'CT Scan and MRI'),
(20, '20241209-163468', 37, 'Vascular and Interventional'),
(21, '20241209-163469', 31, 'Adoloscent and Young Adult Medicine'),
(22, '20241209-163410', 35, 'Palliative Care'),
(23, '20241210-343859', 3, 'Endocrinology'),
(24, '20241210-343859', 8, 'Knee Arthoscopy'),
(25, '20241210-729728', 14, 'Audiology'),
(26, '20241210-729728', 26, 'Cornea'),
(27, '20241210-818669', 2, 'Dermatology'),
(28, '20241210-818669', 44, 'new sub'),
(29, '20241210-683587', 2, 'Dermatology'),
(30, '20241210-683587', 8, 'Knee Arthoscopy'),
(31, '20241210-107664', 3, 'Endocrinology'),
(32, '20241210-499639', 6, 'Arthroplasty'),
(33, '20241210-008918', 9, 'Spine Surgery'),
(34, '20241210-008918', 11, 'Gastroenterology'),
(35, '20241210-708315', 29, 'Sleep Medicine'),
(36, '20241210-708315', 30, 'Sports Medicine'),
(37, '20241210-319039', 4, 'Nephrology'),
(38, '20241210-062221', 8, 'Knee Arthoscopy'),
(39, '20241211-209726', 8, 'Knee Arthoscopy'),
(40, '20241211-275277', 3, 'Endocrinology'),
(41, '20241211-911207', 2, 'Dermatology'),
(42, '20241211-654245', 3, 'Endocrinology'),
(43, '20241211-826180', 4, 'Nephrology'),
(44, '20241211-060504', 3, 'Endocrinology'),
(45, '20241211-357273', 3, 'Endocrinology'),
(46, '20241211-925047', 2, 'Dermatology'),
(47, '20241211-248333', 3, 'Endocrinology'),
(48, '20241211-276691', 6, 'Arthroplasty'),
(49, '20241211-276691', 7, 'Hand Surgery'),
(50, '20241211-276691', 8, 'Knee Arthoscopy'),
(51, '20241212-336265', 3, 'Endocrinology'),
(52, '20241212-336265', 6, 'Arthroplasty'),
(53, '20241212-336265', 7, 'Hand Surgery'),
(54, '20241212-336265', 8, 'Knee Arthoscopy'),
(55, '20241212-336265', 13, 'General Pediatrics'),
(56, '20241212-112356', 7, 'Hand Surgery'),
(57, '20241212-531091', 7, 'Hand Surgery'),
(58, '20241213-803003', 5, 'Rheumatology'),
(59, '20241213-905145', 2, 'Dermatology'),
(60, '20241213-866807', 3, 'Endocrinology'),
(61, '20241213-571014', 3, 'Endocrinology'),
(62, '20241213-281442', 7, 'Hand Surgery'),
(63, '20241213-202795', 5, 'Rheumatology'),
(64, '20241213-409201', 7, 'Hand Surgery'),
(65, '20241213-005198', 7, 'Hand Surgery'),
(66, '20241213-685947', 3, 'Endocrinology'),
(67, '20241213-745088', 2, 'Dermatology'),
(68, '20241213-697001', 3, 'Endocrinology'),
(69, '20241213-697001', 6, 'Arthroplasty'),
(70, '20241213-697001', 8, 'Knee Arthoscopy'),
(71, '20241213-781133', 8, 'Knee Arthoscopy'),
(72, '20241213-013246', 7, 'Hand Surgery'),
(73, '20241213-420079', 3, 'Endocrinology'),
(74, '20241213-420079', 7, 'Hand Surgery'),
(75, '20241213-420079', 8, 'Knee Arthoscopy'),
(76, '20241213-396860', 3, 'Endocrinology'),
(77, '20241213-722798', 2, 'Dermatology'),
(78, '20241213-912737', 2, 'Dermatology'),
(79, '20241213-480590', 13, 'General Pediatrics'),
(80, '20241213-745417', 1, 'Cardiology');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_teleconsult`
--

CREATE TABLE `doctor_teleconsult` (
  `doctor_teleconsult_id` int(11) NOT NULL,
  `teleconsult_doctor_id` varchar(255) NOT NULL,
  `teleconsult_link` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_teleconsult`
--

INSERT INTO `doctor_teleconsult` (`doctor_teleconsult_id`, `teleconsult_doctor_id`, `teleconsult_link`) VALUES
(4, '20241209-163461', 'https://chatgpt.com'),
(5, '20241209-163462', 'https://www.youtube.com/'),
(9, '20241212-336265', 'teleFacebook.com'),
(12, '20241209-163463', NULL),
(13, '20241212-112356', 'facebook.com'),
(14, '20241212-531091', ''),
(15, '20241213-803003', ''),
(16, '20241213-443100', ''),
(17, '20241213-281442', ''),
(18, '20241213-202795', ''),
(19, '20241213-409201', ''),
(20, '20241213-005198', ''),
(21, '20241213-685947', ''),
(22, '20241213-745088', ''),
(23, '20241213-697001', 'asdf'),
(24, '20241213-781133', '2'),
(25, '20241213-013246', 'asdf'),
(26, '20241213-420079', 'htt'),
(27, '20241213-396860', ''),
(28, '20241213-722798', 'sa'),
(29, '20241213-912737', 'ds'),
(30, '20241213-480590', 'd'),
(31, '20241213-745417', 'D');

-- --------------------------------------------------------

--
-- Table structure for table `hmo`
--

CREATE TABLE `hmo` (
  `hmo_id` int(11) NOT NULL,
  `hmo_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hmo`
--

INSERT INTO `hmo` (`hmo_id`, `hmo_name`) VALUES
(1, 'Healthway Medi-Access'),
(2, 'Intellicare'),
(3, 'Insular Life Assurance Co., Ltd.'),
(4, 'KAISER International Healthgroup, Inc.'),
(5, 'IMS Wellth Care, Inc.'),
(6, 'Maxicare Healthcare Corporation'),
(7, 'Medasia Philippines Inc.'),
(8, 'Medicard Philippines Inc.'),
(9, 'Medilink Network Inc.'),
(10, 'MedoCare Health Systems, Inc.'),
(11, 'Pacific Cross Health Care, Inc.'),
(12, 'Value Care Health Systems Inc.'),
(13, 'Allianz PNB Life Insurance Inc'),
(14, 'Advanced Medical Access Philippines, Inc.'),
(15, 'Carewell Health Systems, Inc.'),
(16, 'AsianCare Health Systems Inc.'),
(17, 'Etiqa Life And General Assurance Philippines, Inc.'),
(18, 'Avega Managed Care, Inc.'),
(19, 'Beneficial Life Insurance Company, Inc.'),
(21, 'EastWest Health Care, Inc.'),
(22, 'Generali Life Assurance Philippines Inc.'),
(23, 'Getwell Health Systems, Inc.'),
(24, 'Health Maintenance, Inc.'),
(25, 'Health Plan Philippines, Inc.');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL,
  `room_floor_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `room_floor_name`) VALUES
(1, '2nd Floor - Room 2208'),
(2, '3rd Floor - Room 3306'),
(3, '2nd Floor - Room 2408'),
(4, '2nd Floor - Room 2221'),
(5, '2nd Floor - Room 2251'),
(6, '3rd Floor - Room 3405'),
(7, '3rd Floor - Room 3406'),
(8, '4th Floor - Room 4102'),
(9, '2nd Floor - Room 2405'),
(10, '2nd Floor - Room 2342'),
(11, '3rd Floor - Room 3306'),
(21, '2nd Floor - Room 2307'),
(22, '2nd Floor - Room 2231');

-- --------------------------------------------------------

--
-- Table structure for table `specialization`
--

CREATE TABLE `specialization` (
  `specialization_id` int(11) NOT NULL,
  `specialization_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `specialization`
--

INSERT INTO `specialization` (`specialization_id`, `specialization_name`) VALUES
(1, 'Internal Medicine'),
(2, 'Orthopedics'),
(3, 'Pediatrics'),
(4, 'Surgery'),
(5, 'Psychiatry'),
(6, 'Obstetrics & Gynecology'),
(7, 'Opthalmology'),
(8, 'Family and Community Medicine'),
(9, 'Anesthesia'),
(10, 'Radiology');

-- --------------------------------------------------------

--
-- Table structure for table `sub_specialization`
--

CREATE TABLE `sub_specialization` (
  `sub_specialization_id` int(11) NOT NULL,
  `sub_specs_id` int(11) NOT NULL,
  `sub_specialization_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_specialization`
--

INSERT INTO `sub_specialization` (`sub_specialization_id`, `sub_specs_id`, `sub_specialization_name`) VALUES
(1, 1, 'Cardiology'),
(2, 1, 'Dermatology'),
(3, 1, 'Endocrinology'),
(4, 1, 'Nephrology'),
(5, 1, 'Rheumatology'),
(6, 2, 'Arthroplasty'),
(7, 2, 'Hand Surgery'),
(8, 2, 'Knee Arthoscopy'),
(9, 2, 'Spine Surgery'),
(10, 3, 'Allergology'),
(11, 3, 'Gastroenterology'),
(12, 3, 'Immunology'),
(13, 3, 'General Pediatrics'),
(14, 4, 'Audiology'),
(15, 4, 'Neuro Surgery'),
(16, 4, 'Pediatric Urology'),
(17, 4, 'Colon and Rectal'),
(18, 5, 'Biological Psychiatry'),
(19, 5, 'Epilepsy'),
(20, 6, 'Colposcopic'),
(21, 6, 'Oncology'),
(22, 6, 'Ultrasound'),
(23, 6, 'Urologic Gynecology'),
(24, 7, 'Oculoplastics'),
(25, 7, 'Retina'),
(26, 7, 'Cornea'),
(27, 7, 'Cataract'),
(28, 8, 'Geriatric Medicine'),
(29, 8, 'Sleep Medicine'),
(30, 8, 'Sports Medicine'),
(31, 8, 'Adoloscent and Young Adult Medicine'),
(32, 9, 'Cardiovascular Anesthesia'),
(33, 9, 'General Anesthesia'),
(34, 9, 'Intensive Care'),
(35, 9, 'Palliative Care'),
(36, 10, 'CT Scan and MRI'),
(37, 10, 'Vascular and Interventional'),
(38, 10, 'Radiation Oncology'),
(39, 10, 'Pediatric Radiology');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `admin_activity_logs`
--
ALTER TABLE `admin_activity_logs`
  ADD PRIMARY KEY (`admin_activity_logs_id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`doctor_id`);

--
-- Indexes for table `doctor_archive`
--
ALTER TABLE `doctor_archive`
  ADD PRIMARY KEY (`doctor_archive_id`);

--
-- Indexes for table `doctor_category`
--
ALTER TABLE `doctor_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `doctor_hmo`
--
ALTER TABLE `doctor_hmo`
  ADD PRIMARY KEY (`doctor_hmo_id`);

--
-- Indexes for table `doctor_notes`
--
ALTER TABLE `doctor_notes`
  ADD PRIMARY KEY (`doctor_notes_id`);

--
-- Indexes for table `doctor_room`
--
ALTER TABLE `doctor_room`
  ADD PRIMARY KEY (`doctor_room_id`);

--
-- Indexes for table `doctor_schedule`
--
ALTER TABLE `doctor_schedule`
  ADD PRIMARY KEY (`doctor_schedule_id`);

--
-- Indexes for table `doctor_secretary`
--
ALTER TABLE `doctor_secretary`
  ADD PRIMARY KEY (`doctor_secretary_id`);

--
-- Indexes for table `doctor_specialization`
--
ALTER TABLE `doctor_specialization`
  ADD PRIMARY KEY (`doctor_specialization_id`);

--
-- Indexes for table `doctor_sub_specialization`
--
ALTER TABLE `doctor_sub_specialization`
  ADD PRIMARY KEY (`doctor_sub_specialization_id`);

--
-- Indexes for table `doctor_teleconsult`
--
ALTER TABLE `doctor_teleconsult`
  ADD PRIMARY KEY (`doctor_teleconsult_id`);

--
-- Indexes for table `hmo`
--
ALTER TABLE `hmo`
  ADD PRIMARY KEY (`hmo_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `specialization`
--
ALTER TABLE `specialization`
  ADD PRIMARY KEY (`specialization_id`);

--
-- Indexes for table `sub_specialization`
--
ALTER TABLE `sub_specialization`
  ADD PRIMARY KEY (`sub_specialization_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `admin_activity_logs`
--
ALTER TABLE `admin_activity_logs`
  MODIFY `admin_activity_logs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `doctor_archive`
--
ALTER TABLE `doctor_archive`
  MODIFY `doctor_archive_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_category`
--
ALTER TABLE `doctor_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_hmo`
--
ALTER TABLE `doctor_hmo`
  MODIFY `doctor_hmo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `doctor_notes`
--
ALTER TABLE `doctor_notes`
  MODIFY `doctor_notes_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `doctor_room`
--
ALTER TABLE `doctor_room`
  MODIFY `doctor_room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `doctor_schedule`
--
ALTER TABLE `doctor_schedule`
  MODIFY `doctor_schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `doctor_secretary`
--
ALTER TABLE `doctor_secretary`
  MODIFY `doctor_secretary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `doctor_specialization`
--
ALTER TABLE `doctor_specialization`
  MODIFY `doctor_specialization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `doctor_sub_specialization`
--
ALTER TABLE `doctor_sub_specialization`
  MODIFY `doctor_sub_specialization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `doctor_teleconsult`
--
ALTER TABLE `doctor_teleconsult`
  MODIFY `doctor_teleconsult_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `hmo`
--
ALTER TABLE `hmo`
  MODIFY `hmo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `specialization`
--
ALTER TABLE `specialization`
  MODIFY `specialization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `sub_specialization`
--
ALTER TABLE `sub_specialization`
  MODIFY `sub_specialization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
