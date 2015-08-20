ALTER TABLE `entities_contacts` 
ADD COLUMN `attachment` CHAR(40) NULL DEFAULT NULL AFTER `email_personal`;
