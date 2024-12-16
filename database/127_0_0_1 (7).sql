-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2024 at 12:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

--
-- Dumping data for table `pma__export_templates`
--

INSERT INTO `pma__export_templates` (`id`, `username`, `export_type`, `template_name`, `template_data`) VALUES
(1, 'root', 'table', '1', '{\"quick_or_custom\":\"quick\",\"what\":\"sql\",\"allrows\":\"1\",\"aliases_new\":\"\",\"output_format\":\"sendit\",\"filename_template\":\"@TABLE@\",\"remember_template\":\"on\",\"charset\":\"utf-8\",\"compression\":\"none\",\"maxsize\":\"\",\"codegen_structure_or_data\":\"data\",\"codegen_format\":\"0\",\"csv_separator\":\",\",\"csv_enclosed\":\"\\\"\",\"csv_escaped\":\"\\\"\",\"csv_terminated\":\"AUTO\",\"csv_null\":\"NULL\",\"csv_columns\":\"something\",\"csv_structure_or_data\":\"data\",\"excel_null\":\"NULL\",\"excel_columns\":\"something\",\"excel_edition\":\"win\",\"excel_structure_or_data\":\"data\",\"json_structure_or_data\":\"data\",\"json_unicode\":\"something\",\"latex_caption\":\"something\",\"latex_structure_or_data\":\"structure_and_data\",\"latex_structure_caption\":\"Structure of table @TABLE@\",\"latex_structure_continued_caption\":\"Structure of table @TABLE@ (continued)\",\"latex_structure_label\":\"tab:@TABLE@-structure\",\"latex_relation\":\"something\",\"latex_comments\":\"something\",\"latex_mime\":\"something\",\"latex_columns\":\"something\",\"latex_data_caption\":\"Content of table @TABLE@\",\"latex_data_continued_caption\":\"Content of table @TABLE@ (continued)\",\"latex_data_label\":\"tab:@TABLE@-data\",\"latex_null\":\"\\\\textit{NULL}\",\"mediawiki_structure_or_data\":\"data\",\"mediawiki_caption\":\"something\",\"mediawiki_headers\":\"something\",\"htmlword_structure_or_data\":\"structure_and_data\",\"htmlword_null\":\"NULL\",\"ods_null\":\"NULL\",\"ods_structure_or_data\":\"data\",\"odt_structure_or_data\":\"structure_and_data\",\"odt_relation\":\"something\",\"odt_comments\":\"something\",\"odt_mime\":\"something\",\"odt_columns\":\"something\",\"odt_null\":\"NULL\",\"pdf_report_title\":\"\",\"pdf_structure_or_data\":\"data\",\"phparray_structure_or_data\":\"data\",\"sql_include_comments\":\"something\",\"sql_header_comment\":\"\",\"sql_use_transaction\":\"something\",\"sql_compatibility\":\"NONE\",\"sql_structure_or_data\":\"structure_and_data\",\"sql_create_table\":\"something\",\"sql_auto_increment\":\"something\",\"sql_create_view\":\"something\",\"sql_create_trigger\":\"something\",\"sql_backquotes\":\"something\",\"sql_type\":\"INSERT\",\"sql_insert_syntax\":\"both\",\"sql_max_query_size\":\"50000\",\"sql_hex_for_binary\":\"something\",\"sql_utc_time\":\"something\",\"texytext_structure_or_data\":\"structure_and_data\",\"texytext_null\":\"NULL\",\"xml_structure_or_data\":\"data\",\"xml_export_events\":\"something\",\"xml_export_functions\":\"something\",\"xml_export_procedures\":\"something\",\"xml_export_tables\":\"something\",\"xml_export_triggers\":\"something\",\"xml_export_views\":\"something\",\"xml_export_contents\":\"something\",\"yaml_structure_or_data\":\"data\",\"\":null,\"lock_tables\":null,\"csv_removeCRLF\":null,\"excel_removeCRLF\":null,\"json_pretty_print\":null,\"htmlword_columns\":null,\"ods_columns\":null,\"sql_dates\":null,\"sql_relation\":null,\"sql_mime\":null,\"sql_disable_fk\":null,\"sql_views_as_tables\":null,\"sql_metadata\":null,\"sql_drop_table\":null,\"sql_if_not_exists\":null,\"sql_simple_view_export\":null,\"sql_view_current_user\":null,\"sql_or_replace_view\":null,\"sql_procedure_function\":null,\"sql_truncate\":null,\"sql_delayed\":null,\"sql_ignore\":null,\"texytext_columns\":null}'),
(2, 'root', 'table', '2', '{\"quick_or_custom\":\"quick\",\"what\":\"sql\",\"allrows\":\"1\",\"aliases_new\":\"\",\"output_format\":\"sendit\",\"filename_template\":\"@TABLE@\",\"remember_template\":\"on\",\"charset\":\"utf-8\",\"compression\":\"none\",\"maxsize\":\"\",\"codegen_structure_or_data\":\"data\",\"codegen_format\":\"0\",\"csv_separator\":\",\",\"csv_enclosed\":\"\\\"\",\"csv_escaped\":\"\\\"\",\"csv_terminated\":\"AUTO\",\"csv_null\":\"NULL\",\"csv_columns\":\"something\",\"csv_structure_or_data\":\"data\",\"excel_null\":\"NULL\",\"excel_columns\":\"something\",\"excel_edition\":\"win\",\"excel_structure_or_data\":\"data\",\"json_structure_or_data\":\"data\",\"json_unicode\":\"something\",\"latex_caption\":\"something\",\"latex_structure_or_data\":\"structure_and_data\",\"latex_structure_caption\":\"Structure of table @TABLE@\",\"latex_structure_continued_caption\":\"Structure of table @TABLE@ (continued)\",\"latex_structure_label\":\"tab:@TABLE@-structure\",\"latex_relation\":\"something\",\"latex_comments\":\"something\",\"latex_mime\":\"something\",\"latex_columns\":\"something\",\"latex_data_caption\":\"Content of table @TABLE@\",\"latex_data_continued_caption\":\"Content of table @TABLE@ (continued)\",\"latex_data_label\":\"tab:@TABLE@-data\",\"latex_null\":\"\\\\textit{NULL}\",\"mediawiki_structure_or_data\":\"data\",\"mediawiki_caption\":\"something\",\"mediawiki_headers\":\"something\",\"htmlword_structure_or_data\":\"structure_and_data\",\"htmlword_null\":\"NULL\",\"ods_null\":\"NULL\",\"ods_structure_or_data\":\"data\",\"odt_structure_or_data\":\"structure_and_data\",\"odt_relation\":\"something\",\"odt_comments\":\"something\",\"odt_mime\":\"something\",\"odt_columns\":\"something\",\"odt_null\":\"NULL\",\"pdf_report_title\":\"\",\"pdf_structure_or_data\":\"data\",\"phparray_structure_or_data\":\"data\",\"sql_include_comments\":\"something\",\"sql_header_comment\":\"\",\"sql_use_transaction\":\"something\",\"sql_compatibility\":\"NONE\",\"sql_structure_or_data\":\"structure_and_data\",\"sql_create_table\":\"something\",\"sql_auto_increment\":\"something\",\"sql_create_view\":\"something\",\"sql_create_trigger\":\"something\",\"sql_backquotes\":\"something\",\"sql_type\":\"INSERT\",\"sql_insert_syntax\":\"both\",\"sql_max_query_size\":\"50000\",\"sql_hex_for_binary\":\"something\",\"sql_utc_time\":\"something\",\"texytext_structure_or_data\":\"structure_and_data\",\"texytext_null\":\"NULL\",\"xml_structure_or_data\":\"data\",\"xml_export_events\":\"something\",\"xml_export_functions\":\"something\",\"xml_export_procedures\":\"something\",\"xml_export_tables\":\"something\",\"xml_export_triggers\":\"something\",\"xml_export_views\":\"something\",\"xml_export_contents\":\"something\",\"yaml_structure_or_data\":\"data\",\"\":null,\"lock_tables\":null,\"csv_removeCRLF\":null,\"excel_removeCRLF\":null,\"json_pretty_print\":null,\"htmlword_columns\":null,\"ods_columns\":null,\"sql_dates\":null,\"sql_relation\":null,\"sql_mime\":null,\"sql_disable_fk\":null,\"sql_views_as_tables\":null,\"sql_metadata\":null,\"sql_drop_table\":null,\"sql_if_not_exists\":null,\"sql_simple_view_export\":null,\"sql_view_current_user\":null,\"sql_or_replace_view\":null,\"sql_procedure_function\":null,\"sql_truncate\":null,\"sql_delayed\":null,\"sql_ignore\":null,\"texytext_columns\":null}'),
(3, 'root', 'table', '3', '{\"quick_or_custom\":\"quick\",\"what\":\"sql\",\"allrows\":\"1\",\"aliases_new\":\"\",\"output_format\":\"sendit\",\"filename_template\":\"@TABLE@\",\"remember_template\":\"on\",\"charset\":\"utf-8\",\"compression\":\"none\",\"maxsize\":\"\",\"codegen_structure_or_data\":\"data\",\"codegen_format\":\"0\",\"csv_separator\":\",\",\"csv_enclosed\":\"\\\"\",\"csv_escaped\":\"\\\"\",\"csv_terminated\":\"AUTO\",\"csv_null\":\"NULL\",\"csv_columns\":\"something\",\"csv_structure_or_data\":\"data\",\"excel_null\":\"NULL\",\"excel_columns\":\"something\",\"excel_edition\":\"win\",\"excel_structure_or_data\":\"data\",\"json_structure_or_data\":\"data\",\"json_unicode\":\"something\",\"latex_caption\":\"something\",\"latex_structure_or_data\":\"structure_and_data\",\"latex_structure_caption\":\"Structure of table @TABLE@\",\"latex_structure_continued_caption\":\"Structure of table @TABLE@ (continued)\",\"latex_structure_label\":\"tab:@TABLE@-structure\",\"latex_relation\":\"something\",\"latex_comments\":\"something\",\"latex_mime\":\"something\",\"latex_columns\":\"something\",\"latex_data_caption\":\"Content of table @TABLE@\",\"latex_data_continued_caption\":\"Content of table @TABLE@ (continued)\",\"latex_data_label\":\"tab:@TABLE@-data\",\"latex_null\":\"\\\\textit{NULL}\",\"mediawiki_structure_or_data\":\"data\",\"mediawiki_caption\":\"something\",\"mediawiki_headers\":\"something\",\"htmlword_structure_or_data\":\"structure_and_data\",\"htmlword_null\":\"NULL\",\"ods_null\":\"NULL\",\"ods_structure_or_data\":\"data\",\"odt_structure_or_data\":\"structure_and_data\",\"odt_relation\":\"something\",\"odt_comments\":\"something\",\"odt_mime\":\"something\",\"odt_columns\":\"something\",\"odt_null\":\"NULL\",\"pdf_report_title\":\"\",\"pdf_structure_or_data\":\"data\",\"phparray_structure_or_data\":\"data\",\"sql_include_comments\":\"something\",\"sql_header_comment\":\"\",\"sql_use_transaction\":\"something\",\"sql_compatibility\":\"NONE\",\"sql_structure_or_data\":\"structure_and_data\",\"sql_create_table\":\"something\",\"sql_auto_increment\":\"something\",\"sql_create_view\":\"something\",\"sql_create_trigger\":\"something\",\"sql_backquotes\":\"something\",\"sql_type\":\"INSERT\",\"sql_insert_syntax\":\"both\",\"sql_max_query_size\":\"50000\",\"sql_hex_for_binary\":\"something\",\"sql_utc_time\":\"something\",\"texytext_structure_or_data\":\"structure_and_data\",\"texytext_null\":\"NULL\",\"xml_structure_or_data\":\"data\",\"xml_export_events\":\"something\",\"xml_export_functions\":\"something\",\"xml_export_procedures\":\"something\",\"xml_export_tables\":\"something\",\"xml_export_triggers\":\"something\",\"xml_export_views\":\"something\",\"xml_export_contents\":\"something\",\"yaml_structure_or_data\":\"data\",\"\":null,\"lock_tables\":null,\"csv_removeCRLF\":null,\"excel_removeCRLF\":null,\"json_pretty_print\":null,\"htmlword_columns\":null,\"ods_columns\":null,\"sql_dates\":null,\"sql_relation\":null,\"sql_mime\":null,\"sql_disable_fk\":null,\"sql_views_as_tables\":null,\"sql_metadata\":null,\"sql_drop_table\":null,\"sql_if_not_exists\":null,\"sql_simple_view_export\":null,\"sql_view_current_user\":null,\"sql_or_replace_view\":null,\"sql_procedure_function\":null,\"sql_truncate\":null,\"sql_delayed\":null,\"sql_ignore\":null,\"texytext_columns\":null}'),
(4, 'root', 'server', '01', '{\"quick_or_custom\":\"quick\",\"what\":\"sql\",\"db_select[]\":[\"phpmyadmin\",\"test\",\"web_appeal_db\"],\"aliases_new\":\"\",\"output_format\":\"sendit\",\"filename_template\":\"@SERVER@\",\"remember_template\":\"on\",\"charset\":\"utf-8\",\"compression\":\"none\",\"maxsize\":\"\",\"codegen_structure_or_data\":\"data\",\"codegen_format\":\"0\",\"csv_separator\":\",\",\"csv_enclosed\":\"\\\"\",\"csv_escaped\":\"\\\"\",\"csv_terminated\":\"AUTO\",\"csv_null\":\"NULL\",\"csv_columns\":\"something\",\"csv_structure_or_data\":\"data\",\"excel_null\":\"NULL\",\"excel_columns\":\"something\",\"excel_edition\":\"win\",\"excel_structure_or_data\":\"data\",\"json_structure_or_data\":\"data\",\"json_unicode\":\"something\",\"latex_caption\":\"something\",\"latex_structure_or_data\":\"structure_and_data\",\"latex_structure_caption\":\"Structure of table @TABLE@\",\"latex_structure_continued_caption\":\"Structure of table @TABLE@ (continued)\",\"latex_structure_label\":\"tab:@TABLE@-structure\",\"latex_relation\":\"something\",\"latex_comments\":\"something\",\"latex_mime\":\"something\",\"latex_columns\":\"something\",\"latex_data_caption\":\"Content of table @TABLE@\",\"latex_data_continued_caption\":\"Content of table @TABLE@ (continued)\",\"latex_data_label\":\"tab:@TABLE@-data\",\"latex_null\":\"\\\\textit{NULL}\",\"mediawiki_structure_or_data\":\"data\",\"mediawiki_caption\":\"something\",\"mediawiki_headers\":\"something\",\"htmlword_structure_or_data\":\"structure_and_data\",\"htmlword_null\":\"NULL\",\"ods_null\":\"NULL\",\"ods_structure_or_data\":\"data\",\"odt_structure_or_data\":\"structure_and_data\",\"odt_relation\":\"something\",\"odt_comments\":\"something\",\"odt_mime\":\"something\",\"odt_columns\":\"something\",\"odt_null\":\"NULL\",\"pdf_report_title\":\"\",\"pdf_structure_or_data\":\"data\",\"phparray_structure_or_data\":\"data\",\"sql_include_comments\":\"something\",\"sql_header_comment\":\"\",\"sql_use_transaction\":\"something\",\"sql_compatibility\":\"NONE\",\"sql_structure_or_data\":\"structure_and_data\",\"sql_create_table\":\"something\",\"sql_auto_increment\":\"something\",\"sql_create_view\":\"something\",\"sql_create_trigger\":\"something\",\"sql_backquotes\":\"something\",\"sql_type\":\"INSERT\",\"sql_insert_syntax\":\"both\",\"sql_max_query_size\":\"50000\",\"sql_hex_for_binary\":\"something\",\"sql_utc_time\":\"something\",\"texytext_structure_or_data\":\"structure_and_data\",\"texytext_null\":\"NULL\",\"yaml_structure_or_data\":\"data\",\"\":null,\"as_separate_files\":null,\"csv_removeCRLF\":null,\"excel_removeCRLF\":null,\"json_pretty_print\":null,\"htmlword_columns\":null,\"ods_columns\":null,\"sql_dates\":null,\"sql_relation\":null,\"sql_mime\":null,\"sql_disable_fk\":null,\"sql_views_as_tables\":null,\"sql_metadata\":null,\"sql_drop_database\":null,\"sql_drop_table\":null,\"sql_if_not_exists\":null,\"sql_simple_view_export\":null,\"sql_view_current_user\":null,\"sql_or_replace_view\":null,\"sql_procedure_function\":null,\"sql_truncate\":null,\"sql_delayed\":null,\"sql_ignore\":null,\"texytext_columns\":null}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Dumping data for table `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"web_appeal_db\",\"table\":\"complaints\"},{\"db\":\"test\",\"table\":\"complaints\"},{\"db\":\"test\",\"table\":\"appeals\"},{\"db\":\"web_appeal_db\",\"table\":\"appeals\"},{\"db\":\"web_appeal_db\",\"table\":\"contact_table\"},{\"db\":\"web_appeal_db\",\"table\":\"user\"},{\"db\":\"test\",\"table\":\"user\"},{\"db\":\"web_appeal_db\",\"table\":\"status_change_logs\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2024-12-06 11:14:11', '{\"Console\\/Mode\":\"collapse\"}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;

-- --------------------------------------------------------

--
-- Table structure for table `appeals`
--

CREATE TABLE `appeals` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `report_subject` varchar(255) NOT NULL,
  `report_person` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(15) NOT NULL,
  `contact_location` varchar(255) DEFAULT NULL,
  `contact_details` text DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `incident_date` date DEFAULT NULL,
  `incident_time` time DEFAULT NULL,
  `problem_level` varchar(50) DEFAULT NULL,
  `department` enum('เทศบาลเมือง','สำนักปลัดเทศบาลเมือง','กองคลัง','กองช่าง','กองการศึกษา','กองสาธารณสุข','กองสวัสดิการสังคม','กองยุทธศาสตร์','กองการเจ้าหน้าที่','หน่วยตรวจสอบภายใน','หน่วยงานอื่นๆ') DEFAULT NULL,
  `complaint_description` text DEFAULT NULL,
  `complaint_file` longblob DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('ยังไม่ดำเนินการ','กำลังดำเนินการ','ดำเนินการเสร็จสิ้น') DEFAULT 'ยังไม่ดำเนินการ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appeals`
--

INSERT INTO `appeals` (`id`, `user_id`, `report_subject`, `report_person`, `contact_phone`, `contact_location`, `contact_details`, `latitude`, `longitude`, `incident_date`, `incident_time`, `problem_level`, `department`, `complaint_description`, `complaint_file`, `submitted_at`, `status`) VALUES
(4, 29, 'เจ้าหน้าที่ดูเหมือนจะมีการข่มขู่ประชาชน', 'หน่วยงานที่มาจัดระเบียบตลาด', '0809712342', 'ตลาดนัดวัดพล', 'ตลาดนัดวัดพลช่วงเช้า', 13.7367, 100.523, '2024-12-05', '07:19:00', 'ปานกลาง', 'หน่วยตรวจสอบภายใน', 'เจ้าหน้าที่ดูเหมือนจะมีการข่มขู่ประชาชน', '', '2024-12-05 07:19:31', 'ยังไม่ดำเนินการ'),
(5, 30, 'เจ้าหน้าที่ขโมยของ', 'หน่วยช่อง', '0981726212', 'บ้านเลขที่59หมู่3', 'บ้านที่ช่างเข้ามาเช็คไฟ', 13.7367, 100.523, '2024-12-06', '14:39:00', 'ปานกลาง', 'หน่วยตรวจสอบภายใน', 'หลังจากช่างเข้ามาแก้ไขไฟได้มีของหาย', '', '2024-12-05 07:39:36', 'ยังไม่ดำเนินการ'),
(6, 31, 'เจ้าหน้าที่รับของไปแล้วไม่นำไปแจก', 'เจ้าหน้าที่จิตอาสาของเทศบาล', '0943583488', 'เทศบาล', 'เทศบาล', 13.6495, 100.832, '2024-12-05', '18:29:00', 'ต่ำ', 'เทศบาลเมือง', 'เจ้าหน้าที่รับของไปแล้วไม่นำไปแจก', '', '2024-12-05 10:30:02', 'ยังไม่ดำเนินการ'),
(7, 32, 'เจ้าหน้าที่ดูมีส่วนร่วมกับบ่อพนัน', 'ปลัด', '0867762542', 'บ้านยายยุ้ย', 'หลังบ้านยายยุ้ย', 13.5938, 101.118, '2024-12-05', '19:34:00', 'ต่ำ', 'หน่วยตรวจสอบภายใน', 'เห็นปลัดเล่นพนันและรับสินบนจากบ่อน', '', '2024-12-05 10:34:56', 'ยังไม่ดำเนินการ'),
(8, 33, 'ของหาย', 'เจ้าหน้าที่ที่เข้ามาปฎิบัติงาน', '0867672552', '59หมู่3', 'บ้านเลขที่59หมู่3', 13.7293, 100.536, '2024-12-05', '20:51:00', 'ปานกลาง', 'เทศบาลเมือง', 'เจ้าหน้าที่เข้ามาปฎิบัติงานภายในบ้านเลขที่ 59หมู่3แล้วของหาย', '', '2024-12-05 12:51:50', 'ยังไม่ดำเนินการ'),
(9, 29, 'เจ้าหน้าที่ดูเหมือนจะมีการข่มขู่ประชาชน', 'หน่วยงานที่มาจัดระเบียบตลาด', '0809712342', 'ตลาดนัดวัดพล', 'ตลาดนัดวัดพลช่วงเช้า', 13.7367, 100.523, '2024-12-05', '07:19:00', 'ปานกลาง', 'หน่วยตรวจสอบภายใน', 'เจ้าหน้าที่ดูเหมือนจะมีการข่มขู่ประชาชน', NULL, '2024-12-05 07:19:31', 'ยังไม่ดำเนินการ'),
(10, 31, 'เจ้าหน้าที่รับของไปแล้วไม่นำไปแจก', 'เจ้าหน้าที่จิตอาสาของเทศบาล', '0943583488', 'เทศบาล', 'เทศบาล', 13.6495, 100.832, '2024-12-05', '18:29:00', 'ต่ำ', 'เทศบาลเมือง', 'เจ้าหน้าที่รับของไปแล้วไม่นำไปแจก', NULL, '2024-12-05 10:30:02', 'ยังไม่ดำเนินการ'),
(11, 32, 'เจ้าหน้าที่ดูมีส่วนร่วมกับบ่อพนัน', 'ปลัด', '0867762542', 'บ้านยายยุ้ย', 'หลังบ้านยายยุ้ย', 13.5938, 101.118, '2024-12-05', '19:34:00', 'ต่ำ', 'หน่วยตรวจสอบภายใน', 'เห็นปลัดเล่นพนันและรับสินบนจากบ่อน', NULL, '2024-12-05 10:34:56', 'ยังไม่ดำเนินการ'),
(12, 33, 'ของหาย', 'เจ้าหน้าที่ที่เข้ามาปฎิบัติงาน', '0867672552', '59หมู่3', 'บ้านเลขที่59หมู่3', 13.7293, 100.536, '2024-12-05', '20:51:00', 'ปานกลาง', 'เทศบาลเมือง', 'เจ้าหน้าที่เข้ามาปฎิบัติงานภายในบ้านเลขที่ 59หมู่3แล้วของหาย', NULL, '2024-12-05 12:51:50', 'ยังไม่ดำเนินการ'),
(13, 29, 'เจ้าหน้าที่ดูเหมือนจะมีการข่มขู่ประชาชน', 'หน่วยงานที่มาจัดระเบียบตลาด', '0809712342', 'ตลาดนัดวัดพล', 'ตลาดนัดวัดพลช่วงเช้า', 13.7367, 100.523, '2024-12-05', '07:19:00', 'ปานกลาง', 'หน่วยตรวจสอบภายใน', 'เจ้าหน้าที่ดูเหมือนจะมีการข่มขู่ประชาชน', NULL, '2024-12-05 07:19:31', 'ยังไม่ดำเนินการ'),
(14, 31, 'เจ้าหน้าที่รับของไปแล้วไม่นำไปแจก', 'เจ้าหน้าที่จิตอาสาของเทศบาล', '0943583488', 'เทศบาล', 'เทศบาล', 13.6495, 100.832, '2024-12-05', '18:29:00', 'ต่ำ', 'เทศบาลเมือง', 'เจ้าหน้าที่รับของไปแล้วไม่นำไปแจก', NULL, '2024-12-05 10:30:02', 'ยังไม่ดำเนินการ'),
(15, 32, 'เจ้าหน้าที่ดูมีส่วนร่วมกับบ่อพนัน', 'ปลัด', '0867762542', 'บ้านยายยุ้ย', 'หลังบ้านยายยุ้ย', 13.5938, 101.118, '2024-12-05', '19:34:00', 'ต่ำ', 'หน่วยตรวจสอบภายใน', 'เห็นปลัดเล่นพนันและรับสินบนจากบ่อน', NULL, '2024-12-05 10:34:56', 'ยังไม่ดำเนินการ'),
(16, 33, 'ของหาย', 'เจ้าหน้าที่ที่เข้ามาปฎิบัติงาน', '0867672552', '59หมู่3', 'บ้านเลขที่59หมู่3', 13.7293, 100.536, '2024-12-05', '20:51:00', 'ปานกลาง', 'เทศบาลเมือง', 'เจ้าหน้าที่เข้ามาปฎิบัติงานภายในบ้านเลขที่ 59หมู่3แล้วของหาย', NULL, '2024-12-05 12:51:50', 'ยังไม่ดำเนินการ'),
(17, 29, 'เจ้าหน้าที่ดูเหมือนจะมีการข่มขู่ประชาชน', 'หน่วยงานที่มาจัดระเบียบตลาด', '0809712342', 'ตลาดนัดวัดพล', 'ตลาดนัดวัดพลช่วงเช้า', 13.7367, 100.523, '2024-12-05', '07:19:00', 'ปานกลาง', 'หน่วยตรวจสอบภายใน', 'เจ้าหน้าที่ดูเหมือนจะมีการข่มขู่ประชาชน', NULL, '2024-12-05 07:19:31', 'ยังไม่ดำเนินการ');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `complaint_subject` varchar(255) NOT NULL,
  `contact_phone` varchar(15) NOT NULL,
  `contact_location` varchar(255) DEFAULT NULL,
  `contact_details` text DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `incident_date` date DEFAULT NULL,
  `incident_time` time DEFAULT NULL,
  `problem_level` varchar(50) DEFAULT NULL,
  `department` enum('เทศบาลเมือง','สำนักปลัดเทศบาลเมือง','กองคลัง','กองช่าง','กองการศึกษา','กองสาธารณสุข','กองสวัสดิการสังคม','กองยุทธศาสตร์','กองการเจ้าหน้าที่','หน่วยตรวจสอบภายใน','หน่วยงานอื่นๆ') DEFAULT NULL,
  `complaint_description` text DEFAULT NULL,
  `complaint_file` longblob DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('ยังไม่ดำเนินการ','กำลังดำเนินการ','ดำเนินการเสร็จสิ้น') DEFAULT 'ยังไม่ดำเนินการ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `user_id`, `complaint_subject`, `contact_phone`, `contact_location`, `contact_details`, `latitude`, `longitude`, `incident_date`, `incident_time`, `problem_level`, `department`, `complaint_description`, `complaint_file`, `submitted_at`, `status`) VALUES
(89, 25, 'ืท่อแตก', '0904145645', 'หน้าบ้านผู้ใหญ่ศรี', 'หน้าบ้านตรงปากคลอง', 13.7367, 100.523, '2024-12-04', '00:47:00', 'ปานกลาง', 'เทศบาลเมือง', 'ท่อปะปาแตก', 0x75706c6f6164732fe0b897e0b988e0b8ad2e6a7067, '2024-12-05 05:51:01', 'ยังไม่ดำเนินการ'),
(90, 26, 'ไฟถนนเสีย', '0908448298', 'คลอง1', 'คลอง1กลางคลองไฟเสีย', 13.7367, 100.523, '2024-08-07', '21:12:00', 'ต่ำ', 'เทศบาลเมือง', 'ไฟมันเสียมานานแล้ว ช่วยเข้ามาเปลี่ยนไฟให้หน่อย', 0x75706c6f6164732fe0b984e0b89f2e6a7067, '2024-12-05 06:13:36', 'ยังไม่ดำเนินการ'),
(91, 27, 'ไฟขยะ', '0868843428', 'หมู่3', 'นาของตาสิง', 13.7367, 100.523, '2024-12-05', '03:33:00', 'เร่งด่วน', 'เทศบาลเมือง', 'มีคนแอบจุดไฟใกล้นา ไฟอาจจะลามไหม้นา', '', '2024-12-05 06:34:17', 'ยังไม่ดำเนินการ'),
(92, 28, 'ขยะส่งกลิ่นเหม็น', '0901421552', 'วัดชมภูพล', 'ขยะหน้าวัดส่งกลิ่นเหม็น', 13.3473, 100.963, '2024-08-09', '15:46:00', 'ต่ำ', 'เทศบาลเมือง', 'ช่วยส่งรถมาเก็บขยะไปหน่อย', '', '2024-12-05 06:46:54', 'ยังไม่ดำเนินการ'),
(93, 24, 'ท่อแตก', '0921241252', 'ซอย3', 'บ้านตาลือ', 13.7367, 100.523, '2024-12-05', '13:50:00', 'ต่ำ', 'กองช่าง', 'ท่อประปาแตก', 0x75706c6f6164732fe0b897e0b988e0b8ad2e6a7067, '2024-12-05 06:53:35', 'ยังไม่ดำเนินการ'),
(94, 29, 'มีเหตุรถชนกัน', '0627182842', 'วัดบัว', 'สะพานลอยหน้าวัดบัว', 13.3971, 100.307, '2024-10-10', '14:00:00', 'เร่งด่วน', 'กองสาธารณสุข', 'ต้องการรถพยาบาลด่วน', '', '2024-12-05 07:01:11', 'ยังไม่ดำเนินการ'),
(95, 30, 'ไฟดับ', '0973513134', 'บ้าน', 'บ้านเลขที่59หมู่3', 13.711, 100.489, '2024-12-05', '08:37:00', 'ต่ำ', 'กองช่าง', 'ช่วยมาเช็คไฟให้หน่อย', '', '2024-12-05 07:37:47', 'ยังไม่ดำเนินการ'),
(96, 31, 'ถังขยะหาย', '0959023949', 'หมู่บ้านไทยทศ', 'ถังขยะหน้าหมู่บ้านหาย', 13.7367, 100.523, '2024-12-05', '17:27:00', 'ต่ำ', 'กองคลัง', 'ถังขยะหาย รบกวนเอาถังขยะใหม่มาวางไว้ให้หน่อย', '', '2024-12-05 10:27:53', 'ยังไม่ดำเนินการ'),
(97, 32, 'ห้อแปลงระเบิด', '0923422452', 'หมู่บ้านไททศ', 'หมู่บ้านไททศ ซอย10', 13.7539, 100.466, '2024-12-05', '17:31:00', 'ต่ำ', 'กองช่าง', 'ตรวจสอบหม้อแปลง', '', '2024-12-05 10:32:18', 'ยังไม่ดำเนินการ'),
(98, 33, 'น้ำไม่ไหล', '0867672552', 'บ้าน', '59หมู่3', 13.8509, 100.219, '2024-12-05', '19:47:00', 'ต่ำ', 'เทศบาลเมือง', 'เช็คเครื่องปั้มน้ำ', 0x75706c6f6164732fe0b897e0b988e0b8ad2e6a7067, '2024-12-05 12:48:43', 'ยังไม่ดำเนินการ'),
(99, 29, 'มีเหตุรถชนกัน', '0627182842', 'วัดบัว', 'สะพานลอยหน้าวัดบัว', 13.3971, 100.307, '2024-10-10', '14:00:00', 'เร่งด่วน', 'กองสาธารณสุข', 'ต้องการรถพยาบาลด่วน', NULL, '2024-12-05 07:01:11', 'ยังไม่ดำเนินการ'),
(100, 29, 'มีเหตุรถชนกัน', '0627182842', 'วัดบัว', 'สะพานลอยหน้าวัดบัว', 13.3971, 100.307, '2024-10-10', '14:00:00', 'เร่งด่วน', 'กองสาธารณสุข', 'ต้องการรถพยาบาลด่วน', NULL, '2024-12-05 07:01:11', 'ยังไม่ดำเนินการ');

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
(25, 'อัญนา', 'วิชยประเสริฐกุล', '1568294991222', 'other', '2010-01-04', 'หมอ', '0904145645', 'vajoma1111@ikowat.com', 'บ้านโปง', 'autya', '$2y$10$7V7Z93/XNj/HcfasaRTsMe7jwm1nBn2x2bOwkISgM2po5CX.dbp9.', '2024-12-05 05:45:03', '2024-12-05 05:45:03', 'user', NULL),
(26, 'ธิศา', 'สันติสุข', '1458129201911', 'female', '2003-02-05', 'ชาวนา', '0908448298', 'wanibom846@jonespal.com', '59หมู่3', 'thida', '$2y$10$lQ7XHmFEQWSzwKWr1/wkQu2cAgf3w0fbNpTgf7sCuMmUY3rh1ek82', '2024-12-05 06:11:00', '2024-12-05 06:11:00', 'user', NULL),
(27, 'คัทลียา', 'เกียรติโกศล', '1341245664378', 'other', '1998-06-09', 'ค้าขาย', '0868843428', 'kesebi3072@bflcafe.com', 'ซอย7', 'catli', '$2y$10$zjeP4qDLt8fqEII.q8NILObcHVDe2tLCzur2by53.wlfKYv1a5PFa', '2024-12-05 06:25:46', '2024-12-05 06:25:46', 'user', NULL),
(28, 'บวรวิทย์', 'เพชรประเสริฐ', '1645728881122', 'male', '2000-06-15', 'ช่างตัดผม', '0901421552', 'pdt81366@inohm.com', '37/5ซอย10', 'Bawonwit', '$2y$10$aiD5cHNixHq6p0TjpHBHi.3gf3h29ocUOYiVf6ChskhmSHeBqoYTe', '2024-12-05 06:44:24', '2024-12-05 06:44:24', 'user', NULL),
(29, 'ถิรพุทธ', 'ตรีพงศ์สกุล', '173912842112', 'male', '2001-06-05', 'ชาวไล่', '0627182842', 'lft43724@inohm.com', '68หมู่2', 'Tiraput', '$2y$10$/A.8VZtYFrAQ8Xggh7tsWO8ovlI2tvPwGQGDYD4NnmT5YrTG85dwa', '2024-12-05 06:57:55', '2024-12-05 06:57:55', 'user', NULL),
(30, 'วิสาข์', 'รัตนพิรมย์', '1645529235812', 'female', '2001-06-05', 'ค้าขาย', '0901421554', 'vjl88622@kisoq.com', 'หมู่4', 'Wisa', '$2y$10$Imq/un0Zjg83uVkshcg4Qew8aZEs/mMsesa97v0Vr8IxsXyOX1xja', '2024-12-05 07:21:41', '2024-12-05 07:21:41', 'user', NULL),
(31, 'จารวี', 'โตศิลา', '1547262716272', 'other', '2024-12-05', 'ค้าขาย', '0920812882', 'kesebi30722@bflcafe.com', 'บ้านโป่ง', 'Jarawee', '$2y$10$xCVdJ6iAaj7k6SnmFv27PuY.j2tDYS78M.hEZPWQT/ts79lnq4ULC', '2024-12-05 10:25:25', '2024-12-05 10:25:25', 'user', NULL),
(32, 'กลอน', 'ปิติโอภาสพงศ์', '1739300002141', 'other', '2024-12-05', 'ชาวนา', '0908448254', 'kesebi301272@bflcafe.com', 'บ้านโป่ง', 'Klon', '$2y$10$9p2.dUXktBO//sK/BILBhOu2elN0Z45w1i3E2x5BQ7m.lrj/P0PmG', '2024-12-05 10:31:03', '2024-12-05 10:31:03', 'user', NULL),
(33, 'เจษฎาพร', 'ภมรฉ่ำ', '1640705156', 'male', '2002-09-05', 'นักศึกษา', '0867672552', 'jesadapron.pamo@bumail.net', 'พลัมอไลฟ์1ตึกA', 'GotVader', '$2y$10$wdq.eN3OlpSSIn.JtFPlYuyABnC5Umer6yGXuGOFXTvwd4vQHQUhS', '2024-12-05 12:43:48', '2024-12-05 12:43:48', 'user', NULL),
(35, 'Got', 'Vader', '1739300006472', 'male', '2024-11-14', 'admin', '0867672553', 'gotvader.honkai@gmail.com', '59หมู่3', 'Gotvaderz', '$2y$10$IYCuFWLRiG2gQQhO9gLImuPFocVXntbZOT9v.B2ijX40VlCt.Mzqy', '2024-12-05 12:58:37', '2024-12-05 12:58:37', 'admin', 'สำนักปลัดเทศบาลเมือง');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appeals`
--
ALTER TABLE `appeals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `department` (`department`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
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
  `report_person` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(15) NOT NULL,
  `contact_location` varchar(255) DEFAULT NULL,
  `contact_details` text DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `incident_date` date DEFAULT NULL,
  `incident_time` time DEFAULT NULL,
  `problem_level` varchar(50) DEFAULT NULL,
  `department` enum('เทศบาลเมือง','สำนักปลัดเทศบาลเมือง','กองคลัง','กองช่าง','กองการศึกษา','กองสาธารณสุข','กองสวัสดิการสังคม','กองยุทธศาสตร์','กองการเจ้าหน้าที่','หน่วยตรวจสอบภายใน','หน่วยงานอื่นๆ') DEFAULT NULL,
  `complaint_description` text DEFAULT NULL,
  `complaint_file` longblob DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('ยังไม่ดำเนินการ','กำลังดำเนินการ','ดำเนินการเสร็จสิ้น') DEFAULT 'ยังไม่ดำเนินการ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appeals`
--

INSERT INTO `appeals` (`id`, `user_id`, `report_subject`, `report_person`, `contact_phone`, `contact_location`, `contact_details`, `latitude`, `longitude`, `incident_date`, `incident_time`, `problem_level`, `department`, `complaint_description`, `complaint_file`, `submitted_at`, `status`) VALUES
(89, 29, 'เจ้าหน้าที่ดูเหมือนจะมีการข่มขู่ประชาชน', 'หน่วยงานที่มาจัดระเบียบตลาด', '0809712342', 'ตลาดนัดวัดพล', 'ตลาดนัดวัดพลช่วงเช้า', 13.7367, 100.523, '2024-12-05', '07:19:00', 'ปานกลาง', 'หน่วยตรวจสอบภายใน', 'เจ้าหน้าที่ดูเหมือนจะมีการข่มขู่ประชาชน', NULL, '2024-12-05 07:19:31', 'ยังไม่ดำเนินการ'),
(90, 30, 'เจ้าหน้าที่ขโมยของ', 'หน่วยช่อง', '0981726212', 'บ้านเลขที่59หมู่3', 'บ้านที่ช่างเข้ามาเช็คไฟ', 13.7367, 100.523, '2024-12-06', '14:39:00', 'ปานกลาง', 'หน่วยตรวจสอบภายใน', 'หลังจากช่างเข้ามาแก้ไขไฟได้มีของหาย', NULL, '2024-12-05 07:39:36', 'ยังไม่ดำเนินการ'),
(91, 31, 'เจ้าหน้าที่รับของไปแล้วไม่นำไปแจก', 'เจ้าหน้าที่จิตอาสาของเทศบาล', '0943583488', 'เทศบาล', 'เทศบาล', 13.6495, 100.832, '2024-12-05', '18:29:00', 'ต่ำ', 'เทศบาลเมือง', 'เจ้าหน้าที่รับของไปแล้วไม่นำไปแจก', NULL, '2024-12-05 10:30:02', 'ยังไม่ดำเนินการ'),
(92, 32, 'เจ้าหน้าที่ดูมีส่วนร่วมกับบ่อพนัน', 'ปลัด', '0867762542', 'บ้านยายยุ้ย', 'หลังบ้านยายยุ้ย', 13.5938, 101.118, '2024-12-05', '19:34:00', 'ต่ำ', 'หน่วยตรวจสอบภายใน', 'เห็นปลัดเล่นพนันและรับสินบนจากบ่อน', NULL, '2024-12-05 10:34:56', 'ยังไม่ดำเนินการ'),
(93, 33, 'ของหาย', 'เจ้าหน้าที่ที่เข้ามาปฎิบัติงาน', '0867672552', '59หมู่3', 'บ้านเลขที่59หมู่3', 13.7293, 100.536, '2024-12-05', '20:51:00', 'ปานกลาง', 'เทศบาลเมือง', 'เจ้าหน้าที่เข้ามาปฎิบัติงานภายในบ้านเลขที่ 59หมู่3แล้วของหาย', NULL, '2024-12-05 12:51:50', 'ยังไม่ดำเนินการ'),
(94, 29, 'เจ้าหน้าที่ดูเหมือนจะมีการข่มขู่ประชาชน', 'หน่วยงานที่มาจัดระเบียบตลาด', '0809712342', 'ตลาดนัดวัดพล', 'ตลาดนัดวัดพลช่วงเช้า', 13.7367, 100.523, '2024-12-05', '07:19:00', 'ปานกลาง', 'หน่วยตรวจสอบภายใน', 'เจ้าหน้าที่ดูเหมือนจะมีการข่มขู่ประชาชน', NULL, '2024-12-05 07:19:31', 'ยังไม่ดำเนินการ'),
(95, 31, 'เจ้าหน้าที่รับของไปแล้วไม่นำไปแจก', 'เจ้าหน้าที่จิตอาสาของเทศบาล', '0943583488', 'เทศบาล', 'เทศบาล', 13.6495, 100.832, '2024-12-05', '18:29:00', 'ต่ำ', 'เทศบาลเมือง', 'เจ้าหน้าที่รับของไปแล้วไม่นำไปแจก', NULL, '2024-12-05 10:30:02', 'ยังไม่ดำเนินการ'),
(96, 32, 'เจ้าหน้าที่ดูมีส่วนร่วมกับบ่อพนัน', 'ปลัด', '0867762542', 'บ้านยายยุ้ย', 'หลังบ้านยายยุ้ย', 13.5938, 101.118, '2024-12-05', '19:34:00', 'ต่ำ', 'หน่วยตรวจสอบภายใน', 'เห็นปลัดเล่นพนันและรับสินบนจากบ่อน', NULL, '2024-12-05 10:34:56', 'ยังไม่ดำเนินการ'),
(97, 33, 'ของหาย', 'เจ้าหน้าที่ที่เข้ามาปฎิบัติงาน', '0867672552', '59หมู่3', 'บ้านเลขที่59หมู่3', 13.7293, 100.536, '2024-12-05', '20:51:00', 'ปานกลาง', 'เทศบาลเมือง', 'เจ้าหน้าที่เข้ามาปฎิบัติงานภายในบ้านเลขที่ 59หมู่3แล้วของหาย', NULL, '2024-12-05 12:51:50', 'ยังไม่ดำเนินการ'),
(99, 29, 'เจ้าหน้าที่ดูเหมือนจะมีการข่มขู่ประชาชน', 'หน่วยงานที่มาจัดระเบียบตลาด', '0809712342', 'ตลาดนัดวัดพล', 'ตลาดนัดวัดพลช่วงเช้า', 13.7367, 100.523, '2024-12-05', '07:19:00', 'ปานกลาง', 'หน่วยตรวจสอบภายใน', 'เจ้าหน้าที่ดูเหมือนจะมีการข่มขู่ประชาชน', NULL, '2024-12-05 07:19:31', 'ยังไม่ดำเนินการ');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `complaint_subject` varchar(255) NOT NULL,
  `contact_phone` varchar(15) NOT NULL,
  `contact_location` varchar(255) DEFAULT NULL,
  `contact_details` text DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `incident_date` date DEFAULT NULL,
  `incident_time` time DEFAULT NULL,
  `problem_level` varchar(50) DEFAULT NULL,
  `department` enum('เทศบาลเมือง','สำนักปลัดเทศบาลเมือง','กองคลัง','กองช่าง','กองการศึกษา','กองสาธารณสุข','กองสวัสดิการสังคม','กองยุทธศาสตร์','กองการเจ้าหน้าที่','หน่วยตรวจสอบภายใน','หน่วยงานอื่นๆ') DEFAULT NULL,
  `complaint_description` text DEFAULT NULL,
  `complaint_file` longblob DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('ยังไม่ดำเนินการ','กำลังดำเนินการ','ดำเนินการเสร็จสิ้น') DEFAULT 'ยังไม่ดำเนินการ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `user_id`, `complaint_subject`, `contact_phone`, `contact_location`, `contact_details`, `latitude`, `longitude`, `incident_date`, `incident_time`, `problem_level`, `department`, `complaint_description`, `complaint_file`, `submitted_at`, `status`) VALUES
(89, 25, 'ืท่อแตก', '0904145645', 'หน้าบ้านผู้ใหญ่ศรี', 'หน้าบ้านตรงปากคลอง', 13.7367, 100.523, '2024-12-04', '00:47:00', 'ปานกลาง', 'เทศบาลเมือง', 'ท่อปะปาแตก', NULL, '2024-12-05 05:51:01', 'ยังไม่ดำเนินการ'),
(90, 26, 'ไฟถนนเสีย', '0908448298', 'คลอง1', 'คลอง1กลางคลองไฟเสีย', 13.7367, 100.523, '2024-08-07', '21:12:00', 'ต่ำ', 'เทศบาลเมือง', 'ไฟมันเสียมานานแล้ว ช่วยเข้ามาเปลี่ยนไฟให้หน่อย', NULL, '2024-12-05 06:13:36', 'ยังไม่ดำเนินการ'),
(91, 27, 'ไฟขยะ', '0868843428', 'หมู่3', 'นาของตาสิง', 13.7367, 100.523, '2024-12-05', '03:33:00', 'เร่งด่วน', 'เทศบาลเมือง', 'มีคนแอบจุดไฟใกล้นา ไฟอาจจะลามไหม้นา', NULL, '2024-12-05 06:34:17', 'ยังไม่ดำเนินการ'),
(92, 28, 'ขยะส่งกลิ่นเหม็น', '0901421552', 'วัดชมภูพล', 'ขยะหน้าวัดส่งกลิ่นเหม็น', 13.3473, 100.963, '2024-08-09', '15:46:00', 'ต่ำ', 'เทศบาลเมือง', 'ช่วยส่งรถมาเก็บขยะไปหน่อย', NULL, '2024-12-05 06:46:54', 'ยังไม่ดำเนินการ'),
(93, 24, 'ท่อแตก', '0921241252', 'ซอย3', 'บ้านตาลือ', 13.7367, 100.523, '2024-12-05', '13:50:00', 'ต่ำ', 'กองช่าง', 'ท่อประปาแตก', NULL, '2024-12-05 06:53:35', 'ยังไม่ดำเนินการ');

-- --------------------------------------------------------

--
-- Table structure for table `contact_table`
--

CREATE TABLE `contact_table` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_table`
--

INSERT INTO `contact_table` (`id`, `name`, `email`, `phone`, `message`, `submitted_at`) VALUES
(1, 'Sirawit Charoenpanich', 'poohcha7992@gmail.com', '0973195322', '1111', '2024-12-03 15:32:38'),
(2, 'Sirawit Charoenpanich', 'poohcha7992@gmail.com', '0973195322', '1111', '2024-12-03 15:34:20'),
(3, 'Sirawit Charoenpanich', 'poohcha7992@gmail.com', '0973195322', 'ddd', '2024-12-03 15:35:31'),
(4, 'Sirawit', 'poohcha7992@gmail.com', '0973195322', 'ggggg', '2024-12-03 15:36:11');

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
(19, 'อัญนา', 'วิชยประเสริฐกุล', '1568294991222', 'other', '2010-01-04', 'หมอ', '0904145645', 'vajoma1111@ikowat.com', 'บ้านโปง', 'autya', '$2y$10$7V7Z93/XNj/HcfasaRTsMe7jwm1nBn2x2bOwkISgM2po5CX.dbp9.', '2024-12-05 05:45:03', '2024-12-05 05:45:03', 'user', NULL),
(20, 'ธิศา', 'สันติสุข', '1458129201911', 'female', '2003-02-05', 'ชาวนา', '0908448298', 'wanibom846@jonespal.com', '59หมู่3', 'thida', '$2y$10$lQ7XHmFEQWSzwKWr1/wkQu2cAgf3w0fbNpTgf7sCuMmUY3rh1ek82', '2024-12-05 06:11:00', '2024-12-05 06:11:00', 'user', NULL),
(21, 'คัทลียา', 'เกียรติโกศล', '1341245664378', 'other', '1998-06-09', 'ค้าขาย', '0868843428', 'kesebi3072@bflcafe.com', 'ซอย7', 'catli', '$2y$10$zjeP4qDLt8fqEII.q8NILObcHVDe2tLCzur2by53.wlfKYv1a5PFa', '2024-12-05 06:25:46', '2024-12-05 06:25:46', 'user', NULL),
(22, 'บวรวิทย์', 'เพชรประเสริฐ', '1645728881122', 'male', '2000-06-15', 'ช่างตัดผม', '0901421552', 'pdt81366@inohm.com', '37/5ซอย10', 'Bawonwit', '$2y$10$aiD5cHNixHq6p0TjpHBHi.3gf3h29ocUOYiVf6ChskhmSHeBqoYTe', '2024-12-05 06:44:24', '2024-12-05 06:44:24', 'user', NULL),
(23, 'ถิรพุทธ', 'ตรีพงศ์สกุล', '173912842112', 'male', '2001-06-05', 'ชาวไล่', '0627182842', 'lft43724@inohm.com', '68หมู่2', 'Tiraput', '$2y$10$/A.8VZtYFrAQ8Xggh7tsWO8ovlI2tvPwGQGDYD4NnmT5YrTG85dwa', '2024-12-05 06:57:55', '2024-12-05 06:57:55', 'user', NULL),
(24, 'วิสาข์', 'รัตนพิรมย์', '1645529235812', 'female', '2001-06-05', 'ค้าขาย', '0901421554', 'vjl88622@kisoq.com', 'หมู่4', 'Wisa', '$2y$10$Imq/un0Zjg83uVkshcg4Qew8aZEs/mMsesa97v0Vr8IxsXyOX1xja', '2024-12-05 07:21:41', '2024-12-05 07:21:41', 'user', NULL),
(25, 'จารวี', 'โตศิลา', '1547262716272', 'other', '2024-12-05', 'ค้าขาย', '0920812882', 'kesebi30722@bflcafe.com', 'บ้านโป่ง', 'Jarawee', '$2y$10$xCVdJ6iAaj7k6SnmFv27PuY.j2tDYS78M.hEZPWQT/ts79lnq4ULC', '2024-12-05 10:25:25', '2024-12-05 10:25:25', 'user', NULL),
(26, 'กลอน', 'ปิติโอภาสพงศ์', '1739300002141', 'other', '2024-12-05', 'ชาวนา', '0908448254', 'kesebi301272@bflcafe.com', 'บ้านโป่ง', 'Klon', '$2y$10$9p2.dUXktBO//sK/BILBhOu2elN0Z45w1i3E2x5BQ7m.lrj/P0PmG', '2024-12-05 10:31:03', '2024-12-05 10:31:03', 'user', NULL),
(27, 'เจษฎาพร', 'ภมรฉ่ำ', '1640705156', 'male', '2002-09-05', 'นักศึกษา', '0867672552', 'jesadapron.pamo@bumail.net', 'พลัมอไลฟ์1ตึกA', 'GotVader', '$2y$10$wdq.eN3OlpSSIn.JtFPlYuyABnC5Umer6yGXuGOFXTvwd4vQHQUhS', '2024-12-05 12:43:48', '2024-12-05 12:43:48', 'user', NULL),
(28, 'Got', 'Vader', '1739300006472', 'male', '2024-11-14', 'admin', '0867672553', 'gotvader.honkai@gmail.com', '59หมู่3', 'Gotvaderz', '$2y$10$IYCuFWLRiG2gQQhO9gLImuPFocVXntbZOT9v.B2ijX40VlCt.Mzqy', '2024-12-05 12:58:37', '2024-12-05 12:58:37', 'admin', 'สำนักปลัดเทศบาลเมือง');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appeals`
--
ALTER TABLE `appeals`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `changed_by` (`changed_by`),
  ADD KEY `fk_complaint_id` (`complaint_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `contact_table`
--
ALTER TABLE `contact_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `status_change_logs`
--
ALTER TABLE `status_change_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
  ADD CONSTRAINT `fk_complaint_id` FOREIGN KEY (`complaint_id`) REFERENCES `appeals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `status_change_logs_ibfk_1` FOREIGN KEY (`complaint_id`) REFERENCES `complaints` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `status_change_logs_ibfk_2` FOREIGN KEY (`changed_by`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
