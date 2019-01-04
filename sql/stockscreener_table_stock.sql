
-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `ticker` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `industry_group` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `region` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `trend` int(5) DEFAULT NULL,
  `lowphase` int(1) DEFAULT '0',
  `branche` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `stock` ADD `comment` TEXT NULL AFTER `timing`;
ALTER TABLE `stock` ADD `filter` INT(5) NULL AFTER `watchlist`;
ALTER TABLE `stock` ADD `description` VARCHAR(256) NULL DEFAULT NULL AFTER `name`;
ALTER TABLE `stock` ADD `extrating` INT(4) NULL AFTER `description`;
