-- --------------------------------------------------------
-- Host: 127.0.0.1
-- Cleaned version for shared hosting
-- --------------------------------------------------------

SET FOREIGN_KEY_CHECKS=0;


-- Table: bookings
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
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `bookings` VALUES
(1,1,1,'Panitia Acara','panitia@uinjambi.ac.id','2025-11-27','08:00:00','10:00:00','seminar',NULL,'disetujui','',19,'2025-11-29 01:13:26','2025-11-27 02:35:21',0),
(2,2,10,'Panitia Kimia','panitia_kimia@siboru.com','2025-11-29','06:53:00','06:53:00','seminar','1764374034.pdf','disetujui','',19,'2025-11-29 01:13:23','2025-11-28 23:53:54',0);


-- Table: contacts
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ruangan_id` int NOT NULL,
  `nama_pengelola` varchar(255) NOT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `jam_kerja` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ruangan_id` (`ruangan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `contacts` VALUES
(1,1,'Bapak Ahmad Syafii, M.Kom.','0812-3456-7890','auditorium@uinjambi.ac.id','Senin - Jumat, 08:00 - 16:00 WIB');


-- Table: ratings
CREATE TABLE IF NOT EXISTS `ratings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ruangan_id` int NOT NULL,
  `user_id` int NOT NULL,
  `rating` int NOT NULL,
  `komentar` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ruangan_id` (`ruangan_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `ratings` VALUES
(1,4,10,5,'baguss','2025-11-30 03:46:40');


-- Table: ruangan
CREATE TABLE IF NOT EXISTS `ruangan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `kapasitas` int DEFAULT NULL,
  `fasilitas` text,
  `lokasi` varchar(255) DEFAULT NULL,
  `status` enum('kosong','terbooking') DEFAULT 'kosong',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Table: users
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` VALUES
(19,'admin@siboru.com','admin123','Admin SIBORU','admin','-', '2025-11-27 02:46:44');


SET FOREIGN_KEY_CHECKS=1;
