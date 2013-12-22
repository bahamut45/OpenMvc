-- phpMyAdmin SQL Dump
-- version 4.0.2
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Sam 21 Décembre 2013 à 15:58
-- Version du serveur: 5.5.31-0+wheezy1
-- Version de PHP: 5.4.4-14+deb7u7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `OpenMvc`
--
CREATE DATABASE IF NOT EXISTS `OpenMvc` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `OpenMvc`;

-- --------------------------------------------------------

--
-- Structure de la table `configs`
--
-- Création: Dim 04 Août 2013 à 16:25
-- Dernière modification: Dim 04 Août 2013 à 16:25
--

DROP TABLE IF EXISTS `configs`;
CREATE TABLE IF NOT EXISTS `configs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Vider la table avant d'insérer `configs`
--

TRUNCATE TABLE `configs`;
-- --------------------------------------------------------

--
-- Structure de la table `medias`
--
-- Création: Dim 04 Août 2013 à 16:25
-- Dernière modification: Mar 13 Août 2013 à 22:05
-- Dernière vérification: Mer 14 Août 2013 à 16:47
--

DROP TABLE IF EXISTS `medias`;
CREATE TABLE IF NOT EXISTS `medias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_medias_posts_idx` (`post_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Vider la table avant d'insérer `medias`
--

TRUNCATE TABLE `medias`;
--
-- Contenu de la table `medias`
--

