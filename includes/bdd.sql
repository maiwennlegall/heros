-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 05 mai 2022 à 23:01
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données : `storyofyourlife`
--

-- --------------------------------------------------------

--
-- Structure de la table `chapitre`
--

CREATE TABLE `chapitre` (
  `id_chapitre` int(11) NOT NULL,
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
  `textes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `chapitre`
--

INSERT INTO `chapitre` (`id_chapitre`, `titre`, `id_hist`, `type_fin`, `modif_vie`, `id_ch_choix1`, `id_ch_choix2`, `id_ch_choix3`, `choix1`, `choix2`, `choix3`, `textes`) VALUES
(1, 'aaaaaaaaaaaaa', 1, NULL, -2, 2, 3, 4, 'poopop', 'nono', 'ouiiiiiiiiiiiii', 'dbt'),
(2, 'oui', 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Texte de votre chapitre'),
(3, 'n', 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Texte de votre chapitre'),
(4, 'ouih', 1, NULL, 2, 5, 6, 7, 'oui', 'no', 'pop', 'Texte de votre chapitre'),
(5, 'pou', 1, NULL, -1, 8, 9, 10, 'jouui', 'pop', 'non', 'Texte de votre chapitre'),
(6, 'jou', 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Texte de votre chapitre'),
(7, 'lol', 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Texte de votre chapitre'),
(8, 'jhu', 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Texte de votre chapitre'),
(9, 'ju', 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Texte de votre chapitre'),
(10, 'hhui', 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Texte de votre chapitre');

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

--
-- Déchargement des données de la table `histoire`
--

INSERT INTO `histoire` (`hist_id`, `titre`, `cache`, `nb_vie_dbt`, `nb_joue`, `nb_gagne`, `nb_perdue`, `resumer`) VALUES
(1, 'test', 0, 4, 0, 0, 0, 'je test'),
(2, 'mdr', 1, 8, 0, 0, 0, 'on rigole de fou');

-- --------------------------------------------------------

--
-- Structure de la table `historique_partie`
--

CREATE TABLE `historique_partie` (
  `id_historique` int(11) NOT NULL,
  `id_hist` int(11) NOT NULL,
  `id_joueur` varchar(20) NOT NULL,
  `text_chapitre` text NOT NULL,
  `text_choix_fait` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `historique_partie`
--

INSERT INTO `historique_partie` (`id_historique`, `id_hist`, `id_joueur`, `text_chapitre`, `text_choix_fait`) VALUES
(8, 1, 'administrateur', 'dbt', 'ouiiiiiiiiiiiii');

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

--
-- Déchargement des données de la table `partie`
--

INSERT INTO `partie` (`id_partie`, `id_utilisateur`, `id_hist`, `point_de_vie`, `id_chap`, `etat_fin`) VALUES
(2, '0', 1, -2, 8, 1),
(3, 'administrateur', 1, 2, 4, 0);

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
('administrateur', 'baba', 1),
('pipou', 'lalala', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `chapitre`
--
ALTER TABLE `chapitre`
  ADD PRIMARY KEY (`id_chapitre`),
  ADD KEY `cle_etrangere` (`id_hist`);

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
  ADD KEY `cle_etr` (`id_joueur`),
  ADD KEY `cle_etrangerebis` (`id_hist`);

--
-- Index pour la table `partie`
--
ALTER TABLE `partie`
  ADD PRIMARY KEY (`id_partie`),
  ADD KEY `clee` (`id_chap`),
  ADD KEY `key` (`id_hist`);

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
  MODIFY `id_chapitre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `historique_partie`
--
ALTER TABLE `historique_partie`
  MODIFY `id_historique` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `partie`
--
ALTER TABLE `partie`
  MODIFY `id_partie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
