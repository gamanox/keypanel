ALTER TABLE `entities` 
CHANGE COLUMN `status_row` `status_row` ENUM('DELETED', 'ENABLED', 'DISABLED') CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NULL DEFAULT 'ENABLED' COMMENT 'Indica el borrado lógico' ,
DROP INDEX `breadcrumb` ;

ALTER TABLE `entities` 
ADD INDEX `breadcrumb` (`breadcrumb`(500) ASC);
