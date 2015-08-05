drop table organization_category;

CREATE TABLE `organization_category` (
  `id` mediumint(6) NOT NULL AUTO_INCREMENT,
  `id_parent` mediumint(6) default NULL,
  `breadcrumb` tinytext COLLATE latin1_spanish_ci,
  `name` varchar(45) COLLATE latin1_spanish_ci DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `status_row` enum('DELETED','ENABLED') COLLATE latin1_spanish_ci DEFAULT 'ENABLED' COMMENT 'Indica el borrado logico\n',
  PRIMARY KEY (`id`),
  KEY `id_parent` (`id_parent`),
  KEY `breadcrumb` (`breadcrumb`(500)),
  KEY `status_row` (`status_row`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

drop table organization_category;
CREATE TABLE `organization_category` (
  `id` mediumint(6) NOT NULL AUTO_INCREMENT,
  `id_parent` mediumint(6) DEFAULT NULL,
  `breadcrumb` tinytext COLLATE latin1_spanish_ci,
  `name` varchar(45) COLLATE latin1_spanish_ci DEFAULT NULL,
  `slug` CHAR(45) unique COLLATE 'latin1_spanish_ci' NOT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `status_row` enum('DELETED','ENABLED') COLLATE latin1_spanish_ci DEFAULT 'ENABLED' COMMENT 'Indica el borrado logico\n',
  PRIMARY KEY (`id`,`slug`),
  KEY `id_parent` (`id_parent`),
  KEY `breadcrumb` (`breadcrumb`(500)),
  KEY `status_row` (`status_row`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

