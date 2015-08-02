ALTER TABLE `entities_access_log` 
CHANGE COLUMN `browser` `browser` CHAR(200) CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NOT NULL COMMENT 'Se registrarán 10 logins por usuario, cuando el tamaño de acceso llegue al limite, se sobreescribirá el mas antiguo.' ;

ALTER TABLE `entities_address` 
CHANGE COLUMN `type` `type` ENUM('HOME', 'BUSINESS', 'POBOX') CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NULL DEFAULT 'BUSINESS' ;

ALTER TABLE `entities_address` 
CHANGE COLUMN `neighborhood` `neighborhood` CHAR(40) CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NOT NULL ;

ALTER TABLE `entities_contacts` 
CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT ;

ALTER TABLE `entities_contacts` 
CHANGE COLUMN `phone_personal` `phone_personal` CHAR(20) CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NULL ,
CHANGE COLUMN `phone_business` `phone_business` CHAR(20) CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NULL DEFAULT NULL ;

ALTER TABLE `entities_history` 
DROP FOREIGN KEY `fk_entities_history_entities2`,
DROP FOREIGN KEY `fk_entities_history_entities1`;
ALTER TABLE `entities_history` 
DROP INDEX `id_profile` ;

ALTER TABLE `entities_history` 
ADD INDEX `id_profile` (`id_profile` ASC);



