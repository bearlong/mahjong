-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-06-07 05:39:40
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `my_test_db`
--

-- --------------------------------------------------------

--
-- 資料表結構 `brand`
--

CREATE TABLE `brand` (
  `id` int(6) UNSIGNED NOT NULL COMMENT 'AUTO_INCREMENT',
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `brand`
--

INSERT INTO `brand` (`id`, `name`) VALUES
(1, '東方不敗'),
(2, '雀王'),
(3, '貳筒妹祇'),
(4, 'JB雷射雕刻'),
(5, '優童樂生活館'),
(6, '壓克力板小舖'),
(7, 'LA麻將小舖'),
(8, 'GS MALL 專業網路購物網'),
(9, '商密特SUMITMIT'),
(10, '長勝'),
(11, '麻將大俠'),
(12, '雀友'),
(13, '太陽鳥'),
(14, '輝葉良品'),
(15, '妄想Games'),
(16, '哩來哩來桌遊工作室'),
(17, 'itten'),
(18, 'GOTTA2'),
(19, 'Wise Box Games'),
(20, 'GG工作室'),
(21, '山頂洞人實驗室'),
(22, 'Potato Pirates'),
(23, '想要設計桌遊愛樂事'),
(24, '想要設計'),
(25, '迷走工作坊'),
(26, 'Kanga Games'),
(27, '吾托邦桌遊'),
(28, '艸艸工作室'),
(29, 'ILY Games'),
(30, '桌遊鬍子工作室'),
(31, '日出颶風工作室'),
(33, '大玩桌遊'),
(34, 'Origame'),
(35, '鹿言工作室'),
(36, '享想工作室'),
(37, '桌遊鬍子工作室'),
(38, 'Fulelu Edutainment G'),
(39, 'Sugorokuya'),
(41, '複眼狐狸工作室'),
(42, '桌遊列國'),
(43, 'Potato Pirates'),
(44, '日出颶風工作室'),
(45, '深顏色工作室'),
(46, '2Plus桌遊設計工作室'),
(47, '明夷工作室');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'AUTO_INCREMENT', AUTO_INCREMENT=50;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
