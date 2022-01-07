-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2022 at 10:30 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zobokost`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `thumbnail` text NOT NULL,
  `judul` text NOT NULL,
  `isi` text NOT NULL,
  `dibuat_oleh` int(10) UNSIGNED DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `kategori_id`, `thumbnail`, `judul`, `isi`, `dibuat_oleh`, `dibuat_pada`) VALUES
(3, 2, 'Promo-Tangguh-Bersama-Homebanner-Banner-Promo-1.png', 'Aplikasi kost', '<p>asdsdasdasdasd</p>', NULL, '2022-01-07 09:35:38');

-- --------------------------------------------------------

--
-- Table structure for table `carousel_iklan`
--

CREATE TABLE `carousel_iklan` (
  `id` int(11) NOT NULL,
  `foto_iklan` text NOT NULL,
  `level` int(11) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `carousel_iklan`
--

INSERT INTO `carousel_iklan` (`id`, `foto_iklan`, `level`, `keterangan`) VALUES
(1, 'Promo-Tangguh-Bersama-Homebanner-Banner-Promo.png', 1, 'promo 1'),
(2, 'Homebanner-Promo-Page-TOKENSINGGAH.png', 2, 'promo 2');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `kost_id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas_kost`
--

CREATE TABLE `fasilitas_kost` (
  `kost_id` int(11) NOT NULL,
  `fasilitas_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fasilitas_kost`
--

INSERT INTO `fasilitas_kost` (`kost_id`, `fasilitas_id`) VALUES
(24, 1),
(24, 2),
(24, 3),
(24, 4),
(24, 5),
(24, 6),
(24, 7),
(24, 8);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User'),
(3, 'pemilik', 'Pemiilik Kost'),
(4, 'operator', 'operator kost');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_kost`
--

