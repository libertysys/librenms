UPDATE `dbSchema` SET `version` = 166;# Fudge the db schema to update as this could take a while
ALTER TABLE `access_points` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `alert_map` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `alert_rules` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `alert_schedule` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `alert_schedule_items` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `alert_templates` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `alert_template_map` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `api_tokens` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `applications` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `bgpPeers` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `bgpPeers_cbgp` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `bills` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `bill_perms` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `bill_ports` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `bill_port_counters` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `callback` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `ciscoASA` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `config` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `customers` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `dashboards` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `dbSchema` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `devices_attribs` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `devices_perms` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `device_group_device` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `device_groups` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `device_mibs` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `device_oids` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `entPhysical` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `entPhysical_state` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `juniAtmVp` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `links` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `loadbalancer_rservers` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `loadbalancer_vservers` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `locations` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `mac_accounting` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `mibdefs` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `munin_plugins` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `munin_plugins_ds` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `netscaler_vservers` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `notifications` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `notifications_attribs` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `packages` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `plugins` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `poller_groups` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `pollers` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `port_association_mode` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `ports` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `ports_adsl` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `ports_perms` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `ports_statistics` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `ports_stp` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `ports_vlans` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `processes` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `proxmox` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `proxmox_ports` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `pseudowires` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `route` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `services` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `session` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `slas` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `storage` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `stp` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `alerts` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `toner` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `users` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `users_prefs` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `users_widgets` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `vlans` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `vminfo` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `vrf_lite_cisco` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `vrfs` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `widgets` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `alert_log` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `authlog` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `bill_data` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `bill_history` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `device_perf` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `syslog` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `access_points` CHANGE `name` `name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `type` `type` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `mac_addr` `mac_addr` VARCHAR(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `alert_map` CHANGE `target` `target` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '';
ALTER TABLE `alert_schedule` CHANGE `recurring_day` `recurring_day` VARCHAR(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `title` `title` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `notes` `notes` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `alert_schedule_items` CHANGE `target` `target` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `alert_templates` CHANGE `rule_id` `rule_id` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT ',', CHANGE `name` `name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `template` `template` LONGTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `title` `title` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `title_rec` `title_rec` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `api_tokens` CHANGE `token_hash` `token_hash` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `description` `description` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `applications` CHANGE `app_status` `app_status` VARCHAR(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `app_instance` `app_instance` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `bgpPeers` CHANGE `astext` `astext` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `bgpPeerIdentifier` `bgpPeerIdentifier` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `bgpPeerState` `bgpPeerState` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `bgpPeerAdminStatus` `bgpPeerAdminStatus` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `bgpLocalAddr` `bgpLocalAddr` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `bgpPeerRemoteAddr` `bgpPeerRemoteAddr` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `context_name` `context_name` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `alert_rules` CHANGE `device_id` `device_id` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '', CHANGE `rule` `rule` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `severity` `severity` ENUM('ok','warning','critical') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `extra` `extra` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `name` `name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `query` `query` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `proc` `proc` VARCHAR(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `bgpPeers_cbgp` CHANGE `bgpPeerIdentifier` `bgpPeerIdentifier` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `afi` `afi` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `safi` `safi` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `context_name` `context_name` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `bill_history` CHANGE `bill_type` `bill_type` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `dir_95th` `dir_95th` VARCHAR(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `bills` CHANGE `bill_name` `bill_name` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `bill_type` `bill_type` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `dir_95th` `dir_95th` VARCHAR(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `bill_custid` `bill_custid` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `bill_ref` `bill_ref` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `bill_notes` `bill_notes` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `callback` CHANGE `name` `name` CHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `value` `value` CHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `ciscoASA` CHANGE `oid` `oid` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `config` CHANGE `config_name` `config_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `config_value` `config_value` VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `config_default` `config_default` VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `config_descr` `config_descr` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `config_group` `config_group` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `config_sub_group` `config_sub_group` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `config_hidden` `config_hidden` ENUM('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0', CHANGE `config_disabled` `config_disabled` ENUM('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0';
ALTER TABLE `customers` CHANGE `username` `username` CHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `password` `password` CHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `string` `string` CHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `dashboards` CHANGE `dashboard_name` `dashboard_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `device_groups` CHANGE `name` `name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '', CHANGE `desc` `desc` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '', CHANGE `pattern` `pattern` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci, CHANGE `params` `params` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `device_mibs` CHANGE `module` `module` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `mib` `mib` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `included_by` `included_by` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `device_oids` CHANGE `oid` `oid` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `module` `module` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `mib` `mib` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `object_type` `object_type` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `value` `value` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `devices` CHANGE `hostname` `hostname` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `sysName` `sysName` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `snmpver` `snmpver` VARCHAR(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'v2c', CHANGE `bgpLocalAs` `bgpLocalAs` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `sysDescr` `sysDescr` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci, CHANGE `sysContact` `sysContact` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci, CHANGE `version` `version` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci, CHANGE `hardware` `hardware` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci, CHANGE `features` `features` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `devices_attribs` CHANGE `attrib_type` `attrib_type` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `attrib_value` `attrib_value` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `entPhysical` CHANGE `entPhysicalDescr` `entPhysicalDescr` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `entPhysicalClass` `entPhysicalClass` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `entPhysicalName` `entPhysicalName` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `entPhysicalHardwareRev` `entPhysicalHardwareRev` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `entPhysicalFirmwareRev` `entPhysicalFirmwareRev` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `entPhysicalSoftwareRev` `entPhysicalSoftwareRev` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `entPhysicalAlias` `entPhysicalAlias` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `entPhysicalAssetID` `entPhysicalAssetID` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `entPhysicalIsFRU` `entPhysicalIsFRU` VARCHAR(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `entPhysicalModelName` `entPhysicalModelName` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `entPhysicalVendorType` `entPhysicalVendorType` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci, CHANGE `entPhysicalSerialNum` `entPhysicalSerialNum` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `entPhysicalMfgName` `entPhysicalMfgName` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `entPhysical_state` CHANGE `entPhysicalIndex` `entPhysicalIndex` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `subindex` `subindex` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `group` `group` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `key` `key` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `value` `value` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `hrDevice` CHANGE `hrDeviceDescr` `hrDeviceDescr` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `hrDeviceType` `hrDeviceType` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `hrDeviceStatus` `hrDeviceStatus` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `ipv4_addresses` CHANGE `ipv4_address` `ipv4_address` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `ipv4_network_id` `ipv4_network_id` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `context_name` `context_name` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `ipv4_mac` CHANGE `mac_address` `mac_address` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `ipv4_address` `ipv4_address` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `context_name` `context_name` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `ipv4_networks` CHANGE `ipv4_network` `ipv4_network` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `context_name` `context_name` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `ipv6_addresses` CHANGE `ipv6_address` `ipv6_address` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `ipv6_compressed` `ipv6_compressed` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `ipv6_origin` `ipv6_origin` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `ipv6_network_id` `ipv6_network_id` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `context_name` `context_name` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `ipv6_networks` CHANGE `ipv6_network` `ipv6_network` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `context_name` `context_name` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `juniAtmVp` CHANGE `vp_descr` `vp_descr` VARCHAR(32) CHARACTER SET utf8  COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `links` CHANGE `protocol` `protocol` VARCHAR(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `remote_hostname` `remote_hostname` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `remote_port` `remote_port` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `remote_platform` `remote_platform` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `remote_version` `remote_version` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `loadbalancer_rservers` CHANGE `farm_id` `farm_id` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `StateDescr` `StateDescr` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `loadbalancer_vservers` CHANGE `classmap` `classmap` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `serverstate` `serverstate` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `locations` CHANGE `location` `location` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `mac_accounting` CHANGE `mac` `mac` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `in_oid` `in_oid` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `out_oid` `out_oid` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `mibdefs` CHANGE `module` `module` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `mib` `mib` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `object_type` `object_type` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `oid` `oid` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `syntax` `syntax` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `description` `description` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `max_access` `max_access` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `status` `status` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `included_by` `included_by` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `mempools` CHANGE `mempool_index` `mempool_index` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `mempool_type` `mempool_type` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `mempool_descr` `mempool_descr` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `munin_plugins` CHANGE `mplug_type` `mplug_type` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `mplug_instance` `mplug_instance` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `mplug_category` `mplug_category` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `mplug_title` `mplug_title` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `mplug_info` `mplug_info` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci, CHANGE `mplug_vlabel` `mplug_vlabel` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `mplug_args` `mplug_args` VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `munin_plugins_ds` CHANGE `ds_name` `ds_name` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `ds_type` `ds_type` ENUM('COUNTER','ABSOLUTE','DERIVE','GAUGE') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'GAUGE', CHANGE `ds_label` `ds_label` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `ds_cdef` `ds_cdef` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `ds_draw` `ds_draw` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `ds_graph` `ds_graph` ENUM('no','yes') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes', CHANGE `ds_info` `ds_info` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `ds_extinfo` `ds_extinfo` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `ds_max` `ds_max` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `ds_min` `ds_min` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `ds_negative` `ds_negative` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `ds_warning` `ds_warning` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `ds_critical` `ds_critical` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `ds_colour` `ds_colour` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `ds_sum` `ds_sum` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `ds_stack` `ds_stack` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `ds_line` `ds_line` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `notifications` CHANGE `title` `title` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '', CHANGE `body` `body` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `source` `source` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '', CHANGE `checksum` `checksum` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `notifications_attribs` CHANGE `key` `key` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '', CHANGE `value` `value` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '';
ALTER TABLE `ospf_areas` CHANGE `context_name` `context_name` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `ospf_instances` CHANGE `context_name` `context_name` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `ospf_nbrs` CHANGE `context_name` `context_name` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `ospf_ports` CHANGE `context_name` `context_name` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `packages` CHANGE `name` `name` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `manager` `manager` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1', CHANGE `version` `version` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `build` `build` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `arch` `arch` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `plugins` CHANGE `plugin_name` `plugin_name`VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `poller_groups` CHANGE `group_name` `group_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `descr` `descr` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `pollers` CHANGE `poller_name` `poller_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `port_association_mode` CHANGE `name` `name` VARCHAR(12) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `ports` CHANGE `port_descr_type` `port_descr_type` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `port_descr_descr` `port_descr_descr` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `port_descr_circuit` `port_descr_circuit` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `port_descr_speed` `port_descr_speed` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `port_descr_notes` `port_descr_notes` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `ifDescr` `ifDescr` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `ifName` `ifName` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `portName` `portName` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `ifConnectorPresent` `ifConnectorPresent` VARCHAR(12) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `ifPromiscuousMode` `ifPromiscuousMode` VARCHAR(12) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `ifOperStatus` `ifOperStatus` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `ifOperStatus_prev` `ifOperStatus_prev` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `ifAdminStatus` `ifAdminStatus` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `ifAdminStatus_prev` `ifAdminStatus_prev` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `ifDuplex` `ifDuplex` VARCHAR(12) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `ifType` `ifType` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci, CHANGE `ifAlias` `ifAlias` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci, CHANGE `ifPhysAddress` `ifPhysAddress` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci, CHANGE `ifHardType` `ifHardType` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `ifVlan` `ifVlan` VARCHAR(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '', CHANGE `ifTrunk` `ifTrunk` VARCHAR(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '', CHANGE `pagpOperationMode` `pagpOperationMode` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `pagpPortState` `pagpPortState` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `pagpPartnerDeviceId` `pagpPartnerDeviceId` VARCHAR(48) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `pagpPartnerLearnMethod` `pagpPartnerLearnMethod` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `pagpPartnerDeviceName` `pagpPartnerDeviceName` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `pagpEthcOperationMode` `pagpEthcOperationMode` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `pagpDeviceId` `pagpDeviceId` VARCHAR(48) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `ports_adsl` CHANGE `adslLineCoding` `adslLineCoding` VARCHAR(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `adslLineType` `adslLineType` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `adslAtucInvVendorID` `adslAtucInvVendorID` VARCHAR(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `adslAtucInvVersionNumber` `adslAtucInvVersionNumber` VARCHAR(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `adslAturInvSerialNumber` `adslAturInvSerialNumber` VARCHAR(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `adslAturInvVendorID` `adslAturInvVendorID` VARCHAR(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `adslAturInvVersionNumber` `adslAturInvVersionNumber` VARCHAR(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `ports_stp` CHANGE `state` `state` VARCHAR(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `enable` `enable` VARCHAR(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `designatedRoot` `designatedRoot` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `designatedBridge` `designatedBridge` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `ports_vlans` CHANGE `state` `state` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `processes` CHANGE `cputime` `cputime` VARCHAR(12) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `user` `user` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `command` `command` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `processors` CHANGE `processor_index` `processor_index` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `processor_descr` `processor_descr` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `proxmox` CHANGE `cluster` `cluster` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `description` `description` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `proxmox_ports` CHANGE `port` `port` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `pseudowires` CHANGE `pw_type` `pw_type` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `pw_psntype` `pw_psntype` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `pw_descr` `pw_descr` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `route` CHANGE `context_name` `context_name` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `ipRouteDest` `ipRouteDest` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `ipRouteIfIndex` `ipRouteIfIndex` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `ipRouteMetric` `ipRouteMetric` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `ipRouteNextHop` `ipRouteNextHop` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `ipRouteType` `ipRouteType` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `ipRouteProto` `ipRouteProto` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `ipRouteMask` `ipRouteMask` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `sensors` CHANGE `sensor_oid` `sensor_oid` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `sensor_type` `sensor_type` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `entPhysicalIndex` `entPhysicalIndex` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `entPhysicalIndex_measured` `entPhysicalIndex_measured` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `sensor_class` `sensor_class` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `services` CHANGE `service_ip` `service_ip` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `service_type` `service_type` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `service_desc` `service_desc` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `service_param` `service_param` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `service_message` `service_message` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `service_ds` `service_ds` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Data Sources available for this service';
ALTER TABLE `session` CHANGE `session_username` `session_username` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `session_value` `session_value` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `session_token` `session_token` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `session_auth` `session_auth` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `slas` CHANGE `owner` `owner` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `tag` `tag` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `rtt_type` `rtt_type` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `storage` CHANGE `storage_mib` `storage_mib` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `storage_type` `storage_type` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `storage_descr` `storage_descr` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `stp` CHANGE `bridgeAddress` `bridgeAddress` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `protocolSpecification` `protocolSpecification` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `timeSinceTopologyChange` `timeSinceTopologyChange` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `designatedRoot` `designatedRoot` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `toner` CHANGE `toner_type` `toner_type` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `toner_oid` `toner_oid` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `toner_descr` `toner_descr` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '', CHANGE `toner_capacity_oid` `toner_capacity_oid` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `ucd_diskio` CHANGE `diskio_descr` `diskio_descr` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `users` CHANGE `username` `username` CHAR(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `password` `password` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `realname` `realname` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `email` `email` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `descr` `descr` CHAR(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `twofactor` `twofactor` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `users_prefs` CHANGE `pref` `pref` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `value` `value` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `users_widgets` CHANGE `title` `title` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `settings` `settings` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `vlans` CHANGE `vlan_vlan` `vlan_vlan` INT(11) COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `vlan_type` `vlan_type` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `vlan_name` `vlan_name` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `vminfo` CHANGE `vm_type` `vm_type` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'vmware', CHANGE `vmwVmDisplayName` `vmwVmDisplayName` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `vmwVmGuestOS` `vmwVmGuestOS` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `vmwVmState` `vmwVmState` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `vrf_lite_cisco` CHANGE `context_name` `context_name` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `intance_name` `intance_name` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '', CHANGE `vrf_name` `vrf_name` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'Default';
ALTER TABLE `vrfs` CHANGE `vrf_oid` `vrf_oid` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `vrf_name` `vrf_name` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `mplsVpnVrfRouteDistinguisher` `mplsVpnVrfRouteDistinguisher` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `mplsVpnVrfDescription` `mplsVpnVrfDescription` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `widgets` CHANGE `widget_title` `widget_title` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `widget` `widget` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `base_dimensions` `base_dimensions` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `authlog` CHANGE `user` `user` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `address` `address` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `result` `result` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `eventlog` CHANGE `message` `message` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci, CHANGE `type` `type` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `reference` `reference` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `perf_times` CHANGE `type` `type` VARCHAR(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `doing` `doing` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `syslog` CHANGE `facility` `facility` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `priority` `priority` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `level` `level` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `tag` `tag` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `program` `program` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL, CHANGE `msg` `msg` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
