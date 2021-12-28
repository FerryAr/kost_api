-- Adminer 4.8.1 MySQL 5.5.5-10.4.21-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `zobokost`;
CREATE DATABASE `zobokost` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `zobokost`;

DROP TABLE IF EXISTS `carousel_iklan`;
CREATE TABLE `carousel_iklan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `foto_iklan` text NOT NULL,
  `level` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `carousel_iklan`;
INSERT INTO `carousel_iklan` (`id`, `foto_iklan`, `level`, `keterangan`) VALUES
(1,	'Promo-Tangguh-Bersama-Homebanner-Banner-Promo.png',	1,	'promo 1'),
(2,	'Homebanner-Promo-Page-TOKENSINGGAH.png',	2,	'promo 2');

DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `user_id` int(10) unsigned NOT NULL,
  `kost_id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `kost_id` (`kost_id`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`kost_id`) REFERENCES `kost` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `cart`;

DROP TABLE IF EXISTS `fasilitas_kost`;
CREATE TABLE `fasilitas_kost` (
  `kost_id` int(11) NOT NULL,
  `fasilitas_id` int(11) NOT NULL,
  KEY `kost_id` (`kost_id`),
  KEY `fasilitas_id` (`fasilitas_id`),
  CONSTRAINT `fasilitas_kost_ibfk_1` FOREIGN KEY (`kost_id`) REFERENCES `kost` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fasilitas_kost_ibfk_2` FOREIGN KEY (`fasilitas_id`) REFERENCES `kost_fasilitas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `fasilitas_kost`;
INSERT INTO `fasilitas_kost` (`kost_id`, `fasilitas_id`) VALUES
(21,	1),
(21,	2),
(22,	1),
(22,	2),
(22,	3),
(22,	4),
(22,	5),
(22,	6),
(22,	7),
(22,	8);

DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE `groups`;
INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1,	'admin',	'Administrator'),
(2,	'members',	'General User'),
(3,	'pemilik',	'Pemiilik Kost'),
(4,	'operator',	'operator kost');

DROP TABLE IF EXISTS `jenis_kost`;
CREATE TABLE `jenis_kost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `jenis_kost`;
INSERT INTO `jenis_kost` (`id`, `jenis`) VALUES
(1,	'Harian'),
(2,	'Mingguan'),
(3,	'Bulanan'),
(4,	'Tahunan');

DROP TABLE IF EXISTS `kost`;
CREATE TABLE `kost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kost` varchar(50) NOT NULL,
  `pemilik` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `hp` varchar(20) NOT NULL,
  `jenis_kost` int(11) NOT NULL,
  `type_kost` int(11) NOT NULL,
  `harga` varchar(50) NOT NULL,
  `area_terdekat` text NOT NULL,
  `operator` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `kost` (`jenis_kost`),
  KEY `type_kost` (`type_kost`),
  KEY `operator` (`operator`),
  CONSTRAINT `kost` FOREIGN KEY (`jenis_kost`) REFERENCES `jenis_kost` (`id`),
  CONSTRAINT `kost_ibfk_1` FOREIGN KEY (`type_kost`) REFERENCES `kost_type` (`id`),
  CONSTRAINT `kost_ibfk_2` FOREIGN KEY (`operator`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `kost`;
INSERT INTO `kost` (`id`, `nama_kost`, `pemilik`, `alamat`, `hp`, `jenis_kost`, `type_kost`, `harga`, `area_terdekat`, `operator`) VALUES
(21,	'A',	'azrl',	'Wonosobo',	'08888888',	3,	3,	'10000',	'dffff',	3),
(22,	'PUTU AYU',	'azrl',	'Wonosobo',	'08888888',	3,	2,	'1100000',	'Alun - ALun',	3);

DROP TABLE IF EXISTS `kost_detail`;
CREATE TABLE `kost_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_kost` int(11) NOT NULL,
  `nama_kamar` varchar(50) NOT NULL,
  `deskripsi_kamar` text NOT NULL,
  `harga` varchar(50) NOT NULL,
  `fasilitas` set('Wifi','Kamar Mandi Dalam','Kipas Angin','AC','Makan Pagi','TV','Boleh Bawa Alat Masak','Listrik') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_kost` (`id_kost`),
  CONSTRAINT `kost_detail_ibfk_1` FOREIGN KEY (`id_kost`) REFERENCES `kost` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `kost_detail`;

