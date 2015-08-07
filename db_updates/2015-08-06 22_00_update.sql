ALTER TABLE `keypanel`.`entities_address` 
CHANGE COLUMN `city` `city` CHAR(40) CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NOT NULL ;

drop table tags;
CREATE TABLE `tags` (
  `id` mediumint(6) NOT NULL AUTO_INCREMENT,
  `id_parent` mediumint(6) DEFAULT NULL,
  `breadcrumb` tinytext COLLATE latin1_spanish_ci DEFAULT NULL,
  `name` char(45) COLLATE latin1_spanish_ci NOT NULL,
  `slug` char(45) COLLATE latin1_spanish_ci NOT NULL,
  `count_search` mediumint(6) NOT NULL DEFAULT 0,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `status_row` enum('DELETED','ENABLED') COLLATE latin1_spanish_ci DEFAULT 'ENABLED' COMMENT 'Indica el borrado lógico',
  PRIMARY KEY (`id`,`slug`),
  UNIQUE KEY `slug` (`slug`),
  KEY `id_parent` (`id_parent`),
  KEY `breadcrumb` (`breadcrumb`(500)),
  KEY `count_search` (`count_search`),
  KEY `status_row` (`status_row`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;