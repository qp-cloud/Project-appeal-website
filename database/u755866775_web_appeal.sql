-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 20, 2025 at 12:32 AM
-- Server version: 10.11.10-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u755866775_web_appeal`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `user_id` int(11) NOT NULL,
  `action` varchar(255) DEFAULT NULL,
  `performed_by` int(11) DEFAULT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`user_id`, `action`, `performed_by`, `timestamp`) VALUES
(84, 'deactivate_user', 83, '2025-03-20 00:24:21');

-- --------------------------------------------------------

--
-- Table structure for table `appeals`
--

CREATE TABLE `appeals` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `report_subject` varchar(255) NOT NULL,
  `category` enum('ทุจริตทางการเงิน','ทุจริตในโครงการ','ใช้อำนาจหน้าที่โดยมิชอบ','การเลือกปฏิบัติ','อื่น ๆ','ไม่ทราบหมวดหมู่') DEFAULT NULL,
  `report_person` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(100) DEFAULT NULL,
  `contact_location` varchar(255) DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `incident_date` date DEFAULT NULL,
  `incident_time` time DEFAULT NULL,
  `problem_level` varchar(50) DEFAULT NULL,
  `department` enum('เทศบาลเมือง','สำนักปลัดเทศบาลเมือง','กองคลัง','กองช่าง','กองการศึกษา','กองสาธารณสุข','กองสวัสดิการสังคม','กองยุทธศาสตร์','กองการเจ้าหน้าที่','หน่วยตรวจสอบภายใน','หน่วยงานอื่นๆ','ไม่ทราบหน่วยงาน') DEFAULT NULL,
  `complaint_description` text DEFAULT NULL,
  `complaint_file` longblob DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('ยังไม่ดำเนินการ','กำลังดำเนินการ','ดำเนินการเสร็จสิ้น') DEFAULT 'ยังไม่ดำเนินการ',
  `note` text DEFAULT NULL,
  `video_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appeals`
--

INSERT INTO `appeals` (`id`, `user_id`, `report_subject`, `category`, `report_person`, `contact_phone`, `contact_location`, `latitude`, `longitude`, `incident_date`, `incident_time`, `problem_level`, `department`, `complaint_description`, `complaint_file`, `submitted_at`, `status`, `note`, `video_link`) VALUES
(119, 40, 'testappeal2', 'ใช้อำนาจหน้าที่โดยมิชอบ', 'testappeal2', 'testappeal2', 'testappeal2', 0, 0, '2024-12-20', '01:32:00', 'เร่งด่วน', 'หน่วยตรวจสอบภายใน', 'testappeal2', '', '2024-12-20 18:32:56', 'ดำเนินการเสร็จสิ้น', 'ไม่มีหมายเหตุ', ''),
(120, 36, 'testappeal3', '', 'testappeal3', 'testappeal3', 'testappeal3', 13.811, 99.8756, '2024-12-21', '01:37:00', 'ปานกลาง', 'กองการเจ้าหน้าที่', 'testappeal3', '', '2024-12-20 18:37:14', 'ยังไม่ดำเนินการ', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `complaint_subject` varchar(255) NOT NULL,
  `contact_phone` varchar(100) DEFAULT NULL,
  `contact_location` varchar(255) DEFAULT NULL,
  `contact_details` text DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `incident_date` date DEFAULT NULL,
  `incident_time` time DEFAULT NULL,
  `problem_level` varchar(50) DEFAULT NULL,
  `department` enum('เทศบาลเมือง','สำนักปลัดเทศบาลเมือง','กองคลัง','กองช่าง','กองการศึกษา','กองสาธารณสุข','กองสวัสดิการสังคม','กองยุทธศาสตร์','กองการเจ้าหน้าที่','หน่วยตรวจสอบภายใน','หน่วยงานอื่นๆ','ไม่ทราบหน่วยงาน') DEFAULT NULL,
  `complaint_description` text DEFAULT NULL,
  `complaint_file` longblob DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('ยังไม่ดำเนินการ','กำลังดำเนินการ','ดำเนินการเสร็จสิ้น') DEFAULT 'ยังไม่ดำเนินการ',
  `note` text DEFAULT NULL,
  `video_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `user_id`, `complaint_subject`, `contact_phone`, `contact_location`, `contact_details`, `latitude`, `longitude`, `incident_date`, `incident_time`, `problem_level`, `department`, `complaint_description`, `complaint_file`, `submitted_at`, `status`, `note`, `video_link`) VALUES
