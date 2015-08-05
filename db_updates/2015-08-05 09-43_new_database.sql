-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema keypanel
-- -----------------------------------------------------
-- Organigramas empresariales

-- -----------------------------------------------------
-- Schema keypanel
--
-- Organigramas empresariales
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `keypanel` DEFAULT CHARACTER SET latin1 COLLATE latin1_spanish_ci ;
USE `keypanel` ;

-- -----------------------------------------------------
-- Table `keypanel`.`entities`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `keypanel`.`entities` (
  `id` MEDIUMINT(6) NOT NULL AUTO_INCREMENT,
  `breadcrumb` TINYTEXT NOT NULL,
  `type` ENUM('SUPERADMIN','ADMIN','MEMBER','ORGANIZATION','PROFILE') NULL DEFAULT 'PROFILE' COMMENT 'Tipo de usuario',
  `first_name` CHAR(30) NULL DEFAULT NULL,
  `last_name` CHAR(60) CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NULL DEFAULT NULL,
  `username` CHAR(100) NOT NULL,
  `password` CHAR(32) NOT NULL,
  `email` CHAR(100) NOT NULL,
  `avatar` CHAR(32) NULL DEFAULT NULL,
  `id_membership` MEDIUMINT(6) NULL DEFAULT NULL,
  `id_contact` MEDIUMINT(6) NULL DEFAULT NULL,
  `create_at` DATETIME NULL DEFAULT NULL,
  `update_at` DATETIME NULL DEFAULT NULL,
  `status_row` ENUM('DELETED', 'ENABLED') NULL DEFAULT 'ENABLED' COMMENT 'Indica el borrado lógico',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC),
  INDEX `username` (`username` ASC),
  INDEX `email` (`email` ASC),
  INDEX `type` (`type` ASC),
  INDEX `status_row` (`status_row` ASC),
  INDEX `breadcrumb` (`breadcrumb`(500) ASC),
  INDEX `id_contact` (`id_contact` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `keypanel`.`entities_address`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `keypanel`.`entities_address` (
  `id` MEDIUMINT(6) NOT NULL AUTO_INCREMENT,
  `id_entity` MEDIUMINT(6) NOT NULL,
  `type` ENUM('HOME','BUSINESS','POBOX') NULL DEFAULT 'BUSINESS',
  `street` CHAR(60) NOT NULL,
  `num_ext` CHAR(5) NULL,
  `num_int` CHAR(5) CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NULL,
  `neighborhood` CHAR(40) NOT NULL,
  `zip_code` CHAR(10) NOT NULL,
  `city` CHAR(25) NOT NULL,
  `state` CHAR(40) NOT NULL,
  `country` CHAR(40) NOT NULL,
  `create_at` DATETIME NULL DEFAULT NULL,
  `update_at` DATETIME NULL DEFAULT NULL,
  `status_row` ENUM('DELETED', 'ENABLED') NULL DEFAULT 'ENABLED' COMMENT 'Indica el borrado lógico',
  PRIMARY KEY (`id`),
  INDEX `id_entity` (`id_entity` ASC),
  INDEX `status_row` (`status_row` ASC),
  INDEX `type` (`type` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `keypanel`.`entities_contacts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `keypanel`.`entities_contacts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `bio` TEXT NULL DEFAULT NULL,
  `description` TEXT NULL,
  `phone_personal` CHAR(20) NULL DEFAULT NULL,
  `phone_business` CHAR(20) NULL DEFAULT NULL,
  `facebook` CHAR(255) NULL DEFAULT NULL,
  `twitter` CHAR(255) CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NULL DEFAULT NULL,
  `linkedin` CHAR(255) NULL DEFAULT NULL,
  `gplus` CHAR(255) NULL DEFAULT NULL,
  `email_personal` CHAR(100) NULL DEFAULT NULL,
  `create_at` DATETIME NULL DEFAULT NULL,
  `update_at` DATETIME NULL DEFAULT NULL,
  `status_row` ENUM('DELETED', 'ENABLED') NULL DEFAULT 'ENABLED' COMMENT 'Indica el borrado lógico',
  PRIMARY KEY (`id`),
  INDEX `id_status` (`status_row` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `keypanel`.`tags`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `keypanel`.`tags` (
  `id` MEDIUMINT(6) NOT NULL AUTO_INCREMENT,
  `id_parent` MEDIUMINT(6) NOT NULL,
  `breadcrumb` TINYTEXT NOT NULL,
  `name` VARCHAR(45) CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NOT NULL,
  `create_at` DATETIME NULL DEFAULT NULL,
  `update_at` DATETIME NULL DEFAULT NULL,
  `status_row` ENUM('DELETED', 'ENABLED') NULL DEFAULT 'ENABLED' COMMENT 'Indica el borrado lógico',
  PRIMARY KEY (`id`),
  INDEX `id_parent` (`id_parent` ASC),
  INDEX `breadcrumb` (`breadcrumb`(500) ASC),
  INDEX `status_row` (`status_row` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `keypanel`.`entities_access_log`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `keypanel`.`entities_access_log` (
  `id` MEDIUMINT(6) NOT NULL AUTO_INCREMENT,
  `id_entity` MEDIUMINT(6) NOT NULL COMMENT '	',
  `date` DATETIME NOT NULL,
  `ip_address` CHAR(15) NOT NULL,
  `browser` CHAR(200) NOT NULL COMMENT 'Se registrarán 10 logins por usuario, cuando el tamaño de acceso llegue al limite, se sobreescribirá el mas antiguo.',
  PRIMARY KEY (`id`),
  INDEX `id_entity` (`id_entity` ASC),
  INDEX `date` (`date` ASC),
  INDEX `browser` (`browser` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `keypanel`.`entities_tags`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `keypanel`.`entities_tags` (
  `id` MEDIUMINT(6) NOT NULL AUTO_INCREMENT,
  `id_tag` MEDIUMINT(6) NOT NULL,
  `id_entity` MEDIUMINT(6) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `id_entity` (`id_entity` ASC),
  INDEX `id_tag` (`id_tag` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `keypanel`.`entities_auth`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `keypanel`.`entities_auth` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` CHAR(20) NOT NULL,
  `entity_type` ENUM('SUPERADMIN','ADMIN','COMPANY','PROFILE','MEMBER') NULL,
  `id_entity` MEDIUMINT(6) NULL DEFAULT NULL,
  `c` TINYINT(1) NULL DEFAULT 0 COMMENT 'CREATE',
  `r` TINYINT(1) NULL DEFAULT 0 COMMENT 'READ',
  `u` TINYINT(1) NULL DEFAULT 0 COMMENT 'UPDATE',
  `d` TINYINT(1) NULL DEFAULT 0 COMMENT 'DELETE',
  PRIMARY KEY (`id`, `name`),
  INDEX `user_type` (`entity_type` ASC),
  INDEX `id_entity` (`id_entity` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `keypanel`.`news_posts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `keypanel`.`news_posts` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_entity` MEDIUMINT(6) UNSIGNED NOT NULL,
  `content` LONGTEXT NOT NULL,
  `title` TEXT NOT NULL,
  `status` VARCHAR(20) NULL,
  `comment_status` ENUM('ENABLED','DISABLED') NULL DEFAULT 'ENABLED',
  `password` VARCHAR(20) NULL,
  `slug` VARCHAR(200) NULL,
  `type` VARCHAR(45) NULL,
  `comment_count` BIGINT(20) NULL,
  `create_at` DATETIME NULL,
  `update_at` DATETIME NULL,
  `status_row` ENUM('DELETED','ENABLED') NULL,
  PRIMARY KEY (`id`),
  INDEX `slug` (`slug` ASC),
  INDEX `id_entity` (`id_entity` ASC),
  INDEX `type` (`type` ASC),
  INDEX `date` (`create_at` ASC),
  INDEX `status_row` (`status_row` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `keypanel`.`news_comments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `keypanel`.`news_comments` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_parent` BIGINT(20) UNSIGNED NULL,
  `id_post` BIGINT(20) UNSIGNED NOT NULL,
  `id_entity` MEDIUMINT(6) NOT NULL,
  `content` TEXT NOT NULL,
  `approved` VARCHAR(45) NULL,
  `type` VARCHAR(20) NOT NULL,
  `create_at` DATETIME NULL DEFAULT NULL,
  `update_at` DATETIME NULL DEFAULT NULL,
  `status_row` ENUM('DELETED','ENABLED') NULL,
  PRIMARY KEY (`id`),
  INDEX `id_parent` (`id_parent` ASC),
  INDEX `id_post` (`id_post` ASC),
  INDEX `id_entity` (`id_entity` ASC),
  INDEX `type` (`type` ASC),
  INDEX `create_at` (`create_at` ASC),
  INDEX `status_row` (`status_row` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `keypanel`.`organization`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `keypanel`.`organization` (
  `id` MEDIUMINT(6) NOT NULL AUTO_INCREMENT,
  `id_parent` MEDIUMINT(6) NULL,
  `breadcrumb` TINYTEXT NOT NULL,
  `name` CHAR(100) NULL,
  `description` TINYTEXT NULL,
  `create_at` DATETIME NULL DEFAULT NULL,
  `update_at` DATETIME NULL DEFAULT NULL,
  `status_row` ENUM('DELETED','ENABLED') NULL DEFAULT 'ENABLED',
  PRIMARY KEY (`id`),
  INDEX `id_parent` (`id_parent` ASC),
  INDEX `breadcrumb` (`breadcrumb`(500) ASC),
  INDEX `status_row` (`status_row` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `keypanel`.`organization_profiles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `keypanel`.`organization_profiles` (
  `id` MEDIUMINT(6) NOT NULL AUTO_INCREMENT,
  `id_organization` MEDIUMINT(6) UNSIGNED NOT NULL,
  `id_entity` MEDIUMINT(6) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `id_organization`, `id_entity`),
  INDEX `id_organization` (`id_organization` ASC),
  INDEX `id_entity` (`id_entity` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `keypanel`.`entities_sessions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `keypanel`.`entities_sessions` (
  `id` VARCHAR(40) NOT NULL,
  `ip_address` VARCHAR(45) NOT NULL,
  `timestamp` INT(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` BLOB NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `keypanel`.`entities_membership`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `keypanel`.`entities_membership` (
  `id` MEDIUMINT(6) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `since` DATETIME NOT NULL,
  `until` DATETIME NOT NULL,
  `status_row` ENUM('DELETED','EXPIRED','ACTIVE','PENDING') NULL DEFAULT 'PENDING',
  PRIMARY KEY (`id`),
  INDEX `status_row` (`status_row` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `keypanel`.`entities_history`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `keypanel`.`entities_history` (
  `id` MEDIUMINT(6) NOT NULL AUTO_INCREMENT,
  `id_member` MEDIUMINT(6) NOT NULL,
  `id_profile` MEDIUMINT(6) NOT NULL,
  `create_at` DATETIME NULL DEFAULT NULL,
  `update_at` DATETIME NULL DEFAULT NULL,
  `status_row` ENUM('DELETED', 'ENABLED') NULL DEFAULT 'ENABLED',
  PRIMARY KEY (`id`),
  INDEX `id_member` (`id_member` ASC),
  INDEX `id_profile` (`id_profile` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `keypanel`.`categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `keypanel`.`categories` (
  `id` MEDIUMINT(6) NOT NULL AUTO_INCREMENT,
  `id_parent` MEDIUMINT(6) NULL,
  `breadcrumb` TINYTEXT NULL,
  `name` VARCHAR(45) NULL,
  `slug` CHAR(45) NOT NULL,
  `create_at` DATETIME NULL,
  `update_at` DATETIME NULL,
  `status_row` ENUM('DELETED', 'ENABLED') NULL DEFAULT 'ENABLED' COMMENT 'Indica el borrado logico\n',
  PRIMARY KEY (`id`, `slug`),
  UNIQUE INDEX `slug` (`slug` ASC),
  INDEX `id_parent` (`id_parent` ASC),
  INDEX `breadcrumb` (`breadcrumb`(500) ASC),
  INDEX `status_row` (`status_row` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `keypanel`.`entity_category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `keypanel`.`entity_category` (
  `id` MEDIUMINT(6) NOT NULL AUTO_INCREMENT,
  `id_category` MEDIUMINT(6) NOT NULL,
  `id_entity` MEDIUMINT(6) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `id_category` (`id_category` ASC),
  INDEX `id_entity` (`id_entity` ASC))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
