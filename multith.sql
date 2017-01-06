-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 06 Janvier 2017 à 03:01
-- Version du serveur :  10.1.16-MariaDB
-- Version de PHP :  7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `multith`
--

-- --------------------------------------------------------

--
-- Structure de la table `multith_projects`
--

CREATE TABLE `multith_projects` (
  `row` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `default_theme` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `multith_themes`
--

CREATE TABLE `multith_themes` (
  `row` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `theme` text NOT NULL,
  `project` text NOT NULL,
  `stylesheets` text NOT NULL,
  `scripts` text NOT NULL,
  `enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `multith_tokens`
--

CREATE TABLE `multith_tokens` (
  `row` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `token` text NOT NULL,
  `project` text NOT NULL,
  `theme` text NOT NULL,
  `enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `multith_projects`
--
ALTER TABLE `multith_projects`
  ADD PRIMARY KEY (`row`);

--
-- Index pour la table `multith_themes`
--
ALTER TABLE `multith_themes`
  ADD PRIMARY KEY (`row`);

--
-- Index pour la table `multith_tokens`
--
ALTER TABLE `multith_tokens`
  ADD PRIMARY KEY (`row`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `multith_projects`
--
ALTER TABLE `multith_projects`
  MODIFY `row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `multith_themes`
--
ALTER TABLE `multith_themes`
  MODIFY `row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `multith_tokens`
--
ALTER TABLE `multith_tokens`
  MODIFY `row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
