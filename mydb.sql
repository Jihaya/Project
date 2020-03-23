/*
SQLyog Community v12.4.3 (64 bit)
MySQL - 10.1.35-MariaDB : Database - mydb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`mydb` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `mydb`;

/*Table structure for table `device` */

DROP TABLE IF EXISTS `device`;

CREATE TABLE `device` (
  `id` int(4) NOT NULL,
  `carnum` varchar(6) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `device` */

insert  into `device`(`id`,`carnum`,`status`) values 
(1,'กย105','Ready'),
(2,'ทส345','Ready');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `level` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`,`fname`,`lname`,`email`,`level`) values 
(1,'admin','$2y$10$l2TlMOefA79j5nGZ7QjpK.luV588siRYVf/Rlro2Y0RQcHX5lu54m','admin','admin','admin@gmail.com','admin'),
(4,'aaa','$2y$10$w6.Iy6MQio9SPOAzlKgxcO1IDoFZC33UidJefrDXqptIoi1wr0vzS','aaa','aaa','aa@gmail.com','user'),
(7,'ddd','$2y$10$/C2qs3FLgEtsfz2qaA/pVurNVWKaL5tYquxHQ/kycfYLB6U9RAG9S','ddd','ddd','dd@gmail.com','user'),
(8,'rrr','$2y$10$M5gBXITnR4HB2hdcjcCQ5e3Jq852Vlt2gXmNZggJsYD3szbXuT.Jy','rrr','rrr','rr@rr.com','user');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
