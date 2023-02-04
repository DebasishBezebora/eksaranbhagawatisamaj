-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2023 at 02:29 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eksaranbhagawatisamaj`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `ID` int(11) NOT NULL,
  `Event_Date` date NOT NULL,
  `Event_Category` int(11) NOT NULL,
  `Content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `Photos` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Video_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Video_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Video_3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Keywords` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Active` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL,
  `Sort_Order` int(11) NOT NULL,
  `Created_BY` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Created_AT` datetime NOT NULL,
  `IP` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_category`
--

CREATE TABLE `event_category` (
  `ID` int(11) NOT NULL,
  `Category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Active` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL,
  `Created_BY` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Created_AT` datetime NOT NULL,
  `IP` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE `links` (
  `ID` int(11) NOT NULL,
  `Link_Name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `URL_Slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Link_Content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `Photos` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Video_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Video_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Video_3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Keywords` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Active` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL,
  `Created_AT` datetime NOT NULL,
  `Created_BY` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IP` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `photo_gallery`
--

CREATE TABLE `photo_gallery` (
  `ID` int(11) NOT NULL,
  `Album_Name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Photos` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Active` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL,
  `Sort_Order` int(11) NOT NULL,
  `Description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Keywords` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Created_AT` datetime NOT NULL,
  `Created_BY` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IP` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `ID` int(11) NOT NULL,
  `Contact_No_1` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Contact_No_2` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Brand_Name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Favicon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Twitter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Map` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Keywords` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Active` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL,
  `Created_AT` datetime NOT NULL,
  `Created_BY` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IP` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `Username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Mobile` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `User_Level` int(11) NOT NULL,
  `Profile` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Status` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL,
  `Created_BY` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Created_AT` datetime NOT NULL,
  `IP` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `Username`, `Password`, `Name`, `Mobile`, `Email`, `User_Level`, `Profile`, `Status`, `Created_BY`, `Created_AT`, `IP`) VALUES
(1, 'debasish', '81dc9bdb52d04dc20036dbd8313ed055', 'Debasish Bezborah', '8876044614', 'debu.nzr@gmail.com', -1, NULL, '', 'Administrator', '2023-01-29 12:39:50', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `user_level`
--

CREATE TABLE `user_level` (
  `userlevelid` int(11) NOT NULL,
  `userlevelname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_level`
--

INSERT INTO `user_level` (`userlevelid`, `userlevelname`) VALUES
(-2, 'Anonymous'),
(-1, 'Administrator'),
(0, 'Default');

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `script` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `table` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `field` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keyvalue` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oldvalue` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `newvalue` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`id`, `datetime`, `script`, `user`, `action`, `table`, `field`, `keyvalue`, `oldvalue`, `newvalue`) VALUES
(1, '2023-01-29 10:31:25', '/eksaranbhagawatisamaj/login', 'Administrator', 'login', '::1', '', '', '', ''),
(2, '2023-01-29 10:49:50', '/eksaranbhagawatisamaj/UsersAdd', 'Administrator', 'A', 'users', 'Username', '1', '', 'debasish'),
(3, '2023-01-29 10:49:50', '/eksaranbhagawatisamaj/UsersAdd', 'Administrator', 'A', 'users', 'Password', '1', '', '********'),
(4, '2023-01-29 10:49:50', '/eksaranbhagawatisamaj/UsersAdd', 'Administrator', 'A', 'users', 'Name', '1', '', 'Debasish Bezborah'),
(5, '2023-01-29 10:49:50', '/eksaranbhagawatisamaj/UsersAdd', 'Administrator', 'A', 'users', 'Mobile', '1', '', '8876044614'),
(6, '2023-01-29 10:49:50', '/eksaranbhagawatisamaj/UsersAdd', 'Administrator', 'A', 'users', 'Email', '1', '', 'debu.nzr@gmail.com'),
(7, '2023-01-29 10:49:50', '/eksaranbhagawatisamaj/UsersAdd', 'Administrator', 'A', 'users', 'User_Level', '1', '', '-1'),
(8, '2023-01-29 10:49:50', '/eksaranbhagawatisamaj/UsersAdd', 'Administrator', 'A', 'users', 'Status', '1', '', '1'),
(9, '2023-01-29 10:49:50', '/eksaranbhagawatisamaj/UsersAdd', 'Administrator', 'A', 'users', 'Created_BY', '1', '', 'Administrator'),
(10, '2023-01-29 10:49:50', '/eksaranbhagawatisamaj/UsersAdd', 'Administrator', 'A', 'users', 'Created_AT', '1', '', '2023-01-29 10:49:50'),
(11, '2023-01-29 10:49:50', '/eksaranbhagawatisamaj/UsersAdd', 'Administrator', 'A', 'users', 'IP', '1', '', '::1'),
(12, '2023-01-29 10:49:50', '/eksaranbhagawatisamaj/UsersAdd', 'Administrator', 'A', 'users', 'ID', '1', '', '1'),
(13, '2023-01-29 10:50:02', '/eksaranbhagawatisamaj/logout', 'Administrator', 'logout', '::1', '', '', '', ''),
(14, '2023-01-29 10:50:07', '/eksaranbhagawatisamaj/login', 'debasish', 'login', '::1', '', '', '', ''),
(15, '2023-01-29 12:39:30', '/eksaranbhagawatisamaj/logout', 'debasish', 'logout', '::1', '', '', '', ''),
(16, '2023-01-29 12:39:41', '/eksaranbhagawatisamaj/login', 'Administrator', 'login', '::1', '', '', '', ''),
(17, '2023-01-29 12:39:50', '/eksaranbhagawatisamaj/UsersEdit', 'Administrator', 'U', 'users', 'Status', '1', '1', '0'),
(18, '2023-01-29 12:39:58', '/eksaranbhagawatisamaj/logout', 'Administrator', 'logout', '::1', '', '', '', ''),
(19, '2023-01-29 12:40:06', '/eksaranbhagawatisamaj/login', 'debasish', 'login', '::1', '', '', '', ''),
(20, '2023-01-29 12:40:15', '/eksaranbhagawatisamaj/logout', 'debasish', 'logout', '::1', '', '', '', ''),
(21, '2023-01-29 12:41:31', '/eksaranbhagawatisamaj/login', 'debasish', 'login', '::1', '', '', '', ''),
(22, '2023-01-29 12:42:06', '/eksaranbhagawatisamaj/logout', 'debasish', 'logout', '::1', '', '', '', ''),
(23, '2023-01-29 12:42:18', '/eksaranbhagawatisamaj/login', 'debasish', 'login', '::1', '', '', '', ''),
(24, '2023-01-29 12:42:50', '/eksaranbhagawatisamaj/logout', 'debasish', 'logout', '::1', '', '', '', ''),
(25, '2023-01-29 13:16:16', '/eksaranbhagawatisamaj/login', 'debasish', 'login', '::1', '', '', '', ''),
(26, '2023-01-29 13:16:28', '/eksaranbhagawatisamaj/logout', 'debasish', 'logout', '::1', '', '', '', ''),
(27, '2023-01-29 13:23:09', '/eksaranbhagawatisamaj/login', 'Administrator', 'login', '::1', '', '', '', ''),
(28, '2023-01-29 13:23:17', '/eksaranbhagawatisamaj/logout', 'Administrator', 'logout', '::1', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_permission`
--

CREATE TABLE `user_permission` (
  `userlevelid` int(11) NOT NULL,
  `tablename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_permission`
--

INSERT INTO `user_permission` (`userlevelid`, `tablename`, `permission`) VALUES
(-2, '{514776AE-DABD-4646-A974-0B7DBFD74303}site_settings', 0),
(-2, '{514776AE-DABD-4646-A974-0B7DBFD74303}user_level', 0),
(-2, '{514776AE-DABD-4646-A974-0B7DBFD74303}user_log', 0),
(-2, '{514776AE-DABD-4646-A974-0B7DBFD74303}user_permission', 0),
(-2, '{514776AE-DABD-4646-A974-0B7DBFD74303}users', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `event_category`
--
ALTER TABLE `event_category`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `URL_Slug` (`URL_Slug`);

--
-- Indexes for table `photo_gallery`
--
ALTER TABLE `photo_gallery`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_level`
--
ALTER TABLE `user_level`
  ADD PRIMARY KEY (`userlevelid`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_permission`
--
ALTER TABLE `user_permission`
  ADD PRIMARY KEY (`userlevelid`,`tablename`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_category`
--
ALTER TABLE `event_category`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `links`
--
ALTER TABLE `links`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `photo_gallery`
--
ALTER TABLE `photo_gallery`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
