-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2021 at 11:50 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `appsadv`
--

-- --------------------------------------------------------

--
-- Table structure for table `ads_id`
--

CREATE TABLE `ads_id` (
  `Id` int(11) NOT NULL,
  `ads_enabled` tinyint(4) NOT NULL DEFAULT 1,
  `adMobBannerId` varchar(255) DEFAULT NULL,
  `adMobInterstitialId` varchar(255) DEFAULT NULL,
  `adMobNativeId` varchar(255) DEFAULT NULL,
  `appOpenId` varchar(255) DEFAULT NULL,
  `app_id` int(11) NOT NULL,
  `fb_ad_banner` varchar(255) DEFAULT NULL,
  `fb_ad_inter` varchar(255) NOT NULL,
  `fb_ad_native` varchar(255) NOT NULL,
  `onesignal_app_id` varchar(255) NOT NULL,
  `onesignal_rest_key` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ads_id`
--

INSERT INTO `ads_id` (`Id`, `ads_enabled`, `adMobBannerId`, `adMobInterstitialId`, `adMobNativeId`, `appOpenId`, `app_id`, `fb_ad_banner`, `fb_ad_inter`, `fb_ad_native`, `onesignal_app_id`, `onesignal_rest_key`) VALUES
(6, 1, 'afknekjfn-ckkandckj-ckkdnklcnlk-camsnk', 'caklnclka-hunter-caklnclkanl-casnkl', 'calkmcklma-hunter-cakncan-acancklnl', 'cakca-hunter-mefmdakma-cndkcan', 14, 'fbbanner-hunter-cakncan-acancklnl', 'fbinter-hunter-killer-acanckjdnvkjn', 'fbnative-sksdnfkjes-fkjenfkd-kejnekfneak', 'onesignalappid-hunter-kvjntkj-akjanekjne', 'onesignalrestkey-hunter-cakncan-akjanekjne');

-- --------------------------------------------------------

--
-- Table structure for table `apks`
--

CREATE TABLE `apks` (
  `Id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `image` varchar(255) DEFAULT NULL,
  `appName` varchar(255) DEFAULT NULL,
  `packageName` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `reference_app` int(11) DEFAULT -1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `apks`
--

INSERT INTO `apks` (`Id`, `status`, `image`, `appName`, `packageName`, `url`, `reference_app`) VALUES
(1, 1, 'AppImages/ABCs_1623470750.jpg', 'ABCs', 'com.hunter.abc', 'https://www.hunter.com/killer', 14),
(2, 1, 'AppImages/COD_1623471042.jpg', 'COD', 'com.cod.package', 'https://www.xyz.com/cod', 14);

-- --------------------------------------------------------

--
-- Table structure for table `apps`
--

CREATE TABLE `apps` (
  `Id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `image` varchar(255) DEFAULT NULL,
  `appName` varchar(255) DEFAULT NULL,
  `packageName` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `reference_app` int(11) DEFAULT -1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `apps`
--

INSERT INTO `apps` (`Id`, `status`, `image`, `appName`, `packageName`, `url`, `reference_app`) VALUES
(14, 0, 'AppImages/Hunter_Killer_1623303914.jpg', 'Hunter Killer', 'com.hunter.xyz', 'https://www.hunter.com/killer', -1);

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `Id` int(11) NOT NULL,
  `app_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`Id`, `app_id`, `image`) VALUES
(1, 14, 'AppImages/Hunter_Killer_1623303914.jpg'),
(3, 14, 'AppImages/Sliders/Hunter_Killer_1623920167.jpg'),
(4, 14, 'AppImages/Sliders/Hunter_Killer_1623923381.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `username`, `password`, `email`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ads_id`
--
ALTER TABLE `ads_id`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `ForeignKey` (`app_id`);

--
-- Indexes for table `apks`
--
ALTER TABLE `apks`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `apps`
--
ALTER TABLE `apps`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `packageName` (`packageName`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ads_id`
--
ALTER TABLE `ads_id`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `apks`
--
ALTER TABLE `apks`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `apps`
--
ALTER TABLE `apps`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ads_id`
--
ALTER TABLE `ads_id`
  ADD CONSTRAINT `ForeignKey` FOREIGN KEY (`app_id`) REFERENCES `apps` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
