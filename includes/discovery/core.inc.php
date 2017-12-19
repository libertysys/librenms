<?php

$snmpdata = snmp_get_multi_oid($device, 'sysName.0 sysObjectID.0 sysDescr.0', '-OUQn', 'SNMPv2-MIB:HOST-RESOURCES-MIB:SNMP-FRAMEWORK-MIB');
$disco_device['sysObjectID'] = $snmpdata['.1.3.6.1.2.1.1.2.0'];
$disco_device['sysName'] = strtolower($snmpdata['.1.3.6.1.2.1.1.5.0']);
$disco_device['sysDescr'] = $snmpdata['.1.3.6.1.2.1.1.1.0'];
