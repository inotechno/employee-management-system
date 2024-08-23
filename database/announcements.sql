/*
SQLyog Community v13.2.0 (64 bit)
MySQL - 8.0.34-0ubuntu0.20.04.1 : Database - employee_system
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `employee_system`;

/*Data for the table `announcements` */

insert  into `announcements`(`id`,`subject`,`description`,`created_at`,`updated_at`) values 
(1,'Pengumuman TPM','Diberitahukan kepada seluruh karyawan TPM harus mengikuti hadir','2023-08-28 12:29:25','2023-08-28 12:29:25'),
(2,'Update Android Application','<p>Dear Semua Karyawan,</p><p>Diberitahukan bahwa dengan adanya update pada aplikasi EMS di playstore dengan itu karyawan diharuskan melakukan update di playstore, adapun detail apa saja yang sudah di update pada Mobile / Web yaitu antara lain :</p><ul><li>Penambahan CC daily report ke user lain <b><i>(Mobile / Web)</i></b></li><li>Daily report yang mengirim CC ke user akan tampil pada user tersebut di menu <b>Daily Report For Employee <i>(Web)</i></b></li><li>Penambahan Notification Komentar Daily Report <b><i>(Web)</i></b></li><li>Penambahan fitur forward daily report pada halaman daily report <i><b>(Web)</b></i></li></ul><p>Hanya itu saya yang bisa disampaikan jikalau ada fitur atau proses apapun mengalami masalah silahkan laporkan pada divisi IT.</p><p>Terima Kasih</p>','2023-08-28 19:17:30','2023-08-28 19:17:30');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
