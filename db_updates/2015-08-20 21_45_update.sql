DROP TABLE IF EXISTS `faqs`;
CREATE TABLE IF NOT EXISTS `faqs` (
`id` mediumint(6) NOT NULL,
  `title` text COLLATE latin1_spanish_ci NOT NULL,
  `content` text COLLATE latin1_spanish_ci NOT NULL,
  `create_at` datetime NOT NULL,
  `update_at` datetime DEFAULT NULL,
  `status_row` enum('DELETED','ENABLED') COLLATE latin1_spanish_ci NOT NULL DEFAULT 'ENABLED'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

ALTER TABLE `faqs`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `faqs`
MODIFY `id` mediumint(6) NOT NULL AUTO_INCREMENT;