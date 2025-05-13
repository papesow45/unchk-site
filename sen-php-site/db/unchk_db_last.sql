-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 13 mai 2025 à 00:34
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `unchk_db_last`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_naissance` date DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `type_utilisateur` enum('admin') NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id`, `nom`, `prenom`, `email`, `password`, `role_id`, `is_active`, `created_at`, `date_naissance`, `telephone`, `type_utilisateur`) VALUES
(1, 'DIALLO', 'Awa', 'awa.diallo@example.com', '$2y$10$FWLa2WZzPQQde/5FJffyg.h731yEwm6JNWfm7EAMFQtqN/G7Bz3ZW', 1, 1, '2025-05-10 09:00:00', '1985-03-12', '+221771234567', 'admin'),
(2, 'SOW', 'Mamadou', 'mamadou.sow@example.com', '$2y$10$FWLa2WZzPQQde/5FJffyg.h731yEwm6JNWfm7EAMFQtqN/G7Bz3ZW', 1, 1, '2025-05-10 09:05:00', '1990-07-22', '+221775678901', 'admin'),
(3, 'NDIAYE', 'Fatou', 'fatou.ndiaye@example.com', '$2y$10$FWLa2WZzPQQde/5FJffyg.h731yEwm6JNWfm7EAMFQtqN/G7Bz3ZW', 1, 1, '2025-05-10 09:10:00', '1988-11-05', '+221776543210', 'admin'),
(4, 'BA', 'Cheikh', 'cheikh.ba@example.com', '$2y$10$FWLa2WZzPQQde/5FJffyg.h731yEwm6JNWfm7EAMFQtqN/G7Bz3ZW', 1, 1, '2025-05-10 09:15:00', '1979-02-17', '+221778901234', 'admin'),
(5, 'NDIONE', 'Aissatou', 'aissatou.ndione@example.com', '$2y$10$FWLa2WZzPQQde/5FJffyg.h731yEwm6JNWfm7EAMFQtqN/G7Bz3ZW', 1, 1, '2025-05-10 09:20:00', '1995-12-30', '+221779012345', 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `enos`
--

CREATE TABLE `enos` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `zone_id` int(10) UNSIGNED NOT NULL,
  `estDisponible` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = disponible, 0 = non disponible',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(10) UNSIGNED NOT NULL COMMENT 'ID de l''utilisateur créateur',
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(10) UNSIGNED DEFAULT NULL COMMENT 'ID de l''utilisateur ayant modifié pour la dernière fois'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `enos`
--

INSERT INTO `enos` (`id`, `code`, `nom`, `adresse`, `telephone`, `zone_id`, `estDisponible`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'ENO-ZA-001', 'ENO Dakar Centre', 'Avenue Léopold Sédar Senghor, Dakar', '221781234501', 1, 1, '2025-01-15 10:30:00', 1, '2025-05-10 15:20:00', 1),
(2, 'ENO-ZA-002', 'ENO Plateau', 'Rue Félix Faure, Dakar', '221781234502', 1, 1, '2025-01-20 11:45:00', 2, NULL, NULL),
(3, 'ENO-ZA-003', 'ENO Médina', 'Boulevard du Général De Gaulle, Dakar', '221781234503', 1, 0, '2025-01-25 09:15:00', 1, '2025-04-15 14:30:00', 3),
(4, 'ENO-ZB-001', 'ENO Guédiawaye', 'Quartier Notaire, Guédiawaye', '221781234504', 2, 1, '2025-02-10 08:30:00', 3, NULL, NULL),
(5, 'ENO-ZB-002', 'ENO Parcelles Assainies', 'Unité 26, Parcelles Assainies', '221781234505', 2, 1, '2025-02-15 13:20:00', 2, '2025-05-05 10:45:00', 1),
(6, 'ENO-ZB-003', 'ENO Pikine', 'Rue 10, Pikine', '221781234506', 2, 0, '2025-02-20 15:10:00', 1, NULL, NULL),
(7, 'ENO-ZC-001', 'ENO Thiès Centre', 'Avenue Caen, Thiès', '221781234507', 3, 1, '2025-03-05 09:45:00', 2, NULL, NULL),
(8, 'ENO-ZC-002', 'ENO Mbour', 'Route de Dakar, Mbour', '221781234508', 3, 1, '2025-03-10 14:30:00', 1, '2025-04-20 11:15:00', 2),
(9, 'ENO-ZC-003', 'ENO Tivaouane', 'Quartier Keur Mame El Hadji, Tivaouane', '221781234509', 3, 0, '2025-03-15 10:20:00', 3, NULL, NULL),
(10, 'ENO-ZD-001', 'ENO Saint-Louis Centre', 'Rue Blaise Diagne, Saint-Louis', '221781234510', 4, 1, '2025-04-01 11:30:00', 1, NULL, NULL),
(11, 'ENO-ZD-002', 'ENO Richard Toll', 'Avenue Macky Sall, Richard Toll', '221781234511', 4, 1, '2025-04-05 13:45:00', 2, '2025-05-01 09:30:00', 1),
(12, 'ENO-ZD-003', 'ENO Dagana', 'Quartier Diamaguene, Dagana', '221781234512', 4, 0, '2025-04-10 15:20:00', 3, NULL, NULL),
(13, 'ENO-ZE-001', 'ENO Ziguinchor Centre', 'Avenue du Général De Gaulle, Ziguinchor', '221781234513', 5, 1, '2025-05-01 10:15:00', 2, NULL, NULL),
(14, 'ENO-ZE-002', 'ENO Bignona', 'Quartier Bassène, Bignona', '221781234514', 5, 1, '2025-05-05 14:30:00', 1, '2025-05-10 11:45:00', 3),
(15, 'ENO-ZE-003', 'ENO Oussouye', 'Route de Ziguinchor, Oussouye', '221781234515', 5, 0, '2025-05-10 09:20:00', 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

CREATE TABLE `etudiants` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL DEFAULT 2 COMMENT '2 = étudiant',
  `prenom` varchar(100) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `age` tinyint(3) UNSIGNED DEFAULT NULL,
  `sexe` enum('M','F') NOT NULL DEFAULT 'M',
  `INE` char(12) NOT NULL COMMENT 'Format INE00000001, etc.',
  `pole_id` int(10) UNSIGNED NOT NULL,
  `filiere_id` int(10) UNSIGNED NOT NULL,
  `zone_id` int(10) UNSIGNED NOT NULL,
  `eno_id` int(10) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL COMMENT 'ID de l''admin créateur',
  `updated_by` int(10) UNSIGNED DEFAULT NULL COMMENT 'ID de l''admin qui a fait la mise à jour',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `etudiants`
--

INSERT INTO `etudiants` (`id`, `role_id`, `prenom`, `nom`, `email`, `password`, `telephone`, `age`, `sexe`, `INE`, `pole_id`, `filiere_id`, `zone_id`, `eno_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 2, 'Alice', 'Diop', 'alice.diop@example.com', '$2y$10$FWLa2WZzPQQde/5FJffyg.h731yEwm6JNWfm7EAMFQtqN/G7Bz3ZW', '+221771234000', 20, 'F', 'INE00000001', 1, 1, 1, 1, 1, NULL, '2025-05-11 02:39:13', '2025-05-11 02:41:18'),
(2, 2, 'Blaise', 'Kouyaté', 'blaise.kouyate@example.com', '$2y$10$FWLa2WZzPQQde/5FJffyg.h731yEwm6JNWfm7EAMFQtqN/G7Bz3ZW', '+221771234001', 22, 'M', 'INE00000002', 1, 2, 1, 2, 1, NULL, '2025-05-11 02:39:13', '2025-05-11 02:41:28'),
(3, 2, 'Carla', 'Ngom', 'carla.ngom@example.com', '$2y$10$FWLa2WZzPQQde/5FJffyg.h731yEwm6JNWfm7EAMFQtqN/G7Bz3ZW', '+221771234002', 19, 'F', 'INE00000003', 2, 3, 2, 3, 1, NULL, '2025-05-11 02:39:13', '2025-05-11 02:41:36'),
(4, 2, 'Daniel', 'Sarr', 'daniel.sarr@example.com', '$2y$10$FWLa2WZzPQQde/5FJffyg.h731yEwm6JNWfm7EAMFQtqN/G7Bz3ZW', '+221771234003', 21, 'M', 'INE00000004', 2, 1, 2, 1, 1, NULL, '2025-05-11 02:39:13', '2025-05-11 02:41:42'),
(5, 2, 'Eva', 'Ba', 'eva.ba@example.com', '$2y$10$FWLa2WZzPQQde/5FJffyg.h731yEwm6JNWfm7EAMFQtqN/G7Bz3ZW', '+221771234004', 23, 'F', 'INE00000005', 1, 2, 3, 2, 1, NULL, '2025-05-11 02:39:13', '2025-05-11 02:41:49');

-- --------------------------------------------------------

--
-- Structure de la table `filieres`
--

CREATE TABLE `filieres` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `pole_id` int(10) UNSIGNED NOT NULL,
  `estDisponible` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = disponible, 0 = non disponible',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(10) UNSIGNED NOT NULL COMMENT 'ID de l''utilisateur créateur',
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(10) UNSIGNED DEFAULT NULL COMMENT 'ID de l''utilisateur ayant modifié pour la dernière fois'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `filieres`
--

INSERT INTO `filieres` (`id`, `code`, `nom`, `description`, `pole_id`, `estDisponible`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'INFO', 'Informatique', 'Filière d\'informatique générale', 1, 1, '2025-01-15 10:30:00', 1, NULL, NULL),
(2, 'RESX', 'Réseaux et Télécommunications', 'Spécialisation en réseaux informatiques', 1, 1, '2025-01-20 11:45:00', 2, NULL, NULL),
(3, 'SECU', 'Sécurité Informatique', 'Spécialisation en cybersécurité', 1, 0, '2025-01-25 09:15:00', 1, '2025-04-15 14:30:00', 3),
(4, 'DEVWEB', 'Développement Web', 'Spécialisation en développement d\'applications web', 1, 1, '2025-02-05 10:15:00', 2, NULL, NULL),
(5, 'DATASCIENCE', 'Science des Données', 'Analyse et traitement des données massives', 1, 1, '2025-02-08 14:20:00', 1, NULL, NULL),
(6, 'GEST', 'Gestion d\'Entreprise', 'Formation en management et gestion', 2, 1, '2025-02-10 08:30:00', 3, NULL, NULL),
(7, 'COMPT', 'Comptabilité', 'Spécialisation en comptabilité et finance', 2, 1, '2025-02-15 13:20:00', 2, NULL, NULL),
(8, 'DROIT', 'Sciences Juridiques', 'Formation en droit', 2, 0, '2025-02-20 15:10:00', 1, NULL, NULL),
(9, 'MARKETING', 'Marketing Digital', 'Stratégies de marketing en ligne', 2, 1, '2025-02-25 09:30:00', 3, NULL, NULL),
(10, 'FINANCE', 'Finance d\'Entreprise', 'Gestion financière et investissements', 2, 1, '2025-03-01 11:45:00', 2, NULL, NULL),
(11, 'LETT', 'Lettres Modernes', 'Études littéraires', 3, 1, '2025-03-05 09:45:00', 2, NULL, NULL),
(12, 'SOCIO', 'Sociologie', 'Études des phénomènes sociaux', 3, 1, '2025-03-10 14:30:00', 1, NULL, NULL),
(13, 'EDUC', 'Sciences de l\'Éducation', 'Formation aux métiers de l\'enseignement', 3, 1, '2025-03-15 10:20:00', 3, '2025-05-12 21:56:59', 1),
(14, 'PHILO', 'Philosophie', 'Études philosophiques et éthiques', 3, 1, '2025-03-20 13:15:00', 1, NULL, NULL),
(15, 'PSYCHO', 'Psychologie', 'Étude du comportement humain a', 3, 1, '2025-03-25 15:30:00', 2, '2025-05-11 21:31:12', 1),
(16, 'BIOTECH', 'Biotechnologie', 'Applications technologiques en biologie', 4, 1, '2025-04-01 09:00:00', 1, NULL, NULL),
(17, 'AGRO', 'Agronomie', 'Sciences agricoles et développement durable', 4, 1, '2025-04-05 11:30:00', 3, NULL, NULL),
(18, 'ENVIRO', 'Sciences Environnementales', 'Étude et protection de l\'environnement', 4, 1, '2025-04-10 14:15:00', 2, NULL, NULL),
(19, 'CHIMIE', 'Chimie Appliquée', 'Applications industrielles de la chimie', 4, 0, '2025-04-15 10:45:00', 1, NULL, NULL),
(20, 'PHYSIQUE', 'Physique Moderne', 'Étude des phénomènes physiques avancés', 4, 1, '2025-04-20 13:00:00', 3, NULL, NULL),
(21, 'SANTE', 'Sciences de la Santé', 'Formation aux métiers de la santé', 5, 1, '2025-04-25 09:30:00', 2, NULL, NULL),
(22, 'PHARMA', 'Sciences Pharmaceutiques', 'Développement et étude des médicaments', 5, 1, '2025-04-30 11:45:00', 1, NULL, NULL),
(23, 'NUTRI', 'Nutrition et Diététique', 'Étude de l\'alimentation et de la santé', 5, 1, '2025-05-05 14:00:00', 3, NULL, NULL),
(24, 'SPORT', 'Sciences du Sport', 'Physiologie et performance sportive', 5, 0, '2025-05-10 10:15:00', 2, NULL, NULL),
(25, 'INFIRM', 'Soins Infirmiers', 'Formation aux soins de santé', 5, 1, '2025-05-15 13:30:00', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `lecons`
--

CREATE TABLE `lecons` (
  `id` int(10) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `matiere_id` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `created_by` int(10) UNSIGNED DEFAULT NULL COMMENT 'ID de l''utilisateur créateur',
  `updated_by` int(10) UNSIGNED DEFAULT NULL COMMENT 'ID de l''utilisateur modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `lecons`
--

INSERT INTO `lecons` (`id`, `titre`, `contenu`, `matiere_id`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'Introduction à Algorithmique', 'Cette leçon présente les bases de Algorithmique.', 1, '2025-05-11 00:35:01', NULL, NULL, NULL),
(2, 'Introduction à Structures de données', 'Cette leçon présente les bases de Structures de données.', 2, '2025-05-11 00:35:01', NULL, NULL, NULL),
(3, 'Introduction à Réseaux locaux', 'Cette leçon présente les bases de Réseaux locaux.', 3, '2025-05-11 00:35:01', NULL, NULL, NULL),
(4, 'Introduction à Réseaux étendus', 'Cette leçon présente les bases de Réseaux étendus.', 4, '2025-05-11 00:35:01', NULL, NULL, NULL),
(5, 'Introduction à Cryptographie', 'Cette leçon présente les bases de Cryptographie.', 5, '2025-05-11 00:35:01', NULL, NULL, NULL),
(6, 'Introduction à Tests d’intrusion', 'Cette leçon présente les bases de Tests d’intrusion.', 6, '2025-05-11 00:35:01', NULL, NULL, NULL),
(7, 'Introduction à HTML & CSS', 'Cette leçon présente les bases de HTML & CSS.', 7, '2025-05-11 00:35:01', NULL, NULL, NULL),
(8, 'Introduction à JavaScript', 'Cette leçon présente les bases de JavaScript.', 8, '2025-05-11 00:35:01', NULL, NULL, NULL),
(9, 'Introduction à Statistiques', 'Cette leçon présente les bases de Statistiques.', 9, '2025-05-11 00:35:01', NULL, NULL, NULL),
(10, 'Introduction à Machine Learning', 'Cette leçon présente les bases de Machine Learning.', 10, '2025-05-11 00:35:01', NULL, NULL, NULL),
(11, 'Introduction à Management général', 'Cette leçon présente les bases de Management général.', 11, '2025-05-11 00:35:01', NULL, NULL, NULL),
(12, 'Introduction à Stratégie d’entreprise', 'Cette leçon présente les bases de Stratégie d’entreprise.', 12, '2025-05-11 00:35:01', NULL, NULL, NULL),
(13, 'Introduction à Fiscalité', 'Cette leçon présente les bases de Fiscalité.', 13, '2025-05-11 00:35:01', NULL, NULL, NULL),
(14, 'Introduction à Audit financier', 'Cette leçon présente les bases de Audit financier.', 14, '2025-05-11 00:35:01', NULL, NULL, NULL),
(15, 'Introduction à Droit civil', 'Cette leçon présente les bases de Droit civil.', 15, '2025-05-11 00:35:01', NULL, NULL, NULL),
(16, 'Introduction à Droit pénal', 'Cette leçon présente les bases de Droit pénal.', 16, '2025-05-11 00:35:01', NULL, NULL, NULL),
(17, 'Introduction à Marketing stratégique', 'Cette leçon présente les bases de Marketing stratégique.', 17, '2025-05-11 00:35:01', NULL, NULL, NULL),
(18, 'Introduction à Marketing opérationnel', 'Cette leçon présente les bases de Marketing opérationnel.', 18, '2025-05-11 00:35:01', NULL, NULL, NULL),
(19, 'Introduction à Finance de marché', 'Cette leçon présente les bases de Finance de marché.', 19, '2025-05-11 00:35:01', NULL, NULL, NULL),
(20, 'Introduction à Gestion de portefeuille', 'Cette leçon présente les bases de Gestion de portefeuille.', 20, '2025-05-11 00:35:01', NULL, NULL, NULL),
(21, 'Introduction à Littérature française', 'Cette leçon présente les bases de Littérature française.', 21, '2025-05-11 00:35:01', NULL, NULL, NULL),
(22, 'Introduction à Littérature comparée', 'Cette leçon présente les bases de Littérature comparée.', 22, '2025-05-11 00:35:01', NULL, NULL, NULL),
(23, 'Introduction à Sociologie urbaine', 'Cette leçon présente les bases de Sociologie urbaine.', 23, '2025-05-11 00:35:01', NULL, NULL, NULL),
(24, 'Introduction à Sociologie du travail', 'Cette leçon présente les bases de Sociologie du travail.', 24, '2025-05-11 00:35:01', NULL, NULL, NULL),
(25, 'Introduction à Pédagogie', 'Cette leçon présente les bases de Pédagogie.', 25, '2025-05-11 00:35:01', NULL, NULL, NULL),
(26, 'Introduction à Psychologie de l’élève', 'Cette leçon présente les bases de Psychologie de l’élève.', 26, '2025-05-11 00:35:01', NULL, NULL, NULL),
(27, 'Introduction à Métaphysique', 'Cette leçon présente les bases de Métaphysique.', 27, '2025-05-11 00:35:01', NULL, NULL, NULL),
(28, 'Introduction à Logique', 'Cette leçon présente les bases de Logique.', 28, '2025-05-11 00:35:01', NULL, NULL, NULL),
(29, 'Introduction à Psychologie cognitive', 'Cette leçon présente les bases de Psychologie cognitive.', 29, '2025-05-11 00:35:01', NULL, NULL, NULL),
(30, 'Introduction à Psychologie clinique', 'Cette leçon présente les bases de Psychologie clinique.', 30, '2025-05-11 00:35:01', NULL, NULL, NULL),
(31, 'Introduction à Biochimie', 'Cette leçon présente les bases de Biochimie.', 31, '2025-05-11 00:35:01', NULL, NULL, NULL),
(32, 'Introduction à Génétique', 'Cette leçon présente les bases de Génétique.', 32, '2025-05-11 00:35:01', NULL, NULL, NULL),
(33, 'Introduction à Agroécologie', 'Cette leçon présente les bases de Agroécologie.', 33, '2025-05-11 00:35:01', NULL, NULL, NULL),
(34, 'Introduction à Sciences du sol', 'Cette leçon présente les bases de Sciences du sol.', 34, '2025-05-11 00:35:01', NULL, NULL, NULL),
(35, 'Introduction à Écologie', 'Cette leçon présente les bases de Écologie.', 35, '2025-05-11 00:35:01', NULL, NULL, NULL),
(36, 'Introduction à Gestion de l’eau', 'Cette leçon présente les bases de Gestion de l’eau.', 36, '2025-05-11 00:35:01', NULL, NULL, NULL),
(37, 'Introduction à Chimie organique', 'Cette leçon présente les bases de Chimie organique.', 37, '2025-05-11 00:35:01', NULL, NULL, NULL),
(38, 'Introduction à Chimie inorganique', 'Cette leçon présente les bases de Chimie inorganique.', 38, '2025-05-11 00:35:01', NULL, NULL, NULL),
(39, 'Introduction à Mécanique', 'Cette leçon présente les bases de Mécanique.', 39, '2025-05-11 00:35:01', NULL, NULL, NULL),
(40, 'Introduction à Électromagnétisme', 'Cette leçon présente les bases de Électromagnétisme.', 40, '2025-05-11 00:35:01', NULL, NULL, NULL),
(41, 'Introduction à Anatomie', 'Cette leçon présente les bases de Anatomie.', 41, '2025-05-11 00:35:01', NULL, NULL, NULL),
(42, 'Introduction à Physiologie', 'Cette leçon présente les bases de Physiologie.', 42, '2025-05-11 00:35:01', NULL, NULL, NULL),
(43, 'Introduction à Pharmacologie', 'Cette leçon présente les bases de Pharmacologie.', 43, '2025-05-11 00:35:01', NULL, NULL, NULL),
(44, 'Introduction à Chimie pharmaceutique', 'Cette leçon présente les bases de Chimie pharmaceutique.', 44, '2025-05-11 00:35:01', NULL, NULL, NULL),
(45, 'Introduction à Nutrition clinique', 'Cette leçon présente les bases de Nutrition clinique.', 45, '2025-05-11 00:35:01', NULL, NULL, NULL),
(46, 'Introduction à Diététique appliquée', 'Cette leçon présente les bases de Diététique appliquée.', 46, '2025-05-11 00:35:01', NULL, NULL, NULL),
(47, 'Introduction à Physiologie de l’exercice', 'Cette leçon présente les bases de Physiologie de l’exercice.', 47, '2025-05-11 00:35:01', NULL, NULL, NULL),
(48, 'Introduction à Biomécanique', 'Cette leçon présente les bases de Biomécanique.', 48, '2025-05-11 00:35:01', NULL, NULL, NULL),
(49, 'Introduction à Soins d’urgence', 'Cette leçon présente les bases de Soins d’urgence.', 49, '2025-05-11 00:35:01', NULL, NULL, NULL),
(50, 'Introduction à Gériatrie', 'Cette leçon présente les bases de Gériatrie.', 50, '2025-05-11 00:35:01', NULL, NULL, NULL),
(51, 'Théorie de Algorithmique', 'Développement des concepts clés de Algorithmique.', 1, '2025-05-11 00:35:01', NULL, NULL, NULL),
(52, 'Théorie de Structures de données', 'Développement des concepts clés de Structures de données.', 2, '2025-05-11 00:35:01', NULL, NULL, NULL),
(53, 'Théorie de Réseaux locaux', 'Développement des concepts clés de Réseaux locaux.', 3, '2025-05-11 00:35:01', NULL, NULL, NULL),
(54, 'Théorie de Réseaux étendus', 'Développement des concepts clés de Réseaux étendus.', 4, '2025-05-11 00:35:01', NULL, NULL, NULL),
(55, 'Théorie de Cryptographie', 'Développement des concepts clés de Cryptographie.', 5, '2025-05-11 00:35:01', NULL, NULL, NULL),
(56, 'Théorie de Tests d’intrusion', 'Développement des concepts clés de Tests d’intrusion.', 6, '2025-05-11 00:35:01', NULL, NULL, NULL),
(57, 'Théorie de HTML & CSS', 'Développement des concepts clés de HTML & CSS.', 7, '2025-05-11 00:35:01', NULL, NULL, NULL),
(58, 'Théorie de JavaScript', 'Développement des concepts clés de JavaScript.', 8, '2025-05-11 00:35:01', NULL, NULL, NULL),
(59, 'Théorie de Statistiques', 'Développement des concepts clés de Statistiques.', 9, '2025-05-11 00:35:01', NULL, NULL, NULL),
(60, 'Théorie de Machine Learning', 'Développement des concepts clés de Machine Learning.', 10, '2025-05-11 00:35:01', NULL, NULL, NULL),
(61, 'Théorie de Management général', 'Développement des concepts clés de Management général.', 11, '2025-05-11 00:35:01', NULL, NULL, NULL),
(62, 'Théorie de Stratégie d’entreprise', 'Développement des concepts clés de Stratégie d’entreprise.', 12, '2025-05-11 00:35:01', NULL, NULL, NULL),
(63, 'Théorie de Fiscalité', 'Développement des concepts clés de Fiscalité.', 13, '2025-05-11 00:35:01', NULL, NULL, NULL),
(64, 'Théorie de Audit financier', 'Développement des concepts clés de Audit financier.', 14, '2025-05-11 00:35:01', NULL, NULL, NULL),
(65, 'Théorie de Droit civil', 'Développement des concepts clés de Droit civil.', 15, '2025-05-11 00:35:01', NULL, NULL, NULL),
(66, 'Théorie de Droit pénal', 'Développement des concepts clés de Droit pénal.', 16, '2025-05-11 00:35:01', NULL, NULL, NULL),
(67, 'Théorie de Marketing stratégique', 'Développement des concepts clés de Marketing stratégique.', 17, '2025-05-11 00:35:01', NULL, NULL, NULL),
(68, 'Théorie de Marketing opérationnel', 'Développement des concepts clés de Marketing opérationnel.', 18, '2025-05-11 00:35:01', NULL, NULL, NULL),
(69, 'Théorie de Finance de marché', 'Développement des concepts clés de Finance de marché.', 19, '2025-05-11 00:35:01', NULL, NULL, NULL),
(70, 'Théorie de Gestion de portefeuille', 'Développement des concepts clés de Gestion de portefeuille.', 20, '2025-05-11 00:35:01', NULL, NULL, NULL),
(71, 'Théorie de Littérature française', 'Développement des concepts clés de Littérature française.', 21, '2025-05-11 00:35:01', NULL, NULL, NULL),
(72, 'Théorie de Littérature comparée', 'Développement des concepts clés de Littérature comparée.', 22, '2025-05-11 00:35:01', NULL, NULL, NULL),
(73, 'Théorie de Sociologie urbaine', 'Développement des concepts clés de Sociologie urbaine.', 23, '2025-05-11 00:35:01', NULL, NULL, NULL),
(74, 'Théorie de Sociologie du travail', 'Développement des concepts clés de Sociologie du travail.', 24, '2025-05-11 00:35:01', NULL, NULL, NULL),
(75, 'Théorie de Pédagogie', 'Développement des concepts clés de Pédagogie.', 25, '2025-05-11 00:35:01', NULL, NULL, NULL),
(76, 'Théorie de Psychologie de l’élève', 'Développement des concepts clés de Psychologie de l’élève.', 26, '2025-05-11 00:35:01', NULL, NULL, NULL),
(77, 'Théorie de Métaphysique', 'Développement des concepts clés de Métaphysique.', 27, '2025-05-11 00:35:01', NULL, NULL, NULL),
(78, 'Théorie de Logique', 'Développement des concepts clés de Logique.', 28, '2025-05-11 00:35:01', NULL, NULL, NULL),
(79, 'Théorie de Psychologie cognitive', 'Développement des concepts clés de Psychologie cognitive.', 29, '2025-05-11 00:35:01', NULL, NULL, NULL),
(80, 'Théorie de Psychologie clinique', 'Développement des concepts clés de Psychologie clinique.', 30, '2025-05-11 00:35:01', NULL, NULL, NULL),
(81, 'Théorie de Biochimie', 'Développement des concepts clés de Biochimie.', 31, '2025-05-11 00:35:01', NULL, NULL, NULL),
(82, 'Théorie de Génétique', 'Développement des concepts clés de Génétique.', 32, '2025-05-11 00:35:01', NULL, NULL, NULL),
(83, 'Théorie de Agroécologie', 'Développement des concepts clés de Agroécologie.', 33, '2025-05-11 00:35:01', NULL, NULL, NULL),
(84, 'Théorie de Sciences du sol', 'Développement des concepts clés de Sciences du sol.', 34, '2025-05-11 00:35:01', NULL, NULL, NULL),
(85, 'Théorie de Écologie', 'Développement des concepts clés de Écologie.', 35, '2025-05-11 00:35:01', NULL, NULL, NULL),
(86, 'Théorie de Gestion de l’eau', 'Développement des concepts clés de Gestion de l’eau.', 36, '2025-05-11 00:35:01', NULL, NULL, NULL),
(87, 'Théorie de Chimie organique', 'Développement des concepts clés de Chimie organique.', 37, '2025-05-11 00:35:01', NULL, NULL, NULL),
(88, 'Théorie de Chimie inorganique', 'Développement des concepts clés de Chimie inorganique.', 38, '2025-05-11 00:35:01', NULL, NULL, NULL),
(89, 'Théorie de Mécanique', 'Développement des concepts clés de Mécanique.', 39, '2025-05-11 00:35:01', NULL, NULL, NULL),
(90, 'Théorie de Électromagnétisme', 'Développement des concepts clés de Électromagnétisme.', 40, '2025-05-11 00:35:01', NULL, NULL, NULL),
(91, 'Théorie de Anatomie', 'Développement des concepts clés de Anatomie.', 41, '2025-05-11 00:35:01', NULL, NULL, NULL),
(92, 'Théorie de Physiologie', 'Développement des concepts clés de Physiologie.', 42, '2025-05-11 00:35:01', NULL, NULL, NULL),
(93, 'Théorie de Pharmacologie', 'Développement des concepts clés de Pharmacologie.', 43, '2025-05-11 00:35:01', NULL, NULL, NULL),
(94, 'Théorie de Chimie pharmaceutique', 'Développement des concepts clés de Chimie pharmaceutique.', 44, '2025-05-11 00:35:01', NULL, NULL, NULL),
(95, 'Théorie de Nutrition clinique', 'Développement des concepts clés de Nutrition clinique.', 45, '2025-05-11 00:35:01', NULL, NULL, NULL),
(96, 'Théorie de Diététique appliquée', 'Développement des concepts clés de Diététique appliquée.', 46, '2025-05-11 00:35:01', NULL, NULL, NULL),
(97, 'Théorie de Physiologie de l’exercice', 'Développement des concepts clés de Physiologie de l’exercice.', 47, '2025-05-11 00:35:01', NULL, NULL, NULL),
(98, 'Théorie de Biomécanique', 'Développement des concepts clés de Biomécanique.', 48, '2025-05-11 00:35:01', NULL, NULL, NULL),
(99, 'Théorie de Soins d’urgence', 'Développement des concepts clés de Soins d’urgence.', 49, '2025-05-11 00:35:01', NULL, NULL, NULL),
(100, 'Théorie de Gériatrie', 'Développement des concepts clés de Gériatrie.', 50, '2025-05-11 00:35:01', NULL, NULL, NULL),
(101, 'Exercices sur Algorithmique', 'Entraînez-vous avec des exercices pratiques sur Algorithmique.', 1, '2025-05-11 00:35:01', NULL, NULL, NULL),
(102, 'Exercices sur Structures de données', 'Entraînez-vous avec des exercices pratiques sur Structures de données.', 2, '2025-05-11 00:35:01', NULL, NULL, NULL),
(103, 'Exercices sur Réseaux locaux', 'Entraînez-vous avec des exercices pratiques sur Réseaux locaux.', 3, '2025-05-11 00:35:01', NULL, NULL, NULL),
(104, 'Exercices sur Réseaux étendus', 'Entraînez-vous avec des exercices pratiques sur Réseaux étendus.', 4, '2025-05-11 00:35:01', NULL, NULL, NULL),
(105, 'Exercices sur Cryptographie', 'Entraînez-vous avec des exercices pratiques sur Cryptographie.', 5, '2025-05-11 00:35:01', NULL, NULL, NULL),
(106, 'Exercices sur Tests d’intrusion', 'Entraînez-vous avec des exercices pratiques sur Tests d’intrusion.', 6, '2025-05-11 00:35:01', NULL, NULL, NULL),
(107, 'Exercices sur HTML & CSS', 'Entraînez-vous avec des exercices pratiques sur HTML & CSS.', 7, '2025-05-11 00:35:01', NULL, NULL, NULL),
(108, 'Exercices sur JavaScript', 'Entraînez-vous avec des exercices pratiques sur JavaScript.', 8, '2025-05-11 00:35:01', NULL, NULL, NULL),
(109, 'Exercices sur Statistiques', 'Entraînez-vous avec des exercices pratiques sur Statistiques.', 9, '2025-05-11 00:35:01', NULL, NULL, NULL),
(110, 'Exercices sur Machine Learning', 'Entraînez-vous avec des exercices pratiques sur Machine Learning.', 10, '2025-05-11 00:35:01', NULL, NULL, NULL),
(111, 'Exercices sur Management général', 'Entraînez-vous avec des exercices pratiques sur Management général.', 11, '2025-05-11 00:35:01', NULL, NULL, NULL),
(112, 'Exercices sur Stratégie d’entreprise', 'Entraînez-vous avec des exercices pratiques sur Stratégie d’entreprise.', 12, '2025-05-11 00:35:01', NULL, NULL, NULL),
(113, 'Exercices sur Fiscalité', 'Entraînez-vous avec des exercices pratiques sur Fiscalité.', 13, '2025-05-11 00:35:01', NULL, NULL, NULL),
(114, 'Exercices sur Audit financier', 'Entraînez-vous avec des exercices pratiques sur Audit financier.', 14, '2025-05-11 00:35:01', NULL, NULL, NULL),
(115, 'Exercices sur Droit civil', 'Entraînez-vous avec des exercices pratiques sur Droit civil.', 15, '2025-05-11 00:35:01', NULL, NULL, NULL),
(116, 'Exercices sur Droit pénal', 'Entraînez-vous avec des exercices pratiques sur Droit pénal.', 16, '2025-05-11 00:35:01', NULL, NULL, NULL),
(117, 'Exercices sur Marketing stratégique', 'Entraînez-vous avec des exercices pratiques sur Marketing stratégique.', 17, '2025-05-11 00:35:01', NULL, NULL, NULL),
(118, 'Exercices sur Marketing opérationnel', 'Entraînez-vous avec des exercices pratiques sur Marketing opérationnel.', 18, '2025-05-11 00:35:01', NULL, NULL, NULL),
(119, 'Exercices sur Finance de marché', 'Entraînez-vous avec des exercices pratiques sur Finance de marché.', 19, '2025-05-11 00:35:01', NULL, NULL, NULL),
(120, 'Exercices sur Gestion de portefeuille', 'Entraînez-vous avec des exercices pratiques sur Gestion de portefeuille.', 20, '2025-05-11 00:35:01', NULL, NULL, NULL),
(121, 'Exercices sur Littérature française', 'Entraînez-vous avec des exercices pratiques sur Littérature française.', 21, '2025-05-11 00:35:01', NULL, NULL, NULL),
(122, 'Exercices sur Littérature comparée', 'Entraînez-vous avec des exercices pratiques sur Littérature comparée.', 22, '2025-05-11 00:35:01', NULL, NULL, NULL),
(123, 'Exercices sur Sociologie urbaine', 'Entraînez-vous avec des exercices pratiques sur Sociologie urbaine.', 23, '2025-05-11 00:35:01', NULL, NULL, NULL),
(124, 'Exercices sur Sociologie du travail', 'Entraînez-vous avec des exercices pratiques sur Sociologie du travail.', 24, '2025-05-11 00:35:01', NULL, NULL, NULL),
(125, 'Exercices sur Pédagogie', 'Entraînez-vous avec des exercices pratiques sur Pédagogie.', 25, '2025-05-11 00:35:01', NULL, NULL, NULL),
(126, 'Exercices sur Psychologie de l’élève', 'Entraînez-vous avec des exercices pratiques sur Psychologie de l’élève.', 26, '2025-05-11 00:35:01', NULL, NULL, NULL),
(127, 'Exercices sur Métaphysique', 'Entraînez-vous avec des exercices pratiques sur Métaphysique.', 27, '2025-05-11 00:35:01', NULL, NULL, NULL),
(128, 'Exercices sur Logique', 'Entraînez-vous avec des exercices pratiques sur Logique.', 28, '2025-05-11 00:35:01', NULL, NULL, NULL),
(129, 'Exercices sur Psychologie cognitive', 'Entraînez-vous avec des exercices pratiques sur Psychologie cognitive.', 29, '2025-05-11 00:35:01', NULL, NULL, NULL),
(130, 'Exercices sur Psychologie clinique', 'Entraînez-vous avec des exercices pratiques sur Psychologie clinique.', 30, '2025-05-11 00:35:01', NULL, NULL, NULL),
(131, 'Exercices sur Biochimie', 'Entraînez-vous avec des exercices pratiques sur Biochimie.', 31, '2025-05-11 00:35:01', NULL, NULL, NULL),
(132, 'Exercices sur Génétique', 'Entraînez-vous avec des exercices pratiques sur Génétique.', 32, '2025-05-11 00:35:01', NULL, NULL, NULL),
(133, 'Exercices sur Agroécologie', 'Entraînez-vous avec des exercices pratiques sur Agroécologie.', 33, '2025-05-11 00:35:01', NULL, NULL, NULL),
(134, 'Exercices sur Sciences du sol', 'Entraînez-vous avec des exercices pratiques sur Sciences du sol.', 34, '2025-05-11 00:35:01', NULL, NULL, NULL),
(135, 'Exercices sur Écologie', 'Entraînez-vous avec des exercices pratiques sur Écologie.', 35, '2025-05-11 00:35:01', NULL, NULL, NULL),
(136, 'Exercices sur Gestion de l’eau', 'Entraînez-vous avec des exercices pratiques sur Gestion de l’eau.', 36, '2025-05-11 00:35:01', NULL, NULL, NULL),
(137, 'Exercices sur Chimie organique', 'Entraînez-vous avec des exercices pratiques sur Chimie organique.', 37, '2025-05-11 00:35:01', NULL, NULL, NULL),
(138, 'Exercices sur Chimie inorganique', 'Entraînez-vous avec des exercices pratiques sur Chimie inorganique.', 38, '2025-05-11 00:35:01', NULL, NULL, NULL),
(139, 'Exercices sur Mécanique', 'Entraînez-vous avec des exercices pratiques sur Mécanique.', 39, '2025-05-11 00:35:01', NULL, NULL, NULL),
(140, 'Exercices sur Électromagnétisme', 'Entraînez-vous avec des exercices pratiques sur Électromagnétisme.', 40, '2025-05-11 00:35:01', NULL, NULL, NULL),
(141, 'Exercices sur Anatomie', 'Entraînez-vous avec des exercices pratiques sur Anatomie.', 41, '2025-05-11 00:35:01', NULL, NULL, NULL),
(142, 'Exercices sur Physiologie', 'Entraînez-vous avec des exercices pratiques sur Physiologie.', 42, '2025-05-11 00:35:01', NULL, NULL, NULL),
(143, 'Exercices sur Pharmacologie', 'Entraînez-vous avec des exercices pratiques sur Pharmacologie.', 43, '2025-05-11 00:35:01', NULL, NULL, NULL),
(144, 'Exercices sur Chimie pharmaceutique', 'Entraînez-vous avec des exercices pratiques sur Chimie pharmaceutique.', 44, '2025-05-11 00:35:01', NULL, NULL, NULL),
(145, 'Exercices sur Nutrition clinique', 'Entraînez-vous avec des exercices pratiques sur Nutrition clinique.', 45, '2025-05-11 00:35:01', NULL, NULL, NULL),
(146, 'Exercices sur Diététique appliquée', 'Entraînez-vous avec des exercices pratiques sur Diététique appliquée.', 46, '2025-05-11 00:35:01', NULL, NULL, NULL),
(147, 'Exercices sur Physiologie de l’exercice', 'Entraînez-vous avec des exercices pratiques sur Physiologie de l’exercice.', 47, '2025-05-11 00:35:01', NULL, NULL, NULL),
(148, 'Exercices sur Biomécanique', 'Entraînez-vous avec des exercices pratiques sur Biomécanique.', 48, '2025-05-11 00:35:01', NULL, NULL, NULL),
(149, 'Exercices sur Soins d’urgence', 'Entraînez-vous avec des exercices pratiques sur Soins d’urgence.', 49, '2025-05-11 00:35:01', NULL, NULL, NULL),
(150, 'Exercices sur Gériatrie', 'Entraînez-vous avec des exercices pratiques sur Gériatrie.', 50, '2025-05-11 00:35:01', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `matieres`
--

CREATE TABLE `matieres` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `filiere_id` int(10) UNSIGNED NOT NULL,
  `estDisponible` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = disponible, 0 = non disponible',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(10) UNSIGNED NOT NULL COMMENT 'ID de l''utilisateur créateur',
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(10) UNSIGNED DEFAULT NULL COMMENT 'ID de l''utilisateur ayant modifié pour la dernière fois'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `matieres`
--

INSERT INTO `matieres` (`id`, `code`, `nom`, `description`, `filiere_id`, `estDisponible`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'ALGO', 'Algorithmique', 'Étude des algorithmes et de leur complexité', 1, 1, '2025-05-11 00:26:11', 1, NULL, NULL),
(2, 'STRUCT', 'Structures de données', 'Listes, piles, files, arbres, graphes', 1, 1, '2025-05-11 00:26:11', 1, NULL, NULL),
(3, 'LAN', 'Réseaux locaux', 'Topologies, commutation et câblage', 2, 1, '2025-05-11 00:26:11', 2, NULL, NULL),
(4, 'WAN', 'Réseaux étendus', 'Architecture, protocoles et optimisation WAN', 2, 1, '2025-05-11 00:26:11', 2, NULL, NULL),
(5, 'CRYPTO', 'Cryptographie', 'Chiffrement symétrique et asymétrique', 3, 1, '2025-05-11 00:26:11', 1, NULL, NULL),
(6, 'PEN_TEST', 'Tests d’intrusion', 'Méthodologies, outils et rapports de pentest', 3, 1, '2025-05-11 00:26:11', 1, NULL, NULL),
(7, 'HTMLCSS', 'HTML & CSS', 'Bases du web statique et responsive design', 4, 1, '2025-05-11 00:26:11', 2, NULL, NULL),
(8, 'JS', 'JavaScript', 'Langage client, DOM et ES6+', 4, 1, '2025-05-11 00:26:11', 2, NULL, NULL),
(9, 'STAT', 'Statistiques', 'Probabilités, distributions et tests d’hypothèse', 5, 1, '2025-05-11 00:26:11', 1, NULL, NULL),
(10, 'ML', 'Machine Learning', 'Algorithmes supervisés et non supervisés', 5, 1, '2025-05-11 00:26:11', 1, NULL, NULL),
(11, 'MGNT', 'Management général', 'Principes et pratiques managériales', 6, 1, '2025-05-11 00:26:11', 3, NULL, NULL),
(12, 'STRAT', 'Stratégie d’entreprise', 'Analyse SWOT et choix stratégiques', 6, 1, '2025-05-11 00:26:11', 3, NULL, NULL),
(13, 'FISC', 'Fiscalité', 'Imposition des sociétés et des particuliers', 7, 1, '2025-05-11 00:26:11', 2, NULL, NULL),
(14, 'AUDIT', 'Audit financier', 'Méthodologies et normes d’audit', 7, 1, '2025-05-11 00:26:11', 2, NULL, NULL),
(15, 'D_CIVIL', 'Droit civil', 'Contrats, responsabilité civile, successions', 8, 1, '2025-05-11 00:26:11', 1, NULL, NULL),
(16, 'D_PENAL', 'Droit pénal', 'Infractions, sanctions et procédures', 8, 1, '2025-05-11 00:26:11', 1, NULL, NULL),
(17, 'MKT_STRAT', 'Marketing stratégique', 'Segmentation, ciblage et positionnement', 9, 1, '2025-05-11 00:26:11', 3, NULL, NULL),
(18, 'MKT_OP', 'Marketing opérationnel', 'Campagnes, canaux et ROI', 9, 1, '2025-05-11 00:26:11', 3, NULL, NULL),
(19, 'FIN_MKT', 'Finance de marché', 'Marchés financiers et instruments dérivés', 10, 1, '2025-05-11 00:26:11', 2, NULL, NULL),
(20, 'GEST_PF', 'Gestion de portefeuille', 'Théories modernes et allocation d’actifs', 10, 1, '2025-05-11 00:26:11', 2, NULL, NULL),
(21, 'LIT_FR', 'Littérature française', 'Du Moyen Âge au XXᵉ siècle', 11, 1, '2025-05-11 00:26:11', 2, NULL, NULL),
(22, 'LIT_COMP', 'Littérature comparée', 'Études croisées de littératures', 11, 1, '2025-05-11 00:26:11', 2, NULL, NULL),
(23, 'SOC_URBAINE', 'Sociologie urbaine', 'Étude des dynamiques sociales en milieu urbain', 12, 1, '2025-05-11 00:26:11', 1, NULL, NULL),
(24, 'SOC_TRAVAIL', 'Sociologie du travail', 'Organisation et transformations des métiers', 12, 1, '2025-05-11 00:26:11', 1, NULL, NULL),
(25, 'PEDA', 'Pédagogie', 'Méthodes et outils d’enseignement', 13, 1, '2025-05-11 00:26:11', 3, NULL, NULL),
(26, 'PSY_ELEVE', 'Psychologie de l’élève', 'Développement cognitif et motivation', 13, 1, '2025-05-11 00:26:11', 3, NULL, NULL),
(27, 'METAPH', 'Métaphysique', 'Nature de la réalité et ontologie', 14, 1, '2025-05-11 00:26:11', 1, NULL, NULL),
(28, 'LOGIQ', 'Logique', 'Raisonnement formel et structures argumentatives', 14, 1, '2025-05-11 00:26:11', 1, NULL, NULL),
(29, 'PSY_COG', 'Psychologie cognitive', 'Processus mentaux et perception', 15, 1, '2025-05-11 00:26:11', 2, NULL, NULL),
(30, 'PSY_CLIN', 'Psychologie clinique', 'Diagnostic et prise en charge des troubles', 15, 1, '2025-05-11 00:26:11', 2, NULL, NULL),
(31, 'BIOCHIM', 'Biochimie', 'Réactions et métabolismes moléculaires', 16, 1, '2025-05-11 00:26:11', 1, NULL, NULL),
(32, 'GENET', 'Génétique', 'Hérédité, mutations et génie génétique', 16, 1, '2025-05-11 00:26:11', 1, NULL, NULL),
(33, 'AGROECO', 'Agroécologie', 'Systèmes agricoles durables', 17, 1, '2025-05-11 00:26:11', 3, NULL, NULL),
(34, 'SCI_SOL', 'Sciences du sol', 'Composition, fertilité et conservation', 17, 1, '2025-05-11 00:26:11', 3, NULL, NULL),
(35, 'ECOLOG', 'Écologie', 'Interactions entre organismes et milieu', 18, 1, '2025-05-11 00:26:11', 2, NULL, NULL),
(36, 'GEST_EAU', 'Gestion de l’eau', 'Ressources, traitement et distribution', 18, 1, '2025-05-11 00:26:11', 2, NULL, NULL),
(37, 'CHIM_ORG', 'Chimie organique', 'Composés carbonés et réactions', 19, 1, '2025-05-11 00:26:11', 1, NULL, NULL),
(38, 'CHIM_INORG', 'Chimie inorganique', 'Métaux, minéraux et catalyse', 19, 1, '2025-05-11 00:26:11', 1, NULL, NULL),
(39, 'MECANIQ', 'Mécanique', 'Cinématique, dynamique et statique', 20, 1, '2025-05-11 00:26:11', 3, NULL, NULL),
(40, 'ELECTRO', 'Électromagnétisme', 'Champs électriques et magnétiques', 20, 1, '2025-05-11 00:26:11', 3, NULL, NULL),
(41, 'ANATOM', 'Anatomie', 'Structure du corps humain', 21, 1, '2025-05-11 00:26:11', 2, NULL, NULL),
(42, 'PHYSIOL', 'Physiologie', 'Fonctionnement des organes et systèmes', 21, 1, '2025-05-11 00:26:11', 2, NULL, NULL),
(43, 'PHARMAC', 'Pharmacologie', 'Mécanismes d’action des médicaments', 22, 1, '2025-05-11 00:26:11', 1, NULL, NULL),
(44, 'CHIM_PHAR', 'Chimie pharmaceutique', 'Formulation et stabilité des médicaments', 22, 1, '2025-05-11 00:26:11', 1, NULL, NULL),
(45, 'NUT_CLIN', 'Nutrition clinique', 'Besoins nutritionnels et pathologies', 23, 1, '2025-05-11 00:26:11', 3, NULL, NULL),
(46, 'DIET_APPL', 'Diététique appliquée', 'Régimes et conseils diététiques', 23, 1, '2025-05-11 00:26:11', 3, NULL, NULL),
(47, 'PHYSIO_EX', 'Physiologie de l’exercice', 'Adaptations physiologiques à l’effort', 24, 1, '2025-05-11 00:26:11', 2, NULL, NULL),
(48, 'BIOMEC', 'Biomécanique', 'Analyse des mouvements et postures', 24, 1, '2025-05-11 00:26:11', 2, NULL, NULL),
(49, 'SOINS_UR', 'Soins d’urgence', 'Protocoles et prise en charge immédiate', 25, 1, '2025-05-11 00:26:11', 1, NULL, NULL),
(50, 'GERIAT', 'Gériatrie', 'Spécificités des soins aux personnes âgées', 25, 1, '2025-05-11 00:26:11', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `notes`
--

CREATE TABLE `notes` (
  `id` int(10) UNSIGNED NOT NULL,
  `etudiant_id` int(10) UNSIGNED NOT NULL,
  `matiere_id` int(10) UNSIGNED NOT NULL,
  `note` decimal(5,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `poles`
--

CREATE TABLE `poles` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(10) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `poles`
--

INSERT INTO `poles` (`id`, `code`, `nom`, `description`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'STN', 'Sciences et Technologies du Numérique', 'Pôle regroupant les formations en informatique, réseaux, télécommunications et technologies numériques.dfd', '2025-05-10 16:09:19', NULL, '2025-05-10 16:12:58', 1),
(2, 'LSHE', 'Lettres, Sciences Humaines et Économiques', 'Pôle dédié aux formations en lettres, langues, sciences humaines, sociales et économiques.', '2025-05-10 16:09:19', NULL, NULL, NULL),
(3, 'SEJA', 'Sciences Économiques, Juridiques et Administratives', 'Pôle spécialisé dans les formations en droit, économie, gestion et administration des entreprises.', '2025-05-10 16:09:19', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `nom` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `nom`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'admin', '2025-05-04 17:28:08', NULL, NULL, NULL),
(2, 'etudiant', '2025-05-04 17:29:08', NULL, NULL, NULL),
(3, 'formateur', '2025-05-12 21:44:19', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `zones`
--

CREATE TABLE `zones` (
  `id` int(10) UNSIGNED NOT NULL,
  `nom` varchar(100) NOT NULL,
  `estDisponible` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = disponible, 0 = non disponible',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(10) UNSIGNED NOT NULL COMMENT 'ID de l’utilisateur créateur',
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(10) UNSIGNED DEFAULT NULL COMMENT 'ID de l’utilisateur ayant modifié pour la dernière fois'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `zones`
--

INSERT INTO `zones` (`id`, `nom`, `estDisponible`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Zone A', 1, '2025-01-10 09:30:00', 1, '2025-05-10 14:20:00', 1),
(2, 'Zone B', 1, '2025-02-15 14:20:00', 1, '2025-05-10 14:14:57', 1),
(3, 'Zone C', 1, '2025-03-20 11:10:00', 1, '2025-05-10 14:14:57', 1),
(4, 'Zone D', 1, '2025-04-05 16:00:00', 1, '2025-04-10 10:05:00', 1),
(5, 'Zone E', 1, '2025-05-01 12:00:00', 1, '2025-05-10 14:14:43', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ux_admins_email` (`email`);

--
-- Index pour la table `enos`
--
ALTER TABLE `enos`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `INE` (`INE`),
  ADD UNIQUE KEY `ux_etudiants_email` (`email`),
  ADD KEY `idx_etudiants_pole` (`pole_id`),
  ADD KEY `idx_etudiants_filiere` (`filiere_id`),
  ADD KEY `idx_etudiants_zone` (`zone_id`),
  ADD KEY `idx_etudiants_eno` (`eno_id`);

--
-- Index pour la table `filieres`
--
ALTER TABLE `filieres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `pole_id` (`pole_id`);

--
-- Index pour la table `lecons`
--
ALTER TABLE `lecons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_lecons_matiere` (`matiere_id`);

--
-- Index pour la table `matieres`
--
ALTER TABLE `matieres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ux_matieres_code` (`code`),
  ADD KEY `idx_matieres_filiere` (`filiere_id`);

--
-- Index pour la table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ux_note_unique` (`etudiant_id`,`matiere_id`),
  ADD KEY `idx_notes_etudiant` (`etudiant_id`),
  ADD KEY `idx_notes_matiere` (`matiere_id`);

--
-- Index pour la table `poles`
--
ALTER TABLE `poles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `zones`
--
ALTER TABLE `zones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `enos`
--
ALTER TABLE `enos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `etudiants`
--
ALTER TABLE `etudiants`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `filieres`
--
ALTER TABLE `filieres`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `lecons`
--
ALTER TABLE `lecons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT pour la table `matieres`
--
ALTER TABLE `matieres`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT pour la table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `poles`
--
ALTER TABLE `poles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `zones`
--
ALTER TABLE `zones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD CONSTRAINT `etudiants_eno_fk` FOREIGN KEY (`eno_id`) REFERENCES `enos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `etudiants_filiere_fk` FOREIGN KEY (`filiere_id`) REFERENCES `filieres` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `etudiants_pole_fk` FOREIGN KEY (`pole_id`) REFERENCES `poles` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `etudiants_zone_fk` FOREIGN KEY (`zone_id`) REFERENCES `zones` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `lecons`
--
ALTER TABLE `lecons`
  ADD CONSTRAINT `lecons_matiere_fk` FOREIGN KEY (`matiere_id`) REFERENCES `matieres` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `matieres`
--
ALTER TABLE `matieres`
  ADD CONSTRAINT `matieres_filiere_fk` FOREIGN KEY (`filiere_id`) REFERENCES `filieres` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_etudiant_fk` FOREIGN KEY (`etudiant_id`) REFERENCES `etudiants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notes_matiere_fk` FOREIGN KEY (`matiere_id`) REFERENCES `matieres` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
