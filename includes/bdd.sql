-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 06 mai 2022 à 15:56
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données : `oledur`
--
CREATE DATABASE IF NOT EXISTS `oledur` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `oledur`;

-- --------------------------------------------------------

--
-- Structure de la table `chapitre`
--

CREATE TABLE IF NOT EXISTS `chapitre` (
  `id_chapitre` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(30) NOT NULL,
  `id_hist` int(11) NOT NULL,
  `type_fin` int(11) DEFAULT NULL,
  `modif_vie` int(11) NOT NULL,
  `id_ch_choix1` int(11) DEFAULT NULL,
  `id_ch_choix2` int(11) DEFAULT NULL,
  `id_ch_choix3` int(11) DEFAULT NULL,
  `choix1` text DEFAULT NULL,
  `choix2` text DEFAULT NULL,
  `choix3` text DEFAULT NULL,
  `textes` text NOT NULL,
  PRIMARY KEY (`id_chapitre`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `chapitre`
--

INSERT INTO `chapitre` (`id_chapitre`, `titre`, `id_hist`, `type_fin`, `modif_vie`, `id_ch_choix1`, `id_ch_choix2`, `id_ch_choix3`, `choix1`, `choix2`, `choix3`, `textes`) VALUES
(1, 'test', 14, NULL, 0, 2, 3, 4, 'un', 'deux', 'trois', 'prout'),
(2, 'mais', 14, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'pourqioi'),
(3, 'oh', 14, NULL, 0, 5, 6, 7, 'ça', 'marche', 'lol', 'please'),
(4, 'oh', 14, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'nini'),
(5, 'putan', 14, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'jbvjnbe'),
(6, 'ftgyhujiko', 14, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'fgvhjkl'),
(7, 'poiu', 14, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'lkjiuytfr'),
(8, 'poiu', 14, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'lkjiuytfr');

-- --------------------------------------------------------

--
-- Structure de la table `histoire`
--

CREATE TABLE IF NOT EXISTS `histoire` (
  `hist_id` int(11) NOT NULL,
  `titre` varchar(30) NOT NULL,
  `cache` int(11) NOT NULL DEFAULT 1,
  `nb_vie_dbt` int(11) NOT NULL,
  `nb_joue` int(11) NOT NULL DEFAULT 0,
  `nb_gagne` int(11) NOT NULL DEFAULT 0,
  `nb_perdue` int(11) NOT NULL DEFAULT 0,
  `resumer` text NOT NULL,
  PRIMARY KEY (`hist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `histoire`
--

INSERT INTO `histoire` (`hist_id`, `titre`, `cache`, `nb_vie_dbt`, `nb_joue`, `nb_gagne`, `nb_perdue`, `resumer`) VALUES
(14, 'bordel', 0, 8, 0, 0, 0, 'testons');

-- --------------------------------------------------------

--
-- Structure de la table `historique_partie`
--

CREATE TABLE IF NOT EXISTS `historique_partie` (
  `id_historique` int(11) NOT NULL AUTO_INCREMENT,
  `id_hist` int(11) NOT NULL,
  `id_joueur` varchar(20) NOT NULL,
  `text_chapitre` text NOT NULL,
  `text_choix_fait` text NOT NULL,
  PRIMARY KEY (`id_historique`),
  KEY `cle_etr` (`id_joueur`),
  KEY `cle_etrangerebis` (`id_hist`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `historique_partie`
--

INSERT INTO `historique_partie` (`id_historique`, `id_hist`, `id_joueur`, `text_chapitre`, `text_choix_fait`) VALUES
(18, 14, 'administrateur', 'prout', 'deux');

-- --------------------------------------------------------

--
-- Structure de la table `partie`
--

CREATE TABLE IF NOT EXISTS `partie` (
  `id_partie` int(11) NOT NULL AUTO_INCREMENT,
  `id_utilisateur` varchar(20) NOT NULL,
  `id_hist` int(11) NOT NULL,
  `point_de_vie` int(11) NOT NULL,
  `id_chap` int(11) NOT NULL,
  `etat_fin` int(11) NOT NULL,
  PRIMARY KEY (`id_partie`),
  KEY `clee` (`id_chap`),
  KEY `key` (`id_hist`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `partie`
--

INSERT INTO `partie` (`id_partie`, `id_utilisateur`, `id_hist`, `point_de_vie`, `id_chap`, `etat_fin`) VALUES
(4, 'administrateur', 14, 8, 3, 0);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_joueur` varchar(20) NOT NULL,
  `mdp` varchar(20) NOT NULL,
  `administrateur` int(11) NOT NULL,
  PRIMARY KEY (`id_joueur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_joueur`, `mdp`, `administrateur`) VALUES
('administrateur', 'baba', 1),
('pipou', 'lalala', 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chapitre`
--
ALTER TABLE `chapitre`
  ADD CONSTRAINT `cle_etrangere` FOREIGN KEY (`id_hist`) REFERENCES `histoire` (`hist_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `partie`
--
ALTER TABLE `partie`
  ADD CONSTRAINT `clee` FOREIGN KEY (`id_chap`) REFERENCES `chapitre` (`id_chapitre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `key` FOREIGN KEY (`id_hist`) REFERENCES `histoire` (`hist_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
