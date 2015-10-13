<?php

$exec['create_tables'] = array(
    0 => "DROP TABLE IF EXISTS `test_solr_a`",
    1 => "CREATE TABLE IF NOT EXISTS `test_solr_a` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `updated` (`updated`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1",
    2 => "DROP TABLE IF EXISTS `test_solr_b`",
    3 => "CREATE TABLE IF NOT EXISTS `test_solr_b` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `a_id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `a_id` (`a_id`),
  KEY `updated` (`updated`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;",
);

$exec['insert_solr_a'] = "INSERT INTO `test`.`test_solr_a` (`id`, `name`, `updated`) VALUES (NULL, UUID_SHORT(), NOW())";

$exec['insert_solr_b'] = "INSERT INTO `test`.`test_solr_b` (`id`, `a_id`, `name`, `updated`) VALUES (NULL, 1, UUID_SHORT(), NOW())";

$exec['update_solr_b'] = "UPDATE `test`.`test_solr_b` SET `name` = UUID_SHORT(), `updated` = NOW() WHERE id = ";

$exec['delete_solr_b'] = "DELETE FROM `test`.`test_solr_b` WHERE id = ";

$qry['test_solr_a'] = "SELECT * FROM `test_solr_a` ORDER BY updated DESC";

$qry['test_solr_b'] = "SELECT * FROM `test_solr_b` ORDER BY updated DESC";
