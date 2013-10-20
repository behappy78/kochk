-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Dim 20 Octobre 2013 à 02:02
-- Version du serveur: 5.1.53
-- Version de PHP: 5.3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `db489062710`
--

-- --------------------------------------------------------

--
-- Structure de la table `m5jbw_mediamallfactory_media`
--

DROP TABLE IF EXISTS `m5jbw_mediamallfactory_media`;
CREATE TABLE IF NOT EXISTS `m5jbw_mediamallfactory_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `votes` int(11) NOT NULL,
  `cost_media` int(11) NOT NULL,
  `cost_archive` int(11) NOT NULL,
  `details_media` mediumtext NOT NULL,
  `details_archive` mediumtext NOT NULL,
  `filename_media` varchar(255) NOT NULL,
  `filename_archive` varchar(255) NOT NULL,
  `filename_thumbnail` varchar(255) NOT NULL,
  `has_media` tinyint(1) NOT NULL,
  `has_archive` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `downloads` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`),
  KEY `type_id` (`type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `m5jbw_mediamallfactory_media`
--

INSERT INTO `m5jbw_mediamallfactory_media` (`id`, `title`, `description`, `rating`, `votes`, `cost_media`, `cost_archive`, `details_media`, `details_archive`, `filename_media`, `filename_archive`, `filename_thumbnail`, `has_media`, `has_archive`, `user_id`, `category_id`, `type_id`, `downloads`, `published`, `created_at`, `updated_at`) VALUES
(1, 'Media 1', 'Description de Media 1', '0.0', 0, 1, 0, 'Details Media 1', '', '121511P01.pdf', '', 'lapresse-2013-10-19-22-41-10-1.png', 1, 0, 342, 78, 1, 1, 1, '2013-09-09 16:50:13', '2013-10-20 01:56:19'),
(2, 'N° 19/10/2013', 'INCIDENTS À LA CASERNE DE LA GARDE\r\nNATIONALE D’EL AOUINA\r\nA l’origine, une approche\r\nincohérente', '0.0', 0, 1, 0, 'DETAILS 01', '', '', '', 'lapresse-2013-10-19-22-41-10-2.png', 0, 0, 342, 78, 1, 0, 1, '2013-10-19 21:42:58', '2013-10-20 01:56:31'),
(3, 'N° 20/10/2013', 'INCIDENTS 2 À LA CASERNE DE LA GARDE\r\nNATIONALE D’EL AOUINA\r\nA l’origine, une approche\r\nincohérente', '0.0', 0, 1, 0, 'DETAILS 02', '', '', '', 'lapresse-2013-10-19-22-41-10-3.png', 0, 0, 342, 78, 1, 0, 1, '2013-10-19 21:48:34', '2013-10-20 01:56:41'),
(4, 'N° 21/10/2013', 'INCIDENTS À LA CASERNE DE LA GARDE\r\nNATIONALE D’EL AOUINA\r\nA l’origine, une approche\r\nincohérente', '0.0', 0, 1, 0, 'DETAILS 03', '', '', '', 'lapresse-2013-10-19-22-41-10-4.png', 0, 0, 342, 78, 1, 0, 1, '2013-10-19 21:49:30', '2013-10-20 01:56:54'),
(5, 'N° 22/10/2013', 'INCIDENTS À LA CASERNE DE LA GARDE\r\nNATIONALE D’EL AOUINA\r\nA l’origine, une approche\r\nincohérente', '0.0', 0, 1, 0, 'Details 04', '', '', '', 'lapresse-2013-10-19-22-41-10-5.png', 0, 0, 342, 78, 1, 0, 1, '2013-10-19 21:49:58', '2013-10-20 01:57:06');
