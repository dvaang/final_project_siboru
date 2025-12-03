-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for siboru
CREATE DATABASE IF NOT EXISTS `siboru` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `siboru`;

-- Dumping structure for table siboru.bookings
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ruangan_id` int NOT NULL,
  `user_id` int NOT NULL,
  `nama_pemesan` varchar(255) NOT NULL,
  `email_pemesan` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `kegiatan` text NOT NULL,
  `surat_izin` varchar(255) DEFAULT NULL,
  `status` enum('diproses','disetujui','ditolak') DEFAULT 'diproses',
  `alasan_penolakan` text,
  `processed_by` int DEFAULT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `notif_panitia` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ruangan_id` (`ruangan_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`ruangan_id`) REFERENCES `ruangan` (`id`),
  CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table siboru.bookings: ~15 rows (approximately)
INSERT INTO `bookings` (`id`, `ruangan_id`, `user_id`, `nama_pemesan`, `email_pemesan`, `tanggal`, `jam_mulai`, `jam_selesai`, `kegiatan`, `surat_izin`, `status`, `alasan_penolakan`, `processed_by`, `processed_at`, `created_at`, `notif_panitia`) VALUES
	(1, 1, 1, 'Panitia Acara', 'panitia@uinjambi.ac.id', '2025-11-27', '08:00:00', '10:00:00', 'seminar', NULL, 'disetujui', '', 19, '2025-11-29 01:13:26', '2025-11-27 02:35:21', 0),
	(2, 2, 10, 'Panitia Kimia', 'panitia_kimia@siboru.com', '2025-11-29', '06:53:00', '06:53:00', 'seminar', '1764374034_Blue Plain Watercolor Stationery A4 Document.pdf', 'disetujui', '', 19, '2025-11-29 01:13:23', '2025-11-28 23:53:54', 0),
	(3, 2, 19, 'Admin SIBORU', 'admin@siboru.com', '2025-11-29', '06:53:00', '06:53:00', 'seminar', '1764374140_Blue Plain Watercolor Stationery A4 Document.pdf', 'disetujui', '', 19, '2025-11-29 01:13:17', '2025-11-28 23:55:40', 0),
	(4, 2, 10, 'Panitia Kimia', 'panitia_kimia@siboru.com', '2025-11-29', '08:00:00', '18:00:00', 'seminar', '1764376334_Blue Plain Watercolor Stationery A4 Document.pdf', 'ditolak', 'sudah ada yang booking\r\n', 19, '2025-11-29 00:51:35', '2025-11-29 00:32:14', 0),
	(5, 2, 10, 'Panitia Kimia', 'panitia_kimia@siboru.com', '2025-11-28', '08:00:00', '18:00:00', 'seminar\r\n', '1764377599_Blue Plain Watercolor Stationery A4 Document.pdf', 'disetujui', '', 19, '2025-11-29 01:12:43', '2025-11-29 00:53:19', 0),
	(6, 2, 9, 'Panitia Fisika', 'panitia_fisika@siboru.com', '2025-11-29', '08:00:00', '08:00:00', 'seminar\r\n', '1764382344_Blue Plain Watercolor Stationery A4 Document.pdf', 'disetujui', NULL, 19, '2025-11-30 13:04:32', '2025-11-29 02:12:24', 0),
	(7, 2, 10, 'Panitia Kimia', 'panitia_kimia@siboru.com', '2025-11-30', '08:00:00', '20:00:00', 'seminar', '1764471797_Blue Plain Watercolor Stationery A4 Document.pdf', 'disetujui', NULL, 19, '2025-11-30 03:03:54', '2025-11-30 03:03:17', 0),
	(8, 4, 10, 'Panitia Kimia', 'panitia_kimia@siboru.com', '2025-11-16', '08:00:00', '20:00:00', 'bedah buku', '1764473879_Blue_Plain_Watercolor_Stationery_A4_Document.pdf', 'disetujui', NULL, 19, '2025-11-30 03:38:18', '2025-11-30 03:37:59', 0),
	(9, 3, 10, 'Panitia Kimia', 'panitia_kimia@siboru.com', '2025-12-01', '08:00:00', '20:00:00', 'seminar\r\n', '1764501393_Blue_Plain_Watercolor_Stationery_A4_Document.pdf', 'disetujui', NULL, 19, '2025-11-30 11:18:53', '2025-11-30 11:16:33', 0),
	(10, 1, 10, 'Panitia Kimia', 'panitia_kimia@siboru.com', '2025-12-01', '06:00:00', '17:00:00', 'bedah buku\r\n', '1764502758_Blue_Plain_Watercolor_Stationery_A4_Document.pdf', 'disetujui', NULL, 19, '2025-11-30 11:51:48', '2025-11-30 11:39:18', 0),
	(11, 6, 10, 'Panitia Kimia', 'panitia_kimia@siboru.com', '2025-12-02', '08:00:00', '17:00:00', 'lomba', '1764503745_Blue_Plain_Watercolor_Stationery_A4_Document.pdf', 'disetujui', NULL, 19, '2025-11-30 11:55:53', '2025-11-30 11:55:45', 0),
	(12, 2, 10, 'Panitia Kimia', 'panitia_kimia@siboru.com', '2025-12-02', '08:00:00', '17:00:00', 'lomba', '1764505094_Blue Plain Watercolor Stationery A4 Document.pdf', 'disetujui', NULL, 19, '2025-11-30 12:18:22', '2025-11-30 12:18:14', 0),
	(13, 4, 10, 'Panitia Kimia', 'panitia_kimia@siboru.com', '2025-11-22', '19:23:00', '12:30:00', 'bedah buku', '1764505459_Blue Plain Watercolor Stationery A4 Document.pdf', 'disetujui', NULL, 19, '2025-11-30 12:28:34', '2025-11-30 12:24:19', 0),
	(14, 1, 9, 'Panitia Fisika', 'panitia_fisika@siboru.com', '2025-12-03', '06:00:00', '17:00:00', 'seminar', '1764506734_Blue Plain Watercolor Stationery A4 Document.pdf', 'disetujui', NULL, 19, '2025-11-30 12:46:00', '2025-11-30 12:45:34', 0),
	(15, 3, 9, 'Panitia Fisika', 'panitia_fisika@siboru.com', '2025-11-12', '07:00:00', '20:00:00', 'seminar', '1764507938_Blue Plain Watercolor Stationery A4 Document.pdf', 'disetujui', NULL, 19, '2025-11-30 13:06:14', '2025-11-30 13:05:38', 0);

-- Dumping structure for table siboru.contacts
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ruangan_id` int NOT NULL,
  `nama_pengelola` varchar(255) NOT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `jam_kerja` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ruangan_id` (`ruangan_id`),
  CONSTRAINT `contacts_ibfk_1` FOREIGN KEY (`ruangan_id`) REFERENCES `ruangan` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table siboru.contacts: ~6 rows (approximately)
INSERT INTO `contacts` (`id`, `ruangan_id`, `nama_pengelola`, `telepon`, `email`, `jam_kerja`) VALUES
	(1, 1, 'Bapak Ahmad Syafii, M.Kom.', '0812-3456-7890', 'auditorium@uinjambi.ac.id', 'Senin - Jumat, 08:00 - 16:00 WIB'),
	(2, 2, 'Ibu Siti Rahayu, S.T.', '0813-4567-8901', 'amphitheater.b@uinjambi.ac.id', 'Senin - Jumat, 08:00 - 16:00 WIB'),
	(3, 3, 'Bapak Rizki Pratama, M.T.', '0814-5678-9012', 'amphitheater.c@uinjambi.ac.id', 'Senin - Jumat, 08:00 - 16:00 WIB'),
	(4, 4, 'Ibu Maya Sari, S.Kom.', '0815-6789-0123', 'teras.kedokteran@uinjambi.ac.id', 'Senin - Jumat, 08:00 - 16:00 WIB'),
	(5, 5, 'Bapak Director of Facilities', '0816-7890-1234', 'ruang.rapat@uinjambi.ac.id', 'Senin - Jumat, 08:00 - 17:00 WIB'),
	(6, 6, 'Ibu Diana Wati, M.Kom.', '0817-8901-2345', 'lab.komputer@uinjambi.ac.id', 'Senin - Sabtu, 07:00 - 18:00 WIB');

-- Dumping structure for table siboru.ratings
CREATE TABLE IF NOT EXISTS `ratings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ruangan_id` int NOT NULL,
  `user_id` int NOT NULL,
  `rating` int NOT NULL,
  `komentar` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ruangan_id` (`ruangan_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`ruangan_id`) REFERENCES `ruangan` (`id`),
  CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `ratings_chk_1` CHECK (((`rating` >= 1) and (`rating` <= 5)))
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table siboru.ratings: ~2 rows (approximately)
INSERT INTO `ratings` (`id`, `ruangan_id`, `user_id`, `rating`, `komentar`, `created_at`) VALUES
	(1, 4, 10, 5, 'baguss', '2025-11-30 03:46:40'),
	(2, 4, 10, 5, 'baguss', '2025-11-30 03:46:48');

-- Dumping structure for table siboru.ruangan
CREATE TABLE IF NOT EXISTS `ruangan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `kapasitas` int DEFAULT NULL,
  `fasilitas` text,
  `lokasi` varchar(255) DEFAULT NULL,
  `status` enum('kosong','terbooking') DEFAULT 'kosong',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table siboru.ruangan: ~6 rows (approximately)
INSERT INTO `ruangan` (`id`, `nama`, `kapasitas`, `fasilitas`, `lokasi`, `status`, `created_at`) VALUES
	(1, 'AUDITORIUM CHATIB QUZWAIN UIN STS JAMBI', 500, 'AC, Proyektor, Sound System, Panggung', 'Gedung Utama', 'terbooking', '2025-11-25 04:48:24'),
	(2, 'AMPHITHAETER WING B GEDUNG GCR', 200, 'AC, Proyektor, Whiteboard', 'Gedung GCR Wing B', 'terbooking', '2025-11-25 04:48:24'),
	(3, 'AMPHITHAETER WING C GEDUNG GCR', 150, 'AC, Proyektor, Sound System', 'Gedung GCR Wing C', 'terbooking', '2025-11-25 04:48:24'),
	(4, 'TERAS KEDOKTERAN GEDUNG GCR', 100, 'AC, Meja Kursi, Whiteboard', 'Gedung GCR Teras Kedokteran', 'terbooking', '2025-11-25 04:48:24'),
	(5, 'RUANG RAPAT GEDUNG REKTORAT', 50, 'AC, Proyektor, Meja Rapat, Sound System', 'Gedung Rektorat', 'kosong', '2025-11-25 04:48:24'),
	(6, 'LABORATORIUM KOMPUTER FTIK', 40, 'AC, Komputer, Proyektor, Jaringan Internet', 'Gedung FTIK', 'terbooking', '2025-11-25 04:48:24');

-- Dumping structure for table siboru.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('panitia','admin') DEFAULT 'panitia',
  `nim` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table siboru.users: ~10 rows (approximately)
INSERT INTO `users` (`id`, `email`, `password`, `name`, `type`, `nim`, `created_at`) VALUES
	(1, 'panitia@uinjambi.ac.id', 'panitia@uinjambi.ac.id', 'Panitia Acara', 'panitia', NULL, '2025-11-25 04:48:24'),
	(2, 'khaila@uinjambi.ac.id', 'khaila123', 'Khaila Aura Nurulhadi', 'panitia', '701230029', '2025-11-25 04:48:24'),
	(3, 'diva@uinjambi.ac.id', 'diva123', 'Diva Angeliana', 'panitia', '701230051', '2025-11-25 04:48:24'),
	(4, 'putri@uinjambi.ac.id', 'putri123', 'Putri Yani Anjali', 'panitia', '701230052', '2025-11-25 04:48:24'),
	(9, 'panitia_fisika@siboru.com', 'panitia123', 'Panitia Fisika', 'panitia', '-', '2025-11-27 02:42:47'),
	(10, 'panitia_kimia@siboru.com', 'panitia123', 'Panitia Kimia', 'panitia', '-', '2025-11-27 02:42:47'),
	(11, 'panitia_si@siboru.com', 'panitia123', 'Panitia Sistem Informasi', 'panitia', '-', '2025-11-27 02:42:47'),
	(12, 'panitia_statistika@siboru.com', 'panitia123', 'Panitia Statistika', 'panitia', '-', '2025-11-27 02:42:47'),
	(13, 'panitia_sainsgeografi@siboru.com', 'panitia123', 'Panitia Sains & Geografi', 'panitia', '-', '2025-11-27 02:42:47'),
	(19, 'admin@siboru.com', 'admin123', 'Admin SIBORU', 'admin', '-', '2025-11-27 02:46:44');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
