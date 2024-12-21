-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2024 at 07:38 PM
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
-- Database: `web_appeal_db`
--
CREATE DATABASE IF NOT EXISTS `web_appeal_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `web_appeal_db`;

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
(1, 40, 'test', 'test', 'test', 'test', 13.811, 99.8756, '2024-12-21', '01:28:00', 'เร่งด่วน', 'เทศบาลเมือง', 'test', '', '2024-12-20 18:29:06', 'กำลังดำเนินการ', 'ไม่มีหมายเหตุ', '');

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
  `contacted_back` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_table`
--

INSERT INTO `contact_table` (`id`, `name`, `contact`, `message`, `submitted_at`, `contacted_back`) VALUES
(1, 'Sirawit Charoenpanich', '', '1111', '2024-12-03 15:32:38', 0),
(2, 'Sirawit Charoenpanich', '', '1111', '2024-12-03 15:34:20', 0),
(3, 'Sirawit Charoenpanich', '', 'ddd', '2024-12-03 15:35:31', 1),
(4, 'Sirawit', '', 'ggggg', '2024-12-03 15:36:11', 0),
(5, 'เจษฎาพร ภมรฉ่ำ', '', 'อยากติดต่อเป็นการส่วนตัวกับหน่วยงานช่าง', '2024-12-19 02:32:11', 1),
(6, 'เจษฎาพร ภมรฉ่ำ', '', 'กกก', '2024-12-19 08:49:23', 0),
(7, 'ชยพล เมธาสิทธิกุล', '0828665528', 'Test', '2024-12-19 09:29:39', 0);

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
(3, 119, 'ยังไม่ดำเนินการ', 'ดำเนินการเสร็จสิ้น', 11, '2024-12-21 01:34:16');

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
  `email` varchar(100) DEFAULT NULL,
  `address` text NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` enum('admin','user') DEFAULT 'user',
  `department` enum('เทศบาลเมือง','สำนักปลัดเทศบาลเมือง','กองคลัง','กองช่าง','กองการศึกษา','กองสาธารณสุข','กองสวัสดิการสังคม','กองยุทธศาสตร์','กองการเจ้าหน้าที่','หน่วยตรวจสอบภายใน','หน่วยงานอื่นๆ') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `id_number`, `gender`, `birth_date`, `occupation`, `phone`, `email`, `address`, `username`, `password`, `created_at`, `updated_at`, `role`, `department`) VALUES
(4, 'Sirawit', 'Charoenpanich', '2131231232131', 'male', '2024-11-25', 'sada', '1213123213', 'poohcha7992@gmail.com', 'dasdsad', 'main', '$2y$10$w4D1uxWtVgTvgErDuHMCVOc1p4Ch6nMX97ABJXYSBGgsSqsDFZguK', '2024-11-25 16:56:56', '2024-11-27 02:06:44', 'admin', 'กองสาธารณสุข'),
(11, 'Sirawit', 'Charoenpanich', '2131231232187', 'male', '2024-11-27', 'sadas', '0973195322', 'poohcha72@gmail.com', 'a', 'admin', '$2y$10$GZs2TMCESiYmwFc82iucnOecg7PmKPrur8j4tknuSTcm/bmdmmv6W', '2024-11-26 09:45:15', '2024-11-27 01:41:54', 'admin', 'กองคลัง'),
(13, '', '', '1234567890123', 'male', '2024-11-06', NULL, '', NULL, '', 'phet', '$2y$10$x8ryZZWYR00PL4fm9KfabO8tTt1sLL5iQnsFCrStd1KCyOLjUlocW', '2024-11-27 13:12:37', '2024-12-03 22:16:47', 'user', NULL),
(18, 'chakkapong inwza', 'pattana', '1234567890125', 'male', '2024-11-06', 'dddd', '0973195327', 'sadd@gmail.com', 'dddddd', 'phetza', '$2y$10$hhTEuE4ogvqLQgGW9mkRUuHnmJA9JL.hr4GS4c2e3d3Aa1Owf5DbG', '2024-11-27 13:19:05', '2024-11-27 13:19:05', 'admin', 'กองการเจ้าหน้าที่'),
(19, 'อัญนา', 'วิชยประเสริฐกุล', '1568294991222', 'other', '2010-01-04', 'หมอ', '0904145645', 'vajoma1111@ikowat.com', 'บ้านโปง', 'autya', '$2y$10$7V7Z93/XNj/HcfasaRTsMe7jwm1nBn2x2bOwkISgM2po5CX.dbp9.', '2024-12-04 22:45:03', '2024-12-04 22:45:03', 'user', NULL),
(20, 'ธิศา', 'สันติสุข', '1458129201911', 'female', '2003-02-05', 'ชาวนา', '0908448298', 'wanibom846@jonespal.com', '59หมู่3', 'thida', '$2y$10$lQ7XHmFEQWSzwKWr1/wkQu2cAgf3w0fbNpTgf7sCuMmUY3rh1ek82', '2024-12-04 23:11:00', '2024-12-04 23:11:00', 'user', NULL),
(21, 'คัทลียา', 'เกียรติโกศล', '1341245664378', 'other', '1998-06-09', 'ค้าขาย', '0868843428', 'kesebi3072@bflcafe.com', 'ซอย7', 'catli', '$2y$10$zjeP4qDLt8fqEII.q8NILObcHVDe2tLCzur2by53.wlfKYv1a5PFa', '2024-12-04 23:25:46', '2024-12-04 23:25:46', 'user', NULL),
(22, 'บวรวิทย์', 'เพชรประเสริฐ', '1645728881122', 'male', '2000-06-15', 'ช่างตัดผม', '0901421552', 'pdt81366@inohm.com', '37/5ซอย10', 'Bawonwit', '$2y$10$aiD5cHNixHq6p0TjpHBHi.3gf3h29ocUOYiVf6ChskhmSHeBqoYTe', '2024-12-04 23:44:24', '2024-12-04 23:44:24', 'user', NULL),
(23, 'ถิรพุทธ', 'ตรีพงศ์สกุล', '173912842112', 'male', '2001-06-05', 'ชาวไล่', '0627182842', 'lft43724@inohm.com', '68หมู่2', 'Tiraput', '$2y$10$/A.8VZtYFrAQ8Xggh7tsWO8ovlI2tvPwGQGDYD4NnmT5YrTG85dwa', '2024-12-04 23:57:55', '2024-12-04 23:57:55', 'user', NULL),
(24, 'วิสาข์', 'รัตนพิรมย์', '1645529235812', 'female', '2001-06-05', 'ค้าขาย', '0901421554', 'vjl88622@kisoq.com', 'หมู่4', 'Wisa', '$2y$10$Imq/un0Zjg83uVkshcg4Qew8aZEs/mMsesa97v0Vr8IxsXyOX1xja', '2024-12-05 00:21:41', '2024-12-05 00:21:41', 'user', NULL),
(25, 'จารวี', 'โตศิลา', '1547262716272', 'other', '2024-12-05', 'ค้าขาย', '0920812882', 'kesebi30722@bflcafe.com', 'บ้านโป่ง', 'Jarawee', '$2y$10$xCVdJ6iAaj7k6SnmFv27PuY.j2tDYS78M.hEZPWQT/ts79lnq4ULC', '2024-12-05 03:25:25', '2024-12-05 03:25:25', 'user', NULL),
(26, 'กลอน', 'ปิติโอภาสพงศ์', '1739300002141', 'other', '2024-12-05', 'ชาวนา', '0908448254', 'kesebi301272@bflcafe.com', 'บ้านโป่ง', 'Klon', '$2y$10$9p2.dUXktBO//sK/BILBhOu2elN0Z45w1i3E2x5BQ7m.lrj/P0PmG', '2024-12-05 03:31:03', '2024-12-05 03:31:03', 'user', NULL),
(27, 'เจษฎาพร', 'ภมรฉ่ำ', '1640705156', 'male', '2002-09-05', 'นักศึกษา', '0867672552', 'jesadapron.pamo@bumail.net', 'พลัมอไลฟ์1ตึกA', 'GotVader', '$2y$10$wdq.eN3OlpSSIn.JtFPlYuyABnC5Umer6yGXuGOFXTvwd4vQHQUhS', '2024-12-05 05:43:48', '2024-12-05 05:43:48', 'user', NULL),
(28, 'Got', 'Vader', '1739300006472', 'male', '2024-11-14', 'admin', '0867672553', 'gotvader.honkai@gmail.com', '59หมู่3', 'Gotvaderz', '$2y$10$IYCuFWLRiG2gQQhO9gLImuPFocVXntbZOT9v.B2ijX40VlCt.Mzqy', '2024-12-05 05:58:37', '2024-12-05 05:58:37', 'admin', 'สำนักปลัดเทศบาลเมือง'),
(29, 'Jesadapron', 'Pamornchum', '1213183818882', 'other', '2024-12-12', 'นักเรียน', '0867672572', 'got.jesadapron@gmail.com', 'พลัม', 'jesadapron', '$2y$10$bCAESEqRFRfrRBx8no5qWuTYx3JkqlRhi4HqOQBPITzt1Tk/FumuC', '2024-12-12 07:18:32', '2024-12-12 07:18:32', 'user', NULL),
(33, 'Jesadapron', 'Pamornchum', '1234567890144', 'male', '2024-12-05', 'หมอ', '1234567894', 'got.jesadadfspron@gmail.com', 'บ้าร', 'admin2', '$2y$10$DBUetUGkY6IeVrNKs7ijaud/WcbASjf2cdU.FWNzLLPv4auyAxc42', '2024-12-12 07:25:13', '2024-12-12 07:25:13', 'admin', 'กองการศึกษา'),
(36, 'Sirawit', 'TOD', '2131231232137', 'male', '2024-12-17', 'sada', '0973195320', 'sad@gmail.com', 'd', 'sirawit', '$2y$10$LgsDE0xNmCATJskp1R9cNOT3URC95imnfbDlBguFCoQmr4s3AOeR.', '2024-12-17 13:05:44', '2024-12-17 13:05:44', 'user', NULL),
(40, 'ชยพล', 'เมธาสิทธิกุล', '1439900442100', 'male', '2024-12-19', 'นักศึกษา', '0828665528', 'chayapon.meth@bu.ac.th', 'Bangkok University', 'chayapon', '$2y$10$.9emmKl1rIuk7kxiao2c.eVxYVci8uqjLJt07wfic6fafCgkXkM5m', '2024-12-19 03:29:52', '2024-12-19 03:29:52', 'user', NULL),
(43, 'เจษฎาพร', 'ภมรฉ่ำ', '0950097648606', 'male', '0000-00-00', 'Test', '0828555555', 'gotvader.honkai@gmail.net', 'Tester', 'Tester', '$2y$10$YAZmgwb2jZ7TOlDwWiYfk.naVT/qGQzIx4PI8AVrLORJxP89Tm/aq', '2024-12-19 12:57:05', '2024-12-19 12:57:05', 'user', NULL);

--
-- Indexes for dumped tables
--

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
  ADD UNIQUE KEY `fk_complant_id_2` (`id`),
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
  ADD UNIQUE KEY `email` (`email`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_table`
--
ALTER TABLE `contact_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `status_change_logs`
--
ALTER TABLE `status_change_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `status_change_logs`
--
ALTER TABLE `status_change_logs`
  ADD CONSTRAINT `fk_changed_by` FOREIGN KEY (`changed_by`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
