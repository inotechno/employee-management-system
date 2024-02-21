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

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`username`,`email`,`email_verified_at`,`foto`,`password`,`remember_token`,`created_at`,`updated_at`) values 
(1,'Administrator','administrator','administrator@mindotek.com',NULL,NULL,'$2y$10$zW0d8vf9x.xb9Nob2Y9DtuahqNGC25qtmPueixdxGcybqquUKjzIW',NULL,'2023-03-02 11:08:29','2023-03-02 11:08:29'),
(2,'Director','director','director@mindotek.com',NULL,NULL,'$2y$10$BjtdPs2j2RrLN7fYgcDcqeCbtdYPYpwsA33xwHhiSGu2FP2sRyRUy',NULL,'2023-03-02 11:08:29','2023-03-02 11:08:29'),
(3,'HRD','hrd','hrd@mindotek.com',NULL,NULL,'$2y$10$xy.W6j9d7q4q0.WaYc426.pydxA0osqWuscEEMVNf4wpKRT/nYj1e',NULL,'2023-03-02 11:08:29','2023-03-02 11:08:29'),
(4,'Finance','finance','finance@mindotek.com',NULL,NULL,'$2y$10$Q1Ieb49VDOzccllM9ZK.K.bEkeCxgtme2htrg3ixVOWzalIRCTUSq',NULL,'2023-03-02 11:08:29','2023-03-02 11:08:29'),
(5,'Prasojo Utomo','20221201','prasojo.utomo@tpm-facility.com',NULL,NULL,'$2y$10$Abu/GXv9nDzwZhlwoWgMUeIb5./YAo3i1Jn2AITunOgDKFnqnHRuO',NULL,'2023-03-02 11:35:18','2023-09-07 00:00:08'),
(6,'Arvita Tiarawati','20221202','arvitatiarawati@tpm-facility.com',NULL,NULL,'$2y$10$aXfpAF5zAz7hWYHcnzR7HuJve2Db5g2iy9wSGLZ864uCmkmmmuKtG',NULL,'2023-03-02 11:35:19','2023-09-07 00:00:08'),
(7,'Rekha Kisnawaty','20221203','rekha.kisnawaty@tpm-facility.com',NULL,NULL,'$2y$10$J.9k/nSI4I3W1ehbcWWK5eJe2OMhUjKLw3C0FERV8zaQ0sbDc.Jp6',NULL,'2023-03-02 11:35:19','2023-09-07 00:00:09'),
(8,'Cece Koswara','20221204','koswara@tpm-security.com',NULL,NULL,'$2y$10$PzLra71KBnlLphVEH6lCPecvDgO7H7aVN7TkIdlhq3GPMmAjQ9sBq',NULL,'2023-03-02 11:35:19','2023-09-07 00:00:09'),
(9,'Tumbur M Manurung','20221205','tumbur.manurung@tpm-security.com',NULL,NULL,'$2y$10$wUV4VdJjJhOnFTMQ45qNgepAWOeCdkQQCoy57xj.hu4zIjc5vmcJW',NULL,'2023-03-02 11:35:19','2023-09-07 00:00:09'),
(10,'Iman Suherman','20221206','iman.suherman@tpm-facility.com',NULL,NULL,'$2y$10$QEOvmG0IrV1gfhUsXwsRFuCC3xiHOyd0nPcFrzvD1LC0pDjGLvydm',NULL,'2023-03-02 11:35:19','2023-09-07 00:00:09'),
(11,'Ashafa Anggraeni','20221207','ashafa.anggraeni@tpm-facility.com',NULL,NULL,'$2y$10$lESlgqrtRfnr7kSnWpnHo.tgbDhuxb8CEU58IC1kUFDVFjnSg6.iO',NULL,'2023-03-02 11:35:19','2023-09-07 00:00:09'),
(12,'Riyadi','20221208','riyadi@tpm-facility.com',NULL,NULL,'$2y$10$Ngh4zCsORUozq3paboe/ReeL.lXqaNBH6jsB6HuqPwp6mxJkhbOXG',NULL,'2023-03-02 11:35:19','2023-09-07 00:00:09'),
(13,'Depriana','20221209','depriana@tpm-facility.com',NULL,NULL,'$2y$10$8pWrYjk4AyKOorsdJRAYDuTqAIahnS1MngjU1bxKCxc8.oMmoO08W',NULL,'2023-03-02 11:35:20','2023-09-07 00:00:10'),
(14,'Ridho Ridwan','20221210','ridhoridwan@tpm-facility.com',NULL,NULL,'$2y$10$YJbaHwX39QuWbEiURYBzZuA9iJrwF3qkZQrwaCq/3TdQxo6I5O6jm',NULL,'2023-03-02 11:35:20','2023-09-07 00:00:10'),
(15,'Irsyad Al Fahriza','20221211','irsyad.alfahriza@mindotek.com',NULL,NULL,'$2y$10$6o1R09dobt/0zNt53RO/7.KGmX6LvwERnEhoQGMKblpAZZd3TUOO.',NULL,'2023-03-02 11:35:20','2023-09-07 00:00:10'),
(16,'Septi Dwi Rahayu','20221212','septi.dwirahayu@tpm-facility.com',NULL,NULL,'$2y$10$4GTuk8uY3BhAA5bAWOnfPe53ca2A1qYpMTPcauGD10DHzy4AEQyEG',NULL,'2023-03-02 11:35:20','2023-09-07 00:00:11'),
(17,'Dimas Yogi Mugiarto','20221213','dimas@tpm-facility.com',NULL,NULL,'$2y$10$OIyEVDnrTr0wEIbxrr3rTuoPiFspmchJjtGMTUPEAFiRQButODQt6',NULL,'2023-03-02 11:35:20','2023-09-07 00:00:11'),
(18,'Agung Rahayudi','20221214','agung.rahayudi@tpm-facility.com',NULL,NULL,'$2y$10$JHNbzfwqhmqEwikV3Dvi0ObUSrcHGl/oJ7lpZ9e21ovjGQx8D603K',NULL,'2023-03-02 11:35:20','2023-09-07 00:00:11'),
(19,'Astrilia Hapsari','20221215','astrilia.hapsari@tpm-facility.com',NULL,NULL,'$2y$10$qjMSlVo608DhlnKb72Kw9OqSIY5k7HvnPxHvMDVErFQIBB43G2tT6',NULL,'2023-03-02 11:35:20','2023-09-07 00:00:11'),
(20,'Lilis Laeliya','20221216','lilis.laeliya@tpm-facility.com',NULL,NULL,'$2y$10$8TB5LhojNFMyvQVLfzLZS.w1fCsdtbNBpLAqDLZD.6RRbKGdi23qe',NULL,'2023-03-02 11:35:21','2023-09-07 00:00:12'),
(21,'Fitrian Ansori','20221217','fitrian.ansori@tpm-facility.com',NULL,NULL,'$2y$10$P/G9NuXm4pqf.du.T4KacOZmWSkahRGgMi6NiWqfB4iDSjvVLdYiS',NULL,'2023-03-02 11:35:21','2023-09-07 00:00:12'),
(22,'Ade Sebastian','20221218','ade.sebastian@tpm-security.com',NULL,NULL,'$2y$10$WHvX1NsqBMAe0NEora5wpuO7g9rbkoYCy/8hPxEVdFiJ000.N5Ije',NULL,'2023-03-02 11:35:21','2023-09-07 00:00:12'),
(23,'Leonardo Limeng','20221219','leonardo.limeng@tpm-facility.com',NULL,NULL,'$2y$10$GuI25CVDAeSOOMojOg8ohuvWkkqrAMEzvykpsPKTeqiI8J8m./lnq',NULL,'2023-03-02 11:35:21','2023-09-07 00:00:12'),
(24,'Ilham Taufik','20221220','ilham.taufik@mindotek.com',NULL,NULL,'$2y$10$xCfaGvj67sFezlJmbalPJO9afowX8keuZPAEWX2Xd8U0xNlXwXXAG',NULL,'2023-03-02 11:35:21','2023-09-07 00:00:13'),
(25,'Risa Nurhanipah','20221221','risa.nurhanipah@mindotek.com',NULL,NULL,'$2y$10$Zzxdqh01ekBLdj3az.fEveUX62pDQtfgUalRJFK4.wZXIV/6XGbym',NULL,'2023-03-02 11:35:21','2023-09-07 00:00:13'),
(26,'Tyas Anggraini','20221222','tyas.anggraini@tpm-facility.com',NULL,NULL,'$2y$10$tCsZ8kfyPi59i.UOAd3qtuU/R4g9Syp0uslmsNKdSD7ebgSMGJicy',NULL,'2023-03-02 11:35:21','2023-09-07 00:00:13'),
(27,'Keiko Angel Shantiony','20221223','keiko.angelshantiony@tpm-facility.com',NULL,NULL,'$2y$10$/YzxchZBp038fi58zIz0.ejshNauC4AW.rQURt.Uk/pnar6e2oJ0C',NULL,'2023-03-02 11:35:22','2023-09-07 00:00:13'),
(28,'Ahmad Fatoni','20221224','ahmad.fatoni@mindotek.com',NULL,NULL,'$2y$10$smq7rwn3u4aPOCkjDJW0veKWPq2q8XWukiN56GnHS60nxiWTNjhOO',NULL,'2023-03-02 11:35:22','2023-09-07 00:00:13'),
(29,'Sri Rahayuningsih','20221225','srirahayu@tpm-facility.com',NULL,NULL,'$2y$10$YOGU93tLZ04aFxbZkuOdSOh3tRmLtVRgMZ2NgesRVi0OIY1rSH9xK',NULL,'2023-03-02 11:35:22','2023-09-07 00:00:13'),
(30,'Desti Ayu Nandari','20221226','desty@tpm-facility.com',NULL,NULL,'$2y$10$Vr4az2Px9f77lLxexrJxJev.Wzsb0xcH99eRD1vmjPxnMEi./vKRa',NULL,'2023-03-02 11:35:22','2023-09-07 00:00:14'),
(31,'Tia Setiani Tasim','20221227','tia.setiani@tpm-facility.com',NULL,NULL,'$2y$10$3conAlYrdarvqWvA88ker.mKIZaznQQhcdgQIx7O7yTWEiR6HueYi',NULL,'2023-03-02 11:35:22','2023-09-07 00:00:14'),
(32,'Nofrizal','20221228','novrizal@tpm-security.com',NULL,NULL,'$2y$10$X456L1KF8vnozAAO.Ty35e4MG4jkHDQEUcxH0ijX5QUc9nEyJQlhW',NULL,'2023-03-02 11:35:22','2023-09-07 00:00:14'),
(33,'Fahmi Husaini','20221229','fahmi.husaini@tpm-facility.com',NULL,NULL,'$2y$10$PQ.WG1nR0.e6TBlVIjq8MOj8eL28PLRY5U.MMOJR4Q6o16LTRJGJu',NULL,'2023-03-02 11:35:22','2023-09-07 00:00:14'),
(34,'Astri Hutasoit','20221230','astri.hutasoit@tpm-facility.com',NULL,NULL,'$2y$10$xHA4JjUO20QsfKKjqonLHu8xWuPPRRNK3RjLHXSVY5i.K1xUB1MLG',NULL,'2023-03-02 11:35:23','2023-09-07 00:00:14'),
(35,'Sentot Santoso','20221231','sentot@tpm-facility.com',NULL,NULL,'$2y$10$unZSst2CHvjNeBhVOpFaZu08epB5hPRf0pzxjsWB1KvtpMnpZurKu',NULL,'2023-03-02 11:35:23','2023-09-07 00:00:15'),
(36,'Purwanto','20221232','purwanto@tpm-facility.com',NULL,NULL,'$2y$10$O4hfHvo/v9fSrDUSMbF0gevdGnF2IViNpv3dsa.3WNuupXdeU4dt6',NULL,'2023-03-02 11:35:23','2023-09-07 00:00:15'),
(37,'Evi','20221233',NULL,NULL,NULL,'$2y$10$fXRK4gLIPlS8KgHLJVnsV.HXyfdHfziuituNQoSQBylMvEp5R1Ho2',NULL,'2023-03-02 11:35:23','2023-09-07 00:00:15'),
(38,'Roni Kabo','20221234',NULL,NULL,NULL,'$2y$10$mxdTgeUEhg9TOgS5tcWKAuk9FXq/mPibuGpGRkUmgH2TrVX.1txMC',NULL,'2023-03-02 11:35:23','2023-09-07 00:00:15'),
(39,'Erna Wahyu Winarsih','20221235','erna.wahyu@tpm-facility.com',NULL,NULL,'$2y$10$WFx0vsg2eCdUOoNhlmlZbOQrGG3hWiI4nbRnIfoyx3l8zk1qaSLoa',NULL,'2023-03-02 11:35:23','2023-09-07 00:00:15'),
(40,'Endro Setyantono','20221236','endro.setyantono@tpm-facility.com',NULL,NULL,'$2y$10$dVYwhhNqhUWluXLaY/jzY.nRcUHtDHGU3By7RCaUW71n1yaElEi5y',NULL,'2023-03-02 11:35:23','2023-09-07 00:00:16'),
(41,'Angga Aditya Ramdani','20230101','angga.aditya@mindotek.com',NULL,NULL,'$2y$10$1AjGctSS9gannBbqZyVBOed4aEklwXrye8djYjF8NFuYbl8uIcbcu',NULL,'2023-03-02 11:35:23','2023-09-07 00:00:16'),
(42,'Fatra Hamdi','20230102','fatra.hamdi@tpm-facility.com',NULL,NULL,'$2y$10$OedGE.TmDEu3W7byvbu8GuarI37tYEWDstCQDvsDr966O9llXwI6i',NULL,'2023-03-02 11:35:24','2023-09-07 00:00:16'),
(43,'Gatot Purnawan','20230201','gatotpurnawan@tpm-facility.com',NULL,NULL,'$2y$10$SpyzTiSRM22jJvFaRICMQ.ydxkwPkb2o7mLStqSTaMMOG55RlgoEG',NULL,'2023-03-02 11:35:24','2023-09-07 00:00:16'),
(44,'Tes','20230401',NULL,NULL,NULL,'$2y$10$FOdR4jZymQkgXR4lLSWUneHfF5PoqY0kRoceHZCPR1x2m2Yjr6.ry',NULL,'2023-04-11 00:00:15','2023-04-17 12:09:38'),
(45,'Nur Rohmat','20230301','nur.rohmat@tpm-facility.com',NULL,NULL,'$2y$10$s4h.8Uv7y.W6SKIXU.HuWerryRxtDt4ySX3lVLRrQxGBdFGzAtju.',NULL,'2023-04-17 12:07:23','2023-09-07 00:00:16'),
(46,'Vivi Wiwinda','20230501',NULL,NULL,NULL,'$2y$10$xcXkONkwWGbKzx5lnV5bjekQbThTgX8ewSoVkLaqrVWT7rldvBLCC',NULL,'2023-05-03 00:00:16','2023-09-07 00:00:16'),
(47,'Abdul Fatah','20230103','abdul.fatah@tpm-facility.com',NULL,NULL,'$2y$10$4NTRce6ODQl3Xzb8ANVutee7uLJTugEfFyXEbL5iUbr8LT3MoXtAe',NULL,'2023-05-23 00:00:15','2023-09-07 00:00:17'),
(48,'Firna','20230601',NULL,NULL,NULL,'$2y$10$OxeslcinWDtyUS.1XA9H1OTMBihxkjRkrHo0Kvumi6C2IPUpPGzXO',NULL,'2023-07-07 00:00:07','2023-09-07 00:00:17'),
(49,'Melati Yurikasari','20230701','yesar@tpm-facility.com',NULL,NULL,'$2y$10$ytQtOK8.iJaRWPCa5nYqLeIa8d8RQSJrF.uuNS4xGjncpByQr55s.',NULL,'2023-07-14 00:00:12','2023-09-07 00:00:17'),
(52,'Chrisna Liandi','20230801','chrisna.liandip@tpm-facility.com',NULL,NULL,'$2y$10$FgvIxzN6zSDEkHfdnwGWzev7B6fYvwUhcqfkKffnmor.Tum4mr1qO',NULL,'2023-08-16 00:00:12','2023-09-07 00:00:18'),
(53,'Hendry Wiratama','20230901',NULL,NULL,NULL,'$2y$10$VNtdLv5qDvxjwcz80N34ge3oNehVJZr.k11p9iW/l/XGqIy6oJhCe',NULL,'2023-09-06 00:00:12','2023-09-07 00:00:18');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
