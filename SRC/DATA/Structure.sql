-- phpMyAdmin SQL Dump
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

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

CREATE TABLE `SUN` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `explanation` text DEFAULT NULL,
  `hdurl` varchar(255) DEFAULT NULL,
  `media_type` varchar(50) DEFAULT NULL,
  `service_version` varchar(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `copyright` varchar(255) DEFAULT NULL,
  `planete_nom` varchar(20) DEFAULT 'Sun'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `MOON` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `explanation` text DEFAULT NULL,
  `hdurl` varchar(255) DEFAULT NULL,
  `media_type` varchar(50) DEFAULT NULL,
  `service_version` varchar(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `copyright` varchar(255) DEFAULT NULL,
  `planete_nom` varchar(20) DEFAULT 'Moon'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `EARTH`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `JUPITER`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `MARS`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `MERCURY`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `NEPTUNE`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `SATURN`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `URANUS`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `VENUS`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `SUN`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `MOON`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `EARTH`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `JUPITER`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `MARS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `MERCURY`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `NEPTUNE`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `SATURN`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `URANUS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `VENUS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `SUN`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `MOON`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
