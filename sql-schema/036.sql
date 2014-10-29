<<<<<<< HEAD
DROP TABLE IF EXISTS `alerts`;
CREATE TABLE IF NOT EXISTS `alerts` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `device_id` int(11) NOT NULL,  `rule_id` int(11) NOT NULL,  `state` int(11) NOT NULL,  `alerted` int(11) NOT NULL,  `open` int(11) NOT NULL,  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `alert_log`;
CREATE TABLE IF NOT EXISTS `alert_log` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `rule_id` int(11) NOT NULL,  `device_id` int(11) NOT NULL,  `state` int(11) NOT NULL,  `details` longblob NOT NULL,  `time_logged` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,  PRIMARY KEY `id` (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `alert_rules`;
CREATE TABLE IF NOT EXISTS `alert_rules` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `device_id` int(11) NOT NULL,  `rule` text CHARACTER SET utf8 NOT NULL,  `severity` enum('ok','warning','critical') CHARACTER SET utf8 NOT NULL,  `extra` varchar(255) CHARACTER SET utf8 NOT NULL,  `disabled` tinyint(1) NOT NULL,  PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `alert_schedule`;
CREATE TABLE IF NOT EXISTS `alert_schedule` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `device_id` int(11) NOT NULL,  `start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',  `end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `alert_templates`;
CREATE TABLE IF NOT EXISTS `alert_templates` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `rule_id` varchar(255) NOT NULL DEFAULT ',',`name` varchar(255) NOT NULL,  `template` longtext NOT NULL,  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;
