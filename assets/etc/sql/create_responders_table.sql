#create database cleanapp;
use cleanapp;
CREATE TABLE `responders` (
  `id` varchar(60) NOT NULL,
  `name` varchar(60) NOT NULL,
  `title` varchar(60) DEFAULT NULL,
  `address` varchar(80) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `duration_start` date DEFAULT NULL,
  `duration_end` date DEFAULT NULL,
  `added` datetime DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
