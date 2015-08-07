ALTER TABLE `keypanel`.`news_posts` 
CHANGE COLUMN `status` `status` ENUM('PUBLISH', 'UNPUBLISHED') CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NULL DEFAULT 'UNPUBLISHED' ,
CHANGE COLUMN `slug` `slug` VARCHAR(200) CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NOT NULL ,
CHANGE COLUMN `type` `type` ENUM('POST') CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NULL DEFAULT 'POST' ;

ALTER TABLE `keypanel`.`news_posts` 
CHANGE COLUMN `comment_count` `comment_count` BIGINT(20) NULL DEFAULT 0 ;

ALTER TABLE `keypanel`.`news_posts` 
CHANGE COLUMN `status` `status` ENUM('PUBLISHED', 'UNPUBLISHED') CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NULL DEFAULT 'UNPUBLISHED' ;
