-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 14 jan. 2022 à 17:16
-- Version du serveur : 10.4.19-MariaDB
-- Version de PHP : 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `biblio-drive`
--

-- --------------------------------------------------------

--
-- Structure de la table `auteur`
--

CREATE TABLE `auteur` (
  `noauteur` int(11) NOT NULL,
  `nom` varchar(40) NOT NULL,
  `prenom` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `auteur`
--

INSERT INTO `auteur` (`noauteur`, `nom`, `prenom`) VALUES
(1, 'Hugo', 'Victor'),
(2, 'Zola', 'Emile'),
(3, 'Prévert', 'Jacques'),
(4, 'Perrault', 'Charles'),
(5, 'Gautier', 'Théophile');

-- --------------------------------------------------------

--
-- Structure de la table `emprunter`
--

CREATE TABLE `emprunter` (
  `mel` varchar(40) NOT NULL,
  `nolivre` int(11) NOT NULL,
  `dateemprunt` date NOT NULL,
  `dateretour` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `livre`
--

CREATE TABLE `livre` (
  `nolivre` int(11) NOT NULL,
  `noauteur` int(11) NOT NULL,
  `titre` varchar(128) NOT NULL,
  `isbn13` char(13) NOT NULL,
  `anneeparution` int(11) NOT NULL,
  `resume` text NOT NULL,
  `dateajout` date DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `livre`
--

INSERT INTO `livre` (`nolivre`, `noauteur`, `titre`, `isbn13`, `anneeparution`, `resume`, `dateajout`, `image`) VALUES
(1, 1, 'Les Misérables', '1547896324875', 1862, 'Laction se déroule en France au cours du premier tiers du XIXe siècle, entre la bataille de Waterloo (1815) et les émeutes de juin 1832.', '2021-12-10', 'img\\miserable.jpeg'),
(2, 2, 'Germinal', '1458769423104', 1885, 'Fils de Gervaise Macquart et de son amant Auguste Lantier, le jeune Etienne Lantier sest fait renvoyer de son travail pour avoir donné une gifle à son employeur.', '2021-12-10', 'img\\germinal.jpeg'),
(3, 3, 'Paroles', '1523654789420', 1946, 'Paroles comporte 95 textes non ponctués de forme et de longueur très variées.', '2021-12-10', 'img\\paroles.jpeg'),
(4, 4, 'Contes', '2547896348514', 1694, 'Il était une fois un roi et une reine...', '2021-12-10', 'img\\contes.jpeg'),
(5, 5, 'Mademoiselle de Maupin', '4523698745210', 1835, 'Gautier raconte la vie de Madeleine de Maupin qui, avant de succomber aux avances des hommes, désire se travestir afin de surprendre leurs secrets.', '2021-12-10', 'img\\mademoiselle_de_maupin.jpeg'),
(6, 1, 'Les mythos', '1254789654123', 2021, 'Ceci est un test pour le no du livre', '2022-01-07', 'img\\mythos.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `mel` varchar(40) NOT NULL,
  `motdepasse` varchar(140) NOT NULL,
  `nom` varchar(40) NOT NULL,
  `prenom` varchar(40) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `ville` varchar(40) NOT NULL,
  `codepostal` int(11) NOT NULL,
  `profil` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`mel`, `motdepasse`, `nom`, `prenom`, `adresse`, `ville`, `codepostal`, `profil`) VALUES
('fion.fion@gmail.com', 'fion', 'fion', 'fion', 'fion', 'fion', 22440, 'Membre'),
('jambon.beurre@gmail.com', 'jambon', 'beurre', 'jean-bon', 'beurre', 'Ploufragan', 22440, 'Administrateur'),
('lucas.pereira22440@gmail.com', 'azerty01!', 'Pereira', 'Lucas', '6, Rue des villes moisans', 'Ploufragan', 22440, 'Administrateur'),
('titi@titi.com', 'titi', 'titi', 'titi', 'titi', 'titi', 22000, 'Membre'),
('toto.toto@gmail.com', 'toto', 'toto', 'Toto', '8, Rue du Séminaire', 'Quintin', 22800, 'Membre');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `auteur`
--
ALTER TABLE `auteur`
  ADD PRIMARY KEY (`noauteur`);

--
-- Index pour la table `emprunter`
--
ALTER TABLE `emprunter`
  ADD PRIMARY KEY (`mel`,`nolivre`,`dateemprunt`),
  ADD KEY `fk_emprunter_livre` (`nolivre`);

--
-- Index pour la table `livre`
--
ALTER TABLE `livre`
  ADD PRIMARY KEY (`nolivre`),
  ADD KEY `fk_livre_auteur` (`noauteur`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`mel`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `auteur`
--
ALTER TABLE `auteur`
  MODIFY `noauteur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `livre`
--
ALTER TABLE `livre`
  MODIFY `nolivre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `emprunter`
--
ALTER TABLE `emprunter`
  ADD CONSTRAINT `fk_emprunter_livre` FOREIGN KEY (`nolivre`) REFERENCES `livre` (`nolivre`),
  ADD CONSTRAINT `fk_emprunter_utilisateur` FOREIGN KEY (`mel`) REFERENCES `utilisateur` (`mel`);

--
-- Contraintes pour la table `livre`
--
ALTER TABLE `livre`
  ADD CONSTRAINT `fk_livre_auteur` FOREIGN KEY (`noauteur`) REFERENCES `auteur` (`noauteur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
