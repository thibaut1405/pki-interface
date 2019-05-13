-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 13 Mai 2019 à 12:52
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `pki`
--

-- --------------------------------------------------------

--
-- Structure de la table `certificates`
--

CREATE TABLE IF NOT EXISTS `certificates` (
  `id_certificate` int(11) NOT NULL AUTO_INCREMENT,
  `path_certificate` varchar(250) NOT NULL,
  `state_certificate` int(11) NOT NULL DEFAULT '0',
  `id_demandeur` int(11) DEFAULT NULL,
  `fqdn_certificate` varchar(250) NOT NULL,
  PRIMARY KEY (`id_certificate`),
  KEY `id_demandeur` (`id_demandeur`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Contenu de la table `certificates`
--

INSERT INTO `certificates` (`id_certificate`, `path_certificate`, `state_certificate`, `id_demandeur`, `fqdn_certificate`) VALUES
(11, '_tmp_phpsHnG2g_test.csr', 1, 1, 'exemple.com'),
(12, '_tmp_phpmSH2X_test.csr', 1, 1, 'exemple.fr'),
(13, '_tmp_phpsHvgT5_test.csr', 0, 2, 'blog.com'),
(25, '_tmp_phpshYv24_test.csr', 1, 2, 'defe.com'),
(26, '_tmp_phpftgGe9_test.csr', 1, 1, 'hola.com'),
(27, '_tmp_phpcjTk87_test.csr', 0, 1, 'monsite.fr.test'),
(28, '_tmp_phppoeEf5_test.csr', 1, 1, 'cloclo.fr');

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

CREATE TABLE IF NOT EXISTS `personne` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifiant` varchar(250) NOT NULL,
  `pwd` varchar(250) NOT NULL,
  `nom` varchar(250) NOT NULL,
  `prenom` varchar(250) DEFAULT NULL,
  `admin` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `personne`
--

INSERT INTO `personne` (`id`, `identifiant`, `pwd`, `nom`, `prenom`, `admin`) VALUES
(1, 'admin', 'dc76e9f0c0006e8f919e0c515c66dbba3982f785', 'Doe', 'John', 1),
(2, 'user', '12dea96fec20593566ab75692c9949596833adc9', 'Stark', 'Tony', 0);

-- --------------------------------------------------------

--
-- Structure de la table `real_certificates`
--

CREATE TABLE IF NOT EXISTS `real_certificates` (
  `id_real_certificate` int(11) NOT NULL AUTO_INCREMENT,
  `path_real_certificate` varchar(250) NOT NULL,
  `state_real_certificate` int(11) DEFAULT '0',
  `id_demandeur` int(11) NOT NULL,
  `fqdn_real_certificate` varchar(250) NOT NULL,
  PRIMARY KEY (`id_real_certificate`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `real_certificates`
--

INSERT INTO `real_certificates` (`id_real_certificate`, `path_real_certificate`, `state_real_certificate`, `id_demandeur`, `fqdn_real_certificate`) VALUES
(1, 'exemple.fr.com.crt', 1, 1, 'exemple.fr.com'),
(4, 'monsite.fr.crt', 1, 1, 'monsite.fr'),
(5, 'blog.com.crt', 1, 2, 'blog.com'),
(6, 'jeux.fr.crt', 0, 2, 'jeux.fr'),
(7, 'exemple.com.crt', 0, 1, 'exemple.com'),
(8, 'cloclo.fr.crt', 0, 1, 'cloclo.fr'),
(9, 'defe.com.crt', 0, 1, 'defe.com'),
(10, 'hola.com.crt', 0, 1, 'hola.com');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `certificates_ibfk_1` FOREIGN KEY (`id_demandeur`) REFERENCES `personne` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
