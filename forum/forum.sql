-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 02 nov. 2020 à 15:15
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `forum`
--

-- --------------------------------------------------------

--
-- Structure de la table `reaction`
--

DROP TABLE IF EXISTS `reaction`;
CREATE TABLE IF NOT EXISTS `reaction` (
  `reaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `content_type` varchar(25) NOT NULL,
  `message_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`reaction_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `reaction`
--

INSERT INTO `reaction` (`reaction_id`, `content_type`, `message_id`, `user_id`) VALUES
(9, 'dislike', 5, 1);

-- --------------------------------------------------------

--
-- Structure de la table `reponses`
--

DROP TABLE IF EXISTS `reponses`;
CREATE TABLE IF NOT EXISTS `reponses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auteur_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL,
  `id_sujets` int(11) NOT NULL,
  `count` int(11) DEFAULT '0',
  `count_dislike` int(11) DEFAULT '0',
  PRIMARY KEY (`id`,`id_sujets`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `reponses`
--

INSERT INTO `reponses` (`id`, `auteur_id`, `message`, `date`, `id_sujets`, `count`, `count_dislike`) VALUES
(4, 1, 'test', '2020-10-26 23:04:31', 1, 0, 0),
(5, 1, 'test', '2020-10-26 23:04:49', 1, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `sujets`
--

DROP TABLE IF EXISTS `sujets`;
CREATE TABLE IF NOT EXISTS `sujets` (
  `id_sujets` int(11) NOT NULL AUTO_INCREMENT,
  `auteur` varchar(30) NOT NULL,
  `titre` text NOT NULL,
  `description` text NOT NULL,
  `date` datetime NOT NULL,
  `id_topics` int(11) NOT NULL,
  PRIMARY KEY (`id_sujets`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `sujets`
--

INSERT INTO `sujets` (`id_sujets`, `auteur`, `titre`, `description`, `date`, `id_topics`) VALUES
(1, 'jhon', 'bonjour', 'bonjour tout le monde', '2020-10-13 18:47:48', 1),
(2, 'Admin', 'fgfhfgh', 'fghbcvbfgbfdgb fdg hftg fdgg stdsg fdgfddf', '2020-11-02 16:02:14', 7);

-- --------------------------------------------------------

--
-- Structure de la table `topics`
--

DROP TABLE IF EXISTS `topics`;
CREATE TABLE IF NOT EXISTS `topics` (
  `id_topics` int(11) NOT NULL AUTO_INCREMENT,
  `auteur` varchar(30) NOT NULL,
  `titre` text NOT NULL,
  `date` datetime NOT NULL,
  `grade` int(11) NOT NULL,
  PRIMARY KEY (`id_topics`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `topics`
--

INSERT INTO `topics` (`id_topics`, `auteur`, `titre`, `date`, `grade`) VALUES
(1, 'admin', 'Covid-19', '2020-10-13 15:32:43', 0),
(2, 'Admin', 'sss', '2020-11-02 15:24:06', 0),
(3, 'Admin', 'sss', '2020-11-02 15:24:08', 0),
(4, 'Admin', 'sss', '2020-11-02 15:24:12', 0),
(5, 'Admin', 'sss', '2020-11-02 15:24:43', 0),
(6, 'Admin', 'test', '2020-11-02 15:40:22', 0),
(7, 'Admin', 'Testhgvbcn', '2020-11-02 15:51:25', 0);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `sexe` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `localisation` varchar(255) NOT NULL,
  `grade` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `login`, `password`, `nom`, `prenom`, `sexe`, `email`, `localisation`, `grade`) VALUES
(6, 'Admin2', '$2y$12$mi08QQxLSnBF/WRo/7NAqeNhlI/iwEp1O0vrGp2krqqvfRsZwKkaS', 'ALBERT', 'BASTIEN', 'Homme', 'bastien.albert8@gmail.com', '', 0),
(5, 'CRUEL', '$2y$12$KLO2An4I5CEMM42BLxTrleN1pypgC.Bgp46HQaQ.8JbFhE/PVP0c6', 'ALBERT', 'BASTIEN', 'Homme', 'bastien.albert8@gmail.com', '', 0),
(4, 'Admin', '$2y$12$dY1wt8pNN0LUER7bL4eLT.3bNqJPbaxrLAtB/zQrLgGOxmTAk.2mW', 'ALBERT', 'BASTIEN', 'Homme', 'xensoluce@gmail.com', '', 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
