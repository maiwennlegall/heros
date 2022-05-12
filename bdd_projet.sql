-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 12 mai 2022 à 10:37
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données : `storyofyourlife`
--
CREATE DATABASE IF NOT EXISTS `storyofyourlife` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `storyofyourlife`;

-- --------------------------------------------------------

--
-- Structure de la table `chapitre`
--

CREATE TABLE `chapitre` (
  `id_ch_hors_hist` int(11) NOT NULL,
  `id_chapitre` int(11) NOT NULL,
  `titre` varchar(30) NOT NULL,
  `id_hist` int(11) NOT NULL,
  `id_chap_hist` int(11) NOT NULL,
  `type_fin` int(11) DEFAULT NULL,
  `modif_vie` int(11) NOT NULL,
  `id_ch_choix1` int(11) DEFAULT NULL,
  `id_ch_choix2` int(11) DEFAULT NULL,
  `id_ch_choix3` int(11) DEFAULT NULL,
  `choix1` text DEFAULT NULL,
  `choix2` text DEFAULT NULL,
  `choix3` text DEFAULT NULL,
  `textes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `histoire`
--

CREATE TABLE `histoire` (
  `hist_id` int(11) NOT NULL,
  `titre` varchar(30) NOT NULL,
  `cache` int(11) NOT NULL DEFAULT 1,
  `nb_vie_dbt` int(11) NOT NULL,
  `nb_joue` int(11) NOT NULL DEFAULT 0,
  `nb_gagne` int(11) NOT NULL DEFAULT 0,
  `nb_perdue` int(11) NOT NULL DEFAULT 0,
  `resumer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `historique_partie`
--

CREATE TABLE `historique_partie` (
  `id_historique` int(11) NOT NULL,
  `id_hist` int(11) NOT NULL,
  `id_chap` int(11) NOT NULL,
  `id_joueur` varchar(20) NOT NULL,
  `text_chapitre` text NOT NULL,
  `text_choix_fait` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `partie`
--

CREATE TABLE `partie` (
  `id_partie` int(11) NOT NULL,
  `id_utilisateur` varchar(20) NOT NULL,
  `id_hist` int(11) NOT NULL,
  `point_de_vie` int(11) NOT NULL,
  `id_chap` int(11) NOT NULL,
  `etat_fin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_joueur` varchar(20) NOT NULL,
  `mdp` varchar(20) NOT NULL,
  `administrateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_joueur`, `mdp`, `administrateur`) VALUES
('correcteur', 'mdp_correcteur_1234', 0),
('correcteur_admin', 'mdp_correcteur_1234', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `chapitre`
--
ALTER TABLE `chapitre`
  ADD PRIMARY KEY (`id_ch_hors_hist`),
  ADD KEY `histoire_chap` (`id_hist`);

--
-- Index pour la table `histoire`
--
ALTER TABLE `histoire`
  ADD PRIMARY KEY (`hist_id`);

--
-- Index pour la table `historique_partie`
--
ALTER TABLE `historique_partie`
  ADD PRIMARY KEY (`id_historique`),
  ADD KEY `joueur_historique` (`id_joueur`),
  ADD KEY `histoire_historique` (`id_hist`);

--
-- Index pour la table `partie`
--
ALTER TABLE `partie`
  ADD PRIMARY KEY (`id_partie`),
  ADD KEY `histoire_partie` (`id_hist`),
  ADD KEY `joueur_partie` (`id_utilisateur`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_joueur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `chapitre`
--
ALTER TABLE `chapitre`
  MODIFY `id_ch_hors_hist` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT pour la table `historique_partie`
--
ALTER TABLE `historique_partie`
  MODIFY `id_historique` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT pour la table `partie`
--
ALTER TABLE `partie`
  MODIFY `id_partie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chapitre`
--
ALTER TABLE `chapitre`
  ADD CONSTRAINT `histoire_chap` FOREIGN KEY (`id_hist`) REFERENCES `histoire` (`hist_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `historique_partie`
--
ALTER TABLE `historique_partie`
  ADD CONSTRAINT `histoire_historique` FOREIGN KEY (`id_hist`) REFERENCES `histoire` (`hist_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `joueur_historique` FOREIGN KEY (`id_joueur`) REFERENCES `utilisateur` (`id_joueur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `partie`
--
ALTER TABLE `partie`
  ADD CONSTRAINT `histoire_partie` FOREIGN KEY (`id_hist`) REFERENCES `histoire` (`hist_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `joueur_partie` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_joueur`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
