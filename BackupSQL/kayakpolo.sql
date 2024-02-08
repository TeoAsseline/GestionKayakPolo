-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 08 fév. 2024 à 17:46
-- Version du serveur : 5.7.40
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `kayakpolo`
--

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

DROP TABLE IF EXISTS `joueur`;
CREATE TABLE IF NOT EXISTS `joueur` (
  `Nom` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Prenom` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Photo` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NumLicense` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DateNaissance` date NOT NULL,
  `Taille` smallint(6) NOT NULL,
  `Poids` smallint(6) NOT NULL,
  `PostePref` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Statut` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commentaire` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`NumLicense`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `joueur`
--

INSERT INTO `joueur` (`Nom`, `Prenom`, `Photo`, `NumLicense`, `DateNaissance`, `Taille`, `Poids`, `PostePref`, `Statut`, `commentaire`) VALUES
('Brodoux', 'Martin', 'photo/0011010010.png', '0011010010', '1985-04-11', 177, 67, 'Milieu', 'Absent', ''),
('Belat', 'Cristophe', 'photo/1000000000.png', '1000000000', '1991-02-27', 182, 66, 'Attaquant', 'Actif', 'Lancé droit a améliorer'),
('Lalliot', 'Matthieu', 'photo/1010101010.png', '1010101010', '1981-04-01', 189, 81, 'Defenseur', 'Actif', 'Super récupération de balle'),
('Linet', 'Davids', 'photo/1111111111.png', '1111111111', '1991-11-02', 187, 64, 'Gardien', 'Actif', 'Meilleur gardien de la saison'),
('Ricci', 'Luigi', 'photo/1215738163.png', '1215738163', '1989-11-16', 174, 56, 'Defenseur', 'Actif', 'Très bon travail d\'équipe'),
('Belat', 'Patrice', 'photo/1234567888.png', '1234567888', '1990-01-27', 195, 81, 'Milieu', 'Actif', ''),
('Lanzoni', 'Fabio', 'photo/1617836108.png', '1617836108', '1959-03-15', 187, 67, 'Milieu', 'Actif', ''),
('Chad', 'Francesco', 'photo/1918171615.png', '1918171615', '1991-01-21', 186, 76, 'Attaquant', 'Suspendu', 'Suspendu jusqu\'au 16 Avril'),
('Gohier', 'Maxime', 'photo/6536291753.png', '6536291753', '1987-10-10', 178, 65, 'Defenseur', 'Actif', ''),
('Barbey', 'François', 'photo/9888888745.png', '9888888745', '1980-10-15', 171, 56, 'Milieu', 'Blessé', 'Torsion à l\'épaule droite');

-- --------------------------------------------------------

--
-- Structure de la table `matchj`
--

DROP TABLE IF EXISTS `matchj`;
CREATE TABLE IF NOT EXISTS `matchj` (
  `DateM` date NOT NULL,
  `HeureM` time NOT NULL,
  `NomEquipeAdv` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Lieu` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Resultat` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IDmatch` int(11) NOT NULL AUTO_INCREMENT,
  `Adresse` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Ville` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`IDmatch`),
  KEY `IDmatch` (`IDmatch`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `matchj`
--

INSERT INTO `matchj` (`DateM`, `HeureM`, `NomEquipeAdv`, `Lieu`, `Resultat`, `IDmatch`, `Adresse`, `Ville`) VALUES
('2023-05-23', '14:30:00', 'MUC CK', 'Domicile', '', 21, '', ''),
('2022-06-08', '16:00:00', 'CKC Saint Omer', 'Exterieur', 'Gagné', 24, '69 rue du coiffeur ', 'Saint Omer'),
('2022-10-22', '10:00:00', 'CK Club de l Agenais', 'Exterieur', 'Perdu', 25, '7 route du pécheur', 'Porte-de-Savoie'),
('2023-05-25', '14:00:00', 'CKCIR Saint-Grégoire', 'Domicile', '', 26, '', ''),
('2022-02-08', '20:00:00', 'CKCIR Saint-Grégoire', 'Exterieur', 'Gagné', 27, '22 Allée des platanes', 'Saint-Grégoire'),
('2022-02-15', '15:00:00', 'CTT', 'Domicile', '', 30, '', '');

-- --------------------------------------------------------

--
-- Structure de la table `participer`
--

DROP TABLE IF EXISTS `participer`;
CREATE TABLE IF NOT EXISTS `participer` (
  `IDmatch` int(11) NOT NULL,
  `NumLicense` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Performance` tinyint(4) DEFAULT NULL,
  `Titulaire` tinyint(1) DEFAULT NULL,
  KEY `IDmatch` (`IDmatch`),
  KEY `NumLicense` (`NumLicense`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `participer`
--

INSERT INTO `participer` (`IDmatch`, `NumLicense`, `Performance`, `Titulaire`) VALUES
(24, '1111111111', 2, 1),
(24, '1215738163', 4, 1),
(24, '1000000000', 4, 1),
(24, '1234567888', 5, 1),
(24, '1617836108', 1, 1),
(25, '1617836108', 4, 1),
(25, '1010101010', 2, 1),
(25, '1111111111', 3, 1),
(25, '1234567888', 4, 1),
(25, '1215738163', 5, 1),
(25, '6536291753', 4, 0),
(21, '6536291753', 0, 1),
(21, '1215738163', 0, 1),
(21, '1111111111', 0, 1),
(21, '1010101010', 0, 0),
(27, '1000000000', 5, 1),
(27, '1215738163', 3, 1),
(27, '1234567888', 3, 1),
(27, '1111111111', 5, 1),
(27, '1010101010', 2, 0),
(27, '6536291753', 4, 1),
(21, '1617836108', 0, 1),
(21, '1000000000', 0, 1),
(30, '1000000000', 0, 1),
(30, '1234567888', 0, 1),
(30, '1111111111', 0, 1),
(30, '1215738163', 0, 1),
(30, '6536291753', 0, 1),
(21, '1000000000', 0, 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `participer`
--
ALTER TABLE `participer`
  ADD CONSTRAINT `Participer_ibfk_1` FOREIGN KEY (`IDmatch`) REFERENCES `matchj` (`IDmatch`),
  ADD CONSTRAINT `Participer_ibfk_2` FOREIGN KEY (`NumLicense`) REFERENCES `joueur` (`NumLicense`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
