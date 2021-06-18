<?php
$state_convert = [
    'RaidSet Member' => 1 ,
    'Hot Spare' => 2 ,
];

$state_name = 'raidMember';
$states = [
    ['value' => 1, 'generic' => 0, 'graph' => 0, 'descr' => 'member'],
    ['value' => 2, 'generic' => 3, 'graph' => 0, 'descr' => 'spare'],
];

$walk = [
    'hddEnclosure01' => '.1.3.6.1.4.1.14752.1.3.3.1.4.1.7.',
    'hddEnclosure02' => '.1.3.6.1.4.1.14752.1.3.3.2.4.1.7.',
    'hddEnclosure03' => '.1.3.6.1.4.1.14752.1.3.3.3.4.1.7.',
    'hddEnclosure04' => '.1.3.6.1.4.1.14752.1.3.3.4.4.1.7.',
    'hddEnclosure05' => '.1.3.6.1.4.1.14752.1.3.3.5.4.1.7.',
    'hddEnclosure06' => '.1.3.6.1.4.1.14752.1.3.3.6.4.1.7.',
    'hddEnclosure07' => '.1.3.6.1.4.1.14752.1.3.3.7.4.1.7.',
    'hddEnclosure08' => '.1.3.6.1.4.1.14752.1.3.3.8.4.1.7.',
];

foreach ($walk as $mib => $num_oid){
    $oids = snmpwalk_group($device, $mib.'InfoTable', 'proware-SNMP-MIB');
    if (!empty($oids)) {
        $raids = snmpwalk_group($device, 'raidInfoTable', 'proware-SNMP-MIB');
        create_state_index($state_name, $states);
        foreach ($oids as $index => $entry) {
            $group='Non RAID member';
            $tmp = preg_replace('/hddEnclosure0(\d)(\d+)/i','E${1}S${2}', $mib . $entry[$mib . 'Slots']);
            foreach ($raids as $raid){
                if (in_array($tmp,explode(',',$raid['raidMemberDiskChannels']))){
                    $group=$raid['raidName'];
                    break;
                }
            }
            discover_sensor($valid['sensor'], 'state', $device, $num_oid.$index,$mib . $index, $state_name, $entry[$mib . 'Desc'], '1', '1', null, null, null, null, $state_convert[$entry[$mib . 'State']], 'snmp',$mib . $index,null,null, $group);
            create_sensor_to_state_index($device, $state_name,$mib . $index);
        }
    }
}
