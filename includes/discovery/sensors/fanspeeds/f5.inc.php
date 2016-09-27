<?php

if ($device['os'] == 'f5') {
    $oids = snmp_walk($device, 'sysChassisFanSpeed', '-OsqnU', 'F5-BIGIP-SYSTEM-MIB');
    d_echo($oids."\n");

    if ($oids !== false) {
        echo 'sysChassisFanSpeed ';
    }

    $divisor = 1;
    $type    = 'f5';

    foreach (explode("\n", $oids) as $data) {
        $data = trim($data);
        if ($data) {
            list($oid,$descr) = explode(' ', $data, 2);
            $split_oid        = explode('.', $oid);
            $index            = $split_oid[(count($split_oid) - 1)];
            $descr            = 'Fan Speed '.$index;
            $oid              = '1.3.6.1.4.1.3375.2.1.3.2.1.2.1.3.'.$index;
            $fanspeed         = (snmp_get($device, $oid, '-Oqv') / $divisor);
            if ($fanspeed > 0) {
                discover_sensor($valid['sensor'], 'fanspeed', $device, $oid, $index, $type, $descr, $divisor, '1', null, null, null, null, $fanspeed);
            }
        }
    }
}
