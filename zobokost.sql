-- Adminer 4.8.1 MySQL 5.5.5-10.4.21-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

USE `zobokost`;

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `blog`;
CREATE TABLE `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori_id` int(11) NOT NULL,
  `thumbnail` text NOT NULL,
  `judul` text NOT NULL,
  `isi` text NOT NULL,
  `dibuat_oleh` int(10) unsigned DEFAULT NULL,
  `dibuat_pada` int(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `kategori_id` (`kategori_id`),
  KEY `dibuat_oleh` (`dibuat_oleh`),
  CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `blog_ibfk_2` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `blog`;
INSERT INTO `blog` (`id`, `kategori_id`, `thumbnail`, `judul`, `isi`, `dibuat_oleh`, `dibuat_pada`) VALUES
(4,	2,	'Promo-Tangguh-Bersama-Homebanner-Banner-Promo-1.png',	'Aplikasi kost',	'<p><img class=\"img-responsive\" style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"https://127.0.0.1/kost/assets/img/blog/Homebanner-Promo-Page-TOKENSINGGAH.png\" alt=\"\" width=\"594\" height=\"252\" /></p>',	NULL,	1641609627);

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
(25,	1),
(25,	2),
(25,	3),
(25,	4),
(25,	5),
(25,	6),
(25,	7),
(25,	8);

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

DROP TABLE IF EXISTS `kategori_blog`;
CREATE TABLE `kategori_blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `kategori_blog`;
INSERT INTO `kategori_blog` (`id`, `nama_kategori`) VALUES
(2,	'Berita');

DROP TABLE IF EXISTS `kost`;
CREATE TABLE `kost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kost` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `jenis_kost` int(11) NOT NULL,
  `type_kost` int(11) NOT NULL,
  `harga` varchar(50) NOT NULL,
  `area_terdekat` text NOT NULL,
  `operator` int(11) unsigned NOT NULL,
  `unggulan` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `kost` (`jenis_kost`),
  KEY `type_kost` (`type_kost`),
  KEY `operator` (`operator`),
  CONSTRAINT `kost` FOREIGN KEY (`jenis_kost`) REFERENCES `jenis_kost` (`id`),
  CONSTRAINT `kost_ibfk_1` FOREIGN KEY (`type_kost`) REFERENCES `kost_type` (`id`),
  CONSTRAINT `kost_ibfk_2` FOREIGN KEY (`operator`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `kost`;
INSERT INTO `kost` (`id`, `nama_kost`, `alamat`, `jenis_kost`, `type_kost`, `harga`, `area_terdekat`, `operator`, `unggulan`, `update_time`) VALUES
(25,	'PUTU AYU',	'Wonosobo',	3,	2,	'10000000',	'alun alun',	3,	1,	1641955383);

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
(104,	25,	'promo-tangguh-bersama-homebanner-banner-promo-1.png');

DROP TABLE IF EXISTS `kost_pemilik`;
CREATE TABLE `kost_pemilik` (
  `pemilik_id` int(11) unsigned NOT NULL,
  `kost_id` int(11) NOT NULL,
  KEY `pemilik_id` (`pemilik_id`),
  KEY `kost_id` (`kost_id`),
  CONSTRAINT `kost_pemilik_ibfk_1` FOREIGN KEY (`pemilik_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `kost_pemilik_ibfk_2` FOREIGN KEY (`kost_id`) REFERENCES `kost` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `kost_pemilik`;
INSERT INTO `kost_pemilik` (`pemilik_id`, `kost_id`) VALUES
(2,	25);

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
(1,	'127.0.0.1',	'administrator',	'$2y$10$1.4E9R5hlWZgHHxTZx0tK.WjPbZMUspHwoLgh8EZy7lILBvzA6JTG',	'admin@admin.com',	NULL,	'',	NULL,	NULL,	NULL,	NULL,	NULL,	1268889823,	1641954079,	1,	'Admin',	'istrator',	'ADMIN',	'0',	'',	1,	0),
(2,	'127.0.0.1',	NULL,	'$2y$10$x/HrDKHGgz7CB.cnlzWKPOrcMoB06vdEG.QBGMQ5PyeGXgsyUasle',	'ferryakbarardiansyah@gmail.com',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1639465829,	1640745035,	1,	'azrl',	'akbr',	'wonosobon',	'(+62) 81228679721',	'',	0,	1640745051),
(3,	'127.0.0.1',	NULL,	'$2y$10$4vnM.dvP4e1rPlailrdFIuNSKp/2HkN3iFjV3n.vQyNLlt39TSIze',	'ferryar789@gmail.com',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1639813861,	1640745057,	1,	'Akbar',	'',	'Wonosobo',	'+6285640089448',	'76776556_1404306159736687_6385862615276453888_n1.jpg',	0,	0),
(17,	'127.0.0.1',	NULL,	'$2y$10$wrQKc/1NyMvoX.EA4WKqUOBsZbaoGXGtUQGM.mXj48Go3SDurAoii',	'a@gmail.com',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1641362932,	NULL,	1,	'Pemilik',	'1',	'wonosobo',	'08888888',	'mboh.png',	0,	NULL);

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
(22,	2,	3),
(6,	3,	4),
(23,	17,	3);

-- 2022-01-12 03:11:32
