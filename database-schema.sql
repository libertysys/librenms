--
-- Table structure for table `alerts`
--

DROP TABLE IF EXISTS `alerts`;
CREATE TABLE IF NOT EXISTS `alerts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `importance` int(11) NOT NULL DEFAULT '0',
  `device_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `time_logged` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `alerted` smallint(6) NOT NULL DEFAULT '0',
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

DROP TABLE IF EXISTS `applications`;
CREATE TABLE IF NOT EXISTS `applications` (
  `app_id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) NOT NULL,
  `app_type` varchar(64) NOT NULL,
  PRIMARY KEY (`app_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `authlog`
--

DROP TABLE IF EXISTS `authlog`;
CREATE TABLE IF NOT EXISTS `authlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` text NOT NULL,
  `address` text NOT NULL,
  `result` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bgpPeers`
--

DROP TABLE IF EXISTS `bgpPeers`;
CREATE TABLE IF NOT EXISTS `bgpPeers` (
  `bgpPeer_id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) NOT NULL,
  `astext` varchar(64) NOT NULL,
  `bgpPeerIdentifier` text NOT NULL,
  `bgpPeerRemoteAs` int(11) NOT NULL,
  `bgpPeerState` text NOT NULL,
  `bgpPeerAdminStatus` text NOT NULL,
  `bgpLocalAddr` text NOT NULL,
  `bgpPeerRemoteAddr` text NOT NULL,
  `bgpPeerInUpdates` int(11) NOT NULL,
  `bgpPeerOutUpdates` int(11) NOT NULL,
  `bgpPeerInTotalMessages` int(11) NOT NULL,
  `bgpPeerOutTotalMessages` int(11) NOT NULL,
  `bgpPeerFsmEstablishedTime` int(11) NOT NULL,
  `bgpPeerInUpdateElapsedTime` int(11) NOT NULL,
  PRIMARY KEY (`bgpPeer_id`),
  KEY `device_id` (`device_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bgpPeers_cbgp`
--

DROP TABLE IF EXISTS `bgpPeers_cbgp`;
CREATE TABLE IF NOT EXISTS `bgpPeers_cbgp` (
  `device_id` int(11) NOT NULL,
  `bgpPeerIdentifier` varchar(64) NOT NULL,
  `afi` varchar(16) NOT NULL,
  `safi` varchar(16) NOT NULL,
  KEY `device_id` (`device_id`,`bgpPeerIdentifier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

DROP TABLE IF EXISTS `bills`;
CREATE TABLE IF NOT EXISTS `bills` (
  `bill_id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_name` text NOT NULL,
  `bill_type` text NOT NULL,
  `bill_cdr` int(11) DEFAULT NULL,
  `bill_day` int(11) NOT NULL DEFAULT '1',
  `bill_gb` int(11) DEFAULT NULL,
  `rate_95th_in` int(11) NOT NULL,
  `rate_95th_out` int(11) NOT NULL,
  `rate_95th` int(11) NOT NULL,
  `dir_95th` varchar(3) NOT NULL,
  `total_data` int(11) NOT NULL,
  `total_data_in` int(11) NOT NULL,
  `total_data_out` int(11) NOT NULL,
  `rate_average_in` int(11) NOT NULL,
  `rate_average_out` int(11) NOT NULL,
  `rate_average` int(11) NOT NULL,
  `bill_last_calc` datetime NOT NULL,
  `bill_custid` varchar(64) NOT NULL,
  `bill_ref` varchar(64) NOT NULL,
  `bill_notes` varchar(256) NOT NULL,
  `bill_autoadded` tinyint(1) NOT NULL,
  UNIQUE KEY `bill_id` (`bill_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
-- --------------------------------------------------------

--
-- Table structure for table `bill_data`
--

DROP TABLE IF EXISTS `bill_data`;
CREATE TABLE IF NOT EXISTS `bill_data` (
  `bill_id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `period` int(11) NOT NULL,
  `delta` bigint(11) NOT NULL,
  `in_delta` bigint(11) NOT NULL,
  `out_delta` bigint(11) NOT NULL,
  KEY `bill_id` (`bill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bill_perms`
--

DROP TABLE IF EXISTS `bill_perms`;
CREATE TABLE IF NOT EXISTS `bill_perms` (
  `user_id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bill_ports`
--

DROP TABLE IF EXISTS `bill_ports`;
CREATE TABLE IF NOT EXISTS `bill_ports` (
  `bill_id` int(11) NOT NULL,
  `port_id` int(11) NOT NULL,
  `bill_port_autoadded` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cef_switching`
--

DROP TABLE IF EXISTS `cef_switching`;
CREATE TABLE IF NOT EXISTS `cef_switching` (
  `cef_switching_id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) NOT NULL,
  `entPhysicalIndex` int(11) NOT NULL,
  `afi` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `cef_index` int(11) NOT NULL,
  `cef_path` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `drop` int(11) NOT NULL,
  `punt` int(11) NOT NULL,
  `punt2host` int(11) NOT NULL,
  `drop_prev` int(11) NOT NULL,
  `punt_prev` int(11) NOT NULL,
  `punt2host_prev` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `updated_prev` int(11) NOT NULL,
  PRIMARY KEY (`cef_switching_id`),
  UNIQUE KEY `device_id` (`device_id`,`entPhysicalIndex`,`afi`,`cef_index`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(64) NOT NULL,
  `password` char(32) NOT NULL,
  `string` char(64) NOT NULL,
  `level` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dbSchema`
--

DROP TABLE IF EXISTS `dbSchema`;
CREATE TABLE IF NOT EXISTS `dbSchema` (
  `revision` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`revision`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

DROP TABLE IF EXISTS `devices`;
CREATE TABLE IF NOT EXISTS `devices` (
  `device_id` int(11) NOT NULL AUTO_INCREMENT,
  `hostname` varchar(128) CHARACTER SET latin1 NOT NULL,
  `sysName` varchar(128) CHARACTER SET latin1 DEFAULT NULL,
  `community` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `snmpver` varchar(4) CHARACTER SET latin1 NOT NULL DEFAULT 'v2c',
  `port` smallint(5) unsigned NOT NULL DEFAULT '161',
  `transport` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'udp',
  `timeout` int(11) DEFAULT NULL,
  `retries` int(11) DEFAULT NULL,
  `bgpLocalAs` varchar(16) CHARACTER SET latin1 DEFAULT NULL,
  `sysDescr` text CHARACTER SET latin1,
  `sysContact` text CHARACTER SET latin1,
  `version` text CHARACTER SET latin1,
  `hardware` text CHARACTER SET latin1,
  `features` text CHARACTER SET latin1,
  `location` text COLLATE utf8_unicode_ci,
  `os` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `ignore` tinyint(4) NOT NULL DEFAULT '0',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `uptime` bigint(20) DEFAULT NULL,
  `agent_uptime` int(11) NOT NULL,
  `last_polled` timestamp NULL DEFAULT NULL,
  `last_polled_timetaken` double(5,2) DEFAULT NULL,
  `last_discovered_timetaken` double(5,2) DEFAULT NULL,
  `last_discovered` timestamp NULL DEFAULT NULL,
  `purpose` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `serial` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`device_id`),
  KEY `status` (`status`),
  KEY `hostname` (`hostname`),
  KEY `sysName` (`sysName`),
  KEY `os` (`os`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `devices_attribs`
--

DROP TABLE IF EXISTS `devices_attribs`;
CREATE TABLE IF NOT EXISTS `devices_attribs` (
  `attrib_id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) NOT NULL,
  `attrib_type` varchar(32) NOT NULL,
  `attrib_value` text NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`attrib_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `devices_perms`
--

DROP TABLE IF EXISTS `devices_perms`;
CREATE TABLE IF NOT EXISTS `devices_perms` (
  `user_id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  `access_level` int(4) NOT NULL DEFAULT '0',
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `device_graphs`
--

DROP TABLE IF EXISTS `device_graphs`;
CREATE TABLE IF NOT EXISTS `device_graphs` (
  `device_id` int(11) NOT NULL,
  `graph` varchar(32) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `entPhysical`
--

DROP TABLE IF EXISTS `entPhysical`;
CREATE TABLE IF NOT EXISTS `entPhysical` (
  `entPhysical_id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) NOT NULL,
  `entPhysicalIndex` int(11) NOT NULL,
  `entPhysicalDescr` text NOT NULL,
  `entPhysicalClass` text NOT NULL,
  `entPhysicalName` text NOT NULL,
  `entPhysicalHardwareRev` varchar(64) DEFAULT NULL,
  `entPhysicalFirmwareRev` varchar(64) DEFAULT NULL,
  `entPhysicalSoftwareRev` varchar(64) DEFAULT NULL,
  `entPhysicalAlias` varchar(32) DEFAULT NULL,
  `entPhysicalAssetID` varchar(32) DEFAULT NULL,
  `entPhysicalIsFRU` varchar(8) DEFAULT NULL,
  `entPhysicalModelName` text NOT NULL,
  `entPhysicalVendorType` text,
  `entPhysicalSerialNum` text NOT NULL,
  `entPhysicalContainedIn` int(11) NOT NULL,
  `entPhysicalParentRelPos` int(11) NOT NULL,
  `entPhysicalMfgName` text NOT NULL,
  `ifIndex` int(11) DEFAULT NULL,
  PRIMARY KEY (`entPhysical_id`),
  KEY `device_id` (`device_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `eventlog`
--

DROP TABLE IF EXISTS `eventlog`;
CREATE TABLE IF NOT EXISTS `eventlog` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `host` int(11) NOT NULL DEFAULT '0',
  `datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `message` text CHARACTER SET latin1,
  `type` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
  `reference` varchar(64) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`event_id`),
  KEY `host` (`host`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `graph_types`
--

DROP TABLE IF EXISTS `graph_types`;
CREATE TABLE IF NOT EXISTS `graph_types` (
  `graph_type` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `graph_subtype` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `graph_section` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `graph_descr` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `graph_order` int(11) NOT NULL,
  KEY `graph_type` (`graph_type`),
  KEY `graph_subtype` (`graph_subtype`),
  KEY `graph_section` (`graph_section`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `graph_types_dead`
--

DROP TABLE IF EXISTS `graph_types_dead`;
CREATE TABLE IF NOT EXISTS `graph_types_dead` (
  `graph_type` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `graph_subtype` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `graph_section` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `graph_descr` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `graph_order` int(11) NOT NULL,
  KEY `graph_type` (`graph_type`),
  KEY `graph_subtype` (`graph_subtype`),
  KEY `graph_section` (`graph_section`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrDevice`
--

DROP TABLE IF EXISTS `hrDevice`;
CREATE TABLE IF NOT EXISTS `hrDevice` (
  `hrDevice_id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) NOT NULL,
  `hrDeviceIndex` int(11) NOT NULL,
  `hrDeviceDescr` text CHARACTER SET latin1 NOT NULL,
  `hrDeviceType` text CHARACTER SET latin1 NOT NULL,
  `hrDeviceErrors` int(11) NOT NULL,
  `hrDeviceStatus` text CHARACTER SET latin1 NOT NULL,
  `hrProcessorLoad` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`hrDevice_id`),
  KEY `device_id` (`device_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ipv4_addresses`
--

DROP TABLE IF EXISTS `ipv4_addresses`;
CREATE TABLE IF NOT EXISTS `ipv4_addresses` (
  `ipv4_address_id` int(11) NOT NULL AUTO_INCREMENT,
  `ipv4_address` varchar(32) CHARACTER SET latin1 NOT NULL,
  `ipv4_prefixlen` int(11) NOT NULL,
  `ipv4_network_id` varchar(32) CHARACTER SET latin1 NOT NULL,
  `interface_id` int(11) NOT NULL,
  PRIMARY KEY (`ipv4_address_id`),
  KEY `interface_id` (`interface_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ipv4_mac`
--

DROP TABLE IF EXISTS `ipv4_mac`;
CREATE TABLE IF NOT EXISTS `ipv4_mac` (
  `interface_id` int(11) NOT NULL,
  `mac_address` varchar(32) CHARACTER SET latin1 NOT NULL,
  `ipv4_address` varchar(32) CHARACTER SET latin1 NOT NULL,
  KEY `interface_id` (`interface_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ipv4_networks`
--

DROP TABLE IF EXISTS `ipv4_networks`;
CREATE TABLE IF NOT EXISTS `ipv4_networks` (
  `ipv4_network_id` int(11) NOT NULL AUTO_INCREMENT,
  `ipv4_network` varchar(64) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`ipv4_network_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ipv6_addresses`
--

DROP TABLE IF EXISTS `ipv6_addresses`;
CREATE TABLE IF NOT EXISTS `ipv6_addresses` (
  `ipv6_address_id` int(11) NOT NULL AUTO_INCREMENT,
  `ipv6_address` varchar(128) CHARACTER SET latin1 NOT NULL,
  `ipv6_compressed` varchar(128) CHARACTER SET latin1 NOT NULL,
  `ipv6_prefixlen` int(11) NOT NULL,
  `ipv6_origin` varchar(16) CHARACTER SET latin1 NOT NULL,
  `ipv6_network_id` varchar(128) CHARACTER SET latin1 NOT NULL,
  `interface_id` int(11) NOT NULL,
  PRIMARY KEY (`ipv6_address_id`),
  KEY `interface_id` (`interface_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ipv6_networks`
--

DROP TABLE IF EXISTS `ipv6_networks`;
CREATE TABLE IF NOT EXISTS `ipv6_networks` (
  `ipv6_network_id` int(11) NOT NULL AUTO_INCREMENT,
  `ipv6_network` varchar(64) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`ipv6_network_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `juniAtmVp`
--

DROP TABLE IF EXISTS `juniAtmVp`;
CREATE TABLE IF NOT EXISTS `juniAtmVp` (
  `juniAtmVp_id` int(11) NOT NULL,
  `interface_id` int(11) NOT NULL,
  `vp_id` int(11) NOT NULL,
  `vp_descr` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

DROP TABLE IF EXISTS `links`;
CREATE TABLE IF NOT EXISTS `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `local_interface_id` int(11) DEFAULT NULL,
  `remote_interface_id` int(11) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `protocol` varchar(11) DEFAULT NULL,
  `remote_hostname` varchar(128) NOT NULL,
  `remote_port` varchar(128) NOT NULL,
  `remote_platform` varchar(128) NOT NULL,
  `remote_version` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `src_if` (`local_interface_id`),
  KEY `dst_if` (`remote_interface_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mac_accounting`
--

DROP TABLE IF EXISTS `mac_accounting`;
CREATE TABLE IF NOT EXISTS `mac_accounting` (
  `ma_id` int(11) NOT NULL AUTO_INCREMENT,
  `interface_id` int(11) NOT NULL,
  `mac` varchar(32) NOT NULL,
  `in_oid` varchar(128) NOT NULL,
  `out_oid` varchar(128) NOT NULL,
  `bps_out` int(11) NOT NULL,
  `bps_in` int(11) NOT NULL,
  `cipMacHCSwitchedBytes_input` bigint(20) DEFAULT NULL,
  `cipMacHCSwitchedBytes_input_prev` bigint(20) DEFAULT NULL,
  `cipMacHCSwitchedBytes_input_delta` bigint(20) DEFAULT NULL,
  `cipMacHCSwitchedBytes_input_rate` int(11) DEFAULT NULL,
  `cipMacHCSwitchedBytes_output` bigint(20) DEFAULT NULL,
  `cipMacHCSwitchedBytes_output_prev` bigint(20) DEFAULT NULL,
  `cipMacHCSwitchedBytes_output_delta` bigint(20) DEFAULT NULL,
  `cipMacHCSwitchedBytes_output_rate` int(11) DEFAULT NULL,
  `cipMacHCSwitchedPkts_input` bigint(20) DEFAULT NULL,
  `cipMacHCSwitchedPkts_input_prev` bigint(20) DEFAULT NULL,
  `cipMacHCSwitchedPkts_input_delta` bigint(20) DEFAULT NULL,
  `cipMacHCSwitchedPkts_input_rate` int(11) DEFAULT NULL,
  `cipMacHCSwitchedPkts_output` bigint(20) DEFAULT NULL,
  `cipMacHCSwitchedPkts_output_prev` bigint(20) DEFAULT NULL,
  `cipMacHCSwitchedPkts_output_delta` bigint(20) DEFAULT NULL,
  `cipMacHCSwitchedPkts_output_rate` int(11) DEFAULT NULL,
  `poll_time` int(11) DEFAULT NULL,
  `poll_prev` int(11) DEFAULT NULL,
  `poll_period` int(11) DEFAULT NULL,
  PRIMARY KEY (`ma_id`),
  KEY `interface_id` (`interface_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mempools`
--

DROP TABLE IF EXISTS `mempools`;
CREATE TABLE IF NOT EXISTS `mempools` (
  `mempool_id` int(11) NOT NULL AUTO_INCREMENT,
  `mempool_index` varchar(16) CHARACTER SET latin1 NOT NULL,
  `entPhysicalIndex` int(11) DEFAULT NULL,
  `hrDeviceIndex` int(11) DEFAULT NULL,
  `mempool_type` varchar(32) CHARACTER SET latin1 NOT NULL,
  `mempool_precision` int(11) NOT NULL DEFAULT '1',
  `mempool_descr` varchar(64) CHARACTER SET latin1 NOT NULL,
  `device_id` int(11) NOT NULL,
  `mempool_perc` int(11) NOT NULL,
  `mempool_used` bigint(16) NOT NULL,
  `mempool_free` bigint(16) NOT NULL,
  `mempool_total` bigint(16) NOT NULL,
  `mempool_largestfree` bigint(16) DEFAULT NULL,
  `mempool_lowestfree` bigint(16) DEFAULT NULL,
  PRIMARY KEY (`mempool_id`),
  KEY `device_id` (`device_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ospf_areas`
--

DROP TABLE IF EXISTS `ospf_areas`;
CREATE TABLE IF NOT EXISTS `ospf_areas` (
  `device_id` int(11) NOT NULL,
  `ospfAreaId` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfAuthType` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `ospfImportAsExtern` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `ospfSpfRuns` int(11) NOT NULL,
  `ospfAreaBdrRtrCount` int(11) NOT NULL,
  `ospfAsBdrRtrCount` int(11) NOT NULL,
  `ospfAreaLsaCount` int(11) NOT NULL,
  `ospfAreaLsaCksumSum` int(11) NOT NULL,
  `ospfAreaSummary` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `ospfAreaStatus` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `device_area` (`device_id`,`ospfAreaId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ospf_instances`
--

DROP TABLE IF EXISTS `ospf_instances`;
CREATE TABLE IF NOT EXISTS `ospf_instances` (
  `device_id` int(11) NOT NULL,
  `ospf_instance_id` int(11) NOT NULL,
  `ospfRouterId` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfAdminStat` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfVersionNumber` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfAreaBdrRtrStatus` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfASBdrRtrStatus` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfExternLsaCount` int(11) NOT NULL,
  `ospfExternLsaCksumSum` int(11) NOT NULL,
  `ospfTOSSupport` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfOriginateNewLsas` int(11) NOT NULL,
  `ospfRxNewLsas` int(11) NOT NULL,
  `ospfExtLsdbLimit` int(11) DEFAULT NULL,
  `ospfMulticastExtensions` int(11) DEFAULT NULL,
  `ospfExitOverflowInterval` int(11) DEFAULT NULL,
  `ospfDemandExtensions` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  UNIQUE KEY `device_id` (`device_id`,`ospf_instance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ospf_nbrs`
--

DROP TABLE IF EXISTS `ospf_nbrs`;
CREATE TABLE IF NOT EXISTS `ospf_nbrs` (
  `device_id` int(11) NOT NULL,
  `interface_id` int(11) NOT NULL,
  `ospf_nbr_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfNbrIpAddr` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfNbrAddressLessIndex` int(11) NOT NULL,
  `ospfNbrRtrId` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfNbrOptions` int(11) NOT NULL,
  `ospfNbrPriority` int(11) NOT NULL,
  `ospfNbrState` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfNbrEvents` int(11) NOT NULL,
  `ospfNbrLsRetransQLen` int(11) NOT NULL,
  `ospfNbmaNbrStatus` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfNbmaNbrPermanence` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfNbrHelloSuppressed` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `device_id` (`device_id`,`ospf_nbr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ospf_ports`
--

DROP TABLE IF EXISTS `ospf_ports`;
CREATE TABLE IF NOT EXISTS `ospf_ports` (
  `device_id` int(11) NOT NULL,
  `interface_id` int(11) NOT NULL,
  `ospf_port_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfIfIpAddress` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfAddressLessIf` int(11) NOT NULL,
  `ospfIfAreaId` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfIfType` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ospfIfAdminStat` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ospfIfRtrPriority` int(11) DEFAULT NULL,
  `ospfIfTransitDelay` int(11) DEFAULT NULL,
  `ospfIfRetransInterval` int(11) DEFAULT NULL,
  `ospfIfHelloInterval` int(11) DEFAULT NULL,
  `ospfIfRtrDeadInterval` int(11) DEFAULT NULL,
  `ospfIfPollInterval` int(11) DEFAULT NULL,
  `ospfIfState` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ospfIfDesignatedRouter` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ospfIfBackupDesignatedRouter` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ospfIfEvents` int(11) DEFAULT NULL,
  `ospfIfAuthKey` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ospfIfStatus` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ospfIfMulticastForwarding` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ospfIfDemand` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ospfIfAuthType` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  UNIQUE KEY `device_id` (`device_id`,`ospf_port_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `perf_times`
--

DROP TABLE IF EXISTS `perf_times`;
CREATE TABLE IF NOT EXISTS `perf_times` (
  `type` varchar(8) CHARACTER SET latin1 NOT NULL,
  `doing` varchar(64) CHARACTER SET latin1 NOT NULL,
  `start` int(11) NOT NULL,
  `duration` double(8,2) NOT NULL,
  `devices` int(11) NOT NULL,
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ports`
--

DROP TABLE IF EXISTS `ports`;
CREATE TABLE IF NOT EXISTS `ports` (
  `interface_id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) NOT NULL DEFAULT '0',
  `port_descr_type` varchar(255) DEFAULT NULL,
  `port_descr_descr` varchar(255) DEFAULT NULL,
  `port_descr_circuit` varchar(255) DEFAULT NULL,
  `port_descr_speed` varchar(32) DEFAULT NULL,
  `port_descr_notes` varchar(255) DEFAULT NULL,
  `ifDescr` varchar(255) DEFAULT NULL,
  `ifName` varchar(64) DEFAULT NULL,
  `portName` varchar(128) DEFAULT NULL,
  `ifIndex` int(11) DEFAULT '0',
  `ifSpeed` bigint(20) DEFAULT NULL,
  `ifConnectorPresent` varchar(12) DEFAULT NULL,
  `ifPromiscuousMode` varchar(12) DEFAULT NULL,
  `ifHighSpeed` int(11) DEFAULT NULL,
  `ifOperStatus` varchar(16) DEFAULT NULL,
  `ifAdminStatus` varchar(16) DEFAULT NULL,
  `ifDuplex` varchar(12) DEFAULT NULL,
  `ifMtu` int(11) DEFAULT NULL,
  `ifType` text,
  `ifAlias` text,
  `ifPhysAddress` text,
  `ifHardType` varchar(64) DEFAULT NULL,
  `ifLastChange` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ifVlan` varchar(8) NOT NULL DEFAULT '',
  `ifTrunk` varchar(8) DEFAULT '',
  `ifVrf` int(11) NOT NULL,
  `counter_in` int(11) DEFAULT NULL,
  `counter_out` int(11) DEFAULT NULL,
  `ignore` tinyint(1) NOT NULL DEFAULT '0',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `detailed` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `pagpOperationMode` varchar(32) DEFAULT NULL,
  `pagpPortState` varchar(16) DEFAULT NULL,
  `pagpPartnerDeviceId` varchar(48) DEFAULT NULL,
  `pagpPartnerLearnMethod` varchar(16) DEFAULT NULL,
  `pagpPartnerIfIndex` int(11) DEFAULT NULL,
  `pagpPartnerGroupIfIndex` int(11) DEFAULT NULL,
  `pagpPartnerDeviceName` varchar(128) DEFAULT NULL,
  `pagpEthcOperationMode` varchar(16) DEFAULT NULL,
  `pagpDeviceId` varchar(48) DEFAULT NULL,
  `pagpGroupIfIndex` int(11) DEFAULT NULL,
  `ifInUcastPkts` bigint(20) DEFAULT NULL,
  `ifInUcastPkts_prev` bigint(20) DEFAULT NULL,
  `ifInUcastPkts_delta` bigint(20) DEFAULT NULL,
  `ifInUcastPkts_rate` int(11) DEFAULT NULL,
  `ifOutUcastPkts` bigint(20) DEFAULT NULL,
  `ifOutUcastPkts_prev` bigint(20) DEFAULT NULL,
  `ifOutUcastPkts_delta` bigint(20) DEFAULT NULL,
  `ifOutUcastPkts_rate` int(11) DEFAULT NULL,
  `ifInErrors` bigint(20) DEFAULT NULL,
  `ifInErrors_prev` bigint(20) DEFAULT NULL,
  `ifInErrors_delta` bigint(20) DEFAULT NULL,
  `ifInErrors_rate` int(11) DEFAULT NULL,
  `ifOutErrors` bigint(20) DEFAULT NULL,
  `ifOutErrors_prev` bigint(20) DEFAULT NULL,
  `ifOutErrors_delta` bigint(20) DEFAULT NULL,
  `ifOutErrors_rate` int(11) DEFAULT NULL,
  `ifInOctets` bigint(20) DEFAULT NULL,
  `ifInOctets_prev` bigint(20) DEFAULT NULL,
  `ifInOctets_delta` bigint(20) DEFAULT NULL,
  `ifInOctets_rate` int(11) DEFAULT NULL,
  `ifOutOctets` bigint(20) DEFAULT NULL,
  `ifOutOctets_prev` bigint(20) DEFAULT NULL,
  `ifOutOctets_delta` bigint(20) DEFAULT NULL,
  `ifOutOctets_rate` int(11) DEFAULT NULL,
  `poll_time` int(11) DEFAULT NULL,
  `poll_prev` int(11) DEFAULT NULL,
  `poll_period` int(11) DEFAULT NULL,
  PRIMARY KEY (`interface_id`),
  UNIQUE KEY `device_ifIndex` (`device_id`,`ifIndex`),
  KEY `if_2` (`ifDescr`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ports_adsl`
--

DROP TABLE IF EXISTS `ports_adsl`;
CREATE TABLE IF NOT EXISTS `ports_adsl` (
  `interface_id` int(11) NOT NULL,
  `port_adsl_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `adslLineCoding` varchar(8) COLLATE utf8_bin NOT NULL,
  `adslLineType` varchar(16) COLLATE utf8_bin NOT NULL,
  `adslAtucInvVendorID` varchar(8) COLLATE utf8_bin NOT NULL,
  `adslAtucInvVersionNumber` varchar(8) COLLATE utf8_bin NOT NULL,
  `adslAtucCurrSnrMgn` decimal(5,1) NOT NULL,
  `adslAtucCurrAtn` decimal(5,1) NOT NULL,
  `adslAtucCurrOutputPwr` decimal(5,1) NOT NULL,
  `adslAtucCurrAttainableRate` int(11) NOT NULL,
  `adslAtucChanCurrTxRate` int(11) NOT NULL,
  `adslAturInvSerialNumber` varchar(8) COLLATE utf8_bin NOT NULL,
  `adslAturInvVendorID` varchar(8) COLLATE utf8_bin NOT NULL,
  `adslAturInvVersionNumber` varchar(8) COLLATE utf8_bin NOT NULL,
  `adslAturChanCurrTxRate` int(11) NOT NULL,
  `adslAturCurrSnrMgn` decimal(5,1) NOT NULL,
  `adslAturCurrAtn` decimal(5,1) NOT NULL,
  `adslAturCurrOutputPwr` decimal(5,1) NOT NULL,
  `adslAturCurrAttainableRate` int(11) NOT NULL,
  UNIQUE KEY `interface_id` (`interface_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `ports_perms`
--

DROP TABLE IF EXISTS `ports_perms`;
CREATE TABLE IF NOT EXISTS `ports_perms` (
  `user_id` int(11) NOT NULL,
  `interface_id` int(11) NOT NULL,
  `access_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ports_stack`
--

DROP TABLE IF EXISTS `ports_stack`;
CREATE TABLE IF NOT EXISTS `ports_stack` (
  `device_id` int(11) NOT NULL,
  `interface_id_high` int(11) NOT NULL,
  `interface_id_low` int(11) NOT NULL,
  `ifStackStatus` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `device_id` (`device_id`,`interface_id_high`,`interface_id_low`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `port_in_measurements`
--

DROP TABLE IF EXISTS `port_in_measurements`;
CREATE TABLE IF NOT EXISTS `port_in_measurements` (
  `port_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `counter` bigint(11) NOT NULL,
  `delta` bigint(11) NOT NULL,
  KEY `port_id` (`port_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `port_out_measurements`
--

DROP TABLE IF EXISTS `port_out_measurements`;
CREATE TABLE IF NOT EXISTS `port_out_measurements` (
  `port_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `counter` bigint(11) NOT NULL,
  `delta` bigint(11) NOT NULL,
  KEY `port_id` (`port_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `processors`
--

DROP TABLE IF EXISTS `processors`;
CREATE TABLE IF NOT EXISTS `processors` (
  `processor_id` int(11) NOT NULL AUTO_INCREMENT,
  `entPhysicalIndex` int(11) NOT NULL,
  `hrDeviceIndex` int(11) DEFAULT NULL,
  `device_id` int(11) NOT NULL,
  `processor_oid` varchar(128) CHARACTER SET latin1 NOT NULL,
  `processor_index` varchar(32) CHARACTER SET latin1 NOT NULL,
  `processor_type` varchar(16) CHARACTER SET latin1 NOT NULL,
  `processor_usage` int(11) NOT NULL,
  `processor_descr` varchar(64) CHARACTER SET latin1 NOT NULL,
  `processor_precision` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`processor_id`),
  KEY `device_id` (`device_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pseudowires`
--

DROP TABLE IF EXISTS `pseudowires`;
CREATE TABLE IF NOT EXISTS `pseudowires` (
  `pseudowire_id` int(11) NOT NULL AUTO_INCREMENT,
  `interface_id` int(11) NOT NULL,
  `peer_device_id` int(11) NOT NULL,
  `peer_ldp_id` int(11) NOT NULL,
  `cpwVcID` int(11) NOT NULL,
  `cpwOid` int(11) NOT NULL,
  PRIMARY KEY (`pseudowire_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sensors`
--

DROP TABLE IF EXISTS `sensors`;
CREATE TABLE IF NOT EXISTS `sensors` (
  `sensor_id` int(11) NOT NULL AUTO_INCREMENT,
  `sensor_class` varchar(64) CHARACTER SET latin1 NOT NULL,
  `device_id` int(11) NOT NULL DEFAULT '0',
  `poller_type` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'snmp',
  `sensor_oid` varchar(64) CHARACTER SET latin1 NOT NULL,
  `sensor_index` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `sensor_type` varchar(255) CHARACTER SET latin1 NOT NULL,
  `sensor_descr` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sensor_divisor` int(11) NOT NULL DEFAULT '1',
  `sensor_multiplier` int(11) NOT NULL DEFAULT '1',
  `sensor_current` float DEFAULT NULL,
  `sensor_limit` float DEFAULT NULL,
  `sensor_limit_warn` float DEFAULT NULL,
  `sensor_limit_low` float DEFAULT NULL,
  `sensor_limit_low_warn` float DEFAULT NULL,
  `entPhysicalIndex` varchar(16) CHARACTER SET latin1 DEFAULT NULL,
  `entPhysicalIndex_measured` varchar(16) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`sensor_id`),
  KEY `sensor_host` (`device_id`),
  KEY `sensor_class` (`sensor_class`),
  KEY `sensor_type` (`sensor_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) NOT NULL,
  `service_ip` text NOT NULL,
  `service_type` varchar(16) NOT NULL,
  `service_desc` text NOT NULL,
  `service_param` text NOT NULL,
  `service_ignore` tinyint(1) NOT NULL,
  `service_status` tinyint(4) NOT NULL DEFAULT '0',
  `service_checked` int(11) NOT NULL DEFAULT '0',
  `service_changed` int(11) NOT NULL DEFAULT '0',
  `service_message` text NOT NULL,
  `service_disabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`service_id`),
  KEY `service_host` (`device_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `storage`
--

DROP TABLE IF EXISTS `storage`;
CREATE TABLE IF NOT EXISTS `storage` (
  `storage_id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) NOT NULL,
  `storage_mib` varchar(16) NOT NULL,
  `storage_index` int(11) NOT NULL,
  `storage_type` varchar(32) DEFAULT NULL,
  `storage_descr` text NOT NULL,
  `storage_size` bigint(20) NOT NULL,
  `storage_units` int(11) NOT NULL,
  `storage_used` bigint(20) NOT NULL,
  `storage_free` bigint(20) NOT NULL,
  `storage_perc` text NOT NULL,
  `storage_perc_warn` int(11) DEFAULT '60',
  PRIMARY KEY (`storage_id`),
  KEY `device_id` (`device_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `syslog`
--

DROP TABLE IF EXISTS `syslog`;
CREATE TABLE IF NOT EXISTS `syslog` (
  `device_id` int(11) DEFAULT NULL,
  `facility` varchar(10) DEFAULT NULL,
  `priority` varchar(10) DEFAULT NULL,
  `level` varchar(10) DEFAULT NULL,
  `tag` varchar(10) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `program` varchar(32) DEFAULT NULL,
  `msg` text,
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`seq`),
  KEY `datetime` (`timestamp`),
  KEY `device_id` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `toner`
--

DROP TABLE IF EXISTS `toner`;
CREATE TABLE IF NOT EXISTS `toner` (
  `toner_id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) NOT NULL DEFAULT '0',
  `toner_index` int(11) NOT NULL,
  `toner_type` varchar(64) NOT NULL,
  `toner_oid` varchar(64) NOT NULL,
  `toner_descr` varchar(32) NOT NULL DEFAULT '',
  `toner_capacity` int(11) NOT NULL DEFAULT '0',
  `toner_current` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`toner_id`),
  KEY `device_id` (`device_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ucd_diskio`
--

DROP TABLE IF EXISTS `ucd_diskio`;
CREATE TABLE IF NOT EXISTS `ucd_diskio` (
  `diskio_id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) NOT NULL,
  `diskio_index` int(11) NOT NULL,
  `diskio_descr` varchar(32) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`diskio_id`),
  KEY `device_id` (`device_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(30) NOT NULL,
  `password` varchar(34) DEFAULT NULL,
  `realname` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `descr` char(30) NOT NULL,
  `level` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_prefs`
--

DROP TABLE IF EXISTS `users_prefs`;
CREATE TABLE IF NOT EXISTS `users_prefs` (
  `user_id` int(16) NOT NULL,
  `pref` varchar(32) NOT NULL,
  `value` varchar(128) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id.pref` (`user_id`,`pref`),
  KEY `pref` (`pref`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vlans`
--

DROP TABLE IF EXISTS `vlans`;
CREATE TABLE IF NOT EXISTS `vlans` (
  `vlan_id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) DEFAULT NULL,
  `vlan_vlan` int(11) DEFAULT NULL,
  `vlan_domain` text,
  `vlan_descr` text,
  PRIMARY KEY (`vlan_id`),
  KEY `device_id` (`device_id`,`vlan_vlan`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vminfo`
--

DROP TABLE IF EXISTS `vminfo`;
CREATE TABLE IF NOT EXISTS `vminfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) NOT NULL,
  `vm_type` varchar(16) NOT NULL DEFAULT 'vmware',
  `vmwVmVMID` int(11) NOT NULL,
  `vmwVmDisplayName` varchar(128) NOT NULL,
  `vmwVmGuestOS` varchar(128) NOT NULL,
  `vmwVmMemSize` int(11) NOT NULL,
  `vmwVmCpus` int(11) NOT NULL,
  `vmwVmState` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `device_id` (`device_id`),
  KEY `vmwVmVMID` (`vmwVmVMID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vmware_vminfo`
--

DROP TABLE IF EXISTS `vmware_vminfo`;
CREATE TABLE IF NOT EXISTS `vmware_vminfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) NOT NULL,
  `vmwVmVMID` int(11) NOT NULL,
  `vmwVmDisplayName` varchar(128) NOT NULL,
  `vmwVmGuestOS` varchar(128) NOT NULL,
  `vmwVmMemSize` int(11) NOT NULL,
  `vmwVmCpus` int(11) NOT NULL,
  `vmwVmState` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `device_id` (`device_id`),
  KEY `vmwVmVMID` (`vmwVmVMID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vrfs`
--

DROP TABLE IF EXISTS `vrfs`;
CREATE TABLE IF NOT EXISTS `vrfs` (
  `vrf_id` int(11) NOT NULL AUTO_INCREMENT,
  `vrf_oid` varchar(256) NOT NULL,
  `vrf_name` varchar(128) DEFAULT NULL,
  `mplsVpnVrfRouteDistinguisher` varchar(128) DEFAULT NULL,
  `mplsVpnVrfDescription` text NOT NULL,
  `device_id` int(11) NOT NULL,
  PRIMARY KEY (`vrf_id`),
  KEY `device_id` (`device_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `bill_history`
--

CREATE TABLE IF NOT EXISTS `bill_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) NOT NULL,
  `bill_datefrom` datetime NOT NULL,
  `bill_dateto` datetime NOT NULL,
  `bill_type` text NOT NULL,
  `bill_allowed` int(11) NOT NULL,
  `bill_used` int(11) NOT NULL,
  `bill_overuse` int(11) NOT NULL,
  `bill_percent` DECIMAL(5,2) NOT NULL,
  `rate_95th_in` int(11) NOT NULL,
  `rate_95th_out` int(11) NOT NULL,
  `rate_95th` int(11) NOT NULL,
  `dir_95th` varchar(3) NOT NULL,
  `rate_average` int(11) NOT NULL,
  `rate_average_in` int(11) NOT NULL,
  `rate_average_out` int(11) NOT NULL,
  `traf_in` int(11) NOT NULL,
  `traf_out` int(11) NOT NULL,
  `traf_total` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bill_id` (`bill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `entPhysical_state` (  `device_id` int(11) NOT NULL,  `entPhysicalIndex` varchar(64) NOT NULL,  `subindex` varchar(64) DEFAULT NULL,  `group` varchar(64) NOT NULL,  `key` varchar(64) NOT NULL,  `value` varchar(255) NOT NULL,  KEY `device_id_index` (`device_id`,`entPhysicalIndex`)) ENGINE=MyISAM DEFAULT CHARSET=latin1;