CREATE TABLE `jenis_kost` (
  `id` int(11) NOT NULL,
  `jenis` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jenis_kost`
--

INSERT INTO `jenis_kost` (`id`, `jenis`) VALUES
(1, 'Harian'),
(2, 'Mingguan'),
(3, 'Bulanan'),
(4, 'Tahunan');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_blog`
--

CREATE TABLE `kategori_blog` (
  `id` int(11) NOT NULL,
  `nama_kategori` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori_blog`
--

INSERT INTO `kategori_blog` (`id`, `nama_kategori`) VALUES
(2, 'Berita');

-- --------------------------------------------------------

--
-- Table structure for table `kost`
--

CREATE TABLE `kost` (
  `id` int(11) NOT NULL,
  `nama_kost` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `hp` varchar(20) NOT NULL,
  `jenis_kost` int(11) NOT NULL,
  `type_kost` int(11) NOT NULL,
  `harga` varchar(50) NOT NULL,
  `area_terdekat` text NOT NULL,
  `operator` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kost`
--

INSERT INTO `kost` (`id`, `nama_kost`, `alamat`, `hp`, `jenis_kost`, `type_kost`, `harga`, `area_terdekat`, `operator`) VALUES
(24, 'PUTU AYU', 'Wonosobo', '08888888', 3, 3, '1100000', 'alun alun', 3);

-- --------------------------------------------------------

--
-- Table structure for table `kost_detail`
--

CREATE TABLE `kost_detail` (
  `id` int(11) NOT NULL,
  `id_kost` int(11) NOT NULL,
  `nama_kamar` varchar(50) NOT NULL,
  `deskripsi_kamar` text NOT NULL,
  `harga` varchar(50) NOT NULL,
  `fasilitas` set('Wifi','Kamar Mandi Dalam','Kipas Angin','AC','Makan Pagi','TV','Boleh Bawa Alat Masak','Listrik') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kost_fasilitas`
--

CREATE TABLE `kost_fasilitas` (
  `id` int(11) NOT NULL,
  `fasilitas` text NOT NULL,
  `icon` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kost_fasilitas`
--

INSERT INTO `kost_fasilitas` (`id`, `fasilitas`, `icon`) VALUES
(1, 'Wifi', 'routerWireless'),
(2, 'Kamar Mandi Dalam', 'bathtubOutline'),
(3, 'Kipas Angin', 'fan'),
(4, 'AC', 'airConditioner'),
(5, 'Makan Pagi', 'foodOutline'),
(6, 'TV', 'television'),
(7, 'Boleh Bawa Alat Masak', 'soySauce'),
(8, 'Listrik', 'flash');

-- --------------------------------------------------------

--
-- Table structure for table `kost_foto`
--

CREATE TABLE `kost_foto` (
  `id` int(11) NOT NULL,
  `kost_id` int(11) NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kost_foto`
--

INSERT INTO `kost_foto` (`id`, `kost_id`, `foto`) VALUES
(100, 24, 'a2.png'),
(101, 24, 'promo-tangguh-bersama-homebanner-banner-promo-12.png');

-- --------------------------------------------------------

--
-- Table structure for table `kost_pemilik`
--

CREATE TABLE `kost_pemilik` (
  `pemilik_id` int(11) UNSIGNED NOT NULL,
  `kost_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kost_pemilik`
--

INSERT INTO `kost_pemilik` (`pemilik_id`, `kost_id`) VALUES
(2, 24);

-- --------------------------------------------------------

--
-- Table structure for table `kost_type`
--

CREATE TABLE `kost_type` (
  `id` int(11) NOT NULL,
  `type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kost_type`
--

INSERT INTO `kost_type` (`id`, `type`) VALUES
(1, 'Putra'),
(2, 'Putri'),
(3, 'Campur');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `profil`
--

CREATE TABLE `profil` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `no_wa` text NOT NULL,
  `avatar` text NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `no_wa` varchar(20) DEFAULT NULL,
  `avatar` text DEFAULT NULL,
  `login_status` tinyint(1) DEFAULT NULL,
  `last_logout` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `alamat`, `no_wa`, `avatar`, `login_status`, `last_logout`) VALUES
(1, '127.0.0.1', 'administrator', '$2y$10$1.4E9R5hlWZgHHxTZx0tK.WjPbZMUspHwoLgh8EZy7lILBvzA6JTG', 'admin@admin.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1268889823, 1641527252, 1, 'Admin', 'istrator', 'ADMIN', '0', '', 1, 0),
(2, '127.0.0.1', NULL, '$2y$10$x/HrDKHGgz7CB.cnlzWKPOrcMoB06vdEG.QBGMQ5PyeGXgsyUasle', 'ferryakbarardiansyah@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1639465829, 1640745035, 1, 'azrl', 'akbr', 'wonosobon', '(+62) 81228679721', '', 0, 1640745051),
(3, '127.0.0.1', NULL, '$2y$10$4vnM.dvP4e1rPlailrdFIuNSKp/2HkN3iFjV3n.vQyNLlt39TSIze', 'ferryar789@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1639813861, 1640745057, 1, 'Akbar', '', 'Wonosobo', '+6285640089448', '76776556_1404306159736687_6385862615276453888_n1.jpg', 0, 0),
(17, '127.0.0.1', NULL, '$2y$10$wrQKc/1NyMvoX.EA4WKqUOBsZbaoGXGtUQGM.mXj48Go3SDurAoii', 'a@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1641362932, NULL, 1, 'Pemilik', '1', 'wonosobo', '08888888', 'mboh.png', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(22, 2, 3),
(6, 3, 4),
(23, 17, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`),
  ADD KEY `dibuat_oleh` (`dibuat_oleh`);

--
-- Indexes for table `carousel_iklan`
--
ALTER TABLE `carousel_iklan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `kost_id` (`kost_id`);

--
-- Indexes for table `fasilitas_kost`
--
ALTER TABLE `fasilitas_kost`
  ADD KEY `kost_id` (`kost_id`),
  ADD KEY `fasilitas_id` (`fasilitas_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_kost`
--
ALTER TABLE `jenis_kost`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_blog`
--
ALTER TABLE `kategori_blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kost`
--
ALTER TABLE `kost`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kost` (`jenis_kost`),
  ADD KEY `type_kost` (`type_kost`),
  ADD KEY `operator` (`operator`);

--
-- Indexes for table `kost_detail`
--
ALTER TABLE `kost_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kost` (`id_kost`);

--
-- Indexes for table `kost_fasilitas`
--
ALTER TABLE `kost_fasilitas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kost_foto`
--
ALTER TABLE `kost_foto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kost_id` (`kost_id`);

--
-- Indexes for table `kost_pemilik`
--
ALTER TABLE `kost_pemilik`
  ADD KEY `pemilik_id` (`pemilik_id`),
  ADD KEY `kost_id` (`kost_id`);

--
-- Indexes for table `kost_type`
--
ALTER TABLE `kost_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_email` (`email`),
  ADD UNIQUE KEY `uc_activation_selector` (`activation_selector`),
  ADD UNIQUE KEY `uc_forgotten_password_selector` (`forgotten_password_selector`),
  ADD UNIQUE KEY `uc_remember_selector` (`remember_selector`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `carousel_iklan`
--
ALTER TABLE `carousel_iklan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jenis_kost`
--
ALTER TABLE `jenis_kost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kategori_blog`
--
ALTER TABLE `kategori_blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kost`
--
ALTER TABLE `kost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `kost_detail`
--
ALTER TABLE `kost_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `kost_fasilitas`
--
ALTER TABLE `kost_fasilitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kost_foto`
--
ALTER TABLE `kost_foto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `kost_type`
--
ALTER TABLE `kost_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `profil`
--
ALTER TABLE `profil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `blog_ibfk_2` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`kost_id`) REFERENCES `kost` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fasilitas_kost`
--
ALTER TABLE `fasilitas_kost`
  ADD CONSTRAINT `fasilitas_kost_ibfk_1` FOREIGN KEY (`kost_id`) REFERENCES `kost` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fasilitas_kost_ibfk_2` FOREIGN KEY (`fasilitas_id`) REFERENCES `kost_fasilitas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kost`
--
ALTER TABLE `kost`
  ADD CONSTRAINT `kost` FOREIGN KEY (`jenis_kost`) REFERENCES `jenis_kost` (`id`),
  ADD CONSTRAINT `kost_ibfk_1` FOREIGN KEY (`type_kost`) REFERENCES `kost_type` (`id`),
  ADD CONSTRAINT `kost_ibfk_2` FOREIGN KEY (`operator`) REFERENCES `users` (`id`);

--
-- Constraints for table `kost_detail`
--
ALTER TABLE `kost_detail`
  ADD CONSTRAINT `kost_detail_ibfk_1` FOREIGN KEY (`id_kost`) REFERENCES `kost` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kost_foto`
--
ALTER TABLE `kost_foto`
  ADD CONSTRAINT `kost_foto_ibfk_1` FOREIGN KEY (`kost_id`) REFERENCES `kost` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kost_pemilik`
--
ALTER TABLE `kost_pemilik`
  ADD CONSTRAINT `kost_pemilik_ibfk_1` FOREIGN KEY (`pemilik_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kost_pemilik_ibfk_2` FOREIGN KEY (`kost_id`) REFERENCES `kost` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
