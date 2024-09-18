-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 18, 2024 lúc 11:44 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `ahexvps`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `action_task_vps_vn`
--

CREATE TABLE `action_task_vps_vn` (
  `id` int(11) NOT NULL,
  `user_email` text DEFAULT NULL,
  `task` text DEFAULT NULL,
  `value_task` text DEFAULT NULL,
  `id_vps` text DEFAULT NULL,
  `dateCreated` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `agency_data`
--

CREATE TABLE `agency_data` (
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bank_history`
--

CREATE TABLE `bank_history` (
  `id` int(11) NOT NULL,
  `user_email` text DEFAULT NULL,
  `id_pos` text DEFAULT NULL,
  `dateCreated` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bank_invoice`
--

CREATE TABLE `bank_invoice` (
  `id` int(11) NOT NULL,
  `user_email` text DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `type` text DEFAULT NULL,
  `info` text DEFAULT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cards`
--

CREATE TABLE `cards` (
  `id` int(11) NOT NULL,
  `user_id` text DEFAULT NULL,
  `trans_id` varchar(64) DEFAULT NULL,
  `telco` varchar(255) DEFAULT NULL,
  `amount` int(11) NOT NULL DEFAULT 0,
  `price` int(11) NOT NULL DEFAULT 0,
  `serial` text DEFAULT NULL,
  `pin` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `history_trucongtien`
--

CREATE TABLE `history_trucongtien` (
  `id` int(11) NOT NULL,
  `user_email` text DEFAULT NULL,
  `amount` int(11) DEFAULT 0,
  `reason` text DEFAULT NULL,
  `isAdd` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoa_don`
--

CREATE TABLE `hoa_don` (
  `id` int(11) NOT NULL,
  `partner_id` text DEFAULT NULL,
  `user_email` text DEFAULT NULL,
  `info` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `dateCreated` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_email` text DEFAULT NULL,
  `info_log` text DEFAULT NULL,
  `cat_log` text DEFAULT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_vps_vietnam`
--

CREATE TABLE `order_vps_vietnam` (
  `id` int(11) NOT NULL,
  `user_email` text DEFAULT NULL,
  `cpu` int(11) DEFAULT NULL,
  `ram` int(11) DEFAULT NULL,
  `disk` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `billing_cycle` text DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `id_vps` text DEFAULT NULL,
  `os_id` int(11) DEFAULT NULL,
  `date_create` text DEFAULT NULL,
  `next_due_date` text DEFAULT NULL,
  `vps_status` text DEFAULT NULL,
  `is_special` text DEFAULT NULL,
  `ip` text DEFAULT NULL,
  `username` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `note` text DEFAULT NULL,
  `auto_renew` tinyint(1) DEFAULT 0,
  `pricing` int(11) DEFAULT NULL,
  `dateCreate_donhang` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `base64_avt` text DEFAULT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `money` int(11) DEFAULT 0,
  `request_time` datetime DEFAULT current_timestamp(),
  `isband` tinyint(1) DEFAULT 0,
  `isVerify` tinyint(1) DEFAULT 0,
  `ip` text DEFAULT NULL,
  `isGmailLogin` tinyint(1) DEFAULT 0,
  `token` text DEFAULT NULL,
  `iscoWorker` tinyint(1) DEFAULT 0,
  `timeRequestServer` text DEFAULT NULL,
  `phoneNumber` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `useragent` text DEFAULT NULL,
  `total_money` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `verifysession`
--

CREATE TABLE `verifysession` (
  `id` int(11) NOT NULL,
  `email` text NOT NULL,
  `code` text NOT NULL,
  `dateCreated` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `action_task_vps_vn`
--
ALTER TABLE `action_task_vps_vn`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `bank_history`
--
ALTER TABLE `bank_history`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `bank_invoice`
--
ALTER TABLE `bank_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `history_trucongtien`
--
ALTER TABLE `history_trucongtien`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `hoa_don`
--
ALTER TABLE `hoa_don`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `order_vps_vietnam`
--
ALTER TABLE `order_vps_vietnam`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `verifysession`
--
ALTER TABLE `verifysession`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `action_task_vps_vn`
--
ALTER TABLE `action_task_vps_vn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `bank_history`
--
ALTER TABLE `bank_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `bank_invoice`
--
ALTER TABLE `bank_invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `history_trucongtien`
--
ALTER TABLE `history_trucongtien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `hoa_don`
--
ALTER TABLE `hoa_don`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `order_vps_vietnam`
--
ALTER TABLE `order_vps_vietnam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `verifysession`
--
ALTER TABLE `verifysession`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
