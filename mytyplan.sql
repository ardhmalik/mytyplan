-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2022 at 07:17 AM
-- Server version: 10.6.5-MariaDB
-- PHP Version: 8.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mytyplan`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`ardhmalik`@`localhost` PROCEDURE `addUser` (IN `email_param` VARCHAR(128), IN `username_param` VARCHAR(100), IN `password_param` VARCHAR(256))  BEGIN
INSERT INTO users(email, username, password, avatar, joined) VALUES (email_param, username_param, password_param, "avatar.png", NOW());
END$$

CREATE DEFINER=`ardhmalik`@`localhost` PROCEDURE `viewAllPlan` (IN `id_user_param` INT)  BEGIN
SELECT * from all_plans WHERE id_user=id_user_param;
END$$

CREATE DEFINER=`ardhmalik`@`localhost` PROCEDURE `viewFailPlan` (IN `id_user_param` INT)  BEGIN
SELECT * from fail_plans WHERE id_user=id_user_param;
END$$

CREATE DEFINER=`ardhmalik`@`localhost` PROCEDURE `viewSuccessPlan` (IN `id_user_param` INT)  BEGIN
SELECT * from success_plans WHERE id_user=id_user_param;
END$$

CREATE DEFINER=`ardhmalik`@`localhost` PROCEDURE `viewUserLogs` (IN `id_user_param` INT)  BEGIN
SELECT * FROM user_logs WHERE id_user=id_user_param;
END$$

--
-- Functions
--
CREATE DEFINER=`ardhmalik`@`localhost` FUNCTION `addPlan` (`id_user_param` INT, `plan_param` VARCHAR(128), `desc_param` TEXT, `exp_param` DATETIME, `status_param` BOOL, `id_label_param` INT, `id_month_param` INT) RETURNS INT(11) BEGIN
INSERT INTO plans(plan, description, created, expired, status, id_label, id_month) VALUES (plan_param, desc_param, NOW(), exp_param, status_param, id_label_param, id_month_param);
INSERT INTO history(id_user, id_plan, month, label, plan, description, status, created, updated) VALUES (id_user_param, (SELECT MAX(id_plan) FROM plans WHERE plan=plan_param AND description=desc_param AND expired=exp_param AND status=status_param AND id_label=id_label_param AND id_month=id_month_param), (SELECT month FROM months WHERE id_month=id_month_param), (SELECT label FROM labels WHERE id_label=id_label_param), plan_param, desc_param, status_param, NOW(), NOW());
RETURN 1;
END$$

CREATE DEFINER=`ardhmalik`@`localhost` FUNCTION `delPlan` (`id_plan_param` INT) RETURNS INT(11) BEGIN
DELETE FROM history WHERE id_plan=id_plan_param; 
DELETE FROM plans WHERE id_plan=id_plan_param;
RETURN 1;
END$$

CREATE DEFINER=`ardhmalik`@`localhost` FUNCTION `editPlan` (`id_plan_param` INT, `plan_param` VARCHAR(128), `desc_param` TEXT, `id_label_param` INT) RETURNS INT(11) BEGIN
UPDATE plans SET plan=plan_param, description=desc_param, id_label=id_label_param WHERE id_plan=id_plan_param;
UPDATE history SET plan=plan_param, description=desc_param, label=(SELECT label FROM labels INNER JOIN plans ON plans.id_label=labels.id_label WHERE plans.id_plan=id_plan_param), updated=NOW() WHERE id_plan=id_plan_param;
RETURN 1;
END$$

CREATE DEFINER=`ardhmalik`@`localhost` FUNCTION `failPlan` (`id_plan_param` INT) RETURNS INT(11) BEGIN
UPDATE plans SET status=0 WHERE id_plan=id_plan_param;
UPDATE history SET status=0, updated=NOW() WHERE id_plan=id_plan_param;
RETURN 1;
END$$

CREATE DEFINER=`ardhmalik`@`localhost` FUNCTION `movePlan` (`id_plan_param` INT, `id_month_param` INT, `exp_param` DATETIME) RETURNS INT(11) BEGIN
UPDATE plans SET id_month=id_month_param, expired=exp_param WHERE id_plan=id_plan_param;
UPDATE history SET month=(SELECT month FROM months WHERE id_month=id_month_param) WHERE id_plan=id_plan_param;
RETURN 1;
END$$

CREATE DEFINER=`ardhmalik`@`localhost` FUNCTION `successPlan` (`id_plan_param` INT) RETURNS INT(11) BEGIN
UPDATE plans SET status=1 WHERE id_plan=id_plan_param;
UPDATE history SET status=1, updated=NOW() WHERE id_plan=id_plan_param;
RETURN 1;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `all_plans`
-- (See below for the actual view)
--
CREATE TABLE `all_plans` (
`month` varchar(2)
,`id_plan` int(11)
,`id_user` int(11)
,`label` varchar(100)
,`plan` varchar(128)
,`description` text
,`status` tinyint(1)
,`created` datetime
,`expired` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `fail_plans`
-- (See below for the actual view)
--
CREATE TABLE `fail_plans` (
`month` varchar(2)
,`id_plan` int(11)
,`id_user` int(11)
,`label` varchar(100)
,`plan` varchar(128)
,`description` text
,`status` tinyint(1)
,`created` datetime
,`expired` datetime
);

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id_history` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_plan` int(11) NOT NULL,
  `month` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id_history`, `id_user`, `id_plan`, `month`, `label`, `plan`, `description`, `status`, `created`, `updated`) VALUES
