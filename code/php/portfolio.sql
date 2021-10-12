-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 24 août 2021 à 18:00
-- Version du serveur : 10.4.20-MariaDB
-- Version de PHP : 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `portfolio`
--
CREATE DATABASE IF NOT EXISTS `portfolio`;
USE `portfolio`;

-- --------------------------------------------------------

--
-- Structure de la table `domaine`
--

CREATE TABLE `domaine` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `logiciels` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `competences` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `styles` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `domaine`
--

INSERT INTO `domaine` (`id`, `titre`, `logiciels`, `competences`, `styles`) VALUES
(1, 'Game Design', 'Logiciels : Indesign, Yed, Trello, Gsuite, Adobe XD', 'Compétences : Conception Théorique/Document, Gestion de Projet/d\'Équipe', 'Méthodes : Agile, Top-Down, Bottom-Up'),
(2, 'Graphic Design', 'Logiciels : Blender, 3dsMax, Photoshop, Illustrator, Marmoset, Substance', 'Compétences : Modélisation 3D, Asset 2D', 'Styles : 2D - Flat design / 3D - Cartoon, Low Poly'),
(3, 'Front-End & Back-End', 'Logiciels : Node.js, Unity, My SQL', 'Langages : C#, HTML, CSS, Javascript, PHP', 'Framework : MonoDevelop (.Net / Gtk+), Symfony, JQuery');

-- --------------------------------------------------------

--
-- Structure de la table `frise`
--

