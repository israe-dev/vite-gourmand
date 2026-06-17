-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 08 juin 2026 à 20:19
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `vite_gourmand`
--

-- --------------------------------------------------------

--
-- Structure de la table `allergenes`
--

CREATE TABLE `allergenes` (
  `id` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `allergene_plat`
--

CREATE TABLE `allergene_plat` (
  `plat_id` int(11) NOT NULL,
  `allergene_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `id` int(11) NOT NULL,
  `note` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `statut` varchar(30) DEFAULT 'en_attente',
  `commande_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id` int(11) NOT NULL,
  `date_commande` date NOT NULL,
  `date_prestation` date NOT NULL,
  `heure_livraison` time NOT NULL,
  `lieu_livraison` varchar(200) NOT NULL,
  `nombre_personnes` int(11) NOT NULL,
  `prix_menu` double(8,2) NOT NULL,
  `prix_livraison` double(8,2) NOT NULL,
  `prix_materiel` tinyint(1) DEFAULT 0,
  `statut` varchar(50) DEFAULT 'en attente',
  `utilisateur_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `horaires`
--

CREATE TABLE `horaires` (
  `id` int(11) NOT NULL,
  `jour` int(11) NOT NULL,
  `heure_ouverture` varchar(10) DEFAULT NULL,
  `heure_fermeture` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `horaires`
--

INSERT INTO `horaires` (`id`, `jour`, `heure_ouverture`, `heure_fermeture`) VALUES
(1, 1, '08:00', '22:00'),
(2, 2, '08:00', '22:00'),
(3, 3, '08:00', '22:00'),
(4, 4, '08:00', '22:00'),
(5, 5, '08:00', '23:59'),
(6, 6, '09:00', '23:59'),
(7, 7, '09:00', '21:00');

-- --------------------------------------------------------

--
-- Structure de la table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `nb_personne_minimum` int(11) NOT NULL,
  `prix_par_personne` double(8,2) NOT NULL,
  `conditions` text DEFAULT NULL,
  `quantite_restante` int(11) DEFAULT 0,
  `theme_id` int(11) DEFAULT NULL,
  `regime_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `menu_plat`
--

CREATE TABLE `menu_plat` (
  `menu_id` int(11) NOT NULL,
  `plat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `plats`
--

CREATE TABLE `plats` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `type` varchar(30) NOT NULL,
  `photo` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `regimes`
--

CREATE TABLE `regimes` (
  `id` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `regimes`
--

INSERT INTO `regimes` (`id`, `libelle`) VALUES
(1, 'Végétarien'),
(2, 'Végan'),
(3, 'Classique');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `libelle`) VALUES
(1, 'administrateur'),
(2, 'employe'),
(3, 'utilisateur');

-- --------------------------------------------------------

--
-- Structure de la table `themes`
--

CREATE TABLE `themes` (
  `id` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `themes`
--

INSERT INTO `themes` (`id`, `libelle`) VALUES
(1, 'Noël'),
(2, 'Pâques'),
(3, 'Classique'),
(4, 'Évènement');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `statut` tinyint(1) DEFAULT 1,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `allergenes`
--
ALTER TABLE `allergenes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `allergene_plat`
--
ALTER TABLE `allergene_plat`
  ADD PRIMARY KEY (`plat_id`,`allergene_id`),
  ADD KEY `allergene_id` (`allergene_id`);

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commande_id` (`commande_id`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Index pour la table `horaires`
--
ALTER TABLE `horaires`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `theme_id` (`theme_id`),
  ADD KEY `regime_id` (`regime_id`);

--
-- Index pour la table `menu_plat`
--
ALTER TABLE `menu_plat`
  ADD PRIMARY KEY (`menu_id`,`plat_id`),
  ADD KEY `plat_id` (`plat_id`);

--
-- Index pour la table `plats`
--
ALTER TABLE `plats`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `regimes`
--
ALTER TABLE `regimes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `allergenes`
--
ALTER TABLE `allergenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `horaires`
--
ALTER TABLE `horaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `plats`
--
ALTER TABLE `plats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `regimes`
--
ALTER TABLE `regimes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `themes`
--
ALTER TABLE `themes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `allergene_plat`
--
ALTER TABLE `allergene_plat`
  ADD CONSTRAINT `allergene_plat_ibfk_1` FOREIGN KEY (`plat_id`) REFERENCES `plats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `allergene_plat_ibfk_2` FOREIGN KEY (`allergene_id`) REFERENCES `allergenes` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `avis_ibfk_1` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `commandes_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`);

--
-- Contraintes pour la table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`id`),
  ADD CONSTRAINT `menus_ibfk_2` FOREIGN KEY (`regime_id`) REFERENCES `regimes` (`id`);

--
-- Contraintes pour la table `menu_plat`
--
ALTER TABLE `menu_plat`
  ADD CONSTRAINT `menu_plat_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `menu_plat_ibfk_2` FOREIGN KEY (`plat_id`) REFERENCES `plats` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `utilisateurs_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
