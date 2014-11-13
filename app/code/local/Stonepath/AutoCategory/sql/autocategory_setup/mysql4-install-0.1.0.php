<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT

CREATE TABLE `stonepath_autocategory_rules` (
  `rule_id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_id` int(11) NOT NULL,
  `attribute_option_value` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`rule_id`),
  KEY `attribute_id` (`attribute_id`),
  KEY `attribute_option_value` (`attribute_option_value`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

SQLTEXT;

$installer->run($sql);
/*

* PHP INSTALL CODE

*/
$installer->endSetup();
	 