(1, 40, 'test', 'test', 'test', 'test', 13.811, 99.8756, '2024-12-21', '01:28:00', 'เร่งด่วน', 'เทศบาลเมือง', 'test', '', '2024-12-20 18:29:06', 'กำลังดำเนินการ', 'ไม่มีหมายเหตุ', ''),
(2, 36, 'เสียงดังรบกวนชาวบ้าน', '0973195322', 'ริมแม่นำ้', 'ริมแม่นำ้', 13.8125, 99.8729, '2024-12-21', '10:12:00', 'ต่ำ', 'เทศบาลเมือง', 'เสียงดังรบกวนชาวบ้าน', 0x75706c6f6164732f696d616765732e6a7067, '2024-12-21 03:13:15', 'ดำเนินการเสร็จสิ้น', 'กำลังไปที่สถานที่เกิดเหตุ', 'ไม่มี'),
(3, 81, 'ถนนมีหลุมบ่ออันตรายต่อผู้ขับขี่', 'sirawit@example.com', 'ถนนบ้านใหม่ ตำบลบ้านใหม่ อำเภอบางโป่ง จังหวัดราชบุรี', 'อยู่ในเขตพื้นที่ใกล้โรงเรียนบ้านใหม่ ปากซอยถนนบ้านใหม่', 13.5564, 100.031, '2024-12-21', '11:28:00', 'เร่งด่วน', 'เทศบาลเมือง', 'ถนนในพื้นที่ตำบลบ้านใหม่มีหลุมบ่อขนาดใหญ่หลายจุด ทำให้ผู้ขับขี่เกิดอุบัติเหตุหลายครั้งแล้ว และเป็นอันตรายต่อผู้ขับขี่และผู้สัญจรผ่านไปมา', '', '2024-12-21 04:29:02', 'ดำเนินการเสร็จสิ้น', 'ไม่มีหมายเหตุ', ''),
(4, 51, 'ถนนมีหลุมบ่ออันตรายต่อผู้ขับขี่2', 'sirawit@example.com', 'ถนนบ้านใหม่ ตำบลบ้านใหม่ อำเภอบางโป่ง จังหวัดราชบุรี', 'ถนนบ้านใหม่ ตำบลบ้านใหม่ อำเภอบางโป่ง จังหวัดราชบุรี', 13.811, 99.8756, '2024-12-21', '11:48:00', 'เร่งด่วน', 'กองการเจ้าหน้าที่', 'ถนนบ้านใหม่ ตำบลบ้านใหม่ อำเภอบางโป่ง จังหวัดราชบุรี', '', '2024-12-21 04:49:02', 'กำลังดำเนินการ', 'ไม่มีหมายเหตุ', ''),
(5, 51, 'ถังขยะส่งกลิ่นเหม็น', '0867672572', 'สถานีรถไฟลูกแก', 'หน้าสถานีรถไฟ', 13.8721, 99.8238, '2025-01-10', '18:06:00', 'ต่ำ', 'ไม่ทราบหน่วยงาน', 'ไม่มีเจ้าหน้าที่เข้ามาเก็บขยะนานหลายสัปดาห์แล้ว', 0x75706c6f6164732fe0b882e0b8a2e0b8b02e6a7067, '2025-01-16 11:07:23', 'ยังไม่ดำเนินการ', NULL, ''),
(6, 51, 'สายไฟตกลงมา', '0867672821', 'โรงเรียนพุทธศาสนาปริยัติธรรม', 'หน้าโรงเรียนพุทธศาสนาปริยัติธรรม', 13.81, 99.8755, '2025-01-03', '07:17:00', 'เร่งด่วน', 'กองช่าง', 'สายไฟหน้าโรงเรียนล้ม', 0x75706c6f6164732fe0b8aae0b8b2e0b8a2e0b984e0b89f2e6a7067, '2025-01-16 11:17:21', 'ยังไม่ดำเนินการ', NULL, ''),
(7, 51, 'กระจก3แยกหาย', '0910728579', 'แยกคลองลำพยอม', '3แยกคลองลำพยอม', 13.8265, 99.8192, '2025-01-01', '07:20:00', 'ต่ำ', 'ไม่ทราบหน่วยงาน', 'ต้องการให้เข้ามาติดกระจกให้ใหม่', '', '2025-01-16 11:21:47', 'ยังไม่ดำเนินการ', NULL, ''),
(8, 51, 'เครื่องเล่นเสีย', '0671995792', 'เทศบาล', 'ที่ออกกำลังกายเทศบาลบ้านโป่ง', 0, 0, '2025-01-10', '21:25:00', 'ปานกลาง', 'ไม่ทราบหน่วยงาน', 'เครื่องออกกำลังกายของเทศบาลล้ม', 0x75706c6f6164732fe0b980e0b884e0b8a3e0b8b7e0b988e0b8ade0b887e0b980e0b8a5e0b988e0b8992e706e67, '2025-01-16 11:25:59', 'ดำเนินการเสร็จสิ้น', 'ไม่มีหมายเหตุ', '');

