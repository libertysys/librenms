ALTER TABLE `alert_rules` ADD `query_builder` TEXT NOT NULL AFTER `query`;
CREATE TABLE `alert_group_map` (`id` INT PRIMARY KEY AUTO_INCREMENT, `rule_id` INT NOT NULL, `group_id` INT NOT NULL);
CREATE UNIQUE INDEX `alert_group_map_rule_id_group_id_uindex` ON `alert_group_map` (`rule_id`, `group_id`);
INSERT INTO `alert_group_map` (`rule_id`, `group_id`) SELECT `rule`, SUBSTRING(`target`, 2) as `group_id` FROM `alert_map` WHERE `target` LIKE 'g%';
DELETE FROM `alert_map` WHERE `target` LIKE 'g%';
ALTER TABLE `alert_map` CHANGE `rule` `rule_id` INT(11) NOT NULL;
ALTER TABLE `alert_map` CHANGE `target` `device_id` INT(11) NOT NULL;
ALTER TABLE `alert_map` RENAME TO `alert_device_map`;
CREATE UNIQUE INDEX `alert_device_map_rule_id_device_id_uindex` ON `alert_device_map` (`rule_id`, `device_id`);
INSERT INTO `alert_device_map` (`rule_id`, `device_id`) SELECT `id`, `device_id` FROM `alert_rules` WHERE `device_id` != -1;
ALTER TABLE `alert_rules` DROP COLUMN `device_id`;
