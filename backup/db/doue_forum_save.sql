-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour doue_forum
CREATE DATABASE IF NOT EXISTS `doue_forum` /*!40100 DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `doue_forum`;

-- Listage de la structure de table doue_forum. category
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int NOT NULL AUTO_INCREMENT,
  `nameCategory` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table doue_forum.category : ~6 rows (environ)
INSERT INTO `category` (`id_category`, `nameCategory`) VALUES
	(1, 'Bonheur'),
	(2, 'Amour'),
	(3, 'Existence'),
	(4, 'Humanit&eacute;'),
	(5, 'Climatologie'),
	(6, 'Environnement');

-- Listage de la structure de table doue_forum. post
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int NOT NULL AUTO_INCREMENT,
  `datePost` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `textPost` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `topic_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id_post`),
  KEY `topic_id` (`topic_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `FK_post_topic` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`),
  CONSTRAINT `FK_post_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table doue_forum.post : ~0 rows (environ)

-- Listage de la structure de table doue_forum. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int NOT NULL AUTO_INCREMENT,
  `dateTopic` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nameTopic` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `isLockTopic` tinyint(1) NOT NULL DEFAULT '0',
  `category_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id_topic`),
  KEY `category_id` (`category_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `FK_topic_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`),
  CONSTRAINT `FK_topic_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table doue_forum.topic : ~4 rows (environ)
INSERT INTO `topic` (`id_topic`, `dateTopic`, `nameTopic`, `isLockTopic`, `category_id`, `user_id`) VALUES
	(1, '2023-09-04 15:09:24', 'Les hommes', 0, 4, 1),
	(2, '2023-09-04 15:09:24', 'Les femmes', 0, 4, 2),
	(3, '2023-09-04 15:09:24', 'Les transgenres', 0, 4, 3),
	(4, '2023-09-04 18:01:38', 'Les actions climatiques', 0, 3, 1);

-- Listage de la structure de table doue_forum. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `pseudoUser` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `emailUser` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `passWordUser` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `registrationUser` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `roleUser` json DEFAULT NULL,
  `isBanUser` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `mailUser` (`emailUser`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table doue_forum.user : ~7 rows (environ)
INSERT INTO `user` (`id_user`, `pseudoUser`, `emailUser`, `passWordUser`, `registrationUser`, `roleUser`, `isBanUser`) VALUES
	(1, 'leonMoise', 'user1@domain1.com', 'tftbutjukukkkuykykyuky', '2023-09-04 14:54:53', NULL, 0),
	(2, 'chardonne', 'user2@domain2.com', 'tftbutj1256786ykykyuky', '2023-09-04 14:54:53', NULL, 0),
	(3, 'gideon', 'user3@domain3.com', 'tftbutj1256786ykykyuky', '2023-09-04 14:54:53', NULL, 0),
	(4, 'mom', 'mom75@momo.com', '$2y$10$0juhT0tNMq9QUPSyGOzeGuj7UkDQfymtYd4fU9t23kmZ8c7y2UMzi', '2023-09-08 08:53:35', '["ROLE_USER"]', 0),
	(7, 'momo', 'momo@momo.com', '$2y$10$ZpK.tI8I1J7kEsyfqv06gehtdOef7kZ.Eu9XRmjf1iqDQDCWb/342', '2023-09-08 09:49:08', '[]', 0),
	(8, 'momo2', 'momo2@momo.net', '$2y$10$9klckfSAbgUR1G1q03M4xeYNPcWLvK0dVo2KJVJj8ifbWRG0.mGo.', '2023-09-12 12:46:13', '["ROLE_USER"]', 0),
	(9, 'admin', 'admin@forum-cda.com', '$2y$10$ZwOOr6u9PrSV4R1URSEaju2c3E/rOa7uwQSxOJJYB7NDefU42sigK', '2023-09-12 16:53:16', '["ROLE_ADMIN"]', 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
