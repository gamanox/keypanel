DROP TABLE `keypanel`.`organization`, `keypanel`.`organization_profiles`;

ALTER TABLE `keypanel`.`entity_category` 
ENGINE = MyISAM , RENAME TO  `keypanel`.`entities_categories` ;

drop table entities;
CREATE TABLE `entities` (
  `id` mediumint(6) NOT NULL AUTO_INCREMENT,
  `id_parent` mediumint(6) default NULL,
  `breadcrumb` tinytext COLLATE latin1_spanish_ci DEFAULT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

ALTER TABLE `keypanel`.`entities_categories` 
ADD COLUMN `create_at` DATETIME NULL AFTER `id_entity`,
ADD COLUMN `update_at` DATETIME NULL DEFAULT NULL AFTER `create_at`,
ADD COLUMN `status_row` ENUM('DELETED','ENABLED') CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NULL DEFAULT 'ENABLED' COMMENT 'Indica el borrado lógico' AFTER `update_at`,
ADD INDEX `status_row` (`status_row` ASC);


ALTER TABLE `keypanel`.`entities_tags` 
ADD COLUMN `create_at` DATETIME NULL AFTER `id_entity`,
ADD COLUMN `update_at` DATETIME NULL DEFAULT NULL AFTER `create_at`,
ADD COLUMN `status_row` ENUM('DELETED','ENABLED') CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NULL DEFAULT 'ENABLED' COMMENT 'Indica el borrado lógico' AFTER `update_at`,
ADD INDEX `status_row` (`status_row` ASC);


ALTER TABLE `keypanel`.`entities_address` 
CHANGE COLUMN `country` `country` CHAR(100) CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NOT NULL ;

