CREATE TABLE IF NOT EXISTS `toner` ( `toner_id` int(11) NOT NULL auto_increment, `device_id` int(11) NOT NULL default '0', `toner_index` int(11) NOT NULL, `toner_type` varchar(64) NOT NULL, `toner_oid` varchar(64) NOT NULL, `toner_descr` varchar(32) NOT NULL default '', `toner_capacity` int(11) NOT NULL default '0', `toner_current` int(11) NOT NULL default '0', PRIMARY KEY (`toner_id`), KEY `device_id` (`device_id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE  `mempools` CHANGE  `mempool_descr`  `mempool_descr` VARCHAR( 64 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE  `processors` CHANGE  `processor_descr`  `processor_descr` VARCHAR( 64 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
DROP TABLE `cempMemPool`;
DROP TABLE `cpmCPU`;
DROP TABLE `cmpMemPool`;
ALTER TABLE `mempools` CHANGE `mempool_used` `mempool_used` BIGINT( 16 ) NOT NULL ,CHANGE `mempool_free` `mempool_free` BIGINT( 16 ) NOT NULL ,CHANGE `mempool_total` `mempool_total` BIGINT( 16 ) NOT NULL ,CHANGE `mempool_largestfree` `mempool_largestfree` BIGINT( 16 ) NULL DEFAULT NULL ,CHANGE `mempool_lowestfree` `mempool_lowestfree` BIGINT( 16 ) NULL DEFAULT NULL ;
ALTER TABLE  `ports` ADD  `port_descr_type` VARCHAR( 32 ) NULL DEFAULT NULL AFTER  `device_id` ,ADD  `port_descr_descr` VARCHAR( 64 ) NULL DEFAULT NULL AFTER  `port_descr_type` ,ADD  `port_descr_circuit` VARCHAR( 64 ) NULL DEFAULT NULL AFTER  `port_descr_descr` ,ADD  `port_descr_speed` VARCHAR( 32 ) NULL DEFAULT NULL AFTER  `port_descr_circuit` ,ADD  `port_descr_notes` VARCHAR( 128 ) NULL DEFAULT NULL AFTER  `port_descr_speed`;
CREATE TABLE `frequency` ( `freq_id` int(11) NOT NULL auto_increment, `device_id` int(11) NOT NULL default '0', `freq_oid` varchar(64) NOT NULL, `freq_index` varchar(8) NOT NULL, `freq_type` varchar(32) NOT NULL, `freq_descr` varchar(32) NOT NULL default '', `freq_precision` int(11) NOT NULL default '1', `freq_current` float default NULL, `freq_limit` float default NULL, `freq_limit_low` float default NULL, PRIMARY KEY  (`freq_id`), KEY `freq_host` (`device_id`)) ENGINE=MyISAM AUTO_INCREMENT=189 DEFAULT CHARSET=latin1;
ALTER TABLE  `temperature` CHANGE  `temp_index`  `temp_index` int(11) NOT NULL;
CREATE TABLE `current` ( `current_id` int(11) NOT NULL auto_increment, `device_id` int(11) NOT NULL default '0', `current_oid` varchar(64) NOT NULL, `current_index` varchar(8) NOT NULL, `current_type` varchar(32) NOT NULL, `current_descr` varchar(32) NOT NULL default '', `current_precision` int(11) NOT NULL default '1', `current_current` float default NULL, `current_limit` float default NULL, `current_limit_warn` float default NULL, `current_limit_low` float default NULL, PRIMARY KEY  (`current_id`), KEY `current_host` (`device_id`)) ENGINE=MyISAM AUTO_INCREMENT=189 DEFAULT CHARSET=latin1;