INSERT DELAYED IGNORE INTO `medias` (`id`, `name`, `file`, `post_id`, `type`) VALUES
(1, 'Mon ecran', '2013-08/img5.jpg', 3, 'img'),
(2, 'Mon ecran2', '2013-08/img7.png', 3, 'img'),
(4, 'Mon avatar', '2013-08/avatar_bahamut.png', 11, 'img');

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--
-- Création: Lun 11 Novembre 2013 à 08:37
-- Dernière modification: Jeu 12 Décembre 2013 à 08:14
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `content` text,
  `created` datetime DEFAULT NULL,
  `online` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_posts_users1_idx` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- RELATIONS POUR LA TABLE `posts`:
--   `cat_id`
--       `posts_categories` -> `id`
--

--
-- Vider la table avant d'insérer `posts`
--

TRUNCATE TABLE `posts`;
--
-- Contenu de la table `posts`
--

INSERT DELAYED IGNORE INTO `posts` (`id`, `name`, `content`, `created`, `online`, `type`, `slug`, `user_id`, `cat_id`) VALUES
(1, 'Ma première page', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', '2013-08-06 00:00:00', 1, 'page', 'ma-premiere-page', 0, 0),
(2, 'Ma seconde page', '<p>Un second contenu </p>', '2013-08-06 00:00:00', 1, 'page', 'ma-seconde-page', 0, 0),
(3, 'Performances Web : Principes et Audit', '<p><img class="img-polaroid" style="float: left; margin-right: 10px; margin-left: 10px;" src="http://ww1.prweb.com/prfiles/2009/06/16/168400/logotransparentbg.png" alt="" width="450" height="180" /></p>\r\n<p>Dans cette s&eacute;rie d''articles, je vous propose de d&eacute;couvrir la d&eacute;finition et l''utilisation de la notion de performances web. Cette article traitera des principes de bases et les enjeux.</p>\r\n<hr id="openmvc-readmore" style="border: red dashed 1px;" />\r\n<h3>&nbsp;Principes de base et enjeux</h3>\r\n<p>La notion de performances web, plus simplement appel&eacute;e <strong>WebPerf</strong>, vise &agrave; une seule chose : l''am&eacute;lioration du d&eacute;lai d''affichage d''une page(et par extension, d''un site), une fois que le serveur a termin&eacute; de la g&eacute;n&eacute;rer.</p>\r\n<p>Tout part du constat que la g&eacute;n&eacute;ration d''une page web c&ocirc;t&eacute; serveur repr&eacute;sente au maximum 20% du temps total de chargement de cette page. Essayons donc d&rsquo;am&eacute;liorer les 80% restant.</p>\r\n<p><strong>Pourquoi r&eacute;duire le temps d''affichage de votre site ?&nbsp;</strong>Comme l''ont d&eacute;j&agrave; d&eacute;montr&eacute; nombre d''&eacute;tudes et retours d''exp&eacute;riences, celui-ci a une influence directe sur de multiples &eacute;l&eacute;ments,dont le nombre de pages vues, la performance commerciale et m&ecirc;me le positionnement &nbsp;sur les moteurs de recherches.</p>\r\n<blockquote>\r\n<p><strong>Quelques exemples :</strong></p>\r\n<ul>\r\n<li>Walmart a mesur&eacute; que le temps de chargement des pages inf&eacute;rieurs pour les clients qui ach&egrave;tent que pour ceux qui n''ach&egrave;tent pas.</li>\r\n<li>Apr&egrave;s avoir am&eacute;lior&eacute; le temps de chargement de ses pages d''environ 7 &agrave; 2 secondes, le site Shopzilla a vu son taux de conversion passer de 7 &agrave; 12 %, son nombre de pages vues augmenter de 25 % , tout en divisant par deux le nombre de serveurs n&eacute;cessaires pour tenir la charge.</li>\r\n<li>Les deux moteurs de recherche Google et Bing ont constat&eacute; une baisse durable des recherches, et donc des revenus, suite &agrave; une augmentation du temps de chargement de leurs pages</li>\r\n</ul>\r\n</blockquote>\r\n<p>Ce m&eacute;mento pr&eacute;sente les principales r&egrave;gles et m&eacute;thodes, ainsi que les outils essentiels &agrave; disposition pour &eacute;valuer la performance d''un site, en identifier les points faibles et mettre en place les optimisations. Il ne saurait &ecirc;tre un ouvrage de r&eacute;f&eacute;rence, mais pourra vous aiguiller tout au long de votre projet et vous accompagner dans vos optimisations.</p>', '2013-11-21 20:29:46', 1, 'post', 'performances-web-principes-audits', 1, 1),
(5, 'Mon second article', '<p>Augue eros nunc ultricies nascetur turpis scelerisque sociis dictumst, platea parturient. Elit ac egestas? Urna nec cras ultricies purus tortor amet dolor, mus dis sit arcu cursus. Massa? Amet porta. A nec habitasse, odio, nunc rhoncus, mauris, auctor? Sed, magna nec augue integer placerat phasellus ac adipiscing porta, nunc tempor lorem dolor porta ultricies in, lacus! Aenean, urna cras montes pulvinar cras placerat! Penatibus, ridiculus vut, porttitor porta dignissim eros, amet tempor urna scelerisque mus in rhoncus augue scelerisque turpis! Lundium elementum elit integer dignissim parturient a habitasse, placerat placerat, porta lorem arcu vut odio mauris turpis pulvinar, proin pulvinar sed placerat, ultricies purus phasellus nec sociis aliquam, scelerisque ac. A ridiculus? Augue natoque arcu. Scelerisque ut, turpis aliquet integer.</p>', '2013-09-05 21:35:00', 1, 'post', 'mon-second-article', 0, 2),
(13, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL),
(9, 'Mon article UPDATE de test', '<p>Exemple de contenu en <strong>Gras</strong></p>', '2013-08-10 15:54:08', 1, 'post', 'update-post', 0, 6),
(11, 'Mon troisième article', '<p>Porttitor quis magna? Turpis ultrices vel! Amet mus risus sagittis est lectus cum montes ac! Habitasse odio scelerisque, vel, rhoncus ut habitasse habitasse elementum, sociis integer, ut pellentesque dapibus integer lundium enim arcu odio. Adipiscing dapibus? Massa sed montes purus lorem adipiscing turpis turpis nec elit vut aenean dignissim ut velit! Placerat, ac in, dapibus pid, rhoncus, velit integer ac nec natoque odio etiam pellentesque vut cras quis nunc aliquet, pid ac? Aenean duis placerat pulvinar sed amet augue quis ac massa porta mus, purus in, quis etiam. Vel vel nisi placerat. Eros magna porta elit! Augue urna platea proin? Sit ut natoque tristique! Sed scelerisque tempor massa? Elementum mauris urna enim porttitor nec ut tempor tincidunt risus sagittis tortor.</p>\n<p>&nbsp;</p>\n<blockquote>\n<p>Cette cat&eacute;gorie servira &agrave; lister tous les articles concernant la <strong>programmation</strong></p>\n</blockquote>\n<p>&nbsp;</p>', '2013-08-15 21:41:51', 1, 'post', 'mon-troisieme-article', 0, 6);

-- --------------------------------------------------------

--
-- Structure de la table `posts_categories`
--
-- Création: Mar 17 Décembre 2013 à 06:22
-- Dernière modification: Mar 17 Décembre 2013 à 06:24
--

DROP TABLE IF EXISTS `posts_categories`;
CREATE TABLE IF NOT EXISTS `posts_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` text,
  `parentId` int(11) NOT NULL,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Vider la table avant d'insérer `posts_categories`
--

TRUNCATE TABLE `posts_categories`;
--
-- Contenu de la table `posts_categories`
--

INSERT DELAYED IGNORE INTO `posts_categories` (`id`, `name`, `slug`, `content`, `parentId`, `sort`) VALUES
(1, 'Programmation', 'programmation', '<p><strong>Cette</strong> cat&eacute;gorie servira &agrave; lister tous les articles concernant la <strong>programmation</strong></p>', 0, 0),
(2, 'Musique', 'musique', '<p>Cette cat&eacute;gorie servira &agrave; expliquer le contenu de la <strong>musique</strong> propos&eacute;e</p>', 0, 1),
(3, 'Jeux', 'jeux', '<p>Cette cat&eacute;gorie rassemblera tous les articles sur les jeux vid&eacute;os</p>', 0, 2),
(4, 'FPS', 'fps', '<p>Cette cat&eacute;gorie servira au different jeux du type <strong>F</strong>irst <strong>P</strong>ersonnal <strong>S</strong>hooter</p>', 3, 0),
(5, 'RPG', 'rpg', '<p>Cette cat&eacute;gorie servira pour les jeux de type <strong>R</strong>ole-<strong>P</strong>laying <strong>G</strong>ame</p>', 3, 1),
(6, 'PHP', 'php', '<p>Cette cat&eacute;gorie servira pour tout le language php</p>', 1, 0),
(14, NULL, NULL, NULL, -1, NULL),
(8, 'Call Of Duty', 'call-of-duty', '<p>Cette cat&eacute;gorie servira pour le jeu Call Of Duty</p>', 4, 0);

-- --------------------------------------------------------

--
-- Structure de la table `posts_tags`
--
-- Création: Lun 07 Octobre 2013 à 07:12
-- Dernière modification: Lun 07 Octobre 2013 à 21:27
--

DROP TABLE IF EXISTS `posts_tags`;
CREATE TABLE IF NOT EXISTS `posts_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `posts_id` int(11) NOT NULL,
  `tags_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- RELATIONS POUR LA TABLE `posts_tags`:
--   `posts_id`
--       `posts` -> `id`
--   `tags_id`
--       `tags` -> `id`
--

--
-- Vider la table avant d'insérer `posts_tags`
--

TRUNCATE TABLE `posts_tags`;
--
-- Contenu de la table `posts_tags`
--

INSERT DELAYED IGNORE INTO `posts_tags` (`id`, `posts_id`, `tags_id`) VALUES
(1, 3, 1),
(8, 3, 2),
(10, 3, 4),
(9, 3, 3);

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--
-- Création: Lun 07 Octobre 2013 à 07:13
-- Dernière modification: Lun 07 Octobre 2013 à 21:14
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Vider la table avant d'insérer `tags`
--

TRUNCATE TABLE `tags`;
--
-- Contenu de la table `tags`
--

INSERT DELAYED IGNORE INTO `tags` (`id`, `name`) VALUES
(1, 'php'),
(2, 'html'),
(3, 'js'),
(4, 'mysql'),
(5, 'test');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--
-- Création: Mer 14 Août 2013 à 22:07
-- Dernière modification: Mer 14 Août 2013 à 22:15
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Vider la table avant d'insérer `users`
--

TRUNCATE TABLE `users`;
--
-- Contenu de la table `users`
--

INSERT DELAYED IGNORE INTO `users` (`id`, `login`, `password`, `role`) VALUES
(1, 'Administrateur', '19c432464b90f5f9d8934f01478d2e8f3af64b69', 'admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
