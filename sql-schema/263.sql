ALTER TABLE `access_points` CHANGE `channel` `channel` tinyint(3) unsigned NOT NULL DEFAULT '0' ;
ALTER TABLE `bill_data` CHANGE `delta` `delta` bigint(20) NOT NULL ;
ALTER TABLE `bill_data` CHANGE `in_delta` `in_delta` bigint(20) NOT NULL ;
ALTER TABLE `bill_data` CHANGE `out_delta` `out_delta` bigint(20) NOT NULL ;
ALTER TABLE `component` CHANGE `id` `id` int(10) unsigned NOT NULL auto_increment;
ALTER TABLE `component` CHANGE `device_id` `device_id` int(10) unsigned NOT NULL ;
ALTER TABLE `component_prefs` CHANGE `id` `id` int(10) unsigned NOT NULL auto_increment;
ALTER TABLE `component_prefs` CHANGE `component` `component` int(10) unsigned NOT NULL ;
ALTER TABLE `component_statuslog` CHANGE `id` `id` int(10) unsigned NOT NULL auto_increment;
ALTER TABLE `component_statuslog` CHANGE `component_id` `component_id` int(10) unsigned NOT NULL ;
ALTER TABLE `dashboards` CHANGE `access` `access` tinyint(1) NOT NULL DEFAULT '0' ;
ALTER TABLE `devices` CHANGE `device_id` `device_id` int(10) unsigned NOT NULL auto_increment;
ALTER TABLE `devices` CHANGE `status` `status` tinyint(1) NOT NULL DEFAULT '0' ;
ALTER TABLE `devices` CHANGE `ignore` `ignore` tinyint(1) NOT NULL DEFAULT '0' ;
ALTER TABLE `devices_perms` DROP `access_level`;
ALTER TABLE `device_groups` CHANGE `id` `id` int(10) unsigned NOT NULL auto_increment;
ALTER TABLE `device_perf` CHANGE `id` `id` int(10) unsigned NOT NULL auto_increment;
ALTER TABLE `device_perf` CHANGE `xmt` `xmt` int(11) NOT NULL ;
ALTER TABLE `device_perf` CHANGE `rcv` `rcv` int(11) NOT NULL ;
ALTER TABLE `device_perf` CHANGE `loss` `loss` int(11) NOT NULL ;
ALTER TABLE `device_perf` CHANGE `min` `min` double(8,2) NOT NULL ;
ALTER TABLE `device_perf` CHANGE `max` `max` double(8,2) NOT NULL ;
ALTER TABLE `device_perf` CHANGE `avg` `avg` double(8,2) NOT NULL ;
ALTER TABLE `device_perf` ADD PRIMARY KEY (`id`);
ALTER TABLE `device_perf` DROP INDEX `id`;
ALTER TABLE `device_relationships` CHANGE `parent_device_id` `parent_device_id` int(10) unsigned NOT NULL DEFAULT '0' ;
ALTER TABLE `device_relationships` CHANGE `child_device_id` `child_device_id` int(10) unsigned NOT NULL ;
ALTER TABLE `eventlog` CHANGE `severity` `severity` tinyint(4) NULL DEFAULT '2' ;
ALTER TABLE `ipv4_addresses` DROP INDEX `interface_id_2`;
ALTER TABLE `ipv6_addresses` DROP INDEX `interface_id_2`;
ALTER TABLE `links` CHANGE `active` `active` tinyint(1) NOT NULL DEFAULT '1' ;
ALTER TABLE `locations` CHANGE `lat` `lat` double(10,6) NOT NULL ;
ALTER TABLE `locations` CHANGE `lng` `lng` double(10,6) NOT NULL ;
ALTER TABLE `locations` ADD PRIMARY KEY (`id`);
ALTER TABLE `locations` DROP INDEX `id`;
ALTER TABLE `mefinfo` CHANGE `mefID` `mefID` int(11) NOT NULL ;
ALTER TABLE `mefinfo` CHANGE `mefMTU` `mefMTU` int(11) NOT NULL DEFAULT '1500' ;
ALTER TABLE `mempools` CHANGE `mempool_used` `mempool_used` bigint(20) NOT NULL ;
ALTER TABLE `mempools` CHANGE `mempool_free` `mempool_free` bigint(20) NOT NULL ;
ALTER TABLE `mempools` CHANGE `mempool_total` `mempool_total` bigint(20) NOT NULL ;
ALTER TABLE `mempools` CHANGE `mempool_largestfree` `mempool_largestfree` bigint(20) NULL ;
ALTER TABLE `mempools` CHANGE `mempool_lowestfree` `mempool_lowestfree` bigint(20) NULL ;
ALTER TABLE `munin_plugins` CHANGE `mplug_total` `mplug_total` tinyint(1) NOT NULL DEFAULT '0' ;
ALTER TABLE `munin_plugins` CHANGE `mplug_graph` `mplug_graph` tinyint(1) NOT NULL DEFAULT '1' ;
ALTER TABLE `netscaler_vservers` CHANGE `vsvr_port` `vsvr_port` int(11) NOT NULL ;
ALTER TABLE `ports_fdb` CHANGE `port_id` `port_id` int(10) unsigned NOT NULL ;
ALTER TABLE `poller_cluster_stats` CHANGE `depth` `depth` int(10) unsigned NOT NULL ;
ALTER TABLE `poller_cluster_stats` CHANGE `devices` `devices` int(10) unsigned NOT NULL ;
ALTER TABLE `poller_cluster_stats` CHANGE `workers` `workers` int(10) unsigned NOT NULL ;
ALTER TABLE `poller_cluster_stats` CHANGE `frequency` `frequency` int(10) unsigned NOT NULL ;
ALTER TABLE `ports_fdb` CHANGE `vlan_id` `vlan_id` int(10) unsigned NOT NULL ;
ALTER TABLE `ports_fdb` CHANGE `device_id` `device_id` int(10) unsigned NOT NULL ;
ALTER TABLE `ports_perms` DROP `access_level`;
ALTER TABLE `ports_vlans` CHANGE `priority` `priority` bigint(20) NOT NULL ;
ALTER TABLE `ports_vlans` CHANGE `untagged` `untagged` tinyint(1) NOT NULL DEFAULT '0' ;
ALTER TABLE `processes` CHANGE `pid` `pid` int(11) NOT NULL ;
ALTER TABLE `processes` CHANGE `vsz` `vsz` int(11) NOT NULL ;
ALTER TABLE `processes` CHANGE `rss` `rss` int(11) NOT NULL ;
ALTER TABLE `processors` DROP INDEX `device_id_2`;
ALTER TABLE `route` CHANGE `ipRouteDest` `ipRouteDest` varchar(39) NOT NULL ;
ALTER TABLE `route` CHANGE `ipRouteNextHop` `ipRouteNextHop` varchar(39) NOT NULL ;
ALTER TABLE `sensors` CHANGE `device_id` `device_id` int(10) unsigned NOT NULL DEFAULT '0' ;
ALTER TABLE `sensors` CHANGE `sensor_current` `sensor_current` double NULL ;
ALTER TABLE `sensors` CHANGE `sensor_limit` `sensor_limit` double NULL ;
ALTER TABLE `sensors` CHANGE `sensor_limit_warn` `sensor_limit_warn` double NULL ;
ALTER TABLE `sensors` CHANGE `sensor_limit_low` `sensor_limit_low` double NULL ;
ALTER TABLE `sensors` CHANGE `sensor_limit_low_warn` `sensor_limit_low_warn` double NULL ;
ALTER TABLE `sensors` CHANGE `sensor_prev` `sensor_prev` double NULL ;
ALTER TABLE `state_translations` CHANGE `state_value` `state_value` smallint(6) NOT NULL DEFAULT '0' ;
ALTER TABLE `storage` DROP INDEX `device_id_2`;
ALTER TABLE `tnmsneinfo` CHANGE `neID` `neID` int(11) NOT NULL ;
ALTER TABLE `ucd_diskio` DROP INDEX `device_id_2`;
ALTER TABLE `users` CHANGE `can_modify_passwd` `can_modify_passwd` tinyint(1) NOT NULL DEFAULT '1' ;
ALTER TABLE `users_prefs` CHANGE `user_id` `user_id` int(11) NOT NULL ;
ALTER TABLE `users_prefs` DROP INDEX `user_id.pref`;
ALTER TABLE `users_prefs` ADD UNIQUE `users_prefs_user_id_pref_unique` (`user_id`,`pref`);
ALTER TABLE `wireless_sensors` CHANGE `device_id` `device_id` int(10) unsigned NOT NULL DEFAULT '0' ;
ALTER TABLE `wireless_sensors` CHANGE `sensor_current` `sensor_current` double NULL ;
ALTER TABLE `wireless_sensors` CHANGE `sensor_prev` `sensor_prev` double NULL ;
ALTER TABLE `wireless_sensors` CHANGE `sensor_limit` `sensor_limit` double NULL ;
ALTER TABLE `wireless_sensors` CHANGE `sensor_limit_warn` `sensor_limit_warn` double NULL ;
ALTER TABLE `wireless_sensors` CHANGE `sensor_limit_low` `sensor_limit_low` double NULL ;
ALTER TABLE `wireless_sensors` CHANGE `sensor_limit_low_warn` `sensor_limit_low_warn` double NULL ;
ALTER TABLE `pollers` MODIFY `id` int(11) NOT NULL;
ALTER TABLE `pollers` DROP INDEX `id`;
ALTER TABLE `pollers` DROP INDEX `PRIMARY`;
ALTER TABLE `pollers` ADD PRIMARY KEY (`id`);
ALTER TABLE `pollers` MODIFY `id` int(11) NOT NULL auto_increment;
ALTER TABLE `pollers` ADD UNIQUE `poller_name` (`poller_name`);
ALTER TABLE `poller_cluster` MODIFY `id` int(11) NOT NULL;
ALTER TABLE `poller_cluster` DROP INDEX `id`;
ALTER TABLE `poller_cluster` DROP INDEX `PRIMARY`;
ALTER TABLE `poller_cluster` ADD PRIMARY KEY (`id`);
ALTER TABLE `poller_cluster` MODIFY `id` int(11) NOT NULL auto_increment;
ALTER TABLE `poller_cluster` ADD UNIQUE `poller_cluster_node_id_unique` (`node_id`);
ALTER TABLE `poller_cluster_stats` MODIFY `id` int(11) NOT NULL;
ALTER TABLE `poller_cluster_stats` DROP INDEX `id`;
ALTER TABLE `poller_cluster_stats` DROP INDEX `PRIMARY`;
ALTER TABLE `poller_cluster_stats` ADD PRIMARY KEY (`id`);
ALTER TABLE `poller_cluster_stats` MODIFY `id` int(11) NOT NULL auto_increment;
ALTER TABLE `poller_cluster_stats` ADD UNIQUE `parent_poller_poller_type` (`parent_poller`, `poller_type`);
ALTER TABLE `poller_cluster_stats` CHANGE `parent_poller` `parent_poller` int(11) NOT NULL DEFAULT 0 ;
ALTER TABLE `poller_cluster_stats` CHANGE `poller_type` `poller_type` varchar(64) NOT NULL DEFAULT '' ;

