CREATE DATABASE  IF NOT EXISTS `keypanel` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_spanish_ci */;
USE `keypanel`;
-- MySQL dump 10.13  Distrib 5.6.23, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: keypanel
-- ------------------------------------------------------
-- Server version	5.5.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` mediumint(6) NOT NULL AUTO_INCREMENT,
  `id_parent` mediumint(6) DEFAULT NULL,
  `breadcrumb` tinytext COLLATE latin1_spanish_ci,
  `name` varchar(45) COLLATE latin1_spanish_ci DEFAULT NULL,
  `slug` char(45) COLLATE latin1_spanish_ci NOT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `status_row` enum('DELETED','ENABLED') COLLATE latin1_spanish_ci DEFAULT 'ENABLED' COMMENT 'Indica el borrado logico\n',
  PRIMARY KEY (`id`,`slug`),
  UNIQUE KEY `slug` (`slug`),
  KEY `id_parent` (`id_parent`),
  KEY `breadcrumb` (`breadcrumb`(500)),
  KEY `status_row` (`status_row`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `entities`
--

DROP TABLE IF EXISTS `entities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entities` (
  `id` mediumint(6) NOT NULL AUTO_INCREMENT,
  `id_parent` mediumint(6) DEFAULT NULL,
  `breadcrumb` tinytext COLLATE latin1_spanish_ci,
  `type` enum('SUPERADMIN','ADMIN','MEMBER','ORGANIZATION','PROFILE','AREA') COLLATE latin1_spanish_ci DEFAULT 'PROFILE' COMMENT 'Tipo de usuario',
  `first_name` char(100) COLLATE latin1_spanish_ci DEFAULT NULL,
  `last_name` char(60) COLLATE latin1_spanish_ci DEFAULT NULL,
  `username` char(100) COLLATE latin1_spanish_ci DEFAULT NULL,
  `password` char(32) COLLATE latin1_spanish_ci DEFAULT NULL,
  `email` char(100) COLLATE latin1_spanish_ci DEFAULT NULL,
  `avatar` char(32) COLLATE latin1_spanish_ci DEFAULT NULL,
  `id_membership` mediumint(6) DEFAULT NULL,
  `id_contact` mediumint(6) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `status_row` enum('DELETED','ENABLED') COLLATE latin1_spanish_ci DEFAULT 'ENABLED' COMMENT 'Indica el borrado lógico',
  PRIMARY KEY (`id`),
  KEY `id_parent` (`id_parent`),
  KEY `username` (`username`),
  KEY `email` (`email`),
  KEY `type` (`type`),
  KEY `status_row` (`status_row`),
  KEY `breadcrumb` (`breadcrumb`(500)),
  KEY `id_contact` (`id_contact`)
) ENGINE=MyISAM AUTO_INCREMENT=338 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `entities_access_log`
--

DROP TABLE IF EXISTS `entities_access_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entities_access_log` (
  `id` mediumint(6) NOT NULL AUTO_INCREMENT,
  `id_entity` mediumint(6) NOT NULL COMMENT '	',
  `date` datetime NOT NULL,
  `ip_address` char(15) COLLATE latin1_spanish_ci NOT NULL,
  `browser` char(200) COLLATE latin1_spanish_ci NOT NULL COMMENT 'Se registrarán 10 logins por usuario, cuando el tamaño de acceso llegue al limite, se sobreescribirá el mas antiguo.',
  PRIMARY KEY (`id`),
  KEY `id_entity` (`id_entity`),
  KEY `date` (`date`),
  KEY `browser` (`browser`)
) ENGINE=MyISAM AUTO_INCREMENT=1865 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `entities_address`
--

DROP TABLE IF EXISTS `entities_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entities_address` (
  `id` mediumint(6) NOT NULL AUTO_INCREMENT,
  `id_entity` mediumint(6) NOT NULL,
  `type` enum('HOME','BUSINESS','POBOX') COLLATE latin1_spanish_ci DEFAULT 'BUSINESS',
  `street` char(60) COLLATE latin1_spanish_ci NOT NULL,
  `num_ext` char(5) COLLATE latin1_spanish_ci DEFAULT NULL,
  `num_int` char(5) COLLATE latin1_spanish_ci DEFAULT NULL,
  `neighborhood` char(40) COLLATE latin1_spanish_ci NOT NULL,
  `zip_code` char(10) COLLATE latin1_spanish_ci NOT NULL,
  `city` char(40) COLLATE latin1_spanish_ci NOT NULL,
  `state` char(40) COLLATE latin1_spanish_ci NOT NULL,
  `country` char(100) COLLATE latin1_spanish_ci NOT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `status_row` enum('DELETED','ENABLED') COLLATE latin1_spanish_ci DEFAULT 'ENABLED' COMMENT 'Indica el borrado lógico',
  PRIMARY KEY (`id`),
  KEY `id_entity` (`id_entity`),
  KEY `status_row` (`status_row`),
  KEY `type` (`type`)
) ENGINE=MyISAM AUTO_INCREMENT=284 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `entities_auth`
--

DROP TABLE IF EXISTS `entities_auth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entities_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(20) COLLATE latin1_spanish_ci NOT NULL,
  `entity_type` enum('SUPERADMIN','ADMIN','COMPANY','PROFILE','MEMBER') COLLATE latin1_spanish_ci DEFAULT NULL,
  `id_entity` mediumint(6) DEFAULT NULL,
  `c` tinyint(1) DEFAULT '0' COMMENT 'CREATE',
  `r` tinyint(1) DEFAULT '0' COMMENT 'READ',
  `u` tinyint(1) DEFAULT '0' COMMENT 'UPDATE',
  `d` tinyint(1) DEFAULT '0' COMMENT 'DELETE',
  PRIMARY KEY (`id`,`name`),
  KEY `user_type` (`entity_type`),
  KEY `id_entity` (`id_entity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `entities_categories`
--

DROP TABLE IF EXISTS `entities_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entities_categories` (
  `id` mediumint(6) NOT NULL AUTO_INCREMENT,
  `id_category` mediumint(6) NOT NULL,
  `id_entity` mediumint(6) NOT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `status_row` enum('DELETED','ENABLED') COLLATE latin1_spanish_ci DEFAULT 'ENABLED' COMMENT 'Indica el borrado lógico',
  PRIMARY KEY (`id`),
  KEY `id_category` (`id_category`),
  KEY `id_entity` (`id_entity`),
  KEY `status_row` (`status_row`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `entities_contacts`
--

DROP TABLE IF EXISTS `entities_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entities_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bio` text COLLATE latin1_spanish_ci,
  `description` text COLLATE latin1_spanish_ci,
  `phone_personal` char(20) COLLATE latin1_spanish_ci DEFAULT NULL,
  `phone_business` char(20) COLLATE latin1_spanish_ci DEFAULT NULL,
  `facebook` char(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `twitter` char(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `linkedin` char(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `gplus` char(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `email_personal` char(100) COLLATE latin1_spanish_ci DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `status_row` enum('DELETED','ENABLED') COLLATE latin1_spanish_ci DEFAULT 'ENABLED' COMMENT 'Indica el borrado lógico',
  PRIMARY KEY (`id`),
  KEY `id_status` (`status_row`)
) ENGINE=MyISAM AUTO_INCREMENT=283 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `entities_history`
--

DROP TABLE IF EXISTS `entities_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entities_history` (
  `id` mediumint(6) NOT NULL AUTO_INCREMENT,
  `id_member` mediumint(6) NOT NULL,
  `id_profile` mediumint(6) NOT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `status_row` enum('DELETED','ENABLED') COLLATE latin1_spanish_ci DEFAULT 'ENABLED',
  PRIMARY KEY (`id`),
  KEY `id_member` (`id_member`),
  KEY `id_profile` (`id_profile`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `entities_membership`
--

DROP TABLE IF EXISTS `entities_membership`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entities_membership` (
  `id` mediumint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `since` datetime NOT NULL,
  `until` datetime NOT NULL,
  `status_row` enum('DELETED','EXPIRED','ACTIVE','PENDING') COLLATE latin1_spanish_ci DEFAULT 'PENDING',
  PRIMARY KEY (`id`),
  KEY `status_row` (`status_row`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `entities_sessions`
--

DROP TABLE IF EXISTS `entities_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entities_sessions` (
  `id` varchar(40) COLLATE latin1_spanish_ci NOT NULL,
  `ip_address` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `entities_tags`
--

DROP TABLE IF EXISTS `entities_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entities_tags` (
  `id` mediumint(6) NOT NULL AUTO_INCREMENT,
  `id_tag` mediumint(6) NOT NULL,
  `id_entity` mediumint(6) NOT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `status_row` enum('DELETED','ENABLED') COLLATE latin1_spanish_ci DEFAULT 'ENABLED' COMMENT 'Indica el borrado lógico',
  PRIMARY KEY (`id`),
  KEY `id_entity` (`id_entity`),
  KEY `id_tag` (`id_tag`),
  KEY `status_row` (`status_row`)
) ENGINE=MyISAM AUTO_INCREMENT=1410 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `news_comments`
--

DROP TABLE IF EXISTS `news_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news_comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_parent` bigint(20) unsigned DEFAULT NULL,
  `id_post` bigint(20) unsigned NOT NULL,
  `id_entity` mediumint(6) NOT NULL,
  `content` text COLLATE latin1_spanish_ci NOT NULL,
  `approved` varchar(45) COLLATE latin1_spanish_ci DEFAULT NULL,
  `type` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `status_row` enum('DELETED','ENABLED') COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_parent` (`id_parent`),
  KEY `id_post` (`id_post`),
  KEY `id_entity` (`id_entity`),
  KEY `type` (`type`),
  KEY `create_at` (`create_at`),
  KEY `status_row` (`status_row`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `news_posts`
--

DROP TABLE IF EXISTS `news_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news_posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `content` longtext COLLATE latin1_spanish_ci NOT NULL,
  `title` text COLLATE latin1_spanish_ci NOT NULL,
  `status` enum('PUBLISHED','UNPUBLISHED') COLLATE latin1_spanish_ci DEFAULT 'UNPUBLISHED',
  `comment_status` enum('ENABLED','DISABLED') COLLATE latin1_spanish_ci DEFAULT 'ENABLED',
  `password` varchar(20) COLLATE latin1_spanish_ci DEFAULT NULL,
  `slug` varchar(200) COLLATE latin1_spanish_ci NOT NULL,
  `type` enum('POST') COLLATE latin1_spanish_ci DEFAULT 'POST',
  `comment_count` bigint(20) DEFAULT '0',
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `status_row` enum('DELETED','ENABLED') COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `slug` (`slug`),
  KEY `type` (`type`),
  KEY `date` (`create_at`),
  KEY `status_row` (`status_row`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` mediumint(6) NOT NULL AUTO_INCREMENT,
  `id_parent` mediumint(6) DEFAULT NULL,
  `breadcrumb` tinytext COLLATE latin1_spanish_ci,
  `name` char(45) COLLATE latin1_spanish_ci NOT NULL,
  `slug` char(45) COLLATE latin1_spanish_ci NOT NULL,
  `count_search` mediumint(6) NOT NULL DEFAULT '0',
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `status_row` enum('DELETED','ENABLED') COLLATE latin1_spanish_ci DEFAULT 'ENABLED' COMMENT 'Indica el borrado lógico',
  PRIMARY KEY (`id`,`slug`),
  UNIQUE KEY `slug` (`slug`),
  KEY `id_parent` (`id_parent`),
  KEY `breadcrumb` (`breadcrumb`(500)),
  KEY `count_search` (`count_search`),
  KEY `status_row` (`status_row`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'keypanel'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-08-08 20:26:36
