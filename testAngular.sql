-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:8889
-- Généré le :  Mer 21 Décembre 2016 à 13:07
-- Version du serveur :  5.6.28
-- Version de PHP :  7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `testangular`
--

-- --------------------------------------------------------

--
-- Structure de la table `nodes`
--

CREATE TABLE IF NOT EXISTS `nodes` (
  `node_ID` int(11) NOT NULL AUTO_INCREMENT,
  `parentNode_ID` int(11) NOT NULL,
  `path` text NOT NULL,
  `record_name` text NOT NULL,
  `lastModif` datetime NOT NULL,
  PRIMARY KEY (`node_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `nodes`
--

INSERT INTO `nodes` (`node_ID`, `parentNode_ID`, `path`, `record_name`, `lastModif`) VALUES
(1, 0, 'Images/', 'Images', '2016-12-06 10:36:34'),
(2, 1, 'images/JPEG/', 'JPEG', '2016-12-06 10:36:36'),
(3, 1, 'Images/PNG/', 'PNG', '2016-12-06 10:36:40'),
(4, 0, 'pdf/', 'pdf', '2016-12-06 10:37:00'),
(5, 2, 'Images/JPEG/jpeg2000-home.jpeg', 'jpeg2000-home.jpeg', '2016-12-07 10:42:11'),
(6, 2, 'Images/JPEG/nature.jpeg', 'nature.jpeg', '2016-12-07 11:42:11'),
(7, 3, 'Images/PNG/lac_montagne.png', 'lac_montagne.png', '2016-12-07 12:09:26'),
(8, 4, 'pdf/Tunza_5.2_French.pdf', 'Tunza_5.2_French.pdf', '2016-12-07 12:09:26');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` text NOT NULL,
  `password` text NOT NULL,
  `API_key` varchar(32) NOT NULL,
  `roles` varchar(32) NOT NULL,
  `creationDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UniqLogin` (`login`(30))
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `API_key`, `roles`, `creationDate`) VALUES
(2, 'test', '$2y$10$Z5/T2IfxdpKhuhYCdisRE.P9uWIjrDmPzVkRXr1vEyKbVgEywRMUq', '89846863bf92a807df277e999690c8bf', '0111', '2016-11-30 17:39:38');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
