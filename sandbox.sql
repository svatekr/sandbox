SET NAMES utf8;
SET time_zone = '+01:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` varchar(125) NOT NULL,
  `name` varchar(125) DEFAULT NULL,
  `lastname` varchar(125) DEFAULT NULL,
  `email` varchar(125) NOT NULL,
  `role` varchar(25) NOT NULL,
  `passwordHash` varchar(125) DEFAULT NULL,
  `passwordHashValidity` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
