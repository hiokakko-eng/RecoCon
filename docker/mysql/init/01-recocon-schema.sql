-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: mysql307.phy.lolipop.lan
-- 生成日時: 2026 年 11 月 24 日 00:38
-- サーバのバージョン： 8.0.35
-- PHP のバージョン: 8.2.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


-- --------------------------------------------------------

--
-- テーブルの構造 `Concert_Schedule`
--

CREATE TABLE `Concert_Schedule` (
  `cs_id` int NOT NULL,
  `cs_date` date NOT NULL,
  `cs_open` time NOT NULL,
  `cs_start` time NOT NULL,
  `cs_composer_en` varchar(255) NOT NULL,
  `cs_title_en` varchar(255) NOT NULL,
  `cs_composer_jn` varchar(255) NOT NULL,
  `cs_title_jn` varchar(255) NOT NULL,
  `d_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- テーブルの構造 `Disc`
--

CREATE TABLE `Disc` (
  `d_id` int NOT NULL,
  `d_title` varchar(255) NOT NULL,
  `d_detail` text NOT NULL,
  `d_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- テーブルの構造 `Guest`
--

CREATE TABLE `Guest` (
  `g_id` int NOT NULL,
  `g_name` varchar(255) DEFAULT NULL,
  `g_age` int DEFAULT NULL,
  `g_sex` char(1) DEFAULT NULL,
  `g_address_1` varchar(10) DEFAULT NULL,
  `g_address_2` varchar(10) DEFAULT NULL,
  `g_address_3` varchar(255) DEFAULT NULL,
  `g_tel` varchar(255) DEFAULT NULL,
  `g_mail` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- テーブルの構造 `Login_Failed`
--

CREATE TABLE `Login_Failed` (
  `id` int NOT NULL,
  `login_id_hash` binary(32) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `datetime_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `News`
--

CREATE TABLE `News` (
  `n_id` int NOT NULL,
  `n_date` date NOT NULL,
  `news` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- テーブルの構造 `Request`
--

CREATE TABLE `Request` (
  `r_id` int NOT NULL,
  `r_date` date NOT NULL,
  `u_id` int DEFAULT NULL,
  `request` text NOT NULL,
  `answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- テーブルの構造 `Staff`
--

CREATE TABLE `Staff` (
  `s_id` int NOT NULL,
  `s_name` varchar(255) DEFAULT NULL,
  `s_age` int DEFAULT NULL,
  `s_sex` char(1) DEFAULT NULL,
  `s_address_1` varchar(10) DEFAULT NULL,
  `s_address_2` varchar(25) DEFAULT NULL,
  `s_address_3` varchar(255) DEFAULT NULL,
  `s_tel` varchar(255) DEFAULT NULL,
  `s_mail` varchar(255) DEFAULT NULL,
  `s_input_id` varchar(255) DEFAULT NULL,
  `s_input_pass` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- テーブルの構造 `Ticket`
--

CREATE TABLE `Ticket` (
  `seat` char(10) NOT NULL,
  `price` int NOT NULL,
  `tax` int NOT NULL,
  `price_tax` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- テーブルの構造 `Ticket_Sale`
--

CREATE TABLE `Ticket_Sale` (
  `ts_id` int NOT NULL,
  `cs_id` int NOT NULL,
  `seat` varchar(10) NOT NULL,
  `sale` int NOT NULL,
  `u_id` int DEFAULT NULL,
  `g_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- テーブルの構造 `User`
--

CREATE TABLE `User` (
  `u_id` int NOT NULL,
  `u_name` varchar(255) DEFAULT NULL,
  `u_age` int DEFAULT NULL,
  `u_sex` char(1) DEFAULT NULL,
  `u_address_1` varchar(10) DEFAULT NULL,
  `u_address_2` varchar(25) DEFAULT NULL,
  `u_address_3` varchar(255) DEFAULT NULL,
  `u_tel` varchar(255) DEFAULT NULL,
  `u_mail` varchar(255) DEFAULT NULL,
  `u_input_id` varchar(255) DEFAULT NULL,
  `u_input_pass` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `Concert_Schedule`
--
ALTER TABLE `Concert_Schedule`
  ADD PRIMARY KEY (`cs_id`),
  ADD KEY `d_id` (`d_id`);

--
-- テーブルのインデックス `Disc`
--
ALTER TABLE `Disc`
  ADD PRIMARY KEY (`d_id`);

--
-- テーブルのインデックス `Guest`
--
ALTER TABLE `Guest`
  ADD PRIMARY KEY (`g_id`);

--
-- テーブルのインデックス `Login_Failed`
--
ALTER TABLE `Login_Failed`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `News`
--
ALTER TABLE `News`
  ADD PRIMARY KEY (`n_id`);

--
-- テーブルのインデックス `Request`
--
ALTER TABLE `Request`
  ADD PRIMARY KEY (`r_id`),
  ADD KEY `u_id` (`u_id`);

--
-- テーブルのインデックス `Staff`
--
ALTER TABLE `Staff`
  ADD PRIMARY KEY (`s_id`);

--
-- テーブルのインデックス `Ticket`
--
ALTER TABLE `Ticket`
  ADD PRIMARY KEY (`seat`);

--
-- テーブルのインデックス `Ticket_Sale`
--
ALTER TABLE `Ticket_Sale`
  ADD PRIMARY KEY (`ts_id`),
  ADD KEY `u_id` (`u_id`),
  ADD KEY `seat` (`seat`),
  ADD KEY `cs_id` (`cs_id`),
  ADD KEY `g_id` (`g_id`);

--
-- テーブルのインデックス `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`u_id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `Concert_Schedule`
--
ALTER TABLE `Concert_Schedule`
  MODIFY `cs_id` int NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `Disc`
--
ALTER TABLE `Disc`
  MODIFY `d_id` int NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `Guest`
--
ALTER TABLE `Guest`
  MODIFY `g_id` int NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `Login_Failed`
--
ALTER TABLE `Login_Failed`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `News`
--
ALTER TABLE `News`
  MODIFY `n_id` int NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `Request`
--
ALTER TABLE `Request`
  MODIFY `r_id` int NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `Staff`
--
ALTER TABLE `Staff`
  MODIFY `s_id` int NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `Ticket_Sale`
--
ALTER TABLE `Ticket_Sale`
  MODIFY `ts_id` int NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `User`
--
ALTER TABLE `User`
  MODIFY `u_id` int NOT NULL AUTO_INCREMENT;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `Concert_Schedule`
--
ALTER TABLE `Concert_Schedule`
  ADD CONSTRAINT `concert_schedule_ibfk_1` FOREIGN KEY (`d_id`) REFERENCES `Disc` (`d_id`);

--
-- テーブルの制約 `Request`
--
ALTER TABLE `Request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `User` (`u_id`);

--
-- テーブルの制約 `Ticket_Sale`
--
ALTER TABLE `Ticket_Sale`
  ADD CONSTRAINT `ticket_sale_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `User` (`u_id`),
  ADD CONSTRAINT `ticket_sale_ibfk_2` FOREIGN KEY (`seat`) REFERENCES `Ticket` (`seat`),
  ADD CONSTRAINT `ticket_sale_ibfk_3` FOREIGN KEY (`cs_id`) REFERENCES `Concert_Schedule` (`cs_id`),
  ADD CONSTRAINT `ticket_sale_ibfk_4` FOREIGN KEY (`g_id`) REFERENCES `Guest` (`g_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
