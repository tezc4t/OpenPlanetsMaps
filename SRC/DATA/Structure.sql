-- phpMyAdmin SQL Dump
-- version 5.2.3-1.fc43
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 11 mai 2026 à 09:14
-- Version du serveur : 10.11.16-MariaDB
-- Version de PHP : 8.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `OpenPlanetsMaps`
--

-- --------------------------------------------------------

--
-- Structure de la table `EARTH`
--

CREATE TABLE `EARTH` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `explanation` text DEFAULT NULL,
  `hdurl` varchar(255) DEFAULT NULL,
  `media_type` varchar(50) DEFAULT NULL,
  `service_version` varchar(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `copyright` varchar(255) DEFAULT NULL,
  `planete_nom` varchar(20) DEFAULT 'Earth'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `JUPITER`
--

CREATE TABLE `JUPITER` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `explanation` text DEFAULT NULL,
  `hdurl` varchar(255) DEFAULT NULL,
  `media_type` varchar(50) DEFAULT NULL,
  `service_version` varchar(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `copyright` varchar(255) DEFAULT NULL,
  `planete_nom` varchar(20) DEFAULT 'Jupiter'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `MARS`
--

CREATE TABLE `MARS` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `explanation` text DEFAULT NULL,
  `hdurl` varchar(255) DEFAULT NULL,
  `media_type` varchar(50) DEFAULT NULL,
  `service_version` varchar(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `copyright` varchar(255) DEFAULT NULL,
  `planete_nom` varchar(20) DEFAULT 'Mars'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `MERCURY`
--

CREATE TABLE `MERCURY` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `explanation` text DEFAULT NULL,
  `hdurl` varchar(255) DEFAULT NULL,
  `media_type` varchar(50) DEFAULT NULL,
  `service_version` varchar(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `copyright` varchar(255) DEFAULT NULL,
  `planete_nom` varchar(20) DEFAULT 'Mercury'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `MOON`
--

CREATE TABLE `MOON` (
  `date` date NOT NULL,
  `explanation` text NOT NULL,
  `hdurl` varchar(255) DEFAULT NULL,
  `media_type` varchar(50) DEFAULT NULL,
  `service_version` varchar(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `copyright` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `NEPTUNE`
--

CREATE TABLE `NEPTUNE` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `explanation` text DEFAULT NULL,
  `hdurl` varchar(255) DEFAULT NULL,
  `media_type` varchar(50) DEFAULT NULL,
  `service_version` varchar(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `copyright` varchar(255) DEFAULT NULL,
  `planete_nom` varchar(20) DEFAULT 'Neptune'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `SATURN`
--

CREATE TABLE `SATURN` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `explanation` text DEFAULT NULL,
  `hdurl` varchar(255) DEFAULT NULL,
  `media_type` varchar(50) DEFAULT NULL,
  `service_version` varchar(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `copyright` varchar(255) DEFAULT NULL,
  `planete_nom` varchar(20) DEFAULT 'Saturn'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `SUN`
--

CREATE TABLE `SUN` (
  `date` date NOT NULL,
  `explanation` text NOT NULL,
  `hdurl` varchar(255) DEFAULT NULL,
  `media_type` varchar(50) DEFAULT NULL,
  `service_version` varchar(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `copyright` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `URANUS`
--

CREATE TABLE `URANUS` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `explanation` text DEFAULT NULL,
  `hdurl` varchar(255) DEFAULT NULL,
  `media_type` varchar(50) DEFAULT NULL,
  `service_version` varchar(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `copyright` varchar(255) DEFAULT NULL,
  `planete_nom` varchar(20) DEFAULT 'Uranus'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `VENUS`
--

CREATE TABLE `VENUS` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `explanation` text DEFAULT NULL,
  `hdurl` varchar(255) DEFAULT NULL,
  `media_type` varchar(50) DEFAULT NULL,
  `service_version` varchar(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `copyright` varchar(255) DEFAULT NULL,
  `planete_nom` varchar(20) DEFAULT 'Venus'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `EARTH`
--
ALTER TABLE `EARTH`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `JUPITER`
--
ALTER TABLE `JUPITER`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `MARS`
--
ALTER TABLE `MARS`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `MERCURY`
--
ALTER TABLE `MERCURY`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `MOON`
--
ALTER TABLE `MOON`
  ADD PRIMARY KEY (`date`),
  ADD KEY `title` (`title`);

--
-- Index pour la table `NEPTUNE`
--
ALTER TABLE `NEPTUNE`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `SATURN`
--
ALTER TABLE `SATURN`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `SUN`
--
ALTER TABLE `SUN`
  ADD PRIMARY KEY (`date`),
  ADD KEY `title` (`title`);

--
-- Index pour la table `URANUS`
--
ALTER TABLE `URANUS`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `VENUS`
--
ALTER TABLE `VENUS`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `EARTH`
--
ALTER TABLE `EARTH`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `JUPITER`
--
ALTER TABLE `JUPITER`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `MARS`
--
ALTER TABLE `MARS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `MERCURY`
--
ALTER TABLE `MERCURY`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `NEPTUNE`
--
ALTER TABLE `NEPTUNE`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `SATURN`
--
ALTER TABLE `SATURN`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `URANUS`
--
ALTER TABLE `URANUS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `VENUS`
--
ALTER TABLE `VENUS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