-- --------------------------------------------------------

--
-- Table structure for table `contact_table`
--

CREATE TABLE `contact_table` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `contact` text NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `contacted_back` tinyint(1) DEFAULT 0,
  `responded_by` varchar(255) DEFAULT NULL,
  `responded_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_table`
--

INSERT INTO `contact_table` (`id`, `name`, `contact`, `message`, `submitted_at`, `contacted_back`, `responded_by`, `responded_at`) VALUES
(1, 'Sirawit Charoenpanich', '', '1111', '2024-12-03 15:32:38', 0, NULL, NULL),
(2, 'Sirawit Charoenpanich', '', '1111', '2024-12-03 15:34:20', 0, NULL, NULL),
(3, 'Sirawit Charoenpanich', '', 'ddd', '2024-12-03 15:35:31', 0, NULL, NULL),
(4, 'Sirawit', '', 'ggggg', '2024-12-03 15:36:11', 1, 'ชยพล', '2025-03-18 20:09:59'),
(5, 'เจษฎาพร ภมรฉ่ำ', '', 'อยากติดต่อเป็นการส่วนตัวกับหน่วยงานช่าง', '2024-12-19 02:32:11', 1, 'สิรวิชญ์', '2025-03-18 20:09:48'),
(6, 'เจษฎาพร ภมรฉ่ำ', '', 'กกก', '2024-12-19 08:49:23', 1, 'สิรวิชญ์', '2025-03-18 20:05:55'),
(7, 'ชยพล เมธาสิทธิกุล', '0828665528', 'Test', '2024-12-19 09:29:39', 1, 'Admin', '2025-03-18 19:39:06');

-- --------------------------------------------------------

--
-- Table structure for table `status_change_logs`
--

