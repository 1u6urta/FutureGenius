-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 29 mai 2023 à 20:40
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `databasejob`
--

-- --------------------------------------------------------

--
-- Structure de la table `abonnement`
--

CREATE TABLE `abonnement` (
  `idAbonnement` int(11) NOT NULL,
  `prixAbonnement` int(11) NOT NULL,
  `dateDebutAbonnement` date NOT NULL,
  `disAbonnement` text NOT NULL,
  `idProfile` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `employeur`
--

CREATE TABLE `employeur` (
  `idCandidat` int(11) NOT NULL,
  `nomCandidat` varchar(127) NOT NULL,
  `prenomCandidat` varchar(127) NOT NULL,
  `emailCandidat` varchar(255) NOT NULL,
  `verifieEmail` tinyint(1) NOT NULL,
  `mdpCandidat` varchar(255) NOT NULL,
  `siteCandidat` varchar(255) NOT NULL,
  `dateNaissanceCandidat` date NOT NULL,
  `numPays` varchar(7) NOT NULL,
  `numCandidat` varchar(15) NOT NULL,
  `verifieNum` tinyint(1) NOT NULL,
  `addressCandidat` varchar(255) NOT NULL,
  `paysCandidat` varchar(255) NOT NULL,
  `villeCandidat` varchar(255) NOT NULL,
  `biographie` text NOT NULL,
  `proffession` varchar(127) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `employeur`
--

INSERT INTO `employeur` (`idCandidat`, `nomCandidat`, `prenomCandidat`, `emailCandidat`, `verifieEmail`, `mdpCandidat`, `siteCandidat`, `dateNaissanceCandidat`, `numPays`, `numCandidat`, `verifieNum`, `addressCandidat`, `paysCandidat`, `villeCandidat`, `biographie`, `proffession`) VALUES
(1, 'HAMMOUR', 'Jugurta', 'Jugurta0001@gmail.com', 1, 'd7a6832686189e0b7a14eb2053d2f8ff', 'https//:', '2002-09-14', '', '0791770731', 1, 'El-inser Draa El Mizan Tizi-ouzou', '', '', '                                                                       Je suis un développeur Back-End passionné avec une solide expérience dans la création d\'applications web robustes et performantes. Ma principale expertise réside dans la conception et le développement de l\'architecture serveur, la gestion des bases de données et la création d\'API. Je possède une solide expérience dans des langages de programmation tels que PHP, Java et Python, ainsi que dans l\'utilisation de frameworks populaires tels que Laravel, Spring et Django.Mon approche de développement se concentre sur la création de solutions techniques efficaces qui répondent aux besoins fonctionnels et aux exigences de performance. J\'ai une solide compréhension des concepts clés tels que la sécurité des données, l\'optimisation des requêtes, la gestion de cache et la mise à l\'échelle horizontale. Je suis à l\'aise avec les bases de données relationnelles telles que MySQL et PostgreSQL, ainsi qu\'avec les bases de données NoSQL comme MongoDB.En tant que développeur Back-End, je suis passionné par l\'optimisation des performances, la résolution de problèmes techniques complexes et la collaboration avec les membres de l\'équipe pour créer des applications web de haute qualité. Je suis constamment à l\'affût des dernières tendances et des meilleures pratiques en matière de développement Back-End, et j\'aime relever de nouveaux défis pour continuer à développer mes compétences.\nEn dehors du développement, j\'aime explorer de nouvelles technologies, participer à des projets open source et partager mes connaissances avec la communauté des développeurs. Je suis toujours prêt à apprendre de nouvelles choses et à m\\\'adapter rapidement à des environnements de travail dynamiques.\nSi vous cherchez un développeur Back-End expérimenté, passionné par la création d\'applications web performantes et évolutives, je serais ravi de discuter de vos besoins et de contribuer au succès de votre projet.                                         ', 'développeur Back-End '),
(3, 'luck', 'john', 'jugurta.hadjam@fgei.ummto.dz', 1, '04a70e6be530cc53d32dc476fbeb51f0', 'https://', '2002-09-14', '', '0791770731', 0, 'Tizi-ouzou', '', '', '                                                                                                                ', 'Designer');

-- --------------------------------------------------------

--
-- Structure de la table `entreprise`
--

CREATE TABLE `entreprise` (
  `idEntreprise` int(11) NOT NULL,
  `nomEntreprise` varchar(255) NOT NULL,
  `siteEntreprise` varchar(255) NOT NULL,
  `emailEntreprise` varchar(255) NOT NULL,
  `verifieEmail` tinyint(1) NOT NULL,
  `mdpEntreprise` varchar(255) NOT NULL,
  `dateCEntreprise` date NOT NULL,
  `paysNumEntreprise` varchar(255) NOT NULL,
  `numEntreprise` varchar(255) NOT NULL,
  `verifieNum` tinyint(1) NOT NULL,
  `addressEntreprise` varchar(255) NOT NULL,
  `paysEntreprise` varchar(255) NOT NULL,
  `villeEntreprise` varchar(255) NOT NULL,
  `codeZipEntreprise` int(11) NOT NULL,
  `etatEntreprise` varchar(255) NOT NULL,
  `coordonneLocEntreprise` varchar(255) NOT NULL,
  `bioEntreprise` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `entreprise`
--

INSERT INTO `entreprise` (`idEntreprise`, `nomEntreprise`, `siteEntreprise`, `emailEntreprise`, `verifieEmail`, `mdpEntreprise`, `dateCEntreprise`, `paysNumEntreprise`, `numEntreprise`, `verifieNum`, `addressEntreprise`, `paysEntreprise`, `villeEntreprise`, `codeZipEntreprise`, `etatEntreprise`, `coordonneLocEntreprise`, `bioEntreprise`) VALUES
(1, 'ABC Company', 'www.abccompany.com', 'jugurtaxxhadjam@gmail.com', 0, 'b24331b1a138cde62aa1f679164fc62f', '2020-01-01', '+1', '1234567890', 1, '123 Main Street', '', '', 10001, 'New York', '40.7128° N, 74.0060° W', 'ABC Company est une entreprise innovante spécialisée dans la fourniture de solutions technologiques pour les entreprises du secteur financier.');

-- --------------------------------------------------------

--
-- Structure de la table `files`
--

CREATE TABLE `files` (
  `idFile` int(11) NOT NULL,
  `descriptionFile` varchar(255) NOT NULL,
  `nameFile` varchar(255) NOT NULL,
  `pathFile` varchar(255) NOT NULL,
  `typeFile` varchar(255) NOT NULL,
  `idEmployeur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
  `idImage` int(11) NOT NULL,
  `nomImage` varchar(255) NOT NULL,
  `cheminImage` varchar(255) NOT NULL,
  `typeImage` varchar(255) NOT NULL,
  `estProfil` tinyint(1) NOT NULL,
  `estActive` tinyint(1) NOT NULL,
  `idEmployeur` int(11) NOT NULL,
  `idEntreprise` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`idImage`, `nomImage`, `cheminImage`, `typeImage`, `estProfil`, `estActive`, `idEmployeur`, `idEntreprise`) VALUES
(1, '1.jpg', 'imgs/Profile/', 'image/jpg', 1, 1, 1, 0),
(3, '1.png', 'imgs/Entreprise/', 'image/png', 0, 1, 0, 1),
(4, 'couverture1.jpg', 'imgs/Entreprise/', 'image/jpg', 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `jobrealises`
--

CREATE TABLE `jobrealises` (
  `idjob` int(11) NOT NULL,
  `typejob` varchar(128) NOT NULL,
  `lieujob` varchar(128) NOT NULL,
  `disjob` text NOT NULL,
  `idEntreprise` int(11) NOT NULL,
  `idCond` int(11) NOT NULL,
  `evjob` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `reseauxsociaux`
--

CREATE TABLE `reseauxsociaux` (
  `idReseauxsociaux` int(11) NOT NULL,
  `urlReseauxsociaux` varchar(255) NOT NULL,
  `typeReseauxsociaux` varchar(255) NOT NULL,
  `estProfil` tinyint(1) NOT NULL,
  `idEntreprise` int(11) NOT NULL,
  `idEmployeur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `reseauxsociaux`
--

INSERT INTO `reseauxsociaux` (`idReseauxsociaux`, `urlReseauxsociaux`, `typeReseauxsociaux`, `estProfil`, `idEntreprise`, `idEmployeur`) VALUES
(1, ' www.facebook.com', 'Facebook', 0, 2, 0),
(2, 'www.instagram.com', 'Instagram', 0, 1, 0),
(4, 'www.linkedin.com', 'LinkedIn', 1, 0, 2),
(7, 'www.instagram.com', 'Facebook', 1, 0, 1),
(8, ' www.twitter.com', 'Facebook', 1, 1, 0),
(9, ' www.twitter.com', 'Facebook', 0, 1, 0),
(11, 'www.instagram.com', 'Facebook', 0, 1, 0),
(14, 'www.facebook.com', 'Facebook', 1, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

CREATE TABLE `tags` (
  `idTag` int(11) NOT NULL,
  `nameTag` varchar(255) NOT NULL,
  `idEmployeur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `tags`
--

INSERT INTO `tags` (`idTag`, `nameTag`, `idEmployeur`) VALUES
(2, 'ServerSideDevelopment', 1),
(3, 'WebDevelopment', 1),
(4, 'Programming', 1),
(6, 'APIDevelopment', 1),
(7, 'ServerProgramming', 1),
(8, 'PHPDeveloper', 1),
(9, 'JavaDeveloper', 1),
(10, 'PythonDeveloper', 1),
(21, 'BackendDeveloper', 1),
(22, 'APIDevelopment', 3);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `abonnement`
--
ALTER TABLE `abonnement`
  ADD PRIMARY KEY (`idAbonnement`),
  ADD KEY `idProfile` (`idProfile`);

--
-- Index pour la table `employeur`
--
ALTER TABLE `employeur`
  ADD PRIMARY KEY (`idCandidat`);

--
-- Index pour la table `entreprise`
--
ALTER TABLE `entreprise`
  ADD PRIMARY KEY (`idEntreprise`);

--
-- Index pour la table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`idFile`),
  ADD KEY `filesEmployeur` (`idEmployeur`);

--
-- Index pour la table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`idImage`);

--
-- Index pour la table `jobrealises`
--
ALTER TABLE `jobrealises`
  ADD PRIMARY KEY (`idjob`),
  ADD KEY `idEntreprise` (`idEntreprise`),
  ADD KEY `idCond` (`idCond`);

--
-- Index pour la table `reseauxsociaux`
--
ALTER TABLE `reseauxsociaux`
  ADD PRIMARY KEY (`idReseauxsociaux`);

--
-- Index pour la table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`idTag`),
  ADD KEY `tagsEmployeur` (`idEmployeur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `abonnement`
--
ALTER TABLE `abonnement`
  MODIFY `idAbonnement` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `employeur`
--
ALTER TABLE `employeur`
  MODIFY `idCandidat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `entreprise`
--
ALTER TABLE `entreprise`
  MODIFY `idEntreprise` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `files`
--
ALTER TABLE `files`
  MODIFY `idFile` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
  MODIFY `idImage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `jobrealises`
--
ALTER TABLE `jobrealises`
  MODIFY `idjob` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reseauxsociaux`
--
ALTER TABLE `reseauxsociaux`
  MODIFY `idReseauxsociaux` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `tags`
--
ALTER TABLE `tags`
  MODIFY `idTag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `abonnement`
--
ALTER TABLE `abonnement`
  ADD CONSTRAINT `abonnement_ibfk_1` FOREIGN KEY (`idProfile`) REFERENCES `employeur` (`idCandidat`);

--
-- Contraintes pour la table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `filesEmployeur` FOREIGN KEY (`idEmployeur`) REFERENCES `employeur` (`idCandidat`);

--
-- Contraintes pour la table `jobrealises`
--
ALTER TABLE `jobrealises`
  ADD CONSTRAINT `jobrealises_ibfk_1` FOREIGN KEY (`idEntreprise`) REFERENCES `entreprise` (`idEntreprise`),
  ADD CONSTRAINT `jobrealises_ibfk_2` FOREIGN KEY (`idCond`) REFERENCES `employeur` (`idCandidat`);

--
-- Contraintes pour la table `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `tagsEmployeur` FOREIGN KEY (`idEmployeur`) REFERENCES `employeur` (`idCandidat`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
