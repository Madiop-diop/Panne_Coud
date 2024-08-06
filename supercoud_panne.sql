-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 06 août 2024 à 14:27
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
-- Base de données : `supercoud_panne`
--

-- --------------------------------------------------------

--
-- Structure de la table `imputation`
--

CREATE TABLE `imputation` (
  `id` int(11) NOT NULL,
  `id_chef_dst` int(11) NOT NULL,
  `id_panne` int(11) NOT NULL,
  `instruction` text NOT NULL,
  `date_imputation` varchar(255) NOT NULL,
  `resultat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `imputation`
--

INSERT INTO `imputation` (`id`, `id_chef_dst`, `id_panne`, `instruction`, `date_imputation`, `resultat`) VALUES
(4, 3, 11, 'ordre donner !', 'mardi/06 août/2024', 'imputer');

-- --------------------------------------------------------

--
-- Structure de la table `intervention`
--

CREATE TABLE `intervention` (
  `id` int(11) NOT NULL,
  `date_intervention` varchar(255) NOT NULL,
  `description_action` text NOT NULL,
  `resultat` text NOT NULL,
  `personne_agent` varchar(255) NOT NULL,
  `id_chef_atelier` int(11) DEFAULT NULL,
  `id_panne` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `intervention`
--

INSERT INTO `intervention` (`id`, `date_intervention`, `description_action`, `resultat`, `personne_agent`, `id_chef_atelier`, `id_panne`) VALUES
(5, 'mardi/06 août/2024', 'le travail est bien fait et achevèe', 'en cours', 'madiop faye', 2, 11);

-- --------------------------------------------------------

--
-- Structure de la table `observation`
--

CREATE TABLE `observation` (
  `id` int(11) NOT NULL,
  `evaluation_qualite` varchar(50) NOT NULL,
  `date_observation` varchar(255) NOT NULL,
  `commentaire_suggestion` text NOT NULL,
  `id_chef_residence` int(11) DEFAULT NULL,
  `id_panne` int(11) DEFAULT NULL,
  `id_intervention` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `observation`
--

INSERT INTO `observation` (`id`, `evaluation_qualite`, `date_observation`, `commentaire_suggestion`, `id_chef_residence`, `id_panne`, `id_intervention`) VALUES
(13, 'Inachevee', 'mardi/06 août/2024', 'reste des taches a finir', 5, 11, 5);

-- --------------------------------------------------------

--
-- Structure de la table `panne`
--

CREATE TABLE `panne` (
  `id` int(11) NOT NULL,
  `type_panne` varchar(255) NOT NULL,
  `date_enregistrement` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `localisation` varchar(255) NOT NULL,
  `niveau_urgence` varchar(50) NOT NULL,
  `id_chef_residence` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `panne`
--

INSERT INTO `panne` (`id`, `type_panne`, `date_enregistrement`, `description`, `localisation`, `niveau_urgence`, `id_chef_residence`) VALUES
(11, 'Plomberie', 'mardi/06 août/2024', 'robinet a voir!', 'PAV_A--chambre 3', 'Èlevèe', 5),
(12, 'Menuserie_bois', 'mardi/06 août/2024', 'tables detruit !', 'PAV_A--mon bureau', 'Faible', 5);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `profil1` varchar(255) NOT NULL,
  `profil2` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `username`, `password`, `nom`, `prenom`, `profil1`, `profil2`) VALUES
(1, 'pavb', 'coud2024', 'DIOP', 'Madiop', 'residence', 'PAV_B'),
(2, 'atelier', 'coud2024', 'Faye', 'Waly', 'atelier', 'chef d\'atelier'),
(3, 'dst', 'coud2024', 'Fall', 'Ibrahima', 'dst', 'chef dst'),
(4, 'pavd', 'coud2024', 'Ndiaye', 'Ndiaye', 'residence', 'PAV_D'),
(5, 'pava', 'coud2024', 'DIOP', 'Moussa', 'residence', 'PAV_A'),
(7, 'section1', 'coud2024', 'Sylla', 'Sylla', 'section', 'Menuserie_bois'),
(8, 'section2', 'coud2024', 'Faye', 'Faye', 'section', 'Plomberie');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `imputation`
--
ALTER TABLE `imputation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_chef_dst` (`id_chef_dst`),
  ADD KEY `id_panne` (`id_panne`);

--
-- Index pour la table `intervention`
--
ALTER TABLE `intervention`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_chef_atelier` (`id_chef_atelier`),
  ADD KEY `intervention_ibfk_2` (`id_panne`);

--
-- Index pour la table `observation`
--
ALTER TABLE `observation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_chef_residence` (`id_chef_residence`),
  ADD KEY `id_intervention` (`id_intervention`),
  ADD KEY `observation_ibfk_2` (`id_panne`);

--
-- Index pour la table `panne`
--
ALTER TABLE `panne`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_chef_residence` (`id_chef_residence`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `imputation`
--
ALTER TABLE `imputation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `intervention`
--
ALTER TABLE `intervention`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `observation`
--
ALTER TABLE `observation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `panne`
--
ALTER TABLE `panne`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `imputation`
--
ALTER TABLE `imputation`
  ADD CONSTRAINT `imputation_ibfk_1` FOREIGN KEY (`id_chef_dst`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `imputation_ibfk_2` FOREIGN KEY (`id_panne`) REFERENCES `panne` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `intervention`
--
ALTER TABLE `intervention`
  ADD CONSTRAINT `intervention_ibfk_1` FOREIGN KEY (`id_chef_atelier`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `intervention_ibfk_2` FOREIGN KEY (`id_panne`) REFERENCES `panne` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `observation`
--
ALTER TABLE `observation`
  ADD CONSTRAINT `observation_ibfk_1` FOREIGN KEY (`id_chef_residence`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `observation_ibfk_2` FOREIGN KEY (`id_panne`) REFERENCES `panne` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `observation_ibfk_3` FOREIGN KEY (`id_intervention`) REFERENCES `intervention` (`id`);

--
-- Contraintes pour la table `panne`
--
ALTER TABLE `panne`
  ADD CONSTRAINT `panne_ibfk_1` FOREIGN KEY (`id_chef_residence`) REFERENCES `utilisateur` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
