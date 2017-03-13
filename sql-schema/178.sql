CREATE TABLE IF NOT EXISTS `tnmsneinfo` ( 
`id` int(11) NOT NULL AUTO_INCREMENT,
`device_id` int(11) NOT NULL,
`neID` int(32) NOT NULL,
`neType` varchar(128) NOT NULL,
`neName` varchar(128) NOT NULL,
`neLocation` varchar(128) NOT NULL,
`neAlarm` varchar(128) NOT NULL,
`neOpMode` varchar(128) NOT NULL,
`neOpState` varchar(128) NOT NULL,
PRIMARY KEY (`id`),
KEY `device_id` (`device_id`),
KEY `neID` (`neID`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;