CREATE TABLE `frise` (
  `id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `titre` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `id_div` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `class_div` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `contenu` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `image` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `frise`
--

INSERT INTO `frise` (`id`, `date`, `titre`, `id_div`, `class_div`, `contenu`, `image`) VALUES
(1, 2017, 'Baccalauréat Scientifique', 'bac', 'formation', '', ''),
(2, 2018, 'Mystic Mask', 'mystic', 'project', 'Pitch : Alors qu\'un affrontement entre deux tribus fait rage. Les esprits protecteurs de chaque tribu décide de prendre part à la bataille. Dans ce jeu, chaque joueur contrôle deux avatars aux déplacements opposés sur l\'axe horizontal.\r\nRôles : Game Design (création de gameplay et document de conception) et Graphic Design 2D (feedbacks visuels, avatar apparence animale).\r\nTechnologies : Unity, 3Ds Max, FMOD et la suite Adobe.', '../../media/image/MysticMask/Screen4.jpg'),
(3, 2018, 'Assistant Administratif', 'assistant', 'job', '', ''),
(4, 2019, 'Tentacule', 'tentacule', 'project', 'Pitch : Contrôlez un personnage possédant un tentacule collant manipulez tant bien que mal des objets du quotidien.\r\nRôle : du Game Design (création de gameplay et document conception) et du Graphic Design (mobilier, jouets d\'éveil et UI).\r\nTechnologies : Unity, 3Ds Max, FMOD et la suite Adobe.\r\n', '../../media/image/Tentacule/Screen8.jpg'),
(5, 2019, 'Infographiste', 'kog', 'job', '', ''),
(6, 2019, 'Un Jour de Plus', 'ujdp', 'project', 'Pitch : Vous vous perdez en montagne, sans moyen de communiquer avec le monde extérieur et sans repère pour rentrer chez vous. Heureusement, vous trouvez un abri au loin pour passer la nuit et survivre... Mais pour combien de temps ?\r\nRôles : Projet dans lequel j\'ai fait du Game Design (création de gameplay et document de conception) et du Graphic Design 2D (animation, divers modèle 3D, intégration Unity, UI menu start/pause).\r\nTechnologies : Unity, Blender, 3Ds max, Substance et la suite Adobe.', '../../media/image/UJDP/Screen32.jpg'),
(7, 2020, 'Bachelor Game Design', 'ican', 'formation', 'Parcours de trois années dans l\'école ICAN (Institut de Création et Animation Numérique) pendant lesquels j\'ai étudié le domaine du Game Design, mais également un grand nombre d\'autres domaines du milieu du Jeu Vidéo (Level Design, Modélisation 3D, Programmation, Sound Design...). Pendant mes études, j\'ai également produit des projets, disponibles dans mon portfolio.', '../../media/image/site/ican.jpg'),
(8, 2021, 'Certificat Développeur Web et Web Mobile', 'philiance', 'formation', 'Formation de 6 mois qui me permettra de créer des pages web en front-end et back-end grâce au langage de programmation HTML, CSS, JAVASCRIPT, PHP. Tous en utilisant des outils tel que SYMFONY et en apprenant les bases du SEO, sécurité...', '../../media/image/site/philiance.png');

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

CREATE TABLE `projet` (
  `id` int(11) NOT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `lien` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `alt` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `titre` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `contenu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `projet`
--

INSERT INTO `projet` (`id`, `type`, `lien`, `alt`, `titre`, `contenu`) VALUES
(1, 'game', '../../media/image/MysticMask/Logo.png', 'MM', 'Mystic Mask', 'Alors qu\'un affrontement entre deux tribus fait rage. Les esprits protecteurs de chaque tribu décide de prendre part à la bataille. Dans ce jeu, chaque joueur contrôle deux avatars aux déplacements opposés sur l\'axe horizontal. Pour ma part, j\'ai principalement produit les assets 2D.Le jeu est développé sur Construct 2 avec la suite Adobe.'),
(2, 'game', '../../media/image/Flipperino/Logo.jpg ', 'F', 'Flipperino', 'Jouez à un flipper où presque aucun élément est visible. La particularité de ce projet est qu\'il a été conçu et produit en une semaine. Pour ma part, j\'ai produit tous les assets sonores et la documentation. Le jeu est développé sur Unity avec 3Ds Max, Fmod et la suite Adobe.'),
(3, 'game', '../../media/image/Tentacule/Logo.png', 'T', 'Tentacule', 'Contrôlez un personnage possédant un tentacule collant et manipulez tant bien que mal des objets du quotidien. Pour ma part, j\'ai produit tous les assets 2D, une partie des assets 3D et la documentation. Le jeu est développé sur Unity avec 3Ds Max, Fmod et la suite Adobe.'),
(4, 'game', '../../media/image/RunnerRoyale/Logo.png', 'RR', 'Runner Royale', 'Les coureurs sont en place. La tension est à son comble... Et GO !!!! Lequel des cent coureurs va atteindre la ligne d\'arrivée ? Attention, tous les coups sont permis.'),
(5, 'game', '../../media/image/PongArt/Logo.png', 'PA', 'Pop Art', 'Match en un contre un dans au style pop art.'),
(6, 'game', '../../media/image/UJDP/Logo.png', 'UJDP', 'Un Jour de Plus', 'Vous vous perdez en montagne, sans moyen de communiquer avec le monde extérieur et sans repère pour rentrer chez vous. Heureusement, vous trouvez un abri au loin pour passer la nuit et survivre... Mais pour combien de temps ?'),
(7, 'modelisation', '../../media/image/tour-min.jpg', 'Tour', '', ''),
(8, 'modelisation', '../../media/image/sac.jpg', 'Sac', NULL, NULL),
(9, 'modelisation', '../../media/image/cubeworld.jpg', 'Cube', NULL, NULL),
(10, 'modelisation', '../../media/image/tour-min.jpg', 'Porte', NULL, NULL),
(11, 'modelisation', '../../media/image/cave.jpg', 'Cave', NULL, NULL),
(12, 'modelisation', '../../media/image/chambre.jpg', 'Chambre', NULL, NULL),
(13, 'modelisation', '../../media/image/jouet.jpg', 'Jouet', NULL, NULL),
(14, 'sprite', '../../media/image/monstre.png', 'Monstre', NULL, NULL),
(15, 'sprite', '../../media/image/jolly.jpg', 'Jolly', NULL, NULL),
(16, 'sprite', '../../media/image/logoMM.png', 'MM', NULL, NULL),
(17, 'sprite', '../../media/image/Savane.png', 'Savane', NULL, NULL),
(18, 'sprite', '../../media/image/Doremi.png', 'Doremi', NULL, NULL),
(19, 'sprite', '../../media/image/Boutons.jpg', 'Boutons', NULL, NULL),
(20, 'sprite', '../../media/image/ConceptArt.jpg\"', 'Concept Art', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `identifiant` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `mot_de_passe` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `domaine`
--
ALTER TABLE `domaine`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `frise`
--
ALTER TABLE `frise`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `projet`
--
ALTER TABLE `projet`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `domaine`
--
ALTER TABLE `domaine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `frise`
--
ALTER TABLE `frise`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `projet`
--
ALTER TABLE `projet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
