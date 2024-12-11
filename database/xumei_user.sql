/*
SQLyog Community v13.2.0 (64 bit)
MySQL - 8.0.39-0ubuntu0.22.04.1 : Database - xumei_psikotesdaring
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `xumei_psikotesdaring`;

/*Table structure for table `users` */

CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(300) DEFAULT NULL,
  `gender` int DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `education` int DEFAULT NULL,
  `backup_idprovince` int DEFAULT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `role_id` enum('user','admin') DEFAULT 'user',
  `verification_code` varchar(50) NOT NULL,
  `status` int NOT NULL,
  `reg_on_device` varchar(50) DEFAULT NULL,
  `media_information` varchar(255) DEFAULT NULL,
  `subdistrict_id` bigint unsigned DEFAULT NULL,
  `photo` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  KEY `birthday_key` (`birthday`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `users` */

insert  into `users`(`user_id`,`name`,`email`,`password`,`gender`,`birthday`,`education`,`backup_idprovince`,`phone`,`role_id`,`verification_code`,`status`,`reg_on_device`,`media_information`,`subdistrict_id`,`photo`,`created_at`) values 
(1,'PT Xumei Food Tech Indonesia','ferdie.djunaedi@xumei.id','$2y$10$R9WFAOdKyCqeme8NizTxF.BfnauhUthnNAtl3axfZJCNgujDTGBdi',1,'2024-08-19',1,NULL,'62082112089958','admin','1',1,NULL,NULL,2089,'https://storage.googleapis.com/psikotesdaring.com/images/clients/6fd769ad63887a3eef9ad234ea3c70f3.jpg','2024-08-19 09:42:33'),
(3,'Cassie Emmanuel ','cassieemmanuel01@gmail.com','$2y$10$zx8pxq9fuWW6sx/6rcqpT.DKtmMrvsLP9m6P1RVWZi0Mp5fZqk06W',0,'2001-03-11',2,NULL,'6289526303872','user','5bb8906b9892b0dd12e05668112967a2',1,'Web','Job Portal',2087,'https://storage.googleapis.com/psikotesdaring.com/images/users/58a72c31f08f8df6d8f76ad820a20cdd.jpg','2024-08-21 10:18:29'),
(4,'Gita Septyanti','gitaseptyanti@gmail.com','$2y$10$z8.DrlgJwbfchufd3KFgHOYy.zgkKkvnNcFBYrIc.I2VSiE75Igna',0,'1996-09-18',3,NULL,'6281298773521','user','5b9f7e2eda9d05e7b7be628edba02257',1,'Web','WhatsApp',2095,NULL,'2024-08-29 10:31:53'),
(5,'Yasmine Fadillah','work.yasminefadillah@gmail.com','$2y$10$Qwry2XFX.msOEZmjr82mk.64ciSbD1ThHuCzm2uE9oGQrWC.QeZLO',0,'2002-06-14',3,NULL,'6285921256301','user','c2ff1ca037306654756e18e074c89006',1,'Web','Search Engine',2118,'https://storage.googleapis.com/psikotesdaring.com/images/users/38038c7f849863ff490029d5b1cc1c1b.JPG','2024-09-12 09:22:02'),
(6,'Christophorus Davin','davinchristo12345@gmail.com','$2y$10$h2TNarJywn3BV.8meyM4M.oO/5aTXn4j8gmENGblNIk5MW8MDWiJW',1,'2001-04-06',3,NULL,'6281287252770','user','dca198a11448a46bfa0899fa39c3f4a3',1,'Web','Search Engine',2089,'https://storage.googleapis.com/psikotesdaring.com/images/users/4e89587bd0e65a4c11167181e2f19bce.jpg','2024-09-12 09:22:43'),
(7,'Widya Satriani ','satrianiwidya@gmail.com','$2y$10$h5Rkv92cfafGEp6QCNzKi.GYtNlUQBcz/SjWL1C9KBa3A2aazp5TO',0,'2001-03-22',2,NULL,'6285263873977','user','b954fba3f8ed074452539241a7ded422',1,'Web','WhatsApp',4539,'https://storage.googleapis.com/psikotesdaring.com/images/users/ddc89945d323e597bdb1609059d59d4c.jpeg','2024-09-12 09:29:41'),
(8,'Rina Celica','rinacelica@gmail.com','$2y$10$NlcgKzTeLiwP6gfNg2R6s.4ibTSahXa0D4z/fIhTdvvykGDL5ohyC',0,'2001-11-15',3,NULL,'6281311629308','user','57bd6ca470820d51c62c08094e0b19c9',1,'Web','Job Portal',1580,'https://storage.googleapis.com/psikotesdaring.com/images/users/575fed6ddbd2fd47ea1af2c08baa1cd2.jpeg','2024-09-12 10:01:10'),
(9,'Admin PsikotesDaring','admin@psikotesdaring.com','$2y$10$lXkWZKDFlejm0y30YyEfHOFXwP4zLiaJMiD.AY8S3Xjys6RDtNxny',0,NULL,NULL,NULL,NULL,'admin','123',1,NULL,NULL,NULL,'https://storage.googleapis.com/psikotesdaring.com/images/clients/6fd769ad63887a3eef9ad234ea3c70f3.jpg','2024-09-17 14:03:15'),
(10,'Celine Tan','celine.tan2629@gmail.com','$2y$10$FpKzlQQevmglp4P9QMeXAekEnYJjnhYH0ARC7zmefHsiHeaBKpXg6',0,'2002-10-26',3,NULL,'6281519520732','user','39e6ca547e03398ac90ef0447f6c7365',1,'Web','Job Portal',2087,'https://storage.googleapis.com/psikotesdaring.com/images/users/5941747220dd4cc1ef98b6fdaa7c29d9.jpg','2024-09-19 09:20:26'),
(11,'Fatsyarien Citra','fatsyarien@gmail.com','$2y$10$SWLWWTVuREWAiYZlYtOPTufB0lb7hlIshYgoXkjm0ikslhOk2dUvi',0,'2000-09-19',3,NULL,'6287886298262','user','f57800ba4d2bd6507be8b1ebeae75873',1,'Web','Job Portal',2111,'https://storage.googleapis.com/psikotesdaring.com/images/users/000efda7b3a6e872753e28963194534f.jpg','2024-09-24 09:40:33'),
(12,'Jesstika Anggreany Yendro','jesstikaanggreany14@gmail.com','$2y$10$1vUpqhyxa.0ljYLIYzZUDu2CErYOXMZCGIVi1rPFviNZgxPITacCu',0,'2000-08-29',3,NULL,'6287889506932','user','db1992212842cc6b133dd1f1f7a18f63',1,'Web','Job Portal',2094,'https://storage.googleapis.com/psikotesdaring.com/images/users/f8fb04271f506703faa3851ebe85035c.jpg','2024-09-24 09:44:13'),
(13,'Wahyu Faizan','faizanwahyu8@gmail.com','$2y$10$zlDDBCfRYgzedDsV9z2spuwsB69guogdEZd0u.Qx1fTzEjPxGlQLG',1,'1996-06-08',3,NULL,'6281327003300','user','aea8bf416578f7998abac9f0615bfeee',1,'Web','Job Portal',2127,'https://storage.googleapis.com/psikotesdaring.com/images/users/d0ea579ae40bf1bc24f5b3380c98886b.jpg','2024-09-26 09:22:09'),
(14,'Madelyne Aurelia','madelyneaurelia@gmail.com','$2y$10$ICWwPLW9YKYi3KJrp8JAIOdftIKHO/zes5b/e0k7nfTdkNF3TO3hG',0,'2002-10-28',3,NULL,'6282141287428','user','1103b0c6e1d5ee9b6f3a38cd5b76c5e3',1,'Web','Job Portal',2088,'https://storage.googleapis.com/psikotesdaring.com/images/users/99564d6a69631c933e507f3eea05cb39.jpg','2024-10-11 09:29:32');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