(1, 1, 1, '05', 'Important', 'Menguasai HTML, CSS & JS', 'Belajar dari buku, YT & blog', 1, '2022-01-26 11:20:34', '2022-02-02 10:55:06'),
(2, 1, 2, '02', 'Very Important', 'Menjadi backend dev', 'Mengikuti bootcamp', 0, '2022-01-26 11:22:28', '2022-01-26 11:22:28'),
(4, 2, 4, '12', 'Normal', 'Menjadi Legenda', 'Menjadi tetua Clan Uchiha', 1, '2022-01-26 12:12:39', '2022-01-26 12:12:39'),
(5, 4, 5, '03', 'Important', 'Mengikuti Turnamen', 'Mengikuti turnamen sepakbola DANONE CUP', 0, '2022-01-26 15:02:27', '2022-01-26 15:02:27'),
(6, 1, 7, '02', 'Very Important', 'Menjadi Fullstack Web Dev', 'Menguasai backend & frontend dengan belajar dan praktik langsung', 1, '2022-01-31 21:08:40', '2022-02-02 19:51:28'),
(7, 1, 8, '03', 'Important', 'Mulai nyusun skripsi', 'Kumpulin berbagai referensi buat nyusun skripsi', 0, '2022-01-31 21:14:42', '2022-01-31 21:14:42'),
(8, 1, 9, '01', 'Normal', 'Tuntasin sertifikasi', 'Semangat bro, jangan mager nanti nggak selesai2 tugasnya', 1, '2022-01-31 21:16:13', '2022-02-02 19:36:09'),
(9, 1, 10, '02', 'Very Important', 'Perpanjang SIM', 'Pulkam buat perpanjang SIM, tapi ngga jadi', 0, '2022-01-31 21:19:46', '2022-02-05 09:34:21'),
(10, 1, 11, '03', 'Important', 'Belajar Self Development', 'Mempelajari dari berbagai media untuk meningkatkan soft skill', 1, '2022-02-01 07:30:30', '2022-02-01 11:03:42'),
(11, 1, 12, '09', 'Normal', 'Belajar Bahasa Inggris Dasar', 'Belajar B.Inggris  dasar untuk menambah value dalam mencari kerja', 1, '2022-02-01 07:32:55', '2022-02-01 11:02:49'),
(12, 1, 13, '01', 'Very Important', 'Liburan kuliah', 'Tapi ngga jadi, karna ada sertifikasi. Semangat bro, jangan sia2in kesempatan sama kayak dia nyia2in dirimu XD', 0, '2022-02-01 14:42:17', '2022-02-05 13:58:56'),
(15, 1, 16, '04', 'Normal', 'Lorem ipsum dolor', 'Lorem ipsum dolor sit amet,', 0, '2022-02-01 20:11:22', '2022-02-01 20:11:22'),
(16, 1, 17, '04', 'Very Important', 'Lorem ipsum dolor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ', 0, '2022-02-01 20:11:49', '2022-02-01 20:11:49'),
(17, 1, 18, '08', 'Important', 'Lorem ipsum dolor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 0, '2022-02-01 20:12:18', '2022-02-01 20:12:18'),
(18, 1, 19, '08', 'Very Important', 'Agustusan', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor', 0, '2022-02-01 20:12:55', '2022-02-01 20:12:55'),
(19, 1, 20, '12', 'Normal', 'Lorem ipsum dolor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 0, '2022-02-01 20:13:55', '2022-02-01 20:13:55'),
(20, 1, 21, '12', 'Very Important', 'Tahun baru-an', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 1, '2022-02-01 20:14:31', '2022-02-04 09:14:16'),
(21, 1, 22, '06', 'Important', 'Lorem ipsum dolor', 'Lorem ipsum dolor sit amet, consectetur', 0, '2022-02-01 20:15:24', '2022-02-01 20:15:24'),
(22, 1, 23, '05', 'Normal', 'Demo buruh', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut', 0, '2022-02-01 20:16:04', '2022-02-02 20:22:48'),
(23, 1, 24, '09', 'Very Important', 'Lorem ipsum dolor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 0, '2022-02-01 20:16:43', '2022-02-01 20:16:43'),
(24, 1, 25, '10', 'Very Important', 'Lorem ipsum dolor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod temp', 0, '2022-02-01 20:19:18', '2022-02-01 20:19:18'),
(25, 1, 26, '11', 'Important', 'Lorem ipsum dolor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 0, '2022-02-01 20:19:55', '2022-02-01 20:19:55'),
(26, 1, 27, '07', 'Important', 'Lorem ipsum dolor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 1, '2022-02-01 20:47:17', '2022-02-01 20:47:17'),
(27, 1, 28, '07', 'Very Important', 'Lorem ipsum dolor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 0, '2022-02-01 20:52:53', '2022-02-01 20:52:53'),
(28, 1, 29, '06', 'Important', 'Lorem ipsum dolor', 'Lorem ipsum wkwk', 1, '2022-02-02 09:08:18', '2022-02-02 10:58:09'),
(29, 1, 30, '10', 'Important', 'Lorem ipsum dolor', 'Lorem wkwkwkwk wkwkwk wkw kwk wkwk wkwk wwtfw eeeee eeeee eeeeee eeeee eee eeeee eeee eeeeee ', 1, '2022-02-02 20:16:03', '2022-02-02 20:17:34');

--
-- Triggers `history`
--
DELIMITER $$
CREATE TRIGGER `add_plan` AFTER INSERT ON `history` FOR EACH ROW BEGIN
INSERT INTO logs(id_user, action, content, times, activity) VALUES (NEW.id_user, "ADD PLAN", NEW.plan, NOW(), "User adding new plan");
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `del_plan` AFTER DELETE ON `history` FOR EACH ROW BEGIN
INSERT INTO logs(id_user, action, content, times, activity) VALUES (OLD.id_user, "DELETE PLAN", OLD.plan, NOW(), "User delete a plan");
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `edit_plan` AFTER UPDATE ON `history` FOR EACH ROW BEGIN
INSERT INTO logs(id_user, action, content, times, activity) VALUES (OLD.id_user, "UPDATE PLAN", OLD.plan, NOW(), "User update a plan");
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `labels`
--

CREATE TABLE `labels` (
  `id_label` int(11) NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `labels`
--

INSERT INTO `labels` (`id_label`, `label`) VALUES
(1, 'Normal'),
(2, 'Important'),
(3, 'Very Important');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id_log` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `action` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `times` datetime NOT NULL,
  `activity` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id_log`, `id_user`, `action`, `content`, `times`, `activity`) VALUES
(1, 1, 'JOINED', 'Minato', '2022-01-26 11:10:21', 'User has been joined to My This Year Plans'),
(2, 2, 'JOINED', 'Madara', '2022-01-26 11:10:49', 'User has been joined to My This Year Plans'),
(3, 1, 'ADD PLAN', 'Menguasai HTML&CSS', '2022-01-26 11:20:34', 'User adding new plan'),
(4, 1, 'ADD PLAN', 'Menjadi backend dev', '2022-01-26 11:22:28', 'User adding new plan'),
(5, 1, 'ADD PLAN', 'Menjadi hokage', '2022-01-26 11:24:50', 'User adding new plan'),
(6, 2, 'ADD PLAN', 'Menjadi Legenda', '2022-01-26 12:12:39', 'User adding new plan'),
(7, 1, 'UPDATE PLAN', 'Menjadi hokage', '2022-01-26 12:38:55', 'User update a plan'),
(8, 2, 'UPDATE PLAN', 'Menjadi Legenda', '2022-01-26 12:42:25', 'User update a plan'),
(9, 1, 'UPDATE PLAN', 'Menjadi hokage', '2022-01-26 12:44:04', 'User update a plan'),
(10, 1, 'DELETE PLAN', 'Menjadi hokage', '2022-01-26 12:45:03', 'User delete a plan'),
(11, 3, 'JOINED', 'Obito', '2022-01-26 13:52:54', 'User has been joined to My This Year Plans'),
(12, 4, 'JOINED', 'Boruto', '2022-01-26 14:00:47', 'User has been joined to My This Year Plans'),
(13, 5, 'JOINED', 'Shukaku', '2022-01-26 14:02:39', 'User has been joined to My This Year Plans'),
(14, 6, 'JOINED', 'Sarutobi', '2022-01-26 14:09:17', 'User has been joined to My This Year Plans'),
(16, 4, 'ADD PLAN', 'Mengikuti Turnamen', '2022-01-26 15:02:27', 'User adding new plan'),
(17, 7, 'JOINED', 'Khakasi', '2022-01-30 08:33:32', 'User has been joined to My This Year Plans'),
(18, 8, 'JOINED', 'elon_musk', '2022-01-30 20:41:15', 'User has been joined to My This Year Plans'),
(19, 9, 'JOINED', 'akimichi_choji', '2022-01-30 20:47:45', 'User has been joined to My This Year Plans'),
(20, 1, 'ADD PLAN', 'Menjadi web developer pemula', '2022-01-31 21:08:40', 'User adding new plan'),
(21, 1, 'ADD PLAN', 'Mulai nyusun skripsi', '2022-01-31 21:14:42', 'User adding new plan'),
(22, 1, 'ADD PLAN', 'Tuntasin sertifikasi', '2022-01-31 21:16:13', 'User adding new plan'),
(23, 1, 'ADD PLAN', 'Perpanjang SIM', '2022-01-31 21:19:46', 'User adding new plan'),
(24, 1, 'ADD PLAN', 'Belajar Self Development', '2022-02-01 07:30:30', 'User adding new plan'),
(25, 1, 'ADD PLAN', 'Belajar Bahasa Inggris Dasar', '2022-02-01 07:32:55', 'User adding new plan'),
(26, 1, 'UPDATE PLAN', 'Belajar Bahasa Inggris Dasar', '2022-02-01 11:02:49', 'User update a plan'),
(27, 1, 'UPDATE PLAN', 'Belajar Self Development', '2022-02-01 11:03:42', 'User update a plan'),
(28, 1, 'UPDATE PLAN', 'Menjadi web developer pemula', '2022-02-01 11:15:18', 'User update a plan'),
(29, 1, 'UPDATE PLAN', 'Perpanjang SIM', '2022-02-01 11:19:36', 'User update a plan'),
(30, 1, 'UPDATE PLAN', 'Perpanjang SIM', '2022-02-01 11:19:50', 'User update a plan'),
(31, 1, 'UPDATE PLAN', 'Menguasai HTML&CSS', '2022-02-01 14:19:11', 'User update a plan'),
(32, 1, 'UPDATE PLAN', 'Menjadi Fullstack Web Dev', '2022-02-01 14:40:30', 'User update a plan'),
(33, 1, 'UPDATE PLAN', 'Menjadi Fullstack Web Dev', '2022-02-01 14:40:36', 'User update a plan'),
(34, 1, 'UPDATE PLAN', 'Menguasai HTML, CSS & JS', '2022-02-01 14:40:41', 'User update a plan'),
(35, 1, 'ADD PLAN', 'Liburan kuliah', '2022-02-01 14:42:17', 'User adding new plan'),
(36, 1, 'UPDATE PLAN', 'Liburan kuliah', '2022-02-01 14:42:33', 'User update a plan'),
(37, 1, 'UPDATE PLAN', 'Tuntasin sertifikasi', '2022-02-01 14:43:23', 'User update a plan'),
(38, 1, 'UPDATE PLAN', 'Menjadi Fullstack Web Dev', '2022-02-01 14:43:36', 'User update a plan'),
(39, 1, 'UPDATE PLAN', 'Menjadi Fullstack Web Dev', '2022-02-01 19:07:56', 'User update a plan'),
(40, 1, 'UPDATE PLAN', 'Menjadi Fullstack Web Dev', '2022-02-01 19:08:03', 'User update a plan'),
(41, 1, 'UPDATE PLAN', 'Belajar Bahasa Inggris Dasar', '2022-02-01 19:33:35', 'User update a plan'),
(42, 1, 'UPDATE PLAN', 'Menjadi Fullstack Web Dev', '2022-02-01 19:51:57', 'User update a plan'),
(43, 1, 'ADD PLAN', 'Lorem ipsum dolor', '2022-02-01 20:09:22', 'User adding new plan'),
(44, 1, 'UPDATE PLAN', 'Lorem ipsum dolor', '2022-02-01 20:09:28', 'User update a plan'),
(45, 1, 'UPDATE PLAN', 'Lorem ipsum dolor', '2022-02-01 20:09:35', 'User update a plan'),
(46, 1, 'UPDATE PLAN', 'Lorem ipsum dolor', '2022-02-01 20:09:44', 'User update a plan'),
(47, 1, 'ADD PLAN', 'Lorem ipsum dolor', '2022-02-01 20:10:45', 'User adding new plan'),
(48, 1, 'ADD PLAN', 'Lorem ipsum dolor', '2022-02-01 20:11:22', 'User adding new plan'),
(49, 1, 'ADD PLAN', 'Lorem ipsum dolor', '2022-02-01 20:11:49', 'User adding new plan'),
(50, 1, 'ADD PLAN', 'Lorem ipsum dolor', '2022-02-01 20:12:18', 'User adding new plan'),
(51, 1, 'ADD PLAN', 'Agustusan', '2022-02-01 20:12:55', 'User adding new plan'),
(52, 1, 'UPDATE PLAN', 'Lorem ipsum dolor', '2022-02-01 20:13:18', 'User update a plan'),
(53, 1, 'ADD PLAN', 'Lorem ipsum dolor', '2022-02-01 20:13:55', 'User adding new plan'),
(54, 1, 'ADD PLAN', 'Tahun baru-an', '2022-02-01 20:14:31', 'User adding new plan'),
(55, 1, 'ADD PLAN', 'Lorem ipsum dolor', '2022-02-01 20:15:24', 'User adding new plan'),
(56, 1, 'ADD PLAN', 'Demo buruh', '2022-02-01 20:16:04', 'User adding new plan'),
(57, 1, 'ADD PLAN', 'Lorem ipsum dolor', '2022-02-01 20:16:43', 'User adding new plan'),
(58, 1, 'ADD PLAN', 'Lorem ipsum dolor', '2022-02-01 20:19:18', 'User adding new plan'),
(59, 1, 'ADD PLAN', 'Lorem ipsum dolor', '2022-02-01 20:19:55', 'User adding new plan'),
(60, 1, 'UPDATE PLAN', 'Lorem ipsum dolor', '2022-02-01 20:20:19', 'User update a plan'),
(61, 1, 'DELETE PLAN', 'Lorem ipsum dolor', '2022-02-01 20:21:38', 'User delete a plan'),
(62, 1, 'ADD PLAN', 'Lorem ipsum dolor', '2022-02-01 20:47:17', 'User adding new plan'),
(63, 1, 'ADD PLAN', 'Lorem ipsum dolor', '2022-02-01 20:52:53', 'User adding new plan'),
(64, 1, 'ADD PLAN', 'Lorem ipsum dolor', '2022-02-02 09:08:18', 'User adding new plan'),
(65, 1, 'UPDATE PLAN', 'Lorem ipsum dolor', '2022-02-02 09:18:37', 'User update a plan'),
(66, 1, 'UPDATE PLAN', 'Lorem ipsum dolor', '2022-02-02 09:21:19', 'User update a plan'),
(67, 1, 'UPDATE PLAN', 'Liburan kuliah', '2022-02-02 09:54:53', 'User update a plan'),
(68, 1, 'UPDATE PLAN', 'Liburan kuliah', '2022-02-02 09:55:03', 'User update a plan'),
(69, 1, 'UPDATE PLAN', 'Lorem ipsum dolor', '2022-02-02 10:54:58', 'User update a plan'),
(70, 1, 'UPDATE PLAN', 'Menguasai HTML, CSS & JS', '2022-02-02 10:55:03', 'User update a plan'),
(71, 1, 'UPDATE PLAN', 'Menguasai HTML, CSS & JS', '2022-02-02 10:55:06', 'User update a plan'),
(72, 1, 'UPDATE PLAN', 'Lorem ipsum dolor', '2022-02-02 10:55:32', 'User update a plan'),
(73, 1, 'UPDATE PLAN', 'Lorem ipsum dolor', '2022-02-02 10:56:05', 'User update a plan'),
(74, 1, 'DELETE PLAN', 'Lorem ipsum dolor', '2022-02-02 10:56:38', 'User delete a plan'),
(75, 1, 'UPDATE PLAN', 'Lorem ipsum dolor', '2022-02-02 10:58:09', 'User update a plan'),
(76, 1, 'UPDATE PLAN', 'Lorem ipsum dolor', '2022-02-02 10:58:54', 'User update a plan'),
(77, 1, 'UPDATE PLAN', 'Menguasai HTML, CSS & JS', '2022-02-02 10:59:21', 'User update a plan'),
(78, 1, 'UPDATE PLAN', 'Belajar Bahasa Inggris Dasar', '2022-02-02 10:59:42', 'User update a plan'),
(79, 1, 'UPDATE PLAN', 'Tuntasin sertifikasi', '2022-02-02 19:35:56', 'User update a plan'),
(80, 1, 'UPDATE PLAN', 'Tuntasin sertifikasi', '2022-02-02 19:36:09', 'User update a plan'),
(81, 1, 'UPDATE PLAN', 'Menjadi Fullstack Web Dev', '2022-02-02 19:51:28', 'User update a plan'),
(82, 1, 'ADD PLAN', 'Lorem ipsum dolor', '2022-02-02 20:16:03', 'User adding new plan'),
(83, 1, 'UPDATE PLAN', 'Lorem ipsum dolor', '2022-02-02 20:16:33', 'User update a plan'),
(84, 1, 'UPDATE PLAN', 'Lorem ipsum dolor', '2022-02-02 20:17:34', 'User update a plan'),
(85, 1, 'UPDATE PLAN', 'Liburan kuliah', '2022-02-02 20:19:35', 'User update a plan'),
(86, 1, 'UPDATE PLAN', 'Liburan kuliah', '2022-02-02 20:22:16', 'User update a plan'),
(87, 1, 'UPDATE PLAN', 'Liburan kuliah', '2022-02-02 20:22:19', 'User update a plan'),
(88, 1, 'UPDATE PLAN', 'Demo buruh', '2022-02-02 20:22:45', 'User update a plan'),
(89, 1, 'UPDATE PLAN', 'Demo buruh', '2022-02-02 20:22:48', 'User update a plan'),
(90, 1, 'UPDATE PLAN', 'Perpanjang SIM', '2022-02-02 20:25:37', 'User update a plan'),
(91, 1, 'UPDATE PLAN', 'Perpanjang SIM', '2022-02-04 09:12:56', 'User update a plan'),
(92, 1, 'UPDATE PLAN', 'Perpanjang SIM', '2022-02-04 09:13:04', 'User update a plan'),
(93, 1, 'UPDATE PLAN', 'Tahun baru-an', '2022-02-04 09:14:16', 'User update a plan'),
(94, 1, 'UPDATE PLAN', 'Perpanjang SIM', '2022-02-05 09:34:17', 'User update a plan'),
(95, 1, 'UPDATE PLAN', 'Perpanjang SIM', '2022-02-05 09:34:21', 'User update a plan'),
(96, 1, 'UPDATE PLAN', 'Liburan kuliah', '2022-02-05 13:58:56', 'User update a plan');

-- --------------------------------------------------------

--
-- Table structure for table `months`
--

CREATE TABLE `months` (
  `id_month` int(11) NOT NULL,
  `month` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `month_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `months`
--

INSERT INTO `months` (`id_month`, `month`, `month_name`) VALUES
(1, '01', 'January'),
(2, '02', 'February'),
(3, '03', 'March'),
(4, '04', 'April'),
(5, '05', 'May'),
(6, '06', 'June'),
(7, '07', 'July'),
(8, '08', 'August'),
(9, '09', 'September'),
(10, '10', 'October'),
(11, '11', 'November'),
(12, '12', 'December');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id_plan` int(11) NOT NULL,
  `plan` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `expired` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `id_label` int(11) NOT NULL,
  `id_month` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id_plan`, `plan`, `description`, `created`, `expired`, `status`, `id_label`, `id_month`) VALUES
(1, 'Menguasai HTML, CSS & JS', 'Belajar dari buku, YT & blog', '2022-01-26 11:20:34', '2022-05-31 23:59:59', 1, 2, 5),
(2, 'Menjadi backend dev', 'Mengikuti bootcamp', '2022-01-26 11:22:28', '2022-02-28 20:00:00', 0, 3, 2),
(4, 'Menjadi Legenda', 'Menjadi tetua Clan Uchiha', '2022-01-26 12:12:39', '2022-12-30 10:30:00', 1, 1, 12),
(5, 'Mengikuti Turnamen', 'Mengikuti turnamen sepakbola DANONE CUP', '2022-01-26 15:02:27', '2022-03-30 12:30:00', 0, 2, 3),
(7, 'Menjadi Fullstack Web Dev', 'Menguasai backend & frontend dengan belajar dan praktik langsung', '2022-01-31 21:08:40', '2022-03-31 23:59:59', 1, 3, 2),
(8, 'Mulai nyusun skripsi', 'Kumpulin berbagai referensi buat nyusun skripsi', '2022-01-31 21:14:42', '2022-03-12 23:59:59', 0, 2, 3),
(9, 'Tuntasin sertifikasi', 'Semangat bro, jangan mager nanti nggak selesai2 tugasnya', '2022-01-31 21:16:13', '2022-01-31 23:59:59', 1, 1, 1),
(10, 'Perpanjang SIM', 'Pulkam buat perpanjang SIM, tapi ngga jadi', '2022-01-31 21:19:46', '2022-02-12 23:59:59', 0, 3, 2),
(11, 'Belajar Self Development', 'Mempelajari dari berbagai media untuk meningkatkan soft skill', '2022-02-01 07:30:30', '2022-03-31 23:59:59', 1, 2, 3),
(12, 'Belajar Bahasa Inggris Dasar', 'Belajar B.Inggris  dasar untuk menambah value dalam mencari kerja', '2022-02-01 07:32:55', '2022-09-30 23:59:59', 1, 1, 9),
(13, 'Liburan kuliah', 'Tapi ngga jadi, karna ada sertifikasi. Semangat bro, jangan sia2in kesempatan sama kayak dia nyia2in dirimu XD', '2022-02-01 14:42:17', '2022-01-31 23:59:59', 0, 3, 1),
(16, 'Lorem ipsum dolor', 'Lorem ipsum dolor sit amet,', '2022-02-01 20:11:22', '2022-04-28 23:59:59', 0, 1, 4),
(17, 'Lorem ipsum dolor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ', '2022-02-01 20:11:49', '2022-02-16 23:59:59', 0, 3, 4),
(18, 'Lorem ipsum dolor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2022-02-01 20:12:18', '2022-08-03 23:59:59', 0, 2, 8),
(19, 'Agustusan', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor', '2022-02-01 20:12:55', '2022-08-17 23:59:59', 0, 3, 8),
(20, 'Lorem ipsum dolor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2022-02-01 20:13:55', '2022-12-15 23:59:59', 0, 1, 12),
(21, 'Tahun baru-an', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2022-02-01 20:14:31', '2022-12-30 23:59:59', 1, 3, 12),
(22, 'Lorem ipsum dolor', 'Lorem ipsum dolor sit amet, consectetur', '2022-02-01 20:15:24', '2022-06-23 23:59:59', 0, 2, 6),
(23, 'Demo buruh', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut', '2022-02-01 20:16:04', '2022-05-01 23:59:59', 0, 1, 5),
(24, 'Lorem ipsum dolor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2022-02-01 20:16:43', '2022-09-16 23:59:59', 0, 3, 9),
(25, 'Lorem ipsum dolor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod temp', '2022-02-01 20:19:18', '2022-10-26 23:59:59', 0, 3, 10),
(26, 'Lorem ipsum dolor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2022-02-01 20:19:55', '2022-11-17 23:59:59', 0, 2, 11),
(27, 'Lorem ipsum dolor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2022-02-01 20:47:17', '2022-07-21 23:59:59', 1, 2, 7),
(28, 'Lorem ipsum dolor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2022-02-01 20:52:53', '2022-07-21 23:59:59', 0, 3, 7),
(29, 'Lorem ipsum dolor', 'Lorem ipsum wkwk', '2022-02-02 09:08:18', '2022-06-18 23:59:59', 1, 2, 6),
(30, 'Lorem ipsum dolor', 'Lorem wkwkwkwk wkwkwk wkw kwk wkwk wkwk wwtfw eeeee eeeee eeeeee eeeee eee eeeee eeee eeeeee ', '2022-02-02 20:16:03', '2022-10-02 23:59:59', 1, 2, 10);

-- --------------------------------------------------------

--
-- Stand-in structure for view `success_plans`
-- (See below for the actual view)
--
CREATE TABLE `success_plans` (
`month` varchar(2)
,`id_plan` int(11)
,`id_user` int(11)
,`label` varchar(100)
,`plan` varchar(128)
,`description` text
,`status` tinyint(1)
,`created` datetime
,`expired` datetime
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `email` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `joined` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `email`, `username`, `password`, `avatar`, `joined`) VALUES
(1, 'minato@konoha.com', 'Minato', '$2y$10$B.ue2SxPBVqYD5o7vfTfvucpe.PQRHskD8kxM5CUtpw7Iz0BCY2vS', 'avatar.png', '2022-01-26 11:10:21'),
(2, 'madara@uchiha.com', 'Madara', '$2y$10$sze5jzVFMJu1kyJFiY2RC.3UUhxG76VzaH4T2a5wlxpxeznUwXpP2', 'avatar.png', '2022-01-26 11:10:49'),
(3, 'obito@uchiha.com', 'Obito', '$2y$10$IRF59lMb8apgmlYJ.tFOvuzT3NqoUP0hkjns54LJXhaW7ShMA0JnS', 'avatar.png', '2022-01-26 13:52:54'),
(4, 'boruto123@uzumaki.com', 'Boruto', '$2y$10$1m2gmItESzJCS4aeid3N1eYZVtcf7hmIMFsSJyhF/UzbtlLD99Thi', 'avatar.png', '2022-01-26 14:00:47'),
(5, 'shukaku123@kamegakure.com', 'Shukaku', '$2y$10$qO0FDuaAvmHp/.SCP.RJvOdhEzQz2/vRr8Sd7PUNDqlk.CFOXryOC', 'avatar.png', '2022-01-26 14:02:39'),
(6, 'sarutobi123@konoha.com', 'Sarutobi', '$2y$10$8YGWl6fZhg/ulHruBkMvR.6okC4KyaYrxhDGGR/QqA5XmyZelU1c.', 'avatar.png', '2022-01-26 14:09:17'),
(7, 'khakasi@hatake.com', 'Khakasi', '$2y$10$V5vIgEQhkNrn/ZNQiAROvu56cdQiIck6LriSvI1Oua/RZRWWepHUm', 'avatar.png', '2022-01-30 08:33:32'),
(8, 'musk@elon.com', 'elon_musk', '$2y$10$SB.8QtFDK.SGxGYZ8vJWtOk5wVP/sfklvixhRWDKkuswNOzIBVSmm', 'avatar.png', '2022-01-30 20:41:15'),
(9, 'choji@akimichi.com', 'akimichi_choji', '$2y$10$zHSqUaRrjVRnYznd/eLz0OPISh.bZyE0z9tV0x875wajLt8wLoY/.', 'avatar.png', '2022-01-30 20:47:45');

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `user_joined` AFTER INSERT ON `users` FOR EACH ROW BEGIN
INSERT INTO logs(id_user, action, content, times, activity) VALUES (NEW.id_user, "JOINED", NEW.username, NOW(), "User has been joined to My This Year Plans");
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_logs`
-- (See below for the actual view)
--
CREATE TABLE `user_logs` (
`id_user` int(11)
,`id_log` int(11)
,`action` varchar(128)
,`content` varchar(128)
,`times` datetime
,`activity` text
);

-- --------------------------------------------------------

--
-- Structure for view `all_plans`
--
DROP TABLE IF EXISTS `all_plans`;

CREATE ALGORITHM=UNDEFINED DEFINER=`ardhmalik`@`localhost` SQL SECURITY DEFINER VIEW `all_plans`  AS SELECT `history`.`month` AS `month`, `plans`.`id_plan` AS `id_plan`, `history`.`id_user` AS `id_user`, `history`.`label` AS `label`, `plans`.`plan` AS `plan`, `plans`.`description` AS `description`, `plans`.`status` AS `status`, `plans`.`created` AS `created`, `plans`.`expired` AS `expired` FROM (`plans` join `history` on(`plans`.`id_plan` = `history`.`id_plan`)) ORDER BY `history`.`month` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `fail_plans`
--
DROP TABLE IF EXISTS `fail_plans`;

CREATE ALGORITHM=UNDEFINED DEFINER=`ardhmalik`@`localhost` SQL SECURITY DEFINER VIEW `fail_plans`  AS SELECT `history`.`month` AS `month`, `plans`.`id_plan` AS `id_plan`, `history`.`id_user` AS `id_user`, `history`.`label` AS `label`, `plans`.`plan` AS `plan`, `plans`.`description` AS `description`, `plans`.`status` AS `status`, `plans`.`created` AS `created`, `plans`.`expired` AS `expired` FROM (`plans` join `history` on(`plans`.`id_plan` = `history`.`id_plan`)) WHERE `plans`.`status` = 0 ORDER BY `history`.`month` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `success_plans`
--
DROP TABLE IF EXISTS `success_plans`;

CREATE ALGORITHM=UNDEFINED DEFINER=`ardhmalik`@`localhost` SQL SECURITY DEFINER VIEW `success_plans`  AS SELECT `history`.`month` AS `month`, `plans`.`id_plan` AS `id_plan`, `history`.`id_user` AS `id_user`, `history`.`label` AS `label`, `plans`.`plan` AS `plan`, `plans`.`description` AS `description`, `plans`.`status` AS `status`, `plans`.`created` AS `created`, `plans`.`expired` AS `expired` FROM (`plans` join `history` on(`plans`.`id_plan` = `history`.`id_plan`)) WHERE `plans`.`status` = 1 ORDER BY `history`.`month` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `user_logs`
--
DROP TABLE IF EXISTS `user_logs`;

CREATE ALGORITHM=UNDEFINED DEFINER=`ardhmalik`@`localhost` SQL SECURITY DEFINER VIEW `user_logs`  AS SELECT `logs`.`id_user` AS `id_user`, `logs`.`id_log` AS `id_log`, `logs`.`action` AS `action`, `logs`.`content` AS `content`, `logs`.`times` AS `times`, `logs`.`activity` AS `activity` FROM `logs` ORDER BY `logs`.`times` DESC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id_history`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_plan` (`id_plan`),
  ADD KEY `idx_history` (`id_history`,`id_user`,`id_plan`);

--
-- Indexes for table `labels`
--
ALTER TABLE `labels`
  ADD PRIMARY KEY (`id_label`),
  ADD KEY `idx_labels` (`id_label`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `idx_logs` (`id_log`);

--
-- Indexes for table `months`
--
ALTER TABLE `months`
  ADD PRIMARY KEY (`id_month`),
  ADD KEY `idx_months` (`id_month`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id_plan`),
  ADD KEY `id_label` (`id_label`),
  ADD KEY `id_month` (`id_month`),
  ADD KEY `idx_plans` (`id_plan`,`id_label`,`id_month`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `idx_users` (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id_history` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `labels`
--
ALTER TABLE `labels`
  MODIFY `id_label` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `months`
--
ALTER TABLE `months`
  MODIFY `id_month` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id_plan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `history_ibfk_2` FOREIGN KEY (`id_plan`) REFERENCES `plans` (`id_plan`);

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `plans`
--
ALTER TABLE `plans`
  ADD CONSTRAINT `plans_ibfk_1` FOREIGN KEY (`id_label`) REFERENCES `labels` (`id_label`),
  ADD CONSTRAINT `plans_ibfk_2` FOREIGN KEY (`id_month`) REFERENCES `months` (`id_month`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
