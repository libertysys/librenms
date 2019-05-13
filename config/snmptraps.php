<?php

/*
| !!!! DO NOT EDIT THIS FILE !!!!
|
| You can change settings by setting them in the environment or .env
| If there is something you need to change, but is not available as an environment setting,
| request an environment variable to be created upstream or send a pull request.
*/

return [
    'trap_handlers' => [
        'BGP4-MIB::bgpBackwardTransition' => \LibreNMS\Snmptrap\Handlers\BgpBackwardTransition::class,
        'BGP4-MIB::bgpEstablished' => \LibreNMS\Snmptrap\Handlers\BgpEstablished::class,
        'BGP4-V2-MIB-JUNIPER::jnxBgpM2BackwardTransition' => \LibreNMS\Snmptrap\Handlers\JnxBgpM2BackwardTransition::class,
        'BGP4-V2-MIB-JUNIPER::jnxBgpM2Established' => \LibreNMS\Snmptrap\Handlers\JnxBgpM2Established::class,
        'BRIDGE-MIB::newRoot' => \LibreNMS\Snmptrap\Handlers\BridgeNewRoot::class,
        'BRIDGE-MIB::topologyChange' => \LibreNMS\Snmptrap\Handlers\BridgeTopologyChanged::class,
        'CM-ALARM-MIB::cmNetworkElementAlmTrap' => \LibreNMS\Snmptrap\Handlers\AdvaNetworkElementAlmTrap::class,
        'CM-ALARM-MIB::cmSysAlmTrap' => \LibreNMS\Snmptrap\Handlers\AdvaSysAlmTrap::class,
        'CM-PERFORMANCE-MIB::cmEthernetAccPortThresholdCrossingAlert' => \LibreNMS\Snmptrap\Handlers\AdvaAccThresholdCrossingAlert::class,
        'CM-PERFORMANCE-MIB::cmEthernetNetPortThresholdCrossingAlert' => \LibreNMS\Snmptrap\Handlers\AdvaNetThresholdCrossingAlert::class,
        'CM-SYSTEM-MIB::cmAttributeValueChangeTrap' => \LibreNMS\Snmptrap\Handlers\AdvaAttributeChange::class,
        'CM-SYSTEM-MIB::cmObjectCreationTrap' => \LibreNMS\Snmptrap\Handlers\AdvaObjectCreation::class,
        'CM-SYSTEM-MIB::cmObjectDeletionTrap' => \LibreNMS\Snmptrap\Handlers\AdvaObjectDeletion::class,
        'CM-SYSTEM-MIB::cmSnmpDyingGaspTrap' => \LibreNMS\Snmptrap\Handlers\AdvaSnmpDyingGaspTrap::class,
        'CM-SYSTEM-MIB::cmStateChangeTrap' => \LibreNMS\Snmptrap\Handlers\AdvaStateChangeTrap::class,
        'ENTITY-MIB::entConfigChange' => \LibreNMS\Snmptrap\Handlers\EntityDatabaseConfigChanged::class,
        'EQUIPMENT-MIB::equipStatusTrap' => \LibreNMS\Snmptrap\Handlers\EquipStatusTrap::class,
        'FORTINET-CORE-MIB::fnTrapMemThreshold' => \LibreNMS\Snmptrap\Handlers\FnTrapMemThreshold::class,
        'FORTINET-FORTIGATE-MIB::fgTrapAvOversize' => \LibreNMS\Snmptrap\Handlers\FgTrapAvOversize::class,
        'FORTINET-FORTIGATE-MIB::fgTrapIpsAnomaly' => \LibreNMS\Snmptrap\Handlers\FgTrapIpsAnomaly::class,
        'FORTINET-FORTIGATE-MIB::fgTrapIpsPkgUpdate' => \LibreNMS\Snmptrap\Handlers\FgTrapIpsPkgUpdate::class,
        'FORTINET-FORTIGATE-MIB::fgTrapIpsSignature' => \LibreNMS\Snmptrap\Handlers\FgTrapIpsSignature::class,
        'FORTINET-FORTIGATE-MIB::fgTrapVpnTunDown' => \LibreNMS\Snmptrap\Handlers\FgTrapVpnTunDown::class,
        'FORTINET-FORTIGATE-MIB::fgTrapVpnTunUp' => \LibreNMS\Snmptrap\Handlers\FgTrapVpnTunUp::class,
        'FORTINET-FORTIMANAGER-FORTIANALYZER-MIB::fmTrapLogAlert' => \LibreNMS\Snmptrap\Handlers\FmTrapLogAlert::class,
        'FORTINET-FORTIMANAGER-FORTIANALYZER-MIB::fmTrapLogRateThreshold' => \LibreNMS\Snmptrap\Handlers\FmTrapLogRateThreshold::class,
        'IF-MIB::linkDown' => \LibreNMS\Snmptrap\Handlers\LinkDown::class,
        'IF-MIB::linkUp' => \LibreNMS\Snmptrap\Handlers\LinkUp::class,
        'JUNIPER-CFGMGMT-MIB::jnxCmCfgChange' => \LibreNMS\Snmptrap\Handlers\JnxCmCfgChange::class,
        'JUNIPER-DOM-MIB::jnxDomAlarmCleared' => \LibreNMS\Snmptrap\Handlers\JnxDomAlarmCleared::class,
        'JUNIPER-DOM-MIB::jnxDomAlarmSet' => \LibreNMS\Snmptrap\Handlers\JnxDomAlarmSet::class,
        'JUNIPER-DOM-MIB::jnxDomLaneAlarmCleared' => \LibreNMS\Snmptrap\Handlers\JnxDomLaneAlarmCleared::class,
        'JUNIPER-DOM-MIB::jnxDomLaneAlarmSet' => \LibreNMS\Snmptrap\Handlers\JnxDomLaneAlarmSet::class,
        'JUNIPER-LDP-MIB::jnxLdpLspDown' => \LibreNMS\Snmptrap\Handlers\JnxLdpLspDown::class,
        'JUNIPER-LDP-MIB::jnxLdpLspUp' => \LibreNMS\Snmptrap\Handlers\JnxLdpLspUp::class,
        'JUNIPER-LDP-MIB::jnxLdpSesDown' => \LibreNMS\Snmptrap\Handlers\JnxLdpSesDown::class,
        'JUNIPER-LDP-MIB::jnxLdpSesUp' => \LibreNMS\Snmptrap\Handlers\JnxLdpSesUp::class,
        'JUNIPER-VPN-MIB::jnxVpnIfDown' => \LibreNMS\Snmptrap\Handlers\JnxVpnIfDown::class,
        'JUNIPER-VPN-MIB::jnxVpnIfUp' => \LibreNMS\Snmptrap\Handlers\JnxVpnIfUp::class,
        'JUNIPER-VPN-MIB::jnxVpnPwDown' => \LibreNMS\Snmptrap\Handlers\JnxVpnPwDown::class,
        'JUNIPER-VPN-MIB::jnxVpnPwUp' => \LibreNMS\Snmptrap\Handlers\JnxVpnPwUp::class,
        'LOG-MIB::logTrap' => \LibreNMS\Snmptrap\Handlers\LogTrap::class,
        'MG-SNMP-UPS-MIB::upsmgUtilityFailure' => \LibreNMS\Snmptrap\Handlers\UpsmgUtilityFailure::class,
        'MG-SNMP-UPS-MIB::upsmgUtilityRestored' => \LibreNMS\Snmptrap\Handlers\UpsmgUtilityRestored::class,
        'NETGEAR-SMART-SWITCHING-MIB::failedUserLoginTrap' => \LibreNMS\Snmptrap\Handlers\FailedUserLogin::class,
        'NETGEAR-SWITCHING-MIB::failedUserLoginTrap' => \LibreNMS\Snmptrap\Handlers\FailedUserLogin::class,
        'PowerNet-MIB::outletOff' => \LibreNMS\Snmptrap\Handlers\ApcPduOutletOff::class,
        'PowerNet-MIB::outletOn' => \LibreNMS\Snmptrap\Handlers\ApcPduOutletOn::class,
        'PowerNet-MIB::outletReboot' => \LibreNMS\Snmptrap\Handlers\ApcPduOutletReboot::class,
        'RUCKUS-EVENT-MIB::ruckusEventAssocTrap' => \LibreNMS\Snmptrap\Handlers\RuckusAssocTrap::class,
        'RUCKUS-EVENT-MIB::ruckusEventDiassocTrap' => \LibreNMS\Snmptrap\Handlers\RuckusDiassocTrap::class,
        'RUCKUS-EVENT-MIB::ruckusEventSetErrorTrap' => \LibreNMS\Snmptrap\Handlers\RuckusSetError::class,
        'RUCKUS-SZ-EVENT-MIB::ruckusSZAPMiscEventTrap' => \LibreNMS\Snmptrap\Handlers\RuckusSzApMiscEvent::class,
        'RUCKUS-SZ-EVENT-MIB::ruckusSZAPFirmwareUpdatedTrap' => \LibreNMS\Snmptrap\Handlers\RuckusSzApFirmware::class,
        'RUCKUS-SZ-EVENT-MIB::ruckusSZAPConfUpdatedTrap' => \LibreNMS\Snmptrap\Handlers\RuckusSzApConf::class,
        'RUCKUS-SZ-EVENT-MIB::ruckusSZAPRebootTrap' => \LibreNMS\Snmptrap\Handlers\RuckusSzApReboot::class,
        'RUCKUS-SZ-EVENT-MIB::ruckusSZAPConnectedTrap' => \LibreNMS\Snmptrap\Handlers\RuckusSzApConnect::class,
        'RUCKUS-SZ-EVENT-MIB::ruckusSZUpgradeSuccessTrap' => \LibreNMS\Snmptrap\Handlers\RuckusSzUpgradeSuccess::class,
        'RUCKUS-SZ-EVENT-MIB::ruckusSZAPRadiusServerReachableTrap' => \LibreNMS\Snmptrap\Handlers\RuckusSzApRadiusReachable::class,
        'RUCKUS-SZ-EVENT-MIB::ruckusSZAPRadiusServerUnreachableTrap' => \LibreNMS\Snmptrap\Handlers\RuckusSzApRadiusUnreachable::class,
        'RUCKUS-SZ-EVENT-MIB::ruckusSZAPDisconnectedTrap' => \LibreNMS\Snmptrap\Handlers\RuckusSzApDisconn::class,
        'RUCKUS-SZ-EVENT-MIB::ruckusSZAPLostHeartbeatTrap' => \LibreNMS\Snmptrap\Handlers\RuckusSzApLostHeartbeat::class,
        'RUCKUS-SZ-EVENT-MIB::ruckusSZNodeBackToInServiceTrap' => \LibreNMS\Snmptrap\Handlers\RuckusNodeInService::class,
        'RUCKUS-SZ-EVENT-MIB::ruckusSZNodeRestartedTrap' => \LibreNMS\Snmptrap\Handlers\RuckusSzNodeRestart::class,
        'RUCKUS-SZ-EVENT-MIB::ruckusSZNodeShutdownTrap' => \LibreNMS\Snmptrap\Handlers\RuckusSzNodeShut::class,
        'RUCKUS-SZ-EVENT-MIB::ruckusSZClusterInMaintenanceStateTrap' => \LibreNMS\Snmptrap\Handlers\RuckusSzClusterInMaintenance::class,
        'RUCKUS-SZ-EVENT-MIB::ruckusSZClusterBackToInServiceTrap' => \LibreNMS\Snmptrap\Handlers\RuckusSzClusterInService::class,
        'RUCKUS-SZ-EVENT-MIB::ruckusSZBackupClusterSuccessTrap' => \LibreNMS\Snmptrap\Handlers\RuckusSzBackupClstrSuccess::class,
        'SNMPv2-MIB::authenticationFailure' => \LibreNMS\Snmptrap\Handlers\AuthenticationFailure::class,
        'SNMPv2-MIB::coldStart' => \LibreNMS\Snmptrap\Handlers\ColdBoot::class,
    ]
];