CREATE TABLE `status_change_logs` (
  `id` int(11) NOT NULL,
  `complaint_id` int(11) NOT NULL,
  `old_status` varchar(255) NOT NULL,
  `new_status` varchar(255) NOT NULL,
  `changed_by` int(11) NOT NULL,
  `changed_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_change_logs`
--

INSERT INTO `status_change_logs` (`id`, `complaint_id`, `old_status`, `new_status`, `changed_by`, `changed_at`) VALUES
(1, 1, 'ยังไม่ดำเนินการ', 'กำลังดำเนินการ', 11, '2024-12-21 01:33:25'),
(2, 1, 'ยังไม่ดำเนินการ', 'ดำเนินการเสร็จสิ้น', 11, '2024-12-21 01:33:36'),
(3, 119, 'ยังไม่ดำเนินการ', 'ดำเนินการเสร็จสิ้น', 11, '2024-12-21 01:34:16'),
(4, 2, 'ยังไม่ดำเนินการ', 'กำลังดำเนินการ', 11, '2024-12-21 03:14:22'),
(5, 3, 'ยังไม่ดำเนินการ', 'กำลังดำเนินการ', 11, '2024-12-21 04:29:30'),
(6, 3, 'กำลังดำเนินการ', 'ดำเนินการเสร็จสิ้น', 11, '2024-12-21 04:41:36'),
(7, 2, 'กำลังดำเนินการ', 'ดำเนินการเสร็จสิ้น', 11, '2024-12-21 04:42:25'),
(8, 4, 'ยังไม่ดำเนินการ', 'กำลังดำเนินการ', 11, '2024-12-21 04:49:21'),
(9, 8, 'ยังไม่ดำเนินการ', 'ดำเนินการเสร็จสิ้น', 83, '2025-01-16 13:45:48');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `id_number` char(13) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `birth_date` date NOT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `phone` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` enum('admin','user') DEFAULT 'user',
  `department` enum('เทศบาลเมือง','สำนักปลัดเทศบาลเมือง','กองคลัง','กองช่าง','กองการศึกษา','กองสาธารณสุข','กองสวัสดิการสังคม','กองยุทธศาสตร์','กองการเจ้าหน้าที่','หน่วยตรวจสอบภายใน','หน่วยงานอื่นๆ') DEFAULT NULL,
  `status` enum('active','deactivated') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `id_number`, `gender`, `birth_date`, `occupation`, `phone`, `email`, `address`, `username`, `password`, `created_at`, `updated_at`, `role`, `department`, `status`) VALUES
(4, 'Sirawit', 'Charoenpanich', '2131231232131', 'male', '2024-11-25', 'sada', '1213123213', 'poohcha7992@gmail.com', 'dasdsad', 'main', '$2y$10$w4D1uxWtVgTvgErDuHMCVOc1p4Ch6nMX97ABJXYSBGgsSqsDFZguK', '2024-11-25 16:56:56', '2024-11-27 02:06:44', 'admin', 'กองสาธารณสุข', 'active'),
(11, 'Sirawit', 'Charoenpanich', '2131231232187', 'male', '2024-11-27', 'sadas', '0973195322', 'poohcha72@gmail.com', 'a', 'admin', '$2y$10$GZs2TMCESiYmwFc82iucnOecg7PmKPrur8j4tknuSTcm/bmdmmv6W', '2024-11-26 09:45:15', '2024-11-27 01:41:54', 'admin', 'กองคลัง', 'active'),
(13, '', '', '1234567890123', 'male', '2024-11-06', NULL, '', '', '', 'phet', '$2y$10$x8ryZZWYR00PL4fm9KfabO8tTt1sLL5iQnsFCrStd1KCyOLjUlocW', '2024-11-27 13:12:37', '2024-12-03 22:16:47', 'user', NULL, 'active'),
(18, 'chakkapong inwza', 'pattana', '1234567890125', 'male', '2024-11-06', 'dddd', '0973195327', 'sadd@gmail.com', 'dddddd', 'phetza', '$2y$10$hhTEuE4ogvqLQgGW9mkRUuHnmJA9JL.hr4GS4c2e3d3Aa1Owf5DbG', '2024-11-27 13:19:05', '2024-11-27 13:19:05', 'admin', 'กองการเจ้าหน้าที่', 'active'),
(19, 'อัญนา', 'วิชยประเสริฐกุล', '1568294991222', 'other', '2010-01-04', 'หมอ', '0904145645', 'vajoma1111@ikowat.com', 'บ้านโปง', 'autya', '$2y$10$7V7Z93/XNj/HcfasaRTsMe7jwm1nBn2x2bOwkISgM2po5CX.dbp9.', '2024-12-04 22:45:03', '2024-12-04 22:45:03', 'user', NULL, 'active'),
(20, 'ธิศา', 'สันติสุข', '1458129201911', 'female', '2003-02-05', 'ชาวนา', '0908448298', 'wanibom846@jonespal.com', '59หมู่3', 'thida', '$2y$10$lQ7XHmFEQWSzwKWr1/wkQu2cAgf3w0fbNpTgf7sCuMmUY3rh1ek82', '2024-12-04 23:11:00', '2024-12-04 23:11:00', 'user', NULL, 'active'),
(21, 'คัทลียา', 'เกียรติโกศล', '1341245664378', 'other', '1998-06-09', 'ค้าขาย', '0868843428', 'kesebi3072@bflcafe.com', 'ซอย7', 'catli', '$2y$10$zjeP4qDLt8fqEII.q8NILObcHVDe2tLCzur2by53.wlfKYv1a5PFa', '2024-12-04 23:25:46', '2024-12-04 23:25:46', 'user', NULL, 'active'),
(22, 'บวรวิทย์', 'เพชรประเสริฐ', '1645728881122', 'male', '2000-06-15', 'ช่างตัดผม', '0901421552', 'pdt81366@inohm.com', '37/5ซอย10', 'Bawonwit', '$2y$10$aiD5cHNixHq6p0TjpHBHi.3gf3h29ocUOYiVf6ChskhmSHeBqoYTe', '2024-12-04 23:44:24', '2024-12-04 23:44:24', 'user', NULL, 'active'),
(23, 'ถิรพุทธ', 'ตรีพงศ์สกุล', '173912842112', 'male', '2001-06-05', 'ชาวไล่', '0627182842', 'lft43724@inohm.com', '68หมู่2', 'Tiraput', '$2y$10$/A.8VZtYFrAQ8Xggh7tsWO8ovlI2tvPwGQGDYD4NnmT5YrTG85dwa', '2024-12-04 23:57:55', '2024-12-04 23:57:55', 'user', NULL, 'active'),
(24, 'วิสาข์', 'รัตนพิรมย์', '1645529235812', 'female', '2001-06-05', 'ค้าขาย', '0901421554', 'vjl88622@kisoq.com', 'หมู่4', 'Wisa', '$2y$10$Imq/un0Zjg83uVkshcg4Qew8aZEs/mMsesa97v0Vr8IxsXyOX1xja', '2024-12-05 00:21:41', '2024-12-05 00:21:41', 'user', NULL, 'active'),
(25, 'จารวี', 'โตศิลา', '1547262716272', 'other', '2024-12-05', 'ค้าขาย', '0920812882', 'kesebi30722@bflcafe.com', 'บ้านโป่ง', 'Jarawee', '$2y$10$xCVdJ6iAaj7k6SnmFv27PuY.j2tDYS78M.hEZPWQT/ts79lnq4ULC', '2024-12-05 03:25:25', '2025-03-18 20:36:28', 'user', NULL, 'active'),
(26, 'กลอน', 'ปิติโอภาสพงศ์', '1739300002141', 'other', '2024-12-05', 'ชาวนา', '0908448254', 'kesebi301272@bflcafe.com', 'บ้านโป่ง', 'Klon', '$2y$10$9p2.dUXktBO//sK/BILBhOu2elN0Z45w1i3E2x5BQ7m.lrj/P0PmG', '2024-12-05 03:31:03', '2024-12-05 03:31:03', 'user', NULL, 'active'),
(27, 'เจษฎาพร', 'ภมรฉ่ำ', '1640705156', 'male', '2002-09-05', 'นักศึกษา', '0867672552', 'jesadapron.pamo@bumail.net', 'พลัมอไลฟ์1ตึกA', 'GotVader', '$2y$10$wdq.eN3OlpSSIn.JtFPlYuyABnC5Umer6yGXuGOFXTvwd4vQHQUhS', '2024-12-05 05:43:48', '2024-12-05 05:43:48', 'user', NULL, 'active'),
(28, 'Got', 'Vader', '1739300006472', 'male', '2024-11-14', 'admin', '0867672553', 'gotvader.honkai@gmail.com', '59หมู่3', 'Gotvaderz', '$2y$10$IYCuFWLRiG2gQQhO9gLImuPFocVXntbZOT9v.B2ijX40VlCt.Mzqy', '2024-12-05 05:58:37', '2024-12-05 05:58:37', 'admin', 'สำนักปลัดเทศบาลเมือง', 'active'),
(29, 'Jesadapron', 'Pamornchum', '1213183818882', 'other', '2024-12-12', 'นักเรียน', '0867672572', 'got.jesadapron@gmail.com', 'พลัม', 'jesadapron', '$2y$10$bCAESEqRFRfrRBx8no5qWuTYx3JkqlRhi4HqOQBPITzt1Tk/FumuC', '2024-12-12 07:18:32', '2024-12-12 07:18:32', 'user', NULL, 'active'),
(33, 'Jesadapron', 'Pamornchum', '1234567890144', 'male', '2024-12-05', 'หมอ', '1234567894', 'got.jesadadfspron@gmail.com', 'บ้าร', 'admin2', '$2y$10$DBUetUGkY6IeVrNKs7ijaud/WcbASjf2cdU.FWNzLLPv4auyAxc42', '2024-12-12 07:25:13', '2024-12-12 07:25:13', 'admin', 'กองการศึกษา', 'active'),
(36, 'Sirawit', 'TOD', '2131231232137', 'male', '2024-12-17', 'sada', '0973195320', 'sad@gmail.com', 'd', 'sirawit', '$2y$10$LgsDE0xNmCATJskp1R9cNOT3URC95imnfbDlBguFCoQmr4s3AOeR.', '2024-12-17 13:05:44', '2024-12-17 13:05:44', 'user', NULL, 'active'),
(40, 'ชยพล', 'เมธาสิทธิกุล', '1439900442100', 'male', '2024-12-19', 'นักศึกษา', '0828665528', 'chayapon.meth@bu.ac.th', 'Bangkok University', 'chayapon', '$2y$10$.9emmKl1rIuk7kxiao2c.eVxYVci8uqjLJt07wfic6fafCgkXkM5m', '2024-12-19 03:29:52', '2024-12-19 03:29:52', 'user', NULL, 'active'),
(43, 'เจษฎาพร', 'ภมรฉ่ำ', '0950097648606', 'male', '0000-00-00', 'Test', '0828555555', 'gotvader.honkai@gmail.net', 'Tester', 'Tester', '$2y$10$YAZmgwb2jZ7TOlDwWiYfk.naVT/qGQzIx4PI8AVrLORJxP89Tm/aq', '2024-12-19 12:57:05', '2024-12-19 12:57:05', 'user', NULL, 'active'),
(48, 'Sirawit', 'Charoenpanich', '1439900439079', 'male', '2003-01-02', 'student', '0973195323', 'poohcha7992@gmail.net', '189', 'sirawit.char', '$2y$10$QMApSRQy/s9.i.SZ6AilGeTVmZCK93lz4r75tgm.t6FqpV6F65KUe', '2024-12-21 03:34:48', '2024-12-21 03:34:48', 'user', NULL, 'active'),
(51, 'Sirawit', 'Charoenpanich', '3417663323093', 'male', '2024-12-21', 'student', '0973195324', 'poohcha7992@bu.ac.th', 'KaveTown Space Building D Number 81/950\r\nถนนพหลโยธิน ต.คลองหนึ่ง อ.คลองหลวง จ.ปทุมธานี', 'sirawit.charo', '$2y$10$D8CGzQT7xup/zIZKoKY//uYEDE9MA8LO89YQy5V7eVcljYZvZo9EG', '2024-12-21 03:50:09', '2024-12-21 03:50:09', 'user', NULL, 'active'),
(58, 'Sirawit', 'Charoenpanich', '9389210018576', 'male', '2024-12-21', 'student', '0973195329', 'poohcha7992@gmail.k', '189', 'sirawit.charp', '$2y$10$CMAW.1N5lIw4ACu.nV/aROay6Qq.8obTwpaoeR6CEgpzyq5lV6tqG', '2024-12-21 04:00:39', '2024-12-21 04:00:39', 'user', NULL, 'active'),
(81, 'Sirawit', 'Charoenpanich', '0223155795440', 'male', '2024-12-21', 'student', '0973195325', 'poohcha7992@gmail.com', '189', 'sirawit.charoe', '$2y$10$7zx1W0I/LM6b22iEWpUOSuk1HsIwRL6IJYjH73PIS5NM6uwSxZ1ga', '2024-12-21 04:24:09', '2024-12-21 04:24:09', 'user', NULL, 'active'),
(82, 'thanachot', 'saetai', '3852852136331', 'male', '2025-01-16', 'เจ้าหน้าที่ เทศบาลเมือง', '0973191263', 'thanachot.sae@bumail.net', 'KaveTown Space Building D Number 81/9\r\nถนนพหลโยธิน ต.คลองหนึ่ง อ.คลองหลวง จ.ปทุมธานี', 'thanachot', '$2y$10$ut/eb22jN0UGHKVCC0c2ieK1W5YJQuqYF.9LV7PA/oM7EOafxPnSC', '2025-01-16 08:19:41', '2025-01-16 08:19:41', 'admin', 'สำนักปลัดเทศบาลเมือง', 'active'),
(83, 'Sirawit', 'Charoenpanich', '0131409487201', 'male', '2003-01-02', 'เจ้าหน้าที่', '0983195327', 'poohcha07992@gmail.com', 'KaveTown Space Building D Number 81/9500\r\nถนนพหลโยธิน ต.คลองหนึ่ง อ.คลองหลวง จ.ปทุมธานี', 'sirawit.admin', '$2y$10$JiI01Zg.KZmliBdR94AdoeaWUyQwu3gjvqJNUOVqTKY2CO7yNsdKm', '2025-01-16 08:26:53', '2025-01-16 08:26:53', 'admin', 'กองสวัสดิการสังคม', 'active'),
(84, 'pornchita', 'utalee', '2531217937147', 'female', '2002-06-15', 'student', '0818726147', 'pornchita.u@kkumail.com', 'KaveTown Space Building D Number 81/950\r\nถนนพหลโยธิน ต.คลองหนึ่ง อ.คลองหลวง จ.ปทุมธานี', 'pornchita', '$2y$10$SZeufQ3vYNzpkKwU/Nh9/eB.kc7PsYsaYTwIIur2BQJPf9JuiyTBe', '2025-03-20 00:17:02', '2025-03-20 00:24:21', 'user', NULL, 'deactivated');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`user_id`,`timestamp`);

--
-- Indexes for table `appeals`
--
ALTER TABLE `appeals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`department`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department` (`department`),
  ADD KEY `fk_user_id` (`user_id`) USING BTREE;

--
-- Indexes for table `contact_table`
--
ALTER TABLE `contact_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_change_logs`
--
ALTER TABLE `status_change_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fk_complant_id` (`id`),
  ADD KEY `changed_by` (`changed_by`),
  ADD KEY `idx_complaint_id` (`complaint_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `id_number` (`id_number`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `department` (`department`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appeals`
--
ALTER TABLE `appeals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact_table`
--
ALTER TABLE `contact_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `status_change_logs`
--
ALTER TABLE `status_change_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `status_change_logs`
--
ALTER TABLE `status_change_logs`
  ADD CONSTRAINT `fk_changed_by` FOREIGN KEY (`changed_by`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
