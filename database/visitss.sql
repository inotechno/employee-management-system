/*
SQLyog Community v13.2.0 (64 bit)
MySQL - 10.4.27-MariaDB : Database - employee_system
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `employee_system`;

/*Table structure for table `visits` */

CREATE TABLE `visits` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` bigint(20) unsigned NOT NULL,
  `site_id` bigint(20) unsigned NOT NULL,
  `visit_category_id` bigint(20) unsigned DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 CheckIn, 1 CheckOut',
  `file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `visits_employee_id_foreign` (`employee_id`),
  KEY `visits_site_id_foreign` (`site_id`),
  KEY `visits_visit_category_id_foreign` (`visit_category_id`),
  CONSTRAINT `visits_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  CONSTRAINT `visits_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`),
  CONSTRAINT `visits_visit_category_id_foreign` FOREIGN KEY (`visit_category_id`) REFERENCES `visit_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `visits` */

insert  into `visits`(`id`,`employee_id`,`site_id`,`visit_category_id`,`longitude`,`latitude`,`keterangan`,`status`,`file`,`created_at`,`updated_at`) values 
(1,20221205,78,1,'106.7988285','-6.2631265','ho',0,NULL,'2023-07-06 13:52:14','2023-07-06 13:52:14'),
(2,20221224,84,1,'106.7988188','-6.2631156','tes',0,'20230905160214.png','2023-07-08 12:23:48','2023-09-05 16:02:14'),
(3,20221224,80,1,'106.7988063','-6.2631094','test',0,NULL,'2023-07-26 10:44:08','2023-07-26 10:44:08'),
(4,20221224,80,1,'106.7987889','-6.2630854','checkout',1,NULL,'2023-07-26 10:44:23','2023-07-26 10:44:23'),
(5,20221224,80,1,'106.7988536','-6.2631427','bahaha',0,NULL,'2023-07-26 11:37:12','2023-07-26 11:37:12'),
(6,20221224,80,1,'106.7988536','-6.2631427','bahaha',1,NULL,'2023-07-26 11:37:36','2023-07-26 11:37:36'),
(7,20221224,79,1,'106.7988007','-6.2630846','ttgfg',0,NULL,'2023-07-26 11:37:36','2023-07-26 11:37:36'),
(8,20221205,33,1,'106.7897265','-6.1749002','Checkout',1,NULL,'2023-07-10 15:18:56','2023-07-10 15:18:56'),
(9,20230301,33,1,'106.7897267','-6.1748984','Checkout',1,NULL,'2023-07-10 15:19:06','2023-07-10 15:19:06'),
(10,20221224,33,1,'106.7897242','-6.1748974','pasang QR',1,NULL,'2023-07-10 15:48:11','2023-07-10 15:48:11'),
(11,20221224,5,1,'106.7912536','-6.1771586','visit',0,NULL,'2023-07-10 15:48:11','2023-07-10 15:48:11'),
(12,20221205,5,1,'106.791321','-6.1771582','Visit',0,NULL,'2023-07-10 15:48:17','2023-07-10 15:48:17'),
(13,20221205,5,1,'106.7913298','-6.177164','Checkout',1,NULL,'2023-07-10 15:48:58','2023-07-10 15:48:58'),
(14,20230301,5,1,'106.7913645','-6.1771895','visit dan cek area Max Fashion',0,NULL,'2023-07-10 15:50:03','2023-07-10 15:50:03'),
(15,20221224,5,1,'106.7913446','-6.1771618','Checkout',1,NULL,'2023-07-10 15:50:10','2023-07-10 15:50:10'),
(16,20230301,5,1,'106.7913645','-6.1771895','visit dan cek area Max Fashion',1,NULL,'2023-07-10 16:04:32','2023-07-10 16:04:32'),
(17,20230301,56,1,'106.7912419','-6.1773987','Visit dan Cek personil Sephora CP',0,NULL,'2023-07-10 16:04:32','2023-07-10 16:04:32'),
(18,20221205,56,1,'106.7914411','-6.1774381','visit',0,NULL,'2023-07-10 16:04:49','2023-07-10 16:04:49'),
(19,20221224,56,1,'106.7914861','-6.1774172','sophoro',0,NULL,'2023-07-10 16:04:57','2023-07-10 16:04:57'),
(20,20221205,56,1,'106.7915917','-6.1774888','Checkout',1,NULL,'2023-07-10 16:06:05','2023-07-10 16:06:05'),
(21,20230301,56,1,'106.7913343','-6.1774259','Checkout',1,NULL,'2023-07-10 16:06:19','2023-07-10 16:06:19'),
(22,20221224,56,1,'106.7914861','-6.1774172','sophoro',1,NULL,'2023-07-10 17:24:29','2023-07-10 17:24:29'),
(23,20221224,26,1,'106.7900338','-6.1786263','visit 3',0,NULL,'2023-07-10 17:24:29','2023-07-10 17:24:29'),
(24,20221205,26,1,'106.7900318','-6.1786273','visit',0,NULL,'2023-07-10 17:33:50','2023-07-10 17:33:50'),
(25,20230301,26,1,'106.7900338','-6.1786288','Visit dan cek area Sogo CP',0,NULL,'2023-07-10 17:34:59','2023-07-10 17:34:59'),
(26,20230301,26,1,'106.7900351','-6.1786289','Checkout',1,NULL,'2023-07-10 18:43:03','2023-07-10 18:43:03'),
(27,20221205,26,1,'106.7900345','-6.1786371','Checkout',1,NULL,'2023-07-10 18:43:10','2023-07-10 18:43:10'),
(28,20221224,61,1,'106.9088789','-6.1567795','visit mkg',0,NULL,'2023-07-11 13:38:30','2023-07-11 13:38:30'),
(29,20221205,61,1,'106.9088455','-6.1567643','visit koordinasi dgn Ibu Desi (SM) terkait kinerja personil',0,NULL,'2023-07-11 13:39:04','2023-07-11 13:39:04'),
(30,20221224,61,1,'106.9088789','-6.1567795','visit mkg',1,NULL,'2023-07-11 13:45:19','2023-07-11 13:45:19'),
(31,20221224,64,1,'106.9084603','-6.156642','visit',0,NULL,'2023-07-11 13:45:19','2023-07-11 13:45:19'),
(32,20221224,8,1,'106.9091532','-6.1560567','baby shop mkg',0,NULL,'2023-07-11 15:00:21','2023-07-11 15:00:21'),
(33,20221224,8,1,'106.9091532','-6.1560567','baby shop mkg',1,NULL,'2023-07-11 15:50:25','2023-07-11 15:50:25'),
(34,20221224,35,1,'106.8714157','-6.1382004','visit sunter',0,NULL,'2023-07-11 15:50:25','2023-07-11 15:50:25'),
(35,20221224,16,1,'106.9849725','-6.2496006','max fashion grand metropolitan bekasi',0,NULL,'2023-07-14 14:55:16','2023-07-14 14:55:16'),
(36,20221228,16,1,'106.9849415','-6.2496149','visit max fashion grand metropolitan bekasi',0,NULL,'2023-07-14 15:08:37','2023-07-14 15:08:37'),
(37,20221224,16,1,'106.9849725','-6.2496006','max fashion grand metropolitan bekasi',1,NULL,'2023-07-14 17:35:15','2023-07-14 17:35:15'),
(38,20221224,72,1,'107.1394803','-6.3006794','visit app',0,NULL,'2023-07-14 17:35:15','2023-07-14 17:35:15'),
(39,20221228,16,1,'106.9849415','-6.2496149','visit max fashion grand metropolitan bekasi',1,NULL,'2023-07-14 17:41:16','2023-07-14 17:41:16'),
(40,20221228,72,1,'107.1394295','-6.3005883','Visit App KTM',0,NULL,'2023-07-14 17:41:16','2023-07-14 17:41:16'),
(41,20221224,51,1,'106.8165056','-6.1771573','pakarti center',0,NULL,'2023-07-16 10:49:42','2023-07-16 10:49:42'),
(42,20230103,16,1,'106.9593064','-6.2486059','Kunjungan dan Kordinasi dgn store manager perihal BKO untuk outing tim Max Fashion dan kordinasi training',0,NULL,'2023-07-18 13:58:28','2023-07-18 13:58:28'),
(43,20230103,16,1,'106.9846169','-6.2493312','Selesai visit dgn manager soter perihal training tgl 31 Juli 2023\r\nDan BKO utk outing',1,NULL,'2023-07-18 15:00:50','2023-07-18 15:00:50'),
(44,20230103,8,1,'106.9093069','-6.15568','Visit dan Kordinasi perihal training utk tgl 31 Juli 2023',0,NULL,'2023-07-26 12:11:55','2023-07-26 12:11:55'),
(45,20221220,63,1,'106.8204912','-6.1952663','berska GI',0,NULL,'2023-07-27 14:34:53','2023-07-27 14:34:53'),
(46,20221220,63,1,'106.8204912','-6.1952663','berska GI',1,NULL,'2023-07-27 14:41:58','2023-07-27 14:41:58'),
(47,20221220,57,1,'106.819604','-6.1948795','sephora GI',0,NULL,'2023-07-27 14:41:58','2023-07-27 14:41:58'),
(48,20221220,57,1,'106.819604','-6.1948795','sephora GI',1,NULL,'2023-07-27 15:08:25','2023-07-27 15:08:25'),
(49,20221220,30,1,'106.8196395','-6.1955341','seibu GI',0,NULL,'2023-07-27 15:08:25','2023-07-27 15:08:25'),
(50,20221220,36,1,'106.819571','-6.1957467','foodhall GI',0,NULL,'2023-07-27 15:13:54','2023-07-27 15:13:54'),
(51,20221220,36,1,'106.8195686','-6.1957461','checkout foodhall gi',1,NULL,'2023-07-27 15:14:12','2023-07-27 15:14:12'),
(52,20221220,67,1,'106.8197858','-6.1951667','kinokunia GI',0,NULL,'2023-07-27 15:52:18','2023-07-27 15:52:18'),
(53,20221220,67,1,'106.8197858','-6.1951667','kinokunia GI',1,NULL,'2023-07-27 16:10:48','2023-07-27 16:10:48'),
(54,20221220,64,1,'106.8200272','-6.1955043','m dan S GI',0,NULL,'2023-07-27 16:10:48','2023-07-27 16:10:48'),
(55,20221220,68,1,'107.1340363','-6.3412607','visit mitsubishi',0,NULL,'2023-07-28 18:14:26','2023-07-28 18:14:26'),
(56,20221228,72,1,'107.1394295','-6.3005883','Visit App KTM',1,NULL,'2023-07-28 18:55:04','2023-07-28 18:55:04'),
(57,20221228,68,1,'107.1340009','-6.3412338','kunjungan meaina',0,NULL,'2023-07-28 18:55:04','2023-07-28 18:55:04'),
(58,20221220,68,1,'107.1340363','-6.3412607','visit mitsubishi',1,NULL,'2023-08-01 14:47:40','2023-08-01 14:47:40'),
(59,20221220,47,1,'106.8121346','-6.2465154','visit tarki',0,NULL,'2023-08-01 14:47:40','2023-08-01 14:47:40'),
(60,20221228,47,1,'106.8121763','-6.2464916','Visit Sekolah Tarakanita Polo Raya',0,NULL,'2023-08-01 14:49:24','2023-08-01 14:49:24'),
(61,20221228,47,1,'106.8122929','-6.2465198','Visit selesak',1,NULL,'2023-08-01 14:52:28','2023-08-01 14:52:28'),
(62,20230103,8,1,'106.9093069','-6.15568','Visit dan Kordinasi perihal training utk tgl 31 Juli 2023',1,NULL,'2023-08-02 16:45:39','2023-08-02 16:45:39'),
(63,20230103,16,1,'106.892274','-6.2294808','Visit dan kordinasi site Max Fashion Grand metropolitan Bekasi',0,NULL,'2023-08-02 16:45:39','2023-08-02 16:45:39'),
(64,20230103,16,1,'106.8674862','-6.3303388','Kordinasi selesai perihal Kerapihan kerja',1,NULL,'2023-08-02 17:54:14','2023-08-02 17:54:14'),
(65,20221220,70,1,'106.537405','-6.2154878','visit pt hema 1',0,NULL,'2023-08-03 11:36:48','2023-08-03 11:36:48'),
(66,20221220,70,1,'106.537405','-6.2154878','visit pt hema 1',1,NULL,'2023-08-03 14:19:06','2023-08-03 14:19:06'),
(67,20221220,75,1,'106.6847751','-6.1056098','bollore 1',0,NULL,'2023-08-03 14:19:06','2023-08-03 14:19:06'),
(68,20221228,75,1,'106.6847755','-6.1055528','Visit Site Bolore LV',0,NULL,'2023-08-03 14:20:33','2023-08-03 14:20:33'),
(69,20221220,41,1,'107.3072542','-6.3094273','visit jil ramayana karawang',0,NULL,'2023-08-04 15:40:57','2023-08-04 15:40:57'),
(70,20221220,41,1,'107.3072542','-6.3094273','visit jil ramayana karawang',1,NULL,'2023-08-04 17:23:31','2023-08-04 17:23:31'),
(71,20221220,52,1,'107.1584752','-6.3719252','pakarti jaya',0,NULL,'2023-08-04 17:23:31','2023-08-04 17:23:31'),
(72,20221228,75,1,'106.6847755','-6.1055528','Visit Site Bolore LV',1,NULL,'2023-08-04 17:34:13','2023-08-04 17:34:13'),
(73,20221228,52,1,'107.1584998','-6.3719378','Visit site Pakarti Delta Silicon 3',0,NULL,'2023-08-04 17:34:13','2023-08-04 17:34:13'),
(74,20221224,84,1,'106.7987698','-6.263168','head office',1,NULL,'2023-08-07 18:43:54','2023-08-07 18:43:54'),
(75,20221224,84,1,'106.798749','-6.2630915','tes qr',0,NULL,'2023-08-08 09:10:32','2023-08-08 09:10:32'),
(76,20230103,16,1,'106.9857759','-6.2480385','Visit dan antar MR',0,NULL,'2023-08-08 10:09:05','2023-08-08 10:09:05'),
(77,20221205,61,1,'106.9088668','-6.1567706','visit',1,NULL,'2023-08-08 11:10:12','2023-08-08 11:10:12'),
(78,20221205,61,1,'106.9088229','-6.1567562','Visit',0,NULL,'2023-08-08 11:12:45','2023-08-08 11:12:45'),
(79,20221205,61,1,'106.9088229','-6.1567562','Visit',1,NULL,'2023-08-08 11:18:08','2023-08-08 11:18:08'),
(80,20221205,34,1,'106.9084649','-6.1564471','visit',0,NULL,'2023-08-08 11:18:08','2023-08-08 11:18:08'),
(81,20221205,34,1,'106.9084721','-6.1564483','visit fhkg',1,NULL,'2023-08-08 11:51:18','2023-08-08 11:51:18'),
(82,20221205,57,1,'106.8196252','-6.1949137','visit',0,NULL,'2023-08-08 14:05:45','2023-08-08 14:05:45'),
(83,20221205,57,1,'106.8196252','-6.1949137','visit',1,NULL,'2023-08-08 14:05:45','2023-08-08 14:05:45'),
(84,20221205,64,1,'106.8201045','-6.1955043','visit',0,NULL,'2023-08-08 14:26:18','2023-08-08 14:26:18'),
(85,20221205,64,1,'106.8201045','-6.1955043','visit',1,NULL,'2023-08-08 14:53:01','2023-08-08 14:53:01'),
(86,20221205,63,1,'106.8203997','-6.1952997','koordinasi dengan Pak Rocky (PIC)',0,NULL,'2023-08-08 14:53:01','2023-08-08 14:53:01'),
(87,20221205,63,1,'106.8203997','-6.1952997','koordinasi dengan Pak Rocky (PIC)',1,NULL,'2023-08-09 10:41:36','2023-08-09 10:41:36'),
(88,20221205,56,1,'106.7912445','-6.1773368','Visit',0,NULL,'2023-08-09 10:41:36','2023-08-09 10:41:36'),
(89,20221205,56,1,'106.7912445','-6.1773368','Visit',1,NULL,'2023-08-11 17:26:26','2023-08-11 17:26:26'),
(90,20221205,57,1,'106.8196299','-6.1948794','Visit Sephora , koordinasi dengan pak Erman',1,NULL,'2023-08-11 17:26:26','2023-08-11 17:26:26'),
(91,20221205,61,1,'106.9088521','-6.1567663','Visit Cek Kinerja personil',0,NULL,'2023-08-15 14:08:12','2023-08-15 14:08:12'),
(92,20221205,61,1,'106.9088521','-6.1567663','Visit Cek Kinerja personil',1,NULL,'2023-08-15 14:16:12','2023-08-15 14:16:12'),
(93,20221205,28,1,'106.9078571','-6.1561537','visit Sogo KG',0,NULL,'2023-08-15 14:16:12','2023-08-15 14:16:12'),
(94,20221228,28,1,'106.907919','-6.1561195','Visit dan meeting',0,NULL,'2023-08-15 15:18:13','2023-08-15 15:18:13'),
(95,20230103,16,1,'106.9838878','-6.2487488','Visit dan kordinasi hasil kerja dan jadwal kerja',1,NULL,'2023-08-16 10:24:02','2023-08-16 10:24:02'),
(96,20221224,84,1,'106.798749','-6.2630915','tes qr',1,NULL,'2023-08-16 11:25:19','2023-08-16 11:25:19'),
(97,20221224,53,1,'106.7987597','-6.2629929','visit asea',0,NULL,'2023-08-16 11:25:19','2023-08-16 11:25:19'),
(98,20221228,28,1,'106.907919','-6.1561195','Visit dan meeting',1,NULL,'2023-08-16 12:58:33','2023-08-16 12:58:33'),
(99,20221228,93,1,'106.8537278','-6.2541216','Vist',0,NULL,'2023-08-16 12:58:33','2023-08-16 12:58:33'),
(100,20221228,53,1,'106.8291948','-6.1622718','Visit',0,NULL,'2023-08-16 15:07:31','2023-08-16 15:07:31'),
(101,20221228,53,1,'106.8292646','-6.1622672','Visit',1,NULL,'2023-08-16 16:36:59','2023-08-16 16:36:59'),
(102,20221228,68,1,'107.1339673','-6.3412389','Visit dan Rrfresh Trining',1,NULL,'2023-08-19 07:50:53','2023-08-19 07:50:53'),
(103,20221228,68,1,'107.1340441','-6.341269','Visit dan Refresh Training',0,NULL,'2023-08-19 12:32:06','2023-08-19 12:32:06'),
(104,20221224,53,1,'106.7987597','-6.2629929','visit asea',1,NULL,'2023-08-19 12:34:46','2023-08-19 12:34:46'),
(105,20221224,8,1,'106.798762','-6.2631206','visit baby shop mkg',0,NULL,'2023-08-19 12:34:46','2023-08-19 12:34:46'),
(106,20221228,68,1,'107.1340441','-6.341269','Visit dan Refresh Training',1,NULL,'2023-08-19 12:55:56','2023-08-19 12:55:56'),
(107,20221228,72,1,'107.1394596','-6.3007739','Visit Site App Ktm',0,NULL,'2023-08-19 12:55:56','2023-08-19 12:55:56'),
(108,20221228,72,1,'107.1394274','-6.300701','Visit site App Ktm',1,NULL,'2023-08-19 13:58:33','2023-08-19 13:58:33'),
(109,20230103,5,1,'106.7907171','-6.1781737','Kordinasi dgn management Max Fashion dan antar sertifikat cleaning',0,NULL,'2023-08-21 13:47:04','2023-08-21 13:47:04'),
(110,20230103,5,1,'106.7911498','-6.1776339','Cek hasil grooming\r\nCek kebersihan lokasi\r\nCek peralatan kondisi rapih dan tertata',1,NULL,'2023-08-21 14:36:14','2023-08-21 14:36:14'),
(111,20221220,107,1,'106.8199562','-6.183717','visit iamajaya',0,NULL,'2023-08-23 11:36:49','2023-08-23 11:36:49'),
(112,20221228,47,1,'106.8122313','-6.2464815','Visit dan koordinasi',0,NULL,'2023-08-28 10:26:23','2023-08-28 10:26:23'),
(113,20221228,47,1,'106.8123356','-6.2463952','Visit dan koordinasi',1,NULL,'2023-08-28 13:28:38','2023-08-28 13:28:38'),
(114,20221205,28,1,'106.9078571','-6.1561537','visit Sogo KG',1,NULL,'2023-08-30 10:28:37','2023-08-30 10:28:37'),
(115,20221205,51,1,'106.8162906','-6.1772953','Visit',0,NULL,'2023-08-30 10:28:37','2023-08-30 10:28:37'),
(116,20230103,8,1,'106.9092244','-6.15583','Visit dan kordinasi site Baby Shop Mall kelapa Gading, perihal BKO, karena yg SDR Roni sakit',0,NULL,'2023-08-30 11:24:14','2023-08-30 11:24:14'),
(117,20221228,68,1,'107.1340397','-6.3412202','Visit dan Meeting',0,NULL,'2023-08-30 11:48:22','2023-08-30 11:48:22'),
(118,20221228,68,1,'107.1338356','-6.3411289','Visit dan meeting',1,NULL,'2023-08-30 17:08:50','2023-08-30 17:08:50'),
(119,20221205,51,1,'106.8162906','-6.1772953','Visit',1,NULL,'2023-08-30 17:58:51','2023-08-30 17:58:51'),
(120,20221205,57,1,'106.8196828','-6.1948814','Cek Personil',0,NULL,'2023-08-30 17:58:51','2023-08-30 17:58:51'),
(121,20221205,57,1,'106.8196828','-6.1948814','Cek Personil',1,NULL,'2023-09-01 09:50:30','2023-09-01 09:50:30'),
(122,20221205,107,1,'106.8199598','-6.1836699','Visit Koordinasi dengan Pak Adit (HR)',0,NULL,'2023-09-01 09:50:30','2023-09-01 09:50:30'),
(123,20221205,107,1,'106.8199865','-6.1836532','visit dan Kordinasi dengan Pak Asit',1,NULL,'2023-09-01 09:54:16','2023-09-01 09:54:16'),
(124,20221228,28,1,'106.907889','-6.1561578','Visit dan meeting',0,NULL,'2023-09-01 15:20:40','2023-09-01 15:20:40'),
(125,20221228,28,1,'106.907889','-6.1561578','Visit dan meeting',1,NULL,'2023-09-01 16:56:17','2023-09-01 16:56:17'),
(126,20221228,68,1,'107.1340827','-6.3412339','Visit',0,NULL,'2023-09-01 16:56:17','2023-09-01 16:56:17'),
(127,20221228,68,1,'107.1339475','-6.3412621','Visit',1,NULL,'2023-09-01 18:30:52','2023-09-01 18:30:52'),
(128,20221228,68,1,'107.1340733','-6.3411985','Visit dan Meeting',0,NULL,'2023-09-02 09:35:42','2023-09-02 09:35:42'),
(129,20221228,68,1,'107.1340928','-6.3411425','Visit',1,NULL,'2023-09-02 16:38:38','2023-09-02 16:38:38'),
(130,20221228,68,1,'107.1342292','-6.3415506','Visit , meeting dan Inventigasi',0,NULL,'2023-09-05 08:32:27','2023-09-05 08:32:27');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
