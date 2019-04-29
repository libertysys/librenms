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
        'SNMPv2-MIB::authenticationFailure' => \LibreNMS\Snmptrap\Handlers\AuthenticationFailure::class,
        'BGP4-MIB::bgpEstablished' => \LibreNMS\Snmptrap\Handlers\BgpEstablished::class,
        'BGP4-MIB::bgpBackwardTransition' => \LibreNMS\Snmptrap\Handlers\BgpBackwardTransition::class,
        'IF-MIB::linkUp' => \LibreNMS\Snmptrap\Handlers\LinkUp::class,
        'IF-MIB::linkDown' => \LibreNMS\Snmptrap\Handlers\LinkDown::class,
        'MG-SNMP-UPS-MIB::upsmgUtilityFailure' => \LibreNMS\Snmptrap\Handlers\UpsmgUtilityFailure::class,
        'MG-SNMP-UPS-MIB::upsmgUtilityRestored' => \LibreNMS\Snmptrap\Handlers\UpsmgUtilityRestored::class,
        'EQUIPMENT-MIB::equipStatusTrap' => \LibreNMS\Snmptrap\Handlers\EquipStatusTrap::class,
        'LOG-MIB::logTrap' => \LibreNMS\Snmptrap\Handlers\LogTrap::class,
        'CM-SYSTEM-MIB::cmObjectCreationTrap' => \LibreNMS\Snmptrap\Handlers\AdvaObjectCreation::class,
        'CM-SYSTEM-MIB::cmObjectDeletionTrap' => \LibreNMS\Snmptrap\Handlers\AdvaObjectDeletion::class,
        'CM-SYSTEM-MIB::cmStateChangeTrap' => \LibreNMS\Snmptrap\Handlers\AdvaStateChangeTrap::class,
        'CM-PERFORMANCE-MIB::cmEthernetAccPortThresholdCrossingAlert' => \LibreNMS\Snmptrap\Handlers\AdvaAccThresholdCrossingAlert::class,
        'CM-PERFORMANCE-MIB::cmEthernetNetPortThresholdCrossingAlert' => \LibreNMS\Snmptrap\Handlers\AdvaNetThresholdCrossingAlert::class,
        'CM-ALARM-MIB::cmNetworkElementAlmTrap' => \LibreNMS\Snmptrap\Handlers\AdvaNetworkElementAlmTrap::class,
        'CM-ALARM-MIB::cmSysAlmTrap' => \LibreNMS\Snmptrap\Handlers\AdvaSysAlmTrap::class,
        'CM-SYSTEM-MIB::cmSnmpDyingGaspTrap' => \LibreNMS\Snmptrap\Handlers\AdvaSnmpDyingGaspTrap::class,
        'CM-SYSTEM-MIB::cmAttributeValueChangeTrap' => \LibreNMS\Snmptrap\Handlers\AdvaAttributeChange::class,
        'ENTITY-MIB::entConfigChange' => \LibreNMS\Snmptrap\Handlers\AdvaConfigChange::class,
        'FORTINET-FORTIGATE-MIB::fgTrapVpnTunDown' => \LibreNMS\Snmptrap\Handlers\FgTrapVpnTunDown::class,
        'FORTINET-FORTIGATE-MIB::fgTrapVpnTunUp' => \LibreNMS\Snmptrap\Handlers\FgTrapVpnTunUp::class,
        'FORTINET-FORTIGATE-MIB::fgTrapIpsSignature' => \LibreNMS\Snmptrap\Handlers\FgTrapIpsSignature::class,
        'FORTINET-FORTIGATE-MIB::fgTrapIpsAnomaly' => \LibreNMS\Snmptrap\Handlers\FgTrapIpsAnomaly::class,
        'FORTINET-FORTIGATE-MIB::fgTrapAvOversize' => \LibreNMS\Snmptrap\Handlers\FgTrapAvOversize::class,
        'FORTINET-FORTIGATE-MIB::fgTrapIpsPkgUpdate' => \LibreNMS\Snmptrap\Handlers\FgTrapIpsPkgUpdate::class,
        'FORTINET-CORE-MIB::fnTrapMemThreshold' => \LibreNMS\Snmptrap\Handlers\FnTrapMemThreshold::class,
        'FORTINET-FORTIMANAGER-FORTIANALYZER-MIB::fmTrapLogRateThreshold' => \LibreNMS\Snmptrap\Handlers\FmTrapLogRateThreshold::class,
        'FORTINET-FORTIMANAGER-FORTIANALYZER-MIB::fmTrapLogAlert' => \LibreNMS\Snmptrap\Handlers\FmTrapLogAlert::class,
    ]
];