DROP TABLE IF EXISTS `kost_fasilitas`;
CREATE TABLE `kost_fasilitas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fasilitas` text NOT NULL,
  `icon` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `kost_fasilitas`;
INSERT INTO `kost_fasilitas` (`id`, `fasilitas`, `icon`) VALUES
(1,	'Wifi',	'routerWireless'),
(2,	'Kamar Mandi Dalam',	'bathtubOutline'),
(3,	'Kipas Angin',	'fan'),
(4,	'AC',	'airConditioner'),
(5,	'Makan Pagi',	'foodOutline'),
(6,	'TV',	'television'),
(7,	'Boleh Bawa Alat Masak',	'soySauce'),
(8,	'Listrik',	'flash');

DROP TABLE IF EXISTS `kost_foto`;
CREATE TABLE `kost_foto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kost_id` int(11) NOT NULL,
  `foto` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `kost_id` (`kost_id`),
  CONSTRAINT `kost_foto_ibfk_1` FOREIGN KEY (`kost_id`) REFERENCES `kost` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `kost_foto`;
INSERT INTO `kost_foto` (`id`, `kost_id`, `foto`) VALUES
(94,	21,	'a1.png'),
(95,	21,	'mboh1.png'),
(96,	22,	'promo-tangguh-bersama-homebanner-banner-promo-1.png'),
(97,	22,	'promo-tangguh-bersama-homebanner-banner-promo.png');

DROP TABLE IF EXISTS `kost_type`;
CREATE TABLE `kost_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `kost_type`;
INSERT INTO `kost_type` (`id`, `type`) VALUES
(1,	'Putra'),
(2,	'Putri'),
(3,	'Campur');

DROP TABLE IF EXISTS `login_attempts`;
CREATE TABLE `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE `login_attempts`;

DROP TABLE IF EXISTS `profil`;
CREATE TABLE `profil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `no_wa` text NOT NULL,
  `avatar` text NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `profil`;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `no_wa` varchar(20) DEFAULT NULL,
  `avatar` text DEFAULT NULL,
  `login_status` tinyint(1) DEFAULT NULL,
  `last_logout` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_email` (`email`),
  UNIQUE KEY `uc_activation_selector` (`activation_selector`),
  UNIQUE KEY `uc_forgotten_password_selector` (`forgotten_password_selector`),
  UNIQUE KEY `uc_remember_selector` (`remember_selector`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE `users`;
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `alamat`, `no_wa`, `avatar`, `login_status`, `last_logout`) VALUES
(1,	'127.0.0.1',	'administrator',	'$2y$10$1.4E9R5hlWZgHHxTZx0tK.WjPbZMUspHwoLgh8EZy7lILBvzA6JTG',	'admin@admin.com',	NULL,	'',	NULL,	NULL,	NULL,	NULL,	NULL,	1268889823,	1639982952,	1,	'Admin',	'istrator',	'ADMIN',	'0',	'',	0,	NULL),
(2,	'127.0.0.1',	NULL,	'$2y$10$x/HrDKHGgz7CB.cnlzWKPOrcMoB06vdEG.QBGMQ5PyeGXgsyUasle',	'ferryakbarardiansyah@gmail.com',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1639465829,	1640332349,	1,	'azrl',	'akbr',	'a',	'(+62) 81228679721',	'',	0,	NULL),
(3,	'127.0.0.1',	NULL,	'$2y$10$4vnM.dvP4e1rPlailrdFIuNSKp/2HkN3iFjV3n.vQyNLlt39TSIze',	'ferryar789@gmail.com',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1639813861,	1640584815,	1,	'Akbar',	'',	'Wonosobo',	'+6285640089448',	'76776556_1404306159736687_6385862615276453888_n1.jpg',	0,	1640586436),
(16,	'192.168.157.126',	NULL,	'$2y$10$Ie5X59u.qjZ.ktCD5ffIteGT4pL1PH1X/6.eXfgQnMM6mxtWvao8m',	'shiinamash23@gmail.com ',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1640680716,	NULL,	1,	'Shiina',	'Mashiro',	NULL,	'0888888',	'image_picker3245271196429906581.jpg',	NULL,	NULL);

DROP TABLE IF EXISTS `users_groups`;
CREATE TABLE `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE `users_groups`;
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1,	1,	1),
(2,	1,	2),
(7,	2,	3),
(6,	3,	4),
(20,	16,	2);

-- 2021-12-28 09:10:55
