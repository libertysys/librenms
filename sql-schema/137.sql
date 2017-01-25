INSERT INTO `config` (`config_name`, `config_value`, `config_default`, `config_descr`, `config_group`, `config_group_order`, `config_sub_group`, `config_sub_group_order`, `config_hidden`, `config_disabled`) VALUES('webui.availability_map_box_size', '165', '165', 'Input desired tile width in pixels for box size in full view', 'webui', 0, 'graph', 0, '0', '0');
UPDATE `config` SET `config_hidden` = '0', `config_descr` = 'Sort devices and services by status'  WHERE `config_name` = 'webui.availability_map_sort_status';
UPDATE `config` SET `config_descr` = 'Enable usage of dynamic device groups filter' WHERE `config_name` = 'webui.availability_map_use_device_groups';
UPDATE `config` SET `config_name` = 'webui.availability_map_compact', `config_hidden` = '0' WHERE `config_name` = 'webui.old_availability_map';
