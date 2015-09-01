ALTER TABLE `entities` 
CHANGE COLUMN `status_row` `status_row` ENUM('DELETED', 'ENABLED', 'DISABLED','REGISTERED') CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NULL DEFAULT 'ENABLED' COMMENT 'Indica el borrado lógico' ,
DROP INDEX `breadcrumb` ;

ALTER TABLE `entities` 
ADD INDEX `breadcrumb` (`breadcrumb`(500) ASC);


CREATE TABLE `keypanel`.`tokens` (
  `id` MEDIUMINT NOT NULL AUTO_INCREMENT,
  `id_entity` MEDIUMINT NOT NULL,
  `token` VARCHAR(32) NOT NULL,
  `create_at` DATETIME NULL,
  `update_at` DATETIME NULL,
  `expires_at` DATETIME NULL,
  `status_row` ENUM('DELETED', 'ENABLED', 'USED') NULL DEFAULT 'ENABLED',
  PRIMARY KEY (`id`),
  INDEX `id_entity` (`id_entity` ASC),
  INDEX `token` (`token` ASC),
  INDEX `create_at` (`create_at` ASC),
  INDEX `expires_at` (`expires_at` ASC),
  INDEX `status_row` (`status_row` ASC))
ENGINE = MyISAM;
